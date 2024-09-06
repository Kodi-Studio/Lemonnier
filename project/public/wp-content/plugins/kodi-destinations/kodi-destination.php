<?php
/*
Plugin Name: KodiStudio - Destinations
Plugin URI: http://www.kodi-studio.fr
Description: Gestion des destinations
Version: 0.1
Author: KODI Studio
Author URI: http://www.christopheharel.fr
Text Domain: kdest
*/
define( 'KDEST_URL', plugins_url('/', __FILE__) );
define( 'KDEST_DIR', dirname(__FILE__) );
define( 'KDEST_VERSION', '0.1' );
define( 'KDEST_OPTION', 'me_ext' );





// Activation, uninstall

//register_deactivation_hook ( __FILE__, 'wprdv_Uninstall' );


//// intégration des widgets
//require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'widget_KDEST.php' );
//require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc/class.client.php' );

function Kdest_Init() {
	global $titi;

	//// public part
	if ( !is_admin() ) {
		//header('Location: http://www.example.com/');
		require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'functions.tpl.php' );	
		// require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.client.php' );
		// $tab = getallheaders();
		// if(strrpos($tab['Accept'] ,'application/json' )>-1){
		// 	require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.webservice.php' );
		// 	$webservice = new wprdv_Clientwebservice();			
		// }
		// $myExt['client'] = new wprdv_Client();
	}
	// Admin part
	else if ( is_admin() ) {
		require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'functions.plugin.php' );
		require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.kdest.php' );
		//// page d'administration des voyages
		require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.adminkdest.page.php' );
		// page d'administration des types de voyages (monde, europe ...etc)
		require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.adminkdesttypes.page.php' );
		// page d'administration des discounts
		require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.adminkdestdiscount.page.php' );
		// page d'administration des catalogues
		require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.admincata.page.php' );
		
		
		$myExt['admin_page'] = new Kdest();

		///// preparation des reponses AJAX côté admin
		// function generic_Webservice() {
		// 	require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'class.webservice.php' );
		// 	$webservice = new wprdv_Clientwebservice();
		// 	die();
		// }

		// add_action( 'wp_ajax_rdvlisteAdmin', 'generic_Webservice' );
		// add_action( 'wp_ajax_nopriv_rdvlisteAdmin', 'generic_Webservice' );

		// add_action( 'wp_ajax_updaterdv', 'generic_Webservice' );
		// add_action( 'wp_ajax_nopriv_updaterdv', 'generic_Webservice' );

		// /// nouveau rdv depuis l'admin
		// add_action( 'wp_ajax_newRdvAdmin', 'generic_Webservice' );
		// add_action( 'wp_ajax_nopriv_newRdvAdmin', 'generic_Webservice' );

		// /// suppression collaborateur depuis admin
		// add_action( 'wp_ajax_deletePerson', 'generic_Webservice' );
		// add_action( 'wp_ajax_nopriv_deletePerson', 'generic_Webservice' );
		// /// update collaborateur depuis admin
		// add_action( 'wp_ajax_updatePerson', 'generic_Webservice' );
		// add_action( 'wp_ajax_nopriv_updatePerson', 'generic_Webservice' );	
		// /// insertion collaborateur depuis admin
		// add_action( 'wp_ajax_insertPerson', 'generic_Webservice' );
		// add_action( 'wp_ajax_nopriv_updatePerson', 'generic_Webservice' );
		// /// get persons configs -> coté client 
		// add_action( 'wp_ajax_getPersonsConfigs', 'generic_Webservice' );
		// add_action( 'wp_ajax_nopriv_getPersonsConfigs', 'generic_Webservice' );


		
	}
}
add_action( 'plugins_loaded', 'Kdest_Init' );

if ( is_admin() ) {
	require_once( KDEST_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR.'class.kdest.php' );
	register_activation_hook( __FILE__, array('Kdest','kdest_Install') );
}

/////////////////////////////////////  importation des fichiers javascripts côté client
function Kdest_jsScripts(){
	//wp_enqueue_style( 'tadv-css', TADV_URL . 'css/tadv-styles.css', array( 'editor-buttons' ), '4.0' );
	//wp_enqueue_style( 'wprdv_styles', KDEST_URL. "css/wprdv_styles.css", array( 'wprdv_styles_css' ) , '1.0' , false  );

	wp_register_style( 'wprdv_styles.css', KDEST_URL. "css/wprdv_styles.css", array(), '0.1' );
	wp_enqueue_style( 'wprdv_styles.css');

	wp_register_script( 'jquery.numeric.js', KDEST_URL . 'js/jquery.numeric.js', array('jquery') );
	wp_enqueue_script( 'jquery.numeric.js' );
	wp_register_script( 'scripts.js', KDEST_URL . 'js/scripts.js', array('jquery.numeric.js') );
	wp_enqueue_script( 'scripts.js' );
	wp_register_script( 'mithril', KDEST_URL .'js/mithril.js' );
	wp_enqueue_script( 'mithril' );
	wp_register_script( 'App', KDEST_URL . 'js/App.js', array('mithril') , null, true );
	wp_enqueue_script( 'App' );	
}
if(!is_admin()) add_action('init','Kdest_jsScripts');


/////////////////////////////////////  importation des fichiers javascripts côté Admin
function Kdest_jsScriptsAdmin(){
	//wp_enqueue_style( 'tadv-css', TADV_URL . 'css/tadv-styles.css', array( 'editor-buttons' ), '4.0' );
	//wp_enqueue_style( 'wprdv_styles', KDEST_URL. "css/wprdv_styles.css", array( 'wprdv_styles_css' ) , '1.0' , false  );

	wp_register_style( 'wprdv_styles.css', KDEST_URL. "css/wprdv_styles.css", array(), '0.1' );
	wp_enqueue_style( 'wprdv_styles.css');

	 wp_register_script( 'jquery.numeric.js', KDEST_URL . 'js/jquery.numeric.js', array('jquery') );
	wp_enqueue_script( 'jquery.numeric.js' );
	wp_register_script( 'scripts.js', KDEST_URL . 'js/scripts.js', array('jquery.numeric.js') );
	wp_enqueue_script( 'scripts.js' );
	wp_register_script( 'mithril', KDEST_URL .'js/mithril.js' );
	wp_enqueue_script( 'mithril' );
	//wp_register_script( 'App', KDEST_URL . 'js/AppAdminRdv.js', array('mithril') , null, true );
	//wp_enqueue_script( 'App' );	
}
if(is_admin()) add_action('init','Kdest_jsScriptsAdmin');





//// INTEGRATION DU PLUGIN DANS LA PAGE COTE CLIENT
function wprdv_add_module($post_body) {

    if(  strpos($post_body, '[wprdv]') && is_page() ){
	    //$post_body = str_replace("WordPress", "ototototo Youpi !!!", $post_body );

	    $myExt['client'] = new wprdv_Client();
	    $content = $myExt['client']->render( $post_body);
	    return $content;    	
    }else{
    	return $post_body;
    }
}
add_filter('the_content', 'wprdv_add_module', 9999);



////////// FILTRE POUR RENDRE L'ADRESSE DE DESTINATION DES FORMULAIRES DYNAMIQUES
function dynamic_email_recipient( $components, $contact_form ) {
    
    // Récupérer l'objet du formulaire via l'ID ou un autre paramètre
    $form_id = $contact_form->id();
    
    // Vérifier l'ID du formulaire si nécessaire
    if ( $form_id == '15aaca7' ) { // Remplacez 123 par l'ID de votre formulaire

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
    }
    
    return $components;
}

add_filter( 'wpcf7_mail_components', 'dynamic_email_recipient', 10, 2 );



?>