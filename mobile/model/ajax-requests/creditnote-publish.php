<?php
   //SESSION
    session_start();
	include_once('../includes/include_0_db_conection.php');
	include_once('../includes/funktionen.php');
	
	if ($_SESSION["login"]==1) { // is logtin
	
		$_SESSION['creditnote-publish-type'] = trim(mysql_real_escape_string($_REQUEST['creditnote_type']));		
		$_SESSION['creditnote_publish_name'] = trim(mysql_real_escape_string($_REQUEST['creditnotename_input']));
		$_SESSION['creditnote_publish_value'] = trim(mysql_real_escape_string($_REQUEST['creditnote_value_textarea']));
		$_SESSION['creditnote_publish_credit_limit_user']  = abs(mysql_real_escape_string($_REQUEST['user_credit_limit_input']))*(-1);
		$_SESSION['creditnote_publish_credit_limit_member'] = abs(mysql_real_escape_string($_REQUEST['member_credit_limit_input']))*(-1);
		$_SESSION['creditnote-publish_digits'] = abs(mysql_real_escape_string($_REQUEST['creditnote_digits_input']));
		$_SESSION['creditnote_publish_privat'] = trim(mysql_real_escape_string($_REQUEST['creditnote_privat_checkbox']));
		
		
		
		
//***************************************************************************************************************************************************************
// PRÜFE HERAUSGABE MÖGLICH************************************************************************************************************************************
//***************************************************************************************************************************************************************		
		include_once('../includes/creditnote-publish-check.php');

//echo "after check:  ";			
//echo "user=".$_SESSION['creditnote_publish_credit_limit_user']."/n";	
//echo "member=".$_SESSION['creditnote_publish_credit_limit_member']."/n";	
//echo "digits=".$_SESSION['creditnote-publish_digits']."/n";
//echo "privat=".$_SESSION['creditnote_publish_privat']."/n";
//echo "Nickname_Empfaenger=".$_SESSION['Nickname_Empfaenger']."/n";	

//***************************************************************************************************************************************************************
// DB EINTRÄGE SENDEN, INFO MAILS BZW. SMS SENDEN UND RÜGMELDUNG AN USER ZURÜCKGEBEN **************************************************************************
//***************************************************************************************************************************************************************		
		if (count($errors)==0) { // Herausgabe ist möglich ==> Gutschein Herausgeben
			$send_back='{"msg":"';	
// neuen Gutschein in DB anlegen ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
			
					$ID_Creditnote=lege_an_einheit ($_SESSION['user_id'],
									$_SESSION['creditnote_publish_name'],
									$_SESSION['creditnote-publish-type'], // Minuto, Service , Euro, Goods
									$_SESSION['creditnote-publish_digits'],
									$_SESSION['creditnote_publish_value'],
									$_SESSION['creditnote_publish_credit_limit_user']*(-1), // max Akzeptanz Standard = alle die maximal herauggegeben wurden *(-1) um positiven Wert zu erhalten
									$_SESSION['creditnote_publish_credit_limit_member'], // 	max Ueberziehung Standard
									$_SESSION['creditnote_publish_privat']
								);
// $_SESSION['creditnote_publish_name'] Konto für User eröffnen +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				eroeffne_konto ($_SESSION['user_id'],$_SESSION['creditnote_publish_credit_limit_user'],$_SESSION['creditnote_publish_name'],"0"); // 0 weil keien mehr akzeptieren als mann selbst herausgab
				
			
			
	
			
//User informieren ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			 
		 	 
			if ($_SESSION['Email']<>"") { // Email des Users ist bekannt
			
				$titel = "Glueckwunsch, zur Herausgabe Ihres eigenen ".$_SESSION['creditnote_publish_name']."-Gutscheines!";

				$header  = "From: GutscheinTauschSystem<777horus@gmail.com>\r\n";
				$header .= "Reply-To: GutscheinTauschSystem GuTauS<777horus@gmail.com>\r\n"; //Bei Antwort
				$header .= "Return-Path: 777horus@gmail.com\r\n"; // Bei Unzustellbarkeit
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-Type:text/html; charset=ISO-8859-1\r\n";
				$header .= "Content-Transfer-Encoding: quoted-printable\r\n";
				$header .= "Message-ID: <" .time(). " 777horus@gmail.com>\r\n";
				$header .= "X-Mailer: PHP v" .phpversion(). "\r\n\r\n";	
				
				$mailbody = "Hallo ".$_SESSION["user_name"].","
							."<br><br>"
							."Sie sind nun Herausgeber Ihres eigenen <b>".$_SESSION['creditnote_publish_name']."-Gutscheines</b>."
							."<br><br>"
							."<b>IHRE FESTLEGUNGEN ZUM ".$_SESSION['creditnote_publish_name']."-Gutschein:</b>"
							."<br>"
							."<b>1.)</b> Wir haben Ihnen daher bei <b>GuTauS</b> ein ".$_SESSION['creditnote_publish_name']."-Konto angelegt."
							."Da Sie bei der Erstellung Ihrer Gutscheine angegeben haben, dass Sie <b>maximal ".($_SESSION['creditnote_publish_credit_limit_user']*-1)." ".$_SESSION['creditnote_publish_name']."-Gutscheine</b> heraus geben wollen, "
							."<b>k&ouml;nnen Sie Ihr Konto bis zu ".$_SESSION['creditnote_publish_credit_limit_user']." ".$_SESSION['creditnote_publish_name']."-Gutscheine &uuml;berziehen</b>."
							."Sie zahlen selbsverst&auml;ndlich <b>keinerlei Zinsen f&uuml;r diese &Uuml;berziehung!</b> "
							."An der jeweils aktuellen H&ouml;he ihrer Konto&uuml;berziehung k&ouml;nnen Sie jeterzeit erkennen wie viele Ihrer Gutscheine Sie derzeit selbst herausgegeben haben."
							."<br><br>"
							."<b>2.)</b> Wie gew&uuml;nscht f&uuml;hren wir Ihr <b>".$_SESSION['creditnote_publish_name']."-Konto auf ".$_SESSION['creditnote-publish_digits']." Nachkommastellen</b> genau."
							."<br><br>"
							."<b>3.)</b> Sie haben den Wert eines Ihrer  ".$_SESSION['creditnote_publish_name']."-Gutscheine wie folt definiert:"
							."<br><br>"
							."<b>"
							."Wert eines Ihrer ".$_SESSION['creditnote_publish_name']."-Gutscheine: "
							."<br>"
							.$_SESSION['creditnote_publish_value']	
							."</b>"						   
							."<br><br>";
							if ($_SESSION['creditnote_publish_privat']=='true'){ // not privat
									$mailbody.= "<b>4.)</b> Ihr Gutschein ist ein privater Gutschein. Besitzer Ihers Gutscheines k&ouml;nnen damit nur GuTauS-Mitglieder bezaheln, "
												."denen Sie selbst durch eine Erst&uuml;berweisung ein ".$_SESSION['creditnote_publish_name']."-Konto er&ouml;ffnet haben!"
												;
							}
							else {
									$mailbody.= "<b>4.)</b> Ihr Gutschein ist ein &ouml;ffentlicher Gutschein. Besitzer Ihers Gutscheines k&ouml;nnen damit jedes GuTauS-Mitglieder, ja sogar an jede "
												." Emailadresse und an jede Handynummer bezaheln. "
												."<br>"
												."Es kann also sein, dass Menschen in den Besitz Ihres Gutscheines kommenen, die Ihnen v&ouml;llig unbekant sind."
												."Auch diesen unbekannten Menschen gegen&uuml;ber haben Sie sich verpflichtet Ihre ".$_SESSION['creditnote_publish_name']." Gutscheine einzul&ouml;sen."
												;
							}
				$mailbody.="<br><br><br>";
				$mailbody.="<b>BEMERKUNGEN:</b>"
						   ."<br>"
						   ."<b>1.)</b> Sie k&ouml;nnen nun mit Ihren ".$_SESSION['creditnote_publish_name']."-Gutscheinen an jede belibige Emailadresse oder Handynummer "
						   ."und nat&uuml;rlich auch an jedes GuTauS-Mitglied bezahlen. Sollte der Empf&auml;nger Ihrer Gutscheine noch kein "
						   .$_SESSION['creditnote_publish_name']."-Konto besitzen, so wird dem Empf&auml;nger ein soches Konto automatisch angelegt. Anderseits kann jeder Besitzer Ihrer  "
						   .$_SESSION['creditnote_publish_name']."-Gutscheine Sie und auch andere mit Ihren Gutscheinen bezahlen."
						   ."<br><br>"
						   ."<b>2.)</b> Sie l&ouml;sen beim R&uuml;ckerhalt f&uuml;r jeden erhaltenen Gutschein folgendes ein:"
						   ."<br><br>"	
						   ."<b>".$_SESSION['creditnote_publish_value']."</b>"	
						   ."<br><br>"
						   ."<b>3.)</b> Mit der R&uuml;ckgabe Ihres herausggegeben  ".$_SESSION['creditnote_publish_name']."-Gutscheinenes hat sich der Kreislauf Ihres Gutscheines geschlossen und Sie konnten ohne Geld bezahlen und sind ohne Geld mit Ihren eigenen "
						   .$_SESSION['creditnote_publish_name']."-Gutscheinen bezahlt worden."
						   ."<br><br>"
							."<b>4.)</b> Und denken Sie daran nicht Sie bestimmen ob Ihr Gutschein gerne angenommen wird, sondern die Menschen die bereit sind diesen "
							."anzunehmen. Diese Menschen vertrauen darauf, dass Sie als Gutscheinherausgeber jeden Ihrer Gutscheine zu den von Ihnen bestimmeten Wert einl&ouml;sen. "
							."St&auml;rken Sie dieses Vertrauen durch Ihr Handeln bei R&uuml;ckerhalt Ihrer ".$_SESSION['creditnote_publish_name']."-Gutscheine. "
							."So werden Ihre Gutschein weite Verbreitung finden und gerne gesehen sein.";

				$mailbody.="<br><br><br>";
				$mailbody.= "<b>WICHTIGER HINWEIS:</b>";
				$mailbody.= "<br>";
				if ($_SESSION['creditnote_publish_credit_limit_member']==0) {
						$mailbody.= "Sie sind und bleiben bei GuTauS der alleinige <b>verantwortliche Herausgeber</b> des ".$_SESSION['creditnote_publish_name']."-Gutscheines."
									."<br>"
									."Alle sich bei GuTauS im Umlauf befindlichen ".$_SESSION['creditnote_publish_name']."-Gutscheine werden von Ihnen selbst in den Umlauf gebracht!"
									."<br>"
									."Sie allein tragen alle rechtlichen, moralischen u. ethischen Verpflichtungen und auch die volle Verantwortung f&uuml;r alle  bei GuTauS im Umlauf befindliche ".$_SESSION['creditnote_publish_name']."-Gutscheine."
									;
				}
				else {
						$mailbody.= "Sie sind und bleiben der <b>verantwortliche Herausgeber</b> des ".$_SESSION['creditnote_publish_name']."-Gutscheines, "
									."aber Sie sind <b>nicht</b> der alleinige Herausgeber des ".$_SESSION['creditnote_publish_name']."-Gutscheines bei GuTauS."
									."<br>"
									."Sie gestatten jeden Besitzer eines ".$_SESSION['creditnote_publish_name']."-Kontos bis zu "
									.abs($_SESSION['creditnote_publish_credit_limit_member'])." ".$_SESSION['creditnote_publish_name']."-Gutscheine durch zinslose Konto&uuml;berziehung in den Umlauf zu bringen."
									."<br>"
									."Letzten Endes tragen Sie als <b>verantwortliche Herausgeber</b> aber alle rechtlichen, moralischen u. ethischen Verpflichtungen und auch die volle Verantwortung f&uuml;r alle  bei GuTauS im Umlauf befindliche ".$_SESSION['creditnote_publish_name']."-Gutscheine."
									.$_SESSION['creditnote_publish_name']."-Kontoinhaber, die Ihre Gutscheine "
									."durch die von Ihnen einger&aumlumte zinslose Konto&uumlberziehung ebenfalls in den Umlauf gebracht haben, sind nur Ihnen gegen&uuml;ber "
									."zum Kontoausgleich moralisch und ethisch jedoch nicht rechtlich verpflichtet oder verantwortlich."
									;
				}
				
				$mailbody .=  "<br><br><br><br>"
						   
						   
						   ."Mit freundlichen Gr&uuml;&szlig;en<br><br>"
						   ."Ihr GutscheinTauschSystem  Team GuTauS<br><br>"
						   . "http://www.horus777.bplaced.net/gutaus/mobile";
						   
				
				if(@mail($_SESSION['Email'], $titel, $mailbody, $header)){ // Email senden
				  $send_back.= 'Eine Gutschein-Herausgabe-Info-Mail wurde an Ihre Emailadresse ('.$_SESSION['Email'].') gesendet!\n';
				  //$send_back.= $mailbody;
				}
				// Im Fehlerfall wird die Mailadresse des Webmasters für den direkten Versandt eingeblendet
				else {
					$send_back.= 'Beim Senden der Gutschein-Herausgabe-Info-Mail an '.$_SESSION['Email'].' trat ein Fehler auf.\n'.
						 'Bitte wenden Sie sich direkt an den <a href=\"mailto:777horus@gmail.com\">Webmaster</a>.\n';
				}   
			}
			else { // Email des Users ist nicht bekannt
				$send_back.= 'Hinweis: Ihre Emailadresse ist uns leiter nicht bekannt, daher konnten wir Ihnen keine Gutschein-Herausgabe-Info-Mail zusenden!\n'
							.'Bitte verfollständigen Sie Ihre GuTauS-Profiel mit Ihrer Emailadresse sobalt wie möglich.\n'
							.'Dies erhöt Ihre eingen Sicherheit, da wir Sie dann in Zukunft per Mail über Ihre Kontobewegungen Informieren können!\n';
			}	 
		 
					
//Erfolgsmeldung anzeigen +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++          
				$_SESSION['Kontostand']=$_SESSION['Kontostand']-str_replace(",", ".",trim($_SESSION['Betrag']));        
				$send_back.= 'VIELEN DANK!\n';
				$send_back.='Wir haben Ihnen ein '.$_SESSION['creditnote_publish_name'].'-Konto angelegt\n'
						  .'und die kouml;nnen nun mit Ihren eigenen '.$_SESSION['creditnote_publish_name'].'-Gutscheinen bezahlen.';
					 
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
		$_SESSION['creditnote-publish-type'] = '';
		$_SESSION['creditnote_publish_name'] = '';
		$_SESSION['creditnote_publish_value'] = '';
		$_SESSION['creditnote_publish_credit_limit_user']  = '';
		$_SESSION['creditnote_publish_credit_limit_member'] = '';
		$_SESSION['creditnote-publish_digits'] = '';
		$_SESSION['creditnote_publish_privat'] = '';

		

	}
//logtout melden ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	else { // is logtout
		$send_back="{login:logtout}";
	}
	
//Antwort für user geben +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	echo $send_back;
	

?>