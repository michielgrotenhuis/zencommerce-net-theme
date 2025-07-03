<?php
/**
 * Template Name: Pricing Page - Zencommerce Style
 * Complete Zencommerce.in inspired pricing page
 */

get_header();

// Load required files
require_once get_template_directory() . '/inc/pricing-comparison-table.php';
require_once get_template_directory() . '/inc/pricing-shortcodes.php';

// Get current user currency
$current_currency = function_exists('yoursite_get_user_currency') ? yoursite_get_user_currency() : array('code' => 'USD', 'symbol' => '$');

// Get customizer settings
$hero_title = get_theme_mod('pricing_hero_title', 'Simple, Transparent Pricing');
$hero_subtitle = get_theme_mod('pricing_hero_subtitle', 'Choose the perfect plan for your business. Start free, upgrade when you\'re ready.');
$monthly_text = get_theme_mod('pricing_billing_monthly_text', 'Monthly');
$yearly_text = get_theme_mod('pricing_billing_yearly_text', 'Annual');
$save_text = get_theme_mod('pricing_billing_save_text', 'Save 20%');

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

// Helper function for currency symbols
function get_pricing_currency_symbol($currency = 'USD') {
    $symbols = array(
        'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'CAD' => 'C$', 'AUD' => 'A$',
        'JPY' => '¥', 'CHF' => 'CHF', 'SEK' => 'kr', 'NOK' => 'kr', 'DKK' => 'kr'
    );
    return isset($symbols[$currency]) ? $symbols[$currency] : '$';
}
?>
<div class="pricing-page">
    
    <!-- Hero Section -->
    <section class="pricing-hero">
        <div class="layout-container">
            <h1><?php echo esc_html($hero_title); ?></h1>
            <p><?php echo esc_html($hero_subtitle); ?></p>
            
            <!-- Currency Selector -->
            <?php if (function_exists('yoursite_should_display_currency_selector') && yoursite_should_display_currency_selector()) : ?>
            <div style="margin-bottom: 2rem;">
                <span style="color: rgba(255,255,255,0.9); margin-right: 1rem;">Currency:</span>
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
            <?php endif; ?>
        </div>
    </section>

    <!-- Billing Toggle Section -->
    <section class="billing-toggle-section">
        <div class="layout-container">
            <div class="billing-toggle-wrapper">
                <button class="billing-option monthly-btn" data-period="monthly">
                    <?php echo esc_html($monthly_text); ?>
                </button>
                <button class="billing-option annual-btn active" data-period="annual">
                    <?php echo esc_html($yearly_text); ?>
                </button>
                <span class="save-badge"><?php echo esc_html($save_text); ?></span>
            </div>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="section-bg">
        <div class="layout-container">
            <?php
            $args = array(
                'post_type' => 'pricing',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_key' => '_pricing_monthly_price',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
            );
            
            $plans = get_posts($args);
            
            // Helper function
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
            
            if (!empty($plans)) : ?>
                
                <div class="pricing-grid">
                    <?php foreach ($plans as $plan) : 
                        $meta = yoursite_get_pricing_meta_fields($plan->ID);
                        $is_featured = $meta['pricing_featured'] === '1';
                        
                        // Get pricing in current currency
                        $monthly_price = function_exists('yoursite_get_pricing_plan_price') 
                            ? yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'monthly')
                            : floatval($meta['pricing_monthly_price']);
                        
                        $annual_price = function_exists('yoursite_get_pricing_plan_price') 
                            ? yoursite_get_pricing_plan_price($plan->ID, $current_currency['code'], 'annual')
                            : floatval($meta['pricing_annual_price']);
                        
                        if ($annual_price == 0 && $monthly_price > 0) {
                            $annual_price = $monthly_price * 12 * 0.8; // 20% discount
                        }
                        $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                        
                        // Calculate savings
                        $savings = ($monthly_price * 12) - $annual_price;
                        
                        $currency_symbol = get_pricing_currency_symbol($current_currency['code']);
                    ?>
                    
                    <div class="pricing-card <?php echo $is_featured ? 'featured' : ''; ?>" data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                        
                        <!-- Plan Header -->
                        <div class="plan-header">
                            <h3 class="plan-name"><?php echo esc_html($plan->post_title); ?></h3>
                            <?php if ($plan->post_excerpt) : ?>
                                <p class="plan-description"><?php echo esc_html($plan->post_excerpt); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Price Section -->
                        <div class="price-section">
                            <!-- Monthly Pricing -->
                            <div class="price-display monthly-pricing">
                                <div class="price-amount">
                                    <?php echo $currency_symbol . number_format($monthly_price, 0); ?>
                                    <span class="price-period">/month</span>
                                </div>
                                <?php if ($monthly_price > 0) : ?>
                                    <div class="price-note">Billed monthly</div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Annual Pricing (Default) -->
                            <div class="price-display annual-pricing">
                                <div class="price-amount">
                                    <?php echo $currency_symbol . number_format($annual_monthly, 0); ?>
                                    <span class="price-period">/month</span>
                                </div>
                                <?php if ($annual_price > 0) : ?>
                                    <div class="price-note">
                                        Billed annually (<?php echo $currency_symbol . number_format($annual_price, 0); ?>/year)
                                    </div>
                                    <?php if ($savings > 0) : ?>
                                        <div class="savings-badge">
                                            Save <?php echo $currency_symbol . number_format($savings, 0); ?>/year
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Features List -->
                        <?php if (!empty($meta['pricing_features'])) : ?>
                            <ul class="features-list">
                                <?php 
                                $features = array_filter(explode("\n", $meta['pricing_features']));
                                foreach ($features as $feature) : 
                                    $feature = trim($feature);
                                    if (!empty($feature)) :
                                ?>
                                    <li><?php echo esc_html($feature); ?></li>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </ul>
                        <?php endif; ?>
                        
                        <!-- CTA Button -->
                        <div class="cta-section">
                            <?php if ($is_featured) : ?>
                                <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                   class="btn btn-primary btn-full">
                                    <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                   class="btn btn-border btn-full">
                                    <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
                                </a>
                            <?php endif; ?>
                            <p style="font-size: 0.9em; color: var(--zc-text-tertiary); margin-top: 1em; margin-bottom: 0;">
                                14-day free trial • No credit card required
                            </p>
                        </div>
                    </div>
                    
                    <?php endforeach; ?>
                </div>
                
            <?php else : ?>
                <!-- Fallback Pricing -->
                <div class="pricing-grid">
                    <!-- Free Plan -->
                    <div class="pricing-card">
                        <div class="plan-header">
                            <h3 class="plan-name">Free</h3>
                            <p class="plan-description">Perfect for getting started</p>
                        </div>
                        <div class="price-section">
                            <div class="price-display">
                                <div class="price-amount">
                                    <?php echo $current_currency['symbol']; ?>0
                                    <span class="price-period">/month</span>
                                </div>
                            </div>
                        </div>
                        <ul class="features-list">
                            <li>Up to 10 products</li>
                            <li>Basic templates</li>
                            <li>Email support</li>
                        </ul>
                        <div class="cta-section">
                            <a href="#" class="btn btn-border btn-full">Start Free</a>
                        </div>
                    </div>
                    
                    <!-- Pro Plan -->
                    <div class="pricing-card featured">
                        <div class="plan-header">
                            <h3 class="plan-name">Professional</h3>
                            <p class="plan-description">For growing businesses</p>
                        </div>
                        <div class="price-section">
                            <div class="price-display monthly-pricing">
                                <div class="price-amount">
                                    <?php echo $current_currency['symbol']; ?>29
                                    <span class="price-period">/month</span>
                                </div>
                                <div class="price-note">Billed monthly</div>
                            </div>
                            <div class="price-display annual-pricing">
                                <div class="price-amount">
                                    <?php echo $current_currency['symbol']; ?>23
                                    <span class="price-period">/month</span>
                                </div>
                                <div class="price-note">Billed annually (<?php echo $current_currency['symbol']; ?>276/year)</div>
                                <div class="savings-badge">Save <?php echo $current_currency['symbol']; ?>72/year</div>
                            </div>
                        </div>
                        <ul class="features-list">
                            <li>Unlimited products</li>
                            <li>Premium templates</li>
                            <li>Priority support</li>
                            <li>Advanced analytics</li>
                            <li>Custom domain</li>
                        </ul>
                        <div class="cta-section">
                            <a href="#" class="btn btn-primary btn-full">Start Free Trial</a>
                        </div>
                    </div>
                    
                    <!-- Enterprise Plan -->
                    <div class="pricing-card">
                        <div class="plan-header">
                            <h3 class="plan-name">Enterprise</h3>
                            <p class="plan-description">For large organizations</p>
                        </div>
                        <div class="price-section">
                            <div class="price-display monthly-pricing">
                                <div class="price-amount">
                                    <?php echo $current_currency['symbol']; ?>99
                                    <span class="price-period">/month</span>
                                </div>
                                <div class="price-note">Billed monthly</div>
                            </div>
                            <div class="price-display annual-pricing">
                                <div class="price-amount">
                                    <?php echo $current_currency['symbol']; ?>79
                                    <span class="price-period">/month</span>
                                </div>
                                <div class="price-note">Billed annually (<?php echo $current_currency['symbol']; ?>948/year)</div>
                                <div class="savings-badge">Save <?php echo $current_currency['symbol']; ?>240/year</div>
                            </div>
                        </div>
                        <ul class="features-list">
                            <li>Everything in Professional</li>
                            <li>Dedicated account manager</li>
                            <li>API access</li>
                            <li>White-label options</li>
                            <li>Custom integrations</li>
                        </ul>
                        <div class="cta-section">
                            <a href="#" class="btn btn-border btn-full">Contact Sales</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Compare Features Button -->
            <?php if ($comparison_enable) : ?>
            <div style="text-align: center; margin-top: 4em;">
                <a href="#comparison" class="btn btn-border" style="font-size: 1.1em; padding: 1em 2em;">
                    Compare All Features
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($comparison_enable) : ?>
    <!-- Comparison Table Section -->
    <section class="comparison-section" id="comparison">
        <div class="layout-container">
            <div style="text-center; margin-bottom: 4em;">
                <h2 class="heading-highlight"><?php echo esc_html($comparison_title); ?></h2>
                <p><?php echo esc_html($comparison_subtitle); ?></p>
            </div>
            <?php echo yoursite_render_pricing_comparison_table(); ?>
        </div>
    </section>
    <?php endif; ?>

 <?php if ($faq_enable) : ?>
<!-- FAQ Section -->
<section class="faq-section">
    <div class="layout-container">
        <div style="text-center; margin-bottom: 4em;">
            <h2><?php echo esc_html($faq_title); ?></h2>
            <p><?php echo esc_html($faq_subtitle); ?></p>
        </div>
        
        <ul class="faq-list">
            <?php 
            $faq_count = 0;
            
            // Default FAQ data
            $default_faqs = array(
                1 => array('question' => 'Can I change plans anytime?', 'answer' => 'Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle, and we\'ll prorate any differences.'),
                2 => array('question' => 'Is there a free trial?', 'answer' => 'Yes, all paid plans come with a 14-day free trial. No credit card required to get started. You can also use our Free plan indefinitely.'),
                3 => array('question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for enterprise customers.'),
                4 => array('question' => 'Do you offer refunds?', 'answer' => 'Yes, we offer a 30-day money-back guarantee. If you\'re not satisfied with our service, contact us within 30 days for a full refund.'),
                5 => array('question' => 'Can I cancel anytime?', 'answer' => 'Absolutely! You can cancel your subscription at any time. Your account will remain active until the end of your current billing period.')
            );
            
            for ($i = 1; $i <= 5; $i++) : 
                $faq_enabled = get_theme_mod("pricing_faq_{$i}_enable", true);
                $question = get_theme_mod("pricing_faq_{$i}_question", $default_faqs[$i]['question']);
                $answer = get_theme_mod("pricing_faq_{$i}_answer", $default_faqs[$i]['answer']);
                
                if (!$faq_enabled || empty(trim($question)) || empty(trim($answer))) {
                    continue;
                }
                
                $faq_count++;
            ?>
                <li class="faq-item">
                    <button class="faq-toggle" type="button" aria-expanded="false">
                        <h3><?php echo esc_html($question); ?></h3>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content">
                        <p><?php echo esc_html($answer); ?></p>
                    </div>
                </li>
            <?php endfor; 
            
            if ($faq_count === 0 && current_user_can('manage_options')) : ?>
                <li class="faq-item">
                    <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px; padding: 1em; text-align: center;">
                        <p><strong>Admin Notice:</strong> No FAQ items are being displayed. Check <strong>Appearance → Customize → Pricing Page</strong> to configure your FAQs.</p>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</section>
<?php endif; ?>


   

</div>

<!-- Enhanced JavaScript for Zencommerce-style interactions -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('=== ZENCOMMERCE PRICING PAGE LOADED ===');

    const pricingPage = document.querySelector('.pricing-page');
    const monthlyBtn = document.querySelector('.monthly-btn');
    const annualBtn = document.querySelector('.annual-btn');
    const currencySelector = document.querySelector('.pricing-currency-selector');
    const pricingSection = document.querySelector('.section-bg');
    const compareBtn = document.querySelector('a[href="#comparison"]');

    const currencySymbols = {
        'USD': '$', 'EUR': '€', 'GBP': '£', 'CAD': 'C$', 'AUD': 'A$',
        'JPY': '¥', 'CHF': 'CHF', 'SEK': 'kr', 'NOK': 'kr', 'DKK': 'kr'
    };

    // Default state
    if (pricingPage) {
        pricingPage.classList.add('show-annual');
        pricingPage.classList.remove('show-monthly');
    }

    function showPricingMode(mode) {
        if (!pricingPage) return;

        const isAnnual = mode === 'annual';

        pricingPage.classList.toggle('show-annual', isAnnual);
        pricingPage.classList.toggle('show-monthly', !isAnnual);

        annualBtn?.classList.toggle('active', isAnnual);
        monthlyBtn?.classList.toggle('active', !isAnnual);

        console.log(`Showing ${mode} pricing`);
    }

    monthlyBtn?.addEventListener('click', () => showPricingMode('monthly'));
    annualBtn?.addEventListener('click', () => showPricingMode('annual'));

    // Listen for currency changes (custom or DOM-based)
    document.addEventListener('currencyChanged', (e) => {
        updateAllPricing(e.detail.currency);
    });

    document.addEventListener('click', (e) => {
        const currencyItem = e.target.closest('[data-currency-code], [data-currency]');
        if (!currencyItem) return;

        const newCurrency = currencyItem.dataset.currency || currencyItem.dataset.currencyCode;
        if (newCurrency) updateAllPricing(newCurrency);
    });

    function updateAllPricing(currencyCode) {
        console.log('Updating all pricing to currency:', currencyCode);

        setLoadingState(true);

        const planCards = document.querySelectorAll('[data-plan-id]');
        const planIds = Array.from(planCards)
            .map(card => card.dataset.planId)
            .filter(id => id && !['free', 'pro', 'enterprise'].includes(id));

        if (planIds.length && typeof ajaxurl !== 'undefined') {
            fetch(ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'get_all_pricing_in_currency',
                    currency: currencyCode,
                    plan_ids: planIds.join(','),
                    nonce: PRICING.nonce // Defined via wp_localize_script
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.pricing) {
                    updatePricingCards(data.data.pricing, data.data.currency_info);
                    showCurrencyChangeNotification(currencyCode);
                } else {
                    console.error('Failed to update pricing:', data.data);
                    fallbackCurrencyUpdate(currencyCode);
                }
            })
            .catch(error => {
                console.error('Error updating pricing:', error);
                fallbackCurrencyUpdate(currencyCode);
            })
            .finally(() => setLoadingState(false));
        } else {
            fallbackCurrencyUpdate(currencyCode);
            setLoadingState(false);
        }
    }

    function fallbackCurrencyUpdate(currencyCode) {
        const symbol = currencySymbols[currencyCode] || '';

        // Update price amounts
        document.querySelectorAll('.price-amount').forEach(amount => {
            const currentText = amount.textContent.trim();
            const numericValue = currentText.replace(/[^\d]/g, '');

            if (numericValue) {
                const periodSpan = amount.querySelector('.price-period');
                const periodText = periodSpan?.textContent || '';
                amount.innerHTML = symbol + numericValue +
                    (periodSpan ? `<span class="price-period">${periodText}</span>` : '');
            }
        });

        // Update price notes
        document.querySelectorAll('.price-note').forEach(note => {
            if (/billed annually/i.test(note.textContent)) {
                const matches = note.textContent.match(/\d+/);
                if (matches) {
                    const price = parseInt(matches[0]);
                    note.textContent = note.textContent.replace(/[$€£¥]\d+/, symbol + price);
                }
            }
        });

        showCurrencyChangeNotification(currencyCode);
    }

    function setLoadingState(active) {
        if (!pricingSection) return;
        pricingSection.style.opacity = active ? '0.7' : '';
        pricingSection.style.pointerEvents = active ? 'none' : '';
    }

    function showCurrencyChangeNotification(currencyCode) {
        document.querySelectorAll('.currency-change-notification').forEach(el => el.remove());

        const notification = document.createElement('div');
        notification.className = 'currency-change-notification';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--zc-success), #5cb85c);
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            transform: translateX(120%);
            transition: transform 0.4s ease;
            min-width: 250px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        `;
        notification.innerHTML = `
            <div style="display: flex; align-items: center; font-weight: 500;">
                <svg style="width: 20px; height: 20px; margin-right: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Prices updated to ${currencyCode}</span>
            </div>
        `;
        document.body.appendChild(notification);

        requestAnimationFrame(() => {
            notification.style.transform = 'translateX(0)';
        });

        setTimeout(() => {
            notification.style.transform = 'translateX(120%)';
            setTimeout(() => notification.remove(), 400);
        }, 3000);
    }

    // Smooth scroll for comparison section
    compareBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelector('#comparison')?.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    console.log('Zencommerce pricing page setup complete');
});
// FAQ toggle functionality - matching homepage style
var faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(function(item) {
    var toggle = item.querySelector('.faq-toggle');
    var content = item.querySelector('.faq-content');
    
    if (toggle && content) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Toggle active class
            var isActive = toggle.classList.contains('active');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-toggle').forEach(function(t) {
                t.classList.remove('active');
                t.setAttribute('aria-expanded', 'false');
            });
            document.querySelectorAll('.faq-content').forEach(function(c) {
                c.classList.remove('active');
            });
            
            // Toggle current FAQ
            if (!isActive) {
                toggle.classList.add('active');
                toggle.setAttribute('aria-expanded', 'true');
                content.classList.add('active');
            } else {
                toggle.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
                content.classList.remove('active');
            }
        });
    }
});
</script>


<?php get_footer(); ?>