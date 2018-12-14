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
		
		$(".anbieten_deal").click(function(){
			var fremdeinheit=$(this).attr("href");
			$.post("include_8_anbieten_deal.php",{Fremdeinheit:fremdeinheit},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});
	
	
	});
	
</script>


<?php
	//*********HERAUSGEBER*********************
	
	if ($_POST['Einheit']<>'')
		$_SESSION['Einheit']=$_POST['Einheit'];  

	if ($_POST['Mitglied_ID']<>'')
		$sql = "SELECT e.ID AS ID_Einheit,e.Einheit,e.ID_Mitglied AS ID_Herausgeber,e.privat_Gutschein AS privat_Gutschein,"
		. "Nickname AS Herausgeber,Definition AS Wert,DATE(Erstellungsdatum) AS Herausgabedatum FROM `einheiten` AS e\n"
		. "INNER JOIN mitglieder AS m\n"
		. "ON e.ID_Mitglied=m.ID\n"
		. "WHERE m.ID='".$_POST['Mitglied_ID']."'";		
	else
		$sql = "SELECT e.ID AS ID_Einheit,e.Einheit,e.ID_Mitglied AS ID_Herausgeber,e.privat_Gutschein AS privat_Gutschein,"
		. "Nickname AS Herausgeber,Definition AS Wert,DATE(Erstellungsdatum) AS Herausgabedatum "
		. "FROM `einheiten` AS e\n"
		. "INNER JOIN mitglieder AS m\n"
		. "ON e.ID_Mitglied=m.ID\n"
		. "WHERE e.Einheit='".$_SESSION['Einheit']."'";
    
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

	echo "<table border='0' cellpadding='1' cellspacing='1'>";
	
    while ($row = mysql_fetch_assoc($result)) {
	
		echo "<tr>";
		echo "<th>";
		echo "<h3>Gutschein: ".$row['Einheit']."</h3>";
		if ($row['Herausgeber']<>$_SESSION['Nickname']) {
			echo "<a class='anbieten_deal' href='".$row['Einheit']."'>Jetzt Deal zu meinen Gutscheinen anbieten</a>";
		}
		echo "</th>";
		echo "</tr>";	

		echo "<tr>";
		echo "<td>";

		echo "<table border='0' cellpadding='1' cellspacing='1'>";

		echo "<tr>";
		echo "<th>";	
		echo "Gutschein:";
		echo "</th>";
		echo "<td align='center'>";
		echo "<input disabled type='text' size=12 maxlength=12 value='".$row['Einheit']."'>";	
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<th>";		
		echo "<a class='mitglied' href='".$row['ID_Herausgeber']."'>Herausgeber:</a>";
		echo "</th>";
		echo "<td align='center'>";	
		echo "<input disabled type='text' size=12 maxlength=12 value=".$row['Herausgeber'].">";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<th>";			
		echo "Herausgabedatum:";
		echo "</th>";
		echo "<td align='center'>";	
		echo "<input  disabled type='text' size=12 maxlength=12 value=".$row['Herausgabedatum'].">";
		echo "</td>";
		echo "</tr>";
		
		echo "<tr>";	
		echo "<td colspan=2>";	
		echo "<br>Wert von einen ".$row['Einheit'].":";
		echo "<br><textarea disabled cols=35 rows=5>".$row['Wert']."</textarea>";
		echo "</td>";
		echo "</tr>";
		
		echo "<tr>";	
		echo "<td colspan=2>";	
		echo "<br>Der ".$row['Einheit']." ist ein ";
		if ($row['privat_Gutschein']==1) {
			echo "<b>privater Gutschein</b>. <br>Er kann nur an Personen weitergegebenen werden die beits ein <br><b>".$row['Einheit']."-Konto</b> besitzen.";
		}
		else {
			echo "<b>&ouml;ffentlicher Gutschein</b>. <br>Er kann an alle Personen weitergegebenen werden die eine <br>E-Mail-Adresse oder eine Handynummer haben.";
		}
		echo "</td>";
		echo "</tr>";
		
		
		echo "</table>";
        echo "<br><br>";
		echo "</td>";
		echo "</tr>";

           
    } 
	
	echo "</table>";
    
?>