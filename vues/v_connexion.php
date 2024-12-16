<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Extranet // ORE</title>
    <link rel="stylesheet" href="vues/connexion.css">

</head>
<body>
<!-- partial:index.partial.html -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="body">
    <Center><img src="https://www.association-ore.fr/fr/img/logo_ore.png" width="150px" height="150px"></center>
    <div class="veen">
        <div class="login-btn splits">
            <p>Vous êtes un.e intervenant.e?</p>
            <button class="active">cliquer ici</button>
        </div>
        <div class="rgstr-btn splits">
            <p>Vous êtes un.e élève?</p>
            <button>cliquer ici</button>
        </div>
        <div class="wrapper">
            <form name="frmIdentification" method="POST"
                  action="index.php?choixTraitement=connexion&action=valideConnexion" id="login" tabindex="500">
                <h3>Espace intervenant</h3>
                <div class="mail">
                    <input name="login" type="mail" name="">
                    <label>Email</label>
                </div>
                <div class="passwd">
                    <input name="mdp" type="password" name="">
                    <label>Mot de passe</label>
                </div>
                <div class="submit">
                    <button class="dark">Se connecter</button>
                </div>
            </form>
            <form name="frmIdentificationEl" method="POST"
                  action="index.php?choixTraitement=connexion&action=valideConnexionEleve" id="register" tabindex="502">
                <h3>Espace élève</h3>
                <div class="mail">
                    <input name="loginEL" type="text" name="">
                    <label>Identifiant</label>
                </div>
                <div class="passwd">
                    <input name="mdpEL" type="password" name="">
                    <label>Mot de passe</label>
                </div>
                <div class="submit">
                    <button class="dark">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="site-link">
    <a href="https://www.association-ore.fr/fr/" target="_blank">
        Retour vers le site de ORE
        <img src="https://www.association-ore.fr/fr/img/logo_ore.png"></a>
</div>

<!-- partial -->
<script src="vues/connexion.js"></script>

</body>
</html>
