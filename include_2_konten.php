<?php 
    //SESSION
    session_start();
	//header("Content-Type: text/html; charset=ISO-8859-1");
	header('Content-type: text/html; charset=utf-8');
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>




<script>

	$(document).ready(function(){
		
		$(".Womit").click(function(){
		
			$("#inhalt").load("automatischer_login_logout.php");
			
			var einheit=$(this).attr("href");
			
			
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
		
	
		
		$(".Schuldner").click(function(){
		
			$("#inhalt").load("automatischer_login_logout.php");
		
			var einheit=$(this).attr("href");
			
			
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){ 
				$("#kontostanzanzeige").html(data);
			});
						
			$.post("include_2_schuldner.php",{Einheit:einheit},function(data){
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
		
		$(".Glaeubiger").click(function(){
		
			$("#inhalt").load("automatischer_login_logout.php");
		
			var einheit=$(this).attr("Einheit");
			var schulden=$(this).attr("Schulden")*-1;
			
			
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){ 
				$("#kontostanzanzeige").html(data);
			});
						
			$.post("include_2_glaeubiger.php",{Schulden:schulden,Einheit:einheit},function(data){
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
		
		$(".Umtauschstellen").click(function(){
		
			var einheit=$(this).attr("href");
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});
			$.post("include_53_umtauschstellen_anzeigen.php",{Einheit:einheit},function(data){
					$("#inhalt").html(data);
			});
			
			return false;
			
		});
		
		$(".max_Akzeptanz").click(function(){
		
			var einheit=$(this).attr("Einheit");
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});
			$("#inhalt").load("include_51_max_Akzeptanz.php");
			
			return false;
			
		});
		
		
	
	
	});
	
</script>

<?php
    echo "<h2>Meine Konten</h2>";
	
    echo "<table border='1' cellpadding='1' cellspacing='1'>"; 

    echo " <tr>\n";

	echo "  <th>\n";
    echo "Mein(e) ...\n";
    echo "  </th>\n";
	echo "  <th>\n";
    echo "Umtausch-<br>stellen\n";
    echo "  </th>\n";
	echo "  <th>\n";	
    echo "Gutschein\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Kontostand\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "max. Ueberziehung\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "max. Akzeptanz\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Mein Umsatz\n";
    echo "  </th>\n";
    echo "  <th>\n";
    echo "Er&ouml;ffnungsdatum\n";
    echo "  </th>\n";
	echo "  </th>\n";
	
    echo " </tr>\n"; 

	
	$sql = "SELECT \n"
    . "Kontostand,k.Einheit AS Einheit,k.max_Ueberziehung AS max_Ueberziehung,k.Gesamtumsatz AS Umsatz,\n"
    . "k.max_Akzeptanz AS max_Akzeptanz,  DATE_FORMAT(k.Erstellungsdatum, '%d.%m.%Y') AS Eröffnungsdatum,\n"
    . "e.ID_Mitglied AS Herausgeber,e.Definition,\n"
    . "e.Erstellungsdatum AS Herausgabedatum\n"
    . "FROM `konten` AS k \n"
    . "INNER JOIN einheiten AS e\n"
    . "ON k.ID_Einheit=e.ID\n"
    . "WHERE k.ID_Mitglied=".$_SESSION['UserID']."\n"
    . "ORDER BY k.Kontostand";
    
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 
	
	while ($row = mysql_fetch_assoc($result)) { 
          
		echo " <tr>\n"; 
		
		// Mein(e) ...
		echo "  <td align=center>\n";
		if ($row['Kontostand']<0) {
			echo "<a class='Glaeubiger' Schulden='".$row['Kontostand']."' Einheit='".$row['Einheit']."' href='#'>Gl&auml;ubiger</a>\n";
		}
		elseif ($row['Kontostand']>0)
			echo "<a class='Schuldner' Kontostand='".$row['Kontostand']."' href='".$row['Einheit']."'>Schuldner</a>\n";		
		else
			echo "keine\n";
		
        echo "  </td>\n";	
		
		// Umtauschstellen
		echo "  <td align=center>\n";
		
		$Anz=Umtauschstellen_Anz(ermittle_ID_Einheit ($row['Einheit']));
		if ($Anz>0)
			echo "<a class='Umtauschstellen' href='".$row['Einheit']."'>".$Anz."</a>\n";
		else
			echo $Anz;
        echo "  </td>\n";
		
		// Einheit
		echo "  <td align=right>\n";
        echo "<a class='Womit' href='".$row['Einheit']."'>".$row['Einheit']."</a>\n";
        echo "  </td>\n";
		
		// Kontostand
		if ($row['Kontostand']<0) 
			echo "  <td align=right style='background-color:#FF3030'>\n";
		else 
			echo "  <td align=right style='background-color:#41EE00'>\n";
		echo $row['Kontostand']." \n";
        echo "  </td>\n";
		
		// max. Ueberziehung
		if ($row['max_Ueberziehung']==0) {
			echo "  <td align=center style='background-color:#FF3030'>\n";
			echo "keine erlaubt";
		}
		else {
			echo "  <td align=right style='background-color:#FF3030'>\n";
			echo $row['max_Ueberziehung']." \n";
		}
        echo "  </td>\n";
		
		// max. Akzeptanz
		
		if ($row['Kontostand']<0) {
			$max_Akzeptanz=$row['max_Akzeptanz']+abs($row['Kontostand']);
		}
		else {
			$max_Akzeptanz=$row['max_Akzeptanz'];
		}
		echo "  <td align=right style='background-color:#41EE00'>\n";
		echo "<a class='max_Akzeptanz' Einheit='".$row['Einheit']."' href='#'>".$max_Akzeptanz."</a> \n";
        echo "  </td>\n";
		
		// Mein Umsatz
		echo "  <td align=right>\n";
		echo $row['Umsatz']." \n";
        echo "  </td>\n";	

		// Eröffnungsdatum
		echo "  <td align=center>\n";
		echo $row['Eröffnungsdatum']." \n";
        echo "  </td>\n";			
   
        echo " </tr>\n"; 
		
    } 
	

   
    echo "</table>"; 	
?>