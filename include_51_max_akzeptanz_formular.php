<?php
   echo "<form ".
		 " name=\"max_Akzeptanz\" ".
		 " accept-charset=\"ISO-8859-1\">\n";


    echo "<table>";

    echo "<tr>";
    echo "<td calspan=2>";
    echo "Meine Maximale <b>".$_SESSION['Einheit']."</b> Akzeptanz auf\n";
    echo "<td>";

    echo "<td>";
    echo "<input type=\"text\" name=\"max_Akzeptanz\" STYLE='text-align:right' size='5' maxlength=\"10\" value=\"".$_SESSION['max_Akzeptanz']."\">\n";
    echo " <b>".$_SESSION['Einheit']."</b> ";
	if ($_SESSION['Kontostand']<0) {
		echo "zuz&uuml;glich <b>".abs($_SESSION['Kontostand'])." ".$_SESSION['Einheit']."</b> die ich selbst noch schulde ";
	}
	echo "&auml;ndern";
    echo "</td>";
    echo "</tr>";

	echo "<tr>";
    echo "<td calspan=3>";	
	echo "<a class=\"max_Akzeptanz_pruefen\" href='#'>jetzt &auml;ndern</a>";
	echo "</td>";
    echo "</tr>";
	
    echo "</table>";

	

    echo "</form>\n";
?>