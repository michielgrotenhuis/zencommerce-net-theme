<?php
/**
 * Domain Archive - Final CTA Section
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$');
$special_price = $args['special_price'] ?? '9.99';
$regular_price = $args['regular_price'] ?? '14.99';

?>

<!-- Final CTA Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-32 right-20 w-24 h-24 bg-cyan-300/20 rounded-full blur-lg animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-purple-300/15 rounded-full blur-md animate-pulse delay-500"></div>
        <div class="absolute top-1/4 right-1/4 w-20 h-20 bg-yellow-300/10 rounded-full blur-lg animate-pulse delay-700"></div>
    </div>
    
    <!-- Floating Icons -->
    <div class="absolute inset-0 overflow-hidden opacity-10">
        <div class="absolute top-16 left-16 animate-float">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="absolute top-32 right-32 animate-float" style="animation-delay: 2s;">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="absolute bottom-24 left-24 animate-float" style="animation-delay: 4s;">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto text-center">
            
            <!-- Main CTA Content -->
            <div class="mb-16">
                <h2 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight text-white">
                    <?php _e('Ready to Claim Your', 'yoursite'); ?>
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400">
                        <?php _e('Perfect Domain?', 'yoursite'); ?>
                    </span>
                </h2>
                <p class="text-xl lg:text-2xl mb-8 opacity-90 max-w-3xl mx-auto text-white">
                    <?php _e('Join over 5 million customers who trust us for their domain needs. Get started today with instant setup and expert support.', 'yoursite'); ?>
                </p>
                
                <!-- Primary CTA Button -->
                <div class="mb-8">
                    <a href="#domain-search" 
                       class="inline-flex items-center justify-center px-12 py-5 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 font-bold text-xl rounded-2xl hover:from-yellow-500 hover:to-orange-600 transition-all duration-200 transform hover:scale-105 shadow-2xl hover:shadow-3xl scroll-to-search text-white">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <?php _e('Search Domains Now', 'yoursite'); ?>
                    </a>
                </div>
                
                <p class="text-white/70 text-sm">
                    <?php printf(__('Starting from %s%s/year • Free privacy protection • 30-day money-back guarantee', 'yoursite'), 
                        esc_html($current_currency['symbol']), 
                        esc_html($special_price)
                    ); ?>
                </p>
            </div>
            
            <!-- Secondary CTAs Grid -->
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                
                <!-- Transfer Domains -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">
                        <?php _e('Transfer Your Domains', 'yoursite'); ?>
                    </h3>
                    <p class="text-white/80 mb-6">
                        <?php _e('Move your existing domains and save money with better features and support.', 'yoursite'); ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/domain-transfer')); ?>" 
                       class="inline-flex items-center text-yellow-300 hover:text-yellow-200 font-semibold transition-colors duration-200">
                        <?php _e('Start Transfer', 'yoursite'); ?>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <!-- Bulk Registration -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">
                        <?php _e('Bulk Registration', 'yoursite'); ?>
                    </h3>
                    <p class="text-white/80 mb-6">
                        <?php _e('Register multiple domains at once with volume discounts. Perfect for businesses and investors.', 'yoursite'); ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/bulk-domains')); ?>" 
                       class="inline-flex items-center text-yellow-300 hover:text-yellow-200 font-semibold transition-colors duration-200">
                        <?php _e('Get Quote', 'yoursite'); ?>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <!-- Expert Consultation -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">
                        <?php _e('Expert Consultation', 'yoursite'); ?>
                    </h3>
                    <p class="text-white/80 mb-6">
                        <?php _e('Not sure which domain is right for you? Talk to our experts for personalized recommendations.', 'yoursite'); ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" 
                       class="inline-flex items-center text-yellow-300 hover:text-yellow-200 font-semibold transition-colors duration-200">
                        <?php _e('Contact Expert', 'yoursite'); ?>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Trust Signals -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-16">
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-300 mb-2 counter" data-target="5">0</div>
                    <div class="text-white/80 text-sm"><?php _e('Million+ Customers', 'yoursite'); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-300 mb-2 counter" data-target="99.9">0</div>
                    <div class="text-white/80 text-sm"><?php _e('% Uptime SLA', 'yoursite'); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-300 mb-2">24/7</div>
                    <div class="text-white/80 text-sm"><?php _e('Expert Support', 'yoursite'); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-300 mb-2 counter" data-target="15">0</div>
                    <div class="text-white/80 text-sm"><?php _e('+ Years Experience', 'yoursite'); ?></div>
                </div>
            </div>
            
            <!-- Final Incentive -->
            <div class="bg-black/20 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="max-w-3xl mx-auto">
                    <h3 class="text-2xl font-bold mb-4 text-white">
                        <?php _e('🎉 Special Launch Offer', 'yoursite'); ?>
                    </h3>
                    <p class="text-xl mb-6 opacity-90 text-white">
                        <?php printf(__('Get your first domain for just %s%s (regular %s%s) and receive a FREE website builder, SSL certificate, and professional email address.', 'yoursite'), 
                            esc_html($current_currency['symbol']), 
                            esc_html($special_price),
                            esc_html($current_currency['symbol']), 
                            esc_html($regular_price)
                        ); ?>
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <div class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold animate-pulse">
                            <?php _e('⏰ Limited Time Offer', 'yoursite'); ?>
                        </div>
                        <div class="text-white/70">
                            <?php _e('Offer expires in:', 'yoursite'); ?>
                            <span id="countdown-timer" class="font-bold text-yellow-300 ml-2">23:59:59</span>
                        </div>
                    </div>
                    
                    <!-- Secondary CTA Button -->
                    <div class="mt-8">
                        <a href="#domain-search" 
                           class="inline-flex items-center justify-center px-8 py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 scroll-to-search">
                            <?php _e('Claim This Offer Now', 'yoursite'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS for Animations -->
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

/* Enhanced gradient animations */
.bg-gradient-to-r.from-yellow-400.to-orange-500:hover {
    background-size: 200% 200%;
    animation: gradient-shift 0.3s ease-in-out;
}

@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    100% { background-position: 100% 50%; }
}

/* Countdown timer styling */
#countdown-timer {
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
}

/* Pulse effect for limited time offer */
@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.5);
    }
    50% {
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.8);
    }
}

.animate-pulse {
    animation: pulse-glow 2s infinite;
}

/* Counter animation */
.counter {
    transition: all 0.5s ease-in-out;
}
</style>

<!-- JavaScript for Interactive Elements -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Countdown Timer
    function initCountdownTimer() {
        const timer = document.getElementById('countdown-timer');
        if (!timer) return;
        
        // Set countdown to 24 hours from now
        const endTime = new Date().getTime() + (24 * 60 * 60 * 1000);
        
        function updateTimer() {
            const now = new Date().getTime();
            const timeLeft = endTime - now;
            
            if (timeLeft > 0) {
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                
                timer.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            } else {
                timer.textContent = '00:00:00';
                clearInterval(timerInterval);
            }
        }
        
        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);
    }
    
    // Animate counters on scroll
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const target = parseFloat(element.getAttribute('data-target'));
                    animateNumber(element, 0, target, 2000);
                    observer.unobserve(element);
                }
            });
        }, observerOptions);
        
        counters.forEach(counter => {
            observer.observe(counter);
        });
    }
    
    function animateNumber(element, start, end, duration) {
        const startTime = performance.now();
        
        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = start + (end - start) * easeOutQuart(progress);
            
            if (end === 99.9) {
                element.textContent = current.toFixed(1);
            } else {
                element.textContent = Math.floor(current);
            }
            
            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }
        
        requestAnimationFrame(update);
    }
    
    function easeOutQuart(t) {
        return 1 - Math.pow(1 - t, 4);
    }
    
    // Scroll to search functionality
    document.querySelectorAll('.scroll-to-search').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const searchSection = document.querySelector('.domain-search-container') || 
                                 document.querySelector('#upmind-domain-search') ||
                                 document.querySelector('#domain-search');
            if (searchSection) {
                searchSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                
                // Focus on search input after scroll
                setTimeout(() => {
                    const searchInput = searchSection.querySelector('input[type="text"]');
                    if (searchInput && searchInput.offsetParent !== null) {
                        searchInput.focus();
                    }
                }, 500);
            }
        });
    });
    
    // Track CTA interactions for analytics
    document.querySelectorAll('a[href*="domain"], a[href*="transfer"], a[href*="bulk"], a[href*="contact"]').forEach(link => {
        link.addEventListener('click', function() {
            const linkText = this.textContent.trim();
            const linkHref = this.getAttribute('href');
            
            // Google Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'cta_click', {
                    'event_category': 'conversion',
                    'event_label': linkText,
                    'event_value': linkHref
                });
            }
            
            // Facebook Pixel tracking
            if (typeof fbq !== 'undefined') {
                fbq('track', 'Lead', {
                    content_name: linkText,
                    content_category: 'Domain CTA'
                });
            }
        });
    });
    
    // Floating elements interaction
    document.querySelectorAll('.animate-float').forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.animationPlayState = 'paused';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.animationPlayState = 'running';
        });
    });
    
    // Exit intent detection for additional offer
    let exitIntentShown = false;
    
    document.addEventListener('mouseleave', function(e) {
        if (e.clientY <= 0 && !exitIntentShown) {
            exitIntentShown = true;
            showExitIntentModal();
        }
    });
    
    function showExitIntentModal() {
        // Create exit intent modal with special offer
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 animate-fadeIn';
        modal.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md mx-4 text-center transform animate-slideIn">
                <div class="text-4xl mb-4">🎁</div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php esc_js_e('Wait! Don\'t Miss Out!', 'yoursite'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    <?php esc_js_e('Get an additional 20% off your first domain registration. Use code SAVE20 at checkout.', 'yoursite'); ?>
                </p>
                <div class="flex gap-4">
                    <button onclick="this.closest('.fixed').remove()" 
                            class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                        <?php esc_js_e('No Thanks', 'yoursite'); ?>
                    </button>
                    <a href="#domain-search" 
                       onclick="this.closest('.fixed').remove()" 
                       class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 scroll-to-search">
                        <?php esc_js_e('Claim Offer', 'yoursite'); ?>
                    </a>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Track exit intent for analytics
        if (typeof gtag !== 'undefined') {
            gtag('event', 'exit_intent_modal', {
                'event_category': 'engagement',
                'event_label': 'CTA Section'
            });
        }
        
        // Auto close after 15 seconds
        setTimeout(() => {
            if (modal.parentNode) {
                modal.remove();
            }
        }, 15000);
    }
    
    // Initialize all functions
    initCountdownTimer();
    animateCounters();
});
</script>

<?php
// Additional CSS for modal animations
?>
<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { 
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to { 
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

.animate-slideIn {
    animation: slideIn 0.4s ease-out;
}
</style>