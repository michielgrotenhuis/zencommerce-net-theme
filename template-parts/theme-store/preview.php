<?php
/**
 * Theme Store Preview Section
 * template-parts/theme-store/preview.php
 */

$theme_data = $args['theme_data'] ?? array();
$images = array();

// Parse gallery images if they exist
if (!empty($theme_data['gallery'])) {
    $images = explode(',', $theme_data['gallery']);
    $images = array_filter($images); // Remove empty values
}

// Get full page and mobile screenshots
$fullpage_screenshot = get_post_meta(get_the_ID(), '_theme_fullpage_screenshot', true);
$mobile_screenshot = get_post_meta(get_the_ID(), '_theme_mobile_screenshot', true);

// Check if we have both full page and mobile screenshots
$has_advanced_preview = !empty($fullpage_screenshot) && !empty($mobile_screenshot);
?>

<div class="theme-preview-container <?php echo $has_advanced_preview ? 'advanced-preview' : ''; ?>">
    <?php if ($has_advanced_preview): ?>
        <!-- Advanced Preview with Desktop + Mobile -->
        <div class="advanced-preview-wrapper">
            <!-- Desktop Screenshot with Scroll -->
            <div class="desktop-preview">
                <div class="desktop-browser">
                    <div class="browser-header">
                        <div class="browser-controls">
                            <span class="control-dot red"></span>
                            <span class="control-dot yellow"></span>
                            <span class="control-dot green"></span>
                        </div>
                        <div class="browser-url">
                            <span>yourstore.com</span>
                        </div>
                    </div>
                    <div class="browser-content">
                        <img src="<?php echo wp_get_attachment_image_url($fullpage_screenshot, 'full'); ?>" 
                             alt="Full page preview" 
                             class="fullpage-screenshot" />
                    </div>
                </div>
            </div>
            
            <!-- iPhone Mockup with Mobile Screenshot -->
            <div class="iphone-wrapper">
                <div class="iphone">
                    <div class="iphone-frame">
                        <div class="iphone-notch"></div>
                        <div class="iphone-screen">
                            <img src="<?php echo wp_get_attachment_image_url($mobile_screenshot, 'large'); ?>" 
                                 alt="Mobile preview" 
                                 class="mobile-screenshot" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Standard Preview with Tabs -->
        <?php if (!empty($images) && count($images) > 1): ?>
            <!-- Preview Tabs -->
            <div class="preview-tabs">
                <button class="preview-tab active" onclick="switchPreview(0, 'desktop')">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7l-2 3v1h8v-1l-2-3h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 12H3V4h18v10z"/>
                    </svg>
                    Desktop
                </button>
                <?php if (isset($images[1]) && $images[1]): ?>
                <button class="preview-tab" onclick="switchPreview(1, 'tablet')">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 0H6C4.34 0 3 1.34 3 3v18c0 1.66 1.34 3 3 3h12c1.66 0 3-1.34 3-3V3c0-1.66-1.34-3-3-3zm-2 22H8v-1h8v1zm2-3H6V3h12v16z"/>
                    </svg>
                    Tablet
                </button>
                <?php endif; ?>
                <?php if (isset($images[2]) && $images[2]): ?>
                <button class="preview-tab" onclick="switchPreview(2, 'mobile')">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 1H8C6.34 1 5 2.34 5 4v16c0 1.66 1.34 3 3 3h8c1.66 0 3-1.34 3-3V4c0-1.66-1.34-3-3-3zm-2 20h-4v-1h4v1zm2-3H8V4h8v14z"/>
                    </svg>
                    Mobile
                </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Standard Preview Container -->
        <div class="preview-container">
            <?php 
            if (has_post_thumbnail()): 
                the_post_thumbnail('large', array('id' => 'theme-preview-img', 'alt' => 'Theme Preview'));
            elseif (!empty($images[0])): ?>
                <img id="theme-preview-img" src="<?php echo wp_get_attachment_image_url($images[0], 'large'); ?>" alt="Theme Preview" />
            <?php else: ?>
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, #ddd6fe, #e9d5ff);">
                    <div style="text-align: center; color: #6b7280;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎨</div>
                        <p>Theme Preview</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($images)): ?>
        <script>
        const previewImages = [
            <?php 
            foreach ($images as $index => $image_id) {
                if ($image_id) {
                    echo '"' . wp_get_attachment_image_url($image_id, 'large') . '"';
                    if ($index < count($images) - 1) echo ',';
                }
            }
            ?>
        ];
        
        function switchPreview(index, device) {
            if (previewImages[index]) {
                document.getElementById('theme-preview-img').src = previewImages[index];
            }
            
            // Update active tab
            document.querySelectorAll('.preview-tab').forEach(tab => tab.classList.remove('active'));
            event.target.closest('.preview-tab').classList.add('active');
        }
        </script>
        <?php endif; ?>
    <?php endif; ?>
</div>