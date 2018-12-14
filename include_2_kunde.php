<?php 
    //SESSION
	header("Content-Type: text/html; charset=ISO-8859-1");
    session_start();
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
		
		$(".kunden").click(function(){
			$("#inhalt").load("include_2_kunden.php");
		});
		
	
	});
	
</script>


<?php
	echo "<a style='float:right' class='kunden' href='#'>Alle meine Kunden</a> ";
    echo "<h2>Mein Kunde <a class='mitglied' href='#'>".$_POST['kunde']."</a></h2>";
    echo "<a class='mitglied' href='#'>".$_POST['kunde']."</a> hat mir Gutscheine für meine Lieferungen/Dienstleistung gegeben</h4>";
	
    echo "<table border='1' cellpadding='1' cellspacing='1'>"; 
    echo " <tr>\n"; 
    echo "  <th>\n";
    echo "erhaltener Betrag\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Meine Lieferung/Dienstleistung";
    echo "  </th>\n";
	echo "  <th>\n";
    echo "Datum\n";
    echo "  </th>\n";
	echo "  <th>\n";
    echo "&Uuml;berweisungsart\n";
    echo "  </th>\n";
	
 
    echo " </tr>\n"; 

    $sql = "SELECT Betrag,Einheit,Verwendungszweck,Datum,Art FROM `ueberweisungen` WHERE an_ID=".$_SESSION['UserID']."
			AND von_Nickname='".$_POST['kunde']."' 
			ORDER BY Datum DESC";
    
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

    while ($row = mysql_fetch_assoc($result)) { 
            
        // Betrag
        echo " <tr>\n"; 
        echo "  <td align=right style='background-color:#41EE00'>\n";
		echo $row['Betrag']." ".$row['Einheit']."\n";
        echo "  </td>\n";
		
        // Meine Lieferung/Dienstleistung
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