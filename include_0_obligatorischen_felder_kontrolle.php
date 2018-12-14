<?php
// obligatorischen Felder Kontrolle 
        // Prüft, ob ein Nickname eingegeben wurde
        if(trim($Formulardaten['Nickname'])=='')
            $errors[]= "Bitte geben Sie einen Nickname ein.";
        // Prüft, ob der Nickname mindestens 3 Zeichen enthält
        elseif(strlen(trim($Formulardaten['Nickname'])) < 3)
            $errors[]= "Ihr Name muss mindestens 3 Zeichen lang sein.";
        // Prüft, ob der Nickname nur gültige Zeichen enthält
        elseif(!preg_match('/^\w+$/', trim($Formulardaten['Nickname'])))
            $errors[]= "Benutzen Sie bitte nur alphanumerische Zeichen (Zahlen, Buchstaben und den Unterstrich).";
        // Prüft, ob der Nickname bereits vergeben ist
        elseif (trim($Formulardaten['Nickname'])<>$_SESSION['Nickname'])
            if(ermittle_Nickname_ID(trim($Formulardaten['Nickname'])))
                $errors[]= "Der Nickname ".trim($Formulardaten['Nickname'])." ist bereits vergeben.";
        // Prüft, ob eine Email-Adresse eingegeben wurde
        if(trim($Formulardaten['Email'])=='')
            $errors[]= "Bitte geben Sie Ihre Email-Adresse ein.";
        // Prüft, ob die Email-Adresse gültig ist
        elseif(!check_email(trim($Formulardaten['Email'])))
            $errors[]= "Ihre Email Adresse hat ein falsches Format.";
        // Prüft, ob die Email-Adresse bereits vergeben ist 
        elseif (trim($Formulardaten['Email'])<>$_SESSION['Email'])   
            if (ermittle_Empfaenger_ID(trim($Formulardaten['Email']),$_SESSION['Tester_Flag']))
            $errors[]= "Die Email Adresse ".trim($Formulardaten['Email'])." ist bereits registriert.";
?>