<?php 
    //SESSION
    session_start();
	include('include_0_db_conektion.php');
	include('funktionen.php');	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

	<title>Gutschein Tausch System ==> GuTauS</title>
	<meta name="author" content="Horus777">
	<!--
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.min.css" />
	-->
	<link rel="stylesheet" href="css/smoothness/jquery-ui.min.css" />

	<link rel="shortcut icon" href="images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	
	<script>
	
		$(document).ready(function(){	

		  $("#faq").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("faq.html");
		  });
		  		  
		  
		  $("#marktplatz").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_4_marktplatz.php");
		  });
		  
		  $("#login").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$.post("include_3_login.php","",function(data){
						  $("#inhalt").html(data).fadeIn(4000);
						});
		  });
		  
		  $("#logout").click(function(){
			$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$.post("include_3_logout.php","",function(data){
					$("#inhalt").html(data).fadeIn(4000);
					});
		  });
		  
		  $("#avatar_icon").click(function(){
			$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$.post("include_4_mein_profil.php","",function(data){
					$("#inhalt").html(data).fadeIn(4000);
			});
		  });
		  
		  $(".profil").click(function(){
		    $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_4_mein_profil.php");
		  });
		  
		   
		  $("#registrierung").click(function(){
			$("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
			$("#inhalt").load("include_31_registrierung.php");
		  });
		  
		  
		  $("#impressum").click(function() {
		  $("#inhalt").html("<h1 align='center'> <img style='width:77px' src='images/ajax_loader_blue_64.gif'/></h1>");
						$.post("impressum.html","",function(data){
						  $("#inhalt").html(data).fadeIn(4000);
						});						
						return false;
		  });
		  
		  
	      
		  /*
		  navigator.geolocation.getCurrentPosition(
		    function(position){ 
				var latitude=position.coords.latitude;
				var longitude=position.coords.longitude;
				$.post("position_in_db_schreiben.php",{Latitude:latitude,Longitude:longitude},function(data){
					//$("#inhalt").html(data).fadeIn(4000);
				});
			}, 
			
			function(){
				alert('Deine Position konnte leider nicht ermittelt werden, und kann daher nicht in die Weltkare eingetragen werden');
			}
		  );
		  */
			


	
		  
		  
		  
		});
	</script>
		

		
</head>

	<body>

		<div id="seite">

					
			<script>

				$(function() {
					//$( "#faq-content" ).accordion({ active: 0, heightStyle: "content", collapsible: true });
					$( "#header" ).accordion({ heightStyle: "content", collapsible: true });
				});

				$(".opener").on("click", function () {
					var $this = $(this),
						toOpen = $this.data("panel");

					$( "#header" ).accordion("option", "active", toOpen);

					return false;
			});

			</script>		
		
		
			<div id="header">
			
				<!-- NAVIGATION -->		
				<h2>
				
					<div id="navigation">
						<ul id="navmenu">
							<li id="faq"><a onclick_stop="loadXMLDoc('GET','faq.html')" href="#">FAQ</a></li>
							
							
							<?php
							if(isset($_SESSION['UserID'])) {
								include('nav_eingelogt.php');
							}
							else {  
								include('nav_ausgelogt.html');
							
							}?>

							

						</ul>
					</div>			

				</h2>

				
				<!-- UEBERSCHRIFT -->
				<h2>
				
					<div id="info">
				


					<table border="0">
							<tr> <td colspan=3 align="center" width="25%">
								<!-- Player -->
								<?php if(!isset($_SESSION['UserID'])) {
										echo "
											<div id='dewplayer_content' style='margin:0 auto' >
												<object  style='margin:0 auto' data='media/dewplayer/dewplayer-mini.swf' width='250' height='25px' name='dewplayer' id='dewplayer' type='application/x-shockwave-flash'>
													<param name='movie' value='dewplayer-mini.swf' />
													<param name='flashvars' value='mp3=media/mp3/willkommen.mp3&amp;autostart=1&amp;volume=100'/>
													<param name='wmode' value='transparent' />
												</object>
											</div>
										";
									  }
									  echo "UserID".$_SESSION['UserID'];
								?>	
								<!-- Clustermap -->
								<div id="clustrmaps-widget"></div><script type="text/javascript">var _clustrmaps = {'url' : 'http://horus777.no-ip.info/gutaus/gutaus/', 'user' : 1094263, 'server' : '2', 'id' : 'clustrmaps-widget', 'version' : 1, 'date' : '2013-05-10', 'lang' : 'de', 'corners' : 'square' };(function (){ var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = 'http://www2.clustrmaps.com/counter/map.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);})();</script><noscript><a href="http://www2.clustrmaps.com/user/34010b277"><img src="http://www2.clustrmaps.com/stats/maps-no_clusters/horus777.no-ip.info-gutaus-gutaus--thumb.jpg" alt="Locations of visitors to this page" /></a></noscript>
							
							
							</td></tr>
							
							<tr>
								<td align="center" width="25%">
								<!-- KONTOSTANZANZEIGE -->
								<?php if(isset($_SESSION['UserID'])) { 
										
										echo "<div id='kontostanzanzeige'>"; 
										
												include('include_0_kontostand.php');
												
										echo "</div>";
									  }
									  else {
										echo "<img  style='width:77px' src='images/Pyramide Goldener Schnitt_mini.jpg'/>";
										echo "<img  style='width:77px' src='images/Pyramide Goldener Schnitt_mini.jpg'/>";
									  }
								?>	
								</td>  
								<td align="center">
									<h3>Willkommen <a class='profil' href='#'>
										<?php
											if (isset($_SESSION['UserID'])) 
												echo "<span class='red'>".$_SESSION["Nickname"]."</span>";
										?>
									</a> bei Ihrem</h3>
									
									<h1><span class="red">Gu</span>tschein-<span class="red">Tau</span>sch-<span class="red">S</span>ystem</h1>        
								</td>
								<td align="center" width="25%">

									<?php 
										if (isset($_SESSION['UserID'])) {
											if ($_SESSION['Avatar']<>'') {
												echo "<a id='avatar_icon' href='#'><img   style='width:77px' src='avatare/".$_SESSION['Avatar']."'/></a>"; 
											}
											else {
												echo "<a id='avatar_icon' href='#'><img  style='width:77px' src='avatare/annonym.jpg'/></a>";
											}
											//echo "<h4>".$_SESSION["Nickname"]."</h4>";	
										}
										else {
											echo "<img  style='width:77px' src='images/Pyramide Goldener Schnitt_mini.jpg'/>";
										}
									?><img  style='width:77px' src='images/Pyramide Goldener Schnitt_mini.jpg'/>
					
								</td>
							</tr>
							<tr>
								<td align="center" colspan="3"><h3>Mit <span class="red">GuTauS</span> bezahlen Sie ohne Geld mit Ihren eigenen Gutscheinen an wen sie wollen !!!</h3></td>
							</tr>
							
							
										
						</table>

				</div>	

				</h2>	
				
			</div>
												
			<br style=clear:both/>	

			<div id="inhalt">
					
				<?php
					//include("geolocation_aus_IP.php");
					if(isset($_SESSION['UserID'])) {
						include('include_6_bezahlen_panel.php');
					}
					else {
						
						//$geo_location=geo_location ($_SERVER['REMOTE_ADDR'],"all");
						//var_dump ( $geo_location );
						//echo $_SERVER['REMOTE_ADDR'];
						include('faq.html');
					}
				?>
					
			</div>
						
		</div>

	</body>

</html>

