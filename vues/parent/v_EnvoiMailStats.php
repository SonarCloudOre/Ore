<?php
//envoi d'un mail au parent
$headers = "From: \"Association ORE\n";
$headers .= "Reply-To: association.ore@gmail.com\n";
$headers .= "X-Priority: 5\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

$subject = '';

$message = '<p><center><img src="https://association-ore.fr/extranet/images/logo.png"></center></p>
			  <h2>Intervenants disponibles</h2>
			 <p>
			 
			</p>



			 <p>_____________________________________________________<br>
			 <b> Association ORE</b><br>
Adresse : 2A Bd Olivier de Serres - 21800 Quetigny (Maison des associations)<br>
Tél : 03 80 48 23 96<br>
Mail : association.ore@gmail.com<br>
Web : <a href="http://www.association-ore.fr">www.association-ore.fr</a><br>
Facebook : <a href="https://www.facebook.com/AssociationORE/">https://www.facebook.com/AssociationORE/ </a>
</p>';

$result = mail($mail, $subject, $message, $headers);
?>