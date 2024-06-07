<?php


class TRAVEL_Admin_Page {

	function __construct() {
		
		wp_register_script( 'App', KDEST_URL . 'js/AppAdminKdest.js', null, null, true );
		wp_enqueue_script( 'App' );	

		// var_dump($_POST['travel_id']);
		if(isset($_GET['delete'])) {
			$this->travel_delete($_GET['delete']);
		}
		else if (isset($_POST['mp_form_update_submitted'])) {
			// if(isset($_POST['travel_id'])) $this->update_travel();
			// else  $this->create_travel();
			$this->update_travel();
		}
		else if(isset($_GET['edit'])) {
			$this->renderEditHTML();
		}else if(isset($_GET['new'])) {
			$this->renderEditHTML();
		}else {
			$this->renderListeHTML();
		}
	}

	function travel_delete($delete_id) {
		global $wpdb;
        $wpdb->delete('kdest_travel', array('travel_id' => $delete_id));
        echo '<div class="updated"><p>Élément supprimé avec succès</p></div>';
		$this->renderListeHTML();
	}


	function renderListeHTML() {
		
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM `kdest_travel`");

		$html =  "<div class='wrap' >";
		$html .=  "<h1>Gestion des voyages.";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions">
						<a href="?page=kdest_manager&new=1" class="page-title-action">Ajouter un voyage</a>
					</div>';
		$html .= '</div>';
		$html .= '<hr class="wp-header-end">';
		// $html .= '<div id="App">Plugin d\'administration</div>';

		$html.= '<table class="widefat">
            <thead>
                <tr>
                    <th></th>
                    <th>Titre</th>
                    <th>Sous Titre</th>
                    <th></th>
					<th></th>
                </tr>
            </thead>
            <tbody>';

		foreach ($results as $row) {
			$html.= '<tr>';
			$html.= '<td width="90" ><img src="' . esc_html($row->travel_vignette) . '" width="90" /></td>';
			$html.= '<td>' . esc_html($row->travel_title) . '</td>';
			$html.= '<td>' . esc_html($row->travel_subtitle) . '</td>';
			// $html.= '<td width="90" ><a href="?page=kdest_manager&delete=' . esc_attr($row->travel_id) . '" class="button">Supprimer</a></td>';
			$html.= '<td width="90" ><a href="javascript:removeTravel(\'?page=kdest_manager&delete=' . esc_attr($row->travel_id) . '\')" class="button">Supprimer</a></td>';
			$html.= '<td width="90" ><a href="?page=kdest_manager&edit=' . esc_attr($row->travel_id) . '" class="button">Éditer</a></td>';
			$html.= '</tr>';
		}

		$html .= '</tbody>
        </table>';

		$html .=  "</div>";

		echo $html;

	}



	function renderEditHTML() {

		global $wpdb;
		if(isset($_GET['edit'])) {
			$edit_id = intval($_GET['edit']);
			$edit_item = $wpdb->get_row($wpdb->prepare("SELECT * FROM `kdest_travel` WHERE travel_id = %d", $edit_id));
		} else {
			$edit_item = (object) array(
                    'travel_title' => '',
                    'travel_subtitle' => '',
                    'travel_description' => '',
					'travel_image' => '',
					'travel_vignette' => '',
					'travel_homepage' => 0,
					'travel_online' => 0,
					'travel_type_id' => '',
					'travel_date_a_start' => '',
					'travel_date_a_end' => '',
					'travel_price_a_1' => '',
					'travel_price_a_2' => '',
					'travel_date_b_start' => '',
					'travel_date_b_end' => '',
					'travel_price_b_1' => '',
					'travel_price_b_2' => '',
					'travel_discount_id' => null,

			);
		}

		/// liste des types de travel
		$travels_types = $wpdb->get_results("SELECT travel_type_id, travel_type_title FROM `travel_type`");
		$travel_discount = $wpdb->get_results("SELECT travel_discount_id, travel_discount_libelle FROM `travel_discount`");
		
		// var_dump($travel_discount);

		$html =  '
			<form method="post" action="" enctype="multipart/form-data" >
				<input type="hidden" name="mp_form_update_submitted" value="1">';
				if (isset($edit_item->travel_id)) {
					$html .= '<input type="hidden" name="travel_id" value="'.esc_attr($edit_item->travel_id).'">';
				}
		$html .= '
			<table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="travel_title">Titre</label></th>
                    <td><input type="text" id="travel_title" name="travel_title" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_title) : '').'" required></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_subtitle">Sous Titre</label></th>
                    <td><input type="text" id="travel_subtitle" name="travel_subtitle" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_subtitle) : '').'" required></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_description">Description</label></th>
                    <td><textarea id="travel_description" name="travel_description" class="large-text">'.esc_html($edit_item ? esc_attr($edit_item->travel_description) : '').'</textarea></td>
                </tr>';

		$html .= '<tr><th>Catégorie (type de voyage) :</th></tr>';
    	$html .= '<tr valign="top">';
    	$html .= '<th scope="row"><label for="travel_type_id">Type catégorie :</label></th>';
		$html .= '<td>
					<select id="travel_type_id" name="travel_type_id" required>
                    <option value="">Sélectionner une catégorie</option>';
					foreach ($travels_types as $type) {
                        $selected = $edit_item && $edit_item->travel_type_id == $type->travel_type_id ? 'selected' : '';
                        $html .='<option value="' . esc_attr($type->travel_type_id) . '" ' . $selected . '>' . esc_html($type->travel_type_title) . '</option>';
                    }

		$html .= '</select></td>';
		$html .= '</tr>';


			$html .= '
				<tr><th>Premières dates :</th></tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_date_a_start">Date de début</label></th>
                    <td><input type="date" id="travel_date_a_start" name="travel_date_a_start" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_a_start) : '').'" required></td>
                </tr>
				 <tr valign="top">
                    <th scope="row"><label for="travel_date_a_end">Date de fin</label></th>
                    <td><input type="date" id="travel_date_a_end" name="travel_date_a_end" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_a_end) : '').'" required></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_price_a_1">Tarif 1</label></th>
                    <td><input type="text" id="travel_price_a_1" name="travel_price_a_1" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_a_1) : '').'" required></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_price_a_2">Tarif 2</label></th>
                    <td><input type="text" id="travel_price_a_2" name="travel_price_a_2" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_a_2) : '').'" required></td>
                </tr>


				<tr ><th >Secondes dates :</th></tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_date_b_start">Date de début</label></th>
                    <td><input type="date" id="travel_date_b_start" name="travel_date_b_start" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_b_start) : '').'" required></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_date_b_end">Date de fin</label></th>
                    <td><input type="date" id="travel_date_b_end" name="travel_date_b_end" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_b_end) : '').'" required></td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"><label for="travel_price_b_1">Tarif 1</label></th>
                    <td><input type="text" id="travel_price_b_1" name="travel_price_b_1" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_b_1) : '').'" required></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_price_b_2">Tarif 2</label></th>
                    <td><input type="text" id="travel_price_b_2" name="travel_price_b_2" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_b_2) : '').'" required></td>
                </tr>
				
				<tr >
					<th >Sticker discount  :</th>';
		$html .= '<td>
					<select id="travel_discount_id" name="travel_discount_id" >
						<option value="">Sélectionner un sticker discount</option>';
						foreach ($travel_discount as $discount) {
							$selected = $edit_item && $edit_item->travel_discount_id == $discount->travel_discount_id ? 'selected' : '';
							$html .='<option value="' . esc_attr($discount->travel_discount_id) . '" ' . $selected . '>' . esc_html($discount->travel_discount_libelle) . '</option>';
						}

		$html .= '</select></td>';

		$html .= '</tr>
				<tr ><th >Images  :</th></tr>
				<tr valign="top">
                    <th scope="row"><label for="image">Image principale</label></th>
                    <td>
                        <input type="file" id="travel_image" name="travel_image" accept="image/*">
                        
                        <p><img src="'.esc_attr($edit_item->travel_image).'" alt="" style="max-width: 300px;"></p>
                        
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_vignette">Vignette</label></th>
                    <td>
                        <input type="file" id="travel_vignette" name="travel_vignette" accept="image/*">
                        
                        <p><img src="'.esc_attr($edit_item->travel_vignette).'" alt="" style="max-width: 150px;"></p>
                        
                    </td>
                </tr>

		<tr valign="top">
         	<th scope="row"><label for="travel_homepage">Afficher en page d\'accueil :</label></th>
            <td><input type="checkbox" id="travel_homepage" name="travel_homepage" value="1" '.esc_attr($edit_item && $edit_item->travel_homepage ? 'checked' : '').'></td>
        </tr>
		<tr valign="top">
         	<th scope="row"><label for="travel_online">Publié :</label></th>
            <td><input type="checkbox" id="travel_online" name="travel_online" value="1" '.esc_attr($edit_item && $edit_item->travel_online ? 'checked' : '').'></td>
        </tr>
		</table>';
				
		$html .= '<p class="submit"><input type="submit" name="action" class="button-primary" value="'.esc_attr($edit_item->travel_id ?  'enregistrer' : 'créer').'"></p></form>';
		
		echo $html;

	}

	function update_travel() {
		
		global $wpdb;

		// Inclure les fichiers nécessaires pour l'upload d'images
		if (!function_exists('wp_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}
		if (!function_exists('media_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
		}

		$travel_title = sanitize_text_field($_POST['travel_title']);
        $travel_subtitle = sanitize_text_field($_POST['travel_subtitle']);
        $travel_description = sanitize_text_field($_POST['travel_description']);

		$travel_date_a_start = sanitize_text_field($_POST['travel_date_a_start']);
		$travel_date_a_end = sanitize_text_field($_POST['travel_date_a_end']);

		$travel_date_b_start = sanitize_text_field($_POST['travel_date_b_start']);
		$travel_date_b_end = sanitize_text_field($_POST['travel_date_b_end']);

		$travel_price_a_1 = sanitize_text_field($_POST['travel_price_a_1']);
		$travel_price_a_2 = sanitize_text_field($_POST['travel_price_a_2']);

		$travel_price_b_1 = sanitize_text_field($_POST['travel_price_b_1']);
		$travel_price_b_2 = sanitize_text_field($_POST['travel_price_b_2']);

		$travel_discount_id = sanitize_text_field($_POST['travel_discount_id']);

		$travel_homepage = isset($_POST['travel_homepage']) ? 1 : 0;
		$travel_online = isset($_POST['travel_online']) ? 1 : 0;

		$travel_type_id = intval($_POST['travel_type_id']);
       

        // // Gestion de l'upload de l'image principale
        if (!empty($_FILES['travel_image']['name'])) {
            $uploaded = media_handle_upload('travel_image', 0);
            if (is_wp_error($uploaded)) {
                echo '<div class="error"><p>Erreur lors du téléchargement de l\'image : ' . $uploaded->get_error_message() . '</p></div>';
            } else {
                $travel_image = wp_get_attachment_url($uploaded);
            }
        } else if (isset($_POST['travel_id'])) {
            // Conserver l'image existante si elle n'a pas été mise à jour
            $edit_id = intval($_POST['travel_id']);
            $existing_item = $wpdb->get_row($wpdb->prepare("SELECT travel_image FROM `kdest_travel` WHERE travel_id = %d", $edit_id));
            $travel_image = $existing_item->travel_image;
        }

		// // Gestion de l'upload de l'image vignette
        if (!empty($_FILES['travel_vignette']['name'])) {
            $uploaded = media_handle_upload('travel_vignette', 0);
            if (is_wp_error($uploaded)) {
                echo '<div class="error"><p>Erreur lors du téléchargement de l\'image : ' . $uploaded->get_error_message() . '</p></div>';
            } else {
                $travel_vignette = wp_get_attachment_url($uploaded);
            }
        } else if (isset($_POST['travel_id'])) {
            // Conserver l'image existante si elle n'a pas été mise à jour
            $edit_id = intval($_POST['travel_id']);
            $existing_item = $wpdb->get_row($wpdb->prepare("SELECT travel_vignette FROM `kdest_travel` WHERE travel_id = %d", $edit_id));
            $travel_vignette = $existing_item->travel_vignette;
        }

        if (isset($_POST['travel_id'])) {
            $travel_id = intval($_POST['travel_id']);

            $wpdb->update(
                'kdest_travel',
                array(
                    'travel_title' => $travel_title,
                    'travel_subtitle' => $travel_subtitle,
                    'travel_description' => $travel_description,
					'travel_image' => $travel_image,
					'travel_vignette' => $travel_vignette,
					'travel_homepage' => $travel_homepage,
					'travel_online' => $travel_online,
					'travel_type_id' => $travel_type_id,
					'travel_date_a_start' => $travel_date_a_start,
					'travel_date_a_end' => $travel_date_a_end,
					'travel_price_a_1' => $travel_price_a_1,
					'travel_price_a_2' => $travel_price_a_2,
					'travel_date_b_start' => $travel_date_b_start,
					'travel_date_b_end' => $travel_date_b_end,
					'travel_price_b_1' => $travel_price_b_1,
					'travel_price_b_2' => $travel_price_b_2,
					'travel_discount_id' => $travel_discount_id
                ),
                array('travel_id' => $travel_id)
            );
            echo '<div class="updated"><p>Données mises à jour avec succès '.$travel_title.'</p></div>';

			$this->renderEditHTML();
		
        } else {
            $wpdb->insert(
                'kdest_travel',
                array(
                    'travel_title' => $travel_title,
                    'travel_subtitle' => $travel_subtitle,
                    'travel_description' => $travel_description,
					'travel_image' => $travel_image,
					'travel_vignette' => $travel_vignette,
					'travel_homepage' => $travel_homepage,
					'travel_online' => $travel_online,
					'travel_type_id' => $travel_type_id,
					'travel_type_id' => $travel_type_id,
					'travel_date_a_start' => $travel_date_a_start,
					'travel_date_a_end' => $travel_date_a_end,
					'travel_price_a_1' => $travel_price_a_1,
					'travel_price_a_2' => $travel_price_a_2,
					'travel_date_b_start' => $travel_date_b_start,
					'travel_date_b_end' => $travel_date_b_end,
					'travel_price_b_1' => $travel_price_b_1,
					'travel_price_b_2' => $travel_price_b_2,
					'travel_discount_id' => $travel_discount_id
                ),
            );
			// echo "page d'insertion d'une nouvelle destination";
            echo '<div class="updated"><p>Données enregistrées avec succès</p></div>';

			$this->renderListeHTML();
        }
    
	}
}





// class RDVmanager_AdminRdv_Page{
// 	function __construct() {
		
// 		wp_register_script( 'App', KDEST_URL . 'js/AppAdminRdv.js', array('mithril') , null, true );
// 		wp_enqueue_script( 'App' );	

// 		$this->renderHTML();
	
// 	}
// 	function renderHTML(){

// 		$personListe = getListePerson();
// 		/// jout d'une entrée pour le combobox
// 		$label = $arrayName = array('person_id' =>null ,'person_firstName'=>'choisissez','person_lastName'=>' une personne' );
// 		array_unshift( $personListe , $label );

// 		//// definition des plages haraires
// 		$during = 1800;	$start = 50400;/*14h00*/  $end =	64800;
// 		/// Definition des plages horaies
// 		$tabTimes = array();
// 		for( $i = $start; $i < $end ; $i+=$during ) {
// 			array_push(  $tabTimes ,  date('H:i' , $i ).'|'.date('H:i' , $i+$during ).'|'.$i );
// 		}



// 		$today = new DateTime( date('d-m-Y' , time()) , new DateTimeZone('UTC') );
// 		$stampToday = $today->getTimestamp();
		
// 		$during = 1800;	$start = 50400;/*14h00*/  $end =	64800;
// 		/// Definition des plages horaies
// 		$tabTimes = array();
// 		for( $i = $start; $i < $end ; $i+=$during ) {
// 			array_push(  $tabTimes ,  date('H:i' , $i ).'|'.date('H:i' , $i+$during ).'|'.$i );
// 		}

// 		$html =  "<div class='wrap' >";
// 		$html .=  "<h1>Gestion des rendez-vous en ligne.";
// 		$html .=  '<div class="tablenav top">';
// 		$html .=  	'<div class="alignleft actions bulkactions"></div>';
// 		$html .= '</div>';

// 		$html .= '<div id="App">Plugin d\'administration</div>';

// 		$html .=  "</div>";


// 		$html .= "<script>";
// 		$html .= "var stampToday = ".$stampToday.";";
// 		$html .= "var personListe = ".json_encode($personListe).";";
// 		$html .= "var rdvTimes = ".json_encode($tabTimes).";";
// 		$html .= "</script>";



// 		echo $html;

// 	}
// }
// ?>