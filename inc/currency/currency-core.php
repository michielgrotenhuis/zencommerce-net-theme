<?php
/**
 * Currency Core Functions - FIXED VERSION
 * File: inc/currency/currency-core.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create currency database tables
 */
function yoursite_create_currency_tables() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // Main currencies table
    $currencies_table = $wpdb->prefix . 'yoursite_currencies';
    $currencies_sql = "CREATE TABLE $currencies_table (
        id int(11) NOT NULL AUTO_INCREMENT,
        code varchar(10) NOT NULL,
        name varchar(100) NOT NULL,
        symbol varchar(10) NOT NULL,
        flag varchar(10) DEFAULT '',
        prefix varchar(20) DEFAULT '',
        suffix varchar(20) DEFAULT '',
        decimal_places int(2) DEFAULT 2,
        decimal_separator varchar(5) DEFAULT '.',
        thousand_separator varchar(5) DEFAULT ',',
        conversion_rate decimal(15,8) DEFAULT 1.00000000,
        is_base_currency tinyint(1) DEFAULT 0,
        status enum('active','inactive') DEFAULT 'active',
        rounding_mode enum('up','down','nearest','none') DEFAULT 'nearest',
        rounding_precision varchar(10) DEFAULT '0.01',
        auto_update tinyint(1) DEFAULT 0,
        last_updated datetime DEFAULT CURRENT_TIMESTAMP,
        display_order int(11) DEFAULT 0,
        is_crypto tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY code (code),
        KEY status (status),
        KEY display_order (display_order)
    ) $charset_collate;";
    
    // Pricing plans currencies table
    $pricing_currencies_table = $wpdb->prefix . 'yoursite_pricing_currencies';
    $pricing_currencies_sql = "CREATE TABLE $pricing_currencies_table (
        id int(11) NOT NULL AUTO_INCREMENT,
        pricing_plan_id int(11) NOT NULL,
        currency_code varchar(10) NOT NULL,
        monthly_price decimal(15,2) DEFAULT NULL,
        annual_price decimal(15,2) DEFAULT NULL,
        button_url varchar(500) DEFAULT '',
        is_auto_converted tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY plan_currency (pricing_plan_id, currency_code),
        KEY pricing_plan_id (pricing_plan_id),
        KEY currency_code (currency_code)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
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
 * Populate database with default currencies - FIXED
 */
function yoursite_populate_default_currencies() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    $currencies = yoursite_get_default_currencies();
    
    foreach ($currencies as $code => $currency) {
        // Set default values for missing fields
        $currency_data = array_merge(array(
            'code' => $code,
            'decimal_separator' => '.',
            'thousand_separator' => ',',
            'conversion_rate' => 1.0,
            'is_base_currency' => 0,
            'rounding_mode' => 'nearest',
            'rounding_precision' => '0.01',
            'auto_update' => 0,
            'last_updated' => current_time('mysql'),
            'is_crypto' => 0,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        ), $currency);
        
        $wpdb->insert($table_name, $currency_data);
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
        'geolocation_detection' => true,
        'default_rounding_mode' => 'nearest',
        'show_original_price' => false
    );
    
    update_option('yoursite_currency_settings', $default_settings);
}

/**
 * Get all active currencies - FIXED
 */
function yoursite_get_active_currencies() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    // Check if table exists first
    if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) !== $table_name) {
        // Fallback to USD if table doesn't exist
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
    
    $currencies = $wpdb->get_results(
        "SELECT * FROM {$table_name} WHERE status = 'active' ORDER BY display_order ASC, code ASC",
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
 * Get specific currency by code - FIXED
 */
function yoursite_get_currency($code) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    // Check if table exists
    if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) !== $table_name) {
        return null;
    }
    
    return $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$table_name} WHERE code = %s", $code),
        ARRAY_A
    );
}

/**
 * Get base currency - FIXED
 */
function yoursite_get_base_currency() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yoursite_currencies';
    
    // Check if table exists
    if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) !== $table_name) {
        // Fallback to USD
        return array(
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'prefix' => '$',
            'suffix' => '',
            'conversion_rate' => 1.0,
            'is_base_currency' => 1
        );
    }
    
    $base_currency = $wpdb->get_row(
        "SELECT * FROM {$table_name} WHERE is_base_currency = 1 AND status = 'active'",
        ARRAY_A
    );
    
    if (!$base_currency) {
        // Fallback to USD
        return array(
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'prefix' => '$',
            'suffix' => '',
            'conversion_rate' => 1.0,
            'is_base_currency' => 1
        );
    }
    
    return $base_currency;
}

/**
 * Update currency conversion rates - FIXED
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
            array('%f', '%s'),
            array('%s')
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
 * Get user's preferred currency - FIXED
 */
function yoursite_get_user_currency() {
    // Check session/cookie first
   if (isset($_COOKIE['yoursite_preferred_currency'])) {
    $currency_code = sanitize_text_field($_COOKIE['yoursite_preferred_currency']);
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
 * Convert price between currencies - FIXED
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
    $base_amount = $amount / floatval($from_curr['conversion_rate']);
    $converted_amount = $base_amount * floatval($to_curr['conversion_rate']);
    
    // Apply rounding
    return yoursite_apply_currency_rounding($converted_amount, $to_curr);
}

/**
 * Apply currency-specific rounding - FIXED
 */
function yoursite_apply_currency_rounding($amount, $currency) {
    $rounding_mode = $currency['rounding_mode'] ?? 'nearest';
    $precision = $currency['rounding_precision'] ?? '0.01';
    $decimal_places = intval($currency['decimal_places'] ?? 2);
    
    if ($rounding_mode === 'none') {
        return round($amount, $decimal_places);
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
 * Format price according to currency settings - FIXED
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
    
    // Get currency formatting settings
    $decimal_places = intval($currency['decimal_places'] ?? 2);
    $decimal_separator = $currency['decimal_separator'] ?? '.';
    $thousand_separator = $currency['thousand_separator'] ?? ',';
    $prefix = $currency['prefix'] ?? '';
    $suffix = $currency['suffix'] ?? '';
    
    // Format number
    $formatted = number_format(
        $amount,
        $decimal_places,
        $decimal_separator,
        $thousand_separator
    );
    
    // Add prefix and suffix
    return $prefix . $formatted . $suffix;
}
/**
 * Simple geolocation currency detection - FIXED
 */
function yoursite_detect_currency_by_location() {
    // Simple IP to country detection (you can integrate with a service)
$country_currency_map = array(
    'AF' => 'AFN',
    'AL' => 'ALL',
    'DZ' => 'DZD',
    'AS' => 'USD',
    'AD' => 'EUR',
    'AO' => 'AOA',
    'AI' => 'XCD',
    'AQ' => 'USD',
    'AG' => 'XCD',
    'AR' => 'ARS',
    'AM' => 'AMD',
    'AW' => 'AWG',
    'AU' => 'AUD',
    'AT' => 'EUR',
    'AZ' => 'AZN',
    'BS' => 'BSD',
    'BH' => 'BHD',
    'BD' => 'BDT',
    'BB' => 'BBD',
    'BY' => 'BYN',
    'BE' => 'EUR',
    'BZ' => 'BZD',
    'BJ' => 'XOF',
    'BM' => 'BMD',
    'BT' => 'BTN',
    'BO' => 'BOB',
    'BA' => 'BAM',
    'BW' => 'BWP',
    'BR' => 'BRL',
    'IO' => 'USD',
    'BN' => 'BND',
    'BG' => 'BGN',
    'BF' => 'XOF',
    'BI' => 'BIF',
    'CV' => 'CVE',
    'KH' => 'KHR',
    'CM' => 'XAF',
    'CA' => 'CAD',
    'KY' => 'KYD',
    'CF' => 'XAF',
    'TD' => 'XAF',
    'CL' => 'CLP',
    'CN' => 'CNY',
    'CO' => 'COP',
    'KM' => 'KMF',
    'CG' => 'XAF',
    'CD' => 'CDF',
    'CR' => 'CRC',
    'CI' => 'XOF',
    'HR' => 'EUR',
    'CU' => 'CUP',
    'CY' => 'EUR',
    'CZ' => 'CZK',
    'DK' => 'DKK',
    'DJ' => 'DJF',
    'DM' => 'XCD',
    'DO' => 'DOP',
    'EC' => 'USD',
    'EG' => 'EGP',
    'SV' => 'USD',
    'GQ' => 'XAF',
    'ER' => 'ERN',
    'EE' => 'EUR',
    'SZ' => 'SZL',
    'ET' => 'ETB',
    'FJ' => 'FJD',
    'FI' => 'EUR',
    'FR' => 'EUR',
    'GF' => 'EUR',
    'PF' => 'XPF',
    'GA' => 'XAF',
    'GM' => 'GMD',
    'GE' => 'GEL',
    'DE' => 'EUR',
    'GH' => 'GHS',
    'GI' => 'GIP',
    'GR' => 'EUR',
    'GL' => 'DKK',
    'GD' => 'XCD',
    'GP' => 'EUR',
    'GU' => 'USD',
    'GT' => 'GTQ',
    'GN' => 'GNF',
    'GW' => 'XOF',
    'GY' => 'GYD',
    'HT' => 'HTG',
    'HN' => 'HNL',
    'HK' => 'HKD',
    'HU' => 'HUF',
    'IS' => 'ISK',
    'IN' => 'INR',
    'ID' => 'IDR',
    'IR' => 'IRR',
    'IQ' => 'IQD',
    'IE' => 'EUR',
    'IL' => 'ILS',
    'IT' => 'EUR',
    'JM' => 'JMD',
    'JP' => 'JPY',
    'JO' => 'JOD',
    'KZ' => 'KZT',
    'KE' => 'KES',
    'KI' => 'AUD',
    'KP' => 'KPW',
    'KR' => 'KRW',
    'KW' => 'KWD',
    'KG' => 'KGS',
    'LA' => 'LAK',
    'LV' => 'EUR',
    'LB' => 'LBP',
    'LS' => 'LSL',
    'LR' => 'LRD',
    'LY' => 'LYD',
    'LI' => 'CHF',
    'LT' => 'EUR',
    'LU' => 'EUR',
    'MO' => 'MOP',
    'MK' => 'MKD',
    'MG' => 'MGA',
    'MW' => 'MWK',
    'MY' => 'MYR',
    'MV' => 'MVR',
    'ML' => 'XOF',
    'MT' => 'EUR',
    'MH' => 'USD',
    'MQ' => 'EUR',
    'MR' => 'MRU',
    'MU' => 'MUR',
    'YT' => 'EUR',
    'MX' => 'MXN',
    'FM' => 'USD',
    'MD' => 'MDL',
    'MC' => 'EUR',
    'MN' => 'MNT',
    'ME' => 'EUR',
    'MS' => 'XCD',
    'MA' => 'MAD',
    'MZ' => 'MZN',
    'MM' => 'MMK',
    'NA' => 'NAD',
    'NR' => 'AUD',
    'NP' => 'NPR',
    'NL' => 'EUR',
    'NC' => 'XPF',
    'NZ' => 'NZD',
    'NI' => 'NIO',
    'NE' => 'XOF',
    'NG' => 'NGN',
    'NU' => 'NZD',
    'NF' => 'AUD',
    'MP' => 'USD',
    'NO' => 'NOK',
    'OM' => 'OMR',
    'PK' => 'PKR',
    'PW' => 'USD',
    'PA' => 'PAB',
    'PG' => 'PGK',
    'PY' => 'PYG',
    'PE' => 'PEN',
    'PH' => 'PHP',
    'PL' => 'PLN',
    'PT' => 'EUR',
    'PR' => 'USD',
    'QA' => 'QAR',
    'RE' => 'EUR',
    'RO' => 'RON',
    'RU' => 'RUB',
    'RW' => 'RWF',
    'KN' => 'XCD',
    'LC' => 'XCD',
    'VC' => 'XCD',
    'WS' => 'WST',
    'SM' => 'EUR',
    'ST' => 'STN',
    'SA' => 'SAR',
    'SN' => 'XOF',
    'RS' => 'RSD',
    'SC' => 'SCR',
    'SL' => 'SLE',
    'SG' => 'SGD',
    'SX' => 'ANG',
    'SK' => 'EUR',
    'SI' => 'EUR',
    'SB' => 'SBD',
    'SO' => 'SOS',
    'ZA' => 'ZAR',
    'SS' => 'SSP',
    'ES' => 'EUR',
    'LK' => 'LKR',
    'SD' => 'SDG',
    'SR' => 'SRD',
    'SE' => 'SEK',
    'CH' => 'CHF',
    'SY' => 'SYP',
    'TW' => 'TWD',
    'TJ' => 'TJS',
    'TZ' => 'TZS',
    'TH' => 'THB',
    'TL' => 'USD',
    'TG' => 'XOF',
    'TO' => 'TOP',
    'TT' => 'TTD',
    'TN' => 'TND',
    'TR' => 'TRY',
    'TM' => 'TMT',
    'TC' => 'USD',
    'TV' => 'AUD',
    'UG' => 'UGX',
    'UA' => 'UAH',
    'AE' => 'AED',
    'GB' => 'GBP',
    'US' => 'USD',
    'UY' => 'UYU',
    'UZ' => 'UZS',
    'VU' => 'VUV',
    'VA' => 'EUR',
    'VE' => 'VES',
    'VN' => 'VND',
    'VG' => 'USD',
    'VI' => 'USD',
    'EH' => 'MAD',
    'YE' => 'YER',
    'ZM' => 'ZMW',
    'ZW' => 'ZWL'
);


    // Get IP address
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'; // default fallback IP

    // Call external geolocation API
    $geo = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));

    if (!empty($geo->countryCode) && isset($country_currency_map[$geo->countryCode])) {
        $currency_code = $country_currency_map[$geo->countryCode];
        return yoursite_get_currency($currency_code);
    }

    // Fallback: use browser language
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
