<?php
   //SESSION
    session_start();
	include_once('include_0_db_conection.php');
	include_once('funktionen.php');		

	$reg_code= $_REQUEST['Code']; // Get send reg_code
	

//PRE_VALIDATE BEGINN +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 	
		$i=0;
		if($reg_code != $_SESSION['reg_code'] || strlen($reg_code) < 3 ) {
			$i++;
			$error_Msg[$i]="Der Bestätigungcode $reg_code ist falsch. Bitte überprüfen Sie nochmals Ihren per Email erhaltenen Bestätigunscode!";
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
//POST_VALIDATE BEGINN AND REGISTRATION IN DB+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
	 	else { // pre_validation ok
				$user_ID=neues_Mitglied_registrieren ($_SESSION['reg_username'],$_SESSION['reg_email'],'',$_SESSION['reg_password'],0);
//POST_VALIDATE END +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if($user_ID==0){ // pos_validation false
				
			// creats user-data object and send back to client
				$response_data='{'; 
				$response_data.='"error_count":';
				$response_data.=1;
				$response_data.=',';
				$response_data.='"error_Msg":';
				$response_data.='"Ihre Registrierung war trotz richtigen Bestätigungscode nicht möglich. Bitte wenden Sie an den Administrator 777horus@gmail.com!":';			    
				$response_data.='}';	
	 			echo $response_data; // sends to client			
				
				
			}
			else { // pos_validation an registration ok
			   // call function eroeffne_konto ($UserID,$max_Ueberziehung,$Einheit,$max_Akzeptanz) 
				eroeffne_konto ($user_ID,0,"Horus",10000); 
				eroeffne_konto ($user_ID,0,"Euro",10000);	
			// creats user-data object and send back to client
				$response_data='{'; 
				$response_data.='"error_count":';
				$response_data.=0;
				$response_data.=',';
				$response_data.='"Msg":';
				$response_data.='"Ihre Registrierung war erfogreich. Sie können sich jetzt mit Ihrem Benuzernamen und Ihrem Password bei GuTauS einloggen!"';			    
				$response_data.='}';	
	 			echo $response_data; // sends to client	
				
			}			
		}


?>