<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="top"></div>

    <header class="site-header" role="banner">
    <div class="header-container">
        <div class="site-branding">
            <?php if ( has_custom_logo() ) : ?>
                <div class="site-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php the_custom_logo(); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <nav id="site-navigation" class="main-navigation" role="navigation">
            <?php
            // Display the primary menu set in the WordPress dashboard
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'menu_class'     => 'menu', // Add a class to the menu
                'fallback_cb'    => false,
            ) );            
            ?>
<div class="cart-icon">
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <div class="header-cart">
                    <a href="<?php echo wc_get_cart_url(); ?>" class="cart-link">
                    <span class="cart-count">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </span>
                        <div class="logo-wrapper">
                            <img src="http://localhost:8000/wp-content/uploads/2024/10/cart_icon.png" alt="Logo" class="cart-logo">
                        </div>
                        <span class="cart-icon"></span>
                    </a>
                </div>

            <?php endif; ?>
</div>
                </nav>

                    <div class="hamburger-menu">
    <span></span>
    <span></span>
    <span></span>
</div>

<div class="sidebar-menu">
<div class="site-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php the_custom_logo(); ?>
                    </a>
                </div>
    <?php
    // Display the primary menu here as well
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_id'        => 'primary-menu',
        'fallback_cb'    => false,
    ));
    ?>
    <div class="cart-icon">
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <div class="header-cart">
                    <a href="<?php echo wc_get_cart_url(); ?>" class="cart-link">
                    <span class="cart-count">
                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                        </span>
                        <div class="logo-wrapper">
                            <img src="/wp-content/uploads/2024/10/cart_icon.png" alt="Logo" class="cart-logo">
                        </div>
                        <span class="cart-icon"></span>
                    </a>
                </div>

            <?php endif; ?>
</div>
</div>
</div>
    </header>
