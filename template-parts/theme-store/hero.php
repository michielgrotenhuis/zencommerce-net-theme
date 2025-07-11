<?php
/**
 * Theme Store Hero Section
 * template-parts/theme-store/hero.php
 */

$theme_data = $args['theme_data'] ?? array();
?>

<section class="theme-hero">
    <div class="layout-container">
        <div class="theme-hero-content">
            <!-- Left: Theme Info -->
            <div class="theme-info">
                <h1 class="theme-title"><?php the_title(); ?></h1>
                
                <?php if (get_the_excerpt()) : ?>
                <p class="theme-subtitle"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
                
                <!-- Price and Meta -->
                <div class="theme-meta">
                    <div class="theme-price-display">
                        <?php if ($theme_data['price'] && $theme_data['price'] > 0): ?>
                            <span class="theme-price">$<?php echo number_format($theme_data['price'], 0); ?></span>
                        <?php else: ?>
                            <span class="theme-price free">Free</span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($theme_data['developer']): ?>
                    <div class="theme-meta-item">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        <span>by <?php echo esc_html($theme_data['developer']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($theme_data['rating']): ?>
                    <div class="theme-meta-item">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span><?php echo $theme_data['rating']; ?>/5 rating</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($theme_data['version']): ?>
                    <div class="theme-meta-item">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>v<?php echo esc_html($theme_data['version']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Action Buttons -->
                <div class="theme-actions">
                    <?php if ($theme_data['demo_url']): ?>
                        <a href="<?php echo esc_url($theme_data['demo_url']); ?>" target="_blank" class="flexbutton btn btn-primary">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Try for Free
                        </a>
                        <a href="<?php echo esc_url($theme_data['demo_url']); ?>" target="_blank" class="flexbutton btn btn-secondary">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Live Demo
                        </a>
                    <?php else: ?>
                        <a href="#" class="btn btn-primary">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Try for Free
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- Trust Signals -->
                <div class="theme-trust-signals">
                    <div class="trust-signal">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>30-day money back</span>
                    </div>
                    
                    <?php if ($theme_data['price'] && $theme_data['price'] > 0): ?>
                    <div class="trust-signal">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span>Unlimited free trial</span>
                    </div>
                    <?php else: ?>
                    <div class="trust-signal">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span>Always free</span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="trust-signal">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                        <span>Lifetime updates</span>
                    </div>
                </div>
            </div>

            <!-- Right: Preview -->
            <div class="theme-preview">
                <?php get_template_part('template-parts/theme-store/preview', null, array('theme_data' => $theme_data)); ?>
            </div>
        </div>
    </div>
</section>