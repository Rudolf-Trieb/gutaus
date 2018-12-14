<?php
     $_SESSION['ID_Empfaenger']=0;
     $_SESSION['Nickname_Empfaenger']=0;
	 $_SESSION['Einheit']=mysql_real_escape_string($Formulardaten['Einheit']);
	 $Formulardaten['Betrag']=abs(trim(mysql_real_escape_string($Formulardaten['Betrag'])));

   if (!isset($_SESSION['UserID'])) {
      include ("include_30_login_formular.php");
      $errors[]="Sie sind noch nicht eingelogt.";
   }
// KONTO EIGENES
   elseif (!pruefe_Konto_vorhanden($_SESSION['UserID'],$_SESSION['Einheit'])) {
            $errors[]= "<table><tr><td><h3>Sie haben noch kein Konto f&uuml;r </h3><h2>".$_SESSION['Einheit']." !!!</h2></td></tr>
        	           <tr><td><ul><li><a href='".$_SERVER['PHP_SELF']."?Content_Ebene_0=Konto eroeffnen&LoginStatus=1' title='kostenlose Kontoer&ouml;fnung' >".$_SESSION['Einheit']."-Konto kostenlos er&ouml;ffnen</a></li></ul></td></tr></table>";
   }     
// EMPF�NGER 

// ONLINE EMPF�NGER      
     if ($Formulardaten['Ueberweisungsart']=="Mitglied") {
        // Pr�fe ob, Nickname eingegeben
        if(trim($Formulardaten['Empfaenger'])=='') 
            $errors[]= "Bitte geben Sie den Nickname des Empf&auml;gers ein.";
        else { // Ja ==> Ermittle Empf�nger-Nickname und ID 
            $_SESSION['ID_Empfaenger']=ermittle_Empfaenger_ID(trim($Formulardaten['Empfaenger']),$_SESSION['Tester_Flag']);
            $_SESSION['Nickname_Empfaenger']=ermittle_Nickname($_SESSION['ID_Empfaenger']); 
        }
     }
     
// E-MAIL EMPF�NGER                   
     elseif ($Formulardaten['Ueberweisungsart']=="Email") {
        // print_r ( $_SESSION );
        // Pr�fe ob, Empf�nger-E-Mail eingegeben
        if(trim($Formulardaten['Empfaenger'])=='')
            $errors[]= "Bitte geben Sie die E-Mail-Adresse des Empf&auml;gers ein.";
        else { // Ja ==> Pr�fe ob Format E-Mail ok
            if(!check_email(trim($Formulardaten['Empfaenger'])))
                $errors[]= "Die Email Adresse hat eine falsche Syntax. <br>".
                       "Bitte geben Sie eine Empf&auml;nger E-Mail wie z.B. peterK@web.de ein.";
            else { // Ja ==> Ermittle Empf�nger-Nickname und ID
                $_SESSION['ID_Empfaenger']=ermittle_Empfaenger_ID(trim($Formulardaten['Empfaenger']),$_SESSION['Tester_Flag']);
                $_SESSION['Nickname_Empfaenger']=ermittle_Nickname($_SESSION['ID_Empfaenger']);
            }              
        }    
     }
     
// HANDY EMPF�NGER
     elseif ($Formulardaten['Ueberweisungsart']=="Handy") {
        // Pr�fe ob, Empf�nger-Handynummer eingegeben
        if(trim($Formulardaten['Empfaenger'])=='')
            $errors[]= "Bitte geben Sie die Handynummer des Empf&auml;gers ein.";
        else { // Ja ==> Pr�fe ob Format Handynummer ok
            if(!preg_match('�^0[0-9]{10,20}$�',trim($Formulardaten['Empfaenger'])))
                $errors[]= "Die Handynummer hat ein falsches Format. <br>".
                       "(Beispiel f&uuml;r ein richtiges Format <b>01608540091 oder 00491608540091</b>)".
                       " <br> <b>Achtung: Es sind nur Zahlen erlaubt!</b>";            
            else { // Ja ==> Ermittle Empf�nger-Nickname und ID
                $_SESSION['Handynummer_Empfaenger']=bereinige_und_schreibe_laenderkennung_0049_vor_handynummer(trim($Formulardaten['Empfaenger']));
                $_SESSION['ID_Empfaenger']=ermittle_Empfaenger_ID($_SESSION['Handynummer_Empfaenger'],$_SESSION['Tester_Flag']);
                $_SESSION['Nickname_Empfaenger']=ermittle_Nickname($_SESSION['ID_Empfaenger']);
            }
        }         
     }
     
//  AN SICH SELBST �BERWEISUNG
     if ($_SESSION['ID_Empfaenger']==$_SESSION['UserID'])
		$errors[]= "Es ist nicht erlaubt an sich selbst zu &uuml;berweisen.";
     
// BETRAG     
     // Pr�fe, ob Betrag eingegebn
     if($Formulardaten['Betrag']=='')
           $errors[]= "Bitte geben Sie einen &Uuml;berweisungs-Betrag ein.";
     else { // Ja ==> Pr�fe ob, Format Betrag ok
        if(!preg_match('/^\d+([\.,]\d{1,2})?$/',trim($Formulardaten['Betrag']))) 
            $errors[]= "Bitte geben Sie einen &Uuml;berweisungs-Betrag der Form 1234,70 oder 1234 ein.";  
        else { // Ja ==> Pr�fe ob, Kontostand ausreichend f�r �berweisung           
            $sql = "SELECT
                         Kontostand,
                         max_Ueberziehung
                    FROM
                         konten
					JOIN mitglieder AS m ON m.ID=ID_Mitglied
                    WHERE
                            ID_Mitglied = '".mysql_real_escape_string($_SESSION['UserID'])."'
                        AND Einheit     = '".$_SESSION['Einheit']."'
						AND Tester_Flag = '".mysql_real_escape_string($_SESSION['Tester_Flag'])."'
                ";
				// echo "<br>sql=".$sql;
            $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
            $row = mysql_fetch_assoc($result);          
            if ($row['Kontostand']-trim($Formulardaten['Betrag'])<$row['max_Ueberziehung']) {
                $max_Betrag=$row['Kontostand']-$row['max_Ueberziehung'];
                $errors[]="<b>".$max_Betrag.
                          " ".$_SESSION['Einheit']." maximale &Uuml;berweisung </b> sind f&uuml;r Sie derzeit m&ouml;glich. <br>".
                          " Ihr ".$_SESSION['Einheit']."-Konto h&auml;tte dann seine maximale &Uuml;berziehungsm&ouml;glichkeit von  ".$row['max_Ueberziehung']." ".$_SESSION['Einheit']." erreicht!";
            }
            else {
                $_SESSION['Kontostand']=$row['Kontostand'];
            } 
            
          // Pr�fe wenn, Empf�nger-ID in DB ob, Empf�nger-Nickname hat Konto der Einheit
            
            if ($_SESSION['ID_Empfaenger']) { // Empf�nger_ID in DB
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
                if (mysql_num_rows($result)==0) {
				
						// Pr�fe ob privat Gutschein oder User auch Herausgeber des Gutscheines
						if (privat_Gutschein($_SESSION['Einheit'])==1 
							and 
							$_SESSION['UserID']<>ermittle_ID_Herausgeber_Von_Einheit($_SESSION['Einheit'])) 
						{
							$errors[]="Mit den <b>".$_SESSION['Einheit']." </b>  k&ouml;nnen leider nur Pesonen bezahlt werden die breits ein <b>"
									 .$_SESSION['Einheit']."-Konto</b> haben, da dieser Gutschein ein privater Gutschein ist!";
						}
						else {// �ffendlicher Gutschein oder User auch Herausgeber des Gutscheines 
				
				
							echo "<b>Info:</b> Das Mitglied <b>".$_SESSION['Nickname_Empfaenger'].
								 "</b> hat noch kein <b>".$_SESSION['Einheit']."-Konto</b>.<br>".
								 "f&uuml;r <b>".$_SESSION['Nickname_Empfaenger']."</b> wird ein neues <b>".
								 $_SESSION['Einheit']."-Konto</b> er&ouml;ffnet.<br>"
								 ;
						}
                }
                // Pr�fen, ob das max_Akzeptanz des Kontos des Emf�ngers nicht �berschritten wird
                else {
                    $row = mysql_fetch_assoc($result);
                    if (isset($_SESSION['ID_Empfaenger']) and $row['Kontostand']+trim($Formulardaten['Betrag'])>$row['max_Akzeptanz']) {
					
                        $errors[]="Sie k&ouml;nnen ".$_SESSION['Nickname_Empfaenger']." Ihre <b>".trim($Formulardaten['Betrag'])." ".
                                  $_SESSION['Einheit']."</b> nicht in voller h&ouml;he &uuml;berweisen. <br>".
		   			              "Denn leider nimmt ".$_SESSION['Nickname_Empfaenger']." derzeit h&ouml;chstens nur noch <b>".($row['max_Akzeptanz']-$row['Kontostand']).
                                  " ".$_SESSION['Einheit']."</b> an!<br>".
                                  "Denn ".$_SESSION['Einheit']." sind nicht zum Sammeln da, sie sind zum Tauschen da!!! ";
                    }
                    else {
                        $_SESSION['Kontostand Empfaenger']=$row['Kontostand'];
                    }
                }                
            }  // ENDE Empf�nger_ID in DB     
        }  // ENDE Pr�fe ob, Kontostand ausreichend f�r �berweisung
         
     } // ENDE Pr�fe ob, Format Betrag ok
                 
                 
// VERWENDUNGSZWECK     
     // Pr�fe ob, Verwendungszweck eingegeben
     if(trim($Formulardaten['Verwendungszweck'])=='')
        $errors[]= "Bitte geben Sie einen Verwendungszweck ein.";
		
//FORMULARDATEN AN SESSION �BERGEBEN
$_SESSION['Betrag']=$Formulardaten['Betrag'];
$_SESSION['Einheit']=$_SESSION['Einheit'];
$_SESSION['Empfaenger']=$Formulardaten['Empfaenger'];
$_SESSION['Email_Empfaenger']=$Formulardaten['Empfaenger'];

$_SESSION['Verwendungszweck']=$Formulardaten['Verwendungszweck'];
$_SESSION['Ueberweisungsart']=$Formulardaten['Ueberweisungsart'];

?>