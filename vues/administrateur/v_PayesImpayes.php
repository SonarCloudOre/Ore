<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Liste des Payés / Impayés
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-1 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>

                    <button type="button" class="btn btn-primary" value="" onClick="imprimer2('sectionAimprimer2');">
          <span class="btn-icon-wrapper opacity-7">
            <i class="fa fa-print fa-w-20"></i>
          </span>
                    </button>


                    <?php echo '<a href="index.php?choixTraitement=administrateur&action=ImpayesPayesCSV&reglement=' . $reglement . '&evenementON=' . $evenementON . '&valeur=' . $valeur . '&evenements=' . $evenement . '&tableau1=' . $tableau . '"><button type="button" class=" mr-2 btn btn-primary" value="Exporter la liste"> <span class="btn-icon-wrapper pr-2 opacity-7">
  <i class="fa fa-print fa-w-20"></i>
</span> Exporter la liste </button></a> '; ?>

                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">

                <table class="mb-0 table">
                    <tr>
                        <th> Nom-Prénom</th>
                        <th> Date de naissance</th>
                        <th> Téléphone</th>
                        <th> Adresse complète</th>
                    </tr>

                    <?php

                    $total = 0;
                    foreach ($tableau as $uneLigne) {
                        $total++;
                        echo '<tr> <td > ' . $uneLigne['NOM'] . ' ' . $uneLigne['PRENOM'] . '</td> <td > ' . $uneLigne['DATE_DE_NAISSANCE'] . ' </td> <td > ' . $uneLigne['TÉLÉPHONE_DES_PARENTS'] . ' </td><td > ' . $uneLigne['ADRESSE_POSTALE'] . ' ' . $uneLigne['CODE_POSTAL'] . ' ' . $uneLigne['VILLE'] . '</td></tr>';
                    }

                    echo " <tr >  </th><th>  </th><th >  </th><th > Total d'élèves :  " . $total . " </th></tr> </table></div></div></div></div>";


                    ?>
