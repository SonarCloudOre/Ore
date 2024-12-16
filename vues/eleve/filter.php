<?php
//filter.php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
if (isset($_POST["from_date"], $_POST["to_date"])) {

    $connect = mysqli_connect("mysql51-52.perso", "associatryagain", "E2x6q5Li", "associatryagain");
    $output = '';
    $count = '';
    $query = "SELECT *
  FROM
  (SELECT `ID_ELEVE`, `SEANCE`, 'SOUTIEN SCOLAIRE' as type
  FROM `quetigny_appel`
  WHERE ID_ELEVE = '" . $_POST["eleve"] . "'
  UNION
  SELECT `ID_ELEVE_ANCIENNE_TABLE`, `DATE_PRESENCE`, 'STAGE' as type
  FROM `PRÉSENCES_STAGE`
  LEFT OUTER JOIN INSCRIPTIONS_STAGE ON PRÉSENCES_STAGE.ID_INSCRIPTIONS = INSCRIPTIONS_STAGE.ID_INSCRIPTIONS
  LEFT OUTER JOIN ELEVE_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE
  WHERE ELEVE_STAGE.ID_ELEVE_ANCIENNE_TABLE = '" . $_POST["eleve"] . "') as A
  WHERE SEANCE BETWEEN '" . $_POST["to_date"] . "' AND '" . $_POST["from_date"] . "'
  ORDER BY `A`.`SEANCE` DESC;";
    $result = mysqli_query($connect, $query);
    $num_rows = mysqli_num_rows($result);

    $count = '
      <span>' . $num_rows . '</span>
      ';
    $output .= '
      <table class="mb-0 table table-hover">
          <thead>
              <tr>
                  <th>Date</th>
                  <th>Présences</th>
                  <th>Type</th>
              </tr>
          </thead>
          <tbody>
              <tr>
      ';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $output .= '

                          <tr><th scope="row">' . $row["SEANCE"] . '</th><td>Présent</td><td>' . $row['type'] . '</td></tr>
                ';
        }
    } else {
        $output .= '
           <tr><th scope="row">Aucune données trouvées</th></tr>
           ';
    }

    $output .= '</tr>
</tbody>
</table>';

    $data = array(
        'html' => $output,
        'nb' => $count,
    );
    echo json_encode($data);
}
?>
