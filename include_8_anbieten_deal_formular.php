

<?php


	   echo "<form ".
			 " name=\"anbieten_deal\" ".
			 " accept-charset=\"ISO-8859-1\">\n";

		echo "<h2>Mein angebotener Deal an <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a>: </h2>\n";
			 
		echo "<table>";

		echo "<tr>";
		echo "<th calspan=3>";

		echo "Mein angebotener Wechselkurs: ";
		
		echo "<input type=\"text\" name=\"wechselkurszahl_1\" STYLE='text-align:right' size='5' maxlength=\"10\" value=\"".$_SESSION['wechselkurszahl_1']."\">\n";
		
		include('include_0_eigeneinheiten_select_box.php');

		echo " = ";
		
		echo "<input type=\"text\" name=\"wechselkurszahl_2\" STYLE='text-align:right' size='5' maxlength=\"10\" value=\"".$_SESSION['wechselkurszahl_2']."\">\n";
		
		
		echo " <b>".$_SESSION['Fremdeinheit']."</b>";
		
		echo "</th>";
		echo "</tr>";
		

		echo "<tr>";
		echo "<td calspan=3>";
		echo "<br>Zu diesen Wechselkurs werde ich zukünftig mindestens ";															
		echo "<input type=\"text\" name=\"min_akzeptanz_2\" STYLE='text-align:right' size='5' maxlength=\"10\" value=\"".$_SESSION['min_akzeptanz_2']."\">\n";
		echo " <b>".$_SESSION['Fremdeinheit']."</b>";
		echo " akzeptieren, <br>wenn auch <a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> mindestens ";
		echo "<input type=\"text\" name=\"min_akzeptanz_1\" STYLE='text-align:right' size='5' maxlength=\"10\" value=\"".$_SESSION['min_akzeptanz_1']."\">\n";
		echo " <b>meiner</b>";
		echo " Gutscheine zum oben genannten Wechselkurs akzeptiert.<br><br>";
		echo "</td>"; 
		echo "</tr>";	
		
		
		
		echo "<tr>";
		echo "<td calspan=3>";
		echo "Passwort ist erforderlich:";
		echo "<input type='password' name='passwort' STYLE='text-align:right' size='5' maxlength='35' >\n";
        echo "<br><br>";		
		echo "</td>"; 
		echo "</tr>";	

		echo "<tr>";
		echo "<th calspan=3>";	
		echo "<a class=\"anbieten_deal\" href='#'>Dieses Angebot an <b>".$_SESSION['Mitglied']."</b> senden</a>";
		echo "</th>";    
		echo "</tr>";
		
		echo "</table>";

		

		echo "</form>\n";
	


?>