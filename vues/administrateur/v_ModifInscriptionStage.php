<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Modifier une inscription
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

    <form name="frmConsultFrais" enctype="multipart/form-data" method="POST"
          action="index.php?choixTraitement=administrateur&action=ValidationModifInscriptionStage">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">

                        <div class="form-group">

                            <h4 class="card-title">Stage</h4>
                            <label>Numéro d'inscription</label>
                            <input class="form-control" name="id_inscription"
                                   value="<?php echo $lInscription['ID_INSCRIPTIONS']; ?>" readonly="readonly"><br>

                            <label>Numéro d'élève</label>
                            <input class="form-control" name="id_eleve"
                                   value="<?php echo $lInscription['ID_ELEVE_STAGE']; ?>" readonly="readonly"><br>

                            <label>Importation depuis l'extranet</label>
                            <select class="form-control" name="id_eleve_ancienne_table">
                                <option
                                    value=""<?php if ($lInscription['ID_ELEVE_ANCIENNE_TABLE'] == '') echo ' selected="selected"'; ?>>
                                    Vide
                                </option>
                                <?php
                                foreach ($lesEleves as $unEleve) {
                                    echo '<option value="' . $unEleve['ID_ELEVE'] . '"';
                                    if ($unEleve['ID_ELEVE'] == $lInscription['ID_ELEVE_ANCIENNE_TABLE']) echo ' selected="selected"';
                                    echo '>' . stripslashes($unEleve['NOM']) . ' ' . stripslashes($unEleve['PRENOM']) . '</option>';
                                }
                                ?>
                            </select><br>


                            <label>Stage</label>
                            <select class="form-control" name="stage">
                                <?php
                                foreach ($lesStages as $unStage) {
                                    echo '<option value="' . $unStage['ID_STAGE'] . '"';
                                    if ($unStage['ID_STAGE'] == $lInscription['ID_STAGE']) echo ' selected="selected"';
                                    echo '>' . stripslashes($unStage['NOM_STAGE']) . '</option>';
                                }
                                ?>
                            </select><br>

                            <label>Atelier </label>
                            <select class="form-control" name="atelier">
                                <option
                                    value="0"<?php if ($unAtelier['ID_ATELIERS'] == '0') echo ' selected="selected"'; ?>>
                                    Vide
                                </option>
                                <?php
                                $niveau = array('collégiens', 'lycéens');
                                foreach ($lesAteliers as $unAtelier) {
                                    echo '<option value="' . $unAtelier['ID_ATELIERS'] . '"';
                                    if ($unAtelier['ID_ATELIERS'] == $lInscription['ID_ATELIERS']) echo ' selected="selected"';
                                    echo '>' . stripslashes($unAtelier['NOM_ATELIERS']) . ' (pour ' . $niveau[$unAtelier['NIVEAU_ATELIER']] . ')</option>';
                                }
                                ?>
                            </select><br>

                            <label>Groupe</label>
                            <select class="form-control" name="groupe">
                                <option
                                    value="0"<?php if ($unAtelier['ID_GROUPE'] == '0') echo ' selected="selected"'; ?>>
                                    Vide
                                </option>
                                <?php
                                foreach ($lesGroupes as $unGroupe) {
                                    echo '<option value="' . $unGroupe['ID_GROUPE'] . '"';
                                    if ($unGroupe['ID_GROUPE'] == $lInscription['ID_GROUPE']) echo ' selected="selected"';
                                    echo '>' . stripslashes($unGroupe['NOM_GROUPE']) . '</option>';
                                }
                                ?>
                            </select><br>

                            <label>Date d'inscription</label>
                            <input class="form-control" name="num"
                                   value="<?php echo $lInscription['DATE_INSCRIPTIONS']; ?>"><br>

                            <label>Commentaire</label>
                            <textarea class="form-control"
                                      name="commentaire"><?php echo $lInscription['COMMENTAIRE_INSCRIPTIONS']; ?></textarea><br>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">L'élève</h4>
                        </br>

                        <label for="nom">Nom</label>
                        <input class="form-control" name="nom"
                               value="<?php echo $lInscription['NOM_ELEVE_STAGE']; ?>"><br>

                        <label for="prenom">Prénom</label>
                        <input class="form-control" name="prenom"
                               value="<?php echo $lInscription['PRENOM_ELEVE_STAGE']; ?>"><br>
                        <label for="sexe">Sexe</label>
                        <select class="form-control" name="classe">
                            <option
                                value=""<?php if ($lInscription['SEXE_ELEVE_STAGE'] == '') echo ' selected="selected"'; ?>>
                                Vide
                            </option>
                            <option
                                value="H"<?php if ($lInscription['SEXE_ELEVE_STAGE'] == 'H') echo ' selected="selected"'; ?>>
                                H
                            </option>
                            <option
                                value="F"<?php if ($lInscription['SEXE_ELEVE_STAGE'] == 'F') echo ' selected="selected"'; ?>>
                                F
                            </option>
                        </select><br>

                        <label for="etab">Etablissement</label>
                        <select class="form-control" name="etablissement">
                            <option
                                value="0"<?php if ($lInscription['ETABLISSEMENT_ELEVE_STAGE'] == '') echo ' selected="selected"'; ?>>
                                Vide
                            </option>
                            <?php
                            foreach ($lesEtablissements as $unEtab) {
                                echo '<option value="' . $unEtab['ID'] . '"';
                                if ($unEtab['ID'] == $lInscription['ETABLISSEMENT_ELEVE_STAGE']) echo ' selected="selected"';
                                echo '>' . stripslashes($unEtab['NOM']) . '</option>';
                            }
                            ?>
                        </select><br>

                        <label for="num">Classe</label>
                        <select class="form-control" name="classe">
                            <option
                                value="0"<?php if ($lInscription['CLASSE_ELEVE_STAGE'] == '') echo ' selected="selected"'; ?>>
                                Vide
                            </option>
                            <?php
                            foreach ($lesClasses as $unElement) {
                                echo '<option value="' . $unElement['ID'] . '"';
                                if ($unElement['ID'] == $lInscription['CLASSE_ELEVE_STAGE']) echo ' selected="selected"';
                                echo '>' . stripslashes($unElement['NOM']) . '</option>';
                            }
                            ?>
                        </select><br>

                        <label>Filière</label>
                        <select class="form-control" name="filiere">
                            <option
                                value="0"<?php if ($lInscription['FILIERE_ELEVE_STAGE'] == '') echo ' selected="selected"'; ?>>
                                Vide
                            </option>
                            <?php
                            foreach ($lesFilieres as $unElement) {
                                echo '<option value="' . $unElement['ID'] . '"';
                                if ($unElement['ID'] == $lInscription['FILIERE_ELEVE_STAGE']) echo ' selected="selected"';
                                echo '>' . stripslashes($unElement['NOM']) . '</option>';
                            }
                            ?>
                        </select><br>

                        <label for="association">Association</label>
                        <input class="form-control" name="association"
                               value="<?php echo $lInscription['ASSOCIATION_ELEVE_STAGE']; ?>"><br>


                        <label>Tél de l'enfant</label>
                        <input class="form-control" name="tel_enfant"
                               value="<?php echo $lInscription['TELEPHONE_ELEVE_ELEVE_STAGE']; ?>"><br>


                        <label>Email de l'enfant</label>
                        <input class="form-control" name="email_enfant"
                               value="<?php echo $lInscription['EMAIL_ENFANT_ELEVE_STAGE']; ?>"><br>
                        <?php
                        if ($eleveSelectionner['PHOTO'] == "") {
                            $photo = "AUCUNE.jpg";
                        } else {
                            $photo = $eleveSelectionner['PHOTO'];
                        }
                        echo '<center><img width="200" style="box-shadow: 1px 1px 20px #555;image-orientation: 0deg;"  src="photosEleves/' . $photo . '" ></center>';

                        ?>
                        <label>Photo</label>
                        <input type="file" name="fichier"/><br>

                        <label>Date de naissance</label>
                        <input type="date" class="form-control" name="ddn"
                               value="<?php echo $lInscription['DDN_ELEVE_STAGE']; ?>"><br>


                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h3 class="card-title">Les parents</h3>

                        <label for="tel_parents">Tél des parents</label>
                        <input class="form-control" name="tel_parents"
                               value="<?php echo $lInscription['TELEPHONE_PARENTS_ELEVE_STAGE']; ?>"><br>

                        <label>Email des parents</label>
                        <input class="form-control" name="email_parents"
                               value="<?php echo $lInscription['EMAIL_PARENTS_ELEVE_STAGE']; ?>"><br>

                        <label>Adresse</label>
                        <input class="form-control" name="adresse"
                               value="<?php echo $lInscription['ADRESSE_ELEVE_STAGE']; ?>"><br>

                        <label>Code postal</label>
                        <input class="form-control" name="cp"
                               value="<?php echo $lInscription['CP_ELEVE_STAGE']; ?>"><br>

                        <label>Ville</label>
                        <input class="form-control" name="ville"
                               value="<?php echo $lInscription['VILLE_ELEVE_STAGE']; ?>"><br>


                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Documents</h4>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Réglement</h4>

                        <label for="paiement">Paiement</label>
                        <input class="form-control" name="paiement"
                               value="<?php echo $lInscription['PAIEMENT_INSCRIPTIONS']; ?>"><br>

                        <label for="num_transaction">N° de transaction</label>
                        <input class="form-control" name="num_transaction"
                               value="<?php echo $lInscription['NUMTRANSACTION']; ?>"><br>

                        <label for="banque">Banque</label>
                        <input class="form-control" name="banque"
                               value="<?php echo $lInscription['BANQUE_INSCRIPTIONS']; ?>"><br>

                        <label for="montant">Montant</label>
                        <input class="form-control" type="number" name="montant"
                               value="<?php echo $lInscription['MONTANT_INSCRIPTIONS']; ?>"><br>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Données techniques</h4>

                        <label for="useragent">User Agent</label>
                        <input class="form-control" name="useragent"
                               value="<?php echo $lInscription['USER_AGENT_INSCRIPTIONS']; ?>"><br>

                        <label for="ip">Adresse IP</label>
                        <input class="form-control" name="ip"
                               value="<?php echo $lInscription['IP_INSCRIPTIONS']; ?>"><br>

                        <label for="origine">Origine</label>
                        <input class="form-control" name="origine"
                               value="<?php echo $lInscription['ORIGINE_INSCRIPTIONS']; ?>"><br>

                        <br><input value="Modifier" type="submit" class="btn btn-success">
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
