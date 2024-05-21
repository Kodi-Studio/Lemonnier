<?php

	class wprdv_Clientwebservice {
		function __construct() {

			/// get configurations
			if($_GET['action']=="getPersonsConfigs")  $this->getConfigsClient();
			/// get next RDV list
			else if($_GET['action']=="getFuturRdvByPerson") $this->getFuturRdvByPerson($_GET['person_id']);


			///$this->render();
			else if($_GET['wprdv_person_id'] && !$_GET['action'] ) $this->renderListeRdvByPerson($_GET['wprdv_person_id']);

			else if($_GET['wprdv_person_id'] && $_GET['action'] == "rdvlisteAdmin"  ) $this->renderDetailListeRdvByPerson($_GET['wprdv_person_id']);

			else if($_GET['newRdv']) $this->saveNewRdv($_GET['newRdv']);

			else if($_GET['wprdv_new_adminrdv'] && $_GET['action'] == "newRdvAdmin"    ) $this->saveNewRdvAdmin($_GET['wprdv_new_adminrdv']);

			else if($_GET['wprdv_rdv'] ) $this->updateRdv($_GET['wprdv_rdv']);


			///// save new RDV request from website
			else if($_GET['rdvDatas'] && $_GET['action'] == 'newRdvRequest' ) $this->saveNewRdvClient( $_GET['rdvDatas'] );

			
			

			////// -------  GESTION DES COLLABORATEURS
			////// SUPPRESSION D'UN COLLABORATEUR
			else if($_GET['deletePerson_id'] && $_GET['action'] == "deletePerson" )  $this->deletePerson( $_GET['deletePerson_id'] );
			////// UPDATE D'UN COLLABORATEUR
			else if($_GET['person_datas'] && $_GET['action'] == "updatePerson" )  $this->updatePerson( $_GET['person_datas'] );
			////// INSERT D'UN COLLABORATEUR
			else if($_GET['person_datas'] && $_GET['action'] == "insertPerson" )  $this->insertPerson( $_GET['person_datas'] );

		}

		private function getConfigsClient() {
			$configClient = getConfigsClient();
			echo json_encode($configClient);
			exit();
		}

		private function getFuturRdvByPerson($person_id){
			$liste = getFuturRdvByPerson($person_id);
			echo json_encode($liste);
			exit();
		}

		private function renderListeRdvByPerson($person_id){
			$liste = getOnlyDateHoursRdvByPersonAfterToday($person_id);
			echo json_encode($liste);
			exit();
		}

		private function renderDetailListeRdvByPerson($person_id){
			$liste = getListeRdvByPerson($person_id);
			echo json_encode($liste);
			exit();
		}

		private function updateRdv($rdv){
			//$liste = getListeRdvByPerson($person_id);
			$Urdv = updateRdvStatut( (object) $rdv);
			echo json_encode($Urdv);
			exit();
		}
		
		
		private function saveNewRdvClient($newRdv){
			/*
			email: "Kodi.webstudio@gmail.com"
			firstname: "Christophe"
			lastname: "Harel"
			message: "qsdqsd"
			personId: "11"
			phone: "0601870795"
			rdvSelected: "1541739600000"
			selectedRdvString: "09/11/2018 à 06h00"
			*/

			/*global $wpdb;*/
			$wprdv = array('person_id' => $newRdv['personId'],
				'firstname' =>$newRdv['firstname'],
				'lastname' =>$newRdv['lastname'],
				'message' =>$newRdv['message'],
				'phone' => $newRdv['phone'],
				'email' => $newRdv['email'],
				'dateObj' => $newRdv['selectedRdvStringForDB'],
				'date_time_rdv' => intval($newRdv['rdvSelected'])/1000
			);
			echo json_encode(insertRdv($wprdv));
			//echo json_encode( $wprdv );
			exit;
		}

		private function saveNewRdvAdmin($newRdv){

			
			global $wpdb;
			$wprdv = array('person_id' => $newRdv['person_id'],
				'date' => $newRdv['date'],
				'date_time_rdv' =>$newRdv['date_time_rdv'],
				'name' =>$newRdv['name'],
				'message' =>$newRdv['message'],
				'tel' => "",
				'email' => $newRdv['email'],
				'allday' => $newRdv['allday']
			);
			echo json_encode(insertRdv($wprdv));
			exit;

		}


		private function deletePerson($id){

			if( deletePerson($id) ) {
				echo json_encode( getListePerson() );
				exit;
			}

		}


		private function updatePerson($person_datas){
			
			if( updatePerson( (object) $person_datas) ) {
				echo json_encode( getListePerson() );
				exit;
			}
		}

		private function insertPerson( $person_datas){
			if( insertPerson( (object) $person_datas) ) {
				echo json_encode( getListePerson() );
				exit;
			}
		}
		
	}
