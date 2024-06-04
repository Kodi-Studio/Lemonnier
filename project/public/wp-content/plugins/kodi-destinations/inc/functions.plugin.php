<?php

/// day during millisecondes
$stampday = 86400;
$today =  time();

/////////////////// GETTERS
function getListePerson(){
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM wprdv_person WHERE 1", ARRAY_A );
	//$label = $arrayName = array('person_id' =>null ,'person_firstName'=>'choisissez','person_lastName'=>' une personne' );
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
	$result = $wpdb->get_results("SELECT * FROM wprdv_rdv WHERE person_id = ".$person_id." ORDER BY date_time_rdv DESC LIMIT 0 , 99" );
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
	$result = $wpdb->get_results("SELECT * FROM wprdv_rdv WHERE person_id = ".$person_id." date_time_rdv >= ".$date." AND  date_time_rdv <= ".$max."  ORDER BY date_time_rdv LIMIT 0 , 99" );
	return $result;			
}

/////////////////// INSERT & UPDATE
//INSERT
function insertPerson( $person ) {

	
	global $wpdb;
	$insert = $wpdb->insert( 
		"wprdv_person" , 
		array( 	'person_firstName' => $person->person_firstName,
				'person_lastName'=>$person->person_lastName,
				'person_email'=>$person->person_email ,
				'person_job'=>$person->person_job  
		) , 
		array( '%s','%s','%s','%s' ) );
	return $insert;
}
//// DELETE
function deletePerson( $id ){
	global $wpdb;
	$delete = $wpdb->delete( 'wprdv_person', array( 'person_id' => $id ) );
	return $delete;
}




///////////////// UPDATES
function updateRdvStatut( $rdv ){
	global $wpdb;
	$update = $wpdb->update( "wprdv_rdv", 
		array(
			'allday'=>$rdv->allday,
			'confirmed'=>$rdv->confirmed,
			'refused'=>$rdv->refused
		),
		array(
			'rdv_id'=>$rdv->rdv_id
		),
		$format = null, $where_format = null );
	return $update;
}

function insertRdv($rdv){
	global $wpdb;
	$insert = $wpdb->insert( "wprdv_rdv" , 
		array( 
			'person_id' => $rdv['person_id'],
			'date' => $rdv['date'],
			'date_time_rdv'=>$rdv['date_time_rdv'],
			'name'=>$rdv['name'],
			'mail'=>$rdv['mail'],
			'message'=>$rdv['message'],
			'tel'=>$rdv['tel'],
			'allday'=>$rdv['allday']	
		), 
		array( 
			'%d','%d','%s','%s','%s','%s','%d'
		) 
	);
	return $insert;	
}



function updatePerson(  $person_datas){

	global $wpdb;
	$update = $wpdb->update( "wprdv_person", 
		array(
			'person_firstName'=>$person_datas->person_firstName,
			'person_lastName'=> $person_datas->person_lastName,
			'person_email'=>$person_datas->person_email,
			'person_job'=>$person_datas->person_job,
		),
		array(
			'person_id'=>$person_datas->person_id
		),
		$format = null, $where_format = null );
	return $update;
}



