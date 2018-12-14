<?php
        
// max_Akzeptanz in der DB-Tabelle konten updaten
    if ($_SESSION["Mitglied"]=='') {
		aendere_max_Ueberziehung($_SESSION['UserID'],mysql_real_escape_string($_SESSION['max_Ueberziehung']),$_SESSION['Einheit']);       
		// Erfolgsmeldung anzeigen             
		echo "Vielen Dank!\n<br>".
         "Ihre maximale Üeberziehung f&uuml;r ".trim($_SESSION['Einheit'])." Gutscheine wurde erfolgreich auf <b>"
         .$_SESSION['max_Ueberziehung']." ".trim($_SESSION['Einheit'])."</b> ge&auml;ndert.";
	}
	else {
		aendere_max_Ueberziehung(ermittle_Nickname_ID($_SESSION["Mitglied"]),mysql_real_escape_string($_SESSION['max_Ueberziehung']),$_SESSION['Einheit']);       
		// Erfolgsmeldung anzeigen             
		echo "Vielen Dank!\n<br>".
         "Die maximale Üeberziehung für ".trim($_SESSION['Einheit'])." Gutscheine wurde erfolgreich für <b>".$_SESSION["Mitglied"]."</b> auf <b>"
         .$_SESSION['max_Ueberziehung']." ".trim($_SESSION['Einheit'])."</b> ge&auml;ndert.";
		 $_SESSION["Mitglied"]='';
	}		
   // Weiterleitung($_SERVER['PHP_SELF']."?Content_Ebene_0=Kontoauszug&LoginStatus=1",7000);                  
?>