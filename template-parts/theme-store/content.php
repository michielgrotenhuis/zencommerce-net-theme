<?php
/**
 * Theme Store Content Section
 * template-parts/theme-store/content.php
 */

if (get_the_content()): ?>

<section style="padding: 5rem 0; background: var(--zc-bg-secondary, #f9f9f9);">
    <div class="layout-container">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="text-align: center; font-size: 2.5rem; font-weight: 700; margin-bottom: 3rem; color: var(--zc-text-primary, #1c1c1c);">
                About This Theme
            </h2>
            <div style="font-size: 1.125rem; line-height: 1.7; color: var(--zc-text-primary, #1c1c1c);">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>