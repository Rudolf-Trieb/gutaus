<?php
    
     
    // Prüfen, ob das Formular gesendet wurde 
    if($_SESSION['Content_Ebene_1']=='Login_Kotrolle'){
        echo "<h2>Login Kontrolle</h2>"; 
        // Falls der Nickname und das Passwort übereinstimmen..
		$_SESSION['Einheit']="Horus";   
        include('include_30_login_kontrolle.php');      
    } 
    // Ansonsten ... 
    else { 
        //echo "<h2>Login</h2>";
        // ... Anzeige des Login-Formulars
        include('include_30_login_formular.php');
    } 
?>