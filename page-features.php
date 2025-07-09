<?php
/*
Template Name: Features Page
*/

get_header(); 
?>

<style>
/* Features Page Specific Styles - Zencommerce Inspired */
.features-pain-section {
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-primary-dark) 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.features-pain-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.5;
}

.features-solution-section {
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-primary-dark) 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.features-solution-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
}

.pain-point-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--zc-radius-xl);
    padding: 2rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.pain-point-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    transition: left 0.6s ease;
}

.pain-point-card:hover::before {
    left: 100%;
}

.pain-point-card:hover {
    transform: translateY(-4px);
    border-color: rgba(244, 180, 0, 0.3);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.pain-icon {
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border-radius: var(--zc-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.solution-icon {
    width: 3rem;
    height: 3rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: var(--zc-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.feature-deep-card {
    background: white;
    border: 1px solid var(--zc-border);
    border-radius: var(--zc-radius-xl);
    padding: 2.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.feature-deep-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-secondary) 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.feature-deep-card:hover::before {
    transform: scaleX(1);
}

.feature-deep-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border-color: var(--zc-primary);
}

.feature-category-icon {
    width: 4rem;
    height: 4rem;
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-primary-dark) 100%);
    border-radius: var(--zc-radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 20px rgba(244, 180, 0, 0.3);
}

.feature-benefit-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.feature-benefit-item:hover {
    background: rgba(244, 180, 0, 0.05);
    padding-left: 1rem;
    border-radius: var(--zc-radius-sm);
}

.feature-benefit-item:last-child {
    border-bottom: none;
}

.feature-cta-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--zc-primary) 0%, var(--zc-primary-dark) 100%);
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: var(--zc-radius-md);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    box-shadow: 0 4px 12px rgba(244, 180, 0, 0.25);
}

.feature-cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(244, 180, 0, 0.4);
    color: white;
    text-decoration: none;
}

.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--zc-radius-lg);
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--zc-primary);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-label {
    font-size: 0.9rem;
    color: var(--zc-text-secondary);
    font-weight: 500;
}

.transformation-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--zc-primary);
    font-size: 2rem;
    margin: 2rem 0;
}

/* Hero section text improvements */
.hero-badge {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hero-title {
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.hero-subtitle {
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.hero-cta-buttons .btn-primary {
    background: rgba(255, 255, 255, 0.95);
    color: var(--zc-primary);
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.hero-cta-buttons .btn-primary:hover {
    background: white;
    color: var(--zc-primary-dark);
}

.hero-stats {
    color: rgba(255, 255, 255, 0.8);
}

/* Button icon alignment fix */
.btn-with-icon {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
}

@media (max-width: 768px) {
    .pain-point-card,
    .feature-deep-card {
        padding: 1.5rem;
    }
    
    .feature-category-icon {
        width: 3rem;
        height: 3rem;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .transformation-arrow {
        transform: rotate(90deg);
    }
}
</style>

<?php
// Include template parts
get_template_part('template-parts/features/hero');
get_template_part('template-parts/features/problems');
get_template_part('template-parts/features/transformation-arrow');
get_template_part('template-parts/features/solutions');
get_template_part('template-parts/features/deep-dive');
get_template_part('template-parts/features/roi-calculator');
get_template_part('template-parts/features/success-stories');
get_template_part('template-parts/features/final-cta');
?>

<?php get_footer(); ?>