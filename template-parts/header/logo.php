<!-- Logo/Branding -->
<div class="site-branding flex items-center z-50">
    <?php if (has_custom_logo()) : ?>
        <div class="site-logo">
            <?php the_custom_logo(); ?>
        </div>
    <?php else : ?>
        <h1 class="site-title text-2xl lg:text-3xl font-bold">
            <a href="<?php echo esc_url(home_url('/')); ?>" 
               class="bg-gradient-to-r from-zc-primary to-zc-success bg-clip-text text-transparent hover:from-zc-success hover:to-zc-primary transition-all duration-300"
               rel="home">
                <?php bloginfo('name'); ?>
            </a>
        </h1>
    <?php endif; ?>
</div>