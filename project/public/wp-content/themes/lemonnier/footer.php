<?php

declare(strict_types=1);

/**
 * Project: wordpress-skeleton-theme
 * 
 * @author Thilo Ratnaweera <thilo.ratnaweera@netbrothers.de>
 * @copyright © 2024 NetBrothers GmbH.
 * @license GPLv3
 */

/**
 * @see https://developer.wordpress.org/reference/functions/get_bloginfo/
 * ‘name’ – Site title (set in Settings > General)
 */








// $sponsorUrl = 'https://netbrothers.de/#27eeca5d-b5a7-4a88-83b8-ba2dc0fb0f17';
// $sponsorLink = sprintf('<a target="_blank" href="%s">NetBrothers</a>', $sponsorUrl);
$copyrightTemplate = get_option(
    'nb_theme_setting_copyright',
    sprintf(
        /* translators: %s: Hyperlink to sponsor website. */
        __('© {{year}} {{bloginfo_name}}.', 'nb-wordpress-skeleton-theme'), ''
        // $sponsorLink
    ),
);

$blogInfoName = get_bloginfo('name');
$blogInfoName = is_string($blogInfoName) ? $blogInfoName : '';

$copyright = strtr($copyrightTemplate, [
    '{{year}}' => (new \DateTimeImmutable)->format('Y'),
    '{{bloginfo_name}}' => $blogInfoName,
]);
?>
    </main>
    <footer class="footer" >
        <section class="section section-footer" >
            <div class="footer-container container">
                <div class="footer-container--navs" >
                    
                    <?
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
                        'container_id' => 'information-menu',
                        'container' => 'nav',
                        'menu_id' => 'information-menu',
                        'theme_location' => 'information-menu',
                    ]);

                    ?>
                </div>
                <div class="footer-logo">
                    <a href="<?php echo home_url() ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Voyages_Le_Monnier_logo_blanc.svg" alt=""></a>
                </div>
            </div>
        </section>
        <div><?php echo $copyright; ?></div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
