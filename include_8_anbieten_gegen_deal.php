<?php

	header("Content-Type: text/html; charset=ISO-8859-1");

	//SESSION
	session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<script>
	$(document).ready(function(){
						
		$(".mitglied").click(function(){
			var mitglied=$(this).attr("href");
			$.post("include_21_mitglieder_userprofil.php",{Mitglied_ID:mitglied_ID},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});
		
		
	});
</script>


<?php

// Alten Deal mit Gegen Angebot überschreiben

		deal_updaten ($_SESSION['Deal_ID'],$_SESSION['Eigeneinheit_ID'],$_SESSION['Fremdeinheit_ID'],$_SESSION['wechselkurszahl_1'],$_SESSION['wechselkurszahl_2'],1,
								 0,$_SESSION['min_akzeptanz_1'],$_SESSION['min_akzeptanz_2'],0);
		
		
		
// Erfolgsmeldung anzeigen
		
		  echo "<table>";
		  
		  echo "<tr>";
		  echo "<th colspan=3>";
		  echo "Mein neues Deal-Angebot an <br><a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a>";
		  echo "</th>";
		  echo "</tr>";
		  
		  echo "<tr>";
		  echo "<td>";
		  echo "Wechselkurs";
		  echo "</td>";
		  echo "<td>";
		  echo ": ";
		  echo "</td>";
		  echo "<td>";
		  echo $_SESSION['wechselkurszahl_1']." ".$_SESSION['Eigeneinheit']." = ".$_SESSION['wechselkurszahl_2']." ".$_SESSION['Fremdeinheit'];
		  echo "</td>";
		  echo "</tr>";
		  
		  echo "<tr>";
		  echo "<td>";
		  echo "Meine min. Akzeptanz";
		  echo "</td>";
		  echo "<td>";
		  echo ": ";
		  echo "</td>";
		  echo "<td>";
		  echo $_SESSION['min_akzeptanz_2']." ".$_SESSION['Fremdeinheit'];
		  echo "</td>";
		  echo "</tr>";
		  
		  echo "<tr>";
		  echo "<td>";
		  echo "<a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> min. Akzeptanz";
		  echo "</td>";
		  echo "<td>";
		  echo ": ";
		  echo "</td>";
		  echo "<td>";
		  echo $_SESSION['min_akzeptanz_1']." ".$_SESSION['Eigeneinheit'];
		  echo "</td>";
		  echo "</tr>";
		    
		  echo "</table>";		
		
		
		echo "Ihr neues Deal-Angebot wurde an <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> gesendet!<br>";
		if ($_SESSION['Deal_art']<>3) 
			echo "<br>Ein älteres ".$_SESSION['Eigeneinheit']."-".$_SESSION['Fremdeinheit']."-Deal-Angebot wurde gelöscht";
		else
			echo "<br>Der bisher  gültige ".$_SESSION['Eigeneinheit']."-".$_SESSION['Fremdeinheit']."-Deal wurde gelöscht";
		
		echo " <br><a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> hat nun die Möglichkeit ihr neues Deal-Angrebot zu akzeptiern, abzulehnen oder ein Gegen-Angebot zu senden.";

// SESSION Deal-Daten löschen
	$_SESSION['Deal_ID']='';
	$_SESSION['Deal_art']='';
	$_SESSION['Eigeneinheit_ID']='';
	$_SESSION['Fremdeinheit_ID']='';
	$_SESSION['Eigeneinheit']='';
	$_SESSION['Fremdeinheit']='';
	$_SESSION['Mitglied']='';
	$_SESSION['wechselkurszahl_1']='';
	$_SESSION['wechselkurszahl_2']='';
	$_SESSION['min_akzeptanz_1']='';
	$_SESSION['min_akzeptanz_2']='';
	
?>