<div class="erreur">
    <ul>
        <?php
        foreach ($_REQUEST['erreurs'] as $erreur) {
            echo '<div class="alert alert-danger" role="alert">' . $erreur . '</div>';
        }
        ?>
    </ul>
</div>