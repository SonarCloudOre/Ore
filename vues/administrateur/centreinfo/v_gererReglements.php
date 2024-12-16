


<!-- ------------------contenu de la page------------------- -->
<div class="contenu">
    <!-- page pour gérer les règlements des adhérents -->
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-cash icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Gérer les règlements des adhérents du centre informatique
                </div>
            </div>
            <!-- onglets -->
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>




    <!-- message de succès ou d'erreur -->
    <!-- php Session Erreur/Succes -->
    <?php
        if (isset($_SESSION['erreur'])) {
            $messageErreur = $_SESSION['erreur'];
            echo('<!-- div erreurs -->
                <div class="alert alert-danger" id="alertErreur">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Erreur !</strong> <span id="messageErreur">'. $messageErreur .'</span>
                </div>'
            );
        } else if (isset($_SESSION['succes'])) {
            $messageSucces = $_SESSION['succes'];
            echo('<!-- div succès -->
                <div class="alert alert-success" id="alertSucces">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Succès !</strong> <span id="messageSucces">'. $messageSucces .'</span>
                </div>'
            );
        }
        unset($_SESSION['erreur']);
        unset($_SESSION['succes']);
    ?>

    

    <!-- ajouter un règlement -->
    <div class="main-card mb-3 card" >
        <!-- div pour choisir l'onglet -->
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="consulter-reglement-tab" data-toggle="tab" href="#consulter-reglement" role="tab" aria-controls="consulter-reglement" aria-selected="true">Consulter un règlement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ajouter-reglement-tab" data-toggle="tab" href="#ajouter-reglement" role="tab" aria-controls="ajouter-reglement" aria-selected="false">Ajouter un règlement</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="tab-pane fade show active" id="consulter-reglement" role="tabpanel" aria-labelledby="consulter-reglement-tab">
                <!-- Contenu pour la section Consulter un règlement -->
                <h4 class="card-title">Consulter les règlements d'un utilisateur</h4>
                
                <div class="card-body">
                    <h5 class="card-title">Utilisateur</h5>
                    <!-- sélectionner un utilisateur pour consulter ses règlements -->
                    <div class="search-container" id="divSearch">
                        <input type="search" id="searchInput" placeholder="Entrez un utilisateur et cliquez sur le bouton de recherche" class="search-input" data-dropdown-id="dropdown" autocomplete="off">
                        <!-- bouton avec icone de loupe pour afficher les résultats de la recherche -->
                        <button type="button" id="searchButton" class="btn-search">
                            <i class="fa fa-search"></i>
                        </button>
                        <div id="dropdown" class="dropdown-content">
                            <!-- Les options seront générées par JavaScript -->
                        </div>
                        <input type="hidden" name="" id="user_id">
                    </div>
                </div>

                <!-- div pour afficher les règlements de l'utilisateur -->
                <div id="reglementsSection" style="display: none;" class="card-body">
                    <div id="titleConsult" class="title-container">
                        <h5 id="titleUser" class="card-title">Règlements de l'utilisateur :</h5>
                        <span id="nameUser"></span>
                    </div>

                    <div id="reglementsContent">
                        
                    </div>
                </div>

                <!-- div pour les autres actions -->
                <div id="autresActions" style="display: none;" class="card-body">
                    <h5 class="card-title">Autres Actions</h5>
                    <!-- button pour supprimer tous les règlements de l'utilisateur -->
                    <button type="button" id="deleteAllReglements" class="form-control btn btn-danger">Supprimer tous les règlements de l'utilisateur</button>
                </div>

               
                
                <!-- popup pour afficher les détails du règlement -->
                <div id="popupReglement" class="popup" style="display: none;">
                    <div class="popup-content">
                        <span class="close-popup" id="closePopupReglement">&times;</span>
                        <h4 class="card-title">Détails du règlement</h4>
                        <div id="reglementDetails">
                            <form action="./index.php?choixTraitement=administrateur&action=editReglement" method="post">
                                <!-- Les détails du règlement seront générés par JavaScript -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- id du règlement -->
                                        <input type="hidden" name="idReglementP" id="idReglementP">
                                        <!-- types de règlements -->
                                        <div class="form-group">
                                            <label for="typeReglementP" class="required labelCI">Type de règlement</label>
                                            <select name="typeReglementP" id="idTypeReglementP" class="form-control" required>
                                                <option value="" disabled>Choisir</option>
                                                <?php
                                                foreach ($typesReglement as $typeReglement) {
                                                    echo "<option value='" . $typeReglement['ID'] . "'>" . $typeReglement['NOM'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- banques -->
                                        <div class="form-group">
                                            <label for="banque" class="required labelCI">Banque</label>
                                            <select name="banqueP" id="idBanqueP" class="form-control" required>
                                                <option value="" disabled>Choisir</option>
                                                <?php
                                                foreach ($banques as $banque) {
                                                    echo "<option value='" . $banque['ID'] . "'>" . $banque['NOM'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- numéro de transaction -->
                                        <div class="form-group">
                                            <label for="numTransactionP" class="required labelCI">Numéro de transaction</label>
                                            <input type="number" name="numTransactionP" id="idNumTransactionP" class="form-control" placeholder="Ex : 12345678" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- date de règlement -->
                                        <div class="form-group">
                                            <label for="dateReglement" class="required labelCI">Date du règlement</label>
                                            <input type="date" name="dateReglementP" id="idDateReglementP" class="form-control" required>
                                        </div>
                                        <!-- montant -->
                                        <div class="form-group">
                                            <label for="montantP" class="required labelCI">Montant</label>
                                            <input type="number" name="montantP" id="idMontantP" class="form-control" placeholder="Montant" min="0.01" step="0.01" required>
                                        </div>
                                        <!-- commentaire -->
                                        <div class="form-group">
                                            <label for="commentaireP" class="required labelCI">Commentaire</label>
                                            <textarea name="commentaireP" id="idCommentaireP" class="form-control" placeholder="Écrivez une remarque (facultatif) Max : 300 caractères" maxlength="300"></textarea>
                                        </div>
                                    </div>
                                    <!-- submit -->
                                    <input type="submit" value="Modifier" id="idEditReglement" class="form-control btn btn-success mt-3">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- popup pour supprimer un règlement -->
                <div id="popupDeleteReglement" class="popup" style="display: none;">
                    <div class="popup-content">
                        <span class="close-popup" id="closePopupDeleteReglement">&times;</span>
                        <h4 class="card-title">Supprimer le règlement</h4>
                        <div id="deleteReglementContent">
                            <form action="./index.php?choixTraitement=administrateur&action=deleteReglement" method="post">
                                <!-- Les détails du règlement seront générés par JavaScript -->
                                <input type="hidden" name="idReglementD" id="idReglementD">
                                <p>Êtes-vous sûr de vouloir supprimer ce règlement ?</p>
                                <input type="submit" value="Supprimer" id="idDeleteReglement" class="form-control btn btn-danger mt-3">
                                <button type="button" id="cancelDeleteReglement" class="form-control btn btn-secondary mt-3">Annuler</button>
                            </form>
                        </div>
                    </div>
                </div>

      
                <!-- popup pour supprimer tous les règlements de l'utilisateur -->
                <div id="popupDeleteAllReglements" style="display: none;" class="popup">
                    <div class="popup-content">
                        <span class="close-popup" id="closePopupDeleteAllReglements">&times;</span>
                        <h4 class="card-title">Supprimer tous les règlements de l'utilisateur</h4>
                        <div id="deleteAllReglementContent">
                            <form action="./index.php?choixTraitement=administrateur&action=deleteAllReglements" method="post">
                                <input type="hidden" name="idUserD" id="idUserD">
                                <p>Êtes-vous sûr de vouloir supprimer tous les règlements de cet utilisateur ?</p>
                                <input type="submit" value="Supprimer" class="form-control btn btn-danger mt-3">
                                <button type="button" id="cancelDeleteAllReglements" class="form-control btn btn-secondary mt-3">Annuler</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

             

            <div class="tab-pane fade" id="ajouter-reglement" role="tabpanel" aria-labelledby="ajouter-reglement-tab">
                <!-- Contenu pour la section Ajouter un règlement -->
                <h4 class="card-title">Ajouter un règlement à un utilisateur</h4>
                <form action="./index.php?choixTraitement=administrateur&action=gererReglements" method="post" id="formReglement">
                    <div class="card-body">
                        <h5 class="card-title">Adhérence</h5>
                        <!-- case à cocher pour choisir si oui ou non l'utilisateur est adhérent au centre informatique ou non -->
                        <p>L'utilisateur est-il adhérent au centre informatique ?</p>
                        <div class="custom-radio custom-control custom-control-inline">
                            <input type="radio" id="adherent" name="adherence" class="custom-control-input" onclick="showAdherent()" value="oui">
                            <label class="custom-control-label" for="adherent">Oui</label>
                        </div>
                        <div class="custom-radio custom-control custom-control-inline">
                            <input type="radio" id="nonAdherent" name="adherence" class="custom-control-input" onclick="showNonAdherent()" value="non">
                            <label class="custom-control-label" for="nonAdherent">Non</label>
                        </div>

                        <div class="form-container">
                            <!-- div pour afficher les champs à remplir si l'utilisateur est adhérent -->
                            <div id="adherentDiv" class="form-section">
                                <!-- Colonne de gauche -->
                                <div class="form-section">
                                    <h5 class="card-title">Utilisateur Adhérent</h5>
                                    <div class="input-row">
                                        <label for="userCI2" class="labelCI custom-label">Utilisateur</label>
                                        <div class="search-container">
                                            <input type="search" name="userCI2" id="idUserCI2" placeholder="Entrez un utilisateur" class="search-input inputCI form-input custom-input large-input" autocomplete="off" disabled required>
                                            <div id="dropdown2" class="dropdown-content form-dropdown-content"></div>
                                            <!-- Les options seront générées par JavaScript -->
                                        </div>
                                        <input type="hidden" name="userCI_id2" id="userCI_id2">
                                    </div>
                                </div>
                                <div class="input-row">
                                    <!-- <label for="userCI" class="labelCI custom-label">Nom de l'utilisateur</label> -->
                                    <input type="hidden" name="userCI" id="idUserCI" list="listeUserCI" placeholder="Taper le nom ou le prénom de l'utilisateur" class="inputCI form-input custom-input" disabled>
                                    <datalist id="listeUserCI">
                                    <?php
                                        foreach ($utilisateursCentreInfo as $userCI) {
                                            echo "<option data-id='". $userCI['ID_UTILISATEUR'] ."' value='". $userCI['NOM'] ." ". $userCI['PRENOM'] ."'>". $userCI['NOM'] ." ". $userCI['PRENOM'] ."</option>";
                                        }
                                    ?>
                                    </datalist>
                                    <input type="hidden" name="userCI_id" id="userCI_id">
                                </div>
                            </div>

                            <div class="separator"></div> <!-- barre de séparation -->
                            
                            <div class="form-section">
                                <!-- colonne de droite -->
                                <!-- div pour afficher les champs à remplir si l'utilisateur n'est pas adhérent -->
                                <div id="nonAdherentDiv" class="form-section">
                                    <h5 class="card-title">Utilisateur Non Adhérent</h5>
                                    <div class="input-row">
                                        <label for="nomUser" class="labelCI custom-label">Nom</label>
                                        <input type="text" name="nomUser" id="idNomUser" maxlength="30" placeholder="Nom (max : 30 caractères)" class=" inputCI form-text custom-input" disabled>
                                    </div>
                                    <div class="input-row">
                                        <label for="prenomUser" class="labelCI custom-label">Prénom</label>
                                        <input type="text" name="prenomUser" id="idPrenomUser" maxlength="30" placeholder="Prénom (max : 30 caractères)" class="inputCI form-text custom-input" disabled>
                                    </div>
                                    <div class="input-row">
                                        <label for="emailUser" class="labelCI custom-label">Email</label>
                                        <input type="email" name="emailUser" id="idEmailUser" maxlength="30" placeholder="xyz@example.com" class="inputCI form-text custom-input form-control" disabled>
                                    </div>
                                    <div class="input-row">
                                        <label for="telUser" class="labelCI custom-label">Téléphone Portable</label>
                                        <input type="tel" name="telUser" id="idTelUser" maxlength="10" placeholder="Ex : 0102030405" class="inputCI form-text custom-input form-control" disabled>
                                    </div>
                                    <div class="input-row">
                                        <label for="adresseUser" class="labelCI custom-label">Adresse</label>
                                        <input type="text" name="adresseUser" id="idAdresseUser" placeholder="Taper votre adresse" class="inputCI form-text custom-input" disabled>
                                    </div>
                                    <div class="input-row">
                                        <label for="codePostalUser" class="labelCI custom-label">Code Postal</label>
                                        <input type="text" name="codePostalUser" id="idCodePostalUser" maxlength="5" placeholder="Ex : 75000" class="inputCI form-text custom-input" disabled>
                                    </div>
                                    <div class="input-row">
                                        <label for="villeUser" class="labelCI custom-label">Ville</label>
                                        <input type="text" name="villeUser" id="idVilleUser" placeholder="Taper votre ville de résidence" class="inputCI form-text custom-input" disabled>
                                    </div>
                                    <div class="input-row">
                                        <label for="dateNaissanceUser" class="labelCI custom-label">Date de Naissance</label>
                                        <input type="date" name="dateNaissanceUser" id="idDateNaissanceUser" placeholder="Format : JJ/MM/AAAA" class="inputCI custom-input form-text form-control" disabled>
                                    </div>
                                    <div class="input-row">
                                        <label for="lieuNaissanceUser" class="labelCI custom-label">Lieu de Naissance</label>
                                        <input type="text" name="lieuNaissanceUser" id="idLieuNaissanceUser" placeholder="Taper votre lieu de naissance" class="inputCI form-text custom-input" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                            

                        <div class="card-body">
                            <h5 class="card-title">Infos Règlement</h5>
                            <div class="form-group">
                                <!-- type de règlement -->
                                <label for="typeReglement" class="labelCI required">Type de règlement</label>
                                <select name="typeReglement" id="idTypeReglement" class="custom-select custom-control custom-control-inline custom-input mid-width" required>
                                    <option value="" disabled selected>Choisir</option>
                                    <?php
                                        foreach ($typesReglement as $typeReglement) {
                                            echo "<option value='". $typeReglement['ID'] ."'>". $typeReglement['NOM'] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <!-- div pour sélectionner la banque -->
                            <div class="form-group">
                                <label for="banque" class="labelCI required">Banque</label>
                                <select name="banque" id="idBanque" class="custom-select custom-control custom-control-inline custom-input mid-width" required>
                                    <option disabled selected>Choisir</option>
                                    <?php
                                        foreach ($banques as $banque) {
                                            echo "<option value='". $banque['ID'] ."'>". $banque['NOM'] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="numTransaction" class="labelCI required">Numéro de transaction</label>
                                <input type="number" name="numTransaction" id="idNumTransaction" class="custom-input-number form-control mid-width" placeholder="Ex : 12345678" required>
                            </div>
                            <div class="form-group">
                                <label for="dateReglement" class="labelCI required">Date du règlement</label>
                                <input type="date" name="dateReglement" id="idDateReglement" class="form-control mid-width" required>
                            </div>
                            <div class="form-group">
                                <label for="commentaire">Commentaire</label>
                                <textarea name="commentaire" id="idCommentaire mid-width" class="form-control" placeholder="Écrivez une remarque (facultatif) Max : 300 caractères" maxlength="300"></textarea>
                            </div>
                        </div>

                        <!-- div pour sélectionner si le règlement concerne une adhésion ou non -->
                        <div class="card-body">
                            <h5 class="card-title">Adhésion</h5>
                            <div class='custom-checkbox custom-control custom-control-inline'>
                                <input type="checkbox" name="adhesion" id="idAdhesion" class="custom-control-input">
                                <label class='custom-control-label' for="idAdhesion">Le règlement concerne-t-il une adhésion ?</label>
                            </div>
                        </div>


                        <!-- div pour sélectionner l'activité concerné -->
                        <!-- div pour sélectionner les consommables en lien avec l'activité choisie -->

                        <div class="card-body" id="idFabLab">
                            <!-- ACTIVITES -->
                            <h5 class="card-title">Activités</h5>
                            <label for="activite" class="labelCI required">Activité concernée</label>
                            <div class="form-group">
                                <select name="activite" id="idActivite" class="custom-select custom-control custom-control-inline custom-input mid-width" required>
                                    <option disabled selected>Choisir</option>
                                    <?php
                                        foreach ($activitesCentreInfo as $activiteCI) {
                                            echo "<option value='". $activiteCI['ID_ACTIVITE'] ."'>". $activiteCI['NOM'] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>


                            <br>
                            <br>
                            <!-- CONSOMMABLES  -->
                            <h5 class="card-title">Consommables</h5>
                            <label for="idConsommable" class="labelCI required">Consommable(s) concerné(s)</label>
                            <div id="idConsommable" class='custom-checkbox custom-control'>

                            </div>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">
                            <label for="prixTotal" class="labelCI">
                                    <h4 class="card-title">
                                    Prix Total
                                    </h4>
                                </label>
                            <input type="number" name="prixTotal" id="idPrixTotal" value="0.00" step="0.01" class="custom-input" disabled> €</h5>
                            <!-- <input type="number" name="montant" id="idMontant" hidden> -->
                        </div>

                        <div class="card-body">
                            <input type="submit" value="Ajouter le règlement" id="idSubmitReglement" class="form-control btn btn-success mt-3">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Injecter le JSON encodé dans un script
const utilisateurs = <?php echo json_encode($utilisateursCentreInfo); ?>;
</script>

<?php
exit;
?>