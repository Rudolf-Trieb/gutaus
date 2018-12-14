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
		
		
	});
</script>

<?php    
	$_SESSION['Deal_ID']=$_POST['Deal_ID'];
	$_SESSION['Fremdeinheit']=$_POST['Fremdeinheit'];
	
	$_SESSION['Mitglied']=ermittle_Herausgeber_Von_Einheit ($_SESSION['Fremdeinheit']);
	
	$_SESSION['Eigeneinheit']=$_SESSION['Einheit'];
	
	$_SESSION['Eigeneinheit_ID']=ermittle_ID_Einheit ($_SESSION['Eigeneinheit']);
	
	$_SESSION['Deal_ID']=$_POST['Deal_ID'];

	deal_zustimmen ($_SESSION['Deal_ID'],$_SESSION['Eigeneinheit_ID']);

	$deal_art_nummer=deal_art ($_SESSION['Deal_ID'],$_SESSION['Eigeneinheit_ID']);
	
	$Dealart="Dieser Deal ist nun beiderseits abgeschossen und damit gültig";

	
	include("include_8_deal_anzeigen.php");
		

?>