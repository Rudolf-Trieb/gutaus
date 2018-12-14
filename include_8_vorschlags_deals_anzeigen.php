<script>

	$(document).ready(function(){
	
		$(".mitglied").click(function(){
			var mitglied_ID=$(this).attr("href");
			$.post("include_21_mitglieder_userprofil.php",{Mitglied_ID:mitglied_ID},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
			return false;
		});
		
		$(".anbieten_deal").click(function(){
			var fremdeinheit=$(this).attr("href");
			$.post("include_8_anbieten_deal.php",{Fremdeinheit:fremdeinheit},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});
		
		$(".zustimmen_deal").click(function(){
			var deal_ID=$(this).attr("href");
			var fremdeinheit=$(this).attr("fremdeinheit");
			$.post("include_8_zustimmen_deal.php",{Deal_ID:deal_ID,Fremdeinheit:fremdeinheit},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});
		
		$(".ablehnen_deal").click(function(){
			var deal_ID=$(this).attr("href");
			var fremdeinheit=$(this).attr("fremdeinheit");
			$.post("include_8_ablehnen_deal.php",{Deal_ID:deal_ID,Fremdeinheit:fremdeinheit},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		return false;
		});
			
	
	});
	
</script>


<?php
    echo "<table border='1' cellpadding='1' cellspacing='1'>";
    
    echo " <tr>\n";
    echo "  <th colspan=6>\n";
    echo "PC-Berechnete faire Vorschlags Deals denen Ich und<br>auch mein m&ouml;glicher Deal-Partner noch nicht zugestimmt haben\n";
    echo "  </th>\n";
    echo " </tr>\n";
    
    echo " <tr>\n";
	
    echo "  <th rowspan=1>\n";
    echo "Nickname meines<br> m&ouml;glichen Partners\n";
    echo "  </th>\n";
	
    echo "  <th rowspan=1>\n";
    echo "Vorschlags-<br>Wechselkus\n";
    echo "  </th>\n";

    echo "  <th rowspan=1>\n";
    echo "min. Akzeptanz<br> meines Partners\n";
    echo "  </th>\n";

	echo "  <th rowspan=1>\n";
    echo "Meine <br> min. Akzeptanz\n";
    echo "  </th>\n";
		
    echo "  <th rowspan=1>\n";
    echo "Vorschlagsdatum\n";
    echo "  </th>\n";
	
	echo "  <th rowspan=1>\n";
    echo "Meine<br>Zustimmung\n";
    echo "  </th>\n";
	
    echo " </tr>\n";


    $sql = "SELECT d.deal_ID,m.ID,m.Nickname, d.von_wk, d.an_wk, d.von_min_akzeptanz, d.an_min_akzeptanz, e.einheit, DATE_FORMAT(d.erstellungsdatum, '%d.%m.%Y') as Datum \n"
    . "FROM deals d\n"
    . "LEFT OUTER JOIN einheiten e ON d.an_ID_einheit = e.ID\n"
    . "LEFT OUTER JOIN mitglieder m ON ID_Mitglied = m.ID\n"
    . "WHERE d.von_ID_einheit =".$_SESSION['ID_Einheit']."\n"
    . "AND d.an_ok = 0\n"
    . "AND d.von_ok = 0\n"
    . "ORDER BY Datum  DESC\n";
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
   while ($row = mysql_fetch_assoc($result)) {

        // Nickname
        echo " <tr>\n";
        echo "  <td align='center'>\n";
		echo "<a class='mitglied' href='#'>".$row['Nickname']."</a>\n";

        echo "  </td>\n";
        // Wechselkus
        echo "  <td align='center'>\n";
        echo $row['von_wk']." ".$_SESSION['Einheit']." = ".$row['an_wk']." ".$row['einheit']."\n";
        echo "  </td>\n";

		// min. Akzeptanz Eigeneinheiten
		echo "  <td align='center'>\n";
		echo $row['von_min_akzeptanz']."<br>".$_SESSION['Einheit']."\n";
		echo "  </td>\n";
		
		// min. Akzeptanz Fremdeinheiten
		echo "  <td align='center'>\n";
		echo $row['an_min_akzeptanz']."<br>".$row['einheit']."\n";
		echo "  </td>\n";			

        // Vorschlagsdatum
        echo "  <td>\n";
        echo $row['Datum']."\n";
        echo "  </td>\n";
		
		// Meine Zustimmung
        echo "  <td align='center'>\n";
        echo 		"<a class='zustimmen_deal' fremdeinheit='".$row['einheit']."' href='".$row['deal_ID']."'><img  style='width:28px' src='images/daumen_hoch.gif'/></a>";
		echo 		"<a class='ablehnen_deal' fremdeinheit='".$row['einheit']."' href='".$row['deal_ID']."'>ablehnen</a>";
		echo        "<br>oder";
		echo 		"<br><a class='anbieten_deal' href='".$row['einheit']."'>Gegen-Angebot</a>";
        echo "  </td>\n";
		
        echo " </tr>\n";
    }
    $sql = "SELECT d.deal_ID,m.ID,m.Nickname, d.von_wk, d.an_wk, d.von_min_akzeptanz, d.an_min_akzeptanz, e.einheit, DATE_FORMAT(d.erstellungsdatum, '%d.%m.%Y') as Datum \n"
    . "FROM deals d\n"
    . "LEFT OUTER JOIN einheiten e ON d.von_ID_einheit = e.ID\n"
    . "LEFT OUTER JOIN mitglieder m ON ID_Mitglied = m.ID\n"
    . "WHERE d.an_ID_einheit =".$_SESSION['ID_Einheit']."\n"
    . "AND d.an_ok = 0\n"
    . "AND d.von_ok = 0\n"
    . "ORDER BY Datum  DESC\n";
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
   while ($row = mysql_fetch_assoc($result)) {

        // Nickname
        echo " <tr>\n";
        echo "  <td align='center'>\n";
		echo "<a class='mitglied' href='#'>".$row['Nickname']."</a>\n";

        echo "  </td>\n";
        // Wechselkus
        echo "  <td align='center'>\n";
        echo $row['an_wk']." ".$_SESSION['Einheit']." = ".$row['von_wk']." ".$row['einheit']."\n";
        echo "  </td>\n";

		// min. Akzeptanz Eigeneinheiten
		echo "  <td align='center'>\n";
		echo $row['an_min_akzeptanz']."<br>".$_SESSION['Einheit']."\n";
		echo "  </td>\n";
		
		// min. Akzeptanz Fremdeinheiten
		echo "  <td align='center'>\n";
		echo $row['von_min_akzeptanz']."<br>".$row['einheit']."\n";
		echo "  </td>\n";			
		
        // Vorschlagsdatum
        echo "  <td>\n";
        echo $row['Datum']."\n";
        echo "  </td>\n";
		
		// Meine Zustimmung
        echo "  <td align='center'>\n";
        echo 		"<a class='zustimmen_deal' fremdeinheit='".$row['einheit']."' href='".$row['deal_ID']."'><img  style='width:28px' src='images/daumen_hoch.gif'/></a>";
		echo 		"<a class='ablehnen_deal' fremdeinheit='".$row['einheit']."' href='".$row['deal_ID']."'><img  style='width:28px' src='images/daumen_runter.gif'/></a>";
		echo        "<br>oder";
		echo 		"<br><a class='anbieten_deal' href='".$row['einheit']."'>Gegen-Angebot</a>";
        echo "  </td>\n";

		echo " </tr>\n";
    }
    echo "</table>";

?>