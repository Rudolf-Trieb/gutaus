<?php

	
    // Fehlerarray anlegen 
    $errors = array(); 
    // Prüfen, ob alle Formularfelder vorhanden sind 
    if(!isset($Formulardaten['Nickname'], 
              $Formulardaten['Passwort'], 
              $Formulardaten['Passwortwiederholung'], 
              $Formulardaten['Email'], 
              $Formulardaten['Show_Email'], 
              $Formulardaten['PLZ'], 
              $Formulardaten['Wohnort'],
              $Formulardaten['Strasse'],
              $Formulardaten['Nachname'],
              $Formulardaten['Vorname'],
              $Formulardaten['Mobilnummer'],
              $Formulardaten['Telefonnummer'],
              $Formulardaten['Facebook'],
              $Formulardaten['Okitalk'],
              $Formulardaten['Skype'],
              $Formulardaten['Homepage'], 
              $Formulardaten['ICQ'],   
              $Formulardaten['MSN'])) 
        // Ein Element im Fehlerarray hinzufügen 
        $errors[] = "Bitte benutzen Sie das Formular aus dem Registrierungsbereich";
        
    else{ 
        // Prüfung der einzelnen obligatorischen Felder 
        include ("include_0_obligatorischen_felder_kontrolle.php");
        // Prüft, ob ein Passwort eingegeben wurde 
        if(trim($Formulardaten['Passwort'])=='') 
            $errors[]= "Bitte geben Sie Ihr Passwort ein."; 
        // Prüft, ob das Passwort mindestens 6 Zeichen enthält 
        elseif (strlen(trim($Formulardaten['Passwort'])) < 6) 
            $errors[]= "Ihr Passwort muss mindestens 6 Zeichen lang sein.";
        // Prüft, ob eine Passwortwiederholung eingegeben wurde 
        if(trim($Formulardaten['Passwortwiederholung'])=='') 
            $errors[]= "Bitte wiederholen Sie Ihr Passwort."; 
        // Prüft, ob das Passwort und die Passwortwiederholung übereinstimmen
        elseif (trim($Formulardaten['Passwort']) != trim($Formulardaten['Passwortwiederholung']))
            $errors[]= "Ihre Passwortwiederholung war nicht korrekt.";
         
        // Prüfe, falls eingegeben, ob Format der Mobilnummer ok    
        if(trim($Formulardaten['Mobilnummer'])<>'') {
            if(!preg_match('§^0[0-9]{10,20}$§',trim($Formulardaten['Mobilnummer'])))
                $errors[]= "Die Mobilnummer hat ein falsches Format. <br>".
                       "(Beispiel für ein richtiges Format <b>01608540091 oder 00491608540091</b>)".
                       " <br> <b>Achtung: Es sind nur Zahlen erlaubt!</b>";
            else { // 0049 Voranstellen
                $Formulardaten['Mobilnummer']=bereinige_und_schreibe_laenderkennung_0049_vor_handynummer(trim($Formulardaten['Mobilnummer']));
            }
            $_SESSION['Mobilnummer']=trim($Formulardaten['Mobilnummer']);
        }   
         
    } 
?>