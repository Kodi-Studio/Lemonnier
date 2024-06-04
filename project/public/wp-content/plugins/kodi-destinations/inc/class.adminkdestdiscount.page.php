<?php

class TRAVEL_Admin_discount_Page {

	function __construct() {
		
		wp_register_script( 'App', KDEST_URL . 'js/AppAdminKdest.js', null, null, true );
		wp_enqueue_script( 'App' );	

		// var_dump($_POST['travel_id']);
		if(isset($_GET['delete'])) {
			$this->type_delete($_GET['delete']);
		}
		else if (isset($_POST['mp_form_update_submitted'])) {
			// if(isset($_POST['travel_id'])) $this->update_travel();
			// else  $this->create_travel();
			$this->update_discount();
		}
		else if(isset($_GET['edit'])) {
			$this->renderEditHTML();
		}else if(isset($_GET['new'])) {
			$this->renderEditHTML();
		}else {
			$this->renderListeHTML();
		}
	}

	function type_delete($delete_id) {
		global $wpdb;
        $wpdb->delete('travel_discount', array('travel_discount_id' => $delete_id));
        echo '<div class="updated"><p>Élément supprimé avec succès</p></div>';
		$this->renderListeHTML();
	}


	function renderListeHTML() {
		
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM `travel_discount`");

		$html =  "<div class='wrap' >";
		$html .=  "<h1>Gestion des discounts.";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions" style="display: flex; justify-content: space-between; width: 100%;" >
                        <small>Liste des discounts</small>
						<a href="?page=kdest_discount_manager&new=1" class="page-title-action">Ajouter un discount</a>
					</div>';
		$html .= '</div>';
		$html .= '<hr class="wp-header-end">';
		// $html .= '<div id="App">Plugin d\'administration</div>';

		$html.= '<table class="widefat">
            <thead>
                <tr>
                    <th></th>
                    <th>Libellé</th>
                    <th>Couleur de texte</th>
                    <th></th>
                    <th>Couleur de font</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';

		foreach ($results as $row) {
			$html.= '<tr>';
			$html.= '<td width="90" ></td>';
			$html.= '<td>' . esc_html($row->travel_discount_libelle) . '</td>';
			$html.= '<td>' . $row->travel_discount_color. '</td>';
            $html.= '<td><div style="width:20px; height:20px; border: 1px solid #000; background-color:'.esc_html($row->travel_discount_color).';" ></div></td>';
			$html.= '<td>' . $row->travel_discount_bgcolor. '</td>';
            $html.= '<td><div style="width:20px; height:20px; background-color:'.esc_html($row->travel_discount_bgcolor).';" ></div></td>';
            $html.= '<td width="90" ><a href="javascript:removeTravel(\'?page=kdest_discount_manager&delete=' . esc_attr($row->travel_discount_id) . '\')" class="button">Supprimer</a></td>';
			$html.= '<td width="90" ><a href="?page=kdest_discount_manager&edit=' . esc_attr($row->travel_discount_id) . '" class="button">Éditer</a></td>';
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
			$edit_item = $wpdb->get_row($wpdb->prepare("SELECT * FROM `travel_discount` WHERE travel_discount_id = %d", $edit_id));
		} else {
			$edit_item = (object) array(
                    'travel_discount_libelle' => '',
                    'travel_discount_color' => '',
                    'travel_discount_bgcolor' => '',
			);
		}

        $html =  "<div class='wrap' >";
		$html .=  "<h1>Gestion des discounts.";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions">
						<small>Editer un type de discount</small>
					</div>';
		$html .= '</div>';
		$html .= '<hr class="wp-header-end">';

        $html .=  '
			<form method="post" action="" enctype="multipart/form-data" >
				<input type="hidden" name="mp_form_update_submitted" value="1">';
				if (isset($edit_item->travel_discount_id)) {
					$html .= '<input type="hidden" name="travel_discount_id" value="'.esc_attr($edit_item->travel_discount_id).'">';
				}
		$html .= '
			<table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="travel_discount_libelle">Libelle : </label></th>
                    <td><input type="text" id="travel_discount_libelle" name="travel_discount_libelle" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_discount_libelle) : '').'" required></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_discount_color">Couleur du texte : </label></th>
                    <td><input type="text" id="travel_discount_color" name="travel_discount_color" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_discount_color) : '').'" required></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_discount_bgcolor">Couleur de fond :  </label></th>
                    <td><input type="text" id="travel_discount_bgcolor" name="travel_discount_bgcolor" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_discount_bgcolor) : '').'" required></td>
                </tr>
                ';
        $html .= '</table>';
        $html .= '<p class="submit"><input type="submit" name="action" class="button-primary" value="'.esc_attr(isset($edit_item->travel_discount_id) ?  'enregistrer' : 'créer').'"></p></form>';
		
        $html .= '</form>';

        echo $html;

    }


    function update_discount() {

        global $wpdb;

		// Inclure les fichiers nécessaires pour l'upload d'images
		if (!function_exists('wp_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}
		if (!function_exists('media_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
		}

		$travel_discount_libelle = sanitize_text_field($_POST['travel_discount_libelle']);
        $travel_discount_color = sanitize_text_field($_POST['travel_discount_color']);
        $travel_discount_bgcolor = sanitize_text_field($_POST['travel_discount_bgcolor']);


        if (isset($_POST['travel_discount_id'])) {
            $travel_discount_id = intval($_POST['travel_discount_id']);

            $wpdb->update(
                'travel_discount',
                array(
                    'travel_discount_libelle' => $travel_discount_libelle,
                    'travel_discount_color' => $travel_discount_color,
                    'travel_discount_bgcolor' => $travel_discount_bgcolor,
                ),
                array('travel_discount_id' => $travel_discount_id)
            );
            echo '<div class="updated"><p>Données mises à jour avec succès '.$travel_discount_libelle.'</p></div>';

			$this->renderEditHTML();
        } else {
            $wpdb->insert(
                'travel_discount',
                array(
                    'travel_discount_libelle' => $travel_discount_libelle,
                    'travel_discount_color' => $travel_discount_color,
                    'travel_discount_bgcolor' => $travel_discount_bgcolor,
                ),
            );
            echo '<div class="updated"><p>Données mises à jour avec succès '.$travel_discount_libelle.'</p></div>';

			$this->renderListeHTML();
        }



    }



}

