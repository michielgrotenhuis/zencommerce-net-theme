<?php
/**
 * Domain Landing Page - Domain Alternatives Section
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args (passed from the main template)
$domain_ext = $args['domain_ext'] ?? 'store';
$domain_features = $args['domain_features'] ?? array();
$domain_alternatives = $args['domain_alternatives'] ?? array();
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar');
?>

<!-- Domain Alternatives Section -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="layout-container">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php printf(__('Find a .%s domain alternative', 'yoursite'), esc_html($domain_ext)); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                <?php _e('Couldn\'t find your desired domain name? Try these similar extensions for your brand.', 'yoursite'); ?>
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <?php foreach ($domain_alternatives as $alt_key => $alt_data) : ?>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl p-8 text-center hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-300 border border-gray-200 dark:border-gray-600">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    <?php echo esc_html($alt_data['name']); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    <?php 
                    switch ($alt_key) {
                        case 'shop':
                            _e('Couldn\'t find your desired domain name? Try registering .shop domain for your brand.', 'yoursite');
                            break;
                        case 'online':
                            _e('Register your brand on a similar TLD with .online.', 'yoursite');
                            break;
                        case 'boutique':
                            _e('Secure your brand on a different TLD with .boutique.', 'yoursite');
                            break;
                        default:
                            printf(__('Perfect alternative for your %s business.', 'yoursite'), esc_html($alt_data['name']));
                    }
                    ?>
                </p>
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-4">
                    <?php echo esc_html($current_currency['symbol'] . $alt_data['price']); ?>
                </div>
                <a href="<?php echo esc_url(home_url('/domains/' . $alt_key)); ?>" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <?php printf(__('Buy %s Domain', 'yoursite'), esc_html($alt_data['name'])); ?>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>