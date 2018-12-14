<?php
    //SESSION
    session_start();
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<script language="javascript" type="text/javascript" src="js/bezahlen_pruefen.js"></script>

<h2>An ein Girokonto</h2>
<?php
// FORMULAR
    echo "<form accept-charset=\"ISO-8859-1\">\n";

    // Ich möchte
    echo "
               <table border='0' cellpadding='0' cellspacing='0'>
               <tr align=left>
               <td>Ich m&ouml;chte ";

     // Betrag
    echo "<input title='&Uuml;berweisungs-Betrag' autofocus style=\"text-align: right\" type=\"text\" name=\"Betrag\" size=\"3\" value=\"",$_SESSION['Betrag'],"\">\n";

    // Einheit
    echo " Euro";

    // an
    echo" an das Girokonto:<br> ";




    // Empfänger

	echo "<br>Kontoinhaber:";
	echo "<input title='Kontoinhaber' autofocus style=\"text-align: right\" type=\"text\" name=\"Kontoinhaber\" size=\"20\" value=\"",$_SESSION['Kontoinhaber'],"\">\n";

	echo "<br><br>Kontonummer:";
	echo "<input title='Kontonummer' autofocus style=\"text-align: right\" type=\"text\" name=\"Kontonummer\" size=\"20\" value=\"",$_SESSION['Kontonummer'],"\">\n";


	echo "<br><br>BLZ:";
	echo "<input title='Bankleitzahl' autofocus style=\"text-align: right\" type=\"text\" name=\"BLZ\" size=\"20\" value=\"",$_SESSION['BLZ'],"\">\n";



      // bezahlen.
			echo  "<br><br>&uuml;berweisen.<br><br>
                </td>
                </tr>";

                // Verwendungszweck
                echo "<tr>";
                echo "<td colspan=8>";
                echo "<span style=\"font-weight:bold;\" >".
                     "Verwendungszweck :<br>\n".
                     "</span>\n";
                        echo "<textarea name=\"Verwendungszweck\" rows=\"2\" cols=\"50\" >",$_SESSION['Verwendungszweck'],"</textarea>";
                echo "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td calspan=7>";
				echo "<input type='hidden' name='Ueberweisungsart' value='an email'>";
				echo "<a id=\"pruefen\" href='#'>pr&uuml;fen ob Zahlung m&ouml;glich</a>";
                // echo "<input id=\"pruefen\" type=\"submit\" name=\"submit\" value=\"jetzt pr&uuml;fen\">\n";
                echo "</td>";
                echo "</tr>";



	echo"           </table>

    ";

    echo "</form>\n";
?>




