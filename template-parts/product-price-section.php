<?php
/**
 * WordPress Partial: Product Price Section
 * 
 * Usage: Include this in your theme files or create as a template part
 * File: template-parts/product-price-section.php
 * 
 * To use: get_template_part('template-parts/product-price-section');
 */

// Get product ID from various sources
$product_id = '';
if (isset($_GET['product_id'])) {
    $product_id = sanitize_text_field($_GET['product_id']);
} elseif (is_singular('product')) {
    $product_id = get_post_meta(get_the_ID(), 'upmind_product_id', true);
} elseif (isset($args['product_id'])) {
    $product_id = $args['product_id'];
}

// Default product ID if none found
if (empty($product_id)) {
    $product_id = get_option('default_product_id', '');
}
?>

<section class="product-price-section" id="product-pricing">
    <div class="container">
        <div class="price-header">
            <h2><?php _e('Product Pricing', 'textdomain'); ?></h2>
            <p><?php _e('Choose the billing cycle that works best for you', 'textdomain'); ?></p>
        </div>

        <!-- Price Loading State -->
        <div class="price-loading" id="price-loading">
            <div class="loading-spinner"></div>
            <p><?php _e('Loading pricing information...', 'textdomain'); ?></p>
        </div>

        <!-- Price Error State -->
        <div class="price-error" id="price-error" style="display: none;">
            <p><?php _e('Unable to load pricing. Please try again later.', 'textdomain'); ?></p>
        </div>

        <!-- Price Display Container -->
        <div class="price-grid" id="price-grid" style="display: none;">
            <!-- Prices will be loaded here via JavaScript -->
        </div>

        <!-- Manual Price Check Form (Admin/Testing) -->
        <?php if (current_user_can('manage_options')): ?>
        <div class="price-admin-controls">
            <h3><?php _e('Admin: Manual Price Check', 'textdomain'); ?></h3>
            
            <!-- Debug Information -->
            <div class="debug-info" style="background: #f1f1f1; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <h4>Debug Information:</h4>
                <p><strong>API Key:</strong> <?php echo get_option('upmind_api_key') ? 'Set (' . strlen(get_option('upmind_api_key')) . ' characters)' : 'Not set'; ?></p>
                <p><strong>Default Product ID:</strong> <?php echo get_option('default_product_id') ?: 'Not set'; ?></p>
                <p><strong>Current Product ID:</strong> <?php echo esc_html($product_id) ?: 'Not detected'; ?></p>
                <p><strong>API Endpoint:</strong> https://api.upmind.io/api/admin/products/[PRODUCT_ID]/pricelists</p>
            </div>
            
            <form id="manual-price-check">
                <div class="form-row">
                    <div class="form-group">
                        <label for="admin-product-id"><?php _e('Product ID:', 'textdomain'); ?></label>
                        <input type="text" id="admin-product-id" value="<?php echo esc_attr($product_id); ?>" required placeholder="e.g. 27831d63-50d8-2496-162f-d49e176259e0">
                    </div>
                    <div class="form-group">
                        <label for="admin-pricelist-id"><?php _e('Pricelist ID (optional):', 'textdomain'); ?></label>
                        <input type="text" id="admin-pricelist-id" placeholder="<?php _e('Leave empty for all pricelists', 'textdomain'); ?>">
                    </div>
                </div>
                <button type="submit"><?php _e('Check Prices', 'textdomain'); ?></button>
                <button type="button" id="test-api-connection"><?php _e('Test API Connection', 'textdomain'); ?></button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.product-price-section {
    padding: 60px 0;
    background: #f8f9fa;
}

.product-price-section .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.price-header {
    text-align: center;
    margin-bottom: 40px;
}

.price-header h2 {
    font-size: 2.5em;
    margin-bottom: 15px;
    color: #2c3e50;
}

.price-header p {
    font-size: 1.1em;
    color: #7f8c8d;
}

.price-loading {
    text-align: center;
    padding: 40px;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.price-error {
    background: #fee;
    color: #c33;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #fcc;
}

.price-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.price-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.price-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.price-card.popular {
    border: 2px solid #3498db;
}

.price-card.popular::before {
    content: "Most Popular";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background: #3498db;
    color: white;
    padding: 8px;
    font-size: 0.9em;
    font-weight: bold;
}

.price-card.popular .price-card-body {
    padding-top: 20px;
}

.billing-cycle {
    font-size: 1.2em;
    color: #7f8c8d;
    margin-bottom: 15px;
    font-weight: 600;
}

.price-amount {
    font-size: 3em;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 10px;
}

.price-period {
    color: #95a5a6;
    font-size: 0.9em;
}

.price-details {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #ecf0f1;
}

.price-meta {
    font-size: 0.9em;
    color: #7f8c8d;
    margin-top: 15px;
}

.price-admin-controls {
    margin-top: 60px;
    padding: 30px;
    background: #fff;
    border-radius: 8px;
    border: 2px dashed #ddd;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #2c3e50;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.form-group button {
    background: #3498db;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s;
}

.form-group button:hover {
    background: #2980b9;
}

@media (max-width: 768px) {
    .price-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .price-header h2 {
        font-size: 2em;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    const config = {
        apiKey: '<?php echo esc_js(get_option('upmind_api_key', '')); ?>',
        productId: '<?php echo esc_js($product_id); ?>',
        baseUrl: 'https://api.upmind.io/api/admin'
    };

    // Initialize price checker
    const priceChecker = new UpmindPriceChecker(config.apiKey);

    // DOM elements
    const loadingEl = document.getElementById('price-loading');
    const errorEl = document.getElementById('price-error');
    const gridEl = document.getElementById('price-grid');
    const adminForm = document.getElementById('manual-price-check');

    // Load prices on page load
    if (config.productId) {
        loadProductPrices(config.productId);
    } else {
        showError('<?php _e('No product ID specified', 'textdomain'); ?>');
    }

    // Admin form handler
    if (adminForm) {
        adminForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const productId = document.getElementById('admin-product-id').value.trim();
            const pricelistId = document.getElementById('admin-pricelist-id').value.trim() || null;
            
            if (productId) {
                loadProductPrices(productId, pricelistId);
            }
        });
        
        // Test API connection button
        const testButton = document.getElementById('test-api-connection');
        if (testButton) {
            testButton.addEventListener('click', async function() {
                console.log('Testing API connection...');
                console.log('API Key:', config.apiKey ? 'Present' : 'Missing');
                console.log('Base URL:', config.baseUrl);
                
                try {
                    const testUrl = `${config.baseUrl}/products`;
                    console.log('Test URL:', testUrl);
                    
                    const response = await fetch(testUrl, {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${config.apiKey}`,
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    console.log('Test response status:', response.status);
                    
                    if (response.ok) {
                        alert('API connection successful!');
                    } else {
                        const errorText = await response.text();
                        console.log('Test error:', errorText);
                        alert(`API connection failed: ${response.status} ${response.statusText}`);
                    }
                } catch (error) {
                    console.error('Test connection error:', error);
                    alert(`Connection test failed: ${error.message}`);
                }
            });
        }
    }

    async function loadProductPrices(productId, pricelistId = null) {
        showLoading();
        
        try {
            console.log('Loading prices for product:', productId);
            console.log('API Key available:', config.apiKey ? 'Yes' : 'No');
            console.log('API Key length:', config.apiKey ? config.apiKey.length : 0);
            
            const prices = await priceChecker.getProductPrices(productId, pricelistId);
            console.log('API Response:', prices);
            displayPrices(prices.data);
        } catch (error) {
            console.error('Detailed error:', error);
            console.error('Error message:', error.message);
            console.error('Error stack:', error.stack);
            
            // Show more specific error message
            let errorMessage = '<?php _e('Failed to load pricing information', 'textdomain'); ?>';
            if (error.message.includes('401')) {
                errorMessage = '<?php _e('Authentication failed. Please check your API key.', 'textdomain'); ?>';
            } else if (error.message.includes('404')) {
                errorMessage = '<?php _e('Product not found. Please check the product ID.', 'textdomain'); ?>';
            } else if (error.message.includes('403')) {
                errorMessage = '<?php _e('Access denied. Please check your permissions.', 'textdomain'); ?>';
            } else if (error.message.includes('CORS')) {
                errorMessage = '<?php _e('CORS error. API calls may be blocked by browser.', 'textdomain'); ?>';
            }
            
            showError(errorMessage + ' (Check console for details)');
        }
    }

    function displayPrices(prices) {
        hideLoading();
        
        if (!prices || prices.length === 0) {
            showError('<?php _e('No pricing information available', 'textdomain'); ?>');
            return;
        }

        // Sort prices by billing cycle
        prices.sort((a, b) => a.billing_cycle_months - b.billing_cycle_months);

        const html = prices.map((price, index) => {
            const isPopular = index === 1 && prices.length > 2; // Mark second option as popular
            
            return `
                <div class="price-card ${isPopular ? 'popular' : ''}">
                    <div class="price-card-body">
                        <div class="billing-cycle">${formatBillingCycle(price.billing_cycle_months)}</div>
                        <div class="price-amount">${price.price_formatted}</div>
                        <div class="price-period">${formatPeriod(price.billing_cycle_months)}</div>
                        <div class="price-details">
                            <div class="price-meta">
                                ${price.own_price ? '<?php _e('Direct Price', 'textdomain'); ?>' : '<?php _e('Inherited Price', 'textdomain'); ?>'}
                            </div>
                            ${price.from_datetime ? `<div class="price-meta"><?php _e('Valid from:', 'textdomain'); ?> ${formatDate(price.from_datetime)}</div>` : ''}
                            ${price.to_datetime ? `<div class="price-meta"><?php _e('Valid until:', 'textdomain'); ?> ${formatDate(price.to_datetime)}</div>` : ''}
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        gridEl.innerHTML = html;
        gridEl.style.display = 'grid';
    }

    function formatBillingCycle(months) {
        if (months === 1) return '<?php _e('Monthly', 'textdomain'); ?>';
        if (months === 3) return '<?php _e('Quarterly', 'textdomain'); ?>';
        if (months === 6) return '<?php _e('Semi-Annual', 'textdomain'); ?>';
        if (months === 12) return '<?php _e('Annual', 'textdomain'); ?>';
        return `${months} <?php _e('Months', 'textdomain'); ?>`;
    }

    function formatPeriod(months) {
        if (months === 1) return '<?php _e('per month', 'textdomain'); ?>';
        if (months === 12) return '<?php _e('per year', 'textdomain'); ?>';
        return `<?php _e('per', 'textdomain'); ?> ${months} <?php _e('months', 'textdomain'); ?>`;
    }

    function formatDate(timestamp) {
        return new Date(timestamp * 1000).toLocaleDateString();
    }

    function showLoading() {
        loadingEl.style.display = 'block';
        errorEl.style.display = 'none';
        gridEl.style.display = 'none';
    }

    function hideLoading() {
        loadingEl.style.display = 'none';
    }

    function showError(message) {
        hideLoading();
        errorEl.querySelector('p').textContent = message;
        errorEl.style.display = 'block';
        gridEl.style.display = 'none';
    }
});

// Include the UpmindPriceChecker class here or load it from external file
class UpmindPriceChecker {
    constructor(apiKey) {
        this.apiKey = apiKey;
        this.baseUrl = 'https://api.upmind.io/api/admin';
    }

    async getProductPrices(productId, pricelistId = null) {
        try {
            // Validate product ID (can be integer or UUID string)
            if (!productId || (typeof productId !== 'string' && !Number.isInteger(productId))) {
                throw new Error('Product ID is required and must be a string or integer');
            }

            // Validate API key
            if (!this.apiKey || this.apiKey.trim() === '') {
                throw new Error('API key is required');
            }

            let url = `${this.baseUrl}/products/${productId}/pricelists`;
            if (pricelistId) {
                url += `?pricelist_id=${pricelistId}`;
            }

            console.log('Making request to:', url);
            console.log('With headers:', {
                'Authorization': `Bearer ${this.apiKey.substring(0, 20)}...`,
                'Content-Type': 'application/json'
            });

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${this.apiKey}`,
                    'Content-Type': 'application/json'
                }
            });

            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            if (!response.ok) {
                const errorText = await response.text();
                console.log('Error response body:', errorText);
                throw new Error(`API request failed: ${response.status} ${response.statusText} - ${errorText}`);
            }

            const data = await response.json();
            console.log('Success response:', data);
            return data;

        } catch (error) {
            console.error('Error fetching product prices:', error);
            throw error;
        }
    }
}
</script>

<?php
/**
 * Add WordPress admin options for API configuration
 * Add this to your theme's functions.php or create a plugin
 */
function upmind_price_admin_menu() {
    add_options_page(
        'Upmind Price Settings',
        'Upmind Pricing',
        'manage_options',
        'upmind-pricing',
        'upmind_price_admin_page'
    );
}
add_action('admin_menu', 'upmind_price_admin_menu');

function upmind_price_admin_page() {
    if (isset($_POST['submit'])) {
        update_option('upmind_api_key', sanitize_text_field($_POST['upmind_api_key']));
        update_option('default_product_id', sanitize_text_field($_POST['default_product_id']));
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }

    $api_key = get_option('upmind_api_key', '');
    $default_product_id = get_option('default_product_id', '');
    ?>
    <div class="wrap">
        <h1>Upmind Price Settings</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">API Key</th>
                    <td><input type="text" name="upmind_api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row">Default Product ID</th>
                    <td>
                        <input type="text" name="default_product_id" value="<?php echo esc_attr($default_product_id); ?>" class="regular-text" placeholder="e.g. 27831d63-50d8-2496-162f-d49e176259e0" />
                        <p class="description">Enter the Upmind product ID (UUID format)</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>