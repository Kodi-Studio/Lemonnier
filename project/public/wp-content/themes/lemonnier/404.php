<?php
/**
 * Template Name: 404
 */


declare(strict_types=1);

    // $pageid = get_the_ID();
    $page_404 = get_page_by_title('404');

    $pageid = $page_404->ID;
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
    get_header(); 
?>
    <section class="section section-full page-header"  >
        <img class="image-header" src="<?php echo  get_post_meta($pageid, 'image_url', true); ?>" />
        <img class="weaver" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/weaver.svg" />
    </section>
    <section class="section" >
        <div id="content-container" class="content-container page-content" >
            <main>
                <div class="pages-type-title-block" style="--color-text:#7d41c2;" >
                    <div class="carousel-travels-title">
                        <h2><span style="color: #000;" >Page introuvable.</h2>
                        <div class="image-block-subtitle-page" >
                        </div>
                    </div>
                </div>        
                <?php 
                if ($page_404) {
                    // Affiche le contenu de la page
                    echo apply_filters('the_content', $page_404->post_content);

                } else {
                    // Si la page n'existe pas, affiche un message par défaut
                    echo '<h1>Oups! Page non trouvée.</h1>';
                    echo '<p>Il semble que la page que vous cherchez n\'existe pas. Essayez de revenir à la page d\'accueil.</p>';
                }

            ?>
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
