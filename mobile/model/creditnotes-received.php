<?php
   //SESSION
    session_start();
	include_once('include_0_db_conection.php');
	
	if ($_SESSION["login"]==1) {
	
		$sql = "SELECT  
						k.ID_Einheit AS creditnote_id,
						k.Kontostand AS account_balance, 
						e.Einheit AS creditnote,
						k.max_Ueberziehung AS credit_limit,
						k.max_Akzeptanz AS acceptance_limit,
						k.Gesamtumsatz AS total_turnover,
						e.Nachkommastellen
 
				FROM konten AS k 
				
				JOIN einheiten AS e ON e.ID=k.ID_Einheit
				
				WHERE k.ID_Mitglied='".mysql_real_escape_string(trim($_SESSION['user_id']))."'
				AND  e.ID_Mitglied<>'".mysql_real_escape_string(trim($_SESSION['user_id']))."'
				AND  e.Einheit<>'Horus'
				AND  e.Einheit<>'Euro'
				
				ORDER BY creditnote";
		//echo "sql=".$sql;
		$sql_result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		$send_back="[";
		while ($row = mysql_fetch_assoc($sql_result)) {
			$send_back.="{";
			
			$send_back.='"account_balance":';
			$send_back.='"'.$row['account_balance'].'"';
			$send_back.=',';
			
			$send_back.='"name":';
			$send_back.='"'.$row['creditnote'].'"';
			$send_back.=',';

			$send_back.='"decimal_digits":';
			$send_back.='"'.$row['Nachkommastellen'].'"';
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
			$send_back.=',';
		} // end of creditnotes loop
		
		if (substr($send_back, -1, 1)==',') { // if last character is a comma. This is the case is at least one creditnote was found.
			$send_back = substr($send_back, 0, -1); // delete the last character (a comma)
		}
		
		$send_back.="]";
	}
	else { // if login false
		$send_back='[{"login":false}]';
	}
	echo $send_back;
?>