<?php
/**
 * YourSite.biz Theme Functions - COMPLETE VERSION WITH FIXED CURRENCY SYSTEM
 * 
 * FIXED: All session-related header issues resolved
 * - Sessions start very early before any output
 * - Proper session guards throughout
 * - JavaScript-based cookie management
 * - No more "headers already sent" errors
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// =============================================================================
// EARLY SESSION INITIALIZATION - MUST BE FIRST
// =============================================================================

/**
 * Start session VERY early - before any possible output
 * This is the most critical fix for header issues
 */
function yoursite_start_session_ultra_early() {
    // Only start if:
    // 1. Not in CLI mode
    // 2. Session not already started
    // 3. Headers not sent
    // 4. Not in admin area (unless AJAX)
    if (php_sapi_name() !== 'cli' && 
        session_status() === PHP_SESSION_NONE && 
        !headers_sent() &&
        (!is_admin() || wp_doing_ajax())) {
        session_start();
    }
}
// Hook to the earliest possible action with highest priority
add_action('muplugins_loaded', 'yoursite_start_session_ultra_early', -1000);
add_action('plugins_loaded', 'yoursite_start_session_ultra_early', -1000);

// =============================================================================
// THEME CONSTANTS AND BASIC SETUP
// =============================================================================

// Define theme constants
define('YOURSITE_THEME_VERSION', '1.0.0');
define('YOURSITE_THEME_DIR', get_template_directory());
define('YOURSITE_THEME_URI', get_template_directory_uri());

// Load pricing system components
require_once get_template_directory() . '/inc/pricing-loader.php';
require_once get_template_directory() . '/inc/currency-loader.php';

// =============================================================================
// SAFE SESSION UTILITIES - NO HEADER CONFLICTS
// =============================================================================

/**
 * Check if session is safely available
 */
function yoursite_has_safe_session() {
    return (session_status() === PHP_SESSION_ACTIVE && !headers_sent());
}

/**
 * Get currency from session safely
 */
function yoursite_get_session_currency() {
    if (yoursite_has_safe_session() && isset($_SESSION['preferred_currency'])) {
        return sanitize_text_field($_SESSION['preferred_currency']);
    }
    return '';
}

/**
 * Set currency in session safely
 */
function yoursite_set_session_currency($currency_code) {
    if (yoursite_has_safe_session()) {
        $_SESSION['preferred_currency'] = sanitize_text_field($currency_code);
        return true;
    }
    return false;
}

/**
 * MAIN: Get user currency with comprehensive fallbacks - NO SESSION CREATION
 */
function yoursite_get_user_currency_safe() {
    static $current_currency = null;
    
    // Return cached result to avoid repeated database queries
    if ($current_currency !== null) {
        return $current_currency;
    }
    
    $cookie_name = 'yoursite_preferred_currency';
    
    // 1. First priority: Check cookie (most reliable, no headers involved)
    if (isset($_COOKIE[$cookie_name])) {
        $currency_code = sanitize_text_field($_COOKIE[$cookie_name]);
        if (function_exists('yoursite_get_currency')) {
            $currency = yoursite_get_currency($currency_code);
            if ($currency && $currency['status'] === 'active') {
                $current_currency = $currency;
                // Optionally sync to session if available (but don't create session)
                yoursite_set_session_currency($currency_code);
                return $current_currency;
            }
        }
    }
    
    // 2. Second priority: Check existing session (no session creation)
    $session_currency = yoursite_get_session_currency();
    if ($session_currency && function_exists('yoursite_get_currency')) {
        $currency = yoursite_get_currency($session_currency);
        if ($currency && $currency['status'] === 'active') {
            $current_currency = $currency;
            return $current_currency;
        }
    }
    
    // 3. Third priority: Check user meta if logged in
    if (is_user_logged_in()) {
        $user_currency = get_user_meta(get_current_user_id(), 'preferred_currency', true);
        if ($user_currency && function_exists('yoursite_get_currency')) {
            $currency = yoursite_get_currency($user_currency);
            if ($currency && $currency['status'] === 'active') {
                $current_currency = $currency;
                return $current_currency;
            }
        }
    }
    
    // 4. Final fallback: Base currency or USD
    if (function_exists('yoursite_get_base_currency')) {
        $current_currency = yoursite_get_base_currency();
    } else {
        $current_currency = array(
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'status' => 'active'
        );
    }
    
    return $current_currency;
}

/**
 * Clean up currency session on logout (safely)
 */
function yoursite_cleanup_currency_session_safe() {
    if (yoursite_has_safe_session() && isset($_SESSION['preferred_currency'])) {
        unset($_SESSION['preferred_currency']);
    }
}
add_action('wp_logout', 'yoursite_cleanup_currency_session_safe');

// =============================================================================
// DARK MODE SYSTEM
// =============================================================================

/**
 * Add dark mode CSS variables
 */
function yoursite_add_dark_mode_vars() {
    echo '<style id="dark-mode-vars">
        :root {
            --text-primary: #111827;
            --text-secondary: #374151;
            --text-tertiary: #6b7280;
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
        }
        
        body.dark-mode {
            --text-primary: #f9fafb;
            --text-secondary: #e5e7eb;
            --text-tertiary: #d1d5db;
            --bg-primary: #111827;
            --bg-secondary: #1f2937;
            --card-bg: #1f2937;
            --border-color: #374151;
        }
    </style>';
}
add_action('wp_head', 'yoursite_add_dark_mode_vars', 1);

/**
 * Dark mode detection script
 */
function yoursite_dark_mode_detection() {
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        const isDarkMode = localStorage.getItem("darkMode") === "enabled" ||
                          (localStorage.getItem("darkMode") === null && 
                           window.matchMedia && 
                           window.matchMedia("(prefers-color-scheme: dark)").matches);
        
        if (isDarkMode) {
            document.documentElement.classList.add("dark-mode");
            document.body.classList.add("dark-mode");
        }
    });
</script>';
}
add_action('wp_head', 'yoursite_dark_mode_detection', 0);

/**
 * Emergency dark mode fixes
 */
function yoursite_dark_mode_fixes() {
    echo '<style id="dark-mode-fixes">
        body.dark-mode {
            background-color: #111827 !important;
            color: #e5e7eb !important;
        }
        
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6 {
            color: #f9fafb !important;
        }
        
        body.dark-mode .text-gray-900 {
            color: #f9fafb !important;
        }
        
        body.dark-mode .text-gray-600,
        body.dark-mode .text-gray-700 {
            color: #e5e7eb !important;
        }
        
        body.dark-mode .text-gray-500 {
            color: #d1d5db !important;
        }
        
        body.dark-mode .bg-white {
            background-color: #1f2937 !important;
        }
        
        body.dark-mode .bg-gray-50 {
            background-color: #374151 !important;
        }
        
        body.dark-mode .border-gray-200,
        body.dark-mode .border-gray-300 {
            border-color: #374151 !important;
        }
        
        body.dark-mode .hero-gradient *,
        body.dark-mode .templates-cta-section *,
        body.dark-mode .bg-gradient-to-br *,
        body.dark-mode .bg-gradient-to-r * {
            color: white !important;
        }
        
        /* Ensure final CTA (footer banner) maintains its gradient */
        body.dark-mode .final-cta-section,
        body.dark-mode section.hero-gradient:last-of-type {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }
        
        body.dark-mode .feature-card,
        body.dark-mode .pricing-card,
        body.dark-mode .webinar-card,
        body.dark-mode .template-card,
        body.dark-mode .templates-card {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        body.dark-mode .site-header {
            background-color: #111827 !important;
            border-bottom-color: #374151 !important;
        }
        
        body.dark-mode .site-header a {
            color: #e5e7eb !important;
        }
        
        body.dark-mode input,
        body.dark-mode textarea,
        body.dark-mode select {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
            color: #f9fafb !important;
        }
        
        body.dark-mode .btn-secondary {
            background-color: #374151 !important;
            color: #f9fafb !important;
            border-color: #4b5563 !important;
        }
        
        body.dark-mode a {
            color: #60a5fa !important;
        }
        
        body.dark-mode .template-filter-btn {
            background-color: #1f2937 !important;
            color: #f9fafb !important;
            border-color: #374151 !important;
        }
        
        body.dark-mode .template-filter-btn.active {
            background-color: #8b5cf6 !important;
            color: white !important;
        }
        
        body.dark-mode .webinar-filter {
            background-color: #1f2937 !important;
            color: #f9fafb !important;
            border-color: #374151 !important;
        }
        
        body.dark-mode .webinar-filter.active {
            background-color: #1d4ed8 !important;
            color: white !important;
        }
    </style>';
}
add_action('wp_head', 'yoursite_dark_mode_fixes', 2);

/**
 * Dark mode toggle button
 */
function yoursite_dark_mode_toggle() {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if device is mobile
            function isMobile() {
                return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }
            
            // Only create toggle on desktop
            if (isMobile()) {
                return; // Exit early on mobile devices
            }
            
            let toggle = document.querySelector(".dark-mode-toggle");
            
            if (!toggle) {
                toggle = document.createElement("button");
                toggle.className = "dark-mode-toggle";
                toggle.innerHTML = `
                    <svg class="sun-icon" style="width:20px;height:20px;display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg class="moon-icon" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                `;
                toggle.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    background: var(--card-bg);
                    border: 1px solid var(--border-color);
                    border-radius: 8px;
                    padding: 8px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                `;
                
                document.body.appendChild(toggle);
            }
            
            toggle.addEventListener("click", function() {
                const isDarkMode = document.body.classList.contains("dark-mode");
                
                if (isDarkMode) {
                    document.documentElement.classList.remove("dark-mode");
                    document.body.classList.remove("dark-mode");
                    localStorage.setItem("darkMode", "disabled");
                } else {
                    document.documentElement.classList.add("dark-mode");
                    document.body.classList.add("dark-mode");
                    localStorage.setItem("darkMode", "enabled");
                }
                
                updateToggleAppearance();
            });
            
            function updateToggleAppearance() {
                const isDarkMode = document.body.classList.contains("dark-mode");
                const sunIcon = toggle.querySelector(".sun-icon");
                const moonIcon = toggle.querySelector(".moon-icon");
                
                if (isDarkMode) {
                    sunIcon.style.display = "block";
                    moonIcon.style.display = "none";
                } else {
                    sunIcon.style.display = "none";
                    moonIcon.style.display = "block";
                }
            }
            
            updateToggleAppearance();
            
            // Hide toggle on window resize if screen becomes mobile size
            window.addEventListener("resize", function() {
                if (isMobile() && toggle) {
                    toggle.style.display = "none";
                } else if (toggle) {
                    toggle.style.display = "flex";
                }
            });
        });
    </script>';
}
add_action('wp_footer', 'yoursite_dark_mode_toggle');

// =============================================================================
// THEME SETUP
// =============================================================================

/**
 * Fallback theme setup (only if not already defined)
 */
if (!function_exists('yoursite_theme_setup')) {
    function yoursite_theme_setup_fallback() {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('custom-logo');
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    }
    add_action('after_setup_theme', 'yoursite_theme_setup_fallback', 20);
}

/**
 * Enqueue scripts and styles
 */
function yoursite_scripts_minimal() {
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), YOURSITE_THEME_VERSION);

    wp_enqueue_script('jquery');

    wp_enqueue_script(
        'yoursite-custom-js',
        get_template_directory_uri() . '/assets/js/custom.js',
        array('jquery'), // ensures jquery loads first
        YOURSITE_THEME_VERSION,
        true // load in footer
    );
}
add_action('wp_enqueue_scripts', 'yoursite_scripts_minimal');


// =============================================================================
// COMPONENT LOADING
// =============================================================================

/**
 * Load theme components
 */
function yoursite_load_components() {
    $components = array(
        'theme-setup.php',
        'enqueue-scripts.php',
        'customizer.php',
        'post-types.php',
        'meta-boxes.php',
        'widgets.php',
        'helpers.php',
        'ajax-handlers.php',
        'admin-functions.php',
        'theme-activation.php',
        'theme-modes.php',
        'feature-pages.php',
        'zencommerce-themes.php'
    );
    
    foreach ($components as $component) {
        $file = YOURSITE_THEME_DIR . '/inc/' . $component;
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
add_action('after_setup_theme', 'yoursite_load_components', 5);

// =============================================================================
// CURRENCY SYSTEM INTEGRATION - ENHANCED VERSION
// =============================================================================

/**
 * Enhanced currency JavaScript with comprehensive error handling and improvements
 */
function yoursite_currency_javascript_system() {
    $current_currency = yoursite_get_user_currency_safe();
    ?>
    <script>
    (function() {
        'use strict';
        
        // Initialize YourSite Currency System with enhanced configuration
        window.YourSiteCurrency = window.YourSiteCurrency || {};
        
        // Core configuration
        const config = {
            current: '<?php echo esc_js($current_currency['code']); ?>',
            ajaxUrl: '<?php echo esc_js(admin_url('admin-ajax.php')); ?>',
            nonce: '<?php echo esc_js(wp_create_nonce('currency_switch')); ?>',
            cookieName: 'yoursite_preferred_currency',
            debug: <?php echo WP_DEBUG ? 'true' : 'false'; ?>,
            timeout: 10000,
            retryAttempts: 2,
            cookieExpiry: 30
        };
        
        // State management
        const state = {
            isLoading: false,
            requestQueue: [],
            lastUpdate: null,
            availableCurrencies: null
        };
        
        // Enhanced cookie utility functions with error handling
        const cookieUtils = {
            set: function(name, value, days) {
                try {
                    days = days || config.cookieExpiry;
                    const date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    const expires = "; expires=" + date.toUTCString();
                    const secure = location.protocol === 'https:' ? '; Secure' : '';
                    
                    document.cookie = name + "=" + encodeURIComponent(value || "") + expires + "; path=/; SameSite=Lax" + secure;
                    
                    if (config.debug) {
                        console.log('Cookie set successfully:', { name, value, days });
                    }
                    return true;
                } catch (error) {
                    console.error('Failed to set cookie:', error);
                    return false;
                }
            },
            
            get: function(name) {
                try {
                    const nameEQ = name + "=";
                    const cookies = document.cookie.split(';');
                    
                    for (let i = 0; i < cookies.length; i++) {
                        let cookie = cookies[i].trim();
                        if (cookie.indexOf(nameEQ) === 0) {
                            return decodeURIComponent(cookie.substring(nameEQ.length));
                        }
                    }
                    return null;
                } catch (error) {
                    console.error('Failed to get cookie:', error);
                    return null;
                }
            },
            
            delete: function(name) {
                return this.set(name, '', -1);
            }
        };
        
        // Enhanced AJAX helper with retry logic
        const ajaxHelper = {
            request: function(data, successCallback, errorCallback, attempt) {
                attempt = attempt || 1;
                
                if (state.isLoading && attempt === 1) {
                    if (config.debug) {
                        console.warn('Request blocked - another currency operation in progress');
                    }
                    if (errorCallback) errorCallback({ message: 'Another request in progress' });
                    return;
                }
                
                state.isLoading = true;
                
                jQuery.ajax({
                    url: config.ajaxUrl,
                    type: 'POST',
                    data: {
                        nonce: config.nonce,
                        ...data
                    },
                    dataType: 'json',
                    timeout: config.timeout,
                    success: function(response) {
                        state.isLoading = false;
                        
                        if (response && response.success) {
                            if (successCallback) successCallback(response.data);
                        } else {
                            const errorMsg = response?.data?.message || 'Unknown server error';
                            console.error('Server error:', errorMsg, response?.data);
                            if (errorCallback) errorCallback(response?.data || { message: errorMsg });
                        }
                    },
                    error: function(xhr, status, error) {
                        state.isLoading = false;
                        
                        // Retry logic for network errors
                        if (attempt < config.retryAttempts && (status === 'timeout' || status === 'error')) {
                            if (config.debug) {
                                console.log(`Retrying request (attempt ${attempt + 1}/${config.retryAttempts})`);
                            }
                            setTimeout(() => {
                                ajaxHelper.request(data, successCallback, errorCallback, attempt + 1);
                            }, 1000 * attempt); // Exponential backoff
                            return;
                        }
                        
                        let errorMessage = 'Network error occurred';
                        
                        switch (status) {
                            case 'timeout':
                                errorMessage = 'Request timed out. Please check your connection.';
                                break;
                            case 'abort':
                                errorMessage = 'Request was cancelled';
                                break;
                            case 'parsererror':
                                errorMessage = 'Invalid server response';
                                break;
                            default:
                                if (xhr.status === 403) {
                                    errorMessage = 'Access denied. Please refresh the page.';
                                } else if (xhr.status === 500) {
                                    errorMessage = 'Server error. Please try again later.';
                                } else if (xhr.status === 0) {
                                    errorMessage = 'Network connection lost';
                                }
                        }
                        
                        console.error('AJAX error:', { status, error, xhr: xhr.status });
                        if (errorCallback) errorCallback({ message: errorMessage, code: status });
                    }
                });
            }
        };
        
        // UI helper functions
        const uiHelpers = {
            showLoading: function() {
                jQuery('.currency-switcher select, .currency-button').prop('disabled', true);
                jQuery('.currency-loading').show();
            },
            
            hideLoading: function() {
                jQuery('.currency-switcher select, .currency-button').prop('disabled', false);
                jQuery('.currency-loading').hide();
            },
            
            showNotification: function(message, type) {
                type = type || 'info';
                
                // Remove existing notifications
                jQuery('.currency-notification').remove();
                
                const notification = jQuery(`
                    <div class="currency-notification currency-notification--${type}" style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: ${type === 'error' ? '#dc3545' : type === 'success' ? '#28a745' : '#17a2b8'};
                        color: white;
                        padding: 12px 20px;
                        border-radius: 4px;
                        z-index: 9999;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                        font-size: 14px;
                        max-width: 300px;
                        word-wrap: break-word;
                    ">
                        ${message}
                    </div>
                `);
                
                jQuery('body').append(notification);
                
                // Auto-remove after 4 seconds
                setTimeout(() => {
                    notification.fadeOut(300, function() {
                        jQuery(this).remove();
                    });
                }, 4000);
            },
            
            updateCurrencyDisplay: function(currencyCode, currencyData) {
                // Update currency symbols
                jQuery('.currency-symbol').text(currencyData?.symbol || currencyCode);
                
                // Update currency selectors
                jQuery('.currency-switcher select').val(currencyCode);
                
                // Update currency buttons
                jQuery('.currency-button')
                    .removeClass('active current')
                    .filter(`[data-currency="${currencyCode}"]`)
                    .addClass('active current');
                
                // Update any elements with data-currency-code attribute
                jQuery('[data-currency-code]').attr('data-currency-code', currencyCode);
            }
        };
        
        // Main currency switching function with enhanced error handling
        window.YourSiteCurrency.switchTo = function(currencyCode, callback) {
            // Input validation
            if (!currencyCode || typeof currencyCode !== 'string') {
                const error = { message: 'Invalid currency code provided' };
                if (callback) callback(false, error);
                return;
            }
            
            currencyCode = currencyCode.toUpperCase().trim();
            
            // Check if it's the same currency
            if (currencyCode === config.current) {
                if (config.debug) {
                    console.log('Currency already selected:', currencyCode);
                }
                if (callback) callback(true, { message: 'Currency already selected' });
                return;
            }
            
            if (config.debug) {
                console.log('Switching currency to:', currencyCode);
            }
            
            uiHelpers.showLoading();
            
            // Set cookie immediately for instant UI feedback
            cookieUtils.set(config.cookieName, currencyCode, config.cookieExpiry);
            
            // Update server-side persistence via AJAX
            ajaxHelper.request(
                {
                    action: 'switch_user_currency',
                    currency: currencyCode
                },
                function(data) {
                    // Success callback
                    uiHelpers.hideLoading();
                    
                    // Update global current currency
                    config.current = currencyCode;
                    state.lastUpdate = new Date();
                    
                    // Update UI
                    uiHelpers.updateCurrencyDisplay(currencyCode, data.currency);
                    
                    // Show success message
                    if (data.message) {
                        uiHelpers.showNotification(data.message, 'success');
                    }
                    
                    if (config.debug) {
                        console.log('Currency switched successfully:', data);
                    }
                    
                    // Call success callback
                    if (callback) callback(true, data);
                    
                    // Trigger custom event for other components
                    jQuery(document).trigger('currencyChanged', [currencyCode, data]);
                },
                function(error) {
                    // Error callback
                    uiHelpers.hideLoading();
                    
                    const errorMessage = error?.message || 'Failed to switch currency';
                    uiHelpers.showNotification(errorMessage, 'error');
                    
                    console.error('Currency switch failed:', error);
                    
                    // Revert cookie on server error (but keep for immediate UI feedback on network errors)
                    if (error?.code !== 'timeout' && error?.code !== 'error') {
                        cookieUtils.set(config.cookieName, config.current, config.cookieExpiry);
                    }
                    
                    if (callback) callback(false, error);
                }
            );
        };
        
        // Get all available currencies with caching
        window.YourSiteCurrency.getAvailable = function(callback, forceRefresh) {
            if (!forceRefresh && state.availableCurrencies) {
                if (callback) callback(state.availableCurrencies);
                return;
            }
            
            ajaxHelper.request(
                { action: 'get_available_currencies' },
                function(data) {
                    if (data && data.currencies) {
                        state.availableCurrencies = data.currencies;
                        if (callback) callback(data.currencies);
                    } else {
                        if (callback) callback([]);
                    }
                },
                function(error) {
                    console.error('Failed to get available currencies:', error);
                    if (callback) callback([]);
                }
            );
        };
        
        // Get current currency info
        window.YourSiteCurrency.getCurrent = function() {
            return {
                code: config.current,
                fromCookie: cookieUtils.get(config.cookieName),
                lastUpdate: state.lastUpdate
            };
        };
        
        // Utility functions
        window.YourSiteCurrency.setCookie = cookieUtils.set;
        window.YourSiteCurrency.getCookie = cookieUtils.get;
        window.YourSiteCurrency.isLoading = function() { return state.isLoading; };
        window.YourSiteCurrency.refresh = function() {
            state.availableCurrencies = null;
            window.YourSiteCurrency.getAvailable(null, true);
        };
        
        // Enhanced initialization on document ready
  jQuery(document).ready(function($) {
    try {
        if (typeof config === 'undefined' || typeof cookieUtils === 'undefined' || typeof uiHelpers === 'undefined' || typeof window.YourSiteCurrency === 'undefined') {
            console.error('Currency system dependencies are missing.');
            return;
        }


                // Sync cookie with current currency
                const cookieCurrency = cookieUtils.get(config.cookieName);
                if (cookieCurrency && cookieCurrency !== config.current) {
                    cookieUtils.set(config.cookieName, config.current, config.cookieExpiry);
                }
                
                if (config.debug) {
                    console.log('YourSite Currency System Initialized:', {
                        current: config.current,
                        cookie: cookieCurrency,
                        sessionSupported: typeof(Storage) !== "undefined",
                        timestamp: new Date().toISOString()
                    });
                }
                
                // Enhanced event handling for currency switchers
                $(document).on('change', '.currency-switcher select', function(e) {
                    e.preventDefault();
                    const selectedCurrency = $(this).val();
                    if (selectedCurrency && selectedCurrency !== config.current) {
                        window.YourSiteCurrency.switchTo(selectedCurrency);
                    }
                });
                
                // Support for currency buttons
                $(document).on('click', '.currency-button', function(e) {
                    e.preventDefault();
                    const selectedCurrency = $(this).data('currency');
                    if (selectedCurrency && selectedCurrency !== config.current) {
                        window.YourSiteCurrency.switchTo(selectedCurrency);
                    }
                });
                
                // Enhanced currency change event handler
                $(document).on('currencyChanged', function(event, currencyCode, data) {
                    // Update all pricing displays with error handling
                    $('.pricing-amount, .price, [data-price]').each(function() {
                        const $element = $(this);
                        const planId = $element.data('plan-id');
                        
                        if (planId) {
                            // Add loading state
                            $element.addClass('currency-updating');
                            
                            // This would trigger a pricing update AJAX call
                            // You should implement this based on your pricing structure
                            if (window.YourSiteCurrency.updatePricing) {
                                window.YourSiteCurrency.updatePricing(planId, currencyCode, function(success) {
                                    $element.removeClass('currency-updating');
                                    if (!success) {
                                        $element.addClass('currency-update-failed');
                                        setTimeout(() => $element.removeClass('currency-update-failed'), 3000);
                                    }
                                });
                            }
                        }
                    });
                });
                
                // Handle page visibility changes to refresh stale data
                $(document).on('visibilitychange', function() {
                    if (!document.hidden && state.lastUpdate) {
                        const timeSinceUpdate = Date.now() - state.lastUpdate.getTime();
                        // Refresh if it's been more than 30 minutes
                        if (timeSinceUpdate > 1800000) {
                            window.YourSiteCurrency.refresh();
                        }
                    }
                });
                
                // Initialize UI state
                uiHelpers.updateCurrencyDisplay(config.current, null);
                
                // Load available currencies for future use
                window.YourSiteCurrency.getAvailable();
                
                // Trigger ready event
                $(document).trigger('currencySystemReady');
                
            } catch (initError) {
                console.error('Currency system initialization failed:', initError);
            }
        });
        
    })();
    </script>
    <?php
}
add_action('wp_head', 'yoursite_currency_javascript_system', 5);

/**
 * FIXED: Currency switching AJAX handler - NO SESSION CONFLICTS
 */
function yoursite_ajax_switch_user_currency_fixed() {
    // Clean any existing output buffers to prevent header issues
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Start fresh output buffer
    ob_start();
    
    // Validate input
    $currency_code = sanitize_text_field($_POST['currency'] ?? '');
    
    if (empty($currency_code)) {
        ob_end_clean();
        wp_send_json_error(array(
            'message' => __('Invalid currency code', 'yoursite'),
            'code' => 'invalid_currency'
        ));
    }
    
    // Validate currency format
    if (!preg_match('/^[A-Z]{3}$/', $currency_code)) {
        ob_end_clean();
        wp_send_json_error(array(
            'message' => __('Invalid currency format', 'yoursite'),
            'code' => 'invalid_format'
        ));
    }
    
    // Verify currency exists and is active
    $currency = null;
    if (function_exists('yoursite_get_currency')) {
        $currency = yoursite_get_currency($currency_code);
        if (!$currency || $currency['status'] !== 'active') {
            ob_end_clean();
            wp_send_json_error(array(
                'message' => __('Currency not available', 'yoursite'),
                'code' => 'currency_unavailable'
            ));
        }
    } else {
        // Fallback validation
        $valid_currencies = array('USD', 'EUR', 'GBP', 'CAD', 'AUD', 'JPY');
        if (!in_array($currency_code, $valid_currencies)) {
            ob_end_clean();
            wp_send_json_error(array(
                'message' => __('Currency not supported', 'yoursite'),
                'code' => 'currency_not_supported'
            ));
        }
        
        $currency = array(
            'code' => $currency_code,
            'name' => $currency_code,
            'symbol' => $currency_code,
            'status' => 'active'
        );
    }
    
    // Clean buffer before processing
    ob_end_clean();
    
    // Store in session if available (but don't create session)
    $session_updated = yoursite_set_session_currency($currency_code);
    
    // Update user meta if logged in
    $user_meta_updated = false;
    if (is_user_logged_in()) {
        $user_meta_updated = update_user_meta(get_current_user_id(), 'preferred_currency', $currency_code);
    }
    
    // Log for debugging
    if (WP_DEBUG_LOG) {
        error_log(sprintf(
            'Currency switched to %s - Session: %s, User Meta: %s, User ID: %d',
            $currency_code,
            $session_updated ? 'Yes' : 'No',
            $user_meta_updated ? 'Yes' : 'No',
            is_user_logged_in() ? get_current_user_id() : 0
        ));
    }
    
    // Return success response
    wp_send_json_success(array(
        'currency' => $currency,
        'currency_code' => $currency_code,
        'message' => sprintf(__('Currency switched to %s', 'yoursite'), $currency['name'] ?? $currency_code),
        'session_updated' => $session_updated,
        'user_meta_updated' => $user_meta_updated,
        'cookie_should_be_set' => true, // Tell frontend to set cookie
        'timestamp' => current_time('mysql')
    ));
}

// Register the AJAX handler
add_action('wp_ajax_switch_user_currency', 'yoursite_ajax_switch_user_currency_fixed');
add_action('wp_ajax_nopriv_switch_user_currency', 'yoursite_ajax_switch_user_currency_fixed');

/**
 * Get available currencies AJAX handler
 */
function yoursite_ajax_get_available_currencies() {
    $currencies = array();
    
    if (function_exists('yoursite_get_active_currencies')) {
        $currencies = yoursite_get_active_currencies();
    } else {
        // Fallback currency list
        $currencies = array(
            array('code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$'),
            array('code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'),
            array('code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£'),
            array('code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$'),
            array('code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$'),
            array('code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥'),
        );
    }
    
    wp_send_json_success(array(
        'currencies' => $currencies,
        'count' => count($currencies),
        'current' => yoursite_get_user_currency_safe()['code']
    ));
}
add_action('wp_ajax_get_available_currencies', 'yoursite_ajax_get_available_currencies');
add_action('wp_ajax_nopriv_get_available_currencies', 'yoursite_ajax_get_available_currencies');

// =============================================================================
// PRESS KIT CUSTOMIZER
// =============================================================================

/**
 * Add press kit customizer options
 */
function yoursite_press_kit_customizer($wp_customize) {
    $wp_customize->add_section('press_kit_section', array(
        'title' => 'Press Kit Information',
        'priority' => 40,
    ));
    
    $settings = array(
        'company_founded' => array('label' => 'Company Founded Year', 'default' => '2020'),
        'company_location' => array('label' => 'Company Location', 'default' => 'San Francisco, CA, USA'),
        'company_industry' => array('label' => 'Company Industry', 'default' => 'E-commerce Technology & SaaS'),
        'company_employees' => array('label' => 'Number of Employees', 'default' => '50-100'),
        'stat_users' => array('label' => 'Active Users', 'default' => '100K+'),
        'stat_integrations' => array('label' => 'Integrations', 'default' => '50+'),
        'stat_countries' => array('label' => 'Countries Served', 'default' => '180+'),
        'stat_uptime' => array('label' => 'Uptime', 'default' => '99.9%')
    );
    
    foreach ($settings as $setting_key => $setting_data) {
        $wp_customize->add_setting($setting_key, array(
            'default' => $setting_data['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control($setting_key, array(
            'label' => $setting_data['label'],
            'section' => 'press_kit_section',
            'type' => 'text',
        ));
    }
    
    // Textarea settings
    $textarea_settings = array(
        'company_mission' => array(
            'label' => 'Mission Statement', 
            'default' => 'To empower businesses of all sizes with seamless integrations that drive growth, efficiency, and customer satisfaction in the digital economy.'
        ),
        'company_vision' => array(
            'label' => 'Vision Statement', 
            'default' => 'To be the world\'s leading platform for e-commerce integrations, connecting every business tool and service in a unified ecosystem.'
        )
    );
    
    foreach ($textarea_settings as $setting_key => $setting_data) {
        $wp_customize->add_setting($setting_key, array(
            'default' => $setting_data['default'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        
        $wp_customize->add_control($setting_key, array(
            'label' => $setting_data['label'],
            'section' => 'press_kit_section',
            'type' => 'textarea',
        ));
    }
}
add_action('customize_register', 'yoursite_press_kit_customizer');

// =============================================================================
// HERO BACKGROUND SYSTEM - SINGLE CLEAN IMPLEMENTATION
// =============================================================================

/**
 * Hero Background Image System - Main Customizer Function
 */
function yoursite_hero_background_customizer($wp_customize) {
    
    // Add section if it doesn't exist
    if (!$wp_customize->get_section('homepage_editor')) {
        $wp_customize->add_section('homepage_editor', array(
            'title' => __('Homepage', 'yoursite'),
            'priority' => 30,
        ));
    }
    
    // Hero Background Type
    $wp_customize->add_setting('hero_background_type', array(
        'default' => 'gradient',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_background_type', array(
        'label' => __('Hero Background Type', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'select',
        'choices' => array(
            'gradient' => __('Gradient Background', 'yoursite'),
            'image' => __('Image Background', 'yoursite'),
            'image_with_gradient' => __('Image with Gradient Overlay', 'yoursite'),
        ),
        'priority' => 13,
    ));
    
    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label' => __('Hero Background Image', 'yoursite'),
        'section' => 'homepage_editor',
        'description' => __('Upload an image to use as hero background', 'yoursite'),
        'priority' => 14,
    )));
    
    // Gradient Primary Color
    $wp_customize->add_setting('hero_gradient_primary', array(
        'default' => '#667eea',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_gradient_primary', array(
        'label' => __('Gradient Primary Color', 'yoursite'),
        'section' => 'homepage_editor',
        'priority' => 15,
    )));
    
    // Gradient Secondary Color
    $wp_customize->add_setting('hero_gradient_secondary', array(
        'default' => '#764ba2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_gradient_secondary', array(
        'label' => __('Gradient Secondary Color', 'yoursite'),
        'section' => 'homepage_editor',
        'priority' => 16,
    )));
    
    // Overlay Opacity
    $wp_customize->add_setting('hero_overlay_opacity', array(
        'default' => 40,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_overlay_opacity', array(
        'label' => __('Background Overlay Opacity (%)', 'yoursite'),
        'section' => 'homepage_editor',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0,
            'max' => 80,
            'step' => 5,
        ),
        'priority' => 17,
    ));
}
add_action('customize_register', 'yoursite_hero_background_customizer');

/**
 * Helper function for hex to rgba conversion
 */
function yoursite_hero_hex_to_rgba($hex, $alpha = 1) {
    $hex = str_replace('#', '', $hex);
    
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    return 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $alpha . ')';
}

/**
 * Output the dynamic hero CSS - MAIN HERO ONLY
 */
function yoursite_hero_background_css() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    $background_type = get_theme_mod('hero_background_type', 'gradient');
    $background_image = get_theme_mod('hero_background_image', '');
    $gradient_primary = get_theme_mod('hero_gradient_primary', '#667eea');
    $gradient_secondary = get_theme_mod('hero_gradient_secondary', '#764ba2');
    $overlay_opacity = get_theme_mod('hero_overlay_opacity', 40);
    
    $css = '';
    switch ($background_type) {
        case 'gradient':
            $css = 'background: linear-gradient(135deg, ' . esc_attr($gradient_primary) . ' 0%, ' . esc_attr($gradient_secondary) . ' 100%) !important;';
            break;
            
        case 'image':
            if ($background_image) {
                $css = 'background: url("' . esc_url($background_image) . '") !important; background-size: cover !important; background-position: center !important; background-repeat: no-repeat !important;';
            }
            break;
            
        case 'image_with_gradient':
            if ($background_image) {
                $primary_rgba = yoursite_hero_hex_to_rgba($gradient_primary, 0.8);
                $secondary_rgba = yoursite_hero_hex_to_rgba($gradient_secondary, 0.8);
                $css = 'background: linear-gradient(135deg, ' . $primary_rgba . ' 0%, ' . $secondary_rgba . ' 100%), url("' . esc_url($background_image) . '") !important; background-size: cover !important; background-position: center !important; background-repeat: no-repeat !important;';
            }
            break;
    }
    
    echo '<style id="hero-background-dynamic">' . "\n";
    
    // Target only the FIRST hero section (main hero), not the final CTA
    echo '.hero-gradient:first-of-type, section.hero-gradient:first-of-type {' . "\n";
    echo '    position: relative !important;' . "\n";
    echo '    min-height: 600px !important;' . "\n";
    echo '    display: flex !important;' . "\n";
    echo '    align-items: center !important;' . "\n";
    echo '    color: white !important;' . "\n";
    echo '    ' . $css . "\n";
    echo '}' . "\n";
    
    // Ensure the final CTA keeps its default gradient
    echo 'section.hero-gradient:last-of-type, .final-cta-section {' . "\n";
    echo '    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;' . "\n";
    echo '}' . "\n";
    
    // Text styling for main hero only
    echo '.hero-gradient:first-of-type h1, .hero-gradient:first-of-type p, .hero-gradient:first-of-type .text-white {' . "\n";
    echo '    color: white !important;' . "\n";
    echo '}' . "\n";
    
    echo '</style>' . "\n";
}
add_action('wp_head', 'yoursite_hero_background_css', 20);

// =============================================================================
// UPDATED PRICING SYSTEM INTEGRATION - CLEANED VERSION
// =============================================================================

/**
 * Remove old pricing plan customizer sections
 */
function yoursite_remove_old_pricing_customizer($wp_customize) {
    // Remove any existing pricing plan controls from customizer
    $old_controls = array(
        'pricing_plans_enable',
        'pricing_plan_1_enable', 'pricing_plan_1_name', 'pricing_plan_1_description', 'pricing_plan_1_price', 'pricing_plan_1_features', 'pricing_plan_1_button_text',
        'pricing_plan_2_enable', 'pricing_plan_2_name', 'pricing_plan_2_description', 'pricing_plan_2_price', 'pricing_plan_2_features', 'pricing_plan_2_button_text',
        'pricing_plan_3_enable', 'pricing_plan_3_featured', 'pricing_plan_3_name', 'pricing_plan_3_description', 'pricing_plan_3_price', 'pricing_plan_3_features', 'pricing_plan_3_button_text'
    );
    
    foreach ($old_controls as $control) {
        $wp_customize->remove_control($control);
        $wp_customize->remove_setting($control);
    }
}
add_action('customize_register', 'yoursite_remove_old_pricing_customizer', 99);

/**
 * Main admin notice to guide users to the new pricing system
 */
function yoursite_pricing_admin_notice() {
    $screen = get_current_screen();
    
    // Only show on relevant admin pages (not dashboard)
    if (!$screen || (!strpos($screen->id, 'customize') && $screen->id !== 'edit-pricing' && $screen->id !== 'pricing')) {
        return;
    }
    
    // Don't show on dashboard
    if ($screen->id === 'dashboard') {
        return;
    }
    
    // Check if this notice has been dismissed
    $dismissed = get_user_meta(get_current_user_id(), 'yoursite_pricing_notice_dismissed', true);
    
    if (!$dismissed) {
        ?>
        <div class="notice notice-info is-dismissible" data-notice="yoursite-pricing-update">
            <h3><?php _e('🎉 Pricing Plans System Updated!', 'yoursite'); ?></h3>
            <p><?php _e('Great news! Your pricing plans are now managed directly in WP-Admin for better flexibility.', 'yoursite'); ?></p>
            <p><strong><?php _e('What changed:', 'yoursite'); ?></strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><?php _e('Pricing plans are now managed in <strong>WP-Admin → Pricing Plans</strong>', 'yoursite'); ?></li>
                <li><?php _e('Each plan has comprehensive feature settings for the comparison table', 'yoursite'); ?></li>
                <li><?php _e('Page content (hero, FAQ, CTA) is still customized in <strong>Appearance → Customize → Pricing Page</strong>', 'yoursite'); ?></li>
            </ul>
            <p>
                <a href="<?php echo admin_url('edit.php?post_type=pricing'); ?>" class="button button-primary">
                    <?php _e('Manage Pricing Plans', 'yoursite'); ?>
                </a>
                <a href="<?php echo admin_url('customize.php?autofocus[section]=pricing_page_editor'); ?>" class="button">
                    <?php _e('Customize Page Content', 'yoursite'); ?>
                </a>
                <a href="<?php echo home_url('/pricing'); ?>" class="button" target="_blank">
                    <?php _e('View Pricing Page', 'yoursite'); ?>
                </a>
            </p>
        </div>
        <script>
        jQuery(document).ready(function($) {
            $(document).on('click', '.notice[data-notice="yoursite-pricing-update"] .notice-dismiss', function() {
                $.post(ajaxurl, {
                    action: 'dismiss_yoursite_pricing_notice',
                    nonce: '<?php echo wp_create_nonce('dismiss_pricing_notice'); ?>'
                });
            });
        });
        </script>
        <?php
    }
}
add_action('admin_notices', 'yoursite_pricing_admin_notice');

/**
 * Handle dismissal of pricing notice
 */
function yoursite_dismiss_pricing_notice() {
    if (wp_verify_nonce($_POST['nonce'], 'dismiss_pricing_notice')) {
        update_user_meta(get_current_user_id(), 'yoursite_pricing_notice_dismissed', true);
    }
    wp_die();
}
add_action('wp_ajax_dismiss_yoursite_pricing_notice', 'yoursite_dismiss_pricing_notice');

/**
 * Clean up old pricing plan theme mods (run once)
 */
function yoursite_cleanup_old_pricing_mods() {
    // Only run this once
    if (get_option('yoursite_pricing_cleanup_done')) {
        return;
    }
    
    // Remove old pricing plan theme mods
    $old_mods = array(
        'pricing_plans_enable',
        'pricing_plan_1_enable', 'pricing_plan_1_name', 'pricing_plan_1_description', 'pricing_plan_1_price', 'pricing_plan_1_features', 'pricing_plan_1_button_text',
        'pricing_plan_2_enable', 'pricing_plan_2_name', 'pricing_plan_2_description', 'pricing_plan_2_price', 'pricing_plan_2_features', 'pricing_plan_2_button_text',
        'pricing_plan_3_enable', 'pricing_plan_3_featured', 'pricing_plan_3_name', 'pricing_plan_3_description', 'pricing_plan_3_price', 'pricing_plan_3_features', 'pricing_plan_3_button_text',
    );
    
    foreach ($old_mods as $mod) {
        remove_theme_mod($mod);
    }
    
    // Mark cleanup as done
    update_option('yoursite_pricing_cleanup_done', true);
}
add_action('after_switch_theme', 'yoursite_cleanup_old_pricing_mods');

/**
 * Ensure pricing comparison table gets latest data
 */
function yoursite_refresh_pricing_data() {
    // Clear any cached pricing data when plans are updated
    delete_transient('yoursite_pricing_plans_cache');
}
add_action('save_post_pricing', 'yoursite_refresh_pricing_data');
add_action('delete_post', 'yoursite_refresh_pricing_data');

// =============================================================================
// ENHANCED ADMIN EXPERIENCE FOR PRICING
// =============================================================================

/**
 * Add pricing plans to admin menu with counter
 */
function yoursite_enhance_pricing_admin_menu() {
    global $menu, $submenu;
    
    // Find the pricing plans menu item and add a counter
    foreach ($menu as $key => $item) {
        if (isset($item[2]) && $item[2] === 'edit.php?post_type=pricing') {
            $count = wp_count_posts('pricing');
            if ($count && $count->publish > 0) {
                $menu[$key][0] .= ' <span class="awaiting-mod">' . $count->publish . '</span>';
            }
            break;
        }
    }
}
add_action('admin_menu', 'yoursite_enhance_pricing_admin_menu', 999);

/**
 * Add pricing management to admin bar
 */
function yoursite_add_pricing_admin_bar($admin_bar) {
    if (!current_user_can('edit_posts')) {
        return;
    }
    
    $admin_bar->add_menu(array(
        'id' => 'pricing-management',
        'title' => '💰 Pricing',
        'href' => admin_url('edit.php?post_type=pricing'),
        'meta' => array(
            'title' => __('Manage Pricing Plans', 'yoursite'),
        ),
    ));
    
    $admin_bar->add_menu(array(
        'id' => 'add-pricing-plan',
        'parent' => 'pricing-management',
        'title' => 'Add New Plan',
        'href' => admin_url('post-new.php?post_type=pricing'),
    ));
    
    $admin_bar->add_menu(array(
        'id' => 'view-pricing-page',
        'parent' => 'pricing-management',
        'title' => 'View Pricing Page',
        'href' => home_url('/pricing'),
        'meta' => array('target' => '_blank'),
    ));
    
    $admin_bar->add_menu(array(
        'id' => 'customize-pricing',
        'parent' => 'pricing-management',
        'title' => 'Customize Content',
        'href' => admin_url('customize.php?autofocus[section]=pricing_page_editor'),
    ));
}
add_action('admin_bar_menu', 'yoursite_add_pricing_admin_bar', 80);

/**
 * Enhanced admin styles for pricing
 */
function yoursite_pricing_admin_styles() {
    $screen = get_current_screen();
    
    if (in_array($screen->id, array('pricing', 'edit-pricing'))) {
        ?>
        
        
        <script>
        jQuery(document).ready(function($) {
            // Add helpful header to pricing admin
            if ($('.wrap h1').length && $('.wrap h1').text().includes('Pricing')) {
                $('.wrap h1').after(`
                    <div class="pricing-admin-header">
                        <h2>💰 Pricing Plans Management</h2>
                        <p>Create and manage your pricing plans here. Each plan will automatically appear on your pricing page and in the comparison table.</p>
                        <p><strong>Tip:</strong> Use the detailed feature fields to populate the comprehensive comparison table with all your plan features.</p>
                    </div>
                `);
            }
            
            // Add quick actions for new pricing plans
            if ($('.page-title-action').length) {
                $('.page-title-action').after(`
                    <a href="<?php echo home_url('/pricing'); ?>" class="button" target="_blank" style="margin-left: 10px;">
                        👁️ View Pricing Page
                    </a>
                    <a href="<?php echo admin_url('customize.php?autofocus[section]=pricing_page_editor'); ?>" class="button" style="margin-left: 5px;">
                        🎨 Customize Content
                    </a>
                `);
            }
            
            // Add tips for feature fields
            if ($('.pricing-features-comparison').length) {
                $('.pricing-features-comparison').before(`
                    <div class="pricing-tips">
                        <h4>💡 Feature Configuration Tips</h4>
                        <ul>
                            <li><strong>"Yes" or "✓"</strong> - Shows a green checkmark</li>
                            <li><strong>"No" or "✗"</strong> - Shows a dash</li>
                            <li><strong>Numbers</strong> - Like "100", "1000" for limits</li>
                            <li><strong>"Unlimited"</strong> - Shows infinity symbol</li>
                            <li><strong>Descriptive text</strong> - Like "Basic support", "24/7 Premium"</li>
                        </ul>
                    </div>
                `);
            }
            
            // Auto-calculate annual price with 20% discount
            $('#pricing_monthly_price').on('input', function() {
                const monthlyPrice = parseFloat($(this).val());
                const annualField = $('#pricing_annual_price');
                
                if (monthlyPrice > 0 && !annualField.val()) {
                    const annualPrice = (monthlyPrice * 12 * 0.8).toFixed(2);
                    annualField.val(annualPrice);
                    annualField.css('background-color', '#f0f8ff');
                    
                    // Show helpful message
                    if (!annualField.next('.auto-calc-note').length) {
                        annualField.after('<p class="auto-calc-note" style="color: #0073aa; font-size: 12px; margin-top: 5px;">💡 Auto-calculated with 20% annual discount</p>');
                    }
                }
            });
            
            // Clear auto-calc styling when user manually edits
            $('#pricing_annual_price').on('input', function() {
                $(this).css('background-color', '');
                $(this).next('.auto-calc-note').remove();
            });
        });
        </script>
        <?php
    }
}
add_action('admin_head', 'yoursite_pricing_admin_styles');

// =============================================================================
// UTILITY FUNCTIONS AND HELPERS
// =============================================================================

/**
 * Helper function to get currency pricing for templates
 */
function yoursite_get_plan_pricing_display($plan_id, $currency_code = null) {
    if (!$currency_code) {
        $current_currency = yoursite_get_user_currency_safe();
        $currency_code = $current_currency['code'];
    }
    
    if (!function_exists('yoursite_get_pricing_plan_price')) {
        return false;
    }
    
    $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
    $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
    
    if ($monthly_price === false || $annual_price === false) {
        return false;
    }
    
    $annual_monthly_equivalent = $annual_price > 0 ? $annual_price / 12 : 0;
    $savings = $monthly_price > 0 && $annual_monthly_equivalent > 0 ? 
               ($monthly_price * 12) - $annual_price : 0;
    $discount_percentage = $monthly_price > 0 ? 
                          round((($savings / ($monthly_price * 12)) * 100), 0) : 0;
    
    return array(
        'monthly' => array(
            'raw' => $monthly_price,
            'formatted' => yoursite_format_currency($monthly_price, $currency_code)
        ),
        'annual' => array(
            'raw' => $annual_price,
            'formatted' => yoursite_format_currency($annual_price, $currency_code),
            'monthly_equivalent' => array(
                'raw' => $annual_monthly_equivalent,
                'formatted' => yoursite_format_currency($annual_monthly_equivalent, $currency_code)
            )
        ),
        'savings' => array(
            'raw' => $savings,
            'formatted' => $savings > 0 ? yoursite_format_currency($savings, $currency_code) : '',
            'percentage' => $discount_percentage
        ),
        'currency_code' => $currency_code
    );
}

/**
 * Add currency info to body class for CSS targeting
 */
function yoursite_add_currency_body_class($classes) {
    $current_currency = yoursite_get_user_currency_safe();
    $classes[] = 'currency-' . strtolower($current_currency['code']);
    return $classes;
}
add_filter('body_class', 'yoursite_add_currency_body_class');

/**
 * Add currency meta tag for SEO/Analytics
 */
function yoursite_add_currency_meta() {
    $current_currency = yoursite_get_user_currency_safe();
    echo '<meta name="currency" content="' . esc_attr($current_currency['code']) . '">' . "\n";
    echo '<meta name="currency-name" content="' . esc_attr($current_currency['name']) . '">' . "\n";
}
add_action('wp_head', 'yoursite_add_currency_meta');

/**
 * WordPress admin bar currency info (for admins)
 */
function yoursite_add_currency_admin_bar($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $current_currency = yoursite_get_user_currency_safe();
    
    $wp_admin_bar->add_node(array(
        'id' => 'currency-info',
        'title' => '💱 ' . $current_currency['code'],
        'href' => admin_url('edit.php?post_type=pricing'),
        'meta' => array(
            'title' => 'Current Currency: ' . $current_currency['name']
        )
    ));
}
add_action('admin_bar_menu', 'yoursite_add_currency_admin_bar', 80);

// =============================================================================
// PERFORMANCE AND OPTIMIZATION
// =============================================================================

/**
 * Optimize pricing queries
 */
function yoursite_optimize_pricing_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_page_template('page-pricing.php') || is_page('pricing')) {
            // Preload pricing plans to avoid multiple queries
            $pricing_plans = get_posts(array(
                'post_type' => 'pricing',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_key' => '_pricing_monthly_price',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
            ));
            
            // Cache the results
            set_transient('yoursite_pricing_plans_cache', $pricing_plans, HOUR_IN_SECONDS);
        }
    }
}
add_action('pre_get_posts', 'yoursite_optimize_pricing_queries');

/**
 * Debug function for development (remove in production)
 */
function yoursite_currency_debug_info() {
    if (!current_user_can('manage_options') || !isset($_GET['currency_debug'])) {
        return;
    }
    
    $current_currency = yoursite_get_user_currency_safe();
    
    echo '<div style="position: fixed; top: 10px; left: 10px; background: white; padding: 15px; border: 2px solid #ccc; z-index: 9999; font-family: monospace; font-size: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">';
    echo '<h4 style="margin: 0 0 10px 0;">Currency Debug Info</h4>';
    echo '<p><strong>Current:</strong> ' . $current_currency['code'] . ' (' . $current_currency['name'] . ')</p>';
    echo '<p><strong>Cookie:</strong> ' . (isset($_COOKIE['yoursite_preferred_currency']) ? $_COOKIE['yoursite_preferred_currency'] : 'Not set') . '</p>';
    echo '<p><strong>Session:</strong> ' . yoursite_get_session_currency() . '</p>';
    echo '<p><strong>User Meta:</strong> ' . (is_user_logged_in() ? get_user_meta(get_current_user_id(), 'preferred_currency', true) : 'Not logged in') . '</p>';
    echo '<p><strong>Headers Sent:</strong> ' . (headers_sent() ? 'Yes' : 'No') . '</p>';
    echo '<p><strong>Session Status:</strong> ' . session_status() . '</p>';
    echo '<p><strong>Session ID:</strong> ' . (session_id() ?: 'No session') . '</p>';
    echo '<p style="margin: 10px 0 0 0; font-size: 10px; color: #666;">Visit: <code>?currency_debug=1</code></p>';
    echo '</div>';
}
add_action('wp_footer', 'yoursite_currency_debug_info');

// =============================================================================
// MIGRATION AND BACKWARDS COMPATIBILITY
// =============================================================================

/**
 * Handle migration from old pricing system
 */
function yoursite_migrate_old_pricing_data() {
    // Check if migration has already been done
    if (get_option('yoursite_pricing_migrated')) {
        return;
    }
    
    // Check for old customizer pricing plans
    $old_plans = array();
    for ($i = 1; $i <= 3; $i++) {
        $plan_enabled = get_theme_mod("pricing_plan_{$i}_enable", false);
        if ($plan_enabled) {
            $old_plans[] = array(
                'name' => get_theme_mod("pricing_plan_{$i}_name", "Plan {$i}"),
                'description' => get_theme_mod("pricing_plan_{$i}_description", ''),
                'price' => get_theme_mod("pricing_plan_{$i}_price", '0'),
                'features' => get_theme_mod("pricing_plan_{$i}_features", ''),
                'featured' => get_theme_mod("pricing_plan_{$i}_featured", false),
                'button_text' => get_theme_mod("pricing_plan_{$i}_button_text", 'Get Started'),
            );
        }
    }
    
    // Migrate old plans to new post type
    if (!empty($old_plans)) {
        foreach ($old_plans as $plan) {
            $post_id = wp_insert_post(array(
                'post_title' => $plan['name'],
                'post_excerpt' => $plan['description'],
                'post_status' => 'publish',
                'post_type' => 'pricing'
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_pricing_monthly_price', floatval($plan['price']));
                update_post_meta($post_id, '_pricing_annual_price', floatval($plan['price']) * 12 * 0.8);
                update_post_meta($post_id, '_pricing_currency', 'USD');
                update_post_meta($post_id, '_pricing_featured', $plan['featured'] ? '1' : '0');
                update_post_meta($post_id, '_pricing_button_text', $plan['button_text']);
                update_post_meta($post_id, '_pricing_button_url', '#');
                update_post_meta($post_id, '_pricing_features', $plan['features']);
            }
        }
        
        // Add admin notice about migration
        add_option('yoursite_pricing_migration_notice', true);
    }
    
    // Mark migration as complete
    update_option('yoursite_pricing_migrated', true);
}
add_action('after_switch_theme', 'yoursite_migrate_old_pricing_data');

/**
 * Show migration notice
 */
function yoursite_show_migration_notice() {
    if (get_option('yoursite_pricing_migration_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <h3><?php _e('✅ Pricing Plans Migrated Successfully!', 'yoursite'); ?></h3>
            <p><?php _e('Your existing pricing plans have been automatically migrated to the new system.', 'yoursite'); ?></p>
            <p>
                <a href="<?php echo admin_url('edit.php?post_type=pricing'); ?>" class="button button-primary">
                    <?php _e('Review Your Pricing Plans', 'yoursite'); ?>
                </a>
            </p>
        </div>
        <?php
        delete_option('yoursite_pricing_migration_notice');
    }
}
add_action('admin_notices', 'yoursite_show_migration_notice');

// =============================================================================
// ERROR HANDLING AND CLEANUP
// =============================================================================

/**
 * Enhanced error reporting for development
 */
if (WP_DEBUG) {
    // Temporary error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/**
 * Clean up scheduled currency events on theme deactivation
 */
function yoursite_cleanup_currency_cron() {
    wp_clear_scheduled_hook('yoursite_refresh_currency_rates');
}
register_deactivation_hook(__FILE__, 'yoursite_cleanup_currency_cron');

/**
 * Add contextual help for pricing plans
 */
function yoursite_add_pricing_help() {
    $screen = get_current_screen();
    
    if ($screen->id === 'pricing') {
        $screen->add_help_tab(array(
            'id' => 'pricing_overview',
            'title' => __('Pricing Plans Overview'),
            'content' => '
                <h3>Managing Your Pricing Plans</h3>
                <p>This is where you create and manage individual pricing plans that appear on your pricing page.</p>
                
                <h4>Basic Information</h4>
                <ul>
                    <li><strong>Title:</strong> The name of your plan (e.g., "Starter", "Professional", "Enterprise")</li>
                    <li><strong>Excerpt:</strong> Short description that appears under the plan name</li>
                    <li><strong>Monthly/Annual Price:</strong> Set your pricing (annual price auto-calculates with 20% discount)</li>
                    <li><strong>Featured Plan:</strong> Mark your most popular plan to highlight it</li>
                </ul>
                
                <h4>Features Configuration</h4>
                <p>The detailed features section is used to populate the comprehensive comparison table. Use these values:</p>
                <ul>
                    <li><strong>"Yes", "✓", "Included"</strong> - Shows as a green checkmark</li>
                    <li><strong>"No", "✗", "-"</strong> - Shows as a dash</li>
                    <li><strong>Numbers</strong> - Display as-is (e.g., "100", "1000")</li>
                    <li><strong>"Unlimited"</strong> - Shows with infinity symbol</li>
                    <li><strong>Custom text</strong> - Any descriptive text (e.g., "Basic support", "Premium only")</li>
                </ul>
            '
        ));
        
        $screen->add_help_tab(array(
            'id' => 'pricing_tips',
            'title' => __('Best Practices'),
            'content' => '
                <h3>Pricing Page Best Practices</h3>
                
                <h4>Plan Structure</h4>
                <ul>
                    <li>Limit to 3-4 plans maximum for better decision-making</li>
                    <li>Mark one plan as "Featured" to guide customer choice</li>
                    <li>Use clear, descriptive plan names</li>
                    <li>Include brief but compelling plan descriptions</li>
                </ul>
                
                <h4>Pricing Strategy</h4>
                <ul>
                    <li>Annual pricing typically offers 15-25% discount</li>
                    <li>Featured plan should be your target customer choice</li>
                    <li>Include a free or low-cost entry plan when possible</li>
                    <li>Clear value progression between plans</li>
                </ul>
                
                <h4>Feature Presentation</h4>
                <ul>
                    <li>Lead with benefits, not just features</li>
                    <li>Use consistent language across all plans</li>
                    <li>Highlight unique features in higher-tier plans</li>
                    <li>Consider what matters most to your customers</li>
                </ul>
            '
        ));
    }
}
add_action('current_screen', 'yoursite_add_pricing_help');

/**
 * Add pricing plan templates/presets
 */
function yoursite_add_pricing_presets() {
    // Only add on new pricing plan page
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'pricing' && isset($_GET['preset'])) {
        add_action('admin_footer', function() {
            $preset = sanitize_text_field($_GET['preset']);
            
            $presets = array(
                'saas' => array(
                    'title' => 'Professional',
                    'excerpt' => 'Perfect for growing businesses',
                    'monthly_price' => '49',
                    'features' => "Unlimited products\nAdvanced analytics\nPriority support\nCustom integrations\nAPI access"
                ),
                'ecommerce' => array(
                    'title' => 'Store Builder',
                    'excerpt' => 'Everything you need to sell online',
                    'monthly_price' => '29',
                    'features' => "Up to 1,000 products\nPayment processing\nInventory management\nSEO tools\nMobile responsive"
                ),
                'enterprise' => array(
                    'title' => 'Enterprise',
                    'excerpt' => 'For large organizations with custom needs',
                    'monthly_price' => '199',
                    'features' => "Unlimited everything\nDedicated support\nCustom development\nSLA guarantee\nWhite-label options"
                )
            );
            
            if (isset($presets[$preset])) {
                $data = $presets[$preset];
                ?>
                <script>
                jQuery(document).ready(function($) {
                    $('#title').val('<?php echo esc_js($data['title']); ?>');
                    $('#excerpt').val('<?php echo esc_js($data['excerpt']); ?>');
                    $('#pricing_monthly_price').val('<?php echo esc_js($data['monthly_price']); ?>').trigger('input');
                    $('#pricing_features').val('<?php echo esc_js($data['features']); ?>');
                    
                    // Show success message
                    $('<div class="notice notice-success"><p><strong>Preset loaded!</strong> You can now customize these values to match your needs.</p></div>')
                        .insertAfter('.wrap h1');
                });
                </script>
                <?php
            }
        });
    }
}
add_action('admin_init', 'yoursite_add_pricing_presets');

/**
 * Optional: Auto-refresh currency rates daily
 */
function yoursite_schedule_currency_rate_refresh() {
    if (!wp_next_scheduled('yoursite_refresh_currency_rates')) {
        wp_schedule_event(time(), 'daily', 'yoursite_refresh_currency_rates');
    }
}
add_action('wp', 'yoursite_schedule_currency_rate_refresh');

function yoursite_auto_refresh_currency_rates() {
    if (function_exists('yoursite_update_currency_rates')) {
        yoursite_update_currency_rates();
    }
}
add_action('yoursite_refresh_currency_rates', 'yoursite_auto_refresh_currency_rates');

/**
 * Final safety check to prevent any remaining session issues
 */
function yoursite_final_session_check() {
    // If we somehow get to this point with headers sent, just return
    if (headers_sent()) {
        return;
    }
    
    // Start session only if absolutely necessary and safe
    if (php_sapi_name() !== 'cli' && 
        session_status() === PHP_SESSION_NONE && 
        !is_admin() && 
        !wp_doing_ajax()) {
        session_start();
    }
}
add_action('template_redirect', 'yoursite_final_session_check', -1000);
require_once get_template_directory() . '/inc/currency/currency-enqueue.php';
/**
 * Simple Currency Backgrounds Setup
 * Add this to your functions.php file
 */

// Remove any conflicting menu items first
remove_action('admin_menu', 'yoursite_currency_backgrounds_admin_menu');

// Create a simple admin menu for currency backgrounds
function simple_currency_backgrounds_menu() {
    add_options_page(
        'Currency Backgrounds',
        'Currency Backgrounds',
        'manage_options',
        'simple-currency-backgrounds',
        'simple_currency_backgrounds_page'
    );
}
add_action('admin_menu', 'simple_currency_backgrounds_menu');

// Simple admin page for managing currency backgrounds
function simple_currency_backgrounds_page() {
    // Handle form submissions
    if (isset($_POST['save_backgrounds']) && wp_verify_nonce($_POST['_wpnonce'], 'save_currency_backgrounds')) {
        $backgrounds = array();
        
        if (!empty($_POST['currencies'])) {
            foreach ($_POST['currencies'] as $currency => $data) {
                if (!empty($data['image_url'])) {
                    $backgrounds[$currency] = array(
                        'image_url' => esc_url_raw($data['image_url']),
                        'description' => sanitize_text_field($data['description']),
                        'created_at' => current_time('mysql'),
                        'updated_at' => current_time('mysql')
                    );
                }
            }
        }
        
        update_option('yoursite_currency_backgrounds_config', $backgrounds);
        update_option('yoursite_currency_backgrounds_enabled', isset($_POST['enable_backgrounds']));
        update_option('yoursite_currency_backgrounds_default', esc_url_raw($_POST['default_background']));
        
        echo '<div class="notice notice-success"><p>Currency backgrounds saved successfully!</p></div>';
    }
    
    // Handle adding default backgrounds
    if (isset($_POST['add_defaults']) && wp_verify_nonce($_POST['_wpnonce'], 'add_default_backgrounds')) {
        $default_backgrounds = array(
            'USD' => array(
                'image_url' => 'https://images.unsplash.com/photo-1485081669829-bacb8c7bb1f3?w=1920&h=1080&fit=crop&q=80',
                'description' => 'American city skyline',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ),
            'EUR' => array(
                'image_url' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=1920&h=1080&fit=crop&q=80',
                'description' => 'European architecture',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ),
            'INR' => array(
                'image_url' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=1920&h=1080&fit=crop&q=80',
                'description' => 'Indian palace',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ),
            'GBP' => array(
                'image_url' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=1920&h=1080&fit=crop&q=80',
                'description' => 'London landmarks',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ),
            'JPY' => array(
                'image_url' => 'https://images.unsplash.com/photo-1545569341-9eb8b30979d9?w=1920&h=1080&fit=crop&q=80',
                'description' => 'Japanese temple',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ),
            'CAD' => array(
                'image_url' => 'https://images.unsplash.com/photo-1503614472-8c93d56cd665?w=1920&h=1080&fit=crop&q=80',
                'description' => 'Canadian mountains',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            )
        );
        
        update_option('yoursite_currency_backgrounds_config', $default_backgrounds);
        update_option('yoursite_currency_backgrounds_enabled', true);
        echo '<div class="notice notice-success"><p>Default backgrounds added successfully!</p></div>';
    }
    
    // Get current settings
    $backgrounds_config = get_option('yoursite_currency_backgrounds_config', array());
    $backgrounds_enabled = get_option('yoursite_currency_backgrounds_enabled', false);
    $default_background = get_option('yoursite_currency_backgrounds_default', '');
    
    // Common currencies
    $currencies = array(
        'USD' => array('name' => 'US Dollar', 'flag' => '🇺🇸'),
        'EUR' => array('name' => 'Euro', 'flag' => '🇪🇺'),
        'GBP' => array('name' => 'British Pound', 'flag' => '🇬🇧'),
        'JPY' => array('name' => 'Japanese Yen', 'flag' => '🇯🇵'),
        'CAD' => array('name' => 'Canadian Dollar', 'flag' => '🇨🇦'),
        'AUD' => array('name' => 'Australian Dollar', 'flag' => '🇦🇺'),
        'INR' => array('name' => 'Indian Rupee', 'flag' => '🇮🇳'),
        'CHF' => array('name' => 'Swiss Franc', 'flag' => '🇨🇭'),
        'CNY' => array('name' => 'Chinese Yuan', 'flag' => '🇨🇳'),
        'KRW' => array('name' => 'Korean Won', 'flag' => '🇰🇷')
    );
    ?>
    
    <div class="wrap">
        <h1>🖼️ Currency Dynamic Backgrounds</h1>
        
        <!-- Quick Setup -->
        <div class="card" style="max-width: none; margin-bottom: 20px;">
            <h2>Quick Setup</h2>
            <p>Get started quickly with default currency backgrounds:</p>
            <form method="post" style="display: inline;">
                <?php wp_nonce_field('add_default_backgrounds'); ?>
                <input type="submit" name="add_defaults" value="Add Default Backgrounds" class="button button-primary">
            </form>
        </div>
        
        <!-- Main Settings Form -->
        <form method="post">
            <?php wp_nonce_field('save_currency_backgrounds'); ?>
            
            <!-- System Settings -->
            <div class="card" style="max-width: none; margin-bottom: 20px;">
                <h2>System Settings</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">Enable Currency Backgrounds</th>
                        <td>
                            <label>
                                <input type="checkbox" name="enable_backgrounds" value="1" <?php checked($backgrounds_enabled, 1); ?>>
                                Enable dynamic background changes based on currency
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Default Background</th>
                        <td>
                            <input type="url" name="default_background" value="<?php echo esc_attr($default_background); ?>" class="regular-text" placeholder="https://example.com/default-background.jpg">
                            <p class="description">Fallback background when no currency-specific image is available</p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Currency Backgrounds -->
            <div class="card" style="max-width: none;">
                <h2>Currency Backgrounds</h2>
                <p>Set specific background images for each currency:</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-top: 20px;">
                    <?php foreach ($currencies as $code => $currency) : 
                        $current_bg = isset($backgrounds_config[$code]) ? $backgrounds_config[$code] : array('image_url' => '', 'description' => '');
                    ?>
                    <div style="border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
                        <h3 style="margin-top: 0;">
                            <?php echo esc_html($currency['flag']); ?> 
                            <?php echo esc_html($code); ?> - <?php echo esc_html($currency['name']); ?>
                        </h3>
                        
                        <label>
                            <strong>Background Image URL:</strong><br>
                            <input type="url" 
                                   name="currencies[<?php echo esc_attr($code); ?>][image_url]" 
                                   value="<?php echo esc_attr($current_bg['image_url']); ?>" 
                                   class="widefat" 
                                   placeholder="https://example.com/background.jpg">
                        </label>
                        
                        <label style="margin-top: 10px; display: block;">
                            <strong>Description:</strong><br>
                            <input type="text" 
                                   name="currencies[<?php echo esc_attr($code); ?>][description]" 
                                   value="<?php echo esc_attr($current_bg['description']); ?>" 
                                   class="widefat" 
                                   placeholder="e.g., American cityscape">
                        </label>
                        
                        <?php if (!empty($current_bg['image_url'])) : ?>
                        <div style="margin-top: 10px;">
                            <img src="<?php echo esc_url($current_bg['image_url']); ?>" 
                                 style="max-width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <p class="submit">
                <input type="submit" name="save_backgrounds" value="Save Currency Backgrounds" class="button button-primary">
            </p>
        </form>
        
        <!-- Current Status -->
        <div class="card" style="max-width: none; margin-top: 20px;">
            <h2>Current Status</h2>
            <ul>
                <li><strong>System Status:</strong> <?php echo $backgrounds_enabled ? '✅ Enabled' : '❌ Disabled'; ?></li>
                <li><strong>Default Background:</strong> <?php echo $default_background ? '✅ Set' : '❌ Not set'; ?></li>
                <li><strong>Configured Currencies:</strong> <?php echo count($backgrounds_config); ?> out of <?php echo count($currencies); ?></li>
            </ul>
            
            <?php if (!empty($backgrounds_config)) : ?>
            <h3>Configured Backgrounds:</h3>
            <ul>
                <?php foreach ($backgrounds_config as $currency_code => $bg_data) : ?>
                <li>
                    <?php echo isset($currencies[$currency_code]) ? $currencies[$currency_code]['flag'] : ''; ?> 
                    <strong><?php echo esc_html($currency_code); ?></strong>: 
                    <?php echo esc_html($bg_data['description'] ?: 'No description'); ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        
        <!-- Usage Instructions -->
        <div class="card" style="max-width: none; margin-top: 20px;">
            <h2>How to Use</h2>
            <ol>
                <li><strong>Enable the system</strong> by checking "Enable Currency Backgrounds" above</li>
                <li><strong>Set a default background</strong> image URL for fallback</li>
                <li><strong>Add currency-specific backgrounds</strong> by entering image URLs for each currency</li>
                <li><strong>Save your settings</strong></li>
                <li>The hero section will automatically show the correct background based on the user's selected currency</li>
            </ol>
            
            <h3>Image Requirements:</h3>
            <ul>
                <li>Recommended size: 1920x1080 or larger</li>
                <li>Format: JPG or PNG</li>
                <li>File size: Under 500KB for best performance</li>
                <li>Make sure images are web-accessible (https:// URLs)</li>
            </ul>
        </div>
    </div>
    

    <?php
}

// Helper function for getting user currency (if not exists)
if (!function_exists('yoursite_get_user_currency_safe')) {
    function yoursite_get_user_currency_safe() {
        // Try to get from cookie or session
        $currency_code = 'USD'; // Default
        
        if (isset($_COOKIE['yoursite_preferred_currency'])) {
            $currency_code = sanitize_text_field($_COOKIE['yoursite_preferred_currency']);
        }
        
        // Currency data
        $currencies = array(
            'USD' => array('code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'flag' => '🇺🇸'),
            'EUR' => array('code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'flag' => '🇪🇺'),
            'GBP' => array('code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'flag' => '🇬🇧'),
            'JPY' => array('code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'flag' => '🇯🇵'),
            'CAD' => array('code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$', 'flag' => '🇨🇦'),
            'AUD' => array('code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$', 'flag' => '🇦🇺'),
            'INR' => array('code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹', 'flag' => '🇮🇳'),
            'CHF' => array('code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'CHF', 'flag' => '🇨🇭'),
            'CNY' => array('code' => 'CNY', 'name' => 'Chinese Yuan', 'symbol' => '¥', 'flag' => '🇨🇳'),
            'KRW' => array('code' => 'KRW', 'name' => 'Korean Won', 'symbol' => '₩', 'flag' => '🇰🇷')
        );
        
        return isset($currencies[$currency_code]) ? $currencies[$currency_code] : $currencies['USD'];
    }
}

function upmind_price_shortcode($atts) {
    $atts = shortcode_atts([
        'product_id' => get_option('default_product_id', ''),
    ], $atts);
    
    ob_start();
    get_template_part('template-parts/product-price-section', null, $atts);
    return ob_get_clean();
}
add_shortcode('upmind_prices', 'upmind_price_shortcode');


add_action('init', 'zencommerce_safe_init', 999);

// =============================================================================
// END OF FUNCTIONS.PHP
// =============================================================================