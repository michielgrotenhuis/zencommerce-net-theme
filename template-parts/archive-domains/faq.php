<?php
/**
 * Domain Archive - FAQ Section
 * Modern version matching template design patterns
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Extract data from args
$current_currency = $args['current_currency'] ?? array('code' => 'USD', 'symbol' => '$', 'name' => 'USD');

// Define FAQ items with better content structure
$faq_items = array(
    array(
        'question' => __('What is a domain name and why do I need one?', 'yoursite'),
        'answer' => __('A domain name is your unique address on the internet, like yourcompany.com. It makes it easy for customers to find your website and gives your business credibility. Without a domain, people would need to remember complex IP addresses to visit your site.', 'yoursite')
    ),
    array(
        'question' => __('How do I choose the right domain extension?', 'yoursite'),
        'answer' => __('Consider your business type and target audience. .com is best for most businesses, .org for nonprofits, .shop for e-commerce, and country-specific extensions like .uk for local businesses. New extensions like .tech or .app can be great for specific industries.', 'yoursite')
    ),
    array(
        'question' => __('What\'s included with my domain registration?', 'yoursite'),
        'answer' => __('Every domain includes free WHOIS privacy protection, DNS management, email forwarding, domain forwarding, SSL certificate, and 24/7 support. You also get access to our easy-to-use control panel and API access for developers.', 'yoursite')
    ),
    array(
        'question' => __('How long does it take for my domain to become active?', 'yoursite'),
        'answer' => __('Most domains are active instantly after registration. However, it can take up to 24-48 hours for the domain to fully propagate across all DNS servers worldwide. You can start using your domain immediately for email and basic setup.', 'yoursite')
    ),
    array(
        'question' => __('Can I transfer my existing domain to your service?', 'yoursite'),
        'answer' => __('Yes! Domain transfers are easy and include a 1-year extension. The process typically takes 5-7 days. You\'ll need your current registrar\'s authorization code and ensure your domain isn\'t locked or recently transferred.', 'yoursite')
    ),
    array(
        'question' => __('What happens if I don\'t renew my domain?', 'yoursite'),
        'answer' => __('Domains expire if not renewed on time. You have a 30-day grace period to renew at regular price, followed by a 30-day redemption period with additional fees. After that, the domain becomes available for anyone to register.', 'yoursite')
    ),
    array(
        'question' => __('Do you offer bulk domain discounts?', 'yoursite'),
        'answer' => __('Yes! We offer volume discounts for customers registering 10+ domains. Contact our sales team for custom pricing on bulk registrations, transfers, and renewals. We also have special rates for resellers and developers.', 'yoursite')
    ),
    array(
        'question' => __('Is my personal information protected?', 'yoursite'),
        'answer' => __('Absolutely! Free WHOIS privacy protection is included with every domain registration. This replaces your personal contact information in the public WHOIS database with our privacy service details, protecting you from spam and unwanted contact.', 'yoursite')
    ),
    array(
        'question' => sprintf(__('What payment methods do you accept?', 'yoursite')),
        'answer' => sprintf(__('We accept all major credit cards (Visa, MasterCard, American Express), PayPal, bank transfers, and cryptocurrency. All transactions are processed securely and prices are shown in %s.', 'yoursite'), $current_currency['name'])
    ),
    array(
        'question' => __('Do you offer a money-back guarantee?', 'yoursite'),
        'answer' => __('Yes! We offer a 30-day money-back guarantee on all domain registrations. If you\'re not satisfied for any reason, we\'ll refund your registration fee. Note that domains cannot be returned after the 30-day period due to registry policies.', 'yoursite')
    )
);

?>

<!-- FAQ Section -->
<section class="faq-section py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php _e('Frequently Asked Questions', 'yoursite'); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php _e('Got questions about domain registration? We\'ve got answers. Find everything you need to know about registering and managing your domain.', 'yoursite'); ?>
            </p>
        </div>
        
        <!-- FAQ List -->
        <div class="max-w-4xl mx-auto">
            <ul class="faq-list space-y-4" role="list">
                <?php foreach ($faq_items as $index => $faq): ?>
                <li class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600" 
                    id="faq-item-<?php echo esc_attr($index); ?>">
                    
                    <button class="faq-toggle w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                            type="button" 
                            aria-expanded="false"
                            aria-controls="faq-content-<?php echo esc_attr($index); ?>"
                            id="faq-toggle-<?php echo esc_attr($index); ?>">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white pr-4">
                            <?php echo esc_html($faq['question']); ?>
                        </h3>
                        <svg class="faq-icon w-6 h-6 text-gray-500 dark:text-gray-400 transform transition-transform duration-200 flex-shrink-0" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-400 ease-in-out border-t-0 border-gray-200 dark:border-gray-700" 
                         id="faq-content-<?php echo esc_attr($index); ?>"
                         aria-labelledby="faq-toggle-<?php echo esc_attr($index); ?>"
                         role="region">
                        <div class="faq-content-inner px-6 pb-6 pt-2">
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                <?php echo wp_kses_post(nl2br($faq['answer'])); ?>
                            </p>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- Additional Help Section -->
        <div class="mt-20">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-12 shadow-xl border border-gray-200 dark:border-gray-700 max-w-4xl mx-auto text-center">
                <div class="mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php _e('Still Have Questions?', 'yoursite'); ?>
                    </h3>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                        <?php _e('Our domain experts are here to help you find the perfect solution for your business needs.', 'yoursite'); ?>
                    </p>
                </div>
                
                <!-- Contact Options -->
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-md">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white mb-2"><?php _e('Live Chat', 'yoursite'); ?></h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3"><?php _e('Get instant answers', 'yoursite'); ?></p>
                        <button class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200"
                                onclick="openLiveChat()">
                            <?php _e('Start Chat', 'yoursite'); ?>
                        </button>
                    </div>
                    
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-md">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 3.26a2 2 0 001.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white mb-2"><?php _e('Email Support', 'yoursite'); ?></h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3"><?php _e('Detailed assistance', 'yoursite'); ?></p>
                        <a href="mailto:support@yoursite.com" 
                           class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200">
                            <?php _e('Send Email', 'yoursite'); ?>
                        </a>
                    </div>
                    
                    <div class="text-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-md">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white mb-2"><?php _e('Phone Support', 'yoursite'); ?></h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3"><?php _e('Speak with an expert', 'yoursite'); ?></p>
                        <a href="tel:+1-800-DOMAINS" 
                           class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200">
                            <?php _e('Call Now', 'yoursite'); ?>
                        </a>
                    </div>
                </div>
                
                <!-- CTA Section -->
                <div class="text-center pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-xl font-semibold mb-4 text-blue-600 dark:text-blue-400">
                        <?php _e('Need more help?', 'yoursite'); ?>
                    </h4>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 max-w-2xl mx-auto">
                        <?php _e('Our team is here to help you every step of the way. Get in touch for personalized support.', 'yoursite'); ?>
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?php echo esc_url(home_url('/help')); ?>" 
                           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <?php _e('Browse Knowledge Base', 'yoursite'); ?>
                        </a>
                        
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" 
                           class="inline-flex items-center justify-center gap-2 bg-transparent border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 font-semibold px-8 py-3 rounded-lg hover:bg-blue-600 hover:text-white dark:hover:bg-blue-400 dark:hover:text-gray-900 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                            <?php _e('Contact Sales Team', 'yoursite'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ JavaScript - Inline for immediate functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 FAQ Section Loaded');
    
    // FAQ Toggle Functionality
    document.querySelectorAll('.faq-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const contentId = this.getAttribute('aria-controls');
            const content = document.getElementById(contentId);
            const icon = this.querySelector('.faq-icon');
            const expanded = this.getAttribute('aria-expanded') === 'true';
            
            // Close all other FAQ items
            document.querySelectorAll('.faq-toggle').forEach(otherToggle => {
                if (otherToggle !== this) {
                    const otherContentId = otherToggle.getAttribute('aria-controls');
                    const otherContent = document.getElementById(otherContentId);
                    const otherIcon = otherToggle.querySelector('.faq-icon');
                    
                    otherToggle.setAttribute('aria-expanded', 'false');
                    otherContent.style.maxHeight = '0';
                    otherIcon.style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle current FAQ item
            this.setAttribute('aria-expanded', !expanded);
            
            if (!expanded) {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
                
                // Scroll to FAQ item if it's not fully visible
                setTimeout(() => {
                    const rect = this.getBoundingClientRect();
                    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;
                    
                    if (!isVisible) {
                        this.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 300);
            } else {
                content.style.maxHeight = '0';
                icon.style.transform = 'rotate(0deg)';
            }
            
            // Track FAQ interactions
            if (typeof gtag !== 'undefined') {
                const questionText = this.querySelector('h3').textContent.trim();
                gtag('event', 'faq_toggle', {
                    'event_category': 'engagement',
                    'event_label': questionText,
                    'value': expanded ? 0 : 1
                });
            }
        });
    });
    
    // Live Chat Function
    window.openLiveChat = function() {
        // Integration with your live chat system
        if (typeof $crisp !== 'undefined') {
            $crisp.push(['do', 'chat:open']);
        } else if (typeof Intercom !== 'undefined') {
            Intercom('show');
        } else if (typeof Zendesk !== 'undefined') {
            Zendesk('webWidget', 'open');
        } else {
            // Fallback to contact form
            window.location.href = '<?php echo esc_url(home_url('/contact')); ?>';
        }
        
        // Track live chat opens
        if (typeof gtag !== 'undefined') {
            gtag('event', 'live_chat_open', {
                'event_category': 'engagement',
                'event_label': 'FAQ Section'
            });
        }
    };
    
    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);
    
    // Observe FAQ items for scroll animations
    document.querySelectorAll('.faq-item').forEach(el => {
        el.classList.add('scroll-reveal');
        observer.observe(el);
    });
});
</script>

<!-- FAQ Schema Markup for SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    <?php foreach ($faq_items as $index => $faq): ?>
    {
      "@type": "Question",
      "name": "<?php echo esc_js($faq['question']); ?>",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<?php echo esc_js($faq['answer']); ?>"
      }
    }<?php echo $index < count($faq_items) - 1 ? ',' : ''; ?>
    <?php endforeach; ?>
  ]
}
</script>

<!-- Additional CSS for enhanced animations -->
<style>
.scroll-reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out;
}

.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

.faq-item:nth-child(odd) .scroll-reveal.revealed {
    transition-delay: 0.1s;
}

.faq-item:nth-child(even) .scroll-reveal.revealed {
    transition-delay: 0.2s;
}

.faq-toggle:focus {
    outline: 2px solid #3B82F6;
    outline-offset: 2px;
}

.faq-content-inner {
    border-top: 1px solid #E5E7EB;
}

.dark .faq-content-inner {
    border-top-color: #374151;
}
</style>