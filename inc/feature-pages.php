<?php
/**
 * Feature Pages Post Type and Meta Boxes
 * File: inc/feature-pages.php
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class FeaturePagesPostType {
    
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    /**
     * Register Feature Pages Post Type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => 'Feature Pages',
            'singular_name'         => 'Feature Page',
            'menu_name'             => 'Feature Pages',
            'add_new'               => 'Add New',
            'add_new_item'          => 'Add New Feature',
            'edit_item'             => 'Edit Feature',
            'new_item'              => 'New Feature',
            'view_item'             => 'View Feature',
            'search_items'          => 'Search Features',
            'not_found'             => 'No features found',
            'not_found_in_trash'    => 'No features found in trash'
        );
        
        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'features'),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-star-filled',
            'supports'              => array('title', 'editor', 'excerpt', 'thumbnail')
        );
        
        register_post_type('feature_pages', $args);
    }
    
    /**
     * Add Meta Boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'feature_hero_settings',
            'Hero Section Settings',
            array($this, 'hero_settings_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_problem_solution',
            'Problem/Solution Section',
            array($this, 'problem_solution_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_roi_calculator',
            'ROI Calculator',
            array($this, 'roi_calculator_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_statistics',
            'Statistics Section',
            array($this, 'statistics_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_capabilities',
            'Key Capabilities',
            array($this, 'capabilities_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_usp_sections',
            'USP Sections',
            array($this, 'usp_sections_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_competitor_comparison',
            'Competitor Comparison',
            array($this, 'competitor_comparison_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_case_study',
            'Case Study Section',
            array($this, 'case_study_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_faqs',
            'FAQs Section',
            array($this, 'faqs_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_related_features',
            'Related Features',
            array($this, 'related_features_callback'),
            'feature_pages',
            'normal',
            'high'
        );
        
        add_meta_box(
            'feature_technical_info',
            'Technical Information',
            array($this, 'technical_info_callback'),
            'feature_pages',
            'normal',
            'high'
        );
    }
    
    /**
     * Hero Settings Callback
     */
    public function hero_settings_callback($post) {
        wp_nonce_field(basename(__FILE__), 'feature_nonce');
        
        $hero_subtitle = get_post_meta($post->ID, '_feature_hero_subtitle', true);
        $hero_bg_type = get_post_meta($post->ID, '_feature_hero_bg_type', true) ?: 'gradient';
        $hero_bg_image = get_post_meta($post->ID, '_feature_hero_bg_image', true);
        $hero_gradient_primary = get_post_meta($post->ID, '_feature_hero_gradient_primary', true) ?: '#1e3a8a';
        $hero_gradient_secondary = get_post_meta($post->ID, '_feature_hero_gradient_secondary', true) ?: '#7c3aed';
        $hero_cta_text = get_post_meta($post->ID, '_feature_hero_cta_text', true) ?: 'Start Free Trial';
        $hero_cta_url = get_post_meta($post->ID, '_feature_hero_cta_url', true) ?: home_url('/signup');
        ?>
        <table class="form-table">
            <tr>
                <th><label for="feature_hero_subtitle">Hero Subtitle</label></th>
                <td>
                    <textarea id="feature_hero_subtitle" name="feature_hero_subtitle" rows="3" class="large-text"><?php echo esc_textarea($hero_subtitle); ?></textarea>
                    <p class="description">Subtitle text that appears below the main title in the hero section.</p>
                </td>
            </tr>
            <tr>
                <th><label for="feature_hero_bg_type">Background Type</label></th>
                <td>
                    <select id="feature_hero_bg_type" name="feature_hero_bg_type">
                        <option value="gradient" <?php selected($hero_bg_type, 'gradient'); ?>>Gradient</option>
                        <option value="image" <?php selected($hero_bg_type, 'image'); ?>>Image</option>
                        <option value="image_gradient" <?php selected($hero_bg_type, 'image_gradient'); ?>>Image + Gradient Overlay</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="feature_hero_bg_image">Background Image</label></th>
                <td>
                    <input type="text" id="feature_hero_bg_image" name="feature_hero_bg_image" value="<?php echo esc_url($hero_bg_image); ?>" class="large-text" />
                    <button type="button" class="button" id="upload_hero_bg_image">Upload Image</button>
                    <p class="description">Background image for the hero section.</p>
                </td>
            </tr>
            <tr>
                <th><label for="feature_hero_gradient_primary">Primary Gradient Color</label></th>
                <td>
                    <input type="color" id="feature_hero_gradient_primary" name="feature_hero_gradient_primary" value="<?php echo esc_attr($hero_gradient_primary); ?>" />
                </td>
            </tr>
            <tr>
                <th><label for="feature_hero_gradient_secondary">Secondary Gradient Color</label></th>
                <td>
                    <input type="color" id="feature_hero_gradient_secondary" name="feature_hero_gradient_secondary" value="<?php echo esc_attr($hero_gradient_secondary); ?>" />
                </td>
            </tr>
            <tr>
                <th><label for="feature_hero_cta_text">CTA Button Text</label></th>
                <td>
                    <input type="text" id="feature_hero_cta_text" name="feature_hero_cta_text" value="<?php echo esc_attr($hero_cta_text); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="feature_hero_cta_url">CTA Button URL</label></th>
                <td>
                    <input type="url" id="feature_hero_cta_url" name="feature_hero_cta_url" value="<?php echo esc_url($hero_cta_url); ?>" class="large-text" />
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Problem/Solution Callback
     */
    public function problem_solution_callback($post) {
        $problem_points = get_post_meta($post->ID, '_feature_problem_points', true) ?: array();
        $solution_points = get_post_meta($post->ID, '_feature_solution_points', true) ?: array();
        ?>
        <div class="feature-problem-solution-wrapper">
            <h4>Problem Points (What users face without your solution)</h4>
            <div id="problem-points-container">
                <?php
                if (!empty($problem_points)) {
                    foreach ($problem_points as $index => $point) {
                        ?>
                        <div class="problem-point-item">
                            <input type="text" name="feature_problem_points[]" value="<?php echo esc_attr($point); ?>" class="large-text" placeholder="Enter problem point" />
                            <button type="button" class="button remove-point">Remove</button>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button" id="add-problem-point">Add Problem Point</button>
            
            <h4 style="margin-top: 30px;">Solution Points (How your platform solves it)</h4>
            <div id="solution-points-container">
                <?php
                if (!empty($solution_points)) {
                    foreach ($solution_points as $index => $point) {
                        ?>
                        <div class="solution-point-item">
                            <input type="text" name="feature_solution_points[]" value="<?php echo esc_attr($point); ?>" class="large-text" placeholder="Enter solution point" />
                            <button type="button" class="button remove-point">Remove</button>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button" id="add-solution-point">Add Solution Point</button>
        </div>
        <?php
    }
    
    /**
     * ROI Calculator Callback
     */
    public function roi_calculator_callback($post) {
        $roi_current_time = get_post_meta($post->ID, '_feature_roi_current_time', true) ?: '20 hours/week';
        $roi_current_cost_hour = get_post_meta($post->ID, '_feature_roi_current_cost_hour', true) ?: '$50';
        $roi_current_monthly = get_post_meta($post->ID, '_feature_roi_current_monthly', true) ?: '$4,000';
        $roi_current_lost_opportunities = get_post_meta($post->ID, '_feature_roi_current_lost_opportunities', true) ?: '$2,000';
        $roi_current_total = get_post_meta($post->ID, '_feature_roi_current_total', true) ?: '$6,000';
        
        $roi_with_time = get_post_meta($post->ID, '_feature_roi_with_time', true) ?: '2 hours/week';
        $roi_with_platform_cost = get_post_meta($post->ID, '_feature_roi_with_platform_cost', true) ?: '$197/month';
        $roi_with_monthly_savings = get_post_meta($post->ID, '_feature_roi_with_monthly_savings', true) ?: '$4,400';
        $roi_with_new_opportunities = get_post_meta($post->ID, '_feature_roi_with_new_opportunities', true) ?: '$3,200';
        $roi_with_net_gain = get_post_meta($post->ID, '_feature_roi_with_net_gain', true) ?: '+$7,403';
        
        $roi_annual_savings = get_post_meta($post->ID, '_feature_roi_annual_savings', true) ?: '$88,836';
        $roi_percentage = get_post_meta($post->ID, '_feature_roi_percentage', true) ?: '4,486%';
        $roi_payback_period = get_post_meta($post->ID, '_feature_roi_payback_period', true) ?: '3 days';
        ?>
        <div class="roi-calculator-wrapper">
            <h4>Current Costs (Without Your Platform)</h4>
            <table class="form-table">
                <tr>
                    <th><label>Time spent manually:</label></th>
                    <td><input type="text" name="feature_roi_current_time" value="<?php echo esc_attr($roi_current_time); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>Cost per hour:</label></th>
                    <td><input type="text" name="feature_roi_current_cost_hour" value="<?php echo esc_attr($roi_current_cost_hour); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>Monthly cost:</label></th>
                    <td><input type="text" name="feature_roi_current_monthly" value="<?php echo esc_attr($roi_current_monthly); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>Lost opportunities:</label></th>
                    <td><input type="text" name="feature_roi_current_lost_opportunities" value="<?php echo esc_attr($roi_current_lost_opportunities); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>Total monthly cost:</label></th>
                    <td><input type="text" name="feature_roi_current_total" value="<?php echo esc_attr($roi_current_total); ?>" class="regular-text" /></td>
                </tr>
            </table>
            
            <h4>With Your Platform</h4>
            <table class="form-table">
                <tr>
                    <th><label>Time spent manually:</label></th>
                    <td><input type="text" name="feature_roi_with_time" value="<?php echo esc_attr($roi_with_time); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>Platform cost:</label></th>
                    <td><input type="text" name="feature_roi_with_platform_cost" value="<?php echo esc_attr($roi_with_platform_cost); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>Monthly savings:</label></th>
                    <td><input type="text" name="feature_roi_with_monthly_savings" value="<?php echo esc_attr($roi_with_monthly_savings); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>New opportunities:</label></th>
                    <td><input type="text" name="feature_roi_with_new_opportunities" value="<?php echo esc_attr($roi_with_new_opportunities); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>Net monthly gain:</label></th>
                    <td><input type="text" name="feature_roi_with_net_gain" value="<?php echo esc_attr($roi_with_net_gain); ?>" class="regular-text" /></td>
                </tr>
            </table>
            
            <h4>ROI Highlight</h4>
            <table class="form-table">
                <tr>
                    <th><label>Annual savings:</label></th>
                    <td><input type="text" name="feature_roi_annual_savings" value="<?php echo esc_attr($roi_annual_savings); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>ROI percentage:</label></th>
                    <td><input type="text" name="feature_roi_percentage" value="<?php echo esc_attr($roi_percentage); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label>Payback period:</label></th>
                    <td><input type="text" name="feature_roi_payback_period" value="<?php echo esc_attr($roi_payback_period); ?>" class="regular-text" /></td>
                </tr>
            </table>
        </div>
        <?php
    }
    
    /**
     * Statistics Callback
     */
    public function statistics_callback($post) {
        $statistics = get_post_meta($post->ID, '_feature_statistics', true) ?: array();
        ?>
        <div class="feature-statistics-wrapper">
            <div id="statistics-container">
                <?php
                if (!empty($statistics)) {
                    foreach ($statistics as $index => $stat) {
                        ?>
                        <div class="statistic-item">
                            <h4>Statistic <?php echo $index + 1; ?></h4>
                            <table class="form-table">
                                <tr>
                                    <th><label>Number/Percentage:</label></th>
                                    <td><input type="text" name="feature_statistics[<?php echo $index; ?>][number]" value="<?php echo esc_attr($stat['number'] ?? ''); ?>" class="regular-text" placeholder="e.g., 250%, 99.9%, $88k" /></td>
                                </tr>
                                <tr>
                                    <th><label>Label:</label></th>
                                    <td><input type="text" name="feature_statistics[<?php echo $index; ?>][label]" value="<?php echo esc_attr($stat['label'] ?? ''); ?>" class="large-text" placeholder="e.g., Average Sales Increase" /></td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-statistic">Remove Statistic</button>
                            <hr />
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button" id="add-statistic">Add Statistic</button>
        </div>
        <?php
    }
    
    /**
     * Capabilities Callback
     */
    public function capabilities_callback($post) {
        $capabilities = get_post_meta($post->ID, '_feature_capabilities', true) ?: array();
        ?>
        <div class="feature-capabilities-wrapper">
            <div id="capabilities-container">
                <?php
                if (!empty($capabilities)) {
                    foreach ($capabilities as $index => $capability) {
                        ?>
                        <div class="capability-item">
                            <h4>Capability <?php echo $index + 1; ?></h4>
                            <table class="form-table">
                                <tr>
                                    <th><label>Title:</label></th>
                                    <td><input type="text" name="feature_capabilities[<?php echo $index; ?>][title]" value="<?php echo esc_attr($capability['title'] ?? ''); ?>" class="large-text" /></td>
                                </tr>
                                <tr>
                                    <th><label>Description:</label></th>
                                    <td><textarea name="feature_capabilities[<?php echo $index; ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($capability['description'] ?? ''); ?></textarea></td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-capability">Remove Capability</button>
                            <hr />
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button" id="add-capability">Add Capability</button>
        </div>
        <?php
    }
    
    /**
     * USP Sections Callback
     */
    public function usp_sections_callback($post) {
        $usp_sections = get_post_meta($post->ID, '_feature_usp_sections', true) ?: array();
        ?>
        <div class="feature-usp-sections-wrapper">
            <div id="usp-sections-container">
                <?php
                if (!empty($usp_sections)) {
                    foreach ($usp_sections as $index => $usp) {
                        ?>
                        <div class="usp-section-item">
                            <h4>USP Section <?php echo $index + 1; ?></h4>
                            <table class="form-table">
                                <tr>
                                    <th><label>Title:</label></th>
                                    <td><input type="text" name="feature_usp_sections[<?php echo $index; ?>][title]" value="<?php echo esc_attr($usp['title'] ?? ''); ?>" class="large-text" /></td>
                                </tr>
                                <tr>
                                    <th><label>Description:</label></th>
                                    <td><textarea name="feature_usp_sections[<?php echo $index; ?>][description]" rows="5" class="large-text"><?php echo esc_textarea($usp['description'] ?? ''); ?></textarea></td>
                                </tr>
                                <tr>
                                    <th><label>Visual Type:</label></th>
                                    <td>
                                        <select name="feature_usp_sections[<?php echo $index; ?>][type]">
                                            <option value="image" <?php selected($usp['type'] ?? '', 'image'); ?>>Image</option>
                                            <option value="svg" <?php selected($usp['type'] ?? '', 'svg'); ?>>SVG Code</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label>Image URL:</label></th>
                                    <td>
                                        <input type="text" name="feature_usp_sections[<?php echo $index; ?>][image]" value="<?php echo esc_url($usp['image'] ?? ''); ?>" class="large-text" />
                                        <button type="button" class="button upload-image-btn">Upload Image</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label>SVG Code:</label></th>
                                    <td><textarea name="feature_usp_sections[<?php echo $index; ?>][svg_code]" rows="5" class="large-text"><?php echo esc_textarea($usp['svg_code'] ?? ''); ?></textarea></td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-usp-section">Remove USP Section</button>
                            <hr />
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button" id="add-usp-section">Add USP Section</button>
        </div>
        <?php
    }
    
    /**
     * Competitor Comparison Callback
     */
    public function competitor_comparison_callback($post) {
        $comparison_rows = get_post_meta($post->ID, '_feature_comparison_rows', true) ?: array();
        ?>
        <div class="feature-comparison-wrapper">
            <div id="comparison-rows-container">
                <?php
                if (!empty($comparison_rows)) {
                    foreach ($comparison_rows as $index => $row) {
                        ?>
                        <div class="comparison-row-item">
                            <h4>Comparison Row <?php echo $index + 1; ?></h4>
                            <table class="form-table">
                                <tr>
                                    <th><label>Feature Name:</label></th>
                                    <td><input type="text" name="feature_comparison_rows[<?php echo $index; ?>][feature_name]" value="<?php echo esc_attr($row['feature_name'] ?? ''); ?>" class="large-text" /></td>
                                </tr>
                                <tr>
                                    <th><label>Our Platform:</label></th>
                                    <td><input type="text" name="feature_comparison_rows[<?php echo $index; ?>][our_platform]" value="<?php echo esc_attr($row['our_platform'] ?? ''); ?>" class="large-text" /></td>
                                </tr>
                                <tr>
                                    <th><label>Competitors:</label></th>
                                    <td><input type="text" name="feature_comparison_rows[<?php echo $index; ?>][competitors]" value="<?php echo esc_attr($row['competitors'] ?? ''); ?>" class="large-text" /></td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-comparison-row">Remove Row</button>
                            <hr />
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button" id="add-comparison-row">Add Comparison Row</button>
        </div>
        <?php
    }
    
    /**
     * Case Study Callback
     */
    public function case_study_callback($post) {
        $case_study_enable = get_post_meta($post->ID, '_feature_case_study_enable', true);
        $case_study_company = get_post_meta($post->ID, '_feature_case_study_company', true);
        $case_study_challenge = get_post_meta($post->ID, '_feature_case_study_challenge', true);
        $case_study_implementation = get_post_meta($post->ID, '_feature_case_study_implementation', true);
        $case_study_results = get_post_meta($post->ID, '_feature_case_study_results', true);
        $case_study_quote = get_post_meta($post->ID, '_feature_case_study_quote', true);
        $case_study_quote_author = get_post_meta($post->ID, '_feature_case_study_quote_author', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="feature_case_study_enable">Enable Case Study</label></th>
                <td>
                    <input type="checkbox" id="feature_case_study_enable" name="feature_case_study_enable" value="1" <?php checked($case_study_enable, 1); ?> />
                    <label for="feature_case_study_enable">Show case study section</label>
                </td>
            </tr>
            <tr>
                <th><label for="feature_case_study_company">Company Name</label></th>
                <td>
                    <input type="text" id="feature_case_study_company" name="feature_case_study_company" value="<?php echo esc_attr($case_study_company); ?>" class="large-text" />
                </td>
            </tr>
            <tr>
                <th><label for="feature_case_study_challenge">Challenge</label></th>
                <td>
                    <textarea id="feature_case_study_challenge" name="feature_case_study_challenge" rows="4" class="large-text"><?php echo esc_textarea($case_study_challenge); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="feature_case_study_implementation">Implementation/Solution</label></th>
                <td>
                    <textarea id="feature_case_study_implementation" name="feature_case_study_implementation" rows="4" class="large-text"><?php echo esc_textarea($case_study_implementation); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="feature_case_study_results">Results</label></th>
                <td>
                    <textarea id="feature_case_study_results" name="feature_case_study_results" rows="4" class="large-text"><?php echo esc_textarea($case_study_results); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="feature_case_study_quote">Testimonial Quote</label></th>
                <td>
                    <textarea id="feature_case_study_quote" name="feature_case_study_quote" rows="3" class="large-text"><?php echo esc_textarea($case_study_quote); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="feature_case_study_quote_author">Quote Author</label></th>
                <td>
                    <input type="text" id="feature_case_study_quote_author" name="feature_case_study_quote_author" value="<?php echo esc_attr($case_study_quote_author); ?>" class="large-text" />
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * FAQs Callback
     */
    public function faqs_callback($post) {
        $faqs = get_post_meta($post->ID, '_feature_faqs', true) ?: array();
        ?>
        <div class="feature-faqs-wrapper">
            <div id="faqs-container">
                <?php
                if (!empty($faqs)) {
                    foreach ($faqs as $index => $faq) {
                        ?>
                        <div class="faq-item">
                            <h4>FAQ <?php echo $index + 1; ?></h4>
                            <table class="form-table">
                                <tr>
                                    <th><label>Question:</label></th>
                                    <td><input type="text" name="feature_faqs[<?php echo $index; ?>][question]" value="<?php echo esc_attr($faq['question'] ?? ''); ?>" class="large-text" /></td>
                                </tr>
                                <tr>
                                    <th><label>Answer:</label></th>
                                    <td><textarea name="feature_faqs[<?php echo $index; ?>][answer]" rows="4" class="large-text"><?php echo esc_textarea($faq['answer'] ?? ''); ?></textarea></td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-faq">Remove FAQ</button>
                            <hr />
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button" id="add-faq">Add FAQ</button>
        </div>
        <?php
    }
    
    /**
     * Related Features Callback
     */
    public function related_features_callback($post) {
        $related_features = get_post_meta($post->ID, '_feature_related_features', true) ?: array();
        $all_features = get_posts(array(
            'post_type' => 'feature_pages',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'exclude' => array($post->ID)
        ));
        ?>
        <div class="feature-related-features-wrapper">
            <p>Select related features to display at the bottom of this page:</p>
            <?php if (!empty($all_features)) : ?>
                <?php foreach ($all_features as $feature) : ?>
                    <label style="display: block; margin-bottom: 10px;">
                        <input type="checkbox" name="feature_related_features[]" value="<?php echo $feature->ID; ?>" <?php checked(in_array($feature->ID, $related_features)); ?> />
                        <?php echo esc_html($feature->post_title); ?>
                    </label>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No other feature pages found.</p>
            <?php endif; ?>
        </div>
        <?php
    }
    
    /**
     * Technical Info Callback
     */
    public function technical_info_callback($post) {
        $setup_steps = get_post_meta($post->ID, '_feature_setup_steps', true);
        $api_info = get_post_meta($post->ID, '_feature_api_info', true);
        $technical_notes = get_post_meta($post->ID, '_feature_technical_notes', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="feature_setup_steps">Setup Steps</label></th>
                <td>
                    <textarea id="feature_setup_steps" name="feature_setup_steps" rows="6" class="large-text"><?php echo esc_textarea($setup_steps); ?></textarea>
                    <p class="description">Step-by-step setup instructions (optional).</p>
                </td>
            </tr>
            <tr>
                <th><label for="feature_api_info">API Information</label></th>
                <td>
                    <textarea id="feature_api_info" name="feature_api_info" rows="6" class="large-text"><?php echo esc_textarea($api_info); ?></textarea>
                    <p class="description">API documentation or integration details (optional).</p>
                </td>
            </tr>
            <tr>
                <th><label for="feature_technical_notes">Technical Notes</label></th>
                <td>
                    <textarea id="feature_technical_notes" name="feature_technical_notes" rows="6" class="large-text"><?php echo esc_textarea($technical_notes); ?></textarea>
                    <p class="description">Additional technical information (optional).</p>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Save Meta Boxes
     */
    public function save_meta_boxes($post_id) {
        if (!isset($_POST['feature_nonce']) || !wp_verify_nonce($_POST['feature_nonce'], basename(__FILE__))) {
            return $post_id;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
        
        // Hero Settings
        $hero_fields = array(
            'feature_hero_subtitle',
            'feature_hero_bg_type',
            'feature_hero_bg_image',
            'feature_hero_gradient_primary',
            'feature_hero_gradient_secondary',
            'feature_hero_cta_text',
            'feature_hero_cta_url'
        );
        
        foreach ($hero_fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
        
        // Problem/Solution Points
        if (isset($_POST['feature_problem_points'])) {
            $problem_points = array_map('sanitize_text_field', $_POST['feature_problem_points']);
            $problem_points = array_filter($problem_points);
            update_post_meta($post_id, '_feature_problem_points', $problem_points);
        }
        
        if (isset($_POST['feature_solution_points'])) {
            $solution_points = array_map('sanitize_text_field', $_POST['feature_solution_points']);
            $solution_points = array_filter($solution_points);
            update_post_meta($post_id, '_feature_solution_points', $solution_points);
        }
        
        // ROI Calculator
        $roi_fields = array(
            'feature_roi_current_time',
            'feature_roi_current_cost_hour',
            'feature_roi_current_monthly',
            'feature_roi_current_lost_opportunities',
            'feature_roi_current_total',
            'feature_roi_with_time',
            'feature_roi_with_platform_cost',
            'feature_roi_with_monthly_savings',
            'feature_roi_with_new_opportunities',
            'feature_roi_with_net_gain',
            'feature_roi_annual_savings',
            'feature_roi_percentage',
            'feature_roi_payback_period'
        );
        
        foreach ($roi_fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
        
        // Statistics
        if (isset($_POST['feature_statistics'])) {
            $statistics = array();
            foreach ($_POST['feature_statistics'] as $stat) {
                if (!empty($stat['number']) && !empty($stat['label'])) {
                    $statistics[] = array(
                        'number' => sanitize_text_field($stat['number']),
                        'label' => sanitize_text_field($stat['label'])
                    );
                }
            }
            update_post_meta($post_id, '_feature_statistics', $statistics);
        }
        
        // Capabilities
        if (isset($_POST['feature_capabilities'])) {
            $capabilities = array();
            foreach ($_POST['feature_capabilities'] as $capability) {
                if (!empty($capability['title']) && !empty($capability['description'])) {
                    $capabilities[] = array(
                        'title' => sanitize_text_field($capability['title']),
                        'description' => sanitize_textarea_field($capability['description'])
                    );
                }
            }
            update_post_meta($post_id, '_feature_capabilities', $capabilities);
        }
        
        // USP Sections
        if (isset($_POST['feature_usp_sections'])) {
            $usp_sections = array();
            foreach ($_POST['feature_usp_sections'] as $usp) {
                if (!empty($usp['title']) && !empty($usp['description'])) {
                    $usp_sections[] = array(
                        'title' => sanitize_text_field($usp['title']),
                        'description' => sanitize_textarea_field($usp['description']),
                        'type' => sanitize_text_field($usp['type'] ?? 'image'),
                        'image' => esc_url_raw($usp['image'] ?? ''),
                        'svg_code' => wp_kses_post($usp['svg_code'] ?? '')
                    );
                }
            }
            update_post_meta($post_id, '_feature_usp_sections', $usp_sections);
        }
        
        // Competitor Comparison
        if (isset($_POST['feature_comparison_rows'])) {
            $comparison_rows = array();
            foreach ($_POST['feature_comparison_rows'] as $row) {
                if (!empty($row['feature_name']) && !empty($row['our_platform']) && !empty($row['competitors'])) {
                    $comparison_rows[] = array(
                        'feature_name' => sanitize_text_field($row['feature_name']),
                        'our_platform' => sanitize_text_field($row['our_platform']),
                        'competitors' => sanitize_text_field($row['competitors'])
                    );
                }
            }
            update_post_meta($post_id, '_feature_comparison_rows', $comparison_rows);
        }
        
        // Case Study
        $case_study_fields = array(
            'feature_case_study_enable' => 'checkbox',
            'feature_case_study_company' => 'text',
            'feature_case_study_challenge' => 'textarea',
            'feature_case_study_implementation' => 'textarea',
            'feature_case_study_results' => 'textarea',
            'feature_case_study_quote' => 'textarea',
            'feature_case_study_quote_author' => 'text'
        );
        
        foreach ($case_study_fields as $field => $type) {
            if ($type === 'checkbox') {
                $value = isset($_POST[$field]) ? 1 : 0;
                update_post_meta($post_id, '_' . $field, $value);
            } elseif ($type === 'textarea') {
                if (isset($_POST[$field])) {
                    update_post_meta($post_id, '_' . $field, sanitize_textarea_field($_POST[$field]));
                }
            } else {
                if (isset($_POST[$field])) {
                    update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
                }
            }
        }
        
        // FAQs
        if (isset($_POST['feature_faqs'])) {
            $faqs = array();
            foreach ($_POST['feature_faqs'] as $faq) {
                if (!empty($faq['question']) && !empty($faq['answer'])) {
                    $faqs[] = array(
                        'question' => sanitize_text_field($faq['question']),
                        'answer' => sanitize_textarea_field($faq['answer'])
                    );
                }
            }
            update_post_meta($post_id, '_feature_faqs', $faqs);
        }
        
        // Related Features
        if (isset($_POST['feature_related_features'])) {
            $related_features = array_map('intval', $_POST['feature_related_features']);
            update_post_meta($post_id, '_feature_related_features', $related_features);
        } else {
            update_post_meta($post_id, '_feature_related_features', array());
        }
        
        // Technical Info
        $technical_fields = array(
            'feature_setup_steps',
            'feature_api_info',
            'feature_technical_notes'
        );
        
        foreach ($technical_fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_textarea_field($_POST[$field]));
            }
        }
    }
    
    /**
     * Enqueue Admin Scripts
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'post.php' && $hook !== 'post-new.php') {
            return;
        }
        
        global $post;
        if (!$post || $post->post_type !== 'feature_pages') {
            return;
        }
        
        wp_enqueue_media();
    }
}

// Initialize the class
new FeaturePagesPostType();

// Add admin CSS and JS inline
add_action('admin_head', function() {
    global $post;
    if (!$post || $post->post_type !== 'feature_pages') {
        return;
    }
    ?>
    <style>
    .feature-problem-solution-wrapper .problem-point-item,
    .feature-problem-solution-wrapper .solution-point-item,
    .feature-statistics-wrapper .statistic-item,
    .feature-capabilities-wrapper .capability-item,
    .feature-usp-sections-wrapper .usp-section-item,
    .feature-comparison-wrapper .comparison-row-item,
    .feature-faqs-wrapper .faq-item {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f9f9f9;
    }
    
    .feature-problem-solution-wrapper .problem-point-item input,
    .feature-problem-solution-wrapper .solution-point-item input {
        width: 80%;
        margin-right: 10px;
    }
    
    .remove-point,
    .remove-statistic,
    .remove-capability,
    .remove-usp-section,
    .remove-comparison-row,
    .remove-faq {
        background: #dc3545;
        color: white;
        border: none;
        margin-top: 10px;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }
    
    .remove-point:hover,
    .remove-statistic:hover,
    .remove-capability:hover,
    .remove-usp-section:hover,
    .remove-comparison-row:hover,
    .remove-faq:hover {
        background: #c82333;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Media uploader
        function initializeMediaUploader() {
            $('.upload-image-btn, #upload_hero_bg_image').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var input = button.prev('input[type="text"]');
                
                var mediaUploader = wp.media({
                    title: 'Select Image',
                    button: {text: 'Use this image'},
                    multiple: false
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    input.val(attachment.url);
                });
                
                mediaUploader.open();
            });
        }
        
        initializeMediaUploader();
        
        // Problem/Solution Points
        $('#add-problem-point').click(function() {
            var html = '<div class="problem-point-item">' +
                '<input type="text" name="feature_problem_points[]" value="" class="large-text" placeholder="Enter problem point" />' +
                '<button type="button" class="button remove-point">Remove</button>' +
                '</div>';
            $('#problem-points-container').append(html);
        });
        
        $('#add-solution-point').click(function() {
            var html = '<div class="solution-point-item">' +
                '<input type="text" name="feature_solution_points[]" value="" class="large-text" placeholder="Enter solution point" />' +
                '<button type="button" class="button remove-point">Remove</button>' +
                '</div>';
            $('#solution-points-container').append(html);
        });
        
        // Statistics
        var statisticIndex = $('#statistics-container .statistic-item').length;
        $('#add-statistic').click(function() {
            var html = '<div class="statistic-item">' +
                '<h4>Statistic ' + (statisticIndex + 1) + '</h4>' +
                '<table class="form-table">' +
                '<tr><th><label>Number/Percentage:</label></th><td><input type="text" name="feature_statistics[' + statisticIndex + '][number]" value="" class="regular-text" placeholder="e.g., 250%, 99.9%, $88k" /></td></tr>' +
                '<tr><th><label>Label:</label></th><td><input type="text" name="feature_statistics[' + statisticIndex + '][label]" value="" class="large-text" placeholder="e.g., Average Sales Increase" /></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-statistic">Remove Statistic</button>' +
                '<hr />' +
                '</div>';
            $('#statistics-container').append(html);
            statisticIndex++;
        });
        
        // Capabilities
        var capabilityIndex = $('#capabilities-container .capability-item').length;
        $('#add-capability').click(function() {
            var html = '<div class="capability-item">' +
                '<h4>Capability ' + (capabilityIndex + 1) + '</h4>' +
                '<table class="form-table">' +
                '<tr><th><label>Title:</label></th><td><input type="text" name="feature_capabilities[' + capabilityIndex + '][title]" value="" class="large-text" /></td></tr>' +
                '<tr><th><label>Description:</label></th><td><textarea name="feature_capabilities[' + capabilityIndex + '][description]" rows="3" class="large-text"></textarea></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-capability">Remove Capability</button>' +
                '<hr />' +
                '</div>';
            $('#capabilities-container').append(html);
            capabilityIndex++;
        });
        
        // USP Sections
        var uspIndex = $('#usp-sections-container .usp-section-item').length;
        $('#add-usp-section').click(function() {
            var html = '<div class="usp-section-item">' +
                '<h4>USP Section ' + (uspIndex + 1) + '</h4>' +
                '<table class="form-table">' +
                '<tr><th><label>Title:</label></th><td><input type="text" name="feature_usp_sections[' + uspIndex + '][title]" value="" class="large-text" /></td></tr>' +
                '<tr><th><label>Description:</label></th><td><textarea name="feature_usp_sections[' + uspIndex + '][description]" rows="5" class="large-text"></textarea></td></tr>' +
                '<tr><th><label>Visual Type:</label></th><td><select name="feature_usp_sections[' + uspIndex + '][type]"><option value="image">Image</option><option value="svg">SVG Code</option></select></td></tr>' +
                '<tr><th><label>Image URL:</label></th><td><input type="text" name="feature_usp_sections[' + uspIndex + '][image]" value="" class="large-text" /><button type="button" class="button upload-image-btn">Upload Image</button></td></tr>' +
                '<tr><th><label>SVG Code:</label></th><td><textarea name="feature_usp_sections[' + uspIndex + '][svg_code]" rows="5" class="large-text"></textarea></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-usp-section">Remove USP Section</button>' +
                '<hr />' +
                '</div>';
            $('#usp-sections-container').append(html);
            uspIndex++;
            initializeMediaUploader();
        });
        
        // Comparison Rows
        var comparisonIndex = $('#comparison-rows-container .comparison-row-item').length;
        $('#add-comparison-row').click(function() {
            var html = '<div class="comparison-row-item">' +
                '<h4>Comparison Row ' + (comparisonIndex + 1) + '</h4>' +
                '<table class="form-table">' +
                '<tr><th><label>Feature Name:</label></th><td><input type="text" name="feature_comparison_rows[' + comparisonIndex + '][feature_name]" value="" class="large-text" /></td></tr>' +
                '<tr><th><label>Our Platform:</label></th><td><input type="text" name="feature_comparison_rows[' + comparisonIndex + '][our_platform]" value="" class="large-text" /></td></tr>' +
                '<tr><th><label>Competitors:</label></th><td><input type="text" name="feature_comparison_rows[' + comparisonIndex + '][competitors]" value="" class="large-text" /></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-comparison-row">Remove Row</button>' +
                '<hr />' +
                '</div>';
            $('#comparison-rows-container').append(html);
            comparisonIndex++;
        });
        
        // FAQs
        var faqIndex = $('#faqs-container .faq-item').length;
        $('#add-faq').click(function() {
            var html = '<div class="faq-item">' +
                '<h4>FAQ ' + (faqIndex + 1) + '</h4>' +
                '<table class="form-table">' +
                '<tr><th><label>Question:</label></th><td><input type="text" name="feature_faqs[' + faqIndex + '][question]" value="" class="large-text" /></td></tr>' +
                '<tr><th><label>Answer:</label></th><td><textarea name="feature_faqs[' + faqIndex + '][answer]" rows="4" class="large-text"></textarea></td></tr>' +
                '</table>' +
                '<button type="button" class="button remove-faq">Remove FAQ</button>' +
                '<hr />' +
                '</div>';
            $('#faqs-container').append(html);
            faqIndex++;
        });
        
        // Remove handlers (using event delegation)
        $(document).on('click', '.remove-point', function() {
            $(this).closest('.problem-point-item, .solution-point-item').remove();
        });
        
        $(document).on('click', '.remove-statistic', function() {
            $(this).closest('.statistic-item').remove();
        });
        
        $(document).on('click', '.remove-capability', function() {
            $(this).closest('.capability-item').remove();
        });
        
        $(document).on('click', '.remove-usp-section', function() {
            $(this).closest('.usp-section-item').remove();
        });
        
        $(document).on('click', '.remove-comparison-row', function() {
            $(this).closest('.comparison-row-item').remove();
        });
        
        $(document).on('click', '.remove-faq', function() {
            $(this).closest('.faq-item').remove();
        });
        
        // Re-initialize media uploader for dynamically added buttons
        $(document).on('click', '.upload-image-btn', function(e) {
            e.preventDefault();
            var button = $(this);
            var input = button.prev('input[type="text"]');
            
            var mediaUploader = wp.media({
                title: 'Select Image',
                button: {text: 'Use this image'},
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                input.val(attachment.url);
            });
            
            mediaUploader.open();
        });
    });
    </script>
    <?php
});

/**
 * Helper function to get feature page data
 */
function get_feature_page_data($post_id) {
    return array(
        'hero_subtitle' => get_post_meta($post_id, '_feature_hero_subtitle', true),
        'hero_bg_type' => get_post_meta($post_id, '_feature_hero_bg_type', true) ?: 'gradient',
        'hero_bg_image' => get_post_meta($post_id, '_feature_hero_bg_image', true),
        'hero_gradient_primary' => get_post_meta($post_id, '_feature_hero_gradient_primary', true) ?: '#1e3a8a',
        'hero_gradient_secondary' => get_post_meta($post_id, '_feature_hero_gradient_secondary', true) ?: '#7c3aed',
        'hero_cta_text' => get_post_meta($post_id, '_feature_hero_cta_text', true) ?: 'Start Free Trial',
        'hero_cta_url' => get_post_meta($post_id, '_feature_hero_cta_url', true) ?: home_url('/signup'),
        'problem_points' => get_post_meta($post_id, '_feature_problem_points', true) ?: array(),
        'solution_points' => get_post_meta($post_id, '_feature_solution_points', true) ?: array(),
        'statistics' => get_post_meta($post_id, '_feature_statistics', true) ?: array(),
        'capabilities' => get_post_meta($post_id, '_feature_capabilities', true) ?: array(),
        'usp_sections' => get_post_meta($post_id, '_feature_usp_sections', true) ?: array(),
        'comparison_rows' => get_post_meta($post_id, '_feature_comparison_rows', true) ?: array(),
        'faqs' => get_post_meta($post_id, '_feature_faqs', true) ?: array(),
        'related_features' => get_post_meta($post_id, '_feature_related_features', true) ?: array(),
        'setup_steps' => get_post_meta($post_id, '_feature_setup_steps', true),
        'api_info' => get_post_meta($post_id, '_feature_api_info', true),
        'technical_notes' => get_post_meta($post_id, '_feature_technical_notes', true),
        'case_study_enable' => get_post_meta($post_id, '_feature_case_study_enable', true),
        'case_study_company' => get_post_meta($post_id, '_feature_case_study_company', true),
        'case_study_challenge' => get_post_meta($post_id, '_feature_case_study_challenge', true),
        'case_study_implementation' => get_post_meta($post_id, '_feature_case_study_implementation', true),
        'case_study_results' => get_post_meta($post_id, '_feature_case_study_results', true),
        'case_study_quote' => get_post_meta($post_id, '_feature_case_study_quote', true),
        'case_study_quote_author' => get_post_meta($post_id, '_feature_case_study_quote_author', true)
    );
}

?>