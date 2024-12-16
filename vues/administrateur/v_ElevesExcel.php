<?php
include 'PHPExcel/PHPExcel.php';
$objPHPExcel = new PHPExcel;
$s = $objPHPExcel->getActiveSheet();
$s->setCellValue('A1', 'Hello');
$s->setCellValueByColumnAndRow(2, 1, 'World!');
$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// Option 2 : fichier à télécharger par le navigateur
header('Content-Disposition: attachment;filename="HelloWorld2.xlsx"');
$writer->save('php://output');


/*
function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "website_data_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  
  foreach($TousEleves as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  
  /*echo "\t" . $uneLigne['PRENOM'] . "\r\n";
	echo "\t" . $uneLigne['DATE_DE_NAISSANCE'] . "\r\n";
	echo "\t" . $uneLigne['TÉLÉPHONE_DES_PARENTS'] . "\r\n";
	echo "\t" . $uneLigne['EMAIL_DES_PARENTS'] . "\r\n";
	echo "\t" . $uneLigne['EMAIL_DE_L_ENFANT'] . "\r\n";
	echo "\t" . $uneLigne['ADRESSE_POSTALE'] . "\r\n";
	echo "\t" . $uneLigne['CODE_POSTAL'] . "\r\n";
	echo "\t" . $uneLigne['VILLE'] . "\r\n";
	echo "\t" . $classe['NOM'] . "\r\n";*/

/*echo "\tNom\r\n";
foreach($TousEleves as $uneLigne){ echo "\t" . $uneLigne['NOM'] . "\r\n"; }

  echo "\tPrénom\r\n";
foreach($TousEleves as $uneLigne){ echo "\t" . $uneLigne['PRENOM'] . "\r\n"; }




exit;*/

?>