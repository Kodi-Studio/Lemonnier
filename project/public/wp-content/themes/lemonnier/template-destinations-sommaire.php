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

    $pageid = get_the_ID();

    global $wpdb;
    $query = 	"SELECT * from `travel_type` WHERE travel_type_page_id = $pageid";
    $type = $wpdb->get_results($query, ARRAY_A );

    $type_id = $type[0]['travel_type_id'];

    $query = 	"SELECT t1.* , t2.* FROM `kdest_travel` t1 LEFT JOIN `travel_discount` t2 ON t1.travel_discount_id = t2.travel_discount_id WHERE t1.travel_type_id = $type_id";
    $travels = $wpdb->get_results($query, ARRAY_A );


    $bgHeader = $type[0]['travel_type_color'];

?>

<style>

    .header.default {
        --bg-header: <?php echo $bgHeader; ?>;
    }

</style>

<?php get_header(); ?>

<section class="section section-full page-header page-header--small" style="background-color: <?php echo $type[0]['travel_type_color']  ?>;" >
        
        <!-- <img class="image-header" src="<?php echo  get_post_meta(get_the_ID(), 'image_url', true); ?>" /> -->
        <img class="weaver" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/weaver.svg" />
        <!-- <div class="content-container top-page top-page--small">
            <div class="logo-container" >
                <img class="logo-text" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Voyages_Le_Monnier_typo_blanc.svg" alt="">
                <h1 class="page-title" >
                    Créateur<br /> de voyages
                </h1>
            </div>
        </div> -->
    </section>
    <section class="section" >
        <div id="content-container" class="content-container page-content" >
            <main>
                
                <div style="--color-text:<?php echo $type[0]['travel_type_color']  ?>;" >
                    <div class="carousel-travels-title">
                    <h2><?php echo $type[0]['travel_type_title']  ?></h2>
                    <h3><strong><?php echo $type[0]['travel_type_description']  ?></h3>
                    </div>
                </div>
                <?php the_content(); ?>
                <div class="travel-list">
                <?php

                    foreach( $travels as $travel ) {
                        ?>
                        <a class="travel-card" href="<?php echo get_permalink($travel['travel_page_id'])  , true ?>" >
                            <div class="type-card--vignette"><img src="<?php  echo $travel['travel_vignette']  ?>" /></div>
                            <h3 class="--title" ><?php  echo $travel['travel_title']  ?></h3>
                            <div class="--subtitle">
                                <?php  echo $travel['travel_subtitle']  ?>
                            </div>
                            <div>
                            <?php
                            $html = '';
                            if($travel['travel_discount_id']){
                                $borderColor = $travel['travel_discount_bgcolor'] == '#transp' ? $travel['travel_discount_color'] : "transparent";
                                $html .= '<div class="--discount" style="--color-text:'.$travel['travel_discount_color'].'; --color-bg: '.$travel['travel_discount_bgcolor'].'; --border-color:'.$borderColor.'" >'.$travel['travel_discount_libelle'].'</div>';
                            } else {
                                $html .= '<div class="--discount" ></div>';
                            }
                                echo $html;
                            ?>
                            <!-- <p>
                                <a href="<?php echo get_permalink($travel['travel_page_id'])  , true ?>" >> Voir<a>
                            </p> -->
                            </div>
                        </a>
                        <?php
                    }

                ?>
                </div>

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
