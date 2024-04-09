<?php 

	$response = array();
	$posts = array();
	

	$posts[] = array('title'=> 'toto', 'url'=> 'titi');
	$response['posts'] = $posts;

	/*$fp = fopen('results.json', 'w');
	fwrite($fp, json_encode($response));
	fclose($fp);*/

	require_once('inc/functions.tpl.php');


	$liste = getListeRdvByPerson(3);

	var_dump($liste);


	echo json_encode($response);


?> 