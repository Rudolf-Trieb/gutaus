<?php
   //SESSION
    session_start();
	include_once('include_0_db_conection.php');
	include_once('funktionen.php');	

	$username = $_REQUEST['userName']; // Get send username 
    $password = $_REQUEST['passWord']; // Get send password
	$passwordrepeat = $_REQUEST['passWordRepeat']; // Get send paaawordrepeat
	$email = $_REQUEST['email']; // Get send email 
	$emailrepeat = $_REQUEST['emailRepeat']; // Get send emailrepeat
	$agb = $_REQUEST['agb']; // Get send agb 
	

//PRE_VALIDATE BEGINN +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 	
		$i=0;
		if(strlen($username) == 0 & strlen($password) == 0) {
			$i++;
			$error_Msg[$i]="Bitte geben Sie einen Benuzernamen und ein Passwort ein!";
		}
		elseif (strlen($username) == 0 & strlen($password) > 0) {
			$i++;
			$error_Msg[$i]="Bitte geben Sie einen Benuzernamen ein!";
		}
		elseif (strlen($password) == 0 & strlen($username) > 0){
			$i++;
			$error_Msg[$i]="Bitte geben Sie ein Passwort ein!";
		}
		if ($password!=$passwordrepeat) {
			$i++;
			$error_Msg[$i]="Die eingegebenen Passwörter stimmen nicht überein!";
		}
		if (strlen($email)== 0) {
			$i++;
			$error_Msg[$i]="Bitte geben Sie Ihre Email-Adresse ein!";
		}
		elseif (strpos($email, '@')<=0) {
			$i++;
			$error_Msg[$i]="Ihre Email-Adresse muss ein '@'-Zeichen enthalten!";
		}	
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$i++;
			$error_Msg[$i]="Ihre Email-Adresse ist nach  'RFC 2822'-Norm fehlerhaft !";
		}
		if ($email!=$emailrepeat) {
			$i++;
			$error_Msg[$i]="Die eingegebenen Email Adressen stimmen nicht überein!";
		}
		if ($agb=='false') {
			$i++;
			$error_Msg[$i]="Bitte akzeptieren Sie die AGBs!";
		}
//PRE_VALIDATE END +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++        
		if(count($error_Msg)>0){ // pre_validation false
			
			// creats user-data object and send back to client
				$response_data="{"; 
				$response_data.='"error_count":';
				$response_data.=count($error_Msg).',';
				$response_data.='"error_Msg":';
				$response_data.=json_encode($error_Msg);			    
				$response_data.="}";	
	 			echo $response_data; // sends to client
			
			
			//echo json_encode($error_Msg); // sends to client			
		}
//POST_VALIDATE BEGINN +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
	 	else { // pre_validation ok
			$i=0;
			// ceck if username is in DB
			$sql = "SELECT ID FROM mitglieder
                WHERE Nickname   ='".mysql_real_escape_string($username)."'
                ";
        	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        	if (mysql_num_rows($result)>0) {
				$i++;
           		$error_Msg[$i]="Der Benutzername '$username' ist breits vergeben!";		
			}
			// ceck if email is in DB
			$sql = "SELECT ID FROM mitglieder
                WHERE Email   ='".mysql_real_escape_string($email)."'
                ";
        	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        	if (mysql_num_rows($result)>0) {
				$i++;
           		$error_Msg[$i]="Die Email '$email' ist breits registriert!";		
			}			
//POST_VALIDATE END +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if(count($error_Msg)>0){ // pos_validation false
				
			// creats user-data object and send back to client
				$response_data="{"; 
				$response_data.='"error_count":';
				$response_data.=count($error_Msg).',';
				$response_data.='"error_Msg":';
				$response_data.=json_encode($error_Msg);			    
				$response_data.="}";	
	 			echo $response_data; // sends to client			
				
				
			}
			else { // pos_validation ok
				// set SESSION VARs for registration of new user
				$_SESSION['reg_username']=$username;
				$_SESSION['reg_email']=$email;
				$_SESSION['reg_password']=$password;
				
				// send confirm email
				$_SESSION['reg_code']=uniqueID(3);
				$reg_code=$_SESSION['reg_code'];
				$registration_empfeanger = "".$email."";   
				$registration_betreff = "Danke für die Registrierung bei GuTauS! ";
				$registration_text = "Ihr Bestätigungscode: $reg_code";
				mail($registration_empfeanger, $registration_betreff, $registration_text, "FROM: was auch immer<support>");
				
				// creats user-data object and send back to client
				$Msg="GuTauS $reg_code hat Ihnen soeben eine Email an $email mit eien Bestätigungscode gesendet, bitte geben Sie jetzt diesen Code ein, um Ihre Registrierung abzuschließen!";
				$response_data="{"; 
				$response_data.='"Msg":';
				$response_data.='"'.$Msg.'"';
				$response_data.="}";	
	 			echo $response_data; // sends to client
				
			}			
		}


?>