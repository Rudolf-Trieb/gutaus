<?php
    session_start(); 
	if (!headers_sent())
		header("Content-Type: text/html; charset=ISO-8859-1");
?>

<?php
	echo "			<h3>Die Aufladeschnittstelle ist leider noch nicht implementiert!</h3>";
	if ($_SESSION['Herausgeber']==$_SESSION['Nickname'])
		echo "			Hier sollte eine Liste aller Aufladungen (angekudigte und vollzogene=Kontoauszug [Aufladung]) erscheinen ";
	else
		echo "			Eine Aufladung ist aber schön möglich. Zum Aufladen Ihres ".$_SESSION['Einheit']."-Kontos wenden Sie sich bitte an 777horus@gmail.com ";
?>