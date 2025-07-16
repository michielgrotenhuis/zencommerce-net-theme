<?php
/**
 * Domain Archive - Search Form with Upmind Integration
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$');
$search_query = $args['search_query'] ?? '';

?>

<!-- Domain Search Form Container -->
<div class="domain-search-container bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20 shadow-2xl">
    
    <!-- Search Form Header -->
    <div class="text-center mb-6">
        <h3 class="text-2xl font-bold text-white mb-2">
            <?php _e('Find Your Perfect Domain', 'yoursite'); ?>
        </h3>
        <p class="text-white/80">
            <?php _e('Search from over 300 domain extensions and get instant availability results', 'yoursite'); ?>
        </p>
    </div>
    
    <!-- Traditional Search Form (Fallback) -->
    <div id="traditional-search" class="hidden">
        <form class="domain-search-form" action="<?php echo esc_url(home_url('/domain-search')); ?>" method="get">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Domain Input -->
                <div class="flex-1 relative">
                    <input type="text" 
                           name="domain" 
                           id="domain-search-fallback" 
                           class="w-full px-6 py-4 text-lg bg-white rounded-xl border-2 border-transparent focus:border-yellow-400 focus:outline-none transition-all duration-200 text-gray-900 placeholder-gray-500"
                           placeholder="<?php _e('Enter your domain name', 'yoursite'); ?>"
                           value="<?php echo esc_attr($search_query); ?>"
                           required>
                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Search Button -->
                <button type="submit" 
                        class="px-8 py-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 font-bold text-lg rounded-xl hover:from-yellow-500 hover:to-orange-600 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <?php _e('Search Domains', 'yoursite'); ?>
                    </span>
                </button>
            </div>
            
            <!-- Advanced Options -->
            <div class="mt-4 text-center">
                <button type="button" 
                        id="toggle-advanced" 
                        class="text-white/80 hover:text-white text-sm font-medium transition-colors duration-200">
                    <?php _e('Advanced Search Options', 'yoursite'); ?>
                    <svg class="w-4 h-4 inline ml-1 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Advanced Search Panel -->
            <div id="advanced-options" class="hidden mt-6 bg-white/10 rounded-xl p-6 border border-white/20">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Extension Filter -->
                    <div>
                        <label class="block text-white font-medium mb-2"><?php _e('Extension', 'yoursite'); ?></label>
                        <select name="extension" class="w-full px-4 py-2 bg-white rounded-lg border border-gray-300 text-gray-900 focus:border-yellow-400 focus:outline-none">
                            <option value=""><?php _e('Any extension', 'yoursite'); ?></option>
                            <option value="com">.com</option>
                            <option value="net">.net</option>
                            <option value="org">.org</option>
                            <option value="io">.io</option>
                            <option value="co">.co</option>
                            <option value="shop">.shop</option>
                            <option value="store">.store</option>
                            <option value="tech">.tech</option>
                        </select>
                    </div>
                    
                    <!-- Price Range -->
                    <div>
                        <label class="block text-white font-medium mb-2"><?php _e('Max Price', 'yoursite'); ?></label>
                        <select name="max_price" class="w-full px-4 py-2 bg-white rounded-lg border border-gray-300 text-gray-900 focus:border-yellow-400 focus:outline-none">
                            <option value=""><?php _e('Any price', 'yoursite'); ?></option>
                            <option value="10"><?php printf(__('Under %s10', 'yoursite'), esc_html($current_currency['symbol'])); ?></option>
                            <option value="25"><?php printf(__('Under %s25', 'yoursite'), esc_html($current_currency['symbol'])); ?></option>
                            <option value="50"><?php printf(__('Under %s50', 'yoursite'), esc_html($current_currency['symbol'])); ?></option>
                        </select>
                    </div>
                    
                    <!-- Domain Length -->
                    <div>
                        <label class="block text-white font-medium mb-2"><?php _e('Domain Length', 'yoursite'); ?></label>
                        <select name="length" class="w-full px-4 py-2 bg-white rounded-lg border border-gray-300 text-gray-900 focus:border-yellow-400 focus:outline-none">
                            <option value=""><?php _e('Any length', 'yoursite'); ?></option>
                            <option value="short"><?php _e('Short (3-6 chars)', 'yoursite'); ?></option>
                            <option value="medium"><?php _e('Medium (7-12 chars)', 'yoursite'); ?></option>
                            <option value="long"><?php _e('Long (13+ chars)', 'yoursite'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Upmind Domain Search Widget -->
    <div id="upmind-domain-search" class="upmind-domain-widget">
        <!-- Enhanced Upmind Integration -->
        <upm-dac
            order-config-url="https://my.zencommerce.net/order/product"
            currency-code="<?php echo esc_attr($current_currency['code']); ?>"
            theme="dark"
            search-placeholder="<?php esc_attr_e('Enter your domain name', 'yoursite'); ?>"
            button-text="<?php esc_attr_e('Search Domains', 'yoursite'); ?>"
        ></upm-dac>
        
        <!-- Fallback loading indicator -->
        <div class="widget-loading text-center py-12">
            <div class="inline-flex items-center text-white/80 bg-white/10 rounded-lg px-6 py-4">
                <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="font-medium"><?php _e('Loading domain search...', 'yoursite'); ?></span>
            </div>
        </div>
    </div>
    
    <!-- Popular Suggestions -->
    <div class="mt-6 text-center">
        <div class="text-white/70 text-sm mb-3"><?php _e('Popular searches:', 'yoursite'); ?></div>
        <div class="flex flex-wrap justify-center gap-2">
            <?php 
            $popular_searches = array('mybusiness', 'mystore', 'startup', 'agency', 'consulting', 'portfolio');
            foreach ($popular_searches as $suggestion): 
            ?>
            <button type="button" 
                    class="suggestion-tag px-3 py-1 bg-white/20 hover:bg-white/30 text-white text-sm rounded-full transition-colors duration-200 cursor-pointer"
                    data-suggestion="<?php echo esc_attr($suggestion); ?>">
                <?php echo esc_html($suggestion); ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- JavaScript for Search Form Enhancement -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Advanced options toggle
    const toggleBtn = document.getElementById('toggle-advanced');
    const advancedPanel = document.getElementById('advanced-options');
    
    if (toggleBtn && advancedPanel) {
        toggleBtn.addEventListener('click', function() {
            const isHidden = advancedPanel.classList.contains('hidden');
            const icon = this.querySelector('svg');
            
            if (isHidden) {
                advancedPanel.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                advancedPanel.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        });
    }
    
    // Suggestion tags functionality
    const suggestionTags = document.querySelectorAll('.suggestion-tag');
    const searchInput = document.getElementById('domain-search-fallback');
    
    suggestionTags.forEach(tag => {
        tag.addEventListener('click', function() {
            const suggestion = this.dataset.suggestion;
            if (searchInput) {
                searchInput.value = suggestion;
                searchInput.focus();
            }
        });
    });
    
    // Enhanced search functionality
    const searchForm = document.querySelector('.domain-search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="domain"]');
            const submitBtn = this.querySelector('button[type="submit"]');
            
            if (searchInput && searchInput.value.trim()) {
                // Add loading state
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = `
                    <span class="flex items-center justify-center">
                        <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <?php _e('Searching...', 'yoursite'); ?>
                    </span>
                `;
                submitBtn.disabled = true;
                
                // Track search event
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'domain_search', {
                        'event_category': 'engagement',
                        'event_label': searchInput.value.trim()
                    });
                }
            }
        });
    }
});
</script>