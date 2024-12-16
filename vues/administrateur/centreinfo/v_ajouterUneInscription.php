<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Nouvelle inscription
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <form method="POST" enctype="multipart/form-data"
          action="index.php?choixTraitement=administrateur&action=info_ajouterUneInscriptionValidation">


        <div class="row">
            <div class="col-lg-6">
                <div class="main-card mb-3 card">
                    <div class="card-body">

                        <h4 class="card-title">Informations générales</h4>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="ddn">Date d'inscription</label>
                                    <input class="form-control" name="date"
                                           value="<?php echo date('Y-m-d H:i:s', time()); ?>" readonly="readonly">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="num">Nom</label>
                                    <input class="form-control" name="nom" value="">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="num">Prénom</label>
                                    <input class="form-control" name="prenom" value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="num">Année</label>
                                    <input class="form-control" name="annee" value="<?php echo $anneeEnCours; ?>"
                                           type="number">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="ddn">Date de naissance</label>
                                    <input class="form-control" type="date" name="ddn" value="">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="sexe">Sexe</label>
                                    <select name="sexe" class="form-control">
                                        <option value="F">Femme</option>
                                        <option value="H">Homme</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="main-card mb-3 card">
                    <div class="card-body">


                        <h4 class="card-title">Adresse postale</h4>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="adresse">adresse</label>
                                    <input class="form-control" id="adresse" name="adresse" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative form-group">
                                    <label for="cp">Code postal</label>
                                    <input class="form-control"  type="text" name="cp" >
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="position-relative form-group">
                                    <label for="ville">Ville</label>
                                    <input class="form-control"  type="text" name="ville" >
                                </div>
                            </div>
                        </div> <?php //formulaireAdresse('', '', ''); ?>


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="main-card mb-3 card">
                    <div class="card-body">


                        <h4 class="card-title">Coordonnées</h4>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="tel1">Téléphone 1</label>
                                    <input class="form-control" type="text" name="tel1" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="tel2">Téléphone 2</label>
                                    <input class="form-control" type="text" name="tel2" value="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="position-relative form-group">
                                    <label for="tel1">E-mail</label>
                                    <input class="form-control" name="email" value="">
                                    <br>
                                    <input value="Inscrire" type="submit" class="btn btn-success">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </form>
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