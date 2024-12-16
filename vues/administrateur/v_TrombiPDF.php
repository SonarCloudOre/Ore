<?php
foreach ($lesClasses as $uneClasse) {
    if ($uneClasse['ID'] == $classeSelectionner) {
        $pdf->AddPage();
        $posX = $pdf->getX();
        $posY = $pdf->getY();
        $pdf->SetXY($posX + 40, $posY);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(100, 20, utf8_decode('CLASSE : ' . $uneClasse['NOM']), 0, 'C');
        $pdf->Ln(3);

        $classeEnCours = $uneClasse['ID'];
        $lesEleves = $pdo->recupTousEleves();
        $total = 0;
        foreach ($lesEleves as $unEleve) {
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


                if ($total == 0) {
                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX, $posY);
                    $pdf->Image('photosEleves/' . $photo, null, null, 30, 30, 'jpg');
                    $pdf->SetFont('Arial', 'B', 8);
                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX, $posY);
                    $pdf->MultiCell(60, 10, utf8_decode($nomPrenom), 0, 'L');
                }
                if ($total == 1) {
                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX + 35, $posY - 40);
                    $pdf->Image('photosEleves/' . $photo, null, null, 30, 30, 'jpg');
                    $pdf->SetFont('Arial', 'B', 8);

                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX, $posY - 7);
                    $pdf->MultiCell(60, 25, utf8_decode($nomPrenom), 0, 'L');
                }
                if ($total == 2) {
                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX + 70, $posY - 48);
                    $pdf->Image('photosEleves/' . $photo, null, null, 30, 30, 'jpg');
                    $pdf->SetFont('Arial', 'B', 8);

                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX, $posY - 7);
                    $pdf->MultiCell(60, 25, utf8_decode($nomPrenom), 0, 'L');
                }
                if ($total == 3) {
                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX + 105, $posY - 48);
                    $pdf->Image('photosEleves/' . $photo, null, null, 30, 30, 'jpg');
                    $pdf->SetFont('Arial', 'B', 8);

                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX, $posY - 7);
                    $pdf->MultiCell(60, 25, utf8_decode($nomPrenom), 0, 'L');
                }
                if ($total == 4) {
                    $total = -1;
                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX + 140, $posY - 48);
                    $pdf->Image('photosEleves/' . $photo, null, null, 30, 30, 'jpg');
                    $pdf->SetFont('Arial', 'B', 8);

                    $posX = $pdf->getX();
                    $posY = $pdf->getY();
                    $pdf->SetXY($posX, $posY - 7);
                    $pdf->MultiCell(60, 25, utf8_decode($nomPrenom), 0, 'L');
                    $pdf->Ln(9);
                }

                $total++;

            }
        }
    }

} ?>