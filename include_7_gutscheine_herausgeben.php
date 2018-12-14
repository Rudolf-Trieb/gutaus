<?php 
    //SESSION
    session_start();
	header("Content-Type: text/html; charset=ISO-8859-1");
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<?php

// FORMDATEN an PHP ÜBERGEBEN

	parse_str($_POST['formdata'],$Formulardaten);

 //GuTauS-Konto eröffnen 
	// Kontrolle der eingegebenen Daten
	include('include_7_gutscheine_herausgeben_kontrolle.php');

	// Prüft, ob Fehler aufgetreten sind
	if(count($errors)){ // Fehler sind aufgetreten
		 echo "<font color='red'>";
		 echo "<b>FEHLER: Ihr Gutscheine-Konto konnte nicht eröffnen werden</b><br>\n".
			  "<br>\n";
		 $i=1;
		 foreach($errors as $error) {
			 echo $i.".) ".$error."<br>\n";
			 $i+=1;
		 }

		 echo "</font>";
		 
		 // Anzeige des Formulars
		 if($_SESSION['euro_Gutschein']==1)
			include ("include_7_gutscheine_herausgeben_formular_euro.php");
		 else
			include ("include_7_gutscheine_herausgeben_formular.php");
	}
	else { // Es ist kein Fehler aufgetreten ==> Einheit und Konto anlegen
	     if($_SESSION['euro_Gutschein']==1) {
			 $Gutschein_Art="Euro";
			 $Nachkommastellen=2;
		 }
		 else {
			 $Gutschein_Art="?";
			 $Nachkommastellen=0;
		 }
		 $_SESSION['ID_Einheit']=lege_an_einheit ($_SESSION['UserID'],$_SESSION['Gutscheinname'],$Gutschein_Art,$Nachkommastellen,$_SESSION['Definition'],$_SESSION['max_Akzeptanz'],0,$_SESSION['privat_Gutschein']);
		 eroeffne_konto ($_SESSION['UserID'],$_SESSION['max_Ueberziehung'],$_SESSION['Gutscheinname'],0);            
	}
?>