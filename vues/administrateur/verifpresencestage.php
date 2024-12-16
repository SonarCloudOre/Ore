<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

$connect = mysqli_connect("mysql51-52.perso", "associatryagain", "E2x6q5Li", "associatryagain");
$connect->set_charset("utf8mb4");
$stage = $_GET['stage'];
$matinouap = $_GET['matinouap'];
$id = $_GET['id_inscription_stage'];
$datepresence = $_GET['date_presence'];


$requete = "SELECT * FROM  PRÉSENCES_STAGE  INNER JOIN  INSCRIPTIONS_STAGE  ON  INSCRIPTIONS_STAGE . ID_INSCRIPTIONS  =  PRÉSENCES_STAGE . ID_INSCRIPTIONS  where  INSCRIPTIONS_STAGE . ID_STAGE  = $stage AND MATINOUAP =  $matinouap  AND   INSCRIPTIONS_STAGE .ID_INSCRIPTIONS= $id AND DATE_PRESENCE =  '$datepresence'  ORDER BY DATE_PRESENCE, MATINOUAP;";

$result = mysqli_query($connect, $requete) or die(mysqli_error($connect));
if (mysqli_num_rows($result) > 0) {
    echo "true";
} else {
    echo "false";
}

?>
