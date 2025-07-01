<?php
/**
 * Currency System - PHP Enqueue Functions
 * File: functions.php or inc/currency/currency-enqueue.php
 * 
 * This handles the proper loading and configuration of the external currency JavaScript file
 */

/**
 * Enqueue currency system scripts and styles
 */
function yoursite_enqueue_currency_system() {
    // Don't load in admin area unless needed
    if (is_admin() && !wp_doing_ajax()) {
        return;
    }
    
    // Get current currency data
    $current_currency = yoursite_get_user_currency_safe();
    
    // Ensure we have valid currency data
    if (!$current_currency || !isset($current_currency['code'])) {
        if (WP_DEBUG) {
            error_log('Currency System: Invalid currency data, skipping script enqueue');
        }
        return;
    }
    
    // Determine script version for cache busting
    $script_version = WP_DEBUG ? time() : '1.0.0';
    
    // Enqueue the main currency system script
    wp_enqueue_script(
        'yoursite-currency-system',
        get_template_directory_uri() . '/assets/js/currency-system.js',
        array('jquery'), // Dependencies
        $script_version,
        true // Load in footer
    );
    
    // Prepare configuration data for the JavaScript
    $currency_config = array(
        'current' => $current_currency['code'],
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('currency_switch'),
        'cookieName' => 'yoursite_preferred_currency',
        'debug' => WP_DEBUG,
        'timeout' => 10000,
        'retryAttempts' => 2,
        'cookieExpiry' => 30,
        'autoReload' => get_option('yoursite_currency_auto_reload', false),
        'updateDelay' => 300,
        'restUrl' => rest_url('yoursite/v1/currency/'),
        'restNonce' => wp_create_nonce('wp_rest'),
        'currentCurrency' => array(
            'code' => $current_currency['code'],
            'name' => $current_currency['name'],
            'symbol' => $current_currency['symbol'] ?? $current_currency['code'],
            'position' => $current_currency['symbol_position'] ?? 'before'
        ),
        'translations' => array(
            'switchSuccess' => __('Currency switched successfully', 'yoursite'),
            'switchError' => __('Failed to switch currency', 'yoursite'),
            'networkError' => __('Network error occurred', 'yoursite'),
            'loadingText' => __('Switching currency...', 'yoursite'),
            'invalidCurrency' => __('Invalid currency selected', 'yoursite'),
            'accessDenied' => __('Access denied. Please refresh the page.', 'yoursite')
        )
    );
    
    // Localize script with configuration data
    wp_localize_script(
        'yoursite-currency-system',
        'YourSiteCurrencyConfig',
        $currency_config
    );
    
    // Optional: Add CSS for currency system UI
    wp_enqueue_style(
        'yoursite-currency-system',
        get_template_directory_uri() . '/assets/css/currency-system.css',
        array(),
        $script_version
    );
    
    // Add inline CSS for loading states if no external CSS file
    if (!file_exists(get_template_directory() . '/assets/css/currency-system.css')) {
        $inline_css = "
            .currency-loading { display: none; }
            .currency-loading-active .currency-switcher { opacity: 0.6; pointer-events: none; }
            .currency-updating { opacity: 0.7; transition: opacity 0.3s ease; }
            .currency-update-failed { background-color: #fee; border-left: 3px solid #dc3545; }
            .currency-notification { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
            .currency-button.active, .currency-button.selected { 
                background-color: #007cba; 
                color: white; 
                border-color: #007cba; 
            }
        ";
        wp_add_inline_style('yoursite-currency-system', $inline_css);
    }
}
add_action('wp_enqueue_scripts', 'yoursite_enqueue_currency_system', 10);

/**
 * Alternative enqueue method for child themes or plugins
 */
function yoursite_enqueue_currency_system_alternative() {
    // For child themes, use get_stylesheet_directory_uri()
    $script_url = get_stylesheet_directory_uri() . '/assets/js/currency-system.js';
    
    // Check if file exists before enqueuing
    $script_path = get_stylesheet_directory() . '/assets/js/currency-system.js';
    if (!file_exists($script_path)) {
        // Fallback to parent theme
        $script_url = get_template_directory_uri() . '/assets/js/currency-system.js';
        $script_path = get_template_directory() . '/assets/js/currency-system.js';
        
        if (!file_exists($script_path)) {
            if (WP_DEBUG) {
                error_log('Currency System: JavaScript file not found at expected locations');
            }
            return;
        }
    }
    
    $current_currency = yoursite_get_user_currency_safe();
    if (!$current_currency) {
        return;
    }
    
    wp_enqueue_script('jquery');
    
    wp_enqueue_script(
        'yoursite-currency-system',
        $script_url,
        array('jquery'),
        filemtime($script_path), // Use file modification time for versioning
        true
    );
    
    wp_localize_script(
        'yoursite-currency-system',
        'YourSiteCurrencyConfig',
        array(
            'current' => $current_currency['code'],
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('currency_switch'),
            'debug' => WP_DEBUG
        )
    );
}

/**
 * Enqueue for admin areas (if needed)
 */
function yoursite_enqueue_currency_admin_scripts($hook) {
    // Only load on specific admin pages
    $allowed_pages = array(
        'toplevel_page_yoursite-currency',
        'settings_page_yoursite-currency-settings',
        'edit.php?post_type=pricing'
    );
    
    if (!in_array($hook, $allowed_pages)) {
        return;
    }
    
    wp_enqueue_script('jquery');
    
    wp_enqueue_script(
        'yoursite-currency-admin',
        get_template_directory_uri() . '/assets/js/currency-admin.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    wp_localize_script(
        'yoursite-currency-admin',
        'YourSiteCurrencyAdmin',
        array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('currency_management_nonce'),
            'confirmDelete' => __('Are you sure you want to delete this currency?', 'yoursite'),
            'confirmRefresh' => __('This will update all currency rates. Continue?', 'yoursite')
        )
    );
}
add_action('admin_enqueue_scripts', 'yoursite_enqueue_currency_admin_scripts');

/**
 * Conditional loading based on page/post content
 */
function yoursite_conditional_currency_enqueue() {
    global $post;
    
    $should_load = false;
    
    // Always load on pricing pages
    if (is_page_template('page-pricing.php') || 
        is_post_type_archive('pricing') || 
        (is_singular() && get_post_type() === 'pricing')) {
        $should_load = true;
    }
    
    // Load if post/page content contains currency shortcodes or blocks
    if ($post && !$should_load) {
        $content = $post->post_content;
        
        // Check for currency-related shortcodes
        if (has_shortcode($content, 'currency_switcher') ||
            has_shortcode($content, 'pricing_table') ||
            has_shortcode($content, 'currency_price')) {
            $should_load = true;
        }
        
        // Check for Gutenberg blocks
        if (has_block('yoursite/currency-switcher', $post) ||
            has_block('yoursite/pricing-table', $post)) {
            $should_load = true;
        }
        
        // Check for currency switcher in content
        if (strpos($content, 'currency-switcher') !== false ||
            strpos($content, 'data-currency') !== false) {
            $should_load = true;
        }
    }
    
    // Load on checkout, cart, and account pages for WooCommerce
    if (function_exists('is_woocommerce')) {
        if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
            $should_load = true;
        }
    }
    
    // Allow themes/plugins to override
    $should_load = apply_filters('yoursite_should_load_currency_scripts', $should_load);
    
    if ($should_load) {
        yoursite_enqueue_currency_system();
    }
}
// Use this instead of the main enqueue function for conditional loading
// add_action('wp_enqueue_scripts', 'yoursite_conditional_currency_enqueue', 10);

/**
 * Enqueue scripts for specific themes or page builders
 */
function yoursite_currency_theme_compatibility() {
    // Elementor compatibility
    if (defined('ELEMENTOR_VERSION')) {
        add_action('elementor/frontend/after_enqueue_styles', function() {
            if (get_post_meta(get_the_ID(), '_elementor_data', true)) {
                yoursite_enqueue_currency_system();
            }
        });
    }
    
    // Divi compatibility
    if (function_exists('et_divi_fonts_url')) {
        add_action('wp_enqueue_scripts', function() {
            if (et_core_is_fb_enabled() || et_pb_is_pagebuilder_used(get_the_ID())) {
                yoursite_enqueue_currency_system();
            }
        }, 11);
    }
    
    // Beaver Builder compatibility
    if (class_exists('FLBuilder')) {
        add_action('wp_enqueue_scripts', function() {
            if (FLBuilder::is_builder_enabled()) {
                yoursite_enqueue_currency_system();
            }
        }, 11);
    }
}
add_action('init', 'yoursite_currency_theme_compatibility');

/**
 * Handle script loading for AJAX requests
 */
function yoursite_currency_ajax_scripts() {
    if (wp_doing_ajax() && isset($_REQUEST['action'])) {
        $currency_actions = array(
            'switch_user_currency',
            'get_available_currencies',
            'get_currency_pricing',
            'convert_currency_price'
        );
        
        if (in_array($_REQUEST['action'], $currency_actions)) {
            // Ensure scripts are available for AJAX responses that return HTML
            add_action('wp_print_scripts', 'yoursite_enqueue_currency_system');
        }
    }
}
add_action('init', 'yoursite_currency_ajax_scripts');

/**
 * Add script attributes for better performance
 */
function yoursite_currency_script_attributes($tag, $handle, $src) {
    // Add async/defer attributes to currency scripts
    if ($handle === 'yoursite-currency-system') {
        // Add defer attribute for better performance
        $tag = str_replace(' src', ' defer src', $tag);
        
        // Add module type for modern browsers (if using ES6 modules)
        // $tag = str_replace('<script ', '<script type="module" ', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'yoursite_currency_script_attributes', 10, 3);

/**
 * Preload critical currency data
 */
function yoursite_currency_preload_data() {
    if (!is_admin() && yoursite_should_load_currency_system()) {
        // Preload critical currency data in page head
        $current_currency = yoursite_get_user_currency_safe();
        $available_currencies = yoursite_get_active_currencies();
        
        if ($current_currency && $available_currencies) {
            ?>
            <script>
            window.YourSiteCurrencyPreload = {
                current: <?php echo wp_json_encode($current_currency); ?>,
                available: <?php echo wp_json_encode(array_slice($available_currencies, 0, 10)); ?>,
                timestamp: <?php echo time(); ?>
            };
            </script>
            <?php
        }
    }
}
add_action('wp_head', 'yoursite_currency_preload_data', 1);

/**
 * Helper function to check if currency system should load
 */
function yoursite_should_load_currency_system() {
    // Check if explicitly disabled
    if (get_option('yoursite_disable_currency_frontend', false)) {
        return false;
    }
    
    // Check if current page needs currency system
    global $post;
    
    if (is_admin()) {
        return false;
    }
    
    // Always load on pricing-related pages
    if (is_page_template('page-pricing.php') || 
        is_post_type_archive('pricing') ||
        (is_singular() && get_post_type() === 'pricing')) {
        return true;
    }
    
    // Check for currency widgets in sidebars
    if (is_active_widget(false, false, 'yoursite_currency_widget')) {
        return true;
    }
    
    // Check customizer settings
    if (get_theme_mod('show_currency_switcher', false)) {
        return true;
    }
    
    return apply_filters('yoursite_should_load_currency_system', false);
}

/**
 * Register currency system settings for customizer/admin
 */
function yoursite_currency_register_settings() {
    // Register settings
    register_setting('yoursite_currency_settings', 'yoursite_currency_auto_reload', array(
        'type' => 'boolean',
        'default' => false,
        'sanitize_callback' => 'rest_sanitize_boolean'
    ));
    
    register_setting('yoursite_currency_settings', 'yoursite_disable_currency_frontend', array(
        'type' => 'boolean',
        'default' => false,
        'sanitize_callback' => 'rest_sanitize_boolean'
    ));
    
    register_setting('yoursite_currency_settings', 'yoursite_currency_cache_duration', array(
        'type' => 'integer',
        'default' => 300,
        'sanitize_callback' => 'absint'
    ));
}
add_action('init', 'yoursite_currency_register_settings');

/**
 * Add currency system to WordPress Customizer
 */
function yoursite_currency_customizer_settings($wp_customize) {
    // Add currency section
    $wp_customize->add_section('yoursite_currency', array(
        'title' => __('Currency Settings', 'yoursite'),
        'description' => __('Configure currency switcher display options', 'yoursite'),
        'priority' => 130
    ));
    
    // Show currency switcher setting
    $wp_customize->add_setting('show_currency_switcher', array(
        'default' => false,
        'transport' => 'refresh',
        'sanitize_callback' => 'rest_sanitize_boolean'
    ));
    
    $wp_customize->add_control('show_currency_switcher', array(
        'label' => __('Show Currency Switcher', 'yoursite'),
        'description' => __('Display currency switcher in header/footer', 'yoursite'),
        'section' => 'yoursite_currency',
        'type' => 'checkbox'
    ));
    
    // Currency switcher position
    $wp_customize->add_setting('currency_switcher_position', array(
        'default' => 'header',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('currency_switcher_position', array(
        'label' => __('Currency Switcher Position', 'yoursite'),
        'section' => 'yoursite_currency',
        'type' => 'radio',
        'choices' => array(
            'header' => __('Header', 'yoursite'),
            'footer' => __('Footer', 'yoursite'),
            'both' => __('Both Header and Footer', 'yoursite')
        ),
        'active_callback' => function() {
            return get_theme_mod('show_currency_switcher', false);
        }
    ));
}
add_action('customize_register', 'yoursite_currency_customizer_settings');

/**
 * Debug function to check script loading
 */
function yoursite_currency_debug_scripts() {
    if (WP_DEBUG && current_user_can('manage_options')) {
        add_action('wp_footer', function() {
            global $wp_scripts;
            
            if (isset($wp_scripts->registered['yoursite-currency-system'])) {
                echo '<!-- Currency System: Script registered and enqueued -->';
                
                if (isset($wp_scripts->done) && in_array('yoursite-currency-system', $wp_scripts->done)) {
                    echo '<!-- Currency System: Script loaded successfully -->';
                } else {
                    echo '<!-- Currency System: Script registered but not loaded -->';
                }
            } else {
                echo '<!-- Currency System: Script not registered -->';
            }
        });
    }
}
add_action('init', 'yoursite_currency_debug_scripts');

/**
 * Fallback inline script if external file fails to load
 */
function yoursite_currency_fallback_script() {
    if (!wp_script_is('yoursite-currency-system', 'done')) {
        ?>
        <script>
        console.warn('Currency System: External script failed to load, using fallback');
        
        // Minimal fallback functionality
        window.YourSiteCurrency = window.YourSiteCurrency || {
            switchTo: function(currency, callback) {
                console.log('Fallback: Switching to', currency);
                if (callback) callback(false, {message: 'External script not loaded'});
            },
            getCurrent: function() {
                return {code: '<?php echo esc_js(yoursite_get_user_currency_safe()['code'] ?? 'USD'); ?>'};
            }
        };
        </script>
        <?php
    }
}
add_action('wp_footer', 'yoursite_currency_fallback_script', 999);

/**
 * Performance optimization: Preconnect to external resources
 */
function yoursite_currency_preconnect() {
    if (yoursite_should_load_currency_system()) {
        // Preconnect to currency API endpoints if using external services
        echo '<link rel="preconnect" href="https://api.exchangerate-api.com" crossorigin>';
        echo '<link rel="preconnect" href="https://api.fixer.io" crossorigin>';
    }
}
add_action('wp_head', 'yoursite_currency_preconnect', 2);

// Additional helper functions and hooks can be added here...