<?php
     $_SESSION['Nickname_Empfaenger']=0;

// KONTO BEI SENDER VORHANDEN ****************************************************************************************************************************
   if (!pruefe_Konto_vorhanden($_SESSION['user_id'],$_SESSION['Einheit'])) {
            $errors[]='Sie haben noch kein '.$_SESSION['Einheit'].'-Konto !!!\n'.
        	           'Bitte lassen Sie sich ein '.$_SESSION['Einheit'].'-Konto vom Herausgeber dieser Gutscheine einrichten.';
   }     
// EMPFÄNGER *********************************************************************************************************************************************

//  AN SICH SELBST ÜBERWEISUNG
     if ($_SESSION['ID_Empfaenger']==$_SESSION["user_id"])
		$errors[]='Es ist nicht erlaubt an sich selbst zu überweisen.';

// MEMBER EMPFÄNGER      
     if ($_SESSION['Ueberweisungsart']=="member" or $_SESSION['Ueberweisungsart']=="known member") {
        // Prüfe ob, Nickname eingegeben
        if(trim($_SESSION['Empfaenger']=='')) 
            $errors[]='Bitte geben Sie den Nickname des Empfängers ein.';
        else { // Ja ==> Ermittle Empfänger-Nickname und ID 
            $_SESSION['Nickname_Empfaenger']=ermittle_Nickname($_SESSION['ID_Empfaenger']); // aus Sicherheitzgründen wird der Nickname_Empfaenger zur ID_Empfaenger nochmals ermittelt.
        }
     }
     
// EMAIL EMPFÄNGER                   
     elseif ($_SESSION['Ueberweisungsart']=="email") {
        // print_r ( $_SESSION );
        // Prüfe ob, Empfänger-E-Mail eingegeben
        if(trim($_SESSION['Empfaenger'])=='')
            $errors[]='Bitte geben Sie die E-Mail-Adresse des Empfängers ein.';
        else { // Ja ==> Prüfe ob Format E-Mail ok
            if(!check_email(trim($_SESSION['Empfaenger'])))
                $errors[]='Die Email Adresse hat eine falsche Syntax.\n'.
                       'Bitte geben Sie eine Empfänger E-Mail der Form z.B. peterK@web.de ein.';
            else { // Ja ==> Ermittle Empfänger-Nickname und ID
                $_SESSION['ID_Empfaenger']=ermittle_Empfaenger_ID(trim($_SESSION['Empfaenger']),$_SESSION['Tester_Flag']); // ID_Empfaenger wird gefunden wenn Email in DB
                $_SESSION['Nickname_Empfaenger']=ermittle_Nickname($_SESSION['ID_Empfaenger']); // Nickname_Empfaenger wird gefunden wenn Email in DB 
				$_SESSION['Email_Empfaenger']=trim($_SESSION['Empfaenger']);
            }              
        }    
     }
     
// MOBILE EMPFÄNGER
     elseif ($_SESSION['Ueberweisungsart']=="mobile") {
        // Prüfe ob, Empfänger-Handynummer eingegeben
        if(trim($_SESSION['Empfaenger'])=='')
            $errors[]='Bitte geben Sie die Handynummer des Empfägers ein.';
        else { // Ja ==> Prüfe ob Format Handynummer ok
            if(!preg_match('§^0[0-9]{10,20}$§',trim($_SESSION['Empfaenger'])))
                $errors[]='Die Handynummer hat ein falsches Format.\n'.
                       'Beispiel eines richtigen Formates in Deuschland 01608540091 oder mit Länderkennung 00491608540091 auserhalb Deutschlands und für eine nicht deutsche Handynummer.)\n'.
                       'Achtung: Es sind nur Zahlen erlaubt!';            
            else { // Ja ==> Ermittle Empfänger-Nickname und ID
                $_SESSION['Handynummer_Empfaenger']=bereinige_und_schreibe_laenderkennung_0049_vor_handynummer(trim($_SESSION['Empfaenger']));
                $_SESSION['ID_Empfaenger']=ermittle_Empfaenger_ID($_SESSION['Handynummer_Empfaenger'],$_SESSION['Tester_Flag']); // ID_Empfaenger wird gefunden wenn Handynummer in DB
                $_SESSION['Nickname_Empfaenger']=ermittle_Nickname($_SESSION['ID_Empfaenger']); // Nickname_Empfaenger wird gefunden wenn Handynummer in DB
            }
        }         
     }
     

     
// BETRAG ***************************************************************************************************************************************************  
     // Prüfe, ob Betrag eingegebn
     if(trim($_SESSION['Betrag'])=='')
           $errors[]='Bitte geben Sie einen Überweisungs-Betrag ein.';
     else { // Ja ==> Prüfe ob, Format Betrag ok
        if(!preg_match('/^\d+([\.,]\d{1,2})?$/',trim($_SESSION['Betrag']))) 
            $errors[]='Bitte geben Sie einen &Uuml;berweisungs-Betrag der Form 1234,70 oder 1234 ein.'; 
		else { //JA ==> Prüfe ob, Betrag > 0
			if (!trim($_SESSION['Betrag'])>0) {
				$errors[]='Bitte geben Sie einen &Uuml;berweisungs-Betrag der größer als 0 ist ein.';
			}			
			else { // Ja ==> Prüfe ob, Kontostand ausreichend für Überweisung           
				$sql = "SELECT
							 Kontostand,
							 max_Ueberziehung
						FROM
							 konten
						JOIN mitglieder AS m ON m.ID=ID_Mitglied
						WHERE
								ID_Mitglied = '".mysql_real_escape_string($_SESSION['user_id'])."'
							AND Einheit     = '".$_SESSION['Einheit']."'
							AND Tester_Flag = '".mysql_real_escape_string($_SESSION['Tester_Flag'])."'
					";
					// echo "<br>sql=".$sql;
				$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
				$row = mysql_fetch_assoc($result);          
				if ($row['Kontostand']-trim($_SESSION['Betrag'])<$row['max_Ueberziehung']) {
					$max_Betrag=$row['Kontostand']-$row['max_Ueberziehung'];
					$errors[]=$max_Betrag.
							  ' '.$_SESSION['Einheit'].' maximale Überweisung sind für Sie derzeit möglich.\n'.
							  ' Ihr '.$_SESSION['Einheit'].'-Konto hätte dann seine maximale Überziehungsmöglichkeit von  '.$row['max_Ueberziehung'].' '.$_SESSION['Einheit'].' erreicht!';
				}
				else {
					$_SESSION['Kontostand']=$row['Kontostand'];
				} 
				
			  // Prüfe nur wenn Empfänger-ID in DB ist ob, Empfänger-Nickname ein Konto der Einheit hat
				
				if ($_SESSION['ID_Empfaenger']) { // Empfänger_ID in DB
					$sql = "SELECT
							 Kontostand,
							 max_Akzeptanz
							FROM
								konten
							JOIN mitglieder AS m ON m.ID=ID_Mitglied
							WHERE
									ID_Mitglied = '".mysql_real_escape_string($_SESSION['ID_Empfaenger'])."'
								AND Einheit     = '".$_SESSION['Einheit']."'
								AND Tester_Flag = '".mysql_real_escape_string($_SESSION['Tester_Flag'])."'	
					";
					// echo "<br>sql=".$sql;
					$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
					if (mysql_num_rows($result)==0) { // Empfänger-Nickname hat kein Konto der Einheit
					
							// Prüfe ob privat Gutschein und User nicht Herausgeber des Gutscheines
							if (privat_Gutschein($_SESSION['Einheit'])==1 // privater Gutschein
								and 
								$_SESSION['user_id']<>ermittle_ID_Herausgeber_Von_Einheit($_SESSION['Einheit'])) // USER ist nicht Herausgeber des Gutscheines 
							{
								$errors[]='Mit den'.$_SESSION['Einheit'].' können leider nur Emfänger bezahlt werden die breits ein '
										 .$_SESSION['Einheit'].'-Konto haben,\n da dieser Gutschein ein privater Gutschein ist!\n'.
										 'Der Herausgeber des Gutscheines kann ihrem Gutscheinemfänger ein '
										 .$_SESSION['Einheit'].'-Konto einrichten damit Sie überweisen können.';
							}
					}
					// Prüfen, ob das max_Akzeptanz des Kontos des Emfängers nicht überschritten wird
					else {
						$row = mysql_fetch_assoc($result);
						if (isset($_SESSION['ID_Empfaenger']) and $row['Kontostand']+trim($_SESSION['Betrag'])>$row['max_Akzeptanz']) {
						
							$errors[]='Sie können '.$_SESSION['Nickname_Empfaenger'].' Ihre '.trim($_SESSION['Betrag']).' '.
									  $_SESSION['Einheit'].' nicht in voller Höhe überweisen.\n'.
									  'Denn leider nimmt '.$_SESSION['Nickname_Empfaenger'].' derzeit höchstens nur noch '.($row['max_Akzeptanz']-$row['Kontostand']).
									  ' '.$_SESSION['Einheit'].' an!\n'.
									  'Denn '.$_SESSION['Einheit'].' sind nicht zum Sammeln da, sie sind zum Tauschen da!!!\n'.
									  'Daher möchte '.$_SESSION['Nickname_Empfaenger'].' nicht zu viele der '.$_SESSION['Einheit'].'-Gutscheine.';
						}
						else {
							$_SESSION['Kontostand Empfaenger']=$row['Kontostand'];
						}
					}                
				}  // ENDE Empfänger_ID in DB     
			}  // ENDE Prüfe ob, Kontostand ausreichend für Überweisung
							
		} // ENDE Prüfe ob, Betrag > 0
       
     } // ENDE Prüfe ob, Format Betrag ok
                 
                 
// VERWENDUNGSZWECK ******************************************************************************************************************************************     
     // Prüfe ob, Verwendungszweck eingegeben
     if(trim($_SESSION['Verwendungszweck'])=='')
        $errors[]='Bitte geben Sie einen Verwendungszweck ein.';
		


?>