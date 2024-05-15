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

    <section class="section" >

        <div class="page-header">
            
        </div>

        <div id="content-container">
            <main>
                <?php the_content(); ?>
            </main>
            <!-- <?php get_sidebar(); ?> -->
        </div>
    <section>


<?php get_footer(); ?>
