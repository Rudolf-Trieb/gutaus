<?php
   //SESSION
    session_start();
	include_once('../includes/include_0_db_conection.php');
		
	if ($_SESSION["login"]) { // if login true
	
		$_SESSION['creditnote_chosen_id']=$_REQUEST['creditnote_chosen_id']; // Get sended creditnote_chosen_id
		//$_SESSION['creditnote_chosen_decimal_digits']=$_REQUEST['creditnote_chosen_decimal_digits']; // Get sended creditnote_chosen_id
		
				
		$sql="SELECT  
						k.ID_Einheit AS creditnote_id,
						k.Kontostand AS account_balance, 
						e.Einheit AS creditnote,
						e.privat_Gutschein AS privat,
						e.ID_Mitglied AS publisher_id,
						e.Nachkommastellen AS decimal_digits,
						k.max_Ueberziehung AS credit_limit,
						k.max_Akzeptanz AS acceptance_limit,
						Gesamtumsatz AS total_turnover
 
				FROM konten AS k

				JOIN einheiten AS e ON e.ID=k.ID_Einheit
				
				
				WHERE k.ID_Mitglied='".mysql_real_escape_string(trim($_SESSION['user_id']))."'
				  AND k.ID_Einheit=".mysql_real_escape_string(trim($_SESSION['creditnote_chosen_id']));
				  
		//echo "sql=".$sql;
		$sql_result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		
		// Loop through all creditnotes to create a JSON object
		$row = mysql_fetch_assoc($sql_result);
			$send_back.="{";
			
			$send_back.='"account_balance":';
			$send_back.='"'.$row['account_balance'].'"';
			$send_back.=',';
			
			$send_back.='"name":';
			$send_back.='"'.$row['creditnote'].'"';
			$send_back.=',';
			$_SESSION['creditnote']=mysql_real_escape_string(trim($row['creditnote']));
			
			$send_back.='"privat":';
			$send_back.='"'.$row['privat'].'"';
			$send_back.=',';
			
			$send_back.='"publisher_id":';
			$send_back.='"'.$row['publisher_id'].'"';
			$send_back.=',';			
			
			$send_back.='"decimal_digits":';
			$send_back.='"'.$row['decimal_digits'].'"';
			$send_back.=',';
			
			$send_back.='"id":';
			$send_back.='"'.$row['creditnote_id'].'"';
			$send_back.=',';

			$send_back.='"credit_limit":';
			$send_back.='"'.$row['credit_limit'].'"';
			$send_back.=',';
			
			$send_back.='"acceptance_limit":';
			$send_back.='"'.$row['acceptance_limit'].'"';
			$send_back.=',';
			
			$send_back.='"total_turnover":';
			$send_back.='"'.$row['total_turnover'].'"';
			
			$send_back.="}";
	}
	else { // if login false
		$send_back='{"login":false}';
	}
	echo $send_back;
?>