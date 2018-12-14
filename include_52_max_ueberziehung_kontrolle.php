<?php   
	// FORMDATEN an PHP �BERGEBEN
	parse_str($_POST['formdata'],$Formulardaten);	

     // Pr�fe, ob Betrag eingegebn
     if(trim($Formulardaten['max_ueberziehung'])=='')
           $errors[]= "Bitte geben Sie einen maximalen �berziehungs-Betrag ein.";
     else { // Ja ==> Pr�fe ob, Format Betrag ok  
        if(!preg_match('/^([\-|0])\d*([\.,]\d{1,2})?$/',trim($Formulardaten['max_ueberziehung']))) 
            $errors[]= "Bitte geben Sie einen maximalen �berziehungs-Betrag der Form -1234,70 oder -1234 ein."; 
		else { // Ja ==> Pr�fe ob, User auch Herausgeber der Einheit ist                     
            if ($_SESSION['Nickname']<>$_SESSION['Herausgeber']) {
			    
                $errors[]="Sie sind nicht der Herausgerber der ".$_SESSION['Einheit']."-Gutscheine.<br>".
						  " Bitte wenden Sie sich an <a class='mitglied' href='#'>".$_SESSION['Herausgeber']."</a> den Herausgeben der ".$_SESSION['Einheit'].
						  "-Gutscheine<br>".
						  "und bitten Sie diesen um die �nderung Ihrer max. �berziehung.";
            }   
            else {
				
				if (Passwort_OK($_SESSION['UserID'],$Formulardaten["passwort"])) { // Passwort ok
					$_SESSION['max_Ueberziehung']=trim($Formulardaten['max_ueberziehung']);
				}
				else { // Passwort nicht ok
					$errors[]="Die max. �berziehung konnte nicht ge�ndert werden, da Sie ihr Passwort falsch eingeben haben!";
				}
            } 
            
    
        }  // ENDE Pr�fe ob, max_Akzeptanz nicht gr��er als max_Akzeptanz_Standard vom Herrausgeber   

  
     } // ENDE Pr�fe ob, Format Betrag ok              
?>