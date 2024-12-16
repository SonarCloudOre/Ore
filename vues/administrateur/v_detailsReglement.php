<center><img src="./images/logo.png" id="logo" alt="Tres union" title="logo tres union"/>
    <h2>Détails Réglement</h2>
    <?php
    list($annee, $mois, $jour) = explode('-', $reglement['DATE_REGLEMENT']);
    $dateReg = $jour . "-" . $mois . "-" . $annee;

    echo '<br><br>ID : ' . $reglement['ID'];
    echo '<br>ELEVE : ' . $reglement['NOMELEVE'] . ' ' . $reglement['PRENOM'];
    echo '<br>TYPE DE REGLEMENT : ' . $reglement['NOMPARA'];
    echo '<br>MONTANT : ' . $reglement['MONTANT'];
    echo '<br>DATE : ' . $dateReg;

    if ($reglement['ID_TYPEREGLEMENT'] == 1) {
        echo '<br>CHEQUE N° : ' . $reglement['NUMTRANSACTION'];
        echo '<br>BANQUE : ' . $reglement['BANQUE'];
    }
    if ($reglement['ID_TYPEREGLEMENT'] == 3) {
        echo '<br>N° ALLOCATAIRE : ' . $reglement['N°_ALLOCATAIRE'];
        echo '<br>NOMBRE TEMPS LIBRES : ' . $reglement['NOMBRE_TPS_LIBRE'];
    }
    echo '<br>COMMENTAIRES : ' . $reglement['com'];

    ?>
</center>