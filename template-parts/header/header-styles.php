<style>
/* ==========================================================================
   MODERN WORDPRESS HEADER - ZENCOMMERCE INSPIRED DESIGN
   ========================================================================== */

/* Custom CSS Variables */
:root {
    --zc-primary: #0066ff;
    --zc-primary-dark: #0052cc;
    --zc-secondary: #1a1a1a;
    --zc-accent: #ff6b35;
    --zc-success: #00d084;
    --zc-text-primary: #1a1a1a;
    --zc-text-secondary: #6b7280;
    --zc-text-muted: #9ca3af;
    --zc-border: #e5e7eb;
    --zc-bg-secondary: #f8fafc;
    --zc-gradient: linear-gradient(135deg, #0066ff 0%, #00d084 100%);
    --zc-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Dark mode variables */
.dark {
    --zc-text-primary: #f9fafb;
    --zc-text-secondary: #d1d5db;
    --zc-text-muted: #9ca3af;
    --zc-border: #374151;
    --zc-bg-secondary: #111827;
    --zc-secondary: #f9fafb;
}

/* Custom Tailwind Extensions */
.text-zc-primary { color: var(--zc-text-primary); }
.text-zc-secondary { color: var(--zc-text-secondary); }
.text-zc-muted { color: var(--zc-text-muted); }
.border-zc { border-color: var(--zc-border); }
.bg-zc-secondary { background-color: var(--zc-bg-secondary); }

/* Gradient backgrounds */
.bg-zc-gradient { background: var(--zc-gradient); }
.bg-zc-primary { background-color: var(--zc-primary); }
.bg-zc-accent { background-color: var(--zc-accent); }
.text-zc-accent { color: var(--zc-accent); }

/* Mega Menu Animations */
.mega-menu {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-20px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    backdrop-filter: blur(20px);
}

.mega-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* Feature Card Hover Effects */
.feature-card {
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.feature-card:hover::before {
    left: 100%;
}

.feature-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: var(--zc-shadow);
}

/* Mobile Menu Slide Animation */
.mobile-menu-panel {
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.mobile-menu-panel.open {
    transform: translateX(0);
}

/* Hamburger Animation */
.hamburger {
    cursor: pointer;
    transition: all 0.3s ease;
}

.hamburger-line {
    display: block;
    width: 100%;
    height: 2px;
    background: currentColor;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    transform-origin: center;
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

/* Announcement Bar */
.announcement-bar {
    background: var(--zc-gradient);
    position: relative;
    overflow: hidden;
}

.announcement-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    50% { left: 100%; }
    100% { left: 100%; }
}

/* Header Glass Effect */
.header-glass {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.dark .header-glass {
    background: rgba(17, 24, 39, 0.85);
    border-bottom: 1px solid rgba(55, 65, 81, 0.3);
}

/* Smooth Scrolling */
html { scroll-behavior: smooth; }

/* Focus Styles */
.focus-visible:focus-visible {
    outline: 2px solid var(--zc-primary);
    outline-offset: 2px;
    border-radius: 8px;
}

/* CTA Button Effects */
.cta-shimmer {
    position: relative;
    overflow: hidden;
}

.cta-shimmer::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s ease;
}

.cta-shimmer:hover::after {
    left: 100%;
}
</style>