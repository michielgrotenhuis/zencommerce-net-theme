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
                        <button class="faq-question">
                            <?php echo esc_html($question); ?>
                        </button>
                        <div class="faq-answer">
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

    <?php if ($cta_enable) : ?>
    <!-- Final CTA Section -->
    <section>
        <div class="layout-container">
            <div class="cta-section">
                <h2><?php echo esc_html($cta_title); ?></h2>
                <p><?php echo esc_html($cta_subtitle); ?></p>
                <div class="l-flex l-flex-center" style="gap: 1rem; flex-wrap: wrap;">
                    <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn-primary" style="background-color: white; color: var(--zc-secondary); border-color: white;">
                        <?php echo esc_html($cta_primary_text); ?>
                    </a>
                    <a href="<?php echo esc_url($cta_secondary_url); ?>" class="btn btn-border" style="border-color: rgba(255,255,255,0.8); color: white;">
                        <?php echo esc_html($cta_secondary_text); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</div>

<!-- Enhanced JavaScript for Zencommerce-style interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== ZENCOMMERCE PRICING PAGE LOADED ===');
    
    // Find elements
    var pricingPage = document.querySelector('.pricing-page');
    var monthlyBtn = document.querySelector('.monthly-btn');
    var annualBtn = document.querySelector('.annual-btn');
    var currencySelector = document.querySelector('.pricing-currency-selector');
    
    // Find all pricing elements
    var monthlyPricing = document.querySelectorAll('.monthly-pricing');
    var annualPricing = document.querySelectorAll('.annual-pricing');
    
    // Set initial state (annual default)
    if (pricingPage) {
        pricingPage.classList.add('show-annual');
        pricingPage.classList.remove('show-monthly');
    }
    
    function showYearlyPricing() {
        console.log('Showing yearly pricing');
        
        if (pricingPage) {
            pricingPage.classList.add('show-annual');
            pricingPage.classList.remove('show-monthly');
        }
        
        if (annualBtn) {
            annualBtn.classList.add('active');
        }
        if (monthlyBtn) {
            monthlyBtn.classList.remove('active');
        }
    }
    
    function showMonthlyPricing() {
        console.log('Showing monthly pricing');
        
        if (pricingPage) {
            pricingPage.classList.remove('show-annual');
            pricingPage.classList.add('show-monthly');
        }
        
        if (monthlyBtn) {
            monthlyBtn.classList.add('active');
        }
        if (annualBtn) {
            annualBtn.classList.remove('active');
        }
    }
    
    // Billing toggle events
    if (monthlyBtn) {
        monthlyBtn.addEventListener('click', function() {
            showMonthlyPricing();
        });
    }
    
    if (annualBtn) {
        annualBtn.addEventListener('click', function() {
            showYearlyPricing();
        });
    }
    
    // Currency change functionality
    document.addEventListener('currencyChanged', function(e) {
        updateAllPricing(e.detail.currency);
    });
    
    // Listen for currency selector changes
    document.addEventListener('click', function(e) {
        var currencyItem = e.target.closest('[data-currency-code], [data-currency]');
        if (!currencyItem) return;
        
        var newCurrency = currencyItem.dataset.currency || currencyItem.dataset.currencyCode;
        if (newCurrency) {
            updateAllPricing(newCurrency);
        }
    });
    
    function updateAllPricing(currencyCode) {
        console.log('Updating all pricing to currency:', currencyCode);
        
        // Show loading state
        var pricingSection = document.querySelector('.section-bg');
        if (pricingSection) {
            pricingSection.style.opacity = '0.7';
            pricingSection.style.pointerEvents = 'none';
        }
        
        // Get all plan IDs
        var planCards = document.querySelectorAll('[data-plan-id]');
        var planIds = Array.from(planCards).map(function(card) { 
            return card.dataset.planId; 
        }).filter(function(id) { 
            return id && id !== 'free' && id !== 'pro' && id !== 'enterprise'; 
        });
        
        if (planIds.length > 0 && typeof ajaxurl !== 'undefined') {
            // Fetch pricing for real plans
            fetch(ajaxurl, {
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
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success && data.data.pricing) {
                    updatePricingCards(data.data.pricing, data.data.currency_info);
                    showCurrencyChangeNotification(currencyCode);
                } else {
                    console.error('Failed to update pricing:', data.data);
                    updateCurrencySymbolsOnly(currencyCode);
                    showCurrencyChangeNotification(currencyCode);
                }
            })
            .catch(function(error) {
                console.error('Error updating pricing:', error);
                updateCurrencySymbolsOnly(currencyCode);
                showCurrencyChangeNotification(currencyCode);
            })
            .finally(function() {
                // Remove loading state
                if (pricingSection) {
                    pricingSection.style.opacity = '';
                    pricingSection.style.pointerEvents = '';
                }
            });
        } else {
            // Update fallback pricing cards
            updateCurrencySymbolsOnly(currencyCode);
            showCurrencyChangeNotification(currencyCode);
            if (pricingSection) {
                pricingSection.style.opacity = '';
                pricingSection.style.pointerEvents = '';
            }
        }
    }
    
    function updateCurrencySymbolsOnly(currencyCode) {
        // Get currency symbol based on code
        var currencySymbols = {
            'USD': ', 'EUR': '€', 'GBP': '£', 'CAD': 'C, 'AUD': 'A,
            'JPY': '¥', 'CHF': 'CHF', 'SEK': 'kr', 'NOK': 'kr', 'DKK': 'kr'
        };
        
        var symbol = currencySymbols[currencyCode] || ';
        
        // Update all price amounts
        var priceAmounts = document.querySelectorAll('.price-amount');
        priceAmounts.forEach(function(amount) {
            var currentText = amount.textContent;
            var numericValue = currentText.replace(/[^\d]/g, '');
            if (numericValue) {
                var periodSpan = amount.querySelector('.price-period');
                var periodText = periodSpan ? periodSpan.textContent : '';
                amount.innerHTML = symbol + numericValue + (periodSpan ? '<span class="price-period">' + periodText + '</span>' : '');
            }
        });
        
        // Update price notes
        var priceNotes = document.querySelectorAll('.price-note');
        priceNotes.forEach(function(note) {
            if (note.textContent.includes('Billed annually')) {
                var matches = note.textContent.match(/\d+/);
                if (matches) {
                    var price = parseInt(matches[0]);
                    note.textContent = note.textContent.replace(/[$€£¥]\d+/, symbol + price);
                }
            }
        });
    }
    
    function showCurrencyChangeNotification(currencyCode) {
        // Remove any existing notifications
        var existingNotifications = document.querySelectorAll('.currency-change-notification');
        existingNotifications.forEach(function(n) { n.remove(); });
        
        // Create notification
        var notification = document.createElement('div');
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
                <span>Prices updated to ` + currencyCode + `</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        requestAnimationFrame(function() {
            notification.style.transform = 'translateX(0)';
        });
        
        // Remove after 3 seconds
        setTimeout(function() {
            notification.style.transform = 'translateX(120%)';
            setTimeout(function() { 
                if (notification.parentNode) {
                    notification.remove(); 
                }
            }, 400);
        }, 3000);
    }
    
    // FAQ toggle functionality
    var faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            var answer = this.nextElementSibling;
            var isActive = this.classList.contains('active');
            
            // Close all other FAQs
            faqQuestions.forEach(function(otherQuestion) {
                if (otherQuestion !== question) {
                    otherQuestion.classList.remove('active');
                    var otherAnswer = otherQuestion.nextElementSibling;
                    if (otherAnswer) {
                        otherAnswer.classList.remove('active');
                    }
                }
            });
            
            // Toggle current FAQ
            if (isActive) {
                this.classList.remove('active');
                if (answer) answer.classList.remove('active');
            } else {
                this.classList.add('active');
                if (answer) answer.classList.add('active');
            }
        });
    });
    
    // Smooth scroll for compare features button
    var compareBtn = document.querySelector('a[href="#comparison"]');
    if (compareBtn) {
        compareBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector('#comparison');
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
    
    console.log('Zencommerce pricing page setup complete');
});
</script>

<?php get_footer(); ?>