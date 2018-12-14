<?php
    session_start(); 
	if (!headers_sent())
		header("Content-Type: text/html; charset=ISO-8859-1");
?>

<?php
	echo "			<h3>Die Auszahlungsschnittstelle ist leider noch nicht implementiert!</h3>";
	if ($_SESSION['Herausgeber']==$_SESSION['Nickname'])
		echo "			Hier sollte eine Liste aller Auszahlungen (angeforderte und vollzogene=Kontoauszug [Auszahlung] erscheinen";
	else
		echo "					Ihre ".$_SESSION['Einheit']." Auszahlung ist aber schön möglich. Für Ihre ".$_SESSION['Einheit']." Auszahlung wenden Sie sich bitte an 777horus@gmail.com ";
?>	