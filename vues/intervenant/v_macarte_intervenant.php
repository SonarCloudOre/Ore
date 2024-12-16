<link href="./styles/css/cartecss.css" rel="stylesheet">
<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Ma carte ORE - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <button onclick="downloadimage()" class="ladda-button mr-2 btn btn-primary"
                            data-style="expand-left">
                        <span class="ladda-label"> Télécharger ma carte</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="./vendors/Ladda-1.0.6/dist/spin.min.js"></script>
    <script type="text/javascript" src="./vendors/Ladda-1.0.6/dist/ladda.min.js"></script>
    <script type="text/javascript" src="./js/form-components/toggle-switch.js"></script>
    <script type="text/javascript" src="./js/ladda-loading.js"></script>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script type="text/javascript">

        function downloadimage() {
            //var container = document.getElementById("image-wrap"); //specific element on page
            var container = document.getElementById("htmltoimage");
             // full page
            html2canvas(container, {allowTaint: true, useCORS: true}).then(function (canvas) {

                var link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "carte_ore_<?php echo $intervenant["NOM"] ?>.jpg";
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }

    </script>


    <div class="wrapper" id="htmltoimage">
        <div class="left">
            <img src="<?php echo 'photosIntervenants/' . $intervenant["PHOTO"] ?>" alt="user" width="100">
            <p>
                <img
                    src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl=<?php echo 'i_' . $intervenant["ID_INTERVENANT"]; ?>&choe=UTF-8"
                    title="Id intervenant"/>
            </p>
            <h2>2021-2022</h2>
        </div>
        <div class="right">
            <div class="titre">
                <center>
                    <h1>Carte adhérent</h1>
                </center>
            </div>
            <div class="info">


                <h3>Espace personnel</h3>
                <div class="info_data">
                    <div class="data">
                        <h4>Identité</h4>
                        <p><?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></p>
                    </div>
                    <div class="data">
                        <h4>Date de naissance</h4>
                        <p><?php echo dateAnglaisVersFrancais($intervenant["DATE_DE_NAISSANCE"]) ?></p>
                    </div>
                </div>
            </div>

            <div class="projects">

                <div class="projects_data">
                    <div class="data">
                        <h4>Identifiant</h4>
                        <p><?php echo $intervenant["NOM"] . "." . $intervenant["PRENOM"]{0} ?></p>
                    </div>
                    <div class="data">
                        <h4>Mot de passe</h4>
                        <p><?php echo "****" ?></p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
