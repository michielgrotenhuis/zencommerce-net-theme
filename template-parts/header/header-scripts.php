<?php
/**
 * Fixed Header Scripts for Mobile Menu Issues
 * Ensures mobile menu opens properly on all devices
 */
?>

<script>
// Enhanced WordPress Header JavaScript - Fixed Mobile Menu
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileClose = document.getElementById('mobile-menu-close');
    const mobileNav = document.getElementById('mobile-navigation');
    const mobilePanel = document.querySelector('.mobile-menu-panel');
    const mobileOverlay = document.querySelector('.mobile-overlay');
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
    
    // Debug function for mobile
    function debugLog(message) {
        console.log('[Mobile Menu Debug]:', message);
    }
    
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
    
    // Mobile Menu Functions - FIXED VERSION
    function openMobileMenu() {
        debugLog('Opening mobile menu');
        
        if (mobileNav && mobilePanel) {
            // Show the navigation container
            mobileNav.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
            mobileNav.classList.add('opacity-100', 'visible', 'pointer-events-auto');
            
            // Slide in the panel
            setTimeout(() => {
                mobilePanel.classList.remove('translate-x-full');
                mobilePanel.classList.add('translate-x-0');
            }, 10);
            
            // Animate hamburger
            if (hamburger) {
                hamburger.classList.add('active');
            }
            
            // Prevent body scroll
            body.classList.add('overflow-hidden');
            body.style.position = 'fixed';
            body.style.width = '100%';
            
            // Update aria attribute
            if (mobileToggle) {
                mobileToggle.setAttribute('aria-expanded', 'true');
            }
            
            debugLog('Mobile menu opened successfully');
        }
    }
    
    function closeMobileMenu() {
        debugLog('Closing mobile menu');
        
        if (mobileNav && mobilePanel) {
            // Slide out the panel
            mobilePanel.classList.remove('translate-x-0');
            mobilePanel.classList.add('translate-x-full');
            
            // Animate hamburger
            if (hamburger) {
                hamburger.classList.remove('active');
            }
            
            // Hide the navigation container after animation
            setTimeout(() => {
                mobileNav.classList.remove('opacity-100', 'visible', 'pointer-events-auto');
                mobileNav.classList.add('opacity-0', 'invisible', 'pointer-events-none');
            }, 300);
            
            // Restore body scroll
            body.classList.remove('overflow-hidden');
            body.style.position = '';
            body.style.width = '';
            
            // Update aria attribute
            if (mobileToggle) {
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
            
            debugLog('Mobile menu closed successfully');
        }
    }
    
    // Mobile Menu Events - IMPROVED
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            debugLog('Mobile toggle clicked');
            
            const isOpen = mobileNav && mobileNav.classList.contains('opacity-100');
            
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
        
        // Touch events for mobile devices
        mobileToggle.addEventListener('touchstart', function(e) {
            e.preventDefault();
        });
        
        mobileToggle.addEventListener('touchend', function(e) {
            e.preventDefault();
            
            const isOpen = mobileNav && mobileNav.classList.contains('opacity-100');
            
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }
    
    if (mobileClose) {
        mobileClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileMenu();
        });
        
        // Touch events
        mobileClose.addEventListener('touchstart', function(e) {
            e.preventDefault();
        });
        
        mobileClose.addEventListener('touchend', function(e) {
            e.preventDefault();
            closeMobileMenu();
        });
    }
    
    // Close on overlay click
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            closeMobileMenu();
        });
    }
    
    // Features Submenu Toggle
    if (featuresToggle && featuresSubmenu) {
        featuresToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isOpen = !featuresSubmenu.classList.contains('hidden');
            const toggleIcon = this.querySelector('svg');
            
            if (isOpen) {
                featuresSubmenu.classList.add('hidden');
                if (toggleIcon) {
                    toggleIcon.style.transform = 'rotate(0deg)';
                }
            } else {
                featuresSubmenu.classList.remove('hidden');
                if (toggleIcon) {
                    toggleIcon.style.transform = 'rotate(180deg)';
                }
            }
        });
    }
    
    // Keyboard Event Handlers
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (mobileNav && mobileNav.classList.contains('opacity-100')) {
                closeMobileMenu();
            }
            
            if (searchOverlay && searchOverlay.classList.contains('opacity-100')) {
                closeSearch();
            }
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
    
    // Additional mobile-specific event handlers
    if (window.innerWidth <= 1024) {
        debugLog('Mobile device detected, adding touch event handlers');
        
        // Prevent default touch behaviors that might interfere
        document.addEventListener('touchstart', function() {}, {passive: true});
        document.addEventListener('touchmove', function() {}, {passive: true});
        
        // Ensure mobile menu works on orientation change
        window.addEventListener('orientationchange', function() {
            setTimeout(() => {
                if (mobileNav && mobileNav.classList.contains('opacity-100')) {
                    // Refresh menu position after orientation change
                    closeMobileMenu();
                    setTimeout(openMobileMenu, 100);
                }
            }, 100);
        });
    }
    
    debugLog('Header scripts initialized successfully');
});

// Additional CSS for mobile menu fixes (injected via JS)
const mobileMenuStyles = `
<style>
/* Mobile Menu Fixes */
#mobile-navigation {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    will-change: opacity, visibility;
}

.mobile-menu-panel {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    will-change: transform;
}

/* Hamburger animation fixes */
.hamburger .hamburger-line {
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.hamburger.active .hamburger-line:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.hamburger.active .hamburger-line:nth-child(2) {
    opacity: 0;
    transform: scale(0);
}

.hamburger.active .hamburger-line:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

/* Ensure proper z-index stacking */
#mobile-navigation {
    z-index: 9999 !important;
}

.mobile-menu-panel {
    z-index: 10000 !important;
}

/* Fix for iOS Safari */
@supports (-webkit-touch-callout: none) {
    #mobile-navigation {
        position: fixed !important;
    }
    
    .mobile-menu-panel {
        position: fixed !important;
        top: 0 !important;
        height: 100vh !important;
        height: -webkit-fill-available !important;
    }
}

/* Mega menu animation fixes */
.mega-menu {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.mega-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
</style>
`;

// Inject the styles
document.head.insertAdjacentHTML('beforeend', mobileMenuStyles);
</script>

<?php
// WordPress fallback functions
if (!function_exists('yoursite_fallback_menu')) {
    function yoursite_fallback_menu() {
        echo '<ul class="flex items-center space-x-1">';
        echo '<li><a href="' . esc_url(home_url('/')) . '" class="px-4 py-3 text-gray-900 dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Home', 'yoursite') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/features')) . '" class="px-4 py-3 text-gray-900 dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Features', 'yoursite') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/pricing')) . '" class="px-4 py-3 text-gray-900 dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Pricing', 'yoursite') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/templates')) . '" class="px-4 py-3 text-gray-900 dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Templates', 'yoursite') . '</a></li>';
        echo '<li><a href="' . esc_url(home_url('/help')) . '" class="px-4 py-3 text-gray-900 dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">' . esc_html__('Help Center', 'yoursite') . '</a></li>';
        echo '</ul>';
    }
}

if (!function_exists('yoursite_mobile_fallback_menu')) {
    function yoursite_mobile_fallback_menu() {
        echo '<div class="space-y-2">';
        echo '<a href="' . esc_url(home_url('/')) . '" class="block text-lg font-medium text-gray-900 dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Home', 'yoursite') . '</a>';
        echo '<a href="' . esc_url(home_url('/features')) . '" class="block text-lg font-medium text-gray-900 dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Features', 'yoursite') . '</a>';
        echo '<a href="' . esc_url(home_url('/pricing')) . '" class="block text-lg font-medium text-gray-900 dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Pricing', 'yoursite') . '</a>';
        echo '<a href="' . esc_url(home_url('/templates')) . '" class="block text-lg font-medium text-gray-900 dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Templates', 'yoursite') . '</a>';
        echo '<a href="' . esc_url(home_url('/help')) . '" class="block text-lg font-medium text-gray-900 dark:text-white py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">' . esc_html__('Help Center', 'yoursite') . '</a>';
        echo '</div>';
    }
}
?>