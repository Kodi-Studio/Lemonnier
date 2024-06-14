<?php

function remove_accent($str) 
{ 
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'); 
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
  return str_replace($a, $b, $str); 
} 

/// day during millisecondes
$stampday = 86400;
$today =  time();


define('SVG_ARROW' , '
	<svg id="Calque_1" data-name="Calque 1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 36.32 58.75">
	<defs>
		<style>
		.svg-carousel-arrow {
			fill: #cc005a;
			stroke-width: 0px;
		}
		</style>
	</defs>
	<path class="svg-carousel-arrow" d="M4.96,58.49c-1.25,0-2.5-.48-3.45-1.43-1.9-1.9-1.9-4.99,0-6.89l20.88-20.88L1.51,8.42C-.39,6.52-.39,3.43,1.51,1.53,3.42-.38,6.5-.38,8.41,1.53l27.77,27.77-27.77,27.77c-.95.95-2.2,1.43-3.45,1.43Z"/>
	</svg>
');




///// getters
function getHpTravels() {
	global $wpdb;
	/// join with stickers discount
	// $query = 	"SELECT t1.*, t2.*, t3.* FROM `kdest_travel` t1 
	// 			RIGHT JOIN `travel_type` t2 ON t1.travel_homepage = 1 
	// 			AND t2.travel_type_homepage = 1 
	// 			AND t1.travel_type_id = t2.travel_type_id 
	// 			LEFT JOIN `travel_discount` t3 ON t1.travel_discount_id = t3.travel_discount_id WHERE t1.travel_homepage = 1 
	// 			AND t1.travel_online = 1
	// 			AND t2.travel_type_online = 1
	// 			AND t1.travel_online=1
	// 			AND t2.travel_type_online = 1
	// 			-- GROUP BY t1.travel_type_id
	// 			ORDER BY t2.travel_type_homepage_order ASC";

	$query = 	"SELECT t1.*, t2.*, t3.* FROM `kdest_travel` t1 
				RIGHT JOIN `travel_type` t2 ON t1.travel_homepage = 1 
				AND t2.travel_type_homepage = 1 
				AND t1.travel_type_id = t2.travel_type_id 
				LEFT JOIN `travel_discount` t3 ON t1.travel_discount_id = t3.travel_discount_id WHERE t1.travel_homepage = 1 
				AND t1.travel_online = 1
				AND t2.travel_type_online = 1
				AND t1.travel_online=1
				AND t2.travel_type_online = 1
				ORDER BY t2.travel_type_homepage_order ASC, t1.travel_type_id ASC";

	$result = $wpdb->get_results($query, ARRAY_A );

	return $result;
}

function getAllTypes() {
	global $wpdb;
	/// join with stickers discount
	$query = 	"SELECT * FROM `travel_type` WHERE `travel_type_online` = 1 ORDER BY travel_type_sommaire_order ASC";

	$result = $wpdb->get_results($query, ARRAY_A );

	return $result;
}


function getCatalogs() {
	global $wpdb;
	$query = "SELECT * FROM `catalogues` WHERE `cata_online` = 1";
	$result = $wpdb->get_results($query, ARRAY_A );
	return $result;
}



//// SHORTSCODES
// Fonction qui génère le HTML du shortcode liste des voyages mis en avant en homepage
function travels_homepage_shortcode($atts) {
    // Traitement des attributs du shortcode (si nécessaire)
	global $svgArrow;
    $atts = shortcode_atts(
        array(
            'param1' => 'default_value',
            // Ajoutez d'autres paramètres si nécessaire
        ),
        $atts,
        'my_custom_shortcode'
    );

	$liste = getHpTravels();

	$typeId = null;
	
	$html = '';

	$nbElements = count($liste);
	$index = 0;

	foreach ($liste as $value){
		
    	//commandes
		$travel = (object) $value;
		// $typeId = $travel->travel_type_id;


		if($travel->travel_type_id != $typeId) $html .= generateHeaderListeTravel($travel , $typeId);
		
		$html .= '<a href="'.get_permalink( $travel->travel_page_id , true).'" class="carousel-generic--item">';
		$html .= '<div><img class="--vignette" src="'.$travel->travel_vignette.'" width="150" />'.$travel->travel_page_id.'</div>';
		$html .= '<div class="--title" >'.$travel->travel_title.'</div>';
		$html .= '<div class="--subtitle">'.$travel->travel_subtitle.' '.($index+1).'</div>';
		if($travel->travel_discount_id) {
			$borderColor = $travel->travel_discount_bgcolor == '#transp' ? $travel->travel_discount_color : "transparent";
			$html .= '<div class="--discount" style="--color-text:'.$travel->travel_discount_color.'; --color-bg: '.$travel->travel_discount_bgcolor.'; --border-color:'.$borderColor.'" >'.$travel->travel_discount_libelle.'</div>';
		} else {
			$html .= '<div class="--discount" ></div>';
		}
		
		$html .= '</a>';
		
		$nextIndex = ($index+1);

		$nexttravel = $index != $nbElements -1 ? (object) $liste[$nextIndex] : null;

		$endHtml = '</div>
					
					<a class="--next-link" href="/destinations/" >
						<div class="--next-link--arrow">'.SVG_ARROW.'</div>
						<div class="--next-link--text" >Voir toutes les offres</div>
						</div>
					</a>
					</div>'; //</section>fin de section';

		$typeId = $travel->travel_type_id;
		if($nexttravel == null) {
			$html .= $endHtml;
		}else if($typeId != $nexttravel->travel_type_id && $typeId != null ) {
			$html .= $endHtml;
		}
		$index ++;
	}
    return $html;
}
add_shortcode('travels_homepage', 'travels_homepage_shortcode');


function generateHeaderListeTravel($travel , $typeId ) {
	$html = '<div style="--color-text: '.$travel->travel_type_color.';"  ><div class="carousel-travels-title" >';
	$html .= '<h2>'.$travel->travel_type_title.'</h2>';
	$html .= '<h3>'.$travel->travel_type_subtitle.'</h3>';
	$html .= '</div>';
	$html .= '<div class="carousel-generic--container" ><div class="carousel-generic" >';
	return $html;
};




//// SHORTSCODES
// Fonction qui génère le HTML du shortcode liste des voyages mis en avant en homepage
function travels_liste_types_shortcode($atts) {
    // Traitement des attributs du shortcode (si nécessaire)
	global $svgArrow;
    $atts = shortcode_atts(
        array(
            'param1' => 'default_value',
            // Ajoutez d'autres paramètres si nécessaire
        ),
        $atts,
        'my_custom_type_shortcode'
    );

	$liste = getAllTypes();

	$typeId = null;
	
	$html = '<section>';
	$html .= '<div class="types-list">';

	$nbElements = count($liste);
	$index = 0;

	foreach ($liste as $value){
		
    	//commandes
		$type = (object) $value;
		// $typeId = $travel->travel_type_id;

		$page_id = $type->travel_type_page_id; 
		$page_link = get_permalink($page_id);

		$html .= '<a href="'.$page_link.'" class="type-card" >';
		$html .= '<div class="type-card--vignette"  ><img src="'.$type->travel_type_vignette.'" /></div>';
		$html .= '<div class="type-card--description" ><h3>'.$type->travel_type_description.'</h3></div>';

		$html .= '</a>';


		// if($travel->travel_type_id != $typeId) $html .= generateHeaderListeTravel($travel , $typeId);
		
		// $html .= '<div class="carousel-generic--item">TRAVEL LISTE TYPE';
		// $html .= '<div><img class="--vignette" src="'.$travel->travel_vignette.'" width="150" /></div>';
		// $html .= '<div class="--title" >'.$travel->travel_title.'</div>';
		// $html .= '<div class="--subtitle">'.$travel->travel_subtitle.' '.($index+1).'</div>';
		// if($travel->travel_discount_id) {
		// 	$borderColor = $travel->travel_discount_bgcolor == '#transp' ? $travel->travel_discount_color : "transparent";
		// 	$html .= '<div class="--discount" style="--color-text:'.$travel->travel_discount_color.'; --color-bg: '.$travel->travel_discount_bgcolor.'; --border-color:'.$borderColor.'" >'.$travel->travel_discount_libelle.'</div>';
		// }
		
		// $html .= '</div>';
		
		// $nextIndex = ($index+1);

		// $nexttravel = $index != $nbElements -1 ? (object) $liste[$nextIndex] : null;

		// $endHtml = '</div>
					
		// 			<a class="--next-link" href="/destinations/" >
		// 				<div class="--next-link--arrow">'.SVG_ARROW.'</div>
		// 				<div class="--next-link--text" >Voir toutes les offres</div>
		// 				</div>
		// 			</a>
		// 			</div>'; //</section>fin de section';

		// $typeId = $travel->travel_type_id;
		// if($nexttravel == null) {
		// 	$html .= $endHtml;
		// }else if($typeId != $nexttravel->travel_type_id && $typeId != null ) {
		// 	$html .= $endHtml;
		// }
		// $index ++;
	}
	$html .= '</div>';
	$html .= '</section>';

    return $html;
}
add_shortcode('travels_liste_types', 'travels_liste_types_shortcode');






// /////////////////// GETTERS
// function getListePerson(){
// 	global $wpdb;
// 	$result = $wpdb->get_results("SELECT * FROM wprdv_person WHERE 1", ARRAY_A );
// 	//$label = $arrayName = array('id' =>'null' ,'person_prenom'=>'choisissez','person_nom'=>' une personne' );
// 	//array_unshift( $result , $label );

// 	return $result;	
// }

// function getPersonById($id){
// 	global $wpdb;
// 	$result = $wpdb->get_row("SELECT * FROM wprdv_person WHERE person_id = ".$id."", ARRAY_A );
// 	return $result;	
// }

// function getRdvById($id){
// 	global $wpdb;
// 	$result = $wpdb->get_row("SELECT * FROM wprdv_rdv WHERE rdv_id = ".$id."", ARRAY_A );
// 	return $result;		
// }

// function getOnlyDateHoursRdvByPerson($person_id){
// 	global $wpdb;
// 	$result = $wpdb->get_results("SELECT allday , date_time_rdv FROM wprdv_rdv WHERE person_id = ".$person_id." AND refused = 0 ORDER BY date_time_rdv LIMIT 0 , 99" , ARRAY_A );
// 	return $result;		
// }

// function getOnlyDateHoursRdvByPersonAfterToday($person_id){
// 	global $wpdb;
// 	$result = $wpdb->get_results("SELECT allday , date_time_rdv FROM wprdv_rdv WHERE person_id = ".$person_id." AND refused = 0 AND date_time_rdv > ".mktime(0,0,0,date('m'),date('d'),date('Y'))." ORDER BY date_time_rdv LIMIT 0 , 99" , ARRAY_A );
// 	return $result;		
// }

// function getListeRdvByPerson($person_id){
// 	global $wpdb;
// 	$result = $wpdb->get_results("SELECT * FROM wprdv_rdv WHERE person_id = ".$person_id." ORDER BY date_time_rdv LIMIT 0 , 99" , ARRAY_A );
// 	return $result;		
// }

// function getListeRdvByDay($date){
// 	$max = $date + $stampday;
// 	global $wpdb;
// 	$result = $wpdb->get_results("SELECT * FROM wprdv_rdv WHERE date_time_rdv >= ".$date." AND  date_time_rdv <= ".$max."  ORDER BY date_time_rdv LIMIT 0 , 99" );
// 	return $result;			
// }

// function getListeRdvByPersonDay($person_id, $date){
// 	$max = $date + $stampday;
// 	global $wpdb;
// 	$result = $wpdb->get_results("SELECT * FROM wprdv_rdv WHERE person_id = ".$person_id." date_time_rdv >= ".$date." AND  date_time_rdv <= ".$max."  ORDER BY date_time_rdv DESC LIMIT 0 , 99" );
// 	return $result;			
// }

// /////////////////// INSERT & UPDATE
// //INSERT
// /*
// $wprdv = array('person_id' => $newRdv->personId, 
// 				'date_time_rdv' =>$newRdv->rdvStamp,
// 				'name' =>$newRdv->name,
// 				'message' =>$newRdv->message,
// 				'tel' => $newRdv->phone,
// 				'date_time_rdv' =>$newRdv->rdvStamp
// 			);
// */
// function insertRdv($rdv){
// 	global $wpdb;
// 	/*
// 		dateObj: "09/11/2018 08:00:00"
// 		date_time_rdv: "1541746800000"
// 		email: "Kodi.webstudio@gmail.com"
// 		firstname: "Christophe"
// 		lastname: "Harel"
// 		message: "qdqsdq"
// 		person_id: "11"
// 		tel: "0601870795"				
// 	*/
// 	$insert = $wpdb->insert( "wprdv_rdv" , 
// 		array( 
// 			'person_id' => $rdv['person_id'],
// 			'date_time_rdv'=>$rdv['date_time_rdv'],
// 			'firstname'=>$rdv['firstname'],
// 			'lastname'=>$rdv['lastname'],
// 			'email'=>$rdv['email'],
// 			'message'=>$rdv['message'],
// 			'phone'=>$rdv['phone'],
// 			'dateObj'=>str_replace( '/', '-' , $rdv['dateObj']),		
// 		), 
// 		array( 
// 			'%d', '%s','%s','%s','%s','%s','%s','%s'
// 		) 
// 	);
// 	//return $rdv;
// 	return $insert;	
// }

// function getConfigsClient() {
// 	global $wpdb;
// 	$query = "select * FROM `wprdv_person` AS a NATURAL JOIN `wprdv_config` AS b WHERE a.`config_id` = b.`config_id`";
// 	$results = $wpdb->get_results( $query , OBJECT );
// 	///select `date_time_rdv` FROM `wprdv_rdv` AS c WHERE c.`date_time_rdv` > 
// 	return $results;
// }

// function getFuturRdvByPerson($person_id) {
// 	$stamp = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
// 	global $wpdb;
// 	$query = "select `date_time_rdv` FROM `wprdv_rdv` AS c WHERE c.`person_id` = '".$person_id."' AND c.`date_time_rdv` > '".$stamp."'";
// 	$results = $wpdb->get_results( $query , ARRAY_A );
// 	$liste = array('');
// 	foreach ($results as &$value) {
// 		array_push( $liste , $value['date_time_rdv'] ); //  $liste = $value;
// 	}

// 	return $liste;	
// }