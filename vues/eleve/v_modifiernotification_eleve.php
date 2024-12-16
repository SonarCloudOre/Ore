<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Modifier notification
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Modifier une notification</h5>
                <form class=""
                      action="index.php?choixTraitement=eleve&action=valideModifierNotification&id=<?php echo $uneNotif['id']; ?>"
                      method="post" enctype="multipart/form-data">
                    <div class="">
                        <label for="Libelle">Libellé :</label>
                        <input class="form-control" type="text" name="Libelle"
                               value="<?php echo $uneNotif["libelle"]; ?>" style="max-width:200px;">
                        <label for="date_evenement">Date de l'évènement :</label>
                        <input class="form-control" type="date" name="date_evenement"
                               value="<?php echo $uneNotif["date_evenement"]; ?>" style="max-width:200px;">
                        <label for="Cible">Cible :</label>
                        <input class="form-control" type="text" name="Cible" value="<?php echo $uneNotif["cible"]; ?>"
                               style="max-width:200px;">
                        <select multiple="multiple" class="multiselect-dropdown form-control" name="Cible[]">
                            <?php
                            $cibles = $uneNotif["cible"];
                            $lacible = explode("/", $uneNotif["cible"]);
                            foreach ($lesUtilisateurs as $unUtilisateur) {
                                echo '<option value="' . $unUtilisateur['NOM'] . '">' . $unUtilisateur['NOM'] . '</option>';
                            } ?>
                        </select>
                        <label for="Auteur">Auteur :</label>
                        <input class="form-control" type="text" name="Auteur" value="<?php echo $uneNotif["auteur"]; ?>"
                               style="max-width:200px;" readonly>
                        <button type="submit" name="modifier" value="modifier" class="mt-1 btn btn-primary">Modifier
                        </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
/*$cibles = $uneNotif["cible"];
$lacible =explode("/",$uneNotif["cible"]);*/
/*$ct = count($lacible);
foreach ($lesUtilisateurs as $unUtilisateur) {

for ($i=0; $i < $ct; $i++) {
 if ($unUtilisateur['NOM'] == $lacible[$i]) {
   echo $unUtilisateur['NOM'].' => '.$lacible[$i].'<br>';
}
}
}*/

/*$Sible = [];
foreach ($lacible as $S) {
  $Sible = array($Sible, "cible" => $S);
}
var_dump($Sible);*/
?>

<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="./js/form-components/input-select.js"></script>
