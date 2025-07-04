<?php
/**
 * Template Name: Pricing Page - Conversion Optimized Zencommerce Style
 * Matches homepage-benefits-pricing-difm.php styling exactly
 */

get_header();

// Load required files
require_once get_template_directory() . '/inc/pricing-comparison-table.php';
require_once get_template_directory() . '/inc/pricing-shortcodes.php';

// Get current user currency with proper fallback
$current_currency = array(
    'code' => 'USD',
    'symbol' => '$'
);

if (function_exists('yoursite_get_user_currency')) {
    $user_currency = yoursite_get_user_currency();
    if (!empty($user_currency) && is_array($user_currency)) {
        $current_currency = $user_currency;
    }
}

// Get customizer settings
$hero_title = get_theme_mod('pricing_hero_title', 'Simple, Transparent Pricing');
$hero_subtitle = get_theme_mod('pricing_hero_subtitle', 'Choose the perfect plan for your business. Start free, upgrade when you\'re ready.');
$hero_description = get_theme_mod('pricing_hero_description', 'Join thousands of successful merchants who trust our platform to power their online stores. All plans include our 30-day money-back guarantee.');

$comparison_enable = get_theme_mod('pricing_comparison_enable', true);
$comparison_title = get_theme_mod('pricing_comparison_title', 'Compare All Plans');
$comparison_subtitle = get_theme_mod('pricing_comparison_subtitle', 'See what\'s included in each plan');

$faq_enable = get_theme_mod('pricing_faq_enable', true);
$faq_title = get_theme_mod('pricing_faq_title', 'Frequently Asked Questions');
$faq_subtitle = get_theme_mod('pricing_faq_subtitle', 'Quick answers to common pricing questions');

$cta_enable = get_theme_mod('pricing_cta_enable', true);
$cta_title = get_theme_mod('pricing_cta_title', 'Ready to grow your business?');
$cta_subtitle = get_theme_mod('pricing_cta_subtitle', 'Join thousands of successful merchants using our platform');
$cta_primary_text = get_theme_mod('pricing_cta_primary_text', 'Start Your Free Trial');
$cta_primary_url = get_theme_mod('pricing_cta_primary_url', '#');
$cta_secondary_text = get_theme_mod('pricing_cta_secondary_text', 'Talk to Sales');
$cta_secondary_url = get_theme_mod('pricing_cta_secondary_url', '/contact');

// Helper function for pricing meta
if (!function_exists('yoursite_get_pricing_meta_fields')) {
    function yoursite_get_pricing_meta_fields($post_id) {
        return array(
            'pricing_featured' => get_post_meta($post_id, '_pricing_featured', true),
            'pricing_monthly_price' => get_post_meta($post_id, '_pricing_monthly_price', true),
            'pricing_annual_price' => get_post_meta($post_id, '_pricing_annual_price', true),
            'pricing_currency' => get_post_meta($post_id, '_pricing_currency', true) ?: 'USD',
            'pricing_features' => get_post_meta($post_id, '_pricing_features', true),
            'pricing_button_text' => get_post_meta($post_id, '_pricing_button_text', true),
            'pricing_button_url' => get_post_meta($post_id, '_pricing_button_url', true)
        );
    }
}
?>

<div class="pricing-page">
    
    <!-- Hero Section with Integrated Pricing - Conversion Optimized -->
    <section class="py-20 bg-white dark:bg-dark-secondary relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800"></div>
<div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'%3E%3Cdefs%3E%3Cpattern id=\'grid\' width=\'10\' height=\'10\' patternUnits=\'userSpaceOnUse\'%3E%3Cpath d=\'M 10 0 L 0 0 0 10\' fill=\'none\' stroke=\'rgba(59,130,246,0.05)\' stroke-width=\'0.5\'/%3E%3C/pattern%3E%3C/defs%3E%3Crect width=\'100\' height=\'100\' fill=\'url(%23grid)\'/%3E%3C/svg%3E')] opacity-30"></div>
        
        <div class="layout-container relative z-10">
            
            <!-- Hero Content -->
            <div class="text-center mb-16 max-w-4xl mx-auto">
                <!-- Badge -->
                <div class="inline-flex items-center rounded-full px-6 py-3 mb-6 text-sm font-bold bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Trusted by 10,000+ Businesses
                </div>
                
                <h1 class="text-4xl lg:text-6xl font-bold heading-highlight mb-6 leading-tight">
                    <?php echo esc_html($hero_title); ?>
                </h1>
                
                <p class="text-xl lg:text-2xl text-secondary mb-8 leading-relaxed">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
                
                <?php if (!empty($hero_description)) : ?>
                <p class="text-lg text-tertiary mb-12 max-w-2xl mx-auto">
                    <?php echo esc_html($hero_description); ?>
                </p>
                <?php endif; ?>
                
                <!-- Currency Selector -->
                <?php if (function_exists('yoursite_should_display_currency_selector') && yoursite_should_display_currency_selector()) : ?>
                <div class="mb-8">
                    <div class="inline-flex items-center gap-3 bg-white dark:bg-gray-800 rounded-lg px-6 py-4 shadow-md border border-gray-200 dark:border-gray-700">
                        <span class="text-gray-700 dark:text-gray-300 font-medium">Currency:</span>
                        <?php 
                        echo yoursite_render_currency_selector(array(
                            'style' => 'dropdown',
                            'show_flag' => true,
                            'show_name' => false,
                            'show_symbol' => true,
                            'class' => 'pricing-currency-selector'
                        )); 
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Trust Indicators -->
                <div class="flex items-center justify-center gap-8 text-sm text-secondary mb-12 flex-wrap">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="font-semibold">4.9/5 rating</span>
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-semibold">10,000+ stores built</span>
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-semibold">30-day guarantee</span>
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="font-semibold">2-minute setup</span>
                    </span>
                </div>
                
                <!-- Billing Toggle - Exact Same Style -->
                <div class="flex items-center justify-center gap-6 mb-16">
                    <div class="billing-toggle-container">
                        <div class="billing-toggle-wrapper">
                            <span class="billing-label monthly-label">Monthly</span>
                            <label class="billing-switch">
                                <input type="checkbox" id="billing-toggle" checked>
                                <span class="billing-slider"></span>
                            </label>
                            <span class="billing-label annual-label">Annual</span>
                        </div>
                        <span class="savings-badge">
                            Save 20%
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Pricing Cards Container - Exact Same Style -->
            <div class="pricing-cards-container">
                <?php
                // Get pricing plans
                $args = array(
                    'post_type' => 'pricing',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'meta_key' => '_pricing_monthly_price',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC'
                );
                
                $pricing_plans = get_posts($args);
                
                if (!empty($pricing_plans)) :
                    foreach ($pricing_plans as $index => $plan) : 
                        $meta = yoursite_get_pricing_meta_fields($plan->ID);
                        $is_featured = $meta['pricing_featured'] === '1';
                        $features = $meta['pricing_features'];
                        $button_text = $meta['pricing_button_text'];
                        $button_url = $meta['pricing_button_url'];
                        
                        // Get pricing in current currency
                        $monthly_price = function_exists('yoursite_get_pricing_plan_price') 
                            ? yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'monthly')
                            : floatval($meta['pricing_monthly_price']);
                        
                        $annual_price = function_exists('yoursite_get_pricing_plan_price') 
                            ? yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'annual')
                            : floatval($meta['pricing_annual_price']);
                        
                        if ($annual_price == 0 && $monthly_price > 0) {
                            $annual_price = $monthly_price * 12 * 0.8;
                        }
                        $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                        
                        // Calculate savings
                        $savings = function_exists('yoursite_calculate_annual_savings') 
                            ? yoursite_calculate_annual_savings($plan->ID, $current_currency['code'])
                            : ($monthly_price * 12) - $annual_price;
                ?>
                
                <!-- Pricing Card - Exact Same Style -->
                <div class="pricing-card <?php echo $is_featured ? 'featured' : ''; ?>" data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                    
                    <!-- Card Header -->
                    <div class="pricing-card-header">
                        <h3 class="plan-name"><?php echo esc_html($plan->post_title); ?></h3>
                        <?php if ($plan->post_excerpt) : ?>
                        <p class="plan-description"><?php echo esc_html($plan->post_excerpt); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="price-section">
                        <!-- Monthly Pricing -->
                        <div class="monthly-pricing" style="display: none;">
                            <div class="price-display">
                                <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                                <span class="price-amount" data-price-type="monthly">
                                    <?php echo number_format($monthly_price, 0); ?>
                                </span>
                                <span class="price-period">/month</span>
                            </div>
                            <?php if ($monthly_price > 0) : ?>
                            <div class="price-note">Billed monthly</div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Annual Pricing -->
                        <div class="annual-pricing" style="display: block;">
                            <div class="price-display">
                                <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                                <span class="price-amount" data-price-type="annual-monthly">
                                    <?php echo number_format($annual_monthly, 0); ?>
                                </span>
                                <span class="price-period">/month</span>
                            </div>
                            <?php if ($annual_price > 0) : ?>
                            <div class="price-note">
                                Billed annually 
                                (<span data-price-type="annual">
                                    <?php echo esc_html($current_currency['symbol']) . number_format($annual_price, 0); ?>
                                </span>)
                            </div>
                            
                            <?php if ($savings > 0) : ?>
                            <div class="annual-savings">
                                💰 Save <span data-savings-amount>
                                    <?php echo esc_html($current_currency['symbol']) . number_format($savings, 0); ?>
                                </span>/year
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Features Section -->
                    <?php if (!empty($features)) : ?>
                    <div class="features-section">
                        <ul class="features-list">
                            <?php 
                            $features_array = array_filter(explode("\n", $features));
                            $max_features = 10;
                            $display_features = array_slice($features_array, 0, $max_features);
                            
                            foreach ($display_features as $feature) :
                                $feature = trim($feature);
                                if (!empty($feature)) :
                            ?>
                            <li><?php echo esc_html($feature); ?></li>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Card Footer -->
                    <div class="pricing-card-footer">
                        <a href="<?php echo esc_url($button_url ?: '#signup'); ?>" 
                           class="pricing-btn <?php echo $is_featured ? 'pricing-btn-primary' : 'pricing-btn-secondary'; ?> pricing-button"
                           data-monthly-url="<?php echo esc_url($button_url ?: '#signup'); ?>"
                           data-annual-url="<?php echo esc_url(str_replace('monthly', 'annual', $button_url ?: '#signup')); ?>">
                            <?php echo esc_html($button_text ?: __('Get Started', 'yoursite')); ?>
                        </a>
                        
                        <!-- Trust Signals -->
                        <div class="trust-signals">
                            <div class="free-plugins">🎁 <u>28 Plugins</u> worth <strong>$50</strong> included</div>
                            <?php if ($index === 0) : ?>
                            <div class="trial-notice">⏱️ 14-day free trial</div>
                            <?php else : ?>
                            <div class="money-back-guarantee">🛡️ 30-day money back</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <?php endforeach; ?>
                
                <?php else : ?>
                <!-- Fallback Pricing if no pricing posts exist -->
                
                <!-- Free Plan -->
                <div class="pricing-card" data-plan-id="free">
                    <div class="pricing-card-header">
                        <h3 class="plan-name">Free</h3>
                        <p class="plan-description">Perfect for getting started</p>
                    </div>
                    
                    <div class="price-section">
                        <div class="monthly-pricing" style="display: none;">
                            <div class="price-display">
                                <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                                <span class="price-amount">0</span>
                                <span class="price-period">/month</span>
                            </div>
                        </div>
                        <div class="annual-pricing" style="display: block;">
                            <div class="price-display">
                                <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                                <span class="price-amount">0</span>
                                <span class="price-period">/month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="features-section">
                        <ul class="features-list">
                            <li>Up to 100 products</li>
                            <li>Basic templates</li>
                            <li>SSL certificate</li>
                            <li>Community support</li>
                            <li>Mobile responsive</li>
                        </ul>
                    </div>
                    
                    <div class="pricing-card-footer">
                        <a href="#signup" class="pricing-btn pricing-btn-secondary pricing-button">
                            Start Free
                        </a>
                        <div class="trust-signals">
                            <div class="trial-notice">⏱️ No credit card required</div>
                        </div>
                    </div>
                </div>
                
                <!-- Pro Plan -->
                <div class="pricing-card featured" data-plan-id="pro">
                    <div class="pricing-card-header">
                        <h3 class="plan-name">Pro</h3>
                        <p class="plan-description">For growing businesses</p>
                    </div>
                    
                    <div class="price-section">
                        <div class="monthly-pricing" style="display: none;">
                            <div class="price-display">
                                <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                                <span class="price-amount">29</span>
                                <span class="price-period">/month</span>
                            </div>
                            <div class="price-note">Billed monthly</div>
                        </div>
                        <div class="annual-pricing" style="display: block;">
                            <div class="price-display">
                                <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                                <span class="price-amount">23</span>
                                <span class="price-period">/month</span>
                            </div>
                            <div class="price-note">Billed annually (<?php echo esc_html($current_currency['symbol']); ?>276)</div>
                            <div class="annual-savings">
                                💰 Save <?php echo esc_html($current_currency['symbol']); ?>72/year
                            </div>
                        </div>
                    </div>
                    
                    <div class="features-section">
                        <ul class="features-list">
                            <li>Up to 1000 products</li>
                            <li>Premium templates</li>
                            <li>24/7 support</li>
                            <li>SSL certificate</li>
                            <li>Advanced analytics</li>
                            <li>Custom domain</li>
                            <li class="premium-feature">Priority updates</li>
                            <li class="premium-feature">Email marketing</li>
                        </ul>
                    </div>
                    
                    <div class="pricing-card-footer">
                        <a href="#signup" class="pricing-btn pricing-btn-primary pricing-button">
                            Start Free Trial
                        </a>
                        <div class="trust-signals">
                            <div class="free-plugins">🎁 <u>28 Plugins</u> worth <strong>$50</strong> included</div>
                            <div class="money-back-guarantee">🛡️ 30-day money back</div>
                        </div>
                    </div>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="pricing-card" data-plan-id="enterprise">
                    <div class="pricing-card-header">
                        <h3 class="plan-name">Enterprise</h3>
                        <p class="plan-description">For large organizations</p>
                    </div>
                    
                    <div class="price-section">
                        <div class="monthly-pricing" style="display: none;">
                            <div class="price-display">
                                <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                                <span class="price-amount">99</span>
                                <span class="price-period">/month</span>
                            </div>
                            <div class="price-note">Billed monthly</div>
                        </div>
                        <div class="annual-pricing" style="display: block;">
                            <div class="price-display">
                                <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                                <span class="price-amount">79</span>
                                <span class="price-period">/month</span>
                            </div>
                            <div class="price-note">Billed annually (<?php echo esc_html($current_currency['symbol']); ?>948)</div>
                            <div class="annual-savings">
                                💰 Save <?php echo esc_html($current_currency['symbol']); ?>240/year
                            </div>
                        </div>
                    </div>
                    
                    <div class="features-section">
                        <ul class="features-list">
                            <li>Unlimited products</li>
                            <li>Custom templates</li>
                            <li>Dedicated support</li>
                            <li>SSL certificate</li>
                            <li>Advanced analytics</li>
                            <li>Multi-store management</li>
                            <li class="premium-feature">White-label options</li>
                            <li class="premium-feature">API access</li>
                            <li class="premium-feature">Custom integrations</li>
                            <li class="premium-feature">Priority phone support</li>
                        </ul>
                    </div>
                    
                    <div class="pricing-card-footer">
                        <a href="#contact" class="pricing-btn pricing-btn-secondary pricing-button">
                            Contact Sales
                        </a>
                        <div class="trust-signals">
                            <div class="free-plugins">🎁 <u>28 Plugins</u> worth <strong>$50</strong> included</div>
                            <div class="money-back-guarantee">🛡️ 30-day money back</div>
                        </div>
                    </div>
                </div>
                
                <?php endif; ?>
            </div>
            
            <!-- Bottom CTA in Hero -->
            <div class="text-center mt-16 pt-8">
                <p class="text-secondary mb-6 text-lg max-w-2xl mx-auto">
                    All plans include 14-day free trial • No setup fees • Cancel anytime • 99.9% uptime guarantee
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#comparison" class="inline-flex items-center text-primary hover:text-primary-dark font-semibold text-lg transition-all duration-200 hover:transform hover:scale-105">
                        Compare all features
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <span class="text-gray-400">or</span>
                    <a href="<?php echo home_url('/contact'); ?>" class="inline-flex items-center text-secondary hover:text-primary font-medium transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Talk to our team
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php if ($comparison_enable) : ?>
    <!-- Comparison Table Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800" id="comparison">
        <div class="layout-container">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold heading-highlight mb-4">
                    <?php echo esc_html($comparison_title); ?>
                </h2>
                <p class="text-xl text-secondary max-w-2xl mx-auto">
                    <?php echo esc_html($comparison_subtitle); ?>
                </p>
            </div>
            
            <!-- Comparison Table -->
            <?php echo yoursite_render_pricing_comparison_table(); ?>
            
            <!-- Post-Comparison CTA -->
            <div class="text-center mt-16 p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-bold mb-4 text-primary">Still have questions?</h3>
                <p class="text-secondary mb-6">Our team is here to help you choose the perfect plan for your business.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo home_url('/contact'); ?>" class="pricing-btn pricing-btn-primary">
                        Schedule a Demo
                    </a>
                    <a href="mailto:sales@yoursite.biz" class="pricing-btn pricing-btn-secondary">
                        Email Sales Team
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($faq_enable) : ?>
    <!-- FAQ Section - Same Style as Homepage -->
    <section class="faq-section py-20 bg-white dark:bg-dark">
        <div class="layout-container">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold heading-highlight mb-4">
                    <?php echo esc_html($faq_title); ?>
                </h2>
                <p class="text-xl text-secondary max-w-2xl mx-auto">
                    <?php echo esc_html($faq_subtitle); ?>
                </p>
            </div>
            
            <ul class="faq-list">
                <?php 
                $faq_count = 0;
                
                // Default FAQ data - pricing focused
                $default_faqs = array(
                    1 => array(
                        'question' => 'Can I change plans anytime?', 
                        'answer' => 'Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle, and we\'ll prorate any differences.'
                    ),
                    2 => array(
                        'question' => 'Is there a free trial?', 
                        'answer' => 'Yes, all paid plans come with a 14-day free trial. No credit card required to get started. You can also use our Free plan indefinitely.'
                    ),
                    3 => array(
                        'question' => 'What payment methods do you accept?', 
                        'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for enterprise customers.'
                    ),
                    4 => array(
                        'question' => 'Do you offer refunds?', 
                        'answer' => 'Yes, we offer a 30-day money-back guarantee. If you\'re not satisfied with our service, contact us within 30 days for a full refund.'
                    ),
                    5 => array(
                        'question' => 'Can I cancel anytime?', 
                        'answer' => 'Absolutely! You can cancel your subscription at any time. Your account will remain active until the end of your current billing period.'
                    ),
                    6 => array(
                        'question' => 'Are there any setup fees?', 
                        'answer' => 'No, there are no setup fees or hidden costs. The price you see is exactly what you pay. All plans include free setup and migration assistance.'
                    ),
                    7 => array(
                        'question' => 'What happens to my data if I cancel?', 
                        'answer' => 'Your data remains accessible for 30 days after cancellation. You can export all your data, and we\'ll help you migrate to another platform if needed.'
                    ),
                    8 => array(
                        'question' => 'Do you offer discounts for nonprofits?', 
                        'answer' => 'Yes, we offer a 20% discount for registered nonprofits and educational institutions. Contact our sales team to verify your eligibility.'
                    )
                );
                
                for ($i = 1; $i <= 8; $i++) : 
                    $faq_enabled = get_theme_mod("pricing_faq_{$i}_enable", true);
                    $question = get_theme_mod("pricing_faq_{$i}_question", isset($default_faqs[$i]['question']) ? $default_faqs[$i]['question'] : '');
                    $answer = get_theme_mod("pricing_faq_{$i}_answer", isset($default_faqs[$i]['answer']) ? $default_faqs[$i]['answer'] : '');
                    
                    if (!$faq_enabled || empty(trim($question)) || empty(trim($answer))) {
                        continue;
                    }
                    
                    $faq_count++;
                ?>
                    <li class="faq-item">
                        <button class="faq-toggle" type="button" aria-expanded="false">
                            <h3><?php echo esc_html($question); ?></h3>
                            <svg class="faq-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content">
                            <div class="faq-content-inner">
                                <p><?php echo esc_html($answer); ?></p>
                            </div>
                        </div>
                    </li>
                <?php endfor; 
                
                if ($faq_count === 0 && current_user_can('manage_options')) : ?>
                    <li class="faq-item">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                            <p class="text-yellow-800"><strong>Admin Notice:</strong> No FAQ items are being displayed. Check <strong>Appearance → Customize → Pricing Page</strong> to configure your FAQs.</p>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            
            <!-- FAQ Bottom CTA -->
            <div class="text-center mt-16 p-8 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl">
                <h3 class="text-2xl font-bold mb-4">Didn't find what you're looking for?</h3>
                <p class="text-secondary mb-6">Our support team is always happy to help with any questions.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo home_url('/contact'); ?>" class="pricing-btn pricing-btn-primary">
                        Contact Support
                    </a>
                    <a href="<?php echo home_url('/help'); ?>" class="pricing-btn pricing-btn-secondary">
                        Browse Help Center
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($cta_enable) : ?>
    <!-- Final CTA Section -->
    <section class="py-20 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 text-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gradient-to-tl from-purple-600/20 via-transparent to-cyan-400/10"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl animate-float"></div>
            <div class="absolute bottom-32 right-20 w-24 h-24 bg-cyan-300/20 rounded-full blur-lg animate-float-delayed"></div>
        </div>
        
        <div class="layout-container relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h2 class="text-3xl lg:text-5xl font-bold mb-6 text-white">
                    <?php echo esc_html($cta_title); ?>
                </h2>
                <p class="text-xl lg:text-2xl mb-8 text-white/90 leading-relaxed">
                    <?php echo esc_html($cta_subtitle); ?>
                </p>
                
                <!-- Final Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2">10,000+</div>
                        <div class="text-white/80">Happy Customers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2">99.9%</div>
                        <div class="text-white/80">Uptime Guarantee</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2">24/7</div>
                        <div class="text-white/80">Expert Support</div>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <?php if (!empty($cta_primary_text)) : ?>
                    <a href="<?php echo esc_url(home_url($cta_primary_url)); ?>" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-bold text-lg rounded-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-xl">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7"></path>
                        </svg>
                        <?php echo esc_html($cta_primary_text); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($cta_secondary_text)) : ?>
                    <a href="<?php echo esc_url(home_url($cta_secondary_url)); ?>" 
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-semibold text-lg rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <?php echo esc_html($cta_secondary_text); ?>
                    </a>
                    <?php endif; ?>
                </div>
                
                <!-- Trust Elements -->
                <div class="mt-12 pt-8 border-t border-white/20">
                    <div class="flex flex-wrap justify-center items-center gap-8 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>14-day free trial</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>No setup fees</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Cancel anytime</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>30-day money back guarantee</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</div>

<!-- Enhanced JavaScript - Same as Homepage -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== PRICING PAGE LOADED ===');

    // Billing toggle functionality - Same as homepage
    const billingToggle = document.getElementById('billing-toggle');
    const pricingCards = document.querySelectorAll('.pricing-card');
    
    // Handle toggle switch
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            switchBillingDisplay(this.checked);
        });
    }
    
    function switchBillingDisplay(isAnnual) {
        // Update label styling
        const monthlyLabel = document.querySelector('.monthly-label');
        const annualLabel = document.querySelector('.annual-label');
        
        if (monthlyLabel && annualLabel) {
            if (isAnnual) {
                monthlyLabel.style.background = 'transparent';
                monthlyLabel.style.color = 'var(--zc-text-secondary, #6b7280)';
                monthlyLabel.style.boxShadow = 'none';
                
                annualLabel.style.background = 'var(--zc-primary, #3b82f6)';
                annualLabel.style.color = 'white';
                annualLabel.style.boxShadow = '0 2px 4px rgba(59, 130, 246, 0.2)';
            } else {
                monthlyLabel.style.background = 'var(--zc-primary, #3b82f6)';
                monthlyLabel.style.color = 'white';
                monthlyLabel.style.boxShadow = '0 2px 4px rgba(59, 130, 246, 0.2)';
                
                annualLabel.style.background = 'transparent';
                annualLabel.style.color = 'var(--zc-text-secondary, #6b7280)';
                annualLabel.style.boxShadow = 'none';
            }
        }
        
        pricingCards.forEach(function(card) {
            const monthlyDisplay = card.querySelector('.monthly-pricing');
            const annualDisplay = card.querySelector('.annual-pricing');
            const pricingButton = card.querySelector('.pricing-button');
            
            if (monthlyDisplay && annualDisplay) {
                if (isAnnual) {
                    monthlyDisplay.style.display = 'none';
                    annualDisplay.style.display = 'block';
                } else {
                    monthlyDisplay.style.display = 'block';
                    annualDisplay.style.display = 'none';
                }
            }
            
            // Update button URL if available
            if (pricingButton && pricingButton.tagName === 'A') {
                const newUrl = isAnnual ? 
                    pricingButton.dataset.annualUrl : 
                    pricingButton.dataset.monthlyUrl;
                
                if (newUrl) {
                    pricingButton.href = newUrl;
                }
            }
        });
    }
    
    // Add click handlers for labels
    const monthlyLabel = document.querySelector('.monthly-label');
    const annualLabel = document.querySelector('.annual-label');
    
    if (monthlyLabel) {
        monthlyLabel.addEventListener('click', function() {
            billingToggle.checked = false;
            switchBillingDisplay(false);
        });
    }
    
    if (annualLabel) {
        annualLabel.addEventListener('click', function() {
            billingToggle.checked = true;
            switchBillingDisplay(true);
        });
    }
    
    // Initialize with annual billing selected by default
    switchBillingDisplay(true);
    
    // FAQ functionality - Same as homepage
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(function(item) {
        const toggle = item.querySelector('.faq-toggle');
        const content = item.querySelector('.faq-content');
        
        if (toggle && content) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                const isActive = item.classList.contains('active');
                
                // Close all other FAQs
                faqItems.forEach(function(otherItem) {
                    otherItem.classList.remove('active');
                    const otherToggle = otherItem.querySelector('.faq-toggle');
                    const otherContent = otherItem.querySelector('.faq-content');
                    if (otherToggle) otherToggle.setAttribute('aria-expanded', 'false');
                    if (otherContent) otherContent.classList.remove('active');
                });
                
                // Toggle current FAQ
                if (!isActive) {
                    item.classList.add('active');
                    toggle.setAttribute('aria-expanded', 'true');
                    content.classList.add('active');
                }
            });
        }
    });
    
    // Smooth scroll for comparison section
    const compareLink = document.querySelector('a[href="#comparison"]');
    if (compareLink) {
        compareLink.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector('#comparison');
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
    
    // Currency change handling
    document.addEventListener('currencyChanged', function(e) {
        updateAllPricing(e.detail.currency);
    });
    
    function updateAllPricing(currencyCode) {
        console.log('Updating pricing to currency:', currencyCode);
        
        // Add your currency update logic here
        // This should match the logic from the homepage template
    }
    
    // Add loading states for pricing cards
    function setLoadingState(active) {
        const pricingSection = document.querySelector('.pricing-cards-container');
        if (pricingSection) {
            pricingSection.style.opacity = active ? '0.7' : '';
            pricingSection.style.pointerEvents = active ? 'none' : '';
        }
    }
    
    console.log('Pricing page setup complete');
});

// Animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    @keyframes float-delayed {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(-3deg); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-float-delayed {
        animation: float-delayed 8s ease-in-out infinite;
    }
`;
document.head.appendChild(style);
</script>

<style>
/* Billing Toggle Styling */
.billing-toggle-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
}

.billing-toggle-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--zc-bg-secondary, #f3f4f6);
    border-radius: 50px;
    padding: 0.5rem;
    border: 1px solid var(--zc-border, #e5e7eb);
}

.billing-label {
    font-size: 0.9rem;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    transition: all 0.3s ease;
    cursor: pointer;
    user-select: none;
    min-width: 80px;
    text-align: center;
}

.billing-label.monthly-label {
    color: var(--zc-text-secondary, #6b7280);
}

.billing-label.annual-label {
    color: var(--zc-text-secondary, #6b7280);
    background: var(--zc-primary, #3b82f6);
    color: white;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}

.billing-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    margin: 0 0.5rem;
}

.billing-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.billing-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--zc-bg-tertiary, #e5e7eb);
    transition: 0.3s;
    border-radius: 34px;
    border: 2px solid var(--zc-border, #d1d5db);
}

.billing-slider:before {
    position: absolute;
    content: "";
    height: 24px;
    width: 24px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.billing-switch input:checked + .billing-slider {
    background-color: var(--zc-primary, #3b82f6);
    border-color: var(--zc-primary, #3b82f6);
}

.billing-switch input:focus + .billing-slider {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.billing-switch input:checked + .billing-slider:before {
    transform: translateX(26px);
}

.savings-badge {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    white-space: nowrap;
    position: relative;
    animation: pulse-glow 2s ease-in-out infinite;
}

.savings-badge:before {
    content: '';
    position: absolute;
    left: -6px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-top: 6px solid transparent;
    border-bottom: 6px solid transparent;
    border-right: 6px solid #10b981;
}

@keyframes pulse-glow {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    50% {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }
}

/* Benefits Section - Zencommerce Style */
.benefits-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 2rem;
    max-width: 100%;
    margin: 0 auto;
}

@media (min-width: 768px) {
    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .benefits-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.benefit-card {
    background: var(--zc-bg-primary, #ffffff);
    border: 1px solid var(--zc-border, #e5e7eb);
    border-radius: var(--zc-radius-lg, 12px);
    padding: 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.benefit-card:hover {
    box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    transform: translateY(-4px);
    border-color: var(--zc-primary, #3b82f6);
}

.benefit-card-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.benefit-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--zc-primary, #3b82f6) 0%, var(--zc-primary-dark, #2563eb) 100%);
    border-radius: var(--zc-radius-lg, 12px);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

.benefit-icon svg {
    width: 28px;
    height: 28px;
}

.benefit-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.benefit-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--zc-text-primary, #1f2937);
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.benefit-description {
    color: var(--zc-text-secondary, #6b7280);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex: 1;
}

.benefit-link {
    color: var(--zc-primary, #3b82f6);
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    margin-top: auto;
}

.benefit-link:hover {
    color: var(--zc-primary-dark, #2563eb);
    text-decoration: none;
    transform: translateX(4px);
}

.benefit-link-arrow {
    width: 16px;
    height: 16px;
    transition: transform 0.2s ease;
}

.benefit-link:hover .benefit-link-arrow {
    transform: translateX(2px);
}

/* Pricing Cards - Same width as testimonial boxes */
.pricing-cards-container {
    display: grid !important;
    grid-template-columns: repeat(1, 1fr) !important;
    gap: 2rem !important;
    max-width: 100% !important;
    margin: 0 auto !important;
    padding: 0 1rem !important;
}

@media (min-width: 768px) {
    .pricing-cards-container {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 2rem !important;
        padding: 0 2rem !important;
    }
}

/* Ensure cards have proper flex layout and equal heights */
.pricing-card {
    display: flex !important;
    flex-direction: column !important;
    height: 100% !important;
    min-height: 520px !important;
    position: relative !important;
    background: var(--zc-bg-primary, #ffffff);
    border: 1px solid var(--zc-border, #e5e7eb);
    border-radius: var(--zc-radius-lg, 12px);
    padding: 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
}

.pricing-card.featured {
    border-color: var(--zc-primary, #3b82f6);
    border-width: 2px;
    transform: scale(1.05);
    box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

.pricing-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
}

.pricing-card.featured:hover {
    transform: translateY(-8px) scale(1.02) !important;
}

.pricing-card-header {
    text-align: center;
    margin-bottom: 2rem;
}

.plan-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--zc-text-primary, #1f2937);
    margin-bottom: 0.5rem;
}

.plan-description {
    color: var(--zc-text-secondary, #6b7280);
    font-size: 1rem;
}

.price-section {
    text-align: center;
    margin-bottom: 2rem;
}

.price-display {
    display: flex;
    align-items: baseline;
    justify-content: center;
    margin-bottom: 0.5rem;
}

.price-currency {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--zc-text-primary, #1f2937);
}

.price-amount {
    font-size: 3rem;
    font-weight: 700;
    color: var(--zc-text-primary, #1f2937);
    margin: 0 0.25rem;
}

.price-period {
    font-size: 1rem;
    color: var(--zc-text-secondary, #6b7280);
}

.price-note {
    color: var(--zc-text-secondary, #6b7280);
    font-size: 0.9rem;
}

.annual-savings {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #16a34a;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-top: 0.75rem;
    text-align: center;
    animation: subtle-bounce 3s ease-in-out infinite;
}

@keyframes subtle-bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}

.features-section {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    margin-bottom: 2rem;
}

.features-list {
    flex: 1 !important;
    list-style: none;
    padding: 0;
    margin: 0;
}

.features-list li {
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--zc-border, #e5e7eb);
    position: relative;
    padding-left: 1.5rem;
}

.features-list li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #16a34a;
    font-weight: bold;
}

.features-list li:last-child {
    border-bottom: none;
}

.features-list li.premium-feature {
    color: var(--zc-primary, #3b82f6);
    font-weight: 500;
}

.pricing-card-footer {
    margin-top: auto;
}

.pricing-btn {
    display: block;
    width: 100%;
    padding: 1rem 2rem;
    text-align: center;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
    margin-bottom: 1rem;
}

.pricing-btn-primary {
    background: var(--zc-primary, #3b82f6);
    color: white;
    border: 2px solid var(--zc-primary, #3b82f6);
}

.pricing-btn-primary:hover {
    background: var(--zc-primary-dark, #2563eb);
    border-color: var(--zc-primary-dark, #2563eb);
    transform: translateY(-2px);
}

.pricing-btn-secondary {
    background: transparent;
    color: var(--zc-primary, #3b82f6);
    border: 2px solid var(--zc-primary, #3b82f6);
}

.pricing-btn-secondary:hover {
    background: var(--zc-primary, #3b82f6);
    color: white;
    transform: translateY(-2px);
}

.trust-signals {
    text-align: center;
    font-size: 0.85rem;
    color: var(--zc-text-secondary, #6b7280);
}

.trust-signals > div {
    margin-bottom: 0.25rem;
}

/* Mobile responsive fixes */
@media (max-width: 768px) {
    .pricing-cards-container {
        padding: 0 0.5rem !important;
        gap: 1.5rem !important;
    }
    
    .pricing-card {
        min-height: auto !important;
    }
    
    .benefits-grid {
        gap: 1.5rem;
    }
    
    .benefit-card {
        padding: 1.5rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .benefit-card {
        background: var(--zc-card-bg, #1f2937);
        border-color: var(--zc-card-border, #374151);
    }
    
    .pricing-card {
        background: var(--zc-card-bg, #1f2937);
        border-color: var(--zc-card-border, #374151);
    }
    
    .benefit-title,
    .plan-name {
        color: var(--zc-text-primary, #f9fafb);
    }
    
    .benefit-description,
    .plan-description,
    .price-note {
        color: var(--zc-text-secondary, #d1d5db);
    }
}

/* Accessibility improvements */
.benefit-card:focus-within,
.pricing-card:focus-within {
    outline: 2px solid var(--zc-primary, #3b82f6);
    outline-offset: 2px;
}

.benefit-link:focus,
.pricing-btn:focus {
    outline: 2px solid var(--zc-primary, #3b82f6);
    outline-offset: 2px;
}

/* Reduce motion for users who prefer it */
@media (prefers-reduced-motion: reduce) {
    .benefit-card,
    .pricing-card,
    .pricing-btn,
    .annual-savings {
        transition: none !important;
        animation: none !important;
    }
    
    .benefit-card:hover,
    .pricing-card:hover {
        transform: none !important;
    }
}
</style>

<!-- JavaScript for Dynamic Currency and Billing -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Billing toggle functionality
    const billingToggle = document.getElementById('billing-toggle');
    const pricingCards = document.querySelectorAll('.pricing-card');
    
    // Handle toggle switch
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            switchBillingDisplay(this.checked);
        });
    }
    
    function switchBillingDisplay(isAnnual) {
        // Update label styling
        const monthlyLabel = document.querySelector('.monthly-label');
        const annualLabel = document.querySelector('.annual-label');
        
        if (monthlyLabel && annualLabel) {
            if (isAnnual) {
                monthlyLabel.style.background = 'transparent';
                monthlyLabel.style.color = 'var(--zc-text-secondary, #6b7280)';
                monthlyLabel.style.boxShadow = 'none';
                
                annualLabel.style.background = 'var(--zc-primary, #3b82f6)';
                annualLabel.style.color = 'white';
                annualLabel.style.boxShadow = '0 2px 4px rgba(59, 130, 246, 0.2)';
            } else {
                monthlyLabel.style.background = 'var(--zc-primary, #3b82f6)';
                monthlyLabel.style.color = 'white';
                monthlyLabel.style.boxShadow = '0 2px 4px rgba(59, 130, 246, 0.2)';
                
                annualLabel.style.background = 'transparent';
                annualLabel.style.color = 'var(--zc-text-secondary, #6b7280)';
                annualLabel.style.boxShadow = 'none';
            }
        }
        
        pricingCards.forEach(function(card) {
            const monthlyDisplay = card.querySelector('.monthly-pricing');
            const annualDisplay = card.querySelector('.annual-pricing');
            const pricingButton = card.querySelector('.pricing-button');
            
            if (monthlyDisplay && annualDisplay) {
                if (isAnnual) {
                    monthlyDisplay.style.display = 'none';
                    annualDisplay.style.display = 'block';
                } else {
                    monthlyDisplay.style.display = 'block';
                    annualDisplay.style.display = 'none';
                }
            }
            
            // Update button URL if available
            if (pricingButton && pricingButton.tagName === 'A') {
                const newUrl = isAnnual ? 
                    pricingButton.dataset.annualUrl : 
                    pricingButton.dataset.monthlyUrl;
                
                if (newUrl) {
                    pricingButton.href = newUrl;
                }
            }
        });
    }
    
    // Add click handlers for labels
    const monthlyLabel = document.querySelector('.monthly-label');
    const annualLabel = document.querySelector('.annual-label');
    
    if (monthlyLabel) {
        monthlyLabel.addEventListener('click', function() {
            billingToggle.checked = false;
            switchBillingDisplay(false);
        });
    }
    
    if (annualLabel) {
        annualLabel.addEventListener('click', function() {
            billingToggle.checked = true;
            switchBillingDisplay(true);
        });
    }
    
    // Initialize with annual billing selected by default
    switchBillingDisplay(true);
    
    // Smooth scrolling for benefit links
    document.querySelectorAll('.benefit-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Add a subtle click effect
            this.style.transform = 'translateX(2px)';
            const self = this;
            setTimeout(function() {
                self.style.transform = '';
            }, 150);
        });
    });
});
</script>

<?php get_footer(); ?>