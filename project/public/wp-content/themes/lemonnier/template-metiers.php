<?php
/**
 * Template Name: Template_Metiers
 */

declare(strict_types=1);

/**
 * Project: wordpress-metier
 * 
 * @author Thilo Ratnaweera <thilo.ratnaweera@netbrothers.de>
 * @copyright © 2024 NetBrothers GmbH.
 * @license GPLv3
 */

    $pageid = get_the_ID();

?>
<style>

    .page-header {
        --bg-header: #499ea8;
    }
    .header {
        --bg-header: #499ea8;
    }
    .header-container .menu .menu-item:not(.current-menu-item) a {
        --menu-text-color: #FFF;
    }
    .logoInline {
        --menu-text-color:  #FFF;
    }
    .travel-sheet {
        --bg-color: #499ea8;
    }
    .burger span {
         --menu-text-color:  #FFF;
    }
    .carousel-travels-title {
        --color-text: #499ea8;
    }
   
</style>
<?php 
    // global $custom_data;
    // $custom_data = 'valeur_personnalisée';
    get_header(); 
?>

   <section class="section section-full page-header">
        
        <img class="image-header" src="<?php echo  get_post_meta(get_the_ID(), 'image_url', true); ?>" />
        <img class="weaver" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/weaver.svg" />
        <div class="content-container top-page">
            <div class="logo-container" >
                <img class="logo-text" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Voyages_Le_Monnier_typo_blanc.svg" alt="">
                <h1 class="page-title --small" >
                    4 générations <br />
                    au service<br />
                    du tourisme
                </h1>
            </div>
        </div>
    </section>
    <section class="section" >
        <div id="content-container" class="content-container page-content" >
            <main class="page-metiers" >               
                <?php the_content(); ?>
            </main>
            <!-- <?php /*get_sidebar();*/ ?> -->
        </div>
    </section>


<? 
    if (get_post_meta(get_the_ID(), 'show_catas_footer', true) === "1") { ?>
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
<? 
    }
?>

<?php get_footer(); ?>
