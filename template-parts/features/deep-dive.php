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
                        <a href="https://zencommerce.net/features/store-building/" class="feature-cta-button mt-4">
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
                                <span>Processing fees saved:</span>
                                <span class="font-semibold">$2,400/month</span>
                            </div>
                        </div>
                        <a href="https://zencommerce.net/features/payments/" class="feature-cta-button mt-4">
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
            <!-- Marketing & SEO Deep Dive -->
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
                        <a href="https://zencommerce.net/features/marketing-seo/" class="feature-cta-button mt-4">
                            <span>Learn More About Marketing & SEO</span>
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
                                <span>Touch-optimized checkout</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Progressive Web App features</span>
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
                        <a href="https://zencommerce.net/features/mobile-commerce/" class="feature-cta-button mt-4">
                            <span>Learn More About Mobile Commerce</span>
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
                        <a href="https://zencommerce.net/features/inventory/" class="feature-cta-button mt-4">
                            <span>Learn More About Inventory</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_shipping_enable', true)) : ?>
            <!-- Shipping Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Shipping That Delights Customers</h3>
                        <p class="text-gray-600 mb-6">
                            Turn shipping from a cost center into a competitive advantage. Our smart shipping engine finds the cheapest rates, automates tracking, and keeps customers happy with real-time updates.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Compare rates from 50+ carriers instantly</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automated tracking & customer notifications</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Bulk label printing & order fulfillment</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Shipping costs saved:</span>
                                <span class="font-semibold">$1,200/month</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Fulfillment time reduced:</span>
                                <span class="font-semibold">60% faster</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Customer satisfaction boost:</span>
                                <span class="font-semibold">43% higher</span>
                            </div>
                        </div>
                        <a href="https://zencommerce.net/features/shipping/" class="feature-cta-button mt-4">
                            <span>Learn More About Shipping</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_analytics_enable', true)) : ?>
            <!-- Analytics Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Analytics That Make You Money</h3>
                        <p class="text-gray-600 mb-6">
                            Stop guessing what works. Our advanced analytics reveal exactly which products, campaigns, and strategies drive the most profit, so you can double down on what's working.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Real-time profit & loss tracking</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Customer lifetime value insights</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Conversion funnel optimization</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Revenue optimization:</span>
                                <span class="font-semibold">34% increase</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Marketing ROI improvement:</span>
                                <span class="font-semibold">127% better</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Decision-making speed:</span>
                                <span class="font-semibold">5x faster</span>
                            </div>
                        </div>
                        <a href="https://zencommerce.net/features/analytics/" class="feature-cta-button mt-4">
                            <span>Learn More About Analytics</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_security_enable', true)) : ?>
            <!-- Security & Cloud Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Security That Protects Your Business</h3>
                        <p class="text-gray-600 mb-6">
                            Sleep soundly knowing your store is protected by enterprise-grade security. Our cloud infrastructure handles 99.9% uptime, automatic backups, and Fort Knox-level data protection.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>99.9% uptime guarantee</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic daily backups</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>SSL certificates & fraud protection</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Downtime prevention:</span>
                                <span class="font-semibold">$8,500/month saved</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Security breach protection:</span>
                                <span class="font-semibold">99.99% effective</span>
                            </div>
                            <div class="flex justify-between">
                                <span>IT costs eliminated:</span>
                                <span class="font-semibold">$3,200/month</span>
                            </div>
                        </div>
                        <a href="https://zencommerce.net/features/security-cloud/" class="feature-cta-button mt-4">
                            <span>Learn More About Security & Cloud</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_payment_links_enable', true)) : ?>
            <!-- Payment Links Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Payment Links That Close Deals</h3>
                        <p class="text-gray-600 mb-6">
                            Send a payment link, get paid instantly. Perfect for custom quotes, services, or quick sales. No cart abandonment, no complicated checkout - just click, pay, done.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Create payment links in 30 seconds</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Custom amounts & recurring payments</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Track clicks & conversion rates</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Faster payment collection:</span>
                                <span class="font-semibold">73% quicker</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Service sales increase:</span>
                                <span class="font-semibold">$2,800/month</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Payment friction eliminated:</span>
                                <span class="font-semibold">56% more conversions</span>
                            </div>
                        </div>
                        <a href="https://zencommerce.net/features/payment-links/" class="feature-cta-button mt-4">
                            <span>Learn More About Payment Links</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_social_commerce_enable', true)) : ?>
            <!-- Social Commerce Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Social Commerce That Sells</h3>
                        <p class="text-gray-600 mb-6">
                            Turn your social media into a sales machine. Our social commerce tools let customers buy directly from Instagram, Facebook, and TikTok without leaving their favorite apps.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Instagram Shopping integration</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Facebook Shop synchronization</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>TikTok Shop & Pinterest Ready</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Social traffic conversion:</span>
                                <span class="font-semibold">184% higher</span>
                            </div>
                            <div class="flex justify-between">
                                <span>New customer acquisition:</span>
                                <span class="font-semibold">$3,600/month</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Brand reach expansion:</span>
                                <span class="font-semibold">312% growth</span>
                            </div>
                        </div>
                        <a href="https://zencommerce.net/features/social-commerce/" class="feature-cta-button mt-4">
                            <span>Learn More About Social Commerce</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (get_theme_mod('features_graphics_enable', true)) : ?>
            <!-- Graphics & Appearance Deep Dive -->
            <div class="feature-deep-card mb-12">
                <div class="grid lg:grid-cols-2 gap-8 items-start">
                    <div>
                        <div class="feature-category-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Graphics That Convert Browsers to Buyers</h3>
                        <p class="text-gray-600 mb-6">
                            First impressions matter. Our professional design tools and templates make your store look like a million-dollar brand, even if you can't tell Photoshop from PowerPoint.
                        </p>
                        <div class="space-y-3">
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Professional design templates</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Automatic image optimization</span>
                            </div>
                            <div class="feature-benefit-item">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Brand consistency tools</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">What This Means for Your Business:</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Design costs saved:</span>
                                <span class="font-semibold">$4,500/month</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Brand trust increase:</span>
                                <span class="font-semibold">68% higher</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Visual conversion boost:</span>
                                <span class="font-semibold">45% more sales</span>
                            </div>
                        </div>
                        <a href="https://zencommerce.net/features/graphics-and-appearance/" class="feature-cta-button mt-4">
                            <span>Learn More About Graphics & Appearance</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Call-to-Action Section -->
            <div class="text-center mt-16">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    Ready to Stop Settling for Less?
                </h3>
                <p class="text-lg text-gray-600 mb-8">
                    While others juggle 15 different tools, you'll have everything you need in one platform that just works.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Start Your Free Trial
                    </a>
                    <a href="#" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                        See All Features
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>