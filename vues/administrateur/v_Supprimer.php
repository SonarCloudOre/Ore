<?php
// Vérifications
if (isset($_GET['type'])) {

    if (isset($_GET['id'])) {

        // Stage d'avril
        if ($action == 'avril') {

            $pdo->executerRequete2('');
            echo '<p>Suppression id ' . $_GET['id'] . '</p>';

        }

    }


} else {
    echo '<p>Erreur d\'adresse !</p>';
}
?>