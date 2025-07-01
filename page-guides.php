<?php
/**
 * Template Name: Guides Page
 * Custom page template for guides and tutorials using the guide post type
 * Save as: page-guides.php
 */

get_header(); 

// Check if guide post type exists
$guide_post_type_exists = post_type_exists('guide');
$guide_taxonomy_exists = taxonomy_exists('guide_category');

// Show admin notice if guide system isn't set up
if (current_user_can('manage_options') && (!$guide_post_type_exists || !$guide_taxonomy_exists)) {
    echo '<div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">';
    echo '<div class="flex">';
    echo '<div class="flex-shrink-0">';
    echo '<svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">';
    echo '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>';
    echo '</svg>';
    echo '</div>';
    echo '<div class="ml-3">';
    echo '<p class="text-sm text-yellow-700">';
    echo '<strong>Admin Notice:</strong> The Guide system is not fully activated yet. ';
    if (!$guide_post_type_exists) {
        echo 'The Guide post type needs to be registered. ';
    }
    if (!$guide_taxonomy_exists) {
        echo 'The Guide Categories taxonomy needs to be set up. ';
    }
    echo 'Please ensure the inc/post-types.php file has been updated with the guide post type and taxonomy definitions.';
    echo '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

// Get guide categories (using custom taxonomy)
$guide_categories = array();
if ($guide_taxonomy_exists) {
    $guide_categories = get_terms(array(
        'taxonomy' => 'guide_category',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC'
    ));
    if (is_wp_error($guide_categories)) {
        $guide_categories = array();
    }
}

// Get featured guides (guides with featured meta field)
$featured_guides = array();
if ($guide_post_type_exists) {
    $featured_guides = get_posts(array(
        'post_type' => 'guide',
        'posts_per_page' => 3,
        'meta_query' => array(
            array(
                'key' => '_featured_guide',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    
    if (is_wp_error($featured_guides)) {
        $featured_guides = array();
    }
    
    // If no featured guides, get recent ones
    if (empty($featured_guides)) {
        $featured_guides = get_posts(array(
            'post_type' => 'guide',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        if (is_wp_error($featured_guides)) {
            $featured_guides = array();
        }
    }
}

// Get all guides for stats
$all_guides = array();
if ($guide_post_type_exists) {
    $all_guides = get_posts(array(
        'post_type' => 'guide',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));
    
    if (is_wp_error($all_guides)) {
        $all_guides = array();
    }
}

?>

<!-- Hero Section -->
<section class="hero-gradient text-white py-20 lg:py-32">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                Complete Platform Guides
            </h1>
            <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
                Master every aspect of building and growing your online store with our comprehensive step-by-step tutorials and expert guides.
            </p>
            
            <!-- Hero Stats -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2"><?php echo count($all_guides); ?>+</div>
                    <div class="text-white/80">Step-by-Step Guides</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2"><?php echo count($guide_categories); ?>+</div>
                    <div class="text-white/80">Topics Covered</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
                    <div class="text-3xl font-bold mb-2">Free</div>
                    <div class="text-white/80">Always Updated</div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#featured-guides" class="btn-primary text-lg px-8 py-4 bg-white text-blue-600 hover:bg-gray-100 rounded-lg font-semibold">
                    Browse Guides
                </a>
                <a href="#search-guides" class="btn-secondary text-lg px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-blue-600 rounded-lg font-semibold">
                    Search Topics
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Quick Start Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Quick Start Guide</h2>
                <p class="text-xl text-gray-600">Get your online store up and running in just 4 simple steps</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-6 relative">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Create Account</h3>
                    <p class="text-gray-600 mb-4">Sign up for your free account and choose your plan</p>
                    <a href="<?php echo get_post_type_archive_link('guide'); ?>?category=getting-started" class="text-blue-600 hover:text-blue-800 font-medium">Read Guide →</a>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-6 relative">
                        <span class="text-2xl font-bold text-green-600">2</span>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-600 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M15 5l3 3m-3-3l3 3"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Choose Template</h3>
                    <p class="text-gray-600 mb-4">Select from our professional store templates</p>
                    <a href="<?php echo get_post_type_archive_link('guide'); ?>?category=design" class="text-blue-600 hover:text-blue-800 font-medium">Read Guide →</a>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-6 relative">
                        <span class="text-2xl font-bold text-purple-600">3</span>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-purple-600 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Add Products</h3>
                    <p class="text-gray-600 mb-4">Upload your products with photos and descriptions</p>
                    <a href="<?php echo get_post_type_archive_link('guide'); ?>?category=products" class="text-blue-600 hover:text-blue-800 font-medium">Read Guide →</a>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-6 relative">
                        <span class="text-2xl font-bold text-orange-600">4</span>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-orange-600 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Launch Store</h3>
                    <p class="text-gray-600 mb-4">Configure payments and go live with your store</p>
                    <a href="<?php echo get_post_type_archive_link('guide'); ?>?category=payments" class="text-blue-600 hover:text-blue-800 font-medium">Read Guide →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section id="search-guides" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Find the Right Guide</h2>
                <p class="text-xl text-gray-600">Search through our comprehensive library of tutorials</p>
            </div>
            
            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-12">
                <div class="flex flex-col lg:flex-row gap-4 items-center">
                    <!-- Search -->
                    <div class="flex-1 w-full">
                        <div class="relative">
                            <input type="text" id="guide-search" placeholder="Search guides and tutorials..." 
                                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <div class="flex gap-3 w-full lg:w-auto">
                        <select id="difficulty-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Levels</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                        
                        <select id="category-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Topics</option>
                            <?php if (!empty($guide_categories)) : ?>
                                <?php foreach ($guide_categories as $category) : ?>
                                    <option value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="getting-started">Getting Started</option>
                                <option value="design">Design & Customization</option>
                                <option value="products">Product Management</option>
                                <option value="marketing">Marketing & SEO</option>
                                <option value="payments">Payments & Checkout</option>
                                <option value="analytics">Analytics & Reports</option>
                            <?php endif; ?>
                        </select>
                        
                        <button id="reset-filters" class="px-4 py-3 text-gray-600 hover:text-gray-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Guides -->
<?php if (!empty($featured_guides)) : ?>
<section id="featured-guides" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Featured Guides</h2>
                <p class="text-xl text-gray-600">Our most popular and comprehensive tutorials</p>
            </div>
            
            <div class="grid lg:grid-cols-3 gap-8">
                <?php foreach ($featured_guides as $guide) : 
                    $reading_time = yoursite_get_reading_time($guide->ID);
                    $difficulty = get_post_meta($guide->ID, '_guide_difficulty', true) ?: 'beginner';
                    $guide_categories_terms = get_the_terms($guide->ID, 'guide_category');
                ?>
                    <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                        <a href="<?php echo get_permalink($guide->ID); ?>" class="block">
                            <?php if (has_post_thumbnail($guide->ID)) : ?>
                                <div class="aspect-video bg-gray-200 overflow-hidden">
                                    <?php echo get_the_post_thumbnail($guide->ID, 'medium', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300')); ?>
                                </div>
                            <?php else : ?>
                                <div class="aspect-video bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <!-- Tags -->
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        Featured
                                    </span>
                                    
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                        <?php echo ucfirst($difficulty); ?>
                                    </span>
                                    
                                    <?php if ($guide_categories_terms && !is_wp_error($guide_categories_terms)) : ?>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                            <?php echo esc_html($guide_categories_terms[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    <?php echo get_the_title($guide->ID); ?>
                                </h3>
                                
                                <?php if (has_excerpt($guide->ID)) : ?>
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        <?php echo wp_trim_words(get_the_excerpt($guide->ID), 25); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <!-- Meta Info -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <?php echo $reading_time; ?> min read
                                    </div>
                                    
                                    <span class="text-blue-600 font-medium group-hover:text-blue-700 transition-colors">
                                        Read Guide →
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Topic Categories -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Browse by Topic</h2>
                <p class="text-xl text-gray-600">Find guides organized by category and skill level</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                // Define category data with icons and colors - fallback for when taxonomies don't exist yet
                $category_data = array(
                    'getting-started' => array(
                        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                        'color' => 'green',
                        'title' => 'Getting Started',
                        'desc' => 'Learn the basics of setting up your online store from scratch',
                        'sample_guides' => array(
                            'Account setup and dashboard tour',
                            'Choosing the right plan',
                            'Your first store setup',
                            'Essential settings configuration'
                        )
                    ),
                    'design' => array(
                        'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M15 5l3 3m-3-3l3 3',
                        'color' => 'purple',
                        'title' => 'Design & Customization',
                        'desc' => 'Make your store unique with custom designs and branding',
                        'sample_guides' => array(
                            'Template selection and customization',
                            'Brand colors and logo setup',
                            'Custom CSS and styling',
                            'Mobile optimization'
                        )
                    ),
                    'products' => array(
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'color' => 'blue',
                        'title' => 'Product Management',
                        'desc' => 'Add, organize, and optimize your product catalog',
                        'sample_guides' => array(
                            'Adding products and variants',
                            'Product photography best practices',
                            'Inventory tracking and management',
                            'Categories and collections'
                        )
                    ),
                    'marketing' => array(
                        'icon' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V9a1 1 0 011-1h1a2 2 0 100-4H4a1 1 0 01-1-1V4a1 1 0 011-1h3a1 1 0 001-1v-1a2 2 0 012-2z',
                        'color' => 'red',
                        'title' => 'Marketing & SEO',
                        'desc' => 'Drive traffic and sales with proven marketing strategies',
                        'sample_guides' => array(
                            'SEO optimization and meta tags',
                            'Social media integration',
                            'Email marketing campaigns',
                            'Discount codes and promotions'
                        )
                    ),
                    'payments' => array(
                        'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                        'color' => 'yellow',
                        'title' => 'Payments & Checkout',
                        'desc' => 'Set up secure payments and optimize your checkout process',
                        'sample_guides' => array(
                            'Payment gateway setup',
                            'Checkout optimization',
                            'Security and compliance',
                            'Currency and tax settings'
                        )
                    ),
                    'analytics' => array(
                        'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                        'color' => 'orange',
                        'title' => 'Analytics & Reports',
                        'desc' => 'Track performance and make data-driven decisions',
                        'sample_guides' => array(
                            'Setting up analytics',
                            'Understanding your reports',
                            'Key performance indicators',
                            'Data-driven optimization'
                        )
                    )
                );

                // Use actual categories if they exist, otherwise use fallback data
                if (!empty($guide_categories)) :
                    foreach ($guide_categories as $category) : 
                        $category_slug = $category->slug;
                        $category_info = isset($category_data[$category_slug]) ? $category_data[$category_slug] : $category_data['products'];
                        
                        // Count guides in this category
                        $guides_count = get_posts(array(
                            'post_type' => 'guide',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'guide_category',
                                    'field' => 'term_id',
                                    'terms' => $category->term_id
                                )
                            )
                        ));
                        
                        if (is_wp_error($guides_count)) {
                            $guides_count = array();
                        }
                ?>
                <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-12 h-12 bg-<?php echo $category_info['color']; ?>-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-<?php echo $category_info['color']; ?>-200 transition-colors">
                        <svg class="w-6 h-6 text-<?php echo $category_info['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $category_info['icon']; ?>"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3"><?php echo esc_html($category->name); ?></h3>
                    <p class="text-gray-600 mb-6"><?php echo esc_html($category->description ?: $category_info['desc']); ?></p>
                    <ul class="space-y-2 mb-6">
                        <?php 
                        // Get sample guides from this category
                        $sample_guides = get_posts(array(
                            'post_type' => 'guide',
                            'posts_per_page' => 4,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'guide_category',
                                    'field' => 'term_id',
                                    'terms' => $category->term_id
                                )
                            )
                        ));
                        
                        if (is_wp_error($sample_guides)) {
                            $sample_guides = array();
                        }
                        
                        if (!empty($sample_guides)) :
                            foreach ($sample_guides as $sample_guide) :
                            ?>
                                <li class="text-sm text-gray-600">• <?php echo esc_html($sample_guide->post_title); ?></li>
                            <?php endforeach; ?>
                            
                            <?php if (count($guides_count) > 4) : ?>
                                <li class="text-sm text-gray-500">• And <?php echo count($guides_count) - 4; ?> more guides...</li>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php foreach ($category_info['sample_guides'] as $sample) : ?>
                                <li class="text-sm text-gray-600">• <?php echo esc_html($sample); ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <a href="<?php echo get_term_link($category); ?>" class="text-blue-600 hover:text-blue-800 font-medium group-hover:text-blue-700">
                        View All Guides (<?php echo count($guides_count); ?>) →
                    </a>
                </div>
                <?php 
                    endforeach;
                else : 
                    // Show fallback categories when no taxonomy exists yet
                    foreach ($category_data as $slug => $info) :
                ?>
                <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-12 h-12 bg-<?php echo $info['color']; ?>-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-<?php echo $info['color']; ?>-200 transition-colors">
                        <svg class="w-6 h-6 text-<?php echo $info['color']; ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $info['icon']; ?>"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3"><?php echo esc_html($info['title']); ?></h3>
                    <p class="text-gray-600 mb-6"><?php echo esc_html($info['desc']); ?></p>
                    <ul class="space-y-2 mb-6">
                        <?php foreach ($info['sample_guides'] as $sample) : ?>
                            <li class="text-sm text-gray-600">• <?php echo esc_html($sample); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo get_post_type_archive_link('guide') ?: '#'; ?>" class="text-blue-600 hover:text-blue-800 font-medium group-hover:text-blue-700">
                        View Guides →
                    </a>
                </div>
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('guide-search');
    const difficultyFilter = document.getElementById('difficulty-filter');
    const categoryFilter = document.getElementById('category-filter');
    const resetButton = document.getElementById('reset-filters');
    
    // Simple client-side filtering (for demo purposes)
    // In production, you'd want to implement AJAX search
    
    resetButton.addEventListener('click', function() {
        searchInput.value = '';
        difficultyFilter.value = '';
        categoryFilter.value = '';
    });
    
    // Add some basic interactivity
    searchInput.addEventListener('input', function() {
        // Placeholder for search functionality
        console.log('Searching for:', this.value);
    });
    
    categoryFilter.addEventListener('change', function() {
        // Placeholder for category filtering
        console.log('Filter by category:', this.value);
    });
    
    difficultyFilter.addEventListener('change', function() {
        // Placeholder for difficulty filtering
        console.log('Filter by difficulty:', this.value);
    });
});
</script>

<?php get_footer(); ?>