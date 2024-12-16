<?php
foreach ($lesClasses as $uneClasse) {
    $pdf->AddPage();
    $posX = $pdf->getX();
    $posY = $pdf->getY();
    $pdf->SetXY($posX + 40, $posY);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(100, 20, utf8_decode('CLASSE : ' . $uneClasse['NOM']), 0, 'C');
    $pdf->Ln();

    $classeEnCours = $uneClasse['ID'];
    $elevesInscritaEvenement = $pdo->recupElevesInscritEvenement($evenements);
    foreach ($elevesInscritaEvenement as $unEleve) {
        $eleve = $unEleve['ID_ELEVE'];
        if ($unEleve['PHOTO'] == "" or $unEleve['PHOTO'] == NULL) {
            $photo = "AUCUNE.jpg";
        } else {
            $photo = $unEleve['PHOTO'];
        }
        $nomPrenom = $unEleve['NOM'] . ' ' . $unEleve['PRENOM'];

        $annee = date("Y");
        $mois = date("m");
        if ($mois < 7) {
            $annee = $annee - 1;
        }
        $classe = $pdo->recupClasseUnEleve($annee, $eleve);
        if ($classeEnCours == $classe['ID_CLASSE']) {
            $posX = $pdf->getX();
            $posY = $pdf->getY();
            $pdf->SetXY($posX, $posY);
            $pdf->Image('photosEleves/' . $photo, null, null, 25, 25, 'jpg');
            $pdf->SetFont('Arial', 'B', 8);

            $posX = $pdf->getX();
            $posY = $pdf->getY();
            $pdf->SetXY($posX + 25, $posY - 25);
            $pdf->MultiCell(100, 25, utf8_decode($nomPrenom), 1, 'L');


            //$pdf->Ln();
        }

    }

} ?>