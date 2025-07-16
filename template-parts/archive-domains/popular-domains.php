<?php
/**
 * Domain Archive - Popular Domains Section
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args
$popular_domains = $args['popular_domains'] ?? array();
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$');

?>

<!-- Popular Domains Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="layout-container">
        
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php _e('Most Popular Domain Extensions', 'yoursite'); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php _e('Start with the most trusted and widely recognized domain extensions. These popular choices offer great value and instant credibility for your business.', 'yoursite'); ?>
            </p>
        </div>
        
        <!-- Popular Domains Grid -->
        <?php if (!empty($popular_domains)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <?php foreach ($popular_domains as $index => $domain): ?>
            <?php 
                // Define variables with fallbacks to prevent undefined errors
                $domain_name = $domain['name'] ?? $domain['tld'] ?? 'Domain';
                $domain_tld = $domain['tld'] ?? '';
                $domain_description = $domain['description'] ?? 'Popular domain extension';
                $domain_price = $domain['price'] ?? '0';
                $domain_renewal_price = $domain['renewal_price'] ?? $domain_price;
                $domain_sale_price = $domain['sale_price'] ?? '';
                $domain_on_sale = $domain['on_sale'] ?? false;
                $domain_discount_percentage = $domain['discount_percentage'] ?? 0;
            ?>
            <div class="domain-card bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden <?php echo $index === 0 ? 'lg:scale-105 ring-2 ring-blue-500 ring-opacity-50' : ''; ?>">
                
                <!-- Featured Badge -->
                <?php if ($index === 0): ?>
                <div class="absolute top-0 right-0 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 px-4 py-2 rounded-bl-2xl rounded-tr-2xl font-bold text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <?php _e('Most Popular', 'yoursite'); ?>
                </div>
                <?php endif; ?>
                
                <!-- Sale Badge -->
                <?php if ($domain_on_sale): ?>
                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                    <?php printf(__('%s%% OFF', 'yoursite'), esc_html($domain_discount_percentage)); ?>
                </div>
                <?php endif; ?>
                
                <!-- Domain Header -->
                <div class="text-center mb-6 <?php echo $index === 0 ? 'mt-8' : 'mt-4'; ?>">
                    <!-- Domain Icon -->
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-white"><?php echo esc_html(strtoupper(substr($domain_tld, 0, 2))); ?></span>
                    </div>
                    
                    <!-- Domain Name -->
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        <?php echo esc_html($domain_name); ?>
                    </h3>
                    
                    <!-- Domain Description -->
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo esc_html($domain_description); ?>
                    </p>
                </div>
                
                <!-- Pricing -->
                <div class="text-center mb-6">
                    <?php if ($domain_on_sale && !empty($domain_sale_price)): ?>
                    <!-- Sale Price -->
                    <div class="mb-2">
                        <span class="text-3xl font-bold text-red-600 dark:text-red-400">
                            <?php echo esc_html($current_currency['symbol'] . $domain_sale_price); ?>
                        </span>
                        <span class="text-lg text-gray-500 dark:text-gray-400 line-through ml-2">
                            <?php echo esc_html($current_currency['symbol'] . $domain_price); ?>
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <?php printf(__('First year • Renews at %s%s/year', 'yoursite'), esc_html($current_currency['symbol']), esc_html($domain_renewal_price)); ?>
                    </div>
                    <?php else: ?>
                    <!-- Regular Price -->
                    <div class="mb-2">
                        <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            <?php echo esc_html($current_currency['symbol'] . $domain_price); ?>
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <?php printf(__('Per year • Renews at %s%s/year', 'yoursite'), esc_html($current_currency['symbol']), esc_html($domain_renewal_price)); ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Features List -->
                <div class="mb-6">
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php _e('Free privacy protection', 'yoursite'); ?>
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php _e('Easy DNS management', 'yoursite'); ?>
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php _e('24/7 expert support', 'yoursite'); ?>
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php _e('Money-back guarantee', 'yoursite'); ?>
                        </li>
                    </ul>
                </div>
                
                <!-- CTA Buttons -->
                <div class="space-y-3">
                    <a href="<?php echo esc_url(home_url('/domain-search?ext=' . $domain_tld)); ?>" 
                       class="block w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 text-center">
                        <?php printf(__('Search %s Domains', 'yoursite'), esc_html($domain_name)); ?>
                    </a>
                    
                    <?php if (!empty($domain_tld)): ?>
                    <a href="<?php echo esc_url(home_url('/domains/' . str_replace('.', '', $domain_name))); ?>" 
                       class="block w-full px-6 py-3 bg-transparent border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-blue-600 hover:text-blue-600 dark:hover:text-blue-400 font-semibold rounded-lg transition-all duration-200 text-center">
                        <?php _e('Learn More', 'yoursite'); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <!-- View All Domains CTA -->
        <div class="text-center mt-16">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg border border-gray-200 dark:border-gray-700 max-w-3xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php _e('Looking for more options?', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    <?php _e('We offer over 300 domain extensions to choose from. Find the perfect match for your business.', 'yoursite'); ?>
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo esc_url(home_url('/domains/all')); ?>" 
                       class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <?php _e('View All Domains', 'yoursite'); ?>
                    </a>
                    
                    <a href="#domain-search" 
                       class="inline-flex items-center justify-center px-8 py-3 bg-transparent border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 font-semibold rounded-lg hover:bg-blue-600 hover:text-white dark:hover:bg-blue-400 dark:hover:text-gray-900 transition-all duration-200 scroll-to-search">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <?php _e('Search Domains', 'yoursite'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS for Domain Cards -->
<style>
.domain-card {
    position: relative;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
}

.dark .domain-card {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
}

.domain-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 1rem;
}

.domain-card:hover::before {
    opacity: 1;
}

/* Enhanced hover animations */
@media (hover: hover) {
    .domain-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .domain-card:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }
}

/* Popular card special styling */
.domain-card.lg\:scale-105 {
    transform: scale(1.05);
    z-index: 10;
}

.domain-card.lg\:scale-105:hover {
    transform: scale(1.05) translateY(-8px);
}

/* Pulse animation for featured badge */
@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(255, 193, 7, 0.4);
    }
    50% {
        box-shadow: 0 0 30px rgba(255, 193, 7, 0.6);
    }
}

.domain-card:first-child .absolute {
    animation: pulse-glow 2s infinite;
}
</style>