<?php 
    //SESSION
    session_start();
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<?php
// Eintauscheinheit an Tauschpartner überweisen.
	$Tauschpartner_ID=ermittle_Nickname_ID($_SESSION['Tauschpartner']);
	$Ruecktauschbetrag=$_SESSION['Eintauschbetrag']*$_SESSION['Wechselkurs'];
	$Verwendungszweck_Eintausch=$_SESSION['Einheit']." gegen ".$_SESSION['Ruecktauscheinheit']." eingetauscht";
	schreibe_Buchungsatz($_SESSION['UserID'],$_SESSION['Nickname'],$_SESSION['Eintauschbetrag'],$_SESSION['Einheit'],$Verwendungszweck_Eintausch,$Tauschpartner_ID,$_SESSION['Tauschpartner'],"Eintausch");
// Erfolgsmeldung
    echo $_SESSION['Tauschpartner']." wurden ".$_SESSION['Eintauschbetrag']." ".$_SESSION['Einheit']." von Ihrem Konto überwiesen.";


// Rücktauscheinheit von Tauschpartner überweisen.
	$Verwendungszweck_Ruecktausch=$_SESSION['Ruecktauscheinheit']." gegen ".$_SESSION['Einheit']." eingetauscht";
	schreibe_Buchungsatz($Tauschpartner_ID,$_SESSION['Tauschpartner'],$Ruecktauschbetrag,$_SESSION['Ruecktauscheinheit'],$Verwendungszweck_Ruecktausch,$_SESSION['UserID'],$_SESSION['UserID'],"Umtausch");
	  
	  
// Erfolgsmeldung
	echo "<br><br>";
	echo "Sie haben hierfür im Eintausch von ".$_SESSION['Tauschpartner']." ".$Ruecktauschbetrag." ".$_SESSION['Ruecktauscheinheit']." erhalten.";
	
    include("include_5_kontoauszug.php");
?>

