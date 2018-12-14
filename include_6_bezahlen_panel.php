<script>

	$(document).ready(function(){
		
		$(function() {
			//alert ("Tab_Nr=<?php echo $_SESSION['Tab-Nr'];?>");
			//alert ("Sesion Einheit=<?php echo $_SESSION['Einheit'];?>");
			$( "#bezahlen-tabs" ).tabs(2);
			//$( "[Einheit='Horus']").trigger( "click" );
		});
		
	  
	});


</script>


<div id='bezahlen-tabs'>
    <h2>Bezahlen an:</h2>
	<ul>
		<li><a href='include_6_bezahlen_an_formular.php?Ueberweisungsart=Mitglied'>Mitglied</a></li>
		<li><a href='include_6_bezahlen_an_formular.php?Ueberweisungsart=Email'>E-Mail Adresse</a></li>
		<li><a href='include_6_bezahlen_an_formular.php?Ueberweisungsart=Handy'>Handynummer</a></li>
		
	</ul>
	
</div>

<script>


		
		$(function() {
			//alert ("Tab_Nr=<?php echo $_SESSION['Tab-Nr'];?>");
			//alert ("Sesion Einheit=<?php echo $_SESSION['Einheit'];?>");
			$( "#bezahlen-tabs" ).tabs(2);
			//$( "[Einheit='Horus']").trigger( "click" );
		});
		
	  



</script>


