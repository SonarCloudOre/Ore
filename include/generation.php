<?
$code128 = $_REQUEST['code'];	

include('codeBarreC128.class.php');

$code = new codeBarreC128($code128);
$code->setTitle();
$code->setFramedTitle(true);
$code->setHeight(50);
$code->Output();
?>