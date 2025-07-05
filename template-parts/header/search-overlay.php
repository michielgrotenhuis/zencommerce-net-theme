<!-- Search Overlay -->
<div id="search-overlay" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm opacity-0 invisible transition-all duration-300">
    <div class="container mx-auto px-4 pt-20">
        <div class="max-w-2xl mx-auto">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="relative">
                <input type="search" 
                       class="w-full px-6 py-4 text-xl bg-white dark:bg-gray-800 border-0 rounded-2xl shadow-2xl focus:outline-none focus:ring-2 focus:ring-zc-primary" 
                       placeholder="Search for anything..." 
                       value="<?php echo get_search_query(); ?>" 
                       name="s" 
                       id="search-input" />
                <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-zc-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
            <button id="search-close" class="mt-4 text-white/70 hover:text-white transition-colors">
                Press <kbd class="px-2 py-1 bg-white/20 rounded">Esc</kbd> to close
            </button>
        </div>
    </div>
</div>