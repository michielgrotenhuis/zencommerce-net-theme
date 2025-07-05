<!-- Header Actions -->
<div class="hidden lg:flex items-center space-x-3">
    <!-- Search Button -->
    <button id="search-toggle" 
            class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition-all focus-visible"
            aria-label="Toggle search">
        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </button>
    
    <!-- Dark Mode Toggle -->
    <button id="dark-mode-toggle" 
            class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition-all focus-visible"
            aria-label="Toggle dark mode">
        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        <svg class="w-5 h-5 text-gray-300 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </button>
    
    <!-- Login -->
    <a href="<?php echo esc_url(get_theme_mod('header_login_url', '/login')); ?>" 
       class="text-zc-secondary dark:text-gray-300 font-medium hover:text-zc-primary dark:hover:text-white transition-colors focus-visible px-3 py-2 rounded-lg">
        <?php echo esc_html(get_theme_mod('header_login_text', 'Login')); ?>
    </a>
    
    <!-- CTA Button -->
    <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '/signup')); ?>" 
       class="bg-zc-gradient text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:scale-105 transition-all cta-shimmer focus-visible">
        <?php echo esc_html(get_theme_mod('header_cta_text', 'Start Free Trial')); ?>
    </a>
</div>