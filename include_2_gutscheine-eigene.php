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
	
	
		$(".Gutschein").click(function(){
		
			//$("#inhalt").load("automatischer_login_logout.php");
			
			var einheit=$(this).attr("Einheit");
			
					
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});
			
			$("#bezahlen-an-girokonto").remove();
			$("#ubs-bar").remove();
			if (einheit=="Euro" || einheit=="g Silber" || einheit=="g Gold") {
				$("#an_wen").append("<li><a id='bezahlen-an-girokonto'    href='#'>Auszahlung an ein <br>Girokonto</a></li>");
				$("#an_wen").append("<li><a id='ubs-bar'    href='#'>UBS Bar-Auszahlung</a></li>");
			}
			
			return false;
		});
	
		
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

		
	
	
	});
	
</script>



<div class="gutschein-tabs">

<?php

    echo "<h2>Meine eigenen Gutscheine</h2>";
	echo "<h4>Gutscheine die ich <u>selbst herausgebracht</u> habe.</h4>";

	$sql = "SELECT \n"
    . "Kontostand,k.Einheit AS Einheit,k.max_Ueberziehung AS max_Ueberziehung,k.Gesamtumsatz AS Umsatz,\n"
    . "k.max_Akzeptanz AS max_Akzeptanz,DATE(k.Erstellungsdatum) AS Eröffnungsdatum,\n"
    . "e.ID_Mitglied AS Herausgeber,e.Definition,\n"
    . "e.Erstellungsdatum AS Herausgabedatum\n"
    . "FROM `konten` AS k \n"
    . "INNER JOIN einheiten AS e\n"
    . "ON k.ID_Einheit=e.ID\n"
    . "WHERE k.ID_Mitglied=".$_SESSION['UserID']."\n"
	. "AND e.ID_Mitglied=".$_SESSION['UserID']."\n"
	. ""
    . "ORDER BY k.Kontostand";
	
    
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

	// GUTSCHEIN-TABS erzeugen
	$i=0;
	echo "<ul>";
	//echo "<li ><a class='Gutschein' Tab-Nr='1' Einheit='".$_SESSION['Einheit']."' href='#tab-nr-".$i."'>".$_SESSION['Kontostand']." ".$_SESSION['Einheit']."</a></li>";
	while ($row = mysql_fetch_assoc($result)) {
		if ($_SESSION['Einheit']==$row['Einheit']) // ermittle Tabindex der activen Session Einheit
			$_SESSION['Tab-Nr']=$i;
		$i++;
		echo "<li ><a class='Gutschein' Tab-Nr='".$i."'Einheit='".$row['Einheit']."' href='include_2_gutscheine-panel.php'>".$row['Kontostand']." ".$row['Einheit']."</a></li>";
	}
	if ($_SESSION['Tab-Nr']==0) { // active Session Einheit nicht in Tabs
		mysql_data_seek($result, 0); 
		$row=mysql_fetch_assoc($result);
		$_SESSION['Einheit']=$row['Einheit']; // Mache erste Tab Einheit zur aktiven Session Einheit
		$_SESSION['ID_Einheit']=ermittle_Einheit_ID ($_SESSION['Einheit']);
		$_SESSION['Herausgeber']=ermittle_Herausgeber_Von_Einheit ($_SESSION['Einheit']);
	}
	if ($i==0)
		echo "    <li ><a class='Gutschein' Tab-Nr='".$i."'Einheit='".$row['Einheit']."' href='include_7_gutscheine_herausgeben_formular.php'>Eigenen ".$_SESSION['Nickname']." Taler herausgeben</a></li>";
	else
		echo "    <li ><a class='Gutschein' Tab-Nr='".$i."'Einheit='".$row['Einheit']."' href='include_7_gutscheine_herausgeben_formular.php'>Weiteren GuTauS Gutschein herausgeben</a></li>";
	
	$i++; // Tab-Zähler erhöhen	
	if(check_Euro_Gutschein_herausgegeben ($_SESSION['UserID'])==0)
		echo "    <li ><a class='Gutschein' Tab-Nr='".$i."'Einheit='".$row['Einheit']."' href='include_7_gutscheine_herausgeben_formular_euro.php'>Eigenen <b>".$_SESSION['Nickname']."-Euro</b> Gutschein herausgeben</a></li>";	
	echo "</ul>";																		   
	
?>		
	
</div>	

<script>
	$(function() {
		//alert ("Tab_Nr=<?php echo $_SESSION['Tab-Nr'];?>");
		//alert ("Sesion Einheit=<?php echo $_SESSION['Einheit'];?>");
		$( ".gutschein-tabs" ).tabs({ active: <?php echo $_SESSION['Tab-Nr']; $_SESSION['Tab-Nr']=0; ?>, heightStyle: "content" });
	});
</script>