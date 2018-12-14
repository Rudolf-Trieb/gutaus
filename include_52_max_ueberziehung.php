<?php

	header("Content-Type: text/html; charset=ISO-8859-1");

	//SESSION
	session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>


<script>

	$(document).ready(function(){
	
		$(".max_ueberziehung_pruefen").click(function(){
			$.post("include_52_max_ueberziehung.php",{formdata:$("form").serialize()},function(data){
					$("#inhalt").html(data);
					$("#kontostanzanzeige").load("include_0_kontostand.php");
				});
			return false;	
			

		});	
			
		$(".mitglied").click(function(){
			var mitglied_ID=$(this).attr("href");
			$.post("include_21_mitglieder_userprofil.php",{Mitglied_ID:mitglied_ID},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			return false;
		
		});
		
	});	


</script>









<?php    
		
	// Prüfen, ob das Formulardaten gesendet wurde
    if(isset($_POST['formdata'])) { 	
		
        // Kontrolle der eingegebenen Daten
        include('include_52_max_ueberziehung_kontrolle.php');
         
        // Prüft, ob Fehler aufgetreten sind 
        if(count($errors)){ 
             echo "<font color='#FF3030'>";
             echo "<h3>Ihr max. Überziehung f&uuml;r ".$_SESSION['Einheit']." konnte nicht ge&auml;ndert werden.</h3>\n". 
                  "<br>\n"; 
             $i=1;
             foreach($errors as $error) {
                 echo $i.".) ".$error."<br>\n";
                 $i+=1;
             }
             echo "</font>"; 
             echo "<br>\n". 
            include('include_52_max_ueberziehung_formular.php');        } 
        else{ 
            // Daten in die Datenbanktabelle einfügen
            include('include_52_max_ueberziehung_db_eintrag.php'); 
        }  
    } 
    // Ansonsten ... 
    else { 
        // ... Anzeige des Formulars 
        include('include_52_max_ueberziehung_formular.php');
    } 
?>