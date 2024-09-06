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
function add_field_upload_image() {
    add_meta_box(
        'champ_upload_image',
        'Image en tête de page',
        'show_champ_upload_image',
        'page', // Ajouter uniquement à l'édition de pages
        'normal',
        'high'
    );
}



// Fonction pour afficher le champ d'upload d'image entête
function show_champ_upload_image($post) {
    // Récupérer la valeur actuelle du champ s'il existe
    $image_url = get_post_meta($post->ID, 'image_url', true);

    // Sécuriser le formulaire avec un nonce
    wp_nonce_field('upload_image_nonce', 'upload_image_nonce_field');

    // Afficher le champ d'upload d'image entete
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

// Fonction pour enregistrer la valeur du champ d'upload d'image entête
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
add_action('add_meta_boxes', 'add_field_upload_image');
add_action('save_post', 'enregistrer_champ_upload_image');



// Fonction pour ajouter le champ check box liens catalogues avant le footer
function add_field_show_cata_before_footer() {
    add_meta_box(
        'champ_show_cata',
        'Liens de téléchargement des catalogues avant le footer',
        'show_check_cata_before_footer',
        'page', // Ajouter uniquement à l'édition de pages
        'normal',
        'high'
    );
}


///// ajouter un champ custom WYSIWYG pour les mentions sur fond violet des pages fiche vayage
// Enregistrer la meta box
function my_custom_meta_boxes() {
    add_meta_box(
        'travel_mentions_text_meta_box', // ID de la meta box
        'Mentions & détails voyage', // Titre de la meta box
        'travel_mentions_text_meta_box_callback', // Fonction de rappel pour afficher la meta box
        'page', // Type de publication
        'normal', // Contexte (normal, side, advanced)
        'high' // Priorité (high, core, default, low)
    );
}
add_action('add_meta_boxes', 'my_custom_meta_boxes');

// Afficher l'éditeur WYSIWYG
function travel_mentions_text_meta_box_callback($post) {
    wp_nonce_field('travel_mentions_text_meta_box_nonce', 'meta_box_nonce');

    $value = get_post_meta($post->ID, '_travel_mentions_text_meta_key', true);

    wp_editor($value, 'travel_mentions_text_field', array(
        'textarea_name' => 'travel_mentions_text_field', // Important !
        'media_buttons' => true,
        'textarea_rows' => 10,
        'teeny'         => true
    ));
}

// Enregistrer les données de la meta box
function my_save_custom_meta_box_data($post_id) {
    if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'travel_mentions_text_meta_box_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['travel_mentions_text_field'])) {
        update_post_meta($post_id, '_travel_mentions_text_meta_key', wp_kses_post($_POST['travel_mentions_text_field']));
    }
}
add_action('save_post', 'my_save_custom_meta_box_data');




///// END ajouter un champ custom WYSIWYG pour les mentions sur fond violet des pages fiche vayage
function show_check_cata_before_footer($post) {

    // Récupérer la valeur actuelle du champ s'il existe
    $show_catas_footer = get_post_meta($post->ID, 'show_catas_footer', true);

    // Sécuriser le formulaire avec un nonce
    wp_nonce_field('show_catas_footer_nonce', 'show_catas_footer_nonce_field');

    // Afficher le champ d'upload d'image
    echo '<label for="show_catas_footer">Afficher avant le footer :</label>';
    echo '<input type="checkbox" id="show_catas_footer" name="show_catas_footer" value="1" ' . checked($show_catas_footer, '1', false) . '>';
}


// Fonction pour enregistrer la valeur du champ d'upload d'image
function save_show_check_cata_before_footer($post_id) {
    // Vérifier les autorisations et la présence du nonce
    if (!isset($_POST['show_catas_footer']) || !wp_verify_nonce($_POST['show_catas_footer_nonce_field'], 'show_catas_footer_nonce')) {
        // return;
        $show_catas_footer = 0;
    }

    // Vérifier si la valeur a été saisie
    if (isset($_POST['show_catas_footer'])) {
        // Nettoyer et enregistrer la valeur du champ d'upload d'image
       $show_catas_footer = $_POST['show_catas_footer'];
    }

     update_post_meta($post_id, 'show_catas_footer', sanitize_text_field($show_catas_footer));
}
// Hooks pour ajouter et enregistrer le champ d'upload d'image
add_action('add_meta_boxes', 'add_field_show_cata_before_footer');
add_action('save_post', 'save_show_check_cata_before_footer');


// @ini_set( 'upload_max_size' , '64M' );
// @ini_set( 'post_max_size', '64M');
// @ini_set( 'max_execution_time', '300' );

// @ini_set('upload_max_filesize', '64M');
// @ini_set('post_max_size', '64M');
// @ini_set('memory_limit', '128M');

// ####################################################################################################
///// ADD image sous titre templates autocars, Groupes ...etc


// Fonction pour ajouter le champ d'upload d'image EN entête des pages
function add_field_upload_image_titre() {
    add_meta_box(
        'champ_upload_image_titre',
        'Image sous titre',
        'show_champ_upload_image_titre',
        'page', // Ajouter uniquement à l'édition de pages
        'normal',
        'high'
    );
}



// Fonction pour afficher le champ d'upload d'image titre
function show_champ_upload_image_titre($post) {
    $template_file = get_page_template_slug($post->ID);

    $allowed_templates = array(
        'template-autocars.php', // Le nom du template sans le chemin ni l'extension .php
        'template-groupes.php',  // Ajouter d'autres templates si nécessaire
    );

    if (in_array($template_file, $allowed_templates))
    {
        // Récupérer la valeur actuelle du champ s'il existe
        $image_titre_url = get_post_meta($post->ID, 'image_titre_url', true);

        // Sécuriser le formulaire avec un nonce
        wp_nonce_field('upload_image_titre_nonce', 'upload_image_titre_nonce_field');

        // Afficher le champ d'upload d'image entete
        echo '<label for="image_url">Image :</label>';
        echo '<input type="text" id="image_titre_url" name="image_titre_url" value="' . esc_attr($image_titre_url) . '" size="30" />';
        echo '<input type="button" id="upload_image_titre_button" class="button" value="Uploader une image" />';
        echo '<p class="description">Sélectionnez ou téléchargez une image pour cette page.</p>';
        echo '<div><img style="max-width: 200px" src="'.$image_titre_url.'" /></div>'
        // JavaScript pour gérer l'événement de clic sur le bouton d'upload
        ?>
        <script>
            jQuery(document).ready(function($){
                $('#upload_image_titre_button').click(function() {
                    var custom_uploader = wp.media({
                        title: 'Uploader une image',
                        button: {
                            text: 'Choisir une image'
                        },
                        multiple: false  // Set to true to allow multiple files to be selected
                    })
                    .on('select', function() {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        $('#image_titre_url').val(attachment.url);
                    })
                    .open();
                });
            });
        </script>
    <?php

    }

}

// Fonction pour enregistrer la valeur du champ d'upload d'image titre
function enregistrer_champ_upload_image_titre($post_id) {
    // Vérifier les autorisations et la présence du nonce
    if (!isset($_POST['upload_image_titre_nonce_field']) || !wp_verify_nonce($_POST['upload_image_titre_nonce_field'], 'upload_image_titre_nonce')) {
        return;
    }

    // Vérifier si la valeur a été saisie
    if (isset($_POST['image_titre_url'])) {
        // Nettoyer et enregistrer la valeur du champ d'upload d'image
        update_post_meta($post_id, 'image_titre_url', sanitize_text_field($_POST['image_titre_url']));
    }
}

// Hooks pour ajouter et enregistrer le champ d'upload d'image titre
add_action('add_meta_boxes', 'add_field_upload_image_titre');
add_action('save_post', 'enregistrer_champ_upload_image_titre');




////// ADD colors into classic editor
function my_mce4_options($init) {
    $default_colours = '
        "000000", "Black",
        "449ea8", "lemonnier",
        "7D41C2", "Escapades",
        "C7B600", "sejours",
        "CC005A", "france",
        "980071", "AllCircuits",
        "C41E28", "RedLemonnier",
        "D7834D", "LightBrown",
        "993300", "Burnt orange",
        "333300", "Dark olive",
        "003300", "Dark green",
        "003366", "Dark azure",
        "000080", "Navy Blue",
        "333399", "Indigo",
        "333333", "Very dark gray",
        "800000", "Maroon",
        "FF6600", "Orange",
        "808000", "Olive",
        "008000", "Green",
        "008080", "Teal",
        "0000FF", "Blue",
        "666699", "Grayish blue",
        "808080", "Gray",
        "FF0000", "Red",
        "FF9900", "Amber",
        "99CC00", "Yellow green",
        "339966", "Sea green",
        "33CCCC", "Turquoise",
        "3366FF", "Royal blue",
        "800080", "Purple",
        "999999", "Medium gray",
        "FF00FF", "Magenta",
        "FFCC00", "Gold",
        "FFFF00", "Yellow",
        "00FF00", "Lime",
        "00FFFF", "Aqua",
        "00CCFF", "Sky blue",
        "993366", "Red violet",
        "FFFFFF", "White",
        "CC99FF", "Light lavender",
        "FFCC99", "Peach",
        "FFFF99", "Light yellow",
        "CCFFCC", "Pale green",
        "CCFFFF", "Pale cyan",
        "99CCFF", "Light sky blue",
        "CC99CC", "Plum"
    ';

    $init['textcolor_map'] = '['.$default_colours.']';
    $init['textcolor_rows'] = 6; // Expand the color grid to 6 rows
    return $init;
}
add_filter('tiny_mce_before_init', 'my_mce4_options');





////////// FILTRE POUR RENDRE L'ADRESSE DE DESTINATION DES FORMULAIRES DYNAMIQUES
function dynamic_email_recipient( $components, $contact_form ) {
    
    
    // Récupérer l'objet du formulaire via l'ID ou un autre paramètre
    $form_id = $contact_form->id();
    
    // Vérifier l'ID du formulaire si nécessaire
    // if ( $form_id == '15aaca7' ) { // Remplacez 123 par l'ID de votre formulaire

        // Récupérer les données du formulaire (par exemple un champ avec l'email souhaité)
        $submission = WPCF7_Submission::get_instance();
        
        if ( $submission ) {
            $posted_data = $submission->get_posted_data();
            
            // Supposez qu'un champ de formulaire contient l'email (par exemple `[your-email]`)
            if ( isset( $posted_data['your-email'] ) ) {
                $email = sanitize_email( $posted_data['mail-agence'] );
                
                // Modifier l'adresse e-mail de destination
                $components['recipient'] = $email;
            }
        }
    // }
    
    return $components;
}

add_filter( 'wpcf7_mail_components', 'dynamic_email_recipient', 10, 2 );



