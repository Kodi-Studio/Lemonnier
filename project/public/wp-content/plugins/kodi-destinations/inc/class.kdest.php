<?php
class Kdest{
	function __construct() {
		
		add_action('admin_menu', 'kdest_manager');

		// add_action('admin_menu', 'kdest_types_manager');


		function kdest_manager() {
			//add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
			add_menu_page('Gestion des voyages', 'Destinations', 'manage_options', 'kdest_manager', 'showAdminTravelPage',   '', 90);
			// add_options_page('Gestion des rendez-vous', 'Destinations', 'manage_options', 'rdv_manager', 'showAdminTravelTypePage',   '', 90);
			add_submenu_page( 'kdest_manager', 'Gestion des types', 'types', 'manage_options', 'kdest_types_manager', 'showAdminTravelTypePage' );

		}

		function kdest_types_manager() {
			add_menu_page('Gestion des rendez-vousddsfs', 'Types de destinations', 'manage_options', 'kdest_type_manager', 'showAdminTravelTypePage');
		//  add_menu_page('Gestion des rendez-vous', 'RDV', 'manage_options', 'rdv_manager', 'showAdminPage',   '', 90);
		// 	add_submenu_page( 'rdv_manager', 'Gestion des RDV', 'Rendez-vous', 'manage_options', 'rdv_manager', 'showAdminPage' );
		// 	add_submenu_page( 'rdv_manager', 'Collabrateurs', 'Collaborateurs', 'manage_options', 'rdv_manager_persons', 'showAdminPersonsPage' );
			
		}

		function showAdminTravelPage() {  $myExt['admin_travel_page'] = new TRAVEL_Admin_Page();  }

		function showAdminTravelTypePage() {  $myExt['admin_travel_type_page'] = new TRAVEL_Admin_types_Page();  }
		
		
		
	
	}
	// Function called at the installation of the plugin
	static function kdest_Install() {
			///////// TABLES CREATION CREATION
			global $wpdb;
			
			$charset_collate = 'utf8mb4';
			/*if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') ) {
				if (!empty($wpdb->charset)) {
					$charset_collate .= " DEFAULT CHARACTER SET $wpdb->charset";
				}
				if (!empty($wpdb->collate)) {
					$charset_collate .= " COLLATE $wpdb->collate";
				}
			}*/
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset COLLATE $wpdb->collate";


			//// create travel tables
			// $createTableTravel = $wpdb->query("CREATE TABLE `kdest_travel` (
			// 			`travel_id` int(11) NOT NULL AUTO_INCREMENT,
			// 			`travel_title` varchar(256) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			`travel_subtitle` varchar(256) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			`travel_date_start_a` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			`person_job` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			UNIQUE KEY `id` (`person_id`)
			// 		) $charset_collate");






			// /// création wprdv_person
			// $createTablePerson = $wpdb->query("CREATE TABLE `wprdv_person` (
			// 			`person_id` int(11) NOT NULL AUTO_INCREMENT,
			// 			`person_firstName` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			`person_lastName` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			`person_email` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			`person_job` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			UNIQUE KEY `id` (`person_id`)
			// 		) $charset_collate");

			// // table wprdv_rdv
			// $createTableRdv = $wpdb->query("CREATE TABLE `wprdv_rdv` (
			// 			`rdv_id` int(11) NOT NULL AUTO_INCREMENT,
			// 			`person_id` int(11) NOT NULL,
			// 			`date` int(11) NOT NULL,
			// 			`date_time_rdv` int(11) NOT NULL,
			// 			`firstname` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
			// 			`lastname` varchar(128) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
			// 			`name` varchar(128) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
			// 			`mail` varchar(256) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			// 			`tel` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			// 			`message` varchar(512) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			// 			`confirmed` tinyint(1) NOT NULL DEFAULT '0',
			// 			`refused` tinyint(1) NOT NULL DEFAULT '0',
			// 			`allday` tinyint(1) NOT NULL DEFAULT '0',
			// 			UNIQUE KEY `rdvid` (`rdv_id`),
			// 			KEY `person_id` (`person_id`)
			// 		) AUTO_INCREMENT=0 $charset_collate");

		}
		// Function called at the uninstallation of the plugin
		function kdest_Uninstall() {

		}
	}
