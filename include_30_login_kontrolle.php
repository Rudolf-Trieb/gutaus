<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
	include('funktionen.php');
?>

<script>
		$(document).ready(function(){
			
			$("#zumlogin").click(function(){
		  
				$.post("include_30_login_formular.php","",function(data){
						  $("#inhalt").html(data).show();
				});
			
		  });
		  
		});
</script>


<?php

// FUNKTIONEN************************************************************************
        // Loggt einen User ein, .. 
    function doLogin($ID) 
    { 
        // .. indem die aktuelle Session ID in der Datenbank gespeichert wird 
        $sql = "UPDATE 
                        mitglieder 
                SET 
                        SessionID = '".mysql_real_escape_string(session_id())."',
                        Autologin = NULL, 
                        IP = '".$_SERVER['REMOTE_ADDR']."', 
                        Letzte_Aktion = '".mysql_real_escape_string(time())."',
                        Letzter_Login = '".mysql_real_escape_string(time())."' 
                WHERE 
                        ID = '".$ID."' 
                "; 
        mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
        // Daten des Users in der Session speichern 
        $sql = "SELECT 
                        Nickname,
                        Email,
                        Tester_Flag,
						Avatar
                FROM 
                        mitglieder 
                WHERE 
                        ID = '".$ID."' 
               "; 
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

        $row = mysql_fetch_assoc($result); 
        $_SESSION['UserID'] = $ID; 
        $_SESSION['Nickname'] = $row['Nickname'];
        $_SESSION['Email'] = $row['Email'];
        $_SESSION['Tester_Flag']=$row['Tester_Flag'];
		$_SESSION['Avatar']=$row['Avatar'];
        $_SESSION['Einheit']="Horus";
		
        
        $sql = "SELECT
                        Einheit
                FROM
                        einheiten
                WHERE
                        ID_Mitglied = '".$ID."'  
                    AND ID >'7'         
               ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());

        $row = mysql_fetch_assoc($result);
        $_SESSION['User_GuTauS_Einheit']=$_SESSION['Nickname']." Gutschein";
        if ($row['Einheit']<>'')
            $_SESSION['User_GuTauS_Einheit'] = $row['Einheit']; 
        
    }
        
// FUNKTIONEN ENDE*************************************************************************************

	if(isset($_GET["Nickname"])) {
		$Nickname=$_GET["Nickname"];
		$PW=$_GET["PW"];
	}
	else {
			parse_str($_POST["formdata"], $Formulardaten);
			$Nickname=$Formulardaten['Nickname'];
			$PW=$Formulardaten['Passwort'];
	}

	
	 
	
    $sql = "SELECT
                    ID
            FROM
                    mitglieder
            WHERE
                    Nickname = '".mysql_real_escape_string(trim($Nickname))."' AND
                    Passwort = '".md5(trim($PW))."'
           ";
	
	//echo "sql=".$sql;
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
    // wird die ID des Users geholt und der User damit eingeloggt
    $row = mysql_fetch_assoc($result);
    // Prüft, ob wirklich genau ein Datensatz gefunden wurde
	

	
	
    if (mysql_num_rows($result)==1){
         doLogin($row['ID']);
         echo "<h4>Willkommen ".$_SESSION['Nickname']."</h4>\n";
         echo "Sie wurden erfolgreich eingeloggt.<br>\n".
             "<h1>Zur <a href='index.php'>Startseite</a></h1>\n";		 
			 
         Weiterleitung("index.php",0);  
         
 


         //header('Location: $_SERVER['PHP_SELF']');
         //echo "SESSION['angemeldet']=".$_SESSION['angemeldet']."<br>";
    }
    else{
        echo    "Sie konnten nicht eingeloggt werden.<br>\n".
                "Nickname oder Passwort fehlerhaft.<br>\n".
                "Zur&uumlck zum <a href=\"#\" id=\"zumlogin\">Login-Formular</a>\n";
		$_SESSION['Nickname']=$Formulardaten['Nickname'];
    }
	
?>


