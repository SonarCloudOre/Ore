<link href="./styles/css/cartecss.css" rel="stylesheet">
<link href="./styles/css/cartecss-print.css" rel="stylesheet">

<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Ma carte ORE - <?= $utilisateur['NOM'] ?> <?= $utilisateur['PRENOM'] ?>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <button onclick="downloadImage()" class="ladda-button mr-2 btn btn-primary"
                            data-style="expand-left">
                        <span class="ladda-label">Télécharger ma carte</span>
                        <span class="ladda-spinner"></span>
                    </button>
                    <button onclick="printImage()" class="btn btn-primary" title="Imprimer ma carte">
                        <i class="fa fa-print"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper" id="htmltoimage" data-person-type="<?= $typeUtilisateur ?>">
        <div class="left">
            <img src="<?= $emplacementPhoto . '/' . $utilisateur['PHOTO'] ?>" alt="user" width="100">
            <p>
                <img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl=<?= $acronymeUtilisateur . '_' . $id_utilisateur; ?>&choe=UTF-8"/>
            </p>
            <?php $annee =  $_SESSION['anneeExtranet'] ?>
            <h2><?= $annee ?>-<?= $annee + 1 ?></h2>
        </div>
        <div class="right">
            <div class="titre">
                <h1 class="text-center">Carte adhérent</h1>
            </div>
            <div class="info">
                <h3>Espace personnel</h3>
                <div class="info_data">
                    <div class="data<?= count($utilisateur['SPECIALITE'] ?? 0) > 4 ? ' specialites5' : '' ?>">
                        <h4 id="identity">Identité</h4>
                        <p id="person-name"><?= $utilisateur['NOM'] . ' ' . $utilisateur['PRENOM'] ?></p>
						<?php if (!empty($utilisateur['SPECIALITE'])) { ?>
                            <p id="specialites"><?= implode('<br>', $utilisateur['SPECIALITE']) ?></p>
						<?php } ?>
                    </div>
                    <div class="data">
                        <h4>Date de naissance</h4>
                        <p><?= dateAnglaisVersFrancais($utilisateur['DATE_DE_NAISSANCE']) ?></p>
                    </div>
                </div>
            </div>
            <div class="projects">
                <div class="projects_data">
                    <div class="data">
                        <h4>Identifiant</h4>
                        <p><?= $utilisateur['NOM'] . '.' . $utilisateur['PRENOM'][0] ?></p>
                    </div>
                    <div class="data">
                        <h4>Mot de passe</h4>
                        <p>****</p>
                    </div>
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
        function downloadImage() {
            const container = document.getElementById('htmltoimage');
            html2canvas(container, {allowTaint: true, useCORS: true, scale: 2, imageSmoothingEnabled: true}).then(function (canvas) {
                const link = document.createElement('a');
                document.body.appendChild(link);
                link.download = 'carte_ore_<?= $utilisateur['NOM'] ?>.jpg';
                link.href = canvas.toDataURL();
                link.target = '_blank';
                link.click();
            });
        }

        function printImage() {
            const container = document.getElementById('htmltoimage');
            const type = $(container).attr('data-person-type');
            const identity = $('#identity');
            const personName = $('#person-name');

            $(container).addClass('wrapper-print');
            if (type === 'Intervenant') {
                $(container).addClass('wrapper-print-intervenant');
                identity.text(personName.text());
            }
            else identity.text(type);

            html2canvas(container, {allowTaint: true, useCORS: true, scale: 5, imageSmoothingEnabled: true}).then(function (canvas) {
                identity.text('Identité');
                $(container).removeClass('wrapper-print')
                            .removeClass('wrapper-print-intervenant');

                const iframe = document.createElement('iframe');
                $('#contenu').prepend(iframe);
                iframe.src = 'about:blank';
                iframe.style.minHeight = '250px';
                iframe.style.border = 'none';
                iframe.sandbox.add('allow-modals');
                iframe.contentWindow.document.open();
                iframe.contentWindow.document.write(
                    `<head>
                        <style>@page { size: auto; margin: 1mm 1mm 1mm 1mm; }</style>
                    </head>
                    <body style="margin: 0">
                        <img src="${canvas.toDataURL()}" width="300px" height="185px" alt="Carte ORE">
                    </body>`
                );
                iframe.contentWindow.document.close();

                setTimeout(() => {
                    iframe.contentWindow.print();
                    iframe.contentWindow.close();

                    // Remove the print <iframe> and the parent <iframe>, if exists
                    iframe.parentElement.removeChild(iframe);
                    if (window.frameElement) {
                        window.frameElement.parentElement.removeChild(window.frameElement);
                    }
                }, 500);
            });
        }

        window.addEventListener('load', () => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('print')) printImage();
        });
    </script>
</div>
