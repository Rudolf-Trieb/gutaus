<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
?>

<?php 
    if ($_POST["Passwort"]==$_POST["Passwort_Wiederholung"]) {
	
		// Neues Paswort in DB schreiben
            $sql = "UPDATE
                        mitglieder
                    SET
                        Passwort = '".md5(trim($_POST["Passwort"]))."'
                    WHERE
                        Nickname = '".mysql_real_escape_string(trim($_SESSION['Nickname']))."'
                   ";
         mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		 
		 //echo "sql=".$sql;
	
		$_SESSION['code']=""; // E-Mail-Passwort-Ändeungscode zurücksetzen
		echo "<h2>Ihr Passwort wurde erfolgreich ge&auml;ndert. Bitte loggen Sie sich ein!</h2><br><br><br>";
		include ("include_30_login_formular.php");
	}
	else {
		echo "Fehler: Die Wiederholung des neuen Passwortes stimmt nicht &uuml;berein!";
		include ("include_32_pw_neu_festlegen.php");
	}
		
?>