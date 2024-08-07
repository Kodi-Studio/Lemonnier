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

	function br2nl($string) {
    	return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
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
					'travel_display_position' => '',
                    'travel_title' => '',
                    'travel_subtitle' => '',
					'travel_subtitle_fiche' => '',
                    'travel_description' => '',
					'travel_during_text' => '',
					'travel_image' => '',
					'travel_vignette' => '',
					'travel_homepage' => 0,
					'travel_online' => 0,
					'travel_type_id' => '',
					'travel_date_a_start' => '',
					'travel_date_a_end' => '',
					'travel_date_a_note' => '',
					'travel_price_a_1' => '',
					'travel_price_a_2' => '',
					'travel_date_b_start' => '',
					'travel_date_b_end' => '',
					'travel_date_b_note' => '',
					'travel_price_b_1' => '',
					'travel_price_b_2' => '',

					'travel_date_c_start' => '',
					'travel_date_c_end' => '',
					'travel_date_c_note' => '',
					'travel_price_c_1' => '',
					'travel_price_c_2' => '',

					'travel_date_d_start' => '',
					'travel_date_d_end' => '',
					'travel_date_d_note' => '',
					'travel_price_d_1' => '',
					'travel_price_d_2' => '',

					'travel_date_alt_text' => '',

					'travel_discount_id' => null,
					'travel_page_id' => null,
					'travel_pdf' => ''

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
                    <th scope="row"><label for="travel_display_position">Position dans la page</label></th>
                    <td><input type="number" id="travel_display_position" name="travel_display_position" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_display_position) : 0).'" required></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_subtitle">Sous Titre</label></th>
                    <td><input type="text" id="travel_subtitle" name="travel_subtitle" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_subtitle) : '').'" required></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_subtitle_fiche">Sous Titre (fiche voyage)</label></th>
					<td><input type="text" id="travel_subtitle_fiche" name="travel_subtitle_fiche" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_subtitle_fiche) : '').'" ></td>
				</tr>
				
				<tr valign="top">
                    <th scope="row"><label for="travel_description">Description</label></th>
                    <td><textarea id="travel_description" name="travel_description" class="large-text">'.esc_html($edit_item ? esc_attr($edit_item->travel_description) : '').'</textarea></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_during_text">Durée <small>(ex: 10 jours/7 nuits)</small></label></th>
                    <td><textarea id="travel_during_text" name="travel_during_text" class="large-text">'.esc_html($edit_item ? esc_attr($edit_item->travel_during_text) : '').'</textarea></td>
                </tr>
				';

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
                    <td><input type="date" id="travel_date_a_start" name="travel_date_a_start" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_a_start) : '').'" ></td>
                </tr>
				 <tr valign="top">
                    <th scope="row"><label for="travel_date_a_end">Date de fin</label></th>
                    <td><input type="date" id="travel_date_a_end" name="travel_date_a_end" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_a_end) : '').'" ></td>
                </tr>
			
				<tr valign="top">
                    <th scope="row"><label for="travel_price_a_1">Tarif 1</label></th>
                    <td><input type="text" id="travel_price_a_1" name="travel_price_a_1" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_a_1) : '').'" ></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_price_a_1_note">Note tarif</label></th>
					<td><input type="text" id="travel_price_a_1_note" name="travel_price_a_1_note" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_a_1_note) : '').'" ></td>
				</tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_price_a_2">Tarif 2</label></th>
                    <td><input type="text" id="travel_price_a_2" name="travel_price_a_2" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_a_2) : '').'" ></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_price_a_2_note">Note tarif</label></th>
					<td><input type="text" id="travel_price_a_2_note" name="travel_price_a_2_note" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_a_2_note) : '').'" ></td>
				</tr>

				
				<tr ><th >Secondes dates :</th></tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_date_b_start">Date de début</label></th>
                    <td><input type="date" id="travel_date_b_start" name="travel_date_b_start" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_b_start) : '').'" ></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_date_b_end">Date de fin</label></th>
                    <td><input type="date" id="travel_date_b_end" name="travel_date_b_end" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_b_end) : '').'" ></td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"><label for="travel_price_b_1">Tarif 1</label></th>
                    <td><input type="text" id="travel_price_b_1" name="travel_price_b_1" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_b_1) : '').'" ></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_price_b_1_note">Note tarif</label></th>
					<td><input type="text" id="travel_price_b_1_note" name="travel_price_b_1_note" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_b_1_note) : '').'" ></td>
				</tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_price_b_2">Tarif 2</label></th>
                    <td><input type="text" id="travel_price_b_2" name="travel_price_b_2" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_b_2) : '').'" ></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_price_b_2_note">Note tarif</label></th>
					<td><input type="text" id="travel_price_b_2_note" name="travel_price_b_2_note" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_b_2_note) : '').'" ></td>
				</tr>


				<tr ><th >Troisième dates :</th></tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_date_c_start">Date de début</label></th>
                    <td><input type="date" id="travel_date_c_start" name="travel_date_c_start" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_c_start) : '').'" ></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_date_c_end">Date de fin</label></th>
                    <td><input type="date" id="travel_date_c_end" name="travel_date_c_end" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_c_end) : '').'" ></td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"><label for="travel_price_c_1">Tarif 1</label></th>
                    <td><input type="text" id="travel_price_c_1" name="travel_price_c_1" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_c_1) : '').'" ></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_price_c_1_note">Note tarif</label></th>
					<td><input type="text" id="travel_price_c_1_note" name="travel_price_c_1_note" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_c_1_note) : '').'" ></td>
				</tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_price_c_2">Tarif 2</label></th>
                    <td><input type="text" id="travel_price_c_2" name="travel_price_c_2" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_c_2) : '').'" ></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_price_c_2_note">Note tarif</label></th>
					<td><input type="text" id="travel_price_c_2_note" name="travel_price_c_2_note" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_c_2_note) : '').'" ></td>
				</tr>

				<!-- -->

				<tr ><th >Quatrième dates :</th></tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_date_d_start">Date de début '.$_POST['travel_date_d_start'].'</label></th>
                    <td><input type="date" id="travel_date_d_start" name="travel_date_d_start" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_d_start) : '').'" ></td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_date_d_end">Date de fin</label></th>
                    <td><input type="date" id="travel_date_d_end" name="travel_date_d_end" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_d_end) : '').'" ></td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"><label for="travel_price_d_1">Tarif 1</label></th>
                    <td><input type="text" id="travel_price_d_1" name="travel_price_d_1" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_d_1) : '').'" ></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_price_d_1_note">Note tarif</label></th>
					<td><input type="text" id="travel_price_d_1_note" name="travel_price_d_1_note" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_d_1_note) : '').'" ></td>
				</tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_price_d_2">Tarif 2</label></th>
                    <td><input type="text" id="travel_price_d_2" name="travel_price_d_2" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_d_2) : '').'" ></td>
                </tr>
				<tr valign="top">
					<th scope="row"><label for="travel_price_d_2_note">Note tarif</label></th>
					<td><input type="text" id="travel_price_d_2_note" name="travel_price_d_2_note" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_price_d_2_note) : '').'" ></td>
				</tr>


				<!-- -->


				<tr valign="top">
					<th scope="row"><label for="travel_price_c_2_note">Texte alternatif aux dates</label></th>
					<td><input type="text" id="travel_date_alt_text" name="travel_date_alt_text" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_date_alt_text) : '').'" ></td>
				</tr>

				<tr valign="top">
                    <th scope="row"><label for="travel_plus_vlm">Les plus VLM</label></th>
                    <td><textarea rows="8" id="travel_plus_vlm" name="travel_plus_vlm" class="large-text">'.esc_html($edit_item ? wp_kses_post(preg_replace('/\<br(\s*)?\/?\>/i', "", $edit_item->travel_plus_vlm)) : '').'</textarea></td>
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
				<tr ><th >Images et fiche PDF :</th></tr>
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
                    <th scope="row"><label for="travel_pdf">Fiche PDF</label></th>
                    <td>
                        <input type="file" id="travel_pdf" name="travel_pdf" accept="application/pdf">
                        ';
                    	 if (!empty($edit_item->travel_pdf)) {
							$html .= '<p><a href="'.esc_attr($edit_item->travel_pdf).'" target="_blank">Voir la fiche PDF</a></p>';
						 }
                        
        $html .='           </td>
                </tr>

		<tr valign="top">
         	<th scope="row"><label for="travel_homepage">Afficher en page d\'accueil :</label></th>
            <td><input type="checkbox" id="travel_homepage" name="travel_homepage" value="1" '.esc_attr($edit_item && $edit_item->travel_homepage ? 'checked' : '').'></td>
        </tr>
		<tr valign="top">
         	<th scope="row"><label for="travel_online">Publié :</label></th>
            <td><input type="checkbox" id="travel_online" name="travel_online" value="1" '.esc_attr($edit_item && $edit_item->travel_online ? 'checked' : '').'></td>
        </tr>

		<tr valign="top">
			<th scope="row"><label for="travel_page_id">ID de la page <br /><small>Effacer la valeur pour créer une nouvelle page</small></label></th>
			<td><input id="travel_page_id" name="travel_page_id" type="text" value="'.$edit_item->travel_page_id.'" /></td>
		</tr>

		</table>';
				
		$html .= '<p class="submit"><input type="submit" name="action" class="button-primary" value="'.esc_attr(isset($edit_item->travel_id) ?  'enregistrer' : 'créer').'"></p></form>';
		
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

		$travel_display_position = sanitize_text_field(wp_unslash($_POST['travel_display_position']));
		$travel_title = sanitize_text_field(wp_unslash($_POST['travel_title']));
        $travel_subtitle = sanitize_text_field(wp_unslash($_POST['travel_subtitle']));
		$travel_subtitle_fiche = sanitize_text_field(wp_unslash($_POST['travel_subtitle_fiche']));
        $travel_description = sanitize_text_field(wp_unslash($_POST['travel_description']));
		$travel_during_text = sanitize_text_field(wp_unslash($_POST['travel_during_text']));

		$travel_date_a_start = sanitize_text_field($_POST['travel_date_a_start']);
		$travel_date_a_end = sanitize_text_field($_POST['travel_date_a_end']);

		$travel_date_b_start = sanitize_text_field($_POST['travel_date_b_start']);
		$travel_date_b_end = sanitize_text_field($_POST['travel_date_b_end']);

		$travel_date_c_start = sanitize_text_field($_POST['travel_date_c_start']);
		$travel_date_c_end = sanitize_text_field($_POST['travel_date_c_end']);
		var_dump($_POST['travel_date_d_start']);
		$travel_date_d_start = sanitize_text_field($_POST['travel_date_d_start']);
		$travel_date_d_end = sanitize_text_field($_POST['travel_date_d_end']);


		$travel_price_a_1 = sanitize_text_field($_POST['travel_price_a_1']);
		$travel_price_a_1_note = sanitize_text_field($_POST['travel_price_a_1_note']);
		$travel_price_a_2 = sanitize_text_field($_POST['travel_price_a_2']);
		$travel_price_a_2_note = sanitize_text_field($_POST['travel_price_a_2_note']);

		$travel_price_b_1 = sanitize_text_field($_POST['travel_price_b_1']);
		$travel_price_b_1_note = sanitize_text_field($_POST['travel_price_b_1_note']);
		$travel_price_b_2 = sanitize_text_field($_POST['travel_price_b_2']);
		$travel_price_b_2_note = sanitize_text_field($_POST['travel_price_b_2_note']);

		$travel_price_c_1 = sanitize_text_field($_POST['travel_price_c_1']);
		$travel_price_c_1_note = sanitize_text_field($_POST['travel_price_c_1_note']);
		$travel_price_c_2 = sanitize_text_field($_POST['travel_price_c_2']);
		$travel_price_c_2_note = sanitize_text_field($_POST['travel_price_c_2_note']);

		$travel_price_d_1 = sanitize_text_field($_POST['travel_price_d_1']);
		$travel_price_d_1_note = sanitize_text_field($_POST['travel_price_d_1_note']);
		$travel_price_d_2 = sanitize_text_field($_POST['travel_price_d_2']);
		$travel_price_d_2_note = sanitize_text_field($_POST['travel_price_d_2_note']);

		$travel_date_alt_text = sanitize_text_field($_POST['travel_date_alt_text']);

		// $travel_plus_vlm = sanitize_text_field(wp_unslash($_POST['travel_plus_vlm']));
		$travel_plus_vlm = wp_kses_post(nl2br(wp_unslash($_POST['travel_plus_vlm'])));

		$travel_discount_id = sanitize_text_field($_POST['travel_discount_id']);

		$travel_homepage = isset($_POST['travel_homepage']) ? 1 : 0;
		$travel_online = isset($_POST['travel_online']) ? 1 : 0;

		$travel_type_id = intval($_POST['travel_type_id']);

		$travel_page_id = ( isset($_POST['travel_page_id']) && $_POST['travel_page_id'] != null ) ? $_POST['travel_page_id'] : null;

		$travel_image = '';
		$travel_vignette = '';
		$travel_pdf = '';

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

		 // // Gestion de l'upload de la fiche PDF
        if (!empty($_FILES['travel_pdf']['name'])) {
            $uploaded = media_handle_upload('travel_pdf', 0);
            if (is_wp_error($uploaded)) {
                echo '<div class="error"><p>Erreur lors du téléchargement de l\'image : ' . $uploaded->get_error_message() . '</p></div>';
            } else {
                $travel_pdf = wp_get_attachment_url($uploaded);
            }
        } else if (isset($_POST['travel_id'])) {
            // Conserver l'image existante si elle n'a pas été mise à jour
            $edit_id = intval($_POST['travel_id']);
            $existing_item = $wpdb->get_row($wpdb->prepare("SELECT travel_pdf FROM `kdest_travel` WHERE travel_id = %d", $edit_id));
            $travel_pdf = $existing_item->travel_pdf;
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

            /// eventuelle création de page
            if($travel_page_id === null) {
				
				// $travel_type =  = 
				global $wpdb;
				$result = $wpdb->get_results("SELECT * FROM `travel_type` WHERE travel_type_id = $travel_type_id ");

				$page_parent_id = $result[0]->travel_type_page_id;
                /// creation de la page
                $page_title = $travel_title;
                $page_content = '';
                $new_page = array(
					'post_title'    => $page_title,
					'post_content'  => $page_content,
					'post_status'   => 'publish', // ou 'draft' si vous ne souhaitez pas publier immédiatement
					'page_template' => 'template-destination-fiche.php',
					'post_type'     => 'page',
					'post_parent'   => $page_parent_id
				);
				// Insérez la page dans la base de données WordPress
				$travel_page_id = wp_insert_post($new_page);
				// // Vérifiez si l'insertion a réussi et affichez un message d'erreur si nécessaire
				if (is_wp_error($travel_page_id)) {
					// Gestion de l'erreur ici
					error_log('Erreur lors de la création de la page: ' . $page_id->get_error_message());
				}
            }



            $wpdb->update(
                'kdest_travel',
                array(
					'travel_display_position' => $travel_display_position,
                    'travel_title' => $travel_title,
                    'travel_subtitle' => $travel_subtitle,
					'travel_subtitle_fiche' => $travel_subtitle_fiche,
                    'travel_description' => $travel_description,
					'travel_during_text' => $travel_during_text,
					'travel_image' => $travel_image,
					'travel_vignette' => $travel_vignette,
					'travel_pdf' => $travel_pdf,
					'travel_homepage' => $travel_homepage,
					'travel_online' => $travel_online,
					'travel_type_id' => $travel_type_id,
					'travel_date_a_start' => $travel_date_a_start,
					'travel_date_a_end' => $travel_date_a_end,
					'travel_price_a_1' => $travel_price_a_1,
					'travel_price_a_1_note' => $travel_price_a_1_note,
					'travel_price_a_2' => $travel_price_a_2,
					'travel_price_a_2_note' => $travel_price_a_2_note,
					'travel_date_b_start' => $travel_date_b_start,
					'travel_date_b_end' => $travel_date_b_end,
					'travel_price_b_1' => $travel_price_b_1,
					'travel_price_b_1_note' => $travel_price_b_1_note,
					'travel_price_b_2' => $travel_price_b_2,
					'travel_price_b_2_note' => $travel_price_b_2_note,
					
					'travel_date_c_start' => $travel_date_c_start,
					'travel_date_c_end' => $travel_date_c_end,
					'travel_price_c_1' => $travel_price_c_1,
					'travel_price_c_1_note' => $travel_price_c_1_note,
					'travel_price_c_2' => $travel_price_c_2,
					'travel_price_c_2_note' => $travel_price_c_2_note,

					'travel_date_d_start' => $travel_date_d_start,
					'travel_date_d_end' => $travel_date_d_end,
					'travel_price_d_1' => $travel_price_d_1,
					'travel_price_d_1_note' => $travel_price_d_1_note,
					'travel_price_d_2' => $travel_price_d_2,
					'travel_price_d_2_note' => $travel_price_d_2_note,

					'travel_date_alt_text' => $travel_date_alt_text,

					'travel_plus_vlm' => $travel_plus_vlm,
					'travel_discount_id' => $travel_discount_id,
					'travel_page_id' => $travel_page_id
                ),
                array('travel_id' => $travel_id)
            );
            echo '<div class="updated"><p>Données mises à jour avec succès '.$travel_title.'</p></div>';

			$this->renderEditHTML();
		
        } else {

			 // Vérifiez d'abord si la page n'existe pas déjà pour éviter les doublons
            $page_title = $travel_title;
            $page_content = '';
            // $page_check = get_page_by_title($page_title);
            $page_check = (object) get_posts(
                array(
                    'post_type'              => 'page',
                    'title'                  => $page_title,
                )
            );

			$page_check = gettype($page_check) == 'array' ? $page_check[0] : null;

            // Si la page n'existe pas encore, on la crée
            if (!isset($page_check->ID)) {	

				global $wpdb;
				$result = $wpdb->get_results("SELECT * FROM `travel_type` WHERE travel_type_id = $travel_type_id ");

				$page_parent_id = $result[0]->travel_type_page_id;
                /// creation de la page
                $page_title = $travel_title;
                $page_content = '';
                $new_page = array(
					'post_title'    => $page_title,
					'post_content'  => $page_content,
					'post_status'   => 'publish', // ou 'draft' si vous ne souhaitez pas publier immédiatement
					'page_template' => 'template-destination-fiche.php',
					'post_type'     => 'page',
					'post_parent'   => $page_parent_id
				);
				// Insérez la page dans la base de données WordPress
				$travel_page_id = wp_insert_post($new_page);
				// // Vérifiez si l'insertion a réussi et affichez un message d'erreur si nécessaire
				if (is_wp_error($travel_page_id)) {
					// Gestion de l'erreur ici
					error_log('Erreur lors de la création de la page: ' . $page_id->get_error_message());
				}

			}


            $wpdb->insert(
                'kdest_travel',
                array(
					'travel_display_position'=> $travel_display_position,
                    'travel_title' => $travel_title,
                    'travel_subtitle' => $travel_subtitle,
					'travel_subtitle_fiche' => $travel_subtitle_fiche,
                    'travel_description' => $travel_description,
					'travel_during_text' => $travel_during_text,
					'travel_image' => $travel_image,
					'travel_vignette' => $travel_vignette,
					'travel_pdf' => $travel_pdf,
					'travel_homepage' => $travel_homepage,
					'travel_online' => $travel_online,
					'travel_type_id' => $travel_type_id,
					'travel_type_id' => $travel_type_id,
					'travel_date_a_start' => $travel_date_a_start,
					'travel_date_a_end' => $travel_date_a_end,
					'travel_price_a_1' => $travel_price_a_1,
					'travel_price_a_1_note' => $travel_price_a_1_note,
					'travel_price_a_2' => $travel_price_a_2,
					'travel_price_a_2_note' => $travel_price_a_2_note,
					'travel_date_b_start' => $travel_date_b_start,
					'travel_date_b_end' => $travel_date_b_end,
					'travel_price_b_1' => $travel_price_b_1,
					'travel_price_b_1_note' => $travel_price_b_1_note,
					'travel_price_b_2' => $travel_price_b_2,
					'travel_price_b_2_note' => $travel_price_b_2_note,

					'travel_date_c_start' => $travel_date_c_start,
					'travel_date_c_end' => $travel_date_c_end,
					'travel_price_c_1' => $travel_price_c_1,
					'travel_price_c_1_note' => $travel_price_c_1_note,
					'travel_price_c_2' => $travel_price_c_2,
					'travel_price_c_2_note' => $travel_price_c_2_note,

					'travel_date_d_start' => $travel_date_d_start,
					'travel_date_d_end' => $travel_date_d_end,
					'travel_price_d_1' => $travel_price_d_1,
					'travel_price_d_1_note' => $travel_price_d_1_note,
					'travel_price_d_2' => $travel_price_d_2,
					'travel_price_d_2_note' => $travel_price_d_2_note,

					'travel_date_alt_text' => $travel_date_alt_text,

					'travel_plus_vlm' => $travel_plus_vlm,
					'travel_discount_id' => $travel_discount_id,
					'travel_page_id' => $travel_page_id
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