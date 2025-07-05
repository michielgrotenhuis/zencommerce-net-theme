<!-- Mobile Menu Toggle -->
<div class="lg:hidden flex items-center space-x-3">
    <!-- Mobile Search -->
    <button id="mobile-search-toggle" 
            class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition-all focus-visible"
            aria-label="Toggle search">
        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </button>
    
    <!-- Mobile Dark Mode Toggle -->
    <button id="mobile-dark-mode-toggle" 
            class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition-all focus-visible"
            aria-label="Toggle dark mode">
        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        <svg class="w-5 h-5 text-gray-300 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </button>
    
    <!-- Hamburger Button -->
    <button id="mobile-menu-toggle" 
            class="hamburger w-12 h-12 bg-zc-gradient rounded-xl flex items-center justify-center hover:shadow-lg transform hover:scale-105 transition-all focus-visible z-50"
            aria-label="Toggle mobile menu" 
            aria-expanded="false">
        <div class="w-6 h-5 flex flex-col justify-between">
            <span class="hamburger-line bg-white rounded"></span>
            <span class="hamburger-line bg-white rounded"></span>
            <span class="hamburger-line bg-white rounded"></span>
        </div>
    </button>
</div>