<?php

		  $sql = " SELECT * FROM deals
				 WHERE
					deal_ID= ".$_SESSION['Deal_ID'];	

          $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
          $row = mysql_fetch_assoc($result);


		  
		  echo "<table>";
		  
		  echo "<tr>";
		  echo "<th colspan=3>";
		  echo $Dealart;
		  echo "</th>";
		  echo "</tr>";
		  
		  echo "<tr>";
		  echo "<td>";
		  echo "Wechselkurs";
		  echo "</td>";
		  echo "<td>";
		  echo ": ";
		  echo "</td>";
		  echo "<td>";
		  if ($row[von_ID_einheit]==$_SESSION['Eigeneinheit_ID']) 
			echo $row['von_wk']." ".$_SESSION['Eigeneinheit']." = ".$row['an_wk']." ".$_SESSION['Fremdeinheit'];
		  else 
			echo $row['an_wk']." ".$_SESSION['Eigeneinheit']." = ".$row['von_wk']." ".$_SESSION['Fremdeinheit'];

			
		  echo "</td>";
		  echo "</tr>";
		  
		  echo "<tr>";
		  echo "<td>";
		  echo "Meine min. Akzeptanz";
		  echo "</td>";
		  echo "<td>";
		  echo ": ";
		  echo "</td>";
		  echo "<td>";
		   if ($row[von_ID_einheit]==$_SESSION['Eigeneinheit_ID']) 
			echo $row['an_min_akzeptanz']." ".$_SESSION['Fremdeinheit'];
		   else
		    echo $row['von_min_akzeptanz']." ".$_SESSION['Fremdeinheit'];
		  echo "</td>";
		  echo "</tr>";
		  
		  echo "<tr>";
		  echo "<td>";
		  echo "<a class='mitglied' href='".$_SESSION['Mitglied']."' >".$_SESSION['Mitglied']."</a> min. Akzeptanz";
		  echo "</td>";
		  echo "<td>";
		  echo ": ";
		  echo "</td>";
		  echo "<td>";
		   if ($row[von_ID_einheit]==$_SESSION['Eigeneinheit_ID']) 
			echo $row['von_min_akzeptanz']." ".$_SESSION['Eigeneinheit'];
		   else
		    echo $row['an_min_akzeptanz']." ".$_SESSION['Eigeneinheit'];
		  echo "</td>";
		  echo "</tr>";
		  
		  if ($Dealart<>'' and $deal_art_nummer<>3) {
			  echo "<tr>";
			  echo "<th colspan=3>";
			  echo "<a class='zustimmen_entscheidungs_deal' href=#>Diesen Deal-Angebot zustimmen<br> und an ".$_SESSION['Mitglied']." senden</a>";
			  echo "</th>";
			  echo "</tr>";	
		  }			  
		  
		  echo "</table>";
		  

?>