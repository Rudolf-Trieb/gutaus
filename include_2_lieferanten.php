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
		
		$(".was_hat_lieferant_verkauf").click(function(){
			var lieferant=$(this).attr('href');
			$.post("include_2_lieferant.php",{lieferant:lieferant},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			return false;
		
		});
	
	
	});
	
</script>

<?php
    echo "<h2>Meine Lieferanden</h2>";
    echo "<h4>Von diesen Mitglieder habe ich etwas mit Gutscheinen gekauft</h4>";
	
    echo "<table border='1' cellpadding='1' cellspacing='1'>"; 
    echo " <tr>\n"; 
    echo "  <th>\n";
    echo "Lieferant\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Letzer Kontakt\n";
    echo "  </th>\n";
	echo "  <th>\n";
    echo "Anzahl\n";
    echo "  </th>\n";
 
    echo " </tr>\n"; 

    $sql = "SELECT 
				an_ID,
				an_Nickname,
				Datum,
				count(*) AS Anzahl
			FROM `ueberweisungen` 
			WHERE 
				von_Nickname='".$_SESSION['Nickname']."'
			GROUP BY an_Nickname 
			ORDER BY Datum DESC";
    
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

    while ($row = mysql_fetch_assoc($result)) { 
            
        // Kunde
        echo " <tr>\n"; 
        echo "  <td>\n";
		echo "<a class='mitglied' href='".$row['an_ID']."'>".$row['an_Nickname']."</a>\n";

        echo "  </td>\n";
        // Leter Kontakt
        echo "  <td>\n";
        echo $row['Datum']."\n";
        echo "  </td>\n";
        // Anzahl     
        echo "  <td align='center'>\n"; 
		echo "<a class='was_hat_lieferant_verkauf' href='".$row['an_Nickname']."'>".$row['Anzahl']."</a>\n";
        echo "  </td>\n";
   
        echo " </tr>\n"; 
    } 
    echo "</table>"; 
?>