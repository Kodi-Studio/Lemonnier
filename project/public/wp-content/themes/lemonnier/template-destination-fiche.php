<?php
/**
 * Template Name: Template_Destinations_Fiche
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

        return $day.' '.$month.' '.$year;

    }


?>
<?php 
    global $wpdb;

    $headerwhite = true;

    /// get travel data
    $pageId = get_the_ID();

    $query = 	"SELECT t1.* ,  t2.*, t3.* from `kdest_travel` t1  
                LEFT JOIN `travel_discount` t2  ON t1.travel_discount_id = t2.travel_discount_id
                LEFT JOIN `travel_type` t3  ON t1.travel_type_id = t3.travel_type_id
                WHERE t1.travel_page_id = %d AND t1.travel_online = 1";
    $prepared_query = $wpdb->prepare($query, $pageId);
    $travel = $wpdb->get_results($prepared_query, ARRAY_A);

    if(!$travel) {
        header('Location: /');
    } else {
        $travel = $travel[0];
    }


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
        --bg-header: #fff;
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
    .menu-header-container {
        --bg-header:  #7D41C2;
    }
    .burger span {
         --menu-text-color:  <?php echo $bgHeader; ?>;
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
                <div  class="travel-sheet-left--inner">
                    <?php if($travel['travel_discount_libelle']) {
                        echo '<div class="--discount" style="--color-text:#FFF; --color-bg: #cc0000; --border-color:transparent">'.$travel['travel_discount_libelle'].'</div>';
                    }
                    if( $travel['travel_picto'] )
                    {
                        echo '<img class="--picto" src="'.esc_url( get_template_directory_uri() ).'/assets/images/'.$travel['travel_picto'].'.png" />';
                    }
                    ?>
                    <h4 class="--subtitle" ><?php echo $travel['travel_subtitle'] ?></h4>
                    <?php

                    $currentTime = time();

                    if( (!$travel['travel_date_a_start'] || $travel['travel_date_a_start'] == '0000-00-00' ||  $currentTime > strtotime(($travel['travel_date_a_start']))  ) 
                        && (!$travel['travel_date_b_start'] || $travel['travel_date_b_start'] == '0000-00-00' ||  $currentTime > strtotime(($travel['travel_date_b_start']))) 
                        && (!$travel['travel_date_b_start'] || $travel['travel_date_b_start'] == '0000-00-00' ||  $currentTime > strtotime(($travel['travel_date_c_start']))) 
                        ) {

                            echo '<div class="--plus-box">';
                            echo '<div class="--plus-box--text">'.$travel['travel_date_alt_text'].'</div>';
                            echo '</div>';

                        } else {

                            if($travel['travel_date_a_start']) {

                                // $date = DateTime::createFromFormat('Y-m-d', $travel['travel_date_a_start']);

                                $starDate = formatFrenchDate($travel['travel_date_a_start']);
                                $endDate = formatFrenchDate($travel['travel_date_a_end']);

                                echo '<div class="--date-box">';
                                echo '<div class="--during-text">'.$travel['travel_during_text'].'</div>';
                                echo '</div>';

                                echo '<div class="--date-box">';
                                echo '<div class="--date">du '.$starDate.'<br /> au '.$endDate.'</div>';
                                echo '<div class="--price">'.$travel['travel_price_a_1'].'€<small>'.$travel['travel_price_a_1_note'].'</small></div>';
                                if($travel['travel_price_a_2']!='') {
                                    echo '<div class="--price">'.$travel['travel_price_a_2'].'€<small>'.$travel['travel_price_a_2_note'].'</small></div>';
                                }
                                echo '</div>';
                            }

                            if($travel['travel_date_b_start'] && $travel['travel_date_b_start'] != '0000-00-00') {

                                $starDate = formatFrenchDate($travel['travel_date_b_start']);
                                $endDate = formatFrenchDate($travel['travel_date_b_end']);

                                echo '<div class="--date-box">';
                                echo '<div class="--date">du '.$starDate.'<br /> au '.$endDate.'</div>';
                                echo '<div class="--price">'.$travel['travel_price_b_1'].'€<small>'.$travel['travel_price_b_1_note'].'</small></div>';
                                if($travel['travel_price_b_2']!='') {
                                    echo '<div class="--price">'.$travel['travel_price_b_2'].'€<small>'.$travel['travel_price_b_2_note'].'</small></div>';
                                }
                                echo '</div>';
                            }

                            if($travel['travel_date_c_start'] && $travel['travel_date_c_start'] != '0000-00-00') {

                                $starDate = formatFrenchDate($travel['travel_date_c_start']);
                                $endDate = formatFrenchDate($travel['travel_date_c_end']);

                                echo '<div class="--date-box">';
                                echo '<div class="--date">du '.$starDate.'<br /> au '.$endDate.'</div>';
                                echo '<div class="--price">'.$travel['travel_price_c_1'].'€<small>'.$travel['travel_price_c_1_note'].'</small></div>';
                                if($travel['travel_price_c_2']!='') {
                                    echo '<div class="--price">'.$travel['travel_price_c_2'].'€<small>'.$travel['travel_price_c_2_note'].'</small></div>';
                                }
                                echo '</div>';
                            }
                        }

                    

                    if($travel['travel_plus_vlm'] != '') {
                        echo '<div class="--plus-box">';
                        echo '<div class="--plus-box--title" >Les plus</div>';
                        echo '<div class="--plus-box--text">'.$travel['travel_plus_vlm'].'</div>';
                        echo '</div>';
                    }

                    


                   ?>
                </div>
                <?php
                 if($travel['travel_pdf'] != '') {
                    ?>
                    <div  class="download-sheet-pdf--linkbox">
                        <a href="<?php echo $travel['travel_pdf']  ?>" target="_blank" >
                            <img class="download-sheet-pdf"  src="<?php echo esc_url( get_template_directory_uri() ).'/assets/images/picto_loadPDF.png' ?>" />
                            Télécharger<br />la fiche voyage
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="travel-sheet-right">
                <h1 class="travel-title"><?php echo $travel['travel_title']  ?></h1>
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
