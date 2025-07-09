<?php
/**
 * Footer Currency Functions
 * File: footer-functions.php
 */

// Function to convert USD to target currency with realistic rates
function convert_usd_to_currency($usd_amount, $target_currency) {
    // Exchange rates (you should ideally fetch these from an API)
    $exchange_rates = array(
        'USD' => 1.00,
        'EUR' => 0.85,
        'GBP' => 0.75,
        'CAD' => 1.25,
        'AUD' => 1.35,
        'JPY' => 110.0,
        'CHF' => 0.92,
        'SEK' => 9.50,
        'NOK' => 9.80,
        'DKK' => 6.30,
        'PLN' => 3.80,
        'CZK' => 22.0,
        'HUF' => 320.0,
        'BGN' => 1.66,
        'RON' => 4.20,
        'HRK' => 6.40,
        'RUB' => 75.0,
        'CNY' => 6.45,
        'INR' => 74.0,
        'KRW' => 1180.0,
        'SGD' => 1.35,
        'HKD' => 7.80,
        'MXN' => 20.0,
        'BRL' => 5.20,
        'ARS' => 98.0,
        'CLP' => 800.0,
        'COP' => 3800.0,
        'PEN' => 3.60,
        'UYU' => 43.0,
        'ZAR' => 14.5,
        'EGP' => 15.7,
        'NGN' => 411.0,
        'KES' => 108.0,
        'GHS' => 6.10,
        'TND' => 2.75,
        'MAD' => 9.00,
        'THB' => 33.0,
        'PHP' => 50.0,
        'VND' => 23000.0,
        'IDR' => 14300.0,
        'MYR' => 4.15,
        'ILS' => 3.25,
        'AED' => 3.67,
        'SAR' => 3.75,
        'QAR' => 3.64,
        'KWD' => 0.30,
        'BHD' => 0.38,
        'OMR' => 0.38,
        'JOD' => 0.71,
        'LBP' => 1507.0,
        'TRY' => 8.50,
        'IRR' => 42000.0,
        'PKR' => 170.0,
        'BDT' => 85.0,
        'LKR' => 200.0,
        'NPR' => 118.0,
        'BTN' => 74.0,
        'MVR' => 15.4,
        'AFN' => 80.0,
        'UZS' => 10600.0,
        'KZT' => 426.0,
        'KGS' => 84.0,
        'TJS' => 11.3,
        'TMT' => 3.50,
        'AZN' => 1.70,
        'GEL' => 3.30,
        'AMD' => 522.0,
        'BYN' => 2.60,
        'MDL' => 17.8,
        'UAH' => 27.0,
        'RSD' => 100.0,
        'MKD' => 52.0,
        'ALL' => 104.0,
        'BAM' => 1.66,
        'ISK' => 127.0,
    );
    
    $rate = isset($exchange_rates[$target_currency]) ? $exchange_rates[$target_currency] : 1.00;
    $converted_amount = $usd_amount * $rate;
    
    // Round to appropriate decimal places based on currency
    if (in_array($target_currency, ['JPY', 'KRW', 'VND', 'IDR', 'IRR', 'UZS', 'LBP', 'CLP', 'COP', 'HUF', 'CZK'])) {
        // Currencies that don't use decimal places
        return round($converted_amount);
    } elseif (in_array($target_currency, ['KWD', 'BHD', 'OMR', 'JOD'])) {
        // Currencies with 3 decimal places
        return round($converted_amount, 3);
    } else {
        // Most currencies use 2 decimal places, but round to whole numbers for offers
        return round($converted_amount);
    }
}

// Format the currency display
function format_currency_for_offer($amount, $currency_code, $currency_symbol) {
    // For certain currencies, show without decimals
    if (in_array($currency_code, ['JPY', 'KRW', 'VND', 'IDR', 'IRR', 'UZS', 'LBP', 'CLP', 'COP', 'HUF', 'CZK'])) {
        return $currency_symbol . number_format($amount, 0);
    } elseif (in_array($currency_code, ['KWD', 'BHD', 'OMR', 'JOD'])) {
        return $currency_symbol . number_format($amount, 3);
    } else {
        // For offers, always show round numbers
        return $currency_symbol . number_format($amount, 0);
    }
}

// Get user currency (you'll need to implement this based on your system)
function yoursite_get_user_currency() {
    // Default currency
    $default_currency = array(
        'code' => 'USD',
        'symbol' => '$',
        'name' => 'US Dollar'
    );
    
    // Try to get from user session, cookie, or geolocation
    if (isset($_COOKIE['selected_currency'])) {
        $currency_code = sanitize_text_field($_COOKIE['selected_currency']);
        $currency_data = yoursite_get_currency_data($currency_code);
        if ($currency_data) {
            return $currency_data;
        }
    }
    
    return $default_currency;
}

// Get currency data by code
function yoursite_get_currency_data($currency_code) {
    $currencies = array(
        'USD' => array('code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar'),
        'EUR' => array('code' => 'EUR', 'symbol' => '€', 'name' => 'Euro'),
        'GBP' => array('code' => 'GBP', 'symbol' => '£', 'name' => 'British Pound'),
        'CAD' => array('code' => 'CAD', 'symbol' => 'C$', 'name' => 'Canadian Dollar'),
        'AUD' => array('code' => 'AUD', 'symbol' => 'A$', 'name' => 'Australian Dollar'),
        'JPY' => array('code' => 'JPY', 'symbol' => '¥', 'name' => 'Japanese Yen'),
        // Add more currencies as needed
    );
    
    return isset($currencies[$currency_code]) ? $currencies[$currency_code] : null;
}

// Render currency selector
function yoursite_render_currency_selector($args = array()) {
    $defaults = array(
        'style' => 'dropdown',
        'show_flag' => false,
        'show_name' => false,
        'show_symbol' => true,
        'wrapper_class' => 'currency-selector',
        'toggle_class' => 'currency-toggle',
        'dropdown_class' => 'currency-dropdown',
        'item_class' => 'currency-item',
        'active_class' => 'active'
    );
    
    $args = wp_parse_args($args, $defaults);
    $current_currency = yoursite_get_user_currency();
    
    $currencies = array(
        'USD' => array('code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar', 'flag' => '🇺🇸'),
        'EUR' => array('code' => 'EUR', 'symbol' => '€', 'name' => 'Euro', 'flag' => '🇪🇺'),
        'GBP' => array('code' => 'GBP', 'symbol' => '£', 'name' => 'British Pound', 'flag' => '🇬🇧'),
        'CAD' => array('code' => 'CAD', 'symbol' => 'C$', 'name' => 'Canadian Dollar', 'flag' => '🇨🇦'),
        'AUD' => array('code' => 'AUD', 'symbol' => 'A$', 'name' => 'Australian Dollar', 'flag' => '🇦🇺'),
        'JPY' => array('code' => 'JPY', 'symbol' => '¥', 'name' => 'Japanese Yen', 'flag' => '🇯🇵'),
    );
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($args['wrapper_class']); ?>">
        <button class="<?php echo esc_attr($args['toggle_class']); ?>" 
                id="currency-toggle" 
                type="button" 
                aria-expanded="false"
                data-current-currency="<?php echo esc_attr($current_currency['code']); ?>">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
            <span class="selector-text"><?php echo esc_html($current_currency['code']); ?></span>
            <svg class="w-4 h-4 text-gray-400 chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="<?php echo esc_attr($args['dropdown_class']); ?> hidden" 
             id="currency-dropdown" 
             role="listbox" 
             aria-hidden="true">
            <?php foreach ($currencies as $code => $currency) : ?>
                <a href="#" 
                   data-currency="<?php echo esc_attr($code); ?>" 
                   data-symbol="<?php echo esc_attr($currency['symbol']); ?>"
                   class="<?php echo esc_attr($args['item_class']); ?> <?php echo $code === $current_currency['code'] ? esc_attr($args['active_class']) : ''; ?>" 
                   role="option">
                    <?php if ($args['show_flag']) : ?>
                        <span class="flag"><?php echo esc_html($currency['flag']); ?></span>
                    <?php endif; ?>
                    <?php echo esc_html($code); ?>
                    <?php if ($args['show_symbol']) : ?>
                        <span class="symbol">(<?php echo esc_html($currency['symbol']); ?>)</span>
                    <?php endif; ?>
                    <?php if ($args['show_name']) : ?>
                        <span class="name"><?php echo esc_html($currency['name']); ?></span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}