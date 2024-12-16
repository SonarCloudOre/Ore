<?php
/**
 * Fonctions php pour l'application
  * @version 1.0 version MVC modifiee le 6 février 2014 par Blain Pascal
 */

 /**
 * Teste si un agent est connecté (return vrai ou faux)
 */
function estConnecte(){
  return isset($_SESSION['intervenant']);
}

function getAnneeEnCours() {
    $year = (int)date('Y');
    return (int)date('m') > 7
        ? $year
        : $year - 1;
}

/**
 * Enregistre dans des variables de session les informations d'un agent
 */
function connecter($intervenant){
	$_SESSION['intervenant']=array();
	$_SESSION['intervenant']= $intervenant;

    // Ville par défaut
	$_SESSION['villeExtranet']='quetigny';
    $_SESSION['anneeExtranet']=getAnneeEnCours();
}
/**
 * Detruit la session active
 */
function deconnecter(){
	session_destroy();
}
/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
 * @param $madate au format  jj/mm/aaaa
 * @return la date au format anglais aaaa-mm-jj
*/
function dateFrancaisVersAnglais($maDate){
	if(estDateValide($maDate)== true)
	{
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
	}
	else
	{
	return null;
	}
}
/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format français jj/mm/aaaa
 * @param $madate au format  aaaa-mm-jj
 * @return la date au format format français jj/mm/aaaa
*/
function dateAnglaisVersFrancais($maDate)
{
   @list($annee,$mois,$jour)=explode('-',$maDate);
   $date="$jour"."/".$mois."/".$annee;
   return $date;
}

function dateAnglaisVersFrancaisHMS($maDate)
{
@list($annee,$mois,$jour)=explode('-',$maDate);
$jourheures = explode(' ',$jour);
$jour = $jourheures[0];
$heures = $jourheures[1];
  $date="$jour"."/".$mois."/".$annee." ".$heures;
  echo $date;

}
/**
 * retourne le mois au format aaaamm selon le jour dans le mois
 * @param $date au format  jj/mm/aaaa
 * @return le mois au format aaaamm
*/
function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}

/**
 * retourne la date en texte
*/
function dateTexte($laDate){
		$NomDuJour = array ("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
		$NomDuMois = array ("janvier", "f&eacute;vrier", "mars", "avril", "mai", "juin", "juillet", "ao&ucirc;t", "septembre", "octobre", "novembre", "d&eacute;cembre");
		$lejour = date("j",$laDate);
		$lemois = $NomDuMois[date("n",$laDate)-1];
		$dateTexte=$NomDuJour[date("w",$laDate)]." ";
		if($lejour==01){$dateTexte.=' 1er '; }
		else {$dateTexte.=$lejour.' ';}
		$dateTexte.=$lemois.' '.date('Y', $laDate);
		return $dateTexte;
}

/**
 * retourne le mois en texte
*/
function moisTexte($mois){
$tabMois = array(	'01' => "Janvier",
					'02' => "F&eacute;vrier",
					'03' => "Mars",
					'04' => "Avril",
					'05' => "Mai",
					'06' => "Juin",
					'07' => "Juillet",
					'08' => "Ao&ucirc;t",
					'09' => "Septembre",
					'10' => "Octobre",
					'11' => "Novembre",
					'12' => "D&eacute;cembre");
		return $tabMois[$mois];
}

/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul
 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur)
{
	return preg_match("/[^0-9]/", $valeur) == 0;
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 * @param $tabEntiers : le tableau
 * @return vrai ou faux
*/
function estTableauEntiers($tabEntiers)
{
	$ok = true;
	foreach($tabEntiers as $unEntier)
	{
		if(!estEntierPositif($unEntier)){$ok=false;}
	}
	return $ok;
}
/**
 * Vérifie si une date est inférieure d'un an à la date actuelle
 * @param $dateTestee
 * @return vrai ou faux
*/
function estDateDepassee($dateTestee)
{
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse);
}
/**
 * Vérifie la validité du format d'une date française jj/mm/aaaa
 * @param $date
 * @return vrai ou faux
*/
function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}

/**
 * Ajoute le libelle d'une erreur au tableau des erreurs
 * @param $msg : le libellé de l'erreur
 */
function ajouterErreur($msg){
   if (! isset($_REQUEST['erreurs'])){
      $_REQUEST['erreurs']=array();
	}
   $_REQUEST['erreurs'][]=$msg;
}

/**
 * Retoune le nombre de lignes du tableau des erreurs
 * @return le nombre d'erreurs
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}

/** afficherErreurSQL :
		Affichage de messages lors l'accès &agrave; la bdd avec une requete SQL
		@param $message	: message a afficher
		@param $req 	: requete executee
		@param $info	: erreur constatee
*/
function afficherErreurSQL($message, $req, $info) {
		echo $message . "<br />";
		echo "Requete : " . $req . "<br />";
		echo "Code erreur : " . $info[0] . ", Message : " . $info[2];
		die();
}

function getUri($fichierimage) {
    return ('data:' . mime_content_type($fichierimage) . ';base64,' . base64_encode(file_get_contents($fichierimage)));
}

/**
 * Retourne le moment de la journée en tant qu'entier.
 *
 * @return int 1 = matin ; 2 = après-midi
 */
function getMomentJournee() {
    return getdate()['hours'] > 12 ? 2 : 1;
}

/**
 * Retourne le moment de la journée au format français.
 *
 * @return string matin ou après-midi
 */
function getMomentJourneeTexte() {
    $textes = ['', 'matin', 'après-midi'];
    return $textes[getMomentJournee()];
}

// Génére un formulaire d'adresse
function formulaireAdresse($adresse,$cp,$ville) {

    ?>

<label for="adresse">Rechercher une adresse postale</label>
                                <div id="locationField">
                                    <input id="autocomplete" class="form-control" placeholder="Entrez une adresse..." onFocus="geolocate()" type="text"></input>
                                </div><br>

    <script>

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        postal_code: 'short_name'
      };

        function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val.toUpperCase();
          }
        }
          majAdresse();
      }

        // Bias the autocomplete object to the user\'s geographical location,
      // as supplied by the browser\'s \'navigator.geolocation\' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }

    function majAdresse() {
        var streetNumber = document.getElementById('street_number').value;
        var route = document.getElementById('route').value;
        document.getElementById('route_complete').value = streetNumber + " " + route;
    }

    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjPJg7_n_ggdYO9gv0PUksH15ORbkNxXE&libraries=places&callback=initAutocomplete"
        async defer></script>



                            <input type="hidden" id="street_number">
                            <input type="hidden" id="route">

                                <label for="adresse">Rue</label>
                                <input class="form-control" id="route_complete"  name="adresse" value=""><br>

                                <label for="cp">Code postal</label>
                                <input class="form-control" id="postal_code"  type="number" name="cp" value=""><br>

                                <label for="ville">Ville</label>
                                <input class="form-control" id="locality"  name="ville" value=""><br>

<?php }
?>
