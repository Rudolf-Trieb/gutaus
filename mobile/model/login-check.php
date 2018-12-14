<?php
   //SESSION
    session_start();
	include_once('include_0_db_conection.php');
	
    $username = $_REQUEST['userName']; // Get send username 
    $password = $_REQUEST['passWord'];; // Get send password

	
	
	
    $sql = "SELECT
                    ID,Nickname,Avatar,Email,Tester_Flag
            FROM
                    mitglieder
            WHERE
                    Nickname = '".mysql_real_escape_string(trim($username))."' AND
                    Passwort = '".mysql_real_escape_string(md5(trim($password)))."'
           ";
	
	//echo "sql=".$sql;
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
    // wird die ID des Users geholt und der User damit eingeloggt
    $row = mysql_fetch_assoc($result);
    // Prüft, ob wirklich genau ein Datensatz gefunden wurde	
    if (mysql_num_rows($result)==1){
	
		// save user-data in SESSION
		//$_SESSION["login"]=$row['user-id']; 
		$_SESSION["login"]=true; 
		$_SESSION["user_id"]=$row['ID']; //user-id in SESSION then user is logtin 
		$_SESSION["user_name"]=$row['Nickname'];
		$_SESSION["user_avatar"]=$row['Avatar'];
		$_SESSION['Email']=$row['Email'];
		$_SESSION['Tester_Flag']=$row['Tester_Flag'];
		
		// creats user-data object fot send back to client
		$user_data="{"; 
			$user_data.='"login":';
			$user_data.='1';		// login is true
			$user_data.=',';
			$user_data.='"id":';
			$user_data.='"'.$_SESSION["user_id"].'"';
			$user_data.=',';
			$user_data.='"name":';
			$user_data.='"'.$_SESSION["user_name"].'"';
			$user_data.=',';
			$user_data.='"avatar":';
			$user_data.='"'.$_SESSION["user_avatar"].'"';
		$user_data.="}";
		
		// writes in DB aktuelle Session ID of user
		doLogin($_SESSION["user_id"]); 
	}
	else {
	  $_SESSION["login"]=false; // login is set to false. false equalises the number 0
	  
	  
	  // but Lets say everything is in order because it is a test system
	  //$_SESSION["login"]=true; 
	  	// creats user-data object fot send back to client
	  	$user_data="{"; 
			$user_data.='"login":';
			$user_data.='1';		// login is true
			$user_data.=',';
			$user_data.='"user_id":';
			$user_data.='"0"';
			$user_data.=',';
			$user_data.='"user_name":';
			$user_data.='"Gastuser"';
			$user_data.=',';
			$user_data.='"user_avatar":';
			$user_data.='"logo 1.0.jpg"';
		$user_data.="}";
		
		
	}

	echo $user_data; // sends to client in JSON Format
	
	
	
	
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
    }
        
// FUNKTIONEN ENDE*************************************************************************************
	
?>