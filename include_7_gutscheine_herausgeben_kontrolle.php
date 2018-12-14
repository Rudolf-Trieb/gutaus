<?php
//Gutscheinname
     // Prüfe ob, Gutscheinname eingegeben
     if(trim($Formulardaten['Gutscheinname'])=='')
        $errors[]= "Bitte geben Sie an Wie Ihr Gutschein heißen soll!";
     // Prüfen ob, das Wort Horus vorkommt
     // Prüfen ob, ein Nickname außer der Eigene vorkommt
     // Prüfen ob es die Einheit schon gibt
     elseif (ermittle_ID_Einheit (trim($Formulardaten['Gutscheinname'])))
         $errors[]= "Ein Gutschein mit der Bezeichnung <b>".trim($Formulardaten['Gutscheinname'])."</b> ist bereits vergeben!";
     else
        $_SESSION['Gutscheinname']=htmlentities(mysql_real_escape_string(trim($Formulardaten['Gutscheinname'])));
		
// Gutscheinart Euro ..
	if (htmlentities(mysql_real_escape_string(trim($Formulardaten['euro_Gutschein'])))==1)
		$_SESSION['euro_Gutschein']=1;
	else	
		$_SESSION['euro_Gutschein']=0;
	
// Definition
     // Prüfe ob, Definition eingegeben
     if(trim($Formulardaten['Definition'])=='')
        $errors[]= "Bitte geben Sie an was einer Ihrer Gutscheine wert ist!";
     else
        $_SESSION['Definition']= htmlentities(mysql_real_escape_string(trim($Formulardaten['Definition'])));


//max_Ueberziehung
     // Prüfe, ob max_Ueberziehung eingegebn
     if(trim($Formulardaten['max_Ueberziehung'])=='')
           $errors[]= "Bitte geben Sie an wieviele Gutscheine Sie maximal in den Umlauf bringen wollen!.";
     else { // Ja ==> Prüfe ob, Format max_Ueberziehung ok
        if(!preg_match('/^\d+([\.,]\d{1,2})?$/',trim($Formulardaten['max_Ueberziehung'])))
            $errors[]= "Bitte geben Sie eine maximale Anzahl (ohne Buchstaben und ohne Sonderzeichen) f&uuml;r die Gutscheine die Sie in Umlauf brigen wollen an!";
        else
          $_SESSION['max_Ueberziehung']=mysql_real_escape_string(trim($Formulardaten['max_Ueberziehung']))*(-1);
      }

     
//max_Akzeptanz      
     // Prüfe, ob max_Akzeptanz eingegebn
     if(trim($Formulardaten['max_Akzeptanz'])=='')
           $errors[]= "Bitte geben Sie an wieviele Ihrer Gutscheine eine Person maximal besitzen darf!";
     else { // Ja ==> Prüfe ob, Format max_Ueberziehung ok
        if(!preg_match('/^\d+([\.,]\d{1,2})?$/',trim($Formulardaten['max_Akzeptanz'])))
            $errors[]= "Bitte geben Sie eine Anzahl (ohne Buchstaben und ohne Sonderzeichen) f&uuml;r die maximale Anzahl an Gutscheinen die eine Person besitzen darf!";
        else 
          $_SESSION['max_Akzeptanz']=mysql_real_escape_string(trim($Formulardaten['max_Akzeptanz']));
     }   

// private Gutscheine
	 $_SESSION['privat_Gutschein']=mysql_real_escape_string(trim($Formulardaten['privat_Gutschein']));
	 if ($_SESSION['privat_Gutschein']<>1)
						$_SESSION['privat_Gutschein']=0; // öffenlicher Gutschein
	 
	 //$errors[]= "privat_Gutschein:".$_SESSION['privat_Gutschein'];
	 
?>