<?php
/**
 * Template Name: Domain Landing Page
 * 
 * Page template for domain landing pages
 * Select this template when creating domain pages
 * 
 * @package YourSite
 * @since 1.0.0
 */

get_header(); 

// Get domain data - moved to helper function for reusability
$domain_data = get_domain_page_data();

?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('domain-landing-page'); ?>>
        
        <?php 
        // Hero Section
        get_template_part('template-parts/domains-single/hero', null, $domain_data);
        
        // Page Content Section (if there's content in the editor)
        if (get_the_content()) {
            get_template_part('template-parts/domains-single/page-content');
        }
        
        // Why Choose Section
        get_template_part('template-parts/domains-single/why-choose', null, $domain_data);
        
       // Registration Steps Section
get_template_part('template-parts/domains-single/registration-steps', null, $domain_data);
        
        // Benefits Section
        get_template_part('template-parts/domains-single/benefits', null, $domain_data);
        
        // CTA Section
        get_template_part('template-parts/domains-single/cta', null, $domain_data);

        // FAQ Section
get_template_part('template-parts/domains-single/faq', null, $domain_data);

 // Domain Alternatives Section
        if (!empty($domain_data['domain_alternatives'])) {
            get_template_part('template-parts/domains-single/alternatives', null, $domain_data);
        }


        ?>

    </article>
    <?php endwhile; ?>
</main>

<?php
// Include Upmind scripts and styles
get_template_part('template-parts/domains-single/upmind-integration', null, $domain_data);

get_footer();

/**
 * Helper function to get all domain page data
 * Centralizes data retrieval for better maintainability
 */
function get_domain_page_data() {
    // Get domain extension from page slug or custom field
    $domain_ext = get_post_meta(get_the_ID(), '_domain_extension', true);
    if (empty($domain_ext)) {
        // Try to extract from page slug
        $slug = get_post_field('post_name', get_the_ID());
        
        // Update this logic to match your slug pattern
        // If your slugs are just "store", "shop", "co-uk", etc.
        $domain_ext = str_replace('-', '.', $slug);
        
        // Fallback
        if (empty($domain_ext)) {
            $domain_ext = 'store';
        }
    }

    // Get domain pricing
    $domain_price = get_post_meta(get_the_ID(), '_domain_price', true);
    if (empty($domain_price)) {
        $domain_price = '12.99';
    }

    $domain_renewal_price = get_post_meta(get_the_ID(), '_domain_renewal_price', true);
    if (empty($domain_renewal_price)) {
        $domain_renewal_price = '14.99';
    }

    // Get current user currency
    $current_currency = array('code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar');
    if (function_exists('yoursite_get_user_currency_safe')) {
        $user_currency = yoursite_get_user_currency_safe();
        if (!empty($user_currency) && is_array($user_currency)) {
            $current_currency = $user_currency;
        }
    }

    // Get domain features
    $domain_features = get_post_meta(get_the_ID(), '_domain_features', true);
    if (empty($domain_features)) {
        $domain_features = array(
            'SSL certificates included',
            'WHOIS privacy protection',
            'Free DNS management',
            'Easy domain forwarding',
            '24/7 expert support'
        );
    } else {
        if (is_array($domain_features)) {
            $domain_features = $domain_features;
        } else {
            $domain_features = explode("\n", $domain_features);
        }
    }

    // Domain alternatives
    $domain_alternatives = get_post_meta(get_the_ID(), '_domain_alternatives', true);
    if (empty($domain_alternatives)) {
        $domain_alternatives = array(
            'shop' => array('name' => '.shop', 'price' => '9.99'),
            'online' => array('name' => '.online', 'price' => '8.99'),
            'boutique' => array('name' => '.boutique', 'price' => '19.99')
        );
    }

    return array(
        'domain_ext' => $domain_ext,
        'domain_price' => $domain_price,
        'domain_renewal_price' => $domain_renewal_price,
        'current_currency' => $current_currency,
        'domain_features' => $domain_features,
        'domain_alternatives' => $domain_alternatives
    );
}
?>