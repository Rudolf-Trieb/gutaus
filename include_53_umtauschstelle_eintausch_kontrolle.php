<?php 
	header("Content-Type: text/html; charset=ISO-8859-1");
    //SESSION
    session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>


<?php   
	// Eintauschbetrag an PHP �BERGEBEN
	
	 $_SESSION['Deal_ID']=$_POST['Deal_ID'];
	 $_SESSION['Eintauschbetrag']=str_replace(",",".",$_POST['Eintauschbetrag']);
	 $_SESSION['Tauschpartner']=$_POST['Tauschpartner'];
	 $_SESSION['Ruecktauscheinheit']=$_POST['Ruecktauscheinheit'];
	 $_SESSION['Wechselkurs']=Wechselkurs ($_SESSION['Deal_ID'],$_SESSION['Einheit']);
	 $_SESSION['Akzeptanz']=Akzeptanz ($_SESSION['Tauschpartner'],$_SESSION['Einheit']);
	 
	//Pr�fe ob, Format Eintauschbetrag ok 
	if(!preg_match('/^\d+([\.]\d{1,3})?$/',$_SESSION['Eintauschbetrag']))
		$errors[]= "Bitte geben Sie ihren Eintausch-Betrag der Form 1234.70 oder 1234 ein. Also max. 2 Nachkommastellen"; 
	else {
		// Pr�fe, ob Eintauschbetrag nicht gr��er dem Kontostand
		if ($_SESSION['Eintauschbetrag']>$_SESSION['Kontostand'])
			$errors[]= "Ihr Kontostand (".$_SESSION['Kontostand']." ".$_SESSION['Einheit'].") ist nicht ausreichend, um ".$_SESSION['Eintauschbetrag']." ".$_SESSION['Einheit']." einzutauschen!";	
		if ($_SESSION['Eintauschbetrag']==0)
			$errors[]= "Bitte gegen Sie einen Eintausch-Betrag gr��er 0 ein!";	
		// Pr�fe, ob Wechselkurs vereinbart ist
		if ($_SESSION['Wechselkurs']==0) 
			$errors[]= "Zwischen den Gutscheienen ".$_SESSION['Einheit']." und ".$_SESSION['Ruecktauscheinheit']." giebt es keinen g�ltigen Deal!";	
		// Pf�fe, ob Akzeptanz ausreichend
		elseif ($_SESSION['Akzeptanz']<$_SESSION['Eintauschbetrag']) 
			$errors[]= $_SESSION['Tauschpartner']." nimmt derzeit h�chstens noch ".$_SESSION['Akzeptanz']." ".$_SESSION['Einheit']." an. Bitte reduzieren Sie die H�he Ihres gew�nschten Eintauschbetrags";	
	}	
	
	
	      // Pr�ft, ob Fehler aufgetreten sind 
        if(count($errors)){ 
             echo "<font color='#FF3030'>";
             echo "<h3>Ihr ".$_SESSION['Einheit']." Eintausch konnte nicht ausgef�hrt werden.</h3>\n". 
                  "<br>\n"; 
             $i=1;
             foreach($errors as $error) {
                 echo $i.".) ".$error."<br>\n";
                 $i+=1;
             }
             echo "</font>"; 
             echo "<br>\n". 
            include('include_53_umtauschstellen_anzeigen.php');        } 
        else{ 
            // Daten in die Datenbanktabelle einf�gen
            include('include_53_umtauschstellen_eintausch_db.php'); 
        }  
         
?>