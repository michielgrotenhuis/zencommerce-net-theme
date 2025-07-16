<?php
/**
 * Domain Archive - Hero Section
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$');
$current_category = $args['current_category'] ?? null;
$search_query = $args['search_query'] ?? '';
$page_title = $args['page_title'] ?? '';
$page_description = $args['page_description'] ?? '';

?>

<!-- Hero Section -->
<section class="domain-archive-hero relative overflow-hidden">
    <!-- Background Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800"></div>
    <div class="absolute inset-0 bg-gradient-to-tl from-purple-600/20 via-transparent to-cyan-400/10"></div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden opacity-20">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-32 right-20 w-24 h-24 bg-cyan-300/20 rounded-full blur-lg animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-purple-300/15 rounded-full blur-md animate-pulse delay-500"></div>
        <div class="absolute top-1/4 right-1/4 w-20 h-20 bg-yellow-300/10 rounded-full blur-lg animate-pulse delay-700"></div>
    </div>
    
    <div class="relative z-10 py-20 lg:py-32">
        <div class="layout-container">
            <div class="max-w-5xl mx-auto text-center text-white">
                
                <!-- Badge -->
                <div class="inline-flex items-center rounded-full px-6 py-3 mb-6 text-sm font-bold bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 shadow-xl border-2 border-yellow-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0 9c-1.657 0-3-4.03-3-9s1.343-9 3-9m0 9v9"></path>
                    </svg>
                    <?php _e('300+ Domain Extensions Available', 'yoursite'); ?>
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                    <?php if (!empty($page_title) && $current_category): ?>
                        <?php echo esc_html($page_title); ?>
                    <?php elseif (!empty($search_query)): ?>
                        <?php _e('Find Your Perfect', 'yoursite'); ?>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400">
                            <?php _e('Domain Name', 'yoursite'); ?>
                        </span>
                    <?php else: ?>
                        <?php _e('Register Your Perfect', 'yoursite'); ?>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400">
                            <?php _e('Domain Today', 'yoursite'); ?>
                        </span>
                    <?php endif; ?>
                </h1>
                
                <!-- Subheading -->
                <p class="text-xl lg:text-2xl mb-12 leading-relaxed opacity-90 max-w-4xl mx-auto">
                    <?php if (!empty($page_description)): ?>
                        <?php echo esc_html($page_description); ?>
                    <?php else: ?>
                        <?php _e('Get your business online with a professional domain name. Over 300 extensions available with instant setup, free privacy protection, and 24/7 expert support.', 'yoursite'); ?>
                    <?php endif; ?>
                </p>
                
                <!-- Domain Search Form -->
                <div class="max-w-4xl mx-auto mb-12">
                    <?php get_template_part('template-parts/archive-domains/search-form', null, $args); ?>
                </div>
                
                <!-- Trust Indicators -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm max-w-3xl mx-auto">
                    <div class="flex items-center justify-center bg-white/10 backdrop-blur-sm rounded-lg px-4 py-3 border border-white/20">
                        <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-semibold"><?php _e('Instant Setup', 'yoursite'); ?></span>
                    </div>
                    
                    <div class="flex items-center justify-center bg-white/10 backdrop-blur-sm rounded-lg px-4 py-3 border border-white/20">
                        <svg class="w-5 h-5 text-blue-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="font-semibold"><?php _e('Free Privacy', 'yoursite'); ?></span>
                    </div>
                    
                    <div class="flex items-center justify-center bg-white/10 backdrop-blur-sm rounded-lg px-4 py-3 border border-white/20">
                        <svg class="w-5 h-5 text-purple-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-semibold"><?php _e('24/7 Support', 'yoursite'); ?></span>
                    </div>
                    
                    <div class="flex items-center justify-center bg-gradient-to-r from-green-500/20 to-emerald-500/20 backdrop-blur-sm rounded-lg px-4 py-3 border border-green-400/30 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400/10 to-emerald-400/10 animate-pulse"></div>
                        <svg class="w-5 h-5 text-green-300 mr-2 flex-shrink-0 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-semibold relative z-10"><?php _e('Money Back', 'yoursite'); ?></span>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="mt-12 pt-8 border-t border-white/20">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                        <div>
                            <div class="text-3xl font-bold text-yellow-300 mb-1">5M+</div>
                            <div class="text-white/80"><?php _e('Domains Registered', 'yoursite'); ?></div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-yellow-300 mb-1">300+</div>
                            <div class="text-white/80"><?php _e('Domain Extensions', 'yoursite'); ?></div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-yellow-300 mb-1">99.9%</div>
                            <div class="text-white/80"><?php _e('Uptime Guarantee', 'yoursite'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white/60 animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Custom CSS for Hero Animation -->
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.domain-archive-hero .animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Enhance the gradient animation */
.domain-archive-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: translateX(-100%);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
</style>