<?php
   //SESSION
    session_start();
	include_once('../includes/include_0_db_conection.php');
	include_once('../includes/funktionen.php');	
	
	if ($_SESSION["login"]==1) { // is logtin
	
		
		$_SESSION['Einheit'] = trim(mysql_real_escape_string($_REQUEST['creditnote']));
		//$_SESSION['ID_Empfaenger'] = trim(mysql_real_escape_string($_REQUEST['receiverId']));
		$_SESSION['Empfaenger']  = trim(mysql_real_escape_string($_REQUEST['receiver']));
		$_SESSION['Betrag'] = abs(mysql_real_escape_string($_REQUEST['amount']));
		$_SESSION['Verwendungszweck'] = trim(mysql_real_escape_string($_REQUEST['purpose']));
		$_SESSION['Ueberweisungsart'] = trim(mysql_real_escape_string($_REQUEST['typeOfTransfer']));
		
//echo "after data send:  ";		
//echo "user_id=".$_SESSION['user_id']."/n";	
//echo "user_name=".$_SESSION['user_name']."/n";	
//echo "ID_Empfaenger=".$_SESSION['ID_Empfaenger']."/n";
//echo "Empfaenger=".$_SESSION['Empfaenger']."/n";
//echo "Nickname_Empfaenger=".$_SESSION['Nickname_Empfaenger']."/n";

		// Ermittle Emfänger_ID
		if ($_SESSION['Ueberweisungsart']=="member" or $_SESSION['Ueberweisungsart']=="known member") {
			$_SESSION['ID_Empfaenger']=$_SESSION['Empfaenger']
		}
		
		else{ // $_SESSION['Ueberweisungsart']=="email" or =="mobilenumber"
			$_SESSION['ID_Empfaenger']=ermittle_Empfaenger_ID($_SESSION['Empfaenger'],$_SESSION['Tester_Flag']);
		}
//echo "befor check:  ";		
//echo "user_id=".$_SESSION['user_id']."/n";
//echo "user_name=".$_SESSION['user_name']."/n";		
//echo "ID_Empfaenger=".$_SESSION['ID_Empfaenger']."/n";
//echo "Empfaenger=".$_SESSION['Empfaenger']."/n";
//echo "Nickname_Empfaenger=".$_SESSION['Nickname_Empfaenger']."/n";

		
//***************************************************************************************************************************************************************
// PRÜFE ÜBERWEISUNG MÖGLICH************************************************************************************************************************************
//***************************************************************************************************************************************************************		
		include_once('../includes/pay-check.php');

//echo "after check:  ";			
//echo "user_id=".$_SESSION['user_id']."/n";	
//echo "user_name=".$_SESSION['user_name']."/n";	
//echo "ID_Empfaenger=".$_SESSION['ID_Empfaenger']."/n";
//echo "Empfaenger=".$_SESSION['Empfaenger']."/n";
//echo "Nickname_Empfaenger=".$_SESSION['Nickname_Empfaenger']."/n";	

//***************************************************************************************************************************************************************
// DB EINTRÄGE SENDEN, INFO MAILS BZW. SMS SENDEN UND RÜGMELDUNG AN USER ZURÜCKGEBEN **************************************************************************
//***************************************************************************************************************************************************************		
		if (count($errors)==0) { // Überweisung ist möglich ==> Überweise
			$send_back='{"msg":"';	
			// falls nötig neues Mitglied und dessen Horus-Konten registrieren

			if ($_SESSION['ID_Empfaenger']==0) { // Empfänger noch nicht in DB

				$_SESSION['Nickname_Empfaenger']=getnickname();
				$_SESSION['Passwort_Empfaenger']=getpasswort();
				
				// neues Mitglied registrieren
				$_SESSION['ID_Empfaenger']=neues_Mitglied_registrieren($_SESSION['Nickname_Empfaenger'],
																		$_SESSION['Email_Empfaenger'],
																		$_SESSION['Handynummer_Empfaenger'],
																		$_SESSION['Passwort_Empfaenger'],
																		$_SESSION['Tester_Flag']);	
				
				// Horus Konto eröffnen
				eroeffne_konto ($_SESSION['ID_Empfaenger'],0,"Horus",ermittle_Einheit_max_Akzeptanz_Standard("Horus"));
				// Euro Konto eröffnen
				eroeffne_konto ($_SESSION['user_id'],0,"Euro",ermittle_Einheit_max_Akzeptanz_Standard("Euro"));
				// g Gold Konto eröffnen
				eroeffne_konto ($_SESSION['user_id'],0,"g Gold",ermittle_Einheit_max_Akzeptanz_Standard("g Gold"));
				// g Silber Konto eröffnen
				eroeffne_konto ($_SESSION['user_id'],0,"g Silber",ermittle_Einheit_max_Akzeptanz_Standard("g Silber"));	
				$_SESSION['send_Passwort']=true;


			}
			else { // Empfänger ist in DB
				$_SESSION['Nickname_Empfaenger']=ermittle_Nickname($_SESSION['ID_Empfaenger']);
			}

//echo "befor write";			
//echo "user_id=".$_SESSION['user_id']."/n";		
//echo "ID_Empfaenger=".$_SESSION['ID_Empfaenger']."/n";
//echo "Empfaenger=".$_SESSION['Empfaenger']."/n";
//echo "user_name=".$_SESSION['Iuser_name']."/n";
//echo "Nickname_Empfaenger=".$_SESSION['Nickname_Empfaenger']."/n";

//exit();



			// Überweisung in die DB-Tabelle ueberweisungen einfügen und Empfänger-Konto eröffen falls nötig
			$back_msg=schreibe_Buchungsatz($_SESSION['user_id'],
									 $_SESSION['user_name'],
									 str_replace(",", ".",trim($_SESSION['Betrag'])),
									 $_SESSION['Einheit'],
									 mysql_real_escape_string(trim($_SESSION['Verwendungszweck'])),
									 $_SESSION['ID_Empfaenger'],
									 mysql_real_escape_string(trim($_SESSION['Nickname_Empfaenger'])),
									 $_SESSION['Ueberweisungsart']);
									 
//User informieren ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if ($back_msg=="new receiver account was opened") {
				$send_back.= 'Info: Das Mitglied '.$_SESSION['Nickname_Empfaenger'].
				 ' hat noch kein '.$_SESSION['Einheit'].'-Konto,\n'.
				 'für '.$_SESSION['Nickname_Empfaenger'].' wird ein neues '.
				 $_SESSION['Einheit'].'-Konto eröffnet.\n';
			 }
			 
		 	 
			if ($_SESSION['Email']<>"") { // Email des Users ist bekannt
			
				$titel = "Sie haben soeben ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." an ".$_SESSION['Empfaenger']." &uuml;berwiesen !";

				$header  = "From: GutscheinTauschSystem<777horus@gmail.com>\r\n";
				$header .= "Reply-To: GutscheinTauschSystem GuTauS<777horus@gmail.com>\r\n"; //Bei Antwort
				$header .= "Return-Path: 777horus@gmail.com\r\n"; // Bei Unzustellbarkeit
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-Type:text/html; charset=ISO-8859-1\r\n";
				$header .= "Content-Transfer-Encoding: quoted-printable\r\n";
				$header .= "Message-ID: <" .time(). " 777horus@gmail.com>\r\n";
				$header .= "X-Mailer: PHP v" .phpversion(). "\r\n\r\n";	
				
				$mailbody = "Sie haben soeben f&uuml;r "
						   .$_SESSION['Verwendungszweck']." "
						   .$_SESSION['Betrag']." ".$_SESSION['Einheit']
						   ." an ".$_SESSION['Empfaenger']
						   ." &uuml;berwiesen.<br>"
						   .$_SESSION['Empfaenger']
						   ." wird per Mail bzw. SMS von Ihrer &Uuml;berweisung informirt.<br><br>"
						   ."Mit freundlichen Gr&uuml;&szlig;en<br><br>"
						   ."Ihr GutscheinTauschSystem  Team GuTauS<br><br>"
						   . "http://www.horus777.bplaced.net/gutaus/mobile";
						   
				
				if(@mail($_SESSION['Email'], $titel, $mailbody, $header)){ // Email senden
				  $send_back.= 'Eine Überweisungs-Info-Mail wurde an ihre Emailadresse ('.$_SESSION['Email'].') gesendet!\n';
				  //$send_back.= $mailbody;
				}
				// Im Fehlerfall wird die Mailadresse des Webmasters für den direkten Versandt eingeblendet
				else {
					$send_back.= 'Beim Senden der Überweisungs-Info-Mail an '.$_SESSION['Email'].' trat ein Fehler auf.\n'.
						 'Bitte wenden Sie sich direkt an den <a href=\"mailto:777horus@gmail.com\">Webmaster</a>.\n';
				}   
			}
			else {
				$send_back.= 'Hinweis: Ihre Emailadresse ist uns leiter nicht bekannt, daher konnten wir Ihnen keine Überweisungs-Info-Mail zusenden!\n'
							.'Bitte verfollständigen Sie Ihre GuTauS-Profiel mit Ihrer Emailadresse sobalt wie möglich.\n'
							.'Dies erhöt Ihre eingen Sicherheit, da wir Sie dann in Zukunft per Mail über Ihre Kontobewegungen Informieren können!\n';
			}	 
		 
//Empfänger informieren ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			// E-Mal an Empfänger senden
			if ($_SESSION['Ueberweisungsart']=="email") { 

				$titel = $_SESSION['user_name']." hat Ihnen ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." überwiesen !";
				/*
				$header = "Content-Type:text/html\r\n"; // HTML Mail
				$header .= "From: info@HORUS777.Net\r\n";
				$header .= "Mime-Version: 1.0 Content-Type: text/plain; charset=ISO-8859-1 Content-Transfer-Encoding: quoted-printable\r\n";
				*/
				$header  = "From: GutscheinTauschSystem<777horus@gmail.com>\r\n";
				$header .= "Reply-To: GutscheinTauschSystem GuTauS<777horus@gmail.com>\r\n"; //Bei Antwort
				$header .= "Return-Path: 777horus@gmail.com\r\n"; // Bei Unzustellbarkeit
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-Type:text/html; charset=ISO-8859-1\r\n";
				$header .= "Content-Transfer-Encoding: quoted-printable\r\n";
				$header .= "Message-ID: <" .time(). " 777horus@gmail.com>\r\n";
				$header .= "X-Mailer: PHP v" .phpversion(). "\r\n\r\n";	

				// info $mailbody mit Passwort 
				if ($_SESSION['send_Passwort']) { // info $mailbody mit Passwort ==> Neues Mitglied! 
					// Info Email an $Empfaengeemail (Neues Mitglied) mit der Bitte sich einzulogen.
					$mailbody = $_SESSION['user_name']." hat Ihnen f&uuml;r "
							   .$_SESSION['Verwendungszweck']." "
							   .$_SESSION['Betrag']." ".$_SESSION['Einheit']
							   ." &uuml;berwiesen, "
							   ."um mit Ihren ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." Waren und Dienstleistungen zu kaufen " 
							   ."loggen Sie sich bitte unter http://www.horus777.bplaced.net/gutaus/mobile ein. <br>"
							   ."Ihre Zugangsdaten:<br>"
							   ."Nickname: ".$_SESSION['Nickname_Empfaenger']."  <br>"
							   ."Passwort: ".$_SESSION['Passwort_Empfaenger']."  <br><br>"
							   ."Achtung: Wenn sie Sich nicht Inerhalb von 30 Tagen einloggen verf&auml;llt Ihre ".$_SESSION['Betrag']." ".$_SESSION['Einheit']."-Akzeptanz !!!<br><br>"
							   ."Mit freundlichen Gr&uuml;&szlig;en<br><br>"
							   ."Ihr GutscheinTauschSystem  Team GuTauS";
				

				}
				else { // info $mailbody ohne Passwort	
					$mailbody = $_SESSION['user_name']." hat Ihnen f&uuml;r "
								.$_SESSION['Verwendungszweck']." "
								.$_SESSION['Betrag']." ".$_SESSION['Einheit']
								." &uuml;berwiesen, "
							   ."um mit Ihren ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." andere Waren und Dienstleistungen zu kaufen " 
							   ."loggen Sie sich bitte unter http://www.horus777.bplaced.net/gutaus/mobile ein. <br><br>"
							   ."Mit freundlichen Gr&uuml;&szlig;en<br><br>"
							   ."Ihr GutscheinTauschSystem  Team GuTauS";	
				}
				
				if(@mail($_SESSION['Email_Empfaenger'], $titel, $mailbody, $header)){
				  $send_back.= $_SESSION['Empfaenger'].' wurde per Email ('.$_SESSION['Email_Empfaenger'].') von Ihrer '.$_SESSION['Einheit'].' Überweisung informiert./n/n\n';
				  
				  //$send_back.= $mailbody;
				}
				// Im Fehlerfall wird die Mailadresse des Webmasters für den direkten Versandt eingeblendet
				else {
					$send_back.= 'Beim Senden der Info-Email an '.$_SESSION['Email_Empfaenger'].' trat ein Fehler auf./n\n'.
						 'Bitte wenden Sie sich direkt an den <a href=\"mailto:777horus@gmail.com\">Webmaster</a>.\n';
				}   
				
			}

			// SMS an Empfänger senden
			elseif ($_SESSION['Ueberweisungsart']=="mobile") { 

				if ($_SESSION['send_Passwort']) { // info SMS mit Passwort ==> Neues Mitglied! 
					// Info SMS Mitglied $An_HandyNummer
					$Text="Sie haben ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." von ".$_SESSION['user_name']." erhalten."
						."*VerwZweck=\"".$_SESSION['Verwendungszweck']."\""
						."*Ihr Bebutzername: \"".$_SESSION['Nickname_Empfaenger']."\""
						."*Ihr Paswort: \"".$_SESSION['Passwort_Empfaenger']."\""
						."*LOGIN unter http://www.horus777.bplaced.net/gutaus/mobile";
					sende_SMS("GutscheinTauschSystem",$Text,$_SESSION['Handynummer_Empfaenger'],"basicplus",$_SESSION['Tester_Flag'],"info");
					SMS_Gebuehr($_SESSION['user_id'],$_SESSION['user_name'],$_SESSION['Einheit'],trim($_SESSION['Handynummer_Empfaenger']));
					$send_back.= '\n\nDas GuTauS Mitglied '.$_SESSION['Nickname_Empfaenger'].' ,dessen Handynummer '
							.$_SESSION['Handynummer_Empfaenger']. ' lautet, hat Ihre Überweisung erhalten\n'
							.'und wird per SMS von Ihre '.$_SESSION['Einheit'].' Überweisung ('
							.$_SESSION['Betrag'].' '.$_SESSION['Einheit'].') informiert.\n';
				}
				else { // info SMS ohne Passwort ==> Bekanntes Mitglied! 
					 $_SESSION['Kontostand Empfaenger']=ermittle_Kontostand($_SESSION['ID_Empfaenger'],$_SESSION['Einheit']);
					 $Text="Sie haben ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." von ".$_SESSION['user_name']." erhalten."
							."*VerwZweck=\"".$_SESSION['Verwendungszweck']."\""
							."*Ihr neuer Kontostand: ".$_SESSION['Kontostand Empfaenger']." ".$_SESSION['Einheit']
							."*http://www.horus777.bplaced.net/gutaus/mobile";
					 sende_SMS("GutscheinTauschSystem",$Text,$_SESSION['Handynummer_Empfaenger'],"basicplus",$_SESSION['Tester_Flag'],"info");
					 SMS_Gebuehr($_SESSION['user_id'],$_SESSION['user_name'],$_SESSION['Einheit'],trim($_SESSION['Handynummer_Empfaenger']));
					 $send_back.= '\n\nDas GuTauS Mitglied '.$_SESSION['Nickname_Empfaenger'].' ,dessen Handynummer '
							.$_SESSION['Handynummer_Empfaenger']. ' lautet, hat Ihre Überweisung erhalten\n'
							.'und wird per SMS von Ihrer '.$_SESSION['Einheit'].' Überweisung ('
							.$_SESSION['Betrag'].' '.$_SESSION['Einheit'].') informiert.\n'; 	
				}
				
			}
			// info-E-Mal an Empfänger-Mitglied senden
			elseif ($_SESSION['Ueberweisungsart']=="member" or $_SESSION['Ueberweisungsart']=="known member") {
				$_SESSION['Email_Empfaenger']=ermittle_Email_Mitglied($_SESSION['ID_Empfaenger'],$_SESSION['Tester_Flag']);
				if ($_SESSION['Email_Empfaenger']<>"") { // Email des Empfängers ist bekannt
				
					$titel = $_SESSION['user_name']." hat Ihnen ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." überwiesen !";

					$header  = "From: GutscheinTauschSystem<777horus@gmail.com>\r\n";
					$header .= "Reply-To: GutscheinTauschSystem GuTauS<777horus@gmail.com>\r\n"; //Bei Antwort
					$header .= "Return-Path: 777horus@gmail.com\r\n"; // Bei Unzustellbarkeit
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-Type:text/html; charset=ISO-8859-1\r\n";
					$header .= "Content-Transfer-Encoding: quoted-printable\r\n";
					$header .= "Message-ID: <" .time(). " 777horus@gmail.com>\r\n";
					$header .= "X-Mailer: PHP v" .phpversion(). "\r\n\r\n";	
					
					$mailbody = $_SESSION['user_name']." hat Ihnen f&uuml;r "
							   .$_SESSION['Verwendungszweck']." "
							   .$_SESSION['Betrag']." ".$_SESSION['Einheit']
							   ." &uuml;berwiesen, "
							   ."um mit Ihren ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." andere Waren und Dienstleistungen zu kaufen " 
							   ."loggen Sie sich bitte unter http://www.horus777.bplaced.net/gutaus/mobile ein. <br><br>"
							   ."Mit freundlichen Gr&uuml;&szlig;en<br><br>"
							   ."Ihr GutscheinTauschSystem  Team GuTauS";
					
					if(@mail($_SESSION['Email_Empfaenger'], $titel, $mailbody, $header)){ // Email senden
					  $send_back.= $_SESSION['Empfaenger'].' wurde per Email von Ihrer '.$_SESSION['Einheit'].' Überweisung informiert.\n';
					  //$send_back.= $mailbody;
					}
					// Im Fehlerfall wird die Mailadresse des Webmasters für den direkten Versandt eingeblendet
					else {
						$send_back.= 'Beim Senden der Info-Email an '.$_SESSION['Email_Empfaenger'].' trat ein Fehler auf.\n'.
							 'Bitte wenden Sie sich direkt an den <a href=\"mailto:777horus@gmail.com\">Webmaster</a>.\n';
					}   
				}
				else {
					$send_back.= 'Hinweis: Die Emailadresse des Emfängers ist uns nicht bekannt, daher konnten wir den Emfänger nicht von Ihrer Überweisung informieren!\n';
				}
				
			}

					
//Erfolgsmeldung anzeigen +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++          
				$_SESSION['Kontostand']=$_SESSION['Kontostand']-str_replace(",", ".",trim($_SESSION['Betrag']));        
				$send_back.= 'VIELEN DANK!\n';
				$send_back.='Ihr Überweisung von '.trim($_SESSION['Betrag']).' '.$_SESSION['Einheit'].' an '.$_SESSION['Nickname_Empfaenger'].' wurde ERFOLGREICH ausgeführt.\n'.
					 'Ihr neuer Kontostand beträgt nun '.mysql_real_escape_string($_SESSION['Kontostand']).' '.$_SESSION['Einheit'].'.\n';
					 
			$send_back.='"';
			$send_back.='}';
		}			 

//Misserfog melden +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		else { // Überweisung nicht möglich ==> generiere Fehlerausgabe
//   Mißerfolgsmeldungen anzeigen +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$send_back='{"errors":';	
			$send_back.='[';
			
			 $i=1;     
			 foreach($errors as $error) {
				 $send_back.= '"'.$i.'.) '.$error.'\n",';
				 $i+=1;
			 }
			 if (substr($send_back, -1, 1)==',') { // if last character is a comma. This is the case is at least one creditnote was found.
				$send_back = substr($send_back, 0, -4); // delete the last character (a comma) and \n"
				$send_back.='"'; // add json String end-sign a "
			}
			
			 $send_back.=']';
			 $send_back.='}';
		}
		
 
		
//Bezahldaten leeren ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$_SESSION['Betrag']='';
		$_SESSION['Empfaenger']='';
		$_SESSION['Nickname_Empfaenger']='';
		$_SESSION['Email_Empfaenger']='';
		$_SESSION['Kontostand Empfaenger']='';
		$_SESSION['Handynummer_Empfaenger']='';
		$_SESSION['Verwendungszweck']='';
		$_SESSION['ID_Empfaenger']='';
		$_SESSION['Passwort_Empfaenger']='';
		$_SESSION['Ueberweisungsart']='';
		$_SESSION['send_Passwort']=false;
		

	}
//logtout melden ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	else { // is logtout
		$send_back="{login:logtout}";
	}
	
//Antwort für user geben +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	echo $send_back;
	

?>