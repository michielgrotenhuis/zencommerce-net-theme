<?php
/**
 * Template part for Features Deep Dive Section
 * Save as: template-parts/features/deep-dive.php
 * 
 * @package YourSite
 */
?>

<!-- Deep Dive Features Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Every Feature Solves a Real Business Problem
                </h2>
                <p class="text-xl text-gray-600">
                    Click on any feature to learn how it directly impacts your bottom line
                </p>
            </div>
            
            <?php if (get_theme_mod('features_store_building_enable', true)) : ?>
            <!-- Store Building Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Store Building That Actually Works</h3>
                        <p class="text-gray-600 mb-6">
                            Stop wasting weeks trying to make your store look professional. Our drag-and-drop builder creates conversion-optimized stores that look like they cost $50,000 to build.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Build your store in 15 minutes, not 15 weeks</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>100+ conversion-tested templates</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic mobile optimization</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>No coding or design skills needed</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Time saved monthly:</span>
                                <span class="font-semibold">40+ hours</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Development cost saved:</span>
                                <span class="font-semibold">$15,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Faster time to market:</span>
                                <span class="font-semibold">90% faster</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4 color-white">
                            <span>Learn More About Store Building</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (get_theme_mod('features_payments_enable', true)) : ?>
            <!-- Payments Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Payments That Actually Convert</h3>
                        <p class="text-gray-600 mb-6">
                            Stop losing customers at checkout. Our optimized payment process reduces cart abandonment by 32% and supports every payment method your customers want to use.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>One-click checkout with Apple Pay, Google Pay</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Accept 130+ currencies globally</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Bank-level security & PCI compliance</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic tax calculation for 180+ countries</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Cart abandonment reduction:</span>
                                <span class="font-semibold">32% lower</span>
                            </div>
                            <div class="flex justify-between">
                                <span>International sales increase:</span>
                                <span class="font-semibold">165% higher</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Payment processing saved:</span>
                                <span class="font-semibold">$2,400/month</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4">
                            <span>Learn More About Payments</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (get_theme_mod('features_marketing_enable', true)) : ?>
            <!-- Marketing Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Marketing That Runs Itself</h3>
                        <p class="text-gray-600 mb-6">
                            Stop juggling 12 different marketing tools. Our built-in marketing suite automates email campaigns, recovers abandoned carts, and optimizes your SEO without you lifting a finger.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automated email marketing campaigns</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Smart abandoned cart recovery</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Built-in SEO optimization</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Social media integration</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Marketing tools saved:</span>
                                <span class="font-semibold">$890/month</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Email open rates:</span>
                                <span class="font-semibold">47% higher</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Recovered cart revenue:</span>
                                <span class="font-semibold">$3,200/month</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4">
                            <span>Learn More About Marketing</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (get_theme_mod('features_mobile_enable', true)) : ?>
            <!-- Mobile Commerce Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a1 1 0 001-1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v16a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile Commerce That Converts</h3>
                        <p class="text-gray-600 mb-6">
                            75% of your customers shop on mobile. Our mobile-first approach ensures your store loads instantly, looks perfect, and converts visitors into buyers on any device.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Sub-2 second load times on mobile</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Touch-optimized navigation and checkout</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Progressive Web App features</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic image optimization</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Mobile conversion increase:</span>
                                <span class="font-semibold">89% higher</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Page load improvement:</span>
                                <span class="font-semibold">67% faster</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Mobile revenue boost:</span>
                                <span class="font-semibold">$4,200/month</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4">
                            <span>Learn More About Mobile</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (get_theme_mod('features_inventory_enable', true)) : ?>
            <!-- Inventory Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Inventory Management That Thinks Ahead</h3>
                        <p class="text-gray-600 mb-6">
                            Never run out of stock again. Our smart inventory system tracks everything in real-time, predicts when you'll need to reorder, and automatically manages your suppliers.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Real-time inventory tracking</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Smart reorder point alerts</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic supplier management</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Multi-warehouse support</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Stockout prevention:</span>
                                <span class="font-semibold">95% reduction</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Inventory costs saved:</span>
                                <span class="font-semibold">$1,850/month</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Time saved on admin:</span>
                                <span class="font-semibold">25 hours/week</span>
                            </div>
                        </div>
                        <a href="#" class="feature-cta-button mt-4">
                            <span>Learn More About Inventory</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            