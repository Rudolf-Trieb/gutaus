<?php
        echo "<select class='einheit-select' name='Einheit'>";
        echo "<option  value='Horus'>Horus</option>";
        echo "<option  value='Euro'>Euro</option>";
		

    // Eigene Einheiten des Users  aus  DB lesen
        $sql = "    SELECT
                 Einheit
        FROM
             einheiten
        WHERE
                ID_Mitglied=".$_SESSION['UserID']."
            AND
                ID>7     
        ORDER BY
             Einheit
        ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		
        while ($row = mysql_fetch_assoc($result)) {
			echo "<option  value='".$row['Einheit']."'>".$row['Einheit']."</option>";			
        }
		
        echo "<option  value='g Silber'>g Silber</option>";
        echo "<option  value='g Gold'>g Gold</option>";

    if (isset($_SESSION['UserID'])) { // Falls nicht eingelogt nicht in DB suchen
        if(!ermittle_ID_Einheit_Von_ID_Herausgeber ($_SESSION['UserID'])) // Falls User noch keine selbst herausgegebene GuTauS hat
            echo "<option value='".$_SESSION['Nickname']."-GuTauS'>".$_SESSION['Nickname']."-GuTauS</option>";
			
    // Fremde Einheiten des Users  aus  DB lesen
        $sql = "    SELECT
                 Einheit
        FROM
             konten
        WHERE
                ID_Mitglied=".$_SESSION['UserID']."
            AND
                ID_Einheit>7 
			AND
				Kontostand>0
        ORDER BY
             Einheit
        ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());

        while ($row = mysql_fetch_assoc($result)) {
            echo "<option  value='".$row['Einheit']."'>".$row['Einheit']."</option>";
        }
        echo "<option  selected='selected' value='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']."</option>";
    
;
     }
     else 
        echo "<option value='Meine Gutscheine'>Meine Gutscheine</option>";
     echo "</select>"
?>