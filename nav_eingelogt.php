<script>
	$(document).ready(function(){
	
		
		$(".Womit").click(function(){
			$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("automatischer_login_logout.php");
			var einheit=$(this).attr("href");
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});
			$.post("include_5_kontoauszug.php",{Useraufruf:true},function(data){
				$("#inhalt").html(data);
			});
			
			$("#bezahlen-an-girokonto").remove();
			$("#ubs-bar").remove();
			if (einheit=="Euro" || einheit=="g Silber" || einheit=="g Gold") {
				$("#an_wen").append("<li><a id='bezahlen-an-girokonto'    href='#'>Auszahlung an ein <br>Girokonto</a></li>");
				$("#an_wen").append("<li><a id='ubs-bar'    href='#'>UBS Bar-Auszahlung</a></li>");
			}
			return false;
		});
		
		
		$(".Deal-vorgeschlagen").click(function(){
			var einheit=$(this).attr("href");
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});	
			$("#inhalt").load("include_8_vorschlags_deals.php");
			$("#bezahlen-an-girokonto").remove();
			$("#ubs-bar").remove();
			if (einheit=="Euro" || einheit=="g Silber" || einheit=="g Gold") {
				$("#an_wen").append("<li><a id='bezahlen-an-girokonto'    href='#'>Auszahlung an ein <br>Girokonto</a></li>");
				$("#an_wen").append("<li><a id='ubs-bar'    href='#'>UBS Bar-Auszahlung</a></li>");
			}
			return false;
			
		});

		$(".Deal-halb-offen").click(function(){
			var einheit=$(this).attr("href");
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});	
			$("#inhalt").load("include_8_halbe_deals.php");
			$("#bezahlen-an-girokonto").remove();
			$("#ubs-bar").remove();
			if (einheit=="Euro" || einheit=="g Silber" || einheit=="g Gold") {
				$("#an_wen").append("<li><a id='bezahlen-an-girokonto'    href='#'>Auszahlung an ein <br>Girokonto</a></li>");
				$("#an_wen").append("<li><a id='ubs-bar'    href='#'>UBS Bar-Auszahlung</a></li>");
			}
			return false;
			
		});		
		
		
		$(".Deal-volle-abgeschlossen").click(function(){
			var einheit=$(this).attr("href");
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});	
			$("#inhalt").load("include_8_volle_deals.php");
			$("#bezahlen-an-girokonto").remove();
			$("#ubs-bar").remove();
			if (einheit=="Euro" || einheit=="g Silber" || einheit=="g Gold") {
				$("#an_wen").append("<li><a id='bezahlen-an-girokonto'    href='#'>Auszahlung an ein <br>Girokonto</a></li>");
				$("#an_wen").append("<li><a id='ubs-bar'    href='#'>UBS Bar-Auszahlung</a></li>");
			}
			return false;
			
		});
		
		$(".Deal-abgelehnt").click(function(){
			var einheit=$(this).attr("href");
			$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
				$("#kontostanzanzeige").html(data);
			});	
			$("#inhalt").load("include_8_abgelehnte_deals.php");
			$("#bezahlen-an-girokonto").remove();
			$("#ubs-bar").remove();
			if (einheit=="Euro" || einheit=="g Silber" || einheit=="g Gold") {
				$("#an_wen").append("<li><a id='bezahlen-an-girokonto'    href='#'>Auszahlung an ein <br>Girokonto</a></li>");
				$("#an_wen").append("<li><a id='ubs-bar'    href='#'>UBS Bar-Auszahlung</a></li>");
			}
			return false;
			
		});
				
		
		$(".gutschein_herausgeben").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_7_gutscheine_herausgeben_formular.php");
			return false;
		});		
		
		$(".gutscheine-alle").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			
			var einheit=$(this).attr("href");
			if (einheit!='#')
				$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
					$("#kontostanzanzeige").html(data);
				});		
			$("#inhalt").load("include_2_gutscheine-alle.php");
			
			//$("#bezahlen-an-girokonto").remove();
			//$("#ubs-bar").remove();
			// if (einheit=='#')
				$("#kontostanzanzeige").load("include_0_kontostand.php");
			return false;
		});		
	
		
		$(".gutscheine-eigene").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			
			var einheit=$(this).attr("href");
			if (einheit!='#')
				$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
					$("#kontostanzanzeige").html(data);
				});		
			$("#inhalt").load("include_2_gutscheine-eigene.php");
			
			//$("#bezahlen-an-girokonto").remove();
			//$("#ubs-bar").remove();
			// if (einheit=='#')
				$("#kontostanzanzeige").load("include_0_kontostand.php");
			return false;
		});			
		
		$(".gutscheine-fremd").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			
			var einheit=$(this).attr("href");
			if (einheit!='#')
				$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
					$("#kontostanzanzeige").html(data);
				});		
			$("#inhalt").load("include_2_gutscheine-fremd.php");
			
			//$("#bezahlen-an-girokonto").remove();
			//$("#ubs-bar").remove();
			//if (einheit=='#')
				$("#kontostanzanzeige").load("include_0_kontostand.php");
			return false;
		});	

		$("#bezahlen").click(function(){
			$("#inhalt").load("include_6_bezahlen_panel.php");
			return false;
		});

		
		
		$(".bezahlen_an").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$.post("include_6_bezahlen_an_formular.php",{Ueberweisungsart:$(this).attr("href")},function(data){
				$("#inhalt").html(data);
			});
			return false;
		});
		
				
		
		$("#profil").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_4_mein_profil.php");
		});
		
		$(".konten").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_2_konten.php");
		});
		
		$(".mitgliederliste").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_2_mitglieder.php");
		});
		
		$(".kunden").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_2_kunden.php");
		});
		
		$(".lieferanten").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_2_lieferanten.php");
		});
		
		$(".glaeubiger").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_2_glaeubiger_alle_meine.php");
		});
		
		$(".schuldner").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_2_schuldner_alle_meine.php");
		});
				
		
		
	});
</script>		



			<?php include_once('include_0_einheiten_menue.php'); ?>
			
			<li><a id='bezahlen' href="#">bezahlen</a>
			
<!--			<span class="darrow">&#9660;</span>
				<ul id="an_wen" class="sub1">
					<li><a class='bezahlen_an' href="Email">An eine<br>E-Mail Adresse</a></li>
					<li><a class='bezahlen_an' href="Handy">An eine<br>Handynummer</a></li>
					<li><a class='bezahlen_an' href="Mitglied">An ein <br>GuTauS-Mitglied</a></li>
					<?php
					if ($_SESSION['Einheit']=="Euro" || $_SESSION['Einheit']=="g Silber" || $_SESSION['Einheit']=="g Gold") {
						echo "<li><a class='bezahlen_an'   href='An Girokonto'>Auszahlung an ein <br>Girokonto</a></li>";
						echo "<li><a class='bezahlen_an'   href='An UBS'>UBS Bar-Auszahlung</a></li>";
					}
					?>
				</ul>
-->
			</li>

			<li><a href="#">Sonstiges</a><span class="darrow">&#9660;</span>
				<ul class="sub1">
					<li><a id="profil"     href="#">Mein Profil</a></li>
					<li><a class="konten" href="#">Meine Konten</a></li>
					<!-- 
					<li><a id="marktplatz" href="#">Marktplatz</a></li>
					-->
					<li><a class="mitgliederliste" href="#">Mitgliederlisten-</a><span class="rarrow">&#9654;</span>
						<ul class="sub2">
								<li><a class="mitgliederliste" href="#">alle</a></li>
								<li><a class="kunden" href="#">Meine Kunden</a></li>
								<li><a class="lieferanten" href="#">Meine Liferanten</a></li>
								<li><a class="glaeubiger" href="#">Gläubiger</a></li>
								<li><a class="schuldner" href="#">Schuldner</a></li>
						</ul>
					</li>
				</ul>
			</li>
			
			<li><a id="logout" href="#">LOGOUT</a></li>