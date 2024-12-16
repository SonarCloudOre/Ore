<?php
if (isset($taille)) {
    header("Content-length: $taille");
}

if (isset($type)) {
    header("Content-type: $type");
}

if (isset($nom)) {
    header("Content-Disposition: attachment; filename=$nom");
}

ob_clean();
flush();
echo $fichier;
exit;
?>