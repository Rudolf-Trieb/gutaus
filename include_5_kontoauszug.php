<?php 
    //SESSION
    session_start();
	if (!headers_sent())
		header("Content-Type: text/html; charset=ISO-8859-1");
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
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
		
		$(".konten").click(function(){
			$("#inhalt").load("include_2_konten.php");
		});
		
		
	
	
	});
	
</script>


<?php

	$sql = "SELECT SUM(ABS(Betrag))AS Umsatz FROM `ueberweisungen` \n"
			."WHERE `Einheit`='".mysql_real_escape_string($_SESSION['Einheit'])."' AND ( von_ID ='".mysql_real_escape_string($_SESSION['UserID'])."' OR an_ID ='".mysql_real_escape_string($_SESSION['UserID'])."' )";
	
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
	$row = mysql_fetch_assoc($result);
	
	$_SESSION['Umsatz']=$row['Umsatz'];
	
	echo "<a class='konten' href='#' style='float:right'>Meine Konten</a>";
    echo "<h2>".$_SESSION['Einheit']."-Kontoauszug</h2>";
	echo "<h3>Mein Kontostand: ".$_SESSION['Kontostand']." ".$_SESSION['Einheit']."</h3>";
	echo "<h3>Mein Gesamtumsatz: ".$_SESSION['Umsatz']." ".$_SESSION['Einheit']."</h3>";

    echo "<table border='1' cellpadding='1' cellspacing='1'>";
    echo " <tr>\n";
    
    echo "  <th>\n";
    echo "Nickname\n";
    echo "  </th>\n";
    
    echo "  <th>\n";
    echo "Betrag\n";
    echo "  </th>\n";
    
    echo "  <th>\n";
    echo "Verwendungszweck\n";
    echo "  </th>\n";
    
    echo "  <th>\n";
    echo "Datum\n";
    echo "  </th>\n";
    
    echo "  <th>\n";
    echo "&Uuml;berweisungsart\n";
    echo "  </th>\n";
    

    $sql = "SELECT 
                    von_ID,
                    von_Nickname,
                    an_ID,
                    an_Nickname,
                    Verwendungszweck,
                    Betrag,
                    Datum,
                    Art
            FROM
                    ueberweisungen
            WHERE
                    (    von_ID  ='".mysql_real_escape_string($_SESSION['UserID'])."' 
                     OR  an_ID   ='".mysql_real_escape_string($_SESSION['UserID'])."'
                     )
                     AND Einheit ='".mysql_real_escape_string($_SESSION['Einheit'])."'               
            ORDER BY
                    Datum DESC
           ";
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());

    while ($row = mysql_fetch_assoc($result)) {

        // Abbuchung
        if ($row['von_ID']==$_SESSION['UserID']) { 
            // an_Nickname 
            echo " <tr>\n";
            echo "  <td>\n";
			echo "<a class='mitglied' href='".$row['an_ID']."'>".$row['an_Nickname']."</a>\n";
            echo "  </td>\n";    
            // Betrag Abbuchung
            echo "  <td align='right' style='background-color:#FF3030'>\n";
            echo "-".$row['Betrag']." ".$_SESSION['Einheit']."\n";
            echo "  </td>\n";
        }
        // Gutschrift
        else {
            // von Nickname
            echo " <tr>\n";
            echo "  <td>\n";
            echo "<a class='mitglied' href='".$row['von_ID']."'>".$row['von_Nickname']."</a>\n";
            echo "  </td>\n";

            // Betrag Gutschrift
            echo "  <td align='right' style='background-color:#41EE00'>\n";
            echo $row['Betrag']." ".$_SESSION['Einheit']."\n";
            echo "  </td>\n";            
        }    
        
        // Verwendungszweck
        echo "  <td align='right'>\n";
        echo utf8_decode($row['Verwendungszweck'])."\n";
        echo "  </td>\n";
        
        // Datum der Buchung
        echo "  <td>\n";
        echo $row['Datum']."\n";
        echo "  </td>\n";
        
        // Buchungs-Art (online,an E-Mail,an Handy,per SMS)
        echo "  <td align='right'>\n";
        echo $row['Art']."\n";
        echo "  </td>\n";
        
        echo " </tr>\n";
    }
    echo "</table>";




?>