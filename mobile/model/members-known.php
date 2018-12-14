<?php
   //SESSION
    session_start();
	include_once('include_0_db_conection.php');
	
	if ($_SESSION["login"]==1) {
		
		$sql="SELECT  von_Nickname AS Nickname,
					  von_ID AS ID
			FROM ueberweisungen
			WHERE 
			an_ID='".mysql_real_escape_string(trim($_SESSION['user_id']))."'

			UNION

			SELECT  an_Nickname AS Nickname,
					  an_ID AS ID
			FROM ueberweisungen
			WHERE 
			von_ID='".mysql_real_escape_string(trim($_SESSION['user_id']))."'
			GROUP BY Nickname
			ORDER BY Nickname";
			
		
		//echo "sql=".$sql;
		$sql_result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		// Prüft, ob wirklich genau ein Datensatz gefunden wurde
		$send_back="[";
		while ($row = mysql_fetch_assoc($sql_result)) {
			$send_back.="{";
			$send_back.='"name":';
			$send_back.='"'.$row['Nickname'].'"';
			
			$send_back.=',';				
			$send_back.='"id":';
			$send_back.='"'.$row['ID'].'"';
		
			$send_back.="}";
			$send_back.=',';
		}
		$send_back = substr($send_back, 0, -1); // delete the last character (a comma)
		$send_back.="]";
	}
	else {
		$send_back="logtout";
	}
	echo $send_back;
	

	

	
	
	
// Funktionen++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ENDE Funktionen++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

?>