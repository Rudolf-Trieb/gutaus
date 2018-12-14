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
		
		$(".sort").click(function(){
			var sortieren=$(this).attr("href");
			$.post("include_2_mitglieder.php",{Sortieren:sortieren},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			return false;
		});
		
	
	});
	
</script>




<?php
    echo "<h2>Mitglieder</h2>";

    echo "<table border='1' cellpadding='1' cellspacing='1'>"; 
    echo " <tr>\n"; 
    echo "  <th>\n";
    echo "<a class='sort' href='PLZ,Wohnort,Nickname ASC'>PLZ</a>\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "<a class='sort' href='Wohnort,PLZ,Nickname ASC'>Wohnort</a>\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "<a class='sort' href='Nickname'>Nickname</a>\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "<a class='sort' href='Registrierungsdatum DESC'>Registrierungs-<br>Datum</a>\n"; 
    echo "  </th>\n"; 
    echo "  <th>\n"; 
    echo "<a class='sort' href='Letzter_Login DESC'>Letzter Login</a>\n"; 
    echo "  </th>\n"; 
    echo "  <th>\n"; 
    echo " \n"; 
    echo "  </th>\n"; 
    echo " </tr>\n"; 

    $sql = "SELECT 
                    ID, 
                    SessionID, 
                    PLZ,
                    Wohnort,
                    Nickname, 
                    DATE_FORMAT(Registrierungsdatum, '%d.%m.%Y') as Datum, 
                    Letzter_Login, 
                    Letzte_Aktion 
            FROM 
                    mitglieder
            WHERE
                    Tester_Flag=".$_SESSION['Tester_Flag'];


	if (isset($_POST['Sortieren']))
		$sql.= " ORDER BY 
                    ".$_POST['Sortieren']; 	
	else
		$sql.= " ORDER BY 
                    PLZ,Wohnort,Nickname ASC 
           "; 
		   
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

    while ($row = mysql_fetch_assoc($result)) { 
        // existiert eine Session ID und der User 
        // war nicht länger als 2 Minuten inaktiv, so wird er als online betrachtet
        if($row['SessionID'] AND (time()-60*2 < $row['Letzte_Aktion'])) 
            $online = "<span style=\"color:green\">online</span>\n"; 
        else 
            $online = "<span style=\"color:#FF3030\">offline</span>\n"; 
            
        // PLZ
        echo " <tr>\n"; 
        echo "  <td>\n";
        echo $row['PLZ']."\n";

        echo "  </td>\n";
        // Wohnort
        echo "  <td>\n";
        echo $row['Wohnort']."\n";
        echo "  </td>\n";
        // Nickname
        echo "  <td>\n";
        echo "<a class='mitglied' href='".$row['ID']."'>".$row['Nickname']."</a>\n";
        echo "  </td>\n";
        // Registrierungsdatum       
        echo "  <td align='center'>\n"; 
        echo $row['Datum']."\n"; 
        echo "  </td>\n";
        // Letzter Login 
        echo "  <td>\n"; 
        echo date('d.m.Y H:i \U\h\r', $row['Letzter_Login'])."\n"; 
        echo "  </td>\n";
        // online? 
        echo "  <td>\n"; 
        echo $online; 
        echo "  </td>\n"; 
        echo " </tr>\n"; 
    } 
    echo "</table>"; 
?>