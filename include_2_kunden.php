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
		
		$(".was_habe_ich_verkauf").click(function(){
			var kunde=$(this).attr('href');
			$.post("include_2_kunde.php",{kunde:kunde},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			return false;
		
		});
	
	
	});
	
</script>

<?php
    echo "<h2>Meine Kunden</h2>";
    echo "<h4>Für Gutscheine haben diese Kunden Waren oder Diensleistungen von mir gekauft oder gemietet.</h4>";
	
    echo "<table border='1' cellpadding='1' cellspacing='1'>"; 
    echo " <tr>\n"; 
    echo "  <th>\n";
    echo "Kunde\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Letzer Kontakt\n";
    echo "  </th>\n";
	echo "  <th>\n";
    echo "Anzahl\n";
    echo "  </th>\n";
 
    echo " </tr>\n"; 

    $sql = "SELECT 
				von_ID,
				von_Nickname,
				Datum,
				count(an_Nickname) AS Anzahl
			FROM `ueberweisungen` 
			WHERE 
				an_Nickname='".$_SESSION['Nickname']."' 
			GROUP BY von_Nickname 
			ORDER BY Datum DESC";
    
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

    while ($row = mysql_fetch_assoc($result)) { 
            
        // Kunde
        echo " <tr>\n"; 
        echo "  <td>\n";
		echo "<a class='mitglied' href='".$row['von_ID']."'>".$row['von_Nickname']."</a>\n";

        echo "  </td>\n";
        // Leter Kontakt
        echo "  <td>\n";
        echo $row['Datum']."\n";
        echo "  </td>\n";
        // Anzahl      
        echo "  <td align='center'>\n"; 
		echo "<a class='was_habe_ich_verkauf' href='".$row['von_Nickname']."'>".$row['Anzahl']."</a>\n";
        echo "  </td>\n";
   
        echo " </tr>\n"; 
    } 
    echo "</table>"; 
?>