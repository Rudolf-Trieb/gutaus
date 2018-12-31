<?php
   //SESSION
    session_start();
	include_once('../includes/include_0_db_conection.php');
		
    doLogout(); 
    // $_SESSION leeren 
    $_SESSION = array();
    session_unset(); 
    // Session löschen 
    session_destroy();	

	echo true; // informs javascript of logout success
	
	
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
                           Autologin = NULL
                 WHERE
                           ID = '".mysql_real_escape_string(trim($_SESSION['user_id']))."' 
                "; 
         mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
    } 
// ENDE Funktionen++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

?>