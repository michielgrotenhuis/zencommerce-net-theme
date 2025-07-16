<?php
/**
 * Domain Archive Template
 * 
 * Template for displaying all domains in archive format
 * 
 * @package DomainSystem
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="domain-archive">
    <?php 
    // Load template parts
    get_template_part('template-parts/archive-domains/hero-section');
    get_template_part('template-parts/archive-domains/search-section');
    get_template_part('template-parts/archive-domains/categories-section');
    get_template_part('template-parts/archive-domains/pricing-table');
    get_template_part('template-parts/archive-domains/features-section');
    get_template_part('template-parts/archive-domains/testimonials');
    get_template_part('template-parts/archive-domains/why-choose');
    get_template_part('template-parts/archive-domains/faq-section');
    ?>
</div>

<!-- Archive Page Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "<?php _e('Domain Extensions Directory - Zencommerce', 'domain-system'); ?>",
    "description": "<?php _e('Browse and compare domain extensions for your website registration needs with Zencommerce.', 'domain-system'); ?>",
    "url": "<?php echo get_domain_archive_url(); ?>",
    "provider": {
        "@type": "Organization",
        "name": "Zencommerce",
        "url": "<?php echo home_url(); ?>"
    }
}
</script>

<?php get_footer(); ?>
