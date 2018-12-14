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

// Deal Zustimmen
		if ($_SESSION['Deal_art']<>3) // kein gültigeer Deal
			deal_zustimmen ($_SESSION['Deal_ID'],$_SESSION['Eigeneinheit_ID']);
		
// Erfolgsmeldung anzeigen
		
		
		echo "Ihr soeben erstelltes Deal-Angebot wurde nicht gesendet!<br><br>";
		
		switch ($_SESSION['Deal_art'])
		{
		case -3: // abgelehnter Deal
		  // Entscheitungsformular Gegenüberstellung abgelehnter Deal und aktueller Angebotener-Deal des Users
		  echo "Sie haben den zunächst von Ihnen abgelehten Deal-Angebot jetzt doch noch";
		  echo " zugestimmt. <br>";
		  echo "<a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> hat diesen Deal bereits einmal abgelehnt.";
		  echo "<br>Er hat aber weiterhin die Möglichkeit diesen Deal anzunehmen.";
		  break;
		case -1: // abgelehnter Deal
		  echo "Sie haben den zunächst von Ihnen abgelehten Deal-Angebot jetzt doch noch";
		  echo " zugestimmt.";
          
		  if(deal_art ($_SESSION['Deal_ID'],$_SESSION['Eigeneinheit_ID'])==3)
			 echo " Glückwunsch, dieser Deal ist nun gültig.<br>";
		  else
			 echo "Solte <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> diesen Deal auch zugestimmt, dann wird dieser Deal gültig.";

			 break;
		case -2: // abgelehnter Deal
		  echo "Das bereits von <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a>"; 
		  echo " abgelehntes Deal-Angebot wurde nochmals gesendet";
		  break;
		case 0: // offener Vorschlags-Deal
		  echo "Sie haben den vom System vorgeschlagenen Deal zugestimmt.<br>";
		  echo "<a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> hat nun die Möglichkeit dieses vom Sytem vorgeschlagenen Deal-Angebot ebenfalls zu akzeptieren , abzulehnen oder ein Gegen-Angebot zu senden.";

		  break;
		case 1: // halboffener Deal
		  echo "Ihr altes Deal-Angebot wurde nochmals gesendet.<br> ";
		  echo "<a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> hat weiterhin die Möglichkeit Ihr altes Deal-Angrebot zu akzeptiern, abzulehnen oder ein Gegen-Deal-Angebot zu senden.";
		  break;
		case 2: // halboffener Deal
		  echo "Glückwunsch, Sie haben den Deal-Angebot von <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a>";
		  echo " zugestimmt, damit ist dieser Deal gültig.";

		  break;
		case 3: // halboffener Deal
		  echo "<br>Ihr alter Deal mit <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> bleibt weiterhin gültig.";
		  break;
		}	

		include('include_8_deal_anzeigen.php');		
		
		
		

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