<?php 
    //SESSION
    session_start();
	header("Content-Type: text/html; charset=ISO-8859-1");
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<script>

	$(function() {
		$( ".gutschein-tabs" ).tabs({heightStyle: "content"});
	});
	
	
</script>

<?php
		//echo "		<h3>".$_SESSION['Kontostand']." ".$_SESSION['Einheit']."</h3>";
		echo "		<div class='gutschein-tabs'>";
		echo "			<ul>";
		echo "				<li><a href='include_5_kontoauszug.php'>Umsätze</a></li>";
		if ($_SESSION['Nickname']==$_SESSION['Herausgeber'])
				echo "		<li><a href='include_2_schuldner.php'>Schuldner</a></li>";
		if ($_SESSION['Kontostand']<>0) {
			if ($_SESSION['Kontostand']>0) 
				echo "		<li><a href='include_2_schuldner.php'>Schuldner</a></li>";
			else
				echo "		<li><a href='include_2_glaeubiger.php'>Gläubiger</a></li>";
		}
		echo "				<li><a href='include_21_mitglieder_userprofil.php'>Herausgeber</a></li>";
		if ($_SESSION['Nickname']<>$_SESSION['Herausgeber'])
			echo "			<li><a href='include_51_max_akzeptanz.php'>max. Akzeptanz</a></li>";
		echo "				<li><a href='include_2_herausgeber.php'>Wert ".$_SESSION['Einheit']."</a></li>";
		if ($_SESSION['Einheit']=="Euro" Or $_SESSION['Einheit']=="g Silber" Or $_SESSION['Einheit']=="g Gold") {	
			echo "			<li><a href='include_10_aufladen.php'>Aufladen</a></li>";
			echo "			<li><a href='include_9_auszahlung.php'>Auszahlen</a></li>";
		}
		$Umtauschstellen_Anz=Umtauschstellen_Anz($_SESSION['ID_Einheit']);
		if ($Umtauschstellen_Anz>0)
			echo "			<li><a href='include_53_umtauschstellen_anzeigen.php'>Umtauschstellen:".$Umtauschstellen_Anz."</a></li>";	
		if ($_SESSION['Nickname']==ermittle_Herausgeber_Von_Einheit ($_SESSION['Einheit']))
			echo "		<li><a href='include_8_deals_panel.php'>Deals</a></li>";
		echo "			</ul>";
		echo "		</div>";
		
?>