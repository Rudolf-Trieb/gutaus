<?php
    //SESSION
    session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<?php

// FORMDATEN an PHP ÜBERGEBEN

parse_str($_POST['formdata'],$Formulardaten);
//echo $_POST['formdata']."<br>";

$_SESSION['Handynummer_Empfaenger']='';
$_SESSION['Email_Empfaenger']='';

// Kontrolle der eingegebenen Daten
include('include_6_bezahlen_kontrolle.php');

// Prüft, ob Fehler aufgetreten sind
if(count($errors)){
	 echo "<font color='red'>";
	 echo "<b>FEHLER: Ihre &Uuml;berweisung kann nicht ausgef&uuml;hrt werden</b><br>\n".
		  "<br>\n";
	 $i=1;     
	 foreach($errors as $error) {
		 echo $i.".) ".$error."<br><br>\n";
		 $i+=1;
	 }
		 
	 echo "</font>";
	 // ... nochmalige Anzeige des Formulars
	 include('include_6_bezahlen_an_formular.php');
}
// wenn keine Fehler Bestätigunsformular anzeigen	
else {
	include('include_6_bezahlen_bestaetigungsfrage_formular.php');
}
		   
?>