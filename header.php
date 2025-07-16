<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript" src="https://zencommerce.net/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>

    <?php wp_head(); ?>
    
    <?php get_template_part('template-parts/header/header-styles'); ?>
    <?php get_template_part('template-parts/header/tailwind-config'); ?>
</head>

<body <?php body_class('font-sans antialiased'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
    <!-- Skip Link -->
    <a class="skip-link sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-zc-primary text-white px-4 py-2 rounded-lg z-50 font-medium" href="#primary">
        <?php esc_html_e('Skip to content', 'yoursite'); ?>
    </a>

    <?php get_template_part('template-parts/header/announcement-bar'); ?>
    
    <!-- Main Header -->
<header id="masthead" class="site-header header-glass relative z-50 transition-all duration-300">        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4 lg:py-6">
                
                <?php get_template_part('template-parts/header/logo'); ?>
                <?php get_template_part('template-parts/header/desktop-navigation'); ?>
                <?php get_template_part('template-parts/header/header-actions'); ?>
                <?php get_template_part('template-parts/header/mobile-toggle'); ?>
                
            </div>
        </div>
    </header>

    <?php get_template_part('template-parts/header/search-overlay'); ?>
    <?php get_template_part('template-parts/header/mobile-navigation'); ?>
    <?php get_template_part('template-parts/header/header-scripts'); ?>

    <main id="primary" class="site-main">