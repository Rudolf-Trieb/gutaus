<?php 
    //SESSION
    session_start();
	header("Content-Type: text/html; charset=ISO-8859-1");
	include_once('include_0_db_conektion.php');
?>


<script>

	$(document).ready(function(){
	
		$(".mitglied").click(function(){
			var mitglied_ID=$(this).attr("href");
			$.post("include_21_mitglieder_userprofil.php",{Mitglied_ID:mitglied_ID},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			return false;
		
		});
		
		$(".lieferanten").click(function(){
			$("#inhalt").load("include_2_lieferanten.php");
		});
		
	
	});
	
</script>

<?php
	echo "<a style='float:right' class='lieferanten' href='#'>Alle meine Lieferanten/Dienstleister</a> ";
    echo "<h2>Mein Lieferant/Dienstleister <a class='mitglied' href='#'>".$_POST['lieferant']."</a></h2>";
    echo "<h4>Von <a class='mitglied' href='#'>".$_POST['lieferant']."</a> habe ich eine Lieferung/Dienstleistung mit Gutscheinen gekauft</h4>";
	
    echo "<table border='1' cellpadding='1' cellspacing='1'>"; 
    echo " <tr>\n"; 
    echo "  <th>\n";
    echo "gegebner Betrag\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Lieferung/Diestleistung\n";
    echo "  </th>\n";
	echo "  <th>\n";
    echo "Datum\n";
    echo "  </th>\n";
	echo "  <th>\n";
    echo "&Uuml;berweisungsart\n";
    echo "  </th>\n";
	
 
    echo " </tr>\n"; 

    $sql = "SELECT Betrag,Einheit,Verwendungszweck,Datum,Art FROM `ueberweisungen` WHERE von_ID=".$_SESSION['UserID']."
			AND an_Nickname='".$_POST['lieferant']."' 
			ORDER BY Datum DESC";
    
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

    while ($row = mysql_fetch_assoc($result)) { 
            
        // Betrag
        echo " <tr>\n"; 
        echo "  <td align=right style='background-color:#FF3030'>\n";
		echo $row['Betrag']." ".$row['Einheit']."\n";
        echo "  </td>\n";
		
        // Lieferung/Dienstleistung
        echo "  <td>\n";
        echo utf8_decode($row['Verwendungszweck'])."\n";
        echo "  </td>\n";
		
        // Datum       
        echo "  <td>\n";
        echo $row['Datum']."\n";
        echo "  </td>\n";
		
		// Überweisungsart       
        // Datum       
        echo "  <td>\n";
        echo $row['Art']."\n";
        echo "  </td>\n";
   
        echo " </tr>\n"; 
    } 
    echo "</table>"; 
?>