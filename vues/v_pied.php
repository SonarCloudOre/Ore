<?php if (!@$footerNePasAfficher) { ?>
    </div>


    <!-- pied de page du theme -->
    <!-- Division pour le pied de page -->
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-right">
                    <button class="mb-2 mr-2 btn btn-warning" data-toggle="modal" data-target="#mentionlegal">mentions
                        légales
                    </button>
                    <button class="mb-2 mr-2 btn btn-focus" data-toggle="modal" data-target="#contact">contact</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </body>

    <!-- custome.js -->
    <script type="text/javascript" src="./js/script.js"></script>
    <script type="text/javascript" src="./js/demo.js"></script>
    <script type="text/javascript" src="./js/scrollbar.js"></script>
    <script type="text/javascript" src="./js/app.js"></script>
    <script type="text/javascript" src="./js/form-components/clipboard.js"></script>


    <div id="uploadimageModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 text-center">
                            <div id="image_demo" style="width:350px; margin-top:30px">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info crop_image">Sauvegarder</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Quitter</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contact" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contact</h5>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12 d-flex flex-column address-wrap">
                        <div class="single-contact-address d-flex flex-row">
                            <div class="icon">
                                <span class="lnr lnr-home" style="color : rgb(247,105,27);"></span>
                            </div>
                            <div class="contact-details" style="padding-left : 15px;">
                                <h4>Espace Francis-Moulun</h4>
                                <p style="color: #8e8e8e;">
                                    3 Allée des Jardins, 21800 Quetigny
                                </p>
                            </div>
                        </div>
                        <div class="single-contact-address d-flex flex-row">
                            <div class="icon">
                                <span class="lnr lnr-phone-handset" style="color : rgb(247,105,27);"></span>
                            </div>
                            <div class="contact-details" style="padding-left : 15px;">
                                <h4>03 80 48 23 96</h4>
                                <p style="color: #8e8e8e;">Du lundi au vendredi, de 10H à 12H et de 14H à 17H.</p>
                            </div>
                        </div>
                        <div class="single-contact-address d-flex flex-row">
                            <div class="icon">
                                <span class="lnr lnr-envelope" style="color : rgb(247,105,27);"></span>
                            </div>
                            <div class="contact-details" style="padding-left : 15px;">
                                <h4>association.ore@gmail.com</h4>
                                <p style="color: #8e8e8e;">Contactez nous !</p>
                            </div>
                        </div>
                    </div>
                </div>


                <form id="signupForm" class="col-md-10 mx-auto" method="post"
                      action="index.php?choixTraitement=administrateur&action=envoyerMail">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <div>
                                    <input type="text" class="form-control"
                                           id="nom" value="<?php echo $intervenant["NOM"]; ?>" name="nom"
                                           placeholder="Nom" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <div>
                                    <input type="text" class="form-control"
                                           id="prenom" value="<?php echo $intervenant["PRENOM"]; ?>" name="prenom"
                                           placeholder="Prénom" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div>
                            <input type="email" class="form-control"
                                   id="email" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sujet">Sujet</label>
                        <div>
                            <input type="text" class="form-control"
                                   id="sujet" name="sujet" placeholder="Sujet" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">Message</label>
                        <div>
                            <textarea name="content" id="oko" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="enoyermail" value="enoyermail">Envoyer le
                            message
                        </button>
                    </div>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                </div>


            </div>
        </div>
    </div>


    <div class="modal fade" id="mentionlegal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                </div>
                <div class="modal-body">
                    <div class="col-lg-12 d-flex flex-column address-wrap">

                        <h1>MENTIONS LEGALES :</h1>

                        <p style="text-align:justify"><strong> </strong><br/>
                            Conformément aux dispositions des articles 6-III et 19 de la Loi n° 2004-575 du 21 juin 2004
                            pour la Confiance dans l'économie numérique, dite L.C.E.N., nous portons à la connaissance
                            des utilisateurs et visiteurs du site : <a href="http://www.association-ore.fr"
                                                                       target="_blank">www.association-ore.fr</a> les
                            informations suivantes :</p>

                        <p style="text-align:justify"><strong>ÉDITEUR</strong></p>

                        <p style="text-align:justify">Le site <a href="http://www.association-ore.fr"
                                                                 style="color: rgb(7, 130, 193); font-family: sans-serif, Arial, Verdana, "
                                                                 target="_blank">www.association-ore.fr</a> est la
                            propriété exclusive de <strong>Association </strong><strong>Ouverture Rencontres
                                Evolution</strong>, qui l'édite.</p>

                        <p style="text-align:justify">Tél : <strong>03 80 48 23 96</strong></p>

                        <p style="text-align:justify"><strong>3 Allée des Jardins </strong><strong>21800
                                Quetigny</strong><br/>
                            Immatriculée au Registre du Commerce et des Sociétés de <strong> </strong>sous le
                            numéro<strong> </strong><strong>41883205100035</strong><strong> </strong></p>

                        <p style="text-align:left">
                            Adresse de courrier électronique : <strong>association.ore@gmail.com</strong> <br/>
                            <br/>
                            Directeur de la publication : <strong> Sabr YAZZOURH</strong><br/>
                            Contactez le responsable de la publication : <strong> association.ore@gmail.com</strong></p>

                        <p style="text-align:justify"></p>

                        <p style="text-align:justify"><strong>HÉBERGEMENT</strong></p>

                        <p style="text-align:justify">Le site est hébergé par <strong>OVH
                                https://www.ovh.com/fr/ </strong><br/>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modifpolycopie" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">


                </div>
                <div class="modal-body">
                    <div class="col-lg-12 d-flex flex-column address-wrap">
                        <h5 class="card-title">Ajouter une polycopie</h5>
                        <form class="" action="index.php?choixTraitement=eleve&action=ajoutPolycopies" method="post"
                              enctype="multipart/form-data">
                            <div class="">
                                <label for="Nom">Nom :</label>
                                <input class="form-control" type="text" name="Nom" value="<?php echo $id; ?>"
                                       style="max-width:200px;">
                                <label for="Commentaires">Commentaires :</label>
                                <input class="form-control" type="text" name="Commentaires" style="max-width:200px;">
                                <label for="Fichier">Fichier:</label>
                                <input class="form-control" type="file" name="Fichier" value=""
                                       accept=".jpg,.jpeg,.png,.gif,.pdf" style="max-width:200px;">
                                <label for="Date">Date de mise en ligne :</label>
                                <input class="form-control" type="date" name="Date" value="" style="max-width:200px;">
                                <label for="Classe">Classe :</label>
                                <select class="form-control" name="Classe" style="max-width:200px;">
                                    <option value="6ème">6ème</option>
                                    <option value="5ème">5ème</option>
                                    <option value="4ème">4ème</option>
                                    <option value="3ème">3ème</option>
                                    <option value="Seconde">2nd</option>
                                    <option value="Premiere">1ère</option>
                                    <option value="Terminale">Tle</option>
                                </select>
                                <label for="Photo">Photo :</label>
                                <input class="form-control" type="file" name="Photo" value="<?php echo $_POST['id']; ?>"
                                       style="max-width:200px;">
                                <label for="Type">Type :</label>
                                <select class="form-control" name="Type" style="max-width:200px;">
                                    <option value="Cours">Cours</option>
                                    <option value="Exercices">Exercices</option>
                                    <option value="Autres">Autres</option>
                                </select>
                                <label for="Categorie">Catégorie :</label>
                                <select class="form-control" name="Classe" style="max-width:200px;">
                                    <?php foreach ($lesCategoriesDocs as $uneCategorie) {
                                        echo '<option value="' . $uneCategorie["id"] . '">' . $uneCategorie["Matieres"] . '</option>';
                                    } ?>
                                </select>
                                <button type="submit" name="modifier" class="mt-1 btn btn-primary ">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                </div>
            </div>
        </div>
    </div>


    </html>
<?php } ?>


<script type="text/javascript" src="./vendors/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="./js/form-components/form-validation.js"></script>

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>

<script type="text/javascript">
    document.getElementById("E").onchange = function () {
        E()
    };

    function E() {
        var lstTelEleves = <?php echo json_encode($telephonesEleves); ?>;
        var y = document.getElementById("E").value;

        var ii;
        var str1 = "";
        for (ii = 0; ii < lstTelEleves.length; ii++) {
            if (classe1 = lstTelEleves[ii][1] == y) {
                classe1 = lstTelEleves[ii][0];
                str1 += classe1 + ",";
            }
            if (classe1 = "Tout" == y) {
                classe1 = lstTelEleves[ii][0];
                str1 += classe1 + ",";
            }
        }
        str1 = str1.substr(0, str1.length - 1);
        $('#Clipboard_Eleves').html(str1);
    }

</script>


<script type="text/javascript">
    document.getElementById("P").onchange = function () {
        P()
    };

    function P() {
        var lstTelParents = <?php echo json_encode($telephonesParents); ?>;
        var x = document.getElementById("P").value;

        var i;
        var str = "";
        for (i = 0; i < lstTelParents.length; i++) {
            if (classe = lstTelParents[i][1] == x) {
                classe = lstTelParents[i][0];
                str += classe + ",";

            }
            if (classe = "Tout" == x) {
                classe = lstTelParents[i][0];
                str += classe + ",";
            }
        }
        str = str.substr(0, str.length - 1);
        $('#Clipboard_Parents').html(str);
    }

</script>
