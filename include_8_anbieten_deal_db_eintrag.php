<?php

        
// Prüfe, ob ein Deal bereits existiert
	$_SESSION['Deal_ID']=ermittle_deal_ID($_SESSION['Eigeneinheit'],$_SESSION['Fremdeinheit']);
	$_SESSION['Eigeneinheit_ID']=ermittle_ID_Einheit ($_SESSION['Eigeneinheit']);
	$_SESSION['Fremdeinheit_ID']=ermittle_ID_Einheit ($_SESSION['Fremdeinheit']);

	
	if ($_SESSION['Deal_ID']) { // Ein Deal ist schon vorhanden
		
		echo "<h2>Entscheidung für einen Deal erforderlich!</h2>";
		$_SESSION['Deal_art']=deal_art ($_SESSION['Deal_ID'],$_SESSION['Eigeneinheit_ID']);
		
		
		$Dealart=deal_art_als_text ($_SESSION['Deal_art']);
		
// MEIN AKTUELLES DEAL ANGEBOT
		  echo "<div id='aktueller_Deal' style='float:left; width:30% background-color: #ffffc6'>";
		  
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
		  
		  echo "<tr>";
		  echo "<th colspan=3>";
		  echo "<a class='anbieten_gegen_deal' href=#>Diesen Deal-Angebot zustimmen<br> und an ".$_SESSION['Mitglied']." senden</a>";
		  echo "<br>oder";
		  echo "<br><a class='anbieten_deal' href='".$_SESSION['Fremdeinheit']."'>Deal-Angebot ändern</a>";
		  echo "</th>";
		  echo "</tr>";		  
		  
		  echo "</table>";
		  
		  echo "</div>";

// ODER 
		  echo "<div style='float:left; width:16%; padding: 0px auto; margin: 28px ; background-color: #ffffc6'><h2><= oder =></h2></div>";		  
		  
		  
		  
// ODER FRÜHERES DEAL ANGEBOT
	
	    echo "<div id='frueherer_Deal' style='float:right; width:30% background-color: #ffffc6'>";
			include('include_8_deal_anzeigen.php');
		echo "</div>";
	}	
	else { // kein Deal ist vorhanden
		// Deal-Angebot in DB eintragen
		deal_anlegen ($_SESSION['Eigeneinheit_ID'],$_SESSION['Fremdeinheit_ID'],$_SESSION['wechselkurszahl_1'],$_SESSION['wechselkurszahl_2'],1,
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
		
		
		echo "Ihr Deal-Angebot wurde an <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> gesendet!<br>";		
		echo "<br><br><a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> hat nun die Möglichkeit ihr Deal-Angrebot zu akzeptiern, abzulehnen oder ein Gegen-Angebot zu senden.";

		
		
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

		}

?>