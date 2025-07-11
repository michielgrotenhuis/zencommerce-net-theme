<?php
/*
Template Name: Enhanced Single Theme Page - Zencommerce Style
File: single-zencommerce_theme.php
*/

get_header(); 

if (have_posts()) : while (have_posts()) : the_post();

// Get theme data
$theme_id = get_the_ID();
$theme_data = array(
    'price' => get_post_meta($theme_id, '_theme_price', true),
    'developer' => get_post_meta($theme_id, '_theme_developer', true),
    'version' => get_post_meta($theme_id, '_theme_version', true),
    'demo_url' => get_post_meta($theme_id, '_theme_demo_url', true),
    'rating' => get_post_meta($theme_id, '_theme_rating', true),
    'last_updated' => get_post_meta($theme_id, '_theme_last_updated', true),
    'features' => get_post_meta($theme_id, '_theme_features', true),
    'gallery' => get_post_meta($theme_id, '_theme_gallery', true),
    'documentation_url' => get_post_meta($theme_id, '_theme_documentation_url', true),
    'support_email' => get_post_meta($theme_id, '_theme_support_email', true),
    'video_tutorials_url' => get_post_meta($theme_id, '_theme_video_tutorials_url', true),
    'developer_address' => get_post_meta($theme_id, '_theme_developer_address', true),
    'showcase_blocks' => get_post_meta($theme_id, '_theme_showcase_blocks', true),
    'support_features' => get_post_meta($theme_id, '_theme_support_features', true)
);

$categories = get_the_terms($theme_id, 'theme_category');

// Include styles
get_template_part('template-parts/theme-store/styles');
?>

<div class="theme-page">
    <?php 
    // Hero Section
    get_template_part('template-parts/theme-store/hero', null, array('theme_data' => $theme_data));
    
    // Showcase Section
    get_template_part('template-parts/theme-store/showcase', null, array('theme_data' => $theme_data));
    
    // Features Section
    get_template_part('template-parts/theme-store/features', null, array('theme_data' => $theme_data, 'theme_id' => $theme_id));
    
    // Content Section
    get_template_part('template-parts/theme-store/content');
    
    // Trust Section
    get_template_part('template-parts/theme-store/trust', null, array('theme_data' => $theme_data));
    
    // Support Section (now after Trust section)
    get_template_part('template-parts/theme-store/support', null, array('theme_data' => $theme_data));
    
    // Related Themes Section
    get_template_part('template-parts/theme-store/related', null, array('theme_id' => $theme_id, 'categories' => $categories));
    
    // Modals
    get_template_part('template-parts/theme-store/modals');
    
    // Scripts
    get_template_part('template-parts/theme-store/scripts');
    ?>
</div>

<?php 
endwhile; 
else: 
    echo '<div class="layout-container" style="padding: 60px 0; text-align: center;"><h2>Theme not found</h2></div>';
endif; 

get_footer(); 
?>