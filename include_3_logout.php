<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
	include('funktionen.php');
?>

<?php
// Funktionen++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
   // loggt einen User aus, .. 
    function doLogout() 
    { 
         //echo "UserID:".$_SESSION['UserID'];
         // .. die Session ID aus der Datenbank gelöscht werden 
         $sql = "UPDATE 
                           mitglieder 
                 SET 
                           SessionID = NULL, 
                           Autologin = NULL, 
                           IP = NULL 

                 WHERE 
                           ID = '".$_SESSION['UserID']."' 
                "; 
         mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
    } 
// ENDE Funktionen++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    // User ausloggen 
    doLogout(); 
    // $_SESSION leeren 
    $_SESSION = array();
    session_unset(); 
    // Session löschen 
    session_destroy();
    //echo "<h1>Sie haben sich erfolgreich ausgeloggt.</h1>";
    //echo "<h2>Horus777 w&uuml;nscht Ihnen einen sch&ouml;nen Tag!</h2>";
	echo "Sie haben sich erfolgreich ausgeloggt !!!";
    Weiterleitung("index.php",0); 	
?>