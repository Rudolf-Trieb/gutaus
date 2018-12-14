<script>

	$(document).ready(function(){
		
		$(function() {
			//alert ("Tab_Nr=<?php echo $_SESSION['Tab-Nr'];?>");
			//alert ("Sesion Einheit=<?php echo $_SESSION['Einheit'];?>");
			$( "#auszahlen-tabs" ).tabs();
			//$( "[Einheit='Horus']").trigger( "click" );
		});
		
	  
	});


</script>

<div id='auszahlen-tabs'>
	<ul>
		<li><a href='include_9_auszahlung_girokonto.php'>An Girokonto</a></li>
		<li><a href='include_9_auszahlung_ubs.php'>UBS Barauszahlung</a></li>
		<li><a href='include_9_auszahlung_western_union.php'>Western Union Barauszahlung</a></li>
	</ul>
	
</div>


