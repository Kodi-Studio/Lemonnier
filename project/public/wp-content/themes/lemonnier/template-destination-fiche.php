<?php
/**
 * Template Name: Template_Destinations_Fiche
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
<?php 
    global $wpdb;

    $headerwhite = true;

    /// get travel data
    $pageId = get_the_ID();

    $query = 	"SELECT t1.* ,  t2.*, t3.* from `kdest_travel` t1  
                LEFT JOIN `travel_discount` t2  ON t1.travel_discount_id = t2.travel_discount_id
                LEFT JOIN `travel_type` t3  ON t1.travel_type_id = t3.travel_type_id
                WHERE t1.travel_page_id = %d";
    $prepared_query = $wpdb->prepare($query, $pageId);
    $travel = $wpdb->get_results($prepared_query, ARRAY_A)[0];

    $bgHeader = $travel['travel_type_color']

?>
<!-- <style>

    .header.default {
        --bg-header: #FFF;
        --menu-text-color: var(--lem-default-blue);
    }

</style> -->

<style>
    .header {
        --bg-header: #FFF
    }
    .header-container .menu .menu-item:not(.current-menu-item) a {
        --menu-text-color:  <?php echo $bgHeader; ?>;
    }
    .logoInline {
        --menu-text-color:  <?php echo $bgHeader; ?>;
    }
    .travel-sheet {
        --bg-color:  <?php echo $bgHeader; ?>;
    }
</style>


<?php get_header(); ?>

<section class="section section-header-fiche page-header">
    <img class="image-header" src="<?php echo  get_post_meta(get_the_ID(), 'image_url', true); ?>" />
</section>
<section class="section" >
    <div id="content-container" class="content-container page-content" >
        <main class="travel-sheet" >
            <div class="travel-sheet-left">
                
                    <div class="--discount" style="--color-text:#FFF; --color-bg: #cc0000; --border-color:transparent"><?php   echo $travel['travel_discount_libelle'];  ?></div>
                    <h4 class="--subtitle" ><?php echo $travel['travel_subtitle'] ?></h4>
                
                
            </div>
            <div class="travel-sheet-right">
                <h1 class="travel-title"><?php echo $travel['travel_title']  ?></h1>
                <?php the_content(); ?>
            </div>
        </main>
        
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
