<?php
/**
 * Domain System - Main Plugin File
 * 
 * A comprehensive WordPress domain management system
 * 
 * @package DomainSystem
 * @version 2.0.0
 * @author Your Name
 * @since 1.0.0
 * 
 * Plugin Name: Domain System
 * Plugin URI: https://yoursite.com/domain-system
 * Description: Complete domain management system for WordPress with landing pages, pricing, and administration tools.
 * Version: 2.0.0
 * Author: Your Name
 * Author URI: https://yoursite.com
 * Text Domain: domain-system
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

// Define plugin constants
define('DOMAIN_SYSTEM_VERSION', '2.0.0');
define('DOMAIN_SYSTEM_PLUGIN_FILE', __FILE__);
define('DOMAIN_SYSTEM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DOMAIN_SYSTEM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DOMAIN_SYSTEM_INCLUDES_DIR', DOMAIN_SYSTEM_PLUGIN_DIR . 'includes/');
define('DOMAIN_SYSTEM_TEMPLATES_DIR', DOMAIN_SYSTEM_PLUGIN_DIR . 'templates/');
define('DOMAIN_SYSTEM_ASSETS_URL', DOMAIN_SYSTEM_PLUGIN_URL . 'assets/');

/**
 * Main Domain System Class
 */
class DomainSystem {
    
    const VERSION = DOMAIN_SYSTEM_VERSION;
    const MIN_PHP_VERSION = '7.4';
    const MIN_WP_VERSION = '5.0';
    
    private static $instance = null;
    private $components = [];
    
    /**
     * Singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->check_requirements();
        $this->load_dependencies();
        $this->init_hooks();
    }
    
    /**
     * Check system requirements
     */
    private function check_requirements() {
        if (version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '<')) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>' . 
                     sprintf(__('Domain System requires PHP %s or higher. Current version: %s', 'domain-system'), 
                            self::MIN_PHP_VERSION, PHP_VERSION) . '</p></div>';
            });
            return false;
        }
        
        if (version_compare(get_bloginfo('version'), self::MIN_WP_VERSION, '<')) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>' . 
                     sprintf(__('Domain System requires WordPress %s or higher.', 'domain-system'), 
                            self::MIN_WP_VERSION) . '</p></div>';
            });
            return false;
        }
        
        return true;
    }
    
    /**
     * Load plugin dependencies
     */
    private function load_dependencies() {
        // Core classes
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'class-domain-post-type.php';
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'class-domain-url-rewriter.php';
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'class-domain-admin-interface.php';
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'class-domain-rest-api.php';
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'class-domain-shortcodes.php';
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'class-domain-widget.php';
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'class-domain-import-export.php';
        
        // Helper functions
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'domain-functions.php';
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'domain-template-functions.php';
        require_once DOMAIN_SYSTEM_INCLUDES_DIR . 'domain-ajax-handlers.php';
        
        // Load translations
        add_action('plugins_loaded', [$this, 'load_textdomain']);
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action('init', [$this, 'init_components'], 5);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        
        // Activation/Deactivation hooks
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        register_uninstall_hook(__FILE__, [__CLASS__, 'uninstall']);
    }
    
    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'domain-system',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages/'
        );
    }
    
    /**
     * Initialize components
     */
    public function init_components() {
        $this->components['post_type'] = new DomainPostType();
        $this->components['url_rewriter'] = new DomainURLRewriter();
        $this->components['rest_api'] = new DomainRestAPI();
        $this->components['shortcodes'] = new DomainShortcodes();
        $this->components['import_export'] = new DomainImportExport();
        
        if (is_admin()) {
            $this->components['admin_interface'] = new DomainAdminInterface();
        }
        
        // Register widget
        add_action('widgets_init', function() {
            register_widget('DomainSearchWidget');
        });
    }
    
    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        if (is_singular('domain') || is_post_type_archive('domain')) {
            wp_enqueue_style(
                'domain-frontend',
                DOMAIN_SYSTEM_ASSETS_URL . 'css/frontend.css',
                [],
                self::VERSION
            );
            
            wp_enqueue_script(
                'domain-frontend',
                DOMAIN_SYSTEM_ASSETS_URL . 'js/frontend.js',
                ['jquery'],
                self::VERSION,
                true
            );
            
            wp_localize_script('domain-frontend', 'domainSystem', [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('domain_frontend_nonce'),
                'strings' => [
                    'searching' => __('Searching...', 'domain-system'),
                    'error' => __('An error occurred', 'domain-system')
                ]
            ]);
        }
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        $screen = get_current_screen();
        
        if ($screen && ($screen->post_type === 'domain' || 
                       strpos($hook, 'domain') !== false)) {
            
            wp_enqueue_style(
                'domain-admin',
                DOMAIN_SYSTEM_ASSETS_URL . 'css/admin.css',
                [],
                self::VERSION
            );
            
            wp_enqueue_script(
                'domain-admin',
                DOMAIN_SYSTEM_ASSETS_URL . 'js/admin.js',
                ['jquery', 'wp-util'],
                self::VERSION,
                true
            );
            
            wp_localize_script('domain-admin', 'domainAdmin', [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('domain_admin_nonce'),
                'strings' => [
                    'confirm_delete' => __('Are you sure?', 'domain-system'),
                    'processing' => __('Processing...', 'domain-system'),
                    'success' => __('Success!', 'domain-system'),
                    'error' => __('Error occurred', 'domain-system')
                ]
            ]);
        }
    }
    
    /**
     * Activation callback
     */
    public function activate() {
        $this->init_components();
        flush_rewrite_rules();
        $this->create_default_options();
        $this->create_pages();
        
        // Show activation notice
        set_transient('domain_system_activated', true, 30);
        
        // Log activation
        error_log('Domain System activated - Version: ' . self::VERSION);
    }
    
    /**
     * Deactivation callback
     */
    public function deactivate() {
        flush_rewrite_rules();
        wp_clear_scheduled_hook('domain_system_cleanup');
        
        // Log deactivation
        error_log('Domain System deactivated');
    }
    
    /**
     * Uninstall callback
     */
    public static function uninstall() {
        // Only run if user confirmed
        if (!current_user_can('activate_plugins')) {
            return;
        }
        
        // Clean up options
        $options = [
            'domain_system_version',
            'domain_currency',
            'domain_currency_symbol',
            'domain_default_registration_price',
            'domain_default_renewal_price',
            'domain_show_alternatives',
            'domain_enable_cache',
            'domain_categories_created',
            'domain_pages_created'
        ];
        
        foreach ($options as $option) {
            delete_option($option);
        }
        
        // Clear caches
        wp_cache_flush();
        
        // Log uninstall
        error_log('Domain System uninstalled');
    }
    
    /**
     * Create default options
     */
    private function create_default_options() {
        $defaults = [
            'domain_system_version' => self::VERSION,
            'domain_currency' => 'USD',
            'domain_currency_symbol' => '$',
            'domain_default_registration_price' => '12.99',
            'domain_default_renewal_price' => '14.99',
            'domain_show_alternatives' => true,
            'domain_enable_cache' => true,
            'domain_enable_logging' => false
        ];
        
        foreach ($defaults as $option => $value) {
            if (!get_option($option)) {
                add_option($option, $value);
            }
        }
    }
    
    /**
     * Create default pages
     */
    private function create_pages() {
        if (get_option('domain_pages_created')) {
            return;
        }
        
        $pages = [
            'domain-search' => [
                'title' => __('Domain Search', 'domain-system'),
                'content' => '[domain_search]'
            ],
            'domain-list' => [
                'title' => __('Available Domains', 'domain-system'),
                'content' => '[domain_list limit="20" columns="4"]'
            ]
        ];
        
        foreach ($pages as $slug => $page_data) {
            if (!get_page_by_path($slug)) {
                wp_insert_post([
                    'post_title' => $page_data['title'],
                    'post_content' => $page_data['content'],
                    'post_status' => 'publish',
                    'post_type' => 'page',
                    'post_name' => $slug
                ]);
            }
        }
        
        update_option('domain_pages_created', true);
    }
    
    /**
     * Get component instance
     */
    public function get_component($name) {
        return $this->components[$name] ?? null;
    }
    
    /**
     * Check if component exists
     */
    public function has_component($name) {
        return isset($this->components[$name]);
    }
}

/**
 * Initialize the Domain System
 */
function domain_system() {
    return DomainSystem::get_instance();
}

// Initialize the plugin
add_action('plugins_loaded', 'domain_system', 0);

/**
 * Global helper function to access plugin instance
 */
function DS() {
    return domain_system();
}

/**
 * Plugin activation check
 */
if (!function_exists('is_plugin_active')) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * Add action links on plugin page
 */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links) {
    $settings_link = '<a href="' . admin_url('edit.php?post_type=domain&page=domain-settings') . '">' . 
                     __('Settings', 'domain-system') . '</a>';
    $docs_link = '<a href="https://yoursite.com/docs" target="_blank">' . 
                 __('Documentation', 'domain-system') . '</a>';
    
    array_unshift($links, $settings_link, $docs_link);
    return $links;
});

/**
 * Add row meta on plugin page
 */
add_filter('plugin_row_meta', function($links, $file) {
    if ($file === plugin_basename(__FILE__)) {
        $links[] = '<a href="https://yoursite.com/support" target="_blank">' . 
                   __('Support', 'domain-system') . '</a>';
        $links[] = '<a href="https://yoursite.com/changelog" target="_blank">' . 
                   __('Changelog', 'domain-system') . '</a>';
    }
    return $links;
}, 10, 2);

// End of main file