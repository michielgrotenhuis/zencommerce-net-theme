<?php
/**
 * Theme Store Styles
 * template-parts/theme-store/styles.php
 */
?>

<style>
/* Enhanced Zencommerce Style for Single Theme Page */
.theme-page {
    font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
    color: var(--zc-text-primary, #1c1c1c);
    background: var(--zc-bg-primary, #ffffff);
}

/* Hero Section - Zencommerce Style */
.theme-hero {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
    border-bottom: 1px solid var(--zc-border, #f1f1f1);
    position: relative;
    overflow: hidden;
}

.theme-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(59,130,246,0.03)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.6;
}

.theme-hero-content {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 2fr 5fr;
    gap: 2.5rem;
    align-items: center;
    padding: 4rem 0;
}

.theme-title {
    font-size: 2.75rem;
    font-weight: 800;
    color: var(--zc-text-primary, #1c1c1c);
    margin-bottom: 0.75rem;
    line-height: 1.05;
    letter-spacing: -0.025em;
}

.theme-subtitle {
    font-size: 1.125rem;
    color: var(--zc-text-secondary, #5f5f5f);
    margin-bottom: 1.25rem;
    line-height: 1.5;
}

.theme-meta {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}

.theme-price-display {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
}

.theme-price {
    font-size: 2.75rem;
    font-weight: 900;
    background: linear-gradient(135deg, var(--zc-primary, #f4b400) 0%, var(--zc-secondary, #126fb7) 100%);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1;
}

.theme-price.free {
    color: var(--zc-success, #16a34a);
    -webkit-text-fill-color: var(--zc-success, #16a34a);
}

.theme-meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    color: var(--zc-text-secondary, #5f5f5f);
    font-size: 0.875rem;
    line-height: 1.3;
}

.theme-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-top: 1.25rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: var(--zc-radius-sm, 8px);
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    white-space: nowrap;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.btn:hover::before {
    left: 100%;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, var(--zc-primary, #f4b400) 0%, var(--zc-primary-dark, #e09f00) 100%);
    color: white;
    border: 2px solid transparent;
}

.btn-secondary {
    background: transparent;
    color: var(--zc-secondary, #126fb7);
    border: 2px solid var(--zc-secondary, #126fb7);
}

.btn-secondary:hover {
    background: var(--zc-secondary, #126fb7);
    color: white;
}

.theme-trust-signals {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid var(--zc-border, #f1f1f1);
    font-size: 0.8125rem;
    color: var(--zc-text-tertiary, #93afc4);
}

.trust-signal {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

/* Preview Section */
.theme-preview-container {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--zc-radius-lg, 12px);
    padding: 1.5rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    position: relative;
}

/* Advanced Preview Styles */
.theme-preview-container.advanced-preview {
    padding: 0;
    background: transparent;
    border: none;
    box-shadow: none;
    backdrop-filter: none;
}

.advanced-preview-wrapper {
    position: relative;
    height: 500px;
    overflow: hidden;
    border-radius: var(--zc-radius-lg, 12px);
}

/* Desktop Browser Mockup */
.desktop-preview {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.desktop-browser {
    width: 100%;
    height: 100%;
    background: white;
    border-radius: var(--zc-radius-lg, 12px);
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border: 1px solid var(--zc-border, #f1f1f1);
}

.browser-header {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    gap: 1rem;
}

.browser-controls {
    display: flex;
    gap: 0.5rem;
}

.control-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.control-dot.red { background: #ff5f57; }
.control-dot.yellow { background: #ffbd2e; }
.control-dot.green { background: #28ca42; }

.browser-url {
    flex: 1;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    color: #6c757d;
    text-align: center;
}

.browser-content {
    height: calc(100% - 60px);
    overflow-y: auto;
    position: relative;
}

.fullpage-screenshot {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.browser-content:hover .fullpage-screenshot {
    transform: scale(1.02);
}

/* Custom Scrollbar */
.browser-content::-webkit-scrollbar {
    width: 8px;
}

.browser-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.browser-content::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.browser-content::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* iPhone Mockup */
.iphone-wrapper {
    position: absolute;
    bottom: -2rem;
    right: 1.5rem;
    z-index: 2;
    transform: scale(0.8);
    transform-origin: bottom right;
}

.iphone {
    width: 160px;
    height: 320px;
    position: relative;
}

.iphone-frame {
    width: 100%;
    height: 100%;
    background: #1a1a1a;
    border-radius: 36px;
    padding: 8px;
    box-shadow: 
        0 0 0 2px #333,
        0 8px 20px rgba(0, 0, 0, 0.3),
        inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    position: relative;
}

.iphone-notch {
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 20px;
    background: #1a1a1a;
    border-radius: 0 0 12px 12px;
    z-index: 3;
}

.iphone-screen {
    width: 100%;
    height: 100%;
    background: #000;
    border-radius: 28px;
    overflow: hidden;
    position: relative;
}

.mobile-screenshot {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
}

/* Standard Preview Styles */
.preview-tabs {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    justify-content: center;
}

.preview-tab {
    padding: 0.75rem 1.5rem;
    background: var(--zc-bg-secondary, #f9f9f9);
    border: 2px solid transparent;
    border-radius: var(--zc-radius-sm, 8px);
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
    color: var(--zc-text-secondary, #5f5f5f);
}

.preview-tab.active {
    background: white;
    color: var(--zc-secondary, #126fb7);
    border-color: var(--zc-secondary, #126fb7);
    box-shadow: 0 2px 8px rgba(18, 111, 183, 0.2);
}

.preview-container {
    border-radius: var(--zc-radius-sm, 8px);
    overflow: hidden;
    background: var(--zc-bg-secondary, #f9f9f9);
    aspect-ratio: 16/10;
    position: relative;
}

.preview-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.preview-container:hover img {
    transform: scale(1.02);
}

/* Responsive for Advanced Preview */
@media (max-width: 1024px) {
    .advanced-preview-wrapper {
        height: 400px;
    }
    
    .iphone-wrapper {
        transform: scale(0.7);
        bottom: -1.5rem;
        right: 1rem;
    }
}

@media (max-width: 768px) {
    .advanced-preview-wrapper {
        height: 350px;
    }
    
    .iphone-wrapper {
        transform: scale(0.6);
        bottom: -1rem;
        right: 0.5rem;
    }
    
    .browser-header {
        padding: 0.5rem 0.75rem;
    }
    
    .browser-url {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
    }
}


/* Enhanced Showcase Section - No Tabs */

.flexbutton{
    display:flex !important;
}


.theme-showcase {
    padding: 5rem 0;
    background: white;
}

.showcase-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 3rem;
    align-items: start;
}

/* Special handling for exactly 3 items */
.showcase-grid.three-items {
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.showcase-grid.three-items .showcase-item {
    min-height: 400px;
}

.showcase-item {
    background: white;
    border-radius: var(--zc-radius-lg, 12px);
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--zc-border, #f1f1f1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.showcase-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border-color: var(--zc-primary, #f4b400);
}

.showcase-media {
    position: relative;
    aspect-ratio: 16/10;
    overflow: hidden;
    background: var(--zc-bg-secondary, #f9f9f9);
}

.showcase-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.showcase-item:hover .showcase-media img {
    transform: scale(1.05);
}

.media-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
}

.showcase-item:hover .media-overlay {
    opacity: 1;
}

.media-play-btn {
    width: 4rem;
    height: 4rem;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--zc-secondary, #126fb7);
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.media-play-btn:hover {
    transform: scale(1.1);
}

.showcase-content {
    padding: 2rem;
}

.showcase-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--zc-text-primary, #1c1c1c);
    margin-bottom: 1rem;
    line-height: 1.3;
}

.showcase-description {
    color: var(--zc-text-secondary, #5f5f5f);
    line-height: 1.6;
    margin: 0;
}

/* Enhanced Features Section - Shopify Style Grid */
.theme-features {
    padding: 5rem 0;
    background: var(--zc-bg-secondary, #f9f9f9);
}

.features-intro {
    text-align: center;
    margin-bottom: 4rem;
}

.features-intro h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--zc-text-primary, #1c1c1c);
    margin-bottom: 1rem;
}

.features-intro p {
    font-size: 1.25rem;
    color: var(--zc-text-secondary, #5f5f5f);
    max-width: 600px;
    margin: 0 auto;
}

.features-categories {
    display: grid;
    gap: 3rem;
}

.feature-category {
    background: white;
    border-radius: var(--zc-radius-lg, 12px);
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid var(--zc-border, #f1f1f1);
    transition: all 0.3s ease;
}

.feature-category:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.category-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--zc-border, #f1f1f1);
}

.category-icon {
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, var(--zc-primary, #f4b400) 0%, var(--zc-secondary, #126fb7) 100%);
    border-radius: var(--zc-radius-sm, 8px);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.category-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--zc-text-primary, #1c1c1c);
    margin: 0;
}

.category-count {
    background: var(--zc-secondary, #126fb7);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    margin-left: auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--zc-bg-secondary, #f9f9f9);
    border-radius: var(--zc-radius-sm, 8px);
    border: 1px solid var(--zc-border, #f1f1f1);
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.feature-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: var(--zc-primary, #f4b400);
    transform: scaleY(0);
    transition: transform 0.2s ease;
}

.feature-item:hover {
    background: white;
    border-color: var(--zc-primary, #f4b400);
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.2);
}

.feature-item:hover::before {
    transform: scaleY(1);
}

.feature-icon {
    color: var(--zc-success, #16a34a);
    font-weight: bold;
    margin-right: 1rem;
    flex-shrink: 0;
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(22, 163, 74, 0.1);
    border-radius: 50%;
    font-size: 0.875rem;
}

.feature-text {
    font-weight: 500;
    color: var(--zc-text-primary, #1c1c1c);
    line-height: 1.4;
}

/* Support Section - Enhanced */
.theme-support {
    padding: 5rem 0;
    background: white;
}

.support-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    align-items: start;
}

.support-main {
    background: linear-gradient(135deg, rgba(18, 111, 183, 0.05) 0%, rgba(244, 180, 0, 0.05) 100%);
    border: 1px solid rgba(18, 111, 183, 0.1);
    border-radius: var(--zc-radius-lg, 12px);
    padding: 2.5rem;
}

.support-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--zc-secondary, #126fb7);
    margin-bottom: 1.5rem;
}

.support-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.support-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border-radius: var(--zc-radius-sm, 8px);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.support-btn-primary {
    background: var(--zc-secondary, #126fb7);
    color: white;
}

.support-btn-secondary {
    background: transparent;
    color: var(--zc-secondary, #126fb7);
    border: 2px solid var(--zc-secondary, #126fb7);
}

.support-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(18, 111, 183, 0.3);
}

.developer-info {
    background: white;
    border: 1px solid var(--zc-border, #f1f1f1);
    border-radius: var(--zc-radius-lg, 12px);
    padding: 2rem;
    text-align: center;
}

.developer-avatar {
    width: 4rem;
    height: 4rem;
    background: linear-gradient(135deg, var(--zc-primary, #f4b400) 0%, var(--zc-secondary, #126fb7) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
}

.developer-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--zc-text-primary, #1c1c1c);
    margin-bottom: 0.5rem;
}

.developer-meta {
    color: var(--zc-text-secondary, #5f5f5f);
    font-size: 0.875rem;
    line-height: 1.6;
}

/* Trust Section - Zencommerce Style */
.trust-section {
    background: linear-gradient(135deg, var(--zc-secondary, #126fb7) 0%, var(--zc-primary, #f4b400) 100%);
    color: white;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.trust-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="trustGrid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23trustGrid)"/></svg>');
    opacity: 0.3;
}

.trust-content {
    position: relative;
    z-index: 2;
    text-align: center;
    margin-bottom: 3rem;
}

.trust-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.trust-subtitle {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.trust-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    position: relative;
    z-index: 2;
}

.trust-item {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--zc-radius-lg, 12px);
    padding: 2rem;
    transition: all 0.3s ease;
}

.trust-item:hover {
    background: rgba(255, 255, 255, 0.90);
    transform: translateY(-4px);
}

.trust-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: block;
}

.trust-item h3 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.trust-item p {
    opacity: 0.9;
    line-height: 1.6;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .theme-hero-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }
    
    .theme-actions {
        flex-direction: row;
        justify-content: center;
    }
    
    .theme-trust-signals {
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .support-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .showcase-grid,
    .showcase-grid.three-items {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .theme-title {
        font-size: 2.25rem;
    }
    
    .theme-price {
        font-size: 2.25rem;
    }
    
    .theme-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .theme-meta {
        justify-content: center;
    }
    
    .trust-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .showcase-grid,
    .showcase-grid.three-items {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .feature-category {
        padding: 1.5rem;
    }
}

/* Large screens - ensure 3 items stay in a row */
@media (min-width: 1200px) {
    .showcase-grid.three-items {
        gap: 3rem;
    }
}
</style>