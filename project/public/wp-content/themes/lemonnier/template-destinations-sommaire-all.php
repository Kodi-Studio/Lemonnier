<?php
/**
 * Template Name: Template_Destinations_Sommaire_all
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

    $query = 	"SELECT t1.* , t2.* FROM `kdest_travel` t1 
                LEFT JOIN `travel_discount` t2 ON t1.travel_discount_id = t2.travel_discount_id 
                WHERE t1.travel_online = 1 ";

    if(isset($_POST['minprice']) && $_POST['minprice'] != '' && isset($_POST['wishprice'])  && $_POST['wishprice'] == "0" ) {

        $minprice = intval($_POST['minprice']);
        $query .= " AND t1.travel_price_a_1 >= ".$minprice."";
    }

    if(isset($_POST['maxprice']) && $_POST['maxprice'] != '' && isset($_POST['wishprice'])  && $_POST['wishprice'] == "0" ) {
        $maxprice = intval($_POST['maxprice']);
        $query .= " AND t1.travel_price_a_1 <= ".$maxprice."";
    }

    $query  .= " ORDER BY t1.travel_display_position DESC, 
                t1.travel_date_a_start ASC, 
                t1.travel_date_b_start ASC, 
                t1.travel_date_c_start ASC";
    $travels = $wpdb->get_results($query, ARRAY_A );


    $bgHeader = $type[0]['travel_type_color'];


    echo $query;

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
                
                <div class="pages-type-title-block" style="--color-text:<?php echo $type[0]['travel_type_color']  ?>;" >
                    <div class="carousel-travels-title">
                        <h2><?php echo $type[0]['travel_type_title']  ?></h2>
                        <h3><strong><?php echo $type[0]['travel_type_subtitle_page']  ?></strong></h3>
                    </div>
                </div>
                <div class="filter-container" >
                    <form action="#" method="POST" enctype="multipart/form-data" >
                        <div class="filter-form-container" >
                            <div class="formob">
                                <div>RECHERCHE : </div>
                            </div>
                            <div class="formob">
                                <div><input type="number" onkeyup="checkSubmit(event)"  name="minprice" id="minprice" value="<?php echo (isset($_POST['minprice'])) ? $_POST['minprice'] : ''    ?>" placeholder="PRIX MINI" ></div>
                                <div><input type="number" onkeyup="checkSubmit(event)"  name="maxprice" id="maxprice" value="<?php echo (isset($_POST['maxprice'])) ? $_POST['maxprice'] : ''    ?>" placeholder="PRIX MAXI" ></div>
                            </div>
                            <div class="formob">
                                <div><input type="number" onkeyup="checkSubmit(event)"  name="wishprice" value="0" name="wishprice"  placeholder="PRIX SOUHAITE" ></div>
                                <div><button type="submit" id="submit" disabled style="background-color: <?php echo $type[0]['travel_type_color']  ?>;" >OK</button></div>
                            </div>
                        </div>

                    </form>
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
                            }
                            else if($travel['travel_price_a_1']) {
                                $html .= '<div class="--price" >'.$travel['travel_price_a_1'].'€</div>';
                            } 
                            else if($travel['travel_date_alt_text']) {
                                $html .= '<div class="--text-alt" >'.$travel['travel_date_alt_text'].'</div>';
                            }
                            $html .= '<div class="--note" ><div>'.$travel['travel_during_text'].'</div><div class="--note-date" >'.simpleDates($travel['travel_date_a_start'],$travel['travel_date_a_end']).'</div></div>';
		

                                echo $html;
                            ?>
                            </div>
                        </a>
                        <?php
                    }
                ?>
                    <div class="travel-card">
                        <a class="travel-agences-link" href="/nous-contacter-nos-agences/">
                            <p>Vous n'avez pas<br /> encore trouvé le voyage<br /> de vos rêves ?</p>
                            <div>
                                <svg id="arrow" class="arrow" data-name="Calque 1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 36.32 58.75">
                                <defs>
                                    <style>
                                    .svg-carousel-arrow {
                                        fill: #7D41C2;
                                        stroke-width: 0px;
                                    }
                                    </style>
                                </defs>
                                <path class="svg-carousel-arrow" d="M4.96,58.49c-1.25,0-2.5-.48-3.45-1.43-1.9-1.9-1.9-4.99,0-6.89l20.88-20.88L1.51,8.42C-.39,6.52-.39,3.43,1.51,1.53,3.42-.38,6.5-.38,8.41,1.53l27.77,27.77-27.77,27.77c-.95.95-2.2,1.43-3.45,1.43Z"></path>
                                </svg>
                            </div>
                            <p>Beaucoup d'autres<br /> voyages sont disponibles<br /> dans nos agences <span style="text-decoration: underline;" >ici</span></p>
                        </a>
                    </div>
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

<script>

    function checkSubmit(e) {
        if(e.target.value.trim() == 0) {
            if( parseInt(document.getElementById('minprice').value) > 0  || parseInt(document.getElementById('maxprice').value) > 0 ) {
                document.getElementById('submit').disabled = false;
            } else {
                document.getElementById('submit').disabled = true;
            }
        } else {
            document.getElementById('submit').disabled = false;
        }
    }


</script>

<?php get_footer(); ?>
