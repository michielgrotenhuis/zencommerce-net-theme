<?php
/**
 * Theme Store Related Themes Section
 * template-parts/theme-store/related.php
 */

$theme_id = $args['theme_id'] ?? 0;
$categories = $args['categories'] ?? array();

$current_category = null;
if ($categories && !is_wp_error($categories) && !empty($categories)) {
    $current_category = $categories[0];
}

if ($current_category) {
    $related_themes = new WP_Query(array(
        'post_type' => 'zencommerce_theme',
        'posts_per_page' => 6,
        'post__not_in' => array($theme_id),
        'tax_query' => array(
            array(
                'taxonomy' => 'theme_category',
                'field'    => 'term_id',
                'terms'    => $current_category->term_id,
            )
        ),
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_theme_price',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => '_theme_price',
                'compare' => 'NOT EXISTS'
            )
        )
    ));
    
    if ($related_themes->have_posts()) {
?>

<section style="padding: 5rem 0; background: var(--zc-bg-secondary, #f9f9f9);">
    <div class="layout-container">
        <div class="text-center mb-16">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: var(--zc-text-primary, #1c1c1c); margin-bottom: 1rem;">
                More <?php echo esc_html($current_category->name); ?> Themes
            </h2>
            <p style="font-size: 1.25rem; color: var(--zc-text-secondary, #5f5f5f);">
                Discover other professional themes in the <?php echo esc_html($current_category->name); ?> category
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            <?php 
            while ($related_themes->have_posts()) {
                $related_themes->the_post(); 
                $related_id = get_the_ID();
                $related_price = get_post_meta($related_id, '_theme_price', true);
                $related_developer = get_post_meta($related_id, '_theme_developer', true);
                $related_rating = get_post_meta($related_id, '_theme_rating', true);
                $related_demo_url = get_post_meta($related_id, '_theme_demo_url', true);
            ?>
                <div style="background: white; border-radius: var(--zc-radius-lg, 12px); overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: 1px solid var(--zc-border, #f1f1f1); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative;">
                    <!-- Theme Preview -->
                    <div style="position: relative; aspect-ratio: 16/10; overflow: hidden; background: var(--zc-bg-secondary, #f9f9f9);">
                        <?php if (has_post_thumbnail()) { ?>
                            <a href="<?php the_permalink(); ?>" style="display: block; height: 100%;">
                                <?php the_post_thumbnail('large', array(
                                    'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;',
                                    'alt' => get_the_title() . ' Theme Preview'
                                )); ?>
                            </a>
                        <?php } else { ?>
                            <a href="<?php the_permalink(); ?>" style="display: block; height: 100%;">
                                <div style="background: linear-gradient(135deg, #ddd6fe, #e9d5ff); height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <div style="text-align: center; color: #6b7280;">
                                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎨</div>
                                        <p style="margin: 0; font-size: 14px;">Theme Preview</p>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                        
                        <!-- Price Badge -->
                        <div style="position: absolute; top: 1rem; right: 1rem;">
                            <?php if ($related_price && $related_price > 0) { ?>
                                <span style="background: var(--zc-secondary, #126fb7); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; font-size: 0.875rem; box-shadow: 0 2px 8px rgba(18, 111, 183, 0.3);">
                                    $<?php echo number_format($related_price, 0); ?>
                                </span>
                            <?php } else { ?>
                                <span style="background: var(--zc-success, #16a34a); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; font-size: 0.875rem; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.3);">
                                    Free
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- Theme Info -->
                    <div style="padding: 1.5rem;">
                        <h3 style="margin: 0 0 0.75rem 0; font-size: 1.25rem; font-weight: 700; line-height: 1.3;">
                            <a href="<?php the_permalink(); ?>" style="color: var(--zc-text-primary, #1c1c1c); text-decoration: none; transition: color 0.2s;">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <p style="color: var(--zc-text-secondary, #5f5f5f); font-size: 0.875rem; margin: 0 0 1rem 0; line-height: 1.5;">
                            <?php 
                            $excerpt = get_the_excerpt();
                            if (!$excerpt) {
                                $excerpt = 'Professional WordPress theme ready for your business.';
                            }
                            echo wp_trim_words($excerpt, 12, '...');
                            ?>
                        </p>
                        
                        <!-- Meta Info -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.8125rem; color: var(--zc-text-secondary, #5f5f5f);">
                            <div>
                                <?php if ($related_developer) { ?>
                                    <span>by <strong style="color: var(--zc-text-primary, #1c1c1c);"><?php echo esc_html($related_developer); ?></strong></span>
                                <?php } ?>
                            </div>
                            <div>
                                <?php if ($related_rating) { ?>
                                    <span style="display: flex; align-items: center; gap: 0.25rem;">
                                        <span style="color: #fbbf24;">⭐</span>
                                        <span><?php echo $related_rating; ?>/5</span>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 0.75rem;">
                            <a class="text-white" href="<?php the_permalink(); ?>" 
                               style="flex: 1; text-align: center; padding: 0.875rem 1rem; background: var(--zc-secondary, #126fb7); color: white; text-decoration: none; border-radius: var(--zc-radius-sm, 8px); font-weight: 600; font-size: 0.875rem; transition: all 0.3s ease; border: 2px solid var(--zc-secondary, #126fb7);">
                                View Details
                            </a>
                            <?php if ($related_demo_url) { ?>
                                <a href="<?php echo esc_url($related_demo_url); ?>" target="_blank"
                                   style="padding: 0.875rem 1rem; background: transparent; color: var(--zc-secondary, #126fb7); text-decoration: none; border: 2px solid var(--zc-secondary, #126fb7); border-radius: var(--zc-radius-sm, 8px); font-weight: 600; font-size: 0.875rem; transition: all 0.3s ease;">
                                    Demo
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php 
            } // End while loop
            wp_reset_postdata();
            ?>
        </div>
        
        <!-- View All Button -->
        <div style="text-align: center;">
            <a class="text-white" href="<?php echo get_term_link($current_category); ?>" 
               style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 1rem 2rem; background: var(--zc-text-primary, #1c1c1c); color: white; text-decoration: none; border-radius: var(--zc-radius-sm, 8px); font-weight: 600; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(28, 28, 28, 0.2);">
                View All <?php echo esc_html($current_category->name); ?> Themes
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<?php 
    } // End if have_posts
} // End if current_category
?>