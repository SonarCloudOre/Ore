<?php

// Date de début et de fin en Français
list($anneeD, $moisD, $jourD) = explode('-', $debut);
list($anneeF, $moisF, $jourF) = explode('-', $fin);
$dateDebut = $jourD . "-" . $moisD . "-" . $anneeD;
$dateFin = $jourF . "-" . $moisF . "-" . $anneeF;
?>
<div class="app-page-title">

    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Présences - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
        </div>
        <div class="page-title-actions">
            <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
            </button>
            <button type="button" class="btn btn-primary" value="" onClick="imprimer('sectionAimprimer');">
                <i class="fa fa-print"></i>
            </button>
        </div>
    </div>
</div>
<div id="contenu">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Plage de dates</h5>
                <button class="btn btn-primary" id="reportrange">
                    <i class="fa fa-calendar pr-1"></i>
                    <span></span>
                    <i class="fa pl-1 fa-caret-down"></i>
                    <input type="hidden" name="from" id="from" value="">
                    <input type="hidden" name="to" id="to" value="">

                </button>

                <input type="button" name="filter" id="filter" value="Filtrer" class="btn btn-info"/>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Présences</div>
                    <div class="widget-subheading">Nombre total de présences</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white" id="countnb">
                        <span><?php foreach ($nb as $unnb) {
                                echo $unnb['nb'];
                            } ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Tableau des présences </h5>
                <div id="order_table">
                    <table class="mb-0 table table-hover" id="table1">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Présences</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php

                            $total = 0;
                            foreach ($tableau as $uneLigne) {
                                // extraction des jour, mois, an de la date
                                list($annee, $mois, $jour) = explode('-', $uneLigne['SEANCE']);
                                // calcul du timestamp
                                $dateFrench = $jour . "-" . $mois . "-" . $annee;
                                $total++;
                                echo '<tr><th scope="row"> ' . $dateFrench . ' </th><td>Présent(e)</td><td>' . $uneLigne['type'] . '</td></tr>';
                            }
                            ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="./vendors/moment/min/moment-with-locales.js"></script>
<script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/dist/datepicker.min.js"></script>
<script type="text/javascript" src="./vendors/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="./vendors/countup.js/dist/countUp.js"></script>
<script type="text/javascript" src="./js/form-components/datepicker.js"></script>


<script>
    $(document).ready(function () {

        $(function () {
            $("#from").datepicker();
            $("#to").datepicker();
        });
        $('#filter').click(function () {
            var to_date = $('#from').val();
            var from_date = $('#to').val();
            if (from_date != '' && to_date != '') {
                $.ajax({
                    url: "vues/eleve/filter.php",
                    method: "POST",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        "eleve": "<?php  print $intervenant['ID_ELEVE']; ?>"
                    },
                    success: function (data) {
                        var result = $.parseJSON(data);
                        $('#order_table').html(result.html); // This appends value1
                        $('#countnb').html(result.nb); // This appends value2
                    }


                });
            } else {
                alert("Séléctionnez une plage de date");
            }
        });
    });
</script>
