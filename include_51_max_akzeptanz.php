<?php

	header("Content-Type: text/html; charset=ISO-8859-1");

	//SESSION
	session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<script>

	$(document).ready(function(){
		$(".max_Akzeptanz_pruefen").click(function(){
			$.post("include_51_max_akzeptanz.php",{formdata:$("form").serialize()},function(data){
					$("#inhalt").html(data);
					$("#kontostanzanzeige").load("include_0_kontostand.php");
				});
			return false;	
			

		});	
			
	});

</script>

<?php    // Prüfen, ob das Formular gesendet wurde
    echo "<h2>Meine maximale ".$_SESSION['Einheit']." Akzeptanz</h2>"; 
    if(isset($_POST['formdata'])) { 	
		
        // Kontrolle der eingegebenen Daten
        include('include_51_max_akzeptanz_kontrolle.php');
         
        // Prüft, ob Fehler aufgetreten sind 
        if(count($errors)){ 
             echo "<font color='#FF3030'>";
             echo "<h3>Ihr max. Akzeptanz f&uuml;r ".$_SESSION['Einheit']." konnte nicht ge&auml;ndert werden.</h3>\n". 
                  "<br>\n"; 
             $i=1;
             foreach($errors as $error) {
                 echo $i.".) ".$error."<br>\n";
                 $i+=1;
             }
             echo "</font>"; 
             echo "<br>\n". 
            include('include_51_max_akzeptanz_formular.php');        } 
        else{ 
            // Daten in die Datenbanktabelle einfügen
            include('include_51_max_akzeptanz_db_eintrag.php'); 
        }  
    } 
    // Ansonsten ... 
    else { 
        // ... Anzeige des Formulars 
        include('include_51_max_akzeptanz_formular.php');
    } 
?>