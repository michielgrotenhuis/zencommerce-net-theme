<?php
/**
 * Domain Archive - Why Choose Zencommerce Section (Complete Rewrite)
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$');

?>

<!-- Why Choose Zencommerce Section -->
<section class="py-20 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-blue-900 relative overflow-hidden">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-30">
        <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5" class="text-blue-200 dark:text-blue-800"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>
    
    <div class="relative layout-container">
        
        <!-- Section Header -->
        <div class="text-center mb-20">
            <div class="inline-flex items-center rounded-full px-4 py-2 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 text-sm font-semibold mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <?php _e('Trusted by 5M+ customers', 'yoursite'); ?>
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                <?php _e('Why Choose Zencommerce?', 'yoursite'); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                <?php _e('We\'ve been helping businesses establish their online presence since 2008. Here\'s what makes us different from other domain registrars.', 'yoursite'); ?>
            </p>
        </div>
        
        <!-- Main Benefits -->
        <div class="grid lg:grid-cols-3 gap-12 mb-20">
            
            <!-- Benefit 1: Speed & Reliability -->
            <div class="text-center group">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                    <div class="relative w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl mx-auto flex items-center justify-center group-hover:scale-110 transition-all duration-500 shadow-2xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center animate-pulse">
                        <span class="text-xs font-bold text-gray-900">⚡</span>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php _e('Instant Activation', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                    <?php _e('Your domain goes live immediately after purchase. No waiting hours or days - start building your website right away with our lightning-fast registration system.', 'yoursite'); ?>
                </p>
                <div class="inline-flex items-center text-green-600 dark:text-green-400 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <?php _e('Average setup: Under 60 seconds', 'yoursite'); ?>
                </div>
            </div>
            
            <!-- Benefit 2: Security & Privacy -->
            <div class="text-center group">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                    <div class="relative w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl mx-auto flex items-center justify-center group-hover:scale-110 transition-all duration-500 shadow-2xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-green-400 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php _e('Privacy Protection', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                    <?php _e('Free WHOIS privacy protection keeps your personal information safe from spammers and identity thieves. Plus advanced security features including two-factor authentication.', 'yoursite'); ?>
                </p>
                <div class="inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <?php _e('FREE for life - Save $15/year', 'yoursite'); ?>
                </div>
            </div>
            
            <!-- Benefit 3: Support Excellence -->
            <div class="text-center group">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                    <div class="relative w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl mx-auto flex items-center justify-center group-hover:scale-110 transition-all duration-500 shadow-2xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 bg-orange-400 text-white text-xs px-2 py-1 rounded-full font-bold">24/7</div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php _e('Expert Support', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                    <?php _e('Real humans, not bots. Our award-winning support team is available 24/7 via live chat, email, and phone. Average response time under 2 minutes.', 'yoursite'); ?>
                </p>
                <div class="inline-flex items-center text-purple-600 dark:text-purple-400 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <?php _e('4.9/5 customer satisfaction', 'yoursite'); ?>
                </div>
            </div>
        </div>
        
        <!-- Success Metrics -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-12 shadow-2xl border border-gray-200 dark:border-gray-700 mb-20">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php _e('Trusted by Millions', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    <?php _e('Join successful businesses worldwide who rely on Zencommerce for their domain needs', 'yoursite'); ?>
                </p>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2" data-count="5000000">5M+</div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium"><?php _e('Happy Customers', 'yoursite'); ?></div>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2" data-count="99.9">99.9%</div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium"><?php _e('Uptime Guarantee', 'yoursite'); ?></div>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">< 2min</div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium"><?php _e('Support Response', 'yoursite'); ?></div>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">300+</div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium"><?php _e('Domain Extensions', 'yoursite'); ?></div>
                </div>
            </div>
        </div>
        
        <!-- Comparison Section -->
        <div class="bg-gradient-to-br from-slate-800 to-gray-900 rounded-3xl overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-center">
                <h3 class="text-3xl font-bold text-white mb-4">
                    <?php _e('See Why We\'re Different', 'yoursite'); ?>
                </h3>
                <p class="text-blue-100 max-w-2xl mx-auto">
                    <?php _e('Compare Zencommerce with other registrars and see why smart businesses choose us', 'yoursite'); ?>
                </p>
            </div>
            
            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="pb-4 text-white font-bold text-lg"><?php _e('Feature', 'yoursite'); ?></th>
                                <th class="pb-4 text-center">
                                    <div class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-full font-bold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <?php _e('Zencommerce', 'yoursite'); ?>
                                    </div>
                                </th>
                                <th class="pb-4 text-center text-gray-400 font-semibold"><?php _e('Others', 'yoursite'); ?></th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr class="border-b border-gray-700">
                                <td class="py-4 text-white font-medium"><?php _e('Privacy Protection', 'yoursite'); ?></td>
                                <td class="py-4 text-center">
                                    <div class="inline-flex items-center text-green-400 font-bold">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        FREE for Life
                                    </div>
                                </td>
                                <td class="py-4 text-center">
                                    <span class="text-red-400 font-bold"><?php echo esc_html($current_currency['symbol']); ?>15/year</span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-700">
                                <td class="py-4 text-white font-medium"><?php _e('Support Response Time', 'yoursite'); ?></td>
                                <td class="py-4 text-center text-green-400 font-bold"><?php _e('< 2 minutes', 'yoursite'); ?></td>
                                <td class="py-4 text-center text-red-400"><?php _e('2-24 hours', 'yoursite'); ?></td>
                            </tr>
                            <tr class="border-b border-gray-700">
                                <td class="py-4 text-white font-medium"><?php _e('Domain Transfer', 'yoursite'); ?></td>
                                <td class="py-4 text-center">
                                    <div class="inline-flex items-center text-green-400 font-bold">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        FREE + 1 Year
                                    </div>
                                </td>
                                <td class="py-4 text-center text-red-400"><?php _e('Fees Apply', 'yoursite'); ?></td>
                            </tr>
                            <tr class="border-b border-gray-700">
                                <td class="py-4 text-white font-medium"><?php _e('Money-Back Guarantee', 'yoursite'); ?></td>
                                <td class="py-4 text-center text-green-400 font-bold"><?php _e('30 Days', 'yoursite'); ?></td>
                                <td class="py-4 text-center text-red-400"><?php _e('5-7 Days', 'yoursite'); ?></td>
                            </tr>
                            <tr>
                                <td class="py-4 text-white font-medium"><?php _e('Email & DNS Management', 'yoursite'); ?></td>
                                <td class="py-4 text-center">
                                    <div class="inline-flex items-center text-green-400 font-bold">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Advanced
                                    </div>
                                </td>
                                <td class="py-4 text-center text-gray-400"><?php _e('Basic', 'yoursite'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Customer Testimonials -->
        <div class="mt-20">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php _e('What Our Customers Say', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php _e('Real reviews from real customers who trust Zencommerce', 'yoursite'); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 group">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400">
                            <?php for($i = 0; $i < 5; $i++): ?>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <blockquote class="text-gray-600 dark:text-gray-300 mb-6 text-lg leading-relaxed">
                        "<?php _e('I\'ve tried other registrars, but Zencommerce beats them all on pricing and features. The bulk management tools are perfect for my domain portfolio, and I love the API integration.', 'yoursite'); ?>"
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                            MC
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white">Mike Chen</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Web Developer</div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 group">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400">
                            <?php for($i = 0; $i < 5; $i++): ?>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <blockquote class="text-gray-600 dark:text-gray-300 mb-6 text-lg leading-relaxed">
                        "<?php _e('When I had issues transferring 50+ domains from my old registrar, Zencommerce support handled everything. They even stayed on a call with me for 2 hours to ensure everything went smoothly.', 'yoursite'); ?>"
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                            AR
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white">Alex Rivera</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Digital Marketing Agency Owner</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Final CTA Section -->
        <div class="mt-20 text-center">
            <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-3xl p-12 text-white shadow-2xl relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" fill-rule="evenodd">
                            <g fill="currentColor" fill-opacity="0.3">
                                <circle cx="30" cy="30" r="2"/>
                                <circle cx="10" cy="10" r="1"/>
                                <circle cx="50" cy="10" r="1"/>
                                <circle cx="10" cy="50" r="1"/>
                                <circle cx="50" cy="50" r="1"/>
                            </g>
                        </g>
                    </svg>
                </div>
                
                <div class="relative">
                    <h3 class="text-4xl font-bold mb-6 text-white">
                        <?php _e('Ready to Join 5 Million+ Happy Customers?', 'yoursite'); ?>
                    </h3>
                    <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto text-white">
                        <?php _e('Start your online journey today with the most trusted domain registrar. Get instant setup, free privacy protection, and award-winning support.', 'yoursite'); ?>
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-lg mx-auto">
                        <a href="#domain-search" 
                           class="flex-1 px-8 py-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 font-bold text-lg rounded-xl hover:from-yellow-500 hover:to-orange-600 transition-all duration-200 transform hover:scale-105 shadow-lg scroll-to-search text-white">
                            <?php _e('Find Your Domain', 'yoursite'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" 
                           class="flex-1 px-8 py-4 bg-white/20 backdrop-blur-sm border border-white/30 text-white font-bold text-lg rounded-xl hover:bg-white/30 transition-all duration-200">
                            <?php _e('Talk to Expert', 'yoursite'); ?>
                        </a>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-center text-white/80 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php _e('30-day money-back guarantee', 'yoursite'); ?>
                        <span class="mx-2">•</span>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <?php _e('Free privacy protection', 'yoursite'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced JavaScript for Animations and Interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced counter animation with easing
    function animateCounters() {
        const counters = document.querySelectorAll('[data-count]');
        
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const finalValue = element.getAttribute('data-count');
                    
                    if (finalValue === '5000000') {
                        animateNumber(element, 0, 5000000, 'M+', 2500, (val) => (val / 1000000).toFixed(1));
                    } else if (finalValue === '99.9') {
                        animateNumber(element, 0, 99.9, '%', 2000, (val) => val.toFixed(1));
                    }
                    
                    observer.unobserve(element);
                }
            });
        }, observerOptions);
        
        counters.forEach(counter => {
            observer.observe(counter);
        });
    }
    
    function animateNumber(element, start, end, suffix, duration, formatter) {
        const startTime = performance.now();
        
        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing function for smooth animation
            const easedProgress = easeOutCubic(progress);
            const current = start + (end - start) * easedProgress;
            
            if (formatter) {
                element.textContent = formatter(current) + suffix;
            } else {
                element.textContent = Math.floor(current) + suffix;
            }
            
            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }
        
        requestAnimationFrame(update);
    }
    
    function easeOutCubic(t) {
        return 1 - Math.pow(1 - t, 3);
    }
    
    // Scroll-triggered animations for benefit cards
    function animateBenefitCards() {
        const cards = document.querySelectorAll('.group');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.style.opacity = '1';
                    }, index * 150);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        cards.forEach((card, index) => {
            card.style.transform = 'translateY(30px)';
            card.style.opacity = '0';
            card.style.transition = 'all 0.8s cubic-bezier(0.22, 1, 0.36, 1)';
            observer.observe(card);
        });
    }
    
    // Scroll to search functionality
    document.querySelectorAll('.scroll-to-search').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const searchSection = document.querySelector('.domain-search-container') || document.querySelector('#upmind-domain-search');
            if (searchSection) {
                searchSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                
                setTimeout(() => {
                    const searchInput = searchSection.querySelector('input[type="text"]');
                    if (searchInput && searchInput.offsetParent !== null) {
                        searchInput.focus();
                    }
                }, 500);
            }
        });
    });
    
    // Enhanced testimonial interactions
    function setupTestimonialInteractions() {
        const testimonials = document.querySelectorAll('.bg-white.dark\\:bg-gray-800.rounded-3xl');
        
        testimonials.forEach(testimonial => {
            testimonial.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            testimonial.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }
    
    // Track user interactions for analytics
    function trackInteractions() {
        // Track benefit card hovers
        document.querySelectorAll('.group').forEach((card, index) => {
            card.addEventListener('mouseenter', function() {
                const benefitTitle = this.querySelector('h3').textContent.trim();
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'benefit_card_hover', {
                        'event_category': 'engagement',
                        'event_label': benefitTitle,
                        'value': index
                    });
                }
            });
        });
        
        // Track testimonial interactions
        document.querySelectorAll('blockquote').forEach((quote, index) => {
            quote.addEventListener('click', function() {
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'testimonial_click', {
                        'event_category': 'engagement',
                        'event_label': `Testimonial ${index + 1}`,
                        'value': index
                    });
                }
            });
        });
        
        // Track comparison table views
        const comparisonTable = document.querySelector('table');
        if (comparisonTable) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (typeof gtag !== 'undefined') {
                            gtag('event', 'comparison_table_view', {
                                'event_category': 'engagement',
                                'event_label': 'Why Choose Section'
                            });
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            observer.observe(comparisonTable);
        }
    }
    
    // Initialize all functionality
    animateCounters();
    animateBenefitCards();
    setupTestimonialInteractions();
    trackInteractions();
    
    // Add smooth hover effects to metric cards
    document.querySelectorAll('[data-count]').forEach(metric => {
        const container = metric.closest('.text-center.group');
        if (container) {
            container.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.w-16.h-16');
                if (icon) {
                    icon.style.transform = 'scale(1.1) rotate(5deg)';
                }
            });
            
            container.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.w-16.h-16');
                if (icon) {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }
            });
        }
    });
});
</script>

<!-- Additional CSS for enhanced animations -->
<style>
/* Enhanced hover effects */
.group:hover .w-24.h-24 {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Smooth transitions for all interactive elements */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Enhanced gradient animations */
@keyframes gradient-x {
    0%, 100% {
        background-size: 200% 200%;
        background-position: left center;
    }
    50% {
        background-size: 200% 200%;
        background-position: right center;
    }
}

.bg-gradient-to-br:hover {
    animation: gradient-x 3s ease infinite;
}

/* Smooth scaling for metric icons */
.w-16.h-16 {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Enhanced testimonial cards */
.bg-white.dark\:bg-gray-800.rounded-3xl {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Comparison table enhancements */
table tr:hover {
    background: rgba(59, 130, 246, 0.05);
    transition: background-color 0.2s ease;
}

/* Loading states for better UX */
@keyframes pulse-subtle {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse-subtle {
    animation: pulse-subtle 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>