<?php
class PdoBD
{
    private static $serveur='mysql:host=localhost;port=3306';     
	public static $mdp='';              

	
    public static $stats = 'ys2192-001.eu.clouddb.ovh.net';
	public static $bdd='dbname=ore';
	public static $user='root';             
	
	private static $monPdo;
	private static $monPdoBD=null;
	private static $villeExtranet='quetigny';
	private static $anneeExtranet='2022';

	// Changer la ville pour la BDD
	public function setVilleExtranet($ville) {
		PdoBD::$villeExtranet = $ville;
	}

	public function getVilleExtranet() {
		return PdoBD::$villeExtranet;
	}

	// Changer l'année pour la BDD
	public function setAnneeExtranet($annee) {
		PdoBD::$anneeExtranet = $annee;
	}

	public function getAnneeEnCours()
	{
		return PdoBD::$anneeExtranet;
	}

	//Retourne les numéros de téléphone des élèves
		function getTelephonesEleves()
		{
			$req = "SELECT DISTINCT TÉLÉPHONE_DE_L_ENFANT, parametre.NOM as classe FROM ".PdoBD::$villeExtranet."_eleves
				INNER JOIN ".PdoBD::$villeExtranet."_inscrit ON ".PdoBD::$villeExtranet."_eleves.ID_ELEVE=".PdoBD::$villeExtranet."_inscrit.ID_ELEVE
				INNER JOIN parametre ON ".PdoBD::$villeExtranet."_inscrit.ID_CLASSE=parametre.ID
				WHERE ".PdoBD::$villeExtranet."_inscrit.ANNEE= :annee AND (TÉLÉPHONE_DE_L_ENFANT LIKE '06%' OR TÉLÉPHONE_DE_L_ENFANT LIKE '07%') ORDER BY 2 ASC;";
			
			$params = array(
				":annee" => $_SESSION['anneeExtranet'],
			);

			$rs = $this->ReadAll($req,$params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}

	function getLesBanques()
	{
		$req = "SELECT * FROM banque order by 2 ASC";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

  //Retourne les numéros de téléphone des parents d'élèves
	function getTelephonesParentsEleves()
	{
		$req = "SELECT DISTINCT TÉLÉPHONE_DES_PARENTS, parametre.NOM FROM ".PdoBD::$villeExtranet."_eleves
		INNER JOIN ".PdoBD::$villeExtranet."_inscrit ON ".PdoBD::$villeExtranet."_eleves.ID_ELEVE=".PdoBD::$villeExtranet."_inscrit.ID_ELEVE
		INNER JOIN parametre ON ".PdoBD::$villeExtranet."_inscrit.ID_CLASSE=parametre.ID
		WHERE ".PdoBD::$villeExtranet."_inscrit.ANNEE=:annee AND (TÉLÉPHONE_DES_PARENTS LIKE '06%' OR TÉLÉPHONE_DES_PARENTS LIKE '07%') ORDER BY 2 ASC;";

		$params = array(
			":annee" => $_SESSION['anneeExtranet']
		);
		$rs = $this->ReadAll($req,$params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	//Retourne les numéros de téléphone des intervenants
	function getTelephonesIntervenants($annee)
	{
		$req = "SELECT DISTINCT * FROM intervenants INNER JOIN inscrit_intervenants ON intervenants.ID_INTERVENANT = inscrit_intervenants.ID_INTERVENANT WHERE (inscrit_intervenants.ANNEE = :annee OR inscrit_intervenants.ANNEE = :annee1) AND (TELEPHONE LIKE '07%' OR TELEPHONE LIKE '06%')";
		$params = array(
			':annee' => $annee,
			':annee1' => $annee + 1
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getAnneeParDefaut()
	{

		/*$req = "SELECT NOM
		FROM `parametre`
		WHERE ID='82'
		ORDER by ID;";
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetch();
		$annee=$lesLignes['NOM'];
		return $annee;*/

		$req = "SELECT * FROM `quetigny_inscrit` GROUP BY `ANNEE`;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();

		$array = array ();
		if(count($lesLignes) > 0) {
			foreach($lesLignes as $laLigne) {
		$array[] = $laLigne["ANNEE"];
			}
			$end = end($array);
		}
		return $end;

	}

	private function __construct()
	{
		PdoBD::$monPdo = new PDO(PdoBD::$serveur.';'.PdoBD::$bdd, PdoBD::$user, PdoBD::$mdp);
		PdoBD::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		PdoBD::$monPdo->query("SET CHARACTER SET utf8");
	}


	private function ReadAll($req,$params = array()){
		$stmt = PdoBD::$monPdo->prepare($req);
		if(count($params) > 0){
			foreach($params as $key => $param){
				$stmt->bindValue($key,$param);
			}
		}
		
		if (!$stmt->execute()) return false;

		try {
			$data = $stmt->fetchAll();
			return $data !== false ? $data : [];
		} catch (PDOException $e) {
			return false;
		}
	}

	private function Read($req,$params = array()){
		$stmt = PdoBD::$monPdo->prepare($req);
		foreach($params as $key => $param){
			$stmt->bindValue($key,$param);
		}

		if (!$stmt->execute()) return false;

		try {
			$row = $stmt->fetch();
			return $row !== false ? $row : null;
		} catch (PDOException $e) {
			return false;
		}
	}

	private function NonQuery($req,$params = array()){
		$stmt = PdoBD::$monPdo->prepare($req);
		foreach($params as $key => $param){
			$stmt->bindValue($key,$param);
		}

		return $stmt->execute();
	}

	public function __destruct()
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
		$req = "SELECT MAX(ID_ELEVE) as Maximum from `".PdoBD::$villeExtranet."_eleves` ;";

		$rs = $this->Read($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getfilnotif() {

		$req = "SELECT *  FROM `fil_notif` ORDER BY date_publie DESC";
		
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getUneNotif($notif)
	{
		$req = "SELECT * FROM `fil_notif` where id = :notif";

		$params = array(
			":notif" => $notif
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getfilnotifCible($cible) {

		$req = "SELECT * FROM `fil_notif` WHERE cible LIKE '%:cible%' OR cible LIKE '%public%' ORDER BY date_publie DESC";

		$params = array(
			":cible" => $cible
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function connexionBDD()
	{
		$base = mysql_connect ('mysql51-52.perso', 'associatryagain', 'E2x6q5Li');
		mysql_select_db ('associatryagain', $base);
	}

	public function executerRequete($requete) {

		$req = $requete;
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;

	}

	public function repartitionelevestageterminaleS() {
		$sql="SET @classe = (SELECT NOM FROM parametre where ID = 55); SET @filiere = (SELECT NOM FROM parametre where ID = 60); SET @CF = CONCAT(@classe, ' ', @filiere); SET @nbCF = (SELECT COUNT(*) FROM ELEVE_STAGE INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = 43 AND CLASSE_ELEVE_STAGE = 55 AND FILIERE_ELEVE_STAGE=60);
		";
		$sth = PdoBD::$monPdo->prepare($sql);
		$sth->execute();
		// Run the main query
		$sql = "SELECT @CF as classe_filiere, @nbCF as nbClasse_filiere ;";

		if (isset($var1, $var2)) {
        	$sth = PdoBD::$monPdo->prepare($sql);
        	$sth->execute(array($var1, $var2));
        	return $sth->fetchAll(PDO::FETCH_ASSOC);
    	}
	}

	// Nombre de familles différentes pour une année donnée
	public function nbFamilles($annee) {

		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` WHERE `ANNEE` = :annee GROUP BY `ADRESSE_POSTALE`";

		$params = array(
			":annee" => $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		$nbFamilles = 0;
		foreach($rs as $uneFamille) {
			$nbFamilles++;
		}
		return $nbFamilles;
	}

	// Photos manquantes
	public function photosManquantes($annee) {

		$req = "SELECT COUNT(*) FROM `".PdoBD::$villeExtranet."_eleves` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` WHERE (`PHOTO`='' OR `PHOTO` IS NULL) AND `ANNEE` = :annee";

		$params = array(
			':annee' => $annee
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Emails manquants
	public function emailsManquantes($annee) {

		$req = "SELECT COUNT(*) FROM `".PdoBD::$villeExtranet."_eleves` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` WHERE (`EMAIL_DES_PARENTS`='' OR `EMAIL_DES_PARENTS` IS NULL OR `EMAIL_DES_PARENTS`='a@a' OR `EMAIL_DES_PARENTS`='a@a.fr' OR `EMAIL_DES_PARENTS`='-') AND `ANNEE` = :annee";
		
		$params = array(
			":annee" => $annee
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Tels manquants
	public function telsManquantes($annee) {

		$req = "SELECT COUNT(*) FROM `".PdoBD::$villeExtranet."_eleves` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` WHERE (`TÉLÉPHONE_DES_PARENTS`='' OR `TÉLÉPHONE_DES_PARENTS` IS NULL OR `TÉLÉPHONE_DES_PARENTS`='0' OR `TÉLÉPHONE_DES_PARENTS`='0000000000' OR `TÉLÉPHONE_DES_PARENTS`='-') AND `ANNEE` = :annee";

		$params = array(
			':annee'=>$annee
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Adresses manquants
	public function adressesManquantes($annee) {

		$req = "SELECT COUNT(*) FROM `".PdoBD::$villeExtranet."_eleves` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` WHERE (`ADRESSE_POSTALE`='' OR `ADRESSE_POSTALE` IS NULL OR `ADRESSE_POSTALE`='-') AND `ANNEE` = :annee";

		$params = array(
			':annee' => $annee
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Nombre d'élèves pour une année donnée
	public function nbEleves($annee) {

		$req = "SELECT COUNT(*) FROM `".PdoBD::$villeExtranet."_inscrit` WHERE `ANNEE` = :annee";

		$params = array(
			':annee'=>$annee
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Nombre d'élèves pour une année donnée
	public function nbElevesMemeDateAnneeDerniere($annee,$date) {
		$req = "SELECT COUNT(*) FROM `".PdoBD::$villeExtranet."_inscrit` WHERE `ANNEE` = :annee AND `DATE_INSCRIPTION` <= :date";

		$params = array(
			':annee'=> $annee,
			':date'=> $date
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Présences des élèves pour une année donnée
	public function nbPresencesEleves($annee) {
		
		$req = "SELECT COUNT(*), `SEANCE` FROM `".PdoBD::$villeExtranet."_appel` WHERE `".PdoBD::$villeExtranet."_appel`.`ID_ELEVE` != '' AND `SEANCE` > :annee1 AND `SEANCE` < :annee2 GROUP BY `SEANCE`";
		//$rs = PdoBD::$monPdo->query($req);
		$annee2 = $annee+1;

		$params = array(
			':annee1' => $annee.'-09-01',
			':annee2' => $annee2.'-07-30'
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Paiements des élèves pour une année donnée
	public function nbElevesPayes($annee) {
		$req="SELECT COUNT(*) FROM  `".PdoBD::$villeExtranet."_reglements` WHERE `MONTANT` >='16' AND `DATE_REGLEMENT` BETWEEN  :annee1 AND :annee2";
		$annee2 = $annee+1;

		$params = array(
			':annee1' => $annee.'-08-01',
			':annee2' => $annee2.'-07-30'
		);

		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Inscriptions des élèves pour une année donnée
	public function nbInscriptionsEleves($annee) {
		
		//$req = "SELECT `DATE_INSCRIPTION`,COUNT(*) FROM `".PdoBD::$villeExtranet."_inscrit` WHERE `ANNEE` = :annee GROUP BY `DATE_INSCRIPTION`";
		$req =" SELECT `DATE_INSCRIPTION`,COUNT(*) FROM `".PdoBD::$villeExtranet."_inscrit` WHERE `DATE_INSCRIPTION` BETWEEN :annee1 AND :annee2  GROUP BY MONTH(`DATE_INSCRIPTION`) ORDER BY `DATE_INSCRIPTION`ASC;";
		$annee2 = $annee+1;
		$params = array(
			//':annee' => $annee
			':annee1' => $annee.'-08-01',
			':annee2' => $annee2.'-07-30'
		);

		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getdocseleves() {

		$req = "SELECT *, docsEleves.id as 'IDPOLYCOP' FROM `docsEleves` LEFT OUTER JOIN CategorieDocs ON docsEleves.ID_CATEGDOC = CategorieDocs.ID ORDER BY dateMiseEnLigne DESC ";
		$rs = $this->ReadAll($req);

		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getcategoriesdocseleves() {

		$req = "SELECT * FROM CategorieDocs";
		$rs = $this->ReadAll($req);

		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function ajoutdocseleves($nom, $commentaires, $fichier, $corrige, $date, $classe, $photo, $type, $categorie, $valide) {

		$req = "INSERT INTO `docsEleves` (`id`, `nom`, `Commentaires`, `urlfichier`, `urlcorrige`, `dateMiseEnLigne`, `Classe`, `urlphoto`, `Type`, `NBDOWNLOAD`, `ID_CATEGDOC`, `valide`) VALUES (NULL, :nom, :commentaires, :fichier, :corrige, :date, :classe, :photo, :type, '0', :categorie, :valide)";

		$params = array(
			':nom' => $nom,
			':commentaires' => $commentaires,
			':fichier' => $fichier,
			':corrige' => $corrige,
			':date' => $date,
			':classe' => $classe,
			':photo' => $photo,
			':type' => $type,
			':categorie' => $categorie,
			':valide' => $valide
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function modifierdocseleves($id, $nom, $commentaires, $date, $classe, $type, $categorie, $valide) {
		$req = "UPDATE docsEleves SET `nom` = :nom, `Commentaires` = :commentaires, `dateMiseEnLigne` = :date, `Classe` = :classe, `Type` = :tyoe, `ID_CATEGDOC` = :categorie, `valide` = :valide  WHERE id = :id";

		$params = array(
			':id'=>$id,
			':nom'=>$nom,
			':commentaires'=>$commentaires,
			':date'=>$date,
			':classe'=>$classe,
			':type'=>$type,
			':categorie'=>$categorie,
			':valide'=>$valide
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function supprimerdocseleves($id) {

		$req = "DELETE FROM `docsEleves` WHERE id=:id";

		$params = array(
			':id' => $id
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'élève ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function ajouterNotification($libelle, $date_publie, $date_evenement, $cible, $auteur) {

		$req = "INSERT INTO `fil_notif` (`libelle`, `date_publie`, `date_evenement`, `cible`, `auteur`) VALUES (:libelle,:date_publie, :date_evenement, :cible, :auteur)";

		$params = array(
			':libelle' => $libelle,
			':date_publie' => $date_publie,
			':date_evenement' => $date_evenement,
			':cible' => $cible,
			':auteur' => $auteur
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function modifierNotification($id, $libelle, $date_evenement, $cible) {
		$req= "UPDATE fil_notif SET libelle = :libelle, date_evenement = :date_evenement, cible = :cible  WHERE id = :id";

		$params = array(
			':id' => $id,
			':libelle' => $libelle,
			':date_evenement' => $date_evenement,
			':cible' => $cible
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout des polycopiés ..", $req, PdoBD::$monPdo->errorInfo());}
	}
	
	public function supprimerNotification($id) {

		$req = "DELETE FROM `fil_notif` WHERE `id` = :id";

		$params = array(
			':id' => $id
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression d'une notification ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	// Inscriptions des élèves pour une année donnée
	public function nbHeuresPresencesScolaireEleves($annee,$ville,$num) {
		$annee = (int)$annee;
		$req = "SELECT (COUNT(*) * $num) AS total FROM `".$ville."_appel` WHERE `SEANCE` >= :anneeA AND `SEANCE` <= :anneeB AND `ID_ELEVE` > 0";
		$annee1 = $annee."-09-01";
		$annee2 = ($annee+1)."-08-01";

		$params = array(
			':anneeA' => $annee1,
			':anneeB' => $annee2
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Inscriptions des élèves pour une année donnée
	public function nbHeuresPresencesScolaireIntervenants($annee) {

		$req = "SELECT SUM(`HEURES`) AS total FROM `".PdoBD::$villeExtranet."_appel` WHERE `SEANCE` >= :annee1 AND `SEANCE` <= :annee2-08-01 AND `ID_INTERVENANT` > 0";

		$params = array(
			':annee1' => $annee."-09-01",
			':annee2' => ($annee+1)."-08-01"
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Inscriptions des élèves pour une année donnée
	public function nbHeuresPresencesStageEleves($num) {

		$req = "SELECT COUNT(*) AS total FROM `PRÉSENCES_STAGE` JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` = `PRÉSENCES_STAGE`.`ID_INSCRIPTIONS` WHERE `ID_STAGE` = :num";
		
		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Inscriptions des élèves pour une année donnée
	public function nbHeuresPresencesRdvBsb($annee) {

		$req = "SELECT SUM(`DUREE`) AS total FROM `".PdoBD::$villeExtranet."_rdvparents` WHERE `BSB` = 1 AND `DATE_RDV` >= :anneeA AND `DATE_RDV` <= :anneeB";
		//$rs = PdoBD::$monPdo->query($req);

		$params = array(
			':anneeA' => $annee."-09-01", 
			':anneeB' => ($annee+1)."-08-01"
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Paiements des élèves pour une année donnée
	public function nbPayesEleves($annee) {

		$req = "";
		$rs = PdoBD::$monPdo->query($req);

		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Présences des intervenants pour une année donnée
	public function nbPresencesIntervenants($annee) {

		$req = "SELECT COUNT(*), `SEANCE` FROM `".PdoBD::$villeExtranet."_appel` WHERE `".PdoBD::$villeExtranet."_appel`.`ID_INTERVENANT` != '' AND `SEANCE` > :annee1 AND `SEANCE` < :annee2 GROUP BY `SEANCE`";

		$params = array(
			':annee1' => $annee."-09-01",
			':annee2' => ($annee + 1)."-07-30"
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Nombre d'élèves par filière pour une année donnée
	public function nbElevesParFiliere($annee) {

		$req = "SELECT COUNT(*),`parametre`.`NOM`,`ID_CLASSE` FROM `".PdoBD::$villeExtranet."_inscrit` JOIN `parametre` ON `".PdoBD::$villeExtranet."_inscrit`.`ID_FILIERES` = `parametre`.`ID` WHERE ANNEE = :annee AND `ID_CLASSE` > 54 GROUP BY `ID_FILIERES`,`ID_CLASSE`";
		//$rs = PdoBD::$monPdo->query($req);

		$params = array(
			':annee' => $annee 
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	// Nombre d'élèves par classe pour une année donnée
	public function nbElevesParClasse($annee) {

		$req = "SELECT COUNT(*),`parametre`.`NOM` FROM `".PdoBD::$villeExtranet."_inscrit` JOIN `parametre` ON `".PdoBD::$villeExtranet."_inscrit`.`ID_CLASSE` = `parametre`.`ID` WHERE ANNEE = :annee GROUP BY `ID_CLASSE`";

		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Nombre d'élèves par sexe pour une année donnée
	public function nbElevesParVille($annee) {

		$req = "SELECT COUNT(*),`VILLE` FROM `".PdoBD::$villeExtranet."_eleves` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` WHERE `ANNEE` = :annee GROUP BY `VILLE` ORDER BY COUNT(*) DESC LIMIT 0,5";

		$params = array(
			':annee' => $annee
		);

		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}
	//Nombre d'élèves inscrit trié par établissement pour une année donnée
	public function nbElevesParEtablissement($annee){
		$req = "SELECT COUNT(*), `parametre`.`NOM`
		FROM `eleve_stage` 
		JOIN `".PdoBD::$villeExtranet."_inscrit` 
		ON `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` = `eleve_stage`.`ID_ELEVE_STAGE`
		JOIN `parametre` 
		ON `parametre`.`ID` = `eleve_stage`.`ETABLISSEMENT_ELEVE_STAGE`
		WHERE `DATE_INSCRIPTION`
		BETWEEN :annee AND :annee2
		GROUP BY `parametre`.`NOM` 
		ORDER BY COUNT(*) DESC LIMIT 0,6";
		$annee2 = $annee+1;
		$params = array 
		(
			':annee' => $annee.'-09-01',
			':annee2' => $annee2.'-07-30'
			);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des établissements ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Nombre d'élèves par sexe pour une année donnée
	public function nbElevesParSexe($annee) {

		$req = "SELECT COUNT(*),`SEXE` FROM `".PdoBD::$villeExtranet."_eleves` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` WHERE `ANNEE` = :annee GROUP BY `SEXE`";

		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}
	//Nombre de filles et de garçons par classe 
	public function nbSexeParClasse($annee){
	$req = "SELECT COUNT(*), `parametre`.`NOM` AS Classes,
	SUM(CASE WHEN `".PdoBD::$villeExtranet."_eleves`.`SEXE` = 'f' THEN 1 ELSE 0 END) AS Filles,
	SUM(CASE WHEN `".PdoBD::$villeExtranet."_eleves`.`SEXE` = 'h' THEN 1 ELSE 0 END) AS Garcons
	FROM `".PdoBD::$villeExtranet."_inscrit` 
	JOIN `parametre`ON `".PdoBD::$villeExtranet."_inscrit`.`ID_CLASSE` = `parametre`.`ID` 
	JOIN `".PdoBD::$villeExtranet."_eleves`ON `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE`= `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE`
	WHERE ANNEE = :annee
	GROUP BY `ID_CLASSE`, `parametre`.`NOM`;";

	$params = array(
		':annee' => $annee
	);
	$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	public function nbFamillesAvecRdv($bsb,$annee) {
		$date = date("Y-m-d");
		$req = "SELECT DISTINCT `ADRESSE_POSTALE`,COUNT(*) FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_inscrit`.ID_ELEVE INNER JOIN `".PdoBD::$villeExtranet."_rdvparents` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_rdvparents`.ID_ELEVE WHERE ANNEE = :annee AND `".PdoBD::$villeExtranet."_rdvparents`.DATE_RDV < '$date' AND `".PdoBD::$villeExtranet."_rdvparents`.BSB = $bsb";
		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Nombre de familles pour une année donnée
	public function nbFamillesMemeDateAnneeDerniere($annee,$date) {

		$req = "SELECT COUNT(DISTINCT `ADRESSE_POSTALE`) FROM `".PdoBD::$villeExtranet."_inscrit` JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` WHERE `ANNEE` = :annee AND `DATE_INSCRIPTION` <= :date";

		$params = array(
			':annee' => $annee,
			':date' => $date
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getAnneesScolaires2()
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_inscrit` GROUP BY `ANNEE`;";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function executerRequete2($requete) {
		$req = $requete;
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la requete ..", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes;
	}

	public function executerRequete3($req) {
		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la requete ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	/*
	Années des intervenants
	*/
	public function ajoutAnneeIntervenant($num,$annee) {

		$req = "INSERT INTO `inscrit_intervenants`(`ID_INTERVENANT`, `ANNEE`) VALUES (:num,:annee)";

		$params = array(
			':num' => $num,
			':annee' => $annee
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion de l\'année..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}
	}


	/*
	Reglements
	*/
	public function recupTousReglements($nom,$type) {
		if($type === 'tout') {
			$req = "SELECT * FROM `".PdoBD::$villeExtranet."_reglements` WHERE `NOMREGLEMENT` = :nom";
			$params = array(
				':nom' => $nom
			);
		} else {
			$req = "SELECT * FROM `".PdoBD::$villeExtranet."_reglements` WHERE `NOMREGLEMENT` = :nom AND ID_TYPEREGLEMENT = :type";
			$params = array(
				':nom' => $nom,
				':type' => $type
			);
		}
		
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	public function nomsParCheque($num) {
		$req = "SELECT `NOMREGLEMENT` FROM `".PdoBD::$villeExtranet."_reglements` WHERE `NUMTRANSACTION` = :num AND `ID_TYPEREGLEMENT` = 1 GROUP BY `NOMREGLEMENT`";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	public function lesAbsents($num) {

		$req = "";

		$rs = PdoBD::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		$lesLignes= $rs->fetchAll();
		return $lesLignes;
	}


	public function recupNomsParNumCheque($num) {
		$req = "SELECT `NOM`,`PRENOM`,SUM(MONTANT) as `total` FROM `".PdoBD::$villeExtranet."_reglements` INNER JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_reglements`.ID_ELEVE = `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE `NUMTRANSACTION` = :num";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	/* -------------------------------------------- STAGES DE REVISION ------------------------------------------------- */


	/*
	Associer un partenaire stage
	*/
	public function LesPartenairesAssocier($partenaire,$numStage) {

		$req = "INSERT INTO `STAGE_PARTENAIRES`(`ID_PARTENAIRES`, `ID_STAGE`) VALUES ('$partenaire','$numStage')";

		$params = array(
			':partenaire' => $partenaire,
			':numStage' => $numStage
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion du partenaire..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}

	}


	/*
	Associer un partenaire stage
	*/
	public function LesIntervenantsAssocier($intervenant,$numStage) {

		$req = "INSERT INTO `INTERVIENT_STAGE`(`ID_STAGE`, `ID_INTERVENANT`) VALUES(:numStage,:intervenant)";

		$params = array(
			':numStage' => $numStage,
			':intervenant' => $intervenant
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion du intervenat..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}


		$req2 = "SELECT * FROM intervenants WHERE ID_INTERVENANT = :intervenant";

		$params2 = array(
			':intervenant'=>$intervenant
		);

		$rs2 = $this->Read($req2,$params2);
		if ($rs2 === false) {afficherErreurSQL("Probleme lors de l\'insertion du intervenat..<br>Peut être en doublon ?", $req2, PdoBD::$monPdo->errorInfo());}


$i = $rs2["ID_INTERVENANT"];
$n = $rs2["NOM"];
$p = $rs2["PRENOM"];
$e = $rs2["EMAIL"];
$t = $rs2["TELEPHONE"];

		$req3 = "INSERT INTO `INTERVENANT_STAGE` VALUES (:numStage , :i, :n,:p,:e,:t)";

		$params3 = array(
			':numStage'=> $numStage,
			':i' => $i,
			':n' => $n,
			':p' => $p,
			':e' => $e,
			':t' => $t
		);
		$rs3 = $this->NonQuery($req3,$params3);
		if ($rs3 === false) {afficherErreurSQL("Probleme lors de l\'insertion du intervenat..<br>Peut être en doublon ?", $req3, PdoBD::$monPdo->errorInfo());}

	}


	/*
	Dissocier un partenaire stage
	*/
	public function LesPartenairesDissocier($partenaire,$numStage) {

		$req = "DELETE FROM `STAGE_PARTENAIRES` WHERE `ID_PARTENAIRES` = :partenaire AND `ID_STAGE` = :numStage";

		$params = array(
			':partenaire'=> $partenaire,
			'numStage' => $numStage
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du partenaire..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}

	}

	/*
	Supprimer un partenaire stage
	*/
	public function LesPartenairesSupprimer($partenaire) {

		$req = "SELECT * FROM `STAGE_PARTENAIRES` WHERE `ID_PARTENAIRES` = :partenaire;
		DELETE FROM `PARTENAIRES_STAGE` WHERE `ID_PARTENAIRES` = :partenaire";
		//$rs = PdoBD::$monPdo->query($req);

		$params = array(
			':partenaire'=>$partenaire
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du partenaire..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}

	}


	/*
	Dissocier un intervenant stage
	*/
	public function LesIntervenantsDissocier($intervenant,$numStage) {

		$req = "DELETE FROM `INTERVIENT_STAGE` WHERE `ID_INTERVENANT` = :intervenant AND `ID_STAGE` = :numStage";

		$params = array(
			':intervenant'=>$intervenant,
			':numStage' => $numStage
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du intervenant..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}

		$req2 = "DELETE FROM `INTERVENANT_STAGE` WHERE `ID_INTERVENANT` = '$intervenant' AND `ID_STAGE` = '$numStage'";

		$params2 = array(
			':intervenant'=>$intervenant,
			':numStage' => $numStage
		);
		$rs2 = $this->NonQuery($req2,$params2);
		if ($rs2 === false) {afficherErreurSQL("Probleme lors de la suppression du intervenant..<br>Peut être en doublon ?", $req2, PdoBD::$monPdo->errorInfo());}
	}


	/*
	Supprimer un intervenant stage
	*/
	public function supprimerIntervenantStage($num) {

		$req = "DELETE FROM `INTERVIENT_STAGE` WHERE `ID_INTERVENANT` = :num;
		DELETE FROM `INTERVENANT_STAGE` WHERE `ID_INTERVENANT` = :num";

		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression du intervenant..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}

	}

	/*
	Ajouter un atelier
	*/
	public function ajouterUnAtelier($numStage,$nom,$nbmax,$niveau,$description,$photo,$groupe) {

		$req = "INSERT INTO `ATELIERS_LUDIQUES`(`ID_STAGE`, `NOM_ATELIERS`, `IMAGE_ATELIERS`, `DESCRIPTIF_ATELIERS`, `NBMAX_ATELIERS`, `NIVEAU_ATELIER`,`GROUPE_ATELIER`) VALUES (:numStage,:nom,:photo,:description,:nbmax,:niveau,:groupe)";
		//$rs = PdoBD::$monPdo->query($req);

		$params = array(
			':numStage'=>$numStage,
			':nom' => $nom,
			':nbmax' => $nbmax,
			':niveau' => $niveau,
			':description' => $description,
			':photo' => $photo,
			':groupe' => $groupe
		);

		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion de l\'année..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}

	}


	/*
	Ajouter un groupe
	*/
	public function ajouterGroupe($numStage,$nbmax,$salles,$nom) {

		$req = "INSERT INTO `GROUPE_STAGE`(`ID_STAGE`, `NBMAX_GROUPE`, `SALLES_GROUPE`, `NOM_GROUPE`) VALUES (:numStage,:nbmax,:salles,:nom)";

		$params = array(
			':numStage'=> $numStage,
			':nbmax'=>$nbmax,
			':salles'=>$salles,
			':nom'=> addslashes($nom)
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion du groupe..<br>Peut être en doublon ?", $req, PdoBD::$monPdo->errorInfo());}

	}

	/*
	Présences stage
	*/
	public function ajouterPresencesStage($numStage,$date,$matinouap,$presences) {
		
		foreach($presences as $unePresence) {
			    $req = '';
				$req = "INSERT INTO `PRÉSENCES_STAGE`(`ID_PRESENCE`, `ID_INSCRIPTIONS`, `DATE_PRESENCE`, `MATINOUAP`) VALUES ('',:unePresence,:date,:matinouap);";
				$params = array(
					':unePresence'=>$unePresence,
					':date' => $date,
					':matinouap' => $matinouap
				);
				$rs = $this->NonQuery($req,$params);
				if ($rs === false) {afficherErreurSQL("Probleme lors de l\'insertion des presences", $req, PdoBD::$monPdo->errorInfo());}
		
		}

		
	}

	public function getAnneesIntervenants($num) {
		$req = "SELECT * FROM `inscrit_intervenants` WHERE `ID_INTERVENANT` = :num";

		$params = array(
			':num'=>$num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annes de l\'intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function supprimerAnneeIntervenant($num,$annee) {

		$req = "DELETE FROM `inscrit_intervenants` WHERE `ID_INTERVENANT` = :num AND `ANNEE` = :annee";

		$params = array(
			':num' => $num,
			':annee'=> $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des annes de l\'intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;

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
			$req = "UPDATE `intervenants` SET :champ ='' WHERE `ID_INTERVENANT` = :num";
			//$rs = PdoBD::$monPdo->query($req);

			$params = array(
				':champ' => $champ,
				':num' => $num
			);
			$rs = $this->NonQuery($req,$params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture de l\'intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		}
	}

	/**
	* Retourne le numéro ID max de la table remise CAF
	*/
	public function maxNumRemiseCaf()
	{
		$req = "SELECT MAX(`ID`) as max FROM `remisecaf`;";
		$rs = $this->Read($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	/**
	* Retourne le numéro ID max de la table remise cheque
	*/
	public function maxNumRemiseCheque()
	{
		$req = "SELECT MAX(`ID`) as max FROM `remisecheque`;";

		$rs = $this->Read($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// recupere les presences d'un intervenant
	public function getPresenceDunIntervenant($num)
	{
		$req = "SELECT  `DATE_PRESENCE` FROM `".PdoBD::$villeExtranet."_presence` WHERE `ID_INTERVENANT`=:num";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des présence dun intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// recupere les  intervenant stage
	public function recupIntervenantsStage($num)
	{
		$req = "SELECT INTERVENANT_STAGE.ID_STAGE as ID_STAGE, INTERVENANT_STAGE.ID_INTERVENANT as ID_INTERVENANT, NOM_INTERVENANT, PRENOM_INTERVENANT, EMAIL_INTERVENANT, TEL_INTERVENANT, HEURES FROM `INTERVENANT_STAGE` LEFT JOIN `INTERVIENT_STAGE` ON `INTERVENANT_STAGE`.`ID_INTERVENANT` = `INTERVIENT_STAGE`.`ID_INTERVENANT` AND `INTERVENANT_STAGE`.`ID_STAGE` = `INTERVIENT_STAGE`.`ID_STAGE` WHERE `INTERVENANT_STAGE`.`ID_STAGE` = :num
		order by NOM_INTERVENANT";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des présence dun intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// recupere les  intervenant stage
	public function recupIntervenantIntervientStage($num, $intervenant)
	{
		$req = "SELECT * FROM `INTERVIENT_STAGE` WHERE ID_STAGE = 22 AND ID_INTERVENANT = 4";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intervenants présents aux stages ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// recupere les  intervenant stage
	public function recupIntervenantsStageTout()
	{
		$req = "SELECT * FROM `INTERVENANT_STAGE` WHERE 1";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des présence dun intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getLesReglements($dateDebut, $dateFin, $type) {
        $params = array(
            ':debut' => $dateDebut,
            ':fin' => $dateFin
        );
		if ($type == 0) {
			$req = "SELECT * FROM `".PdoBD::$villeExtranet."_reglements` WHERE DATE_REGLEMENT BETWEEN '$dateDebut' AND '$dateFin' AND (ID_TYPEREGLEMENT = 1 OR ID_TYPEREGLEMENT = 151) ORDER BY DATE_REGLEMENT DESC";
		} else {
			$req = "SELECT * FROM `".PdoBD::$villeExtranet."_reglements` WHERE DATE_REGLEMENT BETWEEN '$dateDebut' AND '$dateFin' AND ID_TYPEREGLEMENT = $type ORDER BY DATE_REGLEMENT DESC";
            $params[':type'] = $type;
		}
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {
			afficherErreurSQL("Probleme lors de la lecture des reglements ..", $req, PdoBD::$monPdo->errorInfo());
		}
		return $rs;
	}

	// recupere les journaux caf
	public function getLesJournauxCAF()
	{
		$req = "SELECT CONCAT( 'Du ', date_format(min( date( DATE_REGLEMENT ) ), '%d/%m/%Y') , ' au ', date_format(max( date( DATE_REGLEMENT ) ), '%d/%m/%Y') ) AS date, ID_APPARTIENT_RCAF
		FROM `".PdoBD::$villeExtranet."_reglements`
		Where ID_TYPEREGLEMENT=3
		GROUP BY ID_APPARTIENT_RCAF;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des noms de médecin ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne la table type
	*/
	public function returnLesTypes()
	{
		$req = "SELECT `ID`, `NOM` FROM `type`;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des types ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne la table parametre
	*/
	public function returnParametre($typeNum)
	{
		$req = "SELECT `parametre`.ID as IDPARA, `type`.NOM as NOMTYPE, `parametre`.NOM as NOMPARA, `NIVEAU`,`VALEUR` FROM `parametre` INNER JOIN `type` ON `parametre`.ID_AVOIR=`type`.ID where ID_AVOIR=:typeNum ORDER BY `parametre`.ID, `type`.NOM  ;";

		$params = array(
			':typeNum'=>$typeNum
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des parametres...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne le numéro de l'eleve selon son codebarre
	*/
	public function returnNumEleve($codebarre)
	{
		$req = "SELECT ID_ELEVE from `".PdoBD::$villeExtranet."_eleves` where CODEBARRETEXTE=:codebarre;";

		$params = array(
			':codebarre' => $codebarre
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un intervenant selon le ID
	*/
	public function recupUnIntervenant($num)
	{
		$req = "SELECT * FROM `intervenants` where ID_INTERVENANT=:num;";

		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un intervenant selon le ID
	*/
	public function recupUnIntervenantsParStatut($num)
	{
		$req = "SELECT * FROM `intervenants` where STATUT='$num';";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un stage selon le ID
	*/
	public function recupStage($num)
	{
		$req = "SELECT * FROM `STAGE_REVISION` where ID_STAGE=:num;";

		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupStageActifs()
	{
		$req = "SELECT * FROM `STAGE_REVISION`";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

		public function recupPlateformeeleves()
		{ 
			$req = "SELECT * FROM `plateformes`";

			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}

		public function ajoutPlateformeeleves($nom, $logo, $url, $login,$mdp, $commentaires)
		{
			$req = "INSERT INTO `plateformes` (`id`, `nom`, `logo`, `url`, `login`, `mdp`, `commentaires`) VALUES (NULL,:nom,:logo,:url,:login,:mdp,:commentaires) ";

			$params = array(
				':nom' => $nom,
				':logo' => $logo,
				':url' => $url,
				':login' => $login,
				':mdp' => $mdp,
				'commentaires' => $commentaires
			);
			$rs = $this->NonQuery($req,$params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion d'une plateforme ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}

		public function modifPlateformeeleves($id, $nom, $url, $login,$mdp, $commentaires)
		{
			$req = "UPDATE plateformes SET `nom` = :nom, `url` = :url, `login` = :login, `mdp` = :mdp, `commentaires` = :commentaires WHERE id = :id";

			$params = array(
				':id'=>$id,
				':nom'=>$nom,
				':url'=>$url,
				':login'=>$login,
				':mdp'=>$mdp,
				':commentaires'=>$commentaires
			);
			$rs = $this->NonQuery($req,$params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la modification d'une plateforme ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}

		public function supprimerplateformeeleves($id)
		{
			$req = "DELETE FROM `plateformes` WHERE id=:id";

			$params = array(
				':id' => $id
			);
			$rs = $this->NonQuery($req,$params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression d'une plateforme ..", $req, PdoBD::$monPdo->errorInfo());}
		}

	/**
	* Retourne les partenaires
	*/
	public function recupPartenaires($num)
	{
		$req = "SELECT * FROM `PARTENAIRES_STAGE` INNER JOIN `STAGE_PARTENAIRES` ON `PARTENAIRES_STAGE`.ID_PARTENAIRES = `STAGE_PARTENAIRES`.ID_PARTENAIRES where ID_STAGE=:num;";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les partenaires
	*/
	public function recupPartenairesTout()
	{
		$req = "SELECT * FROM `PARTENAIRES_STAGE`";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un lieu selon le ID
	*/
	public function recupLieu($num)
	{
		$req = "SELECT * FROM `LIEUX_STAGE` where ID_LIEU=:num;";

		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du lieu ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne tous les ateliers d'un stage pour l'inscription
	*/
	public function recupAteliers($num)
	{
		$req = "Select * FROM `ATELIERS_LUDIQUES` WHERE `ID_STAGE` = :num AND (SELECT COUNT(*) FROM `INSCRIPTIONS_STAGE` WHERE `ID_ATELIERS` = :num) < `NBMAX_ATELIERS` ORDER BY `GROUPE_ATELIER`";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne tous les ateliers d'un stage
	*/
	public function recupAteliersStage($num)
	{
		$req = "Select * FROM `ATELIERS_LUDIQUES` WHERE `ID_STAGE` = :num";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Change un atelier
	*/
	public function changerAtelierEleve($id_inscription,$id_atelier,$id_ancien_atelier)
	{
		$req = "UPDATE `STAGE_PARTICIPE` SET `ID_ATELIER`=:id_atelier WHERE `ID_INSCRIPTION` = :id_inscription AND `ID_ATELIER` = :id_ancien_atelier";

		$params = array(
			':id_inscription' => $id_inscription,
			':id_atelier' => $id_atelier,
			'id_ancien_atelier' => $id_ancien_atelier
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Change un atelier
	*/
	public function ajouterAtelierEleve($id_inscription,$id_atelier)
	{
		$req = "INSERT INTO `STAGE_PARTICIPE`(`ID_INSCRIPTION`, `ID_ATELIER`) VALUES (:id_inscription,:id_atelier);";

		$params = array(
			'id_inscription' => $id_inscription,
			':id_atelier' => $id_atelier	
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Recupère les groupes d'atelier
	*/
	public function lesGroupesAtelier($num)
	{
		$req = "SELECT DISTINCT `GROUPE_ATELIER` FROM `ATELIERS_LUDIQUES` WHERE `ID_STAGE` = :num";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Valide un élève
	*/
	public function changerValiderEleve($id_inscription,$valide)
	{
		$req = "UPDATE `INSCRIPTIONS_STAGE` SET `VALIDE`=:valide WHERE `ID_INSCRIPTIONS`= :id_inscription";

		$params = array(
			':valide' => $valide,
			':id_inscription' => $id_inscription
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function FaireSauvegarde() {

		$mysqli = new mysqli("mysql51-52.perso", "associatryagain", "E2x6q5Li","associatryagain");

		// Check connection
		if ($mysqli -> connect_errno) {
		  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		  exit();
		}

		$db = mysqli_select_db ( $mysqli , "associatryagain" );
		$tables = '*';

		//get all of the tables
		if($tables == '*')
		{
		  $tables = array();
		  $result = mysqli_query($mysqli, 'SHOW TABLES');
		  while($row = mysqli_fetch_row($result))
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
		  $result = mysqli_query($mysqli, 'SELECT * FROM '.$table);
		  $num_fields = mysqli_num_fields($result);

		  $return.= 'DROP TABLE '.$table.';';
		  $row2 = mysqli_fetch_row(mysqli_query( $mysqli, 'SHOW CREATE TABLE '.$table));
		  $return.= "\n\n".$row2[1].";\n\n";

		  for ($i = 0; $i < $num_fields; $i++)
		  {
		    while($row = mysqli_fetch_row($result))
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

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne le nb d'un les ateliers
	*/
	public function nbInscritsAtelier()
	{
		$req = "SELECT * FROM `STAGE_PARTICIPE` JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` = `STAGE_PARTICIPE`.`ID_INSCRIPTION`";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des ateliers ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne tous les partenaires d'un stage
	*/
	public function recupPartenairesStage($num)
	{
		$req = "Select * FROM `PARTENAIRES_STAGE` INNER JOIN `STAGE_PARTENAIRES` ON `PARTENAIRES_STAGE`.`ID_PARTENAIRES` = `STAGE_PARTENAIRES`.`ID_PARTENAIRES` WHERE `STAGE_PARTENAIRES`.`ID_STAGE` = :num";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des partenaires ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne tous les evenements
	*/
	public function recupEvenementApresDateNow()
	{
		$req = "Select  `NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER` FROM `evenements`  WHERE DATEFIN >= CURRENT_DATE";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne tous les evenements apres ojd
	*/
	public function recupEvenement()
	{
		$req = "Select  `NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER` FROM `evenements`";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un evenements
	*/
	public function recupUnEvenement($num)
	{
		$req = "Select `NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER` FROM `evenements` where NUMÉROEVENEMENT=:num";

		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les intervenants présent  a une date donner
	*/
	public function recupIntervenants($date)
	{
		$req = "SELECT `intervenants`.ID_INTERVENANT,NOM,PRENOM FROM `intervenants` inner join `".PdoBD::$villeExtranet."_presence` ON `intervenants`.ID_INTERVENANT=`".PdoBD::$villeExtranet."_presence`.ID_INTERVENANT
		where DATE_PRESENCE=:date AND VALIDER=1;";

		$params = array(
			':date' => $date
		);
		$rs = $this->ReadAll($req,$params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de la recupération des intervenants ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les intervenants présent  a une date donner
	*/
	public function recupIntervenantsSansValider($date)
	{
		$req = "SELECT `intervenants`.ID_INTERVENANT,NOM,PRENOM FROM `intervenants` inner join `".PdoBD::$villeExtranet."_presence` ON `intervenants`.ID_INTERVENANT=`".PdoBD::$villeExtranet."_presence`.ID_INTERVENANT
		where DATE_PRESENCE=:date ;";

		$params = array(
			':date' => $date
		);
		$rs = $this->ReadAll($req,$params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de la recupération des intervenants ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les intervenants
	*/
	public function recupTousIntervenants()
	{
		$req = "SELECT * FROM `intervenants` order by NOM;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intevenants ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les intervenants
	*/
	public function recupTousIntervenantsParStatut()
	{
		$req = "SELECT * FROM `intervenants` order by NOM ORDER BY ;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intevenants ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupTousIntervenantsAnneeEnCours($annee)
	{
		$req = "SELECT * FROM `intervenants` INNER JOIN `inscrit_intervenants` ON `intervenants`.`ID_INTERVENANT`=`inscrit_intervenants`.`ID_INTERVENANT` WHERE ANNEE = :annee ORDER BY NOM;";

		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intevenants ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupTousIntervenantsAnneeEnCoursParStatut($annee)
	{
		$req = "SELECT * FROM `intervenants` INNER JOIN `inscrit_intervenants` ON `intervenants`.`ID_INTERVENANT`=`inscrit_intervenants`.`ID_INTERVENANT` WHERE ANNEE = :annee AND STATUT != 'Service Civique' ORDER BY STATUT,NOM;";

		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intevenants ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	//récupère l'identifiant google d'un rendez-vous en fonction du rendez-vous choisi
	public function recupRdvIdGoogle($num)
	{
		$req = "SELECT idgoogle FROM `".PdoBD::$villeExtranet."_rdvparents` where ID_RDV = :num";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupRdvParents($annee)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_rdvparents` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_rdvparents`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` WHERE `BSB` = FALSE AND `ANNEE` = :annee ORDER BY `DATE_RDV`;";

		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupRdvParentsDate($date)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_rdvparents` WHERE `BSB` = FALSE AND DATE(`DATE_RDV`) = :date ORDER BY `DATE_RDV`;";

		$params = array(
			':date' => $date
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupRdvBsb($annee)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_rdvparents` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_rdvparents`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_rdvparents`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_eleves`.`ID_ELEVE` WHERE `BSB` = TRUE AND `ANNEE` = 2020 ORDER BY `DATE_RDV`;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupRdvBsbSemaine()
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_rdvparents` WHERE WEEK(`DATE_RDV`) = WEEK(NOW()) AND YEAR(`DATE_RDV`) = YEAR(NOW()) AND `BSB` = TRUE ORDER BY `DATE_RDV`";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un parametre
	*/
	public function returnUnParametre($num)
	{
		$req = "SELECT `ID`, `ID_AVOIR`, `NOM`, `NIVEAU` FROM `parametre` WHERE ID=:num;";

		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du parametre ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les élèves
	*/
	public function recupTousEleves()
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_eleves` order by NOM;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupTousEleves222()
	{
		$req = "SELECT DISTINCT * FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_inscrit`.ID_ELEVE   WHERE ANNEE = ".PdoBD::$anneeExtranet." order by NOM;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupEmailTousEleves($annee)
	{
		$req = "SELECT DISTINCT email_des_parents, email_de_l_enfant FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_inscrit`.ID_ELEVE WHERE ANNEE = :annee order by NOM;";
        $params = array(
            ':annee' => $annee
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupInfosImportEleve($eleve)
	{
		$req = "SELECT NOM, RESPONSABLE_LEGAL, PROFESSION_DU_PÈRE, PROFESSION_DE_LA_MÈRE, ADRESSE_POSTALE, CODE_POSTAL, VILLE, TÉLÉPHONE_DES_PARENTS, TÉLÉPHONE_DES_PARENTS2, TÉLÉPHONE_DES_PARENTS3 FROM `".PdoBD::$villeExtranet."_eleves` WHERE ID_ELEVE = :eleve";

		$params = array(
			':eleve' => $eleve
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function importerEleveBIS($unEleve,$uneVille,$uneVilleOrigine,$anneeEnCours)
	{
		$req = "INSERT INTO ".$uneVille."_eleves SELECT * FROM ".$uneVilleOrigine."_eleves WHERE ID_ELEVE = :eleve";

		$rs = $this->NonQuery($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function importerEleve($unEleve,$uneVille,$uneVilleOrigine,$anneeEnCours)
	{
		//INSERT INTO ".$uneVille."_eleves SELECT * FROM ".$uneVilleOrigine."_eleves WHERE ID_ELEVE = ".$unEleve.";

		$req = "
		INSERT INTO ".$uneVille."_inscrit SELECT * FROM ".$uneVilleOrigine."_inscrit WHERE ID_ELEVE =:eleve AND ANNEE = :annee;";

		$params = array(
			':eleve' => $unEleve,
			':annee' => $anneeEnCours
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}

	}

	public function modifierPhotoEleve($nom_photo,$num)
	{
		$req = "UPDATE `".PdoBD::$villeExtranet."_eleves` SET `PHOTO` = :nom_photo WHERE `ID_ELEVE` = :num";

		$params = array(
			':nom_photo' => $nom_photo,
			':num' => $num
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}

	}

	public function modifierPhotoIntervenant($nom_photo,$num)
	{
		$req = "UPDATE `intervenants` SET `PHOTO` = :nom_photo WHERE `ID_INTERVENANT` = :num";

		$params = array(
			':nom_photo' => $nom_photo,
			':num' => $num
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la photo de l'intervenant ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* retourne la classe dun eleve a une date
	*/
	public function recupClasseUnEleve($annee,$eleve)
	{
		$req = "SELECT  `ID_CLASSE`,NOM FROM `".PdoBD::$villeExtranet."_inscrit` INNER JOIN `parametre` ON `".PdoBD::$villeExtranet."_inscrit`.ID_CLASSE=`parametre`.ID  WHERE `ID_ELEVE`=:eleve AND `ANNEE`=:annee;";

		$params = array(
			':eleve' => $eleve,
			'annee' => $annee
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* retourne la filiere dun eleve a une date
	*/
	public function recupFiliereUnEleve($annee,$eleve)
	{
		$req = "SELECT  `ID_FILIERES`,NOM FROM `".PdoBD::$villeExtranet."_inscrit` INNER JOIN `parametre` ON `".PdoBD::$villeExtranet."_inscrit`.ID_FILIERES=`parametre`.ID  WHERE `ID_ELEVE`=:eleve AND `ANNEE`=:annee;";

		$params = array(
			':eleve' => $eleve,
			':annee' => $annee
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les élèves  inscrit a un evenement
	*/
	public function recupElevesInscritEvenement($evenement)
	{
		$req = "select * from `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscription` on `".PdoBD::$villeExtranet."_inscription`.ID_ELEVE=`".PdoBD::$villeExtranet."_eleves`.ID_ELEVE WHERE NUMÉROEVENEMENT=:evenement ;";

		$params = array(
			':evenement' => $evenement
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les infos d'un élève
	*/
	public function recupUnEleves($num)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_eleves` where ID_ELEVE=:num;";

		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture de l'eleve ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les infos d'un stage
	*/
	public function recupUnStage($num)
	{
		$req = "SELECT * FROM `STAGE_REVISION` where ID_STAGE=:num;";

		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les inscrits d'un stage
	*/
	public function recupLesInscriptions($num)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=:num ORDER BY NOM_ELEVE_STAGE;";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des inscriptions du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

/**
	* Retourne les inscrits d'un stage
	*/
	public function recupParticipationsofImpaye($num)
	{
		$req = "SELECT `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS`, count( ID_PRESENCE) as nbP FROM `INSCRIPTIONS_STAGE` INNER JOIN PRÉSENCES_STAGE ON PRÉSENCES_STAGE.ID_INSCRIPTIONS = `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=:num  GROUP BY `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS`; ";
    //$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN PRÉSENCES_STAGE ON PRÉSENCES_STAGE.ID_INSCRIPTIONS = `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=$num  GROUP BY `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS`; ";
		
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des inscriptions du stage ..", $req, PdoBD::$monPdo->errorInfo());}

		return $rs;
	}

	/**
	* Retourne les inscrits d'un stage par groupe
	*/
	public function recupLesInscriptionsParGroupe($num)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=:num ORDER BY  ID_GROUPE, NOM_ELEVE_STAGE, PRENOM_ELEVE_STAGE;";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des inscriptions du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un inscrits d'un stage
	*/
	public function recupUneInscription($num)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS`= :num;";

		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des inscriptions du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les présences d'un stage
	*/
	public function recupLesPresences($num)
	{
		$req = "SELECT * FROM `PRÉSENCES_STAGE` INNER JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` = `PRÉSENCES_STAGE`.`ID_INSCRIPTIONS` where `INSCRIPTIONS_STAGE`.`ID_STAGE`=:num ORDER BY DATE_PRESENCE, MATINOUAP;";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des presences du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupLesPresencesParDate($num, $date, $matinouap){
		$req = "SELECT * FROM `PRÉSENCES_STAGE` INNER JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` = `PRÉSENCES_STAGE`.`ID_INSCRIPTIONS` where `INSCRIPTIONS_STAGE`.`ID_STAGE` = :stage AND `PRÉSENCES_STAGE`.`DATE_PRESENCE` = :date AND MATINOUAP = :moment;";
        $params = array(
            ':stage' => $num,
            ':date' => $date,
            ':moment' => $matinouap
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des presences du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}
	
	public function recupLesAbsencesStage($num, $date, $matinouap){
		$req = "SELECT DISTINCT `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` FROM `INSCRIPTIONS_STAGE` INNER JOIN `présences_stage` ON `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` = `présences_stage`.`ID_INSCRIPTIONS` WHERE `INSCRIPTIONS_STAGE`.`ID_STAGE` = :stage AND `présences_stage`.`DATE_PRESENCE` = :date AND `présences_stage`.`MATINOUAP` = :moment AND NOT EXISTS(SELECT DISTINCT * FROM `présences_stage` INNER JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` = `présences_stage`.`ID_INSCRIPTIONS` WHERE `INSCRIPTIONS_STAGE`.`ID_STAGE` = :stage1 AND`présences_stage`.`DATE_PRESENCE` = :date1 AND `présences_stage`.`MATINOUAP` = :moment1)";
        $params = array(
            ':stage' => $num,
            ':stage1' => $num,
            ':date' => $date,
            ':date1' => $date,
            ':moment' => $matinouap,
            ':moment1' => $matinouap
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des absents du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un élève d'un stage avec son ID inscription
	*/
	public function recupEleveStage($num)
	{
		$req = "SELECT * FROM `ELEVE_STAGE` INNER JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS`=:num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les élèves des stage
	*/
	public function recuplesElevesDesStages($num)
	{
		$req = "SELECT * FROM `ELEVE_STAGE` WHERE `ID_ELEVE_STAGE` = :num ORDER BY `NOM_ELEVE_STAGE`;";

		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des élèves du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	*
	*/
	public function lierEleve($eleve,$stage)
	{
		foreach($eleve as $unEleve) {
			$req = "INSERT INTO `INSCRIPTIONS_STAGE`(`ID_STAGE`, `ID_ELEVE_STAGE`) VALUES (:stage,:eleve);";

			$params = array(
				':stage' => $stage,
				':eleve' => $unEleve
			);
			$rs = $this->NonQuery($req,$params);
		}

		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des élèves du stage ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Retourne les élèves des stage
	*/
	public function recuplesElevesDesStagesTout()
	{
		$req = "SELECT * FROM `ELEVE_STAGE` ORDER BY `NOM_ELEVE_STAGE`";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des élèves du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les Horaires d'un intervenant
	*/
	public function recupPresenceEleve($debut,$fin,$eleve)
	{
		$req = "SELECT `ID_ELEVE`, `SEANCE` FROM `".PdoBD::$villeExtranet."_appel` WHERE SEANCE BETWEEN :debut and :fin AND ID_ELEVE = :eleve ORDER BY SEANCE;";
		
		$params = array(
			':debut' => $debut,
			':fin' => $fin,
			':eleve' => $eleve
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupPresenceEleveSansDate($eleve)
	{
		$req = "SELECT *
				FROM
				(SELECT `ID_ELEVE`, `SEANCE`, 'SOUTIEN SCOLAIRE' as type
				FROM `quetigny_appel`
				WHERE ID_ELEVE = :eleve
				UNION
				SELECT `ID_ELEVE_ANCIENNE_TABLE`, `DATE_PRESENCE`, 'STAGE' as type
				FROM `PRÉSENCES_STAGE`
				LEFT OUTER JOIN INSCRIPTIONS_STAGE ON PRÉSENCES_STAGE.ID_INSCRIPTIONS = INSCRIPTIONS_STAGE.ID_INSCRIPTIONS
				LEFT OUTER JOIN ELEVE_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE
				WHERE ELEVE_STAGE.ID_ELEVE_ANCIENNE_TABLE = :eleve) as A
				ORDER BY `A`.`SEANCE` DESC;";

		$params = array(
			':eleve' => $eleve
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function CountrecupPresenceEleveSansDate($eleve)
	{
		$req = "SELECT count(SEANCE) as 'nb' FROM (SELECT `ID_ELEVE`, `SEANCE`, 'SOUTIEN SCOLAIRE' as type
		FROM `quetigny_appel`
		WHERE ID_ELEVE = :eleve
		UNION
		SELECT `ID_ELEVE_ANCIENNE_TABLE`, `DATE_PRESENCE`, 'STAGE' as type
		FROM `PRÉSENCES_STAGE`
		LEFT OUTER JOIN INSCRIPTIONS_STAGE ON PRÉSENCES_STAGE.ID_INSCRIPTIONS = INSCRIPTIONS_STAGE.ID_INSCRIPTIONS
		LEFT OUTER JOIN ELEVE_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE
		WHERE ELEVE_STAGE.ID_ELEVE_ANCIENNE_TABLE = :eleve) as A;";


		$params = array(
			':eleve' => $eleve
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recup7PresenceEleve($utilisateur , $eleve)
	{
		$req = "SELECT `ID_$utilisateur`, `SEANCE` FROM `quetigny_appel` WHERE ID_$utilisateur = :eleve ORDER BY SEANCE DESC LIMIT 7;";
		
		$params = array(
			':eleve' => $eleve
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les intervenants present a une date, sur la demi-journée spécifiée
	*/
	public function recupIntervenantsPresentDate($date, $moment)
	{
		$req = "SELECT NOM,PRENOM,ID,intervenants.ID_INTERVENANT,HEURES FROM `intervenants` INNER JOIN `".PdoBD::$villeExtranet."_appel` ON `intervenants`.ID_INTERVENANT=`".PdoBD::$villeExtranet."_appel`.ID_INTERVENANT WHERE SEANCE = :date";
		$params = array(
			':date' => $date
		);
		if ($moment !== null) {
			$req .= " AND ID_MOMENT = :moment";
			$params[':moment'] = $moment;
		} else $req .= " AND ID_MOMENT IS NULL";
		$req .= ' ORDER BY NOM;';
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les impayés à un réglement
	*/
	public function recupImpayesReglement($reglement)
	{
		$req = "SELECT * from `".PdoBD::$villeExtranet."_eleves` where ID_ELEVE NOT IN ( select ID_ELEVE from `".PdoBD::$villeExtranet."_reglements` where NOMREGLEMENT=:reglement);";
		
		$params = array(
			':reglement' => $reglement
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les impayés à un réglement avec evenement
	*/
	public function recupImpayesReglementAvecEvenement($reglement,$evenement)
	{
		$req = "SELECT * from `".PdoBD::$villeExtranet."_eleves` where ID_ELEVE NOT IN ( select ID_ELEVE from `".PdoBD::$villeExtranet."_reglements` where NOMREGLEMENT=:reglement) AND ID_ELEVE IN (select ID_ELEVE from `".PdoBD::$villeExtranet."_inscription` where NUMÉROEVENEMENT=:evenement);";
		
		$params = array(
			':reglement' => $reglement,
			':evenement' => $evenement
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les impayés à un réglement
	*/
	public function recupPayesReglement($reglement)
	{
		$req = "SELECT * from `".PdoBD::$villeExtranet."_eleves` where ID_ELEVE IN ( select ID_ELEVE from `".PdoBD::$villeExtranet."_reglements` where NOMREGLEMENT='$reglement');";
		
		$params = array(
			':reglement' =>$reglement
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les impayés à un réglement avec evenement
	*/
	public function recupPayesReglementAvecEvenement($reglement,$evenement)
	{
		$req = "SELECT * from `".PdoBD::$villeExtranet."_eleves` where ID_ELEVE IN ( select ID_ELEVE from `".PdoBD::$villeExtranet."_reglements` where NOMREGLEMENT='$reglement') AND ID_ELEVE IN (select ID_ELEVE from `".PdoBD::$villeExtranet."_inscription` where NUMÉROEVENEMENT=$evenement);";
		
		$params = array(
			':reglement' => $reglement,
			':evenement' => $evenement
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	/**
	* Retourne les eleves present a une date, sur la demi-journée spécifiée
	*/
	public function recupElevesPresentDate($date, $moment)
	{
		$req = "SELECT NOM,PRENOM,ID,`".PdoBD::$villeExtranet."_eleves`.ID_ELEVE FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_appel` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE=`".PdoBD::$villeExtranet."_appel`.ID_ELEVE where SEANCE =:date";
		$params = array(
			':date' => $date
		);
		if ($moment !== null) {
			$req .= " AND ID_MOMENT = :moment";
			$params[':moment'] = $moment;
		} else $req .= " AND ID_MOMENT IS NULL";
		$req .= ' ORDER BY NOM;';
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les eleves present a une date
	*/
	public function listedateannee($anneedeb,$anneefin)
	{
		$req = "SELECT seance FROM `quetigny_appel` WHERE SEANCE BETWEEN :anneedeb AND :anneefin;";
		
		$params = array(
			':anneedeb' => $anneedeb."-09-01",
			':anneefin' => $anneefin."-09-01"
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les Horaires d'un intervenant
	*/
	public function recupHoraireIntervenant($debut,$fin,$intervenant)
	{
		$req = "SELECT `ID_INTERVENANT`, `SEANCE`, `HEURES`, `ID_MOMENT` FROM `".PdoBD::$villeExtranet."_appel` WHERE SEANCE BETWEEN :debut and :fin AND ID_INTERVENANT = :intervenant ORDER BY SEANCE;";
		
	    $params = array(
			':debut' => $debut,
			':fin' => $fin,
			':intervenant' => $intervenant
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les rdv d'un intervenant
	*/
	public function recupRdvIntervenant($debut,$fin,$intervenant)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_rdvparents` WHERE DATE_RDV BETWEEN '$debut' and '$fin' AND ID_INTERVENANT = $intervenant ORDER BY DATE_RDV;";
		
		$params = array(
			':debut' => $debut,
			':fin' => $fin,
			':intervenant' => $intervenant
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les Horaires de tous les intervenants d'un statut
	*/
	public function recupHoraireIntervenantStatut($debut,$fin,$statut)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_appel` INNER JOIN `intervenants` ON `intervenants`.ID_INTERVENANT=`".PdoBD::$villeExtranet."_appel`.ID_INTERVENANT WHERE SEANCE >= DATE(:debut) AND SEANCE <= DATE(:fin) AND STATUT=:statut ORDER BY NOM";
		
		$params = array(
			':debut' => $debut,
			':fin' => $fin,
			':statut' => $statut
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les inscritiption de leleve
	*/
	public function recupInscriptionAnnuelEleve($num)
	{
		$req = " SELECT `ID_ELEVE`, `ANNEE`, `ID`, `ID_FILIERES`, `ID_LV1`, `ID_LV2`, `ID_CLASSE`, `DATE_INSCRIPTION`, `NOM_DU_PROF_PRINCIPAL`, `COMMENTAIRESANNEE` FROM `".PdoBD::$villeExtranet."_inscrit` WHERE ID_ELEVE=:num ORDER BY ANNEE DESC;";
		
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les rdv pour une date
	*/
	public function lesRdv($date,$bsb)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_rdvparents` WHERE `DATE_RDV` = :date AND `BSB` = :bsb";

		$params = array(
			':date' => $date,
			':bsb' => $bsb
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	/**
	* Retourne le numéro ID max de la table intervenants
	*/
	public function maxNumIntervenants()
	{
		$req = "SELECT MAX(ID_INTERVENANT) as Maximum from `intervenants` ;";
		
		
		$rs = $this->Read($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les informations d'un agent sous la forme d'un tableau associatif
	*/
	public function getInfosUtilisateurs($login,$mdp)
	{
		$req = "SELECT *
		FROM `intervenants`
		WHERE (EMAIL =:email || (CONCAT(REPLACE(NOM, ' ', ''), '.', LEFT(PRENOM, 1)) =:login))";

		$params = array(
			':email' => $login,
			':login' => $login
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des informations d'un agent...", $req, PdoBD::$monPdo->errorInfo());}
		if (verify_password($mdp, $rs['PASSWORD'])) {
			return $rs;
		}
		return false;
	}

	public function getInfosEleves($loginEL,$mdpEL)
    {
        $req = "SELECT *
        FROM `quetigny_eleves`
        WHERE CONCAT(REPLACE(NOM, ' ', ''), '.', LEFT(PRENOM, 1)) =:login
        AND CONCAT(REPLACE(DATE_DE_NAISSANCE, '-', ''), '_', ID_ELEVE) = :mdp";

		$params = array(
			':login' => $loginEL,
			':mdp' => $mdpEL
		);
        $rs = $this->Read($req,$params);
        if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des informations d'un eleve...", $req, PdoBD::$monPdo->errorInfo());}
        return $rs;
    }

    public function getidentifianteleves($ideleve)
    {
        $req = "SELECT CONCAT(REPLACE(NOM, ' ', ''), '.', LEFT(PRENOM, 1)) id, CONCAT(REPLACE(DATE_DE_NAISSANCE, '-', ''), '_', ID_ELEVE) mdp
        FROM `quetigny_eleves`
         where ID_ELEVE= :id";

		$params = array(
			':id' => $ideleve
		);
        $rs = $this->Read($req,$params);
        if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des informations d'un eleve...", $req, PdoBD::$monPdo->errorInfo());}
        return $rs;
    }

	public function getinfospersoseleves($ideleve)
	{
		$req = "SELECT *
		FROM `quetigny_eleves`

		where ID_ELEVE= '$ideleve'";

		$params = array(
			':id' => $ideleve
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des informations d'un eleve...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne le planning  sous la forme d'un tableau associatif
	*/
	public function getPlanning($numIntervenant)
	{
		$req = "SELECT DATE_PRESENCE
		FROM `".PdoBD::$villeExtranet."_presence`
		WHERE ID_INTERVENANT=:numIntervenant";


		$params = array(
			':numIntervenant' => $numIntervenant
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne le planning  sous la forme d'un tableau associatif
	*/
	public function supprimerDispo($num,$date)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_presence` WHERE `ID_INTERVENANT` = :num AND `DATE_PRESENCE` = :date";
		
		$params = array(
			':num' => $num,
			':date' => $date
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de la dispo...", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Retourne le planning des agents sous la forme d'un tableau associatif
	*/
	public function getMaxParametre()
	{
		$req = "SELECT MAX(ID) as maximumNum from `parametre`";
		
		$rs = $this->Read($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne le numero eleve selon code barre
	*/
	public function getIdEleve($codebarre)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_eleves` WHERE `CODEBARRETEXTE`=:codebarre";
		$params = array(
			':codebarre' => $codebarre
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	 * Retourne le numéro de l'élève selon le QRCode (de sa carte d'élève)
	 * @param $qrCode : QRCode sur la carte de l'élève
	 */
	public function getIdEleveQRCode($qrCode) {
		$req = "SELECT qe.ID_ELEVE FROM `".PdoBD::$villeExtranet."_eleves` qe INNER JOIN `".PdoBD::$villeExtranet."_inscrit` qi ON qi.ID_ELEVE = qe.ID_ELEVE WHERE ANNEE = ".PdoBD::$anneeExtranet." AND CONCAT('e_', qe.`ID_ELEVE`)=:qrCode";
		$params = array(
			':qrCode' => $qrCode
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture de l'élève...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs !== null ? (int)$rs['ID_ELEVE'] : null;
	}

	/**
	 * Retourne le numéro de l'intervenant selon le QRCode de sa carte d'intervenant
	 * @param $qrCode : QRCode sur la carte de l'intervenant
	 */
	public function getIdIntervenantQRCode($qrCode) {
		$req = "SELECT * FROM `intervenants` WHERE CONCAT('i_', `ID_INTERVENANT`)=:qrCode";
		$params = array(
			':qrCode' => $qrCode
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture de l'intervenant...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs !== null ? (int)$rs['ID_INTERVENANT'] : null;
	}

	/**
	* Retourne le max de lannee de la table inscription d'un eleve
	*/
	public function getMaxAnneeInscription($num)
	{
		$req = "SELECT  MAX(ANNEE) AS ANNEEMAX FROM `".PdoBD::$villeExtranet."_inscrit` WHERE `ID_ELEVE`=:num";
		
		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne le prix horaire des intervenants
	*/
	public function getPrixHoraireIntervenant()
	{
		$req = "SELECT nom as prixHoraire from `parametre` where id=0";
		
		$rs = $this->Read($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les heures des intervenants
	*/
	public function getHeures($numIntervenant)
	{
		$req = "SELECT `ID_INTERVENANT`, `SEANCE`, `ID`, `HEURES` FROM `".PdoBD::$villeExtranet."_appel` WHERE `ID_INTERVENANT` = :numIntervenant ORDER BY `SEANCE`";
		
		$params = array(
			':numIntervenant' => $numIntervenant
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les heures des intervenants
	*/
	public function getHeuresSeance($seance)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_presence` WHERE `DATE_PRESENCE` = :seance";


		$params = array(
			':seance' => $seance
		);
		$rs = $this->ReadAll($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture du planning...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Met a jour une ligne de la table INTERVENANT Avec Code
	*/
	public function modifIntervenantAvecCode($num, $nom, $prenom, $actif, $date_naissance, $lieu_naissance,$tel, $adresse,$statut, $cp, $ville,$email,$commentaires,$diplome,$numsecu,$nationalite,$password,$photo,$iban,$bic,$compte,$banque,$serviceCivique)
	{
		$req = "UPDATE `intervenants` SET `NOM`=:nom,`PRENOM`=:prenom,`ACTIF`=:actif,`STATUT`=:statut,`EMAIL`=:email,`TELEPHONE`=:tel,`ADRESSE_POSTALE`=:adresse,`CODE_POSTAL`=:cp,`VILLE`=:ville,`DIPLOME`=:diplome,`COMMENTAIRES`=:commentaires,`DATE_DE_NAISSANCE`=:date_naissance,`LIEU_DE_NAISSANCE`=:lieu_naissance,`NATIONALITE`=:nationalite,`SECURITE_SOCIALE`=:numsecu,`PHOTO`=:photo,`PASSWORD`=:password, IBAN=:iban, BIC=:bic, COMPTEBANCAIRE=:compte, BANQUE=:banque, SERVICECIVIQUE=:serviceCivique WHERE `ID_INTERVENANT`=:num";

		$params = array(
			':num' => $nom,
			':nom' => $nom,
			':prenom' => $prenom,
			':actif' => $actif,
			':date_naissance' => $date_naissance,
			':lieu_naissance' => $lieu_naissance,
			':tel' => $tel,
			':adresse' => $adresse,
			':statut' => $statut,
			':cp' => $cp,
			':ville' => $ville,
			':email' => $email,
			':commentaires' => $commentaires,
			':diplome' => $diplome,
			':numsecu' => $numsecu,
			':nationalite' => $nationalite,
			':password' => $password,
			':photo' => $photo,
			':iban' => $iban,
			':bic' => $bic,
			':compte' => $compte,
			':banque' => $banque,
			':serviceCivique' => $serviceCivique
		);

		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function modifElevesInfos($teleleve,$emaileleve,$ideleve)
	{
		$req = "UPDATE `quetigny_eleves` SET `TÉLÉPHONE_DE_L_ENFANT`=:teleleve,`EMAIL_DE_L_ENFANT`=:emaileleve WHERE `ID_ELEVE`=:ideleve";
		
		$params = array(
			':teleleve' => $teleleve,
			':emaileleve' => $emaileleve,
			':ideleve' => $ideleve
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo()); }
	}

	/**
	* Met a jour une ligne de la table INTERVENANT pour reglement
	*/
	public function modifIntervenantReglement($num,$iban,$bic,$compte,$banque)
	{
		$req = "UPDATE `intervenants` SET `IBAN`=:iban, BIC=:bic, `COMPTEBANCAIRE`=:compte, `BANQUE`=:banque WHERE `ID_INTERVENANT`=:num";
		
		
		$params = array(
			':num' => $num,
			':iban' => $iban,
			':bic' => $bic,
			':compte' => $compte,
			':banque' => $banque
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table INTERVENANT Avec Code
	*/
	public function modifIntervenantPublicAvecCode($num, $nom, $prenom, $date_naissance, $lieu_naissance,$tel, $adresse, $cp, $ville,$email,$diplome,$numsecu,$nationalite,$password)
	{
		$req = "UPDATE `intervenants` SET `NOM`=:nom,`PRENOM`=:prenom,`EMAIL`=:email,`TELEPHONE`=:tel,`ADRESSE_POSTALE`=:adresse,`CODE_POSTAL`=:cp,`VILLE`=:ville,`DIPLOME`=:diplome,`DATE_DE_NAISSANCE`=:date_naissance,`LIEU_DE_NAISSANCE`=:lieu_naissance,`NATIONALITE`=:nationalite,`SECURITE_SOCIALE`=:numsecu,`PASSWORD`=:password WHERE `ID_INTERVENANT`=:num";
		
		$params = array(
			':num' => $num,
			':nom' => $nom,
			':prenom' => $prenom,
			':date_naissance' => $date_naissance,
			':lieu_naissance' => $lieu_naissance,
			':tel' => $tel,
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => $ville,
			':email' => $email,
			':diplome' => $diplome,
			':numsecu' => $numsecu,
			':nationalite' => $nationalite,
			':password' => $password
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table INTERVENANT Sans Code
	*/
	public function modifIntervenantPublicSansCode($num, $nom, $prenom, $date_naissance, $lieu_naissance,$tel, $adresse, $cp, $ville,$email,$diplome,$numsecu,$nationalite)
	{
		$req = "UPDATE `intervenants` SET `NOM`=:nom,`PRENOM`=:prenom,`EMAIL`=:email,`TELEPHONE`=:tel,`ADRESSE_POSTALE`=:adresse,`CODE_POSTAL`=:cp,`VILLE`=:ville,`DIPLOME`=:diplome,`DATE_DE_NAISSANCE`=:date_naissance,`LIEU_DE_NAISSANCE`=:lieu_naissance,`NATIONALITE`=:nationalite,`SECURITE_SOCIALE`=:numsecu WHERE `ID_INTERVENANT`=:num";
		
		$params = array(
			':num' => $num,
			':nom' => $nom,
			':prenom' => $prenom,
			':date_naissance' => $date_naissance,
			':lieu_naissance' => $lieu_naissance,
			':tel' => $tel,
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => $ville,
			':email' => $email,
			':diplome' => $diplome,
			':numsecu' => $numsecu,
			':nationalite' => $nationalite
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table STAGE_REVISION
	*/
	public function modifUnStage($num,$nom,$annee,$datedeb,$datefin,$prix,$couleur,$description,$lieu,$datefininscrit,$duree_seances, $prix_stage)
	{
		$req = "UPDATE `STAGE_REVISION` SET `ANNEE_STAGE`=:annee,`NOM_STAGE`=:nom,`DATEDEB_STAGE`=:datedeb,`DATEFIN_STAGE`=:datefin,
		`DESCRIPTION_STAGE`=:description,`PRIX_STAGE`=:prix,`FOND_STAGE`=:couleur,`ID_LIEU`=:lieu,`DATE_FIN_INSCRIT_STAGE`=:datefininscrit,
		`DUREE_SEANCES_STAGE`=:duree_seances, PRIX_STAGE_SORTIE = :prix_sortie 
		WHERE `ID_STAGE` = :num";
		
		$params = array(
			':num' => $num,
			':nom' => $nom,
			':annee' => $annee,
			':datedeb' => $datedeb,
			':datefin' => $datefin,
			':prix' => $prix,
			':couleur' => $couleur,
			':description' => $description,
			':lieu' => $lieu,
			':datefininscrit' => $datefininscrit,
			':duree_seances' => $duree_seances,
			':prix_sortie' => $prix_stage
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* récupère une ligne de la table site
	*/
	public function recupUnStageURL($stage)
	{
		$req = "SELECT * FROM site WHERE STAGE=:stage";

		$params = array(
			':stage' => $stage
		);
		$rs = $this->Read($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves atelier...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Ajoute une ligne à la table SITE
	*/
	public function ajoutUnStageURL($num,$url)
	{
		$req = "INSERT INTO site (STAGE, URL) VALUES (:numid, :url) ;";
		$params = array(
			':url' => $url,
			':numid' => $num,
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		else{
			($this->SupprimerLienInscription($url, $num));
		}
	}

	/**
	* Met a jour une ligne de la table SITE
	*/
	public function modifUnStageURL($num, $url,)
	{



		$req = "UPDATE site SET STAGE=:num, URL=:url WHERE STAGE=:numid ;";
		
		$params = array(
			':num' => $num,
			':url' => $url,
			':numid' => $num,
			
		);
		$rs = $this->NonQuery($req,$params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		else {
			($this->SupprimerLienInscription($url, $num));
		}
	}

	/**
	* Met a jour les heures d'un intervenant sur un stage
	*/
	public function modifHeuresEffectuesStageIntervenant($stage,$intervenant,$heure)
	{
		$req = "UPDATE INTERVIENT_STAGE SET HEURES=:heure WHERE ID_STAGE=:stage AND ID_INTERVENANT=:intervenant";

		$params = array(
			':stage' => $stage,
			':intervenant' => $intervenant,
			':heure' => $heure
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Ajout un lieu
	*/
	public function ajouterLieu($nom, $adresse, $cp, $ville)
	{
		$req = "INSERT INTO `LIEUX_STAGE`(`NOM_LIEU`,`ADRESSE_LIEU`,`CP_LIEU`,`VILLE_LIEU`) VALUES (:nom,:adresse,:cp,:ville)";
		$params = array(
			':nom' => $nom,
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => $ville
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour un lieu
	*/
	public function modifierLieuConfirmation($num, $nom, $adresse, $cp, $ville)
	{
		$req = "UPDATE `LIEUX_STAGE` SET `NOM_LIEU`=:nom,`ADRESSE_LIEU`=:adresse,`CP_LIEU`=:cp,`VILLE_LIEU`=:ville WHERE `ID_LIEU` = :num";
		$params = array(
			':num' => $num,
			':nom' => $nom,
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => $ville
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour un partenaire
	*/
	public function modifierPartenaireConfirmation($num, $nom, $image)
	{
		$req = "UPDATE `PARTENAIRES_STAGE` SET `NOM_PARTENAIRES`=:nom,`IMAGE_PARTENAIRES`=:image WHERE `ID_PARTENAIRES` = :num";
		$params = array(
			':num' => $num,
			':nom' => $nom,
			':image' => $image
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table STAGE_REVISION
	*/
	public function ajouterStage($nom,$annee,$datedeb,$datefin,$prix,$couleur,$description,$lieu,$image,$affiche,$planning,$datefininscrit,$duree_seances, $stage_sortie)
	{
		$req = "INSERT INTO `STAGE_REVISION`(`ANNEE_STAGE`, `NOM_STAGE`, `DATEDEB_STAGE`, `DATEFIN_STAGE`, `DESCRIPTION_STAGE`, `IMAGE_STAGE`, `PRIX_STAGE`, `FOND_STAGE`, `AFFICHE_STAGE`, `PLANNING_STAGE`, `ID_LIEU`, `DATE_FIN_INSCRIT_STAGE`,`DUREE_SEANCES_STAGE`)
		VALUES (:annee,:nom,:datedeb,:datefin,:description,:image,:prix,:couleur,:affiche,:planning,:lieu,:datefininscrit,:duree_seances)";
		$params = array(
			':nom' => $nom,
			':annee' => $annee,
			':datedeb' => $datedeb,
			':datefin' => $datefin,
			':prix' => $prix,
			':couleur' => $couleur,
			':description' => $description,
			':lieu' => $lieu,
			':image' => $image,
			':affiche' => $affiche,
			':planning' => $planning,
			':datefininscrit' => $datefininscrit,
			':duree_seances' => $duree_seances
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table ATELIERS_LUDIQUES
	*/
	public function modifUnAtelier($num,$nom,$nbmax,$niveau,$description,$groupe)
	{
		$description = addslashes($description);
		$req = "UPDATE `ATELIERS_LUDIQUES` SET `NOM_ATELIERS`= :nom,`DESCRIPTIF_ATELIERS`= :description,`NBMAX_ATELIERS`= :nbmax,`NIVEAU_ATELIER`= :niveau,`GROUPE_ATELIER`= :groupe WHERE `ID_ATELIERS` = :num";
		$params = array(
			':nom' => $nom,
			':description' => $description,
			':nbmax' => $nbmax,
			':niveau' => $niveau,
			':groupe' => $groupe,
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'atelier dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Desinscrit un élève d'un atelier
	*/
	public function desinscrireAtelier($numEleve,$numAtelier)
	{
		$req = "DELETE FROM `STAGE_PARTICIPE` WHERE `ID_INSCRIPTION` = :numEleve AND `ID_ATELIER` = :numAtelier";
		$params = array(
			':numEleve' => $numEleve,
			':numAtelier' => $numAtelier
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du stage dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Liste les élèves inscrits à un atelier d'un stage
	*/
	public function elevesInscritsAtelier($numAtelier)
	{
		$req = "SELECT * FROM `STAGE_PARTICIPE` JOIN `INSCRIPTIONS_STAGE` ON `STAGE_PARTICIPE`.`ID_INSCRIPTION` = `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` WHERE `STAGE_PARTICIPE`.`ID_ATELIER` = :numAtelier ORDER BY `CLASSE_ELEVE_STAGE`";
		$params = array(
			':numAtelier' => $numAtelier
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves atelier...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// N'est pas utilisé pour le moment
	public function elevesInscritsAtelier2($numAtelier)
	{
		$req = "SELECT * FROM `STAGE_PARTICIPE` JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` WHERE `STAGE_PARTICIPE`.`ID_ATELIER` = :numAtelier";
		$params = array(
			':numAtelier' => $numAtelier
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves atelier...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function inscrireAtelier($numInscription, $numAtelier)
	{
		$req = "INSERT INTO `STAGE_PARTICIPE`(`ID_INSCRIPTION`, `ID_ATELIER`) VALUES (:numInscription, :numAtelier);";
		$params = array(
			':numInscription' => $numInscription,
			':numAtelier' => $numAtelier
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves atelier...", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function recupIdInscription($numStage)
	{
		$req = "SELECT MAX(`ID_INSCRIPTIONS`) as max FROM `INSCRIPTIONS_STAGE` WHERE `ID_STAGE` = :numStage";
		$params = array(
			':numStage' => $numStage
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves atelier...", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Met a jour une ligne de la table INTERVENANT
	*/
	public function modifServiceCivique($numIntervenant,$service)
	{
		$req = "UPDATE `intervenants` SET SERVICECIVIQUE= :service WHERE `ID_INTERVENANT`= :numIntervenant";
		$params = array(
			':service' => $service,
			':numIntervenant' => $numIntervenant
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'intervenant ( service civique) dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table presence
	*/
	public function modifPlanning($valeur,$date)
	{
		$req = "UPDATE `".PdoBD::$villeExtranet."_presence` SET `VALIDER`=1 WHERE `ID_INTERVENANT`=:valeur AND `DATE_PRESENCE`=:date";
		$params = array(
			':valeur' => $valeur,
			':date' => $date
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de (validation presence) dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Inscription d'un jeune de ORE à un stage
	*/
	public function inscriptionStageOre($num,$nom,$prenom,$datedenaissance,$date,$ip,$user_agent,$origine,$id_atelier,$classe,$tel_parent,$tel_enfant)
	{
		$req = "INSERT INTO `ELEVE_STAGE`(`NOM_ELEVE_STAGE`, `PRENOM_ELEVE_STAGE`,`DDN_ELEVE_STAGE`,`ASSOCIATION_ELEVE_STAGE`, `CLASSE_ELEVE_STAGE`) VALUES (:nom, :prenom, :datedenaissance, 'ore', :classe);";
		$params = array(
			':nom' => strtoupper(addslashes($nom)),
			':prenom' => ucfirst(addslashes($prenom)),
			':datedenaissance' => $datedenaissance,
			':classe' => $classe
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'inscription de l'élève au stage.", $req, PdoBD::$monPdo->errorInfo());}

		$req2 = "INSERT INTO `INSCRIPTIONS_STAGE`(`ID_STAGE`,`ID_ELEVE_STAGE`,`ID_ATELIERS`,`VALIDE`,`DATE_INSCRIPTIONS`,`IP_INSCRIPTIONS`,`USER_AGENT_INSCRIPTIONS`, `ORIGINE_INSCRIPTIONS`) VALUES (:num, (SELECT MAX(`ID_ELEVE_STAGE`) AS max_id FROM `ELEVE_STAGE`), :id_atelier, 0, :date, :ip, :user_agent, :origine);";
		$params2 = array(
			':num' => $num,
			':id_atelier' => $id_atelier,
			':date' => $date,
			':ip' => $ip,
			':user_agent' => addslashes($user_agent),
			':origine' => addslashes($origine)
		);
		$rs2 = $this->NonQuery($req2, $params2);
		if ($rs2 === false) {afficherErreurSQL("Probleme lors de l'inscription de l'élève au stage.", $req2, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Ajout de log suite à une connexion à l'extranet
	*/
	public function addLog($estintervenant,$date,$ip,$ip_localisation,$email,$mdp,$connexion,$user_agent,$forward)
	{
		$req = "INSERT INTO `logs_extranet`(`estintervenant`,`date`, `ip`, `ip_localisation`, `email`, `mdp`, `connexion`, `user_agent`, `forward`) VALUES (:estintervenant, :date, :ip, :ip_localisation, :email, :mdp, :connexion, :user_agent, :forward)";
		$params = array(
			':estintervenant' => $estintervenant,
			':date' => $date,
			':ip' => $ip,
			':ip_localisation' => addslashes($ip_localisation),
			':email' => addslashes($email),
			':mdp' => addslashes($mdp),
			':connexion' => $connexion,
			':user_agent' => addslashes($user_agent),
			':forward' => addslashes($forward)
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout des logs.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Liste des Connexion à l'extranet
	*/
	public function lesLogs($estintervenant)
	{
		$req = "SELECT * FROM `logs_extranet` WHERE estintervenant = :estintervenant";
		$params = array(
			':estintervenant' => $estintervenant
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des logs.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Inscription d'un jeune nouveau
	*/
	public function inscriptionStageNouvelle($num, $nom,$prenom,$datedenaissance,$date,$ip,$user_agent,$origine,$id_atelier,$sexe,$etab,$classe,$filiere,$tel_enfant,$email_enfant,$tel_parent,$email_parent,$adresse,$cp,$ville,$association)
	{
		$req = "INSERT INTO `ELEVE_STAGE`(`NOM_ELEVE_STAGE`, `PRENOM_ELEVE_STAGE`, `SEXE_ELEVE_STAGE`, `ETABLISSEMENT_ELEVE_STAGE`, `CLASSE_ELEVE_STAGE`, `ASSOCIATION_ELEVE_STAGE`, `TELEPHONE_PARENTS_ELEVE_STAGE`, `TELEPHONE_ELEVE_ELEVE_STAGE`, `EMAIL_PARENTS_ELEVE_STAGE`, `EMAIL_ENFANT_ELEVE_STAGE`, `ADRESSE_ELEVE_STAGE`, `CP_ELEVE_STAGE`, `VILLE_ELEVE_STAGE`, `DDN_ELEVE_STAGE`, `FILIERE_ELEVE_STAGE`) VALUES (:nom, :prenom, :sexe, :etab, :classe, :association, :tel_parent, :tel_enfant, :email_parent, :email_enfant, :adresse, :cp, :ville, :datedenaissance, :filiere);";
		$params = array(
			':nom' => addslashes($nom),
			':prenom' => addslashes($prenom),
			':sexe' => $sexe,
			':etab' => $etab,
			':classe' => $classe,
			':association' => addslashes($association),
			':tel_parent' => $tel_parent,
			':tel_enfant' => $tel_enfant,
			':email_parent' => $email_parent,
			':email_enfant' => $email_enfant,
			':adresse' => addslashes($adresse),
			':cp' => $cp,
			':ville' => addslashes($ville),
			':datedenaissance' => $datedenaissance,
			':filiere' => $filiere
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'inscription d'un élève à un stage.", $req, PdoBD::$monPdo->errorInfo());}

		$req2 = "INSERT INTO `INSCRIPTIONS_STAGE`(`ID_STAGE`,`ID_ELEVE_STAGE`,`ID_ATELIERS`,`VALIDE`,`DATE_INSCRIPTIONS`,`IP_INSCRIPTIONS`,`USER_AGENT_INSCRIPTIONS`, `ORIGINE_INSCRIPTIONS`) VALUES (:num, (SELECT MAX(`ID_ELEVE_STAGE`) AS max_id FROM `ELEVE_STAGE`), :id_atelier, 0, :date, :ip, :user_agent, :origine);";
		$params2 = array(
			':num' => $num,
			':id_atelier' => $id_atelier,
			':date' => $date,
			':ip' => $ip,
			':user_agent' => addslashes($user_agent),
			':origine' => addslashes($origine)
		);
		$rs2 = $this->NonQuery($req2, $params2);
		if ($rs2 === false) {afficherErreurSQL("Probleme lors de l'inscription d'un élève à un stage.", $req2, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table inscrit
	*/
	public function modifInscriptionEleve($num,$annee,$etab,$classe,$prof_principal,$filiere,$lv1,$lv2,$date_inscription,$commentaires,$nouveau)
	{
		if($nouveau) {
			$req = "INSERT INTO `".PdoBD::$villeExtranet."_inscrit`(`ID_ELEVE`, `ANNEE`, `ID`, `ID_FILIERES`, `ID_LV1`, `ID_LV2`, `ID_CLASSE`, `DATE_INSCRIPTION`, `NOM_DU_PROF_PRINCIPAL`, `COMMENTAIRESANNEE`) VALUES (:num, :annee, :etab, :filiere, :lv1, :lv2, :classe, :date_inscription, :prof_principal, :commentaires)";
			$params = array(
				'num' => $num,
				'annee' => $annee,
				'etab' => $etab,
				'filiere' => $filiere,
				'lv1' => $lv1,
				'lv2' => $lv2,
				'classe' => $classe,
				'date_inscription' => $date_inscription,
				'prof_principal' => $prof_principal,
				'commentaires' => $commentaires
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout de l'eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		} else {
			$req = "UPDATE `".PdoBD::$villeExtranet."_inscrit` SET `ID`=:etab,`ID_FILIERES`=:filiere,`ID_LV1`=:lv1,`ID_LV2`=:lv2,`ID_CLASSE`=:classe,`DATE_INSCRIPTION`=:date_inscription,`NOM_DU_PROF_PRINCIPAL`=:prof_principal,`COMMENTAIRESANNEE`=:commentaires WHERE `ID_ELEVE`=:num AND `ANNEE`=:annee";
			$params = array(
				'etab' => $etab,
				'filiere' => $filiere,
				'lv1' => $lv1,
				'lv2' => $lv2,
				'classe' => $classe,
				'date_inscription' => $date_inscription,
				'prof_principal' => $prof_principal,
				'commentaires' => $commentaires,
				'num' => $num,
				'annee' => $annee
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		}
	}

	// Semble être la même requête que le "else" de `modifInscriptionEleve`
	public function modifInscriptionEleve2($num,$annee,$etab,$classe,$prof_principal,$filiere,$lv1,$lv2,$date_inscription,$commentaires)
	{
		$req = "UPDATE `".PdoBD::$villeExtranet."_inscrit` SET `ID`=:etab,`ID_FILIERES`=:filiere,`ID_LV1`=:lv1,`ID_LV2`=:lv2,`ID_CLASSE`=:classe,`DATE_INSCRIPTION`=:date_inscription,`NOM_DU_PROF_PRINCIPAL`=:prof_principal,`COMMENTAIRESANNEE`=:commentaires WHERE `ID_ELEVE`=:num AND `ANNEE`=:annee";
		$params = array(
			'etab' => $etab,
			'filiere' => $filiere,
			'lv1' => $lv1,
			'lv2' => $lv2,
			'classe' => $classe,
			'date_inscription' => $date_inscription,
			'prof_principal' => $prof_principal,
			'commentaires' => $commentaires,
			'num' => $num,
			'annee' => $annee
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function ajoutInscriptionEleve2($num,$annee,$etab,$classe,$prof_principal,$filiere,$lv1,$lv2,$date_inscription,$commentaires,$specialites)
	{
		$req = "INSERT INTO `".PdoBD::$villeExtranet."_inscrit`(`ID_ELEVE`, `ANNEE`, `ID`, `ID_FILIERES`, `ID_LV1`, `ID_LV2`, `ID_CLASSE`, `DATE_INSCRIPTION`, `NOM_DU_PROF_PRINCIPAL`, `COMMENTAIRESANNEE`, `ID_SPECIALITES`) VALUES (:num, :annee, :etab, :filiere, :lv1, :lv2, :classe, :date_inscription, :prof_principal, :commentaires, :specialites)";
		$params = array(
			'num' => $num,
			'annee' => $annee,
			'etab' => $etab,
			'filiere' => $filiere,
			'lv1' => $lv1,
			'lv2' => $lv2,
			'classe' => $classe,
			'date_inscription' => $date_inscription,
			'prof_principal' => $prof_principal,
			'commentaires' => $commentaires,
			'specialites' => $specialites,
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table INTERVENANT  Sans Code
	*/
	public function modifIntervenantSansCode($num, $nom, $prenom, $actif, $date_naissance, $lieu_naissance,$tel, $adresse,$statut, $cp, $ville,$email,$commentaires,$diplome,$numsecu,$nationalite,$photo,$iban,$bic,$compte,$banque,$serviceCivique)
	{
		$req = "UPDATE intervenants SET NOM=:nom,PRENOM=:prenom,ACTIF=:actif,STATUT=:statut,EMAIL=:email,TELEPHONE=:tel,ADRESSE_POSTALE=:adresse,CODE_POSTAL=:cp,VILLE=:ville,DIPLOME=:diplome,COMMENTAIRES=:commentaires,DATE_DE_NAISSANCE=:date_naissance,LIEU_DE_NAISSANCE=:lieu_naissance,NATIONALITE=:nationalite,SECURITE_SOCIALE=:numsecu,PHOTO=:photo, IBAN=:iban, BIC=:bic, COMPTEBANCAIRE=:compte, BANQUE=:banque, SERVICECIVIQUE=:serviceCivique WHERE ID_INTERVENANT=:num";
		$params = array(
			':num' => $num,
			':nom' => $nom,
			':prenom' => $prenom,
			':actif' => $actif,
			':date_naissance' => $date_naissance,
			':lieu_naissance' => $lieu_naissance,
			':tel' => $tel,
			':adresse' => $adresse,
			':statut' => $statut,
			':cp' => $cp,
			':ville' => $ville,
			':email' => $email,
			':commentaires' => $commentaires,
			':diplome' => $diplome,
			':numsecu' => $numsecu,
			':nationalite' => $nationalite,
			':photo' => $photo,
			':iban' => $iban,
			':bic' => $bic,
			':compte' => $compte,
			':banque' => $banque,
			':serviceCivique' => $serviceCivique
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table evenement
	*/
	public function majEvenement($num, $nom, $datededebut, $dateFin, $nb, $cout, $annuler)
	{
		$req = "UPDATE `evenements` SET `EVENEMENT`=:nom,`DATEDEBUT`=:datededebut,`DATEFIN`=:dateFin,`COUTPARENFANT`=:cout, `NBPARTICIPANTS`=:nb,`ANNULER`=:annuler WHERE `NUMÉROEVENEMENT`=:num;";
		$params = array(
			':nom' => $nom,
			':datededebut' => $datededebut,
			':datefin' => $dateFin,
			':cout' => $cout,
			':nb' => $nb,
			':annuler' => $annuler,
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'evenement dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Met a jour une ligne de la table parametre
	*/
	public function modifParametre($num,$nom,$niveau,$type)
	{
		$req = "UPDATE `parametre` SET `ID_AVOIR` = :type,`NOM` = :nom, `NIVEAU`= :niveau WHERE `ID` = :num;";
		$params = array(
			':type' => $type,
			':nom' => $nom,
			':niveau' => $niveau,
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour de l'evenement dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	 * Supprime la présence de tous les élèves pour la journée et le moment spécifiés
	 */
	public function suppElevesPresences($date, $moment)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_appel` WHERE SEANCE = :date AND ID_MOMENT = :moment AND ID_ELEVE IS NOT NULL;";
		$params = array(
			':date' => $date,
			':moment' => $moment
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	 * Supprime la présence de tous les intervenants pour la journée et le moment spécifiés
	 */
	public function suppIntervenantsPresences($date, $moment)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_appel` WHERE SEANCE = :date AND ID_MOMENT = :moment AND ID_INTERVENANT IS NOT NULL;";
		$params = array(
			':date' => $date,
			':moment' => $moment
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	 * Supprime la présence `$num` de la base de données
	 */
	public function suppUnePresence($num)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_appel` WHERE ID = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function suppUnAtelier($num)
	{
		$req = "DELETE FROM `ATELIERS_LUDIQUES` WHERE ID_ATELIERS = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime une ligne de la table EVENEMENT
	*/
	public function suppEvenement($num)
	{
		$req = "DELETE FROM `evenements` WHERE NUMÉROEVENEMENT = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function suppEleve($num)
	{
		$params = array(':num' => $num);

		$req = "DELETE FROM `".PdoBD::$villeExtranet."_difficultes` WHERE ID_ELEVE = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		$req = "DELETE FROM `".PdoBD::$villeExtranet."_appel` WHERE ID_ELEVE = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		$req = "DELETE FROM `".PdoBD::$villeExtranet."_inscription` WHERE ID_ELEVE = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_specialites` WHERE ID_ELEVE = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_inscrit` WHERE ID_ELEVE = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_reglements_eleves` WHERE ID_ELEVE = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		$req = "DELETE FROM `".PdoBD::$villeExtranet."_eleves` WHERE ID_ELEVE = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function suppScolarite($num, $annee)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_inscrit` WHERE ID_ELEVE = :num AND ANNEE = :annee;";
		$params = array(
			':num' => $num,
			':annee' => $annee
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de la scolarite dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function suppIntervenant($num)
	{
		$params = array(':num' => $num);

		// Suppression de ses présences
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_appel` WHERE ID_INTERVENANT = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		// Suppression de ses années scolaires
		$req = "DELETE FROM `inscrit_intervenants` WHERE ID_INTERVENANT = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		// Suppression de ses matières
		$req = "DELETE FROM `specialiser` WHERE ID_INTERVENANT = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		// Suppression de l'intervenant
		$req = "DELETE FROM `intervenants` WHERE ID_INTERVENANT = :num;";
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de leleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime les spécialité d'un intervenent
	*/
	public function suppSpecialiter($num)
	{
		$req = "DELETE FROM `specialiser` WHERE ID_INTERVENANT = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime les difficultés d'un élève
	*/
	public function suppDifficultes($num, $annee)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_difficultes` WHERE ID_ELEVE = :num AND ANNEE = :annee;";
		$params = array(
			':num' => $num,
			':annee' => $annee
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime les spécialités d'un élève
	*/
	public function suppSpecialites($num, $annee)
	{
		$req = "DELETE FROM `quetigny_specialites` WHERE ID_ELEVE = :num AND ANNEE = :annee;";
		$params = array(
			':num' => $num,
			':annee' => $annee
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime un rdv
	*/
	public function supprimerRdv($num)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_rdvparents` WHERE ID_RDV = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime un stage
	*/
	public function supprimerUnStage($num)
	{
		$req = "DELETE FROM `INSCRIPTIONS_STAGE` WHERE `ID_STAGE` = :num;
		DELETE FROM `GROUPE_STAGE` WHERE `ID_STAGE` = :num;
		DELETE FROM `STAGE_PARTENAIRES` WHERE `ID_STAGE` = :num;
		DELETE FROM `STAGE_SEDEROULE` WHERE `ID_STAGE` = :num;
		DELETE FROM `INTERVIENT_STAGE` WHERE `ID_STAGE` = :num;
		DELETE FROM `ATELIERS_LUDIQUES` WHERE `ID_STAGE` = :num;
		DELETE FROM `STAGE_REVISION` WHERE `ID_STAGE` = :num;
		";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime une inscription au stage
	*/
	public function suprInscriptionStage($num, $numInscription)
	{
		$req = "DELETE FROM `ELEVE_STAGE` WHERE `ID_ELEVE_STAGE` = :num;
		DELETE FROM `INSCRIPTIONS_STAGE` WHERE `ID_ELEVE_STAGE` = :num;
		DELETE FROM `PRÉSENCES_STAGE` WHERE `ID_INSCRIPTIONS` = :numInscription";
		$params = array(
			':num' => $num,
			':numInscription' => $numInscription
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime un lieu au stage
	*/
	public function supprimerUnLieu($num)
	{
		$req = "DELETE FROM `LIEUX_STAGE` WHERE `ID_LIEU` = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime un partenaire du stage
	*/
	public function supprimerUnPartenaire($num)
	{
		$req = "DELETE FROM `STAGE_PARTENAIRES` WHERE `ID_PARTENAIRES` = :num;
		DELETE FROM `PARTENAIRES_STAGE` WHERE `ID_PARTENAIRES` = :num1;";
		$params = array(
			':num' => $num,
			':num1' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime un groupe au stage
	*/
	public function supprimerGroupe($num)
	{
		$req = "DELETE FROM `GROUPE_STAGE` WHERE `ID_GROUPE` = :num;
		UPDATE `INSCRIPTIONS_STAGE` SET `ID_GROUPE` = 0 WHERE `ID_GROUPE` = :num";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime un/des élèves d'un groupe
	*/
	public function supprimerElevesDuGroupe($num, $eleves)
	{
		$req = '';
		$params = array('');
		foreach($eleves as $eleve) {
			$req .= "UPDATE `INSCRIPTIONS_STAGE` SET `ID_GROUPE` = 0 WHERE `ID_INSCRIPTIONS` = ?;";
			$params[] = $eleve;
		}
		unset($params[0]);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute un élève au groupe
	*/
	public function ajouterEleveGroupe($inscription, $groupe)
	{
		$req = "UPDATE `INSCRIPTIONS_STAGE` SET ID_GROUPE = :groupe WHERE `ID_INSCRIPTIONS` = :inscription";
		$params = array(
			':groupe' => $groupe,
			':inscription' => $inscription
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de lajout de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

    public function getReglementFratrieStage($num) {
        $req = "SELECT * FROM inscriptions_fratries_stage WHERE ID_INSCRIPTIONS = :num";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
        if ($rs === false) {afficherErreurSQL("Probleme lors de lajout de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
        return $rs;
    }

    public function hasReglementFratrieStage($num) {
        $req = "SELECT * FROM inscriptions_fratries_stage WHERE ID_INSCRIPTIONS = :num OR ID_INSCRIPTIONS2 = :num2";
        $params = array(
			':num' => $num,
            ':num2' => $num
		);
		$rs = $this->ReadAll($req, $params);
        if ($rs === false) {afficherErreurSQL("Probleme lors de lajout de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
        return count($rs) > 0;
    }

    public function getInfosReglementStage($num) {
        $req = "SELECT * FROM `quetigny_info_reglements`
        INNER JOIN `INSCRIPTIONS_STAGE` ON `quetigny_info_reglements`.`ID_INFO_REGLEMENT` = `INSCRIPTIONS_STAGE`.`ID_INFO_REGLEMENT`
        WHERE `INSCRIPTIONS_STAGE`.`ID_INSCRIPTIONS` = :num";
        $params = array(
			':num' => $num
		);
		$rs = $this->Read($req, $params);
        if ($rs === false) {afficherErreurSQL("Probleme lors de lajout de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
        return $rs;
    }

	/**
	* ajoute un règlement d'un élève pour un stage
	*/
	public function AjouterReglementStage($num, $type, $transaction, $banque, $montant, $stage, $stageSortie, $eleves)
	{
		$params = array(
			':stage' => $stage,
			':stageSortie' => $stageSortie,
			':type' => $type,
			':transaction' => $transaction,
			':banque' => $banque,
			':montant' => $montant,
			':num' => $num
		);
		$req = "INSERT INTO quetigny_info_reglements (SOUTIEN, ADESION_CAF, ADESION_TARIF_PLEIN, STAGE, SORTIE_STAGE, DONS)
        VALUES (0, 0, 0, :stage, :stageSortie, 0);
        
        SET @info_reglement_id = LAST_INSERT_ID();

		UPDATE `INSCRIPTIONS_STAGE` SET `ID_INFO_REGLEMENT` = @info_reglement_id, `PAIEMENT_INSCRIPTIONS` = :type, `NUMTRANSACTION` = :transaction, `BANQUE_INSCRIPTION` = :banque, `MONTANT_INSCRIPTION` = :montant WHERE `ID_INSCRIPTIONS` = :num";
		$i = 0;
		foreach ($eleves as $idEleve) {
            $req .= "INSERT INTO inscriptions_fratries_stage(ID_INSCRIPTIONS, ID_INSCRIPTIONS2) VALUES (:num, :idEleve$i);";
			$param[':idEleve$i'] = $idEleve;
			$i++;
        }
		
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de lajout de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime un règlement de stage
	*/
	public function supprimerUnReglementStage($num)
	{
		$req = "UPDATE `INSCRIPTIONS_STAGE` SET `PAIEMENT_INSCRIPTIONS` = NULL, `NUMTRANSACTION` = NULL, `BANQUE_INSCRIPTION` = NULL, `MONTANT_INSCRIPTION` = NULL WHERE `ID_INSCRIPTIONS` = :num;" .
		"DELETE FROM inscriptions_fratries_stage WHERE ID_INSCRIPTIONS = :num";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
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
		/*
		$pdf->SetFont('Arial', '', 18);

		$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
		$pdf->Cell(0, 10, utf8_decode('Liste des élèves inscrits à'),0,1,'C');
		$pdf->Cell(0, 10, utf8_decode($stageSelectionner['NOM_STAGE']),0,1,'C');
		$pdf->Ln();
		*/

		/* liste */
		$pdf->SetFont('Arial', '', 11);
		$pdf->SetFillColor(192,192,192);

		// On parcours les inscriptions
		$i = 0;
		$groupePrec = '';
		$classePrec = '';
		foreach($lesInscriptions as $lInscription) {

			$i++;

			//Si on passe aux lycéens
			if($lInscription['CLASSE_ELEVE_STAGE'] != $classePrec) {

				if($classePrec == 53) {
					// On saute une page
					//$pdf->AddPage();
				}

				$classePrec = $lInscription['CLASSE_ELEVE_STAGE'];
			}

			// Si on change de groupe
			if($lInscription['ID_GROUPE'] != $groupePrec) {

				// Entete
				$pdf->SetFont('Arial', '', 18);

				// Si aucun groupe
				if($lInscription['ID_GROUPE'] == 0) {
					$pdf->Cell(170, 8, utf8_decode('Aucun groupe'),1,1,'C',true);
					$groupePrec = 0;
				} else {

					foreach($lesGroupes as $leGroupe) {

						if($leGroupe['ID_GROUPE'] == $lInscription['ID_GROUPE']) {

							$pdf->Cell(170, 8, utf8_decode(stripslashes($leGroupe['NOM_GROUPE']) . ' (' . stripslashes($leGroupe['SALLES_GROUPE']).')'),1,1,'C',true);
							break;
						}
					}
				}
				$pdf->SetFont('Arial', '', 11);

				$pdf->Cell(10, 5, utf8_decode('N°'),1,0,'C',true);
				$pdf->Cell(80, 5, utf8_decode('NOM'),1,0,'C',true);
				$pdf->Cell(80, 5, utf8_decode('Prénom'),1,1,'C',true);
				//$pdf->Cell(50, 5, utf8_decode('Groupe'),1,1,'C',true);

				$groupePrec = $lInscription['ID_GROUPE'];
			}

			// Ligne de l'inscription
			$pdf->Cell(10, 5, utf8_decode($i),1,0,'C');
			$pdf->Cell(80, 5, utf8_decode(strtoupper(stripslashes($lInscription['NOM_ELEVE_STAGE']))),1,0,'L');
			$pdf->Cell(80, 5, utf8_decode(ucfirst(strtolower(stripslashes($lInscription['PRENOM_ELEVE_STAGE'])))),1,1,'L');

			//$pdf->Cell(50, 5, utf8_decode($nom_groupe),1,1,'L');
		}
		$pdf->Output();
	}

	public function imprimerFicheGroupesSortie($idStage,$idAtelier,$nb,$lesInscriptions,$lesClasses)
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

		/* liste */
		$pdf->SetFont('Arial', '', 11);

		// On parcours les inscriptions
		$i = 0;
		$iGroupe = $nb;
		$numGroupe = 0;
		$classePrec = '';
		foreach($lesInscriptions as $lInscription) {

			$i++;

			// Si on atteint le nb max
			if($iGroupe == $nb) {

				// On saute une page
				if($numGroupe > 0) { $pdf->AddPage(); }

				// Compteur du nb d'élèves du groupe
				$iGroupe = 0;

				// Numéro du groupe
				$numGroupe++;

				// Entete
				$pdf->SetFont('Arial', '', 18);
				$pdf->SetFillColor(192,192,192);

				// Nom du groupe
				$pdf->Cell(185, 8, utf8_decode('Groupe n°'.$numGroupe),1,1,'C',true);

				// Nouveau tableau
				$pdf->SetFont('Arial', '', 11);

				$pdf->Cell(5, 5, utf8_decode('N°'),1,0,'C',true);
				$pdf->Cell(40, 5, utf8_decode('Photo'),1,0,'C',true);
				$pdf->Cell(40, 5, utf8_decode('NOM'),1,0,'C',true);
				$pdf->Cell(40, 5, utf8_decode('Prénom'),1,0,'C',true);
				$pdf->Cell(20, 5, utf8_decode('Classe'),1,0,'C',true);
				$pdf->Cell(40, 5, utf8_decode('Tél'),1,1,'C',true);
				//$pdf->Cell(50, 5, utf8_decode('Groupe'),1,1,'C',true);
			}

			// Nom de la classe
			$laClasse = '';
			foreach($lesClasses as $uneClasse) {
				if($uneClasse['ID'] == $lInscription['CLASSE_ELEVE_STAGE']) {
					$laClasse = $uneClasse['NOM'];
					break;
				}
			}

			$pdf->SetFillColor(255,255,255);

			// Ligne de l'inscription
			$pdf->Cell(5, 30, utf8_decode(($iGroupe+1)),1,0,'C',true);

			$pdf->SetFillColor(0,0,0);
			$pdf->Cell(40, 30, '',1,0,'C',true);

			// Si la photo n'est pas vide
			if($lInscription['PHOTO_ELEVE_STAGE'] != '') {
				$url = 'photosEleves/'.$lInscription['PHOTO_ELEVE_STAGE'];
				$extension = pathinfo($url,PATHINFO_EXTENSION);
				$pdf->Image($url,15,(23+($iGroupe*30)),0,30,$extension);
			}


			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(40, 30, utf8_decode(strtoupper(stripslashes($lInscription['NOM_ELEVE_STAGE']))),1,0,'L',true);
			$pdf->Cell(40, 30, utf8_decode(ucfirst(strtolower(stripslashes($lInscription['PRENOM_ELEVE_STAGE'])))),1,0,'L');
			$pdf->Cell(20, 30, utf8_decode($laClasse),1,0,'L');
			$pdf->Cell(40, 30, utf8_decode(stripslashes($lInscription['TELEPHONE_ELEVE_ELEVE_STAGE'])),1,1,'L');

			$i++;
			$iGroupe++;
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
			//$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
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
			//$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
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
			//$pdf->Cell(40, 10, utf8_decode('Photo'),0,0,'L',true);
			$pdf->Cell(60, 10, utf8_decode('Nom'),1,0,'L',true);
			$pdf->Cell(80, 10, utf8_decode('Observations'),1,0,'L',true);
			$pdf->Cell(30, 10, utf8_decode('Présent ?'),1,0,'C',true);
			$pdf->Ln();

			/* liste des élèves */
			$i = 0;
			foreach($lesInscriptions as $lInscription) {

				if($lInscription['ID_GROUPE'] == $leGroupe['ID_GROUPE']) {
					$position = 90+($i*20);
					//if( $lInscription['PHOTO_ELEVE_STAGE'] == '') { $lInscription['PHOTO_ELEVE_STAGE'] = 'AUCUNE.jpg'; }
					// $lEleve['PHOTO'] = str_replace(' ','%20',$lEleve['PHOTO']);

					//$pdf->Image('https://association-ore.fr/extranet/photosEleves/' . $lInscription['PHOTO_ELEVE_STAGE'],10,$position,0,19);
					// espace pour la photo
					//$pdf->Cell(40, 20, ' ',0,0,'L');
					// nom prénom
					$pdf->Cell(60, 10, utf8_decode(strtoupper(stripslashes($lInscription['NOM_ELEVE_STAGE'])) . ' ' . ucfirst(strtolower(stripslashes($lInscription['PRENOM_ELEVE_STAGE'])))),1,0,'L');
					// espace pour observations
					$pdf->Cell(80, 10, ' ',1,0,'L');
					// case à cocher présent
					$pdf->Cell(30, 10, ' ',1,0,'L');
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
		return $file_headers[0] != 'HTTP/1.1 404 Not Found';
	}

	/* fiche présence soutien scolaire */
	public function imprimerFichesPresencesScolaire($lesClasses,$lesEleves,$num)
	{
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->SetFillColor(192,192,192);
		foreach($lesClasses as $laClasse) {

			// Ne pas afficher BTS et FAC
			if($laClasse['ID'] < 57) {


				$pdf->AddPage();
				$pdf->SetFont('Arial', '', 18);
				//$pdf->Image('https://association-ore.fr/extranet/images/logo.png',0,5,50,0,'PNG');
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
				$pdf->Cell(22, 8, utf8_decode('Mail Parent'),0,0,'C',true);
				$pdf->Cell(23, 8, utf8_decode('Règlement'),0,0,'C',true);
				$pdf->Cell(24, 8, utf8_decode('Photo'),0,0,'C',true);

				$pdf->Ln();

				$pdf->SetFont('Arial', '', 11);

				/* liste des élèves */

				foreach($lesEleves as $lEleve) {


					if($lEleve['ID_CLASSE'] == $laClasse['ID']) {

						// case à cocher présent
						$pdf->Cell(20, 8, ' ',1,0,'L');
						// nom prénom
						$pdf->Cell(70, 8, utf8_decode($lEleve['NOM'] . ' ' . $lEleve['PRENOM']),0,0,'L');


						if( $lEleve['EMAIL_DES_PARENTS'] == null){
							$text = "X";
						$pdf->Cell(20, 8, utf8_decode($text) ,0,0,'L');
						}else if( $lEleve['EMAIL_DES_PARENTS'] != null){
							
						}
						if( $Ligne == null){
							$text = "X";
						$pdf->Cell(20, 8, utf8_decode($text) ,0,0,'L');
						}else if( $Ligne != null){
						
						}
						if( $lEleve['PHOTO'] == null){
							$text = "X";
						$pdf->Cell(20, 8, utf8_decode($text) ,0,0,'L');
						}else if( $lEleve['PHOTO'] != null){
						
						}

					
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

	public function getNbHeuresIntervenant($num, $mois, $annee)
	{
		$req = "SELECT SUM(`HEURES`) FROM `".PdoBD::$villeExtranet."_appel` as `heu` WHERE `ID_INTERVENANT` = :num AND `SEANCE` > :debut AND `SEANCE` < :fin";
		$params = array(
			':num' => $num,
			':debut' => $annee . '-' . $mois . '-01',
			':fin' => $annee . '-' . $mois . '-31'
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// N'est pas utilisé pour le moment
	public function getNbHeuresIntervenantsSalaries($mois, $annee)
	{
		$req = "SELECT SUM(`HEURES`),`".PdoBD::$villeExtranet."_appel`.`ID_INTERVENANT`,`NOM`,`PRENOM` FROM `intervenants` JOIN `".PdoBD::$villeExtranet."_appel` ON `intervenants`.`ID_INTERVENANT` = `".PdoBD::$villeExtranet."_appel`.`ID_INTERVENANT` WHERE `".PdoBD::$villeExtranet."_appel`.`ID_INTERVENANT` IS NOT NULL AND `SEANCE` >= :debut AND `SEANCE` <= :fin AND `STATUT` = 'Salarié' GROUP BY `".PdoBD::$villeExtranet."_appel`.`ID_INTERVENANT`";
		$params = array(
			':debut' => $annee . '-' . $mois . '-01',
			':fin' => $annee . '-' . $mois . '-31'
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
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

	/* Fiche  indemnité */
	public function FichesIndemnites($lesIntervenants, $tarif, $mois, $annee, $reglement, $dateReglement)
	{
		$dateReglement = dateAnglaisVersFrancais($dateReglement);

		/* on créé le PDF */
		require(__DIR__ . '/../fpdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->SetFillColor(220,220,220);

		$i = 0;
		foreach($lesIntervenants as $unIntervenant) {
			// Calculs
			$nbHeures = $unIntervenant['SUMH'];
			$totalAPayer = (float)$nbHeures * $tarif;

			//Si il n'y a aucune heure à payer, on passe au suivant
			if($totalAPayer == 0) { continue; }
			$txtAffich = 'TOTAL A PAYER' . "\n";

			if ( $unIntervenant['PRELEVEMENT'] != 0)	{$totalAPayer -= $unIntervenant['PRELEVEMENT'];
				$txtAffich = 'TOTAL A PAYER' . "\n" . 'Après déduction impôt.';
			}
			
			
			$nom = $unIntervenant['NOM'];
			$prenom = $unIntervenant['PRENOM'];

			//Si il n'y a aucune heure à payer, on passe au suivant
			if($totalAPayer == 0) { continue; }

			$pdf->AddPage();
			$pdf->SetFont('Arial', 'B', 20);
			$pdf->Cell(0, 10, utf8_decode('INDEMNITES DES ANIMATEURS'),0,1,'C');
			$pdf->Ln();
			$pdf->SetFont('Arial', 'B', 26);
			$pdf->MultiCell(0, 12, utf8_decode('FICHE A COMPLETER DANS LE' . "\n" . 'CAS D\'UNE DEPENSE POUR ORE'),1,'C', true);
			$pdf->Ln();

			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(0, 10, utf8_decode('Nom et prénom de l\'animateur : ' . $nom . ' '.$prenom),0,0,'L');
			$pdf->Ln();
			$pdf->Cell(0, 10, utf8_decode('Commission : Scolaire'),0,0,'L');
			$pdf->Ln();
			$pdf->Cell(0, 10, utf8_decode('Détail de l\'indemnité :'),0,0,'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(50, 8, utf8_decode('Mois'),1,0,'L');
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(50, 8, utf8_decode(moisTexte($mois) . ' ' . $annee),1,0,'C');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(50, 8, utf8_decode('Tarif à l\'heure'),1,0,'L');
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(50, 8, utf8_decode($tarif . ' euro net'),1,0,'C');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(50, 8, utf8_decode('Nombre d\'heures'),1,0,'L');
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(50, 8, number_format($nbHeures) . utf8_decode(' h'),1,0,'C');
			$pdf->Ln();

			[$x, $y] = [$pdf->GetX(), $pdf->GetY()];
			$pdf->SetFont('Arial', '', 12);

			$pdf->MultiCell(50, 8, utf8_decode($txtAffich),1,'L');
			$y2 = $pdf->GetY();
			$pdf->SetXY($x + 50, $y);
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(50, $y2 - $y, utf8_decode($totalAPayer . ' euro'),1,0,'C');

			$pdf->Ln();
			$pdf->Cell(50, 8);
			$pdf->Ln();

			$pdf->Cell(50, 10, utf8_decode('Montant de la dépense : '.$totalAPayer . ' euro'),0,0,'L');
			$pdf->Ln();

			$pdf->Cell(0, 10, utf8_decode('Date de la dépense : ' . $dateReglement),0,0,'L');
			$pdf->Ln();

			$pdf->Cell(0, 10, utf8_decode('Règlement : ' . $reglement),0,0,'L');
			$pdf->Ln();
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(0, 10, utf8_decode('Fait à Quetigny le ' . date('d/m/Y')),0,0,'L');
			$pdf->Ln();

			$pdf->Cell(0, 10, utf8_decode('Signature du Trésorier'),0,0,'L');
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
		$req = "DELETE FROM `parametre` WHERE ID = :id;";
		$params = array(
			':id' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression de l'agent dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table ELEVES
	*/
	public function ajoutEleve($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant,$responsable_legal,$tel_parent,$tel_parent2,$tel_parent3, $profession_pere,$adresse,$profession_mere,$ville, $email_parent,$prevenir_parent,$commentaires,$cp,$codebarre)
	{
		$req = "INSERT INTO `".PdoBD::$villeExtranet."_eleves`
		(NOM, PRENOM, SEXE, DATE_DE_NAISSANCE, RESPONSABLE_LEGAL, PRÉVENIR_EN_CAS_D_ABSENCE, PROFESSION_DU_PÈRE, PROFESSION_DE_LA_MÈRE, ADRESSE_POSTALE, CODE_POSTAL, VILLE, TÉLÉPHONE_DES_PARENTS, TÉLÉPHONE_DES_PARENTS2, TÉLÉPHONE_DES_PARENTS3, TÉLÉPHONE_DE_L_ENFANT, EMAIL_DES_PARENTS, EMAIL_DE_L_ENFANT, COMMENTAIRES, CODEBARRETEXTE, SIGNATURE_ASSURANCE, SIGNATURE_RESPONSABILITE)
		VALUES (:nom, :prenom, :sexe, :date_naissance, :responsable, :prevenir_absence, :profession_pere, :profession_mere, :adresse, :cp, :ville, :tel_parent, :tel_parent2, :tel_parent3, :tel_enfant, :email_parent, :email_enfant, :commentaires, :codebarre, 1, 1);";
		$params = array(
			':nom' => strtoupper($nom),
			':prenom' => ucwords($prenom),
			':sexe' => $sexe,
			':date_naissance' => $date_naissance,
			':responsable' => $responsable_legal,
			':prevenir_absence' => $prevenir_parent,
			':profession_pere' => $profession_pere,
			':profession_mere' => $profession_mere,
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => strtoupper($ville),
			':tel_parent' => $tel_parent,
			':tel_parent2' => $tel_parent2,
			':tel_parent3' => $tel_parent3,
			':tel_enfant' => $tel_enfant,
			':email_parent' => $email_parent,
			':email_enfant' => $email_enfant,
			':commentaires' => $commentaires,
			':codebarre' => $codebarre
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table RDVPARENTS
	*/
	public function ajoutRdv($num, $intervenant, $date, $commentaire, $matiere, $duree, $bsb, $idgoogle)
	{
		$req = "INSERT INTO `".PdoBD::$villeExtranet."_rdvparents` VALUES ('', :num, :intervenant, :date, :commentaire, :matiere, :duree, :bsb, :idgoogle);";
		$params = array(
			':num' => $num,
			':intervenant' => $intervenant,
			':date' => $date,
			':commentaire' => addslashes($commentaire),
			':matiere' => $matiere,
			':duree' => $duree,
			':bsb' => $bsb,
			':idgoogle' => $idgoogle
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion du rdv dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute un partenaire
	*/
	public function ajouterPartenaire($nom, $image)
	{
		$req = "INSERT INTO `PARTENAIRES_STAGE` (NOM_PARTENAIRES, IMAGE_PARTENAIRES) VALUES (:nom, :image);";
		$params = array(
			':nom' => $nom,
			':image' => $image
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion du rdv dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table inscrit
	*/
	public function ajoutInscriptionELEVE($maximumNum, $anneeschoix, $etab, $filiere, $lv1, $lv2, $classe, $prof_principal)
	{
		$req = "INSERT INTO `".PdoBD::$villeExtranet."_inscrit` VALUES (:eleve, :annee, :etab, :filiere, :lv1, :lv2, :classe, CURRENT_DATE, :prof, NULL, NULL);";
		$params = array(
			':eleve' => $maximumNum,
			':annee' => $anneeschoix,
			':etab' => $etab,
			':filiere' => $filiere,
			':lv1' => $lv1,
			':lv2' => $lv2,
			':classe' => $classe,
			':prof' => $prof_principal
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* maj une ligne dans la table ELEVES avec password
	*/
	public function modifElevesAvecCode($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant, $responsable_legal, $tel_parent, $tel_parent2, $tel_parent3, $profession_pere, $adresse, $profession_mere, $ville, $email_parent, $prevenir_parent, $commentaires, $cp, $assurance, $codebarre, $password, $num, $numAllocataire, $nbTempsLibres, $contactParents, $photo)
	{
		$req = "UPDATE `".PdoBD::$villeExtranet."_eleves` SET `NOM` = :nom, `PRENOM` = :prenom, `SEXE` = :sexe, `DATE_DE_NAISSANCE` = :date_naissance, `RESPONSABLE_LEGAL` = :responsable, `PRÉVENIR_EN_CAS_D_ABSENCE` = :prevenir, `PROFESSION_DU_PÈRE` = :profession_pere, `PROFESSION_DE_LA_MÈRE` = :profession_mere, `ADRESSE_POSTALE` = :adresse, `CODE_POSTAL` = :cp, `VILLE` = :ville, `TÉLÉPHONE_DES_PARENTS` = :tel_parent, `TÉLÉPHONE_DES_PARENTS2` = :tel_parent2, `TÉLÉPHONE_DES_PARENTS3` = :tel_parent3, `TÉLÉPHONE_DE_L_ENFANT` = :tel_enfant, `EMAIL_DES_PARENTS` = :email_parent, `EMAIL_DE_L_ENFANT` = :email_enfant, `PHOTO` = :photo, `CONTACT_AVEC_LES_PARENTS` = :contact_parents, `COMMENTAIRES` = :commentaires, `N°_ALLOCATAIRE` = :allocataire, `NOMBRE_TPS_LIBRE` = :temps_libres, `ASSURANCE_PÉRISCOLAIRE` = :assurance, `PASSWORD` = :password WHERE `ID_ELEVE` = :eleve;";
		$params = array(
			':nom' => strtoupper($nom),
			':prenom' => ucwords($prenom),
			':sexe' => $sexe,
			':date_naissance' => $date_naissance,
			':responsable' => $responsable_legal,
			':prevenir' => $prevenir_parent,
			':profession_pere' => $profession_pere,
			':profession_mere' => $profession_mere,
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => strtoupper($ville),
			':tel_parent' => $tel_parent,
			':tel_parent2' => $tel_parent2,
			':tel_parent3' => $tel_parent3,
			':tel_enfant' => $tel_enfant,
			':email_parent' => $email_parent,
			':email_enfant' => $email_enfant,
			':photo' => $photo,
			':contact_parents' => $contactParents,
			':commentaires' => $commentaires,
			':allocataire' => $numAllocataire,
			':temps_libres' => $nbTempsLibres,
			':assurance' => $assurance,
			':password' => $password,
			':eleve' => $num
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* maj une ligne dans la table ELEVES sans password
	*/
	public function modifElevesSansCode($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant, $responsable_legal, $tel_parent, $tel_parent2, $tel_parent3, $profession_pere, $adresse, $profession_mere, $ville, $email_parent, $prevenir_parent, $commentaires, $cp, $assurance, $codebarre, $num, $numAllocataire, $nbTempsLibres, $contactParents, $photo)
	{
		$req = "UPDATE `".PdoBD::$villeExtranet."_eleves` SET `NOM` = :nom, `PRENOM` = :prenom, `SEXE` = :sexe, `DATE_DE_NAISSANCE` = :date_naissance, `RESPONSABLE_LEGAL` = :responsable, `PRÉVENIR_EN_CAS_D_ABSENCE` = :prevenir, `PROFESSION_DU_PÈRE` = :profession_pere, `PROFESSION_DE_LA_MÈRE` = :profession_mere, `ADRESSE_POSTALE` = :adresse, `CODE_POSTAL` = :cp, `VILLE` = :ville, `TÉLÉPHONE_DES_PARENTS` = :tel_parent, `TÉLÉPHONE_DES_PARENTS2` = :tel_parent2, `TÉLÉPHONE_DES_PARENTS3` = :tel_parent3, `TÉLÉPHONE_DE_L_ENFANT` = :tel_enfant, `EMAIL_DES_PARENTS` = :email_parent, `EMAIL_DE_L_ENFANT` = :email_enfant, `PHOTO` = :photo, `CONTACT_AVEC_LES_PARENTS` = :contact_parents, `COMMENTAIRES` = :commentaires, `N°_ALLOCATAIRE` = :allocataire, `NOMBRE_TPS_LIBRE` = :temps_libres, `ASSURANCE_PÉRISCOLAIRE` = :assurance WHERE `ID_ELEVE` = :eleve;";
		$params = array(
			':nom' => strtoupper($nom),
			':prenom' => ucwords($prenom),
			':sexe' => $sexe,
			':date_naissance' => $date_naissance,
			':responsable' => $responsable_legal,
			':prevenir' => $prevenir_parent,
			':profession_pere' => $profession_pere,
			':profession_mere' => $profession_mere,
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => strtoupper($ville),
			':tel_parent' => $tel_parent,
			':tel_parent2' => $tel_parent2,
			':tel_parent3' => $tel_parent3,
			':tel_enfant' => $tel_enfant,
			':email_parent' => $email_parent,
			':email_enfant' => $email_enfant,
			':photo' => $photo,
			':contact_parents' => $contactParents,
			':commentaires' => $commentaires,
			':allocataire' => $numAllocataire,
			':temps_libres' => $nbTempsLibres,
			':assurance' => $assurance,
			':eleve' => $num
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* maj une ligne dans la table reglement
	*/
	public function modifReglement($num, $nom, $date, $type, $transaction, $banque, $montant, $commentaire, $eleves, $dons, $adhesion_caf, $adhesion_tarif_plein, $soutien)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_reglements_eleves` WHERE `ID_REGLEMENT` = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		foreach ($eleves as $eleve) {
			$req = "INSERT INTO `".PdoBD::$villeExtranet."_reglements_eleves`(`ID_REGLEMENT`, `ID_ELEVE`) VALUES (:num, :eleve);";
			$params = array(
				':eleve' => $eleve,
				':num' => $num
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		}

		$req = "UPDATE `".PdoBD::$villeExtranet."_reglements` SET `ID_TYPEREGLEMENT` = :type, `NUMTRANSACTION` = :transaction, `BANQUE` = :banque, `DATE_REGLEMENT` = :date, `MONTANT` = :montant, `COMMENTAIRES` = :commentaire, `NOMREGLEMENT` = :nom WHERE `ID` = :id;";
		$params = array(
			':type' => $type,
			':transaction' => $transaction,
			':banque' => $banque,
			':date' => $date,
			':montant' => $montant,
			':commentaire' => $commentaire,
			':nom' => $nom,
			':id' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la mise à jour du règlement dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
        $req = "SELECT ID_INFO_REGLEMENT FROM `" . PdoBD::$villeExtranet . "_reglements` WHERE `ID` = :id;";
        $params = array(
            ':id' => $num
        );

        $rs = $this->Read($req, $params);
        if (!is_null($rs)) {
            $req = "UPDATE `" . PdoBD::$villeExtranet . "_info_reglements` SET `DONS` = :dons, `ADESION_CAF` = :adhesion_caf, `ADESION_TARIF_PLEIN` = :adhesion_tarif_plein, `SOUTIEN` = :soutien WHERE `ID_INFO_REGLEMENT` = :id;";
            $params = array(
                ':soutien' => $soutien,
                ':adhesion_caf' => $adhesion_caf,
                ':adhesion_tarif_plein' => $adhesion_tarif_plein,
                ':dons' => $dons,
                ':id' => $rs['ID_INFO_REGLEMENT']
            );
            $this->NonQuery($req, $params);
        }
    }

	/**
	* ajoute une ligne dans la table Parametre
	*/
	public function InsertParametre($id, $nom, $niveau, $type, $value)
	{
		$req = "INSERT INTO `parametre` (`ID`, `ID_AVOIR`, `NOM`, `NIVEAU`, `VALEUR`) VALUES (:id, :type, :nom, :niveau, :value);";
		$params = array(
			':id' => $id,
			':type' => $type,
			':nom' => $nom,
			':niveau' => $niveau,
			':value' => $value
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table APPEL pour les intervenants
	*/
	public function ajoutAppelIntervenant($numero, $date, $heure, $moment)
	{
		$params = array(
			':numero' => $numero,
			':date' => $date,
			':heure' => $heure,
			':moment' => $moment
		);

		$req1 = "SELECT * FROM `".PdoBD::$villeExtranet."_appel` WHERE ID_INTERVENANT = :numero AND SEANCE = :date AND HEURES = :heure AND ID_MOMENT = :moment;";
		$rs1 = $this->ReadAll($req1, $params);
		if ($rs1 === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req1, PdoBD::$monPdo->errorInfo());}

		if (count($rs1) === 0) {
			$req = "INSERT INTO `".PdoBD::$villeExtranet."_appel` (`ID_INTERVENANT`, `SEANCE`, `HEURES`, `ID_MOMENT`) VALUES (:numero, :date, :heure, :moment);";
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		}
	}

	/**
	* ajoute une ligne dans la table APPEL pour les eleves, selon la date et le moment de la journée fournis
	*/
	public function ajoutAppelEleveCase($numero, $date, $moment)
	{
		$params = array(
			':numero' => $numero,
			':date' => $date,
			':moment' => $moment
		);

		$req1 = "SELECT * FROM `".PdoBD::$villeExtranet."_appel` WHERE ID_ELEVE = :numero AND SEANCE = :date AND ID_MOMENT = :moment;";
		$rs1 = $this->ReadAll($req1, $params);
		if ($rs1 === false) {afficherErreurSQL("Probleme lors de la lecture des annees ..", $req1, PdoBD::$monPdo->errorInfo());}

		if (count($rs1) === 0) {
			$req = "INSERT INTO `".PdoBD::$villeExtranet."_appel` (`ID_ELEVE`, `SEANCE`, `ID_MOMENT`) VALUES (:numero, :date, :moment);";
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		}
	}

	/**
	* ajoute une ligne dans la table Intervenants
	*/
	public function ajoutIntervenant($annee, $nom, $prenom, $actif, $date_naissance, $lieu_naissance, $tel, $adresse, $statut, $cp, $ville, $email, $commentaires, $diplome, $numsecu, $nationalite, $password, $iban, $bic, $compte, $banque)
	{
		$req = "INSERT INTO `intervenants` VALUES ('', :nom, :prenom, :actif, :statut, :email, :tel, :adresse, :cp, :ville, :diplome, :commentaires, :date_naissance, :lieu_naissance, :nationalite, :numsecu, 'AUCUNE.jpg', '', '', '', '', :password, 0, :iban, :bic, :compte, :banque, '');";
		$params = array(
			'nom' => $nom,
			'prenom' => $prenom,
			'actif' => $actif,
			'date_naissance' => $date_naissance,
			'lieu_naissance' => $lieu_naissance,
			'tel' => $tel,
			'adresse' => $adresse,
			'statut' => $statut,
			'cp' => $cp,
			'ville' => $ville,
			'email' => $email,
			'commentaires' => $commentaires,
			'diplome' => $diplome,
			'numsecu' => $numsecu,
			'nationalite' => $nationalite,
			'password' => $password,
			'iban' => $iban,
			'bic' => $bic,
			'compte' => $compte,
			'banque' => $banque,
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'intervenant dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		$req = "INSERT INTO `inscrit_intervenants` (`ID_INTERVENANT`, `ANNEE`) VALUES ((SELECT MAX(ID_INTERVENANT) FROM intervenants), :annee)";
		$params = array(':annee' => $annee);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'intervenant dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* ajoute une ligne dans la table Evenements
	*/
	public function ajoutEvenement($nom, $cout, $nb, $dateDebut, $dateFin)
	{
		$req = "INSERT INTO `evenements` (`EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER`) VALUES (:nom, :debut, :fin, :cout, :nb, 0);";
		$params = array(
			':nom' => $nom,
			':debut' => $dateDebut,
			':fin' => $dateFin,
			':cout' => $cout,
			':nb' => $nb
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table DIFFICULTE
	*/
	public function ajoutDifficulte($eleve, $valeur, $annee)
	{
		$req = "INSERT INTO `".PdoBD::$villeExtranet."_difficultes` (ID, ID_ELEVE, ANNEE) VALUES (:valeur, :eleve, :annee);";
		$params = array(
			':valeur' => $valeur,
			':eleve' => $eleve,
			':annee' => $annee
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	public function ajoutSpecialites($eleve, $valeur, $annee)
	{
		$req = "INSERT INTO `quetigny_specialites` (ID, ID_ELEVE, ANNEE) VALUES (:valeur, :eleve, :annee);";
		$params = array(
			':valeur' => $valeur,
			':eleve' => $eleve,
			':annee' => $annee
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de specialites dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table Presence
	*/
	public function ajoutPlanning($intervenant, $valeur)
	{
		$req = "INSERT INTO `".PdoBD::$villeExtranet."_presence` VALUES (:intervenant, :valeur, 0);";
		$params = array(
			':intervenant' => $intervenant,
			':valeur' => $valeur
		);
		$rs = $this->NonQuery($req, $params);
		//if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table specialiser
	*/
	public function ajoutSpecialite($intervenant, $valeur)
	{
		$req = "INSERT INTO `specialiser` VALUES (:intervenant, :valeur);";
		$params = array(
			':intervenant' => $intervenant,
			':valeur' => $valeur
		);
		$rs = $this->NonQuery($req, $params);

		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table remisecaf
	*/
	public function ajoutRemiseCAF($num)
	{
		$req = "INSERT INTO `remisecaf` (`ID`, `DATE_CAF`) VALUES (:num, NOW());";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* ajoute une ligne dans la table remisecheque
	*/
	public function ajoutRemiseCheque($num)
	{
		$req = "INSERT INTO `remisecheque` (`ID`, `DATE_CHEQUE`) VALUES (:num, NOW());";
		$params = array(
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de la difficulté dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Retourne dans un tableau associatifles informations de la table PARAMETRE (pour un type particulier)
	*/
	public function getParametre($type)
	{
		$req = "SELECT ID, NOM, VALEUR FROM `parametre` WHERE ID_AVOIR = :type;";
		$params = array(
			':type' => $type
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un seul parametre
	*/
	public function getParametreSeul($type)
	{
		$req = "SELECT ID, NOM FROM `parametre` WHERE ID_AVOIR = :type LIMIT 0,1;";
		$params = array(
			':type' => $type
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	 * Retourne le paramètre avec l'id spécifié
	 */
	public function getParametreId($id)
	{
		$req = "SELECT ID, NOM, NIVEAU, VALEUR FROM `parametre` WHERE id = :id LIMIT 1;";
		$params = array(
			':id' => $id
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du paramètre dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau les lieux de stage
	*/
	public function getLieux()
	{
		$req = "SELECT * FROM `LIEUX_STAGE` ORDER by `NOM_LIEU`;";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des lieux dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau les groupes de stage
	*/
	public function getGroupes($stage)
	{
		$req = "SELECT * FROM `GROUPE_STAGE` WHERE `ID_STAGE` = :stage ORDER by `NOM_GROUPE`;";
		$params = array(
			':stage' => $stage
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau les reglements de stage
	*/
	public function getReglementsStage($stage)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE` = :stage;";
		$params = array(
			':stage' => $stage
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau les reglements de stage triés
	*/
	public function getReglementsStageTrie($stage)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE` = :stage ORDER BY `PAIEMENT_INSCRIPTIONS`;";
		$params = array(
			':stage' => $stage
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getLesReglementsStage($num, $dateDebut, $dateFin, $type)
	{
        $params = array(
            ':dateDebut' => $dateDebut,
            ':dateFin' => $dateFin,
            ':num' => $num
        );
		if ($type == -1) {
			$req = "SELECT *, DATE_FORMAT(DATE_INSCRIPTIONS, '%d/%m/%Y') as DATE FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` WHERE `DATE_INSCRIPTIONS` BETWEEN DATE_SUB(:dateDebut, INTERVAL 1 DAY) AND DATE_ADD(:dateFin, INTERVAL 1 DAY) AND (`INSCRIPTIONS_STAGE`.`ID_STAGE` = :num AND `INSCRIPTIONS_STAGE`.`DATE_INSCRIPTIONS` AND PAIEMENT_INSCRIPTIONS <> '') ORDER BY `DATE_INSCRIPTIONS`;";
		} else {
			$req = "SELECT *, DATE_FORMAT(DATE_INSCRIPTIONS, '%d/%m/%Y') as DATE FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` WHERE `DATE_INSCRIPTIONS` BETWEEN DATE_SUB(:dateDebut, INTERVAL 1 DAY) AND DATE_ADD(:dateFin, INTERVAL 1 DAY) AND (`INSCRIPTIONS_STAGE`.`ID_STAGE` = :num AND `INSCRIPTIONS_STAGE`.`DATE_INSCRIPTIONS` AND PAIEMENT_INSCRIPTIONS = :type) ORDER BY `DATE_INSCRIPTIONS`;";
			$params[':type'] = $type;
		}
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau un reglements de stage triés
	*/
	public function getUnReglementStage($inscription)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` where `ID_INSCRIPTIONS` = :id";
		$params = array(
			':id' => $inscription
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau un reglements de stage triés
	*/
	public function modifierReglementStage($num, $type, $transaction, $banque, $montant, $eleves, $stage, $stageSortie)
	{
		$req = "DELETE FROM `inscriptions_fratries_stage` WHERE `ID_INSCRIPTIONS` = :num";
		$params = array(
			':num' => $num
		);
		$this->NonQuery($req, $params);
		
		if (count($eleves) > 0) {
            $req = "";
            $i = 0;
            $params = array(
                ':num' => $num
            );
            foreach ($eleves as $eleve) {
                $placeholder = ":eleve" . $i;
                $req .= "INSERT INTO `inscriptions_fratries_stage`(`ID_INSCRIPTIONS`, `ID_INSCRIPTIONS2`) VALUES (:num, $placeholder);";
                $params[$placeholder] = $eleve;
                $i++;
            }
            $rs = $this->NonQuery($req, $params);
            if ($rs === false) {afficherErreurSQL("Probleme lors de la fratries dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
        }

		$req = "UPDATE `INSCRIPTIONS_STAGE` SET `PAIEMENT_INSCRIPTIONS` = :type, `NUMTRANSACTION` = :transaction, `BANQUE_INSCRIPTION` = :banque, `MONTANT_INSCRIPTION` = :montant WHERE `ID_INSCRIPTIONS` = :num";
		$params = array(
			':type' => $type,
			':transaction' => $transaction,
			':banque' => $banque,
			':montant' => $montant,
			':num' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
        $req = "SELECT ID_INFO_REGLEMENT FROM `INSCRIPTIONS_STAGE` WHERE `ID_INSCRIPTIONS` = :id;";
        $params = array(
            ':id' => $num
        );

        $rs = $this->Read($req, $params);
        if (!is_null($rs)) {
            $req = "UPDATE `" . PdoBD::$villeExtranet . "_info_reglements` SET `STAGE` = :stage, `SORTIE_STAGE` = :storiestage WHERE `ID_INFO_REGLEMENT` = :id;";
            $params = array(
                ':stage' => $stage,
                ':storiestage' => $stageSortie,
                ':id' => $rs['ID_INFO_REGLEMENT']
            );
            $this->NonQuery($req, $params);
        }
	}

	/**
	* Retourne dans un tableau les élèves d'un groupe de stage
	*/
	public function getElevesDuGroupe($groupe)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_GROUPE` = :groupe;";
		$params = array(
			':groupe' => $groupe
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des groupes dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau les années scolaires
	*/
	public function getAnneesScolaires()
	{
		$req = "SELECT * FROM `annee_scolaire` ORDER BY TEXTE";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau les stages
	*/
	public function getStages()
	{
		$req = "SELECT * FROM `STAGE_REVISION` WHERE ANNEE_STAGE = ".PdoBD::$anneeExtranet." ORDER BY DATEDEB_STAGE DESC";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne le nb de présences d'un élève dans un stage
	*/
	public function nbPresencesStage($idStage, $idEleve)
	{
		$req = "SELECT COUNT(*) FROM `PRÉSENCES_STAGE` INNER JOIN `INSCRIPTIONS_STAGE` ON `PRÉSENCES_STAGE`.ID_INSCRIPTIONS = `INSCRIPTIONS_STAGE`.ID_INSCRIPTIONS WHERE `PRÉSENCES_STAGE`.ID_INSCRIPTIONS = :eleve AND `INSCRIPTIONS_STAGE`.ID_STAGE = :stage;";
		$params = array(
			':eleve' => $idEleve,
			':stage' => $idStage
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne l'id d'inscription d'un élève inscrit à un stage
	*/
	public function getIdInscriptionStage($idStage, $idEleve)
	{
		$req = "SELECT * FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.ID_ELEVE_STAGE = `ELEVE_STAGE`.ID_ELEVE_STAGE WHERE `ELEVE_STAGE`.ID_ELEVE_ANCIENNE_TABLE = :eleve AND `INSCRIPTIONS_STAGE`.ID_STAGE = :stage";
		$params = array(
			':eleve' => $idEleve,
			':stage' => $idStage
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs !== null ? $rs['ID_INSCRIPTIONS'] : null;
	}

	/**
	* Retourne dans un tableau les villes
	*/
	public function getVilles()
	{
		$req = "SELECT VILLE FROM `".PdoBD::$villeExtranet."_eleves` ORDER BY VILLE";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}

		// Suppression des doublons
		$lesVilles = array();
		foreach ($rs as $uneLigne) {
			if(!in_array($uneLigne, $lesVilles, true)) {
				$lesVilles[] = $uneLigne;
			}
		}
		return $lesVilles;
	}

	public function VillesFrance()
	{
		$req = "SELECT * FROM villes ORDER BY cp ASC";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Importer un élève déjà existant
	*/
	public function importerEleveStage($eleve, $inscription, $annee)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_inscrit`.ID_ELEVE WHERE `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = :eleve AND `".PdoBD::$villeExtranet."_inscrit`.ANNEE = :annee";
		$params = array(
			':eleve' => $eleve,
			':annee' => $annee
		);
		$laLigne = $this->Read($req, $params);
		if ($laLigne === false || $laLigne === null) {
			afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoBD::$monPdo->errorInfo());
		}

		$req = "UPDATE `ELEVE_STAGE` SET `NOM_ELEVE_STAGE` = :nom,
		`PRENOM_ELEVE_STAGE` = :prenom,
		`SEXE_ELEVE_STAGE` = :sexe,
		`ETABLISSEMENT_ELEVE_STAGE` = :etab,
		`CLASSE_ELEVE_STAGE` = :classe,
		`TELEPHONE_PARENTS_ELEVE_STAGE` = :tel_parents,
		`TELEPHONE_ELEVE_ELEVE_STAGE` = :tel_enfant,
		`EMAIL_PARENTS_ELEVE_STAGE` = :email_parents,
		`EMAIL_ENFANT_ELEVE_STAGE` = :email_enfant,
		`ADRESSE_ELEVE_STAGE` = :adresse,
		`CP_ELEVE_STAGE` = :cp,
		`VILLE_ELEVE_STAGE` = :ville,
		`ID_ELEVE_ANCIENNE_TABLE` = :id,
		`PHOTO_ELEVE_STAGE` = :photo,
		`DDN_ELEVE_STAGE` = :ddn,
		`FILIERE_ELEVE_STAGE` = :filiere
		WHERE `ID_ELEVE_STAGE` = :inscription";
		$params = array(
			':id' => $laLigne['ID_ELEVE'],
			':nom' => addslashes($laLigne['NOM']),
			':prenom' => addslashes($laLigne['PRENOM']),
			':sexe' => $laLigne['SEXE'],
			':ddn' => $laLigne['DATE_DE_NAISSANCE'],
			':adresse' => addslashes($laLigne['ADRESSE_POSTALE']),
			':cp' => $laLigne['CODE_POSTAL'],
			':ville' => addslashes($laLigne['VILLE']),
			':tel_parents' => $laLigne['TÉLÉPHONE_DES_PARENTS'],
			':tel_enfant' => $laLigne['TÉLÉPHONE_DE_L_ENFANT'],
			':email_parents' => addslashes($laLigne['EMAIL_DES_PARENTS']),
			':email_enfant' => addslashes($laLigne['EMAIL_DE_L_ENFANT']),
			':photo' => $laLigne['PHOTO'],
			':classe' => $laLigne['ID_CLASSE'],
			':filiere' => $laLigne['ID_FILIERES'],
			':etab' => $laLigne['ID'],
			':inscription' => $inscription
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Importer un élève pas existant
	*/
	public function importerEleveStageNouveau($eleve, $idStage, $annee)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_inscrit`.ID_ELEVE WHERE `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = :eleve AND `".PdoBD::$villeExtranet."_inscrit`.ANNEE = :annee";
		$params = array(
			':eleve' => $eleve,
			':annee' => $annee
		);
		$laLigne = $this->Read($req, $params);
		if ($laLigne === false || $laLigne === null) {
			afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoBD::$monPdo->errorInfo());
		}

		$req = "INSERT INTO `ELEVE_STAGE`
		(`NOM_ELEVE_STAGE`, `PRENOM_ELEVE_STAGE`, `SEXE_ELEVE_STAGE`, `ETABLISSEMENT_ELEVE_STAGE`, `CLASSE_ELEVE_STAGE`, `ASSOCIATION_ELEVE_STAGE`, `TELEPHONE_PARENTS_ELEVE_STAGE`, `TELEPHONE_ELEVE_ELEVE_STAGE`, `EMAIL_PARENTS_ELEVE_STAGE`, `EMAIL_ENFANT_ELEVE_STAGE`, `ADRESSE_ELEVE_STAGE`, `CP_ELEVE_STAGE`, `VILLE_ELEVE_STAGE`, `ID_ELEVE_ANCIENNE_TABLE`, `PHOTO_ELEVE_STAGE`, `DDN_ELEVE_STAGE`, `FILIERE_ELEVE_STAGE`, `DOCUMENT1_STAGE`, `DOCUMENT2_STAGE`, `DOCUMENT3_STAGE`)
		VALUES (:nom, :prenom, :sexe, :etab, :classe, 'ore', :tel_parents, :tel_enfant, :email_parents, :email_enfant, :adresse, :cp, :ville, :eleve, :photo, :ddn, :filiere, NULL, NULL, NULL);

		INSERT INTO `INSCRIPTIONS_STAGE`
		(`ID_STAGE`, `ID_GROUPE`, `ID_ELEVE_STAGE`, `ID_ATELIERS`, `VALIDE`, `DATE_INSCRIPTIONS`, `IP_INSCRIPTIONS`, `USER_AGENT_INSCRIPTIONS`, `ORIGINE_INSCRIPTIONS`, `COMMENTAIRES_INSCRIPTIONS`, `PAIEMENT_INSCRIPTIONS`, `NUMTRANSACTION`, `BANQUE_INSCRIPTION`, `MONTANT_INSCRIPTION`)
		VALUES (:idStage, 0, (SELECT MAX(`ID_ELEVE_STAGE`) FROM `ELEVE_STAGE`), 0, 0, CURRENT_DATE, NULL, '', '', NULL, NULL, NULL, NULL, NULL);";
		$params = array(
			':nom' => addslashes($laLigne['NOM']),
			':prenom' => addslashes($laLigne['PRENOM']),
			':sexe' => $laLigne['SEXE'],
			':etab' => $laLigne['ID'],
			':classe' => $laLigne['ID_CLASSE'],
			':tel_parents' => $laLigne['TÉLÉPHONE_DES_PARENTS'],
			':tel_enfant' => $laLigne['TÉLÉPHONE_DE_L_ENFANT'],
			':email_parents' => addslashes($laLigne['EMAIL_DES_PARENTS']),
			':email_enfant' => addslashes($laLigne['EMAIL_DE_L_ENFANT']),
			':adresse' => addslashes($laLigne['ADRESSE_POSTALE']),
			':cp' => $laLigne['CODE_POSTAL'],
			':ville' => addslashes($laLigne['VILLE']),
			':eleve' => $laLigne['ID_ELEVE'],
			':photo' => $laLigne['PHOTO'],
			':ddn' => $laLigne['DATE_DE_NAISSANCE'],
			':filiere' => $laLigne['ID_FILIERES'],
			':idStage' => $idStage
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l\'importation.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Importer un intervenant
	*/
	public function importerIntervenantStage($num)
	{
		$req = "SELECT * FROM `intervenants` WHERE `ID_INTERVENANT` = :num";
		$params = array(
			':num' => $num
		);
		$laLigne = $this->Read($req, $params);
		if ($laLigne === false) {afficherErreurSQL("Probleme lors de l'importation.", $req, PdoBD::$monPdo->errorInfo());}

		$req = "INSERT INTO `INTERVENANT_STAGE`(`ID_INTERVENANT`, `NOM_INTERVENANT`, `PRENOM_INTERVENANT`, `EMAIL_INTERVENANT`, `TEL_INTERVENANT`)
		VALUES (:id, :nom, :prenom, :email, :tel)";
		$params = array(
			':id' => $laLigne['ID_INTERVENANT'],
			':nom' => addslashes($laLigne['NOM']),
			':prenom' => addslashes($laLigne['PRENOM']),
			':tel' => addslashes($laLigne['TELEPHONE']),
			':email' => addslashes($laLigne['EMAIL'])
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'importation'", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* Retourne dans un tableau associatifles informations de la table specialiser (pour une personne en particulier)
	*/
	public function getSpecialisationIntervenant($num)
	{
		$req = "SELECT ID FROM `specialiser` WHERE ID_INTERVENANT = :num ORDER by ID;";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau associatifles informations de la table difficulter (pour une personne en particulier)
	*/
	public function getDifficultesEleve($eleve, $annee)
	{
		$req = "SELECT ID FROM `".PdoBD::$villeExtranet."_difficultes` WHERE ID_ELEVE = :eleve AND ANNEE = :annee ORDER BY ID;";
		$params = array(
			':eleve' => $eleve,
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function getSpecialitesEleve($eleve, $annee)
	{
		$req = "SELECT ID FROM `".PdoBD::$villeExtranet."_specialites` WHERE ID_ELEVE = :eleve AND ANNEE = :annee ORDER BY ID;";
		$params = array(
			':annee' => $annee,
			':eleve' => $eleve
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des parametres dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Mettre à jour les coordonnées GPS pour un élève
	public function majCoordonneesEleves($num, $lat, $lon) {
		$req = "INSERT INTO `".PdoBD::$villeExtranet."_localisation_eleves` (`ID_ELEVE`, `LAT`, `LON`) VALUES (:num, :lat, :lon)";
		$params = array(
			':num' => $num,
			':lat' => $lat,
			':lon' => $lon
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau associatif les informations de la table inscription (pour une personne en particulier)
	*/
	public function recupEvenementEleve($num)
	{
		$req = "SELECT `".PdoBD::$villeExtranet."_inscription`.`NUMÉROEVENEMENT`, `EVENEMENT`, `DATEDEBUT`, `DATEFIN`, `COUTPARENFANT`, `NBPARTICIPANTS`, `ANNULER` FROM `evenements` INNER JOIN `".PdoBD::$villeExtranet."_inscription` ON `".PdoBD::$villeExtranet."_inscription`.NUMÉROEVENEMENT = `evenements`.NUMÉROEVENEMENT WHERE ID_ELEVE = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les élèves ayant participé à un évèvement
	*/
	public function recupElevesEvenements($event)
	{
		$req = "SELECT NOM, PRENOM FROM `evenements` INNER JOIN `".PdoBD::$villeExtranet."_inscription` ON `".PdoBD::$villeExtranet."_inscription`.NUMÉROEVENEMENT = `evenements`.NUMÉROEVENEMENT INNER JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_inscription`.ID_ELEVE=`".PdoBD::$villeExtranet."_eleves`.ID_ELEVE WHERE `".PdoBD::$villeExtranet."_inscription`.NUMÉROEVENEMENT = :event;";
		$params = array(
			':event' => $event
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau les localisations des élèves d'une année
	*/
	public function recupLocalisations($annee)
	{
		$req = "SELECT * FROM `".PdoBD::$villeExtranet."_localisation_eleves` JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_localisation_eleves`.`ID_ELEVE` = `".PdoBD::$villeExtranet."_inscrit`.`ID_ELEVE` WHERE `".PdoBD::$villeExtranet."_inscrit`.`ANNEE` = :annee";
		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau associatifles les reglements (pour une personne en particulier) dapres le ID DUN ELEVE
	*/
	public function recupReglementsUnEleve($eleve)
    {
		$req = "SELECT `".PdoBD::$villeExtranet."_reglements`.`ID`, `".PdoBD::$villeExtranet."_reglements`.`ID_INFO_REGLEMENT`, parametre.NOM, `ID_APPARTIENT_RCAF`, `ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMTRANSACTION`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, `COMMENTAIRES`, `NOMREGLEMENT` FROM `".PdoBD::$villeExtranet."_reglements`" .
			" INNER JOIN `parametre` ON `".PdoBD::$villeExtranet."_reglements`.ID_TYPEREGLEMENT=`parametre`.ID" .
			" INNER JOIN `" . PdoBD::$villeExtranet."_reglements_eleves` ON `".PdoBD::$villeExtranet."_reglements_eleves`.ID_REGLEMENT=`".PdoBD::$villeExtranet."_reglements`.ID" .
			" WHERE `".PdoBD::$villeExtranet."_reglements_eleves`.ID_ELEVE = :eleve";
		$params = array(
			':eleve' => $eleve
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
    }

	/**
	* Retourne dans un tableau associatifles le reglement (pour une personne en particulier) dapres le ID DUN reglement
	*/
	public function recupUnReglementUnEleve($eleve)
	{
		$req = "SELECT `".PdoBD::$villeExtranet."_reglements`.`ID`, NOM, `ID_APPARTIENT_RCAF`, `ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMTRANSACTION`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, `COMMENTAIRES`, `NOMREGLEMENT`, ID_INFO_REGLEMENT FROM `".PdoBD::$villeExtranet."_reglements` INNER JOIN `parametre` ON `".PdoBD::$villeExtranet."_reglements`.ID_TYPEREGLEMENT=`parametre`.ID  WHERE `".PdoBD::$villeExtranet."_reglements`.`ID` = :eleve;";
		$params = array(
			':eleve' => $eleve
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne dans un tableau associatifles les reglements (pour une personne en particulier) dapres le ID DUN ELEVE si c'est payer par CAF
	*/
	public function recupReglementsUnEleveCAF($eleve, $journal)
	{
		$req = "SELECT `".PdoBD::$villeExtranet."_reglements`.`ID`, NOM, `ID_APPARTIENT_RCAF`, `ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMTRANSACTION`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, `COMMENTAIRES`, `NOMREGLEMENT` FROM `".PdoBD::$villeExtranet."_reglements` INNER JOIN `".PdoBD::$villeExtranet."_reglements_eleves` ON `".PdoBD::$villeExtranet."_reglements`.ID = `".PdoBD::$villeExtranet."_reglements_eleves`.ID_REGLEMENT INNER JOIN `parametre` ON `".PdoBD::$villeExtranet."_reglements`.ID_TYPEREGLEMENT=`parametre`.ID WHERE `".PdoBD::$villeExtranet."_reglements_eleves`.`ID_ELEVE` = :eleve AND ID_TYPEREGLEMENT = 3 AND ID_APPARTIENT_RCAF = :journal;";
		$params = array(
			':eleve' => $eleve,
			':journal' => $journal
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne un reglement dapres son  ID
	*/
	public function recupReglement($num)
	{
		$req = "SELECT NOMBRE_TPS_LIBRE, N°_ALLOCATAIRE, `".PdoBD::$villeExtranet."_reglements`.`ID`, `parametre`.NOM as NOMPARA, `ID_APPARTIENT_RCAF`, `".PdoBD::$villeExtranet."_eleves`.NOM as NOMELEVE, PRENOM,`ID_APPARTIENT_RCHEQUE`, `ID_TYPEREGLEMENT`, `NUMTRANSACTION`, `BANQUE`, `TRANSFERERTRESORIER`, `DATE_REGLEMENT`, `MONTANT`, `".PdoBD::$villeExtranet."_reglements`.`COMMENTAIRES` as com, `NOMREGLEMENT` FROM `".PdoBD::$villeExtranet."_reglements`" .
			" INNER JOIN `parametre` ON `".PdoBD::$villeExtranet."_reglements`.ID_TYPEREGLEMENT=`parametre`.ID".
			" INNER JOIN `" . PdoBD::$villeExtranet."_reglements_eleves`" . " ON `".PdoBD::$villeExtranet."_reglements_eleves`.ID_REGLEMENT=`".PdoBD::$villeExtranet."_reglements`.ID" .
			" INNER JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE=`".PdoBD::$villeExtranet."_reglements_eleves`.ID_ELEVE " .
			"WHERE `".PdoBD::$villeExtranet."_reglements`.`ID` = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupeElevesWithReglement($num) {
		$req = "SELECT `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE, `".PdoBD::$villeExtranet."_eleves`.NOM, `".PdoBD::$villeExtranet."_eleves`.PRENOM FROM `".PdoBD::$villeExtranet."_reglements`" .
			" INNER JOIN `".PdoBD::$villeExtranet."_reglements_eleves`" . " ON `".PdoBD::$villeExtranet."_reglements_eleves`.ID_REGLEMENT=`".PdoBD::$villeExtranet."_reglements`.ID" .
			" INNER JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE=`".PdoBD::$villeExtranet."_reglements_eleves`.ID_ELEVE " .
			"WHERE `".PdoBD::$villeExtranet."_reglements`.`ID` = :num;";
        $params = array(
            ':num' => $num
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

    public function recupeReglementWithInfosReglement($num) {
        $req = "SELECT * FROM `quetigny_reglements` WHERE `quetigny_reglements`.`ID_INFO_REGLEMENT` = :num;";
        $params = array(
            ':num' => $num
        );
        $rs = $this->Read($req, $params);
        if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
        return $rs;
    }

    public function nbElevesAdherents($annee, &$nbAdherents, &$nbAdherentsCAF, &$nbFamillesTotal, &$nbEleveSoutien)
    {
        $req = "SELECT ID_ELEVE, ID_ELEVE2 FROM quetigny_eleves_fratries";
        $result = $this->ReadAll($req);

        $req2 = "SELECT quetigny_reglements_eleves.ID_ELEVE,".PdoBD::$villeExtranet."_info_reglements.ADESION_CAF,".PdoBD::$villeExtranet."_info_reglements.ADESION_TARIF_PLEIN,".PdoBD::$villeExtranet."_info_reglements.SOUTIEN FROM `quetigny_reglements` " .
            " INNER JOIN `quetigny_reglements_eleves` ON `quetigny_reglements_eleves`.ID_REGLEMENT = `quetigny_reglements`.ID" .
            " INNER JOIN `".PdoBD::$villeExtranet."_info_reglements`" . " ON `".PdoBD::$villeExtranet."_reglements`.ID_INFO_REGLEMENT = `".PdoBD::$villeExtranet."_info_reglements`.ID_INFO_REGLEMENT" .
            " WHERE ".PdoBD::$villeExtranet."_reglements.NOMREGLEMENT = :annee AND (".PdoBD::$villeExtranet."_info_reglements.ADESION_TARIF_PLEIN = 1 OR ".PdoBD::$villeExtranet."_info_reglements.ADESION_CAF = 1 OR ".PdoBD::$villeExtranet."_info_reglements.SOUTIEN = 1);";
        $params = array(
            ':annee' => 'Soutien scolaire ' . $annee . '-' . ($annee + 1)
        );
        $result2 = $this->ReadAll($req2, $params);

        $groups = [];

        foreach ($result as $row) {
            $idEleve = $row['ID_ELEVE'];
            $idEleve2 = $row['ID_ELEVE2'];

            // Vérification si le groupe existe déjà dans le tableau
            $groupExists = false;
            foreach ($groups as &$group) {

                if (in_array($idEleve, $group) || in_array($idEleve2, $group)) {
                    $group[] = $idEleve;
                    $group[] = $idEleve2;
                    $groupExists = true;
                    break;
                }
            }

            // Création d'un nouveau groupe si le groupe n'existe pas encore
            if (!$groupExists) {
                $groups[] = array($idEleve, $idEleve2);
            }
        }
        foreach ($groups as $idGroup => $group) {
            $nbFamillesTotal -= count($group);
        }

        $familleAdherents = [];
        $familleAdherentsCAF = [];
        foreach ($result2 as $idEleve) {
            $famille = false;
            foreach ($groups as $idGroup => $group) {
                if (in_array($idEleve['ID_ELEVE'], array_values($group))) {
                    if ($idEleve['ADESION_CAF'] == 1 or $idEleve['ADESION_TARIF_PLEIN'] == 1) {
                        $famille = true;
                        $familleAdherents[$idGroup] = $group;
                        if ($idEleve['ADESION_CAF'] == 1) {
                            $familleAdherentsCAF[$idGroup] = $group;
                        }
                        break;
                    }
                }
            }
            if (!$famille) {
                if ($idEleve['ADESION_CAF'] == 1 or $idEleve['ADESION_TARIF_PLEIN'] == 1) {
                    $nbAdherents++;
                    if ($idEleve['ADESION_CAF'] == 1) {
                        $nbAdherentsCAF++;
                    }
                }
            }
            if ($idEleve['SOUTIEN'] == 1) {
                $nbEleveSoutien++;
            }
        }
        $nbAdherents += count($familleAdherents);
        $nbFamillesTotal += count($familleAdherents);
        $nbAdherentsCAF += count($familleAdherentsCAF);
    }

    public function recupeFratriesByElevesWithReglement($num) {
        $req = "SELECT `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE FROM `".PdoBD::$villeExtranet."_reglements`" .
            " INNER JOIN `".PdoBD::$villeExtranet."_reglements_eleves`" . " ON `".PdoBD::$villeExtranet."_reglements_eleves`.ID_REGLEMENT=`".PdoBD::$villeExtranet."_reglements`.ID" .
            " INNER JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE=`".PdoBD::$villeExtranet."_reglements_eleves`.ID_ELEVE " .
            "WHERE `".PdoBD::$villeExtranet."_reglements`.`ID` = :num;";
        $params = array(
            ':num' => $num
        );
        $rs = $this->Read($req, $params);
        if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
        return $rs !== null ? $this->recupererFratries($rs['ID_ELEVE']) : [];
    }

	public function getTarifs() {
		$req = "SELECT NOM, VALEUR FROM `parametre` WHERE ID_AVOIR = 8;";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des tarifs dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		$tarifs = [];
		foreach ($rs as $tarif) {
			$tarifs[$tarif['NOM']] = $tarif['VALEUR'];
		}
		return $tarifs;
	}

	/**
	* Retourne un reglement dapres son numero de cheque
	*/
	public function recupReglementCheque($num)
	{
		$req = "SELECT MONTANT, NOM, PRENOM FROM `".PdoBD::$villeExtranet."_reglements` INNER JOIN `".PdoBD::$villeExtranet."_reglements_eleves` ON `".PdoBD::$villeExtranet."_reglements`.ID = `".PdoBD::$villeExtranet."_reglements_eleves`.ID_REGLEMENT INNER JOIN `".PdoBD::$villeExtranet."_eleves` ON `".PdoBD::$villeExtranet."_reglements_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE WHERE NUMTRANSACTION = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* ajoute une ligne dans la table inscription
	*/
	public function ajoutInscription($eleve, $evenement)
	{
		$req = "INSERT INTO `".PdoBD::$villeExtranet."_inscription` (`NUMÉROEVENEMENT`, `ID_ELEVE`) VALUES (:evenement, :eleve);";
		$params = array(
			':eleve' => $eleve,
			':evenement' => $evenement
		);
		return $this->NonQuery($req, $params);
	}

	/**
	* ajoute une ligne dans la table reglement
	*/
	public function ajoutReglement($nom, $date, $type, $transaction, $banque, $montant, $commentaire, $eleves, $dons, $adhesion_caf, $adhesion_tarif_plein, $soutien)
	{
		$req = "INSERT INTO quetigny_info_reglements (SOUTIEN, ADESION_CAF, ADESION_TARIF_PLEIN, STAGE, SORTIE_STAGE, DONS)
        VALUES (:soutien, :adhesion_caf, :adhesion_tarif_plein, 0, 0, :dons);
        
        SET @info_reglement_id = LAST_INSERT_ID();
        
        INSERT INTO quetigny_reglements (ID_INFO_REGLEMENT, ID_APPARTIENT_RCAF, ID_APPARTIENT_RCHEQUE, ID_TYPEREGLEMENT, NUMTRANSACTION, BANQUE, TRANSFERERTRESORIER, DATE_REGLEMENT, MONTANT, COMMENTAIRES, NOMREGLEMENT)
        VALUES (@info_reglement_id, NULL, NULL, :type, :transaction, :banque, 0, :date, :montant, :commentaire, :nom);
        
        SET @reglement_id = LAST_INSERT_ID();
        
        INSERT INTO quetigny_reglements_eleves (ID_REGLEMENT, ID_ELEVE) VALUES ";
		$params = array(
			':soutien' => $soutien,
			':adhesion_caf' => $adhesion_caf,
			':adhesion_tarif_plein' => $adhesion_tarif_plein,
			':dons' => $dons,
			':type' => $type,
			':transaction' => $transaction,
			':banque' => $banque,
			':date' => $date,
			':montant' => $montant,
			':commentaire' => $commentaire,
			':nom' => $nom
		);

		$values = array();
		foreach ($eleves as $eleve) {
			$eleve = (int)$eleve;
			$values[] = "(@reglement_id, :eleve$eleve)";
			$params[":eleve$eleve"] = $eleve;
		}
		$req .= implode(", ", $values) . ";";

		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {
			afficherErreurSQL("Problème lors de l'insertion des données dans la base de données.", $req, PdoBD::$monPdo->errorInfo());
		}
	}

    public function getInfosReglement($num) {
        $req = "SELECT * FROM quetigny_info_reglements WHERE ID_INFO_REGLEMENT = :num";
        $params = array(
            ':num' => $num
        );
        $rs = $this->Read($req, $params);
        if ($rs === false) {
            afficherErreurSQL("Probleme lors de la recherche des infos reglements dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());
        }
        return $rs;
    }

    public function getInfosReglementsWithReglement($id) {
        $req = "SELECT * FROM quetigny_info_reglements WHERE ID_INFO_REGLEMENT IN (
            SELECT ID_INFO_REGLEMENT FROM quetigny_reglements WHERE ID = :id
        )";
        $params = array(
            ':id' => $id
        );
        $rs = $this->Read($req, $params);
        if ($rs === false) {
            afficherErreurSQL("Probleme lors de la recherche des infos reglements dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());
        }
        return $rs;
    }

	public function getInfosReglementsWithEleve($eleve) {
		$req = "SELECT * FROM quetigny_info_reglements WHERE ID_INFO_REGLEMENT IN (
			SELECT ID_INFO_REGLEMENT FROM quetigny_reglements WHERE ID IN (
				SELECT ID FROM quetigny_reglements_eleves WHERE ID_ELEVE = :eleve
			)
		)";
        $params = array(
            ':eleve' => $eleve
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {
			afficherErreurSQL("Probleme lors de la recherche des infos reglements dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());
		}
		return $rs;
	}

	/**
	* recuperer les numéro de cheque ayant un numéro journal specifique
	*/
	public function recupCheques($journal)
	{
		$req = "SELECT DISTINCT(`NUMTRANSACTION`), `BANQUE` FROM `".PdoBD::$villeExtranet."_reglements` WHERE ID_APPARTIENT_RCHEQUE = :journal AND ID_TYPEREGLEMENT = 1;";
		$params = array(
			':journal' => $journal
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des evenment d'un eleve dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* supprime une ligne dans la table inscription
	*/
	public function suppInscriptionEvenement($event, $eleve)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_inscription` WHERE `NUMÉROEVENEMENT` = :event AND `ID_ELEVE` = :eleve;";
		$params = array(
			':event' => $event,
			':eleve' => $eleve
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* supprime une ligne dans la table reglement
	*/
	public function suppReglement($num)
	{
		$req = "DELETE FROM `".PdoBD::$villeExtranet."_reglements_eleves` WHERE `ID_REGLEMENT` = :num;
		DELETE FROM `".PdoBD::$villeExtranet."_reglements` WHERE `ID_REGLEMENT` = :num1;";
		$params = array(
			':num' => $num,
			':num1' => $num
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* maj les lignes reglement CAF
	*/
	public function updateReglementCAF($id)
	{
		$req = "UPDATE `".PdoBD::$villeExtranet."_reglements` SET `ID_APPARTIENT_RCAF` = :id WHERE `ID_APPARTIENT_RCAF` IS NULL and `ID_TYPEREGLEMENT` = 3;";
		$params = array(
			':id' => $id
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* maj les lignes reglement Cheque
	*/
	public function updateReglementCheque($id)
	{
		$req = "UPDATE `".PdoBD::$villeExtranet."_reglements` SET `ID_APPARTIENT_RCHEQUE` = :id WHERE `ID_APPARTIENT_RCHEQUE` IS NULL and `ID_TYPEREGLEMENT` = 1;";
		$params = array(
			':id' => $id
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de l'insertion de l'élève dans la base de donn&eacute;es.", $req, PdoBD::$monPdo->errorInfo());}
	}

	/**
	* envoyer un message electronique
	*/
	public function envoyerMail($mail, $sujet, $msg, $entete)
	{
		if (mail($mail, $sujet, $msg, null)==false)
		{ echo 'Suite à un problème technique, votre message n a pas été envoyé a '.$mail.' sujet'.$sujet.'message '.$msg.' entete '.$entete;}
	}

	/* --------------- Centre Info ------------------ */

	// Gestion des présences et des appels
	public function getUtilisateursCentreInfo()
	{
		$req = "SELECT * FROM `utilisateur_centreinfo`";
		$rs = $this->ReadAll($req);
		if ($rs === false) {
			afficherErreurSQL("Problème lors de la lecture des utilisateurs du centre info", $req, PdoBD::$monPdo->errorInfo());
			return false;
		}
		return $rs;
	}
	
	
	public function recupUtilisateursCentreInfoPresentDate($date) {
		$req = "SELECT ID_UTILISATEUR, PRESENT, DATE_PRESENCE FROM `presence_centreinfo` WHERE DATE_PRESENCE = :date";
		$params = array(':date' => $date);
		
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {
			afficherErreurSQL("Problème lors de la récupération des présences des utilisateurs du centre info", $req, PdoBD::$monPdo->errorInfo());
			return false;
		}
		return $rs;
	}
	
	
	public function ajoutAppelCentreInfo($idUtilisateur, $dateAppel, $heure, $heure_arrivee, $activite)
	{
		$req = "INSERT INTO `presence_centreinfo` (ID_UTILISATEUR, DATE_PRESENCE, HEURE, HEURE_ARRIVEE, ACTIVITE) 
				VALUES (:idUtilisateur, :date, :heure, :heure_arrivee, :activite)";
		
		$params = array(
			':idUtilisateur' => $idUtilisateur,
			':date' => $dateAppel,
			':heure' => $heure,
			':heure_arrivee' => $heure_arrivee,
			':activite' => $activite,
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {
			error_log("Error info: " . print_r(self::$monPdo->errorInfo(), true));
			afficherErreurSQL("Problème lors de l'ajout de la présence au centreinfo dans la base de données", $req, self::$monPdo->errorInfo());
		}
	}



	public function afficherPresencesCentreInfo($jourSemaine, $mois)
	{
		// Déterminer la date du premier jour du mois
		$dateDebut = date('Y-m-d', mktime(0, 0, 0, $mois, 1));
	
		// Récupérer les présences pour chaque jour de la semaine
		$presencesParJour = array();
	
		// Boucle sur les jours du mois
		for ($jour = 1; $jour <= 31; $jour++) { // Limite arbitraire, ajustez selon vos besoins
			// Vérifier si le jour correspond au jour de la semaine sélectionné
			$date = date('Y-m-d', mktime(0, 0, 0, $mois, $jour));
	
			// Utiliser DateTime pour obtenir le jour de la semaine en français
			$jourSemaineDate = new DateTime($date);
			$jourSemaineDateFr = $jourSemaineDate->format('l d F Y');
	
			// Vérifier si le jour correspond au jour de la semaine sélectionné
			if ($jourSemaineDate->format('N') == $jourSemaine) {
				// Requête SQL pour récupérer les présences pour ce jour
				$req = "SELECT DISTINCT u.NOM, u.PRENOM, p.DATE_PRESENCE, p.HEURE, p.HEURE_ARRIVEE, p.ACTIVITE
						FROM utilisateur_centreinfo u
						JOIN presence_centreinfo p ON u.ID_UTILISATEUR = p.ID_UTILISATEUR
						WHERE p.DATE_PRESENCE = :date";
	
				$params = array(':date' => $date);
	
				// Exécuter la requête SQL et récupérer les résultats
				$resultats = $this->ReadAll($req, $params);
	
				// Ajouter les résultats à $presencesParJour
				$presencesParJour[$jourSemaineDateFr] = $resultats;
			}
		}
	
		return $presencesParJour;
	}

	/*  Gestion des inscriptions */

	// Récupérer toutes les inscriptions d'une année
	public function getLesAnneesInscriptions() {
		$req = "SELECT DISTINCT annee_inscription FROM `info_annees` ORDER BY annee_inscription DESC;";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des années d'inscriptions ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer toutes les inscriptions d'une année
	public function info_getInscriptions($annee) {
		$req = "SELECT * FROM `info_inscriptions` INNER JOIN `info_annees` ON `info_inscriptions`.`id_inscription` = `info_annees`.`id_inscription` WHERE `info_annees`.`annee_inscription` = :annee ORDER BY `info_inscriptions`.`nom_inscription`;";
		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer toutes les inscriptions
	public function info_getInscriptionsTout() {
		$req = "SELECT * FROM `info_inscriptions`;";
		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer une inscription
	public function info_getUneInscription($id) {
		$req = "SELECT * FROM `info_inscriptions` WHERE `id_inscription` = :id;";
		$params = array(
			':id' => $id
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Ajouter une inscription
	public function info_ajouterUneInscription($nom, $prenom, $adresse, $cp, $ville, $lat, $lon, $sexe, $ddn, $date, $tel1, $tel2, $email, $annee) {
		$req = "INSERT INTO `info_inscriptions` VALUES('', :nom, :prenom, '', '', :adresse, :cp, :ville, :lat, :lon, :sexe, :ddn, :date, :tel1, :tel2, :email);";
		$params = array(
			':nom' => strtoupper($nom),
			':prenom' => ucwords($prenom),
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => strtoupper($ville),
			':lat' => $lat,
			':lon' => $lon,
			':sexe' => $sexe,
			':ddn' => $ddn,
			':date' => $date,
			':tel1' => $tel1,
			':tel2' => $tel2,
			':email' => $email
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}

		$req = "INSERT INTO `info_annees` VALUES(:annee, (SELECT MAX(`id_inscription`) FROM `info_inscriptions`));";
		$params = array(
			':annee' => $annee
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}


		return $rs;
	}

	// Modifier une inscription
	public function info_modifierUneInscription($id, $nom, $prenom, $adresse, $cp, $ville, $lat, $lon, $sexe, $ddn, $date, $tel1, $tel2, $email) {
		$req = "UPDATE `info_inscriptions` SET `nom_inscription` = :nom, `prenom_inscription` = :prenom, `adresse_inscription` = :adresse, `cp_inscription` = :cp, `ville_inscription` = :ville, `lat_inscription` = :lat, `lon_inscription` = :lon, `sexe_inscription` = :sexe, `ddn_inscription` = :ddn, `date_inscription` = :date, `tel1_inscription` = :tel1, `tel2_inscription` = :tel2, `email_inscription` = :email WHERE `id_inscription` = :id";
		$params = array(
			':nom' => strtoupper($nom),
			':prenom' => ucwords($prenom),
			':adresse' => $adresse,
			':cp' => $cp,
			':ville' => strtoupper($ville),
			':lat' => $lat,
			':lon' => $lon,
			':sexe' => $sexe,
			':ddn' => $ddn,
			':date' => $date,
			':tel1' => $tel1,
			':tel2' => $tel2,
			':email' => $email,
			':id' => $id
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Supprimer une inscription
	public function info_supprimerUneInscription($num) {
		$req = "DELETE FROM `info_annees` WHERE `id_inscription` = :num;
		DELETE FROM `info_documents` WHERE `id_inscription` = :num;
		DELETE FROM `info_participe` WHERE `id_inscription` = :num;
		DELETE FROM `info_presences` WHERE `id_inscription` = :num;
		DELETE FROM `info_reglements` WHERE `id_inscription` = :num;
		DELETE FROM `info_visites` WHERE `id_inscription` = :num;
		DELETE FROM `info_inscriptions` WHERE `id_inscription` = :num;";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer toutes les inscriptions d'une année
	public function info_getIdAccesLibre() {
		$req = "SELECT `VALEUR` FROM `parametre` WHERE `ID` = 108";
		$rs = $this->Read($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Mettre à jour les coordonnées GPS pour une inscription
	public function info_majCoordonnees($id, $lat, $lon) {
		$req = "UPDATE `info_inscriptions` SET `lat_inscription` = :lat,`lon_inscription` = :lon WHERE `id_inscription` = :id";
		$params = array(
			':lat' => $lat,
			':lon' => $lon,
			':id' => $id
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer la/les activité(s) à laquelle/lesquelles une personne est inscrite
	public function info_getActivitesPourUneInscription($num) {
		$req = "SELECT * FROM `info_inscriptions` INNER JOIN `info_participe` ON `info_inscriptions`.`id_inscription` = `info_participe`.`id_inscription` WHERE `info_inscriptions`.`id_inscription` = :num ORDER BY `nom_inscription`";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer la/les présence(s) pour une activité
	public function info_getPresencesPourUneActivite($num) {
		$req = "SELECT * FROM `info_presences` INNER JOIN `info_inscriptions` ON `info_inscriptions`.`id_inscription` = `info_presences`.`id_inscription` WHERE `info_presences`.`id_activite` = :num ORDER BY `date_presence` DESC, `matin_ap_presence`";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer la/les inscription(s) pour une activité
	public function info_getInscriptionsPourUneActivite($num,$annee) {
		$annee2 = $annee+1;
		$req = "SELECT * FROM  `inscription`
		INNER JOIN `utilisateur_centreinfo` 
		ON `utilisateur_centreinfo`.`ID_UTILISATEUR` = `inscription`.`ID_UTILISATEUR` 
		INNER JOIN `presence`
		ON `inscription`.`ID_INSCRIPTION` = `presence`.`ID_INSCRIPTION`
		WHERE `ID_ACTIVITE` = :num
		AND `DATE_INSCRIPTION` 
		BETWEEN :annee1 AND :annee2";

		$params = array(
			':annee1' => $annee.'-09-01',
			':annee2' => $annee2.'-07-30',
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}
	
	// Récupérer les activités
	public function info_getActivites($annee) {
		$req = "SELECT * FROM `info_activites` JOIN `info_sederoule` ON `info_activites`.`id_activite` = `info_sederoule`.`id_activite` WHERE `annee_activite` = :annee";
		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les années d'une activité
	public function info_getActiviteAnnees($num) {
		$req = "SELECT * FROM `info_sederoule` WHERE `id_activite` = :num ORDER BY `annee_activite`";
		$params = array(
			':num' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer une activité
	public function info_getActivite($num) {
		$req = "SELECT * FROM `info_activites` WHERE `id_activite` = :num";
		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Modifier une activite
	public function info_modifierUneActivite($num, $nom) {
		$req = "UPDATE `info_activites` SET `nom_activite` = :nom WHERE `id_activite` = :num";
		$params = array(
			':num' => $num,
			':nom' => $nom
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer un document
	public function info_getDocument($num) {
		$req = "SELECT * FROM `info_documents` WHERE `id_document` = :num";
		$params = array(
			':num' => $num
		);
		$rs = $this->Read($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les documents d'une personne
	public function info_getDocuments($num) {
		$req = "SELECT * FROM `info_documents` WHERE `id_inscription` = :ins ORDER BY date_document DESC";
		$params = array(
			':ins' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les documents
	public function info_getDocumentsAnnee($annee) {
		$req = "SELECT * FROM `info_documents` JOIN `info_annees` ON `info_documents`.`id_inscription` = `info_annees`.`id_inscription` WHERE `info_annees`.`annee_inscription` = :annee ORDER BY date_document DESC";
		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les documents
	public function info_getDocumentsTout() {
		$req = "SELECT * FROM `info_documents` JOIN `info_inscriptions` ON `info_documents`.`id_inscription` = `info_inscriptions`.`id_inscription` ORDER BY `info_documents`.`id_inscription`,`date_document`";
		$params = array();
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Ajouter un document
	public function info_envoyerDocument($num,$nom,$contenu,$taille,$type,$date,$commentaire) {
		$req = "INSERT INTO `info_documents` (id_inscription, contenu_document, nom_document, taille_document, type_document, date_document, commentaire_document) VALUES(:num, :contenu, :nom, :taille, :type, :date, :commentaire);";
		$params = array(
			'num' => $num,
			'contenu' => $contenu,
			'nom' => $nom,
			'taille' => $taille,
			'type' => $type,
			'date' => $date,
			'commentaire' => $commentaire,
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Supprimer un document
	public function info_supprimerDocument($id) {
		$req = "DELETE FROM `info_documents` WHERE `id_document` = :id";
		$params = array(
			':id' => $id
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Supprimer des visites
	public function info_supprimerVisites($periode) {
		$req = "DELETE FROM `info_visites` WHERE DATE_FORMAT(`date_visite`,'%m/%Y') = '$periode'";
		$params = array(
			':periode' => $periode
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Ajouter une activité
	public function info_ajouterUneActivite($nom, $annee) {
		$req = "INSERT INTO `info_activites` (nom_activite) VALUES(:nom);
		INSERT INTO `info_sederoule` VALUES(:annee, (SELECT MAX(`id_activite`) FROM `info_activites`));";
		$params = array(
			':nom' => $nom,
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Ajouter une année pour uneactivité
	public function info_ajouterUneAnneeActivite($id, $annee) {
		$req = "INSERT INTO `info_sederoule` VALUES(:annee, :id);";
		$params = array(
			':id' => $id,
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Supprimer une année pour une activité
	public function info_supprimerUneAnneeActivite($id, $annee) {
		$req = "DELETE FROM `info_sederoule` WHERE `annee_activite` = :annee AND `id_activite` = :id";
		$params = array(
			':annee' => $annee,
			':id' => $id
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Supprimer une inscription
	public function info_supprimerUneActivite($id) {
		$req = "DELETE FROM `info_activites` WHERE `id_activite` = :id;
		DELETE FROM `info_sederoule` WHERE `id_activite` = :id;
		DELETE FROM `info_participe` WHERE `id_activite` = :id;
		DELETE FROM `info_presences` WHERE `id_activite` = :id;
		DELETE FROM `info_reglements` WHERE `id_activite` = :id;";
		$params = array(
			':id' => $id
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Enregistrer des présences
	public function info_saisirPresences($activite, $inscription, $date, $periode) {
		$req = "INSERT INTO `info_presences` (id_inscription, id_activite, date_presence, matin_ap_presence) VALUES(:inscription, :activite, :date, :periode);";
		$params = array(
			':inscription' => $inscription,
			':activite' => $activite,
			':date' => $date,
			':periode' => $periode
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Supprimer une présence
	public function info_supprimerUnePresence($id) {
		$req = "DELETE FROM `info_presences` WHERE `id_presence` = :id;";
		$params = array(
			':id' => $id
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// inscrire
	public function info_inscrire($inscription, $activite, $annee) {
		$req = "INSERT INTO `info_participe` (`id_inscription`, `id_activite`, `annee_inscription`) VALUES (:inscription, :activite, :annee)";
		$params = array(
			':inscription' => $inscription,
			':activite' => $activite,
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Déinscrire
	public function info_desinscrire($inscription, $activite, $annee) {
		$req = "DELETE FROM `info_participe` WHERE `id_inscription` = :inscription AND `id_activite` = :activite AND `annee_inscription` = :annee";
		$params = array(
			':inscription' => $inscription,
			':activite' => $activite,
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Total des présences pour un cours d'informatique
	public function info_getTotalPresences($num, $annee) {
		$req = "SELECT `DATE_DEBUT`, COUNT(*) 
				FROM `presence` 
				WHERE `ID_ACTIVITE` = :num
				AND `DATE_DEBUT` between :debut AND :fin GROUP BY `DATE_DEBUT` ORDER BY `DATE_DEBUT` ASC;";

		$params = array(
			':debut' => $annee . '-08-01',
			':fin' => ($annee + 1) . '-07-31',
			':num'=>$num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Répartition par sexe pour les cours d'informatique
	public function info_getRepartitionSexe($num, $annee) {
		$req = "SELECT `SEXE`, COUNT(*) 
		FROM `utilisateur_centreinfo` 
		INNER JOIN `inscription` 
		ON `utilisateur_centreinfo`.`ID_UTILISATEUR` = `inscription`.`ID_UTILISATEUR` 
		INNER JOIN `presence`
		ON `inscription`.`ID_INSCRIPTION` = `presence`.`ID_INSCRIPTION`
		WHERE ID_ACTIVITE = :num AND DATE_INSCRIPTION between :debut AND :fin  
		GROUP BY `SEXE`;";
		
		$params = array(
			':num'=>$num,
			':debut' => $annee . '-08-01',
			':fin' => ($annee + 1) . '-07-31',
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Répartition par ville pour une activité
	public function info_getRepartitionVille($num, $annee) {
		$req = "SELECT `VILLE`, COUNT(*) 
		FROM `utilisateur_centreinfo` 
		INNER JOIN `inscription` 
		ON `utilisateur_centreinfo`.`ID_UTILISATEUR` = `inscription`.`ID_UTILISATEUR` 
		INNER JOIN `presence`
		ON `inscription`.`ID_INSCRIPTION` = `presence`.`ID_INSCRIPTION`
		WHERE ID_ACTIVITE = :num AND DATE_INSCRIPTION between :debut AND :fin
		GROUP BY `VILLE`";
		$params = array(
			':num'=>$num,
			':debut' => $annee . '-08-01',
			':fin' => ($annee + 1) . '-07-31',
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Répartition par age pour les cours d'informatique
	public function info_getRepartitionAge($num, $annee) {
		$req = "SELECT YEAR(`DATE_DE_NAISSANCE`), COUNT(*) 
		FROM `utilisateur_centreinfo` 
		INNER JOIN `inscription` 
		ON `utilisateur_centreinfo`.`ID_UTILISATEUR` = `inscription`.`ID_UTILISATEUR` 
		INNER JOIN `presence`
		ON `inscription`.`ID_INSCRIPTION` = `presence`.`ID_INSCRIPTION`
		WHERE ID_ACTIVITE = :num AND DATE_INSCRIPTION between :debut AND :fin 
		GROUP BY YEAR(`DATE_DE_NAISSANCE`)";

		$params = array(
			':num'=>$num,
			':debut' => $annee . '-08-01',
			':fin' => ($annee + 1) . '-07-31',
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les réglements pour une activité
	public function info_getReglements($activite) {
		$req = "SELECT * FROM `info_reglements` JOIN `info_inscriptions` ON `info_reglements`.`id_inscription` = `info_inscriptions`.`id_inscription` WHERE `info_reglements`.`id_activite` = :activite";
		$params = array(
			':activite' => $activite
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les réglements pour une activité
	public function info_modifierUnReglement($id, $type, $date, $numcheque, $banque, $montant) {
		$req = "UPDATE info_reglements SET type_reglement = :type, date_reglement = :date, num_cheque_reglement = :cheque, banque_reglement = :banque, montant_reglement = :montant WHERE id_reglement = :id";
		$params = array(
			':type' => $type,
			':date' => $date,
			':cheque' => $numcheque,
			':banque' => $banque,
			':montant' => $montant,
			':id' => $id
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la modification d'un réglement ..", $req, PdoBD::$monPdo->errorInfo());}
	}

	// Récupérer les réglements pour une année
	public function info_getReglementsAnnee($annee, $type) {
		$req = "SELECT * FROM `info_reglements` JOIN `info_inscriptions` ON `info_reglements`.`id_inscription` = `info_inscriptions`.`id_inscription` JOIN `info_annees` ON `info_reglements`.`id_inscription` = `info_annees`.`id_inscription` WHERE `annee_inscription` = :annee";
		$params = array(
			':annee' => $annee
		);
		if ($type !== 'tout') {
			$req .= " AND type_reglement = :type";
			$params[':type'] = $type;
		}
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des reglements", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	* Retourne les impayés à un réglement pour une année
	*/
	public function info_getImpayesReglement($annee)
	{
		$req = "SELECT info_inscriptions.nom_inscription, info_inscriptions.prenom_inscription  FROM `info_inscriptions` join info_annees on info_inscriptions.id_inscription = info_annees.id_inscription where info_inscriptions.id_inscription not in (SELECT info_reglements.id_inscription from `info_reglements`) AND info_annees.`annee_inscription` = :annee ORDER BY info_inscriptions.nom_inscription ASC;";
		$params = array(
			':annee' => $annee
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des règlements ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer un réglement pour une activité
	public function info_getUnReglement($id) {
		$req = "SELECT * FROM `info_reglements` WHERE `id_reglement` = :id";
		$params = array(
			':id' => $id
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Enregistrer un réglement
	public function info_ajouterUnReglement($activite, $inscription, $type, $date, $transaction, $banque, $montant) {
		$req = "INSERT INTO `info_reglements` VALUES('', :inscription, :activite, :type, :date, :transaction, :banque, :montant);";
		$params = array(
			':activite' => $activite,
			':inscription' => $inscription,
			':type' => $type,
			':date' => $date,
			':transaction' => $transaction,
			':banque' => addslashes(strtoupper($banque)),
			':montant' => $montant
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Supprimer un réglement
	public function info_supprimerUnReglement($id) {
		$req = "DELETE FROM `info_reglements` WHERE `id_reglement` = :id";
		$params = array(
			':id' => $id
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Vérifier si une inscription Cyberlux existe déjà
	public function info_verifierInscription($num) {
		$req = "SELECT COUNT(*) FROM `info_inscriptions` WHERE `code_cyberlux_inscription` = :code";
		$params = array(
			':code' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les visites d'une personne
	public function info_getVisites($num) {
		$req = "SELECT * FROM `info_visites` WHERE `code_cyberlux` = :code ORDER BY `date_visite` DESC";
		$params = array(
			':code' => $num
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les visites
	public function info_getVisitesTout() {
		$req = "SELECT * FROM `info_visites`";
		$params = array();
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les visites d'un mois
	public function info_getVisitesMois($mois) {
		$req = "SELECT * FROM `info_visites` WHERE DATE_FORMAT(`date_visite`,'%m/%Y') = :mois";
		$params = array(
			':mois' => $mois
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Récupérer les mois des visites
	public function info_getMoisVisites() {
		$req = "SELECT DISTINCT DATE_FORMAT(`date_visite`, '%m/%Y') AS periode FROM `info_visites`";
		$params = array();
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// Stats sur les PC
	public function info_getStatsPC($annee) {
		$req = "SELECT DISTINCT `pc_visite` AS valeur,COUNT(*) AS nb FROM `info_visites` WHERE `date_visite` >= :debut AND `date_visite` <= :fin GROUP BY `pc_visite`";
		$params = array(
			':debut' => $annee . '-09-01',
			':fin' => ($annee + 1) . '-08-31'
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function AjouterFratries($eleve, $fratrie) {
		$req = "INSERT INTO `quetigny_eleves_fratries` VALUES(:eleve, :fratrie);";
		$params = array(
			':eleve' => $eleve,
			':fratrie' => $fratrie
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {
			afficherErreurSQL("Probleme lors de l'ajout de la fratrie ..", $req, PdoBD::$monPdo->errorInfo());
		}
	}

	public function SupprimerFratries($eleve) {
		$req = "DELETE FROM `quetigny_eleves_fratries` WHERE `ID_ELEVE` = :idea OR `ID_ELEVE2` = :ideb;";
		$params = array(
			':idea' => $eleve,
			':ideb' => $eleve
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {
			afficherErreurSQL("Probleme lors de la suppression de la fratrie ..", $req, PdoBD::$monPdo->errorInfo());
		}
	}

    public function recupereFratriesStage($eleve, $idStage) {
        $freresSoeurs = array();
        $visited = array();
        $queue = array();

        // Ajouter l'élève initial à la file d'attente
        $queue[] = ['ID_ELEVE_STAGE' => $eleve];

        while (!empty($queue)) {
            $currentEleve = array_shift($queue);

            // Vérifier si l'élève actuel a déjà été visité
            if (in_array($currentEleve, $visited)) {
                continue;
            }

            // Ajouter l'élève actuel à la liste des frères et sœurs
            $freresSoeurs[] = $currentEleve;

            // Marquer l'élève actuel comme visité
            $visited[] = $currentEleve;

            // Récupérer les frères et sœurs liés à l'élève actuel
            $sql = "SELECT INSCRIPTIONS_STAGE.ID_INSCRIPTIONS, ELEVE_STAGE.ID_ELEVE_STAGE, ELEVE_STAGE.NOM_ELEVE_STAGE, ELEVE_STAGE.PRENOM_ELEVE_STAGE
                FROM ELEVE_STAGE
                INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE
                INNER JOIN quetigny_eleves ON ELEVE_STAGE.ID_ELEVE_ANCIENNE_TABLE = quetigny_eleves.ID_ELEVE
                INNER JOIN quetigny_eleves_fratries ON (
                    (quetigny_eleves_fratries.ID_ELEVE = (SELECT ID_ELEVE_ANCIENNE_TABLE FROM ELEVE_STAGE WHERE ID_ELEVE_STAGE = " . $currentEleve['ID_ELEVE_STAGE'] . ") AND quetigny_eleves_fratries.ID_ELEVE2 = quetigny_eleves.ID_ELEVE)
                    OR 
                    (quetigny_eleves_fratries.ID_ELEVE2 = (SELECT ID_ELEVE_ANCIENNE_TABLE FROM ELEVE_STAGE WHERE ID_ELEVE_STAGE = " . $currentEleve['ID_ELEVE_STAGE'] . ") AND quetigny_eleves_fratries.ID_ELEVE = quetigny_eleves.ID_ELEVE)
                )
                WHERE ELEVE_STAGE.ID_ELEVE_STAGE <> " . $currentEleve['ID_ELEVE_STAGE'] . " AND INSCRIPTIONS_STAGE.ID_STAGE = " . $idStage;
            $result = PdoBD::$monPdo->query($sql);

            // Parcourir les résultats et ajouter les frères et sœurs à la file d'attente
            foreach ($result->fetchAll() as $unFrereSoeur) {
                $frereSoeurID = $unFrereSoeur['ID_ELEVE_STAGE'];
                if ($frereSoeurID == $eleve) {
                    continue;
                }

                // Vérifier si l'ID du frère ou de la sœur n'a pas été visité
                if (!in_array($frereSoeurID, $visited)) {
                    $queue[] = $unFrereSoeur;
                }
            }
        }
        unset($freresSoeurs[0]);
        return $freresSoeurs;
    }

	public function recupererFratries($eleve) {
		$freresSoeurs = array();
		$visited = array();
		$queue = array();

		// Ajouter l'élève initial à la file d'attente
		$queue[] = ['ID_ELEVE' => $eleve];

		while (!empty($queue)) {
			$currentEleve = array_shift($queue);

			// Vérifier si l'élève actuel a déjà été visité
			if (in_array($currentEleve, $visited)) {
				continue;
			}

			// Ajouter l'élève actuel à la liste des frères et sœurs
			$freresSoeurs[] = $currentEleve;

			// Marquer l'élève actuel comme visité
			$visited[] = $currentEleve;

			// Récupérer les frères et sœurs liés à l'élève actuel
            $sql = "SELECT qe.`ID_ELEVE`, qe.`NOM`, qe.`PRENOM`
            FROM `quetigny_eleves` AS qe
            INNER JOIN `quetigny_eleves_fratries` AS qef ON qef.`ID_ELEVE` = qe.`ID_ELEVE`
            WHERE qef.`ID_ELEVE2` = " . $currentEleve['ID_ELEVE'] . "
            UNION
            SELECT qe.`ID_ELEVE`, qe.`NOM`, qe.`PRENOM`
            FROM `quetigny_eleves` AS qe
            INNER JOIN `quetigny_eleves_fratries` AS qef ON qef.`ID_ELEVE2` = qe.`ID_ELEVE`
            WHERE qef.`ID_ELEVE` = " . $currentEleve['ID_ELEVE'] . "
            AND qe.`ID_ELEVE` <> " . $currentEleve['ID_ELEVE'];

            $result = PdoBD::$monPdo->query($sql);

			// Parcourir les résultats et ajouter les frères et sœurs à la file d'attente
			foreach ($result->fetchAll() as $unFrereSoeur) {
				$frereSoeurID = $unFrereSoeur['ID_ELEVE'];
                if ($frereSoeurID == $eleve) {
                    continue;
                }

				// Vérifier si l'ID du frère ou de la sœur n'a pas été visité
				if (!in_array($frereSoeurID, $visited)) {
					$queue[] = $unFrereSoeur;
				}
			}
		}
		unset($freresSoeurs[0]);
		return $freresSoeurs;
	}

	public function recupLesEmailsParentsInscritsNotNull($stage)
	{
		$req = "SELECT EMAIL_PARENTS_ELEVE_STAGE FROM `INSCRIPTIONS_STAGE` INNER JOIN `ELEVE_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE` = :stage AND EMAIL_PARENTS_ELEVE_STAGE IS NOT NULL";
        $params = array(
            ':stage' => $stage
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des inscriptions du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupLesEmailsEnfantsInscritsNotNull($stage)
	{
		$req = "SELECT EMAIL_ENFANT_ELEVE_STAGE FROM `ELEVE_STAGE` INNER JOIN `INSCRIPTIONS_STAGE` ON `INSCRIPTIONS_STAGE`.`ID_ELEVE_STAGE` = `ELEVE_STAGE`.`ID_ELEVE_STAGE` where `INSCRIPTIONS_STAGE`.`ID_STAGE` = :stage AND EMAIL_ENFANT_ELEVE_STAGE IS NOT NULL";
        $params = array(
            ':stage' => $stage
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des inscriptions du stage ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupEmailEnfantAnneeNotNull($annee)
	{
		$req = "SELECT DISTINCT email_de_l_enfant FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_inscrit`.ID_ELEVE WHERE ANNEE = :annee AND email_de_l_enfant IS NOT NULL;";
        $params = array(
            ':annee' => $annee
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupEmailParentsAnneeNotNull($annee)
	{
		$req = "SELECT DISTINCT EMAIL_DES_PARENTS FROM `".PdoBD::$villeExtranet."_eleves` INNER JOIN `".PdoBD::$villeExtranet."_inscrit` ON `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE = `".PdoBD::$villeExtranet."_inscrit`.ID_ELEVE WHERE ANNEE = :annee AND EMAIL_DES_PARENTS IS NOT NULL;";
        $params = array(
            ':annee' => $annee
        );
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}


	public function StatClasseFiliere(){
		$req = "SET @classe = (SELECT NOM FROM parametre where ID = 55); SET @filiere = (SELECT NOM FROM parametre where ID = 60); SET @CF = CONCAT(@classe, ' ', @filiere); SET @nbCF = (SELECT COUNT(*) FROM ELEVE_STAGE INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = 43 AND CLASSE_ELEVE_STAGE = 55 AND FILIERE_ELEVE_STAGE=60); SELECT @CF as classe_filiere, @nbCF as nbClasse_filiere ;";
		$rs = $this->NonQuery($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	public function recupAllStages(){
		$req = "SELECT * FROM STAGE_REVISION;";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}
	//récupère le stage correspondant au bon URL
	public function getInscriptionStage($num)
	{
		$req = "SELECT STAGE FROM site WHERE URL = :num";
		$params = array (
			':num'=> $num,
		);
		$rs = $this->ReadAll($req, $params);
		if ($rs === false) {afficherErreurSQL("Problème lors de la recherche du stage", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	//Supprime les liens ayants le même URL que celui selectionné 
	public function SupprimerLienInscription($url, $num)
	{
		$req = "DELETE FROM site WHERE STAGE !=:numid AND URL =:url;";
		
			$params = array(
				':url' => $url,
				':numid' => $num,
			);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des donnees ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
	}

	/**
	 * Retourne les intervenants présents entre deux dates (incluses)
	 * Paramètres : les dates de début et de fin
	 */
	public function recupIntervenantsEntreDates($dateDebut, $dateFin)
	{
		try {
			$req = "SELECT intervenants.ID_INTERVENANT, intervenants.NOM, intervenants.PRENOM, SEANCE, ID FROM `".PdoBD::$villeExtranet."_appel` 
			inner join intervenants on `".PdoBD::$villeExtranet."_appel`.ID_INTERVENANT = intervenants.ID_INTERVENANT
			where SEANCE between :dateDebut and :dateFin;";
			$params = array(
				':dateDebut' => $dateDebut,
				':dateFin' => $dateFin
			);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intervenants ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les élèves présents entre deux dates (incluses)
	 * Paramètres : les dates de début et de fin
	 */
	public function recupElevesEntreDates($dateDebut, $dateFin)
	{
		try {
			$req = "SELECT `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE, `".PdoBD::$villeExtranet."_eleves`.NOM, `".PdoBD::$villeExtranet."_eleves`.PRENOM, SEANCE, ID FROM `".PdoBD::$villeExtranet."_appel` 
			inner join `".PdoBD::$villeExtranet."_eleves` on `".PdoBD::$villeExtranet."_appel`.ID_ELEVE = `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE
			where SEANCE between :dateDebut and :dateFin.;";
			$params = array(
				':dateDebut' => $dateDebut,
				':dateFin' => $dateFin
			);
		
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des élèves ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les intervenants présents pendant le jour sélectionné d'un mois
	 * Exemple : si on sélectionne le mercredi du mois de janvier 2023, on aura tous les intervenants présents les mercredis du mois de janvier 2023
	 * Paramètres : le jour et le mois (l'année est sélectionnée automatiquement)
	 */
	public function recupIntervenantsParJour($jour, $mois)
	{
		try {
			$annee = PdoBD::$anneeExtranet;
			if ($mois < 8) {
				$annee = $annee + 1;
			}

			$req = "SELECT intervenants.ID_INTERVENANT, intervenants.NOM, intervenants.PRENOM, SEANCE, ID FROM `".PdoBD::$villeExtranet."_appel` 
			inner join intervenants on `".PdoBD::$villeExtranet."_appel`.ID_INTERVENANT = intervenants.ID_INTERVENANT
			WHERE DAYOFWEEK(SEANCE) = :jour AND MONTH(SEANCE) = :mois AND YEAR(SEANCE) = :annee;";
			$params = array(
				':jour' => $jour,
				':mois' => $mois,
				':annee' => $annee
			);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des intervenants ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les élèves présents pendant le jour sélectionné d'un mois
	 * Exemple : si on sélectionne le mercredi du mois de janvier 2023, on aura tous les élèves présents les mercredis du mois de janvier 2023
	 * Paramètres : le jour et le mois (l'année est sélectionnée automatiquement)
	 */
	public function recupElevesParJour($jour, $mois)
	{
		try {
			$annee = PdoBD::$anneeExtranet;
			if ($mois < 8) {
				$annee = $annee + 1;
			}

			$req = "SELECT `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE, `".PdoBD::$villeExtranet."_eleves`.NOM, `".PdoBD::$villeExtranet."_eleves`.PRENOM, SEANCE, ID FROM `".PdoBD::$villeExtranet."_appel` 
			inner join `".PdoBD::$villeExtranet."_eleves` on `".PdoBD::$villeExtranet."_appel`.ID_ELEVE = `".PdoBD::$villeExtranet."_eleves`.ID_ELEVE
			WHERE DAYOFWEEK(SEANCE) = :jour AND MONTH(SEANCE) = :mois AND YEAR(SEANCE) = :annee ;";
			$params = array(
				':jour' => $jour,
				':mois' => $mois,
				':annee' => $annee
			);
		
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des élèves ..", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Ajouter une activité
	 * Paramètre : le nom de l'activité, le prix, la photo et la description
	 */
	public function ajouterActivite($nom, $prix, $photo, $description, $adherent)
	{
		try {
			$req = "INSERT INTO activite VALUES (0, :nom, :prix, :photo, :description, :adherent, FALSE);";
			$params = array(
				':nom' => $nom,
				':prix' => $prix,
				':photo' => $photo,
				':description' => $description,
				':adherent' => $adherent
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout de l'activite dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	
	}

	/**
	 * Modifier une activité
	 * Paramètres : l'id de l'activité, le nom de l'activité, le prix, la photo et la description
	 */
	public function modifierActivite($id, $nom, $prix, $photo, $description, $adherent, $desactiver)
	{
		try {
			$req = "UPDATE activite SET NOM = :nom, PRIX = :prix, PHOTO = :photo, DESCRIPTION = :description, ADHERENT = :adherent, DESACTIVER = :desactiver WHERE ID_ACTIVITE = :id;";
			$params = array(
				':id' => $id,
				':nom' => $nom,
				':prix' => $prix,
				':photo' => $photo,
				':description' => $description,
				':adherent' => $adherent,
				':desactiver' => $desactiver
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la modification de l'activite dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	* Retourne dans un tableau les activités
	*/
	public function getActivites()
	{
		try {
			$req = "SELECT * FROM activite order by NOM;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des activitees dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les activités actives
	 */
	public function getActivitesActives()
	{
		try {
			$req = "SELECT * FROM activite WHERE DESACTIVER = FALSE order by NOM;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des activitees dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne une activité
	 * Paramètre : l'id de l'activité
	 */
	public function getActivite($id)
	{
		try {
			$req = "SELECT * FROM activite WHERE ID_ACTIVITE = :id;";
			$params = array(':id' => $id);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'activite dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs[0];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	
	}

	/**
	 * Retourne la photo d'une activité
	 * Paramètre : l'id de l'activité
	 */
	public function getPhotoActivite($id)
	{
		try {
			$req = "SELECT PHOTO FROM activite WHERE ID_ACTIVITE = :id;";
			$params = array(':id' => $id);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de la photo de l'activite dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs[0]['PHOTO'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les présences pour le.s activité.s pour un jour donné
	 * Paramètres : le jour, le.s activite.s
	 */
	public function getPresencesActivite($jour, $activite)
	{
		try {
			$req = "SELECT ID_PRESENCE, DATE_DEBUT, DATE_FIN, ID_ACTIVITE, utilisateur_centreinfo.ID_UTILISATEUR, utilisateur_centreinfo.NOM, utilisateur_centreinfo.PRENOM 
				from presence 
				inner join utilisateur_centreinfo on utilisateur_centreinfo.ID_UTILISATEUR = presence.ID_UTILISATEUR
				where DATE_DEBUT <= :jour and DATE_FIN >= :jour";
			$params = array(':jour' => $jour);
			
			if ($activite != 0)	// Si une activité est sélectionnée
			{
				$req .= " and ID_ACTIVITE = :activite;";
				$params[':activite'] = $activite;
			}
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des presences dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
		
	}

	/**
	 * Ajoute un utilisateur au centre informatique
	 * Paramètres : le nom, le prénom, le mail, le téléphone mobile, la date de naissance, le lieu de naissance, l'adresse, le code postal et la ville (le téléphone fixe et la photo ne sont pas obligatoire)
	 */
	public function ajouterUtilisateurCentreInfo($idUser, $nom, $prenom, $email, $telFixe, $telMobile, $adresse, $codePostal, $ville, $dateNaissance, $lieuNaissance, $sexe, $photo)
	{
		try {
			$req = "INSERT INTO utilisateur_centreinfo VALUES (:id, :nom, :prenom, :email, :telFixe, :telMobile, :adresse, :codePostal, :ville, :dateNaissance, :lieuNaissance, :sexe, :photo);";
			$params = array(
				':id' => $idUser,
				':nom' => $nom,
				':prenom' => $prenom,
				':email' => $email,
				':telMobile' => $telMobile,
				':telFixe' => $telFixe,
				':dateNaissance' => $dateNaissance,
				':lieuNaissance' => $lieuNaissance,
				':adresse' => $adresse,
				':codePostal' => $codePostal,
				':ville' => $ville,
				':sexe' => $sexe,
				':photo' => $photo
			);
			$rs = $this->NonQuery($req, $params);
			
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout de l'utilisateur dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne tout les utilisateurs du centre informatique
	 */
	public function getUtilisateurCentreInfo()
	{
		try {
			$req = "SELECT * FROM utilisateur_centreinfo order by NOM;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des utilisateurs du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne l'id de l'incription d'un utilisateur du centre informatique
	 * Paramètres : l'id de l'utilisateur
	 */
	public function getIdInscription($idUtilisateur)
	{
		try {
			$req = "SELECT ID_INSCRIPTION FROM inscription where ID_UTILISATEUR = :idUtilisateur;";
			$params = array(':idUtilisateur' => $idUtilisateur);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'inscription dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs[0]['ID_INSCRIPTION'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne un idUtilisateur du centre informatique
	 * Paramètres : l'email de l'utilisateur
	 */
	public function getIdUtilisateurCentreInfo($email)
	{
		try {
			$req = "SELECT ID_UTILISATEUR FROM utilisateur_centreinfo where EMAIL = :email;";
			$params = array(':email' => $email);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs[0]['ID_UTILISATEUR'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne toutes les informations d'un utilisateur grâce à son  email
	 * Paramètres : email de l'utilisateur
	 */
	public function getInfosUtilisateurById($email)
	{
		try  {
			$req= "SELECT * FROM utilisateur_centreinfo WHERE EMAIL = :email;";
			$params = array(':email' => $email);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs[0]['ID_UTILISATEUR'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les numéros de téléphones portable des utilisateurs du centre informatique
	 */
	public function getTelephonesAdherents()
	{
		try {
			$req = "SELECT TELEPHONE_PORTABLE FROM utilisateur_centreinfo;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des utilisateurs du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	
	}

	/**
	 * Ajoute une inscription pour un utilisateur du centre informatique
	 * Paramètres : l'id de l'utilisateur
	 */
	public function ajouterInscriptionCentreInfo($idUtilisateur)
	{
		try {
			$req = "INSERT INTO inscription VALUES (0, :idUtilisateur, :dateInscription, :annee);";
			$params = array(
				':idUtilisateur' => $idUtilisateur,
				':dateInscription' => date('Y-m-d'),
				':annee' => PdoBD::$anneeExtranet
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout de l'inscription dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Ajoute une inscription pour un utilisateur du centre informatique
	 */
	public function ajouterInscripCentreInfo($idUtilisateur, $dateInscription)
	{
		try {
			$req = "INSERT INTO inscription VALUES (0, :idUtilisateur, :dateInscription, :annee);";
			$params = array(
				':idUtilisateur' => $idUtilisateur,
				':dateInscription' => $dateInscription,
				':annee' => PdoBD::$anneeExtranet
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout de l'inscription dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/*
	Supprime un utilisateur du fablab
	Paramètres: email (id d'utilisateur)
	*/
	public function supprimerUtilisateurFabLab($email)
	{
		try {
			$req = "DELETE FROM utilisateur_centreinfo WHERE EMAIL = :email;";
			$params = array(':email' => $email);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Supprime une inscription
	 * Paramètres : idInscription de l'inscription
	 */
	public function supprimerInscriptionFabLab($idInscription)
	{
		try {
			$req = "DELETE FROM inscription WHERE idInscription = :idInscription;";
			$params = array(':idInscription' => $idInscription);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Ajoute une présence pour un utilisateur donné ainsi que pour une activité donnée
	 * Paramètres : l'id de l'utilisateur, la date d'arrivée, la date de sortie, l'id de l'activité et l'id d'inscription
	 */
	public function ajouterFichePresence($idUtilisateur, $dateArrive, $dateSortie, $idActivite, $idInscription)
	{
		try {
			$req = "INSERT INTO presence VALUES (0, :dateArrive, :dateSortie, :idActivite, :idUtilisateur, :idInscription);";
			$params = array(
				':dateArrive' => $dateArrive,
				':dateSortie' => $dateSortie,
				':idActivite' => $idActivite,
				':idUtilisateur' => $idUtilisateur,
				':idInscription' => $idInscription
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout de la fiche de presence dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les consommables
	 * Paramètres : le nom du consommable, le prix, la photo et la description
	 */
	public function ajouterConsommable($nom, $prix, $photo, $description)
	{
		try {
			$req = "INSERT INTO consommable VALUES (0, :nom, :prix, :photo, :description, FALSE);";
			$params = array(
				':nom' => $nom,
				':prix' => $prix,
				':photo' => $photo,
				':description' => $description);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout du consommable dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	
	}

	/**
	 * Modifier un consommable
	 * Paramètres : l'id du consommable, le nom, le prix, la photo et la description
	 */
	public function modifierConsommable($idConsommable, $nom, $prix, $photo, $description, $desactiver)
	{
		try {
			$req = "UPDATE consommable SET NOM = :nom, PRIX = :prix, PHOTO = :photo, DESCRIPTION = :description, DESACTIVER =:desactiver WHERE ID_CONSOMMABLE = :idConsommable;";
			$params = array(
				':idConsommable' => $idConsommable,
				':nom' => $nom,
				':prix' => $prix,
				':photo' => $photo,
				':description' => $description,
				':desactiver' => $desactiver
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la modification du consommable dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les consommables
	 */
	public function getConsommables()
	{
		try {
			$req = "SELECT * FROM consommable order by NOM;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des consommables dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Retourne les consommables actifs
	 */
	public function getConsommablesActifs()
	{
		try {
			$req = "SELECT * FROM consommable WHERE DESACTIVER = FALSE order by NOM;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des consommables actifs dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	
	}

	/**
	 * Retourne un consommable
	 * Paramètre : l'id du consommable
	 */
	public function getConsommable($idConsommable)
	{
		try {
			$req = "SELECT * FROM consommable WHERE ID_CONSOMMABLE = :idConsommable;";
			$params = array(':idConsommable' => $idConsommable);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du consommable dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs[0];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}


	/**
	 * Retourne la photo d'un consommable
	 * Paramètre : l'id du consommable
	 */
	public function getPhotoConsommable($idConsommable)
	{
		try {
			$req = "SELECT PHOTO FROM consommable WHERE ID_CONSOMMABLE = :idConsommable;";
			$params = array(':idConsommable' => $idConsommable);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de la photo du consommable dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs[0]['PHOTO'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * permet de modifier une inscription au fab lab
	 * Paramètres : donnees tableau associatif contenant les champs à mettre à jour et leurs nouvelles valeurs.
	 */
	public function info_modifierInscripFabLab($idUtilisateurSelectionne, $nom, $prenom, $email, $telFixe, $telMobile, $adresse, $codePostal, $ville, $dateNaissance, $lieuNaissance, $sexe, $photo) {
		$req = "UPDATE utilisateur_centreinfo SET NOM = :nom, PRENOM = :prenom, EMAIL = :email, TELEPHONE_FIXE = :telFixe, TELEPHONE_PORTABLE = :telMobile, ADRESSE_POSTALE = :adresse, CODE_POSTAL = :codePostal, VILLE = :ville, DATE_DE_NAISSANCE = :dateNaissance, LIEU_DE_NAISSANCE = :lieuNaissance, SEXE = :sexe, PHOTO = :photo WHERE `ID_UTILISATEUR` = :idUtilisateurSelectionne;";
		$params = array(
			':idUtilisateurSelectionne' => $idUtilisateurSelectionne,
			':nom' => strtoupper($nom),
			':prenom' => ucwords($prenom),
			':email' => $email,
			':telFixe' => $telFixe,
			':telMobile' => $telMobile,
			':adresse' => $adresse,
			':codePostal' => $codePostal,
			':ville' => strtoupper($ville),
			':dateNaissance' => $dateNaissance,
			':lieuNaissance' => $lieuNaissance,
			':sexe' => $sexe,
			':photo' => $photo
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la modification des données de l'utilisateur ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	/**
	 * récupère les infos d'un utilisateur sélectionné
	 * Paramètres :  idUtilisateurSelectionne, l'identifiant de l'utilisateur dont on veut les informations
	 */
	public function getInfosUserByID($idUtilisateurSelectionne)
	{
		try  {
			$req= "SELECT * FROM utilisateur_centreinfo WHERE ID_UTILISATEUR = :idUtilisateurSelectionne;";
			$params = array(':idUtilisateurSelectionne' => $idUtilisateurSelectionne);
			$rs = $this->Read($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * récupère la date d'inscription d'une personne en prenant son identifiant
	 */
	public function getDateInscription ($idUtilisateurSelectionne)
	{
		try {
			$req = "SELECT DATE_INSCRIPTION FROM inscription WHERE ID_UTILISATEUR = :idUtilisateurSelectionne;";
			$params = array(':idUtilisateurSelectionne' => $idUtilisateurSelectionne);
			$rs = $this->Read($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * supprimer une personnes des isncriptions avec l'id utilisateur
	 */
	public function supprimerInfoInscription ($idUtilisateur)
	{
		try {
			//On supprime la ligne correspondante à cet identifiant dans la table
			$req = "DELETE FROM inscription WHERE ID_UTILISATEUR =  :idUtilisateur;";
			$params = array(':idUtilisateur' => $idUtilisateur);
			$rs = $this->Read($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	/**
	 * Permet de supprimer un utilisateur en prenant l'identifiant utilisateur en paramètres
	 */
	public function supprimerInfoUtilisateur ($idUtilisateur)
	{
		try {
			//On supprime la ligne correspondante à cet identifiant dans la table
			$req = "DELETE FROM utilisateur_centreinfo WHERE ID_UTILISATEUR =  :idUtilisateur;";
			$params = array(':idUtilisateur' => $idUtilisateur);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function supprimerConsommableUtilisateur ($idUtilisateur) {
		try {
			$req = "DELETE FROM utilisateur_consommable WHERE ID_CONSOMMABLE = :idUtilisateur;";
			$params = array(':idUtilisateur' => $idUtilisateur);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la suppression des consommables dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	
	}

	/**
	 * Permet de récupérer tous les règlements associés à un utilisateur
	 * Paramètre : l'identifiant de l'inscrit
	 */
	public function recupReglementFabLab ($idInscrit)
	{
		try {
			$req = "SELECT * FROM reglement WHERE ID_UTILISATEUR = :idInscrit;";
			$params = array(':idInscrit' => $idInscrit);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre stats_repartitionSexe dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}
	//recupère la liste de tout les élèves qui ont participés à des stages cette année
	public function getElevesAllStage(){
		$req="SELECT DISTINCT * FROM eleve_stage 
		INNER JOIN inscriptions_stage 
		ON eleve_stage.ID_ELEVE_STAGE = inscriptions_stage.ID_ELEVE_STAGE 
		INNER JOIN stage_revision
		ON inscriptions_stage.ID_STAGE = stage_revision.ID_STAGE

		WHERE ANNEE_STAGE = ".PdoBD::$anneeExtranet."
		ORDER BY NOM_ELEVE_STAGE ASC";

		$rs = $this->ReadAll($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture des eleves ..", $req, PdoBD::$monPdo->errorInfo());}
		return $rs;
	}

	// récupère la liste des utilisateurs du centre informatique avec les inscriptions si elles existent
	public function getUtilisateurCentreInfoAvecInscriptions() {
		try {
			$req = "SELECT uci.*, ins.*
			FROM utilisateur_centreinfo uci
			LEFT JOIN inscription ins ON ins.ID_UTILISATEUR = uci.ID_UTILISATEUR
			WHERE ins.ID_INSCRIPTION = (
				SELECT MAX(sub_ins.ID_INSCRIPTION)
				FROM inscription sub_ins
				WHERE sub_ins.ID_UTILISATEUR = uci.ID_UTILISATEUR
			)
			GROUP BY uci.ID_UTILISATEUR;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des adherents du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function getTypesReglement() {
		try {
			$req = "SELECT parametre.ID, parametre.NOM FROM parametre 
			WHERE parametre.ID_AVOIR = 5
			ORDER BY 
				CASE 
					WHEN parametre.NOM = 'Chèque' THEN 1
					WHEN parametre.NOM = 'Espèces' THEN 2
					WHEN parametre.NOM = 'Bon Caf' THEN 3
					WHEN parametre.NOM = 'CB' THEN 4
					WHEN parametre.NOM = 'Autre' THEN 5
					WHEN parametre.NOM = 'Exonéré' THEN 6
					ELSE 7
				END;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du parametre dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	// récupère toutes les activités du centre informatique
	public function getActivitesCentreInfo() {
		try {
			$req = "SELECT * FROM activite;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des activites du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	// récupère tous les consommables d'une activité du centre informatique
	public function getConsommablesCentreInfo($idActivite) {
		try {
			$req = "SELECT consommable.ID_CONSOMMABLE, consommable.NOM, consommable.`DESCRIPTION`, consommable.`PHOTO`,consommable.PRIX FROM consommable
			JOIN activite_consommable ON consommable.ID_CONSOMMABLE = activite_consommable.ID_CONSOMMABLE
			JOIN activite ON activite.ID_ACTIVITE = activite_consommable.ID_ACTIVITE
			WHERE activite.ID_ACTIVITE = :idActivite AND consommable.DESACTIVER = 0;";
			$params = array(':idActivite' => $idActivite);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des consommables du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	public function getNomBanqueById($idBanque) {
		try {
			$req = "SELECT NOM FROM banque WHERE ID = :idBanque;";
			$params = array(':idBanque' => $idBanque);
			$rs = $this->Read($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du nom de la banque dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs['NOM'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function getBanques() {
		try {
			$req = "SELECT * FROM banque
			ORDER BY
				CASE WHEN NOM = 'Autres' THEN 1 ELSE 0 END,
				NOM ASC;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des banques dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	// ajoute un règlement pour un utilisateur du centre informatique
	public function ajouterReglementCentreInfo($idReglement, $typeReglement, $montant, $banque, $numTransaction, $date, $commentaire) {
		try {
			$req = "INSERT INTO `ore`.`reglement_centreinfo` (`ID`, `TYPE_REGLEMENT`, `MONTANT`, `BANQUE`, `NUM_TRANSACTION`, `DATE`, `COMMENTAIRE`) 
			VALUES (:id, :typeReglement, :montant, :banque, :numTransaction, :dateReglement, :commentaire);";
			$params = array(
				':id' => $idReglement,
				':typeReglement' => $typeReglement,
				':montant' => $montant,
				':banque' => $banque,
				':numTransaction' => $numTransaction,
				':dateReglement' => $date,
				':commentaire' => $commentaire
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout du reglement dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function getDernierIdentifiantReglement() {
		try {
			$req = "SELECT `ID`
			FROM reglement_centreinfo
			ORDER BY ID DESC
			LIMIT 1";
			$rs = $this->Read($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du dernier identifiant de reglement dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs['ID'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	
	}

	public function getTypeReglementById($idTypeReglement) {
		try {
			$req = "SELECT `NOM` FROM parametre WHERE ID = :idTypeReglement;";
			$params = array(':idTypeReglement' => $idTypeReglement);
			$rs = $this->Read($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du type de reglement dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs['NOM'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	
	}

	public function reglementUtilisateurCentreInfo($idReglement, $idUtilisateur) {
		try {
			$req = "INSERT INTO reglement_utilisateur_centreinfo (ID_REGLEMENT, ID_UTILISATEUR)
				VALUES (:idReglement, :idUtilisateur);";
			$params = array(
				':idReglement' => $idReglement,
				':idUtilisateur' => $idUtilisateur
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout du consommable dans le reglement dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function utilisateurConsommable($idUtilisateur, $consommable) {
		try {
			$req = "INSERT INTO utilisateur_consommable (ID, ID_UTILISATEUR, CONSOMMABLE)
				VALUES (0, :idUtilisateur, :consommable);";
			$params = array(
				':idUtilisateur' => $idUtilisateur,
				':consommable' => $consommable
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout du consommable dans le reglement dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	public function ajouterConsommableReglement($idReglement, $idConsommable) {
		try {
			$req = "INSERT INTO reglement_consommable (ID_REGLEMENT, ID_CONSOMMABLE)
				VALUES (:idReglement, :idConsommable);";
			$params = array(
				':idReglement' => $idReglement,
				':idConsommable' => $idConsommable
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de l'ajout du consommable dans le reglement dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	
	}


	// Récupère l'id de l'utilisateur du centre informatique en fonction de son email
	public function getIdUtilisateur($email)
	{
		try {
			$req = "SELECT ID_UTILISATEUR FROM utilisateur_centreinfo where EMAIL = :email;";
			$params = array(':email' => $email);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function getDernierIdUtilisateurCentreInfo() {
		try {
			$req = "SELECT MAX(ID_UTILISATEUR) FROM utilisateur_centreinfo;";
			$rs = $this->Read($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du dernier identifiant de l'utilisateur du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs['MAX(ID_UTILISATEUR)'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	// Compte le nombre de consommables
	public function compteConsommables() {
		try {
			$req = "SELECT COUNT(*) FROM consommable;";
			$rs = $this->Read($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du nombre de consommables dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs['COUNT(*)'];
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	public function getConsommableById($idConsommable) {
		try {
			$req = "SELECT * FROM consommable WHERE ID_CONSOMMABLE = :idConsommable;";
			$params = array(':idConsommable' => $idConsommable);
			$rs = $this->Read($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche du consommable dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	public function getActiviteById($idActivite) {
		try {
			$req = "SELECT * FROM activite WHERE ID_ACTIVITE = :idActivite;";
			$params = array(':idActivite' => $idActivite);
			$rs = $this->Read($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche de l'activite dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	// Récupère toutes les activités du centre informatique (sauf "Toutes les activités")
	public function getActivitesExceptAll() {
		try {
			$req = "SELECT * FROM activite WHERE ID_ACTIVITE != 0;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des activites du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	public function getIdUtilisateursCentreInfo() {
		try {
			$req = "SELECT ID_UTILISATEUR FROM utilisateur_centreinfo;";
			$rs = $this->ReadAll($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des utilisateurs du centre informatique dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	public function getConsommablesActivite($idActivite) {
		try {
			$req = "SELECT consommable.ID_CONSOMMABLE, consommable.NOM, consommable.PRIX, consommable.PHOTO, consommable.DESCRIPTION
			FROM consommable
			JOIN activite_consommable ON consommable.ID_CONSOMMABLE = activite_consommable.ID_CONSOMMABLE
			WHERE activite_consommable.ID_ACTIVITE = :idActivite;";
			$params = array(':idActivite' => $idActivite);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la recherche des consommables de l'activite dans la base de donnees.", $req, PdoBD::$monPdo->errorInfo());}
			return $rs;
		}
		catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}	
	}

	public function getReglementsByUserId($userId) {
		try {
			$req = "SELECT * FROM reglement_centreinfo rci
			INNER JOIN reglement_utilisateur_centreinfo ruci ON ruci.ID_REGLEMENT = rci.ID
			INNER JOIN utilisateur_centreinfo uci ON uci.ID_UTILISATEUR = ruci.ID_UTILISATEUR
			WHERE uci.ID_UTILISATEUR = :userId;";
			$params = array(':userId' => $userId);
			$rs = $this->ReadAll($req, $params);
			if ($rs === false) {
				afficherErreurSQL("Problème lors de la recherche des règlements pour l'utilisateur $userId");
			}
			return $rs;
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function modifierReglement($idReglement, $typeReglement, $montant, $banque, $numTransaction, $date, $commentaire) {
		try {
			$req = "UPDATE reglement_centreinfo
			SET TYPE_REGLEMENT = :typeReglement, MONTANT = :montant, BANQUE = :banque, NUM_TRANSACTION = :numTransaction, DATE = :dateReglement, COMMENTAIRE = :commentaire
			WHERE ID = :idReglement;";
			$params = array(
				':idReglement' => $idReglement,
				':typeReglement' => $typeReglement,
				':montant' => $montant,
				':banque' => $banque,
				':numTransaction' => $numTransaction,
				':dateReglement' => $date,
				':commentaire' => $commentaire
			);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {
				afficherErreurSQL("Problème lors de la modification du règlement $idReglement");
			}
			return $rs;
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}
	public function supprimerReglement($idReglement) {
		try {
			$req = "DELETE FROM reglement_utilisateur_centreinfo WHERE ID_REGLEMENT = :idReglement;
			DELETE FROM reglement_centreinfo WHERE ID = :idReglement;";
			$params = array(':idReglement' => $idReglement);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {
				afficherErreurSQL("Problème lors de la suppression du règlement $idReglement");
			}
			return $rs;
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function supprimerTousReglements($idUser) {
		try {
			$req = "DELETE FROM reglement_utilisateur_centreinfo WHERE ID_UTILISATEUR = :idUser;";
			$params = array(':idUser' => $idUser);
			$rs = $this->NonQuery($req, $params);
			if ($rs === false) {
				afficherErreurSQL("Problème lors de la suppression de tous les règlements de l'utilisateur $idUser");
			}
			return $rs;
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}
	
	public function getUtilisateurCentreInfoById ($idUser) {
		try {
			$req = "SELECT * FROM utilisateur_centreinfo WHERE ID_UTILISATEUR = :idUser;";
			$params = array(':idUser' => $idUser);
			$rs = $this->Read($req, $params);
			if ($rs === false) {
				afficherErreurSQL("Problème lors de la recherche de l'utilisateur $idUser");
			}
			return $rs;
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
	}	
  
	//envoie la note globale du stage dans la table stage_revision
	public function setNotesStageRevision($idStage, $notes) {
		$req = "UPDATE stage_revision
				SET NOTES = :notes
				WHERE ID_STAGE = :idStage;";
		$params = array(
			':idStage' => $idStage,
			':notes' => $notes
		);
		$rs = $this->NonQuery($req, $params);
		if ($rs === false) {
			afficherErreurSQL("Problème lors de l'ajout des notes dans la base de données.", $req, PdoBD::$monPdo->errorInfo());
		}
		return $rs;
	}
}
?>