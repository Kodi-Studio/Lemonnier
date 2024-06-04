<?php

class TRAVEL_Admin_cata_Page {

	function __construct() {
		
		wp_register_script( 'App', KDEST_URL . 'js/AppAdminKdest.js', null, null, true );
		wp_enqueue_script( 'App' );	

		// var_dump($_POST['travel_id']);
		if(isset($_GET['delete'])) {
			$this->cata_delete($_GET['delete']);
		}
		else if (isset($_POST['mp_form_update_submitted'])) {
			// if(isset($_POST['travel_id'])) $this->update_travel();
			// else  $this->create_travel();
			$this->update_cata();
		}
		else if(isset($_GET['edit'])) {
			$this->renderEditHTML();
		}
        else if(isset($_GET['new'])) {
			$this->renderEditHTML();
		}else {
			$this->renderListeHTML();
		}
	}

	function cata_delete($delete_id) {
		global $wpdb;
        $wpdb->delete('catalogues', array('cata_id' => $delete_id));
        echo '<div class="updated"><p>Élément supprimé avec succès</p></div>';
		$this->renderListeHTML();
	}


	function renderListeHTML() {
		
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM `catalogues`");

		$html =  "<div class='wrap' >";
		$html .=  "<h1>Gestion des catalogues.</h1>";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions" style="display: flex; justify-content: space-between; width: 100%;" >
                        <small>Liste des catalogues</small>
						<a href="?page=kdest_cata_manager&new=1" class="page-title-action">Ajouter un catalogue</a>
					</div>';
		$html .= '</div>';
		$html .= '<hr class="wp-header-end">';
		// $html .= '<div id="App">Plugin d\'administration</div>';

		$html.= '<table class="widefat">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Vignette</th>
                    <th>Fichier</th>
                    <th>Online</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';

		foreach ($results as $row) {
			$html.= '<tr>';
			$html.= '<td width="200" >' . esc_html($row->cata_libelle) . '</td>';
			$html.= '<td width="90" ><img src="' . esc_html($row->cata_vignette) . '" width="90" /></td>';
			$html.= '<td><a href="'. $row->cata_fichier.'" traget="_blank" >Voir le fichier</a></td>';
            $html.= '<td>'. esc_html($row->cata_online === 1 ? "oui" : "non").'</td>';
            $html.= '<td width="90" ><a href="?page=kdest_cata_manager&edit=' . esc_attr($row->cata_id) . '" class="button">Éditer</a></td>';
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
			$edit_item = $wpdb->get_row($wpdb->prepare("SELECT * FROM `catalogues` WHERE cata_id = %d", $edit_id));
		} else {
			$edit_item = (object) array(
                    'cata_libelle' => '',
                    'cata_vignette' => '',
                    'cata_fichier' => '',
                    'cata_online' => 0,
			);
		}

        $html =  "<div class='wrap' >";
		$html .=  "<h1>Gestion des catalogues.";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions">
						<small>Editer un catalogue</small>
					</div>';
		$html .= '</div>';
		$html .= '<hr class="wp-header-end">';

        $html .=  '
			<form method="post" action="" enctype="multipart/form-data" >
				<input type="hidden" name="mp_form_update_submitted" value="1">';
				if (isset($edit_item->cata_id)) {
					$html .= '<input type="hidden" name="cata_id" value="'.esc_attr($edit_item->cata_id).'">';
				}
		$html .= '
			<table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="cata_libelle">Libelle : </label></th>
                    <td><input type="text" id="cata_libelle" name="cata_libelle" class="regular-text" value="'.esc_html(isset($edit_item) ? esc_attr($edit_item->cata_libelle) : '').'" required></td>
                </tr>';
        
        $html .= '</tr>
				<tr ><th >Vignette et fichier PDF :</th></tr>
				<tr valign="top">
                    <th scope="row"><label for="image">Image vignette</label></th>
                    <td>
                        <input type="file" id="cata_vignette" name="cata_vignette" accept="image/*" required>
                        
                        <p><img src="'.esc_attr($edit_item->cata_vignette).'" alt="" style="max-width: 300px;"></p>
                        
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label for="travel_vignette">Fichier PDF</label></th>
                    <td>
                        <input type="file" id="cata_fichier" name="cata_fichier" accept="application/pdf" required>';


        if(isset($_GET['edit'])) {

            $file_url = esc_attr($edit_item->cata_fichier);
            $file_type = wp_check_filetype($file_url)['type'];
            if ($file_type == 'application/pdf') {
                $html .= '<p><a href="'.esc_attr($file_url).'" target="_blank">Voir le fichier PDF</a></p>';
            }

        }

        $html .= '   </td>
                </tr>';
        $html .= '<tr valign="top">
                        <th scope="row"><label for="cata_online">Publié :</label></th>
                        <td><input type="checkbox" id="cata_online" name="cata_online" value="1" '.esc_attr($edit_item && $edit_item->cata_online ? 'checked' : '').'></td>
                    </tr>';


        $html .= '</table>';
        $html .= '<p class="submit"><input type="submit" name="action" class="button-primary" value="'.esc_attr($edit_item->cata_id ?  'enregistrer' : 'créer').'"></p></form>';
		
        $html .= '</form>';

        echo $html;

    }


    function update_cata() {

        global $wpdb;

		// Inclure les fichiers nécessaires pour l'upload d'images
		if (!function_exists('wp_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}
		if (!function_exists('media_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
		}

		$cata_libelle = sanitize_text_field($_POST['cata_libelle']);
        $cata_online = sanitize_text_field($_POST['cata_online']);

        // Gestion de l'upload de l'image vignette
        if (!empty($_FILES['cata_vignette']['name'])) {
            $uploaded = media_handle_upload('cata_vignette', 0);
            if (is_wp_error($uploaded)) {
                echo '<div class="error"><p>Erreur lors du téléchargement de l\'image : ' . $uploaded->get_error_message() . '</p></div>';
            } else {
                $cata_vignette = wp_get_attachment_url($uploaded);
            }
        } else if (isset($_POST['cata_id'])) {
            // Conserver l'image existante si elle n'a pas été mise à jour
            $edit_id = intval($_POST['cata_id']);
            $existing_item = $wpdb->get_row($wpdb->prepare("SELECT cata_vignette FROM `catalogues` WHERE cata_id = %d", $edit_id));
            $cata_vignette = $existing_item->cata_vignette;
        }
        // Gestion de l'upload du fichier PDF
        if (!empty($_FILES['cata_fichier']['name'])) {
            $uploaded = media_handle_upload('cata_fichier', 0);
            if (is_wp_error($uploaded)) {
                echo '<div class="error"><p>Erreur lors du téléchargement du fichier PDF : ' . $uploaded->get_error_message() . '</p></div>';
            } else {
                $cata_fichier = wp_get_attachment_url($uploaded);
            }
        } else if (isset($_POST['cata_id'])) {
            // Conserver l'image existante si elle n'a pas été mise à jour
            $edit_id = intval($_POST['cata_id']);
            $existing_item = $wpdb->get_row($wpdb->prepare("SELECT cata_fichier FROM `catalogues` WHERE cata_id = %d", $edit_id));
            $cata_fichier = $existing_item->cata_fichier;
        }


       

        if (isset($_POST['cata_id'])) {
            $cata_id = intval($_POST['cata_id']);

            $wpdb->update(
                'catalogues',
                array(
                    'cata_libelle' => $cata_libelle,
                    'cata_vignette' => $cata_vignette,
                    'cata_fichier' => $cata_fichier,
                    'cata_online' => $cata_online,
                ),
                array('cata_id' => $cata_id)
            );
            echo '<div class="updated"><p>Données mises à jour avec succès '.$cata_libelle.'</p></div>';

			$this->renderEditHTML();
        } else {


    
            $data = array(
                    'cata_libelle' => $cata_libelle,
                    'cata_vignette' => $cata_vignette,
                    'cata_fichier' => $cata_fichier,
                    'cata_online' => $cata_online,
            );

            // var_dump($data);

            $wpdb->insert(
                'catalogues',
                array(
                    'cata_libelle' => $cata_libelle,
                    'cata_vignette' => $cata_vignette,
                    'cata_fichier' => $cata_fichier,
                    'cata_online' => $cata_online,
                ),
            );
            echo '<div class="updated"><p>Données créées avec succès '.$cata_libelle.'</p></div>';

			$this->renderListeHTML();
        }



    }



}

