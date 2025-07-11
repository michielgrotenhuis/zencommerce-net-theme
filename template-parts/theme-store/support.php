<?php
/**
 * Theme Store Support Section
 * template-parts/theme-store/support.php
 */

$theme_data = $args['theme_data'] ?? array();

// Check if any support information exists
$has_support_info = $theme_data['support_email'] || $theme_data['documentation_url'] || $theme_data['video_tutorials_url'] || $theme_data['developer'];

if ($has_support_info): ?>

<section class="theme-support">
    <div class="layout-container">
        <div class="support-grid">
            <!-- Main Support Info -->
            <div class="support-main">
                <h2 class="support-title">
                    Get Support for This Theme
                </h2>
                
                <p style="margin-bottom: 2rem; color: var(--zc-text-secondary, #5f5f5f); font-size: 1.125rem;">
                    This theme is professionally supported by <?php echo esc_html($theme_data['developer'] ?: 'our development team'); ?>. 
                    Get help with installation, customization, and any questions you might have.
                </p>
                
                <!-- Support Actions -->
                <div class="support-actions">
                    <?php if ($theme_data['support_email']): ?>
                    <a href="mailto:<?php echo esc_attr($theme_data['support_email']); ?>" class="support-btn support-btn-primary text-white">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email Support
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($theme_data['documentation_url']): ?>
                    <a href="<?php echo esc_url($theme_data['documentation_url']); ?>" target="_blank" class="support-btn support-btn-secondary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Documentation
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($theme_data['video_tutorials_url']): ?>
                    <a href="<?php echo esc_url($theme_data['video_tutorials_url']); ?>" target="_blank" class="support-btn support-btn-secondary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Video Tutorials
                    </a>
                    <?php endif; ?>
                </div>
                
                <!-- Included Support Features -->
                <?php if ($theme_data['support_features'] && is_array($theme_data['support_features']) && !empty($theme_data['support_features'])): ?>
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--zc-border, #f1f1f1);">
                    <h4 style="margin-bottom: 1rem; color: var(--zc-text-primary, #1c1c1c); font-weight: 600;">Support Includes:</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.75rem;">
                        <?php 
                        $support_labels = array(
                            'documentation' => 'Complete Documentation',
                            'video_tutorials' => 'Video Tutorials',
                            'email_support' => 'Email Support',
                            'forum_support' => 'Community Forum',
                            'free_updates' => 'Free Updates',
                            'child_theme' => 'Child Theme Included',
                            'lifetime_updates' => 'Lifetime Updates',
                            'priority_support' => 'Priority Support',
                            'installation_service' => 'Installation Service',
                            'customization_service' => 'Customization Service'
                        );
                        
                        foreach ($theme_data['support_features'] as $feature): 
                            $label = isset($support_labels[$feature]) ? $support_labels[$feature] : ucwords(str_replace('_', ' ', $feature));
                        ?>
                            <div style="display: flex; align-items: center; padding: 0.5rem 0.75rem; background: rgba(18, 111, 183, 0.05); border-radius: 6px; font-size: 0.875rem;">
                                <span style="color: var(--zc-success, #16a34a); margin-right: 0.5rem; font-weight: bold;">✓</span>
                                <span style="color: var(--zc-text-primary, #1c1c1c);"><?php echo esc_html($label); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Developer Info -->
            <?php if ($theme_data['developer']): ?>
            <div class="developer-info">
                <div class="developer-avatar">
                    <?php echo substr($theme_data['developer'], 0, 1); ?>
                </div>
                
                <h3 class="developer-name"><?php echo esc_html($theme_data['developer']); ?></h3>
                
                <div class="developer-meta">
                    <?php if ($theme_data['developer_address']): ?>
                        <div class="flex items-center" style="margin-bottom: 0.5rem;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem; vertical-align: middle;">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <?php echo nl2br(esc_html($theme_data['developer_address'])); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($theme_data['support_email']): ?>
                        <div class="flex items-center"  style="margin-bottom: 0.5rem;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem; vertical-align: middle;">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <?php echo esc_html($theme_data['support_email']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($theme_data['rating']): ?>
                        <div class="flex items-center" style="margin-bottom: 0.5rem;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem; vertical-align: middle;">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <?php echo $theme_data['rating']; ?>/5.0 rating
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($theme_data['version']): ?>
                        <div class="flex items-center" >
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem; vertical-align: middle;">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                            </svg>
                            Current version: <?php echo esc_html($theme_data['version']); ?>
                            <?php if ($theme_data['last_updated']): ?>
                                <br><small>Updated: <?php echo date('M j, Y', strtotime($theme_data['last_updated'])); ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php endif; ?>