<?php
/**
 * Template part for homepage - Benefits, Pricing & DIFM sections
 * Enhanced with Dynamic Currency Support - ZENCOMMERCE COMPATIBLE
 */

// Get current user currency
$current_currency = yoursite_get_user_currency();
?>

<!-- Key Benefits - Feature Rich -->
<?php if (get_theme_mod('benefits_enable', true)) : ?>
<section class="py-20 bg-secondary dark:bg-dark">
    <div class="container">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold heading-highlight mb-4">
                    <?php echo esc_html(get_theme_mod('benefits_title', __('Everything You Need to Succeed Online', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-secondary max-w-3xl mx-auto">
                    <?php echo esc_html(get_theme_mod('benefits_subtitle', __('From beautiful storefronts to powerful analytics, we\'ve got you covered', 'yoursite'))); ?>
                </p>
            </div>
            
            <!-- Benefits Grid -->
            <div class="features-grid">
                <?php 
                for ($i = 1; $i <= 6; $i++) {
                    $title = get_theme_mod("benefit_{$i}_title", '');
                    $description = get_theme_mod("benefit_{$i}_description", '');
                    $color = get_theme_mod("benefit_{$i}_color", 'blue');
                    $icon = get_theme_mod("benefit_{$i}_icon", '');
                    
                    // Default icons if none specified
                    $default_icons = array(
                        1 => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                        2 => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                        3 => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                        4 => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        5 => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4',
                        6 => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'
                    );
                    
                    if (empty($icon) && isset($default_icons[$i])) {
                        $icon = $default_icons[$i];
                    }
                    
                    // Skip if no title
                    if (empty($title)) continue;
                ?>
                <div class="feature-card hover-lift">
                    <div class="icon-circle icon-primary mb-6">
                        <?php if (!empty($icon)) : ?>
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($icon); ?>"></path>
                        </svg>
                        <?php else : ?>
                        <!-- Fallback icon -->
                        <div class="w-7 h-7 bg-highlight rounded"></div>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-primary text-center">
                        <?php echo esc_html($title); ?>
                    </h3>
                    <?php if (!empty($description)) : ?>
                    <p class="text-secondary text-center leading-relaxed">
                        <?php echo esc_html($description); ?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Pricing Section - Enhanced with Dynamic Currency -->
<?php if (get_theme_mod('pricing_enable', true)) : ?>
<section class="py-20 bg-primary" id="pricing-section">
    <div class="container">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header with Currency Selector -->
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-4">
                    <?php echo esc_html(get_theme_mod('pricing_title', __('Simple, Transparent Pricing', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-secondary max-w-3xl mx-auto mb-8">
                    <?php echo esc_html(get_theme_mod('pricing_subtitle', __('Start free, then choose the plan that scales with your business', 'yoursite'))); ?>
                </p>
                
                <!-- Currency Selector -->
                <?php if (function_exists('yoursite_should_display_currency_selector') && yoursite_should_display_currency_selector()) : ?>
                <div class="l-flex l-flex-center l-flex-wrap l-spacing-smaller mb-8">
                    <div class="l-flex l-flex-vcenter l-spacing-smaller">
                        <span class="text-secondary font-medium">
                            <?php _e('Currency:', 'yoursite'); ?>
                        </span>
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
                
                <!-- Billing Toggle -->
                <div class="billing-toggle-container mb-8">
                    <button class="billing-btn monthly-btn" data-billing="monthly">
                        Monthly
                    </button>
                    <button class="billing-btn annual-btn active" data-billing="annual">
                        Annual
                        <span class="annual-savings">Save 20%</span>
                    </button>
                </div>
            </div>
            
            <!-- Pricing Cards -->
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
                // Helper functions
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
                
                $grid_class = min(count($pricing_plans), 3) == 3 ? 'grid-cols-3' : 'grid-cols-' . min(count($pricing_plans), 3);
            ?>
            
            <div class="pricing-grid <?php echo $grid_class; ?>" id="pricing-cards-container">
                <?php foreach ($pricing_plans as $index => $plan) : 
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
                
                <div class="pricing-card <?php echo $is_featured ? 'featured' : ''; ?>"
                     data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                    
                    <?php if ($is_featured) : ?>
                    <!-- Featured Badge -->
                    <div class="most-popular-badge">
                        Most Popular
                    </div>
                    <?php endif; ?>
                    
                    <div class="pricing-card-content">
                        <!-- Plan Header -->
                        <div class="text-center mb-8 pricing-header">
                            <h3 class="text-2xl font-bold text-primary mb-2">
                                <?php echo esc_html($plan->post_title); ?>
                            </h3>
                            
                            <?php if ($plan->post_excerpt) : ?>
                            <p class="text-secondary text-sm">
                                <?php echo esc_html($plan->post_excerpt); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Pricing Display -->
                        <div class="text-center mb-8 pricing-price">
                            <!-- Monthly Price -->
                            <div class="monthly-pricing pricing-display">
                                <div class="text-4xl font-bold text-primary">
                                    <span class="price-amount" data-price-type="monthly">
                                        <?php 
                                        if (function_exists('yoursite_format_currency')) {
                                            echo yoursite_format_currency($monthly_price, $current_currency['code']);
                                        } else {
                                            echo $current_currency['symbol'] . number_format($monthly_price, 0);
                                        }
                                        ?>
                                    </span>
                                    <span class="price-period">/mo</span>
                                </div>
                                <?php if ($monthly_price > 0) : ?>
                                <p class="text-tertiary text-sm mt-1">
                                    Billed monthly
                                </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Annual Price -->
                            <div class="annual-pricing pricing-display active">
                                <div class="text-4xl font-bold text-primary">
                                    <span class="price-amount" data-price-type="annual-monthly">
                                        <?php 
                                        if (function_exists('yoursite_format_currency')) {
                                            echo yoursite_format_currency($annual_monthly, $current_currency['code']);
                                        } else {
                                            echo $current_currency['symbol'] . number_format($annual_monthly, 0);
                                        }
                                        ?>
                                    </span>
                                    <span class="price-period">/mo</span>
                                </div>
                                <?php if ($annual_price > 0) : ?>
                                <p class="text-tertiary text-sm mt-1">
                                    Billed annually (<span data-price-type="annual">
                                        <?php 
                                        if (function_exists('yoursite_format_currency')) {
                                            echo yoursite_format_currency($annual_price, $current_currency['code']);
                                        } else {
                                            echo $current_currency['symbol'] . number_format($annual_price, 0);
                                        }
                                        ?>
                                    </span>)
                                </p>
                                <div class="mt-2">
                                    <span class="annual-savings">
                                        Save <span data-savings-amount class="ml-1">
                                            <?php 
                                            if (function_exists('yoursite_format_currency')) {
                                                echo yoursite_format_currency($savings, $current_currency['code']);
                                            } else {
                                                echo $current_currency['symbol'] . number_format($savings, 0);
                                            }
                                            ?>
                                        </span>/year
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <?php if (!empty($features)) : ?>
                        <div class="pricing-features mb-8">
                            <ul class="pricing-features">
                                <?php 
                                $features_array = array_filter(explode("\n", $features));
                                $max_features = 6;
                                $display_features = array_slice($features_array, 0, $max_features);
                                
                                foreach ($display_features as $feature) :
                                    $feature = trim($feature);
                                    if (!empty($feature)) :
                                ?>
                                <li>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span><?php echo esc_html($feature); ?></span>
                                </li>
                                <?php endif; endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <!-- CTA Button -->
                        <div class="pricing-cta text-center">
                            <a href="<?php echo esc_url($button_url ?: '#signup'); ?>" 
                               class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> btn-full pricing-button"
                               data-monthly-url="<?php echo esc_url($button_url ?: '#signup'); ?>"
                               data-annual-url="<?php echo esc_url(str_replace('monthly', 'annual', $button_url ?: '#signup')); ?>">
                                <?php echo esc_html($button_text ?: __('Get Started', 'yoursite')); ?>
                            </a>
                            
                            <?php if ($index === 0) : ?>
                            <p class="text-tertiary text-xs mt-3">
                                No credit card required
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php else : ?>
            <!-- Fallback Pricing if no pricing posts exist -->
            <div class="pricing-grid grid-cols-3" id="pricing-cards-container">
                <!-- Free Plan -->
                <div class="pricing-card" data-plan-id="free">
                    <div class="pricing-card-content">
                        <div class="text-center mb-8 pricing-header">
                            <h3 class="text-2xl font-bold text-primary mb-2">Free</h3>
                            <p class="text-secondary text-sm">Perfect for getting started</p>
                        </div>
                        <div class="text-center mb-8 pricing-price">
                            <div class="monthly-pricing pricing-display">
                                <div class="text-4xl font-bold text-primary">
                                    <span class="price-amount"><?php echo $current_currency['symbol']; ?>0</span>
                                    <span class="text-lg font-normal text-secondary">/mo</span>
                                </div>
                            </div>
                            <div class="annual-pricing pricing-display active">
                                <div class="text-4xl font-bold text-primary">
                                    <span class="price-amount"><?php echo $current_currency['symbol']; ?>0</span>
                                    <span class="text-lg font-normal text-secondary">/mo</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-cta">
                            <a href="#signup" class="btn-secondary btn-full pricing-button">
                                Start Free
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Pro Plan -->
                <div class="pricing-card featured" data-plan-id="pro">
                    <div class="most-popular-badge">
                        Most Popular
                    </div>
                    <div class="pricing-card-content">
                        <div class="text-center mb-8 pricing-header">
                            <h3 class="text-2xl font-bold text-primary mb-2">Pro</h3>
                            <p class="text-secondary text-sm">For growing businesses</p>
                        </div>
                        <div class="text-center mb-8 pricing-price">
                            <div class="monthly-pricing pricing-display">
                                <div class="text-4xl font-bold text-primary">
                                    <span class="price-amount"><?php echo $current_currency['symbol']; ?>29</span>
                                    <span class="text-lg font-normal text-secondary">/mo</span>
                                </div>
                                <p class="text-tertiary text-sm mt-1">
                                    Billed monthly
                                </p>
                            </div>
                            <div class="annual-pricing pricing-display active">
                                <div class="text-4xl font-bold text-primary">
                                    <span class="price-amount"><?php echo $current_currency['symbol']; ?>23</span>
                                    <span class="text-lg font-normal text-secondary">/mo</span>
                                </div>
                                <p class="text-tertiary text-sm mt-1">
                                    Billed annually (<?php echo $current_currency['symbol']; ?>276)
                                </p>
                                <div class="mt-2">
                                    <span class="savings-indicator">
                                        Save <?php echo $current_currency['symbol']; ?>72/year
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-cta">
                            <a href="#signup" class="btn-primary btn-full pricing-button">
                                Start Free Trial
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="pricing-card" data-plan-id="enterprise">
                    <div class="pricing-card-content">
                        <div class="text-center mb-8 pricing-header">
                            <h3 class="text-2xl font-bold text-primary mb-2">Enterprise</h3>
                            <p class="text-secondary text-sm">For large organizations</p>
                        </div>
                        <div class="text-center mb-8 pricing-price">
                            <div class="monthly-pricing pricing-display">
                                <div class="text-4xl font-bold text-primary">
                                    <span class="price-amount"><?php echo $current_currency['symbol']; ?>99</span>
                                    <span class="text-lg font-normal text-secondary">/mo</span>
                                </div>
                                <p class="text-tertiary text-sm mt-1">
                                    Billed monthly
                                </p>
                            </div>
                            <div class="annual-pricing pricing-display active">
                                <div class="text-4xl font-bold text-primary">
                                    <span class="price-amount"><?php echo $current_currency['symbol']; ?>79</span>
                                    <span class="text-lg font-normal text-secondary">/mo</span>
                                </div>
                                <p class="text-tertiary text-sm mt-1">
                                    Billed annually (<?php echo $current_currency['symbol']; ?>948)
                                </p>
                                <div class="mt-2">
                                    <span class="savings-indicator">
                                        Save <?php echo $current_currency['symbol']; ?>240/year
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-cta">
                            <a href="#contact" class="btn-secondary btn-full pricing-button">
                                Contact Sales
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Bottom CTA -->
            <div class="text-center mt-12">
                <p class="text-secondary mb-4">
                    <?php echo esc_html(get_theme_mod('pricing_cta_text', __('All plans include 14-day free trial • No setup fees • Cancel anytime', 'yoursite'))); ?>
                </p>
                <a href="<?php echo home_url('/pricing'); ?>" class="link-highlight font-medium">
                    <?php echo esc_html(get_theme_mod('pricing_link_text', __('Compare all features →', 'yoursite'))); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- DIFM Banner Section - Conversion Focused -->
<?php if (get_theme_mod('difm_banner_enable', true)) : ?>
<section class="py-20" style="background: linear-gradient(135deg, #0f6fb8 0%, #1c7cd6 50%, #0f6fb8 100%); color: white; position: relative; overflow: hidden;">
    <!-- Background Pattern -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><defs><pattern id=%22difm-grid%22 width=%2220%22 height=%2220%22 patternUnits=%22userSpaceOnUse%22><path d=%22M 20 0 L 0 0 0 20%22 fill=%22none%22 stroke=%22rgba(255,255,255,0.08)%22 stroke-width=%221%22/></pattern></defs><rect width=%22100%22 height=%22100%22 fill=%22url(%23difm-grid)%22/></svg>'); opacity: 0.4;"></div>
    
    <div class="container" style="position: relative; z-index: 2;">
        <div class="max-w-6xl mx-auto">
            <div class="l-flex l-flex-vcenter l-spacing">
                
                <!-- Left Content -->
                <div class="l-box-6 text-center lg:text-left">
                    <!-- Badge -->
                    <?php 
                    $badge_text = get_theme_mod('difm_banner_badge_text', __('Done-For-You Service', 'yoursite'));
                    if (!empty($badge_text)) :
                    ?>
                    <div class="inline-flex items-center rounded-full px-6 py-3 mb-6 text-sm font-semibold" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 2px solid rgba(255, 255, 255, 0.3); color: #0f6fb8; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4"></path>
                        </svg>
                        <?php echo esc_html($badge_text); ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Main Heading -->
                    <h2 class="text-4xl lg:text-5xl font-bold mb-6 leading-tight" style="color: white; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                        <?php echo esc_html(get_theme_mod('difm_banner_title', __('Don\'t Want to Build It Yourself?', 'yoursite'))); ?>
                    </h2>
                    
                    <!-- Subheading -->
                    <p class="text-xl mb-8 leading-relaxed" style="color: rgba(255, 255, 255, 0.95); text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);">
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
                            $feature_text = get_theme_mod("difm_banner_feature_{$i}", $default_features[$i] ?? '');
                            if (!empty(trim($feature_text))) :
                        ?>
                            <div class="flex items-center">
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
                           class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-200">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <?php echo esc_html($secondary_text); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Trust Elements -->
                    <div class="mt-8 pt-8 border-t border-white border-opacity-20">
                        <div class="flex items-center justify-center lg:justify-start space-x-6 text-sm">
                            <?php 
                            $trust_rating = get_theme_mod('difm_banner_trust_rating', __('4.9/5 rating', 'yoursite'));
                            if (!empty($trust_rating)) :
                            ?>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="font-medium"><?php echo esc_html($trust_rating); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php 
                            $trust_count = get_theme_mod('difm_banner_trust_count', __('500+ stores built', 'yoursite'));
                            if (!empty($trust_count)) :
                            ?>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-medium"><?php echo esc_html($trust_count); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Right Visual Element -->
                <div class="l-box-6 hidden lg:block">
                    <div class="relative max-w-md mx-auto">
                        <!-- Main illustration container -->
                        <div class="relative bg-white bg-opacity-10 rounded-3xl p-8 backdrop-blur-sm border border-white border-opacity-20">
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
    </div>
</section>
<?php endif; ?>

<!-- Enhanced JavaScript for Dynamic Currency and Billing - ZENCOMMERCE COMPATIBLE -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Billing toggle functionality - Updated for Zencommerce styling
    const billingButtons = document.querySelectorAll('.billing-btn');
    const pricingCards = document.querySelectorAll('.pricing-card');
    
    billingButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isAnnual = this.getAttribute('data-billing') === 'annual';
            
            // Update button states with Zencommerce classes
            billingButtons.forEach(btn => {
                if (btn.getAttribute('data-billing') === (isAnnual ? 'annual' : 'monthly')) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
            
            // Switch pricing displays
            switchBillingDisplay(isAnnual);
        });
    });
    
    function switchBillingDisplay(isAnnual) {
        pricingCards.forEach(card => {
            const monthlyDisplay = card.querySelector('.monthly-pricing');
            const annualDisplay = card.querySelector('.annual-pricing');
            const pricingButton = card.querySelector('.pricing-button');
            
            if (monthlyDisplay && annualDisplay) {
                if (isAnnual) {
                    monthlyDisplay.classList.remove('active');
                    annualDisplay.classList.add('active');
                } else {
                    monthlyDisplay.classList.add('active');
                    annualDisplay.classList.remove('active');
                }
            }
            
            // Update button URL if available
            if (pricingButton) {
                const newUrl = isAnnual ? 
                    pricingButton.dataset.annualUrl : 
                    pricingButton.dataset.monthlyUrl;
                
                if (newUrl) {
                    pricingButton.href = newUrl;
                }
            }
        });
    }
    
    // Currency change functionality
    document.addEventListener('currencyChanged', function(e) {
        updateAllPricing(e.detail.currency);
    });
    
    // Listen for currency selector changes
    document.addEventListener('click', function(e) {
        const currencyItem = e.target.closest('[data-currency-code], [data-currency]');
        if (!currencyItem) return;
        
        const newCurrency = currencyItem.dataset.currency || currencyItem.dataset.currencyCode;
        if (newCurrency) {
            updateAllPricing(newCurrency);
        }
    });
    
    function updateAllPricing(currencyCode) {
        // Show loading state - Zencommerce style
        const pricingSection = document.getElementById('pricing-section');
        if (pricingSection) {
            pricingSection.classList.add('loading');
        }
        
        // Get all plan IDs
        const planCards = document.querySelectorAll('[data-plan-id]');
        const planIds = Array.from(planCards).map(card => card.dataset.planId).filter(id => id && id !== 'free' && id !== 'pro' && id !== 'enterprise');
        
        if (planIds.length > 0) {
            // Fetch pricing for real plans
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_all_pricing_in_currency',
                    currency: currencyCode,
                    plan_ids: planIds.join(','),
                    nonce: '<?php echo wp_create_nonce("get_pricing"); ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.pricing) {
                    updatePricingCards(data.data.pricing, data.data.currency_info);
                } else {
                    console.error('Failed to update pricing:', data.data);
                    updateCurrencySymbolsOnly(currencyCode);
                }
            })
            .catch(error => {
                console.error('Error updating pricing:', error);
                updateCurrencySymbolsOnly(currencyCode);
            })
            .finally(() => {
                // Remove loading state
                if (pricingSection) {
                    pricingSection.classList.remove('loading');
                }
            });
        } else {
            // Update fallback pricing cards
            updateCurrencySymbolsOnly(currencyCode);
            if (pricingSection) {
                pricingSection.classList.remove('loading');
            }
        }
    }
    
    function updatePricingCards(pricingData, currencyInfo) {
        Object.keys(pricingData).forEach(planId => {
            const pricing = pricingData[planId];
            const card = document.querySelector(`[data-plan-id="${planId}"]`);
            
            if (!card) return;
            
            try {
                // Update monthly price
                const monthlyAmount = card.querySelector('[data-price-type="monthly"]');
                if (monthlyAmount && pricing.monthly_price_formatted) {
                    monthlyAmount.textContent = pricing.monthly_price_formatted.replace(/[^\d.,€£$¥]/g, '');
                }
                
                // Update annual monthly equivalent
                const annualMonthlyAmount = card.querySelector('[data-price-type="annual-monthly"]');
                if (annualMonthlyAmount && pricing.annual_monthly_equivalent_formatted) {
                    annualMonthlyAmount.textContent = pricing.annual_monthly_equivalent_formatted.replace(/[^\d.,€£$¥]/g, '');
                }
                
                // Update annual total
                const annualAmount = card.querySelector('[data-price-type="annual"]');
                if (annualAmount && pricing.annual_price_formatted) {
                    annualAmount.textContent = pricing.annual_price_formatted;
                }
                
                // Update savings
                const savingsAmount = card.querySelector('[data-savings-amount]');
                if (savingsAmount && pricing.savings_formatted) {
                    savingsAmount.textContent = pricing.savings_formatted;
                }
                
                // Update currency symbols if they exist as separate elements
                const currencySymbols = card.querySelectorAll('.currency-symbol');
                currencySymbols.forEach(symbol => {
                    if (currencyInfo && currencyInfo.symbol) {
                        symbol.textContent = currencyInfo.symbol;
                    }
                });
                
            } catch (error) {
                console.error('Error updating card pricing:', error, planId);
            }
        });
    }
    
    function updateCurrencySymbolsOnly(currencyCode) {
        // Get currency symbol based on code
        const currencySymbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'CAD': 'C',
            'AUD': 'A,
            'JPY': '¥',
            'CHF': 'CHF',
            'SEK': 'kr',
            'NOK': 'kr',
            'DKK': 'kr'
        };
        
        const symbol = currencySymbols[currencyCode] || ';
        
        // Update fallback pricing if exists
        const fallbackCards = document.querySelectorAll('[data-plan-id="free"], [data-plan-id="pro"], [data-plan-id="enterprise"]');
        
        fallbackCards.forEach(card => {
            const priceAmounts = card.querySelectorAll('.price-amount');
            priceAmounts.forEach(amount => {
                const currentText = amount.textContent;
                const numericValue = currentText.replace(/[^\d]/g, '');
                if (numericValue) {
                    amount.textContent = symbol + numericValue;
                }
            });
            
            // Update annual billing text
            const annualTexts = card.querySelectorAll('p');
            annualTexts.forEach(text => {
                if (text.textContent.includes('Billed annually')) {
                    const matches = text.textContent.match(/\d+/);
                    if (matches) {
                        const planId = card.dataset.planId;
                        let annualPrice;
                        
                        switch(planId) {
                            case 'pro':
                                annualPrice = 276;
                                break;
                            case 'enterprise':
                                annualPrice = 948;
                                break;
                            default:
                                annualPrice = parseInt(matches[0]);
                        }
                        
                        // Simple currency conversion estimation
                        if (currencyCode === 'EUR') {
                            annualPrice = Math.round(annualPrice * 0.85);
                        } else if (currencyCode === 'GBP') {
                            annualPrice = Math.round(annualPrice * 0.75);
                        }
                        
                        text.innerHTML = text.innerHTML.replace(/\$\d+/, symbol + annualPrice);
                    }
                }
            });
        });
    }
    
    // Show success message when currency changes - Zencommerce style
    function showCurrencyChangeNotification(currencyCode) {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.currency-change-notification');
        existingNotifications.forEach(n => n.remove());
        
        // Create notification with Zencommerce styling
        const notification = document.createElement('div');
        notification.className = 'currency-change-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <svg class="notification-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Prices updated to ${currencyCode}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Enhanced currency change listener
    document.addEventListener('currencyChanged', function(e) {
        showCurrencyChangeNotification(e.detail.currency);
    });
    
    // Initialize with monthly billing selected by default
    const isMonthlyDefault = true;
    if (isMonthlyDefault) {
        switchBillingDisplay(false);
    }
});
</script>