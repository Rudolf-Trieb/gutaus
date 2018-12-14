<?php

	header("Content-Type: text/html; charset=ISO-8859-1");

	//SESSION
	session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>


<script>
	$(document).ready(function(){
				
				
		$(".mitglied").click(function(){
			var mitglied=$(this).attr("href");
			$.post("include_21_mitglieder_userprofil.php",{Mitglied_ID:mitglied_ID},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});
		
		$(".anbieten_deal").click(function(){
			$.post("include_8_anbieten_deal.php",{formdata:$("form").serialize()},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});
			
		$(".anbieten_gegen_deal").click(function(){
			$.post("include_8_anbieten_gegen_deal.php",{},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});	
		

		$(".zustimmen_entscheidungs_deal").click(function(){
			$.post("include_8_zustimmen_entscheidungs_deal.php",{},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});	
		
		
	});
</script>

<?php    
		
	// Prüfen, ob das Formulardaten gesendet wurde
    if(isset($_POST['formdata'])) { 
	//var_dump ($_SESSION);
		
        // Kontrolle der eingegebenen Daten
        include('include_8_anbieten_deal_kontrolle.php');
         
        // Prüft, ob Fehler aufgetreten sind 
        if(count($errors)){ 
             echo "<font color='#FF3030'>";
             echo "<h3>Ihr Deal-Angebot wurde nicht an ".$_SESSION['Mitglied']." gsendet !.</h3>\n". 
                  "<br>\n"; 
             $i=1;
             foreach($errors as $error) {
                 echo $i.".) ".$error."<br>\n";
                 $i+=1;
             }
             echo "</font>"; 
             echo "<br><br>\n". 
            include('include_8_anbieten_deal_formular.php');        } 
        else{ 
            // Daten in die Datenbanktabelle einfügen
            include('include_8_anbieten_deal_db_eintrag.php'); 
        }  
    } 
    // Ansonsten ... 
    else { 
		$_SESSION['Fremdeinheit']=$_POST['Fremdeinheit'];
		$_SESSION['Mitglied']=ermittle_Herausgeber_Von_Einheit ($_SESSION['Fremdeinheit']);
        // ... Anzeige des Formulars 
        include('include_8_anbieten_deal_formular.php');
    } 
?>