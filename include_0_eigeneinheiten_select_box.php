
<script>

	$(document).ready(function(){

		$(".einheit-select").change(function() {
			//alert ("ok1");
			var einheit=$(".einheit-select").val();
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});
		});
	
	});
	
</script>	


<?php                                 
    echo "<select CLASS='einheit-select' name='Eigeneinheit'>";

    // Eigene Einheiten des Users  aus  DB lesen
        $sql = "    SELECT
                 Einheit
        FROM
             einheiten
        WHERE
                ID_Mitglied=".$_SESSION['UserID']."   
        ORDER BY
             Einheit
        ";
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		
        while ($row = mysql_fetch_assoc($result)) {
			if ($_SESSION['Fremdeinheit']<>$row['Einheit'])
				echo "<option  value='".$row['Einheit']."'>".$row['Einheit']."</option>";			
        }
		
     echo "</select>"
?>