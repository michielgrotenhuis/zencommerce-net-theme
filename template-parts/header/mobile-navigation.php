<!-- Mobile Navigation -->
<div id="mobile-navigation" class="fixed inset-0 z-40 lg:hidden opacity-0 invisible transition-all duration-300">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    
    <!-- Mobile Menu Panel -->
    <nav class="mobile-menu-panel absolute top-0 right-0 w-80 max-w-[85vw] h-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl shadow-2xl flex flex-col">
        <!-- Mobile Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-gray-50/50 to-gray-100/50 dark:from-gray-800/30 dark:to-gray-700/30">
            <h2 class="text-xl font-bold text-zc-primary dark:text-white">Menu</h2>
            <button id="mobile-menu-close" 
                    class="w-10 h-10 bg-gray-200/50 dark:bg-gray-700/50 rounded-xl flex items-center justify-center hover:bg-gray-300/50 dark:hover:bg-gray-600/50 transition-colors focus-visible"
                    aria-label="Close menu">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Search -->
        <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="relative">
                <input type="search" 
                       class="w-full px-4 py-3 pr-10 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:border-zc-primary focus:ring-2 focus:ring-zc-primary/20 transition-all" 
                       placeholder="Search..." 
                       value="<?php echo get_search_query(); ?>" 
                       name="s" />
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-zc-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
        
        <!-- Mobile Menu Content -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            <?php get_template_part('template-parts/header/mobile-features'); ?>
            
            <!-- Other Menu Items -->
            <div class="space-y-2">
                <a href="/pricing" class="block text-lg font-medium text-zc-primary dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">Pricing</a>
                <a href="/templates" class="block text-lg font-medium text-zc-primary dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">Templates</a>
                <a href="/help" class="block text-lg font-medium text-zc-primary dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">Help Center</a>
            </div>
        </div>
        
        <!-- Mobile CTA Section -->
        <div class="p-6 border-t border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-gray-50/50 to-gray-100/50 dark:from-gray-800/30 dark:to-gray-700/30 space-y-4">
            <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
               class="block w-full py-3 px-4 text-center font-semibold text-zc-primary dark:text-white border border-gray-300/50 dark:border-gray-600/50 rounded-xl hover:bg-gray-100/50 dark:hover:bg-gray-700/50 transition-colors">
                <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
            </a>
            
            <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
               class="block w-full py-3 px-4 text-center font-bold text-white bg-zc-gradient rounded-xl hover:shadow-lg transform hover:scale-105 transition-all cta-shimmer">
                <?php echo esc_html(get_theme_mod('header_cta_text', 'Start Free Trial')); ?>
            </a>
            
            <!-- Trust Indicators -->
            <div class="flex items-center justify-center space-x-4 text-sm text-zc-secondary dark:text-gray-400">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>No credit card</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>SSL secure</span>
                </div>
            </div>
        </div>
    </nav>
</div>