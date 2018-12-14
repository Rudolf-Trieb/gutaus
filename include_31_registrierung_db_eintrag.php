<?php
// Daten in die Datenbanktabelle einfügen
                
                   
        // Neus Mitglied eintragen           
        $sql = "INSERT INTO
                   mitglieder
                    (Nickname,
                     Passwort,
                     Email,
                     Show_Email,
                     Registrierungsdatum,
                     PLZ,
                     Wohnort,
                     Strasse,
                     Nachname,
                     Vorname,
                     Mobilnummer,
                     Telefonnummer,
                     Facebook,
                     Skype,
                     Okitalk,
                     Homepage,
                     ICQ,
                     MSN,
					 Tester_Flag
                     )
                VALUES
                     ('".mysql_real_escape_string(trim($Formulardaten['Nickname']))."',
                     '".md5(trim($Formulardaten['Passwort']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Email']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Show_Email']))."',
                     CURDATE(),
                     '".mysql_real_escape_string(trim($Formulardaten['PLZ']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Wohnort']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Strasse']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Nachname']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Vorname']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Mobilnummer']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Telefonnummer']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Facebook']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Skype']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Okitalk']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['Homepage']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['ICQ']))."',
                     '".mysql_real_escape_string(trim($Formulardaten['MSN']))."',
					 '".mysql_real_escape_string(trim($_SESSION['Tester_Flag']))."'
                     )
                ";
                   
            mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
            
            
            // ID_Mitglied auslesen
            $_SESSION['UserID']=ermittle_Nickname_ID($Formulardaten['Nickname']);
            
            // Horus Konto eröffnen
            eroeffne_konto ($_SESSION['UserID'],-20,"Horus",ermittle_Einheit_max_Akzeptanz_Standard("Horus"));
			// Euro Konto eröffnen
            eroeffne_konto ($_SESSION['UserID'],0,"Euro",ermittle_Einheit_max_Akzeptanz_Standard("Euro"));
			// g Gold Konto eröffnen
            eroeffne_konto ($_SESSION['UserID'],0,"g Gold",ermittle_Einheit_max_Akzeptanz_Standard("g Gold"));
			// g Silber Konto eröffnen
            eroeffne_konto ($_SESSION['UserID'],0,"g Silber",ermittle_Einheit_max_Akzeptanz_Standard("g Silber"));
            
            echo "Vielen Dank!\n<br>". 
                 "Ihr Accout wurde erfolgreich erstellt.\n<br>". 
                 "Sie k&ouml;nnen sich nun mit Ihren Daten einloggen.\n<br>". 
                 "<a id='login' href='#'>Zum Login</a>\n";

?>