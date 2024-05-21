<?php

declare(strict_types=1);

/**
 * Project: wordpress-skeleton-theme
 * 
 * @author Thilo Ratnaweera <thilo.ratnaweera@netbrothers.de>
 * @copyright © 2024 NetBrothers GmbH.
 * @license GPLv3
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title><?php wp_title(); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php wp_head(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
</head>
<body <?php body_class(); ?>>
    <section class="section section-header" >
        <div class="header default" id="header" >
            <header class="header-container" >
                <a class="logo" href="<?php echo home_url() ?>">Accueil
                </a>
                <!-- <span class="logo-separator">e</span> -->


                    <?php
                    wp_nav_menu([
                        'container_id' => 'main-menu-container',
                        'container' => 'nav',
                        'menu_id' => 'header',
                        'theme_location' => 'nb-main-menu',
                        // 'after' => '',
                        // 'before' => '',
                        // 'container_aria_label' => '',
                        // 'container_class' => '',
                        // 'depth' => '',
                        // 'echo' => '',
                        // 'fallback_cb' => '',
                        // 'item_spacing' => '',
                        // 'items_wrap' => '',
                        // 'link_after' => '',
                        // 'link_before' => '',
                        // 'menu_class' => 'main-menu',
                        // 'menu_id' => '',
                        // 'menu' => '',
                        // 'walker' => '',
                    ]);
                    wp_nav_menu([
                        'container_id' => 'cta-menu-container',
                        'container' => 'nav',
                        'fallback_cb' => false, // show nothing if menu is not set by admin
                        'menu_id' => 'cta-menu',
                        'theme_location' => 'nb-cta-menu',
                    ]);
                    ?>
                <button class="burger"><span></span><span></span><span></span></button>
            </header>
        </div>
        
    </section>
    <main class="main" >
