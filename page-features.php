<?php
/*
Template Name: Features Page
*/

get_header(); 

// Load the pricing comparison table functionality
if (file_exists(get_template_directory() . '/inc/pricing-comparison-table.php')) {
    require_once get_template_directory() . '/inc/pricing-comparison-table.php';
}
?>

<style>
/* Features Page Specific Styles - Zencommerce Inspired */
.features-pain-section {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.features-pain-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.5;
}

.features-solution-section {
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-primary-dark) 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.features-solution-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
}

.pain-point-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--zc-radius-xl);
    padding: 2rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.pain-point-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    transition: left 0.6s ease;
}

.pain-point-card:hover::before {
    left: 100%;
}

.pain-point-card:hover {
    transform: translateY(-4px);
    border-color: rgba(244, 180, 0, 0.3);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.pain-icon {
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border-radius: var(--zc-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.solution-icon {
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: var(--zc-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.feature-deep-card {
    background: white;
    border: 1px solid var(--zc-border);
    border-radius: var(--zc-radius-xl);
    padding: 2.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.feature-deep-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-secondary) 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.feature-deep-card:hover::before {
    transform: scaleX(1);
}

.feature-deep-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border-color: var(--zc-primary);
}

.feature-category-icon {
    width: 4rem;
    height: 4rem;
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-primary-dark) 100%);
    border-radius: var(--zc-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 20px rgba(244, 180, 0, 0.3);
}

.feature-benefit-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.feature-benefit-item:hover {
    background: rgba(244, 180, 0, 0.05);
    padding-left: 1rem;
    border-radius: var(--zc-radius-sm);
}

.feature-benefit-item:last-child {
    border-bottom: none;
}

.feature-cta-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-primary-dark) 100%);
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: var(--zc-radius-md);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.25);
}

.feature-cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(244, 180, 0, 0.4);
    color: white;
    text-decoration: none;
}

.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--zc-radius-lg);
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--zc-primary);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-label {
    font-size: 0.9rem;
    color: var(--zc-text-secondary);
    font-weight: 500;
}

.transformation-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--zc-primary);
    font-size: 2rem;
    margin: 2rem 0;
}

@media (max-width: 768px) {
    .pain-point-card,
    .feature-deep-card {
        padding: 1.5rem;
    }
    
    .feature-category-icon {
        width: 3rem;
        height: 3rem;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .transformation-arrow {
        transform: rotate(90deg);
    }
}
</style>

<?php if (get_theme_mod('features_hero_enable', true)) : ?>
<!-- Hero Section -->
<section class="features-pain-section py-20">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-red-500/10 text-red-300 px-4 py-2 rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span>The Hidden Costs of DIY eCommerce</span>
            </div>
            
            <h1 class="text-4xl lg:text-6xl font-bold mb-6">
                Stop Losing Sales to
                <span class="text-red-400">Technical Headaches</span>
            </h1>
            
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90">
                Every day your store isn't optimized, you're bleeding money. While you wrestle with plugins, themes, and payment gateways, your competitors are making sales. We solve the problems that keep you up at night.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#solution" class="btn-primary text-lg px-8 py-4 inline-flex items-center gap-2">
                    <span>See How We Fix This</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
                <div class="flex items-center gap-2 text-sm opacity-75">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Used by 50,000+ businesses</span>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- The Real Problems Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    The Real Cost of "Doing It Yourself"
                </h2>
                <p class="text-xl text-gray-600">
                    These problems cost businesses an average of $47,000 per year in lost revenue
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Problem 1: Technical Overwhelm -->
                <div class="pain-point-card">
                    <div class="pain-icon">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Technical Overwhelm</h3>
                    <p class="text-gray-300 mb-4">
                        You're spending 20+ hours per week fighting with plugins, themes, and hosting issues instead of growing your business.
                    </p>
                    <div class="stats-card">
                        <div class="stats-number">73%</div>
                        <div class="stats-label">of store owners report technical stress</div>
                    </div>
                </div>
                
                <!-- Problem 2: Cart Abandonment -->
                <div class="pain-point-card">
                    <div class="pain-icon">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Cart Abandonment Crisis</h3>
                    <p class="text-gray-300 mb-4">
                        Your checkout process is too complicated, slow, or doesn't work properly on mobile devices.
                    </p>
                    <div class="stats-card">
                        <div class="stats-number">69%</div>
                        <div class="stats-label">average cart abandonment rate</div>
                    </div>
                </div>
                
                <!-- Problem 3: Hidden Costs -->
                <div class="pain-point-card">
                    <div class="pain-icon">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Hidden Costs Everywhere</h3>
                    <p class="text-gray-300 mb-4">
                        Plugin fees, theme costs, hosting upgrades, payment processing fees, and security patches add up fast.
                    </p>
                    <div class="stats-card">
                        <div class="stats-number">$2,847</div>
                        <div class="stats-label">average monthly hidden costs</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Transformation Arrow -->
<section class="py-8 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <div class="transformation-arrow">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Here's How We Fix Everything</h3>
        </div>
    </div>
</section>

<!-- Solutions Section -->
<section class="features-solution-section py-20" id="solution">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                    Everything You Need, Nothing You Don't
                </h2>
                <p class="text-xl opacity-90">
                    Our all-in-one platform eliminates every problem that's holding your business back
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Solution 1: Drag & Drop -->
                <div class="pain-point-card">
                    <div class="solution-icon">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">No-Code Store Builder</h3>
                    <p class="text-gray-200 mb-4">
                        Build stunning stores in minutes, not weeks. No technical knowledge required.
                    </p>
                    <div class="stats-card">
                        <div class="stats-number">15 min</div>
                        <div class="stats-label">average setup time</div>
                    </div>
                </div>
                
                <!-- Solution 2: Optimized Checkout -->
                <div class="pain-point-card">
                    <div class="solution-icon">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Lightning-Fast Checkout</h3>
                    <p class="text-gray-200 mb-4">
                        One-click payments, mobile-optimized, and conversion-tested checkout process.
                    </p>
                    <div class="stats-card">
                        <div class="stats-number">32%</div>
                        <div class="stats-label">higher conversion rate</div>
                    </div>
                </div>
                
                <!-- Solution 3: All-In-One -->
                <div class="pain-point-card">
                    <div class="solution-icon">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">All-In-One Platform</h3>
                    <p class="text-gray-200 mb-4">
                        Hosting, payments, marketing, inventory, and support all included in one price.
                    </p>
                    <div class="stats-card">
                        <div class="stats-number">$0</div>
                        <div class="stats-label">hidden fees</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Deep Dive Features Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Every Feature Solves a Real Business Problem
                </h2>
                <p class="text-xl text-gray-600">
                    Click on any feature to learn how it directly impacts your bottom line
                </p>
            </div>
            
            <?php if (get_theme_mod('features_store_building_enable', true)) : ?>
            <!-- Store Building Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Store Building That Actually Works</h3>
                        <p class="text-gray-600 mb-6">
                            Stop wasting weeks trying to make your store look professional. Our drag-and-drop builder creates conversion-optimized stores that look like they cost $50,000 to build.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Build your store in 15 minutes, not 15 weeks</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>100+ conversion-tested templates</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic mobile optimization</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>No coding or design skills needed</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Time saved monthly:</span>
                                <span class="font-semibold">40+ hours</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Development cost saved:</span>
                                <span class="font-semibold">$15,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Faster time to market:</span>
                                <span class="font-semibold">90% faster</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4">
                            <span>Learn More About Store Building</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (get_theme_mod('features_payments_enable', true)) : ?>
            <!-- Payments Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Payments That Actually Convert</h3>
                        <p class="text-gray-600 mb-6">
                            Stop losing customers at checkout. Our optimized payment process reduces cart abandonment by 32% and supports every payment method your customers want to use.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>One-click checkout with Apple Pay, Google Pay</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Accept 130+ currencies globally</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Bank-level security & PCI compliance</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic tax calculation for 180+ countries</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Cart abandonment reduction:</span>
                                <span class="font-semibold">32% lower</span>
                            </div>
                            <div class="flex justify-between">
                                <span>International sales increase:</span>
                                <span class="font-semibold">165% higher</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Payment processing saved:</span>
                                <span class="font-semibold">$2,400/month</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4">
                            <span>Learn More About Payments</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (get_theme_mod('features_marketing_enable', true)) : ?>
            <!-- Marketing Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Marketing That Runs Itself</h3>
                        <p class="text-gray-600 mb-6">
                            Stop juggling 12 different marketing tools. Our built-in marketing suite automates email campaigns, recovers abandoned carts, and optimizes your SEO without you lifting a finger.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automated email marketing campaigns</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Smart abandoned cart recovery</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Built-in SEO optimization</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Social media integration</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Marketing tools saved:</span>
                                <span class="font-semibold">$890/month</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Email open rates:</span>
                                <span class="font-semibold">47% higher</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Recovered cart revenue:</span>
                                <span class="font-semibold">$3,200/month</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4">
                            <span>Learn More About Marketing</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (get_theme_mod('features_inventory_enable', true)) : ?>
            <!-- Inventory Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Inventory Management That Thinks Ahead</h3>
                        <p class="text-gray-600 mb-6">
                            Never run out of stock again. Our smart inventory system tracks everything in real-time, predicts when you'll need to reorder, and automatically manages your suppliers.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Real-time inventory tracking</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Smart reorder point alerts</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic supplier management</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Multi-warehouse support</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Stockout prevention:</span>
                                <span class="font-semibold">95% reduction</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Inventory costs saved:</span>
                                <span class="font-semibold">$1,850/month</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Time saved on admin:</span>
                                <span class="font-semibold">25 hours/week</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4">
                            <span>Learn More About Inventory</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ROI Calculator Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    See Your Return on Investment
                </h2>
                <p class="text-xl text-gray-600">
                    Calculate how much money you'll save and make with our platform
                </p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 border border-blue-200">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Your Current Costs</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-4 bg-white rounded-lg border border-red-200">
                                <div>
                                    <div class="font-semibold text-gray-900">Monthly hosting & plugins</div>
                                    <div class="text-sm text-gray-600">Average WordPress eCommerce setup</div>
                                </div>
                                <div class="text-xl font-bold text-red-600">$347</div>
                            </div>
                            <div class="flex justify-between items-center p-4 bg-white rounded-lg border border-red-200">
                                <div>
                                    <div class="font-semibold text-gray-900">Lost sales (technical issues)</div>
                                    <div class="text-sm text-gray-600">Downtime, slow speeds, broken checkout</div>
                                </div>
                                <div class="text-xl font-bold text-red-600">$2,840</div>
                            </div>
                            <div class="flex justify-between items-center p-4 bg-white rounded-lg border border-red-200">
                                <div>
                                    <div class="font-semibold text-gray-900">Developer & maintenance</div>
                                    <div class="text-sm text-gray-600">Fixes, updates, security, customizations</div>
                                </div>
                                <div class="text-xl font-bold text-red-600">$890</div>
                            </div>
                            <div class="border-t-2 border-red-300 pt-4">
                                <div class="flex justify-between items-center">
                                    <div class="text-lg font-bold text-gray-900">Total Monthly Cost</div>
                                    <div class="text-2xl font-bold text-red-600">$4,077</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">With Our Platform</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-4 bg-white rounded-lg border border-green-200">
                                <div>
                                    <div class="font-semibold text-gray-900">All-in-one platform</div>
                                    <div class="text-sm text-gray-600">Everything included, no hidden fees</div>
                                </div>
                                <div class="text-xl font-bold text-green-600">$197</div>
                            </div>
                            <div class="flex justify-between items-center p-4 bg-white rounded-lg border border-green-200">
                                <div>
                                    <div class="font-semibold text-gray-900">Increased sales</div>
                                    <div class="text-sm text-gray-600">Better conversion, uptime, speed</div>
                                </div>
                                <div class="text-xl font-bold text-green-600">+$1,890</div>
                            </div>
                            <div class="flex justify-between items-center p-4 bg-white rounded-lg border border-green-200">
                                <div>
                                    <div class="font-semibold text-gray-900">Zero maintenance</div>
                                    <div class="text-sm text-gray-600">We handle everything for you</div>
                                </div>
                                <div class="text-xl font-bold text-green-600">$0</div>
                            </div>
                            <div class="border-t-2 border-green-300 pt-4">
                                <div class="flex justify-between items-center">
                                    <div class="text-lg font-bold text-gray-900">Net Monthly Gain</div>
                                    <div class="text-2xl font-bold text-green-600">+$5,770</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <div class="bg-gradient-to-r from-green-500 to-blue-600 text-white p-6 rounded-lg">
                        <div class="text-3xl font-bold mb-2">You Save $69,240 Per Year</div>
                        <div class="text-lg opacity-90">Plus earn an additional $22,680 from increased sales</div>
                    </div>
                    <a href="#" class="btn-primary text-lg px-8 py-4 mt-6 inline-flex items-center gap-2">
                        <span>Start Your 14-Day Free Trial</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Stories Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Real Results From Real Businesses
                </h2>
                <p class="text-xl text-gray-600">
                    See how our features solved real business problems
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Success Story 1 -->
                <div class="bg-white rounded-lg p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-bold">TC</span>
                        </div>
                        <div>
                            <div class="font-semibold">Tom Chen</div>
                            <div class="text-sm text-gray-600">Outdoor Gear Store</div>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "I was spending 30 hours a week just keeping my WordPress store running. Now I spend 30 minutes a week and my sales increased 240%."
                    </p>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>240% sales increase</span>
                    </div>
                </div>
                
                <!-- Success Story 2 -->
                <div class="bg-white rounded-lg p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-purple-600 font-bold">SM</span>
                        </div>
                        <div>
                            <div class="font-semibold">Sarah Martinez</div>
                            <div class="text-sm text-gray-600">Fashion Boutique</div>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Cart abandonment dropped from 78% to 31% after switching. The one-click checkout feature alone pays for the entire platform."
                    </p>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>60% better conversion</span>
                    </div>
                </div>
                
                <!-- Success Story 3 -->
                <div class="bg-white rounded-lg p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-green-600 font-bold">MJ</span>
                        </div>
                        <div>
                            <div class="font-semibold">Mike Johnson</div>
                            <div class="text-sm text-gray-600">Electronics Store</div>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "The automated inventory management saved me from stockouts that were costing $15K per month. ROI was immediate."
                    </p>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>95% fewer stockouts</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 to-purple-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl lg:text-4xl font-bold mb-6">
                Ready to Stop Losing Money to Technical Problems?
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Join 50,000+ businesses who switched to our platform and never looked back
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="#" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4 inline-flex items-center gap-2">
                    <span>Start Your Free Trial</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="#" class="btn-border border-white text-white hover:bg-white hover:text-blue-600 text-lg px-8 py-4 inline-flex items-center gap-2">
                    <span>Schedule a Demo</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </a>
            </div>
            
            <div class="flex flex-wrap justify-center items-center gap-6 text-sm opacity-75">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>14-day free trial</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>No credit card required</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Cancel anytime</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (get_theme_mod('features_comparison_enable', true)) : ?>
<!-- Feature Comparison Section -->
<section class="bg-gray-50 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('features_comparison_title', __('See What\'s Included in Every Plan', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('features_comparison_description', __('Every feature designed to solve real business problems', 'yoursite'))); ?>
                </p>
            </div>
            
            <?php 
            // Check if the comparison table function exists and render it
            if (function_exists('yoursite_render_pricing_comparison_table')) {
                echo yoursite_render_pricing_comparison_table();
            } else {
                // Fallback message if the comparison table is not available
                echo '<div class="text-center py-12">';
                echo '<p class="text-gray-500 text-lg mb-4">Feature comparison table is not available.</p>';
                if (current_user_can('manage_options')) {
                    echo '<p class="text-sm text-gray-400">Admin: Make sure pricing plans are created in WP-Admin → Pricing Plans</p>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>