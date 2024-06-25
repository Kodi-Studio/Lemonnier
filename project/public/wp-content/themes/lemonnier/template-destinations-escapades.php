<?php
/**
 * Template Name: Template_Destinations_Escapades
 */

declare(strict_types=1);

// date_default_timezone_set("UTC");
setlocale(LC_TIME, "fr-FR");
date_default_timezone_set('Europe/Paris');

/**
 * Project: wordpress-skeleton-theme
 * 
 * @author Thilo Ratnaweera <thilo.ratnaweera@netbrothers.de>
 * @copyright © 2024 NetBrothers GmbH.
 * @license GPLv3
 */


    function formatFrenchDate($dateString) {

         $months = array(
            'Janvier',
            'Février',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Septembre',
            'Octobre',
            'Novembre',
            'Décembre'
        );

        ///$newDate = date("d-F-Y", strtotime($dateString));
        $day = date("d", strtotime($dateString));
        $month =  $months[+date("m", strtotime($dateString))-1];
        $year = date("Y", strtotime($dateString));

        return $day.' '.$month; //.' '.$year;

    }


?>
<?php 
    global $wpdb;

    $headerwhite = true;

    /// get travel data
    $pageId = get_the_ID();

    // $query = 	"SELECT t1.* ,  t2.*, t3.* from `kdest_travel` t1  
    //             LEFT JOIN `travel_discount` t2  ON t1.travel_discount_id = t2.travel_discount_id
    //             LEFT JOIN `travel_type` t3  ON t1.travel_type_id = t3.travel_type_id
    //             WHERE t1.travel_page_id = %d";
    // $prepared_query = $wpdb->prepare($query, $pageId);
    // $travel = $wpdb->get_results($prepared_query, ARRAY_A)[0];

    // $bgHeader = $travel['travel_type_color']

?>
<!-- <style>

    .header.default {
        --bg-header: #FFF;
        --menu-text-color: var(--lem-default-blue);
    }

</style> -->

<style>
    .header {
        --bg-header: #7d41c2;
    }
    .header-container .menu .menu-item:not(.current-menu-item) a {
        --menu-text-color: #FFF;
    }
    .logoInline {
        --menu-text-color:  #FFF;
    }
    .travel-sheet {
        --bg-color: #7d41c2;
    }
    .burger span {
         --menu-text-color:  #FFF;
    }
</style>


<?php get_header(); ?>

<section class="section section-full page-header" style="background-color: #7d41c2;" >
        
        <img class="image-header" src="<?php echo  get_post_meta(get_the_ID(), 'image_url', true); ?>" />
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
        <main class="travel-sheet" >
            <div class="travel-sheet-full">
                <?php the_content(); ?>
            </div>
        </main>
        
    </div>
</section>

<?php
    $custom_text = get_post_meta(get_the_ID(), '_travel_mentions_text_meta_key', true);
    // Affichez le champ personnalisé si non vide
    if (!empty($custom_text)) {
        echo '<section class="section-mentions" >';
        echo '<div class="content-container page-content page-content--mentions">';
        echo wpautop($custom_text);
        echo '</div>';
        echo '</section>';
    }
?>



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
