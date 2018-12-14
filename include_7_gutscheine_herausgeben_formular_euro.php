<?php 
	if(!isset($_POST['formdata'])) {
		//SESSION
		session_start();
		header("Content-Type: text/html; charset=ISO-8859-1");
	}
?>


<script>

	$(document).ready(function(){
		$("#pruefen-gutschein").click(function(){
			var Data=$("form").serialize();
			$.post("include_7_gutscheine_herausgeben.php",{formdata:Data},function(data){
				$("#inhalt").html(data).fadeIn(4000);
			});
		});
		
	});

</script>


<?php    
			$_SESSION['Gutscheinname']=$_SESSION['Nickname']."-Euro";
	        $_SESSION['Definition']="Für jeden ".$_SESSION['Gutscheinname']." erhalten Sie von ".$_SESSION['Nickname']." einen realen Euro (Gemeinschaftswährung der EU seit 1.Januar 2002) in bar oder per Überweisung.";
			echo "<h2>Eigenen <b>".$_SESSION['Gutscheinname']."</b> Gutschein herausgeben</h2>";

            echo "<form ".
                 " name=\"Euro Gutscheine herausgeben\" ".
                 " accept-charset=\"ISO-8859-1\">\n";
            echo "<table>";
                            
                echo "<tr>";
                echo "<td colspan=2>";
                echo "<span>\n".
                 "Ihr Euro-Gutscheine wird <b>".$_SESSION['Gutscheinname']."</b> hei&szlig;en !\n".
                 "</span>\n";
				 echo "<input style='text-align: right' type=\"hidden\" name=\"Gutscheinname\" maxlength=\"70\" value=\"".$_SESSION['Gutscheinname']."\">\n";
				 echo "<input style='text-align: right' type=\"hidden\" name=\"euro_Gutschein\" maxlength=\"70\" value=\"1\">\n";
				
                echo "</td>";
                echo "</tr>";
                
                // Definition
                echo "<tr>";
                echo "<td colspan=2>";
                echo "<span style=\"font-weight:bold;\" >".
                     "Was ist einer Ihrer Gutscheine Wert ?<br>\n".
                     "</span>\n";
                        echo "<textarea name=\"Definition\" rows=\"7\" cols=\"77\" >",$_SESSION['Definition'],"</textarea>";
                echo "</td>";
                echo "</tr>";
                
                // max_Ueberziehung
                
                echo "<tr>";
                echo "<td>";
                echo "<span>\n".
                 "Wieviele Ihre Gutscheine wollen Sie maximal in den Umlauf bringen ?\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                    echo "<input type=\"text\" name=\"max_Ueberziehung\" maxlength=\"10\" value=\"".($_SESSION['max_Ueberziehung']*(-1))."\">\n";
                echo "</td>";
                echo "</tr>"; 
                
                // max_Akzeptanz

                echo "<tr>";
                echo "<td>";
                echo "<span>\n".
                 "Wieviele Ihre Gutscheine darf eine Person maximal besitzen ?\n".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
                    echo "<input type=\"text\" name=\"max_Akzeptanz\" maxlength=\"10\" value=\"".$_SESSION['max_Akzeptanz']."\">\n";
                echo "</td>";
                echo "</tr>";    

               
                // private Gutscheine

                echo "<tr>";
                echo "<td>";
                echo "<span>\n".
				 "<br>".
                 "Diese Gutscheine sind privat.<br> \n".
				 "Die Gutscheine können nur an Personen weitergegeben werden,<br>
				 die ein <b>".$_SESSION['Gutscheinname']."-Gutschein-Konto</b> per Erstüberweisung von Ihnen erhalten haben.".
                 "</span>\n";
                echo "</td>";
                echo "<td>";
				    if ($_SESSION['privat_Gutschein']==1)
						$privat_Gutschein="checked";
                    echo "<input type=\"checkbox\" name=\"privat_Gutschein\" value=1 ".$privat_Gutschein.">\n";
					echo "private Gutscheine";
                echo "</td>";
                echo "</tr>";   				
                
                // Mein Gutscheine-Konto eröffnen
                echo "<tr>";
                echo "<th calspan=2>";
				echo "<a id=\"pruefen-gutschein\" href='#'>Mein Gutscheine-Konto eröffnen</a>";
                echo "</th>";
                echo "</tr>";
                
            echo "</table>"; 
            echo "</form>\n";


?>