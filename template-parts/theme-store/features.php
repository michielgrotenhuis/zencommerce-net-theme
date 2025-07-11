<?php
/**
 * Theme Store Features Section
 * template-parts/theme-store/features.php
 */

$theme_data = $args['theme_data'] ?? array();
$theme_id = $args['theme_id'] ?? 0;

$theme_features = $theme_data['features'] ?? array();
$support_features = $theme_data['support_features'] ?? array();

if (!is_array($theme_features)) $theme_features = array();
if (!is_array($support_features)) $support_features = array();

// Include feature configuration
$feature_categories = array(
    'great-for' => array(
        'title' => 'Perfect For',
        'icon' => '🎯',
        'type' => 'theme',
        'features' => array('quick_setup', 'visual_storytelling', 'dropshipping', 'high_volume_stores', 'physical_stores', 'small_catalogs', 'large_catalogs', 'editorial_content', 'quick_launch')
    ),
    'sales-conversion' => array(
        'title' => 'Sales & Conversion',
        'icon' => '💰',
        'type' => 'theme',
        'features' => array('cart_notes', 'in_store_pickups', 'quick_buy', 'slide_out_cart', 'cart_countdown_timers', 'gift_wrapping', 'pre_order', 'back_in_stock_notifications', 'bnpl_messaging', 'trust_badges_checkout', 'cross_selling', 'recommended_products', 'age_verifier', 'announcement_bar', 'countdown_timers', 'popups_modals', 'email_signup_forms', 'product_badges', 'custom_cta_buttons', 'social_proof', 'affiliate_ready')
    ),
    'product-showcase' => array(
        'title' => 'Product Showcase',
        'icon' => '🏪',
        'type' => 'theme',
        'features' => array('color_swatches', 'high_resolution_images', 'image_galleries', 'image_rollover', 'image_zoom', 'ingredients_nutritional', 'lookbooks', 'product_options', 'product_videos', 'shipping_delivery_info', 'size_chart', 'slideshow', 'usage_information', 'product_view_360', 'accordion_product_tabs', 'custom_product_badges', 'sticky_add_to_cart', 'back_in_stock_label', 'before_after_slider', 'product_bundling', 'tabbed_product_info', 'multiple_product_layouts', 'customizable_hotspots', 'product_feature_icons')
    ),
    'navigation-search' => array(
        'title' => 'Navigation & Search',
        'icon' => '🔍',
        'type' => 'theme',
        'features' => array('enhanced_search', 'mega_menu', 'product_filtering_sorting', 'recommended_products_discovery', 'sticky_header', 'swatch_filters', 'live_search_suggestions', 'predictive_search', 'infinite_scroll', 'quick_view', 'tag_based_filters', 'recently_viewed', 'advanced_navigation')
    ),
    'technical' => array(
        'title' => 'Technical Features',
        'icon' => '⚙️',
        'type' => 'theme',
        'features' => array('responsive', 'retina', 'seo_optimized', 'fast_loading', 'customizable', 'multilingual', 'rtl_support', 'page_builder', 'one_click_demo', 'social_sharing', 'contact_form', 'newsletter_integration', 'css3_animations', 'bootstrap_framework', 'custom_widgets', 'parallax_effects', 'video_backgrounds', 'lazy_loading', 'compression_optimization', 'schema_markup', 'accessibility_ready')
    )
);

// Feature labels
$feature_labels = array(
    // Perfect For
    'quick_setup' => 'Quick setup & fast launch',
    'visual_storytelling' => 'Visual storytelling & branding',
    'dropshipping' => 'Dropshipping businesses',
    'high_volume_stores' => 'High-volume stores',
    'physical_stores' => 'Physical store locations',
    'small_catalogs' => 'Small product catalogs',
    'large_catalogs' => 'Large product catalogs',
    'editorial_content' => 'Editorial & blog content',
    'quick_launch' => 'Quick market entry',
    
    // Sales & Conversion
    'cart_notes' => 'Customer cart notes',
    'in_store_pickups' => 'In-store pickup options',
    'quick_buy' => 'One-click quick buy',
    'slide_out_cart' => 'Slide-out cart drawer',
    'cart_countdown_timers' => 'Cart abandonment timers',
    'gift_wrapping' => 'Gift wrapping options',
    'pre_order' => 'Pre-order functionality',
    'back_in_stock_notifications' => 'Stock notification alerts',
    'bnpl_messaging' => 'Buy now, pay later options',
    'trust_badges_checkout' => 'Security trust badges',
    'cross_selling' => 'Cross-selling suggestions',
    'recommended_products' => 'Smart product recommendations',
    'age_verifier' => 'Age verification system',
    'announcement_bar' => 'Promotional announcement bar',
    'countdown_timers' => 'Sale countdown timers',
    'popups_modals' => 'Conversion pop-ups & modals',
    'email_signup_forms' => 'Email capture forms',
    'product_badges' => 'Product labels & badges',
    'custom_cta_buttons' => 'Custom call-to-action buttons',
    'social_proof' => 'Reviews & testimonials',
    'affiliate_ready' => 'Affiliate marketing ready',
    
    // Product Showcase
    'color_swatches' => 'Color variant swatches',
    'high_resolution_images' => 'High-resolution image support',
    'image_galleries' => 'Product image galleries',
    'image_rollover' => 'Image hover effects',
    'image_zoom' => 'Zoom functionality',
    'ingredients_nutritional' => 'Ingredient & nutrition info',
    'lookbooks' => 'Style lookbooks',
    'product_options' => 'Product variant options',
    'product_videos' => 'Product demonstration videos',
    'shipping_delivery_info' => 'Shipping & delivery details',
    'size_chart' => 'Interactive size charts',
    'slideshow' => 'Product image slideshow',
    'usage_information' => 'Product usage guides',
    'product_view_360' => '360° product viewer',
    'accordion_product_tabs' => 'Accordion product tabs',
    'custom_product_badges' => 'Custom product badges',
    'sticky_add_to_cart' => 'Sticky add to cart button',
    'back_in_stock_label' => 'Back in stock indicators',
    'before_after_slider' => 'Before/after comparison',
    'product_bundling' => 'Product bundle offers',
    'tabbed_product_info' => 'Tabbed product information',
    'multiple_product_layouts' => 'Multiple layout options',
    'customizable_hotspots' => 'Interactive image hotspots',
    'product_feature_icons' => 'Feature highlight icons',
    
    // Navigation & Search
    'enhanced_search' => 'Advanced search functionality',
    'mega_menu' => 'Mega menu navigation',
    'product_filtering_sorting' => 'Product filters & sorting',
    'recommended_products_discovery' => 'AI product recommendations',
    'sticky_header' => 'Sticky navigation header',
    'swatch_filters' => 'Visual swatch filters',
    'live_search_suggestions' => 'Live search suggestions',
    'predictive_search' => 'Predictive search results',
    'infinite_scroll' => 'Infinite scroll pagination',
    'quick_view' => 'Quick product preview',
    'tag_based_filters' => 'Tag-based filtering',
    'recently_viewed' => 'Recently viewed products',
    'advanced_navigation' => 'Breadcrumbs & multi-level menus',
    
    // Technical Features
    'responsive' => 'Mobile responsive design',
    'retina' => 'Retina display optimized',
    'seo_optimized' => 'SEO best practices',
    'fast_loading' => 'Optimized loading speed',
    'customizable' => 'Highly customizable',
    'multilingual' => 'Multi-language support',
    'rtl_support' => 'Right-to-left language support',
    'page_builder' => 'Page builder compatibility',
    'one_click_demo' => 'One-click demo import',
    'social_sharing' => 'Social media integration',
    'contact_form' => 'Contact form builder',
    'newsletter_integration' => 'Email marketing integration',
    'css3_animations' => 'CSS3 animations & effects',
    'bootstrap_framework' => 'Bootstrap framework',
    'custom_widgets' => 'Custom widget areas',
    'parallax_effects' => 'Parallax scrolling effects',
    'video_backgrounds' => 'Video background support',
    'lazy_loading' => 'Lazy loading optimization',
    'compression_optimization' => 'Image compression',
    'schema_markup' => 'Structured data markup',
    'accessibility_ready' => 'WCAG accessibility compliant'
);

// Filter categories that have features
$filtered_categories = array();
foreach ($feature_categories as $cat_id => $category) {
    $category_features = array_intersect($category['features'], $theme_features);
    if (!empty($category_features)) {
        $filtered_categories[$cat_id] = $category;
        $filtered_categories[$cat_id]['available_features'] = $category_features;
    }
}

if (!empty($filtered_categories)):
?>

<section class="theme-features">
    <div class="layout-container">
        <div class="features-intro">
            <h2>What's Included</h2>
            <p>This theme comes packed with powerful features to help your store succeed</p>
        </div>
        
        <div class="features-categories">
            <?php foreach ($filtered_categories as $cat_id => $category): ?>
            <div class="feature-category">
                <div class="category-header">
                    <div class="category-icon"><?php echo $category['icon']; ?></div>
                    <h3 class="category-title"><?php echo esc_html($category['title']); ?></h3>
                    <span class="category-count"><?php echo count($category['available_features']); ?></span>
                </div>
                
                <div class="features-grid">
                    <?php foreach ($category['available_features'] as $feature): 
                        $label = isset($feature_labels[$feature]) ? $feature_labels[$feature] : ucwords(str_replace('_', ' ', $feature));
                    ?>
                        <div class="feature-item">
                            <span class="feature-icon">✓</span>
                            <span class="feature-text"><?php echo esc_html($label); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php endif; ?>