<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Contact - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
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
<div id="contenu">
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Contact</h5>
            <form id="signupForm" class="col-md-10 mx-auto" method="post" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">Nom</label>
                            <div>
                                <input type="text" class="form-control"
                                       id="firstname" value="<?php echo $intervenant["NOM"]; ?>" name="firstname"
                                       placeholder="Nom" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">Prénom</label>
                            <div>
                                <input type="text" class="form-control"
                                       id="lastname" value="<?php echo $intervenant["PRENOM"]; ?>" name="lastname"
                                       placeholder="Prénom" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div>
                        <input type="email" class="form-control"
                               id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="username">Sujet</label>
                    <div>
                        <input type="text" class="form-control"
                               id="username" name="username"
                               value="<?php if (isset($_GET['numsubject']) and $_GET['numsubject'] == 1) {
                                   echo 'Demande de modification d\'informations';
                               } ?>" placeholder="Sujet">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Message">Message</label>
                    <div>
                        <textarea name="content" id="editor"></textarea>

                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Envoyer le message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="./vendors/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="./js/form-components/form-validation.js"></script>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
