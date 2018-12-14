<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
?>

<script>
		$(document).ready(function(){
		
			$("#send_nickname").click(function() {
				var Data=$("form").serialize();
				$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
				$.post("include_32_passwort_vergessen.php",{formdata:Data},function(data){
				  $("#inhalt").html(data).fadeIn(4000);
				});
				
				return false;
		    });
			
			$("#pw_neu_festlegen").click(function(){
				var code=$("#CODE").val();
				$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
				$.post("include_32_pw_neu_festlegen.php",{Code:code},function(data){
						  $("#inhalt").html(data).show();
				});
			
		  });
		  
		});
</script>

<?php


   echo "<h2>Passwort vergessen</h2>";
       if(isset($_POST["formdata"])){
	   	parse_str($_POST["formdata"], $Formulardaten);
        // Daten prüfen
        $errors = array();
        if(!isset($Formulardaten['Nickname']))
            $errors[] = "Bitte benutzen Sie unser Passwortformular";
        else{
            if(trim($Formulardaten['Nickname']) == "")
                $errors[] = "Geben Sie Ihren Nickname an.";
            // Nickname suchen
            $sql = "SELECT
                        Email
                    FROM
                        mitglieder
                    WHERE
                        Nickname = '".mysql_real_escape_string(trim($Formulardaten['Nickname']))."'
                        ";
            $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
            $row = mysql_fetch_assoc($result);
            if(!$row)
                $errors[] = "Ihr Nickname konnte nicht gefunden werden.\n";
            elseif ($row['Email']=='')
				$errors[] = "Leider ist keine E-Mail Adresse zu Ihren Nickname hinterlegt.
				Bitte wenten Sie sich direckt an den <a href=\"mailto:support@gutaus.net\">Support</a>! \n";
        }
        if(count($errors)){
            echo "Ihr Passwort konnte nicht versendet werden.<br>\n".
                 "<br>\n";
            foreach($errors as $error)
                echo $error."<br>\n";
            echo "<br>\n";
        }
        else {
         // Email verschicken
			$laenge = 7; 
			$zeichen = "abcdefghijklmnopqrstuvxwyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
			$_SESSION['code']=""; 
			mt_srand ((double) microtime()*1000000); 
			for ($i=0; $i<$laenge; $i++) 
			{ 
				$_SESSION['code'].= $zeichen{mt_rand(0,strlen($zeichen))}; 
			}  
            $empfaenger = $row['Email'];
            $titel = "Passwort Code";
            $mailbody = "Wir kennen Ihr Passwort auch nicht, da es aus Sicherheitsgrünten verschlüsselt
			in unserer Dadenbank hinterlegt ist. Geben Sie also bitte jetzt folgenden Code auf Unserer Homepage ein, um Ihr Passwort neu festzulegen.
			CODE: ".$_SESSION['code'].
			"      Bitte beachten Sie die Groß- und Kleinschreibung! ";
            $header = "From: webmaster@gutaus.net\n";
            if(@mail($empfaenger, $titel, $mailbody, $header)){
                echo "Bitte geben Sie hier: <input type='text' id='CODE'/> den soeben per E-Mail an Sie gesendeten CODE ein,<br>
					  um Ihr Password neu festzulegen<br>\n";
                echo "Bitte beachten Sie die Gro&szlig;- und Kleinschreibung!<br><br>";
				echo "<a id='pw_neu_festlegen' href='#'>Passwort neu festlegen</<a>";
            }
            // Im Fehlerfall wird die Mailadresse des Webmasters für den direkten Versandt eingeblendet
            else{
                echo "Beim Senden der Email trat ein Fehler auf.<br>\n".
                     "Bitte wenden Sie sich direkt an den <a href=\"mailto:support@gutaus.net\">Support</a>.\n";
            }
        }
    }
    else{
            echo "<form ".
                 " accept-charset=\"ISO-8859-1\">\n";
            echo "Nickname :\n";
            echo "<input type=\"text\" name=\"Nickname\" maxlength=\"32\" value='".$_SESION['Nickname']."'>\n";
            echo "<br>\n";
            echo "<input id='send_nickname' type=\"submit\" name=\"submit\" value=\"Abschicken\">\n";
            echo "</form>\n";
    }




?>