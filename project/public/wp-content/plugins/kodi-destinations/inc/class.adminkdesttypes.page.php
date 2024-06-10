<?php


class TRAVEL_Admin_types_Page {

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
			$this->update_type();
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
        $wpdb->delete('travel_type', array('travel_type_id' => $delete_id));
        echo '<div class="updated"><p>Élément supprimé avec succès</p></div>';
		$this->renderListeHTML();
	}


	function renderListeHTML() {
		
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM `travel_type`");

		$html =  "<div class='wrap' >";
		$html .=  "<h1>Gestion types de voyages.";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions" style="display: flex; justify-content: space-between; width: 100%;" >
                        <small>Liste de types</small>
						<a href="?page=kdest_types_manager&new=1" class="page-title-action">Ajouter un type</a>
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
                    <th>couleur</th>
					<th>homepage</th>
                    <th></th>
					<th></th>
                </tr>
            </thead>
            <tbody>';

		foreach ($results as $row) {
			$html.= '<tr>';
			$html.= '<td width="90" ><img src="' . esc_html($row->travel_type_vignette) . '" width="90" /></td>';
			$html.= '<td>' . esc_html($row->travel_type_title) . '</td>';
			$html.= '<td>' . $row->travel_type_subtitle. '</td>';
            $html.= '<td><div style="display: flex;">' . esc_html($row->travel_type_color) . '&nbsp;&nbsp;<div style="width:20px; height:20px; background-color:'.esc_html($row->travel_type_color).';" ></div></div></td>';
			$html.= '<td>' . esc_html($row->travel_type_homepage === '1' ? 'oui' : 'non') . '</td>';
			// $html.= '<td width="90" ><a href="?page=kdest_manager&delete=' . esc_attr($row->travel_id) . '" class="button">Supprimer</a></td>';
			$html.= '<td width="90" ><a href="javascript:removeTravelType(\'?page=kdest_types_manager&delete=' . esc_attr($row->travel_type_id) . '\')" class="button">Supprimer</a></td>';
			$html.= '<td width="90" ><a href="?page=kdest_types_manager&edit=' . esc_attr($row->travel_type_id) . '" class="button">Éditer</a></td>';
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
			$edit_item = $wpdb->get_row($wpdb->prepare("SELECT * FROM `travel_type` WHERE travel_type_id = %d", $edit_id));
		} else {
			$edit_item = (object) array(
                    'travel_type_title' => '',
                    'travel_type_subtitle' => '',
                    'travel_type_description' => '',
                    'travel_type_image' => '',
                    'travel_type_vignette' => '',
                    'travel_type_color' => '',
					'travel_type_homepage' => '',
                    'travel_type_online' => '',
                    'travel_type_page_id' => null
			);
		}

        $nonce_field = wp_nonce_field('save_travel_subtitle', 'travel_subtitle_nonce', true, false);

        $html =  "<div class='wrap' >";
		$html .=  "<h1>Gestion types de voyages.";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions">
						<small>Editer un type</small>
					</div>';
		$html .= '</div>';
		$html .= '<hr class="wp-header-end">';

        $html .=  '
			<form method="post" action="" enctype="multipart/form-data" >
				<input type="hidden" name="mp_form_update_submitted" value="1">';
				if (isset($edit_item->travel_type_id)) {
					$html .= '<input type="hidden" name="travel_type_id" value="'.esc_attr($edit_item->travel_type_id).'">';
				}
		$html .= '
			<table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="travel_type_title">Titre</label></th>
                    <td><input type="text" id="travel_type_title" name="travel_type_title" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_type_title) : '').'" required></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_type_subtitle">Sous Titre</label></th>
                    <td>
                        '.$nonce_field.'
                        <input type="text" id="travel_type_subtitle" name="travel_type_subtitle" class="regular-text" value="'.esc_attr($edit_item ? esc_attr($edit_item->travel_type_subtitle) : '').'" required>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_type_description">Description</label></th>
                    <td><input type="text" id="travel_type_description" name="travel_type_description" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_type_description) : '').'" required></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_type_color">Code couleur</label></th>
                    <td><input type="text" id="travel_type_color" name="travel_type_color" class="regular-text" value="'.esc_html($edit_item ? esc_attr($edit_item->travel_type_color) : '').'" required></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_type_image">Image</label></th>
                    <td>
                        <input type="file" id="travel_type_image" name="travel_type_image" accept="image/*">
                        <p><img src="'.esc_attr($edit_item->travel_type_image).'" alt="" style="max-width: 150px;"></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_type_vignette">Vignette</label></th>
                    <td>
                        <input type="file" id="travel_type_vignette" name="travel_type_vignette" accept="image/*">
                        
                        <p><img src="'.esc_attr($edit_item->travel_type_vignette).'" alt="" style="max-width: 150px;"></p>
                        
                    </td>
                </tr>


                <tr valign="top">
                    <th scope="row"><label for="travel_type_homepage">Afficher sur la page d\'acceuil</label></th>
                    <td><input type="checkbox" id="travel_type_homepage" name="travel_type_homepage" value="1" '.esc_attr($edit_item && $edit_item->travel_type_homepage ? 'checked' : '').'></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="travel_type_homepage_order">Position sur la page d\'acceuil</label></th>
                    <td><input type="number" id="travel_type_homepage_order" name="travel_type_homepage_order" value="'.esc_attr($edit_item ? esc_attr($edit_item->travel_type_homepage_order) : '0' ).'"/></td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label for="travel_type_sommaire_order">Position sur la page sommaire</label></th>
                    <td><input type="number" id="travel_type_sommaire_order" name="travel_type_sommaire_order" value="'.esc_attr($edit_item ? esc_attr($edit_item->travel_type_sommaire_order) : '0' ).'"/></td>
                </tr>

                 <tr valign="top">
                    <th scope="row"><label for="travel_type_online">Publié</label></th>
                    <td><input type="checkbox" id="travel_type_online" name="travel_type_online" value="1" '.esc_attr($edit_item && $edit_item->travel_type_online ? 'checked' : '').'></td>
                </tr>
                <tr valign="top">
                    <td><input id="travel_type_page_id" name="travel_type_page_id" type="text" value="'.$edit_item->travel_type_page_id.'" /></td>
                </tr>

                ';
        $html .= '</table>';
        $html .= '<p class="submit"><input type="submit" name="action" class="button-primary" value="'.esc_attr(isset($edit_item->travel_type_id) ?  'enregistrer' : 'créer').'"></p></form>';
		
        $html .= '</form>';

        echo $html;

    }


    function update_type() {

        global $wpdb;

		// Inclure les fichiers nécessaires pour l'upload d'images
		if (!function_exists('wp_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}
		if (!function_exists('media_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
		}

		$travel_type_title = sanitize_text_field($_POST['travel_type_title']);

        if (!isset($_POST['travel_subtitle_nonce']) || !wp_verify_nonce($_POST['travel_subtitle_nonce'], 'save_travel_subtitle')) {
            return;
        }
        $travel_type_subtitle = wp_kses_post($_POST['travel_type_subtitle']);

        $travel_type_description = sanitize_text_field($_POST['travel_type_description']);
        $travel_type_color = sanitize_text_field($_POST['travel_type_color']);
        $travel_type_image = '';//sanitize_text_field($_POST['travel_type_image']);	
        $travel_type_vignette = '';//sanitize_text_field($_POST['travel_type_vignette']);
        $travel_type_homepage = isset($_POST['travel_type_homepage']) ? 1 : 0;
        $travel_type_homepage_order = isset($_POST['travel_type_homepage_order']) ? $_POST['travel_type_homepage_order'] : 0;
        $travel_type_sommaire_order = isset($_POST['travel_type_sommaire_order']) ? $_POST['travel_type_sommaire_order'] : 0;

        $travel_type_online = isset($_POST['travel_type_online']) ? 1 : 0;
        $travel_type_page_id = ( isset($_POST['travel_type_page_id']) && $_POST['travel_type_page_id'] != null ) ? $_POST['travel_type_page_id'] : null;

        // // Gestion de l'upload de l'image principale
        if (!empty($_FILES['travel_type_image']['name'])) {
            $uploaded = media_handle_upload('travel_type_image', 0);
            if (is_wp_error($uploaded)) {
                echo '<div class="error"><p>Erreur lors du téléchargement de l\'image : ' . $uploaded->get_error_message() . '</p></div>';
            } else {
                $travel_type_image = wp_get_attachment_url($uploaded);
            }
        } else if (isset($_POST['travel_type_id'])) {
            // Conserver l'image existante si elle n'a pas été mise à jour
            $edit_id = intval($_POST['travel_type_id']);
            $existing_item = $wpdb->get_row($wpdb->prepare("SELECT travel_type_image FROM `travel_type` WHERE travel_type_id = %d", $edit_id));
            $travel_type_image = $existing_item->travel_type_image;
        }

		// // Gestion de l'upload de l'image vignette
        if (!empty($_FILES['travel_type_vignette']['name'])) {
            $uploaded = media_handle_upload('travel_type_vignette', 0);
            if (is_wp_error($uploaded)) {
                echo '<div class="error"><p>Erreur lors du téléchargement de l\'image : ' . $uploaded->get_error_message() . '</p></div>';
            } else {
                $travel_type_vignette = wp_get_attachment_url($uploaded);
            }
        } else if (isset($_POST['travel_type_id'])) {
            // Conserver l'image existante si elle n'a pas été mise à jour
            $edit_id = intval($_POST['travel_type_id']);
            $existing_item = $wpdb->get_row($wpdb->prepare("SELECT travel_type_vignette FROM `travel_type` WHERE travel_type_id = %d", $edit_id));
            $travel_type_vignette = $existing_item->travel_type_vignette;
        }

        if (isset($_POST['travel_type_id'])) {







            /// eventuelle création de page
            if($travel_type_page_id === null) {
                /// creation de la page
                $page_title = 'Sommaire '.$travel_type_title;
                $page_content = 'Voici le contenu de ma nouvelle page.';
                $new_page = array(
                        'post_title'    => $page_title,
                        'post_content'  => $page_content,
                        'post_status'   => 'publish', // ou 'draft' si vous ne souhaitez pas publier immédiatement
                        'post_type'     => 'page'
                    );
                    // Insérez la page dans la base de données WordPress
                    $travel_type_page_id = wp_insert_post($new_page);
                    // Vérifiez si l'insertion a réussi et affichez un message d'erreur si nécessaire
                    if (is_wp_error($travel_type_page_id)) {
                        // Gestion de l'erreur ici
                        error_log('Erreur lors de la création de la page: ' . $page_id->get_error_message());
                    }
            }

            $travel_type_id = intval($_POST['travel_type_id']);

            $wpdb->update(
                'travel_type',
                array(
                    'travel_type_title' => $travel_type_title,
                    'travel_type_subtitle' => $travel_type_subtitle,
                    'travel_type_description' => $travel_type_description,
                    'travel_type_color' => $travel_type_color,
					'travel_type_image' => $travel_type_image,
                    'travel_type_vignette' => $travel_type_vignette,
                    'travel_type_homepage' => $travel_type_homepage,
                    'travel_type_homepage_order' => $travel_type_homepage_order,
                    'travel_type_sommaire_order' => $travel_type_sommaire_order,
                    'travel_type_online' => $travel_type_online,
                    'travel_type_page_id' => $travel_type_page_id
                ),
                array('travel_type_id' => $travel_type_id)
            );
            echo '<div class="updated"><p>Données mises à jour avec succès '.$travel_type_title.'</p></div>';

			$this->renderEditHTML();
        } else {

            /// creation d'une page sommaire du type en question
            // Vérifiez d'abord si la page n'existe pas déjà pour éviter les doublons
            $page_title = 'Sommaire '.$travel_type_title;
            $page_content = 'Voici le contenu de ma nouvelle page.';
            // $page_check = get_page_by_title($page_title);
            $page_check = (object) get_posts(
                array(
                    'post_type'              => 'page',
                    'title'                  => $page_title,
                )
            );
            // Si la page n'existe pas encore, on la crée
            if (!isset($page_check->ID)) {
                // Créez un tableau contenant les détails de la page
                $new_page = array(
                    'post_title'    => $page_title,
                    'post_content'  => $page_content,
                    'post_status'   => 'publish', // ou 'draft' si vous ne souhaitez pas publier immédiatement
                    'post_type'     => 'page'
                );
                // Insérez la page dans la base de données WordPress
                $page_id = wp_insert_post($new_page);
                // Vérifiez si l'insertion a réussi et affichez un message d'erreur si nécessaire
                if (is_wp_error($page_id)) {
                    // Gestion de l'erreur ici
                    error_log('Erreur lors de la création de la page: ' . $page_id->get_error_message());
                }
            }

            $new_page = get_posts(
                array(
                    'post_type'              => 'page',
                    'title'                  => $page_title,
                )
            );

            $travel_type_page_id = $new_page[0]->ID;
            
            $wpdb->insert(
                'travel_type',
                array(
                    'travel_type_title' => $travel_type_title,
                    'travel_type_subtitle' => $travel_type_subtitle,
                    'travel_type_description' => $travel_type_description,
                    'travel_type_color' => $travel_type_color,
                    'travel_type_image' => $travel_type_image,
                    'travel_type_vignette' => $travel_type_vignette,
					'travel_type_homepage' => $travel_type_homepage,
                    'travel_type_homepage_order' => $travel_type_homepage_order,
                    'travel_type_sommaire_order' => $travel_type_sommaire_order,
                    'travel_type_online' => $travel_type_online,
                    'travel_type_page_id' => $travel_type_page_id,
                    
                )
            );
            echo '<div class="updated"><p>Données mises à jour avec succès '.$travel_type_title.'</p></div>';
            
			$this->renderListeHTML();
        }



    }



}

