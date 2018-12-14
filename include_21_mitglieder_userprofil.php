<?php 
	//header("Content-Type: text/html; charset=ISO-8859-1");
    //SESSION
    session_start(); 
	if (!headers_sent())
		header("Content-Type: text/html; charset=ISO-8859-1");
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<?php
// FUNKTIONEN************************************************************************
    // Prüft die Länge jedes Wortes eines Strings und korrigiert diese evtl. 
    function shorten($str, $max=30, $range=5) 
    { 
            // aufteilen in Zeilen 
         $lines = explode("\n", $str); 
         foreach($lines as $key_line => $line){ 
                 // aufteilen in Wörter 
                 $words = explode(" ", $line); 
                 // prüfen der Länge jeden Wortes 
                 foreach($words as $key_word => $word){ 
                        if (strlen($word) > $max) 
                                $words[$key_word] = substr($word,0,$max-3-$range)."...".substr($word,-$range);
                 } 
                 // zusammenfügen der neuen Zeile 
                 $lines[$key_line] = implode(" ", $words); 
         } 
         // zusammenfügen des neues Textes 
         $str = implode("\n", $lines); 
         return $str; 
    } 
// FUNKTIONEN ENDE****************************************************************************






    if (!isset($_SESSION['UserID'])) {
       echo "Sie sind nicht eingeloggt! <br />";
       include('include_3_login.php'); 
    }
	else {
	
		if(!isset($_POST["Mitglied_ID"])) { // Herausgeber der aktuellen Einheit 
			 echo "<h2>".$_SESSION["Einheit"]."-Gutscheine werden von ".$_SESSION["Herausgeber"]." herausgeber</h2>";
			 $sql = "SELECT 
							 SessionID, 
							 Nickname, 
							 Email, 
							 Show_Email, 
							 DATE_FORMAT(Registrierungsdatum, '%d.%m.%Y') as Datum,
							 PLZ,
							 Wohnort, 
							 Strasse,
							 Nachname,
							 Vorname,
							 Homepage,
							 Facebook,
							 Skype,
							 Okitalk, 
							 ICQ, 
							 MSN, 
							 Avatar, 
							 Letzte_Aktion, 
							 Letzter_Login 
					 FROM 
						 mitglieder 
					 WHERE 
						 Nickname = '".mysql_real_escape_string($_SESSION["Herausgeber"])."' 
					"; 
		} 
		else { // Mitglied aus Userliste gewählt
		
			 $sql = "SELECT 
							 SessionID, 
							 Nickname, 
							 Email, 
							 Show_Email, 
							 DATE_FORMAT(Registrierungsdatum, '%d.%m.%Y') as Datum,
							 PLZ,
							 Wohnort, 
							 Strasse,
							 Nachname,
							 Vorname,
							 Homepage,
							 Facebook,
							 Skype,
							 Okitalk, 
							 ICQ, 
							 MSN, 
							 Avatar, 
							 Letzte_Aktion, 
							 Letzter_Login 
					 FROM 
						 mitglieder 
					 WHERE 
						 ID = '".mysql_real_escape_string($_POST["Mitglied_ID"])."' 
					"; 
		}
		
		$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
		$row = mysql_fetch_assoc($result);
		echo "<h2>Userprofil ".$row['Nickname']."</h2>";
        echo "<div style='margin 0 auto'>";		
		if(!$row){
			echo "Sie haben keinen g&uuml;ltigen Benutzer ausgewählt.<br>\n". 
				  "Bitte benutzen Sie einen Link aus der <b>»</b> <a href=\"userliste.php\">Userliste</a>\n";
		 } 
		else { 
			
			echo "<table style='float: left'>\n"; 
			echo " <tr>\n"; 
			echo "  <td>\n"; 
			echo "Nickname :\n"; 
			echo "  </td>\n"; 
			echo "  <td>\n"; 
			echo htmlentities($row['Nickname'], ENT_QUOTES)."\n"; 
			echo " ("; 
			if($row['SessionID'] AND (time()-60*2 < $row['Letzte_Aktion'])) 
				echo "<span style=\"color:green\">online</span>\n"; 
			else 
				echo "<span style=\"color:#FF3030\">offline</span>\n"; 
			echo ")"; 
			echo "  </td>\n"; 
			echo " </tr>\n"; 
					 
			echo " <tr>\n"; 
			echo "  <td>\n"; 
			echo "Registrierungsdatum :\n"; 
			echo "  </td>\n"; 
			echo "  <td>\n"; 
			echo $row['Datum']."\n"; 
			echo "  </td>\n"; 
			echo " </tr>\n";
			 
			echo " <tr>\n"; 
			echo "  <td>\n"; 
			echo "Letzter Login :\n"; 
			echo "  </td>\n"; 
			echo "  <td>\n"; 
			echo date('d.m.Y H:i \U\h\r', $row['Letzter_Login'])."\n"; 
			echo "  </td>\n";
			echo " </tr>\n";
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "Avatar :\n";
			echo "  </td>\n";
			echo "  <td>\n";
			   if($row['Avatar']=='')
				   echo "Kein Avatar vorhanden.\n";
			   else
				   echo "<img width=154px src=\"avatare/".htmlentities($row['Avatar'], ENT_QUOTES)."\">\n";
			echo "  </td>\n";
			echo " </tr>\n";         
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "<h3>Adresse:</h3>";  
			echo "  </td>\n";
			echo "  <td>\n";
			echo " </tr>\n";
								   
			echo " <tr>\n";
			echo "  <td>\n";
			echo "PLZ :\n";
			echo "  </td>\n";
			echo "  <td>\n";
			echo htmlentities($row['PLZ'], ENT_QUOTES)."\n";
			echo "  </td>\n";
			echo " </tr>\n";
			
			echo " <tr>\n"; 
			echo "  <td>\n"; 
			echo "Wohnort :\n"; 
			echo "  </td>\n"; 
			echo "  <td>\n"; 
			echo htmlentities($row['Wohnort'], ENT_QUOTES)."\n"; 
			echo "  </td>\n"; 
			echo " </tr>\n";
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "Strasse :\n";
			echo "  </td>\n";
			echo "  <td>\n";
			echo htmlentities($row['Strasse'], ENT_QUOTES)."\n";
			echo "  </td>\n";
			echo " </tr>\n";
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "Vorname :\n";
			echo "  </td>\n";
			echo "  <td>\n";
			echo htmlentities($row['Vorname'], ENT_QUOTES)."\n";
			echo "  </td>\n";
			echo " </tr>\n";
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "Nachname :\n";
			echo "  </td>\n";
			echo "  <td>\n";
			echo htmlentities($row['Nachname'], ENT_QUOTES)."\n";
			echo "  </td>\n";
			echo " </tr>\n";

			echo " <tr>\n";
			echo "  <td>\n";
			echo "<h3>Kontaktdaten:</h3>";
			echo "  </td>\n";
			echo "  <td>\n";
			echo " </tr>\n";
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "Email-Adresse :\n";
			echo "  </td>\n";
			echo "  <td>\n";
				if($row['Show_Email']==1)
				echo htmlentities($row['Email'], ENT_QUOTES)."\n";
			echo "  </td>\n";
			echo " </tr>\n";        
			
			echo " <tr>\n"; 
			echo "  <td>\n"; 
			echo "Homepage :\n"; 
			echo "  </td>\n"; 
			echo "  <td>\n"; 
			if (trim($row['Homepage'])!= ""){ 
			  if (strtolower(substr($row['Homepage'], 0, 7)) =='http://') 
				echo "<a href=\"".htmlentities($row['Homepage'], ENT_QUOTES)."\" target=\"_blank\">".htmlentities(shorten($row['Homepage']), ENT_QUOTES)."</a>\n"; 
			  // Falls kein http:// eingegeben wurde wird es automatisch eingefügt, um einen gültigen Link zu erzeugen
			  else 
				echo "<a href=\"http://".htmlentities($row['Homepage'], ENT_QUOTES)."\" target=\"_blank\">".htmlentities(shorten($row['Homepage']), ENT_QUOTES)."</a>\n"; 
			} 
			echo "  </td>\n"; 
			echo " </tr>\n";
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "Facebook :\n";
			echo "  </td>\n";
			echo "  <td>\n";
			echo htmlentities($row['Facebook'], ENT_QUOTES)."\n";
			echo "  </td>\n";
			echo " </tr>\n";
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "Skype :\n";
			echo "  </td>\n";
			echo "  <td>\n";
			echo htmlentities($row['Skype'], ENT_QUOTES)."\n";
			echo "  </td>\n";
			echo " </tr>\n";  
			
			echo " <tr>\n";
			echo "  <td>\n";
			echo "www.Okitalk.com :\n";
			echo "  </td>\n";
			echo "  <td>\n";
			echo htmlentities($row['Okitalk'], ENT_QUOTES)."\n";
			echo "  </td>\n";
			echo " </tr>\n";              
			 
			echo " <tr>\n"; 
			echo "  <td>\n"; 
			echo "ICQ :\n"; 
			echo "  </td>\n"; 
			echo "  <td>\n"; 
			echo htmlentities($row['ICQ'], ENT_QUOTES)."\n"; 
			echo "  </td>\n"; 
			echo " </tr>\n"; 

			echo " <tr>\n"; 
			echo "  <td>\n"; 
			echo "MSN :\n"; 
			echo "  </td>\n"; 
			echo "  <td>\n"; 
			echo htmlentities($row['MSN'], ENT_QUOTES)."\n"; 
			echo "  </td>\n"; 
			echo " </tr>\n";
			
			echo "</table>\n";
			
			// Herausgeber
			include('include_2_herausgeber.php'); 			
		} 
		echo "</div>";
		

	
	}
        
?>