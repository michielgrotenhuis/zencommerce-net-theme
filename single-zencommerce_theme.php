<?php
/*
Template Name: Advanced Theme Page - Part 2
File: single-zencommerce_theme.php
*/

get_header(); 

if (have_posts()) : while (have_posts()) : the_post();

// Get theme data
$theme_id = get_the_ID();
$price = get_post_meta($theme_id, '_theme_price', true);
$developer = get_post_meta($theme_id, '_theme_developer', true);
$version = get_post_meta($theme_id, '_theme_version', true);
$demo_url = get_post_meta($theme_id, '_theme_demo_url', true);
$rating = get_post_meta($theme_id, '_theme_rating', true);
$last_updated = get_post_meta($theme_id, '_theme_last_updated', true);
$features = get_post_meta($theme_id, '_theme_features', true);
$support_features = get_post_meta($theme_id, '_theme_support_features', true);
$gallery = get_post_meta($theme_id, '_theme_gallery', true);

// New support fields
$documentation_url = get_post_meta($theme_id, '_theme_documentation_url', true);
$support_email = get_post_meta($theme_id, '_theme_support_email', true);
$video_tutorials_url = get_post_meta($theme_id, '_theme_video_tutorials_url', true);
$developer_address = get_post_meta($theme_id, '_theme_developer_address', true);

$categories = get_the_terms($theme_id, 'theme_category');

?>

<style>
/* Part 1 styles (keeping what works) */
.theme-page {
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
    color: #333;
}
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.hero-section {
    background: linear-gradient(135deg, #f3e8ff, #fce7f3);
    padding: 60px 0;
}
.hero-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}
.theme-title {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #1f2937;
}
.theme-price {
    font-size: 2.5rem;
    font-weight: bold;
    color: #3b82f6;
    margin-bottom: 15px;
}
.theme-price.free {
    color: #16a34a;
}
.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    margin: 8px 8px 8px 0;
    transition: all 0.2s ease;
}
.btn-primary {
    background: #3b82f6;
    color: white;
}
.btn-primary:hover {
    background: #2563eb;
    text-decoration: none;
    color: white;
}
.btn-secondary {
    background: transparent;
    color: #3b82f6;
    border: 2px solid #3b82f6;
}
.btn-secondary:hover {
    background: #3b82f6;
    color: white;
    text-decoration: none;
}
.preview-box {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
.preview-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}
.section {
    padding: 60px 0;
}
.section-title {
    font-size: 2.5rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 40px;
    color: #1f2937;
}
.debug-box {
    background: #dcfce7;
    border: 2px solid #16a34a;
    padding: 20px;
    margin: 20px 0;
    border-radius: 8px;
}

/* NEW Part 2 styles - Feature Tabs */
.features-tabs {
    margin-top: 40px;
}
.tab-navigation {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
    margin-bottom: 40px;
    padding: 0 20px;
}
.tab-btn {
    background: #f3f4f6;
    color: #374151;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    min-width: 140px;
    text-align: center;
}
.tab-btn:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}
.tab-btn.active {
    background: #3b82f6;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}
.tab-panel {
    display: none;
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
}
.tab-panel.active {
    display: block;
    animation: fadeIn 0.3s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 12px;
}
.feature-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}
.feature-item:hover {
    background: #f1f5f9;
    border-color: #3b82f6;
    transform: translateY(-1px);
}
.feature-item::before {
    content: "✓";
    color: #16a34a;
    font-weight: bold;
    margin-right: 12px;
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(22, 163, 74, 0.1);
    border-radius: 50%;
    font-size: 12px;
}
.no-features {
    text-align: center;
    color: #6b7280;
    font-style: italic;
    padding: 40px;
    background: #f9fafb;
    border-radius: 8px;
    border: 2px dashed #d1d5db;
}

@media (max-width: 768px) {
    .hero-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    .theme-title {
        font-size: 2rem;
    }
    .theme-price {
        font-size: 2rem;
    }
    .tab-navigation {
        flex-direction: column;
        align-items: center;
    }
    .tab-btn {
        width: 100%;
        max-width: 250px;
    }
    .tab-panel {
        padding: 20px;
    }
    .feature-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="theme-page">
    
    <!-- Debug Section -->
    <div class="container">
        <div class="debug-box">
            <h4>✅ Part 2: Advanced Features Template</h4>
            <p><strong>Theme ID:</strong> <?php echo $theme_id; ?></p>
            <p><strong>Price:</strong> <?php echo $price ? '$' . $price : 'Free'; ?></p>
            <p><strong>Developer:</strong> <?php echo $developer ?: 'Not set'; ?></p>
            <p><strong>Support Email:</strong> <?php echo $support_email ?: 'Not set'; ?></p>
            <p><strong>Features Count:</strong> <?php echo is_array($features) ? count($features) : 0; ?></p>
            <p><strong>Support Features Count:</strong> <?php echo is_array($support_features) ? count($support_features) : 0; ?></p>
        </div>
    </div>

    <!-- Hero Section (Same as Part 1) -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-grid">
                
                <!-- Left Side: Theme Info -->
                <div class="hero-left">
                    <h1 class="theme-title"><?php the_title(); ?></h1>
                    
                    <!-- Price -->
                    <?php if ($price && $price > 0): ?>
                        <div class="theme-price">$<?php echo number_format($price, 2); ?></div>
                        <div style="background: #dcfce7; border: 1px solid #16a34a; border-radius: 8px; padding: 12px; margin-bottom: 20px; font-size: 14px;">
                            <span style="font-weight: 600; color: #15803d;">🎯 Unlimited Free Trial</span> - Pay only if you publish
                        </div>
                    <?php else: ?>
                        <div class="theme-price free">Free</div>
                    <?php endif; ?>
                    
                    <!-- Description -->
                    <div style="font-size: 1.2rem; color: #6b7280; margin-bottom: 25px;">
                        <?php echo get_the_excerpt() ?: 'Professional WordPress theme ready for your business.'; ?>
                    </div>
                    
                    <!-- Developer -->
                    <?php if ($developer): ?>
                        <div style="margin-bottom: 25px; font-size: 1.1rem;">
                            <span style="color: #6b7280;">by</span>
                            <strong style="color: #3b82f6; margin-left: 5px;"><?php echo esc_html($developer); ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Action Buttons -->
                    <div class="theme-actions">
                        <?php if ($demo_url): ?>
                            <a href="<?php echo esc_url($demo_url); ?>" target="_blank" class="btn btn-primary">
                                🔥 Try for Free
                            </a>
                            <a href="<?php echo esc_url($demo_url); ?>" target="_blank" class="btn btn-secondary">
                                👀 View Demo
                            </a>
                        <?php else: ?>
                            <a href="#" class="btn btn-primary">🔥 Try for Free</a>
                            <a href="#" class="btn btn-secondary">👀 View Demo</a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Meta Info -->
                    <div style="font-size: 14px; color: #6b7280; margin-top: 25px;">
                        <?php if ($last_updated): ?>
                            <div>📅 Last updated: <?php echo date('F j, Y', strtotime($last_updated)); ?></div>
                        <?php endif; ?>
                        <?php if ($version): ?>
                            <div>🔢 Version: <?php echo esc_html($version); ?></div>
                        <?php endif; ?>
                        <?php if ($rating): ?>
                            <div>⭐ Rating: <?php echo $rating; ?>/5</div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Right Side: Preview (Same as Part 1) -->
                <div class="hero-right">
                    <div class="preview-box">
                        <h3 style="margin-bottom: 15px; font-weight: 600;">Theme Preview</h3>
                        
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('large', array('class' => 'preview-image', 'alt' => 'Theme Preview')); ?>
                        <?php elseif ($gallery): 
                            $images = explode(',', $gallery);
                            if (!empty($images[0]) && $images[0]): ?>
                                <img src="<?php echo wp_get_attachment_image_url($images[0], 'large'); ?>" 
                                     alt="Theme Preview" class="preview-image" />
                            <?php endif;
                        else: ?>
                            <div style="background: linear-gradient(135deg, #ddd6fe, #e9d5ff); height: 300px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                                <div style="text-align: center; color: #6b7280;">
                                    <div style="font-size: 3rem; margin-bottom: 10px;">🎨</div>
                                    <p>Theme Preview</p>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($gallery): 
                            $images = explode(',', $gallery);
                            if (count($images) > 1): ?>
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                                    <?php for ($i = 1; $i < min(4, count($images)); $i++): 
                                        if ($images[$i]): ?>
                                            <img src="<?php echo wp_get_attachment_image_url($images[$i], 'thumbnail'); ?>" 
                                                 alt="Preview <?php echo $i; ?>" 
                                                 style="width: 100%; height: 60px; object-fit: cover; border-radius: 4px;" />
                                        <?php endif;
                                    endfor; ?>
                                </div>
                            <?php endif;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW: Theme Showcase Section -->
    <?php 
    $showcase_blocks = get_post_meta($theme_id, '_theme_showcase_blocks', true);
    if ($showcase_blocks && is_array($showcase_blocks) && !empty(array_filter($showcase_blocks, function($block) {
        return !empty($block['title']) || !empty($block['description']);
    }))): 
    ?>
    <section class="section" style="background: white; padding: 80px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 50px; align-items: start;">
                <?php foreach ($showcase_blocks as $index => $block): 
                    if (empty($block['title']) && empty($block['description'])) continue;
                    
                    // Prepare media content
                    $has_image = !empty($block['image_id']) && $block['media_type'] === 'image';
                    $has_youtube = !empty($block['youtube_url']) && $block['media_type'] === 'youtube';
                    $youtube_id = '';
                    
                    if ($has_youtube) {
                        // Extract YouTube ID from URL
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $block['youtube_url'], $matches);
                        $youtube_id = isset($matches[1]) ? $matches[1] : '';
                    }
                ?>
                    <div class="showcase-block" style="text-align: center;">
                        
                        <!-- Media Content -->
                        <?php if ($has_image): 
                            $image_url = wp_get_attachment_image_url($block['image_id'], 'large');
                            $image_full_url = wp_get_attachment_image_url($block['image_id'], 'full');
                            if ($image_url): ?>
                                <div style="margin-bottom: 30px; position: relative; cursor: pointer; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                                     onclick="openLightbox('<?php echo esc_url($image_full_url); ?>', '<?php echo esc_attr($block['title']); ?>')"
                                     onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.15)';"
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0, 0, 0, 0.1)';">
                                    <img src="<?php echo esc_url($image_url); ?>" 
                                         alt="<?php echo esc_attr($block['title']); ?>" 
                                         style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s ease;"
                                         onmouseover="this.style.transform='scale(1.05)';"
                                         onmouseout="this.style.transform='scale(1)';" />
                                    
                                    <!-- Zoom Indicator -->
                                    <div style="position: absolute; top: 15px; right: 15px; background: rgba(0,0,0,0.7); color: white; padding: 8px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        🔍 Click to enlarge
                                    </div>
                                </div>
                            <?php endif;
                        elseif ($has_youtube && $youtube_id): ?>
                            <div style="margin-bottom: 30px; position: relative; cursor: pointer; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;"
                                 onclick="openYouTubeModal('<?php echo esc_attr($youtube_id); ?>', '<?php echo esc_attr($block['title']); ?>')"
                                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 35px rgba(0, 0, 0, 0.15)';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0, 0, 0, 0.1)';">
                                <!-- YouTube Thumbnail -->
                                <div style="position: relative; height: 250px; background: linear-gradient(135deg, #ff0000, #cc0000); display: flex; align-items: center; justify-content: center;">
                                    <img src="https://img.youtube.com/vi/<?php echo esc_attr($youtube_id); ?>/maxresdefault.jpg" 
                                         alt="<?php echo esc_attr($block['title']); ?> Video" 
                                         style="width: 100%; height: 100%; object-fit: cover;" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                    
                                    <!-- Fallback for missing thumbnail -->
                                    <div style="display: none; flex-direction: column; align-items: center; color: white; text-align: center;">
                                        <div style="font-size: 4rem; margin-bottom: 10px;">🎥</div>
                                        <p style="margin: 0; font-weight: 600;">Video Preview</p>
                                    </div>
                                    
                                    <!-- Play Button Overlay -->
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(255,255,255,0.9); border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #ff0000; transition: all 0.3s ease;">
                                        ▶️
                                    </div>
                                    
                                    <!-- Video Indicator -->
                                    <div style="position: absolute; top: 15px; right: 15px; background: rgba(255,0,0,0.9); color: white; padding: 8px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        🎥 Click to play
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Text Content -->
                        <div>
                            <?php if (!empty($block['title'])): ?>
                                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 15px; color: #1f2937; line-height: 1.3;">
                                    <?php echo esc_html($block['title']); ?>
                                </h3>
                            <?php endif; ?>
                            
                            <?php if (!empty($block['description'])): ?>
                                <p style="color: #6b7280; font-size: 1rem; line-height: 1.6; margin: 0;">
                                    <?php echo nl2br(esc_html($block['description'])); ?>
                                </p>
                            <?php endif; ?>
                            
                            <!-- Action indicator for media -->
                            <?php if ($has_image || ($has_youtube && $youtube_id)): ?>
                                <div style="margin-top: 15px;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; color: #3b82f6; font-size: 14px; font-weight: 600;">
                                        <?php if ($has_image): ?>
                                            🔍 Enlarge screenshot in lightbox
                                        <?php else: ?>
                                            ▶️ Watch video demonstration
                                        <?php endif; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal for Images -->
    <div id="lightbox-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 10000; cursor: pointer;" onclick="closeLightbox()">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
            <img id="lightbox-image" src="" alt="" style="max-width: 100%; max-height: 100%; border-radius: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.5);" />
        </div>
        <button onclick="closeLightbox()" style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: white; font-size: 3rem; cursor: pointer; z-index: 10001;">&times;</button>
    </div>

    <!-- YouTube Modal -->
    <div id="youtube-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 10000;" onclick="closeYouTubeModal()">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90%; max-width: 800px; aspect-ratio: 16/9;">
            <iframe id="youtube-iframe" src="" frameborder="0" allowfullscreen style="width: 100%; height: 100%; border-radius: 8px;"></iframe>
        </div>
        <button onclick="closeYouTubeModal()" style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: white; font-size: 3rem; cursor: pointer; z-index: 10001;">&times;</button>
    </div>

    <style>
    .showcase-block:hover {
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .showcase-block {
            margin-bottom: 40px;
        }
        .showcase-block h3 {
            font-size: 1.3rem !important;
        }
        #lightbox-modal div {
            max-width: 95% !important;
            max-height: 80% !important;
        }
        #youtube-modal div {
            width: 95% !important;
        }
    }
    </style>

    <script>
    // Lightbox functionality for images
    function openLightbox(imageUrl, title) {
        const modal = document.getElementById('lightbox-modal');
        const image = document.getElementById('lightbox-image');
        
        image.src = imageUrl;
        image.alt = title;
        modal.style.display = 'block';
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    }

    function closeLightbox() {
        const modal = document.getElementById('lightbox-modal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // YouTube modal functionality
    function openYouTubeModal(videoId, title) {
        const modal = document.getElementById('youtube-modal');
        const iframe = document.getElementById('youtube-iframe');
        
        iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
        modal.style.display = 'block';
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeYouTubeModal();
            }
        });
    }

    function closeYouTubeModal() {
        const modal = document.getElementById('youtube-modal');
        const iframe = document.getElementById('youtube-iframe');
        
        // Stop video by clearing src
        iframe.src = '';
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modals when clicking outside content
    document.addEventListener('DOMContentLoaded', function() {
        const lightboxModal = document.getElementById('lightbox-modal');
        const youtubeModal = document.getElementById('youtube-modal');
        
        if (lightboxModal) {
            lightboxModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLightbox();
                }
            });
        }
        
        if (youtubeModal) {
            youtubeModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeYouTubeModal();
                }
            });
        }
    });
    </script>
    <?php endif; ?>

    <!-- DEBUGGING: Advanced Features Section with All Tabs -->
    <section class="section" style="background: #f9fafb;">
        <div class="container">
            <h2 class="section-title">Theme Features</h2>
            
            <?php 
            // Get both feature types
            $theme_features = get_post_meta($theme_id, '_theme_features', true);
            $support_features = get_post_meta($theme_id, '_theme_support_features', true);
            
            // Ensure arrays
            if (!is_array($theme_features)) $theme_features = array();
            if (!is_array($support_features)) $support_features = array();
            
            // Debug output
            echo "<!-- DEBUG: Theme Features: " . print_r($theme_features, true) . " -->";
            echo "<!-- DEBUG: Support Features: " . print_r($support_features, true) . " -->";
            
            // Complete feature categories
            $feature_categories = array(
                'great-for' => array(
                    'title' => '🎯 This Theme is Great For',
                    'type' => 'theme',
                    'features' => array('quick_setup', 'visual_storytelling', 'dropshipping', 'high_volume_stores', 'physical_stores', 'small_catalogs', 'large_catalogs', 'editorial_content', 'quick_launch')
                ),
                'cart-checkout' => array(
                    'title' => '🛒 Cart & Checkout',
                    'type' => 'theme',
                    'features' => array('cart_notes', 'in_store_pickups', 'quick_buy', 'slide_out_cart', 'cart_countdown_timers', 'gift_wrapping', 'pre_order', 'back_in_stock_notifications', 'bnpl_messaging', 'trust_badges_checkout')
                ),
                'marketing' => array(
                    'title' => '📈 Marketing & Conversion',
                    'type' => 'theme',
                    'features' => array('blogs', 'cross_selling', 'faq_page', 'press_coverage', 'promo_banners', 'recommended_products', 'age_verifier', 'announcement_bar', 'countdown_timers', 'popups_modals', 'email_signup_forms', 'product_badges', 'custom_cta_buttons', 'social_proof', 'affiliate_ready')
                ),
                'merchandising' => array(
                    'title' => '🏪 Merchandising',
                    'type' => 'theme',
                    'features' => array('color_swatches', 'high_resolution_images', 'image_galleries', 'image_rollover', 'image_zoom', 'ingredients_nutritional', 'lookbooks', 'product_options', 'product_videos', 'shipping_delivery_info', 'size_chart', 'slideshow', 'usage_information', 'product_view_360', 'accordion_product_tabs', 'custom_product_badges', 'sticky_add_to_cart', 'back_in_stock_label', 'before_after_slider', 'product_bundling', 'tabbed_product_info', 'multiple_product_layouts', 'customizable_hotspots', 'product_feature_icons')
                ),
                'discovery' => array(
                    'title' => '🔍 Product Discovery',
                    'type' => 'theme',
                    'features' => array('enhanced_search', 'mega_menu', 'product_filtering_sorting', 'recommended_products_discovery', 'sticky_header', 'swatch_filters', 'live_search_suggestions', 'predictive_search', 'infinite_scroll', 'quick_view', 'tag_based_filters', 'recently_viewed', 'advanced_navigation')
                ),
                'technical' => array(
                    'title' => '⚙️ Technical Features',
                    'type' => 'theme',
                    'features' => array('responsive', 'retina', 'seo_optimized', 'fast_loading', 'customizable', 'multilingual', 'rtl_support', 'page_builder', 'one_click_demo', 'social_sharing', 'contact_form', 'newsletter_integration', 'css3_animations', 'bootstrap_framework', 'custom_widgets', 'parallax_effects', 'video_backgrounds', 'lazy_loading', 'compression_optimization', 'schema_markup', 'accessibility_ready')
                ),
                'support' => array(
                    'title' => '🛠️ Support & Documentation',
                    'type' => 'support',
                    'features' => array('documentation', 'video_tutorials', 'email_support', 'forum_support', 'free_updates', 'child_theme', 'lifetime_updates', 'priority_support', 'installation_service', 'customization_service')
                )
            );
            
            // Feature labels
            $feature_labels = array(
                // This Theme is Great For
                'quick_setup' => 'Quick setup (minimal setup for fast launch)',
                'visual_storytelling' => 'Visual storytelling (image-focused brand presentation)',
                'dropshipping' => 'Dropshipping',
                'high_volume_stores' => 'High-volume stores',
                'physical_stores' => 'Physical stores',
                'small_catalogs' => 'Small catalogs',
                'large_catalogs' => 'Large catalogs',
                'editorial_content' => 'Editorial content',
                'quick_launch' => 'Quick launch',
                
                // Cart and Checkout
                'cart_notes' => 'Cart notes',
                'in_store_pickups' => 'In-store pickups',
                'quick_buy' => 'Quick buy',
                'slide_out_cart' => 'Slide-out / drawer cart',
                'cart_countdown_timers' => 'Cart countdown timers',
                'gift_wrapping' => 'Gift wrapping options',
                'pre_order' => 'Pre-order support',
                'back_in_stock_notifications' => 'Back-in-stock notifications',
                'bnpl_messaging' => 'Buy now, pay later messaging (BNPL)',
                'trust_badges_checkout' => 'Trust badges at checkout',
                
                // Marketing and Conversion
                'blogs' => 'Blogs',
                'cross_selling' => 'Cross-selling',
                'faq_page' => 'FAQ page',
                'press_coverage' => 'Press coverage',
                'promo_banners' => 'Promo banners',
                'recommended_products' => 'Recommended products',
                'age_verifier' => 'Age verifier',
                'announcement_bar' => 'Announcement bar',
                'countdown_timers' => 'Countdown timers',
                'popups_modals' => 'Pop-ups/modals (newsletter, exit intent)',
                'email_signup_forms' => 'Email signup forms',
                'product_badges' => 'Product badges (e.g., "New", "Sale")',
                'custom_cta_buttons' => 'Custom CTA buttons',
                'social_proof' => 'Social proof (reviews, testimonials)',
                'affiliate_ready' => 'Affiliate-ready integrations',
                
                // Merchandising
                'color_swatches' => 'Color swatches',
                'high_resolution_images' => 'High-resolution images',
                'image_galleries' => 'Image galleries',
                'image_rollover' => 'Image rollover',
                'image_zoom' => 'Image zoom',
                'ingredients_nutritional' => 'Ingredients or nutritional information',
                'lookbooks' => 'Lookbooks',
                'product_options' => 'Product options',
                'product_videos' => 'Product videos',
                'shipping_delivery_info' => 'Shipping/delivery information',
                'size_chart' => 'Size chart',
                'slideshow' => 'Slideshow',
                'usage_information' => 'Usage information',
                'product_view_360' => '360° product view',
                'accordion_product_tabs' => 'Accordion-style product tabs',
                'custom_product_badges' => 'Custom product badges',
                'sticky_add_to_cart' => 'Sticky add to cart',
                'back_in_stock_label' => 'Back-in-stock label',
                'before_after_slider' => 'Before/after image slider',
                'product_bundling' => 'Product bundling',
                'tabbed_product_info' => 'Tabbed product information',
                'multiple_product_layouts' => 'Multiple product layout options',
                'customizable_hotspots' => 'Customizable image hotspots',
                'product_feature_icons' => 'Icons for product features (e.g., eco-friendly, handmade)',
                
                // Product Discovery
                'enhanced_search' => 'Enhanced search',
                'mega_menu' => 'Mega menu',
                'product_filtering_sorting' => 'Product filtering and sorting',
                'recommended_products_discovery' => 'Recommended products',
                'sticky_header' => 'Sticky header',
                'swatch_filters' => 'Swatch filters',
                'live_search_suggestions' => 'Live search suggestions',
                'predictive_search' => 'Predictive search',
                'infinite_scroll' => 'Infinite scroll',
                'quick_view' => 'Quick view',
                'tag_based_filters' => 'Tag-based/custom filters',
                'recently_viewed' => 'Recently viewed products',
                'advanced_navigation' => 'Advanced navigation (breadcrumbs, multi-level menus)',
                
                // Technical Features
                'responsive' => 'Responsive Design',
                'retina' => 'Retina Ready',
                'seo_optimized' => 'SEO Optimized',
                'fast_loading' => 'Fast Loading',
                'customizable' => 'Highly Customizable',
                'multilingual' => 'Multilingual Ready',
                'rtl_support' => 'RTL Support',
                'page_builder' => 'Page Builder Compatible',
                'one_click_demo' => 'One Click Demo Import',
                'social_sharing' => 'Social Sharing',
                'contact_form' => 'Contact Form',
                'newsletter_integration' => 'Newsletter Integration',
                'css3_animations' => 'CSS3 Animations',
                'bootstrap_framework' => 'Bootstrap Framework',
                'custom_widgets' => 'Custom Widgets',
                'parallax_effects' => 'Parallax Effects',
                'video_backgrounds' => 'Video Backgrounds',
                'lazy_loading' => 'Lazy Loading',
                'compression_optimization' => 'Image Compression & Optimization',
                'schema_markup' => 'Schema Markup',
                'accessibility_ready' => 'Accessibility Ready (WCAG)',
                
                // Support & Documentation
                'documentation' => 'Documentation',
                'video_tutorials' => 'Video Tutorials',
                'email_support' => 'Email Support',
                'forum_support' => 'Forum Support',
                'free_updates' => 'Free Updates',
                'child_theme' => 'Child Theme Included',
                'lifetime_updates' => 'Lifetime Updates',
                'priority_support' => 'Priority Support',
                'installation_service' => 'Installation Service',
                'customization_service' => 'Customization Service'
            );
            ?>
            
            <!-- Debug info visible on page -->
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin-bottom: 20px; border-radius: 8px;">
                <h4>🔍 Debug Info</h4>
                <p><strong>Total Categories:</strong> <?php echo count($feature_categories); ?></p>
                <p><strong>Theme Features Count:</strong> <?php echo count($theme_features); ?></p>
                <p><strong>Support Features Count:</strong> <?php echo count($support_features); ?></p>
                <p><strong>Categories:</strong> 
                    <?php foreach($feature_categories as $id => $cat) echo $id . ' '; ?>
                </p>
            </div>
            
            <div class="features-tabs">
                <!-- Tab Navigation -->
                <div class="tab-navigation">
                    <?php 
                    $tab_counter = 0;
                    foreach ($feature_categories as $tab_id => $category): 
                        $tab_counter++;
                        $is_first = ($tab_counter === 1);
                    ?>
                        <button class="tab-btn <?php echo $is_first ? 'active' : ''; ?>" 
                                onclick="showFeatureTab('<?php echo $tab_id; ?>')"
                                data-tab-id="<?php echo $tab_id; ?>">
                            <?php echo $category['title']; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <!-- Tab Panels -->
                <div class="tab-content">
                    <?php 
                    $panel_counter = 0;
                    foreach ($feature_categories as $tab_id => $category): 
                        $panel_counter++;
                        $is_first_panel = ($panel_counter === 1);
                        
                        // Get correct features based on type
                        if ($category['type'] === 'support') {
                            $category_features = array_intersect($category['features'], $support_features);
                        } else {
                            $category_features = array_intersect($category['features'], $theme_features);
                        }
                        
                        echo "<!-- DEBUG: Panel $tab_id has " . count($category_features) . " features -->";
                    ?>
                        <div id="<?php echo $tab_id; ?>" 
                             class="tab-panel <?php echo $is_first_panel ? 'active' : ''; ?>" 
                             style="<?php echo !$is_first_panel ? 'display: none;' : ''; ?>">
                            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 20px; color: #1f2937; display: flex; align-items: center; justify-content: space-between;">
                                <span><?php echo $category['title']; ?></span>
                                <span style="background: #3b82f6; color: white; padding: 6px 12px; border-radius: 12px; font-size: 14px; margin-left: 10px;">
                                    <?php echo count($category_features); ?> features
                                </span>
                            </h3>
                            
                            <?php if (!empty($category_features)): ?>
                                <div class="feature-grid">
                                    <?php foreach ($category_features as $feature): 
                                        $label = isset($feature_labels[$feature]) ? $feature_labels[$feature] : ucwords(str_replace('_', ' ', $feature));
                                    ?>
                                        <div class="feature-item">
                                            <?php echo esc_html($label); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="no-features">
                                    <div style="font-size: 2rem; margin-bottom: 10px;">
                                        <?php if ($tab_id === 'great-for'): ?>
                                            🎯
                                        <?php elseif ($tab_id === 'support'): ?>
                                            🛠️
                                        <?php else: ?>
                                            📋
                                        <?php endif; ?>
                                    </div>
                                    <p>No features selected for this category yet.</p>
                                    <p style="font-size: 14px; margin-top: 10px; color: #6b7280;">
                                        <?php if ($tab_id === 'great-for'): ?>
                                            Select use cases in the admin to help users understand what this theme is perfect for.
                                        <?php elseif ($tab_id === 'support'): ?>
                                            Add support options in the admin to show what's included with this theme.
                                        <?php else: ?>
                                            Add features in the WordPress admin to see them here.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Support & Documentation Section (Same as Part 1) -->
    <?php if ($support_email || $documentation_url || $video_tutorials_url): ?>
    <section class="section" style="background: white;">
        <div class="container">
            <h2 class="section-title">Support & Documentation</h2>
            
            <div style="max-width: 800px; margin: 0 auto;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px;">
                    <h3 style="color: #1e40af; margin-bottom: 20px; font-size: 1.5rem;">
                        This theme is supported by <?php echo esc_html($developer ?: 'Zencommerce Team'); ?>
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
                        <?php if ($support_email): ?>
                            <a href="mailto:<?php echo esc_attr($support_email); ?>" 
                               style="display: flex; align-items: center; padding: 15px; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.2s;">
                                <span style="margin-right: 8px;">📧</span> Get Support
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($documentation_url): ?>
                            <a href="<?php echo esc_url($documentation_url); ?>" target="_blank"
                               style="display: flex; align-items: center; padding: 15px; background: transparent; color: #3b82f6; text-decoration: none; border: 2px solid #3b82f6; border-radius: 8px; font-weight: 600; transition: all 0.2s;">
                                <span style="margin-right: 8px;">📚</span> Documentation
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($video_tutorials_url): ?>
                            <a href="<?php echo esc_url($video_tutorials_url); ?>" target="_blank"
                               style="display: flex; align-items: center; padding: 15px; background: #16a34a; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.2s;">
                                <span style="margin-right: 8px;">🎥</span> Video Tutorials
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($developer_address || $support_email || $rating): ?>
                        <div style="background: white; padding: 20px; border-radius: 8px; margin-top: 20px; border: 1px solid #e5e7eb;">
                            <h4 style="margin-bottom: 15px; color: #1f2937;">About Developer</h4>
                            <div style="font-size: 14px; color: #6b7280; line-height: 1.6;">
                                <?php if ($developer_address): ?>
                                    <div style="margin-bottom: 8px;">📍 <?php echo nl2br(esc_html($developer_address)); ?></div>
                                <?php endif; ?>
                                <?php if ($support_email): ?>
                                    <div style="margin-bottom: 8px;">📧 <?php echo esc_html($support_email); ?></div>
                                <?php endif; ?>
                                <?php if ($rating): ?>
                                    <div>⭐ <?php echo $rating; ?>/5.0 rating</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($support_features && is_array($support_features) && !empty($support_features)): ?>
                        <div style="margin-top: 20px;">
                            <h4 style="margin-bottom: 15px; color: #1f2937;">What's Included</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 8px;">
                                <?php foreach ($support_features as $feature): ?>
                                    <div style="display: flex; align-items: center; padding: 8px 12px; background: #f0f9ff; border-radius: 6px; font-size: 14px; border: 1px solid #e0f2fe;">
                                        <span style="color: #0369a1; margin-right: 8px; font-weight: bold;">✓</span>
                                        <?php echo esc_html(ucwords(str_replace('_', ' ', $feature))); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Content Section -->
    <section class="section" style="background: #f9fafb;">
        <div class="container">
            <h2 class="section-title">About This Theme</h2>
            <div style="max-width: 800px; margin: 0 auto; font-size: 1.1rem; line-height: 1.7; color: #374151;">
                <?php the_content(); ?>
            </div>
        </div>
    </section>

     <!-- Updated Trust Section with Zencommerce Promise -->
    <section class="section" style="background: linear-gradient(135deg, #3b82f6, #1e40af); color: white;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 20px; color: white;">
                    Build with confidence — the Zencommerce promise
                </h2>
                <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">
                    Professional themes built for serious entrepreneurs who demand excellence
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto;">
                <!-- Feature 1 -->
                <div style="padding: 30px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 20px;">🚀</div>
                    <h3 style="font-weight: 700; margin-bottom: 15px; color: white; font-size: 1.3rem;">Works with the latest ecommerce features</h3>
                    <p style="font-size: 15px; opacity: 0.9; line-height: 1.6;">Themes are built with modern web standards and stay compatible with Zencommerce's growing feature set, ensuring your store always performs at its best.</p>
                </div>
                
                <!-- Feature 2 -->
                <div style="padding: 30px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 20px;">⚡</div>
                    <h3 style="font-weight: 700; margin-bottom: 15px; color: white; font-size: 1.3rem;">Speed-tested and conversion-optimized</h3>
                    <p style="font-size: 15px; opacity: 0.9; line-height: 1.6;">Every theme meets strict performance standards with Core Web Vitals optimization, ensuring faster loading times and higher conversion rates for your business.</p>
                </div>
                
                <!-- Feature 3 -->
                <div style="padding: 30px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 20px;">🆓</div>
                    <h3 style="font-weight: 700; margin-bottom: 15px; color: white; font-size: 1.3rem;">Unlimited free trial</h3>
                    <p style="font-size: 15px; opacity: 0.9; line-height: 1.6;">Test the theme with your products, branding, and customizations. <?php if ($price && $price > 0): ?>Pay only $<?php echo number_format($price, 0); ?> when you're ready to publish<?php else: ?>Download and use completely free<?php endif; ?>.</p>
                </div>
                
                <!-- Feature 4 -->
                <div style="padding: 30px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 20px;">📸</div>
                    <h3 style="font-weight: 700; margin-bottom: 15px; color: white; font-size: 1.3rem;">Professional design resources</h3>
                    <p style="font-size: 15px; opacity: 0.9; line-height: 1.6;">Access to high-quality stock photos, design guidelines, and branding resources to make your store look professionally designed from day one.</p>
                </div>
                
                <!-- Feature 5 -->
                <div style="padding: 30px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 20px;">🔄</div>
                    <h3 style="font-weight: 700; margin-bottom: 15px; color: white; font-size: 1.3rem;">Lifetime updates and support</h3>
                    <p style="font-size: 15px; opacity: 0.9; line-height: 1.6;">Get continuous theme improvements, security updates, and new features. Professional support included with every theme purchase.</p>
                </div>
                
                <!-- Feature 6 -->
                <div style="padding: 30px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 20px;">🏪</div>
                    <h3 style="font-weight: 700; margin-bottom: 15px; color: white; font-size: 1.3rem;">Multi-store license included</h3>
                    <p style="font-size: 15px; opacity: 0.9; line-height: 1.6;">Use the theme on unlimited stores you own. Perfect for agencies, entrepreneurs with multiple businesses, or testing different markets.</p>
                </div>
            </div>
            
            <!-- Additional Trust Elements -->
            <div style="margin-top: 50px; padding-top: 40px; border-top: 1px solid rgba(255,255,255,0.2);">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: center;">
                    <div>
                        <div style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 8px;">99.9%</div>
                        <div style="font-size: 14px; opacity: 0.8;">Uptime Guarantee</div>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 8px;">&lt;2s</div>
                        <div style="font-size: 14px; opacity: 0.8;">Average Load Time</div>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 8px;">24/7</div>
                        <div style="font-size: 14px; opacity: 0.8;">Expert Support</div>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 8px;">60+</div>
                        <div style="font-size: 14px; opacity: 0.8;">Countries Served</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php 
    // Get the first category of the current theme
    $current_category = null;
    if ($categories && !is_wp_error($categories) && !empty($categories)) {
        $current_category = $categories[0];
    }
    
    if ($current_category):
        // Query for more themes in the same category (excluding current theme)
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
        
        if ($related_themes->have_posts()):
    ?>
    <section class="section" style="background: #f9fafb;">
        <div class="container">
            <h2 class="section-title">More <?php echo esc_html($current_category->name); ?> Themes</h2>
            <p style="text-align: center; color: #6b7280; font-size: 1.1rem; margin-bottom: 40px;">
                Discover other professional themes in the <?php echo esc_html($current_category->name); ?> category
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-bottom: 40px;">
                <?php while ($related_themes->have_posts()): $related_themes->the_post(); 
                    $related_id = get_the_ID();
                    $related_price = get_post_meta($related_id, '_theme_price', true);
                    $related_developer = get_post_meta($related_id, '_theme_developer', true);
                    $related_rating = get_post_meta($related_id, '_theme_rating', true);
                    $related_demo_url = get_post_meta($related_id, '_theme_demo_url', true);
                ?>
                    <div class="related-theme-card" style="background: white; border-radius: 12px; padding: 0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); border: 1px solid #e5e7eb; transition: all 0.3s ease; overflow: hidden;">
                        <!-- Theme Preview -->
                        <div style="position: relative; height: 200px; overflow: hidden;">
                            <?php if (has_post_thumbnail()): ?>
                                <a href="<?php the_permalink(); ?>" style="display: block; height: 100%;">
                                    <?php the_post_thumbnail('medium_large', array(
                                        'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;',
                                        'alt' => get_the_title() . ' Theme Preview'
                                    )); ?>
                                </a>
                            <?php else: ?>
                                <a href="<?php the_permalink(); ?>" style="display: block; height: 100%;">
                                    <div style="background: linear-gradient(135deg, #ddd6fe, #e9d5ff); height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <div style="text-align: center; color: #6b7280;">
                                            <div style="font-size: 2rem; margin-bottom: 5px;">🎨</div>
                                            <p style="margin: 0; font-size: 14px;">Theme Preview</p>
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?>
                            
                            <!-- Price Badge -->
                            <div style="position: absolute; top: 15px; right: 15px;">
                                <?php if ($related_price && $related_price > 0): ?>
                                    <span style="background: #3b82f6; color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        $<?php echo number_format($related_price, 0); ?>
                                    </span>
                                <?php else: ?>
                                    <span style="background: #16a34a; color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        Free
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Theme Info -->
                        <div style="padding: 20px;">
                            <h3 style="margin: 0 0 10px 0; font-size: 1.3rem; font-weight: 700; line-height: 1.3;">
                                <a href="<?php the_permalink(); ?>" style="color: #1f2937; text-decoration: none; transition: color 0.2s;">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            
                            <p style="color: #6b7280; font-size: 14px; margin: 0 0 15px 0; line-height: 1.5;">
                                <?php 
                                $excerpt = get_the_excerpt();
                                if (!$excerpt) {
                                    $excerpt = 'Professional WordPress theme ready for your business.';
                                }
                                echo wp_trim_words($excerpt, 15, '...');
                                ?>
                            </p>
                            
                            <!-- Meta Info -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 13px; color: #6b7280;">
                                <div>
                                    <?php if ($related_developer): ?>
                                        <span>by <strong style="color: #374151;"><?php echo esc_html($related_developer); ?></strong></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <?php if ($related_rating): ?>
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <span style="color: #fbbf24;">⭐</span>
                                            <span><?php echo $related_rating; ?>/5</span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div style="display: flex; gap: 10px;">
                                <a href="<?php the_permalink(); ?>" 
                                   style="flex: 1; text-align: center; padding: 12px 16px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.2s; border: 2px solid #3b82f6;"
                                   onmouseover="this.style.background='#2563eb'; this.style.borderColor='#2563eb';"
                                   onmouseout="this.style.background='#3b82f6'; this.style.borderColor='#3b82f6';">
                                    View Details
                                </a>
                                <?php if ($related_demo_url): ?>
                                    <a href="<?php echo esc_url($related_demo_url); ?>" target="_blank"
                                       style="padding: 12px 16px; background: transparent; color: #3b82f6; text-decoration: none; border: 2px solid #3b82f6; border-radius: 6px; font-weight: 600; font-size: 14px; transition: all 0.2s;"
                                       onmouseover="this.style.background='#3b82f6'; this.style.color='white';"
                                       onmouseout="this.style.background='transparent'; this.style.color='#3b82f6';">
                                        Demo
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            
            <!-- View All Button -->
            <div style="text-align: center;">
                <a href="<?php echo get_term_link($current_category); ?>" 
                   style="display: inline-block; padding: 15px 30px; background: #1f2937; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                   onmouseover="this.style.background='#111827'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.15)';"
                   onmouseout="this.style.background='#1f2937'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    View All <?php echo esc_html($current_category->name); ?> Themes →
                </a>
            </div>
        </div>
    </section>

    <!-- Additional CSS for better responsiveness -->
    <style>
    .related-theme-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }
    .related-theme-card img:hover {
        transform: scale(1.05);
    }
    @media (max-width: 768px) {
        .related-theme-card {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 2rem !important;
        }
    }
    </style>

    <?php 
        endif; // End if related themes
        wp_reset_postdata();
    endif; // End if category exists
    ?>

</div>

<script>
// Feature tab functionality
function showFeatureTab(tabId) {
    // Hide all tab panels
    document.querySelectorAll('.tab-panel').forEach(panel => {
        panel.classList.remove('active');
        panel.style.display = 'none';
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab panel
    const selectedPanel = document.getElementById(tabId);
    if (selectedPanel) {
        selectedPanel.classList.add('active');
        selectedPanel.style.display = 'block';
    }
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial active tab
    showFeatureTab('cart-checkout');
    
    // Add hover effects to support links
    document.querySelectorAll('a[href^="mailto:"], a[href*="docs"], a[href*="tutorial"]').forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>

<?php 
endwhile; 
else: 
    echo '<div class="container" style="padding: 60px 0; text-align: center;"><h2>Theme not found</h2></div>';
endif; 

get_footer(); 
?>