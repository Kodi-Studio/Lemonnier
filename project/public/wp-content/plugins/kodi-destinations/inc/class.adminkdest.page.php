<?php
class RDVmanager_AdminRdv_Page{
	function __construct() {
		
		wp_register_script( 'App', KDEST_URL . 'js/AppAdminRdv.js', array('mithril') , null, true );
		wp_enqueue_script( 'App' );	

		$this->renderHTML();
	
	}
	function renderHTML(){

		$personListe = getListePerson();
		/// jout d'une entrée pour le combobox
		$label = $arrayName = array('person_id' =>null ,'person_firstName'=>'choisissez','person_lastName'=>' une personne' );
		array_unshift( $personListe , $label );

		//// definition des plages haraires
		$during = 1800;	$start = 50400;/*14h00*/  $end =	64800;
		/// Definition des plages horaies
		$tabTimes = array();
		for( $i = $start; $i < $end ; $i+=$during ) {
			array_push(  $tabTimes ,  date('H:i' , $i ).'|'.date('H:i' , $i+$during ).'|'.$i );
		}



		$today = new DateTime( date('d-m-Y' , time()) , new DateTimeZone('UTC') );
		$stampToday = $today->getTimestamp();
		
		$during = 1800;	$start = 50400;/*14h00*/  $end =	64800;
		/// Definition des plages horaies
		$tabTimes = array();
		for( $i = $start; $i < $end ; $i+=$during ) {
			array_push(  $tabTimes ,  date('H:i' , $i ).'|'.date('H:i' , $i+$during ).'|'.$i );
		}

		$html =  "<div class='wrap' >";
		$html .=  "<h1>Gestion des rendez-vous en ligne.";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions"></div>';
		$html .= '</div>';

		$html .= '<div id="App">Plugin d\'administration</div>';

		$html .=  "</div>";


		$html .= "<script>";
		$html .= "var stampToday = ".$stampToday.";";
		$html .= "var personListe = ".json_encode($personListe).";";
		$html .= "var rdvTimes = ".json_encode($tabTimes).";";
		$html .= "</script>";



		echo $html;

	}
}
?>