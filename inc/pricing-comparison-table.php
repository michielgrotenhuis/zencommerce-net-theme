<?php
/**
 * Enhanced Pricing Comparison Table Component with Dynamic Currency Support
 * File: inc/pricing-comparison-table.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the pricing comparison table with enhanced UI and dynamic currency support
 */
function yoursite_render_pricing_comparison_table() {
    $plans = yoursite_get_pricing_plans_for_comparison();
    $categories = yoursite_get_comparison_feature_categories(); // This function is defined in pricing-meta-boxes.php
    
    // Get current user currency
    $current_currency = yoursite_get_user_currency();
    
    if (empty($plans)) {
        return '<p class="text-center text-gray-500 dark:text-gray-400 py-8">' . __('No pricing plans available.', 'yoursite') . '</p>';
    }
    
    ob_start();
    ?>
    
    <div class="pricing-comparison-wrapper bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        
        <!-- Streamlined Header with Currency Selector -->
        <div class="comparison-header sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 z-40 p-6">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    <?php _e('See What\'s Included in Each Plan', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php _e('Every feature designed to help your business grow', 'yoursite'); ?>
                </p>
            </div>
            
            <!-- Currency Selector and Billing Toggle Container -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mb-4">
                
                <!-- Currency Selector (if available) -->
                <?php if (function_exists('yoursite_should_display_currency_selector') && yoursite_should_display_currency_selector()) : ?>
                <div class="flex items-center gap-3">
                    <span class="text-gray-600 dark:text-gray-400 font-medium">
                        <?php _e('Currency:', 'yoursite'); ?>
                    </span>
                    <?php 
                    echo yoursite_render_currency_selector(array(
                        'style' => 'dropdown',
                        'show_flag' => true,
                        'show_name' => false,
                        'show_symbol' => true,
                        'class' => 'comparison-currency-selector'
                    )); 
                    ?>
                </div>
                <?php endif; ?>
                
                <!-- Billing Period Toggle - Annual Default -->
                <div class="flex items-center justify-center">
                    <span class="text-gray-700 dark:text-gray-300 mr-4 font-medium comparison-monthly-label">
                        <?php _e('Monthly', 'yoursite'); ?>
                    </span>
                    <div class="relative">
                        <input type="checkbox" id="comparison-billing-toggle" class="sr-only peer" checked>
                        <label for="comparison-billing-toggle" class="relative inline-flex items-center justify-between w-16 h-8 bg-gray-200 dark:bg-gray-700 rounded-full cursor-pointer transition-colors duration-300 peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800">
                            <span class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 peer-checked:translate-x-8"></span>
                        </label>
                    </div>
                    <span class="text-gray-700 dark:text-gray-300 ml-4 font-medium comparison-yearly-label">
                        <?php _e('Annual', 'yoursite'); ?>
                    </span>
                    <span class="bg-emerald-500 text-emerald-50 dark:text-white text-sm font-semibold px-3 py-1 rounded-full ml-3 shadow-md">
                        <?php _e('Save 20%', 'yoursite'); ?>
                    </span>
                </div>
            </div>
        </div>


       


        
        <!-- Comparison Table -->
        <div class="comparison-table-container">
            <table class="comparison-table w-full min-w-[800px]">
 
                <!-- Plan Headers (Sticky) -->
                <thead class="comparison-sticky-header bg-white dark:bg-gray-800 z-30 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="text-left p-4 w-64 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                <?php _e('Features', 'yoursite'); ?>
                            </span>
                        </th>
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
                                $annual_price = $monthly_price * 12 * 0.8;
                            }
                            $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
                            
                            // Calculate savings
                            $savings = function_exists('yoursite_calculate_annual_savings') 
                                ? yoursite_calculate_annual_savings($plan->ID, $current_currency['code'])
                                : ($monthly_price * 12) - $annual_price;
                            ?>
                            <th class="text-center p-4 border-r border-gray-200 dark:border-gray-700 relative <?php echo $is_featured ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-gray-800'; ?>"
                                data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                                <?php if ($is_featured) : ?>
                                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-1 text-xs font-semibold rounded-t-lg">
                                        <?php _e('Most Popular', 'yoursite'); ?>
                                    </div>
                                    <div class="mt-6">
                                <?php else : ?>
                                    <div class="mt-2">
                                <?php endif; ?>
                                
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                    <?php echo esc_html($plan->post_title); ?>
                                </h4>
                                
                                <div class="price-display mb-4">
                                    <div class="monthly-pricing hidden">
                                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount" data-price-type="monthly">
                                                <?php 
                                                if (function_exists('yoursite_format_currency')) {
                                                    echo yoursite_format_currency($monthly_price, $current_currency['code']);
                                                } else {
                                                    echo $current_currency['symbol'] . number_format($monthly_price, 0);
                                                }
                                                ?>
                                            </span>
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                                            /<?php _e('month', 'yoursite'); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="annual-pricing">
                                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                            <span class="price-amount" data-price-type="annual-monthly">
                                                <?php 
                                                if (function_exists('yoursite_format_currency')) {
                                                    echo yoursite_format_currency($annual_monthly, $current_currency['code']);
                                                } else {
                                                    echo $current_currency['symbol'] . number_format($annual_monthly, 0);
                                                }
                                                ?>
                                            </span>
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">
                                            /<?php _e('month', 'yoursite'); ?>
                                        </span>
                                        <div class="text-xs text-green-600 dark:text-green-400 mt-1">
                                            <?php printf(__('Billed annually (%s)', 'yoursite'), '<span data-price-type="annual">' . (function_exists('yoursite_format_currency') ? yoursite_format_currency($annual_price, $current_currency['code']) : $current_currency['symbol'] . number_format($annual_price, 0)) . '</span>'); ?>
                                        </div>
                                        <?php if ($savings > 0) : ?>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
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
                                
                                <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>" 
                                   class="<?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?> text-sm px-4 py-2 rounded-lg font-semibold inline-block transition-all duration-200 hover:transform hover:-translate-y-1 comparison-cta-button"
                                   data-monthly-url="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>"
                                   data-annual-url="<?php echo esc_url(str_replace('monthly', 'annual', $meta['pricing_button_url'] ?: '#')); ?>">
                                    <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
                                </a>
                                
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                
                <!-- Feature Categories -->
                <tbody>
                    <?php foreach ($categories as $category_key => $category) : ?>
                        
                        <!-- Category Header -->
                        <tr class="bg-gray-50 dark:bg-gray-900">
                            <td colspan="<?php echo count($plans) + 1; ?>" class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3"><?php echo $category['icon']; ?></span>
                                    <div>
                                        <h5 class="text-lg font-bold text-gray-900 dark:text-white">
                                            <?php echo esc_html($category['title']); ?>
                                        </h5>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <?php echo esc_html($category['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Category Features -->
                        <?php foreach ($category['fields'] as $field_key => $field_data) : ?>
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="p-4 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
                                    <div class="feature-label-wrapper">
                                        <span class="font-medium text-gray-900 dark:text-white feature-label" data-tooltip="<?php echo esc_attr($field_data['tooltip']); ?>">
                                            <?php echo esc_html($field_data['label']); ?>
                                            <svg class="inline-block w-4 h-4 ml-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </td>
                                
                                <?php foreach ($plans as $plan) : 
                                    $meta = yoursite_get_pricing_meta_fields($plan->ID);
                                    $meta_key = $category_key . '_' . $field_key;
                                    $feature_value = isset($meta[$meta_key]) ? $meta[$meta_key] : '';
                                    $is_featured = $meta['pricing_featured'] === '1';
                                    ?>
                                    <td class="p-4 text-center border-r border-gray-200 dark:border-gray-700 <?php echo $is_featured ? 'bg-blue-50/30 dark:bg-blue-900/10' : ''; ?>">
                                        <?php echo yoursite_format_feature_value($feature_value); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                        
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Bottom CTA -->
        <div class="comparison-footer bg-gray-50 dark:bg-gray-900 p-6 text-center border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                <?php _e('Still have questions?', 'yoursite'); ?>
            </h4>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                <?php _e('Our team is here to help you choose the right plan for your business.', 'yoursite'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-secondary">
                <?php _e('Contact Sales', 'yoursite'); ?>
            </a>
        </div>
    </div>
    
    <!-- Feature Tooltip Modal -->
    <div id="feature-tooltip" class="feature-tooltip hidden">
        <div class="tooltip-content">
            <p class="tooltip-text"></p>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration constants
        const CONFIG = {
            TOOLTIP_DELAY: 10,
            TOOLTIP_HIDE_DELAY: 200,
            TOOLTIP_MARGIN: 10,
            SCROLL_THROTTLE_DELAY: 16, // ~60fps
            STICKY_HEADER_OPACITY_THRESHOLD: 0.2
        };

        // Utility functions
        const utils = {
            throttle(func, delay) {
                let timeoutId;
                let lastExecTime = 0;
                return function (...args) {
                    const currentTime = Date.now();
                    if (currentTime - lastExecTime > delay) {
                        func.apply(this, args);
                        lastExecTime = currentTime;
                    } else {
                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(() => {
                            func.apply(this, args);
                            lastExecTime = Date.now();
                        }, delay - (currentTime - lastExecTime));
                    }
                };
            },

            debounce(func, delay) {
                let timeoutId;
                return function (...args) {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func.apply(this, args), delay);
                };
            },

            safeQuerySelector(selector) {
                try {
                    return document.querySelector(selector);
                } catch (error) {
                    console.warn(`Invalid selector: ${selector}`, error);
                    return null;
                }
            },

            safeQuerySelectorAll(selector) {
                try {
                    return document.querySelectorAll(selector);
                } catch (error) {
                    console.warn(`Invalid selector: ${selector}`, error);
                    return [];
                }
            }
        };

        // Tooltip system
        const TooltipManager = {
            init() {
                this.tooltip = utils.safeQuerySelector('#feature-tooltip');
                this.tooltipText = this.tooltip?.querySelector('.tooltip-text');
                this.featureLabels = utils.safeQuerySelectorAll('.feature-label[data-tooltip]');
                
                if (!this.tooltip || !this.tooltipText || !this.featureLabels.length) {
                    console.warn('Tooltip elements not found');
                    return;
                }

                this.bindEvents();
            },

            bindEvents() {
                this.featureLabels.forEach(label => {
                    label.addEventListener('mouseenter', this.handleMouseEnter.bind(this));
                    label.addEventListener('mouseleave', this.handleMouseLeave.bind(this));
                    label.addEventListener('mousemove', this.handleMouseMove.bind(this));
                });
            },

            handleMouseEnter(e) {
                const tooltipContent = e.currentTarget.getAttribute('data-tooltip');
                if (!tooltipContent) return;

                this.tooltipText.textContent = tooltipContent;
                this.tooltip.classList.remove('hidden');
                
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        this.tooltip.classList.add('show');
                    }, CONFIG.TOOLTIP_DELAY);
                });
                
                this.updateTooltipPosition(e);
            },

            handleMouseLeave() {
                this.tooltip.classList.remove('show');
                setTimeout(() => {
                    if (!this.tooltip.classList.contains('show')) {
                        this.tooltip.classList.add('hidden');
                    }
                }, CONFIG.TOOLTIP_HIDE_DELAY);
            },

            handleMouseMove(e) {
                if (!this.tooltip.classList.contains('hidden')) {
                    this.updateTooltipPosition(e);
                }
            },

            updateTooltipPosition(e) {
                const rect = this.tooltip.getBoundingClientRect();
                const { clientX: x, clientY: y } = e;
                
                let left = x - rect.width / 2;
                let top = y - rect.height - CONFIG.TOOLTIP_MARGIN;
                
                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;
                
                if (left < CONFIG.TOOLTIP_MARGIN) {
                    left = CONFIG.TOOLTIP_MARGIN;
                } else if (left + rect.width > viewportWidth - CONFIG.TOOLTIP_MARGIN) {
                    left = viewportWidth - rect.width - CONFIG.TOOLTIP_MARGIN;
                }
                
                if (top < CONFIG.TOOLTIP_MARGIN) {
                    top = y + CONFIG.TOOLTIP_MARGIN;
                }
                
                this.tooltip.style.left = `${left}px`;
                this.tooltip.style.top = `${top}px`;
            }
        };

        // Enhanced Billing toggle system with currency support
        const BillingToggleManager = {
            init() {
                this.comparisonToggle = utils.safeQuerySelector('#comparison-billing-toggle');
                this.comparisonWrapper = utils.safeQuerySelector('.pricing-comparison-wrapper');
                this.comparisonMonthlyLabel = utils.safeQuerySelector('.comparison-monthly-label');
                this.comparisonYearlyLabel = utils.safeQuerySelector('.comparison-yearly-label');
                this.mainToggle = utils.safeQuerySelector('#billing-toggle');

                if (!this.comparisonToggle || !this.comparisonWrapper) {
                    console.warn('Billing toggle elements not found');
                    return;
                }

                this.setupInitialState();
                this.bindEvents();
            },

            setupInitialState() {
                this.comparisonToggle.checked = true;
                this.updateComparisonDisplay(true);
            },

            bindEvents() {
                this.comparisonToggle.addEventListener('change', this.handleComparisonToggleChange.bind(this));
                
                if (this.mainToggle && this.mainToggle !== this.comparisonToggle) {
                    this.mainToggle.addEventListener('change', this.handleMainToggleChange.bind(this));
                }
            },

            handleComparisonToggleChange() {
                const isYearly = this.comparisonToggle.checked;
                this.updateComparisonDisplay(isYearly);
                this.syncWithMainToggle(isYearly);
                this.updateCTAButtons(isYearly);
            },

            handleMainToggleChange() {
                const isYearly = this.mainToggle.checked;
                this.comparisonToggle.checked = isYearly;
                this.updateComparisonDisplay(isYearly);
                this.updateCTAButtons(isYearly);
            },

            syncWithMainToggle(isYearly) {
                if (this.mainToggle && this.mainToggle !== this.comparisonToggle) {
                    this.mainToggle.checked = isYearly;
                    this.mainToggle.dispatchEvent(new Event('change', { bubbles: true }));
                }
            },

            updateComparisonDisplay(isYearly) {
                const yearlyClass = 'comparison-yearly-active';
                const monthlyClass = 'comparison-monthly-active';
                
                if (isYearly) {
                    this.comparisonWrapper.classList.add(yearlyClass);
                    this.comparisonWrapper.classList.remove(monthlyClass);
                    this.updateLabelStyles(true);
                } else {
                    this.comparisonWrapper.classList.remove(yearlyClass);
                    this.comparisonWrapper.classList.add(monthlyClass);
                    this.updateLabelStyles(false);
                }
            },

            updateLabelStyles(isYearly) {
                const activeStyle = { color: '#3b82f6', fontWeight: '600' };
                const inactiveStyle = { color: '#9ca3af', fontWeight: '400' };
                
                if (this.comparisonYearlyLabel) {
                    Object.assign(this.comparisonYearlyLabel.style, isYearly ? activeStyle : inactiveStyle);
                }
                
                if (this.comparisonMonthlyLabel) {
                    Object.assign(this.comparisonMonthlyLabel.style, isYearly ? inactiveStyle : activeStyle);
                }
            },

            updateCTAButtons(isYearly) {
                const ctaButtons = utils.safeQuerySelectorAll('.comparison-cta-button');
                ctaButtons.forEach(button => {
                    const newUrl = isYearly ? 
                        button.dataset.annualUrl : 
                        button.dataset.monthlyUrl;
                    
                    if (newUrl) {
                        button.href = newUrl;
                    }
                });
            }
        };

        // Enhanced Currency Manager for comparison table
        const CurrencyManager = {
            init() {
                this.comparisonWrapper = utils.safeQuerySelector('.pricing-comparison-wrapper');
                this.currencySelector = utils.safeQuerySelector('.comparison-currency-selector');
                
                if (!this.comparisonWrapper) {
                    console.warn('Comparison wrapper not found');
                    return;
                }

                this.bindEvents();
            },

            bindEvents() {
                // Listen for currency changes from main pricing section
                document.addEventListener('currencyChanged', this.handleCurrencyChange.bind(this));
                
                // Listen for currency selector changes within comparison table
                if (this.currencySelector) {
                    this.currencySelector.addEventListener('change', this.handleSelectorChange.bind(this));
                }
                
                // Listen for currency selector clicks (for dropdown style)
                document.addEventListener('click', this.handleCurrencyClick.bind(this));
            },

            handleCurrencyChange(e) {
                const newCurrency = e.detail.currency;
                this.updateComparisonPricing(newCurrency);
            },

            handleSelectorChange(e) {
                const newCurrency = e.target.value;
                this.updateComparisonPricing(newCurrency);
                this.dispatchCurrencyChangeEvent(newCurrency);
            },

            handleCurrencyClick(e) {
                const currencyItem = e.target.closest('[data-currency-code], [data-currency]');
                if (!currencyItem || !this.comparisonWrapper.contains(currencyItem)) return;
                
                const newCurrency = currencyItem.dataset.currency || currencyItem.dataset.currencyCode;
                if (newCurrency) {
                    this.updateComparisonPricing(newCurrency);
                    this.dispatchCurrencyChangeEvent(newCurrency);
                }
            },

            updateComparisonPricing(currencyCode) {
                // Show loading state
                this.comparisonWrapper.classList.add('comparison-updating');
                this.comparisonWrapper.style.opacity = '0.7';
                this.comparisonWrapper.style.pointerEvents = 'none';
                
                // Get all plan IDs from the comparison table
                const planHeaders = utils.safeQuerySelectorAll('[data-plan-id]');
                const planIds = Array.from(planHeaders).map(header => header.dataset.planId).filter(id => id);
                
                if (planIds.length > 0) {
                    // Fetch pricing for comparison table plans
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            action: 'get_comparison_pricing_in_currency',
                            currency: currencyCode,
                            plan_ids: planIds.join(','),
                            nonce: '<?php echo wp_create_nonce("get_comparison_pricing"); ?>'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.pricing) {
                            this.updatePricingHeaders(data.data.pricing, data.data.currency_info);
                            this.showCurrencyChangeNotification(currencyCode);
                        } else {
                            console.error('Failed to update comparison pricing:', data.data);
                            this.updateCurrencySymbolsOnly(currencyCode);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating comparison pricing:', error);
                        this.updateCurrencySymbolsOnly(currencyCode);
                    })
                    .finally(() => {
                        // Remove loading state
                        this.comparisonWrapper.classList.remove('comparison-updating');
                        this.comparisonWrapper.style.opacity = '';
                        this.comparisonWrapper.style.pointerEvents = '';
                    });
                } else {
                    // No plans found, just remove loading state
                    this.comparisonWrapper.classList.remove('comparison-updating');
                    this.comparisonWrapper.style.opacity = '';
                    this.comparisonWrapper.style.pointerEvents = '';
                }
            },

            updatePricingHeaders(pricingData, currencyInfo) {
                Object.keys(pricingData).forEach(planId => {
                    const pricing = pricingData[planId];
                    const planHeader = utils.safeQuerySelector(`[data-plan-id="${planId}"]`);
                    
                    if (!planHeader) return;
                    
                    try {
                        // Update monthly price
                        const monthlyAmount = planHeader.querySelector('[data-price-type="monthly"]');
                        if (monthlyAmount && pricing.monthly_price_formatted) {
                            monthlyAmount.textContent = pricing.monthly_price_formatted.replace(/[^\d.,€£$¥₹₩]/g, '');
                        }
                        
                        // Update annual monthly equivalent
                        const annualMonthlyAmount = planHeader.querySelector('[data-price-type="annual-monthly"]');
                        if (annualMonthlyAmount && pricing.annual_monthly_equivalent_formatted) {
                            annualMonthlyAmount.textContent = pricing.annual_monthly_equivalent_formatted.replace(/[^\d.,€£$¥₹₩]/g, '');
                        }
                        
                        // Update annual total
                        const annualAmount = planHeader.querySelector('[data-price-type="annual"]');
                        if (annualAmount && pricing.annual_price_formatted) {
                            annualAmount.textContent = pricing.annual_price_formatted;
                        }
                        
                        // Update savings
                        const savingsAmount = planHeader.querySelector('[data-savings-amount]');
                        if (savingsAmount && pricing.savings_formatted) {
                            savingsAmount.textContent = pricing.savings_formatted;
                        }
                        
                        // Update currency symbols if they exist as separate elements
                        const currencySymbols = planHeader.querySelectorAll('.currency-symbol');
                        currencySymbols.forEach(symbol => {
                            if (currencyInfo && currencyInfo.symbol) {
                                symbol.textContent = currencyInfo.symbol;
                            }
                        });
                        
                    } catch (error) {
                        console.error('Error updating plan header pricing:', error, planId);
                    }
                });
            },

            updateCurrencySymbolsOnly(currencyCode) {
                // Fallback currency symbols
                const currencySymbols = {
                    'USD': '$',
                    'EUR': '€',
                    'GBP': '£',
                    'CAD': 'C',
                    'AUD': 'A',
                    'JPY': '¥',
                    'CHF': 'CHF',
                    'SEK': 'kr',
                    'NOK': 'kr',
                    'DKK': 'kr',
                    'INR': '₹',
                    'KRW': '₩'
                };
                
                const symbol = currencySymbols[currencyCode] || '$';
                
                // Update all price amounts in comparison table
                const planHeaders = utils.safeQuerySelectorAll('[data-plan-id]');
                planHeaders.forEach(header => {
                    const priceAmounts = header.querySelectorAll('.price-amount');
                    priceAmounts.forEach(amount => {
                        const currentText = amount.textContent;
                        const numericValue = currentText.replace(/[^\d]/g, '');
                        if (numericValue) {
                            amount.textContent = symbol + numericValue;
                        }
                    });
                    
                    // Update annual billing text
                    const annualTexts = header.querySelectorAll('[data-price-type="annual"]');
                    annualTexts.forEach(text => {
                        const currentText = text.textContent;
                        const numericValue = currentText.replace(/[^\d]/g, '');
                        if (numericValue) {
                            text.textContent = symbol + numericValue;
                        }
                    });
                    
                    // Update savings amounts
                    const savingsAmounts = header.querySelectorAll('[data-savings-amount]');
                    savingsAmounts.forEach(savings => {
                        const currentText = savings.textContent;
                        const numericValue = currentText.replace(/[^\d]/g, '');
                        if (numericValue) {
                            savings.textContent = symbol + numericValue;
                        }
                    });
                });
            },

            dispatchCurrencyChangeEvent(currencyCode) {
                const event = new CustomEvent('currencyChanged', {
                    detail: { currency: currencyCode },
                    bubbles: true
                });
                document.dispatchEvent(event);
            },

            showCurrencyChangeNotification(currencyCode) {
                // Remove any existing notifications
                const existingNotifications = document.querySelectorAll('.currency-change-notification');
                existingNotifications.forEach(n => n.remove());
                
                // Create notification
                const notification = document.createElement('div');
                notification.className = 'currency-change-notification fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Prices updated to ${currencyCode}</span>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Animate in
                requestAnimationFrame(() => {
                    notification.classList.remove('translate-x-full');
                    notification.classList.add('translate-x-0');
                });
                
                // Remove after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        };

        // Scroll indicator system
        const ScrollIndicatorManager = {
            init() {
                this.tableContainer = utils.safeQuerySelector('.comparison-table-container');
                if (!this.tableContainer || !this.shouldShowScrollIndicator()) {
                    return;
                }
                
                this.addScrollIndicator();
            },

            shouldShowScrollIndicator() {
                return this.tableContainer.scrollWidth > this.tableContainer.clientWidth;
            },

            addScrollIndicator() {
                const scrollIndicator = document.createElement('div');
                scrollIndicator.className = 'scroll-indicator';
                scrollIndicator.innerHTML = '← Scroll to see more features →';
                scrollIndicator.style.cssText = `
                    position: sticky;
                    left: 0;
                    top: 0;
                    background: linear-gradient(90deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
                    color: #3b82f6;
                    text-align: center;
                    padding: 8px;
                    font-size: 12px;
                    font-weight: 600;
                    border-bottom: 1px solid #e5e7eb;
                    z-index: 20;
                    transition: opacity 0.3s ease;
                `;
                
                this.tableContainer.prepend(scrollIndicator);
                this.bindScrollEvents(scrollIndicator);
            },

            bindScrollEvents(scrollIndicator) {
                const throttledScrollHandler = utils.throttle((e) => {
                    const { scrollLeft, scrollWidth, clientWidth } = e.target;
                    const scrollPercentage = scrollLeft / (scrollWidth - clientWidth);
                    
                    scrollIndicator.style.opacity = scrollPercentage > 0.9 ? '0' : '1';
                }, CONFIG.SCROLL_THROTTLE_DELAY);
                
                this.tableContainer.addEventListener('scroll', throttledScrollHandler);
            }
        };

        // Sticky header system
        const StickyHeaderManager = {
            init() {
                this.tableContainer = utils.safeQuerySelector('.comparison-table-container');
                this.stickyHeader = utils.safeQuerySelector('.comparison-sticky-header');
                this.comparisonSection = utils.safeQuerySelector('.pricing-comparison-wrapper');
                
                if (!this.tableContainer || !this.stickyHeader || !this.comparisonSection) {
                    console.warn('Sticky header elements not found');
                    return;
                }

                this.isSticky = false;
                this.bindEvents();
                this.handleStickyHeader(); // Initial check
            },

            bindEvents() {
                const throttledScrollHandler = utils.throttle(this.handleStickyHeader.bind(this), CONFIG.SCROLL_THROTTLE_DELAY);
                const debouncedResizeHandler = utils.debounce(this.handleResize.bind(this), 100);
                
                window.addEventListener('scroll', throttledScrollHandler);
                window.addEventListener('resize', debouncedResizeHandler);
            },

            handleStickyHeader() {
                const sectionRect = this.comparisonSection.getBoundingClientRect();
                const containerRect = this.tableContainer.getBoundingClientRect();
                
                const shouldBeSticky = sectionRect.top <= 0 && sectionRect.bottom > 0;
                
                if (shouldBeSticky && !this.isSticky) {
                    this.activateStickyMode(containerRect);
                } else if (!shouldBeSticky && this.isSticky) {
                    this.deactivateStickyMode();
                }
                
                this.handleStickyHeaderVisibility(sectionRect);
            },

            activateStickyMode(containerRect) {
                this.isSticky = true;
                Object.assign(this.stickyHeader.style, {
                    position: 'fixed',
                    top: '0px',
                    //left: `${containerRect.left}px`,
                    width: `${containerRect.width}px`,
                    zIndex: '999',
                    boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
                    transition: 'opacity 0.3s ease, transform 0.3s ease'
                });
            },

            deactivateStickyMode() {
                this.isSticky = false;
                Object.assign(this.stickyHeader.style, {
                    position: 'sticky',
                    top: '0',
                    left: 'auto',
                    width: 'auto',
                    zIndex: '100',
                    boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
                    opacity: '1',
                    transform: 'translateY(0)'
                });
            },

            handleStickyHeaderVisibility(sectionRect) {
                if (!this.isSticky) return;
                
                const tableBottom = sectionRect.bottom;
                const threshold = window.innerHeight * CONFIG.STICKY_HEADER_OPACITY_THRESHOLD;
                
                if (tableBottom <= threshold) {
                    this.stickyHeader.style.opacity = '0';
                    this.stickyHeader.style.transform = 'translateY(-100%)';
                } else {
                    this.stickyHeader.style.opacity = '1';
                    this.stickyHeader.style.transform = 'translateY(0)';
                }
            },

            handleResize() {
                if (this.isSticky) {
                    const containerRect = this.tableContainer.getBoundingClientRect();
                    this.stickyHeader.style.left = `${containerRect.left}px`;
                    this.stickyHeader.style.width = `${containerRect.width}px`;
                }
            }
        };

        // Initialize all systems
        const initializeSystems = () => {
            try {
                TooltipManager.init();
                BillingToggleManager.init();
                CurrencyManager.init();
                StickyHeaderManager.init();
                
                // Add scroll indicator on mobile devices
                if (window.innerWidth < 1024) {
                    ScrollIndicatorManager.init();
                }
            } catch (error) {
                console.error('Error initializing comparison table systems:', error);
            }
        };

        // Run initialization
        initializeSystems();

        // Handle responsive changes
        const handleResponsiveChanges = utils.debounce(() => {
            const isMobile = window.innerWidth < 1024;
            const scrollIndicatorExists = utils.safeQuerySelector('.scroll-indicator');
            
            if (isMobile && !scrollIndicatorExists) {
                ScrollIndicatorManager.init();
            } else if (!isMobile && scrollIndicatorExists) {
                scrollIndicatorExists.remove();
            }
        }, 250);

        window.addEventListener('resize', handleResponsiveChanges);
    });
    </script>
    

<style>

/* ==========================================================================
   ENHANCED COMPARISON TABLE - ZENCOMMERCE STYLE
   ========================================================================== */

.pricing-comparison-wrapper {
    margin: 60px 0;
    font-family: 'Roboto', Arial, sans-serif;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding: 0 1rem;
    background: var(--zc-bg-primary);
    border-radius: var(--zc-radius-xl);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--zc-border);
    overflow: hidden;
    position: relative;
}

/* ==========================================================================
   COMPARISON HEADER - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-header {
    background: linear-gradient(135deg, var(--zc-bg-secondary) 0%, rgba(249, 249, 249, 0.8) 100%);
    border-bottom: 2px solid var(--zc-border);
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
}

.comparison-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(18,111,183,0.03)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.5;
    pointer-events: none;
}

.comparison-header > * {
    position: relative;
    z-index: 2;
}

.comparison-header h3 {
    font-size: 2rem;
    font-weight: 300;
    color: var(--zc-text-primary);
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.comparison-header p {
    font-size: 1.125rem;
    color: var(--zc-text-secondary);
    margin-bottom: 2rem;
    line-height: 1.5;
}

/* Currency and Billing Toggle Container */
.comparison-header .flex {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 1rem;
}

/* ==========================================================================
   CURRENCY SELECTOR - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-currency-selector {
    background: linear-gradient(135deg, rgba(18, 111, 183, 0.1) 0%, rgba(244, 180, 0, 0.1) 100%);
    border: 1px solid rgba(18, 111, 183, 0.3);
    color: var(--zc-text-primary);
    font-size: 0.875rem;
    padding: 0.75rem 1rem;
    border-radius: var(--zc-radius-lg);
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    min-width: 120px;
    position: relative;
    overflow: hidden;
}

.comparison-currency-selector::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.comparison-currency-selector:hover::before {
    left: 100%;
}

.comparison-currency-selector:hover {
    background: linear-gradient(135deg, rgba(18, 111, 183, 0.2) 0%, rgba(244, 180, 0, 0.2) 100%);
    border-color: var(--zc-primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.15);
}

/* ==========================================================================
   BILLING TOGGLE - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-header .flex .flex {
    background: var(--zc-bg-primary);
    border: 1px solid var(--zc-border);
    border-radius: 50px;
    padding: 0.5rem;
    box-shadow: var(--zc-shadow-sm);
    position: relative;
}

.comparison-monthly-label,
.comparison-yearly-label {
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--zc-text-secondary);
    transition: all 0.3s ease;
    cursor: pointer;
    user-select: none;
}

.comparison-yearly-label {
    color: var(--zc-primary);
    font-weight: 600;
}

/* Toggle Switch - Zencommerce Style */
#comparison-billing-toggle + label {
    background: var(--zc-border-dark);
    border: 2px solid transparent;
    transition: all 0.3s ease;
    cursor: pointer;
}

#comparison-billing-toggle + label span {
    background: var(--zc-bg-primary);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#comparison-billing-toggle:checked + label {
    background: var(--zc-primary);
    border-color: var(--zc-primary-dark);
}

#comparison-billing-toggle:checked + label span {
    box-shadow: 0 2px 8px rgba(244, 180, 0, 0.3);
}

#comparison-billing-toggle:focus + label {
    box-shadow: 0 0 0 3px rgba(244, 180, 0, 0.1);
}

/* Save Badge */
.comparison-header .bg-emerald-500 {
    background: linear-gradient(135deg, var(--zc-success), #22c55e);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.8125rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
    animation: subtle-pulse 2s ease-in-out infinite;
    position: relative;
    overflow: hidden;
}

.comparison-header .bg-emerald-500::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    animation: shimmer-save 3s ease-in-out infinite;
}

@keyframes subtle-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

@keyframes shimmer-save {
    0% { left: -100%; }
    50% { left: 100%; }
    100% { left: 100%; }
}

/* ==========================================================================
   COMPARISON TABLE CONTAINER
   ========================================================================== */

.comparison-table-container {
    position: relative;
    background: var(--zc-bg-primary);
    border-radius: 0 0 var(--zc-radius-xl) var(--zc-radius-xl);
}

.comparison-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    min-width: 800px;
    background: var(--zc-bg-primary);
    font-size: 0.9375rem;
}

/* ==========================================================================
   TABLE HEADERS - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-sticky-header {
    position: sticky;
    top: 0;
    z-index: 100;
    background: var(--zc-bg-primary);
    border-bottom: 2px solid var(--zc-primary);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.comparison-table th {
    padding: 2rem 1.5rem;
    text-align: center;
    border-right: 1px solid var(--zc-border);
    vertical-align: top;
    background: var(--zc-bg-primary);
    position: relative;
    transition: all 0.3s ease;

}

.comparison-table th:first-child {
    text-align: left;
    background: var(--zc-bg-secondary);
    border-right: 2px solid var(--zc-border-dark);
    width: 280px;
    padding: 2rem 1.5rem;
}

.comparison-table th:last-child {
    border-right: none;
}

/* Featured Plan Header */
.comparison-table th.bg-blue-50 {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
    border-left: 3px solid var(--zc-primary);
    border-right: 3px solid var(--zc-primary);
    position: relative;
    transform: scale(1.02);
    z-index: 5;
}

.comparison-table th.bg-blue-50::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(244, 180, 0, 0.02) 0%, rgba(18, 111, 183, 0.02) 100%);
    pointer-events: none;
}

/* Most Popular Badge */
.comparison-table th .absolute.top-0 {
    background: var(--zc-gradient);
    color: white;
    padding: 0.5rem 0;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 2px 8px rgba(244, 180, 0, 0.3);
    border-radius: var(--zc-radius-lg) var(--zc-radius-lg) 0 0;
    margin: -2rem -1.5rem 0 -1.5rem;
}

/* Plan Titles */
.comparison-table th h4 {
    font-size: 1.375rem;
    font-weight: 300;
    color: var(--zc-text-primary);
    margin-bottom: 1rem;
    line-height: 1.3;
}

/* ==========================================================================
   PRICE DISPLAY - ZENCOMMERCE STYLE
   ========================================================================== */

.price-display {
    margin-bottom: 1.5rem;
    position: relative;
}

.monthly-pricing,
.annual-pricing {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.pricing-comparison-wrapper.comparison-yearly-active .monthly-pricing {
    opacity: 0;
    transform: translateY(-10px);
    height: 0;
    overflow: hidden;
}

.pricing-comparison-wrapper.comparison-yearly-active .annual-pricing {
    opacity: 1;
    transform: translateY(0);
}

.pricing-comparison-wrapper.comparison-monthly-active .annual-pricing {
    opacity: 0;
    transform: translateY(10px);
    height: 0;
    overflow: hidden;
}

.pricing-comparison-wrapper.comparison-monthly-active .monthly-pricing {
    opacity: 1;
    transform: translateY(0);
}


/* Price period and notes */
.comparison-table .text-gray-600 {
    color: var(--zc-text-secondary);
    font-size: 0.875rem;
    font-weight: 300;
}

.comparison-table .text-xs.text-green-600 {
    color: var(--zc-success);
    font-size: 0.8125rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

/* Savings Badge */
.comparison-table .inline-flex.items-center.px-2 {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: var(--zc-success);
    padding: 0.375rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-top: 0.5rem;
    box-shadow: 0 2px 4px rgba(34, 197, 94, 0.1);
}

/* ==========================================================================
   CTA BUTTONS - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-cta-button {
    padding: 0.75rem 1.5rem;
    border-radius: var(--zc-radius-sm);
    font-size: 0.9375rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    text-decoration: none;
    display: inline-block;
    position: relative;
    overflow: hidden;
}

.comparison-cta-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    transition: left 0.3s ease;
    z-index: 1;
}

.comparison-cta-button span,
.comparison-cta-button::after {
    position: relative;
    z-index: 2;
}

/* Primary CTA (Featured Plan) */
.comparison-cta-button.btn-primary {
    background: var(--zc-primary);
    color: white;
    border-color: var(--zc-primary);
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.3);
}

.comparison-cta-button.btn-primary::before {
    background: var(--zc-primary-dark);
}

.comparison-cta-button.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(244, 180, 0, 0.4);
    color: white;
    text-decoration: none;
}

.comparison-cta-button.btn-primary:hover::before {
    left: 0;
}

/* Secondary CTA */
.comparison-cta-button.btn-secondary {
    background: transparent;
    color: var(--zc-primary);
    border-color: var(--zc-primary);
}

.comparison-cta-button.btn-secondary::before {
    background: var(--zc-primary);
}

.comparison-cta-button.btn-secondary:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.3);
    text-decoration: none;
}

.comparison-cta-button.btn-secondary:hover::before {
    left: 0;
}

/* ==========================================================================
   FEATURE CATEGORIES - ZENCOMMERCE STYLE
   ========================================================================== */

/* Category Headers */
.comparison-table tbody tr.bg-gray-50 td {
    background: linear-gradient(135deg, var(--zc-bg-secondary) 0%, rgba(249, 249, 249, 0.8) 100%);
    padding: 1.5rem;
    border-bottom: 2px solid var(--zc-border-dark);
    border-top: 1px solid var(--zc-border);
    position: relative;
}

.comparison-table tbody tr.bg-gray-50 td::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: var(--zc-gradient);
}

.comparison-table tbody tr.bg-gray-50 h5 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--zc-text-primary);
    margin: 0 0 0.25rem 0;
    line-height: 1.3;
}

.comparison-table tbody tr.bg-gray-50 p {
    font-size: 0.875rem;
    color: var(--zc-text-secondary);
    margin: 0;
    line-height: 1.4;
}

.comparison-table tbody tr.bg-gray-50 .flex span:first-child {
    font-size: 1.5rem;
    margin-right: 0.75rem;
    filter: drop-shadow(0 2px 4px rgba(244, 180, 0, 0.2));
}

/* ==========================================================================
   FEATURE ROWS - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-table tbody tr {
    transition: all 0.2s ease;
}

.comparison-table tbody tr:hover {
    background: rgba(244, 180, 0, 0.02);
}

.comparison-table tbody tr:hover td:first-child {
    background: rgba(244, 180, 0, 0.05);
    border-right-color: var(--zc-primary);
}

.comparison-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--zc-border);
    border-right: 1px solid var(--zc-border);
    vertical-align: middle;
    transition: all 0.2s ease;
    width:25%;
}

.comparison-table td:first-child {
    background: var(--zc-bg-secondary);
    border-right: 2px solid var(--zc-border-dark);
    text-align: left;
    font-weight: 500;
    color: var(--zc-text-primary);
    position: relative;
    width:240px;
}

.comparison-table td:last-child {
    border-right: none;
}

/* Featured Plan Cells */
.comparison-table td.bg-blue-50\/30 {
    background: rgba(59, 130, 246, 0.02);
    border-left: 1px solid rgba(244, 180, 0, 0.1);
    border-right: 1px solid rgba(244, 180, 0, 0.1);
    position: relative;
}

/* ==========================================================================
   FEATURE VALUES - ZENCOMMERCE STYLE
   ========================================================================== */

/* Check marks */
.comparison-table .text-green-500 {
    color: var(--zc-success);
    font-size: 1.25rem;
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(34, 197, 94, 0.2);
}

/* Cross marks and dashes */
.comparison-table .text-gray-400 {
    color: var(--zc-text-tertiary);
    font-size: 1.25rem;
}

/* Special feature values */
.comparison-table .font-semibold.text-orange-600 {
    color: #ea580c;
    background: rgba(234, 88, 12, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: var(--zc-radius-sm);
    font-size: 0.8125rem;
}

.comparison-table .font-semibold.text-blue-600 {
    color: var(--zc-secondary);
    font-weight: 600;
}

.comparison-table .font-semibold.text-purple-600 {
    color: #9333ea;
    background: rgba(147, 51, 234, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: var(--zc-radius-sm);
    font-size: 0.8125rem;
}

.comparison-table .font-semibold.text-indigo-600 {
    color: #4f46e5;
    font-weight: 600;
}

/* ==========================================================================
   FEATURE TOOLTIPS - ZENCOMMERCE STYLE
   ========================================================================== */

.feature-label-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.feature-label {
    cursor: help;
    position: relative;
}

.feature-label svg {
    opacity: 0.6;
    transition: all 0.2s ease;
}

.feature-label:hover svg {
    opacity: 1;
    color: var(--zc-primary);
    transform: scale(1.1);
}

.feature-tooltip {
    position: fixed;
    z-index: 9999;
    background: var(--zc-text-primary);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: var(--zc-radius-md);
    font-size: 0.8125rem;
    line-height: 1.4;
    max-width: 280px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
}

.feature-tooltip.show {
    opacity: 1;
    transform: translateY(0);
}

.feature-tooltip::before {
    content: '';
    position: absolute;
    top: -6px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid var(--zc-text-primary);
}

/* ==========================================================================
   COMPARISON FOOTER - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-footer {
    background: linear-gradient(135deg, var(--zc-bg-tertiary) 0%, rgba(247, 248, 249, 0.8) 100%);
    border-top: 2px solid var(--zc-border);
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
}

.comparison-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="1" fill="rgba(18,111,183,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    pointer-events: none;
}

.comparison-footer > * {
    position: relative;
    z-index: 2;
}

.comparison-footer h4 {
    font-size: 1.375rem;
    font-weight: 300;
    color: var(--zc-text-primary);
    margin-bottom: 0.75rem;
}

.comparison-footer p {
    font-size: 1rem;
    color: var(--zc-text-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.comparison-footer .btn-secondary {
    background: transparent;
    color: var(--zc-primary);
    border: 2px solid var(--zc-primary);
    padding: 0.875rem 2rem;
    border-radius: var(--zc-radius-sm);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    position: relative;
    overflow: hidden;
}

.comparison-footer .btn-secondary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--zc-primary);
    transition: left 0.3s ease;
    z-index: 1;
}

.comparison-footer .btn-secondary:hover::before {
    left: 0;
}

.comparison-footer .btn-secondary:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(244, 180, 0, 0.3);
    text-decoration: none;
}

.comparison-footer .btn-secondary span {
    position: relative;
    z-index: 2;
}

/* ==========================================================================
   LOADING STATES - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-updating {
    position: relative;
    pointer-events: none;
}

.comparison-updating::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    z-index: 1000;
    border-radius: var(--zc-radius-xl);
}

.comparison-updating::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 40px;
    height: 40px;
    border: 3px solid var(--zc-border);
    border-top-color: var(--zc-primary);
    border-radius: 50%;
    animation: spin 1s ease-in-out infinite;
    z-index: 1001;
}

@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

/* ==========================================================================
   CURRENCY CHANGE NOTIFICATION - ZENCOMMERCE STYLE
   ========================================================================== */

.currency-change-notification {
    background: linear-gradient(135deg, var(--zc-success) 0%, #22c55e 100%);
    color: white;
    border-radius: var(--zc-radius-lg);
    box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.currency-change-notification svg {
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.2));
}

/* ==========================================================================
   SCROLL INDICATOR - ZENCOMMERCE STYLE
   ========================================================================== */

.scroll-indicator {
    background: linear-gradient(90deg, rgba(244, 180, 0, 0.1), rgba(18, 111, 183, 0.1));
    color: var(--zc-primary);
    text-align: center;
    padding: 0.75rem;
    font-size: 0.8125rem;
    font-weight: 600;
    border-bottom: 1px solid var(--zc-border);
    position: sticky;
    left: 0;
    top: 0;
    z-index: 50;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    animation: gentle-pulse 2s ease-in-out infinite;
}

@keyframes gentle-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

/* ==========================================================================
   RESPONSIVE DESIGN - MOBILE OPTIMIZATIONS
   ========================================================================== */

@media (max-width: 1024px) {
    .pricing-comparison-wrapper {
        margin: 40px 0;
        padding: 0 0.5rem;
    }
    
    .comparison-header {
        padding: 2rem 1.5rem;
    }
    
    .comparison-header h3 {
        font-size: 1.75rem;
    }
    
    .comparison-header .flex {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .comparison-table {
        min-width: 700px;
        font-size: 0.875rem;
    }
    
    .comparison-table th,
    .comparison-table td {
        padding: 0.75rem 0.5rem;
    }
    
    .comparison-table th:first-child {
        width: 180px;
        padding: 0.75rem;
    }
    
    
    .comparison-cta-button {
        padding: 0.625rem 1rem;
        font-size: 0.8125rem;
    }
    
    .feature-tooltip {
        max-width: 240px;
        font-size: 0.75rem;
    }
    
    .comparison-footer {
        padding: 2rem 1rem;
    }
}

@media (max-width: 480px) {
    .pricing-comparison-wrapper {
        margin: 20px 0;
        padding: 0;
    }
    
    .comparison-header {
        padding: 1.25rem 0.75rem;
    }
    
    .comparison-header h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }
    
    .comparison-header p {
        font-size: 0.9375rem;
        margin-bottom: 1.5rem;
    }
    
    .comparison-table {
        min-width: 500px;
        font-size: 0.75rem;
    }
    
    .comparison-table th,
    .comparison-table td {
        padding: 0.625rem 0.375rem;
    }
    
    .comparison-table th:first-child {
        width: 140px;
        padding: 0.625rem 0.5rem;
    }
    
    .comparison-table th h4 {
        font-size: 1.125rem;
        margin-bottom: 0.75rem;
    }
    
    
    .comparison-cta-button {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .comparison-footer {
        padding: 1.5rem 0.75rem;
    }
    
    .comparison-footer h4 {
        font-size: 1.125rem;
    }
    
    /* Simplify billing toggle on very small screens */
    .comparison-header .flex .flex {
        flex-direction: column;
        gap: 0.75rem;
        padding: 1rem;
    }
    
    .comparison-monthly-label,
    .comparison-yearly-label {
        font-size: 0.875rem;
    }
}

/* ==========================================================================
   DARK MODE SUPPORT - ZENCOMMERCE STYLE
   ========================================================================== */

@media (prefers-color-scheme: dark) {
    .pricing-comparison-wrapper {
        background: var(--zc-card-bg, #1f2937);
        border-color: var(--zc-card-border, #374151);
    }
    
    .comparison-header {
        background: linear-gradient(135deg, var(--zc-bg-secondary, #374151) 0%, rgba(55, 65, 81, 0.8) 100%);
        border-bottom-color: var(--zc-card-border, #374151);
    }
    
    .comparison-header h3 {
        color: var(--zc-text-primary, #f9fafb);
    }
    
    .comparison-header p {
        color: var(--zc-text-secondary, #d1d5db);
    }
    
    .comparison-table,
    .comparison-table th,
    .comparison-table td {
        background: var(--zc-card-bg, #1f2937);
        border-color: var(--zc-card-border, #374151);
    }
    
    .comparison-table th:first-child,
    .comparison-table td:first-child {
        background: var(--zc-bg-secondary, #374151);
    }
    
    .comparison-table th h4 {
        color: var(--zc-text-primary, #f9fafb);
    }
    
    .comparison-footer {
        background: linear-gradient(135deg, var(--zc-bg-secondary, #374151) 0%, rgba(55, 65, 81, 0.8) 100%);
        border-top-color: var(--zc-card-border, #374151);
    }
    
    .comparison-footer h4 {
        color: var(--zc-text-primary, #f9fafb);
    }
    
    .comparison-footer p {
        color: var(--zc-text-secondary, #d1d5db);
    }
    
    .feature-tooltip {
        background: var(--zc-card-bg, #1f2937);
        border: 1px solid var(--zc-card-border, #374151);
    }
    
    .feature-tooltip::before {
        border-bottom-color: var(--zc-card-bg, #1f2937);
    }
}

/* ==========================================================================
   HIGH CONTRAST MODE SUPPORT
   ========================================================================== */

@media (prefers-contrast: high) {
    .pricing-comparison-wrapper {
        border-width: 2px;
        border-color: #000;
    }
    
    .comparison-table th,
    .comparison-table td {
        border-width: 2px;
    }
    
    .comparison-cta-button {
        border-width: 3px;
    }
    
    .feature-tooltip {
        border-width: 2px;
        border-color: #000;
    }
}

/* ==========================================================================
   PRINT STYLES
   ========================================================================== */

@media print {
    .pricing-comparison-wrapper {
        background: white !important;
        border: 2px solid #000 !important;
        box-shadow: none !important;
        break-inside: avoid;
        page-break-inside: avoid;
        margin: 20px 0 !important;
    }
    
    .comparison-header {
        background: white !important;
        color: #000 !important;
        border-bottom: 2px solid #000 !important;
    }
    
    .comparison-header h3,
    .comparison-header p {
        color: #000 !important;
    }
    
    .comparison-table,
    .comparison-table th,
    .comparison-table td {
        background: white !important;
        color: #000 !important;
        border-color: #000 !important;
    }
    
    .comparison-cta-button {
        background: white !important;
        color: #000 !important;
        border: 2px solid #000 !important;
        box-shadow: none !important;
    }
    
    .comparison-footer {
        background: white !important;
        color: #000 !important;
        border-top: 2px solid #000 !important;
    }
    
    .feature-tooltip {
        display: none !important;
    }
    
    /* Hide interactive elements */
    .scroll-indicator,
    .currency-change-notification,
    #comparison-billing-toggle + label {
        display: none !important;
    }
    
    /* Show all pricing tiers */
    .monthly-pricing,
    .annual-pricing {
        display: block !important;
        opacity: 1 !important;
        height: auto !important;
    }
    
    .annual-pricing {
        margin-top: 10px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }
}

/* ==========================================================================
   ACCESSIBILITY IMPROVEMENTS
   ========================================================================== */

.comparison-cta-button:focus,
#comparison-billing-toggle:focus + label,
.feature-label:focus {
    outline: 3px solid var(--zc-primary);
    outline-offset: 2px;
}

.pricing-comparison-wrapper:focus-within {
    outline: 2px solid var(--zc-primary);
    outline-offset: 4px;
}

/* Screen reader only content */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* Focus trap for keyboard navigation */
.comparison-table:focus {
    outline: 2px solid var(--zc-primary);
    outline-offset: 2px;
}

/* High contrast focus indicators */
@media (prefers-contrast: high) {
    .comparison-cta-button:focus,
    #comparison-billing-toggle:focus + label,
    .feature-label:focus {
        outline: 4px solid #000;
        outline-offset: 2px;
    }
}

/* ==========================================================================
   REDUCED MOTION SUPPORT
   ========================================================================== */

@media (prefers-reduced-motion: reduce) {
    .pricing-comparison-wrapper,
    .comparison-table th,
    .comparison-table td,
    .comparison-cta-button,
    .feature-tooltip,
    .currency-change-notification,
    .scroll-indicator,
    .monthly-pricing,
    .annual-pricing {
        transition: none !important;
        animation: none !important;
    }
    
    .comparison-header::before,
    .comparison-footer::before,
    .comparison-cta-button::before,
    .comparison-footer .btn-secondary::before {
        animation: none !important;
    }
    
    .comparison-table tbody tr:hover,
    .comparison-cta-button:hover,
    .feature-label:hover svg {
        transform: none !important;
    }
    
    .feature-tooltip.show {
        transform: none !important;
    }
}

/* ==========================================================================
   PERFORMANCE OPTIMIZATIONS
   ========================================================================== */

.pricing-comparison-wrapper {
    contain: layout style;
}

.comparison-table {
    will-change: scroll-position;
}

.comparison-cta-button,
.feature-tooltip {
    will-change: transform;
}

/* GPU acceleration for smooth animations */
.comparison-cta-button::before,
.comparison-footer .btn-secondary::before {
    will-change: transform;
    transform: translateZ(0);
}

/* ==========================================================================
   BROWSER-SPECIFIC FIXES
   ========================================================================== */

/* Safari sticky positioning fix */
@supports (-webkit-appearance: none) {
    .comparison-sticky-header {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
    }
}

/* Firefox scrollbar styling */
@-moz-document url-prefix() {
    .comparison-table-container {
        scrollbar-width: thin;
        scrollbar-color: var(--zc-primary) var(--zc-bg-secondary);
    }
}

/* WebKit scrollbar styling */
.comparison-table-container::-webkit-scrollbar {
    height: 8px;
}

.comparison-table-container::-webkit-scrollbar-track {
    background: var(--zc-bg-secondary);
    border-radius: 4px;
}

.comparison-table-container::-webkit-scrollbar-thumb {
    background: var(--zc-primary);
    border-radius: 4px;
    transition: background 0.3s ease;
}

.comparison-table-container::-webkit-scrollbar-thumb:hover {
    background: var(--zc-primary-dark);
}

/* Edge legacy support */
@supports (-ms-high-contrast: none) {
    .comparison-table {
        border-collapse: collapse;
    }
    
    .pricing-comparison-wrapper {
        border-radius: 0;
    }
}
    .comparison-table td {
        padding: 1rem 0.75rem;
    }
    
    .comparison-table th:first-child {
       /*  width: 200px; */
    }
}

@media (max-width: 768px) {
    .pricing-comparison-wrapper {
        margin: 30px 0;
        border-radius: var(--zc-radius-lg);
    }
    
    .comparison-header {
        padding: 1.5rem 1rem;
    }
    
    .comparison-header h3 {
        font-size: 1.5rem;
    }
    
    .comparison-header p {
        font-size: 1rem;
    }
    
    .comparison-table {
        min-width: 600px;
        font-size: 0.8125rem;
    }
/* ==========================================================================
   ENHANCED COMPARISON TABLE - ZENCOMMERCE STYLE WITH BETTER VISUAL APPEAL
   ========================================================================== */

.pricing-comparison-wrapper {
    margin: 60px 0;
    font-family: 'Roboto', Arial, sans-serif;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding: 0 1rem;
    background: var(--zc-bg-primary);
    border-radius: var(--zc-radius-xl);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 8px 25px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--zc-border);
    overflow: hidden;
    position: relative;
}

/* Enhanced background pattern */
.pricing-comparison-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 20%, rgba(244, 180, 0, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(18, 111, 183, 0.03) 0%, transparent 50%),
        linear-gradient(135deg, rgba(249, 249, 249, 0.5) 0%, rgba(255, 255, 255, 0.8) 100%);
    pointer-events: none;
    z-index: 1;
}

.pricing-comparison-wrapper > * {
    position: relative;
    z-index: 2;
}

/* ==========================================================================
   COMPARISON HEADER - ENHANCED ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-header {
    background: linear-gradient(135deg, var(--zc-bg-secondary) 0%, rgba(249, 249, 249, 0.9) 50%, white 100%);
    border-bottom: 3px solid transparent;
    border-image: linear-gradient(90deg, var(--zc-primary), var(--zc-secondary)) 1;
    padding: 3rem 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.comparison-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        linear-gradient(45deg, transparent 30%, rgba(244, 180, 0, 0.02) 50%, transparent 70%),
        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="rgba(18,111,183,0.04)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    opacity: 0.8;
    pointer-events: none;
    animation: subtle-float 6s ease-in-out infinite;
}

@keyframes subtle-float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-2px) rotate(0.5deg); }
    66% { transform: translateY(2px) rotate(-0.5deg); }
}

.comparison-header > * {
    position: relative;
    z-index: 2;
}

.comparison-header h3 {
    font-size: 2.25rem;
    font-weight: 300;
    color: var(--zc-text-primary);
    margin-bottom: 1rem;
    line-height: 1.2;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.comparison-header h3::after {
    content: '';
    display: block;
    width: 80px;
    height: 3px;
    background: var(--zc-gradient);
    margin: 1rem auto 0;
    border-radius: 2px;
}

.comparison-header p {
    font-size: 1.1875rem;
    color: var(--zc-text-secondary);
    margin-bottom: 2.5rem;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Currency and Billing Toggle Container */
.comparison-header .flex {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 1rem;
}

/* ==========================================================================
   CURRENCY SELECTOR - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-currency-selector {
    background: linear-gradient(135deg, rgba(18, 111, 183, 0.1) 0%, rgba(244, 180, 0, 0.1) 100%);
    border: 1px solid rgba(18, 111, 183, 0.3);
    color: var(--zc-text-primary);
    font-size: 0.875rem;
    padding: 0.75rem 1rem;
    border-radius: var(--zc-radius-lg);
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    min-width: 120px;
    position: relative;
    overflow: hidden;
}

.comparison-currency-selector::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.comparison-currency-selector:hover::before {
    left: 100%;
}

.comparison-currency-selector:hover {
    background: linear-gradient(135deg, rgba(18, 111, 183, 0.2) 0%, rgba(244, 180, 0, 0.2) 100%);
    border-color: var(--zc-primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.15);
}

/* ==========================================================================
   BILLING TOGGLE - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-header .flex .flex {
    background: var(--zc-bg-primary);
    border: 1px solid var(--zc-border);
    border-radius: 50px;
    padding: 0.5rem;
    box-shadow: var(--zc-shadow-sm);
    position: relative;
}

.comparison-monthly-label,
.comparison-yearly-label {
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--zc-text-secondary);
    transition: all 0.3s ease;
    cursor: pointer;
    user-select: none;
}

.comparison-yearly-label {
    color: var(--zc-primary);
    font-weight: 600;
}

/* Toggle Switch - Zencommerce Style */
#comparison-billing-toggle + label {
    background: var(--zc-border-dark);
    border: 2px solid transparent;
    transition: all 0.3s ease;
    cursor: pointer;
}

#comparison-billing-toggle + label span {
    background: var(--zc-bg-primary);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#comparison-billing-toggle:checked + label {
    background: var(--zc-primary);
    border-color: var(--zc-primary-dark);
}

#comparison-billing-toggle:checked + label span {
    box-shadow: 0 2px 8px rgba(244, 180, 0, 0.3);
}

#comparison-billing-toggle:focus + label {
    box-shadow: 0 0 0 3px rgba(244, 180, 0, 0.1);
}

/* Save Badge */
.comparison-header .bg-emerald-500 {
    background: linear-gradient(135deg, var(--zc-success), #22c55e);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.8125rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
    animation: subtle-pulse 2s ease-in-out infinite;
    position: relative;
    overflow: hidden;
}

.comparison-header .bg-emerald-500::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    animation: shimmer-save 3s ease-in-out infinite;
}

@keyframes subtle-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

@keyframes shimmer-save {
    0% { left: -100%; }
    50% { left: 100%; }
    100% { left: 100%; }
}

/* ==========================================================================
   COMPARISON TABLE CONTAINER
   ========================================================================== */

.comparison-table-container {
    position: relative;
    background: var(--zc-bg-primary);
    border-radius: 0 0 var(--zc-radius-xl) var(--zc-radius-xl);
}

.comparison-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    min-width: 800px;
    background: var(--zc-bg-primary);
    font-size: 0.9375rem;
}

/* ==========================================================================
   TABLE HEADERS - ZENCOMMERCE STYLE WITH FIXED STICKY BEHAVIOR
   ========================================================================== */

.comparison-sticky-header {
    position: sticky;
    top: 0;
    z-index: 999;
    background: var(--zc-bg-primary);
    border-bottom: 2px solid var(--zc-primary);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    /* Ensure sticky works properly */
    transform: translateZ(0);
    -webkit-transform: translateZ(0);
    /* Prevent style changes on scroll */
    will-change: auto;
}

/* Force sticky positioning to work correctly */
.comparison-sticky-header th {
    position: sticky;
    top: 0;
    z-index: 999;
    background: var(--zc-bg-primary);
}

.comparison-table th {
    padding: 2rem 1.5rem;
    text-align: center;
    border-right: 1px solid var(--zc-border);
    vertical-align: top;
    background: var(--zc-bg-primary);
    position: relative;
    /* Remove transition that causes scroll issues */
    transition: none;
    width: 25%;
}

.comparison-table th:first-child {
    text-align: left;
    background: var(--zc-bg-secondary);
    border-right: 2px solid var(--zc-border-dark);
    width: 280px;
    padding: 2rem 1.5rem;
}

.comparison-table th:last-child {
    border-right: none;
}

/* Featured Plan Header */
.comparison-table th.bg-blue-50 {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
    border-left: 3px solid var(--zc-primary);
    border-right: 3px solid var(--zc-primary);
    position: relative;
    transform: scale(1.02);
    z-index: 5;
}

.comparison-table th.bg-blue-50::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(244, 180, 0, 0.02) 0%, rgba(18, 111, 183, 0.02) 100%);
    pointer-events: none;
}

/* Most Popular Badge */
.comparison-table th .absolute.top-0 {
    background: var(--zc-gradient);
    color: white;
    padding: 0.5rem 0;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 2px 8px rgba(244, 180, 0, 0.3);
    border-radius: var(--zc-radius-lg) var(--zc-radius-lg) 0 0;
    margin: -2rem -1.5rem 0 -1.5rem;
}

/* Plan Titles */
.comparison-table th h4 {
    font-size: 1.375rem;
    font-weight: 300;
    color: var(--zc-text-primary);
    margin-bottom: 1rem;
    line-height: 1.3;
}

/* ==========================================================================
   PRICE DISPLAY - ZENCOMMERCE STYLE
   ========================================================================== */

.price-display {
    margin-bottom: 1.5rem;
    position: relative;
}

.monthly-pricing,
.annual-pricing {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.pricing-comparison-wrapper.comparison-yearly-active .monthly-pricing {
    opacity: 0;
    transform: translateY(-10px);
    height: 0;
    overflow: hidden;
}

.pricing-comparison-wrapper.comparison-yearly-active .annual-pricing {
    opacity: 1;
    transform: translateY(0);
}

.pricing-comparison-wrapper.comparison-monthly-active .annual-pricing {
    opacity: 0;
    transform: translateY(10px);
    height: 0;
    overflow: hidden;
}

.pricing-comparison-wrapper.comparison-monthly-active .monthly-pricing {
    opacity: 1;
    transform: translateY(0);
}

/* Price period and notes */
.comparison-table .text-gray-600 {
    color: var(--zc-text-secondary);
    font-size: 0.875rem;
    font-weight: 300;
}

.comparison-table .text-xs.text-green-600 {
    color: var(--zc-success);
    font-size: 0.8125rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

/* Savings Badge */
.comparison-table .inline-flex.items-center.px-2 {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: var(--zc-success);
    padding: 0.375rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-top: 0.5rem;
    box-shadow: 0 2px 4px rgba(34, 197, 94, 0.1);
}

/* ==========================================================================
   CTA BUTTONS - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-cta-button {
    padding: 0.75rem 1.5rem;
    border-radius: var(--zc-radius-sm);
    font-size: 0.9375rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    text-decoration: none;
    display: inline-block;
    position: relative;
    overflow: hidden;
}

.comparison-cta-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    transition: left 0.3s ease;
    z-index: 1;
}

.comparison-cta-button span,
.comparison-cta-button::after {
    position: relative;
    z-index: 2;
}

/* Primary CTA (Featured Plan) */
.comparison-cta-button.btn-primary {
    background: var(--zc-primary);
    color: white;
    border-color: var(--zc-primary);
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.3);
}

.comparison-cta-button.btn-primary::before {
    background: var(--zc-primary-dark);
}

.comparison-cta-button.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(244, 180, 0, 0.4);
    color: white;
    text-decoration: none;
}

.comparison-cta-button.btn-primary:hover::before {
    left: 0;
}

/* Secondary CTA */
.comparison-cta-button.btn-secondary {
    background: transparent;
    color: var(--zc-primary);
    border-color: var(--zc-primary);
}

.comparison-cta-button.btn-secondary::before {
    background: var(--zc-primary);
}

.comparison-cta-button.btn-secondary:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.3);
    text-decoration: none;
}

.comparison-cta-button.btn-secondary:hover::before {
    left: 0;
}

/* ==========================================================================
   FEATURE CATEGORIES - ZENCOMMERCE STYLE
   ========================================================================== */

/* Category Headers */
.comparison-table tbody tr.bg-gray-50 td {
    background: linear-gradient(135deg, var(--zc-bg-secondary) 0%, rgba(249, 249, 249, 0.8) 100%);
    padding: 1.5rem;
    border-bottom: 2px solid var(--zc-border-dark);
    border-top: 1px solid var(--zc-border);
    position: relative;
}

.comparison-table tbody tr.bg-gray-50 td::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: var(--zc-gradient);
}

.comparison-table tbody tr.bg-gray-50 h5 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--zc-text-primary);
    margin: 0 0 0.25rem 0;
    line-height: 1.3;
}

.comparison-table tbody tr.bg-gray-50 p {
    font-size: 0.875rem;
    color: var(--zc-text-secondary);
    margin: 0;
    line-height: 1.4;
}

.comparison-table tbody tr.bg-gray-50 .flex span:first-child {
    font-size: 1.5rem;
    margin-right: 0.75rem;
    filter: drop-shadow(0 2px 4px rgba(244, 180, 0, 0.2));
}

/* ==========================================================================
   FEATURE ROWS - ZENCOMMERCE STYLE WITH IMPROVED SCROLL BEHAVIOR
   ========================================================================== */

.comparison-table tbody tr {
    /* Remove problematic transitions that change on scroll */
    transition: background-color 0.2s ease;
}

.comparison-table tbody tr:hover {
    background: rgba(244, 180, 0, 0.02);
}

/* Prevent style changes during scrolling */
.comparison-table tbody tr:hover td:first-child {
    background: rgba(244, 180, 0, 0.05);
    border-right-color: var(--zc-primary);
    /* Remove transform that causes issues */
}

.comparison-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--zc-border);
    border-right: 1px solid var(--zc-border);
    vertical-align: middle;
    /* Simplified transition to prevent scroll issues */
    transition: background-color 0.2s ease;
}

.comparison-table td:first-child {
    background: var(--zc-bg-secondary);
    border-right: 2px solid var(--zc-border-dark);
    text-align: left;
    font-weight: 500;
    color: var(--zc-text-primary);
    position: relative;
    /* Ensure consistent background */
    background-color: var(--zc-bg-secondary) !important;
}

.comparison-table td:last-child {
    border-right: none;
}

/* Featured Plan Cells - Fixed styling */
.comparison-table td.bg-blue-50\/30 {
    background: rgba(59, 130, 246, 0.02) !important;
    border-left: 1px solid rgba(244, 180, 0, 0.1);
    border-right: 1px solid rgba(244, 180, 0, 0.1);
    position: relative;
}

/* ==========================================================================
   FEATURE VALUES - ZENCOMMERCE STYLE
   ========================================================================== */

/* Check marks */
.comparison-table .text-green-500 {
    color: var(--zc-success);
    font-size: 1.25rem;
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(34, 197, 94, 0.2);
}

/* Cross marks and dashes */
.comparison-table .text-gray-400 {
    color: var(--zc-text-tertiary);
    font-size: 1.25rem;
}

/* Special feature values */
.comparison-table .font-semibold.text-orange-600 {
    color: #ea580c;
    background: rgba(234, 88, 12, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: var(--zc-radius-sm);
    font-size: 0.8125rem;
}

.comparison-table .font-semibold.text-blue-600 {
    color: var(--zc-secondary);
    font-weight: 600;
}

.comparison-table .font-semibold.text-purple-600 {
    color: #9333ea;
    background: rgba(147, 51, 234, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: var(--zc-radius-sm);
    font-size: 0.8125rem;
}

.comparison-table .font-semibold.text-indigo-600 {
    color: #4f46e5;
    font-weight: 600;
}

/* ==========================================================================
   FEATURE TOOLTIPS - ZENCOMMERCE STYLE
   ========================================================================== */

.feature-label-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.feature-label {
    cursor: help;
    position: relative;
}

.feature-label svg {
    opacity: 0.6;
    transition: all 0.2s ease;
}

.feature-label:hover svg {
    opacity: 1;
    color: var(--zc-primary);
    transform: scale(1.1);
}

.feature-tooltip {
    position: fixed;
    z-index: 9999;
    background: var(--zc-text-primary);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: var(--zc-radius-md);
    font-size: 0.8125rem;
    line-height: 1.4;
    max-width: 280px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
}

.feature-tooltip.show {
    opacity: 1;
    transform: translateY(0);
}

.feature-tooltip::before {
    content: '';
    position: absolute;
    top: -6px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid var(--zc-text-primary);
}

/* ==========================================================================
   COMPARISON FOOTER - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-footer {
    background: linear-gradient(135deg, var(--zc-bg-tertiary) 0%, rgba(247, 248, 249, 0.8) 100%);
    border-top: 2px solid var(--zc-border);
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
}

.comparison-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="1" fill="rgba(18,111,183,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    pointer-events: none;
}

.comparison-footer > * {
    position: relative;
    z-index: 2;
}

.comparison-footer h4 {
    font-size: 1.375rem;
    font-weight: 300;
    color: var(--zc-text-primary);
    margin-bottom: 0.75rem;
}

.comparison-footer p {
    font-size: 1rem;
    color: var(--zc-text-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.comparison-footer .btn-secondary {
    background: transparent;
    color: var(--zc-primary);
    border: 2px solid var(--zc-primary);
    padding: 0.875rem 2rem;
    border-radius: var(--zc-radius-sm);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    position: relative;
    overflow: hidden;
}

.comparison-footer .btn-secondary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--zc-primary);
    transition: left 0.3s ease;
    z-index: 1;
}

.comparison-footer .btn-secondary:hover::before {
    left: 0;
}

.comparison-footer .btn-secondary:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(244, 180, 0, 0.3);
    text-decoration: none;
}

.comparison-footer .btn-secondary span {
    position: relative;
    z-index: 2;
}

/* ==========================================================================
   LOADING STATES - ZENCOMMERCE STYLE
   ========================================================================== */

.comparison-updating {
    position: relative;
    pointer-events: none;
}

.comparison-updating::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    z-index: 1000;
    border-radius: var(--zc-radius-xl);
}

.comparison-updating::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 40px;
    height: 40px;
    border: 3px solid var(--zc-border);
    border-top-color: var(--zc-primary);
    border-radius: 50%;
    animation: spin 1s ease-in-out infinite;
    z-index: 1001;
}

@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

/* ==========================================================================
   CURRENCY CHANGE NOTIFICATION - ZENCOMMERCE STYLE
   ========================================================================== */

.currency-change-notification {
    background: linear-gradient(135deg, var(--zc-success) 0%, #22c55e 100%);
    color: white;
    border-radius: var(--zc-radius-lg);
    box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.currency-change-notification svg {
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.2));
}

/* ==========================================================================
   SCROLL INDICATOR - ZENCOMMERCE STYLE
   ========================================================================== */

.scroll-indicator {
    background: linear-gradient(90deg, rgba(244, 180, 0, 0.1), rgba(18, 111, 183, 0.1));
    color: var(--zc-primary);
    text-align: center;
    padding: 0.75rem;
    font-size: 0.8125rem;
    font-weight: 600;
    border-bottom: 1px solid var(--zc-border);
    position: sticky;
    left: 0;
    top: 0;
    z-index: 50;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    animation: gentle-pulse 2s ease-in-out infinite;
}

@keyframes gentle-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

/* ==========================================================================
   RESPONSIVE DESIGN - MOBILE OPTIMIZATIONS
   ========================================================================== */

@media (max-width: 1024px) {
    .pricing-comparison-wrapper {
        margin: 40px 0;
        padding: 0 0.5rem;
    }
    
    .comparison-header {
        padding: 2rem 1.5rem;
    }
    
    .comparison-header h3 {
        font-size: 1.75rem;
    }
    
    .comparison-header .flex {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .comparison-table {
        min-width: 700px;
        font-size: 0.875rem;
    }
    
    .comparison-table th,
    .comparison-table td {
        padding: 0.75rem 0.5rem;
    }
    
    .comparison-table th:first-child {
        width: 180px;
        padding: 0.75rem;
    }
    
    .comparison-cta-button {
        padding: 0.625rem 1rem;
        font-size: 0.8125rem;
    }
    
    .feature-tooltip {
        max-width: 240px;
        font-size: 0.75rem;
    }
    
    .comparison-footer {
        padding: 2rem 1rem;
    }
}

@media (max-width: 480px) {
    .pricing-comparison-wrapper {
        margin: 20px 0;
        padding: 0;
    }
    
    .comparison-header {
        padding: 1.25rem 0.75rem;
    }
    
    .comparison-header h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }
    
    .comparison-header p {
        font-size: 0.9375rem;
        margin-bottom: 1.5rem;
    }
    
    .comparison-table {
        min-width: 500px;
        font-size: 0.75rem;
    }
    
    .comparison-table th,
    .comparison-table td {
        padding: 0.625rem 0.375rem;
    }
    
    .comparison-table th:first-child {
        width: 140px;
        padding: 0.625rem 0.5rem;
    }
    
    .comparison-table th h4 {
        font-size: 1.125rem;
        margin-bottom: 0.75rem;
    }
    
    .comparison-cta-button {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .comparison-footer {
        padding: 1.5rem 0.75rem;
    }
    
    .comparison-footer h4 {
        font-size: 1.125rem;
    }
    
    /* Simplify billing toggle on very small screens */
    .comparison-header .flex .flex {
        flex-direction: column;
        gap: 0.75rem;
        padding: 1rem;
    }
    
    .comparison-monthly-label,
    .comparison-yearly-label {
        font-size: 0.875rem;
    }
}

/* ==========================================================================
   DARK MODE SUPPORT - ZENCOMMERCE STYLE
   ========================================================================== */

@media (prefers-color-scheme: dark) {
    .pricing-comparison-wrapper {
        background: var(--zc-card-bg, #1f2937);
        border-color: var(--zc-card-border, #374151);
    }
    
    .comparison-header {
        background: linear-gradient(135deg, var(--zc-bg-secondary, #374151) 0%, rgba(55, 65, 81, 0.8) 100%);
        border-bottom-color: var(--zc-card-border, #374151);
    }
    
    .comparison-header h3 {
        color: var(--zc-text-primary, #f9fafb);
    }
    
    .comparison-header p {
        color: var(--zc-text-secondary, #d1d5db);
    }
    
    .comparison-table,
    .comparison-table th,
    .comparison-table td {
        background: var(--zc-card-bg, #1f2937);
        border-color: var(--zc-card-border, #374151);
    }
    
    .comparison-table th:first-child,
    .comparison-table td:first-child {
        background: var(--zc-bg-secondary, #374151);
    }
    
    .comparison-table th h4 {
        color: var(--zc-text-primary, #f9fafb);
    }
    
    .comparison-footer {
        background: linear-gradient(135deg, var(--zc-bg-secondary, #374151) 0%, rgba(55, 65, 81, 0.8) 100%);
        border-top-color: var(--zc-card-border, #374151);
    }
    
    .comparison-footer h4 {
        color: var(--zc-text-primary, #f9fafb);
    }
    
    .comparison-footer p {
        color: var(--zc-text-secondary, #d1d5db);
    }
    
    .feature-tooltip {
        background: var(--zc-card-bg, #1f2937);
        border: 1px solid var(--zc-card-border, #374151);
    }
    
    .feature-tooltip::before {
        border-bottom-color: var(--zc-card-bg, #1f2937);
    }
}

/* ==========================================================================
   HIGH CONTRAST MODE SUPPORT
   ========================================================================== */

@media (prefers-contrast: high) {
    .pricing-comparison-wrapper {
        border-width: 2px;
        border-color: #000;
    }
    
    .comparison-table th,
    .comparison-table td {
        border-width: 2px;
    }
    
    .comparison-cta-button {
        border-width: 3px;
    }
    
    .feature-tooltip {
        border-width: 2px;
        border-color: #000;
    }
}

/* ==========================================================================
   PRINT STYLES
   ========================================================================== */

@media print {
    .pricing-comparison-wrapper {
        background: white !important;
        border: 2px solid #000 !important;
        box-shadow: none !important;
        break-inside: avoid;
        page-break-inside: avoid;
        margin: 20px 0 !important;
    }
    
    .comparison-header {
        background: white !important;
        color: #000 !important;
        border-bottom: 2px solid #000 !important;
    }
    
    .comparison-header h3,
    .comparison-header p {
        color: #000 !important;
    }
    
    .comparison-table,
    .comparison-table th,
    .comparison-table td {
        background: white !important;
        color: #000 !important;
        border-color: #000 !important;
    }
    
    .comparison-cta-button {
        background: white !important;
        color: #000 !important;
        border: 2px solid #000 !important;
        box-shadow: none !important;
    }
    
    .comparison-footer {
        background: white !important;
        color: #000 !important;
        border-top: 2px solid #000 !important;
    }
    
    .feature-tooltip {
        display: none !important;
    }
    
    /* Hide interactive elements */
    .scroll-indicator,
    .currency-change-notification,
    #comparison-billing-toggle + label {
        display: none !important;
    }
    
    /* Show all pricing tiers */
    .monthly-pricing,
    .annual-pricing {
        display: block !important;
        opacity: 1 !important;
        height: auto !important;
    }
    
    .annual-pricing {
        margin-top: 10px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }
}

/* ==========================================================================
   ACCESSIBILITY IMPROVEMENTS
   ========================================================================== */

.comparison-cta-button:focus,
#comparison-billing-toggle:focus + label,
.feature-label:focus {
    outline: 3px solid var(--zc-primary);
    outline-offset: 2px;
}

.pricing-comparison-wrapper:focus-within {
    outline: 2px solid var(--zc-primary);
    outline-offset: 4px;
}

/* Screen reader only content */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* Focus trap for keyboard navigation */
.comparison-table:focus {
    outline: 2px solid var(--zc-primary);
    outline-offset: 2px;
}

/* High contrast focus indicators */
@media (prefers-contrast: high) {
    .comparison-cta-button:focus,
    #comparison-billing-toggle:focus + label,
    .feature-label:focus {
        outline: 4px solid #000;
        outline-offset: 2px;
    }
}

/* ==========================================================================
   REDUCED MOTION SUPPORT
   ========================================================================== */

@media (prefers-reduced-motion: reduce) {
    .pricing-comparison-wrapper,
    .comparison-table th,
    .comparison-table td,
    .comparison-cta-button,
    .feature-tooltip,
    .currency-change-notification,
    .scroll-indicator,
    .monthly-pricing,
    .annual-pricing {
        transition: none !important;
        animation: none !important;
    }
    
    .comparison-header::before,
    .comparison-footer::before,
    .comparison-cta-button::before,
    .comparison-footer .btn-secondary::before {
        animation: none !important;
    }
    
    .comparison-table tbody tr:hover,
    .comparison-cta-button:hover,
    .feature-label:hover svg {
        transform: none !important;
    }
    
    .feature-tooltip.show {
        transform: none !important;
    }
}

/* ==========================================================================
   PERFORMANCE OPTIMIZATIONS
   ========================================================================== */

.pricing-comparison-wrapper {
    contain: layout style;
}

.comparison-table {
    will-change: scroll-position;
}

.comparison-cta-button,
.feature-tooltip {
    will-change: transform;
}

/* GPU acceleration for smooth animations */
.comparison-cta-button::before,
.comparison-footer .btn-secondary::before {
    will-change: transform;
    transform: translateZ(0);
}

/* ==========================================================================
   BROWSER-SPECIFIC FIXES
   ========================================================================== */

/* Safari sticky positioning fix */
@supports (-webkit-appearance: none) {
    .comparison-sticky-header {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
    }
}

/* Firefox scrollbar styling */
@-moz-document url-prefix() {
    .comparison-table-container {
        scrollbar-width: thin;
        scrollbar-color: var(--zc-primary) var(--zc-bg-secondary);
    }
}

/* WebKit scrollbar styling */
.comparison-table-container::-webkit-scrollbar {
    height: 8px;
}

.comparison-table-container::-webkit-scrollbar-track {
    background: var(--zc-bg-secondary);
    border-radius: 4px;
}

.comparison-table-container::-webkit-scrollbar-thumb {
    background: var(--zc-primary);
    border-radius: 4px;
    transition: background 0.3s ease;
}

.comparison-table-container::-webkit-scrollbar-thumb:hover {
    background: var(--zc-primary-dark);
}

/* Edge legacy support */
@supports (-ms-high-contrast: none) {
    .comparison-table {
        border-collapse: collapse;
    }
    
    .pricing-comparison-wrapper {
        border-radius: 0;
    }
}
    .comparison-table td {
        padding: 1rem 0.75rem;
    }
    
    .comparison-table th:first-child {
        width: 200px;
    }
}

@media (max-width: 768px) {
    .pricing-comparison-wrapper {
        margin: 30px 0;
        border-radius: var(--zc-radius-lg);
    }
    
    .comparison-header {
        padding: 1.5rem 1rem;
    }
    
    .comparison-header h3 {
        font-size: 1.5rem;
    }
    
    .comparison-header p {
        font-size: 1rem;
    }
    
    .comparison-table {
        min-width: 600px;
        font-size: 0.8125rem;
    }
    
    .comparison-table th,
    </style>

    <?php
    return ob_get_clean();
}

/**
 * Get pricing plans for comparison
 */
function yoursite_get_pricing_plans_for_comparison() {
    $args = array(
        'post_type' => 'pricing',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => '_pricing_monthly_price',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    );
    
    return get_posts($args);
}

/**
 * Format feature value for display with enhanced styling
 */
function yoursite_format_feature_value($value) {
    if (empty($value)) {
        return '<span class="text-gray-400 dark:text-gray-600">—</span>';
    }
    
    $value = trim($value);
    $lower_value = strtolower($value);
    
    // Check marks
    if (in_array($lower_value, ['yes', 'included', 'true', '✓'])) {
        return '<span class="text-green-500 dark:text-green-400 text-xl">✓</span>';
    }
    
    // Cross marks
    if (in_array($lower_value, ['no', 'not included', 'false', '✗', '-'])) {
        return '<span class="text-gray-400 dark:text-gray-500 text-xl">—</span>';
    }
    
    // Fee display
    if (strpos($lower_value, 'fee') !== false) {
        return '<span class="font-semibold text-orange-600 dark:text-orange-400">' . esc_html($value) . '</span>';
    }
    
    // Numeric values
    if (is_numeric($value)) {
        return '<span class="font-semibold text-gray-900 dark:text-white">' . number_format($value) . '</span>';
    }
    
    // Special values
    if (strpos($lower_value, 'unlimited') !== false) {
        return '<span class="font-semibold text-blue-600 dark:text-blue-400">∞ Unlimited</span>';
    }
    
    if (strpos($lower_value, 'custom') !== false || strpos($lower_value, 'enterprise') !== false) {
        return '<span class="font-semibold text-purple-600 dark:text-purple-400">' . esc_html($value) . '</span>';
    }
    
    // Storage sizes
    if (preg_match('/(\d+)\s*(mb|gb|tb)/i', $value, $matches)) {
        $size = $matches[1];
        $unit = strtoupper($matches[2]);
        return '<span class="font-semibold text-blue-600 dark:text-blue-400">' . $size . ' ' . $unit . '</span>';
    }
    
    // Language counts
    if (preg_match('/^(\d+)$/', $value) && $value <= 50) {
        return '<span class="font-semibold text-indigo-600 dark:text-indigo-400">' . $value . ' languages</span>';
    }
    
    // Default
    return '<span class="text-gray-700 dark:text-gray-300">' . esc_html($value) . '</span>';
}

/**
 * AJAX handler for getting comparison pricing in different currencies
 */
add_action('wp_ajax_get_comparison_pricing_in_currency', 'yoursite_ajax_get_comparison_pricing_in_currency');
add_action('wp_ajax_nopriv_get_comparison_pricing_in_currency', 'yoursite_ajax_get_comparison_pricing_in_currency');

function yoursite_ajax_get_comparison_pricing_in_currency() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'get_comparison_pricing')) {
        wp_die('Security check failed');
    }
    
    $currency_code = sanitize_text_field($_POST['currency']);
    $plan_ids = explode(',', sanitize_text_field($_POST['plan_ids']));
    
    $response_data = array();
    
    foreach ($plan_ids as $plan_id) {
        $plan_id = intval($plan_id);
        if ($plan_id <= 0) continue;
        
        // Get pricing in requested currency
        if (function_exists('yoursite_get_pricing_plan_price')) {
            $monthly_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'monthly');
            $annual_price = yoursite_get_pricing_plan_price($plan_id, $currency_code, 'annual');
        } else {
            // Fallback to basic meta fields
            $monthly_price = floatval(get_post_meta($plan_id, '_pricing_monthly_price', true));
            $annual_price = floatval(get_post_meta($plan_id, '_pricing_annual_price', true));
        }
        
        // Calculate annual monthly equivalent if needed
        if ($annual_price == 0 && $monthly_price > 0) {
            $annual_price = $monthly_price * 12 * 0.8; // 20% discount
        }
        $annual_monthly = $annual_price > 0 ? $annual_price / 12 : 0;
        
        // Calculate savings
        $savings = ($monthly_price * 12) - $annual_price;
        
        // Format prices
        if (function_exists('yoursite_format_currency')) {
            $monthly_formatted = yoursite_format_currency($monthly_price, $currency_code);
            $annual_formatted = yoursite_format_currency($annual_price, $currency_code);
            $annual_monthly_formatted = yoursite_format_currency($annual_monthly, $currency_code);
            $savings_formatted = yoursite_format_currency($savings, $currency_code);
        } else {
            
  $currency_symbols = array(
    'USD' => '$',
    'EUR' => '€',
    'GBP' => '£',
    'CAD' => 'C$',
    'AUD' => 'A$',
    'JPY' => '¥',
    'CHF' => 'CHF',
    'SEK' => 'kr',
    'NOK' => 'kr',
    'DKK' => 'kr',
    'INR' => '₹',
    'KRW' => '₩'
);

$symbol = isset($currency_symbols[$currency_code]) ? $currency_symbols[$currency_code] : '';
            
            $monthly_formatted = $symbol . number_format($monthly_price, 0);
            $annual_formatted = $symbol . number_format($annual_price, 0);
            $annual_monthly_formatted = $symbol . number_format($annual_monthly, 0);
            $savings_formatted = $symbol . number_format($savings, 0);
        }
        
        $response_data[$plan_id] = array(
            'monthly_price' => $monthly_price,
            'annual_price' => $annual_price,
            'annual_monthly_equivalent' => $annual_monthly,
            'savings' => $savings,
            'monthly_price_formatted' => $monthly_formatted,
            'annual_price_formatted' => $annual_formatted,
            'annual_monthly_equivalent_formatted' => $annual_monthly_formatted,
            'savings_formatted' => $savings_formatted
        );
    }
    
    // Get currency info
    $currency_info = array();
    if (function_exists('yoursite_get_currency_info')) {
        $currency_info = yoursite_get_currency_info($currency_code);
    }
    
    wp_send_json_success(array(
        'pricing' => $response_data,
        'currency_info' => $currency_info
    ));
}