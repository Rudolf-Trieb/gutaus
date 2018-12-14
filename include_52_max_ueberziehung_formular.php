<script>
	$(document).ready(function(){
				
		$(".herausgeber").click(function(){
			var einheit=$(this).attr("href");
			$.post("include_2_herausgeber.php",{Einheit:einheit},function(data){

				$("#inhalt").html(data);
			});
			return false;
		});	
		
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

	// Prüfen ob $_SESSION["Nickname"] auch der Herausgeber von $_SESSION['Einheit'] ist
	if($_SESSION["Nickname"]==$_SESSION["Herausgeber"]) {
	
		if ($_POST["Mitglied"]==$_SESSION["Nickname"]) {
			echo "<h2>Meine maximale ".$_SESSION['Einheit']." Überziehung</h2>";	
		}
		elseif  (!$_POST["Mitglied"]=='') {
			echo "<h2>Maximale ".$_SESSION['Einheit']." Überziehung von ".$_POST["Mitglied"]."</h2>"; 
			$_SESSION["Mitglied"]=$_POST["Mitglied"];
			$_SESSION['max_Ueberziehung']=$_POST["max_Ueberziehung"];
		}
		else {// kein POST[Mitglied] ==> Formular wird wegen Fehler noch mal aufgerufen
			if ($_SESSION["Mitglied"]==$_SESSION["Nickname"]) 
				echo "<h2>Meine maximale ".$_SESSION['Einheit']." Überziehung</h2>";
			else
				echo "<h2>Maximale ".$_SESSION['Einheit']." Überziehung von ".$_SESSION["Mitglied"]."</h2>";
		}


	   echo "<form ".
			 " name=\"max_ueberziehung\" ".
			 " accept-charset=\"ISO-8859-1\">\n";


		echo "<table>";

		echo "<tr>";
		echo "<td calspan=2>";
		if ($_SESSION["Mitglied"]==$_SESSION["Nickname"])
			echo "Meine Maximale <b>".$_SESSION['Einheit']."</b> Üeberziehung auf\n";
		else {
			echo "Maximale <b>".$_SESSION['Einheit']."</b> Üeberziehung von <b>".$_SESSION["Mitglied"]."</b> auf \n";
		}
		echo "<td>";

		echo "<td>";
		echo "<input type=\"text\" name=\"max_ueberziehung\" STYLE='text-align:right' size='5' maxlength=\"10\" value=\"".$_SESSION['max_Ueberziehung']."\">\n";
		echo " <b>".$_SESSION['Einheit']."</b> &auml;ndern";
		echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td calspan=2>";
		echo "Ihr Passwort ist erforderlich:";
		echo "</td>"; 
		echo "<td >";	
		echo "<input type='password' name='passwort' STYLE='text-align:right' size='5' maxlength='35' >\n";
		echo "</td>";    
		echo "</tr>";	

		echo "<tr>";
		echo "<td calspan=3>";	
		echo "<a class=\"max_ueberziehung_pruefen\" href='#'>jetzt &auml;ndern</a>";
		echo "</td>";    
		echo "</tr>";
		
		echo "</table>";

		

		echo "</form>\n";
	
	}
	else {
		echo "Sie können ihre <a class='herausgeber' href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']." </a>\n Gutschein max. Überziehung nicht ändern, ";
		echo "weil sie nicht der Herausgeber der ".$_SESSION['Einheit']." Gutscheine sind!.<br>";
		echo "Bitte wenden Sie sich an <a class='mitglied' href='".$_SESSION['Herausgeber']."'>".$_SESSION['Herausgeber']."</a> den Herausgber der ".$_SESSION['Einheit']." Gutscheine.";
	
	}


?>