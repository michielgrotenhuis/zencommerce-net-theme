<?php
/**
 * Template Name: Domain Archive Page
 * 
 * Domain archive template for domain category and search pages
 * 
 * @package YourSite
 * @since 1.0.0
 */

get_header(); 

// Get domain archive data
$archive_data = get_domain_archive_data();

?>

<main id="main" class="site-main domain-archive-page">
    
    <?php 
    // Hero Section with Search
    get_template_part('template-parts/archive-domains/hero', null, $archive_data);
    
    // Domain Categories Section
    get_template_part('template-parts/archive-domains/categories', null, $archive_data);
    
    // Popular Domains Section
    get_template_part('template-parts/archive-domains/popular-domains', null, $archive_data);
    
    // Domain Pricing Table
    get_template_part('template-parts/archive-domains/pricing-table', null, $archive_data);
    
    // Why Choose Zencommerce Section
    get_template_part('template-parts/archive-domains/why-choose', null, $archive_data);
    
    // Features Section
    get_template_part('template-parts/archive-domains/features', null, $archive_data);
    
    // FAQ Section
    get_template_part('template-parts/archive-domains/faq', null, $archive_data);
    
    // CTA Section
    get_template_part('template-parts/archive-domains/cta', null, $archive_data);
    ?>

</main>

<?php
// Include Upmind scripts and styles for domain search
get_template_part('template-parts/archive-domains/upmind-integration', null, $archive_data);

get_footer();

/**
 * Helper function to get all domain archive data
 * Centralizes data retrieval for better maintainability
 */
function get_domain_archive_data() {
    // Get current user currency
    $current_currency = array('code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar');
    if (function_exists('yoursite_get_user_currency_safe')) {
        $user_currency = yoursite_get_user_currency_safe();
        if (!empty($user_currency) && is_array($user_currency)) {
            $current_currency = $user_currency;
        }
    }
    
    // Get current category if viewing category archive
    $current_category = null;
    if (is_tax('domain_category')) {
        $current_category = get_queried_object();
    }
    
    // Get search query if searching
    $search_query = get_query_var('domain_search', '');
    
    // Get domain categories
    $domain_categories = get_theme_domain_categories();
    
    // Get popular domains - use plugin function if available, otherwise fallback
    $popular_domains = function_exists('get_popular_domains') ? 
        get_popular_domains() : 
        get_theme_popular_domains();
    
    // Get featured domains for pricing table
    $featured_domains = get_theme_featured_domains_for_pricing();
    
    return array(
        'current_currency' => $current_currency,
        'current_category' => $current_category,
        'search_query' => $search_query,
        'domain_categories' => $domain_categories,
        'popular_domains' => $popular_domains,
        'featured_domains' => $featured_domains,
        'page_title' => get_archive_page_title(),
        'page_description' => get_archive_page_description()
    );
}

/**
 * Get domain categories with predefined structure (theme version)
 */
function get_theme_domain_categories() {
    $categories = array(
        'popular' => array(
            'name' => __('Popular', 'yoursite'),
            'domains' => array('com', 'net', 'org', 'io', 'co', 'app'),
            'icon' => 'trending-up',
            'color' => 'blue'
        ),
        'international' => array(
            'name' => __('International', 'yoursite'),
            'domains' => array('de', 'uk', 'ca', 'au', 'fr', 'eu'),
            'icon' => 'globe',
            'color' => 'green'
        ),
        'business' => array(
            'name' => __('Business', 'yoursite'),
            'domains' => array('biz', 'company', 'corp', 'inc', 'llc', 'ltd'),
            'icon' => 'briefcase',
            'color' => 'indigo'
        ),
        'technology' => array(
            'name' => __('Technology', 'yoursite'),
            'domains' => array('tech', 'dev', 'ai', 'cloud', 'digital', 'software'),
            'icon' => 'cpu',
            'color' => 'purple'
        ),
        'shopping' => array(
            'name' => __('Shopping & Sales', 'yoursite'),
            'domains' => array('shop', 'store', 'buy', 'sale', 'deals', 'market'),
            'icon' => 'shopping-cart',
            'color' => 'orange'
        ),
        'professional' => array(
            'name' => __('Professional', 'yoursite'),
            'domains' => array('pro', 'expert', 'lawyer', 'doctor', 'consulting', 'agency'),
            'icon' => 'user-tie',
            'color' => 'gray'
        ),
        'education' => array(
            'name' => __('Academic & Education', 'yoursite'),
            'domains' => array('edu', 'school', 'university', 'academy', 'learning', 'study'),
            'icon' => 'graduation-cap',
            'color' => 'blue'
        ),
        'media' => array(
            'name' => __('Media & Music', 'yoursite'),
            'domains' => array('media', 'music', 'radio', 'tv', 'news', 'blog'),
            'icon' => 'music',
            'color' => 'pink'
        ),
        'finance' => array(
            'name' => __('Finance', 'yoursite'),
            'domains' => array('finance', 'bank', 'money', 'crypto', 'trading', 'invest'),
            'icon' => 'dollar-sign',
            'color' => 'green'
        ),
        'health' => array(
            'name' => __('Health & Fitness', 'yoursite'),
            'domains' => array('health', 'fitness', 'gym', 'wellness', 'medical', 'care'),
            'icon' => 'heart',
            'color' => 'red'
        ),
        'travel' => array(
            'name' => __('Travel', 'yoursite'),
            'domains' => array('travel', 'flights', 'hotel', 'vacation', 'tours', 'booking'),
            'icon' => 'plane',
            'color' => 'blue'
        ),
        'food' => array(
            'name' => __('Food & Drink', 'yoursite'),
            'domains' => array('food', 'restaurant', 'cafe', 'bar', 'kitchen', 'recipe'),
            'icon' => 'utensils',
            'color' => 'yellow'
        ),
        'sports' => array(
            'name' => __('Sports & Hobbies', 'yoursite'),
            'domains' => array('sport', 'football', 'soccer', 'basketball', 'tennis', 'golf'),
            'icon' => 'football',
            'color' => 'green'
        ),
        'new' => array(
            'name' => __('New', 'yoursite'),
            'domains' => array('online', 'website', 'digital', 'virtual', 'cyber', 'web'),
            'icon' => 'star',
            'color' => 'yellow'
        ),
        'short' => array(
            'name' => __('Short', 'yoursite'),
            'domains' => array('co', 'io', 'me', 'tv', 'ai', 'it'),
            'icon' => 'minimize',
            'color' => 'indigo'
        ),
        'budget' => array(
            'name' => __('$3 or less', 'yoursite'),
            'domains' => array('xyz', 'top', 'site', 'online', 'store', 'tech'),
            'icon' => 'tag',
            'color' => 'green'
        )
    );
    
    return $categories;
}

/**
 * Get popular domains with pricing (theme fallback version)
 */
function get_theme_popular_domains() {
    return array(
        array(
            'tld' => 'com',
            'name' => '.com',
            'description' => __('The king of domains - most trusted and recognized worldwide', 'yoursite'),
            'price' => '13.99',
            'renewal_price' => '15.99',
            'sale_price' => '9.99',
            'on_sale' => true,
            'discount_percentage' => '29'
        ),
        array(
            'tld' => 'net',
            'name' => '.net',
            'description' => __('A true internet original - perfect for tech and network services', 'yoursite'),
            'price' => '14.99',
            'renewal_price' => '16.99',
            'sale_price' => '11.99',
            'on_sale' => true,
            'discount_percentage' => '20'
        ),
        array(
            'tld' => 'org',
            'name' => '.org',
            'description' => __('The domain you can trust - ideal for organizations and communities', 'yoursite'),
            'price' => '12.99',
            'renewal_price' => '14.99',
            'sale_price' => '7.99',
            'on_sale' => true,
            'discount_percentage' => '38'
        ),
        array(
            'tld' => 'io',
            'name' => '.io',
            'description' => __('Popular with startups and tech companies', 'yoursite'),
            'price' => '49.99',
            'renewal_price' => '55.99',
            'sale_price' => '39.99',
            'on_sale' => true,
            'discount_percentage' => '20'
        ),
        array(
            'tld' => 'co',
            'name' => '.co',
            'description' => __('Short, memorable, and perfect for companies', 'yoursite'),
            'price' => '32.99',
            'renewal_price' => '35.99',
            'sale_price' => null,
            'on_sale' => false,
            'discount_percentage' => null
        ),
        array(
            'tld' => 'shop',
            'name' => '.shop',
            'description' => __('Perfect for e-commerce and retail businesses', 'yoursite'),
            'price' => '38.99',
            'renewal_price' => '42.99',
            'sale_price' => '29.99',
            'on_sale' => true,
            'discount_percentage' => '23'
        )
    );
}

/**
 * Get featured domains for pricing table (theme version)
 */
function get_theme_featured_domains_for_pricing() {
    return array(
        array(
            'tld' => 'com',
            'name' => '.com',
            'register_price' => '9.99',
            'renew_price' => '15.99',
            'transfer_price' => '12.99',
            'featured' => true,
            'popular' => true
        ),
        array(
            'tld' => 'net',
            'name' => '.net',
            'register_price' => '11.99',
            'renew_price' => '16.99',
            'transfer_price' => '13.99',
            'featured' => false,
            'popular' => true
        ),
        array(
            'tld' => 'org',
            'name' => '.org',
            'register_price' => '7.99',
            'renew_price' => '14.99',
            'transfer_price' => '11.99',
            'featured' => false,
            'popular' => true
        ),
        array(
            'tld' => 'io',
            'name' => '.io',
            'register_price' => '39.99',
            'renew_price' => '55.99',
            'transfer_price' => '49.99',
            'featured' => false,
            'popular' => false
        ),
        array(
            'tld' => 'shop',
            'name' => '.shop',
            'register_price' => '29.99',
            'renew_price' => '42.99',
            'transfer_price' => '35.99',
            'featured' => false,
            'popular' => false
        ),
        array(
            'tld' => 'store',
            'name' => '.store',
            'register_price' => '12.99',
            'renew_price' => '18.99',
            'transfer_price' => '15.99',
            'featured' => false,
            'popular' => false
        ),
        array(
            'tld' => 'online',
            'name' => '.online',
            'register_price' => '8.99',
            'renew_price' => '12.99',
            'transfer_price' => '10.99',
            'featured' => false,
            'popular' => false
        ),
        array(
            'tld' => 'tech',
            'name' => '.tech',
            'register_price' => '19.99',
            'renew_price' => '24.99',
            'transfer_price' => '22.99',
            'featured' => false,
            'popular' => false
        )
    );
}

/**
 * Get archive page title
 */
function get_archive_page_title() {
    if (is_tax('domain_category')) {
        $term = get_queried_object();
        return sprintf(__('%s Domains', 'yoursite'), $term->name);
    } elseif (get_query_var('domain_search')) {
        return sprintf(__('Search Results for "%s"', 'yoursite'), get_query_var('domain_search'));
    } else {
        return __('Domain Registration - Find Your Perfect Domain', 'yoursite');
    }
}

/**
 * Get archive page description
 */
function get_archive_page_description() {
    if (is_tax('domain_category')) {
        $term = get_queried_object();
        return $term->description ?: sprintf(__('Discover the perfect %s domain for your website with competitive pricing and instant registration.', 'yoursite'), strtolower($term->name));
    } elseif (get_query_var('domain_search')) {
        return __('Find the perfect domain for your business with instant availability checking and competitive pricing.', 'yoursite');
    } else {
        return __('Register your domain with Zencommerce. Over 300 domain extensions available with competitive pricing, instant setup, and 24/7 support.', 'yoursite');
    }
}
?>