<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);?>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Inscriptions stages - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"]
                ?></div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
                <button type="button" class="btn btn-primary" value="" onClick="imprimer('sectionAimprimer');">
                    <i class="fa fa-print"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="contenu">
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Stages - Inscriptions ouvertes</h5>
            <div class="grid-menu grid-menu-2col">
                <div class="no-gutters row">
                    <?php
                    $i = 0;
                    foreach ($lesStage as $unStage) {
                        $nbInscriptionsStages = 0;
                        if (strtotime($unStage['DATE_FIN_INSCRIT_STAGE']) > time()) {
                            $get_expiry_time = $unStage['DATE_FIN_INSCRIT_STAGE'];
                            echo '
                      <div class="col-sm-6">
                      <div class="btn-icon-vertical btn-transition  btn btn-outline-link">
                      <img src="./images/imageStage/' . $unStage['IMAGE_STAGE'] . '" style="width:300px">
                          <i class="lnr-license btn-icon-wrapper btn-icon-lg mb-3"></i>
                          <span class="badge badge-info badge-dot badge-dot-lg badge-dot-inside"></span>
                          ' . $unStage['NOM_STAGE'] . ' - ' . $unStage['PRIX_STAGE'] . ' €
                          <br><br>
                          <a style="text-decoration:none;" href="index.php?choixTraitement=inscriptionstage&action=inscription&num=' . $unStage['ID_STAGE'] . '" target="_blank"><button class="ladda-button mb-2 mr-2 btn btn-warning" data-style="slide-down">
                              <span class="ladda-label">M\'inscrire</span>
                              <span class="ladda-spinner"></span>
                          </button></a>
                          <br><p class="demo" id="demo' . $i . '"></p>
                          <br>
                          <i>' . html_entity_decode($unStage['DESCRIPTION_STAGE']) . '</i>
                          </div>
                      </div>
                      ' ?>
                            <script>
                                var countDownDate = new Date("<?php echo $get_expiry_time ?> 00:00:00").getTime();

                                // Update the count down every 1 second
                                var x = setInterval(function () {

                                    // Get today's date and time
                                    var now = new Date().getTime();

                                    // Find the distance between now and the count down date
                                    var distance = countDownDate - now;

                                    // Time calculations for days, hours, minutes and seconds
                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    // Output the result in an element with id="demo"
                                    document.getElementById("demo<?php echo $i?>").innerHTML = "Temps restant : " + days + "j " + hours + "h "
                                        + minutes + "m " + seconds + "s ";

                                    // If the count down is over, write some text
                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("demo<?php echo $i?>").innerHTML = "PLUS DISPONIBLE";
                                    }
                                }, 1000);
                            </script>


                            <?php $i++;

                            $nbInscriptionsStages++;

                        }
                    }
                    ?>

                </div><?php if ($nbInscriptionsStages == 0) {
                    echo '<br><center><p><i>Aucun stages disponibles pour l\'instant</i></p></center>';
                } ?>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="./vendors/Ladda-1.0.6/dist/spin.min.js"></script>
<script type="text/javascript" src="./vendors/Ladda-1.0.6/dist/ladda.min.js"></script>

<script type="text/javascript" src="./js/ladda-loading.js"></script>
