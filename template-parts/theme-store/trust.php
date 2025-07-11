<?php
/**
 * Theme Store Trust Section
 * template-parts/theme-store/trust.php
 */

$theme_data = $args['theme_data'] ?? array();
?>

<section class="trust-section">
    <div class="layout-container">
        <div class="trust-content">
            <h2 class="trust-title text-white">Build with Confidence — The Zencommerce Promise</h2>
            <p class="trust-subtitle  text-white">Professional themes built for serious entrepreneurs who demand excellence</p>
        </div>
        
        <div class="trust-grid">
            <div class="trust-item">
                <span class="trust-icon">🚀</span>
                <h3>Latest E-commerce Features</h3>
                <p>Built with modern web standards and stays compatible with Zencommerce's growing feature set, ensuring your store always performs at its best.</p>
            </div>
            
            <div class="trust-item">
                <span class="trust-icon">⚡</span>
                <h3>Speed & Conversion Optimized</h3>
                <p>Every theme meets strict performance standards with Core Web Vitals optimization, ensuring faster loading times and higher conversion rates.</p>
            </div>
            
            <div class="trust-item">
                <span class="trust-icon">🆓</span>
                <h3>Unlimited Free Trial</h3>
                <p>Test the theme with your products, branding, and customizations. <?php if ($theme_data['price'] && $theme_data['price'] > 0): ?>Pay only $<?php echo number_format($theme_data['price'], 0); ?> when you're ready to publish<?php else: ?>Download and use completely free<?php endif; ?>.</p>
            </div>
            
            <div class="trust-item">
                <span class="trust-icon">📸</span>
                <h3>Professional Design Resources</h3>
                <p>Access to high-quality stock photos, design guidelines, and branding resources to make your store look professionally designed from day one.</p>
            </div>
            
            <div class="trust-item">
                <span class="trust-icon">🔄</span>
                <h3>Lifetime Updates & Support</h3>
                <p>Get continuous theme improvements, security updates, and new features. Professional support included with every theme purchase.</p>
            </div>
            
            <div class="trust-item">
                <span class="trust-icon">🏪</span>
                <h3>Multi-Store License</h3>
                <p>Use the theme on unlimited stores you own. Perfect for agencies, entrepreneurs with multiple businesses, or testing different markets.</p>
            </div>
        </div>
        
        <!-- Trust Stats -->
        <div style="margin-top: 4rem; padding-top: 3rem; border-top: 1px solid rgba(255,255,255,0.2);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
                <div>
                    <div style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">99.9%</div>
                    <div style="font-size: 0.875rem; opacity: 0.8;">Uptime Guarantee</div>
                </div>
                <div>
                    <div style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">&lt;2s</div>
                    <div style="font-size: 0.875rem; opacity: 0.8;">Average Load Time</div>
                </div>
                <div>
                    <div style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">24/7</div>
                    <div style="font-size: 0.875rem; opacity: 0.8;">Expert Support</div>
                </div>
                <div>
                    <div style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">60+</div>
                    <div style="font-size: 0.875rem; opacity: 0.8;">Countries Served</div>
                </div>
            </div>
        </div>
    </div>
</section>