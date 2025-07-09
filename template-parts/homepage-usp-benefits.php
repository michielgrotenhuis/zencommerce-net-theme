<?php
/**
 * Template part for homepage - USP Benefits section
 * Displays 3-section USP benefits with alternating layout and individual images
 */
?>

<!-- USP Benefits Section - ZenCommerce Style -->
<?php if (get_theme_mod('usp_benefits_section_enable', true)) : ?>
<section class="usp-benefits-section py-20 bg-white dark:bg-gray-800 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-full opacity-50 animate-pulse delay-1000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6 max-w-4xl mx-auto leading-tight">
                <?php echo esc_html(get_theme_mod('usp_benefits_main_title', __('Whether You\'re Just Starting or Already Growing, ZenCommerce Is Your Go-To E-commerce Partner', 'yoursite'))); ?>
            </h2>
            <?php 
            $benefits_subtitle = get_theme_mod('usp_benefits_subtitle', '');
            if (!empty($benefits_subtitle)) :
            ?>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php echo esc_html($benefits_subtitle); ?>
            </p>
            <?php endif; ?>
        </div>

        <div class="max-w-7xl mx-auto">
            
            <!-- Section 1: Boost Sales - Text Left, Image Right -->
            <div class="grid lg:grid-cols-2 gap-16 items-center mb-24">
                <!-- Text Content -->
                <div class="space-y-8">
                    <div class="usp-benefits-card group">
                        <div class="flex items-start mb-6">
                            <div class="usp-benefits-icon-wrapper">
                                <svg class="usp-benefits-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="usp-benefits-title">
                                    <?php echo esc_html(get_theme_mod('usp_benefits_section1_title', __('Boost Sales', 'yoursite'))); ?>
                                </h3>
                            </div>
                        </div>
                        <ul class="usp-benefits-list">
                            <?php 
                            $section1_items = array(
                                get_theme_mod('usp_benefits_section1_item1', __('Mobile-friendly store that converts visitors into buyers.', 'yoursite')),
                                get_theme_mod('usp_benefits_section1_item2', __('Loads up to 6X faster than most platforms.', 'yoursite')),
                                get_theme_mod('usp_benefits_section1_item3', __('Easy bulk upload of products and stock.', 'yoursite')),
                                get_theme_mod('usp_benefits_section1_item4', __('Payment gateways integrated and ready to go.', 'yoursite')),
                                get_theme_mod('usp_benefits_section1_item5', __('Pick and tweak themes to match your brand vibe.', 'yoursite'))
                            );
                            
                            foreach ($section1_items as $item) {
                                if (!empty(trim($item))) :
                            ?>
                            <li class="usp-benefits-list-item">
                                <svg class="usp-benefits-check-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><?php echo esc_html($item); ?></span>
                            </li>
                            <?php 
                                endif;
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <!-- Image -->
                <div class="relative">
                    <?php 
                    $section1_image = get_theme_mod('usp_benefits_section1_image');
                    if ($section1_image) : 
                    ?>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-3xl p-8 shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                            <img src="<?php echo esc_url($section1_image); ?>" 
                                 alt="<?php _e('Boost Sales Dashboard', 'yoursite'); ?>" 
                                 class="w-full h-auto rounded-2xl shadow-lg">
                        </div>
                    </div>

                    <!-- Floating Metric -->
                    <div class="absolute -top-6 -right-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 z-20 animate-float">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">+247%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300"><?php _e('Sales Increase', 'yoursite'); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                    <!-- Fallback for Section 1 -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-3xl p-12 shadow-2xl text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?php _e('Boost Your Sales', 'yoursite'); ?></h3>
                        <p class="text-gray-600 dark:text-gray-300"><?php _e('Convert more visitors into customers', 'yoursite'); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Background decoration -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-100/50 to-indigo-100/50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-3xl transform rotate-6 -z-10"></div>
                </div>
            </div>

            <!-- Section 2: Scale Up - Image Left, Text Right -->
            <div class="grid lg:grid-cols-2 gap-16 items-center mb-24">
                <!-- Image -->
                <div class="relative lg:order-1 order-2">
                    <?php 
                    $section2_image = get_theme_mod('usp_benefits_section2_image');
                    if ($section2_image) : 
                    ?>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-3xl p-8 shadow-2xl transform -rotate-2 hover:rotate-0 transition-transform duration-500">
                            <img src="<?php echo esc_url($section2_image); ?>" 
                                 alt="<?php _e('Scale Up Dashboard', 'yoursite'); ?>" 
                                 class="w-full h-auto rounded-2xl shadow-lg">
                        </div>
                    </div>

                    <!-- Floating Metric -->
                    <div class="absolute -bottom-6 -left-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 z-20 animate-float delay-1000">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">99.5%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300"><?php _e('Uptime', 'yoursite'); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                    <!-- Fallback for Section 2 -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-3xl p-12 shadow-2xl text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?php _e('Scale with Confidence', 'yoursite'); ?></h3>
                        <p class="text-gray-600 dark:text-gray-300"><?php _e('Grow your business without limits', 'yoursite'); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Background decoration -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-100/50 to-pink-100/50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-3xl transform -rotate-6 -z-10"></div>
                </div>

                <!-- Text Content -->
                <div class="space-y-8 lg:order-2 order-1">
                    <div class="usp-benefits-card group">
                        <div class="flex items-start mb-6">
                            <div class="usp-benefits-icon-wrapper">
                                <svg class="usp-benefits-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="usp-benefits-title">
                                    <?php echo esc_html(get_theme_mod('usp_benefits_section2_title', __('Scale Up with Confidence', 'yoursite'))); ?>
                                </h3>
                            </div>
                        </div>
                        <ul class="usp-benefits-list">
                            <?php 
                            $section2_items = array(
                                get_theme_mod('usp_benefits_section2_item1', __('Rock-solid 99.5% uptime — we keep your store open, always.', 'yoursite')),
                                get_theme_mod('usp_benefits_section2_item2', __('Access to 45+ powerful plugins for extra features.', 'yoursite')),
                                get_theme_mod('usp_benefits_section2_item3', __('Built-in marketing tools and discounts to keep customers coming back.', 'yoursite')),
                                get_theme_mod('usp_benefits_section2_item4', __('Add your team and assign roles for smooth collaboration.', 'yoursite')),
                                get_theme_mod('usp_benefits_section2_item5', __('Enjoy unlimited transactions with super low fees.', 'yoursite'))
                            );
                            
                            foreach ($section2_items as $item) {
                                if (!empty(trim($item))) :
                            ?>
                            <li class="usp-benefits-list-item">
                                <svg class="usp-benefits-check-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><?php echo esc_html($item); ?></span>
                            </li>
                            <?php 
                                endif;
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section 3: Manage Like a Pro - Text Left, Image Right -->
            <div class="grid lg:grid-cols-2 gap-16 items-center mb-16">
                <!-- Text Content -->
                <div class="space-y-8">
                    <div class="usp-benefits-card group">
                        <div class="flex items-start mb-6">
                            <div class="usp-benefits-icon-wrapper">
                                <svg class="usp-benefits-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="usp-benefits-title">
                                    <?php echo esc_html(get_theme_mod('usp_benefits_section3_title', __('Manage Like a Pro', 'yoursite'))); ?>
                                </h3>
                            </div>
                        </div>
                        <ul class="usp-benefits-list">
                            <?php 
                            $section3_items = array(
                                get_theme_mod('usp_benefits_section3_item1', __('Easy order tracking, invoicing, and reports.', 'yoursite')),
                                get_theme_mod('usp_benefits_section3_item2', __('Bulk update product info and inventory in seconds.', 'yoursite')),
                                get_theme_mod('usp_benefits_section3_item3', __('Manage shipping worldwide without breaking a sweat.', 'yoursite')),
                                get_theme_mod('usp_benefits_section3_item4', __('Powerful analytics to help you make smart decisions.', 'yoursite')),
                                get_theme_mod('usp_benefits_section3_item5', __('Automated tax calculations for peace of mind.', 'yoursite'))
                            );
                            
                            foreach ($section3_items as $item) {
                                if (!empty(trim($item))) :
                            ?>
                            <li class="usp-benefits-list-item">
                                <svg class="usp-benefits-check-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><?php echo esc_html($item); ?></span>
                            </li>
                            <?php 
                                endif;
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <!-- Image -->
                <div class="relative">
                    <?php 
                    $section3_image = get_theme_mod('usp_benefits_section3_image');
                    if ($section3_image) : 
                    ?>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-3xl p-8 shadow-2xl transform rotate-1 hover:rotate-0 transition-transform duration-500">
                            <img src="<?php echo esc_url($section3_image); ?>" 
                                 alt="<?php _e('Management Dashboard', 'yoursite'); ?>" 
                                 class="w-full h-auto rounded-2xl shadow-lg">
                        </div>
                    </div>

                    <!-- Floating Metric -->
                    <div class="absolute -top-4 -left-4 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 z-20 animate-float delay-500">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">85%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300"><?php _e('Time Saved', 'yoursite'); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                    <!-- Fallback for Section 3 -->

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-3xl p-12 shadow-2xl text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?php _e('Professional management tools', 'yoursite'); ?></h3>
                        <p class="text-gray-600 dark:text-gray-300"><?php _e('Manage Like a Pro', 'yoursite'); ?></p>
                    </div>

                    <?php endif; ?>

                    <!-- Background decoration -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-100/50 to-teal-100/50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-3xl transform rotate-3 -z-10"></div>
                </div>
            </div>

            <!-- CTA Section -->
            <?php 
            $usp_benefits_cta_text = get_theme_mod('usp_benefits_cta_text', __('Get Started Today', 'yoursite'));
            $usp_benefits_cta_url = get_theme_mod('usp_benefits_cta_url', '#signup');
            if (!empty($usp_benefits_cta_text)) :
            ?>
            <div class="text-center">
                <a href="<?php echo esc_url($usp_benefits_cta_url); ?>" class="text-white usp-benefits-cta-button ">
                    <span><?php echo esc_html($usp_benefits_cta_text); ?></span>
                    <svg class="usp-benefits-cta-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>