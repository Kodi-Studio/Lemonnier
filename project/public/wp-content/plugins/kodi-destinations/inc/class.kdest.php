<?php
class Wprdv{
	function __construct() {
		
		add_action('admin_menu', 'rdv_manager');

		add_action('admin_menu', 'rdv_personmanager');


		function rdv_manager() {
			//add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
			add_menu_page('Gestion des rendez-vous', 'RDV Manager', 'manage_options', 'rdv_manager', 'showAdminRdvPage',   '', 90);
			///add_options_page('Gestion des rendez-vous', 'RDV', 'manage_options', 'rdv_manager', 'showAdminPage',   '', 90);

		}

		function rdv_personmanager() {
			//add_menu_page('Gestion des rendez-vous', 'RDV', 'manage_options', 'rdv_manager', 'showAdminPage',   '', 90);
			add_submenu_page( 'rdv_manager', 'Gestion des RDV', 'Rendez-vous', 'manage_options', 'rdv_manager', 'showAdminPage' );
			add_submenu_page( 'rdv_manager', 'Collabrateurs', 'Collaborateurs', 'manage_options', 'rdv_manager_persons', 'showAdminPersonsPage' );
			
		}

		function showAdminRdvPage() {  $myExt['admin_rdv_page'] = new RDVmanager_AdminRdv_Page();  }




		function showAdminPersonsPage() {  $myExt['admin_rdv_page'] = new RDVmanager_AdminPersons_Page();  }
		
		
		
	
	}
	// Function called at the installation of the plugin
	public function wprdv_Install() {
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
			/// création wprdv_person
			$createTablePerson = $wpdb->query("CREATE TABLE `wprdv_person` (
						`person_id` int(11) NOT NULL AUTO_INCREMENT,
						`person_firstName` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
						`person_lastName` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
						`person_email` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
						`person_job` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
						UNIQUE KEY `id` (`person_id`)
					) $charset_collate");

			// table wprdv_rdv
			$createTableRdv = $wpdb->query("CREATE TABLE `wprdv_rdv` (
						`rdv_id` int(11) NOT NULL AUTO_INCREMENT,
						`person_id` int(11) NOT NULL,
						`date` int(11) NOT NULL,
						`date_time_rdv` int(11) NOT NULL,
						`firstname` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
						`lastname` varchar(128) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
						`name` varchar(128) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
						`mail` varchar(256) COLLATE utf8mb4_unicode_520_ci NOT NULL,
						`tel` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL,
						`message` varchar(512) COLLATE utf8mb4_unicode_520_ci NOT NULL,
						`confirmed` tinyint(1) NOT NULL DEFAULT '0',
						`refused` tinyint(1) NOT NULL DEFAULT '0',
						`allday` tinyint(1) NOT NULL DEFAULT '0',
						UNIQUE KEY `rdvid` (`rdv_id`),
						KEY `person_id` (`person_id`)
					) AUTO_INCREMENT=0 $charset_collate");

		}
		// Function called at the uninstallation of the plugin
		function wprdv_Uninstall() {

		}
	}
