<?php
/**
 * Currency Core Functions
 * File: inc/currency/currency-core.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create currency-related database tables
 */
function yoursite_create_currency_tables() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $pricing_currencies_table = $wpdb->prefix . 'yoursite_pricing_currencies';

    // Sanitize table names (precaution)
    $currencies_table = esc_sql($currencies_table);
    $pricing_currencies_table = esc_sql($pricing_currencies_table);

    // Currency definitions
    $currencies_sql = "
        CREATE TABLE {$currencies_table} (
            id INT(11) NOT NULL AUTO_INCREMENT,
            code VARCHAR(10) NOT NULL,
            name VARCHAR(100) NOT NULL,
            symbol VARCHAR(10) NOT NULL,
            flag VARCHAR(10) DEFAULT '',
            prefix VARCHAR(20) DEFAULT '',
            suffix VARCHAR(20) DEFAULT '',
            decimal_places INT(2) DEFAULT 2,
            decimal_separator VARCHAR(5) DEFAULT '.',
            thousand_separator VARCHAR(5) DEFAULT ',',
            conversion_rate DECIMAL(15,8) DEFAULT 1.00000000,
            is_base_currency TINYINT(1) DEFAULT 0,
            status ENUM('active', 'inactive') DEFAULT 'active',
            rounding_mode ENUM('up', 'down', 'nearest', 'none') DEFAULT 'nearest',
            rounding_precision VARCHAR(10) DEFAULT '0.01',
            auto_update TINYINT(1) DEFAULT 0,
            last_updated DATETIME DEFAULT CURRENT_TIMESTAMP,
            display_order INT(11) DEFAULT 0,
            is_crypto TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY code (code),
            KEY status (status),
            KEY display_order (display_order)
        ) {$charset_collate};
    ";

    // Pricing plans and currencies
    $pricing_currencies_sql = "
        CREATE TABLE {$pricing_currencies_table} (
            id INT(11) NOT NULL AUTO_INCREMENT,
            pricing_plan_id INT(11) NOT NULL,
            currency_code VARCHAR(10) NOT NULL,
            monthly_price DECIMAL(15,2) DEFAULT NULL,
            annual_price DECIMAL(15,2) DEFAULT NULL,
            button_url VARCHAR(500) DEFAULT '',
            is_auto_converted TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY plan_currency (pricing_plan_id, currency_code),
            KEY pricing_plan_id (pricing_plan_id),
            KEY currency_code (currency_code)
        ) {$charset_collate};
    ";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Run table creation/update safely
    dbDelta($currencies_sql);
    dbDelta($pricing_currencies_sql);
}


/**
 * Get all default world currencies with comprehensive data
 */
function yoursite_get_default_currencies() {
    return array(
        'USD' => array(
            'name' => 'US Dollar',
            'symbol' => '$',
            'flag' => '🇺🇸',
            'prefix' => '$',
            'suffix' => '',
            'decimal_places' => 2,
            'is_base_currency' => 1,
            'status' => 'active',
            'display_order' => 1
        ),
        'EUR' => array(
            'name' => 'Euro',
            'symbol' => '€',
            'flag' => '🇪🇺',
            'prefix' => '€',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'active',
            'display_order' => 2
        ),
        'GBP' => array(
            'name' => 'British Pound',
            'symbol' => '£',
            'flag' => '🇬🇧',
            'prefix' => '£',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'active',
            'display_order' => 3
        ),
        'JPY' => array(
            'name' => 'Japanese Yen',
            'symbol' => '¥',
            'flag' => '🇯🇵',
            'prefix' => '¥',
            'suffix' => '',
            'decimal_places' => 0,
            'status' => 'inactive',
            'display_order' => 4
        ),
        'CAD' => array(
            'name' => 'Canadian Dollar',
            'symbol' => 'C$',
            'flag' => '🇨🇦',
            'prefix' => 'C$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 5
        ),
        'AUD' => array(
            'name' => 'Australian Dollar',
            'symbol' => 'A$',
            'flag' => '🇦🇺',
            'prefix' => 'A$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 6
        ),
        'CHF' => array(
            'name' => 'Swiss Franc',
            'symbol' => 'CHF',
            'flag' => '🇨🇭',
            'prefix' => 'CHF ',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 7
        ),
        'CNY' => array(
            'name' => 'Chinese Yuan',
            'symbol' => '¥',
            'flag' => '🇨🇳',
            'prefix' => '¥',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 8
        ),
        'SEK' => array(
            'name' => 'Swedish Krona',
            'symbol' => 'kr',
            'flag' => '🇸🇪',
            'prefix' => '',
            'suffix' => ' kr',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 9
        ),
        'NOK' => array(
            'name' => 'Norwegian Krone',
            'symbol' => 'kr',
            'flag' => '🇳🇴',
            'prefix' => '',
            'suffix' => ' kr',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 10
        ),
        'DKK' => array(
            'name' => 'Danish Krone',
            'symbol' => 'kr.',
            'flag' => '🇩🇰',
            'prefix' => '',
            'suffix' => ' kr.',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 11
        ),
        'PLN' => array(
            'name' => 'Polish Złoty',
            'symbol' => 'zł',
            'flag' => '🇵🇱',
            'prefix' => '',
            'suffix' => ' zł',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 12
        ),
        'INR' => array(
            'name' => 'Indian Rupee',
            'symbol' => '₹',
            'flag' => '🇮🇳',
            'prefix' => '₹',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 13
        ),
        'BRL' => array(
            'name' => 'Brazilian Real',
            'symbol' => 'R$',
            'flag' => '🇧🇷',
            'prefix' => 'R$ ',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 14
        ),
        'RUB' => array(
            'name' => 'Russian Ruble',
            'symbol' => '₽',
            'flag' => '🇷🇺',
            'prefix' => '',
            'suffix' => ' ₽',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 15
        ),
        'KRW' => array(
            'name' => 'South Korean Won',
            'symbol' => '₩',
            'flag' => '🇰🇷',
            'prefix' => '₩',
            'suffix' => '',
            'decimal_places' => 0,
            'status' => 'inactive',
            'display_order' => 16
        ),
        'MXN' => array(
            'name' => 'Mexican Peso',
            'symbol' => '$',
            'flag' => '🇲🇽',
            'prefix' => '$',
            'suffix' => ' MXN',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 17
        ),
        'SGD' => array(
            'name' => 'Singapore Dollar',
            'symbol' => 'S$',
            'flag' => '🇸🇬',
            'prefix' => 'S$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 18
        ),
        'NZD' => array(
            'name' => 'New Zealand Dollar',
            'symbol' => 'NZ$',
            'flag' => '🇳🇿',
            'prefix' => 'NZ$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 19
        ),
        'HKD' => array(
            'name' => 'Hong Kong Dollar',
            'symbol' => 'HK$',
            'flag' => '🇭🇰',
            'prefix' => 'HK$',
            'suffix' => '',
            'decimal_places' => 2,
            'status' => 'inactive',
            'display_order' => 20
        ),
        // Popular cryptocurrencies
        'BTC' => array(
            'name' => 'Bitcoin',
            'symbol' => '₿',
            'flag' => '₿',
            'prefix' => '₿',
            'suffix' => '',
            'decimal_places' => 8,
            'status' => 'inactive',
            'is_crypto' => 1,
            'display_order' => 101
        ),
        'ETH' => array(
            'name' => 'Ethereum',
            'symbol' => 'Ξ',
            'flag' => 'Ξ',
            'prefix' => 'Ξ',
            'suffix' => '',
            'decimal_places' => 6,
            'status' => 'inactive',
            'is_crypto' => 1,
            'display_order' => 102
        ),
        'USDC' => array(
            'name' => 'USD Coin',
            'symbol' => 'USDC',
            'flag' => '💰',
            'prefix' => '',
            'suffix' => ' USDC',
            'decimal_places' => 2,
            'status' => 'inactive',
            'is_crypto' => 1,
            'display_order' => 103
        )
    );
}

/**
 * Populate database with default currencies
 */
function yoursite_populate_default_currencies() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $currencies = yoursite_get_default_currencies();
    
    foreach ($currencies as $code => $currency) {
        $wpdb->insert(
            $table_name,
            array_merge(array('code' => $code), $currency)
            // Let WordPress auto-detect the format types
        );
    }
}

/**
 * Initialize default currency settings
 */
function yoursite_initialize_currency_settings() {
    $default_settings = array(
        'base_currency' => 'USD',
        'auto_update_enabled' => false,
        'update_frequency' => 'daily',
        'api_provider' => 'exchangerate_api',
        'api_key' => '',
        'fallback_rates' => array(),
        'display_currency_selector' => true,
        'remember_user_choice' => true,
        'geolocation_detection' => false,
        'default_rounding_mode' => 'nearest',
        'show_original_price' => false
    );
    
    update_option('yoursite_currency_settings', $default_settings);
}

/**
 * Get all active currencies
 */
function yoursite_get_active_currencies() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    $currencies = $wpdb->get_results(
        "SELECT * FROM $table_name WHERE status = 'active' ORDER BY display_order ASC, code ASC",
        ARRAY_A
    );
    
    if (empty($currencies)) {
        // Fallback to USD if no currencies found
        return array(
            array(
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'prefix' => '$',
                'suffix' => '',
                'conversion_rate' => 1.0,
                'is_base_currency' => 1
            )
        );
    }
    
    return $currencies;
}

/**
 * Get specific currency by code
 *
 * @param string $code Currency code (e.g., 'USD')
 * @return array|null Currency data or null if not found
 */
function yoursite_get_currency($code) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'yoursite_currencies';

    $sql = $wpdb->prepare(
        "SELECT * FROM {$table_name} WHERE code = %s",
        $code
    );

    return $wpdb->get_row($sql, ARRAY_A);
}




/**
 * Get the base currency
 *
 * @return array Currency data (default USD if not found)
 */
function yoursite_get_base_currency() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'yoursite_currencies';

    // Using query safely with known values (not user input)
    $sql = "SELECT * FROM {$table_name} WHERE is_base_currency = 1 AND status = 'active'";

    $base_currency = $wpdb->get_row($sql, ARRAY_A);

    if (!$base_currency) {
        // Fallback to USD if no base currency found
        return [
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'prefix' => '$',
            'suffix' => '',
            'conversion_rate' => 1.0,
            'is_base_currency' => 1
        ];
    }

    return $base_currency;
}

/**
 * Update currency conversion rates
 *
 * @param array|null $rates_data Currency rates, format: ['USD' => 1.0, 'EUR' => 0.92, ...]
 * @return int Number of updated currencies
 */
function yoursite_update_currency_rates($rates_data = null) {
    global $wpdb;
    
    if (!$rates_data) {
        $rates_data = yoursite_fetch_exchange_rates();
    }
    
    if (!$rates_data || !is_array($rates_data)) {
        return false;
    }
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $updated_count = 0;
    
    foreach ($rates_data as $currency_code => $rate) {
        $result = $wpdb->update(
            $table_name,
            array(
                'conversion_rate' => $rate,
                'last_updated' => current_time('mysql')
            ),
            array('code' => $currency_code),
            array('%f', '%s'),  // FIXED: Proper format array for data
            array('%s')         // FIXED: Proper format array for where clause
        );
        
        if ($result !== false) {
            $updated_count++;
        }
    }
    
    // Update last refresh time
    update_option('yoursite_currency_last_update', current_time('mysql'));
    
    return $updated_count;
}

/**
 * Get user's preferred currency
 */
function yoursite_get_user_currency() {
    // Check session/cookie first
    if (isset($_COOKIE['yoursite_currency'])) {
        $currency_code = sanitize_text_field($_COOKIE['yoursite_currency']);
        $currency = yoursite_get_currency($currency_code);
        if ($currency && $currency['status'] === 'active') {
            return $currency;
        }
    }
    
    // Check if user is logged in and has preference
    if (is_user_logged_in()) {
        $user_currency = get_user_meta(get_current_user_id(), 'preferred_currency', true);
        if ($user_currency) {
            $currency = yoursite_get_currency($user_currency);
            if ($currency && $currency['status'] === 'active') {
                return $currency;
            }
        }
    }
    
    // Geolocation detection (if enabled)
    $settings = get_option('yoursite_currency_settings', array());
    if (!empty($settings['geolocation_detection'])) {
        $detected_currency = yoursite_detect_currency_by_location();
        if ($detected_currency) {
            return $detected_currency;
        }
    }
    
    // Fallback to base currency
    return yoursite_get_base_currency();
}

/**
 * Convert price between currencies
 */
function yoursite_convert_price($amount, $from_currency, $to_currency) {
    if ($from_currency === $to_currency) {
        return $amount;
    }
    
    $from_curr = yoursite_get_currency($from_currency);
    $to_curr = yoursite_get_currency($to_currency);
    
    if (!$from_curr || !$to_curr) {
        return $amount;
    }
    
    // Convert to base currency first, then to target currency
    $base_amount = $amount / $from_curr['conversion_rate'];
    $converted_amount = $base_amount * $to_curr['conversion_rate'];
    
    // Apply rounding
    return yoursite_apply_currency_rounding($converted_amount, $to_curr);
}

/**
 * Apply currency-specific rounding
 */
function yoursite_apply_currency_rounding($amount, $currency) {
    $rounding_mode = $currency['rounding_mode'] ?? 'nearest';
    $precision = $currency['rounding_precision'] ?? '0.01';
    
    if ($rounding_mode === 'none') {
        return round($amount, $currency['decimal_places']);
    }
    
    $precision_value = floatval($precision);
    
    switch ($rounding_mode) {
        case 'up':
            return ceil($amount / $precision_value) * $precision_value;
        case 'down':
            return floor($amount / $precision_value) * $precision_value;
        case 'nearest':
        default:
            return round($amount / $precision_value) * $precision_value;
    }
}

/**
 * Format price according to currency settings
 */
function yoursite_format_currency($amount, $currency_code = null) {
    if (!$currency_code) {
        $currency = yoursite_get_user_currency();
    } else {
        $currency = yoursite_get_currency($currency_code);
    }
    
    if (!$currency) {
        return number_format($amount, 2);
    }
    
    // Apply rounding
    $amount = yoursite_apply_currency_rounding($amount, $currency);
    
    // Format number
    $formatted = number_format(
        $amount,
        $currency['decimal_places'],
        $currency['decimal_separator'],
        $currency['thousand_separator']
    );
    
    // Add prefix and suffix
    return $currency['prefix'] . $formatted . $currency['suffix'];
}

/**
 * Simple geolocation currency detection
 */
function yoursite_detect_currency_by_location() {
    // Simple IP to country detection (you can integrate with a service)
    $country_currency_map = array(
        'US' => 'USD',
        'CA' => 'CAD',
        'GB' => 'GBP',
        'AU' => 'AUD',
        'DE' => 'EUR',
        'FR' => 'EUR',
        'IT' => 'EUR',
        'ES' => 'EUR',
        'NL' => 'EUR',
        'JP' => 'JPY',
        'CN' => 'CNY',
        'IN' => 'INR',
        'BR' => 'BRL',
        'SE' => 'SEK',
        'NO' => 'NOK',
        'DK' => 'DKK'
    );
    
    // This is a basic implementation - you can enhance with actual IP geolocation
    $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    
    // For demo purposes, return based on browser language
    $browser_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en', 0, 2);
    
    $language_currency_map = array(
        'en' => 'USD',
        'de' => 'EUR',
        'fr' => 'EUR',
        'es' => 'EUR',
        'it' => 'EUR',
        'ja' => 'JPY',
        'zh' => 'CNY',
        'sv' => 'SEK',
        'no' => 'NOK',
        'da' => 'DKK'
    );
    
    $detected_currency_code = $language_currency_map[$browser_language] ?? 'USD';
    
    return yoursite_get_currency($detected_currency_code);
}

/**
 * Enhanced get user currency function with proper guest support
 */
/**
 * Enhanced get user currency function with guest support
 */
if (!function_exists('yoursite_get_user_currency')) {
    /**
     * Get the current user's preferred currency, with guest and fallback support.
     *
     * @return array The current currency data.
     */
    function yoursite_get_user_currency() {
        static $current_currency = null;

        // Return cached result if already set
        if ($current_currency !== null) {
            return $current_currency;
        }

        $cookie_name = 'yoursite_preferred_currency';

        // 1. Check cookie (guests and users)
        if (isset($_COOKIE[$cookie_name])) {
            $currency_code = sanitize_text_field($_COOKIE[$cookie_name]);
            $currency = yoursite_get_currency($currency_code);
            if ($currency && $currency['status'] === 'active') {
                $current_currency = $currency;
                return $current_currency;
            }
        }

        // 2. Check session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['preferred_currency'])) {
            $currency_code = sanitize_text_field($_SESSION['preferred_currency']);
            $currency = yoursite_get_currency($currency_code);
            if ($currency && $currency['status'] === 'active') {
                $current_currency = $currency;
                return $current_currency;
            }
        }

        // 3. Check logged-in user meta
        if (is_user_logged_in()) {
            $user_currency = get_user_meta(get_current_user_id(), 'preferred_currency', true);
            if (!empty($user_currency)) {
                $currency = yoursite_get_currency($user_currency);
                if ($currency && $currency['status'] === 'active') {
                    // Set cookie for future use
                    if (!headers_sent()) {
                        setcookie($cookie_name, $user_currency, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
                    }
                    $current_currency = $currency;
                    return $current_currency;
                }
            }
        }

        // 4. Auto-detect guest currency (first-time visitor)
        if (!is_user_logged_in() && !isset($_COOKIE[$cookie_name])) {
            $detected_currency = yoursite_detect_currency_for_first_time_visitors();
            if ($detected_currency) {
                if (!headers_sent()) {
                    setcookie($cookie_name, $detected_currency['code'], time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
                }
                $current_currency = $detected_currency;
                return $current_currency;
            }
        }

        // 5. Fallback to base currency
        $base_currency = yoursite_get_base_currency();
        $current_currency = $base_currency ?: array(
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'status' => 'active',
            'conversion_rate' => 1.0,
            'is_base_currency' => 1
        );

        return $current_currency;
    }
}

/**
 * Detect currency for guest users based on various signals
 */
function yoursite_detect_currency_for_guests() {
    // Skip detection if already has currency preference
    if (isset($_COOKIE['yoursite_preferred_currency'])) {
        return null;
    }
    
    $detected_currency_code = null;
    
    // 1. Try IP-based geolocation
    $geo_currency = yoursite_detect_currency_by_ip_simple();
    if ($geo_currency) {
        $detected_currency_code = $geo_currency;
    }
    
    // 2. Fallback to browser language
    if (!$detected_currency_code) {
        $lang_currency = yoursite_detect_currency_by_browser_language_simple();
        if ($lang_currency) {
            $detected_currency_code = $lang_currency;
        }
    }
    
    // 3. Check if detected currency is available
    if ($detected_currency_code) {
        $currency = yoursite_get_currency($detected_currency_code);
        if ($currency && $currency['status'] === 'active') {
            return $currency;
        }
    }
    
    return null;
}

/**
 * Simple IP-based currency detection
 */
function yoursite_detect_currency_by_ip_simple() {
    $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    
    // Skip for localhost/private IPs
    if (filter_var($user_ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return null;
    }
    
    // Simple country to currency mapping
    $country_currency_map = array(
        'US' => 'USD', 'CA' => 'CAD', 'GB' => 'GBP', 'AU' => 'AUD',
        'DE' => 'EUR', 'FR' => 'EUR', 'IT' => 'EUR', 'ES' => 'EUR',
        'NL' => 'EUR', 'BE' => 'EUR', 'AT' => 'EUR', 'PT' => 'EUR',
        'JP' => 'JPY', 'CN' => 'CNY', 'IN' => 'INR', 'BR' => 'BRL',
        'SE' => 'SEK', 'NO' => 'NOK', 'DK' => 'DKK', 'CH' => 'CHF',
        'PL' => 'PLN', 'RU' => 'RUB', 'KR' => 'KRW', 'MX' => 'MXN',
        'SG' => 'SGD', 'NZ' => 'NZD', 'HK' => 'HKD'
    );
    
    // Try to get country from Cloudflare header (if available)
    $country_code = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? null;
    
    // Fallback to simple IP lookup (you can integrate with a geolocation service)
    if (!$country_code) {
        $country_code = yoursite_get_country_from_ip($user_ip);
    }
    
    if ($country_code && isset($country_currency_map[$country_code])) {
        return $country_currency_map[$country_code];
    }
    
    return null;
}

/**
 * Simple country detection from IP (basic implementation)
 */
function yoursite_get_country_from_ip($ip) {
    // This is a basic implementation. For production, you'd want to use
    // a proper geolocation service like MaxMind, IP-API, or similar
    
    // Free IP geolocation API (with rate limits)
    $api_url = "http://ip-api.com/json/{$ip}?fields=countryCode";
    
    $response = wp_remote_get($api_url, array(
        'timeout' => 3,
        'sslverify' => false
    ));
    
    if (is_wp_error($response)) {
        return null;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    return $data['countryCode'] ?? null;
}

/**
 * Simple browser language to currency detection
 */
function yoursite_detect_currency_by_browser_language_simple() {
    $accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    
    if (empty($accept_language)) {
        return null;
    }
    
    // Parse accept-language header
    preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)\s*(?:;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $accept_language, $matches);
    
    $languages = array();
    for ($i = 0; $i < count($matches[1]); $i++) {
        $lang = strtolower($matches[1][$i]);
        $quality = $matches[2][$i] ?? '1.0';
        $languages[$lang] = floatval($quality);
    }
    
    // Sort by quality
    arsort($languages);
    
    $language_currency_map = array(
        'en-us' => 'USD', 'en' => 'USD',
        'en-ca' => 'CAD', 'fr-ca' => 'CAD',
        'en-gb' => 'GBP', 'en-au' => 'AUD',
        'de' => 'EUR', 'de-de' => 'EUR',
        'fr' => 'EUR', 'fr-fr' => 'EUR',
        'es' => 'EUR', 'es-es' => 'EUR',
        'it' => 'EUR', 'it-it' => 'EUR',
        'nl' => 'EUR', 'nl-nl' => 'EUR',
        'pt' => 'EUR', 'pt-pt' => 'EUR',
        'ja' => 'JPY', 'ja-jp' => 'JPY',
        'zh' => 'CNY', 'zh-cn' => 'CNY',
        'sv' => 'SEK', 'sv-se' => 'SEK',
        'no' => 'NOK', 'nb' => 'NOK',
        'da' => 'DKK', 'da-dk' => 'DKK',
        'pl' => 'PLN', 'pl-pl' => 'PLN',
        'ru' => 'RUB', 'ru-ru' => 'RUB',
        'ko' => 'KRW', 'ko-kr' => 'KRW'
    );
    
    foreach ($languages as $language => $quality) {
        if (isset($language_currency_map[$language])) {
            return $language_currency_map[$language];
        }
    }
    
    return null;
}

/**
 * Enhanced AJAX handler for currency switching (supports guests)
 */
function yoursite_ajax_switch_user_currency_enhanced() {
    // Start output buffering to prevent any unwanted output
    if (!ob_get_level()) {
        ob_start();
    }
    
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (empty($currency_code)) {
        ob_end_clean();
        wp_send_json_error(__('Invalid currency code', 'yoursite'));
    }
    
    // Validate currency code format (3 letter code)
    if (!preg_match('/^[A-Z]{3}$/', $currency_code)) {
        ob_end_clean();
        wp_send_json_error(__('Invalid currency format', 'yoursite'));
    }
    
    // Check if currency exists and is active
    $currency = yoursite_get_currency($currency_code);
    if (!$currency) {
        ob_end_clean();
        wp_send_json_error(__('Currency not found', 'yoursite'));
    }
    
    if ($currency['status'] !== 'active') {
        ob_end_clean();
        wp_send_json_error(__('Currency not available', 'yoursite'));
    }
    
    // Clean output buffer before processing
    ob_end_clean();
    
    $is_guest = !is_user_logged_in();
    
    // For guests: Only set cookie (JavaScript handles this, but we can confirm)
    if ($is_guest) {
        // Cookie is set by JavaScript, so we just confirm the currency is valid
        wp_send_json_success(array(
            'currency' => $currency,
            'currency_code' => $currency_code,
            'message' => sprintf(__('Currency switched to %s (%s)', 'yoursite'), $currency['name'], $currency_code),
            'user_type' => 'guest',
            'cookie_only' => true
        ));
        return;
    }
    
    // For logged-in users: Store in session and user meta
    if (!session_id()) {
        session_start();
    }
    
    // Store in session (immediate persistence)
    $_SESSION['preferred_currency'] = $currency_code;
    
    // Update user meta (persistent across sessions)
    update_user_meta(get_current_user_id(), 'preferred_currency', $currency_code);
    
    // Also set cookie for consistency
    setcookie('yoursite_preferred_currency', $currency_code, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
    
    wp_send_json_success(array(
        'currency' => $currency,
        'currency_code' => $currency_code,
        'message' => sprintf(__('Currency switched to %s (%s)', 'yoursite'), $currency['name'], $currency_code),
        'user_type' => 'logged_in',
        'session_set' => isset($_SESSION['preferred_currency']),
        'user_meta_updated' => true
    ));
}

/**
 * Enhanced JavaScript initialization with guest support
 */
function yoursite_init_currency_javascript_vars_enhanced() {
    $current_currency = yoursite_get_user_currency_enhanced();
    $is_guest = !is_user_logged_in();
    
    // Get available currencies for JavaScript
    $active_currencies = yoursite_get_active_currencies();
    $currencies_for_js = array();
    
    foreach ($active_currencies as $currency) {
        $currencies_for_js[$currency['code']] = array(
            'code' => $currency['code'],
            'name' => $currency['name'],
            'symbol' => $currency['symbol'] ?? $currency['code'],
            'flag' => $currency['flag'] ?? ''
        );
    }
    
    wp_add_inline_script('jquery', '
        window.YourSiteCurrency = window.YourSiteCurrency || {};
        window.YourSiteCurrency.current = "' . esc_js($current_currency['code']) . '";
        window.YourSiteCurrency.ajaxUrl = "' . esc_js(admin_url('admin-ajax.php')) . '";
        window.YourSiteCurrency.nonce = "' . esc_js(wp_create_nonce('currency_switch')) . '";
        window.YourSiteCurrency.cookieName = "yoursite_preferred_currency";
        window.YourSiteCurrency.debug = ' . (WP_DEBUG ? 'true' : 'false') . ';
        window.YourSiteCurrency.isGuest = ' . ($is_guest ? 'true' : 'false') . ';
        window.YourSiteCurrency.currencies = ' . wp_json_encode($currencies_for_js) . ';
    ', 'before');
}

/**
 * Get available currencies with proper caching
 */
function yoursite_get_active_currencies_cached() {
    static $cached_currencies = null;
    
    if ($cached_currencies !== null) {
        return $cached_currencies;
    }
    
    // Try to get from cache first
    $cached_currencies = wp_cache_get('yoursite_active_currencies', 'currency');
    
    if ($cached_currencies === false) {
        $cached_currencies = yoursite_get_active_currencies();
        // Cache for 15 minutes
        wp_cache_set('yoursite_active_currencies', $cached_currencies, 'currency', 900);
    }
    
    return $cached_currencies;
}

/**
 * Enhanced AJAX handler for getting available currencies (supports guests)
 */
function yoursite_ajax_get_available_currencies_enhanced() {
    $currencies = yoursite_get_active_currencies_cached();
    
    if (empty($currencies)) {
        wp_send_json_error(__('No currencies available', 'yoursite'));
    }
    
    // Format for frontend consumption
    $formatted_currencies = array();
    foreach ($currencies as $currency) {
        $formatted_currencies[] = array(
            'code' => $currency['code'],
            'name' => $currency['name'],
            'symbol' => $currency['symbol'] ?? $currency['code'],
            'flag' => $currency['flag'] ?? '',
            'is_base' => !empty($currency['is_base_currency'])
        );
    }
    
    $current_currency_code = yoursite_get_user_currency_enhanced()['code'];
    
    wp_send_json_success(array(
        'currencies' => $formatted_currencies,
        'count' => count($formatted_currencies),
        'current' => $current_currency_code,
        'user_type' => is_user_logged_in() ? 'logged_in' : 'guest'
    ));
}

/**
 * Override the original functions with enhanced versions
 */
function yoursite_override_currency_functions() {
    // Remove original actions if they exist
    remove_action('wp_enqueue_scripts', 'yoursite_init_currency_javascript_vars', 5);
    
    // Add enhanced versions
    add_action('wp_enqueue_scripts', 'yoursite_init_currency_javascript_vars_enhanced', 5);
    
    // Override AJAX handlers
    remove_action('wp_ajax_switch_user_currency', 'yoursite_ajax_switch_user_currency');
    remove_action('wp_ajax_nopriv_switch_user_currency', 'yoursite_ajax_switch_user_currency');
    remove_action('wp_ajax_get_available_currencies', 'yoursite_ajax_get_available_currencies');
    remove_action('wp_ajax_nopriv_get_available_currencies', 'yoursite_ajax_get_available_currencies');
    
    // Add enhanced handlers
    add_action('wp_ajax_switch_user_currency', 'yoursite_ajax_switch_user_currency_enhanced');
    add_action('wp_ajax_nopriv_switch_user_currency', 'yoursite_ajax_switch_user_currency_enhanced');
    add_action('wp_ajax_get_available_currencies', 'yoursite_ajax_get_available_currencies_enhanced');
    add_action('wp_ajax_nopriv_get_available_currencies', 'yoursite_ajax_get_available_currencies_enhanced');
}

// Initialize the enhanced currency system
add_action('init', 'yoursite_override_currency_functions', 1);

/**
 * Helper function to replace the original get_user_currency function
 */
if (!function_exists('yoursite_get_user_currency')) {
    function yoursite_get_user_currency() {
        return yoursite_get_user_currency_enhanced();
    }
}

if (!function_exists('yoursite_early_currency_detection')) {
    /**
     * Ensure currency detection runs early for guests
     */
    function yoursite_early_currency_detection() {
        // Only run for guests who don't already have the currency cookie
        if (!is_user_logged_in() && !isset($_COOKIE['yoursite_preferred_currency'])) {
            $detected_currency = yoursite_detect_currency_for_guests();
            if ($detected_currency && isset($detected_currency['code'])) {
                // Set the cookie for future visits
                if (!headers_sent()) {
                    setcookie(
                        'yoursite_preferred_currency',
                        $detected_currency['code'],
                        time() + (30 * DAY_IN_SECONDS),
                        COOKIEPATH,
                        COOKIE_DOMAIN,
                        is_ssl(),
                        true
                    );
                }

                // Also set it for the current request
                $_COOKIE['yoursite_preferred_currency'] = $detected_currency['code'];
            }
        }
    }

    add_action('init', 'yoursite_early_currency_detection', 0);
}

/**
 * Debug function to check currency status
 */
function yoursite_debug_currency_status() {
    if (!WP_DEBUG) {
        return;
    }
    
    $current_currency = yoursite_get_user_currency_enhanced();
    $is_guest = !is_user_logged_in();
    $cookie_value = $_COOKIE['yoursite_preferred_currency'] ?? 'not set';
    
    error_log("Currency Debug - User Type: " . ($is_guest ? 'Guest' : 'Logged In'));
    error_log("Currency Debug - Current Currency: " . $current_currency['code']);
    error_log("Currency Debug - Cookie Value: " . $cookie_value);
    
    if (!$is_guest && isset($_SESSION['preferred_currency'])) {
        error_log("Currency Debug - Session Currency: " . $_SESSION['preferred_currency']);
    }
}
add_action('wp_footer', 'yoursite_debug_currency_status');

/**
 * Detect currency for first-time visitors
 */
function yoursite_detect_currency_for_first_time_visitors() {
    $detected_currency_code = null;
    
    // 1. Try browser language first (more reliable)
    $lang_currency = yoursite_detect_currency_by_browser_language();
    if ($lang_currency) {
        $detected_currency_code = $lang_currency;
    }
    
    // 2. Try IP-based detection as fallback
    if (!$detected_currency_code) {
        $geo_currency = yoursite_detect_currency_by_simple_ip();
        if ($geo_currency) {
            $detected_currency_code = $geo_currency;
        }
    }
    
    // 3. Check if detected currency is available
    if ($detected_currency_code) {
        $currency = yoursite_get_currency($detected_currency_code);
        if ($currency && $currency['status'] === 'active') {
            return $currency;
        }
    }
    
    return null;
}



/**
 * Simple IP to currency detection
 */
function yoursite_detect_currency_by_simple_ip() {
    // Simple country to currency mapping
    $country_currency_map = array(
        'US' => 'USD', 'CA' => 'CAD', 'GB' => 'GBP', 'AU' => 'AUD',
        'DE' => 'EUR', 'FR' => 'EUR', 'IT' => 'EUR', 'ES' => 'EUR', 'NL' => 'EUR',
        'JP' => 'JPY', 'CN' => 'CNY', 'SE' => 'SEK', 'NO' => 'NOK', 'DK' => 'DKK'
    );
    
    // Try to get country from Cloudflare header (if available)
    $country_code = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? null;
    
    if ($country_code && isset($country_currency_map[$country_code])) {
        return $country_currency_map[$country_code];
    }
    
    return null;
}

/**
 * Early currency detection for guests
 */
function yoursite_early_currency_detection() {
    // Only run for guests on first visit (no existing cookie)
    if (!is_user_logged_in() && !isset($_COOKIE['yoursite_preferred_currency'])) {
        $detected_currency = yoursite_detect_currency_for_first_time_visitors();
        if ($detected_currency) {
            // Set for current request (JavaScript will handle cookie setting)
            $_COOKIE['yoursite_preferred_currency'] = $detected_currency['code'];
        }
    }
}
add_action('init', 'yoursite_early_currency_detection', 0);