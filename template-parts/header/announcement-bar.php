<?php if (get_theme_mod('show_announcement_bar', true)) : ?>
<!-- Inline script to prevent flash -->
<script>
(function() {
    const today = new Date().toDateString();
    const closedToday = localStorage.getItem('announcementClosed');
    const closedDate = localStorage.getItem('announcementClosedDate');
    
    if (closedToday === 'true' && closedDate === today) {
        document.documentElement.style.setProperty('--announcement-display', 'none');
    } else {
        document.documentElement.style.setProperty('--announcement-display', 'block');
    }
})();
</script>

<div class="announcement-bar bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 text-white py-3 px-4 text-center relative z-40 overflow-hidden" 
     id="announcement-bar" 
     style="display: var(--announcement-display, block)">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 animate-pulse"></div>
    </div>
    
    <div class="container mx-auto flex items-center justify-center relative z-10">
        <div class="flex items-center gap-3 flex-wrap justify-center">
            <!-- Urgency Icon with Animation -->
            <span class="text-xl animate-bounce">⚡</span>
            
            <!-- Main Message with Urgency -->
            <span class="font-bold text-sm sm:text-base">
                <?php echo esc_html(get_theme_mod('announcement_text', '🔥 LIMITED TIME: Save 50% on Annual Plans - Only 48 Hours Left!')); ?>
            </span>
            
            <!-- Social Proof Element -->
            <span class="hidden sm:inline-block text-xs bg-white/20 px-2 py-1 rounded-full font-medium">
                Join 10,000+ stores
            </span>
            
            <!-- CTA Button with Enhanced Design -->
            <a href="<?php echo esc_url(get_theme_mod('announcement_link', '/pricing')); ?>" 
               class="ml-2 bg-white text-red-600 px-6 py-2 rounded-full font-bold text-sm transition-all transform hover:scale-110 hover:shadow-lg active:scale-95 cta-pulse"
               onclick="trackAnnouncementClick()">
                <?php echo esc_html(get_theme_mod('announcement_cta', 'Claim 50% OFF')); ?> 
                <span class="ml-1">→</span>
            </a>
        </div>
    </div>
    
    <!-- Close Button with Better Visibility -->
    <button class="announcement-close absolute right-3 top-1/2 transform -translate-y-1/2 text-white/90 hover:text-white hover:bg-white/20 transition-all p-2 rounded-full hover:rotate-90 focus:outline-none focus:ring-2 focus:ring-white/50" 
            aria-label="Close announcement"
            onclick="closeAnnouncementBar()">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<!-- Enhanced JavaScript for Announcement Bar -->
<script>
// Announcement Bar Enhanced Functionality
document.addEventListener('DOMContentLoaded', function() {
    const announcementBar = document.getElementById('announcement-bar');
    const closeButton = document.querySelector('.announcement-close');
    
    // The visibility is already handled by inline script to prevent flash
    // Just handle the slide-in animation for new visitors
    if (announcementBar && announcementBar.style.display !== 'none') {
        announcementBar.style.transform = 'translateY(-100%)';
        announcementBar.style.transition = 'transform 0.5s ease-out';
        
        setTimeout(() => {
            announcementBar.style.transform = 'translateY(0)';
        }, 500);
    }
    
    // Close announcement function
    window.closeAnnouncementBar = function() {
        if (announcementBar) {
            announcementBar.style.transform = 'translateY(-100%)';
            
            setTimeout(() => {
                announcementBar.style.display = 'none';
                document.documentElement.style.setProperty('--announcement-display', 'none');
            }, 300);
            
            // Store closure with date
            const today = new Date().toDateString();
            try {
                localStorage.setItem('announcementClosed', 'true');
                localStorage.setItem('announcementClosedDate', today);
            } catch (e) {
                console.warn('Unable to save announcement preference');
            }
            
            // Optional: Track dismissal
            if (typeof gtag !== 'undefined') {
                gtag('event', 'announcement_dismissed', {
                    'event_category': 'engagement',
                    'event_label': 'announcement_bar'
                });
            }
        }
    };
    
    // Track CTA clicks
    window.trackAnnouncementClick = function() {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'announcement_cta_click', {
                'event_category': 'conversion',
                'event_label': 'announcement_bar_cta'
            });
        }
    };
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && announcementBar && announcementBar.style.display !== 'none') {
            closeAnnouncementBar();
        }
    });
    
    // Optional: Auto-close after 30 seconds for better UX
    setTimeout(() => {
        if (announcementBar && announcementBar.style.display !== 'none') {
            announcementBar.style.opacity = '0.8';
        }
    }, 30000);
});
</script>

<?php endif; ?>