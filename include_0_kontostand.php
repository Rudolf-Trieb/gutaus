<?php 
    //SESSION
    session_start(); 
	include_once('include_0_db_conektion.php');
	include_once('funktionen.php');
?>

<script>
	$(document).ready(function(){
	
		$(".max_Akzeptanz").click(function(){
			$("#inhalt").load("include_51_max_akzeptanz.php");
		});	

		$(".max_Ueberziehung").click(function(){
			$("#inhalt").load("include_52_max_ueberziehung.php");
		});			
		
		$(".herausgeber").click(function(){
			var einheit=$(this).attr("href");
			$.post("include_2_herausgeber.php",{Einheit:einheit},function(data){

				$("#inhalt").html(data);
			});
			return false;
		});	
		
		$(".Konto-Auszug").click(function(){
			$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("automatischer_login_logout.php");
			$.post("include_5_kontoauszug.php",{Useraufruf:true},function(data){
				$("#inhalt").html(data);
			});
			
			return false;
		});
		
		$(".konten").click(function(){
			$("#inhalt").load("include_2_konten.php");
		});
		
	});
</script>

<?php



    if (!$_POST['Einheit']==''){
       $_SESSION['Einheit']=$_POST['Einheit'];  
    }
	if ($_POST['Einheit']=='Array'){
		$_SESSION['Einheit']=$_POST['Einheit'][0]; 
	}
	
	// Herausgeber
	$_SESSION['Herausgeber']=ermittle_Herausgeber_Von_Einheit ($_SESSION['Einheit']);
	// echo "Herausgeber=".$_SESSION['Herausgeber'];
	$_SESSION['ID_Einheit']=ermittle_Einheit_ID ($_SESSION['Einheit']);
    
    if (!pruefe_Konto_vorhanden($_SESSION['UserID'],$_SESSION['Einheit'])){
        echo "<table><tr>
            	    <td align='center' colspan=2>
            	       <h3>Sie haben noch kein Konto f&uuml;r <h2>".$_SESSION['Einheit']." !!!</h2></h3>
            	       <h4>Sie erhalten ein  <a class='herausgeber' href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']."</a>-Konto sobalt ihnen ".$_SESSION['Einheit']."-Gutscheie &uuml;berwiesen werden.</h4>
            	    </td>
        	    </tr>
              </table>";
    }
    else {

    
        $sql = "SELECT
                        max_Ueberziehung,
                        Kontostand,
                        max_Akzeptanz
                FROM
                        konten
                WHERE
                             ID_Mitglied = '".mysql_real_escape_string($_SESSION['UserID'])."'
                        AND  Einheit     = '".mysql_real_escape_string($_SESSION['Einheit'])."'    
               ";
               
        $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
        $row = mysql_fetch_assoc($result);
		
		
		$_SESSION['max_Akzeptanz']=$row['max_Akzeptanz'];
				
		echo "<table border='0' cellpadding='5' cellspacing='5'>";
		// HEATLINES ZEILE
		echo " <tr>\n";
		// max_Ueberziehung Heatline
		if ($row['max_Ueberziehung']<0) {
			echo "  <th>\n";
			echo "max.<br> &Uuml;berziehung\n";
			echo "  </th>\n";                  
		}
		// Kontostand Heatline
		echo "  <th>\n";  
		echo "Kontostand\n";
		echo "  </th>\n";
		
		// max_Akzeptanz Heatline
		if ($row['max_Akzeptanz']>0) {
			echo "  <th>\n";
			echo "max.<br> Akzeptanz";
			echo "  </th>\n";
		}  
		  
		echo " </tr>\n";
	
		// DATEN ZEILE
		echo " <tr align='center'>\n";
		
		// max_Ueberziehung
		
		if ($row['max_Ueberziehung']<0) {
			echo "  <td>\n";
			
			echo $row['max_Ueberziehung']." ".$_SESSION['Einheit']."\n";
			$_SESSION['max_Ueberziehung']=$row['max_Ueberziehung'];
			echo "<br><a class='max_Ueberziehung' href='#'>&Auml;ndern</a>";
			
			echo "  </td>\n";
		}
		
		// Kontostand
		if ($row['Kontostand']<0)
			echo "  <td  style='background-color:#FF3030'>\n";
		else
			echo "  <td  style='background-color:#41EE00'>\n";
		echo $row['Kontostand']." <a class='herausgeber' href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']."\n";
		//Aufladen Link
		if ($_SESSION['Einheit']=="Euro" || $_SESSION['Einheit']=="g Silber" || $_SESSION['Einheit']=="g Gold") {
			echo "<br><a href='#'>Aufladen</a>";
		}
		$_SESSION['Kontostand']=$row['Kontostand'];

       
/*      
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="X559ML8SNDMSS">
<table>
<tr><td><input type="hidden" name="on0" value="Euro Aufladung">Euro Aufladung</td></tr><tr><td><select name="os0">
	<option value="5 € Aufladung">5 € Aufladung €5,45 EUR</option>
	<option value="10€ Aufladung">10€ Aufladung €10,55 EUR</option>
	<option value="20€ Aufladung">20€ Aufladung €20,75 EUR</option>
	<option value="30€ Aufladung">30€ Aufladung €30,92 EUR</option>
	<option value="50€ Aufladung">50€ Aufladung €51,30 EUR</option>
</select> </td></tr>
<tr><td><input type="hidden" name="on1" value="Ihr € Konto Aufladen">Ihr € Konto Aufladen</td></tr><tr><td><input type="text" name="os1" maxlength="200"></td></tr>
</table>
<input type="hidden" name="currency_code" value="EUR">
<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
*/           
        echo "  </td>\n";
        // max_Akzeptanz
        if ($row['max_Akzeptanz']>0) {
            echo "  <td>\n";
       //     echo "<a href='".$_SERVER['PHP_SELF']."?Content_Ebene_0=Kontoauszug&Content_Ebene_1=max_Akzeptanz' style='color:blue;text-decoration:underline'>";
			if($row['Kontostand']<0) 
				$max_Akzeptanz=$row['max_Akzeptanz']+abs($row['Kontostand']);
			else
				$max_Akzeptanz=$row['max_Akzeptanz'];
			echo $max_Akzeptanz." ".$_SESSION['Einheit']."\n";
			$_SESSION['max_Akzeptanz']=$row['max_Akzeptanz'];
       //     echo "</a>";
			echo "<br><a class='max_Akzeptanz' href='#'>&Auml;ndern</a>";
            echo "  </td>\n";
        }
        echo " </tr>\n";

		echo " <tr>\n";

			echo "  <th colspan=3>\n";
			echo "<a class='Konto-Auszug' href='".$_SESSION['Einheit']."'>".$_SESSION['Einheit']." Konto-Auszug</a>\n";
			echo "  </th>\n";      		
		
        echo " </tr>\n";
		
		echo " <tr>\n";

			echo "  <th colspan=3>\n";
			echo "<a class='konten' href=#>Alle meine Konten</a>\n";
			echo "  </th>\n";      		
		
        echo " </tr>\n";
		

    
    echo "</table>";
	}
	
?>