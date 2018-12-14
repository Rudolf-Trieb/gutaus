

<script>

	$(document).ready(function(){
	
		$("#daten_aendern").click(function(){
			formulardata=$("form[name=Daten]").serialize();
			$.post("include_41_mein_profil_daten_aendern.php",{formdata:formulardata},function(data){
				$("#inhalt").html(data);
			});
			return false;
		});
		
		$("#passwort_aendern").click(function(){
			formulardata=$("form[name=Passwort]").serialize();
			$.post("include_41_mein_profil_passwort_aendern.php",{formdata:formulardata},function(data){
				$("#inhalt").html(data);
			});
			return false; 
		});
		
	
	});
	
</script>

<?php
 // Mein Profil Anzeigen

 
             $sql = "SELECT
                             Nickname,
                             Email,
                             Show_Email,
                             Registrierungsdatum,
                             PLZ,
                             Wohnort,
                             Strasse,
                             Nachname,
                             Vorname,
                             Homepage,
                             Skype,
                             Facebook,
                             Okitalk,
                             ICQ,
                             MSN,
                             Avatar
                     FROM
                         mitglieder
                     WHERE
                         ID = '".mysql_real_escape_string($_SESSION['UserID'])."'
                    ";
            $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
            $row = mysql_fetch_assoc($result);
			
    // Avatar änder anzeigen
				include("include_41_mein_profil_avatar_formular.php");			
			
    // Obligatorische Angaben ändern anzeigen
    
            echo "<form ".
                 " name=\"Daten\" ".
                 " accept-charset=\"ISO-8859-1\">\n";
            echo "<table>";
            
                echo "<tr>";
                echo "<td calspan=2>";
                echo "<h3>Obligatorische Angaben</h3>\n";
                echo "<td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span>\n".
                 "Nickname :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                // Anzal vergangener Tage seit Registrierung des Users 
			     $db_date = explode("-",$row['Registrierungsdatum']); 
			     $tstamp = mktime(0, 0, 0, $db_date[1], $db_date[2], $db_date[0]);
			     $Mitglied_seit_Tagen=floor(  ( time() -$tstamp ) /3600/24  )+1;
			    if ($Mitglied_seit_Tagen<200) // Meldung Nickname nicht änderbar Zeigen
                    echo "<input type=\"text\" name=\"Nickname\" maxlength=\"70\" value=\"".htmlentities($row['Nickname'], ENT_QUOTES)."\">\n";
                else {
                    echo htmlentities($row['Nickname'], ENT_QUOTES)."\n";
					echo "<input type=\"hidden\" name=\"Nickname\" maxlength=\"70\" value=\"".htmlentities($row['Nickname'], ENT_QUOTES)."\">\n"; 
                }					
                echo "</td>";
                echo "</tr>";
                
                echo "<tr align='left'>";
                echo "<td>";
                echo "Mitglied seit: ";
                echo "</td>";
                echo "<td>";
                echo $Mitglied_seit_Tagen." Tagen\n";
                echo "</td>";
                echo "</tr>"; 
                
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\" ".
                 " title=\"Ihre.Adresse@Ihr-Anbieter.de\">\n".
                 "Email-Adresse:\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";                 
                echo "<input type=\"text\" name=\"Email\" maxlength=\"70\" value=\"".htmlentities($row['Email'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span>\n".
                 "Email-Adresse anzeigen:\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
            if($row['Show_Email']==1){
                echo "<input type=\"radio\" name=\"Show_Email\" value=\"1\" checked> ja\n";
                echo "<input type=\"radio\" name=\"Show_Email\" value=\"0\"> nein\n"; 
            }
            else{
                echo "<input type=\"radio\" name=\"Show_Email\" value=\"1\"> ja\n";
                echo "<input type=\"radio\" name=\"Show_Email\" value=\"0\" checked> nein\n";
            }
            echo "</td>";
            echo "</tr>";
            
            echo "</table>";
            

    // Freiwillige Angaben ändern anzeigen
    
                echo "<table>";
                
                echo "<tr>";
                echo "<td calspan=2>";
                echo "<h3>Freiwillige Angaben</h3>\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "PLZ :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"PLZ\" maxlength=\"5\" value=\"".htmlentities($row['PLZ'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";                
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "Wohnort :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"Wohnort\" maxlength=\"70\" value=\"".htmlentities($row['Wohnort'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "Strasse :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"Strasse\" maxlength=\"70\" value=\"".htmlentities($row['Strasse'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "Nachname :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"Nachname\" maxlength=\"30\" value=\"".htmlentities($row['Nachname'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "Vorname :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"Vorname\" maxlength=\"30\" value=\"".htmlentities($row['Vorname'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "Homepage :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"Homepage\" maxlength=\"70\" value=\"".htmlentities($row['Homepage'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "Facebook :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"Facebook\" maxlength=\"30\" value=\"".htmlentities($row['Facebook'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "Skype :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"Skype\" maxlength=\"30\" value=\"".htmlentities($row['Skype'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "www.okitalk.com :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"Okitalk\" maxlength=\"30\" value=\"".htmlentities($row['Okitalk'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                              
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "ICQ :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>"; 
                echo "<input type=\"text\" name=\"ICQ\" maxlength=\"20\" value=\"".htmlentities($row['ICQ'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\">\n".
                 "MSN :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"text\" name=\"MSN\" maxlength=\"70\" value=\"".htmlentities($row['MSN'], ENT_QUOTES)."\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td calspan=2>";
                echo "<a id='daten_aendern' href='#'>Daten &auml;ndern</a>\n";
                echo "</td>";
                echo "</tr>";
                
                echo "</table>"; 
                echo "</form>\n";

    // Passwort  ändern anzeigen
            echo "<br>";
            echo "<form ".
                 " name=\"Passwort\" ".
                 " accept-charset=\"ISO-8859-1\">\n";
                 
                echo "<table>";

                echo "<tr>";
                echo "<td>";     
                echo "<span style=\"font-weight:bold;\" ".
                     " title=\"min.6\">\n".
                     "Altes Passwort :\n".
                     "</span>\n";
                echo "</td>";
                echo "<td>";         
                echo "<input type=\"password\" name=\"Altes_Passwort\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\" ".
                 " title=\"min.6\">\n".
                 "Neues Passwort :\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"password\" name=\"Passwort\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td>";
                echo "<span style=\"font-weight:bold;\" ".
                 " title=\"min.6\">\n".
                 "Neues Passwort wiederholen:\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"password\" name=\"Passwortwiederholung\">\n";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td calspan=2>";
                echo "<a id='passwort_aendern' href='#'>Passwort &auml;ndern</a>\n";
                echo "</td>";
                echo "</tr>";
                
                echo "</table>";
                
                echo "</form>\n";
                
                echo "<br>";
				
				
 	// Herausgeber
	include('include_2_herausgeber.php'); 



?>