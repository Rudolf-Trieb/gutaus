<?php 

//  if ($_POST['Ueberweisungsart']<>''){ // Formular vom User aufgerufen
    //SESSION
    session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
//  }

?>

<script language="javascript" type="text/javascript" src="js/bezahlen_pruefen.js"></script>

<?php 


  
  if ($_POST['Ueberweisungsart']<>'') { 
	$_SESSION['Ueberweisungsart']=$_POST['Ueberweisungsart'];
	$_SESSION['Empfaenger']='';
  }
  elseif ($_GET['Ueberweisungsart']<>'') { 
	$_SESSION['Ueberweisungsart']=$_GET['Ueberweisungsart'];
	$_SESSION['Empfaenger']='';
  }  
  //echo $_GET['Ueberweisungsart'];
//  if ($_GET['Ueberweisungsart']<>'') 
//	$_SESSION['Ueberweisungsart']="An Mitglied";
  
  //echo "<h2>".$_SESSION['Ueberweisungsart']." bezahlen</h2>";
  
  
// FORMULAR    
    echo "<form accept-charset=\"ISO-8859-1\">\n";
 
    // Ich möchte    
    echo "
               <table border='0' cellpadding='0' cellspacing='0'>
               <tr align=center>
               <td>Ich m&ouml;chte ";
               
     // Betrag
    echo "<input title='&Uuml;berweisungs-Betrag' autofocus style=\"text-align: right\" type=\"text\" name=\"Betrag\" size=\"3\" value=\"",$_SESSION['Betrag'],"\"> \n";                       
      
    // Einheit
        include('include_0_einheiten_select_box.php');  
  
  
  
	if ($_SESSION['Ueberweisungsart']=="Mitglied") {

		// an          
		echo" an das Mitglied ";
				 
		// Empfänger Nickname 
	  
		// Alle Nicknames  aus  DB lesen (Tester oder Aktive)
		$sql = "    SELECT
				 Nickname
		FROM
			 mitglieder
		WHERE
			Tester_Flag=".$_SESSION['Tester_Flag']."
			AND ID<>".$_SESSION['UserID']."
		ORDER BY
			 Nickname
		";
		$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
			echo "<select name='Empfaenger'>";
			while ($row = mysql_fetch_assoc($result)) {
				echo "<option>".$row['Nickname']."</option>";
			}

		echo "<option selected='selected'>".$_SESSION['Empfaenger']."</option>";

		echo "</select>";      
    } 
	
	elseif ($_SESSION['Ueberweisungsart']=="Email"){
	
		// an          
		echo" an die Email ";
	     // Empfäner Email
		echo "<input title='Email des Empf&auml;ngers' style=\"text-align: right\" type=\"text\" name=\"Empfaenger\" size=\"20\" value=\"",$_SESSION['Email_Empfaenger'],"\"> \n";                       
	} 
	
	elseif ($_SESSION['Ueberweisungsart']=="Handy"){
	
		// an          
		echo" an die Handynummer ";
	     // Empfäner Email
		echo "<input title='Handynummer des Empf&auml;ngers' style=\"text-align: right\" type=\"text\" name=\"Empfaenger\" size=\"20\" value=\"",$_SESSION['Handynummer_Empfaenger'],"\"> \n";                       	
	} 
		
                
    // überweisen.         
	echo  " &uuml;berweisen.<br>
		</td>
		</tr>";                            
					
	// Verwendungszweck
	echo "<tr>";
	echo "<td colspan=8>";
	echo "<span style=\"font-weight:bold;\" >".
		 "Verwendungszweck :<br>\n".
		 "</span>\n";
			echo "<textarea name=\"Verwendungszweck\" rows=\"2\" cols=\"50\" >",$_SESSION['Verwendungszweck'],"</textarea>";
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<th calspan=7>";
	echo "<input type='hidden' name='Ueberweisungsart' value='".$_SESSION['Ueberweisungsart']."'>";
	echo "<a class=\"pruefen\" href='#'>pr&uuml;fen ob Zahlung m&ouml;glich</a>";
	echo "</th>";
	echo "</tr>";
						
			
                    
	echo"</table>";
    
    echo "</form>\n";    
  

?>