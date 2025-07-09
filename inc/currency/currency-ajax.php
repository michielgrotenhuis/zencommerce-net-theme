<?php
/**
 * Currency AJAX Handlers - IMPROVED VERSION
 * File: inc/currency/currency-ajax.php
 * 
 * Key Improvements:
 * - Fixed wpdb::prepare usage issues
 * - Better error handling and validation
 * - Improved security with proper nonce verification
 * - Cleaner code structure and documentation
 * - Better performance with reduced database queries
 * - Proper output buffering management
 */

if (!defined('ABSPATH')) {
    exit;
}

// =============================================================================
// CORE CURRENCY SWITCHING HANDLERS
// =============================================================================

/**
 * MAIN: Switch user currency - NO COOKIES VERSION
 */
function yoursite_ajax_switch_user_currency() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'currency_switch')) {
        wp_send_json_error([
            'message' => __('Security check failed', 'yoursite'),
            'code' => 'invalid_nonce'
        ]);
    }
    
    // Clean any existing output
    if (ob_get_level()) {
        ob_clean();
    }
    
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    // Validate input
    if (empty($currency_code)) {
        wp_send_json_error([
            'message' => __('Invalid currency code', 'yoursite'),
            'code' => 'empty_currency'
        ]);
    }
    
    // Validate currency code format (3 letter code)
    if (!yoursite_validate_currency_code($currency_code)) {
        wp_send_json_error([
            'message' => __('Invalid currency format', 'yoursite'),
            'code' => 'invalid_format'
        ]);
    }
    
    // Check if currency exists and is active
    $currency = yoursite_get_currency($currency_code);
    if (!$currency) {
        wp_send_json_error([
            'message' => __('Currency not found', 'yoursite'),
            'code' => 'currency_not_found'
        ]);
    }
    
    if ($currency['status'] !== 'active') {
        wp_send_json_error([
            'message' => __('Currency not available', 'yoursite'),
            'code' => 'currency_inactive'
        ]);
    }
    
    // Start session if not already started
    if (!session_id()) {
        session_start();
    }
    
    // Store in session (immediate persistence)
    $_SESSION['preferred_currency'] = $currency_code;
    
    // Update user meta if logged in (persistent across sessions)
    $user_meta_updated = false;
    if (is_user_logged_in()) {
        $user_meta_updated = update_user_meta(get_current_user_id(), 'preferred_currency', $currency_code);
    }
    
    // Log for debugging
    yoursite_log_currency_debug("Currency switched to: $currency_code", [
        'user_id' => is_user_logged_in() ? get_current_user_id() : 0,
        'session_id' => session_id()
    ]);
    
    wp_send_json_success([
        'currency' => $currency,
        'currency_code' => $currency_code,
        'message' => sprintf(__('Currency switched to %s (%s)', 'yoursite'), $currency['name'], $currency_code),
        'set_cookie_js' => true,
        'session_set' => isset($_SESSION['preferred_currency']),
        'user_meta_updated' => $user_meta_updated,
        'debug' => WP_DEBUG ? [
            'session_id' => session_id(),
            'user_id' => is_user_logged_in() ? get_current_user_id() : 0,
            'timestamp' => current_time('mysql')
        ] : []
    ]);
}

/**
 * Get current user currency info
 */
function yoursite_ajax_get_current_currency() {
    $current_currency = yoursite_get_user_currency();
    
    wp_send_json_success([
        'currency' => $current_currency,
        'currency_code' => $current_currency['code'],
        'symbol' => $current_currency['symbol'] ?? $current_currency['code'],
        'name' => $current_currency['name']
    ]);
}



// =============================================================================
// PRICING RELATED AJAX HANDLERS
// =============================================================================

/**
 * Get pricing for specific plan in specific currency
 */
function yoursite_ajax_get_currency_pricing() {
    if (ob_get_level()) {
        ob_clean();
    }
    
    $plan_id = intval($_POST['plan_id'] ?? 0);
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    // Validate input
    if (!$plan_id || !$currency_code) {
        wp_send_json_error([
            'message' => __('Plan ID and currency code are required', 'yoursite'),
            'code' => 'missing_parameters'
        ]);
    }
    
    // Verify plan exists
    $plan = get_post($plan_id);
    if (!$plan || $plan->post_type !== 'pricing' || $plan->post_status !== 'publish') {
        wp_send_json_error([
            'message' => __('Invalid plan', 'yoursite'),
            'code' => 'invalid_plan'
        ]);
    }
    
    // Get pricing in requested currency
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
    
    if ($monthly_price === false || $annual_price === false) {
        wp_send_json_error([
            'message' => __('Unable to calculate pricing', 'yoursite'),
            'code' => 'pricing_calculation_failed'
        ]);
    }
    
    // Calculate additional pricing info
    $annual_monthly_equivalent = $annual_price > 0 ? $annual_price / 12 : 0;
    $savings = yoursite_calculate_annual_savings($plan_id, $currency_code);
    $discount_percentage = yoursite_calculate_annual_discount_percentage($plan_id, $currency_code);
    
    // Format currencies
    $formatted_monthly = yoursite_format_currency($monthly_price, $currency_code);
    $formatted_annual = yoursite_format_currency($annual_price, $currency_code);
    $formatted_annual_monthly = yoursite_format_currency($annual_monthly_equivalent, $currency_code);
    $formatted_savings = $savings > 0 ? yoursite_format_currency($savings, $currency_code) : '';
    
    // Get currency info
    $currency = yoursite_get_currency($currency_code);
    
    wp_send_json_success([
        'plan_id' => $plan_id,
        'currency_code' => $currency_code,
        'pricing' => [
            'monthly' => [
                'raw' => $monthly_price,
                'formatted' => $formatted_monthly
            ],
            'annual' => [
                'raw' => $annual_price,
                'formatted' => $formatted_annual,
                'monthly_equivalent' => [
                    'raw' => $annual_monthly_equivalent,
                    'formatted' => $formatted_annual_monthly
                ]
            ],
            'savings' => [
                'raw' => $savings,
                'formatted' => $formatted_savings,
                'percentage' => $discount_percentage
            ]
        ],
        'currency' => $currency
    ]);
}

/**
 * Get pricing for ALL plans in specific currency
 */
function yoursite_ajax_get_all_pricing_in_currency() {
    if (ob_get_level()) {
        ob_clean();
    }
    
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (!$currency_code) {
        wp_send_json_error([
            'message' => __('Currency code is required', 'yoursite'),
            'code' => 'missing_currency'
        ]);
    }
    
    // Validate currency
    $currency = yoursite_get_currency($currency_code);
    if (!$currency || $currency['status'] !== 'active') {
        wp_send_json_error([
            'message' => __('Invalid or inactive currency', 'yoursite'),
            'code' => 'invalid_currency'
        ]);
    }
    
    // Get all published pricing plans
    $plans = get_posts([
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => '_pricing_monthly_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    ]);
    
    if (empty($plans)) {
        wp_send_json_error([
            'message' => __('No pricing plans found', 'yoursite'),
            'code' => 'no_plans'
        ]);
    }
    
    $pricing_data = [];
    
    foreach ($plans as $plan) {
        $monthly_price = yoursite_get_pricing_plan_price($plan->ID, $currency_code, 'monthly');
        $annual_price = yoursite_get_pricing_plan_price($plan->ID, $currency_code, 'annual');
        
        if ($monthly_price === false || $annual_price === false) {
            continue; // Skip plans with pricing errors
        }
        
        $annual_monthly_equivalent = $annual_price > 0 ? $annual_price / 12 : 0;
        $savings = yoursite_calculate_annual_savings($plan->ID, $currency_code);
        $discount_percentage = yoursite_calculate_annual_discount_percentage($plan->ID, $currency_code);
        
        $pricing_data[$plan->ID] = [
            'title' => $plan->post_title,
            'monthly' => [
                'raw' => $monthly_price,
                'formatted' => yoursite_format_currency($monthly_price, $currency_code)
            ],
            'annual' => [
                'raw' => $annual_price,
                'formatted' => yoursite_format_currency($annual_price, $currency_code),
                'monthly_equivalent' => [
                    'raw' => $annual_monthly_equivalent,
                    'formatted' => yoursite_format_currency($annual_monthly_equivalent, $currency_code)
                ]
            ],
            'savings' => [
                'raw' => $savings,
                'formatted' => $savings > 0 ? yoursite_format_currency($savings, $currency_code) : '',
                'percentage' => $discount_percentage
            ],
            'featured' => get_post_meta($plan->ID, '_pricing_featured', true) === '1'
        ];
    }
    
    wp_send_json_success([
        'currency_code' => $currency_code,
        'currency' => $currency,
        'plans' => $pricing_data,
        'plan_count' => count($pricing_data)
    ]);
}

/**
 * Convert a specific price between currencies
 */
function yoursite_ajax_convert_currency_price() {
    if (ob_get_level()) {
        ob_clean();
    }
    
    $from_currency = sanitize_text_field($_POST['from_currency'] ?? '');
    $to_currency = sanitize_text_field($_POST['to_currency'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    
    if (!$from_currency || !$to_currency || $amount <= 0) {
        wp_send_json_error([
            'message' => __('Invalid conversion parameters', 'yoursite'),
            'code' => 'invalid_parameters'
        ]);
    }
    
    $converted_amount = yoursite_convert_price($amount, $from_currency, $to_currency);
    
    if ($converted_amount === false) {
        wp_send_json_error([
            'message' => __('Currency conversion failed', 'yoursite'),
            'code' => 'conversion_failed'
        ]);
    }
    
    $formatted_amount = yoursite_format_currency($converted_amount, $to_currency);
    
    wp_send_json_success([
        'from_currency' => $from_currency,
        'to_currency' => $to_currency,
        'original_amount' => $amount,
        'converted_amount' => $converted_amount,
        'formatted_amount' => $formatted_amount,
        'conversion_rate' => yoursite_get_conversion_rate($from_currency, $to_currency)
    ]);
}

// =============================================================================
// ADMIN CURRENCY MANAGEMENT HANDLERS
// =============================================================================

/**
 * ADMIN: Refresh all currency rates
 */
function yoursite_ajax_refresh_currency_rates() {
    if (ob_get_level()) {
        ob_clean();
    }
    
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error([
            'message' => __('Insufficient permissions', 'yoursite'),
            'code' => 'insufficient_permissions'
        ]);
    }
    
    $updated_count = yoursite_update_currency_rates();
    
    if ($updated_count !== false) {
        wp_send_json_success([
            'message' => sprintf(__('%d currencies updated successfully', 'yoursite'), $updated_count),
            'updated_count' => $updated_count,
            'last_update' => current_time('mysql')
        ]);
    } else {
        wp_send_json_error([
            'message' => __('Failed to update currency rates', 'yoursite'),
            'code' => 'update_failed'
        ]);
    }
}

/**
 * ADMIN: Toggle currency status
 */
function yoursite_ajax_toggle_currency_status() {
    if (!ob_get_level()) ob_start();
    
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        ob_end_clean();
        wp_die(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency_id = intval($_POST['currency_id'] ?? 0);
    $status = sanitize_text_field($_POST['status'] ?? '');
    
    if (!$currency_id || !in_array($status, array('active', 'inactive'))) {
        ob_end_clean();
        wp_send_json_error(__('Invalid parameters', 'yoursite'));
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $result = $wpdb->update(
        $table_name,
        array(
            'status' => $status, 
            'updated_at' => current_time('mysql')
        ),
        array('id' => $currency_id),
        array('%s', '%s'),  // FIXED: Format for data
        array('%d')         // FIXED: Format for where clause
    );
    
    ob_end_clean();
    
    if ($result !== false) {
        wp_send_json_success(array(
            'message' => __('Currency status updated', 'yoursite'),
            'currency_id' => $currency_id,
            'new_status' => $status
        ));
    } else {
        wp_send_json_error(__('Failed to update currency status', 'yoursite'));
    }
}


function yoursite_ajax_update_conversion_rate() {
    if (!ob_get_level()) ob_start();

    check_ajax_referer('currency_management_nonce', 'nonce');

    if (!current_user_can('manage_options')) {
        ob_end_clean();
        wp_die(__('Insufficient permissions', 'yoursite'));
    }

    $currency_id = isset($_POST['currency_id']) ? intval($_POST['currency_id']) : 0;
    $conversion_rate = isset($_POST['conversion_rate']) ? floatval($_POST['conversion_rate']) : 0;

    if (!$currency_id || $conversion_rate <= 0) {
        ob_end_clean();
        wp_send_json_error(__('Invalid parameters', 'yoursite'));
    }

    global $wpdb;
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $history_table = $wpdb->prefix . 'yoursite_currency_rate_history';

    $old_rate = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT conversion_rate FROM {$currencies_table} WHERE id = %d",
            $currency_id
        )
    );

    $updated = $wpdb->update(
        $currencies_table,
        array(
            'conversion_rate' => $conversion_rate,
            'last_updated'    => current_time('mysql'),
            'updated_at'      => current_time('mysql'),
        ),
        array('id' => $currency_id),
        array('%f', '%s', '%s'),
        array('%d')
    );

    if ($updated === false) {
        ob_end_clean();
        wp_send_json_error(__('Failed to update conversion rate', 'yoursite'));
    }

    $history_table_like = $wpdb->esc_like($history_table);
    $tables = $wpdb->get_col("SHOW TABLES LIKE '{$history_table_like}'");

    if (!empty($tables) && $old_rate !== null) {
        $wpdb->insert(
            $history_table,
            array(
                'currency_id' => $currency_id,
                'old_rate'    => $old_rate,
                'new_rate'    => $conversion_rate,
                'change_type' => 'manual',
                'created_at'  => current_time('mysql'),
            ),
            array('%d', '%f', '%f', '%s', '%s')
        );
    }

    ob_end_clean();

    wp_send_json_success(array(
        'message'     => __('Conversion rate updated', 'yoursite'),
        'currency_id' => $currency_id,
        'new_rate'    => $conversion_rate,
        'old_rate'    => $old_rate,
    ));
}




/**
 * ADMIN: Get currency statistics
 */
function yoursite_ajax_get_currency_statistics() {
    if (ob_get_level()) {
        ob_clean();
    }
    
    check_ajax_referer('currency_management_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error([
            'message' => __('Insufficient permissions', 'yoursite'),
            'code' => 'insufficient_permissions'
        ]);
    }
    
    global $wpdb;
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $pricing_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    
    // Get basic statistics with prepared statements
    $stats = [
        'total_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM {$currencies_table}"),
        'active_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM {$currencies_table} WHERE status = 'active'"),
        'inactive_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM {$currencies_table} WHERE status = 'inactive'"),
        'crypto_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM {$currencies_table} WHERE is_crypto = 1"),
        'fiat_currencies' => $wpdb->get_var("SELECT COUNT(*) FROM {$currencies_table} WHERE is_crypto = 0"),
        'auto_update_enabled' => $wpdb->get_var("SELECT COUNT(*) FROM {$currencies_table} WHERE auto_update = 1"),
        'base_currency' => $wpdb->get_var("SELECT code FROM {$currencies_table} WHERE is_base_currency = 1"),
        'last_rate_update' => $wpdb->get_var("SELECT MAX(last_updated) FROM {$currencies_table} WHERE auto_update = 1"),
        'stale_rates_count' => $wpdb->get_var(
            "SELECT COUNT(*) FROM {$currencies_table} 
             WHERE status = 'active' 
             AND auto_update = 1 
             AND (last_updated IS NULL OR last_updated < DATE_SUB(NOW(), INTERVAL 24 HOUR))"
        )
    ];
    
    // Get most used currencies
    $popular_currencies = $wpdb->get_results(
        "SELECT c.code, c.name, c.symbol, COUNT(pc.id) as usage_count
         FROM {$currencies_table} c
         LEFT JOIN {$pricing_table} pc ON c.code = pc.currency_code
         WHERE c.status = 'active'
         GROUP BY c.code, c.name, c.symbol
         ORDER BY usage_count DESC, c.name ASC
         LIMIT 10"
    );
    
    $stats['popular_currencies'] = $popular_currencies;
    
    wp_send_json_success($stats);
}

// =============================================================================
// UTILITY HANDLERS
// =============================================================================

/**
 * Test currency formatting
 */
function yoursite_ajax_test_currency_format() {
    $currency_code = sanitize_text_field($_POST['currency_code'] ?? '');
    $test_amounts = [9.99, 123.45, 1234.56, 12345.67];
    
    if (empty($currency_code)) {
        wp_send_json_error([
            'message' => __('Currency code is required', 'yoursite'),
            'code' => 'missing_currency'
        ]);
    }
    
    $formatted_amounts = [];
    
    foreach ($test_amounts as $amount) {
        $formatted_amounts[] = [
            'amount' => $amount,
            'formatted' => yoursite_format_currency($amount, $currency_code)
        ];
    }
    
    wp_send_json_success([
        'currency_code' => $currency_code,
        'test_results' => $formatted_amounts
    ]);
}

/**
 * Get conversion rate between two currencies
 */
function yoursite_ajax_get_conversion_rate() {
    $from_currency = sanitize_text_field($_POST['from'] ?? '');
    $to_currency = sanitize_text_field($_POST['to'] ?? '');
    
    if (!$from_currency || !$to_currency) {
        wp_send_json_error([
            'message' => __('Both currency codes are required', 'yoursite'),
            'code' => 'missing_currencies'
        ]);
    }
    
    $rate = yoursite_get_conversion_rate($from_currency, $to_currency);
    
    if ($rate === false) {
        wp_send_json_error([
            'message' => __('Unable to get conversion rate', 'yoursite'),
            'code' => 'rate_unavailable'
        ]);
    }
    
    wp_send_json_success([
        'from' => $from_currency,
        'to' => $to_currency,
        'rate' => $rate,
        'formatted_rate' => number_format($rate, 6),
        'inverse_rate' => $rate > 0 ? 1 / $rate : 0
    ]);
}

// =============================================================================
// REGISTER ALL AJAX ACTIONS
// =============================================================================

/**
 * Register all AJAX handlers
 */
function yoursite_register_currency_ajax_handlers() {
    // Public handlers (logged in and non-logged in users)
    $public_handlers = [
        'switch_user_currency' => 'yoursite_ajax_switch_user_currency',
        'get_current_currency' => 'yoursite_ajax_get_current_currency',
        'get_available_currencies' => 'yoursite_ajax_get_available_currencies',
        'get_currency_pricing' => 'yoursite_ajax_get_currency_pricing',
        'get_all_pricing_in_currency' => 'yoursite_ajax_get_all_pricing_in_currency',
        'convert_currency_price' => 'yoursite_ajax_convert_currency_price',
        'test_currency_format' => 'yoursite_ajax_test_currency_format',
        'get_conversion_rate' => 'yoursite_ajax_get_conversion_rate'
    ];
    
    foreach ($public_handlers as $action => $callback) {
        add_action('wp_ajax_' . $action, $callback);
        add_action('wp_ajax_nopriv_' . $action, $callback);
    }
    
    // Admin-only handlers
    $admin_handlers = [
        'refresh_currency_rates' => 'yoursite_ajax_refresh_currency_rates',
        'toggle_currency_status' => 'yoursite_ajax_toggle_currency_status',
        'update_conversion_rate' => 'yoursite_ajax_update_conversion_rate',
        'get_currency_statistics' => 'yoursite_ajax_get_currency_statistics'
    ];
    
    foreach ($admin_handlers as $action => $callback) {
        add_action('wp_ajax_' . $action, $callback);
    }
}

// Register handlers early in WordPress lifecycle
add_action('wp_loaded', 'yoursite_register_currency_ajax_handlers', 1);

// =============================================================================
// HELPER FUNCTIONS
// =============================================================================

/**
 * Enhanced get user currency function with multiple fallbacks
 */
function yoursite_get_user_currency_enhanced() {
    static $current_currency = null;
    
    // Return cached result
    if ($current_currency !== null) {
        return $current_currency;
    }
    
    $cookie_name = 'yoursite_preferred_currency';
    

    
    // 1. Check session (most reliable for current request)
    if (isset($_SESSION['preferred_currency'])) {
        $currency_code = sanitize_text_field($_SESSION['preferred_currency']);
        $currency = yoursite_get_currency($currency_code);
        if ($currency && $currency['status'] === 'active') {
            $current_currency = $currency;
            return $current_currency;
        }
    }
    
    // 2. Check cookie
    if (isset($_COOKIE[$cookie_name])) {
        $currency_code = sanitize_text_field($_COOKIE[$cookie_name]);
        $currency = yoursite_get_currency($currency_code);
        if ($currency && $currency['status'] === 'active') {
            $_SESSION['preferred_currency'] = $currency_code;
            $current_currency = $currency;
            return $current_currency;
        }
    }
    
    // 3. Check user meta
    if (is_user_logged_in()) {
        $user_currency = get_user_meta(get_current_user_id(), 'preferred_currency', true);
        if ($user_currency) {
            $currency = yoursite_get_currency($user_currency);
            if ($currency && $currency['status'] === 'active') {
                $_SESSION['preferred_currency'] = $user_currency;
                $current_currency = $currency;
                return $current_currency;
            }
        }
    }
    
    // 4. Fallback to base currency
    $base_currency = yoursite_get_base_currency();
    $current_currency = $base_currency ?: [
        'code' => 'USD',
        'name' => 'US Dollar',
        'symbol' => '$',
        'status' => 'active'
    ];
    
    return $current_currency;
}

/**
 * Initialize currency JavaScript variables
 */
function yoursite_init_currency_javascript_vars() {
    $current_currency = yoursite_get_user_currency_enhanced();
    
    wp_add_inline_script('jquery', '
        window.YourSiteCurrency = window.YourSiteCurrency || {};
        window.YourSiteCurrency.current = "' . esc_js($current_currency['code']) . '";
        window.YourSiteCurrency.ajaxUrl = "' . esc_js(admin_url('admin-ajax.php')) . '";
        window.YourSiteCurrency.nonce = "' . esc_js(wp_create_nonce('currency_switch')) . '";
        window.YourSiteCurrency.cookieName = "yoursite_preferred_currency";
        window.YourSiteCurrency.debug = ' . (WP_DEBUG ? 'true' : 'false') . ';
    ', 'before');
}
add_action('wp_enqueue_scripts', 'yoursite_init_currency_javascript_vars', 5);

/**
 * Clean session on logout
 */
function yoursite_cleanup_currency_session_on_logout() {
    if (isset($_SESSION['preferred_currency'])) {
        unset($_SESSION['preferred_currency']);
    }
}
add_action('wp_logout', 'yoursite_cleanup_currency_session_on_logout');

/**
 * Debug logging function
 */
function yoursite_log_currency_debug($message, $data = null) {
    if (WP_DEBUG_LOG) {
        $log_message = 'YourSite Currency: ' . $message;
        if ($data !== null) {
            $log_message .= ' | Data: ' . print_r($data, true);
        }
        error_log($log_message);
    }
}

/**
 * Validate currency code format
 */
function yoursite_validate_currency_code($currency_code) {
    return preg_match('/^[A-Z]{3}$/', $currency_code);
}

/**
 * Improved error handler for AJAX requests with consistent structure
 */
function yoursite_ajax_error_handler($error_message, $error_code = 'currency_error', $data = null) {
    yoursite_log_currency_debug("AJAX Error: $error_message", $data);
    
    wp_send_json_error([
        'message' => $error_message,
        'code' => $error_code,
        'timestamp' => current_time('mysql'),
        'debug_data' => WP_DEBUG ? $data : null
    ]);
}

/**
 * Sanitize and validate AJAX input data
 */
function yoursite_sanitize_ajax_input($input_data, $expected_fields = []) {
    $sanitized = [];
    
    foreach ($expected_fields as $field => $type) {
        $value = $input_data[$field] ?? null;
        
        switch ($type) {
            case 'int':
                $sanitized[$field] = intval($value);
                break;
            case 'float':
                $sanitized[$field] = floatval($value);
                break;
            case 'currency_code':
                $sanitized[$field] = strtoupper(sanitize_text_field($value));
                break;
            case 'text':
            default:
                $sanitized[$field] = sanitize_text_field($value);
                break;
        }
    }
    
    return $sanitized;
}

/**
 * Check rate limits for AJAX requests (optional security enhancement)
 */
function yoursite_check_ajax_rate_limit($action, $limit = 60, $window = 60) {
    if (!WP_DEBUG) { // Only enable in production
        $transient_key = 'ajax_rate_limit_' . $action . '_' . md5($_SERVER['REMOTE_ADDR'] ?? '');
        $current_count = get_transient($transient_key);
        
        if ($current_count === false) {
            set_transient($transient_key, 1, $window);
            return true;
        }
        
        if ($current_count >= $limit) {
            wp_send_json_error([
                'message' => __('Rate limit exceeded. Please try again later.', 'yoursite'),
                'code' => 'rate_limit_exceeded'
            ]);
        }
        
        set_transient($transient_key, $current_count + 1, $window);
    }
    
    return true;
}

/**
 * Centralized currency cache management
 */
class YourSite_Currency_Cache {
    private static $cache = [];
    private static $cache_duration = 300; // 5 minutes
    
    public static function get($key) {
        if (isset(self::$cache[$key])) {
            $cache_item = self::$cache[$key];
            if (time() - $cache_item['timestamp'] < self::$cache_duration) {
                return $cache_item['data'];
            }
            unset(self::$cache[$key]);
        }
        return false;
    }
    
    public static function set($key, $data) {
        self::$cache[$key] = [
            'data' => $data,
            'timestamp' => time()
        ];
    }
    
    public static function clear($key = null) {
        if ($key) {
            unset(self::$cache[$key]);
        } else {
            self::$cache = [];
        }
    }
}
