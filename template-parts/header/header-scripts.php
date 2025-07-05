<script>
// Enhanced WordPress Header JavaScript with Modern Features
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileClose = document.getElementById('mobile-menu-close');
    const mobileNav = document.getElementById('mobile-navigation');
    const hamburger = document.querySelector('.hamburger');
    const featuresToggle = document.querySelector('.features-toggle');
    const featuresSubmenu = document.querySelector('.features-submenu');
    const announcementClose = document.querySelector('.announcement-close');
    const announcementBar = document.querySelector('.announcement-bar');
    const searchToggle = document.getElementById('search-toggle');
    const mobileSearchToggle = document.getElementById('mobile-search-toggle');
    const searchOverlay = document.getElementById('search-overlay');
    const searchInput = document.getElementById('search-input');
    const searchClose = document.getElementById('search-close');
    const body = document.body;
    const header = document.getElementById('masthead');
    
    // Dark Mode Elements
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const mobileDarkModeToggle = document.getElementById('mobile-dark-mode-toggle');
    
    // Dark Mode Functionality
    function initDarkMode() {
        const savedTheme = localStorage.getItem('theme') || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
    
    function toggleDarkMode() {
        const isDark = document.documentElement.classList.contains('dark');
        
        if (isDark) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    }
    
    // Initialize dark mode
    initDarkMode();
    
    // Dark mode toggle events
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', toggleDarkMode);
    }
    
    if (mobileDarkModeToggle) {
        mobileDarkModeToggle.addEventListener('click', toggleDarkMode);
    }
    
    // Search Functionality
    function openSearch() {
        if (searchOverlay) {
            searchOverlay.classList.remove('opacity-0', 'invisible');
            searchOverlay.classList.add('opacity-100', 'visible');
            body.classList.add('overflow-hidden');
            
            setTimeout(() => {
                if (searchInput) searchInput.focus();
            }, 100);
        }
    }
    
    function closeSearch() {
        if (searchOverlay) {
            searchOverlay.classList.remove('opacity-100', 'visible');
            searchOverlay.classList.add('opacity-0', 'invisible');
            body.classList.remove('overflow-hidden');
            
            if (searchInput) searchInput.value = '';
        }
    }
    
    // Search event listeners
    if (searchToggle) {
        searchToggle.addEventListener('click', openSearch);
    }
    
    if (mobileSearchToggle) {
        mobileSearchToggle.addEventListener('click', openSearch);
    }
    
    if (searchClose) {
        searchClose.addEventListener('click', closeSearch);
    }
    
    if (searchOverlay) {
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearch();
            }
        });
    }
    
    // Mobile Menu Functions
    function openMobileMenu() {
        if (mobileNav && hamburger) {
            mobileNav.classList.remove('opacity-0', 'invisible');
            mobileNav.classList.add('opacity-100', 'visible');
            
            setTimeout(() => {
                document.querySelector('.mobile-menu-panel').classList.add('open');
            }, 10);
            
            hamburger.classList.add('active');
            body.classList.add('overflow-hidden');
            mobileToggle.setAttribute('aria-expanded', 'true');
            
            setTimeout(() => {
                if (mobileClose) mobileClose.focus();
            }, 300);
        }
    }
    
    function closeMobileMenu() {
        if (mobileNav && hamburger) {
            document.querySelector('.mobile-menu-panel').classList.remove('open');
            hamburger.classList.remove('active');
            
            setTimeout(() => {
                mobileNav.classList.remove('opacity-100', 'visible');
                mobileNav.classList.add('opacity-0', 'invisible');
            }, 300);
            
            body.classList.remove('overflow-hidden');
            mobileToggle.setAttribute('aria-expanded', 'false');
            if (mobileToggle) mobileToggle.focus();
        }
    }
    
    // Mobile Menu Events
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            if (mobileNav.classList.contains('opacity-100')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }
    
    if (mobileClose) {
        mobileClose.addEventListener('click', closeMobileMenu);
    }
    
    // Close on overlay click
    if (mobileNav) {
        mobileNav.addEventListener('click', function(e) {
            if (e.target === mobileNav) {
                closeMobileMenu();
            }
        });
    }
    
    // Features Submenu Toggle
    if (featuresToggle && featuresSubmenu) {
        featuresToggle.addEventListener('click', function() {
            const isOpen = !featuresSubmenu.classList.contains('hidden');
            const toggleIcon = this.querySelector('svg');
            
            if (isOpen) {
                featuresSubmenu.classList.add('hidden');
                toggleIcon.style.transform = 'rotate(0deg)';
            } else {
                featuresSubmenu.classList.remove('hidden');
                toggleIcon.style.transform = 'rotate(180deg)';
            }
        });
    }
    
    // Keyboard Event Handlers
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileNav && mobileNav.classList.contains('opacity-100')) {
            closeMobileMenu();
        }
        
        if (e.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('opacity-100')) {
            closeSearch();
        }
        
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            openSearch();
        }
    });
    
    // Close mobile menu on resize to desktop
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 1024) {
                if (mobileNav && mobileNav.classList.contains('opacity-100')) {
                    closeMobileMenu();
                }
                if (searchOverlay && searchOverlay.classList.contains('opacity-100')) {
                    closeSearch();
                }
            }
        }, 100);
    });
    
    // Announcement Bar Close
    if (announcementClose && announcementBar) {
        announcementClose.addEventListener('click', function() {
            announcementBar.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                announcementBar.style.display = 'none';
            }, 300);
            
            try {
                localStorage.setItem('announcementClosed', 'true');
            } catch (e) {
                console.warn('Unable to save announcement preference');
            }
        });
        
        try {
            if (localStorage.getItem('announcementClosed') === 'true') {
                announcementBar.style.display = 'none';
            }
        } catch (e) {
            console.warn('Unable to read announcement preference');
        }
    }
    
    // Mega Menu Functionality for Desktop
    const featuresMenuItem = document.querySelector('.group');
    const megaMenu = document.querySelector('.mega-menu');
    let megaMenuTimeout;
    
    if (featuresMenuItem && megaMenu) {
        featuresMenuItem.addEventListener('mouseenter', function() {
            clearTimeout(megaMenuTimeout);
            megaMenu.classList.add('show');
        });
        
        featuresMenuItem.addEventListener('mouseleave', function() {
            megaMenuTimeout = setTimeout(() => {
                megaMenu.classList.remove('show');
            }, 150);
        });
        
        megaMenu.addEventListener('mouseenter', function() {
            clearTimeout(megaMenuTimeout);
        });
        
        megaMenu.addEventListener('mouseleave', function() {
            megaMenu.classList.remove('show');
        });
    }
    
    // Header Scroll Effect
    let lastScrollY = 0;
    let scrollTimeout;
    
    function handleScroll() {
        const currentScrollY = window.pageYOffset;
        
        if (header) {
            if (currentScrollY > 100) {
                header.classList.add('shadow-xl');
            } else {
                header.classList.remove('shadow-xl');
            }
        }
        
        lastScrollY = currentScrollY;
    }
    
    window.addEventListener('scroll', function() {
        if (!scrollTimeout) {
            scrollTimeout = setTimeout(function() {
                handleScroll();
                scrollTimeout = null;
            }, 16);
        }
    });
});
</script>

<?php
// WordPress fallback functions
if (!function_exists('yoursite_fallback_menu')) {
    function yoursite_fallback_menu() {
        echo '<ul class="flex items-center space-x-1">';
        echo '<li><a href="' . esc_url(home_url('/')) . '" class="px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Home', 'yoursite') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/features')) . '" class="px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Features', 'yoursite') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/pricing')) . '" class="px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Pricing', 'yoursite') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/templates')) . '" class="px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Templates', 'yoursite') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/help')) . '" class="px-4 py-3 text-zc-primary dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Help Center', 'yoursite') . '</a></li>';
        echo '</ul>';
    }
}

if (!function_exists('yoursite_mobile_fallback_menu')) {
    function yoursite_mobile_fallback_menu() {
        echo '<div class="space-y-2">';
        echo '<a href="' . esc_url(home_url('/')) . '" class="block text-lg font-medium text-zc-primary dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Home', 'yoursite') . '</a>';
        echo '<a href="' . esc_url(home_url('/features')) . '" class="block text-lg font-medium text-zc-primary dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Features', 'yoursite') . '</a>';
        echo '<a href="' . esc_url(home_url('/pricing')) . '" class="block text-lg font-medium text-zc-primary dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Pricing', 'yoursite') . '</a>';
        echo '<a href="' . esc_url(home_url('/templates')) . '" class="block text-lg font-medium text-zc-primary dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Templates', 'yoursite') . '</a>';
        echo '<a href="' . esc_url(home_url('/help')) . '" class="block text-lg font-medium text-zc-primary dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Help Center', 'yoursite') . '</a>';
        echo '</div>';
    }
}
?>