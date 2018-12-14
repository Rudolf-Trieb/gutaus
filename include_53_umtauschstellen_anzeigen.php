<?php 
    header("Content-Type: text/html; charset=ISO-8859-1");
    //SESSION
    session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<?php
	if (isset($_POST['Einheit']))
		$_SESSION['Einheit']=$_POST['Einheit'];
		
	//echo "SESSION['Einheit']=".$_SESSION['Einheit'];
	
	if ($_SESSION['Einheit']=="Horus")
		echo "<h2>Umtauschstellen für <a class='herausgeber'  href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']."</a> Gutscheine (Horus-Partner)</h2>";
	else
		echo "<h2>Umtauschstellen für <a class='herausgeber'  href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']."</a> Gutscheine</h2>";
	
    echo "<table class='draggable' border='1' cellpadding='1' cellspacing='1'>"; 

    echo " <tr>\n";

	echo "  <th>\n";
    echo "Umtauschstelle\n";
    echo "  </th>\n";
	echo "  <th colspan=3>\n";
    echo "Wechselkurs\n";
    echo "  </th>\n";
	echo "  <th>\n";	
    echo "aktuelle max.Akzeptanz\n";
    echo "  </th>\n";
	if ($_SESSION['Kontostand']>0) {
		echo "  <th>\n";
		echo "jetzt umtauschen\n";
		echo "<div id='slider' autofocus></div>";
		echo "<input Id='betrag' type='text' value='".$_SESSION['Kontostand']."'>";
		echo "  </th>\n";
	}
	
    echo " </tr>\n"; 

	
	$sql= "SELECT deal_ID,m.Nickname AS Umtauschstelle, e.Einheit, e2.Einheit AS Ruecktauscheinheit, 
	(von_wk / an_wk) AS Wechselkurs, 
	(an_wk / von_wk * ( k.max_Akzeptanz - k.Kontostand )) AS aktuelle_Akzeptanz
	FROM  `einheiten` AS e
	
	JOIN deals AS d ON e.ID = d.an_ID_einheit
	JOIN einheiten AS e2 ON e2.ID = d.von_ID_einheit
	JOIN mitglieder AS m ON m.ID = e2.ID_Mitglied
	JOIN konten AS k ON k.ID_Mitglied = e2.ID_Mitglied
	
	WHERE e.Einheit =  '".$_SESSION['Einheit']."'
	AND k.ID_einheit = e2.ID
	AND von_ok =1
	AND an_ok =1
	
	UNION 
	
	SELECT deal_ID,m.Nickname AS Umtauschstelle, e.Einheit, e2.Einheit AS Ruecktauscheinheit, 
	(an_wk / von_wk) AS Wechselkurs, 
	(von_wk / an_wk * ( k.max_Akzeptanz - k.Kontostand )) AS aktuelle_Akzeptanz
	FROM  `einheiten` AS e
	
	JOIN deals AS d ON e.ID = d.von_ID_einheit
	JOIN einheiten AS e2 ON e2.ID = d.an_ID_einheit
	JOIN mitglieder AS m ON m.ID = e2.ID_Mitglied
	JOIN konten AS k ON k.ID_Mitglied = e2.ID_Mitglied
	
	WHERE e.Einheit =  '".$_SESSION['Einheit']."'
	AND k.ID_einheit = e2.ID
	AND von_ok =1
	AND an_ok =1
	";
	
	//echo "<br>sql=".$sql;
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error()); 

	$Anz_Umtauschpartner=0;
	while ($row = mysql_fetch_assoc($result)) { 
	
		if ($row['aktuelle_Akzeptanz']>0) { // nur Umtauschstellen die auch noch etwas annehmen anzeigen
		
			$Anz_Umtauschpartner=$Anz_Umtauschpartner+1;
			echo " <tr>\n"; 
			
			// Umtauschstelle
			echo "  <td align=center>\n";
			echo "<a class='mitglied'  href='".$row['Umtauschstelle']."'>".$row['Umtauschstelle']."</a>\n";
			echo "  </td>\n";			
			
			

			
			// Wechselkurs
			echo "  <td>\n";
				echo "1 <a class='herausgeber'  href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']."<a>";
			echo "  </td>\n";
			echo "  <td>\n";
				echo " = ";
			echo "  </td>\n";
			echo "  <td>\n";
				echo $row['Wechselkurs']." <a class='herausgeber'  href='".$row['Ruecktauscheinheit']."'>".$row['Ruecktauscheinheit']."<a>";
			echo "  </td>\n";
			
			// aktuelle max.Akzeptanz
			echo "  <td align=right>\n";
			echo $row['aktuelle_Akzeptanz']." <a class='herausgeber'  href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']."</a>";
			echo "  </td>\n";
			
			// jetzt umtauschen
			if ($_SESSION['Kontostand']>0) {
				echo "  <td align=left>\n";
				//echo "Kurs=<span class='kurs'>".$kurs."</span>";
				echo "<span class='eintauschbetrag'>".$_SESSION['Kontostand']." </span> <a class='herausgeber'  href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']."</a>";
				
				echo "<a class='eintauschen' Deal_ID='".$row['deal_ID']."' Ruecktauscheinheit='".$row['Ruecktauscheinheit']."' href='".$row['Umtauschstelle']."'><img  class='umtausch' style='width:21px' src='images/eintauschen.png'/></a>";
				echo "<span class='ruecktauschbetrag_".$Anz_Umtauschpartner."' wechselkurs='".$row['Wechselkurs']."'>".round($_SESSION['Kontostand']*$row['Wechselkurs'],2)."</span> <a class='herausgeber'  href='".$row['Ruecktauscheinheit']."'>".$row['Ruecktauscheinheit']."</a>";
				echo "  </td>\n";
			}
				
			

					
	   
			echo " </tr>\n"; 
		
		}
		
    } 
	

   
    echo "</table>"; 	
?>



<script>


	$(document).ready(function(){
	
		// $(".draggable").draggable();
		
		$(".herausgeber").click(function(){
			var einheit=$(this).attr("href");
			$.post("include_2_herausgeber.php",{Einheit:einheit},function(data){
				$("#inhalt").html(data);
			});
			
			return false;
		});
		
		$(".mitglied").click(function(){
		
			var mitglied_ID=$(this).attr("href");
			$.post("include_21_mitglieder_userprofil.php",{Mitglied_ID:mitglied_ID},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			
			return false;		
		});
		
		
		$(".eintauschen").click(function(){
			
			
			var deal_ID=$(this).attr("Deal_ID");
			var betrag=encodeURI($("#betrag").val());
			var ruecktauscheinheit=$(this).attr("Ruecktauscheinheit");
			var tauschpartner=$(this).attr("href");
			//alert (deal_ID+" "+betrag+" "+ruecktauscheinheit+" "+tauschpartner);
			//var data="Deal_ID="+deal_ID+"&Eintauschbetrag="+betrag+"&Ruecktauscheinheit="+ruecktauscheinheit+"&Tauschpartner="+tauschpartner;
			//alert (data);
			
			

			
			$.post("include_53_umtauschstelle_eintausch_kontrolle.php",
				{Deal_ID:deal_ID,
				Eintauschbetrag:betrag,
				Ruecktauscheinheit:ruecktauscheinheit,
				Tauschpartner:tauschpartner},
				function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			
			
			
			
			return false;		
		});	
		
		

	
	});
	
	$(function() {
		$( "#slider" ).slider({
		  value:<?php echo $_SESSION['Kontostand'] ?>,
		  min: 0,
		  max: <?php echo $_SESSION['Kontostand'] ?>,
		  step: 0.1,
		  slide: function( event, ui ) {
			$( ".eintauschbetrag" ).html( ui.value );
			$("#betrag").val(ui.value);
			<?php 
				
				while ($Anz_Umtauschpartner > 0 ) {
					echo "var kurs=$('.ruecktauschbetrag_".$Anz_Umtauschpartner."').attr('wechselkurs');";
					echo "$( '.ruecktauschbetrag_".$Anz_Umtauschpartner."' ).html( Math.round(ui.value * kurs*100)/100);";
					$Anz_Umtauschpartner=$Anz_Umtauschpartner-1;
				}	
				
			?>	
		  }
		});
	});
	
</script>
