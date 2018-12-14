<?php 
    //SESSION
    session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>


<script>
	$(document).ready(function(){
		$("#kontostanzanzeige").load("include_0_kontostand.php");
	});		
</script>	

<?php

// Ermittle Emfänger_ID

$_SESSION['ID_Empfaenger']=ermittle_Empfaenger_ID($_SESSION['Empfaenger'],$_SESSION['Tester_Flag']);

// falls nötig neues Mitglied und dessen Horus-Konten registrieren

if (!$_SESSION['ID_Empfaenger']) { // Empfänger noch nicht in DB

	$_SESSION['Nickname_Empfaenger']=getnickname();
	$_SESSION['Passwort_Empfaenger']=getpasswort();
	
    // neues Mitglied registrieren
	$_SESSION['ID_Empfaenger']=neues_Mitglied_registrieren($_SESSION['Nickname_Empfaenger'],
															$_SESSION['Email_Empfaenger'],
															$_SESSION['Handynummer_Empfaenger'],
															$_SESSION['Passwort_Empfaenger'],
															$_SESSION['Tester_Flag']);	
	
	// Horus Konto eröffnen
	eroeffne_konto ($_SESSION['ID_Empfaenger'],-20,"Horus",ermittle_Einheit_max_Akzeptanz_Standard("Horus"));
	// Euro Konto eröffnen
	eroeffne_konto ($_SESSION['UserID'],0,"Euro",ermittle_Einheit_max_Akzeptanz_Standard("Euro"));
	// g Gold Konto eröffnen
	eroeffne_konto ($_SESSION['UserID'],0,"g Gold",ermittle_Einheit_max_Akzeptanz_Standard("g Gold"));
	// g Silber Konto eröffnen
	eroeffne_konto ($_SESSION['UserID'],0,"g Silber",ermittle_Einheit_max_Akzeptanz_Standard("g Silber"));	
	$_SESSION['send_Passwort']=true;


}
else { // Empfänger ist in DB
	$_SESSION['Nickname_Empfaenger']=ermittle_Nickname($_SESSION['ID_Empfaenger']);
}



// Überweisung in die DB-Tabelle ueberweisungen einfügen und Empfänger-Konto eröffen falls nötig
    schreibe_Buchungsatz($_SESSION['UserID'],
                         $_SESSION['Nickname'],
                         str_replace(",", ".",trim($_SESSION['Betrag'])),
                         $_SESSION['Einheit'],
                         mysql_real_escape_string(trim($_SESSION['Verwendungszweck'])),
                         $_SESSION['ID_Empfaenger'],
                         mysql_real_escape_string(trim($_SESSION['Nickname_Empfaenger'])),
                         $_SESSION['Ueberweisungsart']);
             
 

//  Empfänger informieren
// E-Mal an Empfänger senden
if ($_SESSION['Ueberweisungsart']=="Email") { 

	$titel = $_SESSION['Nickname']." hat Ihnen ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." überwiesen !";
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
		$mailbody = $_SESSION['Nickname']." hat Ihnen ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." &uuml;berwiesen, "
				   ."um mit Ihren ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." Waren und Dienstleistungen zu kaufen " 
				   ."loggen Sie sich bitte unter http://www.horus777.bplaced.net/gutaus ein. <br>"
				   ."Ihre Zugangsdaten:<br>"
				   ."Nickname: ".$_SESSION['Nickname_Empfaenger']."  <br>"
				   ."Passwort: ".$_SESSION['Passwort_Empfaenger']."  <br><br>"
				   ."Achtung: Wenn sie Sich nicht Inerhalb von 30 Tagen einloggen verf&auml;llt Ihre ".$_SESSION['Betrag']." ".$_SESSION['Einheit']."-Akzeptanz !!!<br><br>"
				   ."Mit freundlichen Gr&uuml;&szlig;en<br><br>"
				   ."Ihr GutscheinTauschSystem  Team GuTauS";
	

	}
	else { // info $mailbody ohne Passwort	
		$mailbody = $_SESSION['Nickname']." hat Ihnen ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." &uuml;berwiesen, "
				   ."um mit Ihren ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." andere Waren und Dienstleistungen zu kaufen " 
				   ."loggen Sie sich bitte unter http://www.horus777.bplaced.net/gutaus ein. <br><br>"
				   ."Mit freundlichen Gr&uuml;&szlig;en<br><br>"
				   ."Ihr GutscheinTauschSystem  Team GuTauS";	
	}
	
	if(@mail($_SESSION['Email_Empfaenger'], $titel, $mailbody, $header)){
	  echo $_SESSION['Empfaenger']." wurde per Email (".$_SESSION['Email_Empfaenger'].") von Ihrer ".$_SESSION['Einheit']." &Uuml;berweisung informiert.<br><br>\n";
	  
	  //echo $mailbody;
	}
	// Im Fehlerfall wird die Mailadresse des Webmasters für den direkten Versandt eingeblendet
	else {
		echo "Beim Senden der Info-Email an ".$_SESSION['Email_Empfaenger']." trat ein Fehler auf.<br>\n".
			 "Bitte wenden Sie sich direkt an den <a href=\"mailto:777horus@gmail.com\">Webmaster</a>.\n";
	}   
	
}

// SMS an Empfänger senden
elseif ($_SESSION['Ueberweisungsart']=="Handy") { 

	if ($_SESSION['send_Passwort']) { // info SMS mit Passwort ==> Neues Mitglied! 
		// Info SMS Mitglied $An_HandyNummer
		$Text="Sie haben ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." von ".$_SESSION['Nickname']." erhalten."
			."*VerwZweck=\"".trim($_SESSION['Verwendungszweck'])."\""
			."*Ihr Bebutzername: \"".$_SESSION['Nickname_Empfaenger']."\""
			."*Ihr Paswort: \"".$_SESSION['Passwort_Empfaenger']."\""
			."*LOGIN unter http://www.horus777.bplaced.net/gutaus";
		sende_SMS("GutscheinTauschSystem",$Text,$_SESSION['Handynummer_Empfaenger'],"basicplus",$_SESSION['Tester_Flag'],"info");
		SMS_Gebuehr($_SESSION['UserID'],$_SESSION['Nickname'],$_SESSION['Einheit'],trim($_SESSION['Handynummer_Empfaenger']));
		echo "<br><br>Das GuTauS Mitglied <b>".$_SESSION['Nickname_Empfaenger']."</b> ,dessen Handynummer <b>"
				.$_SESSION['Handynummer_Empfaenger']. "</b> lautet, hat Ihre &Uuml;berweisung erhalten<br>"
				."und wird per SMS von Ihre ".$_SESSION['Einheit']." &Uuml;berweisung (<b>"
				.$_SESSION['Betrag']." ".$_SESSION['Einheit']."</b>) informiert.<br>";
	}
	else { // info SMS ohne Passwort ==> Bekanntes Mitglied! 
		 $_SESSION['Kontostand Empfaenger']=ermittle_Kontostand($_SESSION['ID_Empfaenger'],$_SESSION['Einheit']);
		 $Text="Sie haben ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." von ".$_SESSION['Nickname']." erhalten."
				."*VerwZweck=\"".trim($_SESSION['Verwendungszweck'])."\""
				."*Ihr neuer Kontostand: ".$_SESSION['Kontostand Empfaenger']." ".$_SESSION['Einheit']
				."*http://www.horus777.bplaced.net/gutaus";
		 sende_SMS("GutscheinTauschSystem",$Text,$_SESSION['Handynummer_Empfaenger'],"basicplus",$_SESSION['Tester_Flag'],"info");
		 SMS_Gebuehr($_SESSION['UserID'],$_SESSION['Nickname'],$_SESSION['Einheit'],trim($_SESSION['Handynummer_Empfaenger']));
		 echo "<br><br>Das GuTauS Mitglied <b>".$_SESSION['Nickname_Empfaenger']."</b> ,dessen Handynummer <b>"
				.$_SESSION['Handynummer_Empfaenger']. "</b> lautet, hat Ihre &Uuml;berweisung erhalten<br>"
				."und wird per SMS von Ihre ".$_SESSION['Einheit']." &Uuml;berweisung (<b>"
				.$_SESSION['Betrag']." ".$_SESSION['Einheit']."</b>) informiert.<br>"; 	
	}
	
}
// info-E-Mal an Empfänger-Mitglied senden
elseif ($_SESSION['Ueberweisungsart']=="Mitglied") {
	$_SESSION['Email_Empfaenger']=ermittle_Email_Mitglied($_SESSION['ID_Empfaenger'],$_SESSION['Tester_Flag']);
	if ($_SESSION['Email_Empfaenger']<>"") { // Email des Empfängers ist bekannt
	
		$titel = $_SESSION['Nickname']." hat Ihnen ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." überwiesen !";

		$header  = "From: GutscheinTauschSystem<777horus@gmail.com>\r\n";
		$header .= "Reply-To: GutscheinTauschSystem GuTauS<777horus@gmail.com>\r\n"; //Bei Antwort
		$header .= "Return-Path: 777horus@gmail.com\r\n"; // Bei Unzustellbarkeit
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type:text/html; charset=ISO-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: quoted-printable\r\n";
		$header .= "Message-ID: <" .time(). " 777horus@gmail.com>\r\n";
		$header .= "X-Mailer: PHP v" .phpversion(). "\r\n\r\n";	
		
		$mailbody = $_SESSION['Nickname']." hat Ihnen ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." &uuml;berwiesen, "
				   ."um mit Ihren ".$_SESSION['Betrag']." ".$_SESSION['Einheit']." andere Waren und Dienstleistungen zu kaufen " 
				   ."loggen Sie sich bitte unter http://www.horus777.bplaced.net/gutaus ein. <br><br>"
				   ."Mit freundlichen Gr&uuml;&szlig;en<br><br>"
				   ."Ihr GutscheinTauschSystem  Team GuTauS";
		
		if(@mail($_SESSION['Email_Empfaenger'], $titel, $mailbody, $header)){ // Email senden
		  echo $_SESSION['Empfaenger']." wurde per Email von Ihrer ".$_SESSION['Einheit']." &Uuml;berweisung informiert.<br><br>\n";
		  //echo $mailbody;
		}
		// Im Fehlerfall wird die Mailadresse des Webmasters für den direkten Versandt eingeblendet
		else {
			echo "Beim Senden der Info-Email an ".$_SESSION['Email_Empfaenger']." trat ein Fehler auf.<br>\n".
				 "Bitte wenden Sie sich direkt an den <a href=\"mailto:777horus@gmail.com\">Webmaster</a>.\n";
		}   
	}
	else {
		echo "Hinweis: Die Emailadresse des Emf&auml;ngers ist uns nicht bekannt, daher konnten wir den Emf&auml;nger nicht von Ihrer &Uuml;berweisung informieren!<br>\n";
	}
	
}



 
			
// Erfolgsmeldung anzeigen           
    $_SESSION['Kontostand']=$_SESSION['Kontostand']-str_replace(",", ".",trim($_SESSION['Betrag']));        
    echo "Vielen Dank!\n<br>".
         "Ihr &Uuml;berweisung von <b>".trim($_SESSION['Betrag'])." ".$_SESSION['Einheit']." an ".$_SESSION['Nickname_Empfaenger']."</b> wurde erfolgreich ausgef&uuml;hrt.\n<br>".
         "Ihr <b>neuer Kontostand betr&auml;gt nun ".mysql_real_escape_string($_SESSION['Kontostand'])." ".$_SESSION['Einheit']."</b>
		 <br>
		 <br>
		 <br>";
         
 // Bezahldaten leeren
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
	
    // Weiterleitung("index.php",0);   


   include("include_5_kontoauszug.php");	
?>
