<?php
/*ini_set('session.cache_limiter','private_no_expire');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();*/

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
// Gestion de la ville
$listeVilleExtranet = array('quetigny', 'chevigny');
// Si un changement de ville est demandé
if (isset($_GET['villeExtranet'])) {
    $_SESSION['villeExtranet'] = $_GET['villeExtranet'];

}

$villeExtranet = $_SESSION['villeExtranet'];

// Si un changement d'année est demandé
if (isset($_GET['anneeExtranet'])) {
    $_SESSION['anneeExtranet'] = $_GET['anneeExtranet'];

}

$anneeExtranet = $_SESSION['anneeExtranet'];


// Données de connexion
$intervenant = $_SESSION['intervenant'];
$admin = $intervenant['ADMINISTRATEUR'];

require_once("include/fct.inc");
require_once("include/class.pdo.php");


$pdo = PdoBD::getPdoBD();
$estConnecte = estConnecte();

// Mise à jour de la ville pour le Pdo
$pdo->setVilleExtranet($villeExtranet);

// Mise à jour de l'année pour le Pdo
$pdo->setAnneeExtranet($anneeExtranet);

// on analyse le cas d'utilisation en cours ...
$choixTraitement = $_REQUEST['choixTraitement'];
switch ($choixTraitement) {
    case 'inscriptionEleves':
    {
        include("controleurs/c_inscptionEleves.php");
        break;
    }
    case 'connexion'    :
    {
        include("controleurs/c_connexion.php");
        break;
    }
    //case 'parent' 	:		{include("controleurs/c_parent.php");break;}
    case 'public'    :
    {
        include("controleurs/c_public.php");
        break;
    }
    //case 'stage' 	:		{if (isset($_SESSION['intervenant'])){include("controleurs/c_stage.php");break;}else{include("controleurs/c_connexion.php");break;}}
    case 'inscriptionstage'    :
    {
        include("controleurs/c_inscriptionstage.php");
        break;
    }
    case 'intervenant'    :
    {
        if (isset($_SESSION['intervenant'])) {
            include("controleurs/c_intervenant.php");
            break;
        } else {
            include("controleurs/c_connexion.php");
            break;
        }
    }
    case 'administrateur'    :
    {
        if ((isset($_SESSION['intervenant'])) && ($admin > 0)) {
            include("controleurs/c_administrateur.php");
            break;
        } else {
            include("controleurs/c_connexion.php");
            break;
        }
    }
    case 'inscriptionIntervenants'    :
    {
        include("controleurs/c_inscriptionIntervenants.php");
        break;
    }
    case 'eleve'    :
    {
        include("controleurs/c_eleve.php");
        break;
    }
    default :
    {
        include("controleurs/c_connexion.php");
        break;
    }
}

if ($footerANePasAfficher == 1 || $choixTraitement == 'connexion' || $choixTraitement == null) {
} else {
    if ($choixTraitement == "eleve") {
        include("vues/v_pied_de_page_eleve.php");
    } else {
        include("vues/v_pied.php");
    }

}
?>
