<?php
$action = $_REQUEST['action'];
switch($action) {
case 'index':
	{
		include("vues/parent/v_enteteParent.php");
		
		include("vues/parent/v_InscriptionStage.php");
		break;
	}
	
	
	case 'EnvoiMailStats':
	{
		include("vues/v_entete.php");

		
		include("vues/parent/v_EnvoiMailStats.php");
		break;
	}

default :
	{
		echo 'erreur d\'aiguillage !'.$action;
		break;
	}
}
?>
