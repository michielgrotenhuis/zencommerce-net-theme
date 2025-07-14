<?php
/**
 * Domain Custom Post Type Registration
 * 
 * @package YourSite
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class DomainPostType {
    
    public function __construct() {
        add_action('init', array($this, 'register_domain_post_type'));
        add_action('init', array($this, 'register_domain_taxonomies'));
        add_action('add_meta_boxes', array($this, 'add_domain_meta_boxes'));
        add_action('save_post', array($this, 'save_domain_meta'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_domain_scripts'));
        add_filter('template_include', array($this, 'domain_template_loader'));
        add_action('wp_ajax_bulk_import_domains', array($this, 'handle_bulk_import'));
        add_action('wp_ajax_nopriv_bulk_import_domains', array($this, 'handle_bulk_import'));
    }
    
    /**
     * Register Domain Custom Post Type
     */
    public function register_domain_post_type() {
        $labels = array(
            'name'                  => __('Domains', 'yoursite'),
            'singular_name'         => __('Domain', 'yoursite'),
            'menu_name'             => __('Domains', 'yoursite'),
            'name_admin_bar'        => __('Domain', 'yoursite'),
            'archives'              => __('Domain Archives', 'yoursite'),
            'attributes'            => __('Domain Attributes', 'yoursite'),
            'parent_item_colon'     => __('Parent Domain:', 'yoursite'),
            'all_items'             => __('All Domains', 'yoursite'),
            'add_new_item'          => __('Add New Domain', 'yoursite'),
            'add_new'               => __('Add New', 'yoursite'),
            'new_item'              => __('New Domain', 'yoursite'),
            'edit_item'             => __('Edit Domain', 'yoursite'),
            'update_item'           => __('Update Domain', 'yoursite'),
            'view_item'             => __('View Domain', 'yoursite'),
            'view_items'            => __('View Domains', 'yoursite'),
            'search_items'          => __('Search Domain', 'yoursite'),
        );

        $args = array(
            'label'                 => __('Domain', 'yoursite'),
            'description'           => __('Domain landing pages', 'yoursite'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields'),
            'taxonomies'            => array('domain_category'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-admin-site-alt3',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'domains',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => array(
                'slug' => 'domains',
                'with_front' => false
            ),
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );

        register_post_type('domain', $args);
    }
    
    /**
     * Register Domain Taxonomies
     */
    public function register_domain_taxonomies() {
        // Domain Categories
        $labels = array(
            'name'                       => __('Domain Categories', 'yoursite'),
            'singular_name'              => __('Domain Category', 'yoursite'),
            'menu_name'                  => __('Categories', 'yoursite'),
            'all_items'                  => __('All Categories', 'yoursite'),
            'parent_item'                => __('Parent Category', 'yoursite'),
            'parent_item_colon'          => __('Parent Category:', 'yoursite'),
            'new_item_name'              => __('New Category Name', 'yoursite'),
            'add_new_item'               => __('Add New Category', 'yoursite'),
            'edit_item'                  => __('Edit Category', 'yoursite'),
            'update_item'                => __('Update Category', 'yoursite'),
            'view_item'                  => __('View Category', 'yoursite'),
            'separate_items_with_commas' => __('Separate categories with commas', 'yoursite'),
            'add_or_remove_items'        => __('Add or remove categories', 'yoursite'),
            'choose_from_most_used'      => __('Choose from the most used', 'yoursite'),
            'popular_items'              => __('Popular Categories', 'yoursite'),
            'search_items'               => __('Search Categories', 'yoursite'),
            'not_found'                  => __('Not Found', 'yoursite'),
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'show_in_rest'               => true,
            'rewrite'                    => array('slug' => 'domain-category'),
        );

        register_taxonomy('domain_category', array('domain'), $args);
        
        // Add default categories
        $this->create_default_categories();
    }
    
    /**
     * Create default domain categories
     */
    private function create_default_categories() {
        $default_categories = array(
            'Shopping & Sales' => 'Perfect for e-commerce and retail businesses',
            'Business & Professional' => 'Ideal for corporate and professional services',
            'Creative & Arts' => 'Great for artists, designers, and creative professionals',
            'Technology & Development' => 'Perfect for tech companies and developers',
            'Health & Wellness' => 'Ideal for healthcare and wellness businesses',
            'Education & Training' => 'Great for educational institutions and training',
            'Food & Restaurants' => 'Perfect for restaurants and food businesses',
            'Travel & Tourism' => 'Ideal for travel agencies and tourism',
            'Real Estate' => 'Great for real estate professionals',
            'Finance & Insurance' => 'Perfect for financial services',
            'Entertainment & Media' => 'Ideal for entertainment and media companies',
            'Non-Profit & Community' => 'Great for non-profits and community organizations'
        );
        
        foreach ($default_categories as $name => $description) {
            if (!term_exists($name, 'domain_category')) {
                wp_insert_term($name, 'domain_category', array(
                    'description' => $description
                ));
            }
        }
    }
    
    /**
     * Add Meta Boxes
     */
    public function add_domain_meta_boxes() {
        // General Information
        add_meta_box(
            'domain-general-info',
            __('General Information', 'yoursite'),
            array($this, 'render_general_info_meta_box'),
            'domain',
            'normal',
            'high'
        );
        
        // Pricing Information
        add_meta_box(
            'domain-pricing-info',
            __('Pricing Information', 'yoursite'),
            'domain-pricing-info',
            array($this, 'render_pricing_info_meta_box'),
            'domain',
            'normal',
            'high'
        );
        
        // Hero Section
        add_meta_box(
            'domain-hero-section',
            __('Hero Section', 'yoursite'),
            array($this, 'render_hero_section_meta_box'),
            'domain',
            'normal',
            'default'
        );
        
        // Content Sections
        add_meta_box(
            'domain-content-sections',
            __('Domain Content Sections', 'yoursite'),
            array($this, 'render_content_sections_meta_box'),
            'domain',
            'normal',
            'default'
        );
        
        // FAQ Section
        add_meta_box(
            'domain-faq-section',
            __('FAQ Section', 'yoursite'),
            array($this, 'render_faq_section_meta_box'),
            'domain',
            'normal',
            'default'
        );
        
        // Domain Policy
        add_meta_box(
            'domain-policy',
            __('Domain Policy', 'yoursite'),
            array($this, 'render_domain_policy_meta_box'),
            'domain',
            'normal',
            'default'
        );
        
        // Registry Information
        add_meta_box(
            'domain-registry-info',
            __('Registry Information', 'yoursite'),
            array($this, 'render_registry_info_meta_box'),
            'domain',
            'side',
            'default'
        );
        
        // Bulk Import
        add_meta_box(
            'domain-bulk-import',
            __('Bulk Import Domains', 'yoursite'),
            array($this, 'render_bulk_import_meta_box'),
            'domain',
            'side',
            'low'
        );
    }
    
    /**
     * Render General Information Meta Box
     */
    public function render_general_info_meta_box($post) {
        wp_nonce_field('domain_meta_nonce', 'domain_meta_nonce');
        
        $tld = get_post_meta($post->ID, '_domain_tld', true);
        $product_id = get_post_meta($post->ID, '_domain_product_id', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="domain_tld"><?php _e('TLD (Top Level Domain)', 'yoursite'); ?></label></th>
                <td>
                    <input type="text" id="domain_tld" name="domain_tld" value="<?php echo esc_attr($tld); ?>" placeholder=".shop" class="regular-text" required />
                    <p class="description"><?php _e('Enter the domain extension (e.g., .shop, .com, .co.uk)', 'yoursite'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="domain_product_id"><?php _e('Product ID (Upmind)', 'yoursite'); ?></label></th>
                <td>
                    <input type="text" id="domain_product_id" name="domain_product_id" value="<?php echo esc_attr($product_id); ?>" placeholder="optional" class="regular-text" />
                    <p class="description"><?php _e('Optional: Product ID for Upmind integration', 'yoursite'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Render Pricing Information Meta Box
     */
    public function render_pricing_info_meta_box($post) {
        $registration_price = get_post_meta($post->ID, '_domain_registration_price', true);
        $renewal_price = get_post_meta($post->ID, '_domain_renewal_price', true);
        $transfer_price = get_post_meta($post->ID, '_domain_transfer_price', true);
        $restoration_price = get_post_meta($post->ID, '_domain_restoration_price', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="domain_registration_price"><?php _e('Registration Price', 'yoursite'); ?></label></th>
                <td>
                    <input type="number" step="0.01" id="domain_registration_price" name="domain_registration_price" value="<?php echo esc_attr($registration_price); ?>" placeholder="12.99" class="small-text" />
                    <span class="description"><?php _e('USD', 'yoursite'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="domain_renewal_price"><?php _e('Renewal Price', 'yoursite'); ?></label></th>
                <td>
                    <input type="number" step="0.01" id="domain_renewal_price" name="domain_renewal_price" value="<?php echo esc_attr($renewal_price); ?>" placeholder="14.99" class="small-text" />
                    <span class="description"><?php _e('USD', 'yoursite'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="domain_transfer_price"><?php _e('Transfer Price', 'yoursite'); ?></label></th>
                <td>
                    <input type="number" step="0.01" id="domain_transfer_price" name="domain_transfer_price" value="<?php echo esc_attr($transfer_price); ?>" placeholder="12.99" class="small-text" />
                    <span class="description"><?php _e('USD', 'yoursite'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="domain_restoration_price"><?php _e('Restoration Price', 'yoursite'); ?></label></th>
                <td>
                    <input type="number" step="0.01" id="domain_restoration_price" name="domain_restoration_price" value="<?php echo esc_attr($restoration_price); ?>" placeholder="99.99" class="small-text" />
                    <span class="description"><?php _e('USD', 'yoursite'); ?></span>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Render Hero Section Meta Box
     */
    public function render_hero_section_meta_box($post) {
        $hero_h1 = get_post_meta($post->ID, '_domain_hero_h1', true);
        $hero_subtitle = get_post_meta($post->ID, '_domain_hero_subtitle', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="domain_hero_h1"><?php _e('Hero H1 Title', 'yoursite'); ?></label></th>
                <td>
                    <input type="text" id="domain_hero_h1" name="domain_hero_h1" value="<?php echo esc_attr($hero_h1); ?>" placeholder="Find your perfect .shop domain" class="large-text" />
                    <p class="description"><?php _e('Main headline for the hero section', 'yoursite'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="domain_hero_subtitle"><?php _e('Hero Subtitle', 'yoursite'); ?></label></th>
                <td>
                    <textarea id="domain_hero_subtitle" name="domain_hero_subtitle" rows="3" class="large-text" placeholder="Showcase your online shop with a branded domain name..."><?php echo esc_textarea($hero_subtitle); ?></textarea>
                    <p class="description"><?php _e('Subtitle text below the main headline', 'yoursite'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Render Content Sections Meta Box
     */
    public function render_content_sections_meta_box($post) {
        $domain_overview = get_post_meta($post->ID, '_domain_overview', true);
        $domain_stats = get_post_meta($post->ID, '_domain_stats', true);
        $domain_benefits = get_post_meta($post->ID, '_domain_benefits', true);
        $domain_ideas = get_post_meta($post->ID, '_domain_ideas', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="domain_overview"><?php _e('Domain Overview', 'yoursite'); ?></label></th>
                <td>
                    <textarea id="domain_overview" name="domain_overview" rows="4" class="large-text" placeholder="Showcase your online shop with a branded domain name..."><?php echo esc_textarea($domain_overview); ?></textarea>
                    <p class="description"><?php _e('General overview of the domain extension', 'yoursite'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="domain_stats"><?php _e('Domain Stats & History', 'yoursite'); ?></label></th>
                <td>
                    <textarea id="domain_stats" name="domain_stats" rows="4" class="large-text" placeholder="Join millions of businesses by registering a domain..."><?php echo esc_textarea($domain_stats); ?></textarea>
                    <p class="description"><?php _e('Statistics, facts, and history about the domain extension', 'yoursite'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="domain_benefits"><?php _e('Domain Benefits', 'yoursite'); ?></label></th>
                <td>
                    <textarea id="domain_benefits" name="domain_benefits" rows="4" class="large-text" placeholder="Looking for an on-brand domain name..."><?php echo esc_textarea($domain_benefits); ?></textarea>
                    <p class="description"><?php _e('Benefits of choosing this domain extension', 'yoursite'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="domain_ideas"><?php _e('Domain Ideas', 'yoursite'); ?></label></th>
                <td>
                    <textarea id="domain_ideas" name="domain_ideas" rows="4" class="large-text" placeholder="A domain is a fresh choice for any business..."><?php echo esc_textarea($domain_ideas); ?></textarea>
                    <p class="description"><?php _e('Ideas for how to use this domain extension', 'yoursite'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Render FAQ Section Meta Box
     */
    public function render_faq_section_meta_box($post) {
        $faq_items = get_post_meta($post->ID, '_domain_faq', true);
        if (!is_array($faq_items)) {
            $faq_items = array();
        }
        
        // Ensure we have at least 3 empty FAQ items
        while (count($faq_items) < 6) {
            $faq_items[] = array('question' => '', 'answer' => '');
        }
        
        ?>
        <div id="domain-faq-container">
            <?php foreach ($faq_items as $index => $faq_item): ?>
            <div class="faq-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; background: #f9f9f9;">
                <h4><?php printf(__('FAQ #%d', 'yoursite'), $index + 1); ?></h4>
                <table class="form-table">
                    <tr>
                        <th><label for="faq_question_<?php echo $index; ?>"><?php _e('Question', 'yoursite'); ?></label></th>
                        <td>
                            <input type="text" 
                                   id="faq_question_<?php echo $index; ?>" 
                                   name="domain_faq[<?php echo $index; ?>][question]" 
                                   value="<?php echo esc_attr($faq_item['question'] ?? ''); ?>" 
                                   class="large-text" 
                                   placeholder="<?php _e('What is a domain?', 'yoursite'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="faq_answer_<?php echo $index; ?>"><?php _e('Answer', 'yoursite'); ?></label></th>
                        <td>
                            <textarea id="faq_answer_<?php echo $index; ?>" 
                                      name="domain_faq[<?php echo $index; ?>][answer]" 
                                      rows="3" 
                                      class="large-text" 
                                      placeholder="<?php _e('A domain is...', 'yoursite'); ?>"><?php echo esc_textarea($faq_item['answer'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                </table>
                <?php if ($index > 2): ?>
                <button type="button" class="button remove-faq-item"><?php _e('Remove FAQ', 'yoursite'); ?></button>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" id="add-faq-item" class="button button-secondary"><?php _e('Add FAQ Item', 'yoursite'); ?></button>
        
        <script>
        jQuery(document).ready(function($) {
            var faqIndex = <?php echo count($faq_items); ?>;
            
            $('#add-faq-item').click(function() {
                var faqHtml = '<div class="faq-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; background: #f9f9f9;">' +
                    '<h4><?php _e("FAQ #", "yoursite"); ?>' + (faqIndex + 1) + '</h4>' +
                    '<table class="form-table">' +
                    '<tr>' +
                    '<th><label for="faq_question_' + faqIndex + '"><?php _e("Question", "yoursite"); ?></label></th>' +
                    '<td><input type="text" id="faq_question_' + faqIndex + '" name="domain_faq[' + faqIndex + '][question]" value="" class="large-text" placeholder="<?php _e("What is a domain?", "yoursite"); ?>" /></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<th><label for="faq_answer_' + faqIndex + '"><?php _e("Answer", "yoursite"); ?></label></th>' +
                    '<td><textarea id="faq_answer_' + faqIndex + '" name="domain_faq[' + faqIndex + '][answer]" rows="3" class="large-text" placeholder="<?php _e("A domain is...", "yoursite"); ?>"></textarea></td>' +
                    '</tr>' +
                    '</table>' +
                    '<button type="button" class="button remove-faq-item"><?php _e("Remove FAQ", "yoursite"); ?></button>' +
                    '</div>';
                
                $('#domain-faq-container').append(faqHtml);
                faqIndex++;
            });
        });
        </script>
        <?php
    }
    
    /**
     * Save Domain Meta Data
     */
    public function save_domain_meta($post_id) {
        // Check if our nonce is set and verify it
        if (!isset($_POST['domain_meta_nonce']) || !wp_verify_nonce($_POST['domain_meta_nonce'], 'domain_meta_nonce')) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions
        if (isset($_POST['post_type']) && 'domain' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        // Sanitize and save meta fields
        $meta_fields = array(
            '_domain_tld' => 'sanitize_text_field',
            '_domain_product_id' => 'sanitize_text_field',
            '_domain_registration_price' => 'sanitize_text_field',
            '_domain_renewal_price' => 'sanitize_text_field',
            '_domain_transfer_price' => 'sanitize_text_field',
            '_domain_restoration_price' => 'sanitize_text_field',
            '_domain_hero_h1' => 'sanitize_text_field',
            '_domain_hero_subtitle' => 'sanitize_textarea_field',
            '_domain_overview' => 'sanitize_textarea_field',
            '_domain_stats' => 'sanitize_textarea_field',
            '_domain_benefits' => 'sanitize_textarea_field',
            '_domain_ideas' => 'sanitize_textarea_field',
            '_domain_min_length' => 'intval',
            '_domain_max_length' => 'intval',
            '_domain_numbers_allowed' => 'sanitize_text_field',
            '_domain_hyphens_allowed' => 'sanitize_text_field',
            '_domain_idn_allowed' => 'sanitize_text_field',
            '_domain_registry' => 'sanitize_text_field'
        );

        foreach ($meta_fields as $field => $sanitize_function) {
            $post_field = str_replace('_domain_', 'domain_', $field);
            if (isset($_POST[$post_field])) {
                update_post_meta($post_id, $field, $sanitize_function($_POST[$post_field]));
            }
        }

        // Handle FAQ data
        if (isset($_POST['domain_faq']) && is_array($_POST['domain_faq'])) {
            $faq_data = array();
            foreach ($_POST['domain_faq'] as $faq_item) {
                if (!empty($faq_item['question']) && !empty($faq_item['answer'])) {
                    $faq_data[] = array(
                        'question' => sanitize_text_field($faq_item['question']),
                        'answer' => sanitize_textarea_field($faq_item['answer'])
                    );
                }
            }
            update_post_meta($post_id, '_domain_faq', $faq_data);
        }
    }
    
    /**
     * Handle bulk import AJAX
     */
    public function handle_bulk_import() {
        check_ajax_referer('bulk_import_nonce', 'nonce');
        
        if (!current_user_can('edit_posts')) {
            wp_die(__('You do not have permission to perform this action.', 'yoursite'));
        }

        if (!isset($_FILES['csv_file'])) {
            wp_send_json_error(__('No file uploaded.', 'yoursite'));
        }

        $file = $_FILES['csv_file'];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            wp_send_json_error(__('File upload error.', 'yoursite'));
        }

        $file_content = file_get_contents($file['tmp_name']);
        $lines = explode("\n", $file_content);
        $header = str_getcsv(array_shift($lines));
        
        $imported = 0;
        $errors = array();
        
        foreach ($lines as $line_num => $line) {
            if (empty(trim($line))) continue;
            
            $data = str_getcsv($line);
            if (count($data) !== count($header)) {
                $errors[] = sprintf(__('Line %d: Invalid data format', 'yoursite'), $line_num + 2);
                continue;
            }
            
            $domain_data = array_combine($header, $data);
            
            // Create new domain post
            $post_data = array(
                'post_title' => $domain_data['tld'] . ' ' . __('Domain', 'yoursite'),
                'post_content' => '',
                'post_status' => 'draft',
                'post_type' => 'domain'
            );
            
            $post_id = wp_insert_post($post_data);
            
            if (is_wp_error($post_id)) {
                $errors[] = sprintf(__('Line %d: Could not create post', 'yoursite'), $line_num + 2);
                continue;
            }
            
            // Save meta data
            update_post_meta($post_id, '_domain_tld', sanitize_text_field($domain_data['tld']));
            update_post_meta($post_id, '_domain_registration_price', sanitize_text_field($domain_data['registration_price']));
            update_post_meta($post_id, '_domain_renewal_price', sanitize_text_field($domain_data['renewal_price']));
            update_post_meta($post_id, '_domain_hero_h1', sanitize_text_field($domain_data['hero_h1']));
            update_post_meta($post_id, '_domain_hero_subtitle', sanitize_textarea_field($domain_data['hero_subtitle']));
            
            // Set category
            if (!empty($domain_data['category'])) {
                $term = get_term_by('name', $domain_data['category'], 'domain_category');
                if ($term) {
                    wp_set_post_terms($post_id, array($term->term_id), 'domain_category');
                }
            }
            
            $imported++;
        }
        
        if (!empty($errors)) {
            wp_send_json_error(sprintf(__('Imported %d domains with errors: %s', 'yoursite'), $imported, implode(', ', $errors)));
        } else {
            wp_send_json_success(sprintf(__('Successfully imported %d domains', 'yoursite'), $imported));
        }
    }
    
    /**
     * Template loader for domain posts
     */
    public function domain_template_loader($template) {
        global $post;
        
        if ($post && $post->post_type === 'domain') {
            $theme_template = locate_template(array('single-domain.php'));
            if ($theme_template) {
                return $theme_template;
            }
        }
        
        return $template;
    }
    
    /**
     * Enqueue scripts for domain functionality
     */
    public function enqueue_domain_scripts() {
        if (is_singular('domain')) {
            wp_enqueue_script('domain-frontend', get_template_directory_uri() . '/assets/js/domain-frontend.js', array('jquery'), '1.0.0', true);
            wp_localize_script('domain-frontend', 'domain_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('domain_frontend_nonce')
            ));
        }
    }
}

// Initialize the class
new DomainPostType();
            
            $(document).on('click', '.remove-faq-item', function() {
                $(this).closest('.faq-item').remove();
            });
        });
        </script>
        <?php
    }
    
    /**
     * Render Domain Policy Meta Box
     */
    public function render_domain_policy_meta_box($post) {
        $min_length = get_post_meta($post->ID, '_domain_min_length', true);
        $max_length = get_post_meta($post->ID, '_domain_max_length', true);
        $numbers_allowed = get_post_meta($post->ID, '_domain_numbers_allowed', true);
        $hyphens_allowed = get_post_meta($post->ID, '_domain_hyphens_allowed', true);
        $idn_allowed = get_post_meta($post->ID, '_domain_idn_allowed', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="domain_min_length"><?php _e('Minimum Length', 'yoursite'); ?></label></th>
                <td>
                    <input type="number" id="domain_min_length" name="domain_min_length" value="<?php echo esc_attr($min_length ?: '2'); ?>" min="1" max="63" class="small-text" />
                    <span class="description"><?php _e('characters', 'yoursite'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="domain_max_length"><?php _e('Maximum Length', 'yoursite'); ?></label></th>
                <td>
                    <input type="number" id="domain_max_length" name="domain_max_length" value="<?php echo esc_attr($max_length ?: '63'); ?>" min="1" max="63" class="small-text" />
                    <span class="description"><?php _e('characters', 'yoursite'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="domain_numbers_allowed"><?php _e('Numbers Allowed', 'yoursite'); ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" id="domain_numbers_allowed" name="domain_numbers_allowed" value="1" <?php checked($numbers_allowed, '1'); ?> />
                        <?php _e('Yes, numbers are allowed', 'yoursite'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th><label for="domain_hyphens_allowed"><?php _e('Hyphens Allowed', 'yoursite'); ?></label></th>
                <td>
                    <select id="domain_hyphens_allowed" name="domain_hyphens_allowed">
                        <option value="none" <?php selected($hyphens_allowed, 'none'); ?>><?php _e('Not allowed', 'yoursite'); ?></option>
                        <option value="middle" <?php selected($hyphens_allowed, 'middle'); ?>><?php _e('Middle only', 'yoursite'); ?></option>
                        <option value="start_middle" <?php selected($hyphens_allowed, 'start_middle'); ?>><?php _e('Start and middle', 'yoursite'); ?></option>
                        <option value="all" <?php selected($hyphens_allowed, 'all'); ?>><?php _e('Start, middle, and end', 'yoursite'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="domain_idn_allowed"><?php _e('IDN Allowed', 'yoursite'); ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" id="domain_idn_allowed" name="domain_idn_allowed" value="1" <?php checked($idn_allowed, '1'); ?> />
                        <?php _e('Yes, Internationalized Domain Names are allowed', 'yoursite'); ?>
                    </label>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Render Registry Information Meta Box
     */
    public function render_registry_info_meta_box($post) {
        $registry = get_post_meta($post->ID, '_domain_registry', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="domain_registry"><?php _e('Domain Registry', 'yoursite'); ?></label></th>
                <td>
                    <input type="text" id="domain_registry" name="domain_registry" value="<?php echo esc_attr($registry); ?>" placeholder="Donuts Inc." class="widefat" />
                    <p class="description"><?php _e('The registry company that manages this TLD', 'yoursite'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Render Bulk Import Meta Box
     */
    public function render_bulk_import_meta_box($post) {
        ?>
        <div id="bulk-import-section">
            <p><?php _e('Upload a CSV file to bulk import domain information.', 'yoursite'); ?></p>
            
            <p><strong><?php _e('CSV Format:', 'yoursite'); ?></strong></p>
            <code style="display: block; background: #f0f0f0; padding: 10px; margin: 10px 0;">
                tld,registration_price,renewal_price,category,hero_h1,hero_subtitle
            </code>
            
            <input type="file" id="bulk_import_file" accept=".csv" />
            <button type="button" id="process_bulk_import" class="button button-secondary"><?php _e('Process Import', 'yoursite'); ?></button>
            
            <div id="import_progress" style="margin-top: 15px; display: none;">
                <div class="progress-bar" style="background: #ddd; height: 20px; border-radius: 10px;">
                    <div class="progress-fill" style="background: #0073aa; height: 100%; width: 0%; border-radius: 10px; transition: width 0.3s;"></div>
                </div>
                <p id="import_status"></p>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#process_bulk_import').click(function() {
                var fileInput = document.getElementById('bulk_import_file');
                var file = fileInput.files[0];
                
                if (!file) {
                    alert('<?php _e("Please select a CSV file first.", "yoursite"); ?>');
                    return;
                }
                
                var formData = new FormData();
                formData.append('action', 'bulk_import_domains');
                formData.append('csv_file', file);
                formData.append('nonce', '<?php echo wp_create_nonce("bulk_import_nonce"); ?>');
                
                $('#import_progress').show();
                $('#import_status').text('<?php _e("Processing...", "yoursite"); ?>');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#import_status').text('<?php _e("Import completed successfully!", "yoursite"); ?>');
                            $('.progress-fill').css('width', '100%');
                        } else {
                            $('#import_status').text('<?php _e("Import failed: ", "yoursite"); ?>' + response.data);
                        }
                    },
                    error: function() {
                        $('#import_status').text('<?php _e("Import failed due to server error.", "yoursite"); ?>');
                    }
                });
            });