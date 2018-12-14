<?php

// FUNKTIONEN**************************************************************************

	function Passwort_OK($User_ID,$Passwort) 
	 // Prüfen, ob Passwort für Nicjnmame OK
	{
	
	    
         $OK=false;
         $sql = "    SELECT
                 Nickname
         FROM
             mitglieder
         WHERE
                 ID = '".mysql_real_escape_string($User_ID)."'
             AND Passwort     = '".md5(mysql_real_escape_string($Passwort))."'
            ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)==1) {
            $row = mysql_fetch_assoc($result);
            $OK=true;
        }
        
     return $OK;
	
	
	}

	function neues_Mitglied_registrieren ($Nickname,$Email,$Handynummer,$neuesPasswort,$Tester_Flag) 
	 /* Prüfung von E-Mail-Syntax über reguläre Ausdrücke* --------------------------
     * http://aktuell.de.selfhtml.org/tippstricks/programmiertechnik/email/
     */
	{
	   $sql = "INSERT INTO
				   mitglieder
					(Nickname,
					 Email,
					 Mobilnummer,
					 Passwort,
					 Show_Email,
					 Registrierungsdatum,
					 Tester_Flag
					)
			VALUES
					('".mysql_real_escape_string(trim($Nickname))."',
					 '".mysql_real_escape_string(trim($Email))."',
					 '".mysql_real_escape_string(trim($Handynummer))."',
					 '".mysql_real_escape_string(md5($neuesPasswort))."',
					 '0',
					 CURDATE(),
					 '".mysql_real_escape_string(trim($Tester_Flag))."'
					)
		   ";
		   mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		// Neue Nikname_ID zurück geben
	   return ermittle_Nickname_ID($Nickname);
}
    
    function check_email($email) 
	{
      // RegEx begin
      $nonascii = "\x80-\xff"; # Non-ASCII-Chars are not allowed
     
      $nqtext = "[^\\\\$nonascii\015\012\"]";
      $qchar = "\\\\[^$nonascii]";
     
      $protocol = '(?:mailto:)';
     
      $normuser = '[a-zA-Z0-9][a-zA-Z0-9_.-]*';
      $quotedstring = "\"(?:$nqtext|$qchar)+\"";
      $user_part = "(?:$normuser|$quotedstring)";
     
      $dom_mainpart = '[a-zA-Z0-9][a-zA-Z0-9._-]*\\.';
      $dom_subpart = '(?:[a-zA-Z0-9][a-zA-Z0-9._-]*\\.)*';
      $dom_tldpart = '[a-zA-Z]{2,5}';
      $domain_part = "$dom_subpart$dom_mainpart$dom_tldpart";
     
    $regex = "$protocol?$user_part\@$domain_part";
      // RegEx end
     
      return preg_match("/^$regex$/",$email);
    }
    
 	function getnickname()
	// Gibt einen in der DB noch nicht vorhandenen neuen Nicknamen zurück
	{
      $newnickname = "";
	  // http://www.sagengestalten.de/   Ägyptische Gotter
      $nicknamelist = array("ra","osiris","isis","amun","amset","naunet","phoenix"
	  				,"pacht","reret","reschef","mat","min","mont","mesetet","miysis"
					,"mesektet","saois","asterix"," obelix","idefix","miraculix",
                    "troubadix","majestix","verleihnix","methusalix","zeus"," poseidon",
                    "herakles","morpheus","plutos","agamemnon","hektor","herakles",
                    "odysseus","herkules","perseus");
      mt_srand((double)microtime()*1000000);
      $newnickname= $nicknamelist[mt_rand(0,count($nicknamelist)-1)].mt_rand(1,999);
	  // Test ob $newickname in DB
	  $sql='SELECT `Nickname` FROM mitglieder WHERE `Nickname`='."\"".$newnickname."\"";
	  $result=mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
	  while(mysql_num_rows($result))
	  { // Einen anderen Nickname erzeugen
	  		$newnickname= $nicknamelist[mt_rand(0,count($nicknamelist)-1)].mt_rand(1,999);
			echo "Neuer Nickname:".$newnickname;
			$sql='SELECT `Nickname` FROM mitglieder WHERE `Nickname`='."\"".$newnickname."\"";
			$result=mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
	  }
    return $newnickname;
    }

	/**
	 * Generiert eine ID aus einem bestimmten Satz an Zeichen
	 *
	 * @author	Manuel Bieh, www.manuelbieh.de
	 *
	 * @param    string    Gewünschte Länge der erzeugten ID (optional, default: 11, maximal: 64)
	 * @param    array     Array mit eigenen Zeichen (optional, default: a-zA-Z_)
	 * @return   string    Gibt die erzeugte ID zurück
	*/
	function uniqueID($length=11, $chars='') {

		$length = empty($length) ? 11 : $length;
		$length = $length > 64 ? 64 : $length;

		if(!is_array($chars) || (is_array($chars) && empty($chars))) {
			for($i=65;$i<=90;$i++) {
				$chars[] = chr($i);
			}
			for($i=97;$i<=122;$i++) {
				$chars[] = chr($i);
			}
			$chars[] = '_';
		}

		$c = count($chars);
		for($i=0;$i<$length;$i++) {
			$uid .= $chars[rand(0, $c-1)];
		}
		return $uid;
	}

   	function getpasswort()
	// Gibt einen zufälliges Passwort zurück
	{
      $newpass = "";
      $laenge=6;
      $string="abcdefghijkmnrstuwxyz23456789";
      mt_srand((double)microtime()*1000000);
      for ($i=1; $i <= $laenge; $i++) $newpass .= substr($string, mt_rand(0,strlen($string)-1), 1);
    return $newpass;
	}

	function bereinige_und_schreibe_laenderkennung_0049_vor_handynummer($handynummer)
	{
    $handynummer=preg_replace ("~[^0-9]~", "", $handynummer); //alles außer Ziffern herausnehmen
		if (!preg_match("~^00~",$handynummer)) // Wenn nicht mit 00 beginnt
		{
		  $handynummer="xyz".$handynummer; // xyz voranstelen damit nur vorterer Teil mit 0049 ersetzt wirt
		  $handynummer = str_replace("xyz0", "0049", $handynummer);
		}
	return $handynummer;
	}

	function sende_SMS($from,$Text,$to,$Type,$debug,$SMS_Art)
	{
		$u = "rex"; // Bitte tragen Sie hier Ihren Benutzernamen ein
		$p = "658b735c2aaaa73859de1c8425e8641e"; // Bitte tragen Sie hier Ihre Passwort ein
		// Ihre Benutzerangaben sind für den User nicht sichtbar!
		$url = 'https://gateway.sms77.de/' .
		'?u=' . urlencode($u) .
		'&p=' . urlencode($p) .
		'&to=' . urlencode($to) .
		'&text=' . urlencode($Text) .
		'&type=' . urlencode($Type).
		'&from=' . urlencode($from).  // wirt bei basicPlus SMS nicht gesendet
        '&debug=' . urlencode($debug); // 1 SMS wird nicht gesendet keine kosten oder 0 SMS wird gesendet
		$ret[0]=100;
		$ret = @file($url); // Hier erfolgt der Aufruf des HTTP-APIs mittels
		// Das @ ist erforderlich, damit die URL bei Fehlern nicht
		// ausgegeben wird
		//echo "<br>URL=".$url;
		//echo "<br>SMS Text=".$Text;
		if ($ret[0] == "100")
			if ($SMS_Art=="Freischaltcode")
				echo "<br>Sie erhalten in kürze eine SMS von Horus777.net <br>Bitte geben sie hier den in der SMS erhaltenen Freischaltcode ein, <br>um Ihre Handynummer zu bestätigen.";
			elseif ($SMS_Art=="An_Nicknmae nicht in DB")
				echo "<br>Fehler: Überweisung nicht möglich, weil der An_Nickname nicht in der DB ist";
			else
				echo "<br> An die Handynummer: <b>".$to."</b> wurde per SMS eine Info über Ihre ".$_SESSION['Einheit']." Überweisung gesendet.<br>\n";
		else
			echo "<br> Fehler beim SMS-Versand! Fehlercode: ".$ret[0]; // Fehlercodeausgabe
	return $ret;
    }
    
 	function SMS_Gebuehr($ID,$Nickname,$Einheit,$an_Handynummer) 
	// Derzeit 1 HORUS
	{
	    $Verwendungszweck="Horus777.Net SMS Gebühr für Info-SMS an die Handynummer; ".$an_Handynummer;
		$Horus777_ID="5";
		
		$Gebuehr="1"; // Horus und GuTauS
		switch($Einheit){
              case ("Euro"):
              $Gebuehr="0.10"; // Euro
              break;
             
              case ("g Silber"):
              $Gebuehr="0.10"; // g Silber 
              break;
              
              case ("g Gold"):
              $Gebuehr="0.01"; // g Gold derzeit 40 cent!!
              break;
        }
        
         
		schreibe_Buchungsatz($ID,$Nickname,$Gebuehr,$Einheit,$Verwendungszweck,$Horus777_ID,'Horus777','SMS Gebuehr');
		aendere_Kontostand($ID,"-".$Gebuehr,$Einheit); // Konto von $Nickname mit $Gebuehr belasten
		aendere_Kontostand($Horus777_ID,$Gebuehr,$Einheit); // Konto Horus777 $Gebuehr gutschreiben
	}  
       
    function schreibe_Buchungsatz($von_ID,$von_Nickname,$Betrag,$Einheit,$Verwendungszweck,$an_ID,$an_Nickname,$Art)
	// schreibt einen Buchungssatz und legt ein Einheiten-Konto beim Empfänger an falls noch nicht Vorhanden
	{ 
		// Buchungssatz schreiben
         $sql = "INSERT INTO ueberweisungen
                            (von_ID,
                             von_Nickname,
                             an_ID,
                             an_Nickname,
                             Betrag,
                             Einheit,
                             Verwendungszweck,
                             Art
                            )
                    VALUES
                            ('".$von_ID."',
                             '".$von_Nickname."', 
                             '".$an_ID."',
                             '".$an_Nickname."',
                             '".$Betrag."',
                             '".$Einheit."',
                             '".$Verwendungszweck."',
                             'An ".$Art."'
                            )";
          mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		  
		  
		// Kontostand des Senders in die DB-Tabelle konten updaten
			aendere_Kontostand(mysql_real_escape_string($von_ID),"-".str_replace(",", ".",$Betrag),$Einheit);
								  
		  // Konto anlegen wenn noch nicht Vorhanden
		  $new_account=false;
		  if (!pruefe_Konto_vorhanden($an_ID,$Einheit)) {
			 if (eroeffne_konto ($an_ID,ermittle_Einheit_max_Ueberziehung_Standard($Einheit),$Einheit,ermittle_Einheit_max_Akzeptanz_Standard($Einheit))) {
				$new_account=true;
			 };
			 
		  }
		  
		// Kontostand des Emfängers in die DB-Tabelle konten updaten
			aendere_Kontostand(mysql_real_escape_string($an_ID),str_replace(",", ".",$Betrag),$Einheit);

			if ($new_account) {
				return "new receiver account was opened";
			}
			else {
				return "receiver account already exists";
			}
			
			
		
	} 
	
	function lege_an_einheit ($ID_Mitglied,$Einheit,$Gutschein_Art,$Nachkommastellen,$Definition,$max_Akzeptanz_Standard,$max_Ueberziehung_Standard,$privat_Gutschein) 
	{
		
        $sql = "INSERT INTO
               einheiten
                (ID_Mitglied,
                 Einheit,
				 Nachkommastellen,
                 Definition,
                 max_Akzeptanz_Standard,
				 max_Ueberziehung_Standard,
				 privat_Gutschein,
				 Gutschein_Art
                 )
            VALUES
                 ('".$ID_Mitglied."',
                  '".$Einheit."',
				  '".$Nachkommastellen."',
                  '".$Definition."',
                  '".$max_Akzeptanz_Standard."',
				  '".$max_Ueberziehung_Standard."',
				  '".$privat_Gutschein."',
				  '".$Gutschein_Art."'
                 )
            ";
		//echo "sql=".$sql;
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        $ID_Einheit=ermittle_Einheit_ID($Einheit);
    return $ID_Einheit; 
    }
    
    function ermittle_Einheit_max_Akzeptanz_Standard($Einheit) 
	{

    	$max_Akzeptanz_Standard=0;
    	$sql = "SELECT max_Akzeptanz_Standard FROM einheiten
                WHERE Einheit   ='".$Einheit."'
                ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $max_Akzeptanz_Standard=$row['max_Akzeptanz_Standard'];
        }


    return $max_Akzeptanz_Standard;
	}
	
	function Akzeptanz ($Nickname,$Einheit) 
	// ermittelt zum $Nickname den aktuelle max. Akzeptanz zur $Einheit 
	{
		
		$Akzeptanz=0;
		
		$sql = "SELECT Nickname, (max_Akzeptanz-Kontostand) As Akzeptanz, e.Einheit\n"
				. "FROM `mitglieder` AS m\n"
				. "JOIN konten AS k ON (m.ID = k.ID_Mitglied )\n"
				. "JOIN einheiten AS e ON (e.ID = k.ID_Einheit )\n"
				. "WHERE Nickname = '".mysql_real_escape_string($Nickname)."' AND e.Einheit='".mysql_real_escape_string($Einheit)."' ";
		
		
		$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		$row = mysql_fetch_assoc($result);
		if ($row['Akzeptanz']>0)
			$Akzeptanz=$row['Akzeptanz'];
			
		return $Akzeptanz;
	
	}
	
    function ermittle_Einheit_max_Ueberziehung_Standard($Einheit) 
	{

    	$max_Ueberziehung_Standard=0;
    	$sql = "SELECT max_Ueberziehung_Standard FROM einheiten
                WHERE Einheit   ='".$Einheit."'
                ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $max_Ueberziehung_Standard=$row['max_Ueberziehung_Standard'];
        }


    return $max_Ueberziehung_Standard;
	}
    
	function eroeffne_konto ($UserID,$max_Ueberziehung,$Einheit,$max_Akzeptanz) 
	{
	
		
           $sql = "INSERT INTO
                   konten
                    (ID_Mitglied,
                     max_Ueberziehung,
                     Einheit,
                     ID_Einheit,
                     max_Akzeptanz
                     )
                VALUES
                     ('".mysql_real_escape_string($UserID)."',
                      '".mysql_real_escape_string($max_Ueberziehung)."',
                      '".mysql_real_escape_string($Einheit)."',
					  '".ermittle_Einheit_ID ($Einheit)."',
                      '".mysql_real_escape_string($max_Akzeptanz)."'
                     )
                ";
			//echo "sql=".$sql;
            $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
			
		return true;
     }
	
	function pruefe_ob_Herausger_der_ID_Einheit($ID_Mitglied,$ID_Einheit)
     // Prüfen, ob ein Konto dieser Währungs-Einhat vorhanden ist	 
	{


         $sql = "    SELECT
                 ID
         FROM
             einheiten
         WHERE
                 ID_Mitglied = '".$ID_Mitglied."'
             AND ID     = '".$ID_Einheit."'
            ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $ID_Einheit=$row['ID'];
        }
        else
            $ID_Einheit=0;

    return $ID_Einheit;
    }
		
	 function pruefe_Konto_vorhanden($ID,$Einheit) 
	 // Prüfen, ob ein Konto dieser Währungs-Einhat vorhanden ist
	 {
	 
         $ID_Einheit=0;
         $sql = "    SELECT
                 ID_Einheit
         FROM
             konten
         WHERE
                 ID_Mitglied = '".mysql_real_escape_string($ID)."'
             AND Einheit     = '".mysql_real_escape_string($Einheit)."'
            ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $ID_Einheit=$row['ID_Einheit'];
        }
        
     return $ID_Einheit;
     }
   
    function ermittle_Nickname_ID($Nickname) 
	{

    	$ID=0;
    	$sql = "SELECT ID FROM mitglieder
                WHERE Nickname   ='".$Nickname."'
                ";
        //echo "<br> Nickname ID: ".$Empfaenger;
        //echo "<br> Sql= ".$sql;
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $ID=$row['ID'];
        }


        // echo "Nickname ID :".$ID;

    return $ID;
	}    
     
    function ermittle_Empfaenger_ID($Empfaenger,$Tester_Flag) 
	{
	
    	$ID=0;
    	$sql = "SELECT ID FROM mitglieder
                WHERE Nickname   ='".$Empfaenger."'
                   OR Email      ='".$Empfaenger."'
                   OR Mobilnummer='".$Empfaenger."'
				   AND Tester_Flag='".$Tester_Flag."'
                ";
		// echo "sql=".$sql;
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $ID=$row['ID'];
        }
        
            
    return $ID;
	}
	
    function ermittle_Email_Mitglied($ID_Mitglied,$Tester_Flag) 
	{
	
    	$Email_Mitglied="";
		
		$sql = "SELECT Email FROM mitglieder
                WHERE  ID  ='".$ID_Mitglied."'
						AND Tester_Flag='".$Tester_Flag."'
						";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $Email_Mitglied=$row['Email'];
        }
        
            
    return $Email_Mitglied;
	}
	
	function ermittle_Nickname($ID) 
	{

    	$Nickname=0;
    	$sql = "SELECT Nickname FROM mitglieder
                WHERE  ID  ='".$ID."'
                ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)==1) {
            $row = mysql_fetch_assoc($result);
            $Nickname=$row['Nickname'];
        }

    return $Nickname;
	}
		
	function ermittle_Kontostand($UserID,$Einheit) 
	{
	        $sql = " SELECT Kontostand FROM konten
					 WHERE 
							ID_Mitglied=".$UserID."
					 AND    Einheit='".$Einheit."'";
                           
			$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
			$row = mysql_fetch_assoc($result);
			$ID_Einheit=ermittle_Einheit_ID($Einheit);
			$Nachkommastellen=ermittle_max_Nachkommastellen($ID_Einheit);
            return round($row['Kontostand'], $Nachkommastellen);	
	}
	
	function ermittle_max_Nachkommastellen($ID_Einheit) 
	{
    	$Nachkommastellen=0;
    	$sql = "SELECT Nachkommastellen FROM einheiten
                WHERE ID   ='".$ID_Einheit."'
                ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $Nachkommastellen=$row['ID'];
        }


		return $Nachkommastellen;
	}	
	
	function aendere_Kontostand($ID,$Betrag,$Einheit) 
	//$Betrag kann auch negativ übergeben werden 
	{
	        $sql = " UPDATE 
	        
                     konten
                     
                     SET
                     Kontostand=Kontostand+".$Betrag."
                    ,Gesamtumsatz=Gesamtumsatz+".abs($Betrag)."
                    
                     WHERE
                         ID_Mitglied = ".$ID."
                         AND Einheit     = '".$Einheit."'"
                         ;
                           
         $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
	}

	function Weiterleitung($Ziel,$mm_Sekunden) 
	{
            echo "<script type='text/javascript'>";
            echo "    function Weiterleitung()";
            echo "    {";
            echo "        window.location.href = '".$Ziel."'";
            echo "    }";
            echo "    window.setTimeout('Weiterleitung()', ".$mm_Sekunden.")";
            echo "</script>";      
    }
		
	function aendere_max_Akzeptanz($ID,$max_Akzeptanz,$Einheit) 
	//$Betrag kann auch negativ übergeben werden
	{
		$sql = " UPDATE

				 konten

				 SET
				 max_Akzeptanz=".$max_Akzeptanz."
				 WHERE
					 ID_Mitglied = ".$ID."
					 AND Einheit     = '".$Einheit."'"
					 ;

         $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
	}
	
	function aendere_max_Ueberziehung($ID,$max_Ueberziehung,$Einheit) 
	//$Betrag kann nur negativ übergeben werden oder 0
	{ 

		$sql = " UPDATE

			 konten

			 SET
			 max_Ueberziehung=".$max_Ueberziehung."
			 WHERE
				 ID_Mitglied = ".$ID."
				 AND Einheit     = '".$Einheit."'"
				 ;

		$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		
	}




	
// EINHEIT-FUNKTIONEN++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function privat_Gutschein ($Einheit) 
	// prüft ob ein Gutsschein privat ist
	{
	    
		
		$privat_Gutschein=1;
		//echo "Einheit privat_Gutschein=".$Einheit;
		$sql = "SELECT privat_Gutschein FROM `einheiten`\n"
				. "WHERE einheit='".$Einheit."'";
		//echo "sql privat_Gutschein=".$sql;
		
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $privat_Gutschein=$row['privat_Gutschein'];
        }

    return $privat_Gutschein;	
	
	
	}
	
    function ermittle_Herausgeber_Von_Einheit ($Einheit) {
 	
		$sql = "SELECT Nickname As Herausgeber FROM `einheiten` AS e\n"
				. "INNER Join mitglieder AS m\n"
				. "ON e.ID_Mitglied=m.ID\n"
				. "WHERE e.einheit='".$Einheit."'";
		
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $Herausgeber=$row['Herausgeber'];
        }

    return $Herausgeber;
    }
	
	function ermittle_ID_Herausgeber_Von_Einheit ($Einheit) {
 	
		$sql = "SELECT ID_Mitglied As ID_Herausgeber FROM `einheiten`\n"
				. "WHERE einheit='".$Einheit."'";
		
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $ID_Herausgeber=$row['ID_Herausgeber'];
        }

    return $ID_Herausgeber;
    }
	
    function ermittle_ID_Einheit_Von_ID_Herausgeber ($ID_Herausgeber) {

    	$ID=0;
    	$sql = "SELECT ID FROM einheiten
                WHERE ID_Mitglied   =".$ID_Herausgeber."
                ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $ID=$row['ID'];
        }

    return $ID;
    }
	
    function ermittle_Einheit_ID($Einheit) 
	{

    	$ID=0;
    	$sql = "SELECT ID FROM einheiten
                WHERE Einheit   ='".$Einheit."'
                ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $ID=$row['ID'];
        }


    return $ID;
	}	
	
	
	
	function check_Euro_Gutschein_herausgegeben ($ID_Mitglied) {

    	$euro_Gutschein=0;
    	$sql = "SELECT euro_Gutschein FROM einheiten
                WHERE ID_Mitglied   ='".$ID_Mitglied."'
				      AND euro_Gutschein='1'
                ";
				
		//echo "sql_Check_Euro=".$sql;
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $euro_Gutschein=$row['euro_Gutschein'];
        }

    return $euro_Gutschein;
    }

	
	
	
// DEAL-FUNKTIONEN++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    function aendere_zustimmung_deal($deal_ID,$von_ok,$an_ok) 
	{
	        $sql = " UPDATE
                        deals
                     SET
                        von_ok=".$von_ok.",
                        an_ok=".$an_ok.",
                        letzte_aenderung=NOW()
                     WHERE
                         deal_ID = ".$deal_ID;

         $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
	}
	
    function ermittle_deal_ID($eigen_einheit,$fremd_einheit)
	{
		$ID=0;
		$eigen_einheit_ID=ermittle_Einheit_ID ($eigen_einheit);
		$fremd_einheit_ID=ermittle_Einheit_ID ($fremd_einheit);
		
		$sql = " SELECT * FROM deals
				 WHERE
					(
						von_ID_einheit = ".$eigen_einheit_ID."
					AND 
						an_ID_einheit  = ".$fremd_einheit_ID."
					)
				 OR
					(
						von_ID_einheit = ".$fremd_einheit_ID."
					AND 
						an_ID_einheit  = ".$eigen_einheit_ID."
					)";	

        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        if (mysql_num_rows($result)>0) {
            $row = mysql_fetch_assoc($result);
            $ID=$row['deal_ID'];
        }
		 
		return $ID;
	}
	
	function deal_art ($deal_ID,$eigeneinheit_ID)
	{
		$ID=-999; // Deal_ID nicht vorhanden
		
		$sql = " SELECT * FROM deals
				 WHERE
					deal_ID= ".$deal_ID;	

        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        $row = mysql_fetch_assoc($result);
        if ($row[von_ok]==1 AND $row[an_ok]==1) {
			$ID=3; // gültiger Deal
		}
		elseif ( ($row[von_ok]==1 AND $row[an_ok]==0) OR ($row[von_ok]==0 AND $row[an_ok]==1) ) { // öffene Halber-Deal
			if (
				($row[von_ID_einheit]==$eigeneinheit_ID AND $row[von_ok]==1) 
				OR
			    ($row[an_ID_einheit]==$eigeneinheit_ID AND $row[an_ok]==1)
			   ){ 
				$ID=1; // nur von Herausgeber der Eigeneinheit zugestimmt
			}
			else { 
				$ID=2; // nur von Herausgeber der Fremdeinheit zugestimmt
			}
		}
		elseif ($row[von_ok]==0 AND $row[an_ok]==0) {
			$ID=0; // offener Vorschlags-Deal ==> keiner hat bisher zugestimmt
		}
		elseif ($row[von_ok]==-1 OR $row[an_ok]==-1) { // abgelehnter Deal
			if ($row[von_ok]==-1 AND $row[an_ok]==-1) { 
				$ID=-3;	// von beiden abgelehnter Deal
			}
			else {// einseitig adgelehter Deal
			  if (
				($row[von_ID_einheit]==$eigeneinheit_ID AND $row[von_ok]==-1) 
				OR
			    ($row[an_ID_einheit]==$eigeneinheit_ID AND $row[an_ok]==-1)
			   ){ 
				$ID=-1; // nur von Herausgeber der Eigeneinheit abgelehnt
				}
			  else { 
				$ID=-2; // nur von Herausgeber der Fremdeinheit abgelehnt
			  }
			}
			
			
		}
		 
		return $ID;
	}
		
	function deal_art_als_text ($deal_art_nummer)
	{
		$Dealart=-999; // $deal_art_nummer nicht vorhanden
		
		
       	switch ($deal_art_nummer)
		{
		case -3: // abgelehnter Deal
		  // Entscheitungsformular Gegenüberstellung abgelehnter Deal und aktueller Angebotener-Deal des Users
		  $Dealart="Diesen beitseitig abgelehnten Deal
		           <br> kann hier von mir Zugestimmt werden";
		  break;
		case -1: // abgelehnter Deal
		  // Entscheitungsformular Gegenüberstellung abgelehnter Deal und aktueller Angebotener-Deal des Users
		  $Dealart="Diesen von mir abgelehnten Deal
					<br> kann hier von mir Zugestimmt werden";
		  break;
		case -2: // abgelehnter Deal
		  // Entscheitungsformular Gegenüberstellung abgelehnter Deal und aktueller Angebotener-Deal des Users
		  $Dealart="Disen von <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> abgelehnter Deal
		            <br> kann ich hier nochmals senden";
		  break;
		case 0: // offener Vorschlags-Deal
		  // Entscheitungsformular Gegenüberstellung offener Vorschlags-Deal und aktueller Angebotener-Deal des Users
		  $Dealart="Diesen vom System vorgeschlagenen Deal
		           <br> kann ich zustimmen und an <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> senden";
		  break;
		case 1: // halboffener Deal
		  // Entscheitungsformular Gegenüberstellung halboffener Deal und aktueller Angebotener-Deal des Users
		  $Dealart="Mein altes Deal-Angebot an 
		            <br><a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a>
					<br>wurde noch nicht angenommen";
		  break;
		case 2: // halboffener Deal
		  // Entscheitungsformular Gegenüberstellung halboffener Deal und aktueller Angebotener-Deal des Users
		  $Dealart="Dieses Deal-Angebot von 
		            <br><a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a>
					<br>wartet auf meine Zustimmung.";
		  break;
		case 3: // halboffener Deal
		  // Entscheitungsformular Gegenüberstellung abgeschlossener Deal und aktueller Angebotener-Deal des Users
		  $Dealart="abgeschlossener derzeit gültiger Deal";
		  break;
		}
		 
		return $Dealart;
	}
	
	function deal_anlegen ($von_ID_einheit,$an_ID_einheit,$von_wk,$an_wk,$von_ok,
								 $an_ok,$von_min_akzeptanz,$an_min_akzeptanz,$pc_vorschlag) 
	// Legt einen Dealdatensatz an, Es kann an Angebots Deal (1 0) System Vorschlagstiel (0 0) oder eine Andere Dealart sein. 	
	{
	   $sql = "INSERT INTO deals
				   
					(
					 von_ID_einheit,
					 an_ID_einheit,
					 
					 von_wk,
					 an_wk,
					 
					 von_ok,
					 an_ok,
					 
					 von_min_akzeptanz,
					 an_min_akzeptanz,
					 
					 pc_vorschlag,
					 letzte_aenderung
					)
					
			VALUES
					(
					 '".mysql_real_escape_string(trim($von_ID_einheit))."',
					 '".mysql_real_escape_string(trim($an_ID_einheit))."',
					 
					 '".mysql_real_escape_string(trim($von_wk))."',					 
					 '".mysql_real_escape_string(trim($an_wk))."',
					 
					 '".mysql_real_escape_string(trim($von_ok))."',
					 '".mysql_real_escape_string(trim($an_ok))."',

					 '".mysql_real_escape_string(trim($von_min_akzeptanz))."',
					 '".mysql_real_escape_string(trim($an_min_akzeptanz))."',	

					 '".mysql_real_escape_string(trim($pc_vorschlag))."',
					 CURDATE()
					)";
					
		   mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		   
	}	
		
	function deal_updaten ($_deal_ID,$von_ID_einheit,$an_ID_einheit,$von_wk,$an_wk,$von_ok,
								 $an_ok,$von_min_akzeptanz,$an_min_akzeptanz,$pc_vorschlag) 
	// Legt einen Dealdatensatz an, Es kann an Angebots Deal (1 0) System Vorschlagstiel (0 0) oder eine Andere Dealart sein. 	
	{
	   $sql = "UPDATE deals
				   
					SET 
					 von_ID_einheit='".mysql_real_escape_string(trim($von_ID_einheit))."',
					 an_ID_einheit='".mysql_real_escape_string(trim($an_ID_einheit))."',
					 
					 von_wk='".mysql_real_escape_string(trim($von_wk))."',	
					 an_wk='".mysql_real_escape_string(trim($an_wk))."',
					 
					 von_ok='".mysql_real_escape_string(trim($von_ok))."',
					 an_ok='".mysql_real_escape_string(trim($an_ok))."',
					 
					 von_min_akzeptanz='".mysql_real_escape_string(trim($von_min_akzeptanz))."',
					 an_min_akzeptanz='".mysql_real_escape_string(trim($an_min_akzeptanz))."',
					 
					 pc_vorschlag='".mysql_real_escape_string(trim($pc_vorschlag))."',
					 letzte_aenderung=CURDATE()
					
					
				WHERE
				    deal_ID='".$_deal_ID."'";
					
		   mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		   
	}	
		
	function deal_zustimmen ($_deal_ID,$_Eigeneinheit_ID)	
	{
	
			if (deal_von_einheit_id_ermitteln ($_deal_ID)==$_Eigeneinheit_ID) {
			
				$sql = "UPDATE deals
					   
						SET 			 				 
							von_ok='1',		 				 
							letzte_aenderung=CURDATE()		
						WHERE
							deal_ID='".$_deal_ID."'";
			}
			elseif (deal_an_einheit_id_ermitteln ($_deal_ID)==$_Eigeneinheit_ID) {
			
				$sql = "UPDATE deals
					   
						SET 			 				 
							an_ok='1',		 				 
							letzte_aenderung=CURDATE()		
						WHERE
							deal_ID='".$_deal_ID."'";
			
			}
			else 
				echo "Fehler: Die Eigeneinheit_ID=".$_Eigeneinheit_ID." konnte im Deal (Deal_ID=".$_deal_ID.") nicht gefunden werden! <br>";
				
					
		   mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
	
	}
		
	function deal_ablehnen ($_deal_ID,$_Eigeneinheit_ID)	
	{
	
			if (deal_von_einheit_id_ermitteln ($_deal_ID)==$_Eigeneinheit_ID) {
			
				$sql = "UPDATE deals
					   
						SET 			 				 
							von_ok='-1',		 				 
							letzte_aenderung=CURDATE()		
						WHERE
							deal_ID='".$_deal_ID."'";
			}
			elseif (deal_an_einheit_id_ermitteln ($_deal_ID)==$_Eigeneinheit_ID) {
			
				$sql = "UPDATE deals
					   
						SET 			 				 
							an_ok='-1',		 				 
							letzte_aenderung=CURDATE()		
						WHERE
							deal_ID='".$_deal_ID."'";
			
			}
			else 
				echo "Fehler: Die Eigeneinheit_ID=".$_Eigeneinheit_ID." konnte im Deal (Deal_ID=".$_deal_ID.") nicht gefunden werden! <br>";
				
					
		   mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
	
	}
		
 	function deal_von_einheit_id_ermitteln ($_deal_ID)
	{
			$sql = "SELECT von_ID_einheit  FROM deals
				   		
					WHERE
					
						deal_ID='".$_deal_ID."'";
					
		    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		    $row = mysql_fetch_assoc($result);
			return $row[von_ID_einheit];
	
	}
	
 	function deal_an_einheit_id_ermitteln ($_deal_ID)	
	{
			$sql = "SELECT an_ID_einheit  FROM deals
				   		
					WHERE
					
						deal_ID='".$_deal_ID."'";
					
		    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		    $row = mysql_fetch_assoc($result);
			return $row[an_ID_einheit];
	
	}
	
	function Umtauschstellen_Anz ($einheit_ID) 
	{

		$sql="SELECT COUNT(*) AS Anzahl_der_Umtauschstellen FROM deals
			
		WHERE
			(an_ID_einheit ='".$einheit_ID."'
		OR
			von_ID_einheit='".$einheit_ID."')
		AND
			(von_OK='1' AND an_OK='1')";
		
		$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		$row = mysql_fetch_assoc($result);
		
		
		return $row[Anzahl_der_Umtauschstellen];
		
	}
	
	function Wechselkurs ($deal_ID,$eigen_einheit) 
	{
		// ermittelt den Wechselkues=$fremd_einheit/$eigen_einheit zwischen zwei Einheiten, falls es keinen gultigen Kurs gibt gilt kurs=0
		$kurs=0;
		if ($deal_ID<>0) {
			$eigeneinheit_ID=ermittle_Einheit_ID($eigen_einheit);
			$deal_art=deal_art ($deal_ID,$eigeneinheit_ID);
			if ($deal_art=3) { //gültiger Deal
				$sql = "SELECT von_wk,an_wk,von_ID_einheit FROM deals
				   		
					WHERE
					
						deal_ID='".mysql_real_escape_string($deal_ID)."'";
					
				$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
				$row = mysql_fetch_assoc($result);
				if ($row['von_ID_einheit']==$eigeneinheit_ID) 
					$kurs=$row['an_wk']/$row['von_wk'];
				else
					$kurs=$row['von_wk']/$row['an_wk'];
			}
		}
		
		
		
		return $kurs;
			
		
	
	}
	
	
 // ENDE FUNKTIONEN****************************************************************************************


 
?>