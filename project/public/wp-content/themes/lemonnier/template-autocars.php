<?php
/**
 * Template Name: Template_Autocars
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

?>
<style>

    .page-header {
        --bg-header: #c7b600;
    }
    .header {
        --bg-header: #c7b600;
    }
    .header-container .menu .menu-item:not(.current-menu-item) a {
        --menu-text-color: #FFF;
    }
    .logoInline {
        --menu-text-color:  #FFF;
    }
    .travel-sheet {
        --bg-color: #c7b600;
    }
    .burger span {
         --menu-text-color:  #FFF;
    }
    .carousel-travels-title {
        --color-text: #c7b600;
    }
   
</style>
<?php get_header(); ?>

    <section class="section section-full page-header page-header--small"  >
        
        <!-- <img class="image-header" src="<?php echo  get_post_meta(get_the_ID(), 'image_url', true); ?>" /> -->
        <img class="weaver" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/weaver.svg" />
    </section>
    <section class="section" >
        <div id="content-container" class="content-container page-content" >
            <main>
                
                <div class="pages-type-title-block" style="--color-text:#7d41c2;" >
                    <div class="carousel-travels-title">
                        <h2><?php  echo explode('/',get_the_title())[0]; ?></span>/<?php  echo explode('/',get_the_title())[1]; ?></h2>
                        <!-- <h3><strong>Une avalanche de propositions</strong> pour toutes sortes d'envies !</h3> -->
                    </div>
                </div>
               
                <?php the_content(); ?>
                
            </main>
            <!-- <?php get_sidebar(); ?> -->
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
