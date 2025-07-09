<?php
/**
 * Payment Methods & Certifications Template Part
 */
?>

<?php if (get_theme_mod('show_payment_methods', true) || get_theme_mod('show_customer_support', true)) : ?>
<div class="border-t border-gray-800 pt-8 mb-8">
    <div class="flex flex-col md:flex-row items-center justify-center gap-8">
        <!-- Payment Methods -->
        <?php if (get_theme_mod('show_payment_methods', true)) : ?>
        <div class="flex items-center gap-4">
            <span class="text-gray-400 text-sm">Accepted payments:</span>
            <div class="flex gap-2 payment-methods">
                <!-- Visa -->
                <svg class="h-8 w-12 opacity-70 hover:opacity-100 transition-opacity" viewBox="0 0 48 32" fill="none">
                    <rect width="48" height="32" rx="4" fill="#1434CB"/>
                    <path d="M19.2 21.6H16.8L18.4 10.4H20.8L19.2 21.6Z" fill="white"/>
                    <path d="M27.2 10.6C26.72 10.4 25.92 10.2 24.96 10.2C22.56 10.2 20.88 11.4 20.88 13.2C20.88 14.5 22.08 15.2 23.04 15.6C24 16 24.32 16.3 24.32 16.7C24.32 17.3 23.6 17.6 22.96 17.6C21.92 17.6 21.36 17.4 20.56 17L20.24 16.8L19.92 19C20.56 19.3 21.6 19.5 22.72 19.5C25.28 19.5 26.88 18.3 26.88 16.4C26.88 15.3 26.24 14.5 24.8 13.8C23.92 13.4 23.44 13.1 23.44 12.6C23.44 12.2 23.92 11.8 24.8 11.8C25.52 11.8 26.08 11.9 26.48 12.1L26.72 12.2L27.04 10.1L27.2 10.6Z" fill="white"/>
                    <path d="M32.64 10.4H30.72C30.08 10.4 29.6 10.6 29.36 11.2L25.6 21.6H28.16L28.64 20H31.68L31.92 21.6H34.08L32.16 10.4H32.64ZM29.44 18C29.44 18 30.88 13.9 30.88 13.9L31.52 16.3C31.52 16.3 31.84 17.7 31.92 18H29.44Z" fill="white"/>
                    <path d="M14.4 10.4L12 17.3L11.76 16C11.28 14.6 9.76 13 8 12L10.08 21.6H12.64L16.96 10.4H14.4Z" fill="white"/>
                    <path d="M9.28 10.4H5.12L5.12 10.6C8.32 11.4 10.56 13.5 11.36 15.6L10.56 11.2C10.4 10.6 9.92 10.4 9.28 10.4Z" fill="#EC982D"/>
                </svg>
                <!-- Mastercard -->
                <svg class="h-8 w-12 opacity-70 hover:opacity-100 transition-opacity" viewBox="0 0 48 32" fill="none">
                    <rect width="48" height="32" rx="4" fill="#EB001B"/>
                    <circle cx="19" cy="16" r="8" fill="#FF5F00"/>
                    <circle cx="29" cy="16" r="8" fill="#F79E1B"/>
                </svg>
                <!-- Stripe -->
                <svg class="h-8 w-12 opacity-70 hover:opacity-100 transition-opacity" viewBox="0 0 48 32" fill="none">
                    <rect width="48" height="32" rx="4" fill="#635BFF"/>
                    <path d="M14 12C14 10.8954 14.8954 10 16 10H20V14H16C14.8954 14 14 13.1046 14 12Z" fill="white"/>
                    <path d="M20 18H16C14.8954 18 14 19.1046 14 20C14 21.1046 14.8954 22 16 22H20V18Z" fill="white"/>
                    <rect x="20" y="10" width="14" height="12" fill="white"/>
                </svg>
                <!-- PayPal -->
                <svg class="h-8 w-12 opacity-70 hover:opacity-100 transition-opacity" viewBox="0 0 48 32" fill="none">
                    <rect width="48" height="32" rx="4" fill="#108043"/>
                    <path d="M20 10L16 22H20L24 10H20Z" fill="white"/>
                    <path d="M28 10L24 22H28L32 10H28Z" fill="white"/>
                </svg>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Customer Support -->
        <?php if (get_theme_mod('show_customer_support', true)) : ?>
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span class="text-gray-400 text-sm"><?php echo esc_html(get_theme_mod('support_hours', '24/7')); ?> Customer Support</span>
            <span class="text-gray-500">•</span>
            <a href="<?php echo esc_url(get_theme_mod('support_link_url', '/contact')); ?>" class="text-blue-400 hover:text-blue-300 text-sm font-medium"><?php echo esc_html(get_theme_mod('support_link_text', __('Get Help Now', 'yoursite'))); ?></a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>