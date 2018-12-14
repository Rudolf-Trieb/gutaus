<?php
// obligatorischen Felder Kontrolle 
        // Pr�ft, ob ein Nickname eingegeben wurde
        if(trim($Formulardaten['Nickname'])=='')
            $errors[]= "Bitte geben Sie einen Nickname ein.";
        // Pr�ft, ob der Nickname mindestens 3 Zeichen enth�lt
        elseif(strlen(trim($Formulardaten['Nickname'])) < 3)
            $errors[]= "Ihr Name muss mindestens 3 Zeichen lang sein.";
        // Pr�ft, ob der Nickname nur g�ltige Zeichen enth�lt
        elseif(!preg_match('/^\w+$/', trim($Formulardaten['Nickname'])))
            $errors[]= "Benutzen Sie bitte nur alphanumerische Zeichen (Zahlen, Buchstaben und den Unterstrich).";
        // Pr�ft, ob der Nickname bereits vergeben ist
        elseif (trim($Formulardaten['Nickname'])<>$_SESSION['Nickname'])
            if(ermittle_Nickname_ID(trim($Formulardaten['Nickname'])))
                $errors[]= "Der Nickname ".trim($Formulardaten['Nickname'])." ist bereits vergeben.";
        // Pr�ft, ob eine Email-Adresse eingegeben wurde
        if(trim($Formulardaten['Email'])=='')
            $errors[]= "Bitte geben Sie Ihre Email-Adresse ein.";
        // Pr�ft, ob die Email-Adresse g�ltig ist
        elseif(!check_email(trim($Formulardaten['Email'])))
            $errors[]= "Ihre Email Adresse hat ein falsches Format.";
        // Pr�ft, ob die Email-Adresse bereits vergeben ist 
        elseif (trim($Formulardaten['Email'])<>$_SESSION['Email'])   
            if (ermittle_Empfaenger_ID(trim($Formulardaten['Email']),$_SESSION['Tester_Flag']))
            $errors[]= "Die Email Adresse ".trim($Formulardaten['Email'])." ist bereits registriert.";
?>