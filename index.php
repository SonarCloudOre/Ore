<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
//error_reporting(0);
session_start();

// Sécurisation des entrées utilisateurs
function secureInputs($data) {
	if (is_array($data)) {
		foreach ($data as $key => $value) {
			$data[$key] = secureInputs($value);
		}
	} elseif (!is_object($data) && !is_resource($data)) {
		$data = htmlspecialchars($data);
	}
	return $data;
}

foreach ($_GET as $key => $value) {
	$_GET[$key] = secureInputs($value);
}
foreach ($_POST as $key => $value) {
	$_POST[$key] = secureInputs($value);
}
foreach ($_REQUEST as $key => $value) {
	$_REQUEST[$key] = secureInputs($value);
}

// Gestion de la ville
$listeVilleExtranet = array('quetigny','chevigny');

// Si un changement de ville est demandé
if(isset($_GET['villeExtranet']) && in_array($_GET['villeExtranet'], $listeVilleExtranet, true)) {
    $_SESSION['villeExtranet'] = $_GET['villeExtranet'];
}
if(isset($_SESSION['villeExtranet'])) {
    $villeExtranet = $_SESSION['villeExtranet'];
}

// Si un changement d'année est demandé
if(isset($_GET['anneeExtranet'])) {
    $_SESSION['anneeExtranet'] = (int)$_GET['anneeExtranet'];
}
if (isset($_SESSION['anneeExtranet'])) {
    $anneeExtranet = $_SESSION['anneeExtranet'];
}

// Données de connexion
if (isset($_SESSION['intervenant'])) {
    $intervenant = $_SESSION['intervenant'];
    $admin = $intervenant['ADMINISTRATEUR'];
}

require_once("include/fct.inc");
require_once("include/passwords.inc");
require_once("include/class.pdo.php");

// Redirige les utilisateurs vers le site en HTTPS si ils ne le sont pas déjà
 if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header('Location: https://' . urlencode($_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI']);
    die();
}
 
$pdo = PdoBD::getPdoBD();
$estConnecte = estConnecte();

// Mise à jour de la ville pour le Pdo
if (isset($villeExtranet)) {
    $pdo->setVilleExtranet($villeExtranet);
}

// Mise à jour de l'année pour le Pdo
if (isset($anneeExtranet)) {
    $pdo->setAnneeExtranet($anneeExtranet);
}

if (!empty($_COOKIE['ore_tablets']) && !isset($_SESSION['intervenant'])) {
    $intervenant = $pdo->recupUnIntervenant($_COOKIE['ore_tablets']);
    if ($intervenant !== false) $_SESSION['intervenant'] = $intervenant;
}

// on analyse le cas d'utilisation en cours ...
$choixTraitement = null;
if (isset($_REQUEST['choixTraitement'])) {
    $choixTraitement = $_REQUEST['choixTraitement'];
    $action= $_REQUEST['action'];
}

switch($choixTraitement)
{
	case 'inscriptionEleves':		{include("controleurs/c_inscptionEleves.php");break;}
	case 'connexion' 	:		{include("controleurs/c_connexion.php");break;}
	//case 'parent' 	:		{include("controleurs/c_parent.php");break;}
	case 'public' 	:		{include("controleurs/c_public.php");break;}
	//case 'stage' 	:		{if (isset($_SESSION['intervenant'])){include("controleurs/c_stage.php");break;}else{include("controleurs/c_connexion.php");break;}}
	case 'inscriptionstage' 	:		{include("controleurs/c_inscriptionstage.php");break;}
	case 'intervenant' 	:		{if (isset($_SESSION['intervenant'])){include("controleurs/c_intervenant.php");break;}else{include("controleurs/c_connexion.php");break;}}
	case 'administrateur' 	:		{if (((isset($_SESSION['intervenant']))&&($admin>0))) {include("controleurs/c_administrateur.php");break;}else if($action == "TrombiIntervenants" || $action=="ajax_unEleve" || $action == "ajax_unEleveStage" || $action == "ajax_reglement"){include("controleurs/c_administrateur.php");break;}else{include("controleurs/c_connexion.php");break;}}
    case 'tablette'     :       {include("controleurs/c_tablette.php");break;}
    case 'inscriptionIntervenants' 	:		{include("controleurs/c_inscriptionIntervenants.php");break;}
	case 'eleve' 	:		{include("controleurs/c_eleve.php");break;}
	default :{include("controleurs/c_connexion.php");break;}
}


if(!(@$footerANePasAfficher==1 || $choixTraitement=='connexion' || $choixTraitement == null))
{
  if ($choixTraitement == "eleve") {
    include("vues/v_pied_de_page_eleve.php");
  }
  elseif ($choixTraitement == "tablette") {
    include("vues/tablette/v_pied_tablette.php");
  }
  else {
    include("vues/v_pied.php");
  }
}
//Liste des urls des formulaires 
$lesUrls = ['janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 
            'aout', 'septembre', 'octobre', 'novembre', 'decembre', 
            'hiver', 'printemps', 'ete', 'automne', 'informatique', 
            'revision', 'ecoleouverte', 'bac', 'brevet', 'bts'];

//redirection automatique vers les URLs
    $path = $_SERVER['HTTP_HOST']; 
    $part = explode('.', $path);//Sépare les éléments du lien
    $RecupUrl = $part[0]; //Récupère le 1er mot du lien
    $UrlStage = $pdo->getInscriptionStage($RecupUrl);
    //Si le 1er mot fait parti de la liste des URL
    if (in_array($RecupUrl, $lesUrls)){
        $testurl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $testurl2 = 'https://'.$_SERVER['HTTP_HOST'].'/';
         //Si les 2 URL coincident
        if($testurl == $testurl2){
            $num = $UrlStage[0]["STAGE"];
            header('location: index.php?choixTraitement=inscriptionstage&action=inscription&num='.$num);
        }
        else{
            echo "Lien introuvable";
        }
    }
    else{
        echo "URL incorrecte ";
    }
?>