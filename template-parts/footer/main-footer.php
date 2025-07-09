<?php
/**
 * Main Footer Content Template Part
 */
?>

<footer id="colophon" class="site-footer bg-gray-900 text-gray-300">
    <!-- Main Footer Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 mb-12">
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <?php if (has_custom_logo()) : ?>
                        <div class="footer-logo mb-4">
                            <?php
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            if ($logo) {
                                echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="h-8 filter brightness-0 invert">';
                            }
                            ?>
                        </div>
                    <?php else : ?>
                        <h3 class="text-2xl font-bold text-white mb-4">
                            <?php bloginfo('name'); ?>
                        </h3>
                    <?php endif; ?>
                    
                    <p class="text-gray-400 mb-6 max-w-sm">
                        <?php echo esc_html(get_theme_mod('footer_company_description', __('Build and scale your online store with confidence. Trusted by 100,000+ businesses worldwide.', 'yoursite'))); ?>
                    </p>
                    
                    <!-- Trust Badges -->
                    <?php get_template_part('template-parts/footer/trust-badges'); ?>
                    
                    <!-- Social Links -->
                    <?php get_template_part('template-parts/footer/social-links'); ?>
                </div>
            </div>

            <!-- Product -->
            <div>
                <h4 class="text-white font-semibold mb-4">Product</h4>
                <ul class="space-y-3">
                    <li><a href="/features" class="footer-link">Features</a></li>
                    <li><a href="/pricing" class="footer-link">Pricing</a></li>
                    <li><a href="/templates" class="footer-link">Templates</a></li>
                    <li><a href="/integrations" class="footer-link">Integrations</a></li>
                    <li><a href="/build-my-website" class="footer-link">Build My Website</a></li>
                    <li><a href="/api" class="footer-link">API</a></li>
                </ul>
            </div>

            <!-- Free Tools -->
            <div>
                <h4 class="text-white font-semibold mb-4">Free Tools <span class="text-xs bg-blue-500 text-white px-2 py-0.5 rounded-full ml-2">New</span></h4>
                <ul class="space-y-3">
                    <li><a href="/tools/privacy-policy-generator" class="footer-link">Privacy Policy Generator</a></li>
                    <li><a href="/tools/product-description-generator" class="footer-link">Product Description AI</a></li>
                    <li><a href="/tools/slogan-generator" class="footer-link">Slogan Generator</a></li>
                    <li><a href="/tools" class="footer-link">All Business Tools →</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div>
                <h4 class="text-white font-semibold mb-4">Learn</h4>
                <ul class="space-y-3">
                    <li><a href="/blog" class="footer-link">Blog</a></li>
                    <li><a href="/guides" class="footer-link">Guides</a></li>
                    <li><a href="/webinars" class="footer-link">Webinars</a></li>
                    <li><a href="/case-studies" class="footer-link">Case Studies</a></li>
                    <li><a href="/help" class="footer-link">Help Center</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div>
                <h4 class="text-white font-semibold mb-4">Company</h4>
                <ul class="space-y-3">
                    <li><a href="/about" class="footer-link">About Us</a></li>
                    <li><a href="/careers" class="footer-link">Careers</a></li>
                    <li><a href="/partners" class="footer-link">Partners</a></li>
                    <li><a href="/press-kit" class="footer-link">Press Kit</a></li>
                    <li><a href="/contact" class="footer-link">Contact</a></li>
                </ul>
            </div>
        </div>

        <!-- Newsletter Section -->
        <?php get_template_part('template-parts/footer/newsletter'); ?>

        <!-- Payment Methods & Certifications -->
        <?php get_template_part('template-parts/footer/payment-methods'); ?>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <!-- Copyright -->
                <div class="text-gray-400 text-sm text-center lg:text-left">
                    <?php echo wp_kses_post(get_theme_mod('footer_text', sprintf(__('© %s %s. All rights reserved.', 'yoursite'), date('Y'), get_bloginfo('name')))); ?>
                </div>
                
                <!-- Legal Links -->
                <?php if (get_theme_mod('show_legal_links', true)) : ?>
                <div class="flex flex-wrap justify-center items-center gap-6 text-sm">
                    <a href="/privacy-policy" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="/terms-of-service" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                    <a href="/cookie-policy" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                    <a href="/sitemap" class="text-gray-400 hover:text-white transition-colors">Sitemap</a>
                </div>
                <?php endif; ?>
                
                <!-- Language/Currency Selector -->
                <?php get_template_part('template-parts/footer/language-currency-selector'); ?>
            </div>
        </div>
    </div>
</footer>