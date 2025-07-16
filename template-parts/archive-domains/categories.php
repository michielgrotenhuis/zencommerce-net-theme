<?php
/**
 * Domain Archive - Categories Section
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args
$domain_categories = $args['domain_categories'] ?? array();
$current_category = $args['current_category'] ?? null;

// Function to get icon SVG
function get_category_icon($icon_name, $classes = 'w-6 h-6') {
    $icons = array(
        'trending-up' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
        'globe' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0 9c1.657 0 3-4.03 3-9s1.343-9 3-9m0 9v9"></path></svg>',
        'briefcase' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path></svg>',
        'cpu' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>',
        'shopping-cart' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path></svg>',
        'user-tie' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
        'graduation-cap' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>',
        'music' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>',
        'dollar-sign' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>',
        'heart' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>',
        'plane' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>',
        'utensils' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v2z"></path></svg>',
        'football' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>',
        'star' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>',
        'minimize' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>',
        'tag' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>'
    );
    
    return $icons[$icon_name] ?? $icons['star'];
}

// Color mapping for categories
function get_category_color_classes($color) {
    $colors = array(
        'blue' => 'from-blue-500 to-blue-600 border-blue-200 hover:border-blue-300',
        'green' => 'from-green-500 to-green-600 border-green-200 hover:border-green-300',
        'indigo' => 'from-indigo-500 to-indigo-600 border-indigo-200 hover:border-indigo-300',
        'purple' => 'from-purple-500 to-purple-600 border-purple-200 hover:border-purple-300',
        'orange' => 'from-orange-500 to-orange-600 border-orange-200 hover:border-orange-300',
        'gray' => 'from-gray-500 to-gray-600 border-gray-200 hover:border-gray-300',
        'pink' => 'from-pink-500 to-pink-600 border-pink-200 hover:border-pink-300',
        'red' => 'from-red-500 to-red-600 border-red-200 hover:border-red-300',
        'yellow' => 'from-yellow-500 to-yellow-600 border-yellow-200 hover:border-yellow-300'
    );
    
    return $colors[$color] ?? $colors['blue'];
}
?>

<!-- Domain Categories Section -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="layout-container">
        
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php _e('Explore Domain Categories', 'yoursite'); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php _e('Find the perfect domain extension for your business type. Browse through our carefully organized categories to discover domains that match your industry and goals.', 'yoursite'); ?>
            </p>
        </div>
        
        <!-- Categories Grid -->
        <?php if (!empty($domain_categories)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
            <?php foreach ($domain_categories as $category_key => $category): ?>
            <a href="<?php echo esc_url(home_url('/domains/category/' . $category_key)); ?>" 
               class="category-card group bg-white dark:bg-gray-900 rounded-2xl p-6 border-2 border-gray-100 dark:border-gray-700 hover:border-gray-200 dark:hover:border-gray-600 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 <?php echo $current_category && $current_category->slug === $category_key ? 'ring-2 ring-blue-500 border-blue-200' : ''; ?>">
                
                <!-- Category Icon & Header -->
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br <?php echo get_category_color_classes($category['color']); ?> flex items-center justify-center text-white mr-4 group-hover:scale-110 transition-transform duration-300">
                        <?php echo get_category_icon($category['icon'], 'w-6 h-6'); ?>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                        <?php echo esc_html($category['name']); ?>
                    </h3>
                </div>
                
                <!-- Domain Extensions Preview -->
                <div class="mb-4">
                    <div class="flex flex-wrap gap-2">
                        <?php 
                        $preview_domains = array_slice($category['domains'], 0, 4);
                        foreach ($preview_domains as $domain): 
                        ?>
                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-full">
                            .<?php echo esc_html($domain); ?>
                        </span>
                        <?php endforeach; ?>
                        
                        <?php if (count($category['domains']) > 4): ?>
                        <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r <?php echo get_category_color_classes($category['color']); ?> text-white text-sm font-medium rounded-full">
                            +<?php echo count($category['domains']) - 4; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Domain Count -->
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    <?php printf(_n('%d domain extension', '%d domain extensions', count($category['domains']), 'yoursite'), count($category['domains'])); ?>
                </div>
                
                <!-- View More Arrow -->
                <div class="flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium group-hover:text-blue-700 dark:group-hover:text-blue-300">
                    <?php _e('Explore category', 'yoursite'); ?>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <!-- Quick Actions -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-8 border border-blue-200 dark:border-blue-800 max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php _e('Not sure which category fits your needs?', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    <?php _e('Our domain experts can help you find the perfect extension for your business.', 'yoursite'); ?>
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#domain-search" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 scroll-to-search">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <?php _e('Search All Domains', 'yoursite'); ?>
                    </a>
                    
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-transparent border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 font-semibold rounded-lg hover:bg-blue-600 hover:text-white dark:hover:bg-blue-400 dark:hover:text-gray-900 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <?php _e('Get Expert Help', 'yoursite'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS for Category Cards -->
<style>
.category-card {
    position: relative;
    overflow: hidden;
}

.category-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s;
}

.category-card:hover::before {
    left: 100%;
}

/* Scroll to search functionality */
.scroll-to-search {
    scroll-behavior: smooth;
}

/* Enhanced hover effects */
@media (hover: hover) {
    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
}

/* Dark mode adjustments */
@media (prefers-color-scheme: dark) {
    .category-card::before {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    }
}
</style>

<!-- JavaScript for Enhanced Category Interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to search functionality
    const scrollToSearchLinks = document.querySelectorAll('.scroll-to-search');
    scrollToSearchLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const searchSection = document.querySelector('.domain-search-container') || document.querySelector('#upmind-domain-search');
            if (searchSection) {
                searchSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                
                // Focus on search input after scroll
                setTimeout(() => {
                    const searchInput = searchSection.querySelector('input[type="text"]');
                    if (searchInput && searchInput.offsetParent !== null) {
                        searchInput.focus();
                    }
                }, 500);
            }
        });
    });
    
    // Track category clicks
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(function(card) {
        card.addEventListener('click', function() {
            const categoryName = this.querySelector('h3').textContent.trim();
            
            // Track category click event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'category_click', {
                    'event_category': 'engagement',
                    'event_label': categoryName
                });
            }
        });
    });
    
    // Add loading states for category navigation
    categoryCards.forEach(function(card) {
        card.addEventListener('click', function(e) {
            const loadingSpinner = document.createElement('div');
            loadingSpinner.className = 'absolute inset-0 bg-white/80 dark:bg-gray-900/80 flex items-center justify-center z-10';
            loadingSpinner.innerHTML = `
                <svg class="animate-spin w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
            
            this.style.position = 'relative';
            this.appendChild(loadingSpinner);
            
            // Remove loading state if navigation is cancelled
            setTimeout(() => {
                if (loadingSpinner.parentNode === this) {
                    this.removeChild(loadingSpinner);
                }
            }, 3000);
        });
    });
});
</script>