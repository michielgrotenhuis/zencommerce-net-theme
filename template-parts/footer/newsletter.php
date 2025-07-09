<?php
/**
 * Newsletter Section Template Part
 */
?>

<?php if (get_theme_mod('show_footer_newsletter', true)) : ?>
<div class="border-t border-gray-800 pt-8 mb-8">
    <div class="max-w-2xl mx-auto text-center">
        <h3 class="text-xl font-semibold text-white mb-3"><?php echo esc_html(get_theme_mod('newsletter_title', __('Stay in the Loop', 'yoursite'))); ?></h3>
        <p class="text-gray-400 mb-6"><?php echo esc_html(get_theme_mod('newsletter_description', __('Get the latest updates, tips, and exclusive offers delivered to your inbox.', 'yoursite'))); ?></p>
        
        <form class="newsletter-form flex flex-col sm:flex-row gap-3 max-w-md mx-auto" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
            <input type="hidden" name="action" value="newsletter_signup">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
            <input 
                type="email" 
                name="email"
                placeholder="Enter your email" 
                required
                class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
            <button 
                type="submit" 
                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 whitespace-nowrap"
            >
                Subscribe
            </button>
        </form>
        <p class="text-xs text-gray-500 mt-3">
            By subscribing, you agree to our <a href="/privacy" class="underline hover:text-gray-400">Privacy Policy</a>
        </p>
    </div>
</div>
<?php endif; ?>