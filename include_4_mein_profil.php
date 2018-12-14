<?php 

	header("Content-Type: text/html; charset=ISO-8859-1");

    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
	include('funktionen.php');
?>

<?php

echo "<h2>Mein Profil</h2>";

// NICHTEINGELOGT++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    if(!isset($_SESSION['UserID'])) { 
         echo "Sie sind nicht eingeloggt.<br>\n". 
              "Bitte <a href=\"include_3_login.php\">loggen</a> Sie sich zuerst ein.\n"; 
    } 
// EINGELOGGT +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   
    else{  
        if(isset($_POST['submit']) AND $_POST['submit'] == "Avatar hochladen") { 
// Avatar hochladen
            include('include_41_mein_profil_avatar_hochladen.php');
        }
// Avatar löschen        
        elseif(isset($_POST['submit']) AND $_POST['submit'] == 'Avatar löschen'){
            include('include_41_mein_profil_avatar_loeschen.php');
    }
// Passwort ändern 
        elseif(isset($_POST['submit']) AND $_POST['submit'] == 'Passwort ändern') { 
            include('include_41_mein_profil_passwort_aendern.php');
        } 
// Daten ändern
        elseif(isset($_POST['submit']) AND $_POST['submit']=='Daten ändern'){
            include('include_41_mein_profil_daten_aendern.php');
        } 
        else {
// Mein Profil Anzeigen    
            include('include_41_mein_profil_anzeigen.php');    
        } 
    }
?>