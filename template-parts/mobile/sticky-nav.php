<?php
/**
 * Template Part: Mobile Sticky Navigation
 * File: template-parts/mobile/sticky-nav.php
 * Self-contained version - no external function dependencies
 */

// Simple check - don't show on admin or if disabled
if (is_admin() || (function_exists('get_theme_mod') && !get_theme_mod('show_mobile_nav', true))) {
    return;
}

// Simple navigation items array
$nav_items = array(
    'home' => array(
        'url' => home_url('/'),
        'label' => 'Home',
        'icon' => 'home',
        'active' => is_front_page()
    ),
    'features' => array(
        'url' => home_url('/features'),
        'label' => 'Features', 
        'icon' => 'features',
        'active' => is_page('features')
    ),
    'pricing' => array(
        'url' => home_url('/pricing'),
        'label' => 'Pricing',
        'icon' => 'pricing',
        'active' => is_page('pricing'),
        'highlight' => true
    ),
    'build' => array(
        'url' => home_url('/build-my-website'),
        'label' => 'Build Now',
        'icon' => 'build',
        'active' => is_page('build-my-website'),
        'primary' => true
    ),
    'signup' => array(
        'url' => home_url('/signup'),
        'label' => 'Start Free',
        'icon' => 'signup',
        'active' => is_page('signup'),
        'cta' => true
    )
);

// Get settings with defaults
$cta_text = function_exists('get_theme_mod') ? get_theme_mod('mobile_nav_cta_text', '🚀 Start Building') : '🚀 Start Building';
$primary_color = function_exists('get_theme_mod') ? get_theme_mod('mobile_nav_primary_color', '#3B82F6') : '#3B82F6';

// Simple icon function
function get_nav_icon($icon_type) {
    $icons = array(
        'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>',
        'features' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="12,2 22,8.5 22,15.5 12,22 2,15.5 2,8.5"/><circle cx="12" cy="12" r="4"/></svg>',
        'pricing' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M16 8l-4 4-4-4"/><text x="12" y="16" text-anchor="middle" font-size="8" fill="currentColor">$</text></svg>',
        'build' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="M21 15l-3.086-3.086a2 2 0 00-2.828 0L6 21"/><path d="M12 12l7-7"/></svg>',
        'signup' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M16 11l2 2 4-4"/></svg>'
    );
    return isset($icons[$icon_type]) ? $icons[$icon_type] : $icons['home'];
}
?>

<!-- Mobile Sticky Bottom Navigation -->
<div class="mobile-bottom-nav" id="mobileBottomNav">
    <!-- Background with gradient and blur effect -->
    <div class="mobile-nav-bg"></div>
    
    <!-- Navigation Items -->
    <div class="mobile-nav-container">
        <?php foreach ($nav_items as $key => $item) : ?>
            <a href="<?php echo esc_url($item['url']); ?>" 
               class="nav-item <?php echo $item['active'] ? 'active' : ''; ?> 
                      <?php echo !empty($item['highlight']) ? 'nav-item-highlight' : ''; ?>
                      <?php echo !empty($item['primary']) ? 'nav-item-primary' : ''; ?>
                      <?php echo !empty($item['cta']) ? 'nav-item-cta' : ''; ?>" 
               data-page="<?php echo esc_attr($key); ?>"
               data-analytics-label="<?php echo esc_attr($item['label']); ?>">
                
                <div class="nav-icon <?php echo !empty($item['primary']) ? 'nav-icon-primary' : ''; ?>">
                    <?php echo get_nav_icon($item['icon']); ?>
                    
                    <?php if (!empty($item['highlight'])) : ?>
                        <div class="price-badge">FREE</div>
                    <?php endif; ?>
                    
                    <?php if (!empty($item['primary'])) : ?>
                        <div class="pulse-ring"></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($item['cta'])) : ?>
                        <div class="signup-dot"></div>
                    <?php endif; ?>
                </div>
                
                <span class="nav-label <?php echo !empty($item['primary']) ? 'nav-label-primary' : ''; ?>">
                    <?php echo esc_html($item['label']); ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
    
    <!-- Removed Floating Action Button -->
</div>

<style>
/* Mobile Sticky Bottom Navigation */
.mobile-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 999;
    display: none; /* Hidden by default, shown only on mobile */
    height: 80px;
    padding: 0;
    overflow: visible;
}

/* Show only on mobile and tablet */
@media (max-width: 1024px) {
    .mobile-bottom-nav {
        display: block;
    }
    
    /* Add bottom padding to body to prevent content being hidden */
    body {
        padding-bottom: 80px !important;
    }
}

/* Background with glassmorphism effect */
.mobile-nav-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.1);
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .mobile-nav-bg {
        background: rgba(17, 24, 39, 0.95);
        border-top: 1px solid rgba(55, 65, 81, 0.3);
    }
}

/* Navigation Container */
.mobile-nav-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-around;
    height: 100%;
    padding: 8px 12px 12px;
    max-width: 500px;
    margin: 0 auto;
}

/* Navigation Items */
.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #6B7280;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 4px 8px;
    border-radius: 12px;
    position: relative;
    min-width: 50px;
    transform: translateY(0);
}

.nav-item:hover,
.nav-item:active {
    color: <?php echo esc_attr($primary_color); ?>;
    transform: translateY(-2px);
}

/* Navigation Icons */
.nav-icon {
    position: relative;
    width: 28px;
    height: 28px;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-icon svg {
    width: 24px;
    height: 24px;
    stroke-width: 2;
    transition: all 0.3s ease;
}

/* Navigation Labels */
.nav-label {
    font-size: 10px;
    font-weight: 500;
    line-height: 1;
    text-align: center;
    transition: all 0.3s ease;
}

/* Highlighted Pricing Item */
.nav-item-highlight {
    background: linear-gradient(135deg, #FFE4B5 0%, #FFD700 100%);
    color: #B45309 !important;
    border-radius: 5px;
    padding: 10px 15px;
    box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
    animation: gentle-pulse 2s ease-in-out infinite;
}

.nav-item-highlight:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
}

.price-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #EF4444;
    color: white;
    font-size: 7px;
    font-weight: 700;
    padding: 1px 4px;
    border-radius: 6px;
    line-height: 1;
    animation: bounce-subtle 1.5s ease-in-out infinite;
}

/* Primary CTA - Build Website */
.nav-item-primary {
    background: linear-gradient(135deg, <?php echo esc_attr($primary_color); ?> 0%, #1D4ED8 100%);
    color: white !important;
    border-radius: 5px;
    padding: 8px 12px;
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    /* transform: scale(1.1); */
}

.nav-item-primary:hover {
    transform: scale(1.15) translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
}

.nav-icon-primary {
    position: relative;
}

.pulse-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 40px;
    height: 40px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: pulse-ring 2s ease-out infinite;
}

.nav-label-primary {
    font-weight: 600;
    color: white !important;
}

/* Secondary CTA - Signup */
.nav-item-cta {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white !important;
    border-radius: 5px;
    padding: 6px 10px;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.nav-item-cta:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.signup-dot {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 8px;
    height: 8px;
    background: #F59E0B;
    border-radius: 50%;
    animation: blink 1s ease-in-out infinite alternate;
}

/* Removed Floating Action Button styles */

/* Active States */
.nav-item.active {
    color: <?php echo esc_attr($primary_color); ?>;
}

.nav-item.active .nav-icon svg {
    stroke-width: 2.5;
}

.nav-item.active .nav-label {
    font-weight: 600;
}

/* Animations */
@keyframes gentle-pulse {
    0%, 100% { 
        transform: translateY(0) scale(1); 
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
    }
    50% { 
        transform: translateY(-1px) scale(1.02); 
        box-shadow: 0 6px 18px rgba(255, 215, 0, 0.4);
    }
}

@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}

@keyframes pulse-ring {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(1.5);
        opacity: 0;
    }
}

@keyframes blink {
    0% { opacity: 1; }
    100% { opacity: 0.3; }
}

/* Removed fab-pulse animation */

/* Responsive adjustments */
@media (max-width: 480px) {
    .mobile-nav-container {
        padding: 6px 8px 10px;
    }
    
    .nav-item {
        min-width: 45px;
        padding: 2px 12px;
    }
    
    .nav-icon {
        width: 26px;
        height: 26px;
    }
    
    .nav-icon svg {
        width: 22px;
        height: 22px;
    }
    
    .nav-label {
        font-size: 9px;
    }
    
    /* Removed floating button mobile styles */
}

/* Very small screens - removed floating button styles */

/* Smooth entrance animation */
.mobile-bottom-nav {
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeMobileBottomNav();
});

function initializeMobileBottomNav() {
    const nav = document.getElementById('mobileBottomNav');
    const navItems = document.querySelectorAll('.nav-item');
    
    if (!nav) return;
    
    // Set active state based on current page
    setActiveNavItem();
    
    // Removed floating CTA handler
    
    // Nav item click tracking
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const page = this.dataset.page;
            
            // Track navigation
            if (typeof gtag !== 'undefined') {
                gtag('event', 'navigation', {
                    'event_category': 'Mobile Nav',
                    'event_label': page
                });
            }
            
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
    
    // Removed scroll hide/show behavior - navigation stays visible
    
    function setActiveNavItem() {
        const currentPath = window.location.pathname;
        
        navItems.forEach(item => {
            item.classList.remove('active');
            
            const href = item.getAttribute('href');
            if (href === currentPath || 
                (currentPath === '/' && href === '<?php echo esc_js(home_url('/')); ?>') ||
                (currentPath.includes(href.replace('<?php echo esc_js(home_url()); ?>', '')) && href !== '<?php echo esc_js(home_url('/')); ?>')) {
                item.classList.add('active');
            }
        });
    }
}

// Removed conversion optimization functions

// Removed auto-trigger offer
</script>