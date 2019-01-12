<?php
   //SESSION
    session_start();
	include_once('../includes/include_0_db_conection.php');
	
	if ($_SESSION["login"]==1) {
		$members_filter = $_REQUEST['members_filter']; // Get send search string
        //echo "members_filter=".$members_filter;
        
        /*  Alternative approach *************************************************************************************
        SELECT COUNT( u.ID ) AS Anzahl, SUM( u.Betrag ) AS Ausgegeben, u.Einheit AS Gutschein, e.ID_Mitglied AS ID_Herausgeber
        FROM ueberweisungen AS u
        INNER JOIN einheiten AS e ON u.Einheit = e.Einheit
        WHERE u.von_ID =7
        GROUP BY u.Einheit
        ORDER BY  `u`.`Einheit` ASC
        *****************************************************************************************************************
        */
        /*  Actually executed *************************************************************************************
        SELECT k.ID AS ID_Konto, e.ID_Mitglied AS ID_Schuldner, m.Nickname AS Schuldner,ROUND( k.Kontostand, e.Nachkommastellen ) AS Kontostand,k.ID_Einheit,k.Einheit
        FROM konten AS k
        INNER JOIN einheiten AS e ON k.ID_Einheit = e.ID
        INNER JOIN mitglieder AS m ON m.ID = e.ID_Mitglied
        WHERE k.ID_Mitglied =7
        AND k.Kontostand >0
        AND e.ID_Mitglied !=7
        AND m.Nickname LIKE '%%'
        ORDER BY Schuldner,k.Einheit
        */
		
        $sql= "SELECT ";
        $sql.=  "k.ID AS ID_Konto,";
        $sql.=  "e.ID_Mitglied AS ID_Schuldner,";
        $sql.=  "m.Nickname AS Schuldner,";
        $sql.=  "ROUND( k.Kontostand, e.Nachkommastellen ) AS Kontostand,";
        $sql.=  "k.ID_Einheit,";
        $sql.=  "k.Einheit ";

        $sql.="FROM konten AS k ";
        $sql.="INNER JOIN einheiten AS e ON k.ID_Einheit = e.ID ";
        $sql.="INNER JOIN mitglieder AS m ON m.ID = e.ID_Mitglied ";

        $sql.="WHERE ";
        $sql.=      "k.ID_Mitglied =".$_SESSION['user_id']." ";
        $sql.=  "AND ";	
        $sql.=      "k.Kontostand >0 ";
        $sql.=  "AND ";
        $sql.=      "e.ID_Mitglied !=".$_SESSION['user_id']." ";
        $sql.=  "AND ";
        $sql.=      "m.Nickname LIKE '%".mysql_real_escape_string(trim($members_filter))."%' ";

        $sql.=" ORDER BY Schuldner,k.Einheit; ";
         



		//echo "sql=".$sql;
		$sql_result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		$send_back="[";
		while ($row = mysql_fetch_assoc($sql_result)) {
			$send_back.="{";
			$send_back.='"ID_Konto":';
			$send_back.='"'.$row['ID_Konto'].'"';
			
			$send_back.=',';				
			$send_back.='"ID_Schuldner":';
            $send_back.='"'.$row['ID_Schuldner'].'"';
            
			$send_back.=',';				
			$send_back.='"Schuldner":';
            $send_back.='"'.$row['Schuldner'].'"';  
            
			$send_back.=',';				
			$send_back.='"Kontostand":';
            $send_back.='"'.$row['Kontostand'].'"'; 
            
			$send_back.=',';				
			$send_back.='"ID_Einheit":';
            $send_back.='"'.$row['ID_Einheit'].'"';

			$send_back.=',';				
			$send_back.='"Einheit":';
            $send_back.='"'.$row['Einheit'].'"';
            

		
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