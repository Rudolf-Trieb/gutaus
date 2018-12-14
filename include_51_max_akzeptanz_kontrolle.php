<?php   
	// FORMDATEN an PHP �BERGEBEN
	parse_str($_POST['formdata'],$Formulardaten);	

     // Pr�fe, ob Betrag eingegebn
     if(trim($Formulardaten['max_Akzeptanz'])=='')
           $errors[]= "Bitte geben Sie einen maximalen Akzeptanz-Betrag ein.";
     else { // Ja ==> Pr�fe ob, Format Betrag ok
        if(!preg_match('/^\d+([\.,]\d{1,2})?$/',trim($Formulardaten['max_Akzeptanz']))) 
            $errors[]= "Bitte geben Sie einen maximalen Akzeptanz-Betrag der Form 1234,70 oder 1234 ein.";  
        else { // Ja ==> Pr�fe ob, max_Akzeptanz nicht gr��er als max_Akzeptanz_Standard vom Herrausgeber           
            $sql = "SELECT
                         max_Akzeptanz_Standard
                    FROM
                         einheiten
                    WHERE
                         Einheit     = '".mysql_real_escape_string($_SESSION['Einheit'])."'
                ";
            $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
            $row = mysql_fetch_assoc($result);          
            if ($row['max_Akzeptanz_Standard']-trim($Formulardaten['max_Akzeptanz'])<0) {
                $errors[]="Der ".$_SESSION['Einheit']."-Herausgeber  erlaubt derzeit <b>".$row['max_Akzeptanz_Standard'].
                          " ".$_SESSION['Einheit']."</b> als h&ouml;chsten Betrag den eine einzelne Person im besitz haben darf.<br>";
            }
            else {
                $_SESSION['max_Akzeptanz']=trim($Formulardaten['max_Akzeptanz']);
            } 
            
    
        }  // ENDE Pr�fe ob, max_Akzeptanz nicht gr��er als max_Akzeptanz_Standard vom Herrausgeber 
         
     } // ENDE Pr�fe ob, Format Betrag ok              
?>