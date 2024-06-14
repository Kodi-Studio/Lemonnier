<?php
/**
 * Template Name: Template_Destinations_Sommaire
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
        <div class="content-container top-page">
            <div class="logo-container" >
                <img class="logo-text" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Voyages_Le_Monnier_typo_blanc.svg" alt="">
                <h1 class="page-title" >
                    Créateur<br /> de voyages
                </h1>
            </div>
        </div>
    </section>
    <section class="section" >
        <div id="content-container" class="content-container page-content" >
            <main>
                <?php 
                
                    $pageid = get_the_ID();

                    global $wpdb;
                    $query = 	"SELECT * from `travel_type` WHERE travel_type_page_id = $pageid";
                    $result = $wpdb->get_results($query, ARRAY_A );

                    $type_id = $result[0]['travel_type_id'];

                    $query = 	"SELECT * from `kdest_travel` WHERE travel_type_id = $type_id";
                    $travels = $wpdb->get_results($query, ARRAY_A );
                
                ?>

                <?php the_content(); ?>

                <?php

                    foreach( $travels as $travel ) {
                        ?>
                        <div class="travel_card" >
                            <h1><?php  echo $travel['travel_title']  ?></h1>
                            <p>
                                <?php  echo $travel['travel_description']  ?>
                            </p>
                            <p>
                                <a href="<?php echo get_permalink($travel['travel_page_id'])  , true ?>" >> Voir<a>
                            </p>
                        </div>
                        <?php
                    }

                ?>


            </main>
            <!-- <?php get_sidebar(); ?> -->
        </div>
    </section>


<? if (get_post_meta(get_the_ID(), 'show_catas_footer', true) === "1") { ?>
    <section class="section section-full" >
        <div class="section-footer--catalogs" >
            <div class="max-width-lg full-vw-width">
                <div class="text-center footer-logo-cata-container" >
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/cata_VLM_full.svg" />
                </div>
                <ul class="footer-catalogs--list full-width text-center""  >
                    
                    
                    <?php
                        $list = getCatalogs();
                        foreach($list as $cata) {
                    ?>
                    
                        <li><a href="<?php echo $cata['cata_fichier']; ?>"><span class="underline">Télécharger</span> <?php echo $cata['cata_libelle'] ?> </a></li>
                    
                    <?php } ?>
                   
                </ul>
            </div>
        </div>
    </section>
    <? } ?>

<?php get_footer(); ?>
