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
    
            
            <!-- Currency Selector and Billing Toggle Container -->
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


       


        
        <!-- Comparison Table -->
        <div class="comparison-table-container">
            <table class="comparison-table w-full">
 
                <!-- Plan Headers (Sticky) -->
                <thead class="bg-white dark:bg-gray-800 z-30 border-b border-gray-200 dark:border-gray-700">
    <tr>
        <!-- Features Column -->
        <th class="text-left p-4 w-64 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
            <span class="text-lg font-semibold text-gray-900 dark:text-white">
                <?php _e('Features', 'yoursite'); ?>
            </span>
        </th>

        <!-- Plan Columns -->
        <?php foreach ($plans as $plan) :
            $meta = yoursite_get_pricing_meta_fields($plan->ID);
            $is_featured = $meta['pricing_featured'] === '1';

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

            $savings = function_exists('yoursite_calculate_annual_savings') 
                ? yoursite_calculate_annual_savings($plan->ID, $current_currency['code'])
                : ($monthly_price * 12) - $annual_price;
        ?>
        <th class="text-center p-4 border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 <?php echo $is_featured ? 'featured' : ''; ?>" data-plan-id="<?php echo esc_attr($plan->ID); ?>">

            <div class="pricing-card <?php echo $is_featured ? 'featured' : ''; ?>">
                
                <!-- Header -->
                <div class="pricing-card-header">
                    <h3 class="plan-name text-xl font-bold text-gray-900 dark:text-white">
                        <?php echo esc_html($plan->post_title); ?>
                    </h3>
                    <?php if ($plan->post_excerpt) : ?>
                        <p class="plan-description text-sm text-gray-600 dark:text-gray-400">
                            <?php echo esc_html($plan->post_excerpt); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Price Section -->
                <div class="price-section mt-4">
                    
                    <!-- Monthly Pricing -->
                    <div class="monthly-pricing hidden">
                        <div class="price-display text-3xl font-bold text-gray-900 dark:text-white">
                            <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                            <span class="price-amount" data-price-type="monthly"><?php echo number_format($monthly_price, 0); ?></span>
                            <span class="price-period text-base font-normal">/<?php _e('month', 'yoursite'); ?></span>
                        </div>
                        <?php if ($monthly_price > 0) : ?>
                        <div class="price-note text-xs text-gray-600 dark:text-gray-400 mt-1">
                            <?php _e('Billed monthly', 'yoursite'); ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Annual Pricing -->
                    <div class="annual-pricing block">
                        <div class="price-display text-3xl font-bold text-gray-900 dark:text-white">
                            <span class="price-currency"><?php echo esc_html($current_currency['symbol']); ?></span>
                            <span class="price-amount" data-price-type="annual-monthly"><?php echo number_format($annual_monthly, 0); ?></span>
                            <span class="price-period text-base font-normal">/<?php _e('month', 'yoursite'); ?></span>
                        </div>
                        <?php if ($annual_price > 0) : ?>
                        <div class="price-note text-xs text-gray-600 dark:text-gray-400 mt-1">
                            <?php printf(__('Billed annually (%s)', 'yoursite'), '<span data-price-type="annual">' . esc_html($current_currency['symbol']) . number_format($annual_price, 0) . '</span>'); ?>
                        </div>
                        <?php if ($savings > 0) : ?>
                        <div class="annual-savings mt-1 text-xs font-medium text-green-700 dark:text-green-400">
                            💰 <?php _e('Save', 'yoursite'); ?> <span data-savings-amount><?php echo esc_html($current_currency['symbol']) . number_format($savings, 0); ?></span>/<?php _e('year', 'yoursite'); ?>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mt-4">
                    <a href="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>"
                        class="inline-block px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-200 hover:transform hover:-translate-y-1 comparison-cta-button <?php echo $is_featured ? 'btn-primary' : 'btn-secondary'; ?>"
                        data-monthly-url="<?php echo esc_url($meta['pricing_button_url'] ?: '#'); ?>"
                        data-annual-url="<?php echo esc_url(str_replace('monthly', 'annual', $meta['pricing_button_url'] ?: '#')); ?>">
                        <?php echo esc_html($meta['pricing_button_text'] ?: __('Get Started', 'yoursite')); ?>
                    </a>
                </div>

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
                                        <span class="font-medium text-gray-900 feature-label" data-tooltip-placement="right" data-tooltip="<?php echo esc_attr($field_data['tooltip']); ?>">
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
    <div id="feature-tooltip" class="feature-tooltip hidden" data-tooltip-placement="right">
        <div class="tooltip-content">
            <p class="tooltip-text"></p>
        </div>
    </div>
    
    <script>
    const labels = document.querySelectorAll('.feature-label');

labels.forEach(label => {
    const tooltip = label.querySelector('.feature-tooltip');

    label.addEventListener('mouseenter', () => {
        const rect = label.getBoundingClientRect();

        tooltip.classList.add('show');

        // Calculate top to vertically center tooltip with the label
        const top = rect.top + rect.height / 2 - tooltip.offsetHeight / 2;
        const left = rect.right + 8; // Add spacing to the right

        tooltip.style.top = `${top}px`;
        tooltip.style.left = `${left}px`;
    });

    label.addEventListener('mouseleave', () => {
        tooltip.classList.remove('show');
        tooltip.style.top = '';
        tooltip.style.left = '';
    });
});</script>
    

<style>
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
    background: var(--zc-text-primary);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: var(--zc-radius-md);
    font-size: 0.8125rem;
    line-height: 1.4;
    max-width: 360px;
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
    left: -6px; 
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-top: 6px solid transparent;
    border-bottom: 6px solid transparent;
    border-right: 6px solid var(--zc-text-primary); /* Arrow points left */
}

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
