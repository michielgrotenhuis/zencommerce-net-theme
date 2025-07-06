<?php
/**
 * Fixed Mobile Navigation - Zencommerce Style
 * Resolved mobile menu opening issues and improved design
 */
?>

<!-- Mobile Navigation -->
<div id="mobile-navigation" class="fixed inset-0 z-50 lg:hidden opacity-0 invisible transition-all duration-300 pointer-events-none">
    <!-- Overlay -->
    <div class="mobile-overlay absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300"></div>
    
    <!-- Mobile Menu Panel -->
    <nav class="mobile-menu-panel absolute top-0 right-0 w-80 max-w-[90vw] h-full bg-white dark:bg-gray-900 shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300">
        <!-- Mobile Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Menu</h2>
            </div>
            <button id="mobile-menu-close" 
                    class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-label="Close menu">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Search -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="relative">
                <input type="search" 
                       class="w-full px-4 py-3 pr-10 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400" 
                       placeholder="Search..." 
                       value="<?php echo get_search_query(); ?>" 
                       name="s" />
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
        
        <!-- Mobile Menu Content -->
        <div class="flex-1 overflow-y-auto p-4 space-y-6">
            
            <!-- Main Navigation Items -->
            <div class="space-y-2">
                <a href="<?php echo home_url('/'); ?>" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h1a1 1 0 001-1v-10"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-base font-medium text-gray-900 dark:text-white">Home</span>
                    </div>
                </a>
                
                <a href="/pricing" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-base font-medium text-gray-900 dark:text-white">Pricing</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Plans & Features</p>
                    </div>
                </a>
                
                <a href="/templates" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-base font-medium text-gray-900 dark:text-white">Templates</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">50+ Designs</p>
                    </div>
                </a>
                
                <a href="/help" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-base font-medium text-gray-900 dark:text-white">Help Center</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Support & Docs</p>
                    </div>
                </a>
            </div>
            
            <!-- Features Section -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Features</span>
                    <button class="features-toggle w-6 h-6 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center transition-colors"
                            aria-label="Toggle features menu">
                        <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Features Submenu -->
                <div class="features-submenu hidden space-y-3 pl-4 border-l-2 border-blue-200 dark:border-blue-800">
                    
                    <!-- Store Setup -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Store Setup</h4>
                        <div class="space-y-1">
                            <a href="/features/store-building" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors group">
                                <div class="w-6 h-6 bg-blue-500 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">Store Building</span>
                            </a>
                            
                            <a href="/features/graphics" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors group">
                                <div class="w-6 h-6 bg-purple-500 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">Graphics & Design</span>
                            </a>
                            
                            <a href="/templates" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors group">
                                <div class="w-6 h-6 bg-emerald-500 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">Templates</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Sales Channels -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Sales Channels</h4>
                        <div class="space-y-1">
                            <a href="/features/mobile" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors group">
                                <div class="w-6 h-6 bg-pink-500 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a1 1 0 001-1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v16a1 1 0 001 1z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">Mobile Commerce</span>
                            </a>
                            
                            <a href="/features/social" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors group">
                                <div class="w-6 h-6 bg-indigo-500 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">Social Commerce</span>
                            </a>
                            
                            <a href="/features/integrations" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors group">
                                <div class="w-6 h-6 bg-orange-500 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V9a1 1 0 011-1h1a2 2 0 100-4H4a1 1 0 01-1-1V4a1 1 0 011-1h3a1 1 0 011 1v1z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">Integrations</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- CTA -->
                    <div class="mt-4 p-3 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-lg border border-yellow-200/50 dark:border-yellow-700/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Build Your Store</h4>
                                <a href="/build-website" class="text-xs text-yellow-700 dark:text-yellow-300 hover:text-yellow-800 dark:hover:text-yellow-200 transition-colors">
                                    Get Started →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile CTA Section -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 space-y-3">
            <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
               class="block w-full py-3 px-4 text-center font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
            </a>
            
            <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
               class="block w-full py-3 px-4 text-center font-semibold text-white bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg hover:from-yellow-600 hover:to-orange-600 transition-all shadow-md hover:shadow-lg">
                <?php echo esc_html(get_theme_mod('header_cta_text', 'Start Free Trial')); ?>
            </a>
            
            <!-- Trust Indicators -->
            <div class="flex items-center justify-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                <div class="flex items-center space-x-1">
                    <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>No credit card</span>
                </div>
                <div class="flex items-center space-x-1">
                    <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>SSL secure</span>
                </div>
            </div>
        </div>
    </nav>
</div>