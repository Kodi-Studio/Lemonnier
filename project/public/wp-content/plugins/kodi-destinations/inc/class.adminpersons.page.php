<?php
class RDVmanager_AdminPersons_Page{
	function __construct() {
		
		wp_register_script( 'App', KDEST_URL . 'js/AppAdminPersons.js', array('mithril') , null, true );
		wp_enqueue_script( 'App' );	

		$this->renderHTML();
	
	}
	function renderHTML(){

		
		$personListe = getListePerson();
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
		$html .=  "<h1>Gestion des collaborateurs.";
		$html .=  '<div class="tablenav top">';
		$html .=  	'<div class="alignleft actions bulkactions"></div>';
		$html .= '</div>';

		$html .= '<div id="App">Plugin d\'administration</div>';

		$html .=  "</div>";


		$html .= "<script>";
		$html .= "var personListe = ".json_encode($personListe).";";
		$html .= "</script>";

		echo $html;

	}
}
?>