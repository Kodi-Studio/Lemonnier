<?php
/**
 * Template Name: Template_Catalog_Sommaire
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

    // global $wpdb;
    // $query = 	"SELECT * from `catalogues` WHERE cata_online = 1";
    // $catalogs = $wpdb->get_results($query, ARRAY_A );

    $bgHeader = "#CC0000"; ///$type[0]['travel_type_color'];

?>

<!-- <style>

    .header.default {
        --bg-header: <?php echo $bgHeader; ?>;

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

    <section class="section section-full page-header page-header--small" style="background-color: <?php echo $type[0]['travel_type_color']  ?>;" >
        
        <img class="image-header" src="<?php echo  get_post_meta(get_the_ID(), 'image_url', true); ?>" />
        <img class="weaver" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/weaver.svg" />
        <div class="content-container top-page top-page--small">
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
                
                <!-- <div class="pages-type-title-block" style="--color-text:#7d41c2;" >
                    <div class="carousel-travels-title">
                        <h2>Catalogues</h2>
                        <h3><strong>Une avalanche de propositions</strong> pour toutes sortes d'envies !</h3>
                    </div>
                </div> -->
               
                <?php the_content(); ?>
                <div class="catalog-list"  >
                    <?php
                        $list = getCatalogs();
                        foreach($list as $cata) {
                    ?>

                        <div class="catalog-item" >
                            <a href="<?php echo $cata['cata_fichier']; ?>" target="_blank" >
                                <img src="<?php echo $cata['cata_vignette'] ?>" alt="<?php echo $cata['cata_libelle'] ?>" class="catalog-vignette" />
                               <p><?php echo $cata['cata_libelle'] ?></p>
                            </a>
                        </div>
                    
                    <?php } ?>
                    <?php
                        $list = getCatalogs();
                        foreach($list as $cata) {
                    ?>

                        <div class="catalog-item" >
                            <a href="<?php echo $cata['cata_fichier']; ?>">
                                <img src="<?php echo $cata['cata_vignette'] ?>" alt="<?php echo $cata['cata_libelle'] ?>" class="catalog-vignette" />
                                <?php echo $cata['cata_libelle'] ?>
                            </a>
                        </div>
                    
                    <?php } ?>
                </div>
            </main>
            <!-- <?php get_sidebar(); ?> -->
        </div>
    </section>


<? 
    /*if (get_post_meta(get_the_ID(), 'show_catas_footer', true) === "1") { ?>
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
    <? }
    
    */ ?>

<?php get_footer(); ?>
