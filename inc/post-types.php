<?php
/**
 * Custom post types
 */

if (!defined('ABSPATH')) {
    exit;
}
/**
 * Register Guide Post Type
 */
function yoursite_register_guide_post_type() {
    $labels = array(
        'name'                  => _x('Guides', 'Post type general name', 'yoursite'),
        'singular_name'         => _x('Guide', 'Post type singular name', 'yoursite'),
        'menu_name'             => _x('Guides', 'Admin Menu text', 'yoursite'),
        'name_admin_bar'        => _x('Guide', 'Add New on Toolbar', 'yoursite'),
        'add_new'               => __('Add New', 'yoursite'),
        'add_new_item'          => __('Add New Guide', 'yoursite'),
        'new_item'              => __('New Guide', 'yoursite'),
        'edit_item'             => __('Edit Guide', 'yoursite'),
        'view_item'             => __('View Guide', 'yoursite'),
        'all_items'             => __('All Guides', 'yoursite'),
        'search_items'          => __('Search Guides', 'yoursite'),
        'parent_item_colon'     => __('Parent Guides:', 'yoursite'),
        'not_found'             => __('No guides found.', 'yoursite'),
        'not_found_in_trash'    => __('No guides found in Trash.', 'yoursite'),
        'featured_image'        => _x('Guide Cover Image', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'yoursite'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type. Added in 4.3', 'yoursite'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase for this post type. Added in 4.3', 'yoursite'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the "Use as featured image" phrase for this post type. Added in 4.3', 'yoursite'),
        'archives'              => _x('Guide archives', 'The post type archive label used in nav menus. Default "Post Archives". Added in 4.4', 'yoursite'),
        'insert_into_item'      => _x('Insert into guide', 'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post). Added in 4.4', 'yoursite'),
        'uploaded_to_this_item' => _x('Uploaded to this guide', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post). Added in 4.4', 'yoursite'),
        'filter_items_list'     => _x('Filter guides list', 'Screen reader text for the filter links heading on the post type listing screen. Default "Filter posts list"/"Filter pages list". Added in 4.4', 'yoursite'),
        'items_list_navigation' => _x('Guides list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default "Posts list navigation"/"Pages list navigation". Added in 4.4', 'yoursite'),
        'items_list'            => _x('Guides list', 'Screen reader text for the items list heading on the post type listing screen. Default "Posts list"/"Pages list". Added in 4.4', 'yoursite'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true, // Enable Gutenberg editor
        'query_var'          => true,
        'rewrite'            => array('slug' => 'guides'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments', 'revisions', 'custom-fields'),
        'taxonomies'         => array('guide_category', 'guide_tag'),
        'show_in_nav_menus'  => true,
        'can_export'         => true,
    );

    register_post_type('guide', $args);
}
add_action('init', 'yoursite_register_guide_post_type');

/**
 * Register Guide Categories Taxonomy
 */
function yoursite_register_guide_taxonomy() {
    // Guide Categories
    $category_labels = array(
        'name'                       => _x('Guide Categories', 'Taxonomy General Name', 'yoursite'),
        'singular_name'              => _x('Guide Category', 'Taxonomy Singular Name', 'yoursite'),
        'menu_name'                  => __('Categories', 'yoursite'),
        'all_items'                  => __('All Categories', 'yoursite'),
        'parent_item'                => __('Parent Category', 'yoursite'),
        'parent_item_colon'          => __('Parent Category:', 'yoursite'),
        'new_item_name'              => __('New Category Name', 'yoursite'),
        'add_new_item'               => __('Add New Category', 'yoursite'),
        'edit_item'                  => __('Edit Category', 'yoursite'),
        'update_item'                => __('Update Category', 'yoursite'),
        'view_item'                  => __('View Category', 'yoursite'),
        'separate_items_with_commas' => __('Separate categories with commas', 'yoursite'),
        'add_or_remove_items'        => __('Add or remove categories', 'yoursite'),
        'choose_from_most_used'      => __('Choose from the most used', 'yoursite'),
        'popular_items'              => __('Popular Categories', 'yoursite'),
        'search_items'               => __('Search Categories', 'yoursite'),
        'not_found'                  => __('Not Found', 'yoursite'),
        'no_terms'                   => __('No categories', 'yoursite'),
        'items_list'                 => __('Categories list', 'yoursite'),
        'items_list_navigation'      => __('Categories list navigation', 'yoursite'),
    );

    $category_args = array(
        'labels'                     => $category_labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'guides/category'),
    );

    register_taxonomy('guide_category', array('guide'), $category_args);

    // Guide Tags
    $tag_labels = array(
        'name'                       => _x('Guide Tags', 'Taxonomy General Name', 'yoursite'),
        'singular_name'              => _x('Guide Tag', 'Taxonomy Singular Name', 'yoursite'),
        'menu_name'                  => __('Tags', 'yoursite'),
        'all_items'                  => __('All Tags', 'yoursite'),
        'new_item_name'              => __('New Tag Name', 'yoursite'),
        'add_new_item'               => __('Add New Tag', 'yoursite'),
        'edit_item'                  => __('Edit Tag', 'yoursite'),
        'update_item'                => __('Update Tag', 'yoursite'),
        'view_item'                  => __('View Tag', 'yoursite'),
        'separate_items_with_commas' => __('Separate tags with commas', 'yoursite'),
        'add_or_remove_items'        => __('Add or remove tags', 'yoursite'),
        'choose_from_most_used'      => __('Choose from the most used', 'yoursite'),
        'popular_items'              => __('Popular Tags', 'yoursite'),
        'search_items'               => __('Search Tags', 'yoursite'),
        'not_found'                  => __('Not Found', 'yoursite'),
        'no_terms'                   => __('No tags', 'yoursite'),
        'items_list'                 => __('Tags list', 'yoursite'),
        'items_list_navigation'      => __('Tags list navigation', 'yoursite'),
    );

    $tag_args = array(
        'labels'                     => $tag_labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'guides/tag'),
    );

    register_taxonomy('guide_tag', array('guide'), $tag_args);
}
add_action('init', 'yoursite_register_guide_taxonomy');

/**
 * Add default guide categories on theme activation
 */
function yoursite_create_default_guide_categories() {
    if (!term_exists('Getting Started', 'guide_category')) {
        wp_insert_term('Getting Started', 'guide_category', array(
            'description' => 'Learn the basics of setting up your online store',
            'slug'        => 'getting-started'
        ));
    }

    if (!term_exists('Design & Customization', 'guide_category')) {
        wp_insert_term('Design & Customization', 'guide_category', array(
            'description' => 'Make your store unique with custom designs and branding',
            'slug'        => 'design'
        ));
    }

    if (!term_exists('Product Management', 'guide_category')) {
        wp_insert_term('Product Management', 'guide_category', array(
            'description' => 'Add, organize, and optimize your product catalog',
            'slug'        => 'products'
        ));
    }

    if (!term_exists('Marketing & SEO', 'guide_category')) {
        wp_insert_term('Marketing & SEO', 'guide_category', array(
            'description' => 'Drive traffic and sales with proven marketing strategies',
            'slug'        => 'marketing'
        ));
    }

    if (!term_exists('Payments & Checkout', 'guide_category')) {
        wp_insert_term('Payments & Checkout', 'guide_category', array(
            'description' => 'Set up secure payments and optimize your checkout process',
            'slug'        => 'payments'
        ));
    }

    if (!term_exists('Analytics & Reports', 'guide_category')) {
        wp_insert_term('Analytics & Reports', 'guide_category', array(
            'description' => 'Track performance and make data-driven decisions',
            'slug'        => 'analytics'
        ));
    }
}
add_action('after_switch_theme', 'yoursite_create_default_guide_categories');

/**
 * Update post type messages
 */
function yoursite_guide_updated_messages($messages) {
    $post             = get_post();
    $post_type        = get_post_type($post);
    $post_type_object = get_post_type_object($post_type);

    $messages['guide'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => __('Guide updated.', 'yoursite'),
        2  => __('Custom field updated.', 'yoursite'),
        3  => __('Custom field deleted.', 'yoursite'),
        4  => __('Guide updated.', 'yoursite'),
        /* translators: %s: date and time of the revision */
        5  => isset($_GET['revision']) ? sprintf(__('Guide restored to revision from %s', 'yoursite'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6  => __('Guide published.', 'yoursite'),
        7  => __('Guide saved.', 'yoursite'),
        8  => __('Guide submitted.', 'yoursite'),
        9  => sprintf(
            __('Guide scheduled for: <strong>%1$s</strong>.', 'yoursite'),
            // translators: Publish box date format, see https://secure.php.net/date
            date_i18n(__('M j, Y @ G:i', 'yoursite'), strtotime($post->post_date))
        ),
        10 => __('Guide draft updated.', 'yoursite')
    );

    if ($post_type_object->publicly_queryable && 'guide' === $post_type) {
        $permalink = get_permalink($post->ID);

        $view_link = sprintf(' <a href="%s">%s</a>', esc_url($permalink), __('View guide', 'yoursite'));
        $messages[$post_type][1] .= $view_link;
        $messages[$post_type][6] .= $view_link;
        $messages[$post_type][9] .= $view_link;

        $preview_permalink = add_query_arg('preview', 'true', $permalink);
        $preview_link = sprintf(' <a target="_blank" href="%s">%s</a>', esc_url($preview_permalink), __('Preview guide', 'yoursite'));
        $messages[$post_type][8]  .= $preview_link;
        $messages[$post_type][10] .= $preview_link;
    }

    return $messages;
}
add_filter('post_updated_messages', 'yoursite_guide_updated_messages');

/**
 * Register all custom post types
 */
function yoursite_register_post_types() {
    yoursite_create_features_post_type();
    yoursite_create_integrations_post_type();
    yoursite_create_testimonials_post_type();
    yoursite_create_pricing_post_type();
    yoursite_create_webinars_post_type();
    yoursite_create_jobs_post_type();
    yoursite_create_case_studies_post_type();
    yoursite_create_partners_post_type();
}
add_action('init', 'yoursite_register_post_types');

/**
 * Custom post type for job listings
 */
function yoursite_create_jobs_post_type() {
    register_post_type('jobs', array(
        'labels' => array(
            'name' => __('Job Listings', 'yoursite'),
            'singular_name' => __('Job', 'yoursite'),
            'add_new_item' => __('Add New Job', 'yoursite'),
            'edit_item' => __('Edit Job', 'yoursite'),
            'view_item' => __('View Job', 'yoursite'),
            'all_items' => __('All Jobs', 'yoursite'),
            'search_items' => __('Search Jobs', 'yoursite'),
            'not_found' => __('No jobs found', 'yoursite'),
            'not_found_in_trash' => __('No jobs found in trash', 'yoursite'),
            'menu_name' => __('Careers', 'yoursite')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-businesswoman',
        'supports' => array('title', 'editor', 'excerpt'),
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'job',
            'with_front' => false
        ),
        'menu_position' => 7,
        'capability_type' => 'post',
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'can_export' => true,
        'exclude_from_search' => false,
        'taxonomies' => array('job_department', 'job_type', 'job_location')
    ));
    
    // Register taxonomies for job organization
    register_taxonomy('job_department', 'jobs', array(
        'labels' => array(
            'name' => __('Departments', 'yoursite'),
            'singular_name' => __('Department', 'yoursite'),
            'search_items' => __('Search Departments', 'yoursite'),
            'all_items' => __('All Departments', 'yoursite'),
            'edit_item' => __('Edit Department', 'yoursite'),
            'update_item' => __('Update Department', 'yoursite'),
            'add_new_item' => __('Add New Department', 'yoursite'),
            'new_item_name' => __('New Department Name', 'yoursite'),
            'menu_name' => __('Departments', 'yoursite'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job-department'),
        'show_in_rest' => true,
    ));
    
    register_taxonomy('job_type', 'jobs', array(
        'labels' => array(
            'name' => __('Job Types', 'yoursite'),
            'singular_name' => __('Job Type', 'yoursite'),
            'menu_name' => __('Job Types', 'yoursite'),
        ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job-type'),
        'show_in_rest' => true,
    ));
    
    register_taxonomy('job_location', 'jobs', array(
        'labels' => array(
            'name' => __('Locations', 'yoursite'),
            'singular_name' => __('Location', 'yoursite'),
            'menu_name' => __('Locations', 'yoursite'),
        ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job-location'),
        'show_in_rest' => true,
    ));
}

/**
 * Custom post type for partner applications
 */
function yoursite_create_partners_post_type() {
    register_post_type('partner_applications', array(
        'labels' => array(
            'name' => __('Partner Applications', 'yoursite'),
            'singular_name' => __('Partner Application', 'yoursite'),
            'add_new_item' => __('Add New Application', 'yoursite'),
            'edit_item' => __('Edit Application', 'yoursite'),
            'view_item' => __('View Application', 'yoursite'),
            'all_items' => __('All Applications', 'yoursite'),
            'search_items' => __('Search Applications', 'yoursite'),
            'not_found' => __('No applications found', 'yoursite'),
            'not_found_in_trash' => __('No applications found in trash', 'yoursite'),
            'menu_name' => __('Partner Applications', 'yoursite')
        ),
        'public' => false,
        'has_archive' => false,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title'),
        'show_in_rest' => false,
        'menu_position' => 8,
        'capability_type' => 'post',
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'can_export' => true,
        'exclude_from_search' => true
    ));
}

/**
 * Custom post type for integrations
 */
function yoursite_create_integrations_post_type() {
    register_post_type('integrations', array(
        'labels' => array(
            'name' => __('Integrations', 'yoursite'),
            'singular_name' => __('Integration', 'yoursite'),
            'add_new_item' => __('Add New Integration', 'yoursite'),
            'edit_item' => __('Edit Integration', 'yoursite'),
            'view_item' => __('View Integration', 'yoursite'),
            'all_items' => __('All Integrations', 'yoursite'),
            'search_items' => __('Search Integrations', 'yoursite'),
            'not_found' => __('No integrations found', 'yoursite'),
            'not_found_in_trash' => __('No integrations found in trash', 'yoursite'),
            'menu_name' => __('Integrations', 'yoursite')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-plugins',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'integration',
            'with_front' => false
        ),
        'menu_position' => 6,
        'capability_type' => 'post',
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'can_export' => true,
        'exclude_from_search' => false,
        'taxonomies' => array('integration_category')
    ));
    
    // Register taxonomy for integration categories
    register_taxonomy('integration_category', 'integrations', array(
        'labels' => array(
            'name' => __('Integration Categories', 'yoursite'),
            'singular_name' => __('Integration Category', 'yoursite'),
            'search_items' => __('Search Categories', 'yoursite'),
            'all_items' => __('All Categories', 'yoursite'),
            'edit_item' => __('Edit Category', 'yoursite'),
            'update_item' => __('Update Category', 'yoursite'),
            'add_new_item' => __('Add New Category', 'yoursite'),
            'new_item_name' => __('New Category Name', 'yoursite'),
            'menu_name' => __('Categories', 'yoursite'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'integration-category'),
        'show_in_rest' => true,
    ));
}

/**
 * Custom post type for features
 */
function yoursite_create_features_post_type() {
    register_post_type('features', array(
        'labels' => array(
            'name' => __('Features', 'yoursite'),
            'singular_name' => __('Feature', 'yoursite'),
            'add_new_item' => __('Add New Feature', 'yoursite'),
            'edit_item' => __('Edit Feature', 'yoursite'),
            'view_item' => __('View Feature', 'yoursite'),
            'all_items' => __('All Features', 'yoursite'),
            'search_items' => __('Search Features', 'yoursite'),
            'not_found' => __('No features found', 'yoursite'),
            'not_found_in_trash' => __('No features found in trash', 'yoursite'),
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'feature'),
    ));
}

/**
 * Custom post type for testimonials
 */
function yoursite_create_testimonials_post_type() {
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => __('Testimonials', 'yoursite'),
            'singular_name' => __('Testimonial', 'yoursite'),
            'add_new_item' => __('Add New Testimonial', 'yoursite'),
            'edit_item' => __('Edit Testimonial', 'yoursite'),
            'view_item' => __('View Testimonial', 'yoursite'),
            'all_items' => __('All Testimonials', 'yoursite'),
            'search_items' => __('Search Testimonials', 'yoursite'),
            'not_found' => __('No testimonials found', 'yoursite'),
            'not_found_in_trash' => __('No testimonials found in trash', 'yoursite'),
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'testimonial'),
    ));
}

/**
 * Custom post type for pricing plans
 */
function yoursite_create_pricing_post_type() {
    register_post_type('pricing', array(
        'labels' => array(
            'name' => __('Pricing Plans', 'yoursite'),
            'singular_name' => __('Pricing Plan', 'yoursite'),
            'add_new_item' => __('Add New Plan', 'yoursite'),
            'edit_item' => __('Edit Plan', 'yoursite'),
            'view_item' => __('View Plan', 'yoursite'),
            'all_items' => __('All Plans', 'yoursite'),
            'search_items' => __('Search Plans', 'yoursite'),
            'not_found' => __('No plans found', 'yoursite'),
            'not_found_in_trash' => __('No plans found in trash', 'yoursite'),
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-cart',
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'pricing-plan'),
    ));
}

/**
 * Custom post type for webinars
 */
function yoursite_create_webinars_post_type() {
    register_post_type('webinars', array(
        'labels' => array(
            'name' => __('Webinars', 'yoursite'),
            'singular_name' => __('Webinar', 'yoursite'),
            'add_new_item' => __('Add New Webinar', 'yoursite'),
            'edit_item' => __('Edit Webinar', 'yoursite'),
            'view_item' => __('View Webinar', 'yoursite'),
            'all_items' => __('All Webinars', 'yoursite'),
            'search_items' => __('Search Webinars', 'yoursite'),
            'not_found' => __('No webinars found', 'yoursite'),
            'not_found_in_trash' => __('No webinars found in trash', 'yoursite'),
            'menu_name' => __('Webinars', 'yoursite')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'webinar',
            'with_front' => false
        ),
        'menu_position' => 5,
        'capability_type' => 'post',
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'can_export' => true,
        'exclude_from_search' => false,
    ));
}

/**
 * Custom post type for case studies
 */
function yoursite_create_case_studies_post_type() {
    register_post_type('case_studies', array(
        'labels' => array(
            'name' => __('Case Studies', 'yoursite'),
            'singular_name' => __('Case Study', 'yoursite'),
            'add_new_item' => __('Add New Case Study', 'yoursite'),
            'edit_item' => __('Edit Case Study', 'yoursite'),
            'view_item' => __('View Case Study', 'yoursite'),
            'all_items' => __('All Case Studies', 'yoursite'),
            'search_items' => __('Search Case Studies', 'yoursite'),
            'not_found' => __('No case studies found', 'yoursite'),
            'not_found_in_trash' => __('No case studies found in trash', 'yoursite'),
            'menu_name' => __('Case Studies', 'yoursite')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'case-study',
            'with_front' => false
        ),
        'menu_position' => 9,
        'capability_type' => 'post',
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'can_export' => true,
        'exclude_from_search' => false,
        'taxonomies' => array('case_study_industry', 'case_study_service')
    ));
    
    // Register taxonomy for industries
    register_taxonomy('case_study_industry', 'case_studies', array(
        'labels' => array(
            'name' => __('Industries', 'yoursite'),
            'singular_name' => __('Industry', 'yoursite'),
            'search_items' => __('Search Industries', 'yoursite'),
            'all_items' => __('All Industries', 'yoursite'),
            'edit_item' => __('Edit Industry', 'yoursite'),
            'update_item' => __('Update Industry', 'yoursite'),
            'add_new_item' => __('Add New Industry', 'yoursite'),
            'new_item_name' => __('New Industry Name', 'yoursite'),
            'menu_name' => __('Industries', 'yoursite'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'case-study-industry'),
        'show_in_rest' => true,
    ));
    
    // Register taxonomy for services
    register_taxonomy('case_study_service', 'case_studies', array(
        'labels' => array(
            'name' => __('Services', 'yoursite'),
            'singular_name' => __('Service', 'yoursite'),
            'menu_name' => __('Services', 'yoursite'),
        ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'case-study-service'),
        'show_in_rest' => true,
    ));
}

// Add Custom Meta Boxes for Case Study Details
function add_case_study_meta_boxes() {
    add_meta_box(
        'case_study_details',
        'Case Study Details',
        'case_study_details_callback',
        'case_studies',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_case_study_meta_boxes');

// Meta Box Callback Function
function case_study_details_callback($post) {
    wp_nonce_field('case_study_details_nonce', 'case_study_details_nonce');
    
    $client_name = get_post_meta($post->ID, '_case_study_client', true);
    $industry = get_post_meta($post->ID, '_case_study_industry', true);
    $project_duration = get_post_meta($post->ID, '_case_study_duration', true);
    $challenge = get_post_meta($post->ID, '_case_study_challenge', true);
    $solution = get_post_meta($post->ID, '_case_study_solution', true);
    $results = get_post_meta($post->ID, '_case_study_results', true);
    $testimonial = get_post_meta($post->ID, '_case_study_testimonial', true);
    $testimonial_author = get_post_meta($post->ID, '_case_study_testimonial_author', true);
    $project_url = get_post_meta($post->ID, '_case_study_url', true);
    $technologies = get_post_meta($post->ID, '_case_study_technologies', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="case_study_client">Client Name</label></th>
            <td><input type="text" id="case_study_client" name="case_study_client" value="<?php echo esc_attr($client_name); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="case_study_industry">Industry</label></th>
            <td><input type="text" id="case_study_industry" name="case_study_industry" value="<?php echo esc_attr($industry); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="case_study_duration">Project Duration</label></th>
            <td><input type="text" id="case_study_duration" name="case_study_duration" value="<?php echo esc_attr($project_duration); ?>" style="width: 100%;" placeholder="e.g., 3 months" /></td>
        </tr>
        <tr>
            <th><label for="case_study_technologies">Technologies Used</label></th>
            <td><input type="text" id="case_study_technologies" name="case_study_technologies" value="<?php echo esc_attr($technologies); ?>" style="width: 100%;" placeholder="e.g., WordPress, React, PHP" /></td>
        </tr>
        <tr>
            <th><label for="case_study_url">Project URL</label></th>
            <td><input type="url" id="case_study_url" name="case_study_url" value="<?php echo esc_attr($project_url); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="case_study_challenge">Challenge</label></th>
            <td><textarea id="case_study_challenge" name="case_study_challenge" rows="4" style="width: 100%;"><?php echo esc_textarea($challenge); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="case_study_solution">Solution</label></th>
            <td><textarea id="case_study_solution" name="case_study_solution" rows="4" style="width: 100%;"><?php echo esc_textarea($solution); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="case_study_results">Results</label></th>
            <td><textarea id="case_study_results" name="case_study_results" rows="4" style="width: 100%;"><?php echo esc_textarea($results); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="case_study_testimonial">Client Testimonial</label></th>
            <td><textarea id="case_study_testimonial" name="case_study_testimonial" rows="3" style="width: 100%;"><?php echo esc_textarea($testimonial); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="case_study_testimonial_author">Testimonial Author</label></th>
            <td><input type="text" id="case_study_testimonial_author" name="case_study_testimonial_author" value="<?php echo esc_attr($testimonial_author); ?>" style="width: 100%;" placeholder="Name, Title, Company" /></td>
        </tr>
    </table>
    <?php
}

// Save Meta Box Data
function save_case_study_meta($post_id) {
    if (!isset($_POST['case_study_details_nonce']) || !wp_verify_nonce($_POST['case_study_details_nonce'], 'case_study_details_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'case_study_client' => '_case_study_client',
        'case_study_industry' => '_case_study_industry',
        'case_study_duration' => '_case_study_duration',
        'case_study_challenge' => '_case_study_challenge',
        'case_study_solution' => '_case_study_solution',
        'case_study_results' => '_case_study_results',
        'case_study_testimonial' => '_case_study_testimonial',
        'case_study_testimonial_author' => '_case_study_testimonial_author',
        'case_study_url' => '_case_study_url',
        'case_study_technologies' => '_case_study_technologies'
    );
    
    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_case_study_meta');

// Add custom columns to Case Studies admin list
function case_study_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['client'] = __('Client');
    $new_columns['industry'] = __('Industry');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_case_studies_posts_columns', 'case_study_admin_columns');

function case_study_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'client':
            echo get_post_meta($post_id, '_case_study_client', true);
            break;
        case 'industry':
            echo get_post_meta($post_id, '_case_study_industry', true);
            break;
    }
}
add_action('manage_case_studies_posts_custom_column', 'case_study_admin_column_content', 10, 2);

/**
 * Consolidated flush rewrite rules function - called on theme activation and when needed
 */
function yoursite_flush_rewrites() {
    // Register all post types and taxonomies
    yoursite_register_guide_post_type();
    yoursite_register_guide_taxonomy();
    yoursite_register_post_types();
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'yoursite_flush_rewrites');

/**
 * Force flush rewrite rules if URLs are not working
 */
function yoursite_check_rewrites() {
    if (get_option('yoursite_flush_rewrites_flag')) {
        flush_rewrite_rules();
        delete_option('yoursite_flush_rewrites_flag');
    }
}
add_action('init', 'yoursite_check_rewrites');

/**
 * Set flag to flush rewrite rules
 */
function yoursite_set_flush_rewrites_flag() {
    add_option('yoursite_flush_rewrites_flag', true);
}

/**
 * Manual flush function for admin
 */
function yoursite_manual_flush_rewrites() {
    if (current_user_can('manage_options') && isset($_GET['flush_rewrites']) && $_GET['flush_rewrites'] === '1') {
        flush_rewrite_rules();
        wp_redirect(admin_url('edit.php?flushed=1'));
        exit;
    }
}
add_action('admin_init', 'yoursite_manual_flush_rewrites');

?>