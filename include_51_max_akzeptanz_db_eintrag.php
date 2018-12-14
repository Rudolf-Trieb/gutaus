<?php
        
// max_Akzeptanz in der DB-Tabelle konten updaten
    aendere_max_Akzeptanz($_SESSION['UserID'],mysql_real_escape_string($_SESSION['max_Akzeptanz']),$_SESSION['Einheit']);       
 // Erfolgsmeldung anzeigen           
            
    echo "Vielen Dank!\n<br>".
         "Ihre maximale Akzeptanz f&uuml;r ".trim($_SESSION['Einheit'])." wurde erfolgreich auf <b>"
         .$_SESSION['max_Akzeptanz']." ".trim($_SESSION['Einheit'])."</b> ge&auml;ndert.";
   // Weiterleitung($_SERVER['PHP_SELF']."?Content_Ebene_0=Kontoauszug&LoginStatus=1",7000);                  
?>