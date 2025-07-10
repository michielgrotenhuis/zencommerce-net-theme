<?php
/**
 * Template part for Features Hero Section
 * 
 * @package YourSite
 */

if (get_theme_mod('features_hero_enable', true)) : ?>
<!-- Hero Section -->
<section class="features-pain-section py-20">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="hero-badge inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span>The Hidden Costs of DIY eCommerce</span>
            </div>
            
            <h1 class="hero-title text-4xl lg:text-6xl font-bold mb-6">
                Stop Losing Sales to
                <span class="text-blue-600">Technical Headaches</span>
            </h1>
            
            <p class="hero-subtitle text-xl mb-8 max-w-3xl mx-auto">
                Every day your store isn't optimized, you're bleeding money. While you wrestle with plugins, themes, and payment gateways, your competitors are making sales. We solve the problems that keep you up at night.
            </p>
            
            <div class="hero-cta-buttons flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#solution" class="btn-primary btn-with-icon text-lg px-8 py-4">
                    <span>See How We Fix This</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
                <div class="hero-stats flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Used by 50,000+ businesses</span>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>