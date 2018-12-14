

<script>
		$(document).ready(function(){
			
			$("#rgistrieren").click(function() {
			
				var serialformdata=$("form").serialize();
				alert(serialformdata);
				$.post("include_31_registrierung.php",{formdata:serialformdata},function(data){
					$("#inhalt").html(data);	
				});
				
				return false;
			
			});
		  
		});
</script>


<?php

	if (!headers_sent())
		header("Content-Type: text/html; charset=ISO-8859-1");

	echo "<h2>Testanmeldung</h2>";
    echo "<form ".
         " accept-charset=\"ISO-8859-1\">\n";


    //Obligatorische Angaben+++++++++++++++++++++++++++++++++++++++++++++
    echo "<table>";


    echo "<tr>";
    echo "<td calspan=2>";
    echo "<h3>Obligatorische Angaben</h3>\n";
    echo "<td>";
    echo "</tr>";

    // Nickname
    echo "<tr>";
    echo "<td>";
    echo "<span style=\"font-weight:bold;\" ".
        " title=\"min.3\nmax.32\nNur Zahlen, Buchstaben und Unterstrich\">\n".
         "Nickname :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Nickname\" maxlength=\"32\" value=\"".$_SESSION['Nickname']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Passwort
    echo "<tr>";
    echo "<td>";
    echo "<span style=\"font-weight:bold;\" ".
        " title=\"min.6\">\n".
         "Passwort :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"password\" name=\"Passwort\" value=\"".$_SESSION['Passwort']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Passwort wiederholen
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Passwort wiederholen:\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"password\" name=\"Passwortwiederholung\" value=\"".$_SESSION['Passwortwiederholung']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Email
    echo "<tr>";
    echo "<td>";
    echo "<span style=\"font-weight:bold;\" ".
        " title=\"Ihre.Adresse@Ihr-Anbieter.de\">\n".
         "Email-Adresse:\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Email\" maxlength=\"70\" value=\"".$_SESSION['Email']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Email-Adresse anzeigen ja/nein
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Email-Adresse anzeigen:\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"radio\" name=\"Show_Email\" value=\"1\" > ja\n";
    echo "<input type=\"radio\" name=\"Show_Email\" value=\"0\" checked > nein\n";
    echo "</td>";
    echo "</tr>";
    echo "</table>";



    echo "<br><br>";



    //Freiwillige Angaben+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    echo "<table>";


    echo "<tr>";
    echo "<td calspan=2>";
    echo "<h3>Freiwillige Angaben</h3>\n";
    echo "</td>";
    echo "</tr>";

    // PLZ
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "PLZ :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"PLZ\" maxlength=\"5\" value=\"".$_SESSION['PLZ']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Wohnort
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Wohnort :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Wohnort\" maxlength=\"70\" value=\"".$_SESSION['Wohnort']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Strasse mit HN
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Strasse mit HN :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Strasse\" maxlength=\"70\" value=\"".$_SESSION['Strasse']."\">\n";
    echo "</td>";
    echo "</tr>";
    
    // Vorname
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Vorname :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Vorname\" maxlength=\"30\" value=\"".$_SESSION['Vorname']."\">\n";
    echo "</td>";
    echo "</tr>";  
      
    // Nachname
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Nachname :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Nachname\" maxlength=\"30\" value=\"".$_SESSION['Nachname']."\">\n";
    echo "</td>";
    echo "</tr>";
      
    // Telefonnummer
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Telefonnumer :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";                      
    echo "<input type=\"text\" name=\"Telefonnummer\" maxlength=\"70\" value=\"".$_SESSION['Telefonnummer']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Mobilnummer
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Mobilnummer :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Mobilnummer\" maxlength=\"70\" value=\"".$_SESSION['Mobilnummer']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Skype
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Skype :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Skype\" maxlength=\"70\" value=\"".$_SESSION['Skype']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Facebook
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Facebook :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Facebook\" maxlength=\"70\" value=\"".$_SESSION['Facebook']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Okitalk
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "www.Okitalk.com :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Okitalk\" maxlength=\"30\" value=\"".$_SESSION['Okitalk']."\">\n";
    echo "</td>";
    echo "</tr>";

    // Homepage
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "Homepage :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"Homepage\" maxlength=\"70\" value=\"".$_SESSION['Homepage']."\">\n";
    echo "</td>";
    echo "</tr>";

    // ICQ
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "ICQ :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"ICQ\" maxlength=\"20\" value=\"".$_SESSION['ICQ']."\">\n";
    echo "</td>";
    echo "</tr>";

    // MSN
    echo "<tr>";
    echo "<td>";
    echo "<span>\n".
         "MSN :\n".
         "</span>\n";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"text\" name=\"MSN\" maxlength=\"70\" value=\"".$_SESSION['MSN']."\">\n";
    echo "</td>";
    echo "</tr>";


    echo "</table>";

    echo "<input id=\"rgistrieren\" type=\"submit\" name=\"submit\" value=\"Registrieren\">\n";

    echo "</form>\n";
?>