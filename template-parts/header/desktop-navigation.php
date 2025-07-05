<!-- Desktop Navigation -->
<nav class="hidden lg:flex items-center space-x-1">
    <ul class="flex items-center space-x-1">
        
        <!-- Features Mega Menu -->
        <li class="relative group">
            <a href="/features" 
               class="flex items-center px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all duration-200 group">
                <span>Features</span>
                <svg class="ml-1 w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>
            
            <?php get_template_part('template-parts/header/mega-menu'); ?>
        </li>
        
        <!-- Regular Menu Items -->
        <li><a href="/pricing" class="px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all focus-visible">Pricing</a></li>
        <li><a href="/templates" class="px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all focus-visible">Templates</a></li>
        <li><a href="/help" class="px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all focus-visible">Help Center</a></li>
    </ul>
</nav>