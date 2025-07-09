<?php
/**
 * Language and Currency Selector Template Part
 */
?>

<?php if (get_theme_mod('show_language_selector', true) || get_theme_mod('show_currency_selector', true)) : ?>
<div class="flex items-center gap-3">
    <!-- Language Selector -->
    <?php if (get_theme_mod('show_language_selector', true)) : ?>
    <div class="fancy-selector-wrapper">
        <button class="fancy-selector" id="language-toggle" type="button" aria-expanded="false">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
            </svg>
            <span class="selector-text"><?php echo esc_html(get_theme_mod('default_language', 'EN')); ?></span>
            <svg class="w-4 h-4 text-gray-400 chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="fancy-dropdown hidden" id="language-dropdown" role="listbox" aria-hidden="true">
            <a href="#" data-lang="en" data-code="EN" class="dropdown-item active" role="option">
                <span class="flag">🇺🇸</span> English
            </a>
            <a href="#" data-lang="es" data-code="ES" class="dropdown-item" role="option">
                <span class="flag">🇪🇸</span> Español
            </a>
            <a href="#" data-lang="fr" data-code="FR" class="dropdown-item" role="option">
                <span class="flag">🇫🇷</span> Français
            </a>
            <a href="#" data-lang="de" data-code="DE" class="dropdown-item" role="option">
                <span class="flag">🇩🇪</span> Deutsch
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Currency Selector -->
    <?php if (get_theme_mod('show_currency_selector', true)) : ?>
        <?php echo yoursite_render_currency_selector(array(
            'style' => 'dropdown', 
            'show_flag' => true,
            'show_name' => false,
            'show_symbol' => false,
            'wrapper_class' => 'fancy-selector-wrapper',
            'toggle_class' => 'fancy-selector',
            'dropdown_class' => 'fancy-dropdown',
            'item_class' => 'dropdown-item',
            'active_class' => 'active'
        )); ?>
    <?php endif; ?>
</div>
<?php endif; ?>