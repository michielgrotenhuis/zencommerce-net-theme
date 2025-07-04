<?php
/**
 * Currency Dynamic Background System
 * File: inc/currency/currency-dynamic-backgrounds.php
 * 
 * This system allows dynamic background image changes based on selected currency
 * with full WordPress admin integration and extensibility for future enhancements.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize the dynamic backgrounds system
 */
function yoursite_init_currency_backgrounds() {
    // Add admin menu
    add_action('admin_menu', 'yoursite_currency_backgrounds_admin_menu');
    
    // Register settings
    add_action('admin_init', 'yoursite_currency_backgrounds_register_settings');
    
    // Enqueue frontend scripts
    add_action('wp_enqueue_scripts', 'yoursite_currency_backgrounds_enqueue_scripts');
    
    // Add AJAX handlers
    add_action('wp_ajax_save_currency_background', 'yoursite_ajax_save_currency_background');
    add_action('wp_ajax_delete_currency_background', 'yoursite_ajax_delete_currency_background');
    add_action('wp_ajax_get_currency_backgrounds', 'yoursite_ajax_get_currency_backgrounds');
    add_action('wp_ajax_nopriv_get_currency_backgrounds', 'yoursite_ajax_get_currency_backgrounds');
}
add_action('init', 'yoursite_init_currency_backgrounds');

/**
 * Add admin menu for currency backgrounds
 */
function yoursite_currency_backgrounds_admin_menu() {
    add_submenu_page(
        'yoursite-currencies',
        __('Dynamic Backgrounds', 'yoursite'),
        __('Dynamic Backgrounds', 'yoursite'),
        'manage_options',
        'yoursite-currency-backgrounds',
        'yoursite_currency_backgrounds_admin_page'
    );
}

/**
 * Register settings for currency backgrounds
 */
function yoursite_currency_backgrounds_register_settings() {
    register_setting('yoursite_currency_backgrounds', 'yoursite_currency_backgrounds_config');
    register_setting('yoursite_currency_backgrounds', 'yoursite_currency_backgrounds_default');
    register_setting('yoursite_currency_backgrounds', 'yoursite_currency_backgrounds_enabled');
    register_setting('yoursite_currency_backgrounds', 'yoursite_currency_backgrounds_transition');
}

/**
 * Admin page for managing currency backgrounds
 */
function yoursite_currency_backgrounds_admin_page() {
    $backgrounds_config = get_option('yoursite_currency_backgrounds_config', array());
    $default_background = get_option('yoursite_currency_backgrounds_default', '');
    $system_enabled = get_option('yoursite_currency_backgrounds_enabled', true);
    $transition_effect = get_option('yoursite_currency_backgrounds_transition', 'fade');
    
    $active_currencies = yoursite_get_active_currencies();
    ?>
    <div class="wrap">
        <h1><?php _e('🖼️ Currency Dynamic Backgrounds', 'yoursite'); ?></h1>
        
        <div class="currency-backgrounds-admin">
            
            <!-- System Settings -->
            <div class="settings-section">
                <h2><?php _e('System Settings', 'yoursite'); ?></h2>
                
                <form method="post" action="options.php" class="system-settings-form">
                    <?php settings_fields('yoursite_currency_backgrounds'); ?>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e('Enable Dynamic Backgrounds', 'yoursite'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="yoursite_currency_backgrounds_enabled" value="1" 
                                           <?php checked($system_enabled, 1); ?> />
                                    <?php _e('Enable currency-based background changes', 'yoursite'); ?>
                                </label>
                                <p class="description">
                                    <?php _e('When enabled, background images will change based on selected currency.', 'yoursite'); ?>
                                </p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row"><?php _e('Default Background Image', 'yoursite'); ?></th>
                            <td>
                                <div class="default-background-selector">
                                    <input type="url" name="yoursite_currency_backgrounds_default" 
                                           value="<?php echo esc_attr($default_background); ?>" 
                                           class="regular-text" 
                                           placeholder="https://example.com/default-hero.jpg" />
                                    <button type="button" class="button upload-background-btn" 
                                            data-target="yoursite_currency_backgrounds_default">
                                        <?php _e('Upload Image', 'yoursite'); ?>
                                    </button>
                                    <?php if ($default_background) : ?>
                                        <div class="background-preview" style="margin-top: 10px;">
                                            <img src="<?php echo esc_url($default_background); ?>" 
                                                 style="max-width: 200px; height: auto; border: 1px solid #ddd;" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p class="description">
                                    <?php _e('This image is used when no currency-specific image is available.', 'yoursite'); ?>
                                </p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row"><?php _e('Transition Effect', 'yoursite'); ?></th>
                            <td>
                                <select name="yoursite_currency_backgrounds_transition">
                                    <option value="fade" <?php selected($transition_effect, 'fade'); ?>>
                                        <?php _e('Fade', 'yoursite'); ?>
                                    </option>
                                    <option value="slide" <?php selected($transition_effect, 'slide'); ?>>
                                        <?php _e('Slide', 'yoursite'); ?>
                                    </option>
                                    <option value="zoom" <?php selected($transition_effect, 'zoom'); ?>>
                                        <?php _e('Zoom', 'yoursite'); ?>
                                    </option>
                                    <option value="none" <?php selected($transition_effect, 'none'); ?>>
                                        <?php _e('No Animation', 'yoursite'); ?>
                                    </option>
                                </select>
                                <p class="description">
                                    <?php _e('Animation effect when background changes.', 'yoursite'); ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                    
                    <?php submit_button(__('Save System Settings', 'yoursite')); ?>
                </form>
            </div>
            
            <!-- Currency-Specific Backgrounds -->
            <div class="currency-backgrounds-section">
                <h2><?php _e('Currency-Specific Backgrounds', 'yoursite'); ?></h2>
                
                <?php if (empty($active_currencies)) : ?>
                    <div class="notice notice-warning">
                        <p><?php _e('No active currencies found. Please activate currencies first.', 'yoursite'); ?></p>
                        <a href="<?php echo admin_url('admin.php?page=yoursite-currencies'); ?>" class="button">
                            <?php _e('Manage Currencies', 'yoursite'); ?>
                        </a>
                    </div>
                <?php else : ?>
                    
                    <!-- Add New Background -->
                    <div class="add-background-form">
                        <h3><?php _e('Add Currency Background', 'yoursite'); ?></h3>
                        <div class="background-form">
                            <div class="form-row">
                                <label>
                                    <?php _e('Currency:', 'yoursite'); ?>
                                    <select id="new-currency-select">
                                        <option value=""><?php _e('Select Currency...', 'yoursite'); ?></option>
                                        <?php foreach ($active_currencies as $currency) : ?>
                                            <?php if (!isset($backgrounds_config[$currency['code']])) : ?>
                                                <option value="<?php echo esc_attr($currency['code']); ?>">
                                                    <?php echo $currency['flag']; ?> <?php echo $currency['code']; ?> - <?php echo $currency['name']; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                                
                                <label>
                                    <?php _e('Background Image URL:', 'yoursite'); ?>
                                    <input type="url" id="new-background-url" placeholder="https://example.com/background.jpg" class="regular-text" />
                                    <button type="button" class="button upload-background-btn" data-target="new-background-url">
                                        <?php _e('Upload', 'yoursite'); ?>
                                    </button>
                                </label>
                                
                                <label>
                                    <?php _e('Description (Optional):', 'yoursite'); ?>
                                    <input type="text" id="new-background-description" placeholder="e.g., Indian landscape with traditional elements" class="regular-text" />
                                </label>
                                
                                <button type="button" class="button button-primary" onclick="addCurrencyBackground()">
                                    <?php _e('Add Background', 'yoursite'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Existing Backgrounds -->
                    <div class="existing-backgrounds">
                        <h3><?php _e('Configured Backgrounds', 'yoursite'); ?></h3>
                        
                        <div class="backgrounds-grid" id="backgrounds-grid">
                            <?php if (empty($backgrounds_config)) : ?>
                                <div class="no-backgrounds" id="no-backgrounds-message">
                                    <p><?php _e('No currency backgrounds configured yet.', 'yoursite'); ?></p>
                                    <p><?php _e('Add some backgrounds above to get started!', 'yoursite'); ?></p>
                                </div>
                            <?php else : ?>
                                <?php foreach ($backgrounds_config as $currency_code => $background_data) : ?>
                                    <?php yoursite_render_background_item($currency_code, $background_data, $active_currencies); ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Bulk Actions -->
                    <div class="bulk-actions-section">
                        <h3><?php _e('Bulk Actions', 'yoursite'); ?></h3>
                        <div class="bulk-buttons">
                            <button type="button" class="button" onclick="addDefaultBackgrounds()">
                                <?php _e('Add Default Backgrounds', 'yoursite'); ?>
                            </button>
                            <button type="button" class="button" onclick="exportBackgroundsConfig()">
                                <?php _e('Export Configuration', 'yoursite'); ?>
                            </button>
                            <button type="button" class="button" onclick="importBackgroundsConfig()">
                                <?php _e('Import Configuration', 'yoursite'); ?>
                            </button>
                        </div>
                    </div>
                    
                <?php endif; ?>
            </div>
            
            <!-- Preview Section -->
            <div class="preview-section">
                <h2><?php _e('Preview', 'yoursite'); ?></h2>
                <div class="preview-container">
                    <div class="preview-hero" id="preview-hero">
                        <div class="preview-currency-selector">
                            <select onchange="previewBackgroundChange(this.value)">
                                <option value=""><?php _e('Default Background', 'yoursite'); ?></option>
                                <?php foreach ($active_currencies as $currency) : ?>
                                    <?php if (isset($backgrounds_config[$currency['code']])) : ?>
                                        <option value="<?php echo esc_attr($currency['code']); ?>">
                                            <?php echo $currency['flag']; ?> <?php echo $currency['code']; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="preview-content">
                            <h1><?php _e('Hero Section Preview', 'yoursite'); ?></h1>
                            <p><?php _e('This shows how the background changes with currency selection.', 'yoursite'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- Upload file input for import -->
    <input type="file" id="import-file-input" accept=".json" style="display: none;" onchange="handleImportFile(this)" />
    
    <script>
    jQuery(document).ready(function($) {
        // Initialize media uploader
        $('.upload-background-btn').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var targetInput = button.data('target');
            var customUploader = wp.media({
                title: '<?php _e('Choose Background Image', 'yoursite'); ?>',
                library: { type: 'image' },
                button: { text: '<?php _e('Use this image', 'yoursite'); ?>' },
                multiple: false
            });
            
            customUploader.on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                if (targetInput === 'new-background-url') {
                    $('#new-background-url').val(attachment.url);
                } else {
                    $('[name="' + targetInput + '"]').val(attachment.url);
                    
                    // Update preview if it exists
                    var preview = $('[name="' + targetInput + '"]').siblings('.background-preview');
                    if (preview.length) {
                        preview.find('img').attr('src', attachment.url);
                    } else {
                        $('[name="' + targetInput + '"]').after(
                            '<div class="background-preview" style="margin-top: 10px;">' +
                            '<img src="' + attachment.url + '" style="max-width: 200px; height: auto; border: 1px solid #ddd;" />' +
                            '</div>'
                        );
                    }
                }
            });
            
            customUploader.open();
        });
    });
    
    function addCurrencyBackground() {
        var currency = jQuery('#new-currency-select').val();
        var imageUrl = jQuery('#new-background-url').val();
        var description = jQuery('#new-background-description').val();
        
        if (!currency || !imageUrl) {
            alert('<?php _e('Please select a currency and enter an image URL.', 'yoursite'); ?>');
            return;
        }
        
        // Validate URL
        if (!isValidUrl(imageUrl)) {
            alert('<?php _e('Please enter a valid image URL.', 'yoursite'); ?>');
            return;
        }
        
        // Save via AJAX
        jQuery.post(ajaxurl, {
            action: 'save_currency_background',
            currency: currency,
            image_url: imageUrl,
            description: description,
            nonce: '<?php echo wp_create_nonce('currency_background_nonce'); ?>'
        }).done(function(response) {
            if (response.success) {
                // Add to grid
                addBackgroundToGrid(currency, {
                    image_url: imageUrl,
                    description: description
                });
                
                // Clear form
                jQuery('#new-currency-select').val('');
                jQuery('#new-background-url').val('');
                jQuery('#new-background-description').val('');
                
                // Remove currency from dropdown
                jQuery('#new-currency-select option[value="' + currency + '"]').remove();
                
                // Hide no-backgrounds message
                jQuery('#no-backgrounds-message').hide();
                
                showNotification('Background added successfully!', 'success');
            } else {
                alert('Error: ' + (response.data || 'Unknown error'));
            }
        }).fail(function() {
            alert('<?php _e('Network error occurred', 'yoursite'); ?>');
        });
    }
    
    function addBackgroundToGrid(currency, data) {
        var currencyInfo = getCurrencyInfo(currency);
        var html = `
            <div class="background-item" id="background-${currency}" data-currency="${currency}">
                <div class="background-preview-image">
                    <img src="${data.image_url}" alt="${currency} background" />
                </div>
                <div class="background-info">
                    <div class="currency-header">
                        <span class="currency-flag">${currencyInfo.flag}</span>
                        <strong class="currency-code">${currency}</strong>
                        <span class="currency-name">${currencyInfo.name}</span>
                    </div>
                    <div class="background-description">${data.description || 'No description'}</div>
                    <div class="background-url">
                        <small>${data.image_url}</small>
                    </div>
                </div>
                <div class="background-actions">
                    <button type="button" class="button button-small" onclick="editBackground('${currency}')">
                        <?php _e('Edit', 'yoursite'); ?>
                    </button>
                    <button type="button" class="button button-small" onclick="previewBackground('${currency}')">
                        <?php _e('Preview', 'yoursite'); ?>
                    </button>
                    <button type="button" class="button button-small button-link-delete" onclick="deleteBackground('${currency}')">
                        <?php _e('Delete', 'yoursite'); ?>
                    </button>
                </div>
            </div>
        `;
        
        jQuery('#backgrounds-grid').append(html);
    }
    
    function deleteBackground(currency) {
        if (!confirm('<?php _e('Are you sure you want to delete this background?', 'yoursite'); ?>')) {
            return;
        }
        
        jQuery.post(ajaxurl, {
            action: 'delete_currency_background',
            currency: currency,
            nonce: '<?php echo wp_create_nonce('currency_background_nonce'); ?>'
        }).done(function(response) {
            if (response.success) {
                jQuery('#background-' + currency).fadeOut(function() {
                    jQuery(this).remove();
                    
                    // Add currency back to dropdown
                    var currencyInfo = getCurrencyInfo(currency);
                    jQuery('#new-currency-select').append(
                        '<option value="' + currency + '">' + 
                        currencyInfo.flag + ' ' + currency + ' - ' + currencyInfo.name +
                        '</option>'
                    );
                    
                    // Show no-backgrounds message if grid is empty
                    if (jQuery('#backgrounds-grid .background-item').length === 0) {
                        jQuery('#no-backgrounds-message').show();
                    }
                });
                
                showNotification('Background deleted successfully!', 'success');
            } else {
                alert('Error: ' + (response.data || 'Unknown error'));
            }
        });
    }
    
    function previewBackgroundChange(currency) {
        var heroElement = jQuery('#preview-hero');
        var imageUrl = '';
        
        if (currency) {
            var backgroundItem = jQuery('#background-' + currency);
            if (backgroundItem.length) {
                imageUrl = backgroundItem.find('img').attr('src');
            }
        } else {
            imageUrl = '<?php echo esc_js($default_background); ?>';
        }
        
        if (imageUrl) {
            heroElement.css('background-image', 'url(' + imageUrl + ')');
        }
    }
    
    function addDefaultBackgrounds() {
        var defaultBackgrounds = {
            'USD': {
                image_url: 'https://images.unsplash.com/photo-1485081669829-bacb8c7bb1f3?w=1920&h=1080&fit=crop',
                description: 'American city skyline with modern buildings'
            },
            'EUR': {
                image_url: 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=1920&h=1080&fit=crop',
                description: 'European architecture and canals'
            },
            'INR': {
                image_url: 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=1920&h=1080&fit=crop',
                description: 'Indian palace and traditional architecture'
            }
        };
        
        Object.keys(defaultBackgrounds).forEach(function(currency) {
            var data = defaultBackgrounds[currency];
            
            jQuery.post(ajaxurl, {
                action: 'save_currency_background',
                currency: currency,
                image_url: data.image_url,
                description: data.description,
                nonce: '<?php echo wp_create_nonce('currency_background_nonce'); ?>'
            }).done(function(response) {
                if (response.success) {
                    addBackgroundToGrid(currency, data);
                    jQuery('#new-currency-select option[value="' + currency + '"]').remove();
                    jQuery('#no-backgrounds-message').hide();
                }
            });
        });
        
        showNotification('Default backgrounds added!', 'success');
    }
    
    function exportBackgroundsConfig() {
        jQuery.post(ajaxurl, {
            action: 'get_currency_backgrounds',
            export: true,
            nonce: '<?php echo wp_create_nonce('currency_background_nonce'); ?>'
        }).done(function(response) {
            if (response.success) {
                var dataStr = JSON.stringify(response.data, null, 2);
                var dataBlob = new Blob([dataStr], {type: 'application/json'});
                var url = URL.createObjectURL(dataBlob);
                var link = document.createElement('a');
                link.href = url;
                link.download = 'currency-backgrounds-' + new Date().toISOString().slice(0,10) + '.json';
                link.click();
                URL.revokeObjectURL(url);
            }
        });
    }
    
    function importBackgroundsConfig() {
        jQuery('#import-file-input').click();
    }
    
    function handleImportFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                try {
                    var config = JSON.parse(e.target.result);
                    // Process import...
                    alert('Import functionality would be implemented here');
                } catch (error) {
                    alert('<?php _e('Invalid file format', 'yoursite'); ?>');
                }
            };
            reader.readAsText(input.files[0]);
        }
    }
    
    // Utility functions
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
    
    function getCurrencyInfo(currency) {
        var currencies = <?php echo json_encode($active_currencies); ?>;
        for (var i = 0; i < currencies.length; i++) {
            if (currencies[i].code === currency) {
                return currencies[i];
            }
        }
        return {flag: '', name: currency};
    }
    
    function showNotification(message, type) {
        var notification = jQuery('<div class="notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
        jQuery('.wrap h1').after(notification);
        setTimeout(function() {
            notification.fadeOut();
        }, 3000);
    }
    </script>
    
    <style>
    .currency-backgrounds-admin {
        max-width: 1200px;
    }
    
    .settings-section,
    .currency-backgrounds-section,
    .preview-section {
        background: #fff;
        margin: 20px 0;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    
    .settings-section h2,
    .currency-backgrounds-section h2,
    .preview-section h2 {
        margin-top: 0;
        color: #333;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    
    .add-background-form {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 6px;
        margin-bottom: 30px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr auto;
        gap: 15px;
        align-items: end;
    }
    
    .form-row label {
        display: flex;
        flex-direction: column;
        font-weight: 600;
    }
    
    .form-row input,
    .form-row select {
        margin-top: 5px;
        padding: 8px;
    }
    
    .backgrounds-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .background-item {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }
    
    .background-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .background-preview-image {
        height: 150px;
        overflow: hidden;
    }
    
    .background-preview-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .background-info {
        padding: 15px;
    }
    
    .currency-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }
    
    .currency-flag {
        font-size: 18px;
    }
    
    .currency-code {
        color: #0073aa;
    }
    
    .currency-name {
        color: #666;
        font-size: 14px;
    }
    
    .background-description {
        margin-bottom: 10px;
        color: #333;
    }
    
    .background-url {
        color: #666;
        font-size: 12px;
        word-break: break-all;
    }
    
    .background-actions {
        padding: 15px;
        border-top: 1px solid #eee;
        display: flex;
        gap: 8px;
    }
    
    .bulk-actions-section {
        background: #f0f6fc;
        padding: 20px;
        border-radius: 6px;
        margin-top: 30px;
    }
    
    .bulk-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .preview-container {
        margin-top: 20px;
    }
    
    .preview-hero {
        height: 300px;
        background: url('<?php echo esc_url($default_background ?: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&h=1080&fit=crop'); ?>') center/cover;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        border-radius: 8px;
        position: relative;
        transition: background-image 0.5s ease;
    }
    
    .preview-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
        border-radius: 8px;
    }
    
    .preview-currency-selector {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 2;
    }
    
    .preview-currency-selector select {
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        background: rgba(255,255,255,0.9);
    }
    
    .preview-content {
        z-index: 2;
        position: relative;
    }
    
    .preview-content h1 {
        margin: 0 0 10px 0;
        font-size: 2.5em;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    
    .preview-content p {
        margin: 0;
        font-size: 1.2em;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    
    .no-backgrounds {
        text-align: center;
        padding: 40px;
        color: #666;
    }
    
    .default-background-selector {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .background-preview {
        margin-top: 10px;
    }
    
    .background-preview img {
        max-width: 200px;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .backgrounds-grid {
            grid-template-columns: 1fr;
        }
        
        .bulk-buttons {
            flex-direction: column;
        }
        
        .default-background-selector {
            flex-direction: column;
            align-items: stretch;
        }
    }
    </style>
    <?php
}

/**
 * Render individual background item
 */
function yoursite_render_background_item($currency_code, $background_data, $active_currencies) {
    $currency_info = null;
    foreach ($active_currencies as $currency) {
        if ($currency['code'] === $currency_code) {
            $currency_info = $currency;
            break;
        }
    }
    
    if (!$currency_info) {
        return; // Currency not found in active currencies
    }
    ?>
    <div class="background-item" id="background-<?php echo esc_attr($currency_code); ?>" data-currency="<?php echo esc_attr($currency_code); ?>">
        <div class="background-preview-image">
            <img src="<?php echo esc_url($background_data['image_url']); ?>" alt="<?php echo esc_attr($currency_code); ?> background" />
        </div>
        <div class="background-info">
            <div class="currency-header">
                <span class="currency-flag"><?php echo esc_html($currency_info['flag']); ?></span>
                <strong class="currency-code"><?php echo esc_html($currency_code); ?></strong>
                <span class="currency-name"><?php echo esc_html($currency_info['name']); ?></span>
            </div>
            <div class="background-description">
                <?php echo esc_html($background_data['description'] ?: __('No description', 'yoursite')); ?>
            </div>
            <div class="background-url">
                <small><?php echo esc_html($background_data['image_url']); ?></small>
            </div>
        </div>
        <div class="background-actions">
            <button type="button" class="button button-small" onclick="editBackground('<?php echo esc_js($currency_code); ?>')">
                <?php _e('Edit', 'yoursite'); ?>
            </button>
            <button type="button" class="button button-small" onclick="previewBackground('<?php echo esc_js($currency_code); ?>')">
                <?php _e('Preview', 'yoursite'); ?>
            </button>
            <button type="button" class="button button-small button-link-delete" onclick="deleteBackground('<?php echo esc_js($currency_code); ?>')">
                <?php _e('Delete', 'yoursite'); ?>
            </button>
        </div>
    </div>
    <?php
}

/**
 * AJAX: Save currency background
 */
function yoursite_ajax_save_currency_background() {
    check_ajax_referer('currency_background_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency = sanitize_text_field($_POST['currency'] ?? '');
    $image_url = esc_url_raw($_POST['image_url'] ?? '');
    $description = sanitize_text_field($_POST['description'] ?? '');
    
    if (empty($currency) || empty($image_url)) {
        wp_send_json_error(__('Currency and image URL are required', 'yoursite'));
    }
    
    // Validate currency exists and is active
    $currency_obj = yoursite_get_currency($currency);
    if (!$currency_obj || $currency_obj['status'] !== 'active') {
        wp_send_json_error(__('Invalid or inactive currency', 'yoursite'));
    }
    
    // Get current config
    $backgrounds_config = get_option('yoursite_currency_backgrounds_config', array());
    
    // Add/update background
    $backgrounds_config[$currency] = array(
        'image_url' => $image_url,
        'description' => $description,
        'created_at' => current_time('mysql'),
        'updated_at' => current_time('mysql')
    );
    
    // Save config
    $saved = update_option('yoursite_currency_backgrounds_config', $backgrounds_config);
    
    if ($saved) {
        wp_send_json_success(array(
            'message' => __('Background saved successfully', 'yoursite'),
            'currency' => $currency,
            'config' => $backgrounds_config[$currency]
        ));
    } else {
        wp_send_json_error(__('Failed to save background', 'yoursite'));
    }
}

/**
 * AJAX: Delete currency background
 */
function yoursite_ajax_delete_currency_background() {
    check_ajax_referer('currency_background_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(__('Insufficient permissions', 'yoursite'));
    }
    
    $currency = sanitize_text_field($_POST['currency'] ?? '');
    
    if (empty($currency)) {
        wp_send_json_error(__('Currency is required', 'yoursite'));
    }
    
    // Get current config
    $backgrounds_config = get_option('yoursite_currency_backgrounds_config', array());
    
    // Remove background
    if (isset($backgrounds_config[$currency])) {
        unset($backgrounds_config[$currency]);
        
        // Save config
        $saved = update_option('yoursite_currency_backgrounds_config', $backgrounds_config);
        
        if ($saved) {
            wp_send_json_success(array(
                'message' => __('Background deleted successfully', 'yoursite'),
                'currency' => $currency
            ));
        } else {
            wp_send_json_error(__('Failed to delete background', 'yoursite'));
        }
    } else {
        wp_send_json_error(__('Background not found', 'yoursite'));
    }
}

/**
 * AJAX: Get currency backgrounds configuration
 */
function yoursite_ajax_get_currency_backgrounds() {
    // Verify nonce if coming from admin
    if (is_admin() && !wp_verify_nonce($_POST['nonce'] ?? '', 'currency_background_nonce')) {
        wp_send_json_error(__('Security check failed', 'yoursite'));
    }
    
    $backgrounds_config = get_option('yoursite_currency_backgrounds_config', array());
    $default_background = get_option('yoursite_currency_backgrounds_default', '');
    $system_enabled = get_option('yoursite_currency_backgrounds_enabled', true);
    $transition_effect = get_option('yoursite_currency_backgrounds_transition', 'fade');
    
    wp_send_json_success(array(
        'backgrounds' => $backgrounds_config,
        'default_background' => $default_background,
        'system_enabled' => $system_enabled,
        'transition_effect' => $transition_effect
    ));
}

/**
 * Enqueue frontend scripts for dynamic backgrounds
 */
function yoursite_currency_backgrounds_enqueue_scripts() {
    // Only load on pages where needed
    if (!yoursite_should_load_currency_backgrounds()) {
        return;
    }
    
    wp_enqueue_script(
        'yoursite-currency-backgrounds',
        get_template_directory_uri() . '/assets/js/currency-backgrounds.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Get configuration
    $backgrounds_config = get_option('yoursite_currency_backgrounds_config', array());
    $default_background = get_option('yoursite_currency_backgrounds_default', '');
    $system_enabled = get_option('yoursite_currency_backgrounds_enabled', true);
    $transition_effect = get_option('yoursite_currency_backgrounds_transition', 'fade');
    
    // Localize script with configuration
    wp_localize_script('yoursite-currency-backgrounds', 'CurrencyBackgrounds', array(
        'enabled' => $system_enabled,
        'backgrounds' => $backgrounds_config,
        'defaultBackground' => $default_background,
        'transitionEffect' => $transition_effect,
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'debug' => WP_DEBUG
    ));
    
    // Add inline CSS for transitions
    wp_add_inline_style('wp-block-library', yoursite_get_currency_backgrounds_css());
}

/**
 * Check if currency backgrounds should be loaded
 */
function yoursite_should_load_currency_backgrounds() {
    // Don't load in admin
    if (is_admin()) {
        return false;
    }
    
    // Check if system is enabled
    if (!get_option('yoursite_currency_backgrounds_enabled', true)) {
        return false;
    }
    
    // Load on homepage, or pages with hero sections
    if (is_front_page() || is_home()) {
        return true;
    }
    
    // Load on pages with currency-hero class or data attribute
    global $post;
    if ($post && (
        has_shortcode($post->post_content, 'currency_hero') ||
        strpos($post->post_content, 'currency-hero') !== false ||
        strpos($post->post_content, 'data-currency-background') !== false
    )) {
        return true;
    }
    
    // Allow filtering
    return apply_filters('yoursite_load_currency_backgrounds', false);
}

/**
 * Get CSS for currency background transitions
 */
function yoursite_get_currency_backgrounds_css() {
    $transition_effect = get_option('yoursite_currency_backgrounds_transition', 'fade');
    
    $css = '
    /* Currency Dynamic Backgrounds */
    .currency-hero,
    .hero-section,
    [data-currency-background] {
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
    }
    
    .currency-hero::before,
    .hero-section::before,
    [data-currency-background]::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: inherit;
        z-index: -1;
    }
    ';
    
    switch ($transition_effect) {
        case 'fade':
            $css .= '
            .currency-hero,
            .hero-section,
            [data-currency-background] {
                transition: background-image 0.6s ease-in-out;
            }
            
            .currency-hero.changing,
            .hero-section.changing,
            [data-currency-background].changing {
                opacity: 0.8;
                transition: opacity 0.3s ease, background-image 0.6s ease-in-out;
            }
            ';
            break;
            
        case 'slide':
            $css .= '
            .currency-hero,
            .hero-section,
            [data-currency-background] {
                background-attachment: fixed;
                transition: background-position 0.8s ease-in-out, background-image 0.4s ease;
            }
            
            .currency-hero.changing,
            .hero-section.changing,
            [data-currency-background].changing {
                background-position: -100px center;
            }
            ';
            break;
            
        case 'zoom':
            $css .= '
            .currency-hero,
            .hero-section,
            [data-currency-background] {
                transition: transform 0.6s ease, background-image 0.4s ease;
            }
            
            .currency-hero.changing,
            .hero-section.changing,
            [data-currency-background].changing {
                transform: scale(1.05);
            }
            ';
            break;
            
        case 'none':
        default:
            // No animation
            break;
    }
    
    $css .= '
    
    /* Loading state */
    .currency-hero.loading,
    .hero-section.loading,
    [data-currency-background].loading {
        opacity: 0.7;
    }
    
    .currency-hero.loading::after,
    .hero-section.loading::after,
    [data-currency-background].loading::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin: -20px 0 0 -20px;
        border: 3px solid rgba(255,255,255,0.3);
        border-top-color: rgba(255,255,255,0.8);
        border-radius: 50%;
        animation: currencyBackgroundSpin 1s linear infinite;
        z-index: 10;
    }
    
    @keyframes currencyBackgroundSpin {
        to { transform: rotate(360deg); }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .currency-hero,
        .hero-section,
        [data-currency-background] {
            background-attachment: scroll;
        }
    }
    
    /* High contrast mode */
    @media (prefers-contrast: high) {
        .currency-hero::before,
        .hero-section::before,
        [data-currency-background]::before {
            background: rgba(0,0,0,0.6);
        }
    }
    
    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .currency-hero,
        .hero-section,
        [data-currency-background],
        .currency-hero.changing,
        .hero-section.changing,
        [data-currency-background].changing {
            transition: none !important;
            animation: none !important;
            transform: none !important;
        }
    }
    ';
    
    return $css;
}

/**
 * Generate default currency backgrounds configuration
 */
function yoursite_get_default_currency_backgrounds() {
    return array(
        'USD' => array(
            'image_url' => 'https://images.unsplash.com/photo-1485081669829-bacb8c7bb1f3?w=1920&h=1080&fit=crop&q=80',
            'description' => 'American city skyline with modern skyscrapers and urban landscape',
            'alt_text' => 'US Dollar background - American cityscape'
        ),
        'EUR' => array(
            'image_url' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=1920&h=1080&fit=crop&q=80',
            'description' => 'European canal scene with traditional architecture and bridges',
            'alt_text' => 'Euro background - European canal and architecture'
        ),
        'INR' => array(
            'image_url' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=1920&h=1080&fit=crop&q=80',
            'description' => 'Indian palace architecture with intricate details and cultural elements',
            'alt_text' => 'Indian Rupee background - Traditional Indian palace'
        ),
        'GBP' => array(
            'image_url' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=1920&h=1080&fit=crop&q=80',
            'description' => 'London cityscape with Big Ben and Thames river',
            'alt_text' => 'British Pound background - London landmarks'
        ),
        'JPY' => array(
            'image_url' => 'https://images.unsplash.com/photo-1545569341-9eb8b30979d9?w=1920&h=1080&fit=crop&q=80',
            'description' => 'Japanese temple with cherry blossoms and traditional architecture',
            'alt_text' => 'Japanese Yen background - Traditional Japanese temple'
        ),
        'CAD' => array(
            'image_url' => 'https://images.unsplash.com/photo-1503614472-8c93d56cd665?w=1920&h=1080&fit=crop&q=80',
            'description' => 'Canadian mountain landscape with pristine lakes and forests',
            'alt_text' => 'Canadian Dollar background - Mountain and lake scenery'
        ),
        'AUD' => array(
            'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&h=1080&fit=crop&q=80',
            'description' => 'Australian beach coastline with golden sand and ocean waves',
            'alt_text' => 'Australian Dollar background - Coastal beach scene'
        ),
        'CHF' => array(
            'image_url' => 'https://images.unsplash.com/photo-1527404239307-a34bcd6b9ddc?w=1920&h=1080&fit=crop&q=80',
            'description' => 'Swiss Alps mountain peaks with snow and alpine landscape',
            'alt_text' => 'Swiss Franc background - Alpine mountain scenery'
        )
    );
}

/**
 * Helper function to get current user's currency safely
 */
function yoursite_get_user_currency_safe() {
    if (function_exists('yoursite_get_user_currency')) {
        return yoursite_get_user_currency();
    }
    
    // Fallback
    return array(
        'code' => 'USD',
        'name' => 'US Dollar',
        'symbol' => ',
        'flag' => '🇺🇸'
    );
}

/**
 * Shortcode for currency hero section
 */
function yoursite_currency_hero_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'class' => '',
        'height' => '500px',
        'overlay' => 'true',
        'overlay_color' => 'rgba(0,0,0,0.4)',
        'text_color' => '#ffffff',
        'text_align' => 'center',
        'enable_backgrounds' => 'true'
    ), $atts, 'currency_hero');
    
    $current_currency = yoursite_get_user_currency_safe();
    $backgrounds_config = get_option('yoursite_currency_backgrounds_config', array());
    $default_background = get_option('yoursite_currency_backgrounds_default', '');
    
    // Determine background image
    $background_image = '';
    if ($atts['enable_backgrounds'] === 'true' && isset($backgrounds_config[$current_currency['code']])) {
        $background_image = $backgrounds_config[$current_currency['code']]['image_url'];
    } elseif ($default_background) {
        $background_image = $default_background;
    }
    
    $style = '';
    if ($background_image) {
        $style .= "background-image: url('" . esc_url($background_image) . "');";
    }
    if ($atts['height']) {
        $style .= "height: " . esc_attr($atts['height']) . ";";
    }
    if ($atts['text_color']) {
        $style .= "color: " . esc_attr($atts['text_color']) . ";";
    }
    if ($atts['text_align']) {
        $style .= "text-align: " . esc_attr($atts['text_align']) . ";";
    }
    
    $overlay_style = '';
    if ($atts['overlay'] === 'true' && $atts['overlay_color']) {
        $overlay_style = "background: " . esc_attr($atts['overlay_color']) . ";";
    }
    
    ob_start();
    ?>
    <div class="currency-hero <?php echo esc_attr($atts['class']); ?>" 
         data-currency-background="true"
         data-current-currency="<?php echo esc_attr($current_currency['code']); ?>"
         style="<?php echo $style; ?>">
        
        <?php if ($atts['overlay'] === 'true') : ?>
            <div class="hero-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; <?php echo $overlay_style; ?>"></div>
        <?php endif; ?>
        
        <div class="hero-content" style="position: relative; z-index: 2; padding: 2em;">
            <?php echo do_shortcode($content); ?>
        </div>
    </div>
    <?php
    
    return ob_get_clean();
}
add_shortcode('currency_hero', 'yoursite_currency_hero_shortcode');

/**
 * Add meta box for currency backgrounds on pages/posts
 */
function yoursite_add_currency_background_meta_box() {
    add_meta_box(
        'currency_background_settings',
        __('Currency Background Settings', 'yoursite'),
        'yoursite_currency_background_meta_box_callback',
        array('page', 'post'),
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'yoursite_add_currency_background_meta_box');

/**
 * Currency background meta box callback
 */
function yoursite_currency_background_meta_box_callback($post) {
    wp_nonce_field('currency_background_meta_box', 'currency_background_meta_box_nonce');
    
    $enable_backgrounds = get_post_meta($post->ID, '_enable_currency_backgrounds', true);
    $custom_selector = get_post_meta($post->ID, '_currency_background_selector', true);
    
    ?>
    <div class="currency-background-meta-box">
        <p>
            <label>
                <input type="checkbox" name="enable_currency_backgrounds" value="1" 
                       <?php checked($enable_backgrounds, 1); ?> />
                <?php _e('Enable currency backgrounds on this page', 'yoursite'); ?>
            </label>
        </p>
        
        <p>
            <label for="currency_background_selector">
                <?php _e('CSS Selector for hero element:', 'yoursite'); ?>
            </label>
            <input type="text" name="currency_background_selector" 
                   id="currency_background_selector"
                   value="<?php echo esc_attr($custom_selector ?: '.hero-section, .currency-hero'); ?>"
                   class="widefat"
                   placeholder=".hero-section, .currency-hero" />
            <small class="description">
                <?php _e('CSS selector for the element that should have dynamic backgrounds.', 'yoursite'); ?>
            </small>
        </p>
    </div>
    <?php
}

/**
 * Save currency background meta box data
 */
function yoursite_save_currency_background_meta_box($post_id) {
    if (!isset($_POST['currency_background_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['currency_background_meta_box_nonce'], 'currency_background_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $enable_backgrounds = isset($_POST['enable_currency_backgrounds']) ? 1 : 0;
    $custom_selector = sanitize_text_field($_POST['currency_background_selector'] ?? '');
    
    update_post_meta($post_id, '_enable_currency_backgrounds', $enable_backgrounds);
    update_post_meta($post_id, '_currency_background_selector', $custom_selector);
}
add_action('save_post', 'yoursite_save_currency_background_meta_box');

/**
 * Initialize the system
 */
yoursite_init_currency_backgrounds();