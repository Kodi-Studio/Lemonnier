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

/////////////////// GETTERS
function getListePerson(){
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM wprdv_person WHERE 1", ARRAY_A );
	//$label = $arrayName = array('id' =>'null' ,'person_prenom'=>'choisissez','person_nom'=>' une personne' );
	//array_unshift( $result , $label );

	return $result;	
}

function getPersonById($id){
	global $wpdb;
	$result = $wpdb->get_row("SELECT * FROM wprdv_person WHERE person_id = ".$id."", ARRAY_A );
	return $result;	
}

function getRdvById($id){
	global $wpdb;
	$result = $wpdb->get_row("SELECT * FROM wprdv_rdv WHERE rdv_id = ".$id."", ARRAY_A );
	return $result;		
}

function getOnlyDateHoursRdvByPerson($person_id){
	global $wpdb;
	$result = $wpdb->get_results("SELECT allday , date_time_rdv FROM wprdv_rdv WHERE person_id = ".$person_id." AND refused = 0 ORDER BY date_time_rdv LIMIT 0 , 99" , ARRAY_A );
	return $result;		
}

function getOnlyDateHoursRdvByPersonAfterToday($person_id){
	global $wpdb;
	$result = $wpdb->get_results("SELECT allday , date_time_rdv FROM wprdv_rdv WHERE person_id = ".$person_id." AND refused = 0 AND date_time_rdv > ".mktime(0,0,0,date('m'),date('d'),date('Y'))." ORDER BY date_time_rdv LIMIT 0 , 99" , ARRAY_A );
	return $result;		
}

function getListeRdvByPerson($person_id){
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM wprdv_rdv WHERE person_id = ".$person_id." ORDER BY date_time_rdv LIMIT 0 , 99" , ARRAY_A );
	return $result;		
}

function getListeRdvByDay($date){
	$max = $date + $stampday;
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM wprdv_rdv WHERE date_time_rdv >= ".$date." AND  date_time_rdv <= ".$max."  ORDER BY date_time_rdv LIMIT 0 , 99" );
	return $result;			
}

function getListeRdvByPersonDay($person_id, $date){
	$max = $date + $stampday;
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM wprdv_rdv WHERE person_id = ".$person_id." date_time_rdv >= ".$date." AND  date_time_rdv <= ".$max."  ORDER BY date_time_rdv DESC LIMIT 0 , 99" );
	return $result;			
}

/////////////////// INSERT & UPDATE
//INSERT
/*
$wprdv = array('person_id' => $newRdv->personId, 
				'date_time_rdv' =>$newRdv->rdvStamp,
				'name' =>$newRdv->name,
				'message' =>$newRdv->message,
				'tel' => $newRdv->phone,
				'date_time_rdv' =>$newRdv->rdvStamp
			);
*/
function insertRdv($rdv){
	global $wpdb;
	/*
		dateObj: "09/11/2018 08:00:00"
		date_time_rdv: "1541746800000"
		email: "Kodi.webstudio@gmail.com"
		firstname: "Christophe"
		lastname: "Harel"
		message: "qdqsdq"
		person_id: "11"
		tel: "0601870795"				
	*/
	$insert = $wpdb->insert( "wprdv_rdv" , 
		array( 
			'person_id' => $rdv['person_id'],
			'date_time_rdv'=>$rdv['date_time_rdv'],
			'firstname'=>$rdv['firstname'],
			'lastname'=>$rdv['lastname'],
			'email'=>$rdv['email'],
			'message'=>$rdv['message'],
			'phone'=>$rdv['phone'],
			'dateObj'=>str_replace( '/', '-' , $rdv['dateObj']),		
		), 
		array( 
			'%d', '%s','%s','%s','%s','%s','%s','%s'
		) 
	);
	//return $rdv;
	return $insert;	
}

function getConfigsClient() {
	global $wpdb;
	$query = "select * FROM `wprdv_person` AS a NATURAL JOIN `wprdv_config` AS b WHERE a.`config_id` = b.`config_id`";
	$results = $wpdb->get_results( $query , OBJECT );
	///select `date_time_rdv` FROM `wprdv_rdv` AS c WHERE c.`date_time_rdv` > 
	return $results;
}

function getFuturRdvByPerson($person_id) {
	$stamp = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	global $wpdb;
	$query = "select `date_time_rdv` FROM `wprdv_rdv` AS c WHERE c.`person_id` = '".$person_id."' AND c.`date_time_rdv` > '".$stamp."'";
	$results = $wpdb->get_results( $query , ARRAY_A );
	$liste = array('');
	foreach ($results as &$value) {
		array_push( $liste , $value['date_time_rdv'] ); //  $liste = $value;
	}

	return $liste;	
}