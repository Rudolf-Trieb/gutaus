<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
	include('funktionen.php');
?>

<script>

	$(document).ready(function(){
	
		$("#login").click(function(){
			$.post("include_3_login.php","",function(data){
						  $("#inhalt").html(data).fadeIn(4000);
						});
		});	
		
	})
	
</script>
		  

<?php

	$_SESSION['Tester_Flag']=1;

	parse_str($_POST["formdata"], $Formulardaten);

    echo "<h2>Registrierung</h2>"; 
        // Kontrolle der eingegebenen Daten
        include('include_31_registrierung_kontrolle.php');
         
        // Prüft, ob Fehler aufgetreten sind 
        if(count($errors)){ 
             echo "<font color='red'>";
             echo "<h3>Ihr Account konnte nicht erstellt werden.</h3>\n". 
                  "<br>\n"; 
             $i=1;
             foreach($errors as $error) {
                 echo $i.".) ".$error."<br>\n";
                 $i+=1;
             }
             echo "</font>"; 
             
			// Eingegebene Daten in SESSION übertragen damit Reg.form bei wiederanzeige nicht gelöscht wird 
			$_SESSION=$Formulardaten;  
			include('include_31_registrierung_formular.php');
        } 
        else{ 
            // Daten in die Datenbanktabelle einfügen
            include('include_31_registrierung_db_eintrag.php'); 
        }  
?>