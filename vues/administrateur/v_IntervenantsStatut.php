<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Fiches horaires
                    <?php

                    if (isset($num)) {
                        echo '<div class="page-title-subheading">' . $IntervenantSelectionner["PRENOM"] . ' ' . $IntervenantSelectionner["NOM"] . '</div>';
                    } else {
                        echo '<div class="page-title-subheading">Heures effectuées par les intervenants</div>';
                    }
                    ?>

                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <div class="row">
                        <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                            <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=administrateur&action=ValidationIntervenantsHoraires">
        <fieldset>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="form-group">

                                <h4 class="card-title">Fiches horaires </h4>
                                <label for="assurance">Tableau</label><br>
                                <div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">

                                    <label class="btn btn-warning">
                                        <input type="radio" value="1" name="tableau" autocomplete="off" checked>
                                        Un intervenant
                                    </label>
                                    <label class="btn btn-warning">
                                        <input type="radio" value="0" name="tableau" autocomplete="off">
                                        Par Statut
                                    </label>

                                </div>


                                <br><br>

                                <div class="statut">

                                    <label for="statut">Statut</label>
                                    <select name="statut" class="form-control" style="max-width:300px;">
                                        <option value="Etudiant" selected="selected" name="statut">Bénévole</option>
                                        <option value="Salarié" name="statut">Salarié</option>
                                        <option value="Stagiaire" name="statut">Stagiaire</option>
                                        <option value="Bénévole nbH" name="statut">Bénévole nbH</option>
                                        <option value="BSB" name="statut">BSB</option>
                                        <option value="Service Civique" name="statut">Service Civique</option>
                                    </select></div>
                                <br>

                                <div class="intervenants">

                                    <label for="intervenants">Les Intervenants</label>
                                    <select name="intervenants" class="multiselect-dropdown form-control"
                                            style="max-width:300px;">

                                        <?php

                                        foreach ($lesIntervenants as $unIntervenant) {

                                            echo '<option value="' . $unIntervenant['ID_INTERVENANT'] . '" name="intervenants">' . $unIntervenant['NOM'] . ' ' . $unIntervenant['PRENOM'] . '</option>';

                                        }

                                        ?>
                                    </select></div>
                                <br>
                                <fieldset>


                                    <button type="button" class="btn btn-primary" id="reportrange">


                                        <i class="fa fa-calendar pr-1"></i>
                                        <span></span>
                                        <i class="fa pl-1 fa-caret-down"></i>
                                        <input type="hidden" name="debut" id="from" value="">
                                        <input type="hidden" name="fin" id="to" value="">

                                    </button>
                                    <input type="submit" name="filter" id="filter" value="Filtrer"
                                           class="btn btn-info"/>


                                </fieldset>
    </form>
    <br>

</div></div></div></div></div>
<br/>


</div>


<script type="text/javascript" src="./vendors/moment/min/moment-with-locales.js"></script>
<script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/dist/datepicker.min.js"></script>
<script type="text/javascript" src="./vendors/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="./vendors/countup.js/dist/countUp.js"></script>
<script type="text/javascript" src="./js/form-components/datepicker.js"></script>


<script>
    // Filtre les date avec le datepicker
    $(document).ready(function () {

        $(function () {
            $("#from").datepicker();
            $("#to").datepicker();
        });
        $('#filter').click(function () {
            var from_date = $('#from').val();
            var to_date = $('#to').val();

        });
    });

    $(".intervenants").hide();
    $(".statut").hide();

    $("input[name='tableau']").click(function () {
        if ($(this).val() == 1) {
            $(".intervenants").show();
            $(".statut").hide();
        } else {
            $(".intervenants").hide();
            $(".statut").show();
        }
    });
</script>


<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript"
        src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="./js/form-components/input-select.js"></script>
