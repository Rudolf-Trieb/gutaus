<?php 
    //SESSION
    session_start();
	header("Content-Type: text/html; charset=ISO-8859-1");
	include_once('include_0_db_conektion.php');
?>

<?php
    echo "<h2>Voll Deals (Wechselkurse zum ".$_SESSION['Einheit'].")</h2>";
    // Prüfen, ob das Formular gesendet wurde
    if(isset($_POST['submit']) AND $_POST['submit']=='Entscheidung Senden') {
   
    }
    else 
        // Formular anzeigen
        include('include_8_volle_deals_anzeigen.php');
?>