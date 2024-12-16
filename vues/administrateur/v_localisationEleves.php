<div id="contenu">


    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Carte des élèves
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <div class="row">
                        <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                            <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                        </button>
                        <button type="button" class="btn btn-primary" value=""
                                onClick="imprimer2('sectionAimprimer2');">
                            <i class="fa fa-print"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Module Leaflet -->
    <link rel="stylesheet" href="include/leaflet/leaflet.css"/>
    <script src="include/leaflet/leaflet.js"></script>

    <!-- Liste des cantons -->
    <?php if ($afficherCantons) { ?>
        <script type="text/javascript" src="include/cantons2015.js"></script><?php } ?>


    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form method="POST" action="index.php?choixTraitement=administrateur&action=localisationEleves">
                        <p>
                            <label for="afficherCantons">
                                <input type="checkbox" name="afficherCantons"
                                       id="afficherCantons"<?php if ($afficherCantons) {
                                    echo ' checked="checked"';
                                } ?> onchange="this.form.submit()"> Afficher les cantons
                            </label>
                        </p>
                    </form>
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        #map {
            width: 1100px;
            height: 700px;
        }
    </style>

    <script>
        var map = L.map('map').setView([47.322047, 5.04148], 13);


        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1Ijoib3JlLXF1ZXRpZ255IiwiYSI6ImNrbzMwMnd2bzE0cXQycXBnY3BrOGpxZ3gifQ.eA2lCbOvIhxh973t1khghw'
        }).addTo(map);

        <?php if($afficherCantons) { ?>
        L.geoJSON(cantons2015).addTo(map);
        <?php } ?>
        <?php
        // On parcours les inscriptions
        $i = 0;
        foreach ($lesEleves as $uneInscription) {

            $lat = NULL;
            $lon = NULL;

            // On récupère les coordonnées
            foreach ($lesLocalisations as $laLocalisation) {
                if ($laLocalisation['ID_ELEVE'] == $uneInscription['ID_ELEVE']) {
                    $lat = $laLocalisation['LAT'];
                    $lon = $laLocalisation['LON'];
                }
            }

            // Si les coordonnées sont vides
            if ($lat == NULL) {

                // On récupère les coordonnées GPS de l'adresse
                $address = addslashes($uneInscription['ADRESSE_POSTALE']) . ' ' . addslashes($uneInscription['CODE_POSTAL']) . ' ' . addslashes($uneInscription['VILLE']) . ', France';
                $request_url = "https://maps.googleapis.com/maps/api/geocode/xml?key=AIzaSyA_C2zsDEHSud_LkZbu4KuoTwyx6hIpDQU&address=" . $address . "&sensor=true";
                $xml = simplexml_load_file($request_url) or die("url not loading");
                $status = $xml->status;
                if ($status == "OK") {
                    $lat = $xml->result->geometry->location->lat;
                    $lon = $xml->result->geometry->location->lng;
                }

                // Si erreur sur l'adresse
                if ($lat == '') {
                    $lat = 0;
                    $lon = 0;
                }

                // On stocke les coordonnées dans la base
                $pdo->majCoordonneesEleves($uneInscription['ID_ELEVE'], $lat, $lon);

            }

            // Si l'adresse a été trouvée
            if ($lat != 0) {

                if ($uneInscription['PHOTO'] == "") {
                    $photo = "AUCUNE.jpg";
                } else {
                    $photo = $uneInscription['PHOTO'];
                }

                // On crée la bulle d'info
                echo "L.marker([" . $lat . ", " . $lon . "]).addTo(map)
    .bindPopup('<b><a href=index.php?choixTraitement=administrateur&action=lesEleves&unEleve=" . $uneInscription['ID_ELEVE'] . ">" . addslashes($uneInscription['NOM']) . " " . addslashes($uneInscription['PRENOM']) . "</a></b><br>" . addslashes($uneInscription['ADRESSE_POSTALE']) . "<br>" . addslashes($uneInscription['CODE_POSTAL']) . " " . addslashes($uneInscription['VILLE']) . "')
    ;
    ";
                $i++;
            }

        }
        ?>

    </script>


    <!--


                <script type="text/javascript">

                function initMap() {
  var mymap = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: {lat: 47.322047, lng: 5.04148},
    zoomControl: true,
    scaleControl: true
  });

<?php
    /*
    // On parcours les inscriptions
    $i = 0;
    foreach($lesEleves as $uneInscription) {

        $lat = NULL;
        $lon = NULL;

        // On récupère les coordonnées
        foreach($lesLocalisations as $laLocalisation) {
            if($laLocalisation['ID_ELEVE'] == $uneInscription['ID_ELEVE']) {
                $lat = $laLocalisation['LAT'];
                $lon = $laLocalisation['LON'];
            }
        }

        // Si les coordonnées sont vides
        if($lat == NULL) {

            // On récupère les coordonnées GPS de l'adresse
            $address = addslashes($uneInscription['ADRESSE_POSTALE']) . ' ' . addslashes($uneInscription['CODE_POSTAL']) . ' ' . addslashes($uneInscription['VILLE']) . ', France';
            $request_url = "https://maps.googleapis.com/maps/api/geocode/xml?key=AIzaSyA_C2zsDEHSud_LkZbu4KuoTwyx6hIpDQU&address=".$address."&sensor=true";
            $xml = simplexml_load_file($request_url) or die("url not loading");
            $status = $xml->status;
            if ($status=="OK") {
                $lat = $xml->result->geometry->location->lat;
                $lon = $xml->result->geometry->location->lng;
            }

            // Si erreur sur l'adresse
            if($lat == '') {
                $lat = 0;
                $lon = 0;
            }

            // On stocke les coordonnées dans la base
            $pdo->majCoordonneesEleves($uneInscription['ID_ELEVE'],$lat,$lon);

        }

        // Si l'adresse a été trouvée
        if($lat != 0) {

        if($uneInscription['PHOTO']=="")
            {$photo="AUCUNE.jpg";}
            else
            {$photo=$uneInscription['PHOTO'];}

        // On crée la bulle d'info
        echo "var infowindow".$i." = new google.maps.InfoWindow({
              content: '<center><img src=\'photosEleves/".$photo."\' style=width:150px;display:none></center><br><b><a href=index.php?choixTraitement=administrateur&action=lesEleves&unEleve=".$uneInscription['ID_ELEVE'].">".addslashes($uneInscription['NOM'])." ".addslashes($uneInscription['PRENOM'])."</a></b><br>".addslashes($uneInscription['ADRESSE_POSTALE'])."<br>".addslashes($uneInscription['CODE_POSTAL'])." ".addslashes($uneInscription['VILLE'])."'
            });
            ";

        // On ajoute le marqueur
        echo "var marker".$i." = new google.maps.Marker({
            position: {lat: ".$lat.", lng: ".$lon."},
            map: mymap,
            title: ''
            });

            marker".$i.".addListener('click', function() {
              infowindow".$i.".open(mymap, marker".$i.");
            });";

        $i++;
        }

    } */
    ?>
}
                </script>

                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_C2zsDEHSud_LkZbu4KuoTwyx6hIpDQU&callback=initMap" type="text/javascript"></script>

                    </div>
-->
</div>
