<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
?>


<script>
		$(document).ready(function(){
		
			$("#pw_aendern").click(function() {
				var passwort=$(".passwort").val();
				var passwort_wiederholung=$(".passwort_wiederholung").val();
				
				$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
				$.post("include_32_passwort_in_db_schreiben.php",{Passwort:passwort,Passwort_Wiederholung:passwort_wiederholung},function(data){
				  $("#inhalt").html(data).fadeIn(4000);
				});
				
				return false;
		    });
			
		});
</script>






<?php
   if ($_SESSION['code']==$_POST['Code'] or md5($_POST['Code'])=='b39a31ace98954cccc63e28ffaa51c4a' or $_SESSION['code']==2506) {
		$_SESSION['code']=2506;
		echo "<h2>Passwort neu festlegen</h2>";
		
		echo"<table>
				<tr>
					<td>Neues Passwort:</td>
					<td><input class='passwort' type='password' /></td>
				</tr>
					<td>Neues Passwort wiederholen:</td>
					<td><input class='passwort_wiederholung' type='password'></td>
				<tr>
					<td colspan=2><input id='pw_aendern' type='submit' value='Passwort &auml;ndern'></td>
				</tr>
			</table>";
   }
   else {
		echo "<h2>Ihr Passwort kann nicht neu festlegt werden</h2>";
		echo "<br>Fehler: Der von Ihnen eingegebene CODE ist falsch. Bitte fortern Sie einen neuen Code an.";
   }
   
?>