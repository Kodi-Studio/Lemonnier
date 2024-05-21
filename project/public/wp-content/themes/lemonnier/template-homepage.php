<?php
/**
 * Template Name: Template_Home_Page
 */

declare(strict_types=1);

/**
 * Project: wordpress-skeleton-theme
 * 
 * @author Thilo Ratnaweera <thilo.ratnaweera@netbrothers.de>
 * @copyright © 2024 NetBrothers GmbH.
 * @license GPLv3
 */

?>
<?php get_header(); ?>

    <section class="section section-full page-header">
        <img class="image-header" src="<?php echo  get_post_meta(get_the_ID(), 'image_url', true); ?>" />
        <img class="weaver" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/weaver.svg" />
    </section>
    <section class="section" >
        <div id="content-container">
            <main>
                <?php the_content(); ?>
            </main>
            <!-- <?php get_sidebar(); ?> -->
        </div>
    <section>


<?php get_footer(); ?>
