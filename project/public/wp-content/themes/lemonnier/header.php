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
                <a class="logo" href="<?php echo home_url() ?>">

                <!--  -->
                    <svg
                        class="logoInline-svg"
                        version="1.1"
                        id="Calque_1"
                        x="0px"
                        y="0px"
                        viewBox="0 0 110 50.000001"
                        xml:space="preserve"
                        sodipodi:docname="VLM_logo_blanc.svg"
                        width="80%"
                        height="auto"
                        inkscape:version="1.3.2 (091e20e, 2023-11-25)"
                        xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                        xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:svg="http://www.w3.org/2000/svg"><defs
                        id="defs2" /><sodipodi:namedview
                        id="namedview2"
                        pagecolor="#ffffff"
                        bordercolor="#000000"
                        borderopacity="0.25"
                        inkscape:showpageshadow="2"
                        inkscape:pageopacity="0.0"
                        inkscape:pagecheckerboard="true"
                        inkscape:deskcolor="#d1d1d1"
                        showguides="true"
                        inkscape:zoom="2.300195"
                        inkscape:cx="-52.386864"
                        inkscape:cy="0.86949151"
                        inkscape:window-width="1648"
                        inkscape:window-height="951"
                        inkscape:window-x="1921"
                        inkscape:window-y="724"
                        inkscape:window-maximized="0"
                        inkscape:current-layer="Calque_1"><sodipodi:guide
                            position="-25.899153,60.597461"
                            orientation="0,-1"
                            id="guide2"
                            inkscape:locked="false" /><sodipodi:guide
                            position="-16.769492,13.210171"
                            orientation="0,-1"
                            id="guide3"
                            inkscape:locked="false" /><sodipodi:guide
                            position="-8.0745765,14.514408"
                            orientation="1,0"
                            id="guide4"
                            inkscape:locked="false" /><sodipodi:guide
                            position="96.699152,-35.481353"
                            orientation="1,0"
                            id="guide5"
                            inkscape:locked="false" /></sodipodi:namedview>
                        <g
                        id="g2"
                        transform="translate(-10.5,-27.25)">
                            <defs
                        id="defs1">
                                <path
                        id="SVGID_1_"
                        d="m 45.5,61.3 c -1.4,1.9 -3.4,5.4 1.5,5.4 10.4,0 27.9,-15.1 32.6,-15.1 3.6,0 -8.4,9.6 -8.4,11.3 0,0.7 2.4,0.6 3.7,0.3 3.5,-0.8 13.3,-10.7 17.1,-10.7 1.6,0 -2.9,6.3 -3.7,7.6 -0.8,1.4 -1,2.1 1.9,1.6 2.2,-0.4 10.8,-7.3 11.9,-7.3 0.6,0 -4.7,5.4 1.4,5.4 4,0 9.3,-2.1 11.2,-3.4 0.1,-0.1 0.2,-0.2 0.4,-0.3 v -0.4 c -0.1,0 -0.3,0.1 -0.6,0.2 -1.5,0.5 -9.2,3.4 -9.2,1.8 0,-1.5 4.3,-6.3 -0.1,-6.3 -3.5,0 -7.7,2 -9.7,4.2 0,0 4.4,-6.1 -1.4,-6.1 -4.5,0 -9.3,3.1 -9.3,3.1 0,0 2.8,-4.9 -2.3,-4.9 -7.8,0 -20.4,10.5 -28.8,13.9 -1.7,0.7 -2.4,0.4 -1.4,-0.9 6.7,-9.2 15.1,-21 31,-28.1 0,0 -0.4,-0.2 -1.5,-0.2 -13.2,0.1 -29,18.8 -36.3,28.9 m 0.6,-14.4 c -8.4,9 -14.8,18.6 -15.9,18.6 -1.2,0 -2.1,-8.2 -3.4,-14.6 -1,-5.1 -2.2,-11.4 -5,-14.7 -1.6,-1.9 -4.3,-2.6 -5.9,-2.4 0,0 3.4,15.3 4.5,21 1,5 3.4,17.8 8.5,17.8 7.4,0 16.5,-28.7 42.8,-40.5 0,0 -0.4,-0.2 -1.5,-0.2 -8.1,0 -16.8,7.3 -24.1,15" />
                            </defs>
                            <use
                        xlink:href="#SVGID_1_"
                        class="logoInline"
                        
                        id="use1" />
                            <clipPath
                        id="SVGID_2_">
                                <use
                        xlink:href="#SVGID_1_"
                        style="overflow:visible"
                        id="use2" />
                            </clipPath>
                        </g>
                    </svg>

                <!-- style="overflow:visible;fill:#ffffff" -->

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
