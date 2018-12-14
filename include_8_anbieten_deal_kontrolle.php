<?php   
	// FORMDATEN an PHP ÜBERGEBEN
	parse_str($_POST['formdata'],$Formulardaten);
	
     // Prüfe, Wechselkurs
    if(trim($Formulardaten['wechselkurszahl_1'])=='' or trim($Formulardaten['wechselkurszahl_2'])=='')
           $errors[]= "Bitte geben Sie einen Wechselkurs ein.";
    else { // Ja ==> Prüfe ob, Format Wechselkurs ok  
        if(!preg_match('/^\d*([\.,]\d{1,2})?$/',trim($Formulardaten['wechselkurszahl_1'])) or !preg_match('/^\d*([\.,]\d{1,2})?$/',trim($Formulardaten['wechselkurszahl_2']))) 
            $errors[]= "Bitte geben Sie einen Wechselkur in Form von Zahlen (auch Kommazahlen sind erlaubt) ein"; 
		else { // Ja ==> wechselkurszahlen in SESSION setzen
			$_SESSION['wechselkurszahl_1']=str_replace(",",".",$Formulardaten['wechselkurszahl_1']);
			$_SESSION['wechselkurszahl_2']=str_replace(",",".",$Formulardaten['wechselkurszahl_2']);
        }  // ENDE  
    } // ENDE Prüfe Wechselkurs 
	
	// Prüfen, Eigeneinheit
	if(trim($Formulardaten['Eigeneinheit'])=='') 
		$errors[]= "Bitte geben Sie einen ihrer Gutscheine an";
	else {
		$_SESSION['Eigeneinheit']=$Formulardaten['Eigeneinheit'];	 
	}		

	
	// Prüfen, akzeptanz 2 Fremdeinheit
	if(trim($Formulardaten['min_akzeptanz_2'])=='') 
		$errors[]= "Bitte geben Sie einen wie viele <b>".$_SESSION['Fremdeinheit']."</b> Gutscheine Sie maximal akzeptieren.";
	else {
		if(!preg_match("/^[0-9]+$/",trim($Formulardaten['min_akzeptanz_2']))) 
            $errors[]= "Bitte geben Sie <b>in ganzen Zahlen</b> ein wie viele <b>".$_SESSION['Fremdeinheit']."</b> Gutscheine Sie maximal akzeptieren."; 
		else { // Ja ==> min_akzeptanz_2 in SESSION setzen
			$_SESSION['min_akzeptanz_2']=$Formulardaten['min_akzeptanz_2'];
        }  // ENDE  					 
	}	
	
	// Prüfen, akzeptanz 1 Eigeneinheit
	if(trim($Formulardaten['min_akzeptanz_1'])=='')
		$errors[]= "Bitte geben Sie einen wie viele Ihrer Gutschein ".$_SESSION['Mitglied']." zu dem angebotenen Wechselkurs mindestens akzeptieren soll.";
	else {	
		if(!preg_match("/^[0-9]+$/",trim($Formulardaten['min_akzeptanz_1']))) 
            $errors[]= "Bitte geben Sie <b>in ganzen Zahlen</b> ein wie viele Ihrer Gutschein ".$_SESSION['Mitglied']." zu dem angebotenen Wechselkurs mindestens akzeptieren soll."; 
		else { // Ja ==> min_akzeptanz_1 in SESSION setzen
			$_SESSION['min_akzeptanz_1']=$Formulardaten['min_akzeptanz_1'];
        }  // ENDE  
	}
	
	// Prüfen, akzeptanz 1 Eigeneinheit
	if($_SESSION['Eigeneinheit']==$_SESSION['Fremdeinheit'])
		$errors[]= "Es ist nicht möglich einen Wechselkurs zwischen gleichen Gutscheinen festzulegen!";
	

	// Prüfen, Passwort ok
	if (!Passwort_OK($_SESSION['UserID'],$Formulardaten["passwort"])) { // Passwort ok
		$errors[]="Passwort nicht oder falsch eingeben!";
	}
?>