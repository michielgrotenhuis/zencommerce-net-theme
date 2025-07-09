<?php
/**
 * Pre-Footer CTA Section Template Part
 */

// Get data passed from main footer
$formatted_amount = $args['formatted_amount'] ?? '$200';
$base_usd_amount = $args['base_usd_amount'] ?? 200;
$converted_amount = $args['converted_amount'] ?? 200;
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$');
?>

<!-- Pre-Footer CTA Section -->
<section class="final-cta-section relative py-20 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 text-white overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/90 to-purple-600/90"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/5 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-white/5 rounded-full animate-pulse delay-1000"></div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Trust Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium mb-6 border border-white/20">
                <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Join 50,000+ successful merchants
            </div>
            
            <!-- Main Headline -->
            <h2 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight text-white">
                Ready to Launch Your Dream Store?
            </h2>
            
            <!-- Subheadline -->
            <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto leading-relaxed text-white">
                Start your 14-day free trial today. No credit card required, no setup fees, cancel anytime.
            </p>
            
            <!-- Dynamic Currency Limited Time Offer -->
            <div class="limited-time-offer bg-yellow-400 text-yellow-900 px-6 py-3 rounded-full inline-block font-bold text-lg mb-8" 
                 data-base-amount="<?php echo esc_attr($base_usd_amount); ?>"
                 data-current-currency="<?php echo esc_attr($current_currency['code']); ?>"
                 data-current-amount="<?php echo esc_attr($converted_amount); ?>">
                🔥 <span class="offer-text">Limited Time: Free setup worth <span class="offer-amount"><?php echo esc_html($formatted_amount); ?></span></span>
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <!-- Primary CTA -->
                <a href="/signup" 
                   class="group inline-flex items-center justify-center px-10 py-5 bg-white text-gray-900 font-bold text-xl rounded-2xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300 min-w-[280px]">
                    <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Start Your Free Store Now
                    <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <!-- Secondary CTA -->
                <a href="/demo" 
                   class="group inline-flex items-center justify-center px-10 py-5 bg-transparent border-2 border-white/60 hover:border-white text-white font-bold text-xl rounded-2xl hover:bg-white/10 transition-all duration-300 min-w-[280px]">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Book a Demo
                </a>
            </div>
            
            <!-- Risk Reversal & Trust Elements -->
            <div class="flex flex-wrap justify-center items-center gap-6 text-sm opacity-90">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    14-day free trial
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    No credit card required
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    30-day money-back guarantee
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Cancel anytime
                </div>
            </div>
        </div>
    </div>
    
    <!-- Background Pattern -->
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
</section>