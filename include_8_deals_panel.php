<script>

	$(function() {
		$( ".deals-tabs" ).tabs({heightStyle: "content"});
	});
	
	
</script>

<?php
		//echo "		<h3>".$_SESSION['Kontostand']." ".$_SESSION['Einheit']."</h3>";
		echo "		<div class='deals-tabs'>";
		echo "			<ul>";
		echo "				<li><a href='include_8_abgelehnte_deals.php'><font color='red'>abgelehnte<br>Deals</font></a></li>";
		echo "				<li><a href='include_8_vorschlags_deals.php'><font color='#EE9A49'>faire System<br>Vorschlag-Deals</font></a></li>";
		echo "				<li><a href='include_8_halbe_deals.php'><font color='#EE9A49'>offene<br>Halbe-Deals</font></a></li>";
		echo "				<li><a href='include_8_volle_deals.php'><font color='green'>abgeschlossene<br>Volle-Deals</font></a></li>";
		echo "			</ul>";
		echo "		</div>";
		
?>