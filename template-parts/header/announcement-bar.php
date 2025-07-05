<?php if (get_theme_mod('show_announcement_bar', true)) : ?>
<div class="announcement-bar text-white py-3 px-4 text-center relative z-40">
    <div class="container mx-auto flex items-center justify-center relative z-10">
        <div class="flex items-center gap-3 flex-wrap justify-center">
            <span class="text-xl">🚀</span>
            <span class="font-medium text-sm sm:text-base">
                <?php echo esc_html(get_theme_mod('announcement_text', 'Limited Time: Get 50% OFF on all annual plans! Use code SAVE50')); ?>
            </span>
            <a href="<?php echo esc_url(get_theme_mod('announcement_link', '/pricing')); ?>" 
               class="ml-2 bg-white/20 hover:bg-white/30 text-white px-4 py-1.5 rounded-full font-semibold text-sm transition-all transform hover:scale-105 backdrop-blur-sm">
                <?php echo esc_html(get_theme_mod('announcement_cta', 'Claim Now')); ?> →
            </a>
        </div>
    </div>
    <button class="announcement-close absolute right-4 top-1/2 transform -translate-y-1/2 text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10" 
            aria-label="Close announcement">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
<?php endif; ?>