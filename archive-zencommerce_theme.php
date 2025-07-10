<?php
/*
Template Name: Themes Archive
File: archive-zencommerce_theme.php
*/

get_header(); ?>

<div class="themes-archive-page">
    <!-- Hero Section -->
    <section class="themes-hero-section py-20 bg-gradient-to-br from-purple-50 to-pink-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-6xl font-bold mb-6 text-gray-900">
                    Beautiful themes for every business
                </h1>
                <p class="text-xl mb-8 max-w-3xl mx-auto text-gray-600">
                    Choose from 100+ professionally designed themes. All mobile-responsive, SEO-optimized, and ready to customize for your brand.
                </p>
                
                <!-- Filter Buttons -->
                <div class="flex flex-wrap justify-center gap-4 theme-filters">
                    <button class="filter-btn active" data-filter="all">All Themes</button>
                    <button class="filter-btn" data-filter="fashion">Fashion</button>
                    <button class="filter-btn" data-filter="electronics">Electronics</button>
                    <button class="filter-btn" data-filter="food">Food & Drink</button>
                    <button class="filter-btn" data-filter="home">Home & Garden</button>
                    <button class="filter-btn" data-filter="beauty">Beauty</button>
                    <button class="filter-btn" data-filter="business">Business</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Themes Section -->
    <section class="featured-themes-section py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4 text-gray-900">
                        Featured Themes
                    </h2>
                    <p class="text-xl text-gray-600">
                        Our most popular and versatile designs
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    <?php
                    // Get featured themes
                    $featured_args = array(
                        'post_type' => 'zencommerce_theme',
                        'posts_per_page' => 3,
                        'meta_query' => array(
                            array(
                                'key' => '_theme_featured',
                                'value' => '1',
                                'compare' => '='
                            )
                        )
                    );
                    
                    $featured_themes = new WP_Query($featured_args);
                    
                    if ($featured_themes->have_posts()):
                        while ($featured_themes->have_posts()): $featured_themes->the_post();
                            $price = get_post_meta(get_the_ID(), '_theme_price', true);
                            $developer = get_post_meta(get_the_ID(), '_theme_developer', true);
                            $rating = get_post_meta(get_the_ID(), '_theme_rating', true);
                            $demo_url = get_post_meta(get_the_ID(), '_theme_demo_url', true);
                            $categories = get_the_terms(get_the_ID(), 'theme_category');
                            $category_class = '';
                            if ($categories && !is_wp_error($categories)) {
                                $category_class = strtolower(str_replace(' ', '-', $categories[0]->name));
                            }
                    ?>
                        <div class="theme-card featured-card bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 <?php echo $category_class; ?>" data-category="<?php echo $category_class; ?>">
                            <div class="relative group">
                                <div class="theme-preview aspect-w-16 aspect-h-12 h-64 bg-gradient-to-br from-blue-100 to-purple-100">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover')); ?>
                                    <?php else: ?>
                                        <div class="flex items-center justify-center h-full">
                                            <div class="text-center">
                                                <div class="w-20 h-20 rounded-lg mx-auto mb-4 flex items-center justify-center bg-blue-500 bg-opacity-40">
                                                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-gray-600 font-medium">
                                                    <?php echo $categories && !is_wp_error($categories) ? $categories[0]->name : 'Theme'; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity space-x-3">
                                        <a href="<?php echo esc_url($demo_url); ?>" target="_blank" 
                                           class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg font-medium hover:bg-opacity-30 transition-colors">
                                            Preview
                                        </a>
                                        <a href="<?php the_permalink(); ?>" 
                                           class="bg-blue-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-600 transition-colors">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Featured Badge -->
                                <div class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">
                                    ⭐ FEATURED
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2 text-gray-900">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-2">
                                    <?php echo get_the_excerpt(); ?>
                                </p>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div class="price">
                                        <?php if ($price && $price > 0): ?>
                                            <span class="text-2xl font-bold text-blue-600">$<?php echo number_format($price, 0); ?></span>
                                        <?php else: ?>
                                            <span class="text-2xl font-bold text-green-600">Free</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($rating): ?>
                                        <div class="rating flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600 ml-1"><?php echo $rating; ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span><?php echo $categories && !is_wp_error($categories) ? $categories[0]->name : 'General'; ?></span>
                                    <?php if ($developer): ?>
                                        <span>by <?php echo esc_html($developer); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    else:
                        // Show placeholder cards if no featured themes
                        for ($i = 1; $i <= 3; $i++):
                    ?>
                        <div class="theme-card bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                            <div class="theme-preview h-64 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-20 h-20 rounded-lg mx-auto mb-4 flex items-center justify-center bg-gray-300">
                                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Sample Theme <?php echo $i; ?></p>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2">Sample Theme <?php echo $i; ?></h3>
                                <p class="text-gray-600 mb-4">Professional theme perfect for your business needs.</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-blue-600">$<?php echo 50 + ($i * 20); ?></span>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-sm text-gray-600 ml-1">4.<?php echo $i + 3; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endfor;
                    endif; 
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- All Themes Grid -->
    <section class="all-themes-section py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4 text-gray-900">
                        All Themes
                    </h2>
                    <p class="text-xl text-gray-600">
                        Browse our complete collection of themes
                    </p>
                </div>
                
                <!-- Search and Sort -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <div class="search-box flex-1 max-w-md">
                        <form method="GET" class="relative">
                            <input type="text" name="search" placeholder="Search themes..." 
                                   value="<?php echo esc_attr(get_query_var('search')); ?>"
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    
                    <div class="sort-options flex items-center gap-4">
                        <label class="text-gray-700 font-medium">Sort by:</label>
                        <select id="theme-sort" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="newest">Newest</option>
                            <option value="popular">Most Popular</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="rating">Highest Rated</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" id="themes-grid">
                    <?php
                    // Main themes query
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $themes_args = array(
                        'post_type' => 'zencommerce_theme',
                        'posts_per_page' => 12,
                        'paged' => $paged,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    
                    // Add search if present
                    if (get_query_var('search')) {
                        $themes_args['s'] = get_query_var('search');
                    }
                    
                    $themes_query = new WP_Query($themes_args);
                    
                    if ($themes_query->have_posts()):
                        while ($themes_query->have_posts()): $themes_query->the_post();
                            $price = get_post_meta(get_the_ID(), '_theme_price', true);
                            $rating = get_post_meta(get_the_ID(), '_theme_rating', true);
                            $demo_url = get_post_meta(get_the_ID(), '_theme_demo_url', true);
                            $categories = get_the_terms(get_the_ID(), 'theme_category');
                            $category_class = '';
                            $category_name = 'General';
                            if ($categories && !is_wp_error($categories)) {
                                $category_class = strtolower(str_replace(' ', '-', $categories[0]->name));
                                $category_name = $categories[0]->name;
                            }
                    ?>
                        <div class="theme-card bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 <?php echo $category_class; ?>" data-category="<?php echo $category_class; ?>" data-price="<?php echo $price ?: 0; ?>" data-rating="<?php echo $rating ?: 0; ?>">
                            <div class="relative group">
                                <div class="theme-preview aspect-w-16 aspect-h-10 h-48 bg-gradient-to-br from-blue-100 to-purple-100">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
                                    <?php else: ?>
                                        <div class="flex items-center justify-center h-full">
                                            <div class="text-center">
                                                <div class="w-16 h-16 bg-blue-200 rounded-lg flex items-center justify-center mx-auto mb-2">
                                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-gray-600 text-sm"><?php echo $category_name; ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity space-x-2">
                                        <a href="<?php echo esc_url($demo_url); ?>" target="_blank" 
                                           class="text-white bg-white bg-opacity-20 px-3 py-2 rounded-lg text-sm font-medium hover:bg-opacity-30 transition-colors">
                                            Preview
                                        </a>
                                        <a href="<?php the_permalink(); ?>" 
                                           class="text-white bg-blue-500 px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors">
                                            Use
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <h4 class="font-semibold mb-1 text-gray-900">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600 mb-2"><?php echo $category_name; ?></p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="price">
                                        <?php if ($price && $price > 0): ?>
                                            <span class="font-bold text-blue-600">$<?php echo number_format($price, 0); ?></span>
                                        <?php else: ?>
                                            <span class="font-bold text-green-600">Free</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($rating): ?>
                                        <div class="rating flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600 ml-1"><?php echo $rating; ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                    else:
                        // Show sample themes if none exist
                        $sample_themes = array(
                            array('name' => 'Organic Market', 'category' => 'food', 'price' => 'Free', 'rating' => '4.6'),
                            array('name' => 'Garden Oasis', 'category' => 'home', 'price' => '$79', 'rating' => '4.4'),
                            array('name' => 'Glow Studio', 'category' => 'beauty', 'price' => '$99', 'rating' => '4.9'),
                            array('name' => 'Tech Store', 'category' => 'electronics', 'price' => '$89', 'rating' => '4.7'),
                            array('name' => 'Fashion Hub', 'category' => 'fashion', 'price' => '$119', 'rating' => '4.8'),
                            array('name' => 'Business Pro', 'category' => 'business', 'price' => '$149', 'rating' => '4.5'),
                        );
                        
                        foreach ($sample_themes as $theme):
                    ?>
                        <div class="theme-card bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-lg transition-all duration-300 <?php echo $theme['category']; ?>" data-category="<?php echo $theme['category']; ?>">
                            <div class="relative group">
                                <div class="theme-preview h-48 bg-gradient-to-br from-<?php echo $theme['category'] === 'food' ? 'green' : ($theme['category'] === 'beauty' ? 'pink' : 'blue'); ?>-100 to-<?php echo $theme['category'] === 'food' ? 'teal' : ($theme['category'] === 'beauty' ? 'rose' : 'purple'); ?>-100">
                                    <div class="flex items-center justify-center h-full">
                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-<?php echo $theme['category'] === 'food' ? 'green' : ($theme['category'] === 'beauty' ? 'rose' : 'blue'); ?>-200 rounded-lg flex items-center justify-center mx-auto mb-2">
                                                <svg class="w-8 h-8 text-<?php echo $theme['category'] === 'food' ? 'green' : ($theme['category'] === 'beauty' ? 'rose' : 'blue'); ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <?php if ($theme['category'] === 'food'): ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    <?php elseif ($theme['category'] === 'beauty'): ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                    <?php else: ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                    <?php endif; ?>
                                                </svg>
                                            </div>
                                            <p class="text-gray-600 text-sm"><?php echo ucfirst($theme['category']); ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity space-x-2">
                                        <a href="#" class="text-white bg-white bg-opacity-20 px-3 py-2 rounded-lg text-sm font-medium hover:bg-opacity-30">Preview</a>
                                        <a href="#" class="text-white bg-blue-500 px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-600">Use</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <h4 class="font-semibold mb-1"><?php echo $theme['name']; ?></h4>
                                <p class="text-sm text-gray-600 mb-2"><?php echo ucfirst($theme['category']); ?></p>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold <?php echo $theme['price'] === 'Free' ? 'text-green-600' : 'text-blue-600'; ?>"><?php echo $theme['price']; ?></span>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-sm text-gray-600 ml-1"><?php echo $theme['rating']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </div>
                
                <!-- Load More Button -->
                <div class="text-center mt-12">
                    <?php if ($themes_query->have_posts() && $themes_query->max_num_pages > 1): ?>
                        <div class="pagination-wrapper">
                            <?php
                            echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total' => $themes_query->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'plain',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_next' => true,
                                'prev_text' => sprintf('<span>%1$s</span>', __('← Previous', 'zencommerce')),
                                'next_text' => sprintf('<span>%1$s</span>', __('Next →', 'zencommerce')),
                                'add_args' => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </div>
                        <?php wp_reset_postdata(); ?>
                    <?php else: ?>
                        <button id="load-more-themes" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Load More Themes
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4 text-gray-900">
                        Why Choose Our Themes?
                    </h2>
                    <p class="text-xl text-gray-600">
                        Every theme is built with best practices and conversion optimization
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="feature-item text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">Mobile Ready</h3>
                        <p class="text-gray-600">Responsive design that works perfectly on all devices and screen sizes.</p>
                    </div>
                    
                    <div class="feature-item text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">SEO Optimized</h3>
                        <p class="text-gray-600">Built with clean code and SEO best practices for better search rankings.</p>
                    </div>
                    
                    <div class="feature-item text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">Lightning Fast</h3>
                        <p class="text-gray-600">Optimized for speed with clean code and efficient loading.</p>
                    </div>
                    
                    <div class="feature-item text-center">
                        <div class="w-16 h-16 bg-orange-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">Easy Setup</h3>
                        <p class="text-gray-600">One-click demo import and intuitive customization options.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Filter Button Styles */
.filter-btn {
    @apply px-6 py-3 bg-white text-gray-700 rounded-lg font-medium border border-gray-200 hover:bg-gray-50 transition-all duration-200 cursor-pointer;
}

.filter-btn.active {
    @apply bg-blue-600 text-white border-blue-600 shadow-md;
}

.filter-btn:hover {
    @apply transform -translate-y-0.5 shadow-sm;
}

/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Animation utilities */
.theme-card {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Pagination styles */
.pagination-wrapper {
    @apply flex justify-center items-center gap-2 mt-8;
}

.pagination-wrapper a,
.pagination-wrapper span {
    @apply px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .theme-filters {
        @apply flex-col;
    }
    
    .filter-btn {
        @apply w-full max-w-xs;
    }
    
    .search-box {
        @apply max-w-none;
    }
    
    .grid {
        @apply grid-cols-1 sm:grid-cols-2;
    }
    
    .featured-themes-section .grid {
        @apply md:grid-cols-1 lg:grid-cols-2;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const themeCards = document.querySelectorAll('.theme-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white', 'border-blue-600', 'shadow-md');
                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
            });
            
            this.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
            this.classList.add('active', 'bg-blue-600', 'text-white', 'border-blue-600', 'shadow-md');
            
            // Filter themes
            themeCards.forEach(card => {
                if (filter === 'all' || card.classList.contains(filter) || card.dataset.category === filter) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease-out';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Sort functionality
    const sortSelect = document.getElementById('theme-sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortBy = this.value;
            const grid = document.getElementById('themes-grid');
            const cards = Array.from(grid.children);
            
            cards.sort((a, b) => {
                switch (sortBy) {
                    case 'price-low':
                        return parseFloat(a.dataset.price || 0) - parseFloat(b.dataset.price || 0);
                    case 'price-high':
                        return parseFloat(b.dataset.price || 0) - parseFloat(a.dataset.price || 0);
                    case 'rating':
                        return parseFloat(b.dataset.rating || 0) - parseFloat(a.dataset.rating || 0);
                    case 'popular':
                        // Sort by rating for now
                        return parseFloat(b.dataset.rating || 0) - parseFloat(a.dataset.rating || 0);
                    case 'newest':
                    default:
                        // Default order - no change needed
                        return 0;
                }
            });
            
            // Re-append sorted cards
            cards.forEach(card => grid.appendChild(card));
        });
    }
    
    // Load more functionality
    const loadMoreBtn = document.getElementById('load-more-themes');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            // This would typically load more themes via AJAX
            console.log('Loading more themes...');
            this.textContent = 'Loading...';
            this.disabled = true;
            
            // Simulate loading delay
            setTimeout(() => {
                this.textContent = 'Load More Themes';
                this.disabled = false;
                // Add your AJAX logic here
            }, 1000);
        });
    }
    
    // Search functionality enhancement
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.toLowerCase();
            
            searchTimeout = setTimeout(() => {
                themeCards.forEach(card => {
                    const title = card.querySelector('h4, h3').textContent.toLowerCase();
                    const category = card.querySelector('.text-gray-600').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || category.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }, 300);
        });
    }
});

// Add fade-in animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>

<?php get_footer(); ?>