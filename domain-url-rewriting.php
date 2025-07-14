<?php
/**
 * Domain URL Rewriting and Admin Functions
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class DomainURLRewriting {
    
    public function __construct() {
        add_action('init', array($this, 'add_domain_rewrite_rules'));
        add_filter('query_vars', array($this, 'add_domain_query_vars'));
        add_action('template_redirect', array($this, 'handle_domain_template_redirect'));
        add_action('wp_loaded', array($this, 'flush_rewrite_rules_maybe'));
        add_filter('post_type_link', array($this, 'domain_post_type_link'), 10, 2);
        add_action('save_post', array($this, 'update_domain_slug'), 20, 2);
        
        // Admin enhancements
        add_filter('manage_domain_posts_columns', array($this, 'add_domain_admin_columns'));
        add_action('manage_domain_posts_custom_column', array($this, 'populate_domain_admin_columns'), 10, 2);
        add_filter('manage_edit-domain_sortable_columns', array($this, 'make_domain_columns_sortable'));
        add_action('pre_get_posts', array($this, 'handle_domain_admin_sorting'));
        add_action('admin_head', array($this, 'add_domain_admin_styles'));
        
        // Bulk actions
        add_filter('bulk_actions-edit-domain', array($this, 'add_domain_bulk_actions'));
        add_filter('handle_bulk_actions-edit-domain', array($this, 'handle_domain_bulk_actions'), 10, 3);
        add_action('admin_notices', array($this, 'domain_bulk_action_notices'));
    }
    
    /**
     * Add rewrite rules for domain URLs
     */
    public function add_domain_rewrite_rules() {
        // Match domains/tld/ pattern (e.g., domains/shop/, domains/co-uk/)
        add_rewrite_rule(
            '^domains/([^/]+)/?,
            'index.php?post_type=domain&domain_tld=$matches[1]',
            'top'
        );
        
        // Match domains/tld/page/ pattern for pagination if needed
        add_rewrite_rule(
            '^domains/([^/]+)/page/([0-9]{1,})/?,
            'index.php?post_type=domain&domain_tld=$matches[1]&paged=$matches[2]',
            'top'
        );
    }
    
    /**
     * Add domain query vars
     */
    public function add_domain_query_vars($vars) {
        $vars[] = 'domain_tld';
        return $vars;
    }
    
    /**
     * Handle domain template redirect
     */
    public function handle_domain_template_redirect() {
        $domain_tld = get_query_var('domain_tld');
        
        if (!empty($domain_tld)) {
            // Convert URL slug back to TLD format
            $tld = str_replace('-', '.', $domain_tld);
            
            // Find the domain post with this TLD
            $domain_post = $this->get_domain_by_tld($tld);
            
            if ($domain_post) {
                // Set up the global post
                global $post, $wp_query;
                $post = $domain_post;
                setup_postdata($post);
                
                // Modify the main query
                $wp_query->is_single = true;
                $wp_query->is_singular = true;
                $wp_query->is_404 = false;
                $wp_query->found_posts = 1;
                $wp_query->post_count = 1;
                $wp_query->posts = array($domain_post);
                
                // Load the single domain template
                $template = locate_template(array('single-domain.php'));
                if ($template) {
                    include $template;
                    exit;
                }
            } else {
                // No domain found, show 404
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
                get_template_part('404');
                exit;
            }
        }
    }
    
    /**
     * Get domain post by TLD
     */
    private function get_domain_by_tld($tld) {
        $query = new WP_Query(array(
            'post_type' => 'domain',
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_domain_tld',
                    'value' => ltrim($tld, '.'),
                    'compare' => '='
                )
            )
        ));
        
        return $query->have_posts() ? $query->posts[0] : null;
    }
    
    /**
     * Flush rewrite rules when needed
     */
    public function flush_rewrite_rules_maybe() {
        if (get_option('domain_rewrite_rules_flushed') !== '1') {
            flush_rewrite_rules();
            update_option('domain_rewrite_rules_flushed', '1');
        }
    }
    
    /**
     * Customize domain post permalink
     */
    public function domain_post_type_link($post_link, $post) {
        if ($post->post_type === 'domain') {
            $tld = get_post_meta($post->ID, '_domain_tld', true);
            if (!empty($tld)) {
                $tld = ltrim($tld, '.');
                $slug = str_replace('.', '-', $tld);
                return home_url('/domains/' . $slug . '/');
            }
        }
        return $post_link;
    }
    
    /**
     * Update domain slug when TLD changes
     */
    public function update_domain_slug($post_id, $post) {
        if ($post->post_type !== 'domain' || wp_is_post_revision($post_id)) {
            return;
        }
        
        $tld = get_post_meta($post_id, '_domain_tld', true);
        if (!empty($tld)) {
            $tld = ltrim($tld, '.');
            $new_slug = str_replace('.', '-', $tld);
            
            // Update post slug if it's different
            if ($post->post_name !== $new_slug) {
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_name' => $new_slug
                ));
            }
        }
    }
    
    /**
     * Add custom columns to domain admin
     */
    public function add_domain_admin_columns($columns) {
        $new_columns = array();
        
        // Keep checkbox and title
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = $columns['title'];
        
        // Add custom columns
        $new_columns['domain_tld'] = __('TLD', 'yoursite');
        $new_columns['domain_price'] = __('Price', 'yoursite');
        $new_columns['domain_category'] = __('Category', 'yoursite');
        $new_columns['domain_registry'] = __('Registry', 'yoursite');
        $new_columns['domain_status'] = __('Status', 'yoursite');
        
        // Add remaining columns
        $new_columns['date'] = $columns['date'];
        
        return $new_columns;
    }
    
    /**
     * Populate custom admin columns
     */
    public function populate_domain_admin_columns($column, $post_id) {
        switch ($column) {
            case 'domain_tld':
                $tld = get_post_meta($post_id, '_domain_tld', true);
                if (!empty($tld)) {
                    $tld = ltrim($tld, '.');
                    echo '<strong>.' . esc_html($tld) . '</strong>';
                    echo '<br><small><a href="' . esc_url(get_permalink($post_id)) . '" target="_blank">View Page</a></small>';
                } else {
                    echo '<span style="color: #dc3232;">' . __('Not set', 'yoursite') . '</span>';
                }
                break;
                
            case 'domain_price':
                $price = get_post_meta($post_id, '_domain_registration_price', true);
                $renewal = get_post_meta($post_id, '_domain_renewal_price', true);
                if (!empty($price)) {
                    echo '<strong> . esc_html($price) . '</strong>';
                    if (!empty($renewal)) {
                        echo '<br><small>Renewal:  . esc_html($renewal) . '</small>';
                    }
                } else {
                    echo '<span style="color: #dc3232;">' . __('Not set', 'yoursite') . '</span>';
                }
                break;
                
            case 'domain_category':
                $terms = get_the_terms($post_id, 'domain_category');
                if (!empty($terms) && !is_wp_error($terms)) {
                    $term_names = array();
                    foreach ($terms as $term) {
                        $term_names[] = '<a href="' . esc_url(admin_url('edit.php?post_type=domain&domain_category=' . $term->slug)) . '">' . esc_html($term->name) . '</a>';
                    }
                    echo implode(', ', $term_names);
                } else {
                    echo '—';
                }
                break;
                
            case 'domain_registry':
                $registry = get_post_meta($post_id, '_domain_registry', true);
                echo !empty($registry) ? esc_html($registry) : '—';
                break;
                
            case 'domain_status':
                $tld = get_post_meta($post_id, '_domain_tld', true);
                $price = get_post_meta($post_id, '_domain_registration_price', true);
                $hero_h1 = get_post_meta($post_id, '_domain_hero_h1', true);
                
                $status_items = array();
                
                if (empty($tld)) {
                    $status_items[] = '<span style="color: #dc3232;">Missing TLD</span>';
                }
                if (empty($price)) {
                    $status_items[] = '<span style="color: #dc3232;">Missing Price</span>';
                }
                if (empty($hero_h1)) {
                    $status_items[] = '<span style="color: #ffb900;">Missing Hero</span>';
                }
                
                if (empty($status_items)) {
                    echo '<span style="color: #46b450;">✓ Complete</span>';
                } else {
                    echo implode('<br>', $status_items);
                }
                break;
        }
    }
    
    /**
     * Make columns sortable
     */
    public function make_domain_columns_sortable($columns) {
        $columns['domain_tld'] = 'domain_tld';
        $columns['domain_price'] = 'domain_price';
        $columns['domain_registry'] = 'domain_registry';
        return $columns;
    }
    
    /**
     * Handle admin column sorting
     */
    public function handle_domain_admin_sorting($query) {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }
        
        $orderby = $query->get('orderby');
        
        switch ($orderby) {
            case 'domain_tld':
                $query->set('meta_key', '_domain_tld');
                $query->set('orderby', 'meta_value');
                break;
                
            case 'domain_price':
                $query->set('meta_key', '_domain_registration_price');
                $query->set('orderby', 'meta_value_num');
                break;
                
            case 'domain_registry':
                $query->set('meta_key', '_domain_registry');
                $query->set('orderby', 'meta_value');
                break;
        }
    }
    
    /**
     * Add admin styles
     */
    public function add_domain_admin_styles() {
        $screen = get_current_screen();
        if ($screen && $screen->post_type === 'domain') {
            ?>
            <style>
            .wp-list-table .column-domain_tld { width: 120px; }
            .wp-list-table .column-domain_price { width: 100px; }
            .wp-list-table .column-domain_category { width: 150px; }
            .wp-list-table .column-domain_registry { width: 130px; }
            .wp-list-table .column-domain_status { width: 120px; }
            .domain-admin-highlight { background-color: #fff3cd; }
            </style>
            <?php
        }
    }
    
    /**
     * Add bulk actions
     */
    public function add_domain_bulk_actions($bulk_actions) {
        $bulk_actions['update_prices'] = __('Update Prices from CSV', 'yoursite');
        $bulk_actions['publish_domains'] = __('Publish Selected', 'yoursite');
        $bulk_actions['draft_domains'] = __('Move to Draft', 'yoursite');
        return $bulk_actions;
    }
    
    /**
     * Handle bulk actions
     */
    public function handle_domain_bulk_actions($redirect_to, $doaction, $post_ids) {
        if ($doaction === 'publish_domains') {
            foreach ($post_ids as $post_id) {
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_status' => 'publish'
                ));
            }
            $redirect_to = add_query_arg('domains_published', count($post_ids), $redirect_to);
        }
        
        if ($doaction === 'draft_domains') {
            foreach ($post_ids as $post_id) {
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_status' => 'draft'
                ));
            }
            $redirect_to = add_query_arg('domains_drafted', count($post_ids), $redirect_to);
        }
        
        return $redirect_to;
    }
    
    /**
     * Show bulk action notices
     */
    public function domain_bulk_action_notices() {
        if (!empty($_REQUEST['domains_published'])) {
            $count = intval($_REQUEST['domains_published']);
            printf(
                '<div class="notice notice-success is-dismissible"><p>' . 
                _n('%s domain published.', '%s domains published.', $count, 'yoursite') . 
                '</p></div>',
                $count
            );
        }
        
        if (!empty($_REQUEST['domains_drafted'])) {
            $count = intval($_REQUEST['domains_drafted']);
            printf(
                '<div class="notice notice-success is-dismissible"><p>' . 
                _n('%s domain moved to draft.', '%s domains moved to draft.', $count, 'yoursite') . 
                '</p></div>',
                $count
            );
        }
    }
}

// Initialize the URL rewriting class
new DomainURLRewriting();

/**
 * Reset rewrite rules on theme activation
 */
function domain_activate_rewrite_rules() {
    delete_option('domain_rewrite_rules_flushed');
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'domain_activate_rewrite_rules');

/**
 * Add domain quick edit functionality
 */
function add_domain_quick_edit() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Add quick edit functionality for domains
        $('a.editinline').on('click', function() {
            var post_id = $(this).closest('tr').attr('id').replace('post-', '');
            var $inline_row = $('#edit-' + post_id);
            
            // Add TLD field to quick edit
            if ($inline_row.find('.domain-tld-field').length === 0) {
                var tld_field = '<label class="domain-tld-field alignleft">' +
                    '<span class="title"><?php _e("TLD", "yoursite"); ?></span>' +
                    '<span class="input-text-wrap">' +
                    '<input type="text" name="domain_tld" class="ptitle" value="" placeholder=".shop">' +
                    '</span>' +
                    '</label>';
                
                $inline_row.find('.inline-edit-col-right .inline-edit-col').prepend(tld_field);
            }
        });
    });
    </script>
    <?php
}
add_action('admin_footer-edit.php', 'add_domain_quick_edit');

/**
 * Domain admin dashboard widget
 */
function add_domain_dashboard_widget() {
    wp_add_dashboard_widget(
        'domain_stats_widget',
        __('Domain Statistics', 'yoursite'),
        'domain_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'add_domain_dashboard_widget');

function domain_dashboard_widget_content() {
    $total_domains = wp_count_posts('domain');
    $published = $total_domains->publish ?? 0;
    $draft = $total_domains->draft ?? 0;
    
    // Get domains missing key info
    $incomplete_domains = new WP_Query(array(
        'post_type' => 'domain',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_domain_tld',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => '_domain_registration_price',
                'compare' => 'NOT EXISTS'
            )
        )
    ));
    
    ?>
    <div class="domain-stats-widget">
        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
            <div style="text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #0073aa;"><?php echo $published; ?></div>
                <div style="font-size: 12px; color: #666;"><?php _e('Published', 'yoursite'); ?></div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #ffb900;"><?php echo $draft; ?></div>
                <div style="font-size: 12px; color: #666;"><?php _e('Draft', 'yoursite'); ?></div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #dc3232;"><?php echo $incomplete_domains->found_posts; ?></div>
                <div style="font-size: 12px; color: #666;"><?php _e('Incomplete', 'yoursite'); ?></div>
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="<?php echo admin_url('edit.php?post_type=domain'); ?>" class="button button-primary">
                <?php _e('Manage Domains', 'yoursite'); ?>
            </a>
            <a href="<?php echo admin_url('post-new.php?post_type=domain'); ?>" class="button">
                <?php _e('Add Domain', 'yoursite'); ?>
            </a>
        </div>
    </div>
    <?php
}