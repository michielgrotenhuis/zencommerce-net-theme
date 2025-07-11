<?php
/**
 * ZENCOMMERCE THEME POST TYPE - COMPLETE SYSTEM
 * 
 * Custom post type for managing WordPress themes in the Zencommerce theme store
 * 
 * @package YourSite
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Enable error logging for debugging
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}

// =============================================================================
// POST TYPE REGISTRATION
// =============================================================================

/**
 * Register Custom Post Type for Themes
 */
function zencommerce_register_theme_post_type() {
    try {
        $labels = array(
            'name'                  => _x('Themes', 'Post Type General Name', 'zencommerce'),
            'singular_name'         => _x('Theme', 'Post Type Singular Name', 'zencommerce'),
            'menu_name'             => __('Themes', 'zencommerce'),
            'name_admin_bar'        => __('Theme', 'zencommerce'),
            'add_new_item'          => __('Add New Theme', 'zencommerce'),
            'add_new'               => __('Add New', 'zencommerce'),
            'new_item'              => __('New Theme', 'zencommerce'),
            'edit_item'             => __('Edit Theme', 'zencommerce'),
            'update_item'           => __('Update Theme', 'zencommerce'),
            'view_item'             => __('View Theme', 'zencommerce'),
            'all_items'             => __('All Themes', 'zencommerce'),
        );
        
        $args = array(
            'label'                 => __('Theme', 'zencommerce'),
            'description'           => __('WordPress Themes for Zencommerce', 'zencommerce'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
            'taxonomies'            => array('theme_category', 'theme_tag'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-admin-appearance',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rewrite'               => array('slug' => 'themes'),
        );
        
        register_post_type('zencommerce_theme', $args);
        error_log('✅ Zencommerce theme post type registered successfully');
        
    } catch (Exception $e) {
        error_log('❌ Error registering theme post type: ' . $e->getMessage());
    }
}
add_action('init', 'zencommerce_register_theme_post_type', 0);

// =============================================================================
// TAXONOMIES REGISTRATION
// =============================================================================

/**
 * Register Custom Taxonomies
 */
function zencommerce_register_theme_taxonomies() {
    try {
        // Theme Categories
        $category_labels = array(
            'name'              => _x('Theme Categories', 'taxonomy general name', 'zencommerce'),
            'singular_name'     => _x('Theme Category', 'taxonomy singular name', 'zencommerce'),
            'search_items'      => __('Search Categories', 'zencommerce'),
            'all_items'         => __('All Categories', 'zencommerce'),
            'edit_item'         => __('Edit Category', 'zencommerce'),
            'update_item'       => __('Update Category', 'zencommerce'),
            'add_new_item'      => __('Add New Category', 'zencommerce'),
            'new_item_name'     => __('New Category Name', 'zencommerce'),
            'menu_name'         => __('Categories', 'zencommerce'),
        );

        register_taxonomy('theme_category', array('zencommerce_theme'), array(
            'hierarchical'      => true,
            'labels'            => $category_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => 'theme-category'),
        ));

        // Theme Tags
        $tag_labels = array(
            'name'              => _x('Theme Tags', 'taxonomy general name', 'zencommerce'),
            'singular_name'     => _x('Theme Tag', 'taxonomy singular name', 'zencommerce'),
            'search_items'      => __('Search Tags', 'zencommerce'),
            'popular_items'     => __('Popular Tags', 'zencommerce'),
            'all_items'         => __('All Tags', 'zencommerce'),
            'edit_item'         => __('Edit Tag', 'zencommerce'),
            'update_item'       => __('Update Tag', 'zencommerce'),
            'add_new_item'      => __('Add New Tag', 'zencommerce'),
            'new_item_name'     => __('New Tag Name', 'zencommerce'),
            'menu_name'         => __('Tags', 'zencommerce'),
        );

        register_taxonomy('theme_tag', array('zencommerce_theme'), array(
            'hierarchical'      => false,
            'labels'            => $tag_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => 'theme-tag'),
        ));
        
        error_log('✅ Zencommerce taxonomies registered successfully');
        
    } catch (Exception $e) {
        error_log('❌ Error registering taxonomies: ' . $e->getMessage());
    }
}
add_action('init', 'zencommerce_register_theme_taxonomies', 0);

// =============================================================================
// META BOXES
// =============================================================================

/**
 * Add Custom Meta Fields
 */
function zencommerce_add_theme_meta_boxes() {
    try {
        add_meta_box(
            'theme_details',
            __('Theme Details', 'zencommerce'),
            'zencommerce_theme_details_callback',
            'zencommerce_theme',
            'normal',
            'high'
        );
        
        add_meta_box(
            'theme_features',
            __('Theme Features', 'zencommerce'),
            'zencommerce_theme_features_callback',
            'zencommerce_theme',
            'normal',
            'high'
        );
        
        add_meta_box(
            'theme_gallery',
            __('Theme Gallery', 'zencommerce'),
            'zencommerce_theme_gallery_callback',
            'zencommerce_theme',
            'side',
            'default'
        );
        
        add_meta_box(
            'theme_showcase',
            __('Theme Showcase Blocks', 'zencommerce'),
            'zencommerce_theme_showcase_callback',
            'zencommerce_theme',
            'normal',
            'high'
        );
        
        error_log('✅ Meta boxes added successfully');
        
    } catch (Exception $e) {
        error_log('❌ Error adding meta boxes: ' . $e->getMessage());
    }
}
add_action('add_meta_boxes', 'zencommerce_add_theme_meta_boxes');

// =============================================================================
// META BOX CALLBACKS
// =============================================================================

/**
 * Theme Details Meta Box
 */
function zencommerce_theme_details_callback($post) {
    try {
        // Security nonce
        wp_nonce_field('zencommerce_theme_meta_nonce', 'zencommerce_theme_meta_nonce_field');
        
        // Safely get meta values with fallbacks
        $price = get_post_meta($post->ID, '_theme_price', true) ?: '';
        $developer = get_post_meta($post->ID, '_theme_developer', true) ?: '';
        $version = get_post_meta($post->ID, '_theme_version', true) ?: '';
        $demo_url = get_post_meta($post->ID, '_theme_demo_url', true) ?: '';
        $download_url = get_post_meta($post->ID, '_theme_download_url', true) ?: '';
        $rating = get_post_meta($post->ID, '_theme_rating', true) ?: '';
        $last_updated = get_post_meta($post->ID, '_theme_last_updated', true) ?: '';
        $color_variations = get_post_meta($post->ID, '_theme_color_variations', true) ?: '';
        
        // Support & Documentation URLs
        $documentation_url = get_post_meta($post->ID, '_theme_documentation_url', true) ?: '';
        $support_email = get_post_meta($post->ID, '_theme_support_email', true) ?: '';
        $video_tutorials_url = get_post_meta($post->ID, '_theme_video_tutorials_url', true) ?: '';
        $support_forum_url = get_post_meta($post->ID, '_theme_support_forum_url', true) ?: '';
        $developer_address = get_post_meta($post->ID, '_theme_developer_address', true) ?: '';
        
        ?>
        <style>
        .theme-meta-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .theme-meta-table th { 
            text-align: left; 
            padding: 12px 15px; 
            width: 200px; 
            background: #f9f9f9; 
            border: 1px solid #ddd; 
            font-weight: 600;
        }
        .theme-meta-table td { 
            padding: 12px 15px; 
            border: 1px solid #ddd; 
        }
        .theme-meta-table input, 
        .theme-meta-table textarea, 
        .theme-meta-table select { 
            width: 100%; 
            max-width: 400px; 
            padding: 8px 12px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            font-size: 14px;
        }
        .meta-section { 
            margin-bottom: 30px; 
            padding: 20px; 
            background: #f9f9f9; 
            border-radius: 8px; 
            border-left: 4px solid #0073aa; 
        }
        .meta-section h3 { 
            margin-top: 0; 
            color: #0073aa; 
            font-size: 18px;
        }
        .description {
            font-style: italic;
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }
        </style>
        
        <!-- Basic Theme Information -->
        <div class="meta-section">
            <h3>📋 Basic Theme Information</h3>
            <table class="theme-meta-table">
                <tr>
                    <th><label for="theme_price"><?php _e('Price ($)', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="text" id="theme_price" name="theme_price" 
                               value="<?php echo esc_attr($price); ?>" placeholder="99.00" />
                        <p class="description"><?php _e('Enter 0 for free themes (e.g., 99 or 0)', 'zencommerce'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_developer"><?php _e('Developer', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="text" id="theme_developer" name="theme_developer" 
                               value="<?php echo esc_attr($developer); ?>" placeholder="Zencommerce Team" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_version"><?php _e('Version', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="text" id="theme_version" name="theme_version" 
                               value="<?php echo esc_attr($version); ?>" placeholder="1.3.2" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_demo_url"><?php _e('Demo URL', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="url" id="theme_demo_url" name="theme_demo_url" 
                               value="<?php echo esc_attr($demo_url); ?>" placeholder="https://demo.zencommerce.com" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_download_url"><?php _e('Download URL', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="url" id="theme_download_url" name="theme_download_url" 
                               value="<?php echo esc_attr($download_url); ?>" placeholder="https://downloads.zencommerce.com" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_rating"><?php _e('Rating (1-5)', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="number" step="0.1" min="1" max="5" id="theme_rating" name="theme_rating" 
                               value="<?php echo esc_attr($rating); ?>" placeholder="4.8" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_last_updated"><?php _e('Last Updated', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="date" id="theme_last_updated" name="theme_last_updated" 
                               value="<?php echo esc_attr($last_updated); ?>" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_color_variations"><?php _e('Color Variations', 'zencommerce'); ?></label></th>
                    <td>
                        <textarea id="theme_color_variations" name="theme_color_variations" rows="2" 
                                  placeholder="Blue, Red, Green, Purple"><?php echo esc_textarea($color_variations); ?></textarea>
                        <p class="description"><?php _e('Enter color names separated by commas', 'zencommerce'); ?></p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Support & Documentation -->
        <div class="meta-section">
            <h3>🛠️ Support & Documentation</h3>
            <table class="theme-meta-table">
                <tr>
                    <th><label for="theme_documentation_url"><?php _e('Documentation URL', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="url" id="theme_documentation_url" name="theme_documentation_url" 
                               value="<?php echo esc_attr($documentation_url); ?>" placeholder="https://docs.zencommerce.com" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_support_email"><?php _e('Support Email', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="email" id="theme_support_email" name="theme_support_email" 
                               value="<?php echo esc_attr($support_email); ?>" placeholder="support@zencommerce.com" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_video_tutorials_url"><?php _e('Video Tutorials URL', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="url" id="theme_video_tutorials_url" name="theme_video_tutorials_url" 
                               value="<?php echo esc_attr($video_tutorials_url); ?>" placeholder="https://tutorials.zencommerce.com" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_support_forum_url"><?php _e('Support Forum URL', 'zencommerce'); ?></label></th>
                    <td>
                        <input type="url" id="theme_support_forum_url" name="theme_support_forum_url" 
                               value="<?php echo esc_attr($support_forum_url); ?>" placeholder="https://forum.zencommerce.com" />
                    </td>
                </tr>
                <tr>
                    <th><label for="theme_developer_address"><?php _e('Developer Address', 'zencommerce'); ?></label></th>
                    <td>
                        <textarea id="theme_developer_address" name="theme_developer_address" rows="3" 
                                  placeholder="123 Main Street, City, Country"><?php echo esc_textarea($developer_address); ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        
        <div style="background: #f0f6fc; padding: 15px; border-radius: 4px; margin: 20px 0; border-left: 4px solid #0073aa;">
            <h4 style="margin-top: 0;">💡 Quick Fill Example Data</h4>
            <button type="button" id="fill-example-data" class="button button-primary">Fill Example Data</button>
            <p class="description">This will fill all fields with example data for testing.</p>
        </div>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fillButton = document.getElementById('fill-example-data');
            if (fillButton) {
                fillButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Basic info
                    var fields = {
                        'theme_price': '99',
                        'theme_developer': 'Zencommerce Team',
                        'theme_version': '1.3.2',
                        'theme_demo_url': 'https://demo.zencommerce.com',
                        'theme_download_url': 'https://download.zencommerce.com',
                        'theme_rating': '4.8',
                        'theme_last_updated': new Date().toISOString().split('T')[0],
                        'theme_color_variations': 'Blue, Red, Green, Purple, Dark',
                        'theme_documentation_url': 'https://docs.zencommerce.com',
                        'theme_support_email': 'support@zencommerce.com',
                        'theme_video_tutorials_url': 'https://tutorials.zencommerce.com',
                        'theme_support_forum_url': 'https://forum.zencommerce.com',
                        'theme_developer_address': '123 Main Street, Your City, Country'
                    };
                    
                    for (var field in fields) {
                        var element = document.getElementById(field);
                        if (element) {
                            element.value = fields[field];
                        }
                    }
                    
                    alert('✅ Example data filled! Don\'t forget to save the post.');
                });
            }
        });
        </script>
        <?php
        
    } catch (Exception $e) {
        error_log('❌ Error in theme details callback: ' . $e->getMessage());
        echo '<div class="notice notice-error"><p>Error loading theme details. Check error logs.</p></div>';
    }
}

/**
 * Theme Features Meta Box
 */
function zencommerce_theme_features_callback($post) {
    try {
        $features = get_post_meta($post->ID, '_theme_features', true);
        $support_features = get_post_meta($post->ID, '_theme_support_features', true);
        
        // Ensure arrays
        if (!is_array($features)) $features = array();
        if (!is_array($support_features)) $support_features = array();
        
        // Complete feature categories
        $feature_categories = array(
            'This Theme is Great For' => array(
                'quick_setup' => 'Quick setup (minimal setup for fast launch)',
                'visual_storytelling' => 'Visual storytelling (image-focused brand presentation)',
                'dropshipping' => 'Dropshipping',
                'high_volume_stores' => 'High-volume stores',
                'physical_stores' => 'Physical stores',
                'small_catalogs' => 'Small catalogs',
                'large_catalogs' => 'Large catalogs',
                'editorial_content' => 'Editorial content',
                'quick_launch' => 'Quick launch',
            ),
            'Cart and Checkout' => array(
                'cart_notes' => 'Cart notes',
                'in_store_pickups' => 'In-store pickups',
                'quick_buy' => 'Quick buy',
                'slide_out_cart' => 'Slide-out / drawer cart',
                'cart_countdown_timers' => 'Cart countdown timers',
                'gift_wrapping' => 'Gift wrapping options',
                'pre_order' => 'Pre-order support',
                'back_in_stock_notifications' => 'Back-in-stock notifications',
                'bnpl_messaging' => 'Buy now, pay later messaging (BNPL)',
                'trust_badges_checkout' => 'Trust badges at checkout',
            ),
            'Marketing and Conversion' => array(
                'blogs' => 'Blogs',
                'cross_selling' => 'Cross-selling',
                'faq_page' => 'FAQ page',
                'press_coverage' => 'Press coverage',
                'promo_banners' => 'Promo banners',
                'recommended_products' => 'Recommended products',
                'age_verifier' => 'Age verifier',
                'announcement_bar' => 'Announcement bar',
                'countdown_timers' => 'Countdown timers',
                'popups_modals' => 'Pop-ups/modals (newsletter, exit intent)',
                'email_signup_forms' => 'Email signup forms',
                'product_badges' => 'Product badges (e.g., "New", "Sale")',
                'custom_cta_buttons' => 'Custom CTA buttons',
                'social_proof' => 'Social proof (reviews, testimonials)',
                'affiliate_ready' => 'Affiliate-ready integrations',
            ),
            'Technical Features' => array(
                'responsive' => 'Responsive Design',
                'retina' => 'Retina Ready',
                'seo_optimized' => 'SEO Optimized',
                'fast_loading' => 'Fast Loading',
                'customizable' => 'Highly Customizable',
                'multilingual' => 'Multilingual Ready',
                'rtl_support' => 'RTL Support',
                'page_builder' => 'Page Builder Compatible',
                'one_click_demo' => 'One Click Demo Import',
                'social_sharing' => 'Social Sharing',
            )
        );
        
        $support_feature_list = array(
            'documentation' => 'Documentation',
            'video_tutorials' => 'Video Tutorials',
            'email_support' => 'Email Support',
            'forum_support' => 'Forum Support',
            'free_updates' => 'Free Updates',
        );
        
        ?>
        <style>
        .feature-category { 
            margin-bottom: 25px; 
            padding: 20px; 
            background: #f9f9f9; 
            border-radius: 8px; 
            border-left: 4px solid #0073aa;
        }
        .feature-category h4 { 
            margin-top: 0; 
            color: #0073aa; 
            font-size: 16px; 
            font-weight: 600;
            margin-bottom: 15px;
        }
        .feature-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 8px; 
        }
        .feature-grid label { 
            display: flex; 
            align-items: flex-start; 
            gap: 8px; 
            padding: 10px 12px; 
            background: white; 
            border-radius: 4px; 
            border: 1px solid #ddd;
            font-size: 14px;
        }
        </style>
        
        <div class="feature-summary">
            <h4>📋 Theme Features Management</h4>
            <p>Select all features that apply to this theme.</p>
        </div>
        
        <?php foreach ($feature_categories as $category_name => $category_features): ?>
            <div class="feature-category">
                <h4><?php echo esc_html($category_name); ?></h4>
                <div class="feature-grid">
                    <?php foreach ($category_features as $key => $label): ?>
                        <label>
                            <input type="checkbox" 
                                   name="theme_features[]" 
                                   value="<?php echo esc_attr($key); ?>" 
                                   <?php checked(in_array($key, $features)); ?> />
                            <span><?php echo esc_html($label); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="feature-category">
            <h4>🛠️ Support & Documentation</h4>
            <div class="feature-grid">
                <?php foreach ($support_feature_list as $key => $label): ?>
                    <label>
                        <input type="checkbox" 
                               name="theme_support_features[]" 
                               value="<?php echo esc_attr($key); ?>" 
                               <?php checked(in_array($key, $support_features)); ?> />
                        <span><?php echo esc_html($label); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        
    } catch (Exception $e) {
        error_log('❌ Error in theme features callback: ' . $e->getMessage());
        echo '<div class="notice notice-error"><p>Error loading theme features. Check error logs.</p></div>';
    }
}

/**
 * Theme Gallery Meta Box
 */
function zencommerce_theme_gallery_callback($post) {
    try {
        $gallery = get_post_meta($post->ID, '_theme_gallery', true) ?: '';
        ?>
        <p>
            <label for="theme_gallery"><?php _e('Gallery Image IDs', 'zencommerce'); ?></label>
            <textarea id="theme_gallery" name="theme_gallery" rows="3" style="width: 100%;" 
                      placeholder="123,456,789"><?php echo esc_textarea($gallery); ?></textarea>
        </p>
        <p class="description">Enter image IDs separated by commas, or use the media library.</p>
        <?php
    } catch (Exception $e) {
        error_log('❌ Error in gallery callback: ' . $e->getMessage());
        echo '<p>Error loading gallery field.</p>';
    }
}

/**
 * Theme Showcase Blocks Meta Box - UPDATED VERSION
 * Replace the existing zencommerce_theme_showcase_callback function with this one
 */
function zencommerce_theme_showcase_callback($post) {
    try {
        $showcase_blocks = get_post_meta($post->ID, '_theme_showcase_blocks', true);
        if (!is_array($showcase_blocks)) {
            $showcase_blocks = array();
        }
        
        // Ensure we have 3 blocks with all required fields
        for ($i = 0; $i < 3; $i++) {
            if (!isset($showcase_blocks[$i])) {
                $showcase_blocks[$i] = array(
                    'title' => '',
                    'description' => '',
                    'media_type' => 'image',
                    'image_id' => '',
                    'youtube_url' => '',
                );
            }
            // Ensure all fields exist (for backward compatibility)
            if (!isset($showcase_blocks[$i]['media_type'])) {
                $showcase_blocks[$i]['media_type'] = 'image';
            }
            if (!isset($showcase_blocks[$i]['image_id'])) {
                $showcase_blocks[$i]['image_id'] = '';
            }
            if (!isset($showcase_blocks[$i]['youtube_url'])) {
                $showcase_blocks[$i]['youtube_url'] = '';
            }
        }
        ?>
        <style>
        .showcase-block {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            background: #f9fafb;
            position: relative;
        }
        .showcase-field {
            margin-bottom: 15px;
        }
        .showcase-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #374151;
        }
        .showcase-field input,
        .showcase-field textarea,
        .showcase-field select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 14px;
        }
        .media-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 6px;
            padding: 20px;
            text-align: center;
            background: #f9fafb;
            transition: all 0.3s ease;
        }
        .media-upload-area:hover {
            border-color: #9ca3af;
            background: #f3f4f6;
        }
        .media-upload-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            margin-right: 10px;
        }
        .media-upload-btn:hover {
            background: #2563eb;
        }
        .media-remove-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }
        .media-remove-btn:hover {
            background: #dc2626;
        }
        .media-preview {
            margin-top: 15px;
            max-width: 300px;
        }
        .media-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .media-type-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .media-type-option {
            flex: 1;
            padding: 10px;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }
        .media-type-option.active {
            border-color: #3b82f6;
            background: #eff6ff;
            color: #1d4ed8;
        }
        .media-type-option:hover {
            border-color: #9ca3af;
        }
        .youtube-preview {
            margin-top: 15px;
            padding: 15px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 6px;
            color: #991b1b;
        }
        .youtube-preview.valid {
            background: #f0f9ff;
            border-color: #93c5fd;
            color: #1e40af;
        }
        .block-number {
            position: absolute;
            top: -10px;
            right: 20px;
            background: #3b82f6;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }
        .showcase-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }
        </style>
        
        <div class="showcase-header">
            <h3 style="margin: 0 0 10px 0; font-size: 24px;">🎨 Theme Showcase Blocks</h3>
            <p style="margin: 0; opacity: 0.9;">Create up to 3 showcase blocks to highlight your theme's key features. Each block can contain an image or YouTube video.</p>
        </div>
        
        <?php for ($i = 0; $i < 3; $i++): 
            $block = $showcase_blocks[$i];
            $block_num = $i + 1;
        ?>
            <div class="showcase-block" id="showcase-block-<?php echo $i; ?>">
                <div class="block-number"><?php echo $block_num; ?></div>
                
                <h4 style="margin-top: 0; color: #1f2937; font-size: 18px;">
                    📋 Showcase Block <?php echo $block_num; ?>
                </h4>
                
                <!-- Block Title -->
                <div class="showcase-field">
                    <label for="showcase_title_<?php echo $i; ?>">Block Title</label>
                    <input type="text" 
                           id="showcase_title_<?php echo $i; ?>" 
                           name="showcase_blocks[<?php echo $i; ?>][title]" 
                           value="<?php echo esc_attr($block['title']); ?>" 
                           placeholder="e.g., 'Mobile-First Design', 'Advanced Customization'" />
                </div>
                
                <!-- Block Description -->
                <div class="showcase-field">
                    <label for="showcase_description_<?php echo $i; ?>">Description</label>
                    <textarea id="showcase_description_<?php echo $i; ?>" 
                              name="showcase_blocks[<?php echo $i; ?>][description]" 
                              rows="3"
                              placeholder="Describe what makes this feature special..."><?php echo esc_textarea($block['description']); ?></textarea>
                </div>
                
                <!-- Media Type Selector -->
                <div class="showcase-field">
                    <label>Media Type</label>
                    <div class="media-type-selector">
                        <div class="media-type-option <?php echo ($block['media_type'] === 'image') ? 'active' : ''; ?>" 
                             onclick="selectMediaType(<?php echo $i; ?>, 'image')">
                            <strong>🖼️ Image</strong><br>
                            <small>Upload a screenshot or graphic</small>
                        </div>
                        <div class="media-type-option <?php echo ($block['media_type'] === 'youtube') ? 'active' : ''; ?>" 
                             onclick="selectMediaType(<?php echo $i; ?>, 'youtube')">
                            <strong>🎥 YouTube Video</strong><br>
                            <small>Embed a YouTube video</small>
                        </div>
                    </div>
                    <input type="hidden" 
                           id="media_type_<?php echo $i; ?>" 
                           name="showcase_blocks[<?php echo $i; ?>][media_type]" 
                           value="<?php echo esc_attr($block['media_type']); ?>" />
                </div>
                
                <!-- Image Upload Area -->
                <div class="showcase-field image-upload-area" id="image_area_<?php echo $i; ?>" 
                     style="display: <?php echo ($block['media_type'] === 'image') ? 'block' : 'none'; ?>;">
                    <label>Showcase Image</label>
                    <div class="media-upload-area">
                        <input type="hidden" 
                               id="showcase_image_<?php echo $i; ?>" 
                               name="showcase_blocks[<?php echo $i; ?>][image_id]" 
                               value="<?php echo esc_attr($block['image_id']); ?>" />
                        
                        <button type="button" 
                                class="media-upload-btn" 
                                onclick="uploadShowcaseImage(<?php echo $i; ?>)">
                            <?php echo !empty($block['image_id']) ? 'Change Image' : 'Upload Image'; ?>
                        </button>
                        
                        <?php if (!empty($block['image_id'])): ?>
                            <button type="button" 
                                    class="media-remove-btn" 
                                    onclick="removeShowcaseImage(<?php echo $i; ?>)">
                                Remove Image
                            </button>
                        <?php endif; ?>
                        
                        <p style="margin: 10px 0 0 0; font-size: 13px; color: #6b7280;">
                            Recommended: 1200x800px or larger for best quality
                        </p>
                        
                        <?php if (!empty($block['image_id'])): ?>
                            <div class="media-preview" id="image_preview_<?php echo $i; ?>">
                                <img src="<?php echo wp_get_attachment_image_url($block['image_id'], 'medium'); ?>" 
                                     alt="Preview" />
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- YouTube URL Area -->
                <div class="showcase-field youtube-upload-area" id="youtube_area_<?php echo $i; ?>" 
                     style="display: <?php echo ($block['media_type'] === 'youtube') ? 'block' : 'none'; ?>;">
                    <label for="showcase_youtube_<?php echo $i; ?>">YouTube Video URL</label>
                    <input type="url" 
                           id="showcase_youtube_<?php echo $i; ?>" 
                           name="showcase_blocks[<?php echo $i; ?>][youtube_url]" 
                           value="<?php echo esc_attr($block['youtube_url']); ?>" 
                           placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                           onchange="validateYouTubeUrl(<?php echo $i; ?>, this.value)" />
                    
                    <div class="youtube-preview" id="youtube_preview_<?php echo $i; ?>" style="display: none;">
                        <strong>✅ Valid YouTube URL detected!</strong><br>
                        Video will be embedded in the showcase.
                    </div>
                </div>
            </div>
        <?php endfor; ?>
        
        <div style="background: #f0f6fc; padding: 15px; border-radius: 6px; margin-top: 20px; border-left: 4px solid #3b82f6;">
            <h4 style="margin-top: 0; color: #1e40af;">💡 Showcase Tips</h4>
            <ul style="margin: 0; color: #1e40af;">
                <li><strong>Images:</strong> Use high-quality screenshots that highlight specific features</li>
                <li><strong>Videos:</strong> Keep videos under 2 minutes for best engagement</li>
                <li><strong>Descriptions:</strong> Focus on benefits, not just features</li>
                <li><strong>Order:</strong> Place your most important showcase first</li>
            </ul>
        </div>
        
        <script>
        function selectMediaType(blockIndex, mediaType) {
            // Update hidden input
            document.getElementById('media_type_' + blockIndex).value = mediaType;
            
            // Update visual selector
            const block = document.getElementById('showcase-block-' + blockIndex);
            const options = block.querySelectorAll('.media-type-option');
            options.forEach(option => option.classList.remove('active'));
            
            if (mediaType === 'image') {
                options[0].classList.add('active');
                document.getElementById('image_area_' + blockIndex).style.display = 'block';
                document.getElementById('youtube_area_' + blockIndex).style.display = 'none';
            } else {
                options[1].classList.add('active');
                document.getElementById('image_area_' + blockIndex).style.display = 'none';
                document.getElementById('youtube_area_' + blockIndex).style.display = 'block';
            }
        }
        
        function uploadShowcaseImage(blockIndex) {
            const mediaUploader = wp.media({
                title: 'Select Showcase Image',
                button: {
                    text: 'Use This Image'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });
            
            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                
                // Update hidden input
                document.getElementById('showcase_image_' + blockIndex).value = attachment.id;
                
                // Update button text
                const uploadBtn = document.querySelector('#showcase-block-' + blockIndex + ' .media-upload-btn');
                uploadBtn.textContent = 'Change Image';
                
                // Add remove button if it doesn't exist
                const removeBtn = document.querySelector('#showcase-block-' + blockIndex + ' .media-remove-btn');
                if (!removeBtn) {
                    const newRemoveBtn = document.createElement('button');
                    newRemoveBtn.type = 'button';
                    newRemoveBtn.className = 'media-remove-btn';
                    newRemoveBtn.textContent = 'Remove Image';
                    newRemoveBtn.onclick = function() { removeShowcaseImage(blockIndex); };
                    uploadBtn.parentNode.insertBefore(newRemoveBtn, uploadBtn.nextSibling);
                }
                
                // Update preview
                let preview = document.getElementById('image_preview_' + blockIndex);
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'image_preview_' + blockIndex;
                    preview.className = 'media-preview';
                    document.querySelector('#image_area_' + blockIndex + ' .media-upload-area').appendChild(preview);
                }
                
                preview.innerHTML = '<img src="' + (attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url) + '" alt="Preview" />';
            });
            
            mediaUploader.open();
        }
        
        function removeShowcaseImage(blockIndex) {
            // Clear hidden input
            document.getElementById('showcase_image_' + blockIndex).value = '';
            
            // Update button text
            const uploadBtn = document.querySelector('#showcase-block-' + blockIndex + ' .media-upload-btn');
            uploadBtn.textContent = 'Upload Image';
            
            // Remove remove button
            const removeBtn = document.querySelector('#showcase-block-' + blockIndex + ' .media-remove-btn');
            if (removeBtn) {
                removeBtn.remove();
            }
            
            // Remove preview
            const preview = document.getElementById('image_preview_' + blockIndex);
            if (preview) {
                preview.remove();
            }
        }
        
        function validateYouTubeUrl(blockIndex, url) {
            const preview = document.getElementById('youtube_preview_' + blockIndex);
            
            if (!url) {
                preview.style.display = 'none';
                return;
            }
            
            // Basic YouTube URL validation
            const youtubeRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
            
            if (youtubeRegex.test(url)) {
                preview.className = 'youtube-preview valid';
                preview.style.display = 'block';
                preview.innerHTML = '<strong>✅ Valid YouTube URL detected!</strong><br>Video will be embedded in the showcase.';
            } else {
                preview.className = 'youtube-preview';
                preview.style.display = 'block';
                preview.innerHTML = '<strong>⚠️ Invalid YouTube URL</strong><br>Please enter a valid YouTube video URL.';
            }
        }
        
        // Initialize YouTube validation on page load
        document.addEventListener('DOMContentLoaded', function() {
            for (let i = 0; i < 3; i++) {
                const youtubeInput = document.getElementById('showcase_youtube_' + i);
                if (youtubeInput && youtubeInput.value) {
                    validateYouTubeUrl(i, youtubeInput.value);
                }
            }
        });
        </script>
        <?php
        
    } catch (Exception $e) {
        error_log('❌ Error in showcase callback: ' . $e->getMessage());
        echo '<div class="notice notice-error"><p>Error loading showcase blocks. Check error logs.</p></div>';
    }
}

// =============================================================================
// SAVE META DATA
// =============================================================================

/**
 * Save Theme Meta Data
 */
function zencommerce_save_theme_meta($post_id) {
    try {
        // Security checks
        if (!isset($_POST['zencommerce_theme_meta_nonce_field']) || 
            !wp_verify_nonce($_POST['zencommerce_theme_meta_nonce_field'], 'zencommerce_theme_meta_nonce')) {
            error_log('❌ Nonce verification failed for post ' . $post_id);
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            error_log('❌ User lacks permission to edit post ' . $post_id);
            return;
        }

        // Only save for our post type
        if (get_post_type($post_id) !== 'zencommerce_theme') {
            return;
        }

        error_log('🔄 Starting to save theme meta for post ' . $post_id);

        // Save all theme meta fields
        $fields = array(
            'theme_price', 'theme_developer', 'theme_version', 'theme_demo_url',
            'theme_download_url', 'theme_rating', 'theme_last_updated',
            'theme_color_variations', 'theme_gallery',
            'theme_documentation_url', 'theme_support_email', 'theme_video_tutorials_url',
            'theme_support_forum_url', 'theme_developer_address'
        );
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $value = sanitize_text_field($_POST[$field]);
                $meta_key = '_' . $field;
                
                $result = update_post_meta($post_id, $meta_key, $value);
                error_log("✅ Saved {$field}: '{$value}' for post {$post_id}");
            }
        }
        
        // Save showcase blocks
     if (isset($_POST['showcase_blocks']) && is_array($_POST['showcase_blocks'])) {
    $showcase_blocks = array();
    foreach ($_POST['showcase_blocks'] as $index => $block) {
        // Ensure we have the required fields
        $sanitized_block = array(
            'title' => sanitize_text_field($block['title'] ?? ''),
            'description' => sanitize_textarea_field($block['description'] ?? ''),
            'media_type' => sanitize_text_field($block['media_type'] ?? 'image'),
            'image_id' => sanitize_text_field($block['image_id'] ?? ''),
            'youtube_url' => esc_url_raw($block['youtube_url'] ?? ''),
        );
        
        // Only save blocks that have at least a title or description
        if (!empty($sanitized_block['title']) || !empty($sanitized_block['description'])) {
            $showcase_blocks[$index] = $sanitized_block;
        }
    }
    
    if (!empty($showcase_blocks)) {
        update_post_meta($post_id, '_theme_showcase_blocks', $showcase_blocks);
        error_log("✅ Saved " . count($showcase_blocks) . " showcase blocks for post {$post_id}");
    } else {
        delete_post_meta($post_id, '_theme_showcase_blocks');
        error_log("🗑️ Deleted empty showcase blocks for post {$post_id}");
    }
} else {
    delete_post_meta($post_id, '_theme_showcase_blocks');
}
        
        // Save features arrays
        if (isset($_POST['theme_features']) && is_array($_POST['theme_features'])) {
            $features = array_map('sanitize_text_field', $_POST['theme_features']);
            update_post_meta($post_id, '_theme_features', $features);
            error_log("✅ Saved features: " . implode(', ', $features));
        } else {
            delete_post_meta($post_id, '_theme_features');
        }
        
        if (isset($_POST['theme_support_features']) && is_array($_POST['theme_support_features'])) {
            $support_features = array_map('sanitize_text_field', $_POST['theme_support_features']);
            update_post_meta($post_id, '_theme_support_features', $support_features);
            error_log("✅ Saved support features: " . implode(', ', $support_features));
        } else {
            delete_post_meta($post_id, '_theme_support_features');
        }
        
        error_log("🎉 Theme meta saved successfully for post {$post_id}");
        
    } catch (Exception $e) {
        error_log('❌ Error saving theme meta for post ' . $post_id . ': ' . $e->getMessage());
    }
}
add_action('save_post', 'zencommerce_save_theme_meta', 10);

// =============================================================================
// ADMIN CUSTOMIZATIONS
// =============================================================================

/**
 * Add custom columns to admin
 */
function zencommerce_theme_columns($columns) {
    $columns['theme_price'] = __('Price', 'zencommerce');
    $columns['theme_developer'] = __('Developer', 'zencommerce');
    $columns['theme_rating'] = __('Rating', 'zencommerce');
    return $columns;
}
add_filter('manage_zencommerce_theme_posts_columns', 'zencommerce_theme_columns');

/**
 * Display custom column content
 */
function zencommerce_theme_column_content($column, $post_id) {
    try {
        switch ($column) {
            case 'theme_price':
                $theme_price = get_post_meta($post_id, '_theme_price', true);
                echo $theme_price ? '$' . esc_html($theme_price) : __('Free', 'zencommerce');
                break;
            case 'theme_developer':
                $developer = get_post_meta($post_id, '_theme_developer', true);
                echo $developer ? esc_html($developer) : __('Not set', 'zencommerce');
                break;
            case 'theme_rating':
                $rating = get_post_meta($post_id, '_theme_rating', true);
                echo $rating ? esc_html($rating) . '/5' : __('Not rated', 'zencommerce');
                break;
        }
    } catch (Exception $e) {
        error_log('❌ Error displaying column content: ' . $e->getMessage());
        echo __('Error', 'zencommerce');
    }
}
add_action('manage_zencommerce_theme_posts_custom_column', 'zencommerce_theme_column_content', 10, 2);

/**
 * Admin styles for theme management
 */
function zencommerce_admin_styles() {
    $screen = get_current_screen();
    if ($screen && $screen->post_type === 'zencommerce_theme') {
        ?>
        <style>
        .zencommerce-admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .zencommerce-tips {
            background: #f0f6fc;
            border-left: 4px solid #0073aa;
            padding: 15px;
            margin: 20px 0;
        }
        </style>
        <?php
    }
}
add_action('admin_head', 'zencommerce_admin_styles');

/**
 * Add help text for theme management
 */
function zencommerce_add_help_text() {
    $screen = get_current_screen();
    if ($screen && $screen->post_type === 'zencommerce_theme' && $screen->base === 'post') {
        echo '<div class="zencommerce-tips">';
        echo '<h4>💡 Tips for Theme Management</h4>';
        echo '<ul>';
        echo '<li><strong>Featured Image:</strong> Use this as the main theme preview (recommended: 1200x800px)</li>';
        echo '<li><strong>Gallery:</strong> Add additional screenshots to showcase theme features</li>';
        echo '<li><strong>Categories:</strong> Help users find themes by organizing them properly</li>';
        echo '<li><strong>Features:</strong> Select all applicable features to improve discoverability</li>';
        echo '</ul>';
        echo '</div>';
    }
}
add_action('edit_form_after_title', 'zencommerce_add_help_text');

// =============================================================================
// SYSTEM REQUIREMENTS CHECK
// =============================================================================

/**
 * Check system requirements
 */
function zencommerce_check_requirements() {
    $errors = array();
    
    // Check PHP version
    if (version_compare(PHP_VERSION, '7.4', '<')) {
        $errors[] = 'PHP 7.4 or higher required. Current: ' . PHP_VERSION;
    }
    
    // Check memory limit
    $memory_limit = ini_get('memory_limit');
    $memory_in_bytes = wp_convert_hr_to_bytes($memory_limit);
    if ($memory_in_bytes < 128 * 1024 * 1024) {
        $errors[] = 'Memory limit too low: ' . $memory_limit . '. Recommend 128M or higher.';
    }
    
    // Check for required functions
    if (!function_exists('wp_verify_nonce')) {
        $errors[] = 'WordPress security functions not available';
    }
    
    if (!empty($errors)) {
        error_log('❌ Zencommerce Theme Requirements Check Failed:');
        foreach ($errors as $error) {
            error_log('  - ' . $error);
        }
        
        // Show admin notice
        add_action('admin_notices', function() use ($errors) {
            echo '<div class="notice notice-error"><h4>Zencommerce Theme Issues:</h4><ul>';
            foreach ($errors as $error) {
                echo '<li>' . esc_html($error) . '</li>';
            }
            echo '</ul></div>';
        });
    }
}
add_action('admin_init', 'zencommerce_check_requirements');

// =============================================================================
// ACTIVATION/DEACTIVATION
// =============================================================================

/**
 * Flush rewrite rules safely
 */
function zencommerce_flush_rewrites() {
    try {
        zencommerce_register_theme_post_type();
        zencommerce_register_theme_taxonomies();
        flush_rewrite_rules();
        error_log('✅ Rewrite rules flushed successfully');
    } catch (Exception $e) {
        error_log('❌ Error flushing rewrite rules: ' . $e->getMessage());
    }
}

/**
 * Theme activation
 */
function zencommerce_activate() {
    zencommerce_flush_rewrites();
    
    // Create default categories
    if (!term_exists('Business', 'theme_category')) {
        wp_insert_term('Business', 'theme_category');
    }
    if (!term_exists('Portfolio', 'theme_category')) {
        wp_insert_term('Portfolio', 'theme_category');
    }
    if (!term_exists('Blog', 'theme_category')) {
        wp_insert_term('Blog', 'theme_category');
    }
    
    error_log('✅ Zencommerce theme system activated');
}

/**
 * Theme deactivation
 */
function zencommerce_deactivate() {
    flush_rewrite_rules();
    error_log('✅ Zencommerce theme system deactivated');
}

// =============================================================================
// INITIALIZATION
// =============================================================================

/**
 * Safe initialization wrapper
 */
function zencommerce_safe_init() {
    try {
        // All our functions are already hooked above
        error_log('✅ Zencommerce theme system initialized successfully');
    } catch (Exception $e) {
        error_log('❌ Critical error in Zencommerce theme system: ' . $e->getMessage());
        
        // Show admin error
        add_action('admin_notices', function() use ($e) {
            echo '<div class="notice notice-error"><p>';
            echo '<strong>Zencommerce Theme Error:</strong> ' . esc_html($e->getMessage());
            echo '</p></div>';
        });
    }
}
add_action('init', 'zencommerce_safe_init', 999);

// =============================================================================
// UTILITY FUNCTIONS
// =============================================================================

/**
 * Get theme data helper function
 */
function zencommerce_get_theme_data($post_id) {
    if (!$post_id || get_post_type($post_id) !== 'zencommerce_theme') {
        return false;
    }
    
    $theme_data = array(
        'id' => $post_id,
        'title' => get_the_title($post_id),
        'description' => get_the_excerpt($post_id),
        'content' => get_the_content(null, false, $post_id),
        'featured_image' => get_the_post_thumbnail_url($post_id, 'large'),
        'price' => get_post_meta($post_id, '_theme_price', true),
        'developer' => get_post_meta($post_id, '_theme_developer', true),
        'version' => get_post_meta($post_id, '_theme_version', true),
        'demo_url' => get_post_meta($post_id, '_theme_demo_url', true),
        'download_url' => get_post_meta($post_id, '_theme_download_url', true),
        'rating' => get_post_meta($post_id, '_theme_rating', true),
        'last_updated' => get_post_meta($post_id, '_theme_last_updated', true),
        'color_variations' => get_post_meta($post_id, '_theme_color_variations', true),
        'gallery' => get_post_meta($post_id, '_theme_gallery', true),
        'features' => get_post_meta($post_id, '_theme_features', true),
        'support_features' => get_post_meta($post_id, '_theme_support_features', true),
        'showcase_blocks' => get_post_meta($post_id, '_theme_showcase_blocks', true),
        'categories' => wp_get_post_terms($post_id, 'theme_category'),
        'tags' => wp_get_post_terms($post_id, 'theme_tag'),
    );
    
    return $theme_data;
}

/**
 * Get all themes with optional filtering
 */
function zencommerce_get_themes($args = array()) {
    $default_args = array(
        'post_type' => 'zencommerce_theme',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    
    $args = wp_parse_args($args, $default_args);
    $themes = get_posts($args);
    
    $theme_data = array();
    foreach ($themes as $theme) {
        $theme_data[] = zencommerce_get_theme_data($theme->ID);
    }
    
    return $theme_data;
}

/**
 * Get themes by category
 */
function zencommerce_get_themes_by_category($category_slug, $limit = -1) {
    $args = array(
        'post_type' => 'zencommerce_theme',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'tax_query' => array(
            array(
                'taxonomy' => 'theme_category',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        ),
    );
    
    return zencommerce_get_themes($args);
}

// =============================================================================
// SHORTCODES
// =============================================================================

/**
 * Shortcode to display themes
 * Usage: [zencommerce_themes category="business" limit="6"]
 */
function zencommerce_themes_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => '',
        'limit' => -1,
        'columns' => 3,
        'show_price' => 'yes',
        'show_rating' => 'yes',
        'show_developer' => 'yes',
    ), $atts);
    
    if ($atts['category']) {
        $themes = zencommerce_get_themes_by_category($atts['category'], intval($atts['limit']));
    } else {
        $themes = zencommerce_get_themes(array('posts_per_page' => intval($atts['limit'])));
    }
    
    if (empty($themes)) {
        return '<p>No themes found.</p>';
    }
    
    ob_start();
    ?>
    <div class="zencommerce-themes-grid" style="display: grid; grid-template-columns: repeat(<?php echo intval($atts['columns']); ?>, 1fr); gap: 20px; margin: 20px 0;">
        <?php foreach ($themes as $theme): ?>
            <div class="theme-card" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: white;">
                <?php if ($theme['featured_image']): ?>
                    <img src="<?php echo esc_url($theme['featured_image']); ?>" alt="<?php echo esc_attr($theme['title']); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                <?php endif; ?>
                
                <div style="padding: 20px;">
                    <h3 style="margin: 0 0 10px 0; font-size: 18px;">
                        <?php echo esc_html($theme['title']); ?>
                    </h3>
                    
                    <?php if ($theme['description']): ?>
                        <p style="color: #666; font-size: 14px; margin: 0 0 15px 0;">
                            <?php echo esc_html($theme['description']); ?>
                        </p>
                    <?php endif; ?>
                    
                    <div class="theme-meta" style="display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #888; margin-bottom: 15px;">
                        <?php if ($atts['show_developer'] === 'yes' && $theme['developer']): ?>
                            <span>By <?php echo esc_html($theme['developer']); ?></span>
                        <?php endif; ?>
                        
                        <?php if ($atts['show_rating'] === 'yes' && $theme['rating']): ?>
                            <span>⭐ <?php echo esc_html($theme['rating']); ?>/5</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="theme-actions" style="display: flex; justify-content: space-between; align-items: center;">
                        <?php if ($atts['show_price'] === 'yes'): ?>
                            <span class="theme-price" style="font-weight: bold; color: #0073aa;">
<?php 
$price = isset($theme['price']) && !empty($theme['price']) && $theme['price'] != '0' 
    ? '$' . esc_html($theme['price']) 
    : __('Free', 'zencommerce');
echo $price;
?>
                            </span>
                        <?php endif; ?>
                        
                        <div style="display: flex; gap: 10px;">
                            <?php if ($theme['demo_url']): ?>
                                <a href="<?php echo esc_url($theme['demo_url']); ?>" target="_blank" class="button" style="font-size: 12px; padding: 5px 10px;">Demo</a>
                            <?php endif; ?>
                            
                            <?php if ($theme['download_url']): ?>
                                <a href="<?php echo esc_url($theme['download_url']); ?>" class="button button-primary" style="font-size: 12px; padding: 5px 10px;">Download</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
/**
 * Theme Store Admin Functions
 * Add this to your functions.php file or include as a separate file
 */

// Add meta boxes for theme preview images
add_action('add_meta_boxes', 'add_theme_preview_meta_boxes');
function add_theme_preview_meta_boxes() {
    add_meta_box(
        'theme-preview-images',
        'Advanced Theme Preview',
        'theme_preview_images_callback',
        'zencommerce_theme',
        'normal',
        'high'
    );
}

// Meta box callback function
function theme_preview_images_callback($post) {
    // Add nonce for security
    wp_nonce_field('theme_preview_images_nonce', 'theme_preview_images_nonce');
    
    // Get current values
    $fullpage_screenshot = get_post_meta($post->ID, '_theme_fullpage_screenshot', true);
    $mobile_screenshot = get_post_meta($post->ID, '_theme_mobile_screenshot', true);
    
    ?>
    <style>
    .theme-preview-admin {
        margin: 20px 0;
    }
    .preview-field {
        margin-bottom: 20px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 5px;
        border-left: 4px solid #0073aa;
    }
    .preview-field label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #23282d;
    }
    .preview-field .description {
        font-style: italic;
        color: #666;
        font-size: 13px;
        margin-bottom: 10px;
    }
    .preview-upload-btn {
        background: #0073aa;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 3px;
        cursor: pointer;
        margin-right: 10px;
    }
    .preview-upload-btn:hover {
        background: #005a87;
    }
    .preview-remove-btn {
        background: #dc3232;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 3px;
        cursor: pointer;
    }
    .preview-remove-btn:hover {
        background: #a31b1b;
    }
    .preview-image-container {
        margin-top: 10px;
        max-width: 300px;
    }
    .preview-image {
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .preview-notice {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 3px;
        padding: 12px;
        margin-bottom: 20px;
        color: #856404;
    }
    .preview-example {
        background: #e8f4fd;
        border: 1px solid #b8daff;
        border-radius: 3px;
        padding: 12px;
        margin-top: 10px;
        font-size: 13px;
    }
    </style>
    
    <div class="theme-preview-admin">
        <div class="preview-notice">
            <strong>Advanced Preview Mode:</strong> Upload both a full-page desktop screenshot and mobile screenshot to enable the elegant desktop + iPhone mockup preview (like Shopify). If only standard images are uploaded, the regular preview tabs will be used.
        </div>
        
        <!-- Full Page Screenshot -->
        <div class="preview-field">
            <label for="theme_fullpage_screenshot">Full Page Desktop Screenshot</label>
            <div class="description">
                Upload a complete, full-length screenshot of the desktop homepage. This should be a tall image showing the entire page from top to bottom.
            </div>
            <input type="hidden" id="theme_fullpage_screenshot" name="theme_fullpage_screenshot" value="<?php echo esc_attr($fullpage_screenshot); ?>" />
            <button type="button" class="preview-upload-btn" data-field="theme_fullpage_screenshot">
                <?php echo $fullpage_screenshot ? 'Change Image' : 'Upload Full Page Screenshot'; ?>
            </button>
            <?php if ($fullpage_screenshot): ?>
                <button type="button" class="preview-remove-btn" data-field="theme_fullpage_screenshot">Remove</button>
            <?php endif; ?>
            
            <?php if ($fullpage_screenshot): ?>
                <div class="preview-image-container">
                    <img src="<?php echo wp_get_attachment_image_url($fullpage_screenshot, 'medium'); ?>" class="preview-image" />
                </div>
            <?php endif; ?>
            
            <div class="preview-example">
                <strong>Example:</strong> Take a screenshot of the full homepage using a tool like Full Page Screen Capture browser extension. The image should be around 1200-1400px wide and quite tall (3000-5000px+).
            </div>
        </div>
        
        <!-- Mobile Screenshot -->
        <div class="preview-field">
            <label for="theme_mobile_screenshot">Mobile Screenshot</label>
            <div class="description">
                Upload a mobile homepage screenshot. This will be displayed inside an iPhone mockup.
            </div>
            <input type="hidden" id="theme_mobile_screenshot" name="theme_mobile_screenshot" value="<?php echo esc_attr($mobile_screenshot); ?>" />
            <button type="button" class="preview-upload-btn" data-field="theme_mobile_screenshot">
                <?php echo $mobile_screenshot ? 'Change Image' : 'Upload Mobile Screenshot'; ?>
            </button>
            <?php if ($mobile_screenshot): ?>
                <button type="button" class="preview-remove-btn" data-field="theme_mobile_screenshot">Remove</button>
            <?php endif; ?>
            
            <?php if ($mobile_screenshot): ?>
                <div class="preview-image-container">
                    <img src="<?php echo wp_get_attachment_image_url($mobile_screenshot, 'medium'); ?>" class="preview-image" />
                </div>
            <?php endif; ?>
            
            <div class="preview-example">
                <strong>Example:</strong> Take a screenshot on mobile device or use browser dev tools mobile view. Ideal size is around 375-414px wide. The image will be cropped to fit the iPhone screen proportions.
            </div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Media uploader
        $('.preview-upload-btn').click(function(e) {
            e.preventDefault();
            
            var button = $(this);
            var fieldId = button.data('field');
            var field = $('#' + fieldId);
            
            var mediaUploader = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use This Image'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                field.val(attachment.id);
                
                // Update button text
                button.text('Change Image');
                
                // Add remove button if it doesn't exist
                if (!button.siblings('.preview-remove-btn').length) {
                    button.after('<button type="button" class="preview-remove-btn" data-field="' + fieldId + '">Remove</button>');
                }
                
                // Add/update preview image
                var container = button.closest('.preview-field').find('.preview-image-container');
                if (container.length) {
                    container.find('img').attr('src', attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url);
                } else {
                    button.closest('.preview-field').append(
                        '<div class="preview-image-container"><img src="' + 
                        (attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url) + 
                        '" class="preview-image" /></div>'
                    );
                }
            });
            
            mediaUploader.open();
        });
        
        // Remove image
        $(document).on('click', '.preview-remove-btn', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var fieldId = button.data('field');
            var field = $('#' + fieldId);
            var uploadBtn = button.siblings('.preview-upload-btn');
            
            // Clear field
            field.val('');
            
            // Update button text
            uploadBtn.text(uploadBtn.text().includes('fullpage') ? 'Upload Full Page Screenshot' : 'Upload Mobile Screenshot');
            
            // Remove remove button and preview
            button.remove();
            button.closest('.preview-field').find('.preview-image-container').remove();
        });
    });
    </script>
    <?php
}

// Save meta box data
add_action('save_post', 'save_theme_preview_images');
function save_theme_preview_images($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['theme_preview_images_nonce']) || !wp_verify_nonce($_POST['theme_preview_images_nonce'], 'theme_preview_images_nonce')) {
        return;
    }

    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if this is the right post type
    if (get_post_type($post_id) !== 'zencommerce_theme') {
        return;
    }

    // Save the full page screenshot
    if (isset($_POST['theme_fullpage_screenshot'])) {
        $fullpage_screenshot = sanitize_text_field($_POST['theme_fullpage_screenshot']);
        if (!empty($fullpage_screenshot)) {
            update_post_meta($post_id, '_theme_fullpage_screenshot', $fullpage_screenshot);
        } else {
            delete_post_meta($post_id, '_theme_fullpage_screenshot');
        }
    }

    // Save the mobile screenshot
    if (isset($_POST['theme_mobile_screenshot'])) {
        $mobile_screenshot = sanitize_text_field($_POST['theme_mobile_screenshot']);
        if (!empty($mobile_screenshot)) {
            update_post_meta($post_id, '_theme_mobile_screenshot', $mobile_screenshot);
        } else {
            delete_post_meta($post_id, '_theme_mobile_screenshot');
        }
    }
}

// Add admin column to show preview type
add_filter('manage_zencommerce_theme_posts_columns', 'add_theme_preview_column');
function add_theme_preview_column($columns) {
    $columns['preview_type'] = 'Preview Type';
    return $columns;
}

add_action('manage_zencommerce_theme_posts_custom_column', 'show_theme_preview_column', 10, 2);
function show_theme_preview_column($column, $post_id) {
    if ($column === 'preview_type') {
        $fullpage = get_post_meta($post_id, '_theme_fullpage_screenshot', true);
        $mobile = get_post_meta($post_id, '_theme_mobile_screenshot', true);
        
        if (!empty($fullpage) && !empty($mobile)) {
            echo '<span style="color: #0073aa; font-weight: 600;">✨ Advanced Preview</span>';
        } else {
            echo '<span style="color: #666;">📱 Standard Preview</span>';
        }
    }
}

// Add quick edit support
add_action('quick_edit_custom_box', 'theme_preview_quick_edit', 10, 2);
function theme_preview_quick_edit($column_name, $post_type) {
    if ($column_name === 'preview_type' && $post_type === 'zencommerce_theme') {
        ?>
        <fieldset class="inline-edit-col-right">
            <div class="inline-edit-col">
                <label>
                    <span class="title">Preview Type</span>
                    <span class="input-text-wrap">
                        <em>Use "Edit" to change preview images</em>
                    </span>
                </label>
            </div>
        </fieldset>
        <?php
    }
}

// Enqueue media uploader on theme edit page
add_action('admin_enqueue_scripts', 'enqueue_theme_preview_scripts');
function enqueue_theme_preview_scripts($hook) {
    global $post_type;
    
    if ($post_type === 'zencommerce_theme' && ($hook === 'post.php' || $hook === 'post-new.php')) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}

// Add help text to the theme edit screen
add_action('admin_notices', 'theme_preview_admin_notice');
function theme_preview_admin_notice() {
    global $post_type, $pagenow;
    
    if ($post_type === 'zencommerce_theme' && ($pagenow === 'post.php' || $pagenow === 'post-new.php')) {
        ?>
        <div class="notice notice-info">
            <p><strong>💡 Tip:</strong> For the best preview experience, upload both a full-page desktop screenshot and mobile screenshot in the "Advanced Theme Preview" section below. This will create an elegant preview similar to Shopify's theme store.</p>
        </div>
        <?php
    }
}

// Add bulk action to convert themes to advanced preview
add_filter('bulk_actions-edit-zencommerce_theme', 'add_theme_preview_bulk_actions');
function add_theme_preview_bulk_actions($bulk_actions) {
    $bulk_actions['check_preview_status'] = 'Check Preview Status';
    return $bulk_actions;
}

add_filter('handle_bulk_actions-edit-zencommerce_theme', 'handle_theme_preview_bulk_actions', 10, 3);
function handle_theme_preview_bulk_actions($redirect_to, $doaction, $post_ids) {
    if ($doaction !== 'check_preview_status') {
        return $redirect_to;
    }

    $processed = 0;
    $advanced = 0;
    
    foreach ($post_ids as $post_id) {
        $fullpage = get_post_meta($post_id, '_theme_fullpage_screenshot', true);
        $mobile = get_post_meta($post_id, '_theme_mobile_screenshot', true);
        
        if (!empty($fullpage) && !empty($mobile)) {
            $advanced++;
        }
        $processed++;
    }

    $redirect_to = add_query_arg(array(
        'preview_checked' => $processed,
        'advanced_previews' => $advanced
    ), $redirect_to);

    return $redirect_to;
}

add_action('admin_notices', 'theme_preview_bulk_action_notices');
function theme_preview_bulk_action_notices() {
    if (!empty($_REQUEST['preview_checked'])) {
        $processed = intval($_REQUEST['preview_checked']);
        $advanced = intval($_REQUEST['advanced_previews']);
        $standard = $processed - $advanced;
        
        printf(
            '<div class="notice notice-success is-dismissible"><p>Preview status checked for %d themes: <strong>%d advanced previews</strong>, %d standard previews</p></div>',
            $processed,
            $advanced,
            $standard
        );
    }
}
add_shortcode('zencommerce_themes', 'zencommerce_themes_shortcode');