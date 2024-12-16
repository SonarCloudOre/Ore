<div id="contenu">
    <!-------------------------------------------------------------------- Lieux --------------------------------------------------------------------------------->

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Modifier un lieu
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <?php
                    foreach ($lesLieux

                    as $leLieu) {
                    if ($leLieu['ID_LIEU'] == $num) {
                    ?>
                    <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
                          action="index.php?choixTraitement=administrateur&action=ModifierLieuConfirmation">
                        <div class="form-group">
                            <input type="hidden" name="num" value="<?php echo $leLieu['ID_LIEU']; ?>">
                            <h4 class="card-title">Modifier un lieu</h4>
                            <label for="nom">Nom </label>
                            <input class="form-control" name="nom" value="<?php echo $leLieu['NOM_LIEU']; ?>"
                                   autofocus=""><br>

                            <label for="adresse">Adresse </label>
                            <input class="form-control" name="adresse" value="<?php echo $leLieu['ADRESSE_LIEU']; ?>"
                                   autofocus=""><br>

                            <label for="cp">Code postal </label>
                            <input class="form-control" name="cp" value="<?php echo $leLieu['CP_LIEU']; ?>"
                                   autofocus=""><br>

                            <label for="ville">Ville </label>
                            <input class="form-control" name="ville" value="<?php echo $leLieu['VILLE_LIEU']; ?>"
                                   autofocus=""><br>

                            <input value="Modifier" type="submit" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php }
    } ?>
</div>


<?php
$LstVilles = array();
$LstCP = array();
for ($i = 0; $i < count($villesFrance); $i++) {
    $ville = $villesFrance[$i]["COMMUNE"];
    $cp = $villesFrance[$i]["CP"];
    array_push($LstVilles, $ville);
    array_push($LstCP, $cp);
}
?>
<link rel="stylesheet" href="./styles/css/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function () {
        var villes = <?php echo json_encode($LstVilles); ?>;
        var cp = <?php echo json_encode($LstCP); ?>;
        $("input[name='ville']").autocomplete({
            source: villes,
        });
        $("input[name='cp']").autocomplete({
            source: cp,
        });
    });

    $(function () {
        $("input[name='ville']").change(function () {
            var villes = <?php echo json_encode($LstVilles); ?>;
            var cp = <?php echo json_encode($LstCP); ?>;
            var a = $("input[name='ville']").val();
            indexVille = villes.indexOf(a);
            //alert(indexVille);
            var cpText = cp[indexVille];
            //alert(cpText);
            $("input[name='cp']").val(cpText);
        });
    });

    $(function () {
        $("input[name='cp']").change(function () {
            var villes = <?php echo json_encode($LstVilles); ?>;
            var cp = <?php echo json_encode($LstCP); ?>;
            var a = $("input[name='cp']").val();
            indexCp = cp.indexOf(a);
            //alert(indexVille);
            var villeText = villes[indexCp];
            //alert(cpText);
            $("input[name='ville']").val(villeText);
        });
    });

</script>
