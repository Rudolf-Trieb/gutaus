<?php
   //SESSION
    session_start();
	include_once('../includes/include_0_db_conection.php');
		
	if ($_SESSION["login"]) { // if login true
	
		$_SESSION['member_email']=$_REQUEST['member_email']; // Get sended member_chosen_id
		
		
		$sql="    SELECT 
						`ID` AS id, 
						`Nickname` AS name, 
						`Email` AS email, 
						`Show_Email` AS email_show, 
						`Avatar` AS avatar,
						`Telefonnummer` AS telephone_number, 
						`Show_Telefonnummer` AS telephone_number_show, 
						`Mobilnummer` AS mobile , 
						`Show_Mobilnummer` AS mobile_show, 
						`Homepage` AS homepage, 
						`Registrierungsdatum` AS registration_date, 
						`PLZ` AS postal_code, 
						`Wohnort` AS residence, 
						`Strasse` AS street, 
						`Nachname` AS last_name, 
						`Vorname`AS first_name, 
						`Skype` AS skype,
						`Okitalk` AS okitalk, 
						`Facebook` AS facebook,  
						`Letzter_Login` AS  last_login, 
						`Tester_Flag` AS test_member
						
					FROM `mitglieder`
					
					WHERE `email`='".mysql_real_escape_string(trim($_SESSION['member_email']))."'";

				  
		//echo "sql=".$sql;
		$sql_result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		
		$row = mysql_fetch_assoc($sql_result);
			$send_back.="{";
			
			$send_back.='"id":';
			$send_back.='"'.$row['id'].'"';
			$send_back.=',';
			
			$send_back.='"name":';
			$send_back.='"'.$row['name'].'"';
			$send_back.=',';
			
			$send_back.='"email":';
			($row['email_show'] ? $send_back.='"'.$row['email'].'"' : $send_back.='"privat"');
			$send_back.=',';

			$send_back.='"avatar":';
			$send_back.='"'.$row['avatar'].'"';
			$send_back.=',';			
			
			$send_back.='"telephone_number":';
			($row['telephone_number_show'] ? $send_back.='"'.$row['telephone_number'].'"' : $send_back.='"privat"');
			$send_back.=',';
			
			$send_back.='"mobile":';
			($row['mobile_show'] ? $send_back.='"'.$row['mobile'].'"' : $send_back.='"privat"');
			$send_back.=',';
			
			$send_back.='"homepage":';
			$send_back.='"'.$row['homepage'].'"';
			$send_back.=',';			
			
			$send_back.='"registration_date":';
			$send_back.='"'.$row['registration_date'].'"';
			$send_back.=',';
			
			$send_back.='"postal_code":';
			$send_back.='"'.$row['postal_code'].'"';
			$send_back.=',';

			$send_back.='"residence":';
			$send_back.='"'.$row['residence'].'"';
			$send_back.=',';
			
			$send_back.='"street":';
			$send_back.='"'.$row['street'].'"';
			$send_back.=',';
			
			$send_back.='"last_name":';
			$send_back.='"'.$row['last_name'].'"';
			$send_back.=',';

			$send_back.='"first_name":';
			$send_back.='"'.$row['first_name'].'"';
			$send_back.=',';

			$send_back.='"skype":';
			$send_back.='"'.$row['skype'].'"';
			$send_back.=',';

			$send_back.='"okitalk":';
			$send_back.='"'.$row['okitalk'].'"';
			$send_back.=',';

			$send_back.='"facebook":';
			$send_back.='"'.$row['facebook'].'"';
			$send_back.=',';

			$send_back.='"last_login":';
			$send_back.='"'.$row['last_login'].'"';
			$send_back.=',';			
			
			
			$send_back.='"test_member":';
			$send_back.='"'.$row['test_member'].'"';
			
			$send_back.="}";
	}
	else { // if login false
		$send_back='{"login":false}';
	}
	echo $send_back;
?>