<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Par défaut, on affiche le formulaire
if(!isset($_REQUEST['action'])){
    $_REQUEST['action'] = 'demandeConnexion';
}

$action = $_REQUEST['action'];

switch($action){

    // Formulaire de connexion
	case 'demandeConnexion':{

        // Destruction de la session, mais en conversant le nombre de tentatives
        $nbTentatives = 0;
        if (isset($_SESSION['nbTentatives'])){
            $nbTentatives = $_SESSION['nbTentatives'];
        }
        session_unset();
        $_SESSION['nbTentatives'] = $nbTentatives;

        if (isset($_COOKIE['ore_tablets'])) {
            setcookie('ore_tablets', 'null', time() - 1);
        }

        unset($choix);
        $formulaire		="frmIdentification";
        $champ			="login";

        // Pages

        include("vues/v_connexion.php");
        break;
	}

    // Demande de connexion
	case 'valideConnexion':{

        // Nombre de tentatives
        if(!isset($_SESSION['nbTentatives'])) {
            $_SESSION['nbTentatives'] = 1;
        } else {
            ++$_SESSION['nbTentatives'];
        }

        // Si l'utilisateur n'a pas dépassé le nb max de tentatives
        if($_SESSION['nbTentatives'] < 30) {

            // Récupération des informations
            $login = strtolower($_REQUEST['login']);
            $mdp = $_REQUEST['mdp'];

            // On interroge la BDD
            $utilisateur = $pdo->getInfosUtilisateurs($login,$mdp);

            // Echec de la connexion, utilisateur introuvable
            if(!is_array($utilisateur)){
                $formulaire		="frmIdentification";
                $champ			="login";
                //include("vues/v_entete.php");
                ajouterErreur("Login ou mot de passe incorrect");
                include("vues/v_erreurs.php");
                include("vues/v_connexion.php");
                $connexionReussie = false;

            // Connexion réussie
            } else {
                $intervenant = $utilisateur;

                // Suppression du nb de tentatives
                unset($_SESSION['nbTentatives']);

                // Connexion
                connecter($intervenant);
                // Année par défaut

                // Redirection selon si admin ou intervenant
                if($utilisateur['ADMINISTRATEUR']==1 || $utilisateur['ADMINISTRATEUR']==2) {
                    header('location: index.php?choixTraitement=administrateur&action=index');
                    setcookie('ore_tablets', $utilisateur['ID_INTERVENANT'], time() + 3600 * 24 * 7);
                } else {
                    header('location: index.php?choixTraitement=intervenant&action=index');
                }
                $connexionReussie = true;
                $pdo->addLog(1, date('Y-m-d H:i:s'),$_SERVER["REMOTE_ADDR"],$localisation,$login,hash_password($mdp),$connexionReussie,$_SERVER["HTTP_USER_AGENT"],$_SERVER["HTTP_REFERER"]);
                include("vues/v_entete.php");
            }

            // On enregistre la tentative de connexion
            $fichier = fopen('http://api.ipinfodb.com/v3/ip-city/?key=e352800e16a92560a31d99eae95f9441a0eaa803cfe7ad8ecf3fda4f6e98d9ad&ip='.$_SERVER["REMOTE_ADDR"],'r');
            $ip_infos = explode(';',fgets($fichier,4096));
            $localisation = $ip_infos[6].' '.$ip_infos[5].' '.$ip_infos[4];
            fclose($fichier);
            $pdo->addLog(1, date('Y-m-d H:i:s'),$_SERVER["REMOTE_ADDR"],$localisation,$login,hash_password($mdp),$connexionReussie,$_SERVER["HTTP_USER_AGENT"],$_SERVER["HTTP_REFERER"]);

        // Trop de tentatives
        } else {
            $formulaire		="frmIdentification";
            $champ			="login";
            include("vues/v_entete.php");
            ajouterErreur("Trop de tentatives de connexion.");
            include("vues/v_erreurs.php");
            include("vues/v_connexion.php");
            $connexionReussie = false;
        }

		break;
	}
	default :{
		$formulaire			="frmIdentification";
		$champ				="login";
		include("vues/v_entete.php");
		include("vues/v_connexion.php");
		break;
	}

        // Demande de connexion
    	case 'valideConnexionEleve':{

            // Nombre de tentatives
            if(!isset($_SESSION['nbTentatives'])) {
                $_SESSION['nbTentatives'] = 1;
            } else {
                ++$_SESSION['nbTentatives'];
            }

            // Si l'utilisateur n'a pas dépassé le nb max de tentatives
            if($_SESSION['nbTentatives'] < 5) {

                // Récupération des informations
                $loginEL = $_REQUEST['loginEL'];
                $mdpEL = $_REQUEST['mdpEL'];

                // On interroge la BDD
                $eleve = $pdo->getInfosEleves($loginEL,$mdpEL);
                $mdpEL = hash_password($mdpEL);

                // Echec de la connexion, utilisateur introuvable
                if(!is_array($eleve)){
                    $formulaire		="frmIdentificationEL";
                    $champ			="loginEL";
                    //include("vues/v_entete.php");
                    ajouterErreur("Login ou mot de passe incorrect eleve".$loginEL." et ".$mdpEL);
                    include("vues/v_erreurs.php");
                    include("vues/v_connexion.php");
                    $connexionReussie = false;

                // Connexion réussie
                } else {
                    $intervenant = $eleve;

                    // Suppression du nb de tentatives
                    unset($_SESSION['nbTentatives']);

                    // Connexion
                    connecter($intervenant);

                    header ('location: index.php?choixTraitement=eleve&action=index');

                    $connexionReussie = true;
                    $pdo->addLog(0,date('Y-m-d H:i:s',time()),$_SERVER["REMOTE_ADDR"],$localisation,$loginEL,$mdpEL,$connexionReussie,$_SERVER["HTTP_USER_AGENT"],$_SERVER["HTTP_REFERER"]);
                    include("vues/v_entete.php");
                }

                // On enregistre la tentative de connexion
                $fichier = fopen('http://api.ipinfodb.com/v3/ip-city/?key=e352800e16a92560a31d99eae95f9441a0eaa803cfe7ad8ecf3fda4f6e98d9ad&ip='.$_SERVER["REMOTE_ADDR"],'r');
                $ip_infos = explode(';',fgets($fichier,4096));
                $localisation = $ip_infos[6].' '.$ip_infos[5].' '.$ip_infos[4];
                fclose($fichier);

                $pdo->addLog(0,date('Y-m-d H:i:s',time()),$_SERVER["REMOTE_ADDR"],$localisation,$loginEL,$mdpEL,$connexionReussie,$_SERVER["HTTP_USER_AGENT"],$_SERVER["HTTP_REFERER"]);

            // Trop de tentatives
            } else {
                $formulaire		="frmIdentificationEL";
                $champ			="loginEL";
                include("vues/v_entete.php");
                ajouterErreur("Trop de tentatives de connexion.");
                include("vues/v_erreurs.php");
                include("vues/v_connexion.php");
                $connexionReussie = false;
            }
    		break;
    	}
}
?>
