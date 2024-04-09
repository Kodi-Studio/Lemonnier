<?php
class wprdv_Client{
	function __construct() {
		
		///$this->render();

	}

	function genrateHoraires( $date , $start, $end  ){

		$tabTimes = array();
		$html;
		for( $i = $start; $i < $end ; $i+=$during ) {
			$html.='<br>'.date('H:i' , $i ).' -  '.date('H:i' , $i+1800 );
		}
		return $html;
	}


	function render($postContent) {
		$html = "";

		
		// /// PERSON LISTE -> SELECTOR
		// $personListe = getListePerson();
		// //// TIME LIST IN A DAY
		// //date_default_timezone_set("UTC");//// definition des plages haraires

		// $today = new DateTime( date('d-m-Y' , time()) , new DateTimeZone('Europe/Paris') );
		// $stampToday = $today->getTimestamp()*1000;
		// $during = 1800;	$start = 50400;/*14h00*/  $end =	64800;
		// $tabTimes = array();
		// for( $i = $start; $i < $end ; $i+=$during ) {
		// 	//echo '<br>'.date('H:i' , $i ).' -  '.date('H:i' , $i+1800 );
		// 	array_push(  $tabTimes ,  date('H:i' , $i ).'|'.date('H:i' , $i+$during ).'|'.$i );
		// }
		// //var_dump($tabTimes);
		// //echo genrateHoraires( $today , $start, $end  );
		// $html .= "<script>";
		// $html .= "var language='".get_locale()."';";
		// //$html .= "var stampToday = ".$stampToday.";";
		// //$html .= "var personListe = '".json_encode($personListe)."';";
		// //$html .= "var rdvTimes = '".json_encode($tabTimes)."';";
		// $html .= "</script>";

		// /// DIV contenant l'app
		// //$html .= "<div>".esc_html_e( 'Monday.' , 'wprdv')."</div>";
		// $html .= "<div id='App'></div>";

		$postContent = str_replace("[kdest]", $html, $postContent );
		return $postContent;
	}

}
?>