<?php
/**
 * Template part for homepage - Benefits, Pricing & DIFM sections
 * Enhanced Zencommerce styling with proper structure
 */

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
?>

<!-- Key Benefits Section - Zencommerce Style -->
<?php if (get_theme_mod('benefits_enable', true)) : ?>
<section class="py-20 bg-secondary dark:bg-dark">
    <div class="layout-container">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold heading-highlight mb-4">
                <?php echo esc_html(get_theme_mod('benefits_title', __('Everything You Need to Succeed Online', 'yoursite'))); ?>
            </h2>
            <p class="text-xl text-secondary max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('benefits_subtitle', __('From beautiful storefronts to powerful analytics, we\'ve got you covered', 'yoursite'))); ?>
            </p>
        </div>
        
        <!-- Benefits Grid - 3 columns -->
        <div class="benefits-grid">
            <?php 
            // Default benefits data
            $default_benefits = array(
                1 => array(
                    'title' => 'Drag & Drop Builder',
                    'description' => 'Create stunning stores without coding. Our intuitive builder makes it easy to design your perfect storefront.',
                    'icon' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
                    'link' => '/features/drag-drop-builder'
                ),
                2 => array(
                    'title' => 'Secure Payments',
                    'description' => 'Accept payments from anywhere in the world with our secure, PCI-compliant payment processing.',
                    'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                    'link' => '/features/payments'
                ),
                3 => array(
                    'title' => 'Advanced Analytics',
                    'description' => 'Track your performance with detailed reports and insights to grow your business smarter.',
                    'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                    'link' => '/features/analytics'
                ),
                4 => array(
                    'title' => 'Mobile Optimized',
                    'description' => 'Your store looks perfect on every device. Responsive design that converts visitors into customers.',
                    'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                    'link' => '/features/mobile-responsive'
                ),
                5 => array(
                    'title' => 'SEO Optimized',
                    'description' => 'Built-in SEO tools help your store rank higher in search results and attract more customers.',
                    'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                    'link' => '/features/seo'
                ),
                6 => array(
                    'title' => '24/7 Support',
                    'description' => 'Get help when you need it. Our expert support team is available around the clock.',
                    'icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z',
                    'link' => '/support'
                )
            );
            
            for ($i = 1; $i <= 6; $i++) {
                $title = get_theme_mod("benefit_{$i}_title", isset($default_benefits[$i]['title']) ? $default_benefits[$i]['title'] : '');
                $description = get_theme_mod("benefit_{$i}_description", isset($default_benefits[$i]['description']) ? $default_benefits[$i]['description'] : '');
                $icon = get_theme_mod("benefit_{$i}_icon", isset($default_benefits[$i]['icon']) ? $default_benefits[$i]['icon'] : '');
                $link = get_theme_mod("benefit_{$i}_link", isset($default_benefits[$i]['link']) ? $default_benefits[$i]['link'] : '');
                
                // Skip if no title
                if (empty($title)) continue;
            ?>
            <div class="benefit-card">
                <div class="benefit-card-content">
                    <!-- Icon -->
                    <div class="benefit-icon">
                        <?php if (!empty($icon)) : ?>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($icon); ?>"></path>
                        </svg>
                        <?php else : ?>
                        <!-- Fallback icon -->
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content -->
                    <div class="benefit-content">
                        <h3 class="benefit-title"><?php echo esc_html($title); ?></h3>
                        <p class="benefit-description"><?php echo esc_html($description); ?></p>
                        
                        <?php if (!empty($link)) : ?>
                        <a href="<?php echo esc_url(home_url($link)); ?>" class="benefit-link">
                            Learn more
                            <svg class="benefit-link-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        
        <!-- Benefits CTA -->
        <div class="text-center mt-12">
            <a href="<?php echo home_url('/features'); ?>" class="btn btn-primary btn-l">
                Explore All Features
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Pricing Section - Enhanced with Dynamic Currency -->
<?php if (get_theme_mod('pricing_enable', true)) : ?>
<section class="py-20 bg-white dark:bg-dark-secondary">
    <div class="layout-container">
        <!-- Pricing Hero Section -->
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold heading-highlight mb-4">
                <?php echo esc_html(get_theme_mod('pricing_title', __('Simple, Transparent Pricing', 'yoursite'))); ?>
            </h2>
            <p class="text-xl text-secondary max-w-3xl mx-auto mb-8">
                <?php echo esc_html(get_theme_mod('pricing_subtitle', __('Start free, then choose the plan that scales with your business', 'yoursite'))); ?>
            </p>
            
            <!-- Trust Indicators -->
            <div class="flex items-center justify-center gap-6 text-sm text-secondary mb-8">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    4.9/5 rating
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    500+ stores built
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    30-day guarantee
                </span>
            </div>
            
            <!-- Billing Toggle -->
            <div class="flex items-center justify-center gap-6 mb-12">
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
        
        <!-- Pricing Cards Container -->
        <div class="pricing-cards-container">
            <?php
            // Get pricing plans
            $pricing_count = get_theme_mod('homepage_pricing_count', 3);
            $pricing_args = array(
                'post_type' => 'pricing',
                'posts_per_page' => $pricing_count,
                'post_status' => 'publish',
                'meta_key' => '_pricing_monthly_price',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
            );

            $pricing_plans = get_posts($pricing_args);

            if (!empty($pricing_plans)) :
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
            
            <!-- Pricing Card -->
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
                        $max_features = 8;
                        $display_features = array_slice($features_array, 0, $max_features);
                        
                        foreach ($display_features as $feature) :
                            $feature = trim($feature);
                            if (!empty($feature)) :
                        ?>
                        <li><?php echo esc_html($feature); ?></li>
                        <?php endif; endforeach; ?>
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
                        <div class="money-back-guarantee">30-day money back</div>
                        <?php if ($index === 0) : ?>
                        <div class="trial-notice">14-day free trial</div>
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
                    </ul>
                </div>
                
                <div class="pricing-card-footer">
                    <a href="#signup" class="pricing-btn pricing-btn-secondary pricing-button">
                        Start Free
                    </a>
                    <div class="trust-signals">
                        <div class="trial-notice">No credit card required</div>
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
                        <li class="premium-feature">Priority updates</li>
                    </ul>
                </div>
                
                <div class="pricing-card-footer">
                    <a href="#signup" class="pricing-btn pricing-btn-primary pricing-button">
                        Start Free Trial
                    </a>
                    <div class="trust-signals">
                        <div class="money-back-guarantee">30-day money back</div>
                        <div class="trial-notice">14-day free trial</div>
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
                    </ul>
                </div>
                
                <div class="pricing-card-footer">
                    <a href="#contact" class="pricing-btn pricing-btn-secondary pricing-button">
                        Contact Sales
                    </a>
                    <div class="trust-signals">
                        <div class="money-back-guarantee">30-day money back</div>
                    </div>
                </div>
            </div>
            
            <?php endif; ?>
        </div>
        
        <!-- Bottom CTA -->
        <div class="text-center mt-16 pt-8 border-t border-gray-200 dark:border-gray-700">
            <p class="text-secondary mb-4 text-lg">
                <?php echo esc_html(get_theme_mod('pricing_cta_text', __('All plans include 14-day free trial • No setup fees • Cancel anytime', 'yoursite'))); ?>
            </p>
            <a href="<?php echo home_url('/pricing'); ?>" class="text-primary hover:text-primary-dark font-medium text-lg">
                <?php echo esc_html(get_theme_mod('pricing_link_text', __('Compare all features →', 'yoursite'))); ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- DIFM Banner Section - Conversion Focused -->
<?php if (get_theme_mod('difm_banner_enable', true)) : ?>
<section class="relative overflow-hidden">
    <!-- Modern Background with Multiple Layers -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800"></div>
    <div class="absolute inset-0 bg-gradient-to-tl from-purple-600/20 via-transparent to-cyan-400/10"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-30">
        <!-- Floating Circles -->
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl animate-float"></div>
        <div class="absolute bottom-32 right-20 w-24 h-24 bg-cyan-300/20 rounded-full blur-lg animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-purple-300/15 rounded-full blur-md animate-float-slow"></div>
        
        <!-- Geometric Shapes -->
        <div class="absolute top-16 right-16 w-20 h-20 border border-white/20 rotate-45 animate-spin-slow"></div>
        <div class="absolute bottom-20 left-20 w-12 h-12 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 transform rotate-12 animate-pulse"></div>
    </div>
    
    <!-- Grid Pattern Overlay -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    
    <div class="relative z-10 py-24 lg:py-32">
        <div class="layout-container">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left Content -->
                <div class="text-center lg:text-left text-white">
                <!-- Badge -->
                <?php 
                $badge_text = get_theme_mod('difm_banner_badge_text', __('Done-For-You Service', 'yoursite'));
                if (!empty($badge_text)) :
                ?>
                <div class="inline-flex items-center rounded-full px-6 py-3 mb-6 text-sm font-bold bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 shadow-xl border-2 border-yellow-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                    </svg>
                    <?php echo esc_html($badge_text); ?>
                </div>
                <?php endif; ?>
                
                <!-- Main Heading -->
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 leading-tight text-white drop-shadow-lg">
                    <?php echo esc_html(get_theme_mod('difm_banner_title', __('Don\'t Want to Build It Yourself?', 'yoursite'))); ?>
                </h2>
                
                <!-- Subheading -->
                <p class="text-xl mb-8 leading-relaxed text-white drop-shadow-md">
                    <?php echo esc_html(get_theme_mod('difm_banner_subtitle', __('Let our expert team build your perfect store while you focus on your business. Professional results, guaranteed.', 'yoursite'))); ?>
                </p>
                
                <!-- Value Props -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <?php 
                    // Default features and icons for value props
                    $default_features = array(
                        1 => 'Expert Design',
                        2 => 'Fast Delivery',
                        3 => 'Full Support',
                        4 => 'Money-back Guarantee'
                    );
                    
                    $value_prop_icons = array(
                        1 => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                        2 => 'M13 10V3L4 14h7v7l9-11h-7z',
                        3 => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        4 => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'
                    );
                    
                    for ($i = 1; $i <= 4; $i++) {
                        $feature_text = get_theme_mod("difm_banner_feature_{$i}", isset($default_features[$i]) ? $default_features[$i] : '');
                        if (!empty(trim($feature_text))) :
                    ?>
                        <div class="flex items-center text-white">
                            <div class="w-6 h-6 mr-3 flex-shrink-0">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($value_prop_icons[$i]); ?>"></path>
                                </svg>
                            </div>
                            <span class="font-medium"><?php echo esc_html($feature_text); ?></span>
                        </div>
                    <?php 
                        endif;
                    }
                    ?>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <!-- PRIMARY CTA BUTTON -->
                    <?php 
                    $primary_text = get_theme_mod('difm_banner_primary_text', __('Build My Store', 'yoursite'));
                    $primary_url = get_theme_mod('difm_banner_primary_url', '/build-my-website');
                    if (!empty($primary_text)) :
                    ?>
                    <a href="<?php echo esc_url(home_url($primary_url)); ?>" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                        </svg>
                        <?php echo esc_html($primary_text); ?>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <?php endif; ?>
                    
                    <!-- Secondary CTA -->
                    <?php 
                    $secondary_text = get_theme_mod('difm_banner_secondary_text', __('Ask Questions', 'yoursite'));
                    $secondary_url = get_theme_mod('difm_banner_secondary_url', '/contact');
                    if (!empty($secondary_text)) :
                    ?>
                    <a href="<?php echo esc_url(home_url($secondary_url)); ?>" 
                       class="difm-secondary-btn inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg transition-all duration-200">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <?php echo esc_html($secondary_text); ?>
                    </a>
                    <?php endif; ?>
                </div>
                
                <!-- Trust Elements -->
                <div class="mt-8 pt-8 border-t border-white/20">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-white">
                        <?php 
                        $trust_rating = get_theme_mod('difm_banner_trust_rating', __('4.9/5 rating', 'yoursite'));
                        if (!empty($trust_rating)) :
                        ?>
                        <div class="flex items-center justify-center lg:justify-start bg-white/10 backdrop-blur-sm rounded-lg px-4 py-3 border border-white/20">
                            <svg class="w-5 h-5 text-yellow-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="font-semibold"><?php echo esc_html($trust_rating); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php 
                        $trust_count = get_theme_mod('difm_banner_trust_count', __('500+ stores built', 'yoursite'));
                        if (!empty($trust_count)) :
                        ?>
                        <div class="flex items-center justify-center lg:justify-start bg-white/10 backdrop-blur-sm rounded-lg px-4 py-3 border border-white/20">
                            <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="font-semibold"><?php echo esc_html($trust_count); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- 30-day guarantee box -->
                        <div class="flex items-center justify-center lg:justify-start bg-gradient-to-r from-green-500/20 to-emerald-500/20 backdrop-blur-sm rounded-lg px-4 py-3 border border-green-400/30 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-400/10 to-emerald-400/10 animate-pulse"></div>
                            <svg class="w-5 h-5 text-green-300 mr-2 flex-shrink-0 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold relative z-10">30-day guarantee</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Visual Element -->
            <div class="hidden lg:block">
                <div class="relative max-w-md mx-auto">
                    <!-- Main illustration container -->
                    <div class="relative bg-white/10 rounded-3xl p-8 backdrop-blur-sm border border-white/20">
                        <!-- Website mockup -->
                        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden transform rotate-3 hover:rotate-0 transition-transform duration-500">
                            <!-- Browser bar -->
                            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                    <div class="flex-1 bg-white rounded-sm h-6 ml-4 flex items-center px-3">
                                        <div class="w-3 h-3 text-green-500 mr-2">🔒</div>
                                        <div class="text-xs text-gray-500 font-mono">yourstore.com</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Website content -->
                            <div class="p-6 bg-white">
                                <div class="h-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded mb-3 w-3/4"></div>
                                <div class="h-3 bg-gray-200 rounded mb-2 w-full"></div>
                                <div class="h-3 bg-gray-200 rounded mb-4 w-2/3"></div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg"></div>
                                    <div class="h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating success indicator -->
                        <div class="absolute -top-2 -right-2 bg-green-500 text-white p-3 rounded-full shadow-lg animate-bounce">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Custom Animations -->
    <style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    @keyframes float-delayed {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(-3deg); }
    }
    
    @keyframes float-slow {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-10px) scale(1.1); }
    }
    
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-float-delayed {
        animation: float-delayed 8s ease-in-out infinite;
    }
    
    .animate-float-slow {
        animation: float-slow 10s ease-in-out infinite;
    }
    
    .animate-spin-slow {
        animation: spin-slow 20s linear infinite;
    }
    </style>
</section>
<?php endif; ?>

<style>
/* DIFM Secondary Button Styling */
.difm-secondary-btn {
    background: transparent;
    border: 2px solid white;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.difm-secondary-btn:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: white;
    transition: left 0.3s ease;
    z-index: 1;
}

.difm-secondary-btn:hover:before {
    left: 0;
}

.difm-secondary-btn:hover {
    background: white;
    color: #1e40af;
    border-color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
}

.difm-secondary-btn:hover svg,
.difm-secondary-btn:hover span {
    color: #1e40af !important;
}

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