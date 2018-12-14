<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
?>

<?php
// Avatar löschen
    // Bildname des Avatars aus der Datenbank holen
    $sql = "SELECT
                Avatar
            FROM
                mitglieder
            WHERE
                ID = '".$_SESSION['UserID']."'
           ";
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
    $row = mysql_fetch_assoc($result);
    // Datei löschen
    unlink('avatare/'.$row['Avatar']);
    // Bildname des Avatars als leeren String setzen
    $sql = "UPDATE
                mitglieder
            SET
                Avatar = ''
            WHERE
                ID = '".$_SESSION['UserID']."'
           ";
    mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
    echo "Ihr Avatar wurde erfolgreich gel&ouml;scht.<br>\n";    
?>