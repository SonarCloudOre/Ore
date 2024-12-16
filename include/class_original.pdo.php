<?php
class PdoBD
{   
 private static $serveur='mysql:host=ys2192-001.eu.clouddb.ovh.net;port=35661';     
	public static $mdp='M8v3Ts9LfZ5a8u';     

	//private static $serveur='mysql:host=mysql51-52.perso';
	private static $bdd='dbname=associatryagain';   		
	private static $user='associatryagain';    		
	//private static $mdp='assORE1994';	
	private static $monPdo;
	private static $monPdoBD=null;
			
	private function __construct()
	{
		PdoBD::$monPdo = new PDO(PdoBD::$serveur.';'.PdoBD::$bdd, PdoBD::$user, PdoBD::$mdp); 
		PdoBD::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct()
	{
		PdoBD::$monPdo = null;
	}

	/**
	 * Fonction statique qui cree l'unique instance de la classe PdoBD
	 * Appel : $instancePdoBD = PdoBD::getPdoBD();
	 */
	public  static function getPdoBD()
	{
		if(PdoBD::$monPdoBD==null)	{PdoBD::$monPdoBD= new PdoBD();}
		return PdoBD::$monPdoBD;  
	}
	
	
	/**
	 * Retourne le numéro ID max de la table eleves
	*/
	public function maxNumEleves()
	{		
		$req = "SELECT MAX(ID_ELEVE) as Maximum from eleves ;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	
	public function connexionBDD()
	{		
		$base = mysql_connect ('mysql51-52.perso', 'associatryagain', 'assORE1994');
		mysql_select_db ('associatryagain', $base); 
	}
	
	
	
	
	public function executerRequete($requete) {
	
		$req = $requete;
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	
	}
	
	// Nombre de familles différentes pour une année donnée
	public function nbFamilles($annee) {
	
		$req = 'SELECT * FROM eleves INNER JOIN inscrit ON eleves.ID_ELEVE = inscrit.ID_ELEVE WHERE ANNEE = "'.$annee.'" GROUP BY `ADRESSE_POSTALE`';
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		$nbFamilles = 0;
foreach($laLigne as $uneFamille) {
	$nbFamilles++;
}
		return $nbFamilles; 
	
	}
    
    // Photos manquantes
    public function photosManquantes($annee) {
	
		$req = "SELECT COUNT(*) FROM `eleves` JOIN `inscrit` ON `eleves`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` WHERE (`PHOTO`='' OR `PHOTO` IS NULL) AND `ANNEE` = $annee";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
        return $laLigne;
	}
    
    // Emails manquants
    public function emailsManquantes($annee) {
	
		$req = "SELECT COUNT(*) FROM `eleves` JOIN `inscrit` ON `eleves`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` WHERE (`EMAIL_DES_PARENTS`='' OR `EMAIL_DES_PARENTS` IS NULL OR `EMAIL_DES_PARENTS`='a@a' OR `EMAIL_DES_PARENTS`='a@a.fr' OR `EMAIL_DES_PARENTS`='-') AND `ANNEE` = $annee";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
        return $laLigne;
	}
    
    // Tels manquants
    public function telsManquantes($annee) {
	
		$req = "SELECT COUNT(*) FROM `eleves` JOIN `inscrit` ON `eleves`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` WHERE (`TÉLÉPHONE_DES_PARENTS`='' OR `TÉLÉPHONE_DES_PARENTS` IS NULL OR `TÉLÉPHONE_DES_PARENTS`='0' OR `TÉLÉPHONE_DES_PARENTS`='0000000000' OR `TÉLÉPHONE_DES_PARENTS`='-') AND `ANNEE` = $annee";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
        return $laLigne;
	}
    
    // Adresses manquants
    public function adressesManquantes($annee) {
	
		$req = "SELECT COUNT(*) FROM `eleves` JOIN `inscrit` ON `eleves`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` WHERE (`ADRESSE_POSTALE`='' OR `ADRESSE_POSTALE` IS NULL OR `ADRESSE_POSTALE`='-') AND `ANNEE` = $annee";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
        return $laLigne;
	}
    
    // Nombre d'élèves pour une année donnée
    public function nbEleves($annee) {
	
		$req = "SELECT COUNT(*) FROM `inscrit` WHERE `ANNEE` = $annee";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
        return $laLigne;
	}
    
    // Nombre d'élèves pour une année donnée
    public function nbElevesMemeDateAnneeDerniere($annee,$date) {
	
		$req = "SELECT COUNT(*) FROM `inscrit` WHERE `ANNEE` = $annee AND `DATE_INSCRIPTION` <= '$date'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
        return $laLigne;
	}
    
     // Présences des élèves pour une année donnée
    public function nbPresencesEleves($annee) {
	
		$req = "SELECT COUNT(*), SEANCE FROM appel WHERE appel.ID_ELEVE != '' AND `SEANCE` > '$annee-09-01' AND `SEANCE` < '".($annee + 1)."-07-30' GROUP BY SEANCE";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
        return $laLigne;
	}
    
    // Paiements des élèves pour une année donnée
    public function nbElevesPayes($annee) {
	
		$req = "SELECT COUNT(*) FROM `reglements` WHERE `DATE_REGLEMENT` > '$annee-08-01' AND `DATE_REGLEMENT` < '".($annee+1)."-07-30'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
        return $laLigne;
	}
    
     // Inscriptions des élèves pour une année donnée
    public function nbInscriptionsEleves($annee) {
	
		$req = "SELECT `DATE_INSCRIPTION`,COUNT(*) FROM `inscrit` WHERE `ANNEE` = $annee GROUP BY `DATE_INSCRIPTION`";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
        return $laLigne;
	}
    
    // Paiements des élèves pour une année donnée
    public function nbPayesEleves($annee) {
	
		$req = "";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
        return $laLigne;
	}
    
    // Présences des intervenants pour une année donnée
    public function nbPresencesIntervenants($annee) {
	
		$req = "SELECT COUNT(*), SEANCE FROM appel WHERE appel.ID_INTERVENANT != '' AND `SEANCE` > '$annee-09-01' AND `SEANCE` < '".($annee + 1)."-07-30' GROUP BY SEANCE";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
        return $laLigne;
	}
    
    // Nombre d'élèves par filière pour une année donnée
    public function nbElevesParFiliere($annee) {
	
		$req = "SELECT COUNT(*),`parametre`.`NOM`,`ID_CLASSE` FROM `inscrit` JOIN `parametre` ON `inscrit`.`ID_FILIERES` = `parametre`.`ID` WHERE ANNEE = $annee AND `ID_CLASSE` > 54 GROUP BY `ID_FILIERES`,`ID_CLASSE`";
        $rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
        return $laLigne;
	}
    
    // Nombre d'élèves par classe pour une année donnée
    public function nbElevesParClasse($annee) {
	
		$req = "SELECT COUNT(*),`parametre`.`NOM` FROM `inscrit` JOIN `parametre` ON `inscrit`.`ID_CLASSE` = `parametre`.`ID` WHERE ANNEE = $annee GROUP BY `ID_CLASSE`";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
        return $laLigne;
	}
    
    // Nombre d'élèves par sexe pour une année donnée
    public function nbElevesParVille($annee) {
	
		$req = "SELECT COUNT(*),`VILLE` FROM `eleves` JOIN `inscrit` ON `inscrit`.`ID_ELEVE` = `eleves`.`ID_ELEVE` WHERE `ANNEE` = $annee GROUP BY `VILLE` ORDER BY COUNT(*) DESC LIMIT 0,7";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
        return $laLigne;
	}
    
    // Nombre d'élèves par sexe pour une année donnée
    public function nbElevesParSexe($annee) {
	
		$req = "SELECT COUNT(*),`SEXE` FROM `eleves` JOIN `inscrit` ON `inscrit`.`ID_ELEVE` = `eleves`.`ID_ELEVE` WHERE `ANNEE` = $annee GROUP BY `SEXE`";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
        return $laLigne;
	}
    
    
    public function nbFamillesAvecRdv($bsb,$annee) {
	
		$req = 'SELECT DISTINCT `ADRESSE_POSTALE`,COUNT(*) FROM eleves INNER JOIN inscrit ON eleves.ID_ELEVE = inscrit.ID_ELEVE INNER JOIN rdvparents ON eleves.ID_ELEVE = rdvparents.ID_ELEVE WHERE ANNEE = "'.$annee.'" AND rdvparents.DATE_RDV<NOW() AND rdvparents.BSB = '.$bsb;
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne;
    }
        
        public function nbElevesAvecRdv($bsb,$annee) {
	
		$req = 'SELECT DISTINCT `ADRESSE_POSTALE`,COUNT(*) FROM eleves INNER JOIN inscrit ON eleves.ID_ELEVE = inscrit.ID_ELEVE INNER JOIN rdvparents ON eleves.ID_ELEVE = rdvparents.ID_ELEVE WHERE ANNEE = "'.$annee.'" AND rdvparents.DATE_RDV<NOW() AND rdvparents.BSB = '.$bsb;
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne;
	
	}
    
    // Nombre de familles pour une année donnée
    public function nbFamillesMemeDateAnneeDerniere($annee,$date) {
	
		$req = "SELECT COUNT(DISTINCT `ADRESSE_POSTALE`) FROM `inscrit` JOIN `eleves` ON `eleves`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` WHERE `ANNEE` = $annee AND `DATE_INSCRIPTION` <= '$date'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
        return $laLigne;
	}
    
    public function getAnneesScolaires2()
	{		
		$req = "SELECT * FROM `inscrit` GROUP BY `ANNEE`;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	


	public function executerRequete2($requete) {
	
		$req = $requete;
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes; 
	
	}
	
	/*
		Années des intervenants
	*/
	public function ajoutAnneeIntervenant($num,$annee) {
	
		$req = "INSERT INTO `inscrit_intervenants`(`ID_INTERVENANT`, `ANNEE`) VALUES ('".$num."','".$annee."')";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion de l\'année..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	
		/*
		Reglements
	*/
	public function recupTousReglements($nom,$type) {
	
		if($type == 'tout') {
			$req = "SELECT * FROM `reglements` WHERE `NOMREGLEMENT` = '$nom'";
		} else {
			$req = "SELECT * FROM `reglements` WHERE `NOMREGLEMENT` = '$nom' AND ID_TYPEREGLEMENT = '$type'";
		}
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes; 
	}
    
    
    
    public function recupTousCheques($nom) {

        $req = "SELECT `NUMCHEQUE` FROM `reglements` WHERE `ID_TYPEREGLEMENT` = 1 AND `NOMREGLEMENT` = '$nom' GROUP BY `NUMCHEQUE`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes; 
	}
    
    
    
    public function lesAbsents($num) {

        $req = "";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes; 
	}
    
    
    public function recupNomsParNumCheque($num) {
	
        $req = "SELECT `NOM`,`PRENOM`,SUM(MONTANT) as `total` FROM `reglements` INNER JOIN `eleves` ON `reglements`.ID_ELEVE = `eleves`.ID_ELEVE `NUMCHEQUE` = ".$num;
		
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes; 
	}
	
	
	
	/*
		Associer un partenaire stage
	*/
	public function LesPartenairesAssocier($partenaire,$numStage) {
	
		$req = "INSERT INTO `STAGE_PARTENAIRES`(`ID_PARTENAIRES`, `ID_STAGE`) VALUES ('$partenaire','$numStage')";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion du partenaire..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	
	/*
		Associer un partenaire stage
	*/
	public function LesIntervenantsAssocier($intervenant,$numStage) {
	
		$req = "INSERT INTO `INTERVIENT_STAGE`(`ID_STAGE`, `ID_INTERVENANT`) VALUES('$numStage','$intervenant')";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion du intervenat..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	
	/*
		Dissocier un partenaire stage
	*/
	public function LesPartenairesDissocier($partenaire,$numStage) {
	
		$req = "DELETE FROM `STAGE_PARTENAIRES` WHERE `ID_PARTENAIRES` = '$partenaire' AND `ID_STAGE` = '$numStage'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du partenaire..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	/*
		Supprimer un partenaire stage
	*/
	public function LesPartenairesSupprimer($partenaire) {
	
		$req = "SELECT * FROM `STAGE_PARTENAIRES` WHERE `ID_PARTENAIRES` = $partenaire;
		DELETE FROM `PARTENAIRES_STAGE` WHERE `ID_PARTENAIRES` = $partenaire";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du partenaire..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	
	/*
		Dissocier un intervenant stage
	*/
	public function LesIntervenantsDissocier($intervenant,$numStage) {
	
		$req = "DELETE FROM `INTERVIENT_STAGE` WHERE `ID_INTERVENANT` = '$intervenant' AND `ID_STAGE` = '$numStage'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du intervenant..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	
	/*
		Supprimer un intervenant stage
	*/
	public function supprimerIntervenantStage($num) {
	
		$req = "DELETE FROM `INTERVIENT_STAGE` WHERE `ID_INTERVENANT` = '$num';
		DELETE FROM `INTERVENANT_STAGE` WHERE `ID_INTERVENANT` = '$num'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du intervenant..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	/*
		Ajouter un atelier
	*/
	public function ajouterUnAtelier($numStage,$nom,$nbmax,$niveau,$description,$photo,$groupe) {
	
		$req = "INSERT INTO `ATELIERS_LUDIQUES`(`ID_ATELIERS`, `ID_STAGE`, `NOM_ATELIERS`, `IMAGE_ATELIERS`, `DESCRIPTIF_ATELIERS`, `NBMAX_ATELIERS`, `NIVEAU_ATELIER`,`GROUPE_ATELIER`) VALUES ('','".$numStage."','".$nom."','".$photo."','".$description."','".$nbmax."','".$niveau."','".$groupe."')";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion de l\'année..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	
	/*
		Ajouter un groupe
	*/
	public function ajouterGroupe($numStage,$nom,$nbmax,$salles,$nom) {
	
		$req = "INSERT INTO `GROUPE_STAGE`(`ID_GROUPE`, `ID_STAGE`, `NBMAX_GROUPE`, `SALLES_GROUPE`, `NOM_GROUPE`) VALUES ('','$numStage','$nbmax','$salles','".addslashes($nom)."')";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion du groupe..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	
	
	/*
		Présences stage
	*/
	public function ajouterPresencesStage($numStage,$date,$matinouap,$presences) {
	
		$req = '';
		foreach($presences as $unePresence) {
		
			$req .= "INSERT INTO `PRÉSENCES_STAGE`(`ID_PRESENCE`, `ID_INSCRIPTIONS`, `DATE_PRESENCE`, `MATINOUAP`) VALUES ('','$unePresence','$date','$matinouap');";

		}
		
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion des presences", $req, PdoBD::$monPdo->errorInfo());}
	
	}
	
	public function getAnneesIntervenants($num) {
	
	
		$req = "SELECT * FROM `inscrit_intervenants` WHERE `ID_INTERVENANT` = '$num'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annes de l\'intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes; 
		

	
	}
	
	public function supprimerAnneeIntervenant($num,$annee) {
	
		$req = "DELETE FROM `inscrit_intervenants` WHERE `ID_INTERVENANT` = $num AND `ANNEE` = $annee";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annes de l\'intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes; 
	
	}
	
	public function supprimerFichierIntervenant($num,$fichier) {
	
		$champ = '';
		$dossier = '';
		
		if($fichier != '') {
		
		if($fichier == 'rib') { $champ = 'FICHIER_RIB'; $dossier = 'ribIntervenants'; }
		if($fichier == 'cv') { $champ = 'FICHIER_CV'; $dossier = 'cvIntervenants';  }
		if($fichier == 'diplome') { $champ = 'FICHIER_DIPLOME'; $dossier = 'diplomesIntervenants';  }
		/*
		// on récupère le nom du fichier
		$req = "SELECT `".$champ."` FROM `intervenants` WHERE `ID_INTERVENANT` = $num";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annes de l\'intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		
		// On supprime le fichier
		unlink('./www/extranet/'.$dossier.'/'.$lesLignes[$champ]);*/
		
		// On enlève de la base
		$req = "UPDATE `intervenants` SET `" . $champ . "`='' WHERE `ID_INTERVENANT` = $num";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture de l\'intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		
		
		
		}
	
	}
	
	/**
	 * Retourne le numéro ID max de la table remise CAF
	*/
	public function maxNumRemiseCaf()
	{		
		$req = "SELECT MAX(`ID`) as max FROM `remisecaf`;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	
	/**
	 * Retourne le numéro ID max de la table remise cheque
	*/
	public function maxNumRemiseCheque()
	{		
		$req = "SELECT MAX(`ID`) as max FROM `remisecheque`;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	// recupere les presences d'un intervenant
	public function getPresenceDunIntervenant($num)
	{		
		$req = "SELECT  `DATE_PRESENCE` FROM `presence` WHERE `ID_INTERVENANT`=$num";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des présence dun intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	// recupere les  intervenant stage
	public function recupIntervenantsStage($num)
	{		
		$req = "SELECT * FROM `INTERVENANT_STAGE` INNER JOIN `INTERVIENT_STAGE` ON `INTERVENANT_STAGE`.`ID_INTERVENANT` = `INTERVIENT_STAGE`.`ID_INTERVENANT` WHERE `INTERVIENT_STAGE`.`ID_STAGE` = $num";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des présence dun intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	// recupere les  intervenant stage
	public function recupIntervenantsStageTout()
	{		
		$req = "SELECT * FROM `INTERVENANT_STAGE` WHERE 1";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des présence dun intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	
	// recupere les journaux caf
	public function getLesJournauxCAF()
	{		
		$req = "SELECT CONCAT( 'Du ', date_format(min( date( DATE_REGLEMENT ) ), '%d/%m/%Y') , ' au ', date_format(max( date( DATE_REGLEMENT ) ), '%d/%m/%Y') ) AS date, ID_APPARTIENT_RCAF 
				FROM reglements
				Where ID_TYPEREGLEMENT=3
				GROUP BY ID_APPARTIENT_RCAF;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des noms de médecin ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	// recupere les journaux cheque
	public function getLesJournauxCheque()
	{		
		$req = "SELECT CONCAT( 'Du ', date_format(min( date( DATE_REGLEMENT ) ), '%d/%m/%Y') , ' au ', date_format(max( date( DATE_REGLEMENT ) ), '%d/%m/%Y') ) AS date, ID_APPARTIENT_RCHEQUE 
				FROM reglements
				Where ID_TYPEREGLEMENT=1
				GROUP BY ID_APPARTIENT_RCHEQUE;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des noms de médecin ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	/**
	 * Retourne la table type
	*/
	public function returnLesTypes()
	{		
		$req = "SELECT `ID`, `NOM` FROM `type`;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des types ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	
	public function getAnneeEnCours()
	{
		$req = "SELECT NOM
				FROM parametre
				WHERE ID='82'
				ORDER by ID;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetch();
		$annee=$lesLignes['NOM'];
		return $annee;
		
	}
	
	/**
	 * Retourne la table parametre
	*/
	public function returnParametre($typeNum)
	{		
		$req = "SELECT parametre.ID as IDPARA, type.NOM as NOMTYPE, parametre.NOM as NOMPARA, `NIVEAU`,`VALEUR` FROM `parametre` INNER JOIN type ON parametre.ID_AVOIR=type.ID where ID_AVOIR=$typeNum ORDER BY parametre.ID, type.NOM  ;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des parametres...", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne le numéro de l'eleve selon son codebarre
	*/
	public function returnNumEleve($codebarre)
	{		
		$req = "SELECT ID_ELEVE from eleves where CODEBARRETEXTE='$codebarre';";
		$rs = PdoBD::$monPdo->query($req);
		echo $rs;
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	/**
	 * Retourne un intervenant selon le ID
	*/
	public function recupUnIntervenant($num)
	{		
		$req = "SELECT * FROM intervenants where ID_INTERVENANT=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
    
    /**
	 * Retourne un intervenant selon le ID
	*/
	public function recupUnIntervenantsParStatut($num)
	{		
		$req = "SELECT * FROM intervenants where STATUT='$num';";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne un stage selon le ID
	*/
	public function recupStage($num)
	{		
		$req = "SELECT * FROM STAGE_REVISION where ID_STAGE=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	
	/**
	 * Retourne les partenaires
	*/
	public function recupPartenaires($num)
	{		
		$req = "SELECT * FROM PARTENAIRES_STAGE INNER JOIN STAGE_PARTENAIRES ON PARTENAIRES_STAGE.ID_PARTENAIRES = STAGE_PARTENAIRES.ID_PARTENAIRES where ID_STAGE=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne;  
	}
	
	/**
	 * Retourne les partenaires
	*/
	public function recupPartenairesTout()
	{		
		$req = "SELECT * FROM PARTENAIRES_STAGE";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne;  
	}
	
	
	/**
	 * Retourne un lieu selon le ID
	*/
	public function recupLieu($num)
	{		
		$req = "SELECT * FROM LIEUX_STAGE where ID_LIEU=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du lieu ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	
	
	/**
	 * Retourne tous les ateliers d'un stage pour l'inscription
	*/
	public function recupAteliers($num)
	{		
		$req = "Select * FROM `ATELIERS_LUDIQUES` WHERE `ID_STAGE` = '$num' AND (SELECT COUNT(*) FROM `INSCRIPTIONS_STAGE` WHERE `ID_ATELIERS` = $num) < `NBMAX_ATELIERS` ORDER BY `GROUPE_ATELIER`";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	
	
	/**
	 * Retourne tous les ateliers d'un stage
	*/
	public function recupAteliersStage($num)
	{		
		$req = "Select * FROM `ATELIERS_LUDIQUES` WHERE `ID_STAGE` = '$num'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
    
    
    
	
	
	
	/**
	 * Change un atelier
	*/
	public function changerAtelierEleve($id_inscription,$id_atelier,$id_ancien_atelier)
	{		
		$req = "UPDATE `STAGE_PARTICIPE` SET `ID_ATELIER`=$id_atelier WHERE `ID_INSCRIPTION` = $id_inscription AND `ID_ATELIER` = $id_ancien_atelier";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
    
    
    /**
	 * Recupère les groupes d'atelier
	*/
	public function lesGroupesAtelier($num)
	{		
		$req = "SELECT DISTINCT `GROUPE_ATELIER` FROM `ATELIERS_LUDIQUES` WHERE `ID_STAGE` = $num";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
    
    /**
	 * Valide un élève
	*/
	public function changerValiderEleve($id_inscription,$valide)
	{		
		$req = "UPDATE `INSCRIPTIONS_STAGE` SET `VALIDE`='$valide' WHERE `ID_INSCRIPTIONS`='$id_inscription'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	
	public function FaireSauvegarde() {
	
	$host = 'mysql51-52.perso';
	$user = 'associatryagain';
	$pass = 'assORE1994';
	$name = 'associatryagain';
	$tables = '*';
	
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = str_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$handle = fopen('sauvegardes/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}
	

	
	
	
	
	/**
	 * Retourne tous les ateliers
	*/
	public function recupAteliersTout()
	{		
		$req = "Select * FROM `ATELIERS_LUDIQUES`";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	
	/**
	 * Retourne tous les partenaires d'un stage
	*/
	public function recupPartenairesStage($num)
	{		
		$req = "Select * FROM `PARTENAIRES_STAGE` INNER JOIN `STAGE_PARTENAIRES` ON `PARTENAIRES_STAGE`.`ID_PARTENAIRES` = `STAGE_PARTENAIRES`.`ID_PARTENAIRES` WHERE `STAGE_PARTENAIRES`.`ID_STAGE` = '$num'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des partenaires ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}

	
	/**
	 * Retourne tous les evenements
	*/
	public function recupEvenementApresDateNow()
	{		
		$req = "Select  `NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER` FROM `evenements`  WHERE DATEFIN >= CURRENT_DATE";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	/**
	 * Retourne tous les evenements apres ojd
	*/
	public function recupEvenement()
	{		
		$req = "Select  `NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER` FROM `evenements`";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	/**
	 * Retourne un evenements
	*/
	public function recupUnEvenement($num)
	{		
		$req = "Select `NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER` FROM `evenements` where NUMÉROEVENEMENT=$num";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetch();
		return $lesLignes; 
	}
	
	
	/**
	 * Retourne les intervenants présent  a une date donner
	*/
	public function recupIntervenants($date)
	{		
		$req = "SELECT intervenants.ID_INTERVENANT,NOM,PRENOM FROM intervenants inner join presence ON intervenants.ID_INTERVENANT=presence.ID_INTERVENANT
where DATE_PRESENCE='$date' AND VALIDER=1;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recupération des intervenants ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne les intervenants présent  a une date donner
	*/
	public function recupIntervenantsSansValider($date)
	{		
		$req = "SELECT intervenants.ID_INTERVENANT,NOM,PRENOM FROM intervenants inner join presence ON intervenants.ID_INTERVENANT=presence.ID_INTERVENANT
where DATE_PRESENCE='$date' ;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recupération des intervenants ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	
	/**
	 * Retourne les intervenants 
	*/
	public function recupTousIntervenants()
	{		
		$req = "SELECT * FROM `intervenants` order by NOM;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intevenants ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	
	/**
	 * Retourne les intervenants 
	*/
	public function recupTousIntervenantsParStatut()
	{		
		$req = "SELECT * FROM `intervenants` order by NOM ORDER BY ;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intevenants ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	public function recupTousIntervenantsAnneeEnCours($annee)
	{		
		$req = "SELECT * FROM `intervenants` INNER JOIN `inscrit_intervenants` ON `intervenants`.`ID_INTERVENANT`=`inscrit_intervenants`.`ID_INTERVENANT` WHERE ANNEE = $annee ORDER BY NOM;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intevenants ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	public function recupTousIntervenantsAnneeEnCoursParStatut($annee)
	{		
		$req = "SELECT * FROM `intervenants` INNER JOIN `inscrit_intervenants` ON `intervenants`.`ID_INTERVENANT`=`inscrit_intervenants`.`ID_INTERVENANT` WHERE ANNEE = $annee AND STATUT != 'Service Civique' ORDER BY STATUT,NOM;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intevenants ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    
	
	public function recupRdvParents($annee)
	{		
		
		
		$req = "SELECT * FROM `rdvparents` JOIN `inscrit` ON `rdvparents`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` JOIN `eleves` ON `eleves`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` WHERE `BSB` = FALSE AND `ANNEE` = $annee ORDER BY `DATE_RDV`;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    public function recupRdvParentsDate($date)
	{		
		
		
		$req = "SELECT * FROM `rdvparents` WHERE `BSB` = FALSE AND DATE(`DATE_RDV`) = '$date' ORDER BY `DATE_RDV`;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    
    public function recupRdvBsb($annee)
	{		
		
		
		$req = "SELECT * FROM `rdvparents` JOIN `inscrit` ON `rdvparents`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` JOIN `eleves` ON `rdvparents`.`ID_ELEVE` = `eleves`.`ID_ELEVE` WHERE `BSB` = TRUE AND `ANNEE` = $annee ORDER BY `DATE_RDV`;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    
    public function recupRdvBsbSemaine()
	{		
		
		
		$req = "SELECT * FROM `rdvparents` WHERE WEEK(`DATE_RDV`) = WEEK(NOW()) AND YEAR(`DATE_RDV`) = YEAR(NOW()) AND `BSB` = TRUE ORDER BY `DATE_RDV`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne un parametre 
	*/
	public function returnUnParametre($num)
	{		
		$req = "SELECT `ID`, `ID_AVOIR`, `NOM`, `NIVEAU` FROM `parametre` WHERE ID=$num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du parametre ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	/**
	 * Retourne les élèves 
	*/
	public function recupTousEleves()
	{		
		
		
		$req = "SELECT * FROM `eleves` order by NOM;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	
		public function recupTousEleves222()
	{		
		
		
		$req = "SELECT * FROM `eleves` INNER JOIN inscrit ON eleves.ID_ELEVE = inscrit.ID_ELEVE   WHERE ANNEE IN (SELECT NOM FROM parametre WHERE ID='82') order by NOM;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * retourne la classe dun eleve a une date
	*/
	public function recupClasseUnEleve($annee,$eleve)
	{		
		$req = "SELECT  `ID_CLASSE`,NOM FROM `inscrit` INNER JOIN parametre ON inscrit.ID_CLASSE=parametre.ID  WHERE `ID_ELEVE`=$eleve AND `ANNEE`='$annee';";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	
	/**
	 * retourne la filiere dun eleve a une date
	*/
	public function recupFiliereUnEleve($annee,$eleve)
	{		
		$req = "SELECT  `ID_FILIERES`,NOM FROM `inscrit` INNER JOIN parametre ON inscrit.ID_FILIERES=parametre.ID  WHERE `ID_ELEVE`=$eleve AND `ANNEE`='$annee';";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	/**
	 * Retourne les élèves  inscrit a un evenement
	*/
	public function recupElevesInscritEvenement($evenement)
	{		
		$req = "select * from eleves INNER JOIN inscription on inscription.ID_ELEVE=eleves.ID_ELEVE WHERE NUMÉROEVENEMENT=$evenement ;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	
	
	/**
	 * Retourne les infos d'un élève 
	*/
	public function recupUnEleves($num)
	{		
		$req = "SELECT * FROM `eleves` where ID_ELEVE=$num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture de leleve ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	
	/**
	 * Retourne les infos d'un stage
	*/
	public function recupUnStage($num)
	{		
		$req = "SELECT * FROM `STAGE_REVISION` where ID_STAGE=$num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	/**
	 * Retourne les inscrits d'un stage
	*/
	public function recupLesInscriptions($num)
	{		
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=$num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des inscriptions du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
    
    
    /**
	 * Retourne un inscrits d'un stage
	*/
	public function recupUneInscription($num)
	{		
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS`=$num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des inscriptions du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetch();
		return $lesLignes; 
	}
	
	
		/**
	 * Retourne les présences d'un stage
	*/
	public function recupLesPresences($num)
	{		
		$req = "SELECT * FROM `PRÉSENCES_STAGE` INNER JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` = `PRÉSENCES_STAGE`.`ID_INSCRIPTIONS` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=$num ORDER BY DATE_PRESENCE, MATINOUAP;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des presences du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
		/**
	 * Retourne un élève d'un stage avec son ID inscription
	*/
	public function recupEleveStage($num)
	{		
		$req = "SELECT * FROM `ELEVE_STAGE` INNER JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS`=$num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 

	}
	
	
	/**
	 * Retourne les élèves des stage
	*/
	public function recuplesElevesDesStages($num)
	{		
		$req = "SELECT * FROM `ELEVE_STAGE` WHERE `ID_ELEVE_STAGE` = $num ORDER BY `NOM_ELEVE_STAGE`;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des élèves du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	
	
	/**
	 *
	*/
	public function lierEleve($eleve,$stage)
	{		
		$req = '';
		foreach($eleve as $unEleve) {
			$req .= "INSERT INTO `INSCRIPTIONS_STAGE`(`ID_STAGE`, `ID_ELEVE_STAGE`) VALUES ($stage,$unEleve);";
		}

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des élèves du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	
	
	/**
	 * Retourne les élèves des stage
	*/
	public function recuplesElevesDesStagesTout()
	{		
		$req = "SELECT * FROM `ELEVE_STAGE` ORDER BY `NOM_ELEVE_STAGE`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des élèves du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	
	
	/**
	 * Retourne les Horaires d'un intervenant
	*/
	public function recupPresenceEleve($debut,$fin,$eleve)
	{		
		$req = "SELECT `ID_ELEVE`, `SEANCE` FROM `appel` WHERE SEANCE BETWEEN '$debut' and '$fin' AND ID_ELEVE = $eleve ORDER BY SEANCE;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne les intervenants present a une date
	*/
	public function recupIntervenantsPresentDate($date)
	{		
		$req = "SELECT NOM,PRENOM,ID FROM intervenants INNER JOIN appel ON intervenants.ID_INTERVENANT=appel.ID_INTERVENANT where SEANCE ='$date' ORDER BY NOM;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne les impayés à un réglement
	*/
	public function recupImpayesReglement($reglement)
	{		
		$req = "SELECT * from eleves where ID_ELEVE NOT IN ( select ID_ELEVE from reglements where NOMREGLEMENT='$reglement');";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne les impayés à un réglement avec evenement
	*/
	public function recupImpayesReglementAvecEvenement($reglement,$evenement)
	{		
		$req = "SELECT * from eleves where ID_ELEVE NOT IN ( select ID_ELEVE from reglements where NOMREGLEMENT='$reglement') AND ID_ELEVE IN (select ID_ELEVE from inscription where NUMÉROEVENEMENT=$evenement);";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne les impayés à un réglement
	*/
	public function recupPayesReglement($reglement)
	{		
		$req = "SELECT * from eleves where ID_ELEVE IN ( select ID_ELEVE from reglements where NOMREGLEMENT='$reglement');";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne les impayés à un réglement avec evenement
	*/
	public function recupPayesReglementAvecEvenement($reglement,$evenement)
	{		
		$req = "SELECT * from eleves where ID_ELEVE IN ( select ID_ELEVE from reglements where NOMREGLEMENT='$reglement') AND ID_ELEVE IN (select ID_ELEVE from inscription where NUMÉROEVENEMENT=$evenement);";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne les eleves present a une date
	*/
	public function recupElevesPresentDate($date)
	{		
		$req = "SELECT NOM,PRENOM,ID FROM eleves INNER JOIN appel ON eleves.ID_ELEVE=appel.ID_ELEVE where SEANCE ='$date' ORDER BY NOM;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	
	/**
	 * Retourne les Horaires d'un intervenant
	*/
	public function recupHoraireIntervenant($debut,$fin,$intervenant)
	{		
		$req = "SELECT `ID_INTERVENANT`, `SEANCE`, `HEURES` FROM `appel` WHERE SEANCE BETWEEN '$debut' and '$fin' AND ID_INTERVENANT = $intervenant ORDER BY SEANCE;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    /**
	 * Retourne les rdv d'un intervenant
	*/
	public function recupRdvIntervenant($debut,$fin,$intervenant)
	{		
		$req = "SELECT * FROM `rdvparents` WHERE DATE_RDV BETWEEN '$debut' and '$fin' AND ID_INTERVENANT = $intervenant ORDER BY DATE_RDV;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
	/**
	 * Retourne les Horaires de tous les intervenants d'un statut
	*/
	public function recupHoraireIntervenantStatut($debut,$fin,$statut)
	{		
		$req = "SELECT * FROM `appel` INNER JOIN intervenants ON intervenants.ID_INTERVENANT=appel.ID_INTERVENANT WHERE SEANCE >= DATE('$debut') AND SEANCE <= DATE('$fin') AND STATUT='$statut' ORDER BY NOM";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	/**
	 * Retourne les inscritiption de leleve
	*/
	public function recupInscriptionAnnuelEleve($num)
	{		
		$req = " SELECT `ID_ELEVE`, `ANNEE`, `ID`, `ID_FILIERES`, `ID_LV1`, `ID_LV2`, `ID_CLASSE`, `DATE_INSCRIPTION`, `NOM_DU_PROF_PRINCIPAL`, `COMMENTAIRESANNEE` FROM `inscrit` WHERE ID_ELEVE=$num ORDER BY ANNEE DESC;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
	/**
	 * Retourne les rdv pour une date
	*/
	public function lesRdv($date,$bsb)
	{		
		$req = "SELECT * FROM `rdvparents` WHERE `DATE_RDV` = '$date' AND `BSB` = $bsb";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
    
	/**
	 * Retourne le numéro ID max de la table intervenants
	*/
	public function maxNumIntervenants()
	{		
		$req = "SELECT MAX(ID_INTERVENANT) as Maximum from intervenants ;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
	
	/**
	 * Retourne les informations d'un agent sous la forme d'un tableau associatif
	*/
	public function getInfosUtilisateurs($login,$mdp)
	{
		$req = "SELECT * 
                        FROM intervenants
                        WHERE EMAIL ='$login' 
                        AND PASSWORD = '$mdp'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des informations d'un agent...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
	}
	
	/**
	 * Retourne le planning  sous la forme d'un tableau associatif
	*/
	public function getPlanning($numIntervenant)
	{
		$req = "SELECT DATE_PRESENCE
                        FROM presence
                        WHERE ID_INTERVENANT=$numIntervenant";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetchAll();
		return $ligne;
	}
	
	
	
	/**
	 * Retourne le planning  sous la forme d'un tableau associatif
	*/
	public function supprimerDispo($num,$date)
	{
		$req = "DELETE FROM `presence` WHERE `ID_INTERVENANT` = $num AND `DATE_PRESENCE` = '$date'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de la dispo...", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	 * Retourne le planning des agents sous la forme d'un tableau associatif
	*/
	public function getMaxParametre()
	{
		$req = "SELECT MAX(ID) as maximumNum from parametre";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
	}
	
	/**
	 * Retourne le numero eleve selon code barre
	*/
	public function getIdEleve($codebarre)
	{
		$req = "SELECT * FROM `eleves` WHERE `CODEBARRETEXTE`='$codebarre'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
	}
	
	/**
	 * Retourne le max de lannee de la table inscription d'un eleve
	*/
	public function getMaxAnneeInscription($num)
	{
		$req = "SELECT  MAX(ANNEE) AS ANNEEMAX FROM `inscrit` WHERE `ID_ELEVE`=$num";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
	}
	
	/**
	 * Retourne le prix horaire des intervenants
	*/
	public function getPrixHoraireIntervenant()
	{
		$req = "SELECT nom as prixHoraire from parametre where id=0";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
	}
	
	
	/**
	 * Retourne les heures des intervenants
	*/
	public function getHeures($numIntervenant)
	{
		$req = "SELECT `ID_INTERVENANT`, `SEANCE`, `ID`, `HEURES` FROM `appel` WHERE `ID_INTERVENANT` = $numIntervenant ORDER BY `SEANCE`";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetchAll();
		return $ligne;
	}
	
	
	/**
	 * Retourne les heures des intervenants
	*/
	public function getHeuresSeance($seance)
	{
		$req = "SELECT * FROM `presence` WHERE `DATE_PRESENCE` = '$seance'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetchAll();
		return $ligne;
	}
	
/**
	* Met a jour une ligne de la table INTERVENANT Avec Code
*/
	public function modifIntervenantAvecCode($num, $nom, $prenom, $actif, $date_naissance, $lieu_naissance,$tel, $adresse,$statut, $cp, $ville,$email,$commentaires,$diplome,$numsecu,$nationalite,$password,$photo,$iban,$bic,$compte,$banque,$serviceCivique)
	{
		$req = "UPDATE `intervenants` SET `NOM`='$nom',`PRENOM`='$prenom',`ACTIF`=$actif,`STATUT`='$statut',`EMAIL`='$email',`TELEPHONE`='$tel',`ADRESSE_POSTALE`='$adresse',`CODE_POSTAL`='$cp',`VILLE`='$ville',`DIPLOME`='$diplome',`COMMENTAIRES`='$commentaires',`DATE_DE_NAISSANCE`='$date_naissance',`LIEU_DE_NAISSANCE`='$lieu_naissance',`NATIONALITE`='$nationalite',`SECURITE_SOCIALE`='$numsecu',`PHOTO`='$photo',`PASSWORD`='$password', IBAN='$iban', BIC='$bic', COMPTEBANCAIRE='$compte', BANQUE='$banque', SERVICECIVIQUE='$serviceCivique' WHERE `ID_INTERVENANT`=$num";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* Met a jour une ligne de la table INTERVENANT pour reglement
*/
	public function modifIntervenantReglement($num,$iban,$bic,$compte,$banque)
	{
		$req = "UPDATE `intervenants` SET `IBAN`='$iban', BIC='$bic', `COMPTEBANCAIRE`='$compte', `BANQUE`='$banque' WHERE `ID_INTERVENANT`=$num";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* Met a jour une ligne de la table INTERVENANT Avec Code
*/
	public function modifIntervenantPublicAvecCode($num, $nom, $prenom, $date_naissance, $lieu_naissance,$tel, $adresse, $cp, $ville,$email,$diplome,$numsecu,$nationalite,$password)
	{
		$req = "UPDATE `intervenants` SET `NOM`='$nom',`PRENOM`='$prenom',`EMAIL`='$email',`TELEPHONE`='$tel',`ADRESSE_POSTALE`='$adresse',`CODE_POSTAL`='$cp',`VILLE`='$ville',`DIPLOME`='$diplome',`DATE_DE_NAISSANCE`='$date_naissance',`LIEU_DE_NAISSANCE`='$lieu_naissance',`NATIONALITE`='$nationalite',`SECURITE_SOCIALE`='$numsecu',`PASSWORD`='$password' WHERE `ID_INTERVENANT`=$num";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* Met a jour une ligne de la table INTERVENANT Sans Code
*/
	public function modifIntervenantPublicSansCode($num, $nom, $prenom, $date_naissance, $lieu_naissance,$tel, $adresse, $cp, $ville,$email,$diplome,$numsecu,$nationalite)
	{
		$req = "UPDATE `intervenants` SET `NOM`='$nom',`PRENOM`='$prenom',`EMAIL`='$email',`TELEPHONE`='$tel',`ADRESSE_POSTALE`='$adresse',`CODE_POSTAL`='$cp',`VILLE`='$ville',`DIPLOME`='$diplome',`DATE_DE_NAISSANCE`='$date_naissance',`LIEU_DE_NAISSANCE`='$lieu_naissance',`NATIONALITE`='$nationalite',`SECURITE_SOCIALE`='$numsecu' WHERE `ID_INTERVENANT`=$num";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* Met a jour une ligne de la table STAGE_REVISION
*/
	public function modifUnStage($num,$nom,$annee,$datedeb,$datefin,$prix,$couleur,$description,$lieu,$datefininscrit)
	{
		$req = "UPDATE `STAGE_REVISION` SET `ANNEE_STAGE`='$annee',`NOM_STAGE`='$nom',`DATEDEB_STAGE`='$datedeb',`DATEFIN_STAGE`='$datefin',`DESCRIPTION_STAGE`='$description',`PRIX_STAGE`='$prix',`FOND_STAGE`='$couleur',`ID_LIEU`=$lieu,`DATE_FIN_INSCRIT_STAGE`='$datefininscrit' WHERE `ID_STAGE` = $num";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* Ajout un lieu
*/
	public function ajouterLieu($nom, $adresse, $cp, $ville)
	{
		$req = "INSERT INTO `LIEUX_STAGE`(`NOM_LIEU`,`ADRESSE_LIEU`,`CP_LIEU`,`VILLE_LIEU`) VALUES ('$nom','$adresse','$cp','$ville')";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* Met a jour un lieu
*/
	public function modifierLieuConfirmation($num, $nom, $adresse, $cp, $ville)
	{
		$req = "UPDATE `LIEUX_STAGE` SET `NOM_LIEU`='$nom',`ADRESSE_LIEU`='$adresse',`CP_LIEU`='$cp',`VILLE_LIEU`='$ville' WHERE `ID_LIEU` = '$num'";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* Met a jour un partenaire
*/
	public function modifierPartenaireConfirmation($num, $nom, $image)
	{
		$req = "UPDATE `PARTENAIRES_STAGE` SET `NOM_PARTENAIRES`='$nom',`IMAGE_PARTENAIRES`='$image' WHERE `ID_PARTENAIRES` = '$num'";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* Met a jour une ligne de la table STAGE_REVISION
*/
	public function ajouterStage($nom,$annee,$datedeb,$datefin,$prix,$couleur,$description,$lieu,$image,$affiche,$planning,$datefininscrit)
	{
		$req = "INSERT INTO `STAGE_REVISION`(`ID_STAGE`, `ANNEE_STAGE`, `NOM_STAGE`, `DATEDEB_STAGE`, `DATEFIN_STAGE`, `DESCRIPTION_STAGE`, `IMAGE_STAGE`, `PRIX_STAGE`, `FOND_STAGE`, `AFFICHE_STAGE`, `PLANNING_STAGE`, `ID_LIEU`, `DATE_FIN_INSCRIT_STAGE`) 
		VALUES ('','$annee','$nom','$datedeb','$datefin','$description','$image','$prix','$couleur','$affiche','$planning','$lieu','$datefininscrit')";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* Met a jour une ligne de la table ATELIERS_LUDIQUES
*/
	public function modifUnAtelier($num,$nom,$nbmax,$niveau,$description,$groupe)
	{
		$req = "UPDATE `ATELIERS_LUDIQUES` SET `NOM_ATELIERS`='$nom',`DESCRIPTIF_ATELIERS`='$description',`NBMAX_ATELIERS`='$nbmax',`NIVEAU_ATELIER`='$niveau',`GROUPE_ATELIER`='$groupe' WHERE `ID_ATELIERS` = $num";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
    
    /**
	* Desinscrit un élève d'un atelier
*/
	public function desinscrireAtelier($numEleve,$numAtelier)
	{
		$req = "DELETE FROM `STAGE_PARTICIPE` WHERE `ID_INSCRIPTION` = $numEleve AND `ID_ATELIER` = $numAtelier";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
    
    /**
	* Met a jour une ligne de la table ATELIERS_LUDIQUES
*/
	public function elevesInscritsAtelier($numAtelier)
	{
        $req = "SELECT * FROM `STAGE_PARTICIPE` JOIN `INSCRIPTIONS_STAGE` ON `STAGE_PARTICIPE`.`ID_INSCRIPTION` = `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` WHERE `STAGE_PARTICIPE`.`ID_ATELIER` = $numAtelier";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves atelier...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetchAll();
		return $ligne;
    }
    
    
    public function inscrireAtelier($numAtelier,$numInscription)
	{
        $req = "INSERT INTO `STAGE_PARTICIPE`(`ID_INSCRIPTION`, `ID_ATELIER`) VALUES ($numInscription,$numAtelier);";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves atelier...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetchAll();
		return $ligne;
    }
	
	
    public function recupIdInscription($numStage)
	{
        $req = "SELECT MAX(`ID_INSCRIPTIONS`) as max FROM `INSCRIPTIONS_STAGE` WHERE `ID_STAGE` = $numStage";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves atelier...", $req, PdoBD::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
    }
	
    
	/**
	* Met a jour une ligne de la table INTERVENANT
*/
	public function modifServiceCivique($numIntervenant,$service)
	{
		$req = "UPDATE `intervenants` SET SERVICECIVIQUE='$service' WHERE `ID_INTERVENANT`=$numIntervenant";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'intervenant ( service civique) dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	/**
	* Met a jour une ligne de la table presence
*/
	public function modifPlanning($valeur,$date)
	{
		$req = "UPDATE `presence` SET `VALIDER`=1 WHERE `ID_INTERVENANT`=$valeur AND `DATE_PRESENCE`='$date'";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de (validation presence) dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* Inscription d'un jeune de ORE à un stage
*/
	public function inscriptionStageOre($num,$nom,$prenom,$jour_naissance,$mois_naissance,$annee_naissance,$date,$ip,$user_agent,$origine,$id_atelier,$classe)
	{
		$req = "INSERT INTO `ELEVE_STAGE`(`NOM_ELEVE_STAGE`, `PRENOM_ELEVE_STAGE`,`DDN_ELEVE_STAGE`,`ASSOCIATION_ELEVE_STAGE`, `CLASSE_ELEVE_STAGE`) VALUES ('".strtoupper(addslashes($nom))."','".ucfirst(addslashes($prenom))."','$annee_naissance-$mois_naissance-$jour_naissance','ore','$classe');";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'inscription.", $req, PdoBD::$monPdo->errorInfo());}
		
		
		$req = "INSERT INTO `INSCRIPTIONS_STAGE`(`ID_STAGE`,`ID_ELEVE_STAGE`,`ID_ATELIERS`,`VALIDE`,`DATE_INSCRIPTIONS`,`IP_INSCRIPTIONS`,`USER_AGENT_INSCRIPTIONS`, `ORIGINE_INSCRIPTIONS`) VALUES ('$num',(SELECT MAX(`ID_ELEVE_STAGE`) AS max_id FROM `ELEVE_STAGE`),'$id_atelier',0,'$date','$ip','".addslashes($user_agent)."','".addslashes($origine)."'); ";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'inscription.", $req, PdoBD::$monPdo->errorInfo());}
	}
        
        
        /**
	* Connexion à l'extranet
*/
	public function addLog($date,$ip,$ip_localisation,$email,$mdp,$connexion,$user_agent,$forward)
	{
		$req = "INSERT INTO `logs_extranet`(`id`, `date`, `ip`, `ip_localisation`, `email`, `mdp`, `connexion`, `user_agent`, `forward`) VALUES ('','$date','$ip','".addslashes($ip_localisation)."','".addslashes($email)."','".addslashes($mdp)."','$connexion','".addslashes($user_agent)."','".addslashes($forward)."')";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'inscription.", $req, PdoBD::$monPdo->errorInfo());}
    }
        
            /**
	* Liste des Connexion à l'extranet
*/
	public function lesLogs()
	{
		$req = "SELECT * FROM `logs_extranet` WHERE 1 ORDER BY `date` DESC";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		
		return $laLigne;
    }
	
	
	/**
	* Inscription d'un jeune nouveau
*/
	public function inscriptionStageNouvelle($num,$nom,$prenom,$jour_naissance,$mois_naissance,$annee_naissance,$date,$ip,$user_agent,$origine,$id_atelier,$sexe,$etab,$classe,$filiere,$tel_enfant,$email_enfant,$tel_parent,$email_parent,$adresse,$cp,$ville,$association)
	{
		$req = "INSERT INTO `ELEVE_STAGE`(`NOM_ELEVE_STAGE`, `PRENOM_ELEVE_STAGE`, `SEXE_ELEVE_STAGE`, `ETABLISSEMENT_ELEVE_STAGE`, `CLASSE_ELEVE_STAGE`, `ASSOCIATION_ELEVE_STAGE`, `TELEPHONE_PARENTS_ELEVE_STAGE`, `TELEPHONE_ELEVE_ELEVE_STAGE`, `EMAIL_PARENTS_ELEVE_STAGE`, `EMAIL_ENFANT_ELEVE_STAGE`, `ADRESSE_ELEVE_STAGE`, `CP_ELEVE_STAGE`, `VILLE_ELEVE_STAGE`, `DDN_ELEVE_STAGE`, `FILIERE_ELEVE_STAGE`) VALUES ('".addslashes($nom)."','".addslashes($prenom)."','$sexe','$etab','$classe','".addslashes($association)."','$tel_parent','$tel_enfant','".addslashes($email_parent)."','".addslashes($email_enfant)."','".addslashes($adresse)."','$cp','".addslashes($ville)."','$annee_naissance-$mois_naissance-$jour_naissance','$filiere');";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'inscription.", $req, PdoBD::$monPdo->errorInfo());}
		
		
		$req = "INSERT INTO `INSCRIPTIONS_STAGE`(`ID_STAGE`,`ID_ELEVE_STAGE`,`ID_ATELIERS`,`VALIDE`,`DATE_INSCRIPTIONS`,`IP_INSCRIPTIONS`,`USER_AGENT_INSCRIPTIONS`, `ORIGINE_INSCRIPTIONS`) VALUES ('$num',(SELECT MAX(`ID_ELEVE_STAGE`) AS max_id FROM `ELEVE_STAGE`),'$id_atelier',0,'$date','$ip','".addslashes($user_agent)."','".addslashes($origine)."'); ";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'inscription.", $req, PdoBD::$monPdo->errorInfo());}
	}
	/**
	* Met a jour une ligne de la table inscrit
*/
	public function modifInscriptionEleve($num,$annee,$etab,$classe,$prof_principal,$filiere,$lv1,$lv2,$date_inscription,$commentaires,$nouveau)
	{

		// Sinon, on l'ajoute
		if($nouveau) {
			$req = "INSERT INTO `inscrit`(`ID_ELEVE`, `ANNEE`, `ID`, `ID_FILIERES`, `ID_LV1`, `ID_LV2`, `ID_CLASSE`, `DATE_INSCRIPTION`, `NOM_DU_PROF_PRINCIPAL`, `COMMENTAIRESANNEE`) VALUES ('$num', '$annee', '$etab','$filiere','$lv1','$lv2','$classe','$date_inscription','$prof_principal','$commentaires') ";
			$rs = PdoBD::$monPdo->exec($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout de l'eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
			
					// Si elle existe, on la met à jour
		
		} else {
			
			
		$req = "UPDATE `inscrit` SET `ID`=$etab,`ID_FILIERES`=$filiere,`ID_LV1`=$lv1,`ID_LV2`=$lv2,`ID_CLASSE`=$classe,`DATE_INSCRIPTION`='$date_inscription',`NOM_DU_PROF_PRINCIPAL`='$prof_principal',`COMMENTAIRESANNEE`='$commentaires' WHERE`ID_ELEVE`=$num AND `ANNEE`='$annee' ";
			$rs = PdoBD::$monPdo->exec($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

			
		}
	}
	
	
	public function modifInscriptionEleve2($num,$annee,$etab,$classe,$prof_principal,$filiere,$lv1,$lv2,$date_inscription,$commentaires)
	{
	$req = "UPDATE `inscrit` SET `ID`=$etab,`ID_FILIERES`=$filiere,`ID_LV1`=$lv1,`ID_LV2`=$lv2,`ID_CLASSE`=$classe,`DATE_INSCRIPTION`='$date_inscription',`NOM_DU_PROF_PRINCIPAL`='$prof_principal',`COMMENTAIRESANNEE`='$commentaires' WHERE`ID_ELEVE`=$num AND `ANNEE`='$annee' ";
			$rs = PdoBD::$monPdo->exec($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	public function ajoutInscriptionEleve2($num,$annee,$etab,$classe,$prof_principal,$filiere,$lv1,$lv2,$date_inscription,$commentaires)
	{
	$req = "INSERT INTO `inscrit`(`ID_ELEVE`, `ANNEE`, `ID`, `ID_FILIERES`, `ID_LV1`, `ID_LV2`, `ID_CLASSE`, `DATE_INSCRIPTION`, `NOM_DU_PROF_PRINCIPAL`, `COMMENTAIRESANNEE`) VALUES ('$num', '$annee', '$etab','$filiere','$lv1','$lv2','$classe','$date_inscription','$prof_principal','$commentaires') ";
			$rs = PdoBD::$monPdo->exec($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		}
	
	
	
	/**
	* Met a jour une ligne de la table INTERVENANT  Sans Code
*/
	public function modifIntervenantSansCode($num, $nom, $prenom, $actif, $date_naissance, $lieu_naissance,$tel, $adresse,$statut, $cp, $ville,$email,$commentaires,$diplome,$numsecu,$nationalite,$photo,$iban,$bic,$compte,$banque,$serviceCivique)
	{
		$req = "UPDATE `intervenants` SET `NOM`='$nom',`PRENOM`='$prenom',`ACTIF`=$actif,`STATUT`='$statut',`EMAIL`='$email',`TELEPHONE`='$tel',`ADRESSE_POSTALE`='$adresse',`CODE_POSTAL`='$cp',`VILLE`='$ville',`DIPLOME`='$diplome',`COMMENTAIRES`='$commentaires',`DATE_DE_NAISSANCE`='$date_naissance',`LIEU_DE_NAISSANCE`='$lieu_naissance',`NATIONALITE`='$nationalite',`SECURITE_SOCIALE`='$numsecu',`PHOTO`='$photo', IBAN='$iban', BIC='$bic', COMPTEBANCAIRE='$compte', BANQUE='$banque', SERVICECIVIQUE='$serviceCivique' WHERE `ID_INTERVENANT`=$num";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
		
/**
	* Met a jour une ligne de la table evenement 
*/
	public function majEvenement($num, $nom, $datededebut, $dateFin, $nb, $cout, $annuler)
	{
		$req = "UPDATE `evenements` SET 
		`EVENEMENT`='$nom',`DATEDEBUT`='$datededebut',`DATEFIN`='$dateFin',`COUTPARENFANT`=$cout, `NBPARTICIPANTS`=$nb,`ANNULER`=$annuler WHERE `NUMÉROEVENEMENT`=$num ;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'evenement dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* Met a jour une ligne de la table parametre 
*/
	public function modifParametre($num,$nom,$niveau,$type)
	{
		$req = "UPDATE `parametre` SET `ID_AVOIR`=$type,`NOM`='$nom',`NIVEAU`='$niveau' WHERE `ID`=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'evenement dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	
	public function suppElevesPresences($date)
	{
		$req = "DELETE 
				FROM appel
				WHERE  SEANCE='$date' AND ID_ELEVE != '';";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	public function suppIntervenantsPresences($date)
	{
		$req = "DELETE 
				FROM appel
				WHERE  SEANCE='$date' AND ID_INTERVENANT != '';";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	public function suppUnePresence($num)
	{
		$req = "DELETE 
				FROM appel
				WHERE ID='$num';";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	public function suppUnAtelier($num)
	{
		$req = "DELETE 
				FROM ATELIERS_LUDIQUES
				WHERE ID_ATELIERS='$num';";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
	* supprime une ligne de la table EVENEMENT
*/
	public function suppEvenement($num)
	{
		$req = "DELETE 
				FROM evenements
				WHERE  NUMÉROEVENEMENT=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	public function suppEleve($num)
	{
		$req = "DELETE 
				FROM difficultes
			    WHERE  ID_ELEVE=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		
		$req = "DELETE 
				FROM appel
				WHERE  ID_ELEVE=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		
		$req = "DELETE 
				FROM inscription
				WHERE  ID_ELEVE=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$req = "DELETE 
				FROM inscrit
				WHERE  ID_ELEVE=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$req = "DELETE 
				FROM reglements
				WHERE  ID_ELEVE=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		
		$req = "DELETE 
				FROM eleves
				WHERE  ID_ELEVE=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	public function suppScolarite($num,$annee)
	{
		$req = "DELETE 
				FROM inscrit
				WHERE  ID_ELEVE=$num AND ANNEE = $annee;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de la scolarite dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	public function suppIntervenant($num)
	{
		// Suppression de ses présences
		$req = "DELETE 
				FROM appel
				WHERE  ID_INTERVENANT=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		
		// Suppression de ses années scolaires
		$req = "DELETE 
				FROM inscrit_intervenants
				WHERE  ID_INTERVENANT=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		
		// Suppression de ses matières
		$req = "DELETE 
				FROM specialiser
				WHERE  ID_INTERVENANT=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		
		// Suppression de l'intervenant
		$req = "DELETE 
				FROM intervenants
				WHERE  ID_INTERVENANT=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* supprime les spécialité d'un intervenent
*/
	public function suppSpecialiter($num)
	{
		$req = "DELETE 
				FROM specialiser
				WHERE  ID_INTERVENANT=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* supprime les spécialité d'un intervenent
*/
	public function suppDifficultes($num,$annee)
	{
		$req = "DELETE 
				FROM difficultes
				WHERE  ID_ELEVE=$num
				AND ANNEE='$annee';";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* supprime un rdv
*/
	public function supprimerRdv($num)
	{
		$req = "DELETE 
				FROM rdvparents
				WHERE ID_RDV='$num';";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* supprime un stage
*/
	public function supprimerUnStage($num)
	{
		$req = "DELETE FROM `INSCRIPTIONS_STAGE` WHERE `ID_STAGE` = '$num';
		DELETE FROM `GROUPE_STAGE` WHERE `ID_STAGE` = '$num';
		DELETE FROM `STAGE_PARTENAIRES` WHERE `ID_STAGE` = '$num';
		DELETE FROM `STAGE_SEDEROULE` WHERE `ID_STAGE` = '$num';
		DELETE FROM `INTERVIENT_STAGE` WHERE `ID_STAGE` = '$num';
		DELETE FROM `ATELIERS_LUDIQUES` WHERE `ID_STAGE` = '$num';
		DELETE FROM `STAGE_REVISION` WHERE `ID_STAGE` = '$num';
		";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* supprime une inscription au stage
*/
	public function suprInscriptionStage($num,$numInscription)
	{
		$req = "DELETE FROM `ELEVE_STAGE` WHERE `ID_ELEVE_STAGE` = $num;
		DELETE FROM `INSCRIPTIONS_STAGE` WHERE `ID_ELEVE_STAGE` = $num;
		DELETE FROM `PRÉSENCES_STAGE` WHERE `ID_INSCRIPTIONS`  = $numInscription";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
	* supprime un lieu au stage
*/
	public function supprimerUnLieu($num)
	{
		$req = "DELETE FROM `LIEUX_STAGE` WHERE `ID_LIEU` = $num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* supprime un lieu au stage
*/
	public function supprimerUnPartenaire($num)
	{
		$req = "DELETE FROM `STAGE_PARTENAIRES` WHERE `ID_PARTENAIRES` = $num;
		DELETE FROM `PARTENAIRES_STAGE` WHERE `ID_PARTENAIRES` = $num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* supprime un groupe au stage
*/
	public function supprimerGroupe($num)
	{
		$req = "DELETE FROM `GROUPE_STAGE` WHERE `ID_GROUPE` = $num;
		UPDATE `INSCRIPTIONS_STAGE` SET `ID_GROUPE`='0' WHERE `ID_GROUPE` = $num";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* supprime un groupe au stage
*/
	public function supprimerElevesDuGroupe($num,$eleves)
	{
		$req = '';
		foreach($eleves as $eleve) {
			$req .= "UPDATE `INSCRIPTIONS_STAGE` SET `ID_GROUPE`='0' WHERE `ID_INSCRIPTIONS` = $eleve;";
		}
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
	* ajoute un élève au groupe
*/
	public function ajouterEleveGroupe($id_inscription,$id_groupe)
	{
		$req = "UPDATE `INSCRIPTIONS_STAGE` SET `ID_GROUPE`='$id_groupe' WHERE `ID_INSCRIPTIONS` = '$id_inscription'";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de lajout de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	
	/**
	* ajoute un élève au groupe
*/
	public function AjouterReglementStage($num,$type,$num_transaction,$banque,$montant)
	{
		$req = "UPDATE `INSCRIPTIONS_STAGE` SET `PAIEMENT_INSCRIPTIONS`='$type',`NUMTRANSACTION`='$num_transaction',`BANQUE_INSCRIPTION`='$banque',`MONTANT_INSCRIPTION`='$montant' WHERE `ID_INSCRIPTIONS` = '$num'";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de lajout de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
		/**
	* ajoute un élève au groupe
*/
	public function supprimerUnReglementStage($num)
	{
		$req = "UPDATE `INSCRIPTIONS_STAGE` SET `PAIEMENT_INSCRIPTIONS`=NULL,`NUMTRANSACTION`=NULL,`BANQUE_INSCRIPTION`=NULL,`MONTANT_INSCRIPTION`=NULL WHERE `ID_INSCRIPTIONS` = '$num'";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de lajout de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	public function FichePresenceIntervenants($TousIntervenant)
	{
		/* on créé le PDF */
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		
		//$pdf->AddPage('L');
		
		/* Fonction Cell :
		premier chiffre = largeur
		2ème chiffre = hauteur
		texte
		bordure (0 ou 1)
		retour à la ligne (0 pas de retour, 1 retour)
		alignement (L, C ou R)
		couleur de fond (true ou false)
		lien
		*/
		
		/* titre */
		$pdf->SetFont('Arial', '', 18);
		
		/*$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
		$pdf->Cell(0, 10, utf8_decode('Fiche de présence des intervenants'),0,1,'C');
		$pdf->Ln();*/
		
		/* liste */
		$pdf->SetFont('Arial', '', 11);
		
		$iIntervenant = 0;
		$couleurDeFond = false;
		$statutIntervenant = '';
		$hauteurDesLignes = 7;
		
		// On parcours les intervenants
		foreach($TousIntervenant as $unIntervenant) {

			// On ignore l'admin
			if($unIntervenant['NOM'] != 'admin') {
				
				// Si le statut a changé
				if($unIntervenant['STATUT'] != $statutIntervenant) {
					
					$pdf->AddPage('L');

					
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(40, $hauteurDesLignes, utf8_decode('NOM'),1,0,'L',true);
		$pdf->Cell(40, $hauteurDesLignes, utf8_decode('Prénom'),1,0,'L',true);
		
		$nbJours = 0;
		/* dates */
		 for($i=0;$i<40;$i++) {
		    $dateCircuit = date('d-m-Y', strtotime('+'.$i.' day')); 
		   
			// extraction des jour, mois, an de la date
			list($jour, $mois, $annee) = explode('-', $dateCircuit);
			// calcul du timestamp
			$timestamp = mktime (0, 0, 0, $mois, $jour, $annee);
			// affichage du jour de la semaine
			$jour=date("w",$timestamp);

			if($jour==3) //si mercredi
		  {
			$pdf->Cell(15, $hauteurDesLignes, utf8_decode(substr($dateCircuit,0,5)),1,0,'C',true);
			$nbJours++;
		  }
		  
		   if($jour==6) // si samedi
		  {
			 $pdf->Cell(15, $hauteurDesLignes, utf8_decode(substr($dateCircuit,0,5)),1,0,'C',true);
			 $nbJours++;
		  }

		}
		$pdf->Ln();
		$pdf->SetFillColor(192,192,192);
		$pdf->SetTextColor(0,0,0);
					
					$pdf->SetFillColor(96,96,96);
					$pdf->SetTextColor(255,255,255);
					
					$pdf->Cell((80 + 15*$nbJours), $hauteurDesLignes, utf8_decode($unIntervenant['STATUT']),1,0,'C',true);
					$pdf->Ln();
					
					$statutIntervenant = $unIntervenant['STATUT'];
					
					$pdf->SetFillColor(192,192,192);
					$pdf->SetTextColor(0,0,0);
				}
				
				// couleur de fond
				if($iIntervenant % 2 == 1) {
					$couleurDeFond = true;
				} else {
					$couleurDeFond = false;
				}
				
				
				$pdf->Cell(40, $hauteurDesLignes, utf8_decode($unIntervenant['NOM']),1,0,'L',$couleurDeFond);
				$pdf->Cell(40, $hauteurDesLignes, utf8_decode($unIntervenant['PRENOM']),1,0,'L',$couleurDeFond);
			
				$i = 0;

				for($i = 0; $i < $nbJours; $i++) {
	
					$pdf->Cell(15, $hauteurDesLignes, utf8_decode(' '),1,0,'C',$couleurDeFond);	
				}
				$pdf->Ln();
			}
			
			$iIntervenant++;
		}
		
		
		$pdf->Output();	
		
	}
	
	
	
	
	
	
	
		
	public function imprimerListeEleves($num,$lesInscriptions,$stageSelectionner,$lesGroupes)
	{
		/* on créé le PDF */
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		
		$pdf->AddPage();
		
		/* Fonction Cell :
		premier chiffre = largeur
		2ème chiffre = hauteur
		texte
		bordure (0 ou 1)
		retour à la ligne (0 pas de retour, 1 retour)
		alignement (L, C ou R)
		couleur de fond (true ou false)
		lien
		*/
		
		/* titre */
		$pdf->SetFont('Arial', '', 18);
		
		$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
		$pdf->Cell(0, 10, utf8_decode('Liste des élèves inscrits à'),0,1,'C');
		$pdf->Cell(0, 10, utf8_decode($stageSelectionner['NOM_STAGE']),0,1,'C');
		$pdf->Ln();
		
		/* liste */
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetFillColor(192,192,192);
		$pdf->Cell(10, 5, utf8_decode('N°'),1,0,'C',true);
		$pdf->Cell(60, 5, utf8_decode('NOM'),1,0,'C',true);
		$pdf->Cell(60, 5, utf8_decode('Prénom'),1,0,'C',true);
		$pdf->Cell(50, 5, utf8_decode('Groupe'),1,1,'C',true);
		
		$i = 0;
		foreach($lesInscriptions as $lInscription) {
			$i++;
			$pdf->Cell(10, 5, utf8_decode($i),1,0,'C');
			$pdf->Cell(60, 5, utf8_decode($lInscription['NOM_ELEVE_STAGE']),1,0,'L');
			$pdf->Cell(60, 5, utf8_decode($lInscription['PRENOM_ELEVE_STAGE']),1,0,'L');
			$nom_groupe = '';
			foreach($lesGroupes as $leGroupe) {
				if($leGroupe['ID_GROUPE'] == $lInscription['ID_GROUPE']) { $nom_groupe = $leGroupe['NOM_GROUPE']; }
			}
			$pdf->Cell(50, 5, utf8_decode($nom_groupe),1,1,'L');
		}
		$pdf->Output();	
		
	}
	
	
	
	
	public function imprimerListeGroupes($lesGroupes)
	{
		/* on créé le PDF */
		require('fpdf/fpdf.php');
		$pdf = new FPDF('L');
		
		
		foreach($lesGroupes as $leGroupe) {
			$pdf->AddPage();
			$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
			$pdf->SetFont('Arial', '', 50);
			$pdf->Cell(0, 10, utf8_decode(' '),0,1,'C');
			$pdf->Ln();
			$pdf->Cell(0, 10, utf8_decode('Groupe :'),0,1,'C');
			$pdf->SetFont('Arial', '', 100);
			$pdf->Ln();
			$pdf->Ln();
			$pdf->MultiCell(0, 50, utf8_decode($leGroupe['NOM_GROUPE']),0,'C');
		}
		$pdf->Output();	
	}
	
	
	/* fiche présence stages */
	public function imprimerFichesPresences($lesGroupes,$lesInscriptions,$stageSelectionner,$periode)
	{
		/* on créé le PDF */
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->SetFillColor(192,192,192);
		
		foreach($lesGroupes as $leGroupe) {
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 18);
			$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
			$pdf->Cell(0, 10, utf8_decode('Fiche de présences'),0,1,'C');
			$pdf->Cell(0, 10, utf8_decode($stageSelectionner['NOM_STAGE']),0,1,'C');
			$pdf->SetFont('Arial', 'B', 11);
			$pdf->Ln();
			$pdf->Cell(50, 10, utf8_decode('Groupe : '),0,0,'L');
			$pdf->Cell(50, 10, utf8_decode($leGroupe['NOM_GROUPE']),0,1,'L');
			$pdf->Cell(50, 10, utf8_decode('Date et période : '),0,0,'L');
			$pdf->Cell(50, 10, utf8_decode($periode),0,1,'L');
			$pdf->Cell(50, 10, utf8_decode('Intervenant : '),0,0,'L');
			$pdf->Cell(50, 10, utf8_decode('________________________________'),0,1,'L');
			
			
			$pdf->Ln();
			$pdf->Cell(40, 10, utf8_decode('Photo'),0,0,'L',true);
			$pdf->Cell(60, 10, utf8_decode('Nom'),0,0,'L',true);
			$pdf->Cell(60, 10, utf8_decode('Observations'),0,0,'L',true);
			$pdf->Cell(30, 10, utf8_decode('Présent ?'),0,0,'C',true);
			$pdf->Ln();
			
			/* liste des élèves */
			$i = 0;
			foreach($lesInscriptions as $lInscription) {
				
				if($lInscription['ID_GROUPE'] == $leGroupe['ID_GROUPE']) {
					$position = 90+($i*20);
					if( $lInscription['PHOTO_ELEVE_STAGE'] == '') { $lInscription['PHOTO_ELEVE_STAGE'] = 'AUCUNE.jpg'; }
					 $lEleve['PHOTO'] = str_replace(' ','%20',$lEleve['PHOTO']);
					
					//$pdf->Image('https://association-ore.fr/extranet/photosEleves/' . $lInscription['PHOTO_ELEVE_STAGE'],10,$position,0,19);
					// espace pour la photo
					$pdf->Cell(40, 20, ' ',0,0,'L');
					// nom prénom
					$pdf->Cell(60, 20, utf8_decode($lInscription['NOM_ELEVE_STAGE'] . ' ' . $lInscription['PRENOM_ELEVE_STAGE']),0,0,'L');
					// espace pour observations
					$pdf->Cell(60, 20, ' ',0,0,'L');
					// case à cocher présent
					$pdf->Cell(30, 20, ' ',1,0,'L');
					$pdf->Ln();

					$i++;
				}
				
			}
			if($i == 0) {
					$pdf->Cell(50, 10, utf8_decode('Aucun élève inscrit.'),0,0,'L');
				}
		}
		$pdf->Output();	
	}
	
	
	
	public function urlExist($url) {
    $file_headers = @get_headers($url);
    if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
       return false;
	} else {
		return true;
	}
	}

	
	
		/* fiche présence soutien scolaire */
	public function imprimerFichesPresencesScolaire($lesClasses,$lesEleves,$num)
	{
		/* on créé le PDF */
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->SetFillColor(192,192,192);
		
		foreach($lesClasses as $laClasse) {

            // Ne pas afficher BTS et FAC
            if($laClasse['ID'] < 57) {

			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 18);
			$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
			$pdf->Cell(0, 10, utf8_decode('Fiche de présences'),0,1,'C');
			$pdf->Cell(0, 10, utf8_decode('soutien scolaire'),0,1,'C');
			$pdf->SetFont('Arial', 'B', 11);
			$pdf->Ln();
			$pdf->Cell(50, 10, utf8_decode('Classe : '),0,0,'L');
			$pdf->Cell(50, 10, utf8_decode($laClasse['NOM']),0,1,'L');
			$pdf->Cell(50, 10, utf8_decode('Date : '),0,0,'L');
			$pdf->Cell(50, 10, utf8_decode('________________________________'),0,1,'L');
			$pdf->Cell(50, 10, utf8_decode('Intervenant : '),0,0,'L');
			$pdf->Cell(50, 10, utf8_decode('________________________________'),0,1,'L');
			
			

			$pdf->Cell(20, 8, utf8_decode('Présent ?'),0,0,'C',true);
			$pdf->Cell(60, 8, utf8_decode('Nom'),0,0,'C',true);
			$pdf->Cell(60, 8, utf8_decode('Observations'),0,0,'C',true);
			
			$pdf->Ln();
			
			$pdf->SetFont('Arial', '', 11);
			
			/* liste des élèves */

			foreach($lesEleves as $lEleve) {
				
				
				if($lEleve['ID_CLASSE'] == $laClasse['ID']) {
					
					// case à cocher présent
					$pdf->Cell(20, 8, ' ',1,0,'L');
					// nom prénom
					$pdf->Cell(70, 8, utf8_decode($lEleve['NOM'] . ' ' . $lEleve['PRENOM']),0,0,'L');
					// espace pour observations
					$pdf->Cell(70, 8, '______________________',0,0,'L');
					
					$pdf->Ln();

					$i++;
				}
				
			}
            
            // Lignes vides
            for($x = 0; $x < 6; $x++) {
                // case à cocher présent
					$pdf->Cell(20, 8, ' ',1,0,'L');
					// nom prénom
					$pdf->Cell(70, 8, utf8_decode('__________________________'),0,0,'L');
					// espace pour observations
					$pdf->Cell(70, 8, '______________________',0,0,'L');
					
					$pdf->Ln();
            }
            
            
			if($i == 0) {
					$pdf->Cell(50, 10, utf8_decode('Aucun élève inscrit dans cette classe.'),0,0,'L');
				}
				

		}
            
        }
		$pdf->Output();	
	}	
    
    
    public function getNbHeuresIntervenant($num,$mois,$annee)
	{
		$req = "SELECT SUM(`HEURES`) FROM `appel` as `heu` WHERE `ID_INTERVENANT` = ".$num." AND `SEANCE` > '".$annee."-".$mois."-01' AND `SEANCE` < '".$annee."-".$mois."-31'";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		
		return $laLigne;
    }
    
    
    public function getNbHeuresIntervenantsSalaries($mois,$annee)
	{
		$req = "SELECT SUM(`HEURES`),`appel`.`ID_INTERVENANT`,`NOM`,`PRENOM` FROM `intervenants` JOIN `appel` ON `intervenants`.`ID_INTERVENANT` = `appel`.`ID_INTERVENANT` WHERE `appel`.`ID_INTERVENANT` IS NOT NULL AND `SEANCE` >= '$annee-$mois-01' AND `SEANCE` <= '$annee-$mois-31' AND `STATUT` = 'Salarié' GROUP BY `appel`.`ID_INTERVENANT`";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		
		return $laLigne;
    }
    
    /* Génération d'un bordereau d'un stage */
    public function bordereauStage($num,$lesReglements)
	{
		/* on créé le PDF */
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		
		$pdf->AddPage('L');
		
		/* titre */
		$pdf->SetFont('Arial', '', 18);
		
		$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
		$pdf->Cell(0, 10, utf8_decode('Bordereau des réglements'),0,1,'C');
		$pdf->Ln();
		
		/* liste */
		$pdf->SetFont('Arial', '', 11);

		$hauteurDesLignes = 7;
				
        $pdf->SetFillColor(160,160,160);
        $pdf->SetTextColor(0,0,0);
				
        
        
        $i = 0;
        $montant = 0;
        $typePrecedent = '';
		
		// On parcours les intervenants
		foreach($lesReglements as $leReglement) {
				
            // couleur de fond
            if($i % 2 == 1) {
					$couleurDeFond = true;
				} else {
					$couleurDeFond = false;
				}
            
            if($leReglement['PAIEMENT_INSCRIPTIONS'] != '') {
            
            // Si le type de reglement change
            if($typePrecedent != $leReglement['PAIEMENT_INSCRIPTIONS']) {
                
                $pdf->SetFillColor(0,0,0);
                $pdf->SetTextColor(255,255,255);
                
                // On inscrit le total
                $pdf->Cell(180, $hauteurDesLignes, utf8_decode('Total :'),1,0,'R',true);
                $pdf->Cell(20, $hauteurDesLignes, utf8_decode($montant),1,0,'L',true);
                
                // On remet le montant total à zéro
                $montant = 0;
                
                // On change de page
                $pdf->AddPage('L');
                
                // On met l'entete
                
                $pdf->Cell(40, $hauteurDesLignes, utf8_decode('Nom'),1,0,'L',true);
                $pdf->Cell(40, $hauteurDesLignes, utf8_decode('Prénom'),1,0,'L',true);
                $pdf->Cell(40, $hauteurDesLignes, utf8_decode('Type'),1,0,'L',true);
                $pdf->Cell(20, $hauteurDesLignes, utf8_decode('N° chèque'),1,0,'L',true);
                $pdf->Cell(40, $hauteurDesLignes, utf8_decode('Banque'),1,0,'L',true);
                $pdf->Cell(20, $hauteurDesLignes, utf8_decode('Montant'),1,0,'L',true);
                $pdf->Ln();
                $pdf->SetFillColor(160,160,160);
                $pdf->SetTextColor(0,0,0);
            }
            
            $typePrecedent = $leReglement['PAIEMENT_INSCRIPTIONS'];
				
            $pdf->Cell(40, $hauteurDesLignes, utf8_decode(stripslashes($leReglement['NOM_ELEVE_STAGE'])),1,0,'L',$couleurDeFond);
            $pdf->Cell(40, $hauteurDesLignes, utf8_decode(stripslashes($leReglement['PRENOM_ELEVE_STAGE'])),1,0,'L',$couleurDeFond);
            $pdf->Cell(40, $hauteurDesLignes, utf8_decode(stripslashes($leReglement['PAIEMENT_INSCRIPTIONS'])),1,0,'L',$couleurDeFond);
            $pdf->Cell(20, $hauteurDesLignes, utf8_decode($leReglement['NUMTRANSACTION']),1,0,'L',$couleurDeFond);
            $pdf->Cell(40, $hauteurDesLignes, utf8_decode(stripslashes($leReglement['BANQUE_INSCRIPTION'])),1,0,'L',$couleurDeFond);
            $pdf->Cell(20, $hauteurDesLignes, utf8_decode($leReglement['MONTANT_INSCRIPTION']),1,0,'L',$couleurDeFond);
			
            $montant = $montant + $leReglement['MONTANT_INSCRIPTION'];
				
            $pdf->Ln();
			
			
			$i++;
		}
        }
		$pdf->Output();	
		
	}
    
    
    
    /* fiche  indemnité */
	public function FichesIndemnites($lesIntervenants, $tarif, $mois, $annee, $reglement, $dateReglement)
	{
		/* on créé le PDF */
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->SetFillColor(220,220,220);
	
        $i = 0;
		foreach($lesIntervenants as $unIntervenant) {
   
            // Calculs
            $nbHeures = $unIntervenant['SUM(`HEURES`)'];
            $totalAPayer = (doubleval($nbHeures) * $tarif);
            $nom = $unIntervenant['NOM'];
            $prenom = $unIntervenant['PRENOM'];
			
			// Si il n'y a aucune heure à payer, on passe au suivant
			if($totalAPayer == 0) { continue; }

			$pdf->AddPage();
			$pdf->SetFont('Arial', 'B', 20);
			//$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
			$pdf->Cell(0, 10, utf8_decode('INDEMNITES DES ANIMATEURS'),0,1,'C');
			$pdf->Ln();
			$pdf->Cell(0, 10, utf8_decode('FICHE A COMPLETER'),0,1,'C', true);
            $pdf->Cell(0, 10, utf8_decode('DANS LE CAS D\'UNE DEPENSE'),0,1,'C', true);
            $pdf->Ln();
                
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, utf8_decode('Nom et prénom de l\'animateur : '.$nom.' '.$prenom),0,0,'L');
            $pdf->Ln();
            $pdf->Cell(0, 10, utf8_decode('Commission : Scolaire'),0,0,'L');
            $pdf->Ln();
            $pdf->Cell(0, 10, utf8_decode('Détail de l\'indemnité :'),0,0,'L');
			$pdf->Ln();
			

			$pdf->Cell(50, 8, utf8_decode('Mois :'),1,0,'L',true);
			$pdf->Cell(50, 8, utf8_decode($mois.'/'.$annee),1,0,'L',true);
            $pdf->Ln();
                
			$pdf->Cell(50, 8, utf8_decode('Nombre d\'heures :'),1,0,'L',true);
			$pdf->Cell(50, 8, utf8_decode($nbHeures),1,0,'L',true);
            $pdf->Ln();
			
			$pdf->Cell(50, 8, utf8_decode('Tarif à l\'heure :'),1,0,'L',true);
			$pdf->Cell(50, 8, utf8_decode($tarif.' euros net'),1,0,'L',true);
            $pdf->Ln();
                
            $pdf->Cell(50, 8, utf8_decode('TOTAL A PAYER :'),1,0,'L',true);
			$pdf->Cell(50, 8, utf8_decode($totalAPayer.' euros'),1,0,'L',true);
            $pdf->Ln();
                $pdf->Ln();
            $pdf->Cell(50, 10, utf8_decode('Montant de la dépense : '.$totalAPayer.' euros'),0,0,'L');
            $pdf->Ln();
                
            $pdf->Cell(0, 10, utf8_decode('Date de la dépense : '.$dateReglement),0,0,'L');
            $pdf->Ln();
                
            $pdf->Cell(0, 10, utf8_decode('Règlement : '.$reglement),0,0,'L');
            $pdf->Ln();
                
            $pdf->Cell(0, 10, utf8_decode('Fait à Quetigny le '.date('d/m/Y', time())),0,0,'R');
            $pdf->Ln();
            $pdf->Ln();

                
            $pdf->Cell(0, 10, utf8_decode('Signature du Trésorier'),0,0,'R');
            $pdf->Ln();

            $i++;
        }
		$pdf->Output();	
	}	
	

		
/**
	* supprime une ligne de la table parametre
*/
	public function suppParametre($num)
	{
		$req = "DELETE 
				FROM parametre
				WHERE  ID=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
/**
 * ajoute une ligne dans la table ELEVES
*/
	public function ajoutEleve($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant,$responsable_legal,$tel_parent,$tel_parent2,$tel_parent3, $profession_pere,$adresse,$profession_mere,$ville, $email_parent,$prevenir_parent,$commentaires,$cp,$codebarre)
	{			
		$req = "INSERT INTO `eleves` VALUES ('', '".strtoupper($nom)."', '".ucfirst($prenom)."', '$sexe', '$date_naissance', '$responsable_legal', $prevenir_parent, '$profession_pere', '$profession_mere', '".strtoupper($adresse)."', '".strtoupper($cp)."', '".strtoupper($ville)."', '$tel_parent', '$tel_parent2', '$tel_parent3', '$tel_enfant', '$email_parent', '$email_enfant', NULL, NULL, '$commentaires', '', '', '', '$codebarre', 1, 1);";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
 * ajoute une ligne dans la table RDVPARENTS
*/
	public function ajoutRdv($num,$intervenant,$date,$commentaire,$matiere,$duree,$bsb)
	{			
		$req = "INSERT INTO `rdvparents` VALUES ('','$num', '$intervenant', '$date', '".addslashes($commentaire)."',$matiere,$duree,$bsb);";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion du rdv dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
		/**
 * ajoute un partenaire
*/
	public function ajouterPartenaire($nom, $image)
	{			
		$req = "INSERT INTO `PARTENAIRES_STAGE` VALUES ('','$nom', '$image');";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion du rdv dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * ajoute une ligne dans la table inscrit
*/
	public function ajoutInscriptionELEVE($maximumNum, $anneeschoix ,$etab, $filiere, $lv1,$lv2,$classe,$prof_principal)
	{			

		
		$req = "INSERT INTO `inscrit` VALUES ($maximumNum, '$anneeschoix', $etab, $filiere, $lv1, $lv2, $classe, CURRENT_DATE, '$prof_principal', '');";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	
/**
 * maj une ligne dans la table ELEVES avec password
*/
	public function modifElevesAvecCode($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant,$responsable_legal,$tel_parent,$tel_parent2,$tel_parent3, $profession_pere,$adresse,$profession_mere,$ville, $email_parent,$prevenir_parent,$commentaires,$cp,$assurance,$codebarre,$password,$num,$numAllocataire,$nbTempsLibres,$contactParents,$photo)
	{			
		$req = "UPDATE `eleves` SET `NOM`='".strtoupper($nom)."',`PRENOM`='".ucfirst($prenom)."',`SEXE`='$sexe',`DATE_DE_NAISSANCE`='$date_naissance',`RESPONSABLE_LEGAL`='$responsable_legal',`PRÉVENIR_EN_CAS_D_ABSENCE`='$prevenir_parent',`PROFESSION_DU_PÈRE`='$profession_pere',`PROFESSION_DE_LA_MÈRE`='$profession_mere',`ADRESSE_POSTALE`='$adresse',`CODE_POSTAL`='$cp',`VILLE`='".strtoupper($ville)."',`TÉLÉPHONE_DES_PARENTS`='$tel_parent',`TÉLÉPHONE_DES_PARENTS2`='$tel_parent2',`TÉLÉPHONE_DES_PARENTS3`='$tel_parent3',`TÉLÉPHONE_DE_L_ENFANT`='$tel_enfant',`EMAIL_DES_PARENTS`='$email_parent',`EMAIL_DE_L_ENFANT`='$email_enfant',`PHOTO`='$photo',`CONTACT_AVEC_LES_PARENTS`='$contactParents',`COMMENTAIRES`='$commentaires',`N°_ALLOCATAIRE`='$numAllocataire',`NOMBRE_TPS_LIBRE`='$nbTempsLibres',`ASSURANCE_PÉRISCOLAIRE`='$assurance', `PASSWORD`='$password' WHERE `ID_ELEVE`=" . $num . ";";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());} else { }

	}
	
	
		
/**
 * maj une ligne dans la table ELEVES sans password
*/
	public function modifElevesSansCode($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant,$responsable_legal,$tel_parent,$tel_parent2,$tel_parent3, $profession_pere,$adresse,$profession_mere,$ville, $email_parent,$prevenir_parent,$commentaires,$cp,$assurance,$codebarre,$num,$numAllocataire,$nbTempsLibres,$contactParents,$photo)
	{			
		$req = "UPDATE `eleves` SET `NOM`='".strtoupper($nom)."',`PRENOM`='".ucfirst($prenom)."',`SEXE`='$sexe',`DATE_DE_NAISSANCE`='$date_naissance',`RESPONSABLE_LEGAL`='$responsable_legal',`PRÉVENIR_EN_CAS_D_ABSENCE`='$prevenir_parent',`PROFESSION_DU_PÈRE`='$profession_pere',`PROFESSION_DE_LA_MÈRE`='$profession_mere',`ADRESSE_POSTALE`='$adresse',`CODE_POSTAL`='$cp',`VILLE`='".strtoupper($ville)."',`TÉLÉPHONE_DES_PARENTS`='$tel_parent',`TÉLÉPHONE_DES_PARENTS2`='$tel_parent2',`TÉLÉPHONE_DES_PARENTS3`='$tel_parent3',`TÉLÉPHONE_DE_L_ENFANT`='$tel_enfant',`EMAIL_DES_PARENTS`='$email_parent',`EMAIL_DE_L_ENFANT`='$email_enfant',`PHOTO`='$photo',`CONTACT_AVEC_LES_PARENTS`='$contactParents',`COMMENTAIRES`='$commentaires',`N°_ALLOCATAIRE`='$numAllocataire',`NOMBRE_TPS_LIBRE`='$nbTempsLibres',`ASSURANCE_PÉRISCOLAIRE`='$assurance' WHERE `ID_ELEVE`=" . $num . ";";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	
	
	
		
/**
 * maj une ligne dans la table reglement
*/
	public function modifReglement($num,$nom,$date,$type,$cheque,$banque,$montant,$commentaire)
	{			
		$req = "UPDATE `reglements` SET `ID_TYPEREGLEMENT`=$type,`NUMCHEQUE`='$cheque',`BANQUE`='$banque',`DATE_REGLEMENT`='$date',`MONTANT`='$montant',`COMMENTAIRES`='$commentaire',`NOMREGLEMENT`='$nom' WHERE `ID`=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * ajoute une ligne dans la table Parametre
*/
	public function InsertParametre($id,$nom,$niveau,$type)
	{			
		$req = "INSERT INTO `parametre`(`ID`, `ID_AVOIR`, `NOM`, `NIVEAU`) VALUES ($id,$type,'$nom','$niveau');";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	/**
 * ajoute une ligne dans la table APPEL pour les intervenants
*/
	public function ajoutAppelIntervenant($numero,$date,$heure)
	{			
		$req = "INSERT INTO `appel`(`ID_INTERVENANT`, `SEANCE`,  `HEURES`) VALUES ($numero,'$date',$heure);";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
 * ajoute une ligne dans la table APPEL pour les eleves 
*/
	public function ajoutAppelEleveCase($numero,$date)
		{			
		$req = "INSERT INTO `appel`(`ID_ELEVE`, `SEANCE`) VALUES ($numero,'$date');";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
		
	
/**
 * ajoute une ligne dans la table Intervenants
*/
	public function ajoutIntervenant($annee, $nom, $prenom, $actif, $date_naissance, $lieu_naissance,$tel, $adresse,$statut, $cp, $ville,$email,$commentaires,$diplome,$numsecu,$nationalite,$password,$iban,$bic,$compte,$banque)
	{			
		$req = "INSERT INTO `intervenants` VALUES ('', '$nom', '$prenom', $actif, '$statut', '$email', '$tel', '$adresse', '$cp', '$ville', '$diplome', '$commentaires', '$date_naissance', '$lieu_naissance', '$nationalite', '$numsecu', 'AUCUNE.jpg', '', '', '', '', '$password', 0,'$iban','$bic','$compte','$banque','');";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'intervenant dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		
		$req = "INSERT INTO `inscrit_intervenants`(`ID_INTERVENANT`, `ANNEE`) VALUES ((SELECT MAX(ID_INTERVENANT) FROM intervenants),$annee)";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'intervenant dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
/**
 * ajoute une ligne dans la table Evenements
*/
	public function ajoutEvenement($nom,$cout,$nb,$dateDebut,$dateFin)
	{			
		$req = "INSERT INTO `evenements`(`NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER`) VALUES ('','$nom','$dateDebut','$dateFin','$cout','$nb',0);";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * ajoute une ligne dans la table DIFFICULTE
*/
	public function ajoutDifficulte($maximumNum,$valeur,$annee)
	{			
		$req = "INSERT INTO `difficultes` VALUES ($valeur,$maximumNum,'$annee','0');";
		$rs = PdoBD::$monPdo->exec($req);
	
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
 * ajoute une ligne dans la table Presence
*/
	public function ajoutPlanning($intervenant,$valeur1)
	{			
		$req = "INSERT INTO `presence` VALUES ($intervenant,'$valeur1',0);";
		$rs = PdoBD::$monPdo->exec($req);
		return $rs;
		//if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
 * ajoute une ligne dans la table specialite
*/
	public function ajoutSpecialite($maximumNum,$valeur)
	{			
		$req = "INSERT INTO `specialiser` VALUES ($maximumNum,$valeur);";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
 * ajoute une ligne dans la table remisecaf
*/
	public function ajoutRemiseCAF($num)
	{			
		$req = "INSERT INTO `remisecaf`(`ID`, `DATE_CAF`) VALUES ($num,NOW());";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	/**
 * ajoute une ligne dans la table remisecheque
*/
	public function ajoutRemiseCheque($num)
	{			
		$req = "INSERT INTO `remisecheque`(`ID`, `DATE_CHEQUE`) VALUES ($num,NOW());";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
	
	
/**
 * Retourne dans un tableau associatifles informations de la table PARAMETRE (pour un type particulier)
*/
	public function getParametre($type)
	{
        $tri = 'ID';
        if($type == 8) { $tri = 'ID DESC'; }
		$req = "SELECT ID,NOM,VALEUR
				FROM parametre
				WHERE ID_AVOIR='$type'
				ORDER by $tri;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
	/**
 * Retourne un seul parametre
*/
	public function getParametreSeul($type)
	{
		$req = "SELECT ID,NOM
				FROM parametre
				WHERE ID_AVOIR='$type'
				LIMIT 0,1;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetch();
		return $lesLignes;
	}
	
	/**
 * Retourne dans un tableau les lieux de stage
*/
	public function getLieux()
	{
		$req = "SELECT *
				FROM `LIEUX_STAGE`
				ORDER by `NOM_LIEU`;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des lieux dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
	/**
 * Retourne dans un tableau les groupes de stage
*/
	public function getGroupes($num)
	{
		$req = "SELECT *
				FROM `GROUPE_STAGE`
				WHERE `ID_STAGE` = $num
				ORDER by `ID_GROUPE`;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
	/**
 * Retourne dans un tableau les reglements de stage
*/
	public function getReglementsStage($num)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
    
    
    /**
 * Retourne dans un tableau les reglements de stage triés
*/
	public function getReglementsStageTrie($num)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=$num ORDER BY `PAIEMENT_INSCRIPTIONS`;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
		/**
 * Retourne dans un tableau les élèves d'un groupe de stage
*/
	public function getElevesDuGroupe($num)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_GROUPE`=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
	/**
 * Retourne dans un tableau les années scolaires
*/
	public function getAnneesScolaires()
	{
		$req = "SELECT * FROM annee_scolaire ORDER BY TEXTE";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	

	
		/**
 * Retourne dans un tableau les stages
*/
	public function getStages()
	{
		$req = "SELECT * FROM STAGE_REVISION WHERE ANNEE_STAGE IN (SELECT NOM FROM parametre WHERE ID='82') ORDER BY DATEDEB_STAGE";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	/**
 * Retourne le nb de présences d'un élève dans un stage 
*/
	public function nbPresencesStage($id_stage,$id_eleve)
	{
		$req = "SELECT COUNT(*) FROM PRÉSENCES_STAGE INNER JOIN INSCRIPTIONS_STAGE ON PRÉSENCES_STAGE.ID_INSCRIPTIONS = INSCRIPTIONS_STAGE.ID_INSCRIPTIONS WHERE PRÉSENCES_STAGE.ID_INSCRIPTIONS = $id_eleve AND INSCRIPTIONS_STAGE.ID_STAGE = $id_stage ";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		
		return $laLigne;
		
	}
	
	
	/**
 * Retourne l'id d'inscription d'un élève inscrit à un stage
*/
	public function getIdInscriptionStage($id_stage,$id_eleve)
	{
		$req = "SELECT * FROM INSCRIPTIONS_STAGE INNER JOIN ELEVE_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE  WHERE ELEVE_STAGE.ID_ELEVE_ANCIENNE_TABLE = $id_eleve AND INSCRIPTIONS_STAGE.ID_STAGE = $id_stage";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		
		return $laLigne['ID_INSCRIPTIONS'];
		
	}
	
			/**
 * Retourne dans un tableau les villes
*/
	public function getVilles()
	{
		$req = "SELECT VILLE FROM eleves ORDER BY VILLE";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		
		// Suppression des doublons
		$lesVilles = array();
		foreach ($lesLignes as $uneLigne) {	
			if(!array_search($uneLigne, $lesVilles)) {
				$lesVilles[] = $uneLigne;
			}
		}
		return $lesVilles;
	}
	
	
	
			/**
 * Importer un élève déjà existant
*/
	public function importerEleveStage($id_ancien,$id_inscription,$anneeEnCours)
	{
		$req = "SELECT * FROM eleves INNER JOIN inscrit ON eleves.ID_ELEVE = inscrit.ID_ELEVE WHERE eleves.ID_ELEVE = $id_ancien AND inscrit.ANNEE = $anneeEnCours";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		
		$id = $laLigne['ID_ELEVE'];
		$nom = addslashes($laLigne['NOM']);
		$prenom = addslashes($laLigne['PRENOM']);
		$sexe = $laLigne['SEXE'];
		$ddn = $laLigne['DATE_DE_NAISSANCE'];
		$adresse = addslashes($laLigne['ADRESSE_POSTALE']);
		$cp = $laLigne['CODE_POSTAL'];
		$ville = addslashes($laLigne['VILLE']);
		$tel_parents = $laLigne['TÉLÉPHONE_DES_PARENTS'];
		$tel_enfant = $laLigne['TÉLÉPHONE_DE_L_ENFANT'];
		$email_parents = addslashes($laLigne['EMAIL_DES_PARENTS']);
		$email_enfant = addslashes($laLigne['EMAIL_DE_L_ENFANT']);
		$photo = $laLigne['PHOTO'];
		$classe = $laLigne['ID_CLASSE'];
		$filiere = $laLigne['ID_FILIERES'];
		$etab = $laLigne['ID'];
		

		$req = "UPDATE `ELEVE_STAGE` SET `NOM_ELEVE_STAGE`='$nom',
		`PRENOM_ELEVE_STAGE`='$prenom',
		`SEXE_ELEVE_STAGE`='$sexe',
		`ETABLISSEMENT_ELEVE_STAGE`='$etab',
		`CLASSE_ELEVE_STAGE`='$classe',
		`TELEPHONE_PARENTS_ELEVE_STAGE`='$tel_parents',
		`TELEPHONE_ELEVE_ELEVE_STAGE`='$tel_enfant',
		`EMAIL_PARENTS_ELEVE_STAGE`='$email_parents',
		`EMAIL_ENFANT_ELEVE_STAGE`='$email_enfant',
		`ADRESSE_ELEVE_STAGE`='$adresse',
		`CP_ELEVE_STAGE`='$cp',
		`VILLE_ELEVE_STAGE`='$ville',
		`ID_ELEVE_ANCIENNE_TABLE`='$id',
		`PHOTO_ELEVE_STAGE`='$photo',
		`DDN_ELEVE_STAGE`='$ddn',
		`FILIERE_ELEVE_STAGE`='$filiere'
		WHERE `ID_ELEVE_STAGE`=$id_inscription";
	
		
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
	}
    
    
    
    
    
			/**
 * Importer un élève pas existant
*/
	public function importerEleveStageNouveau($id_ancien,$idStage,$anneeEnCours)
	{
		$req = "SELECT * FROM eleves INNER JOIN inscrit ON eleves.ID_ELEVE = inscrit.ID_ELEVE WHERE eleves.ID_ELEVE = $id_ancien AND inscrit.ANNEE = $anneeEnCours";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		
		$id = $laLigne['ID_ELEVE'];
		$nom = addslashes($laLigne['NOM']);
		$prenom = addslashes($laLigne['PRENOM']);
		$sexe = $laLigne['SEXE'];
		$ddn = $laLigne['DATE_DE_NAISSANCE'];
		$adresse = addslashes($laLigne['ADRESSE_POSTALE']);
		$cp = $laLigne['CODE_POSTAL'];
		$ville = addslashes($laLigne['VILLE']);
		$tel_parents = $laLigne['TÉLÉPHONE_DES_PARENTS'];
		$tel_enfant = $laLigne['TÉLÉPHONE_DE_L_ENFANT'];
		$email_parents = addslashes($laLigne['EMAIL_DES_PARENTS']);
		$email_enfant = addslashes($laLigne['EMAIL_DE_L_ENFANT']);
		$photo = $laLigne['PHOTO'];
		$classe = $laLigne['ID_CLASSE'];
		$filiere = $laLigne['ID_FILIERES'];
		$etab = $laLigne['ID'];
		

		$req = "INSERT INTO `ELEVE_STAGE`
        (`ID_ELEVE_STAGE`, `NOM_ELEVE_STAGE`, `PRENOM_ELEVE_STAGE`, `SEXE_ELEVE_STAGE`, `ETABLISSEMENT_ELEVE_STAGE`, `CLASSE_ELEVE_STAGE`, `ASSOCIATION_ELEVE_STAGE`, `TELEPHONE_PARENTS_ELEVE_STAGE`, `TELEPHONE_ELEVE_ELEVE_STAGE`, `EMAIL_PARENTS_ELEVE_STAGE`, `EMAIL_ENFANT_ELEVE_STAGE`, `ADRESSE_ELEVE_STAGE`, `CP_ELEVE_STAGE`, `VILLE_ELEVE_STAGE`, `ID_ELEVE_ANCIENNE_TABLE`, `PHOTO_ELEVE_STAGE`, `DDN_ELEVE_STAGE`, `FILIERE_ELEVE_STAGE`, `DOCUMENT1_STAGE`, `DOCUMENT2_STAGE`, `DOCUMENT3_STAGE`)
        VALUES ('','$nom','$prenom','$sexe','$etab','$classe','ore','$tel_parents','$tel_enfant','$email_parents','$email_enfant','$adresse','$cp','$ville','$id_ancien','$photo','$ddn','$filiere',NULL,NULL,NULL);
        
        INSERT INTO `INSCRIPTIONS_STAGE`
        (`ID_INSCRIPTIONS`, `ID_STAGE`, `ID_GROUPE`, `ID_ELEVE_STAGE`, `ID_ATELIERS`, `VALIDE`, `DATE_INSCRIPTIONS`, `IP_INSCRIPTIONS`, `USER_AGENT_INSCRIPTIONS`, `ORIGINE_INSCRIPTIONS`, `COMMENTAIRES_INSCRIPTIONS`, `PAIEMENT_INSCRIPTIONS`, `NUMTRANSACTION`, `BANQUE_INSCRIPTION`, `MONTANT_INSCRIPTION`)
        VALUES ('',$idStage,0,(SELECT MAX(`ID_ELEVE_STAGE`) FROM `ELEVE_STAGE`),0,0,'".date('Y-m-d H:i:s',time())."','','','','','','','','');";
	
		
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
	}
	
	
	
			/**
 * Importer un intervenant
*/
	public function importerIntervenantStage($num)
	{
		$req = "SELECT * FROM `intervenants` WHERE `ID_INTERVENANT` = $num";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		
		$id = $laLigne['ID_INTERVENANT'];
		$nom = addslashes($laLigne['NOM']);
		$prenom = addslashes($laLigne['PRENOM']);
		$tel = addslashes($laLigne['TELEPHONE']);
		$email = addslashes($laLigne['EMAIL']);
		
		

		$req = "INSERT INTO `INTERVENANT_STAGE`(`ID_INTERVENANT`, `NOM_INTERVENANT`, `PRENOM_INTERVENANT`, `EMAIL_INTERVENANT`, `TEL_INTERVENANT`, `ID_ANCIENNE_TABLE_INTERVENANT`) 
		VALUES ('','$nom','$prenom','$email','$tel','$id')";
		
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoSasti::$monPdo->errorInfo());}
	}
	
	
	
	
	
	/**
 * Retourne dans un tableau associatifles informations de la table specialiser (pour une personne en particulier)
*/
	public function getSpecialisationIntervenant($num)
	{
		$req = "SELECT ID
				FROM specialiser
				WHERE ID_INTERVENANT=$num
				ORDER by ID;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	/**
 * Retourne dans un tableau associatifles informations de la table difficulter (pour une personne en particulier)
*/
	public function getDifficultesEleve($num,$annee)
	{
		$req = "SELECT ID
				FROM difficultes
				WHERE ID_ELEVE=$num
				and ANNEE='$annee'
				ORDER by ID;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
    
    // Mettre à jour les coordonnées GPS pour un élève
    public function majCoordonneesEleves($num,$lat,$lon) {

        $req = "INSERT INTO `localisation_eleves`(`ID_ELEVE`, `LAT`, `LON`) VALUES ($num,$lat,$lon)";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
        
    }
	
		/**
 * Retourne dans un tableau associatifles informations de la table difficulter (pour une personne en particulier)
*/
	public function recupEvenementEleve($num)
	{
		$req = "SELECT inscription.`NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER` FROM `evenements` INNER JOIN inscription ON inscription.NUMÉROEVENEMENT = evenements.NUMÉROEVENEMENT WHERE ID_ELEVE=$num ;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
    
    	/**
 * Retourne dans un tableau les localisations des élèves d'une année
*/
	public function recupLocalisations($annee)
	{
		$req = "SELECT * FROM `localisation_eleves` JOIN `inscrit` ON `localisation_eleves`.`ID_ELEVE` = `inscrit`.`ID_ELEVE` WHERE `inscrit`.`ANNEE` = $annee";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
		/**
 * Retourne dans un tableau associatifles les reglements (pour une personne en particulier) dapres le ID DUN ELEVE
*/
	public function recupReglementsUnEleve($num)
	{
		$req = "SELECT reglements.`ID`, NOM, `ID_APPARTIENT_RCAF`, `ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMCHEQUE`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, `COMMENTAIRES`, `NOMREGLEMENT` FROM `reglements` INNER JOIN parametre ON reglements.ID_TYPEREGLEMENT=parametre.ID  WHERE `ID_ELEVE`=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
    
    /**
 * Retourne dans un tableau associatifles le reglement (pour une personne en particulier) dapres le ID DUN reglement
*/
	public function recupUnReglementUnEleve($num)
	{
		$req = "SELECT reglements.`ID`, NOM, `ID_APPARTIENT_RCAF`, `ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMCHEQUE`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, `COMMENTAIRES`, `NOMREGLEMENT` FROM `reglements` INNER JOIN parametre ON reglements.ID_TYPEREGLEMENT=parametre.ID  WHERE reglements.`ID`=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
	
		/**
 * Retourne dans un tableau associatifles les reglements (pour une personne en particulier) dapres le ID DUN ELEVE si c'est payer par CAF
*/
	public function recupReglementsUnEleveCAF($num,$journal)
	{
		$req = "SELECT reglements.`ID`, NOM, `ID_APPARTIENT_RCAF`, `ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMCHEQUE`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, `COMMENTAIRES`, `NOMREGLEMENT` FROM `reglements` INNER JOIN parametre ON reglements.ID_TYPEREGLEMENT=parametre.ID  WHERE `ID_ELEVE`=$num AND ID_TYPEREGLEMENT=3 AND ID_APPARTIENT_RCAF=$journal;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
	
	
	
	/**
 * Retourne un reglement dapres son  ID
*/
	public function recupReglement($num)
	{
		$req = "SELECT NOMBRE_TPS_LIBRE, N°_ALLOCATAIRE, reglements.`ID`, parametre.NOM as NOMPARA, `ID_APPARTIENT_RCAF`, eleves.NOM as NOMELEVE, PRENOM,`ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMCHEQUE`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, reglements.`COMMENTAIRES` as com, `NOMREGLEMENT` FROM `reglements` INNER JOIN parametre ON reglements.ID_TYPEREGLEMENT=parametre.ID INNER JOIN eleves ON eleves.ID_ELEVE=reglements.ID_ELEVE WHERE reglements.`ID`=$num;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetch();
		return $lesLignes;
	}
	
		/**
 * Retourne un reglement dapres son numero de cheque
*/
	public function recupReglementCheque($num)
	{
		$req = "SELECT MONTANT, NOM, PRENOM FROM `reglements` INNER JOIN eleves ON reglements.ID_ELEVE=eleves.ID_ELEVE WHERE NUMCHEQUE='$num';";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
	
	/**
 * ajoute une ligne dans la table inscription
*/
	public function ajoutInscription($num,$evenement)
	{			
		$req = "INSERT INTO `inscription`(`NUMÉROEVENEMENT`, `ID_ELEVE`) VALUES ($evenement,$num);";
		$rs = PdoBD::$monPdo->exec($req);
		
		return $rs;
	}
	
	/**
 * ajoute une ligne dans la table reglement
*/
	public function ajoutReglement($num,$nom,$date,$type,$cheque,$banque,$montant,$commentaire)
	{			
		$req = "INSERT INTO `reglements`(`ID`, `ID_APPARTIENT_RCAF`, `ID_ELEVE`, `ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMCHEQUE`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, `COMMENTAIRES`, `NOMREGLEMENT`) VALUES ('',NULL,$num,NULL,$type,'$cheque','$banque',0,'$date','$montant','$commentaire','$nom');";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	
	/**
 * recuperer les numéro de cheque ayant un numéro journal specifique
*/
	public function recupCheques($journal)
	{			
		$req = "SELECT  DISTINCT(`NUMCHEQUE`), `BANQUE` FROM `reglements` WHERE ID_APPARTIENT_RCHEQUE=$journal AND ID_TYPEREGLEMENT =1;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;
	}
	
	
	/**
 * supprime une ligne dans la table inscription
*/
	public function suppInscriptionEvenement($num,$eleve)
	{			
		$req = "DELETE FROM `inscription` WHERE `NUMÉROEVENEMENT`=$num  AND `ID_ELEVE`=$eleve;";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	/**
 * supprime une ligne dans la table reglement
*/
	public function suppReglement($num)
	{			
		$req = "DELETE FROM `reglements` WHERE ID=$num;";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	
/**
 * maj les lignes reglement CAF
*/
	public function updateReglementCAF($newNumCAF)
	{			
		$req = "UPDATE `reglements` SET `ID_APPARTIENT_RCAF`=$newNumCAF WHERE `ID_APPARTIENT_RCAF` IS NULL and `ID_TYPEREGLEMENT`=3;";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * maj les lignes reglement Cheque
*/
	public function updateReglementCheque($newNumCAF)
	{			
		$req = "UPDATE `reglements` SET `ID_APPARTIENT_RCHEQUE`=$newNumCAF WHERE `ID_APPARTIENT_RCHEQUE` IS NULL and `ID_TYPEREGLEMENT`=1;";
		$rs = PdoBD::$monPdo->exec($req);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}
	
/**
 * envoyer un message electronique
*/
	public function envoyerMail($mail, $sujet, $msg, $entete)
	{			
		if (mail($mail, $sujet, $msg, null)==false)  
		{ echo 'Suite à un problème technique, votre message n a pas été envoyé a '.$mail.' sujet'.$sujet.'message '.$msg.' entete '.$entete;break;}
	}
    
    
    
    
    /* --------------- Centre Info ------------------ */
    
    /*  Gestion des inscriptions */
    
    // Récupérer toutes les inscriptions d'une année
    public function info_getInscriptions($annee) {		
		
        $req = "SELECT * FROM `info_inscriptions` INNER JOIN `info_annees` ON `info_inscriptions`.`id_inscription` = `info_annees`.`id_inscription` WHERE `info_annees`.`annee_inscription` = '$annee' ORDER BY `info_inscriptions`.`nom_inscription`;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Récupérer toutes les inscriptions 
    public function info_getInscriptionsTout() {		
		
        $req = "SELECT * FROM `info_inscriptions`;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Récupérer une inscription
    public function info_getUneInscription($num) {		
		$req = "SELECT * FROM `info_inscriptions` WHERE `id_inscription` = $num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
    
    // Ajouter une inscription
    public function info_ajouterUneInscription($nom, $prenom, $adresse, $cp, $ville, $lat, $lon, $sexe, $ddn, $date, $tel1, $tel2, $email,$annee) {

        $req = "INSERT INTO `info_inscriptions` VALUES('','".strtoupper($nom)."','".ucfirst($prenom)."','','','".strtoupper($adresse)."','$cp','".strtoupper($ville)."','$lat','$lon','$sexe','$ddn','$date','$tel1','$tel2','$email');
        INSERT INTO `info_annees` VALUES($annee,(SELECT MAX(`id_inscription`) FROM `info_inscriptions`));";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Modifier une inscription
    public function info_modifierUneInscription($num, $nom, $prenom, $adresse, $cp, $ville, $lat, $lon, $sexe, $ddn, $date, $tel1, $tel2, $email) {

        $req = "UPDATE `info_inscriptions` SET `nom_inscription` = '".strtoupper($nom)."', `prenom_inscription` = '".ucfirst($prenom)."', `adresse_inscription` = '".strtoupper($adresse)."', `cp_inscription` = '$cp', `ville_inscription` = '".strtoupper($ville)."', `lat_inscription` = '$lat', `lon_inscription` = '$lon', `sexe_inscription` = '$sexe', `ddn_inscription` = '$ddn', `date_inscription` = '$date', `tel1_inscription` = '$tel1', `tel2_inscription` = '$tel2', `email_inscription` = '$email' WHERE `id_inscription` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
        echo $req;
        
    }
    
    // Supprimer une inscription
    public function info_supprimerUneInscription($num) {

        $req = "DELETE FROM `info_annees` WHERE `id_inscription` = $num;
        DELETE FROM `info_documents` WHERE `id_inscription` = $num;
        DELETE FROM `info_participe` WHERE `id_inscription` = $num;
        DELETE FROM `info_presences` WHERE `id_inscription` = $num;
        DELETE FROM `info_reglements` WHERE `id_inscription` = $num;
        DELETE FROM `info_visites` WHERE `id_inscription` = $num;
        DELETE FROM `info_inscriptions` WHERE `id_inscription` = $num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Mettre à jour les coordonnées GPS pour une inscription
    public function info_majCoordonnees($num,$lat,$lon) {

        $req = "UPDATE `info_inscriptions` SET `lat_inscription`= '$lat',`lon_inscription`='$lon' WHERE `id_inscription` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
        
    }
    
    // Récupérer la/les activité(s) à laquelle/lesquelles une personne est inscrite
    public function info_getActivitesPourUneInscription($num) {		
		$req = "SELECT * FROM `info_inscriptions` INNER JOIN `info_participe` ON `info_inscriptions`.`id_inscription` = `info_participe`.`id_inscription` WHERE `info_inscriptions`.`id_inscription` = $num ORDER BY `nom_inscription`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Récupérer la/les présence(s) pour une activité
    public function info_getPresencesPourUneActivite($num) {		
		$req = "SELECT * FROM `info_presences` INNER JOIN `info_inscriptions` ON `info_inscriptions`.`id_inscription` = `info_presences`.`id_inscription` WHERE `info_presences`.`id_activite` = $num ORDER BY `date_presence` DESC, `matin_ap_presence`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Récupérer la/les inscription(s) pour une activite
    public function info_getInscriptionsPourUneActivite($num,$annee) {		
		$req = "SELECT * FROM `info_inscriptions` INNER JOIN `info_participe` ON `info_inscriptions`.`id_inscription` = `info_participe`.`id_inscription` WHERE `id_activite` = $num AND `annee_inscription` = $annee ORDER BY `nom_inscription`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Récupérer les activités
    public function info_getActivites($annee) {		
		$req = "SELECT * FROM `info_activites` JOIN `info_sederoule` ON `info_activites`.`id_activite` = `info_sederoule`.`id_activite` WHERE `annee_activite` = $annee";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Récupérer les années d'une activité
    public function info_getActiviteAnnees($num) {		
		$req = "SELECT * FROM `info_sederoule` WHERE `id_activite` = $num ORDER BY `annee_activite`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Récupérer une activité
    public function info_getActivite($num) {		
		$req = "SELECT * FROM `info_activites` WHERE `id_activite` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}
    
    // Modifier une activite
    public function info_modifierUneActivite($num, $nom) {

        $req = "UPDATE `info_activites` SET `nom_activite` = '$nom' WHERE `id_activite` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Récupérer les documents d'une personne
    public function info_getDocuments($num) {		
		$req = "SELECT * FROM `info_documents` WHERE `id_inscription` = $num ORDER BY date_document DESC";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Ajouter un document
    public function info_envoyerDocument($num,$fichier,$date,$commentaire) {		
		$req = "INSERT INTO `info_documents` VALUES('',$num,'$fichier','$date','$commentaire');";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Supprimer un document
    public function info_supprimerDocument($id) {		
		$req = "DELETE FROM `info_documents` WHERE `id_document` = $id";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
	}
    
    // Ajouter une activité
    public function info_ajouterUneActivite($nom,$annee) {

        $req = "INSERT INTO `info_activites` VALUES('','$nom');
        INSERT INTO `info_sederoule` VALUES('$annee',(SELECT MAX(`id_activite`) FROM `info_activites`));";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Ajouter une année pour uneactivité
    public function info_ajouterUneAnneeActivite($num,$annee) {

        $req = "INSERT INTO `info_sederoule` VALUES('$annee','$num');";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Supprimer une année pour une activité
    public function info_supprimerUneAnneeActivite($num,$annee) {

        $req = "DELETE FROM `info_sederoule` WHERE `annee_activite` = $annee AND `id_activite` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Supprimer une inscription
    public function info_supprimerUneActivite($num) {

        $req = "DELETE FROM `info_activites` WHERE `id_activite` = $num;
        DELETE FROM `info_sederoule` WHERE `id_activite` = $num;
        DELETE FROM `info_participe` WHERE `id_activite` = $num;
        DELETE FROM `info_presences` WHERE `id_activite` = $num;
        DELETE FROM `info_reglements` WHERE `id_activite` = $num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Enregistrer des présences
    public function info_saisirPresences($num,$inscription,$date,$periode) {

        $req = "INSERT INTO `info_presences` VALUES('','$inscription','$num','$date','$periode');";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Supprimer une présence
    public function info_supprimerUnePresence($num) {

        $req = "DELETE FROM `info_presences` WHERE `id_presence` = $num;";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // inscrire
    public function info_inscrire($uneInscription,$uneActivite,$annee) {

        $req = "INSERT INTO `info_participe` (`id_inscription`, `id_activite`,`annee_inscription`) VALUES ('$uneInscription','$uneActivite','$annee')";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Déinscrire
    public function info_desinscrire($uneInscription,$uneActivite,$annee) {

        $req = "DELETE FROM `info_participe` WHERE `id_inscription` = $uneInscription AND `id_activite` = $uneActivite AND `annee_inscription` = $annee";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Total des présences pour une activité pour chaque date
    public function info_getTotalPresences($num,$annee) {

        $req = "SELECT `date_presence`,COUNT(*) FROM `info_presences` WHERE `id_activite` = $num AND `date_presence` >= '$annee-08-01' AND `date_presence` <= '".($annee+1)."-07-30' GROUP BY `date_presence`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Répartition par sexe pour une activité
    public function info_getRepartitionSexe($num) {

        $req = "SELECT `sexe_inscription`,COUNT(*) FROM `info_inscriptions` INNER JOIN `info_participe` ON `info_inscriptions`.`id_inscription` = `info_participe`.`id_inscription` WHERE `info_participe`.`id_activite` = $num GROUP BY `sexe_inscription`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
     // Répartition par ville pour une activité
    public function info_getRepartitionVille($num) {

        $req = "SELECT `ville_inscription`,COUNT(*) FROM `info_inscriptions` INNER JOIN `info_participe` ON `info_inscriptions`.`id_inscription` = `info_participe`.`id_inscription` WHERE `info_participe`.`id_activite` = $num GROUP BY `ville_inscription`";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Répartition par age pour une activité
    public function info_getRepartitionAge($num) {

        $req = "SELECT YEAR(`ddn_inscription`),COUNT(*) FROM `info_inscriptions` INNER JOIN `info_participe` ON `info_inscriptions`.`id_inscription` = `info_participe`.`id_inscription` WHERE `info_participe`.`id_activite` = $num AND `ddn_inscription` != '0000-00-00' GROUP BY YEAR(`ddn_inscription`)";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Récupérer les réglements pour une activité
    public function info_getReglements($num) {

        $req = "SELECT * FROM `info_reglements` JOIN `info_inscriptions` ON `info_reglements`.`id_inscription` = `info_inscriptions`.`id_inscription` WHERE `info_reglements`.`id_activite` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Récupérer un réglement pour une activité
    public function info_getUnReglement($num) {

        $req = "SELECT * FROM `info_reglements` WHERE `id_reglement` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Enregistrer un réglement
    public function info_ajouterUnReglement($uneActivite,$uneInscription,$type,$date,$num_transaction,$banque,$montant) {

        $req = "INSERT INTO `info_reglements` VALUES('','$uneInscription','$uneActivite','$type','$date','$num_transaction',UPPER('".addslashes($banque)."'),'$montant');";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Supprimer un réglement
    public function info_supprimerUnReglement($num) {

        $req = "DELETE FROM `info_reglements` WHERE `id_reglement` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
    
    // Vérifier si une inscription Cyberlux existe déjà
    public function info_verifierInscription($num) {

        $req = "SELECT COUNT(*) FROM `info_inscriptions` WHERE `code_cyberlux_inscription` = $num";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		$laLigne = $rs->fetchAll();
		return $laLigne; 
        
    }
}
?>