<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
?>

<?php
parse_str($_POST["formdata"], $Formulardaten);


// Passwort ändern 
            $errors=array();
            // Altes Passwort zum Vergleich aus der Datenbank holen
            $sql = "SELECT
                        Passwort
                    FROM
                        mitglieder
                    WHERE
                        ID = '".$_SESSION['UserID']."'
                   ";
            $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
            $row = mysql_fetch_assoc($result);
            if(!isset($Formulardaten['Passwort'],
                      $Formulardaten['Passwortwiederholung'],
                      $Formulardaten['Altes_Passwort']))
                $errors[]= "Bitte benutzen Sie das Formular aus Ihrem Profil.";
            else {
                if(trim($Formulardaten['Passwort'])=="")
                    $errors[]= "Bitte geben Sie Ihr Passwort ein.";
                elseif(strlen(trim($Formulardaten['Passwort'])) < 6)
                    $errors[]= "Ihr Passwort muss mindestens 6 Zeichen lang sein.";
                if(trim($Formulardaten['Passwortwiederholung'])=="")
                    $errors[]= "Bitte wiederholen Sie Ihr Passwort.";
                elseif(trim($Formulardaten['Passwort']) != trim($Formulardaten['Passwortwiederholung']))
                    $errors[]= "Ihre Passwortwiederholung war nicht korrekt.";
                // Kontrolle des alten Passworts
                if(trim($row['Passwort']) != md5(trim($Formulardaten['Altes_Passwort'])))
                    $errors[]= "Ihr altes Passwort ist nicht korrekt.";
            }
            if(count($errors)){
                echo "Ihr Passwort konnte nicht gespeichert werden.<br>\n".
                     "<br>\n";
                 foreach($errors as $error)
                     echo $error."<br>\n";
                 echo "<br>\n";
                      
            }
            else{
                $sql = "UPDATE
                                mitglieder
                        SET
                                Passwort ='".md5(trim($Formulardaten['Passwort']))."'
                        WHERE
                                ID = '".$_SESSION['UserID']."'
                       ";
                mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
                echo "Ihr neues Passwort wurde erfolgreich gespeichert.<br>\n";
                     
            }
?>