<?php
/**
 * Theme Store Showcase Section
 * template-parts/theme-store/showcase.php
 */

$theme_data = $args['theme_data'] ?? array();
$showcase_blocks = $theme_data['showcase_blocks'] ?? array();

// Ensure showcase_blocks is an array
if (!is_array($showcase_blocks)) {
    $showcase_blocks = array();
}

// Filter blocks that have content
$filtered_blocks = array_filter($showcase_blocks, function($block) {
    return is_array($block) && (!empty($block['title']) || !empty($block['description']));
});

// Check if showcase blocks exist and have content
if (!empty($filtered_blocks)): 
    $block_count = count($filtered_blocks);
    $grid_class = ($block_count === 3) ? 'showcase-grid three-items' : 'showcase-grid';
?>

<section class="theme-showcase">
    <div class="layout-container">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">See It in Action</h2>
            <p class="text-xl text-secondary">Explore the key features and capabilities of this theme</p>
        </div>
        
        <div class="<?php echo $grid_class; ?>">
            <?php foreach ($filtered_blocks as $index => $block): 
                // Ensure block is an array
                if (!is_array($block)) continue;
                
                $has_image = !empty($block['image_id']) && isset($block['media_type']) && $block['media_type'] === 'image';
                $has_youtube = !empty($block['youtube_url']) && isset($block['media_type']) && $block['media_type'] === 'youtube';
                $youtube_id = '';
                
                if ($has_youtube) {
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $block['youtube_url'], $matches);
                    $youtube_id = isset($matches[1]) ? $matches[1] : '';
                }
            ?>
                <div class="showcase-item">
                    <?php if ($has_image): 
                        $image_url = wp_get_attachment_image_url($block['image_id'], 'large');
                        $image_full_url = wp_get_attachment_image_url($block['image_id'], 'full');
                        if ($image_url): ?>
                            <div class="showcase-media" onclick="openLightbox('<?php echo esc_url($image_full_url); ?>', '<?php echo esc_attr($block['title'] ?? ''); ?>')">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($block['title'] ?? ''); ?>" />
                                <div class="media-overlay">
                                    <div class="media-play-btn">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M10 2a8 8 0 105.293 14.293l5.707 5.707 1.414-1.414-5.707-5.707A8 8 0 0010 2zm0 2a6 6 0 110 12 6 6 0 010-12z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    elseif ($has_youtube && $youtube_id): ?>
                        <div class="showcase-media" onclick="openYouTubeModal('<?php echo esc_attr($youtube_id); ?>', '<?php echo esc_attr($block['title'] ?? ''); ?>')">
                            <img src="https://img.youtube.com/vi/<?php echo esc_attr($youtube_id); ?>/maxresdefault.jpg" alt="<?php echo esc_attr($block['title'] ?? ''); ?> Video" />
                            <div class="media-overlay">
                                <div class="media-play-btn">
                                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="showcase-content">
                        <?php if (!empty($block['title'])): ?>
                            <h3 class="showcase-title"><?php echo esc_html($block['title']); ?></h3>
                        <?php endif; ?>
                        
                        <?php if (!empty($block['description'])): ?>
                            <p class="showcase-description"><?php echo nl2br(esc_html($block['description'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php endif; ?>