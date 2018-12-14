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
		
		$(".Womit").click(function(){
		
			$("#inhalt").load("automatischer_login_logout.php");
			
			var einheit=$(this).attr("href");
			
			$("#Womit").html("Mit "+einheit);
			
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});
			
			$.post("include_5_kontoauszug.php",{Useraufruf:true},function(data){ 
				$("#inhalt").html(data);
			});
			
			$("#bezahlen-an-girokonto").remove();
			$("#ubs-bar").remove();
			if (einheit=="Euro" || einheit=="g Silber" || einheit=="g Gold") {
				$("#an_wen").append("<li><a id='bezahlen-an-girokonto'    href='#'>Auszahlung an ein <br>Girokonto</a></li>");
				$("#an_wen").append("<li><a id='ubs-bar'    href='#'>UBS Bar-Auszahlung</a></li>");
			}
			
			return false;
		});
		
		$(".konten").click(function(){
			$("#inhalt").load("include_2_konten.php");
		});
		
		$(".gutschein").click(function(){
			var einheit=$(this).attr("href");
			$.post("include_2_herausgeber.php",{Einheit:einheit},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			
			return false;
		});		
		
		$(".max_Ueberziehung").click(function(){
		    var Mitglied=$(this).attr("href");
			var max_Ueberziehung=$(this).attr("max_Ueberziehung");
			$.post("include_52_max_ueberziehung.php",{Mitglied:Mitglied,max_Ueberziehung:max_Ueberziehung},function(data){
				$("#inhalt").html(data);
			});
			
			return false;
		});		
		
	
	
	});
	
</script>

<?php

	echo "<a class='konten' href='#' style='float:right'>Meine Konten</a>";
    echo "<h2>Meine Schuldner</h2>";
	echo "<br>";
	echo "<h4>Diese Mitglieder benötige derzeit Gutscheine in deren Besitz ich bin, um ihr(e) Kont(o/en) auszugleichen</a>.</h4>";
//	echo "Herausgeber=".$_SESSION['Herausgeber'];
    echo "<table border='1' cellpadding='1' cellspacing='1'>"; 

    echo " <tr>\n";	
	echo "  <th>\n";
    echo "Kontoinhaber\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Gutschein\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Kontostand\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "max_Ueberziehung\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "max_Akzeptanz\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Umsatz\n";
    echo "  </th>\n";
    echo "  <th>\n";
	echo "Kontoeroeffnung\n";
	echo "  </th>\n";
	
    echo " </tr>\n"; 

	
	
	
	
$sql = "SELECT \n"
	. "ID_Mitglied AS Kontoinhaber_ID,\n"
    . "Nickname AS Kontoinhaber,\n"
    . "Einheit AS Gutschein,\n"
    . "Kontostand,\n"
    . "Gesamtumsatz,\n"
    . "max_Akzeptanz,\n"
    . "max_Ueberziehung,\n"
    . "DATE(Erstellungsdatum) AS Kontoeroeffnung \n"
    . "FROM `konten`\n"
    . "INNER JOIN mitglieder AS m\n"
    . "ON m.ID=ID_Mitglied\n"
	. "WHERE `ID_Mitglied`<>".$_SESSION['UserID']."\n"
	. "AND Tester_Flag=".$_SESSION['Tester_Flag']."\n"
	. "	AND  `Kontostand`<0\n"
	. "	AND  `ID_Einheit` in (SELECT `ID_Einheit` FROM `konten` where `ID_Mitglied`=".$_SESSION['UserID']." and `Kontostand`>0)\n"
	. "ORDER BY `Gutschein`,  `Kontostand` ASC\n";

	
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
	
	$i=0;
	while ($row = mysql_fetch_assoc($result)) { 
          
		echo " <tr>\n"; 
		
		// Kontoinhaber
		echo "  <td align=center>\n";
        echo "<a class='mitglied' href='".$row['Kontoinhaber_ID']."'>".$row['Kontoinhaber']."</a>\n";
        echo "  </td>\n";
		
		// Gutschein
		echo "  <td align=center>\n";
		echo "<a class='Womit' href='".$row['Gutschein']."'>".$row['Gutschein']."</a>\n";
        echo "  </td>\n";
		
		// Kontostand
		if ($row['Kontostand']<0) 
			echo "  <td align=right style='background-color:#FF3030'>\n";
		else 
			echo "  <td align=right style='background-color:#41EE00'>\n";
		echo $row['Kontostand']." \n";
        echo "  </td>\n";
		
		// max. Ueberziehung
		echo "  <td align=right style='background-color:#FF3030'>\n";
		if ($_SESSION['Nickname']==$_SESSION['Herausgeber']) 
			echo "<a class='max_Ueberziehung' max_Ueberziehung='".$row['max_Ueberziehung']."' href='".$row['Kontoinhaber']."'>";
		if ($row['max_Ueberziehung']==0)
			echo "keine erlaubt";
		else
			echo $row['max_Ueberziehung']." \n";
		if ($_SESSION['Nickname']==$_SESSION['Herausgeber']) 
			echo "</a>";
        echo "  </td>\n";
		
		
		// max. Akzeptanz
		echo "  <td align=right style='background-color:#41EE00'>\n";
		if ($row['max_Akzeptanz']==0)
			echo "Alle herausgegebene";
		else
			echo $row['max_Akzeptanz']." \n";
        echo "  </td>\n";
		
		// Mein Umsatz
		echo "  <td align=right>\n";
		echo $row['Gesamtumsatz']." \n";
        echo "  </td>\n";	

		// Eröffnungsdatum
		echo "  <td align=center>\n";
		echo $row['Kontoeroeffnung']." \n";
        echo "  </td>\n";	
		
   
        echo " </tr>\n"; 
		
    } 
	

   
    echo "</table>"; 
?>