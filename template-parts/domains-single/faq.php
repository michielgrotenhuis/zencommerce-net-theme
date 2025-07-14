<?php
/**
 * Domain Landing Page - FAQ Section (Updated)
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Extract data from args
$domain_ext = $args['domain_ext'] ?? 'store';
$domain_faq = $args['domain_faq'] ?? array();
$domain_price = $args['domain_price'] ?? '12.99';

// If no custom FAQ, provide defaults
if (empty($domain_faq)) {
    $domain_faq = array(
        array(
            'question' => sprintf(__('What is a .%s domain?', 'yoursite'), $domain_ext),
            'answer' => sprintf(__('A .%s domain is a top-level domain (TLD) that\'s perfect for businesses, especially those with an online presence. It\'s a modern, memorable alternative to traditional domains like .com.', 'yoursite'), $domain_ext)
        ),
        array(
            'question' => sprintf(__('Why should I choose a .%s domain?', 'yoursite'), $domain_ext),
            'answer' => sprintf(__('.%s domains are more readily available than .com domains, making it easier to get the exact domain name you want. They also clearly communicate your business focus and are trusted by search engines.', 'yoursite'), $domain_ext)
        ),
        array(
            'question' => sprintf(__('How much does a .%s domain cost?', 'yoursite'), $domain_ext),
            'answer' => sprintf(__('Our .%s domains start at just $%s per year, with transparent pricing and no hidden fees. You\'ll also get free WHOIS privacy protection and DNS management included.', 'yoursite'), $domain_ext, $domain_price)
        )
    );
}


// Only show section if we have FAQ items
if (empty($domain_faq)) {
    return;
}
?>

<!-- FAQ Section -->
<section class="faq-section py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php printf(__('Frequently Asked Questions about .%s domains', 'yoursite'), esc_html($domain_ext)); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php _e('Got questions? We\'ve got answers.', 'yoursite'); ?>
                </p>
            </div>
            
            <!-- FAQ Items -->
            <ul class="faq-list space-y-4" role="list">
    <?php foreach ($domain_faq as $index => $faq_item) : ?>
        <?php 
        if (!empty($faq_item['question']) && !empty($faq_item['answer'])) : 
            $faq_id = "faq-item-{$index}";
            $content_id = "faq-content-{$index}";
            $toggle_id = "faq-toggle-{$index}";
        ?>
        <li class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600" id="<?php echo esc_attr($faq_id); ?>">
            <button 
                class="faq-toggle w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                type="button" 
                aria-expanded="false"
                aria-controls="<?php echo esc_attr($content_id); ?>"
                id="<?php echo esc_attr($toggle_id); ?>"
            >
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white pr-4">
                    <?php echo esc_html($faq_item['question']); ?>
                </h3>
                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400 transform transition-transform duration-200 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div 
                class="faq-content max-h-0 overflow-hidden transition-all duration-400 ease-in-out border-t-0 border-gray-200 dark:border-gray-700" 
                id="<?php echo esc_attr($content_id); ?>"
                aria-labelledby="<?php echo esc_attr($toggle_id); ?>"
                role="region"
            >
                <div class="faq-content-inner px-6 pb-5 pt-2">
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo wp_kses_post(wpautop($faq_item['answer'])); ?>
                    </p>
                </div>
            </div>
        </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

            
            <!-- Contact CTA -->
            <div class="text-center mt-16">
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-8 border border-blue-200 dark:border-blue-800">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php _e('Still have questions?', 'yoursite'); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        <?php _e('Our domain experts are here to help you find the perfect domain for your business.', 'yoursite'); ?>
                    </p>
                    <a 
                        href="<?php echo esc_url(home_url('/contact')); ?>" 
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200"
                    >
                        <?php _e('Contact Support', 'yoursite'); ?>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ JavaScript - Inline for immediate functionality -->
<script>
document.querySelectorAll('.faq-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const contentId = toggle.getAttribute('aria-controls');
        const content = document.getElementById(contentId);
        const expanded = toggle.getAttribute('aria-expanded') === 'true';

        toggle.setAttribute('aria-expanded', !expanded);
        toggle.querySelector('.faq-icon')?.classList.toggle('rotate-180');

        if (!expanded) {
            content.style.maxHeight = content.scrollHeight + 'px';
        } else {
            content.style.maxHeight = '0';
        }
    });
});

</script>