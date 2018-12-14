
<script>
	$(document).ready(function(){
	
		$("#bezahlen-ausfuehren").click(function(){
			$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("automatischer_login_logout.php");
			$("#inhalt").load("include_6_bezahlen_db_eintrag_und_empfaenger_info.php");
		});	
	
		$("#bezahlen-abbrechen").click(function(){
			$("#inhalt").load("include_6_bezahlen_an_formular.php");
		});
	
	
	});
</script>

<?php
        
// FORMULAR     
    echo "<form ".
     " name=\"Bezahlen\" ".
     " accept-charset=\"ISO-8859-1\">\n";
 
    // Sie möchte 
	echo "<br>\n";
    echo "<table border='0' cellpadding='0' cellspacing='0'>";    
    echo "<tr>"; 
    echo "<td calspan=3>";  
    echo "Sie m&ouml;chten ".$_SESSION['Betrag']." ".$_SESSION['Einheit'].
         " an ".$_SESSION['Ueberweisungsart']." ".$_SESSION['Empfaenger']." bezahlen?";
    echo "</td>";
    echo "</tr>";
    
    
    
    echo "<tr>";
    echo "<td calspan=3>";
    echo "<h3>Verwendungszweck :</h3>";
    echo $_SESSION['Verwendungszweck'];
    echo "</td>";
    echo "</tr>";   
    
	echo "<tr>";
    echo "<td calspan=3>";
    echo "<br><br>********************************************************************<br>";
    echo "</td>";
    echo "</tr>";   
	
                           
    echo "<tr>";
    echo "<td>";
  	echo "<a id='bezahlen-ausfuehren' href='#' title='Zahlung wird ausgef&uuml;hrt, wenn m&ouml;glich!'>ja, jetzt bezahlen</a>"; 
    echo " oder ";
	echo "<a id='bezahlen-abbrechen' href='#' title='Zahlung wird nicht ausgef&uuml;hrt!'>Nein, abbrechen</a>"; 
	echo "</td>";
    
    echo "</tr>";
                                                     
    echo"</table>";
    
    echo "</form>\n";   
?>




