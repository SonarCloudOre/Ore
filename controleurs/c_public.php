<?php
$action = $_REQUEST['action'];

switch($action) {
	
	case 'MailAutomatique':
	{		
		
		

	  //$dateAujourdhui=date();
	$tableaudate=array();
	  
	  for($i=0;$i<7;$i++)
	  {
		    $dateCircuit = date('d-m-Y', strtotime('+'.$i.' day')); 
		   
			
			// extraction des jour, mois, an de la date
			list($jour, $mois, $annee) = explode('-', $dateCircuit);
			// calcul du timestamp
			$timestamp = mktime (0, 0, 0, $mois, $jour, $annee);
			// affichage du jour de la semaine
			$jour=date("w",$timestamp);

			

		  if($jour==3) //si mercredi
		  {
			list($jour, $mois, $annee) = explode('-', $dateCircuit);
			$tableaudate[$i] = $annee.'-'.$mois.'-'.$jour;

		  }
		  
		   if($jour==6) // si samedi
		  {
			list($jour, $mois, $annee) = explode('-', $dateCircuit);
			$tableaudate[$i] = $annee.'-'.$mois.'-'.$jour;
		  }
	  }
		
		include("vues/public/v_MailAutomatique.php");
		break;
	}
	case 'janvier';
	{
		include ("vues/inscriptionStage/v_InscriptionStage.php");
		break;
	}
	case 'octobre';
	{
		include ("vues/inscriptionStage/v_InscriptionStage.php");
		break;
	}
	

default :
	{
		echo 'erreur d\'aiguillage !'.$action;
		break;
	}
}
?>
