<?php
session_start();

require_once('google-calendar-api.php');
require('settings.php');


//unset($_SESSION["access_token"]); //permet de tester la création du token

if (!$_SESSION["access_token"]) {

	$login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $login_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$data = curl_exec($ch);
	$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
	var_dump($data);
	if ($http_code = 200) {
		$capi = new GoogleCalendarApi();

		$data = $capi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);

		$_SESSION['access_token'] = $data['access_token'];


		header('Location: index.php?choixTraitement=administrateur&action=index');
	}
}


try {
	// Récupère les détails de l'évènement
	$capi = new GoogleCalendarApi();


	// Récupérer la timezone de l'utilisateur du calendrier
	//$user_timezone = $capi->GetUserCalendarTimezone($_SESSION['access_token']);

	// Début et fin de l'évènement
  //$event_time = [ 'start_time' => '2021-04-19T13:00:00', 'end_time' => '2021-04-19T15:00:00' ];

	// Crée un évènement dans le calendrier abssce0v033p6av125vb6qrivo@group.calendar.google.com
	//$event_id = $capi->CreateCalendarEvent('abssce0v033p6av125vb6qrivo@group.calendar.google.com', 'titre test', '3 Allée des Jardins, 21800 Quetigny', 'desc : Ceci est un test','0', $event_time , $user_timezone, $_SESSION['access_token']);

	// Récupérer un évènement avec son id
	/*
  $event=$capi->GetEventbyId('abssce0v033p6av125vb6qrivo@group.calendar.google.com','85otjl7lolj7eukriqamctl6jk',$_SESSION['access_token']);
  var_dump($event);
	*/

}
catch(Exception $e) {
	header('Bad Request', true, 400);
    echo json_encode(array( 'error' => 1, 'message' => $e->getMessage() ));
}

?>
