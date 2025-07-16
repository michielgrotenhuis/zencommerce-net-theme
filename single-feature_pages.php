<?php
/**
 * Enhanced Template for single feature pages - Conversion Optimized
 * File: single-feature_pages.php
 */

get_header();

// Get feature page data
$post_id = get_the_ID();
$hero_subtitle = get_post_meta($post_id, '_feature_hero_subtitle', true);
$hero_bg_type = get_post_meta($post_id, '_feature_hero_bg_type', true) ?: 'gradient';
$hero_bg_image = get_post_meta($post_id, '_feature_hero_bg_image', true);
$hero_gradient_primary = get_post_meta($post_id, '_feature_hero_gradient_primary', true) ?: '#1e3a8a';
$hero_gradient_secondary = get_post_meta($post_id, '_feature_hero_gradient_secondary', true) ?: '#7c3aed';
$hero_cta_text = get_post_meta($post_id, '_feature_hero_cta_text', true) ?: 'Start Free Trial';
$hero_cta_url = get_post_meta($post_id, '_feature_hero_cta_url', true) ?: home_url('/signup');


$solution_points = get_post_meta($post_id, '_feature_solution_points', true) ?: array();
$problem_points = get_post_meta($post_id, '_feature_problem_points', true) ?: array();
$capabilities = get_post_meta($post_id, '_feature_capabilities', true) ?: array();
$setup_steps = get_post_meta($post_id, '_feature_setup_steps', true);
$api_info = get_post_meta($post_id, '_feature_api_info', true);
$technical_notes = get_post_meta($post_id, '_feature_technical_notes', true);

$case_study_enable = get_post_meta($post_id, '_feature_case_study_enable', true);
$case_study_company = get_post_meta($post_id, '_feature_case_study_company', true);
$case_study_challenge = get_post_meta($post_id, '_feature_case_study_challenge', true);
$case_study_implementation = get_post_meta($post_id, '_feature_case_study_implementation', true);
$case_study_results = get_post_meta($post_id, '_feature_case_study_results', true);
$case_study_quote = get_post_meta($post_id, '_feature_case_study_quote', true);
$case_study_quote_author = get_post_meta($post_id, '_feature_case_study_quote_author', true);

$faqs = get_post_meta($post_id, '_feature_faqs', true) ?: array();
$related_features = get_post_meta($post_id, '_feature_related_features', true) ?: array();
$usp_sections = get_post_meta($post_id, '_feature_usp_sections', true) ?: array();

// Get current feature slug for comparison data
$current_feature_slug = get_post_field('post_name', $post_id);

// Generate hero background CSS
$hero_bg_css = '';
switch ($hero_bg_type) {
    case 'gradient':
        $hero_bg_css = 'background: linear-gradient(135deg, ' . esc_attr($hero_gradient_primary) . ' 0%, ' . esc_attr($hero_gradient_secondary) . ' 100%);';
        break;
    case 'image':
        if ($hero_bg_image) {
            $hero_bg_css = 'background: url("' . esc_url($hero_bg_image) . '") center/cover no-repeat;';
        }
        break;
    case 'image_gradient':
        if ($hero_bg_image) {
            $hero_bg_css = 'background: linear-gradient(135deg, ' . esc_attr($hero_gradient_primary) . '80 0%, ' . esc_attr($hero_gradient_secondary) . '80 100%), url("' . esc_url($hero_bg_image) . '") center/cover no-repeat;';
        }
        break;
}
?>

<style>
/* Enhanced Feature Page Styles - Conversion Optimized */
.feature-hero {
    <?php echo $hero_bg_css; ?>
    color: white;
    position: relative;
    overflow: hidden;
}

.feature-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.2);
    pointer-events: none;
}

.feature-hero::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
    pointer-events: none;
}

.problem-solution-section {
    background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
    position: relative;
}

.problem-solution-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #ef4444, #dc2626);
}

.problem-card {
    background: white;
    border-left: 4px solid #ef4444;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.problem-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.solution-card {
    background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
    border-left: 4px solid #10b981;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.solution-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.roi-calculator {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border: 1px solid #93c5fd;
    border-radius: 16px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.roi-calculator::before {
    content: '💰';
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 2rem;
    opacity: 0.3;
}

.roi-highlight {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    text-align: center;
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1rem;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.competitor-comparison {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
}

.comparison-header {
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-primary-dark) 100%);
    color: white;
    padding: 1.5rem;
    text-align: center;
    font-weight: 600;
    font-size: 1.125rem;
}

.comparison-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    border-bottom: 1px solid #e2e8f0;
    min-height: 60px;
}

.comparison-cell {
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    text-align: center;
    border-right: 1px solid #e2e8f0;
}

.comparison-cell:last-child {
    border-right: none;
}

.comparison-cell.feature-name {
    font-weight: 600;
    background: #f1f5f9;
}

.comparison-cell.our-feature {
    background: #ecfdf5;
    color: #065f46;
    font-weight: 600;
}

.comparison-cell.competitor-feature {
    background: #fef2f2;
    color: #991b1b;
}

.check-icon {
    color: #10b981;
    font-size: 1.25rem;
}

.x-icon {
    color: #ef4444;
    font-size: 1.25rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--zc-primary);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

.testimonial-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    position: relative;
    margin-top: 2rem;
}

.testimonial-card::before {
    content: '"';
    position: absolute;
    top: -10px;
    left: 20px;
    font-size: 4rem;
    color: var(--zc-primary);
    font-family: Georgia, serif;
}

.testimonial-content {
    font-style: italic;
    font-size: 1.125rem;
    color: #374151;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--zc-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.125rem;
}

.author-info h4 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
}

.author-info p {
    margin: 0;
    font-size: 0.875rem;
    color: #6b7280;
}

.cta-section {
    background: linear-gradient(135deg, var(--zc-secondary) 0%, var(--zc-primary) 100%);
    color: white;
    padding: 4rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
}

.cta-content {
    position: relative;
    z-index: 2;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    align-items: center;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.cta-primary {
    background: white;
    color: var(--zc-secondary);
    padding: 1rem 2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.125rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
}

.cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    text-decoration: none;
    color: var(--zc-secondary);
}

.cta-secondary {
    background: transparent;
    color: white !important;
    padding: 1rem 2rem;
    border: 2px solid white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.125rem;
    transition: all 0.3s ease;
}

.cta-secondary:hover {
    background: white;
    color: var(--zc-secondary) !important;
    text-decoration: none;
}

.trust-indicators {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.trust-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    opacity: 0.9;
}

.breadcrumb-nav {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 0;
}

.breadcrumb-nav ol {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-nav a {
    color: #6b7280;
    text-decoration: none;
    font-size: 0.875rem;
}

.breadcrumb-nav a:hover {
    color: var(--zc-primary);
}

.breadcrumb-nav .current {
    color: #111827;
    font-weight: 500;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .comparison-row {
        grid-template-columns: 1fr;
    }
    
    .comparison-cell {
        border-right: none;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .cta-primary,
    .cta-secondary {
        text-align: center;
    }
    
    .trust-indicators {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<!-- Breadcrumb Navigation -->
<nav class="breadcrumb-nav">
    <div class="container mx-auto px-4">
        <ol>
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li><span class="mx-2 text-gray-400">/</span></li>
            <li><a href="<?php echo get_post_type_archive_link('feature_pages'); ?>">Features</a></li>
            <li><span class="mx-2 text-gray-400">/</span></li>
            <li class="current"><?php the_title(); ?></li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="feature-hero py-20 lg:py-32 relative">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>Powerful Feature</span>
            </div>
            
            <h1 class="text-white text-4xl lg:text-6xl font-bold mb-6">
                <?php the_title(); ?>
            </h1>
            
            <?php if ($hero_subtitle) : ?>
                <p class="text-white text-xl lg:text-2xl mb-8 opacity-90 max-w-4xl mx-auto">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
            <?php endif; ?>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?php echo esc_url($hero_cta_url); ?>" class="cta-primary">
                    <?php echo esc_html($hero_cta_text); ?>
                </a>
                <a href="#learn-more" class="cta-secondary text-white hover:text-black">
                    See How It Works
                </a>
            </div>
            
            <div class="trust-indicators">
                <div class="trust-indicator">
                    <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>14-day free trial</span>
                </div>
                <div class="trust-indicator">
                    <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>No credit card required</span>
                </div>
                <div class="trust-indicator">
                    <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Used by 50,000+ businesses</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Problem/Solution Section -->
<section class="problem-solution-section py-20" id="learn-more">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    The Problem Most Businesses Face
                </h2>
                <p class="text-xl text-gray-600">
                    And how we solve it better than anyone else
                </p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8 items-start">
<div class="problem-card">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900">Without Our Solution</h3>
    </div>
    <div class="space-y-3">
        <?php if (!empty($problem_points)): ?>
            <?php foreach ($problem_points as $point): ?>
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                    <p class="text-gray-700"><?php echo esc_html($point); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback default content -->
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                <p class="text-gray-700">Hours wasted on manual processes</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                <p class="text-gray-700">Increased risk of human error</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                <p class="text-gray-700">Lost sales due to slow processes</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                <p class="text-gray-700">Frustrated customers and team</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="solution-card">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900">With Our Solution</h3>
    </div>
    <div class="space-y-3">
        <?php if (!empty($solution_points)): ?>
            <?php foreach ($solution_points as $point): ?>
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                    <p class="text-gray-700"><?php echo esc_html($point); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback bullets if no solution points are found -->
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                <p class="text-gray-700">99.9% accuracy guarantee</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                <p class="text-gray-700">3x faster execution</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                <p class="text-gray-700">Delighted customers & team</p>
            </div>
        <?php endif; ?>
    </div>
</div>



                      

  
</section>

<!-- ROI Calculator Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Calculate Your ROI
                </h2>
                <p class="text-xl text-gray-600">
                    See exactly how much money you'll save and earn
                </p>
            </div>
            
            <div class="roi-calculator">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Your Current Costs</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Time spent manually:</span>
                                <span class="font-semibold text-red-600">20 hours/week</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Cost per hour:</span>
                                <span class="font-semibold text-red-600">$50</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Monthly cost:</span>
                                <span class="font-semibold text-red-600">$4,000</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Lost opportunities:</span>
                                <span class="font-semibold text-red-600">$2,000</span>
                            </div>
                            <hr class="my-4">
                            <div class="flex justify-between items-center text-lg font-bold">
                                <span>Total Monthly Cost:</span>
                                <span class="text-red-600">$6,000</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">With Our Platform</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Time spent manually:</span>
                                <span class="font-semibold text-green-600">2 hours/week</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Platform cost:</span>
                                <span class="font-semibold text-green-600">$11/month</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Monthly savings:</span>
                                <span class="font-semibold text-green-600">$4,586</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">New opportunities:</span>
                                <span class="font-semibold text-green-600">$3,200</span>
                            </div>
                            <hr class="my-4">
                            <div class="flex justify-between items-center text-lg font-bold">
                                <span>Net Monthly Gain:</span>
                                <span class="text-green-600">+$7,403</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="roi-highlight">
                    <div class="text-2xl font-bold mb-2">You Save $88,836 Per Year</div>
                    <div class="text-lg opacity-90">ROI of 4,486% - Your investment pays for itself in just 3 days!</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Overview Section -->
<?php if (get_the_content()) : ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">How It Works</h2>
            </div>
            <div class="prose prose-lg max-w-none">
                <?php 
                if (has_excerpt()) {
                    echo '<div class="text-xl text-gray-600 mb-8">' . get_the_excerpt() . '</div>';
                }
                the_content(); 
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- USP Sections -->
<?php if (!empty($usp_sections)) : ?>
    <?php foreach ($usp_sections as $index => $usp) : ?>
        <section class="py-20 <?php echo ($index % 2 === 0) ? 'bg-white' : 'bg-gray-50'; ?>">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="grid lg:grid-cols-2 gap-12 items-center <?php echo ($index % 2 === 1) ? 'lg:flex-row-reverse' : ''; ?>">
                        <div class="<?php echo ($index % 2 === 1) ? 'lg:order-2' : ''; ?>">
                            <h3 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                                <?php echo esc_html($usp['title']); ?>
                            </h3>
                            <div class="text-lg text-gray-600 leading-relaxed">
                                <?php echo wpautop(wp_kses_post($usp['description'])); ?>
                            </div>
                        </div>
                        <div class="<?php echo ($index % 2 === 1) ? 'lg:order-1' : ''; ?>">
                            <?php if ($usp['type'] === 'image' && !empty($usp['image'])) : ?>
                                <img src="<?php echo esc_url($usp['image']); ?>" alt="<?php echo esc_attr($usp['title']); ?>" class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
                            <?php elseif ($usp['type'] === 'svg' && !empty($usp['svg_code'])) : ?>
                                <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                                    <?php echo wp_kses($usp['svg_code'], array(
                                        'svg' => array('class' => array(), 'xmlns' => array(), 'width' => array(), 'height' => array(), 'viewbox' => array(), 'viewBox' => array(), 'fill' => array(), 'stroke' => array()),
                                        'g' => array('fill' => array(), 'stroke' => array(), 'transform' => array()),
                                        'path' => array('d' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array()),
                                        'circle' => array('cx' => array(), 'cy' => array(), 'r' => array(), 'fill' => array()),
                                        'rect' => array('x' => array(), 'y' => array(), 'width' => array(), 'height' => array(), 'fill' => array()),
                                        'line' => array('x1' => array(), 'y1' => array(), 'x2' => array(), 'y2' => array(), 'stroke' => array(), 'stroke-width' => array()),
                                        'polyline' => array('points' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array()),
                                        'polygon' => array('points' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array()),
                                        'text' => array('x' => array(), 'y' => array(), 'font-family' => array(), 'font-size' => array(), 'fill' => array()),
                                        'defs' => array(),
                                        'clippath' => array('id' => array()),
                                        'clipPath' => array('id' => array()),
                                        'linearGradient' => array('id' => array(), 'x1' => array(), 'y1' => array(), 'x2' => array(), 'y2' => array()),
                                        'stop' => array('offset' => array(), 'stop-color' => array(), 'stop-opacity' => array()),
                                    )); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Competitive Advantage Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Why We're the Best Choice
                </h2>
                <p class="text-xl text-gray-600">
                    Compare us to the competition and see why thousands choose us
                </p>
            </div>
            
            <div class="competitor-comparison">
                <div class="comparison-header">
                    Feature Comparison
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature-name text-left">Features</div>
                    <div class="comparison-cell feature-name">Our Platform</div>
                    <div class="comparison-cell feature-name">Competitors</div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature-name">Setup Time</div>
                    <div class="comparison-cell our-feature">
                        <span class="check-icon">✓</span>
                        <span class="ml-2">15 minutes</span>
                    </div>
                    <div class="comparison-cell competitor-feature">
                        <span class="x-icon">✗</span>
                        <span class="ml-2">2-4 weeks</span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature-name">Technical Support</div>
                    <div class="comparison-cell our-feature">
                        <span class="check-icon">✓</span>
                        <span class="ml-2">24/7 Live Chat</span>
                    </div>
                    <div class="comparison-cell competitor-feature">
                        <span class="x-icon">✗</span>
                        <span class="ml-2">Email Only</span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature-name">Monthly Cost</div>
                    <div class="comparison-cell our-feature">
                        <span class="check-icon">✓</span>
                        <span class="ml-2">$11/month</span>
                    </div>
                    <div class="comparison-cell competitor-feature">
                        <span class="x-icon">✗</span>
                        <span class="ml-2">$500+ /month</span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature-name">Hidden Fees</div>
                    <div class="comparison-cell our-feature">
                        <span class="check-icon">✓</span>
                        <span class="ml-2">None</span>
                    </div>
                    <div class="comparison-cell competitor-feature">
                        <span class="x-icon">✗</span>
                        <span class="ml-2">Many</span>
                    </div>
                </div>
                
                <div class="comparison-row">
                    <div class="comparison-cell feature-name">Migration Help</div>
                    <div class="comparison-cell our-feature">
                        <span class="check-icon">✓</span>
                        <span class="ml-2">Free & Complete</span>
                    </div>
                    <div class="comparison-cell competitor-feature">
                        <span class="x-icon">✗</span>
                        <span class="ml-2">$2,000+ fee</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Proven Results
                </h2>
                <p class="text-xl text-gray-600">
                    Real numbers from real businesses
                </p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">250%</div>
                    <div class="stat-label">Average Sales Increase</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">87%</div>
                    <div class="stat-label">Time Savings</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime Guarantee</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">$88k</div>
                    <div class="stat-label">Average Annual Savings</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Key Capabilities Section -->
<?php if (!empty($capabilities)) : ?>
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Powerful Capabilities</h2>
                <p class="text-xl text-gray-600">Everything you need to succeed</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($capabilities as $index => $capability) : ?>
                    <div class="stat-card">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg mb-4 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">
                            <?php echo esc_html($capability['title']); ?>
                        </h3>
                        <p class="text-gray-600">
                            <?php echo esc_html($capability['description']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Case Study Section -->
<?php if ($case_study_enable && $case_study_company) : ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Success Story</h2>
                <p class="text-xl text-gray-600">See how <?php echo esc_html($case_study_company); ?> transformed their business</p>
            </div>
            
            <div class="grid lg:grid-cols-3 gap-8 mb-12">
                <?php if ($case_study_challenge) : ?>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">The Challenge</h3>
                        <p class="text-gray-600"><?php echo esc_html($case_study_challenge); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if ($case_study_implementation) : ?>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">The Solution</h3>
                        <p class="text-gray-600"><?php echo esc_html($case_study_implementation); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if ($case_study_results) : ?>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">The Results</h3>
                        <p class="text-gray-600"><?php echo esc_html($case_study_results); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($case_study_quote) : ?>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <?php echo esc_html($case_study_quote); ?>
                    </div>
                    <?php if ($case_study_quote_author) : ?>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <?php echo strtoupper(substr($case_study_quote_author, 0, 1)); ?>
                            </div>
                            <div class="author-info">
                                <h4><?php echo esc_html($case_study_quote_author); ?></h4>
                                <p><?php echo esc_html($case_study_company); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ Section -->
<?php if (!empty($faqs)) : ?>
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Common Questions</h2>
                <p class="text-xl text-gray-600">Everything you need to know</p>
            </div>
            
            <div class="space-y-4">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFAQ(<?php echo $index; ?>)">
                            <h3 class="text-lg font-semibold text-gray-900">
                                <?php echo esc_html($faq['question']); ?>
                            </h3>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-icon-<?php echo $index; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer faq-answer-<?php echo $index; ?> max-h-0 overflow-hidden transition-all duration-300">
                            <div class="px-6 pb-4 pt-4 text-gray-700">
                                <?php echo nl2br(esc_html($faq['answer'])); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Related Features Section -->
<?php if (!empty($related_features)) : ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Explore More Features</h2>
                <p class="text-xl text-gray-600">Discover other ways we can help your business</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                $related_posts = get_posts(array(
                    'post_type' => 'feature_pages',
                    'include' => $related_features,
                    'post_status' => 'publish'
                ));
                
                foreach ($related_posts as $related_post) :
                    $related_excerpt = get_the_excerpt($related_post->ID);
                    if (empty($related_excerpt)) {
                        $related_excerpt = wp_trim_words($related_post->post_content, 20);
                    }
                ?>
                    <div class="stat-card group">
                        <?php if (has_post_thumbnail($related_post->ID)) : ?>
                            <div class="mb-4 overflow-hidden rounded-lg">
                                <?php echo get_the_post_thumbnail($related_post->ID, 'medium', array('class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            <a href="<?php echo get_permalink($related_post->ID); ?>" class="hover:text-blue-600 transition-colors">
                                <?php echo esc_html($related_post->post_title); ?>
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 mb-4">
                            <?php echo esc_html($related_excerpt); ?>
                        </p>
                        
                        <a href="<?php echo get_permalink($related_post->ID); ?>" class="inline-flex items-center text-blue-600 font-medium hover:text-blue-700 transition-colors">
                            Learn more 
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
// FAQ functionality
function toggleFAQ(index) {
    const answer = document.querySelector('.faq-answer-' + index);
    const icon = document.querySelector('.faq-icon-' + index);
    
    if (answer.style.maxHeight && answer.style.maxHeight !== '0px') {
        answer.style.maxHeight = '0px';
        icon.style.transform = 'rotate(0deg)';
    } else {
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
    }
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Analytics tracking
function trackFeatureInteraction(action, featureName) {
    if (typeof gtag !== 'undefined') {
        gtag('event', 'feature_interaction', {
            'action': action,
            'feature_name': featureName,
            'page_title': document.title
        });
    }
}

// Track CTA clicks
document.querySelectorAll('.cta-primary, .cta-secondary').forEach(button => {
    button.addEventListener('click', function() {
        trackFeatureInteraction('cta_click', '<?php echo esc_js(get_the_title()); ?>');
    });
});
</script>

<?php get_footer(); ?>