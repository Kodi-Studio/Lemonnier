<?php

declare(strict_types=1);

/**
 * Project: wordpress-skeleton-theme
 *
 * @author Thilo Ratnaweera <thilo.ratnaweera@netbrothers.de>
 * @copyright 2024 NetBrothers GmbH
 * @license GPLv3
 */

/**
 * Add scripts and styles.
 * @return void 
 */
function nb_add_theme_scripts()
{
    // add global style
    // wp_enqueue_style('nb_style', get_stylesheet_uri());

    // add additional style
    // wp_enqueue_style('nb_slider', get_template_directory_uri() . '/css/slider.css', [], '1.1', 'all');

    // styles template Lemonnier
    wp_enqueue_style('template', get_template_directory_uri() . '/dist/styles/styles.css', [], '1.1', 'all');


    // add global script
    wp_enqueue_script(
        'nb_script',
        get_template_directory_uri() . '/dist/js/bundle.js',
        // dependencies
        [],
        // version (increase on changes)
        '1.0.0',
        // options (optional obviously)
        [
            'in_footer' => true,    // or false
            'strategy' => 'async',  // or 'defer'
        ]
    );

    // @see https://developer.wordpress.org/themes/basics/including-css-javascript/#the-comment-reply-script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'nb_add_theme_scripts');

/**
 * Register menus
 * @return void 
 */
function nb_register_menus()
{
    register_nav_menus([
        'nb-main-menu' => __('Main Menu', 'nb-wordpress-skeleton-theme'),
        'nb-cta-menu' => __('Call-to-Action Menu', 'nb-wordpress-skeleton-theme'),
        'information-menu' => __('Infomation Menu', 'nb-wordpress-skeleton-theme'),
    ]);
}
add_action( 'init', 'nb_register_menus' );

/**
 * Register sidebar, widget areas, etc.
 * @return void 
 */
function nb_register_widget_areas()
{
    register_sidebar([
        'name'          => __('Sidebar', 'nb-wordpress-skeleton-theme'),
        'id'            => 'sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    // for ($i = 1; $i <= 4; $i++) {
    //     register_sidebar([
    //         'name'          => __(sprintf('Footer Widget Area %d', $i), 'nb-wordpress-skeleton-theme'),
    //         'id'            => 'sidebar-2',
    //         'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
    //         'after_widget'  => '</li></ul>',
    //         'before_title'  => '<h3 class="widget-title">',
    //         'after_title'   => '</h3>',
    //     ]);
    // }
}
add_action('widgets_init', 'nb_register_widget_areas');

/**
 * Theme Settings
 * 
 * @param mixed $wp_customize
 * @return void
 */
function nb_customize_register($wp_customize)
{
    // section in customizer
    $wp_customize->add_section('nb_theme_settings_section', [
        'title' => __('Additional Theme Settings', 'nb-wordpress-skeleton-theme'),
    ]);

    // copyright setting
    $wp_customize->add_setting('nb_theme_setting_copyright', [
        // @see https://www.usablewp.com/learn-wordpress/wordpress-customizer/theme-mods-vs-options-in-wordpress/
        'type' => 'option',
    ]);
    // control to change copyright setting
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'nb_theme_control_copyright',
        [
            'label'    => __('Copyright', 'nb-wordpress-skeleton-theme'),
            'section'  => 'nb_theme_settings_section',
            'settings' => [
                'nb_theme_setting_copyright',
                // ... add any additional settings IDs ...
            ],
        ]
    ));
}
add_action('customize_register', 'nb_customize_register');






// Fonction pour ajouter le champ d'upload d'image EN entête des pages
function ajouter_champ_upload_image() {
    add_meta_box(
        'champ_upload_image',
        'Image en tête de page',
        'afficher_champ_upload_image',
        'page', // Ajouter uniquement à l'édition de pages
        'normal',
        'high'
    );
}

// Fonction pour afficher le champ d'upload d'image
function afficher_champ_upload_image($post) {
    // Récupérer la valeur actuelle du champ s'il existe
    $image_url = get_post_meta($post->ID, 'image_url', true);

    // Sécuriser le formulaire avec un nonce
    wp_nonce_field('upload_image_nonce', 'upload_image_nonce_field');

    // Afficher le champ d'upload d'image
    echo '<label for="image_url">Image :</label>';
    echo '<input type="text" id="image_url" name="image_url" value="' . esc_attr($image_url) . '" size="30" />';
    echo '<input type="button" id="upload_image_button" class="button" value="Uploader une image" />';
    echo '<p class="description">Sélectionnez ou téléchargez une image pour cette page.</p>';
    echo '<div><img style="max-width: 200px" src="'.$image_url.'" /></div>'
    // JavaScript pour gérer l'événement de clic sur le bouton d'upload
    ?>
    <script>
        jQuery(document).ready(function($){
            $('#upload_image_button').click(function() {
                var custom_uploader = wp.media({
                    title: 'Uploader une image',
                    button: {
                        text: 'Choisir une image'
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                })
                .on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#image_url').val(attachment.url);
                })
                .open();
            });
        });
    </script>
    <?php



}

// Fonction pour enregistrer la valeur du champ d'upload d'image
function enregistrer_champ_upload_image($post_id) {
    // Vérifier les autorisations et la présence du nonce
    if (!isset($_POST['upload_image_nonce_field']) || !wp_verify_nonce($_POST['upload_image_nonce_field'], 'upload_image_nonce')) {
        return;
    }

    // Vérifier si la valeur a été saisie
    if (isset($_POST['image_url'])) {
        // Nettoyer et enregistrer la valeur du champ d'upload d'image
        update_post_meta($post_id, 'image_url', sanitize_text_field($_POST['image_url']));
    }
}

// Hooks pour ajouter et enregistrer le champ d'upload d'image
add_action('add_meta_boxes', 'ajouter_champ_upload_image');
add_action('save_post', 'enregistrer_champ_upload_image');
