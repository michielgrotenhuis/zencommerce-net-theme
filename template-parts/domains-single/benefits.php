<?php
/**
 * Domain Landing Page - Benefits Section
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args (passed from the main template)
$domain_ext = $args['domain_ext'] ?? 'store';
$domain_features = $args['domain_features'] ?? array();

?>

<!-- Benefits Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="layout-container">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left - Content -->
            <div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    <?php printf(__('Is .%s right for you?', 'yoursite'), esc_html($domain_ext)); ?>
                </h2>
                
                <div class="space-y-8">
                    <!-- Benefits -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <?php printf(__('.%s benefits', 'yoursite'), esc_html($domain_ext)); ?>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php 
                            $domain_benefits = get_post_meta(get_the_ID(), '_domain_benefits', true);
                            if (empty($domain_benefits)) {
                                printf(__('Looking for an on-brand domain name for your online store but the .com domain is taken? Try using .%s instead. As a modern top-level domain (TLD), it\'s more readily available and can make a great alternative.', 'yoursite'), esc_html($domain_ext));
                            } else {
                                echo esc_html($domain_benefits);
                            }
                            ?>
                        </p>
                    </div>
                    
                    <!-- Ideas -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <?php printf(__('Ideas for your .%s domain', 'yoursite'), esc_html($domain_ext)); ?>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php 
                            $domain_ideas = get_post_meta(get_the_ID(), '_domain_ideas', true);
                            if (empty($domain_ideas)) {
                                printf(__('A .%s domain is a fresh choice for any business, but especially if your products are sold online. Whether you\'re a big brand or just starting out, a .%s domain is a great way to signal to potential customers that they can shop online with your brand.', 'yoursite'), esc_html($domain_ext), esc_html($domain_ext));
                            } else {
                                echo esc_html($domain_ideas);
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Right - Benefits List -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    <?php _e('What\'s included', 'yoursite'); ?>
                </h3>
                
                <ul class="space-y-4">
                    <?php foreach ($domain_features as $feature) : ?>
                    <li class="flex items-center">
                        <div class="w-6 h-6 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300 font-medium"><?php echo esc_html(trim($feature)); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>