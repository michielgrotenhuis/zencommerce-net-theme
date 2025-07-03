<?php
/**
 * Template part for homepage - Testimonials, Stats, FAQ & Final CTA sections
 * Part 3 of 3 - Fully Dynamic Version - SYNTAX FIXED
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<!-- Testimonials - Social Proof -->
<?php if (get_theme_mod('testimonials_enable', true)) : ?>
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('testimonials_title', __('Loved by 50,000+ Merchants Worldwide', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('testimonials_subtitle', __('See why businesses choose us to power their online success', 'yoursite'))); ?>
                </p>
            </div>
            
            <!-- Testimonials Grid -->
            <?php
            $testimonials_count = get_theme_mod('testimonials_count', 3);
            
            // Try to get testimonials from custom post type first
            if (function_exists('get_testimonials')) {
                $testimonials = get_testimonials($testimonials_count);
            } else {
                $testimonials = false;
            }
            
            if ($testimonials && $testimonials->have_posts()) :
            ?>
            <div class="grid md:grid-cols-<?php echo min($testimonials_count, 3); ?> gap-8">
                <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <!-- Rating -->
                    <div class="flex text-yellow-400 mb-6">
                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    
                    <!-- Testimonial Content -->
                    <blockquote class="text-gray-700 dark:text-gray-300 mb-6 text-lg leading-relaxed">
                        "<?php the_content(); ?>"
                    </blockquote>
                    
                    <!-- Author -->
                    <div class="flex items-center">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="mr-4">
                                <?php the_post_thumbnail('thumbnail', array('class' => 'w-14 h-14 rounded-full object-cover')); ?>
                            </div>
                        <?php else : ?>
                            <div class="w-14 h-14 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg"><?php echo substr(get_the_title(), 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white"><?php the_title(); ?></div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm"><?php the_excerpt(); ?></div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php 
            wp_reset_postdata();
            else : 
            ?>
            <!-- Fallback testimonials from customizer -->
            <div class="grid md:grid-cols-<?php echo min($testimonials_count, 3); ?> gap-8">
                <?php 
                for ($i = 1; $i <= $testimonials_count; $i++) {
                    $content = get_theme_mod("testimonial_{$i}_content", '');
                    $name = get_theme_mod("testimonial_{$i}_name", '');
                    $title = get_theme_mod("testimonial_{$i}_title", '');
                    
                    // Skip if no content
                    if (empty($content)) continue;
                ?>
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="flex text-yellow-400 mb-6">
                        <?php for ($j = 0; $j < 5; $j++) : ?>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <blockquote class="text-gray-700 dark:text-gray-300 mb-6 text-lg leading-relaxed">
                        "<?php echo esc_html($content); ?>"
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg"><?php echo !empty($name) ? substr($name, 0, 1) : 'T'; ?></span>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white"><?php echo esc_html($name); ?></div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm"><?php echo esc_html($title); ?></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Stats/Numbers Section -->
<?php if (get_theme_mod('stats_enable', true)) : ?>
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo esc_html(get_theme_mod('stats_title', __('Trusted by Growing Businesses', 'yoursite'))); ?>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-12">
                <?php echo esc_html(get_theme_mod('stats_subtitle', __('Join thousands of successful merchants who chose us', 'yoursite'))); ?>
            </p>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                for ($i = 1; $i <= 4; $i++) {
                    $number = get_theme_mod("stat_{$i}_number", '');
                    $label = get_theme_mod("stat_{$i}_label", '');
                    $icon = get_theme_mod("stat_{$i}_icon", '');
                    
                    // Default icons if none specified
                    $default_icons = array(
                        1 => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a1 1 0 00-1-1H9a1 1 0 00-1 1v9m5 0H9m6-12v4m-8-4v4',
                        2 => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        3 => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        4 => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                    );
                    
                    if (empty($icon) && isset($default_icons[$i])) {
                        $icon = $default_icons[$i];
                    }
                    
                    // Skip if no number or label
                    if (empty($number) || empty($label)) continue;
                ?>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <?php if (!empty($icon)) : ?>
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($icon); ?>"></path>
                        </svg>
                        <?php else : ?>
                        <!-- Fallback icon -->
                        <div class="w-8 h-8 bg-white rounded"></div>
                        <?php endif; ?>
                    </div>
                    <div class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 stat-number">
                        <?php echo esc_html($number); ?>
                    </div>
                    <div class="text-gray-600 dark:text-gray-300 font-medium">
                        <?php echo esc_html($label); ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- FAQ Section - FIXED VERSION -->
<?php if (get_theme_mod('faq_enable', true)) : ?>
<section class="faq-section py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo esc_html(get_theme_mod('faq_title', __('Frequently Asked Questions', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    <?php echo esc_html(get_theme_mod('faq_subtitle', __('Everything you need to know to get started', 'yoursite'))); ?>
                </p>
            </div>
            
            <ul class="faq-list space-y-4" role="list">
                <?php 
                for ($i = 1; $i <= 8; $i++) { // Increased to 8 for more FAQs
                    $question = get_theme_mod("faq_{$i}_question", '');
                    $answer = get_theme_mod("faq_{$i}_answer", '');
                    
                    if (!empty(trim($question)) && !empty(trim($answer))) :
                        $faq_id = "faq-item-{$i}";
                        $content_id = "faq-content-{$i}";
                        $toggle_id = "faq-toggle-{$i}";
                ?>
                    <li class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600" id="<?php echo esc_attr($faq_id); ?>">
                  <button 
    class="faq-toggle" 
    type="button" 
    aria-expanded="false"
    aria-controls="<?php echo esc_attr($content_id); ?>"
>
    <h3><?php echo esc_html($question); ?></h3>
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <?php echo wp_kses_post(nl2br($answer)); ?>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php 
                    endif;
                }
                ?>
            </ul>
            
            <!-- FAQ CTA Section -->
            <div class="text-center mt-16 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold mb-4 text-blue-600 dark:text-blue-400">
                    <?php echo esc_html(get_theme_mod('faq_cta_title', __('Still have questions?', 'yoursite'))); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6 max-w-2xl mx-auto">
                    <?php echo esc_html(get_theme_mod('faq_cta_description', __('Our team is here to help you every step of the way. Get in touch for personalized support.', 'yoursite'))); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo esc_url(get_theme_mod('faq_cta_primary_url', '/contact')); ?>" 
                       class="faq-cta-button inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('faq_cta_primary_text', __('Contact Support', 'yoursite'))); ?>
                    </a>
                    
                    <a href="<?php echo esc_url(get_theme_mod('faq_cta_secondary_url', '/help')); ?>" 
                       class="inline-flex items-center justify-center gap-2 bg-transparent border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <?php echo esc_html(get_theme_mod('faq_cta_secondary_text', __('Help Center', 'yoursite'))); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ JavaScript - Inline for immediate functionality -->
<script>
function initializeFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(function(item) {
        const toggle = item.querySelector('.faq-toggle');
        const content = item.querySelector('.faq-content');
        
        if (toggle && content) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Toggle active class
                const isActive = toggle.classList.contains('active');
                
                // Close all other FAQs
                document.querySelectorAll('.faq-toggle').forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-expanded', 'false');
                });
                document.querySelectorAll('.faq-content').forEach(c => {
                    c.classList.remove('active');
                });
                
                // Toggle current FAQ
                if (!isActive) {
                    toggle.classList.add('active');
                    toggle.setAttribute('aria-expanded', 'true');
                    content.classList.add('active');
                } else {
                    toggle.classList.remove('active');
                    toggle.setAttribute('aria-expanded', 'false');
                    content.classList.remove('active');
                }
            });
        }
    });
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', function() {
    initializeFAQ();
});

</script>

<style>
/* FAQ Section Additional Styles */
.faq-section .faq-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.faq-item {
    transition: all 0.3s ease;
}

.faq-item:hover {
    transform: translateY(-1px);
}

.faq-toggle:focus {
    outline: none;
}

.faq-toggle h3 {
    margin: 0;
    font-size: 1.125rem;
    line-height: 1.4;
}

.faq-content {
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                border-top-width 0.3s ease;
}

.faq-content-inner {
    padding-top: 0.5rem;
}

.faq-toggle-icon {
    transition: transform 0.3s ease, color 0.3s ease;
}

.faq-cta-button:focus {
    outline: none;
    ring: 3px solid rgba(59, 130, 246, 0.5);
    ring-offset: 2px;
}

/* Dark mode adjustments */
.dark .faq-item.faq-active {
    border-color: rgb(59 130 246);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(59, 130, 246, 0.2);
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .faq-toggle {
        padding: 1rem 1.25rem !important;
    }
    
    .faq-toggle h3 {
        font-size: 1rem;
        padding-right: 0.75rem;
    }
    
    .faq-content-inner {
        padding: 0.5rem 1.25rem 1.25rem 1.25rem;
    }
    
    .faq-toggle-icon {
        width: 1.25rem;
        height: 1.25rem;
    }
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
    .faq-item,
    .faq-content,
    .faq-toggle-icon,
    .faq-cta-button {
        transition: none !important;
    }
    
    .faq-item:hover {
        transform: none !important;
    }
}

/* Print styles */
@media print {
    .faq-content {
        max-height: none !important;
        overflow: visible !important;
    }
    
    .faq-toggle-icon {
        display: none;
    }
    
    .faq-cta-button {
        display: none;
    }
}
</style>
<?php endif; ?>

<!-- Video Modal -->
<div id="video-modal" class="fixed inset-0 z-50 hidden" style="z-index: 9999;">
    <div class="absolute inset-0 bg-black bg-opacity-90 backdrop-blur-sm"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative max-w-6xl w-full">
            <button id="close-video-modal" class="absolute -top-16 right-0 text-white hover:text-gray-300 transition-colors z-50 p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="bg-black rounded-xl shadow-2xl overflow-hidden" style="padding-top: 56.25%; position: relative;">
                <iframe id="video-iframe" 
                        class="absolute top-0 left-0 w-full h-full" 
                        src="" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<div id="video-modal" class="fixed inset-0 z-50 hidden" style="z-index: 9999;">
    <div class="absolute inset-0 bg-black bg-opacity-90 backdrop-blur-sm"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative max-w-6xl w-full">
            <button id="close-video-modal" class="absolute -top-16 right-0 text-white hover:text-gray-300 transition-colors z-50 p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="bg-black rounded-xl shadow-2xl overflow-hidden" style="padding-top: 56.25%; position: relative;">
                <iframe id="video-iframe" 
                        class="absolute top-0 left-0 w-full h-full" 
                        src="" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Homepage Part 3 Loaded');
    
    // ===== PRICING TOGGLE FUNCTIONALITY =====
    const monthlyBtn = document.querySelector('.monthly-btn');
    const annualBtn = document.querySelector('.annual-btn');
    const monthlyPricing = document.querySelectorAll('.monthly-pricing');
    const annualPricing = document.querySelectorAll('.annual-pricing');
    
    if (monthlyBtn && annualBtn) {
        // Set initial state (annual active)
        setActiveToggle('annual');
        
        monthlyBtn.addEventListener('click', () => setActiveToggle('monthly'));
        annualBtn.addEventListener('click', () => setActiveToggle('annual'));
        
        function setActiveToggle(type) {
            // Update button states
            monthlyBtn.classList.toggle('active', type === 'monthly');
            annualBtn.classList.toggle('active', type === 'annual');
            
            // Update pricing display
            monthlyPricing.forEach(el => {
                el.style.display = type === 'monthly' ? 'block' : 'none';
            });
            annualPricing.forEach(el => {
                el.style.display = type === 'annual' ? 'block' : 'none';
            });
            
            // Add animation
            document.querySelectorAll('.pricing-card').forEach((card, index) => {
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.style.transform = '';
                }, index * 50);
            });
        }
    }
    
    // ===== FAQ FUNCTIONALITY =====
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    if (faqToggles.length > 0) {
        faqToggles.forEach((toggle, index) => {
            const content = toggle.nextElementSibling;
            
            // Set initial state
            if (content && content.classList.contains('faq-content')) {
                content.style.maxHeight = '0px';
                content.style.paddingBottom = '0px';
                content.style.overflow = 'hidden';
                content.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            }
            
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                const content = this.nextElementSibling;
                const icon = this.querySelector('svg');
                const isCurrentlyOpen = content.classList.contains('faq-open');
                
                // Close all other FAQs first
                faqToggles.forEach((otherToggle, otherIndex) => {
                    if (otherIndex !== index) {
                        const otherContent = otherToggle.nextElementSibling;
                        const otherIcon = otherToggle.querySelector('svg');
                        
                        // Close other FAQ
                        otherToggle.classList.remove('faq-active');
                        otherToggle.setAttribute('aria-expanded', 'false');
                        if (otherContent) {
                            otherContent.classList.remove('faq-open');
                            otherContent.style.maxHeight = '0px';
                            otherContent.style.paddingBottom = '0px';
                        }
                        
                        if (otherIcon) {
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
                    }
                });
                
                // Toggle current FAQ
                if (isCurrentlyOpen) {
                    // Close current FAQ
                    this.classList.remove('faq-active');
                    this.setAttribute('aria-expanded', 'false');
                    content.classList.remove('faq-open');
                    content.style.maxHeight = '0px';
                    content.style.paddingBottom = '0px';
                    
                    if (icon) {
                        icon.style.transform = 'rotate(0deg)';
                    }
                } else {
                    // Open current FAQ
                    this.classList.add('faq-active');
                    this.setAttribute('aria-expanded', 'true');
                    content.classList.add('faq-open');
                    
                    // Calculate and set the height
                    const contentHeight = content.scrollHeight + 24; // Add padding
                    content.style.maxHeight = contentHeight + 'px';
                    content.style.paddingBottom = '1.5rem';
                    
                    if (icon) {
                        icon.style.transform = 'rotate(180deg)';
                    }
                }
            });
        });
        
        console.log(`✅ FAQ initialized with ${faqToggles.length} items`);
    }
    
    // ===== VIDEO MODAL FUNCTIONALITY =====
    const videoModal = document.getElementById('video-modal');
    const videoIframe = document.getElementById('video-iframe');
    const closeButton = document.getElementById('close-video-modal');
    const videoThumbnails = document.querySelectorAll('.video-thumbnail');
    
    videoThumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function(e) {
            e.preventDefault();
            const videoUrl = this.getAttribute('data-video-url');
            if (videoUrl) openVideoModal(videoUrl);
        });
    });
    
    if (closeButton) {
        closeButton.addEventListener('click', closeVideoModal);
    }
    
    if (videoModal) {
        videoModal.addEventListener('click', function(e) {
            if (e.target === this || e.target.classList.contains('bg-black')) {
                closeVideoModal();
            }
        });
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal && !videoModal.classList.contains('hidden')) {
            closeVideoModal();
        }
    });
    
    function openVideoModal(videoUrl) {
        const embedUrl = convertToEmbedUrl(videoUrl);
        if (!embedUrl || !videoModal || !videoIframe) return;
        
        videoModal.classList.add('loading');
        videoIframe.src = embedUrl;
        videoModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        videoIframe.onload = () => {
            videoModal.classList.remove('loading');
        };
        
        setTimeout(() => closeButton?.focus(), 100);
    }
    
    function closeVideoModal() {
        if (!videoModal || videoModal.classList.contains('hidden')) return;
        
        videoModal.classList.add('hidden');
        videoModal.classList.remove('loading');
        if (videoIframe) videoIframe.src = '';
        document.body.style.overflow = '';
    }
    
    function convertToEmbedUrl(url) {
        if (!url) return null;
        
        let videoId = null;
        
        if (url.includes('youtube.com/watch?v=')) {
            videoId = url.split('v=')[1].split('&')[0];
        } else if (url.includes('youtu.be/')) {
            videoId = url.split('youtu.be/')[1].split('?')[0];
        } else if (url.includes('youtube.com/embed/')) {
            videoId = url.split('embed/')[1].split('?')[0];
        }
        
        return videoId ? `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1` : null;
    }
    
    // ===== SCROLL ANIMATIONS =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                
                // Animate stats numbers
                if (entry.target.classList.contains('stat-number')) {
                    animateNumber(entry.target);
                }
            }
        });
    }, observerOptions);
    
    // Observe elements for scroll animations
    document.querySelectorAll('.feature-card, .pricing-card, .testimonial-card, .stat-number').forEach(el => {
        el.classList.add('scroll-reveal');
        observer.observe(el);
    });
    
    // ===== STATS COUNTER ANIMATION =====
    function animateNumber(element) {
        const text = element.textContent;
        const number = parseInt(text.replace(/\D/g, ''));
        if (isNaN(number)) return;
        
        const suffix = text.replace(/[\d,]/g, '');
        const duration = 2000;
        const steps = 60;
        const increment = number / steps;
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= number) {
                current = number;
                clearInterval(timer);
            }
            
            const formatted = Math.floor(current).toLocaleString();
            element.textContent = formatted + suffix;
        }, duration / steps);
    }
    
    // ===== ENHANCED BUTTON INTERACTIONS =====
    // Add loading states to CTA buttons
    document.querySelectorAll('a[href*="signup"], a[href*="trial"]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.href.includes('#signup') || this.href.includes('#trial')) {
                e.preventDefault();
                
                this.classList.add('btn-loading');
                
                // Simulate loading for demo purposes
                setTimeout(() => {
                    this.classList.remove('btn-loading');
                    // In real implementation, redirect to signup
                    window.location.href = '/signup';
                }, 1500);
            }
        });
    });
    
    // ===== CONVERSION TRACKING =====
    // Track CTA button clicks
    document.querySelectorAll('.btn-primary, .cta-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Track conversion event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'cta_click', {
                    'event_category': 'conversion',
                    'event_label': this.textContent.trim(),
                    'button_location': getButtonLocation(this)
                });
            }
            
            console.log('🎯 CTA Clicked:', this.textContent.trim());
        });
    });
    
    // Track scroll depth
    let maxScroll = 0;
    window.addEventListener('scroll', throttle(() => {
        const scrollPercent = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
        
        if (scrollPercent > maxScroll && scrollPercent % 25 === 0) {
            maxScroll = scrollPercent;
            
            if (typeof gtag !== 'undefined') {
                gtag('event', 'scroll_depth', {
                    'event_category': 'engagement',
                    'event_label': scrollPercent + '%'
                });
            }
            
            console.log('📊 Scroll Depth:', scrollPercent + '%');
        }
    }, 250));
    
    function getButtonLocation(button) {
        const section = button.closest('section');
        if (section) {
            if (section.classList.contains('hero-gradient')) return 'hero';
            if (section.classList.contains('final-cta-section')) return 'final_cta';
            if (section.querySelector('h2')) {
                return section.querySelector('h2').textContent.toLowerCase().replace(/\s+/g, '_');
            }
        }
        return 'unknown';
    }
    
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
});
</script>