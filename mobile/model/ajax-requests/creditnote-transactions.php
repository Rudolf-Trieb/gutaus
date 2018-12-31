<?php
   //SESSION
    session_start();
	include_once('../includes/include_0_db_conection.php');
	
	if ($_SESSION["login"]) { // if login true
	
		$sql = "(SELECT 
						`an_ID` AS id,
						`an_Nickname` AS name,
						`Betrag`*(-1) AS amount,
						`Verwendungszweck` AS purpose,
						`Datum` As date,
						`Art` AS type
						
				FROM `ueberweisungen`
				WHERE 		`von_ID`='".mysql_real_escape_string(trim($_SESSION['user_id']))."' 
						AND 
							`Einheit`='".mysql_real_escape_string(trim($_SESSION['creditnote']))."')

			UNION 


				(SELECT 
						`von_ID` AS id,
						`von_Nickname` AS name,
						`Betrag` AS amount,
						`Verwendungszweck` AS purpose,
						`Datum` As date,
						`Art` AS type
				FROM `ueberweisungen`
				WHERE 
						`an_ID`='".mysql_real_escape_string(trim($_SESSION['user_id']))."'
					AND 
						`Einheit`='".mysql_real_escape_string(trim($_SESSION['creditnote']))."')

			ORDER By date DESC";
				
		//echo "sql=".$sql;
		$sql_result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		
		// Loop through all creditnotes to create a JSON object
		$send_back="[";
		while ($row = mysql_fetch_assoc($sql_result)) {
			$send_back.="{";
			
			$send_back.='"name":';
			$send_back.='"'.$row['name'].'"';
			$send_back.=',';
			
			$send_back.='"amount":';
			$send_back.='"'.$row['amount'].'"';
			$send_back.=',';
			
			$send_back.='"date":';
			$send_back.='"'.$row['date'].'"';
			$send_back.=',';
			
			$send_back.='"purpose":';
			$send_back.='"'.str_replace('"', '\"', $row['purpose']).'"';		
			$send_back.=',';

			$send_back.='"type":';
			$send_back.='"'.$row['type'].'"';
			
			$send_back.="}";
			$send_back.=',';
		} // end of creditnotes loop
		
		if (substr($send_back, -1, 1)==',') { // if last character is a comma. This is the case is at least one creditnote was found.
			$send_back = substr($send_back, 0, -1); // delete the last character (a comma)
		}
		
		$send_back.="]";
	}
	else { // if login false
		$send_back='[{"login":false}"]';
	}

	$send_back = str_replace("\n", "\\n", $send_back); // escape \n because it isn't allowed in JSON 
    $send_back = str_replace("\r", "\\r", $send_back); // escape \r because it isn't allowed in JSON 
	$send_back = str_replace("\t", "\\t", $send_back); // escape \t because it isn't allowed in JSON 
	//$send_back= utf8_decode(utf8_encode($send_back));
	
	echo $send_back;
?>