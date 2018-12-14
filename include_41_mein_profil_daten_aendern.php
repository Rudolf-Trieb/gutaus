<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
	include('funktionen.php');
?>


<?php

parse_str($_POST["formdata"], $Formulardaten);

// Daten ändern 
    // Fehlerarray anlegen 
    $errors = array(); 
    // Prüfen, ob alle Formularfelder vorhanden sind 
    if(!isset($Formulardaten['Email'], 
              $Formulardaten['Show_Email'], 
              $Formulardaten['PLZ'], 
              $Formulardaten['Wohnort'],
              $Formulardaten['Strasse'],
              $Formulardaten['Nachname'],
              $Formulardaten['Vorname'],
              $Formulardaten['Homepage'],
              $Formulardaten['Skype'],
              $Formulardaten['Facebook'],
              $Formulardaten['Okitalk'], 
              $Formulardaten['ICQ'], 
              $Formulardaten['MSN'])) 
        // Ein Element im Fehlerarray hinzufügen 
        $errors = "Bitte benutzen Sie das Formular aus Ihrem Profil"; 
    else{ 
    
    
        // Prüfung der einzelnen obligatorischen Felder
        include ("include_0_obligatorischen_felder_kontrolle.php");
    
        // Fehler ausgeben falls vorhanden   
        if(count($errors)){ 
            echo "Ihre Daten konnten nicht bearbeitet werden.<br>\n". 
                 "<br>\n"; 
            foreach($errors as $error) 
                echo $error."<br>\n"; 
            echo "<br>\n". 
                 "Zurück zu <a href=\"".$_SERVER['PHP_SELF']."?Content_Ebene_0=Mein+Profil&Content_Ebene_1=Avatar+Daten+&auml;ndern&LoginStatus=1\">Mein Profil</a>\n";
        } 
        // Keine Fehler dann Updaten
        else{ 
            if ($Formulardaten['Nickname']=='')
                $Formulardaten['Nickname']=$_SESSION['Nickname']; 
            else
                $_SESSION['Nickname']=$Formulardaten['Nickname'];

            $sql = "UPDATE 
                            mitglieder 
                    SET 
                            Nickname= '".mysql_real_escape_string(trim($Formulardaten['Nickname']))."',
                            Email =  '".mysql_real_escape_string(trim($Formulardaten['Email']))."',
                            Show_Email = '".mysql_real_escape_string(trim($Formulardaten['Show_Email']))."',
                            PLZ = '".mysql_real_escape_string(trim($Formulardaten['PLZ']))."',
                            Wohnort = '".mysql_real_escape_string(trim($Formulardaten['Wohnort']))."',
                            Strasse = '".mysql_real_escape_string(trim($Formulardaten['Strasse']))."',
                            Nachname = '".mysql_real_escape_string(trim($Formulardaten['Nachname']))."',
                            Vorname = '".mysql_real_escape_string(trim($Formulardaten['Vorname']))."',
                            Homepage = '".mysql_real_escape_string(trim($Formulardaten['Homepage']))."',
                            Skype = '".mysql_real_escape_string(trim($Formulardaten['Skype']))."',
                            Okitalk = '".mysql_real_escape_string(trim($Formulardaten['Okitalk']))."',
                            Facebook = '".mysql_real_escape_string(trim($Formulardaten['Facebook']))."',
                            ICQ = '".mysql_real_escape_string(trim($Formulardaten['ICQ']))."',
                            MSN = '".mysql_real_escape_string(trim($Formulardaten['MSN']))."'
                    WHERE 
                            ID = '".mysql_real_escape_string($_SESSION['UserID'])."'
                   ";    
            mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
            echo "Die &Auml;nderung ihrer Daten wurden erfolgreich gespeichert.<br>\n"; 
                 
        }
    }    
?>