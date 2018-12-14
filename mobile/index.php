<?php 
    //SESSION
    session_start();
?>    
<!DOCTYPE html>

<html>

<head>
<title>GuTauS - Gutschein Tausch System</title>

<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8"> <!--for older browsers -->
<meta http-equiv="expires" content="0">  <!--no cashing refresh each call from sever -->
<meta name="description" content="Bezahlen Sie weltweit ohne Geld mit Ihren eigenen Gutscheinen. GuTauS das Gutschein-Tausch-System ermöglicht Ihnen in wenigen Schritten die Herausgabe Ihrer eigener Gutscheine ">
<meta name="autor" content="Horus777">
<meta name="creator" content="Horus777">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="shortcut icon" href="images/favicon.ico" />

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

<!--
<script src="http://code.jquery.com/jquery-1.11.2.min.js">
</script>-->
<script   src="http://code.jquery.com/jquery-1.12.3.min.js"   integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ="   crossorigin="anonymous"></script>
			
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<script src="js/user-event-mobile.js"></script>
<link rel="stylesheet" href="./css/style-mobil.css">


</head>

<body>

<!--
//*************************************************************************************************************************************************
// LOGIN LOGOUT REGISTRATION
//*************************************************************************************************************************************************	
//-->
<div data-role="page" id="main-logtout">
  <div data-role="header" data-theme="b" data-position="fixed" data-position="fixed">
	<div data-role="navbar">
	  <ul>
		<li style="text-align: center;">GuTauS</li>
	  </ul>
	</div>
	<div data-role="navbar">
	  <ul>                
			<li style="text-align: center;"><img  style='width:77px' src='../avatare/logo 5.0.png'/></li>
	  </ul>
	</div>	
	<div data-role="navbar">
	  <ul>
		<li style="text-align: center;">Gutschein-Tausch-System</li>
	  </ul>
	</div>
	<div data-role="navbar">
	  <ul>
		<li style="text-align: center;">Mit GuTauS bezahlen Sie ohne Geld<br>mit eigenen Gutscheinen an wen Sie wollen!!!</li>
	  </ul>
	</div>
  </div>

  <div data-role="main" class="ui-content">
	<a href="#login" class="ui-btn ui-icon-edit ui-btn-icon-right" data-transition="flip" autofocus>LOGIN</a>
	<a href="#faq" class="ui-btn ui-icon-bullets ui-btn-icon-right" data-transition="slide">FAQ</a>
	<a href="#registration" class="ui-btn ui-icon-edit ui-btn-icon-right" data-transition="slide">REGISTRIERUNG</a>
  </div>

  <div data-role="footer" data-theme="b" data-position="fixed">
		<div data-role="navbar">
		  <ul>
				<li style="text-align: center;"><a href="#" class="ui-btn ui-btn-inline ui-icon-info ui-btn-icon-right  ui-corner-all" data-transition="flow" data-direction="reverse">Info</a></li>
		  </ul>
		</div>
  </div>
</div> 

<div data-role="page" id="login">
  <div data-role="header" data-theme="b" data-position="fixed" data-position="fixed">
	  
		<div data-role="navbar">
		  <ul>
			<li style="text-align: center;">GuTauS</li>
		  </ul>
		</div>
		<div data-role="navbar">
		  <ul>                
				<li style="text-align: center;"><img  style='width:77px' src='../avatare/logo 5.0.png'/></li>
		  </ul>
		</div>	
		<div data-role="navbar">
		  <ul>
			<li style="text-align: center;">Gutschein-Tausch-System</li>
		  </ul>
		</div>

  </div>

  <div data-role="main" class="ui-content">
    <form id="check-user" data-ajax="false" autocomplete="on">
		<label for="username" class="ui-hidden-accessible">Benutzername:</label>
		<input type="text" name="username" id="username" placeholder="Benutzername" data-clear-btn="true" autofocus>
		<label for="password" class="ui-hidden-accessible">Passwort:</label>
		<input type="password" name="password" id="password" placeholder="Passwort" data-clear-btn="true">
<!--		
		<label for="remember-login">Eingeloggt bleiben</label>
		<input type="checkbox" name="remember-login" id="remember-login" value="remember-login">
//-->
		<a href="#" id="btn-login-check" class="ui-btn ui-corner-all " data-transition="flip" data-theme="b" data-icon="check" data-iconpos="right">LOGIN</a>
    </form> 
  </div>

  <div data-role="footer" data-theme="b" data-position="fixed">
	<div data-role="navbar">
	  <ul>	
		<li style="text-align: center;"><a href="#" class="ui-btn ui-btn-inline ui-icon-info ui-btn-icon-right ui-corner-all" data-transition="slide" data-direction="reverse">Info</a></li>
		<li style="text-align: center;">Sie sind nicht eingeloggt!</li>
		<li style="text-align: center;"><a href="#main-logtout" class="ui-btn ui-btn-inline ui-icon-back ui-btn-icon-right ui-corner-all" data-transition="slide" data-direction="reverse">Back</a></li>
		</ul>
	</div>
  </div>
 
</div>

	
<div data-role="page" id="registration">
  <div data-role="header" data-theme="b" data-position="fixed" data-position="fixed">
	  
		<div data-role="navbar">
		  <ul>
			<li style="text-align: center;">GuTauS</li>
		  </ul>
		</div>
		<div data-role="navbar">
		  <ul>                
				<li style="text-align: center;"><img  style='width:77px' src='../avatare/logo 5.0.png'/></li>
		  </ul>
		</div>	
		<div data-role="navbar">
		  <ul>
			<li style="text-align: center;">Gutschein-Tausch-System</li>
		  </ul>
		</div>

  </div>


  <div data-role="main" class="ui-content" autocomplete="on">
    <form id="form-registration" data-ajax="false">
		<fieldset data-role="controlgroup">
		<label for="reg-username" class="ui-hidden-accessible">Benutzername:</label>
		<input type="text" name="reg-username" id="reg-username" placeholder="Benutzername" data-clear-btn="true" maxlength="14" autofocus>
		<label for="reg-password" class="ui-hidden-accessible">Passwort:</label>
		<input type="password" name="reg-password" id="reg-password" placeholder="Passwort" data-clear-btn="true">
		<label for="reg-password-repeat" class="ui-hidden-accessible">Passwort wiederholen:</label>
		<input type="password" name="reg-password-repeat" id="reg-password-repeat" placeholder="Passwort wiederholen" data-clear-btn="true">
		<label for="reg-email" class="ui-hidden-accessible">E-Mail:</label>
		<input type="email" name="reg-email" id="reg-email" placeholder="hans.mustermann@web.de" data-clear-btn="true">
	    <label for="reg-email-repeat" class="ui-hidden-accessible">E-Mail wiederholen :</label>
		<input type="email" name="reg-email-repeat" id="reg-email-repeat" placeholder="Email wiederholen" data-clear-btn="true"><br>
		<input type="checkbox" name="reg-agb" id="reg-agb"/>
		<label for="reg-agb">Ich habe die <a>AGBs</a> gelesen und akzeptiere diese</label><br>			
	    <a id="btn-reg-check" class="ui-btn ui-corner-all " data-transition="flip" data-theme="b" data-icon="check" data-iconpos="right">jetzt registrieren</a>
		</fieldset>
	</form> 
  </div>

  <div data-role="footer" data-theme="b" data-position="fixed">
    <h1>Sie sind nicht eingeloggt</h1>
	<a href="#" class="ui-btn ui-btn-inline ui-icon-info ui-btn-icon-bottom  ui-corner-all" data-transition="flow" data-direction="reverse">Info</a>
	<a href="#main-logtout" class="ui-btn ui-btn-inline ui-icon-back ui-btn-icon-bottom ui-corner-all" data-transition="slide" data-direction="reverse" data-iconpos="left">Back</a>
  </div>
 
</div>

<div data-role="page" id="registration-confirm">
  <div data-role="header" data-theme="b" data-position="fixed" data-position="fixed">
	  
		<div data-role="navbar">
		  <ul>
			<li style="text-align: center;">GuTauS</li>
		  </ul>
		</div>
		<div data-role="navbar">
		  <ul>                
				<li style="text-align: center;"><img  style='width:77px' src='../avatare/logo 5.0.png'/></li>
		  </ul>
		</div>	
		<div data-role="navbar">
		  <ul>
			<li style="text-align: center;">Bestätigungscode</li>
		  </ul>
		</div>

  </div>


  <div data-role="main" class="ui-content" autocomplete="on">
    <form id="form-registration-confirm" data-ajax="false">
		<fieldset data-role="controlgroup">
		<label for="reg-code" class="ui-hidden-accessible">Bestätigungscode:</label>
		<input type="text" name="reg-code" id="reg-code" placeholder="Bestätigungscode" data-clear-btn="true" maxlength="14" autofocus>		
	    <a id="btn-reg-confirm" class="ui-btn ui-corner-all" data-transition="flip" data-theme="b" data-icon="check" data-iconpos="right">senden</a>
		</fieldset>
	</form> 
  </div>

  <div data-role="footer" data-theme="b" data-position="fixed">
    <h1>Sie sind nicht eingeloggt</h1>
	<a href="#" class="ui-btn ui-btn-inline ui-icon-info ui-btn-icon-bottom  ui-corner-all" data-transition="flow" data-direction="reverse">Info</a>
	<a href="#registration" class="ui-btn ui-btn-inline ui-icon-back ui-btn-icon-bottom ui-corner-all" data-transition="slide" data-direction="reverse" data-iconpos="left">Back</a>
  </div>
 
</div>


<div data-role="page" id="main">
  <div data-role="header" data-theme="b" data-position="fixed">
	<div data-role="navbar">
	  <ul>
		<li style="text-align: center;">GuTauS</li>
	  </ul>
	</div>
	<div data-role="navbar">
	  <ul>
		<li style="text-align: center"; class="avatar"></li>
	  </ul>
	</div>	
	<div data-role="navbar">
	  <ul>
		<li style="text-align: center;">Gutschein-Tausch-System</li>
	  </ul>
	</div>
	<div data-role="navbar">
	  <ul>
		<li style="text-align: center;">HOME</li>
	  </ul>
	</div>
    <a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip" data-theme="b">LOGOUT<br><span class="username"></span></a>
  </div>

  <div data-role="main" class="ui-content">
   <a href="#creditnotes-menu" class="ui-btn ui-icon-carat-r ui-btn-icon-right" data-transition="slide" autofocus>Gutscheine</a>
   <a href="#profile"          class="ui-btn ui-icon-user    ui-btn-icon-right" data-transition="slide"          >Profil</a>
   <a href="#memberlists"      class="ui-btn ui-icon-carat-r ui-btn-icon-right" data-transition="slide"          >Mitgliederlisten</a>
   <a href="#faq"              class="ui-btn ui-icon-bullets ui-btn-icon-right" data-transition="slide"          >FAQ</a>
  </div>

  <div data-role="footer" data-theme="b" data-position="fixed">
		<div data-role="navbar">
			<ul>
				<li style="text-align: center;"><a href="#"             class="ui-btn ui-btn-inline ui-icon-info ui-btn-icon-right ui-corner-all"  data-transition="flow" data-direction="reverse">Info</a></li>
			</ul>
		</div>
  </div>
</div> 



<!--
//*************************************************************************************************************************************************
// SELECT CREDITNOTE 
//*************************************************************************************************************************************************	
//-->
	<div data-role="page" id="creditnotes-menu">
		<?php include('header.html');?>
		
	  <div data-role="main" class="ui-content">
	   <a href="#" 					id="btn-creditnotes-published" class="ui-btn ui-icon-carat-r ui-btn-icon-right" autofocus>herausgebene Gutscheine</a>
	   <a href="#" 					id="btn-creditnotes-received"  class="ui-btn ui-icon-carat-r ui-btn-icon-right"          >erhaltene Gutscheine</a>
	   <a href="#"            		id="btn-creditnote-horus"      class="ui-btn ui-icon-carat-r ui-btn-icon-right"          >Horus</a>
	   <a href="#"            		id="btn-creditnote-euro"       class="ui-btn ui-icon-carat-r ui-btn-icon-right"          >Euro</a>
	   <a href="#" 					id="btn-creditnotes-publish"   class="ui-btn ui-icon-carat-r ui-btn-icon-right"          >Gutschein selbst herausgeben</a>
	  </div>
	  
	  <?php include('footer.html');?>
	</div> 
	
		<div data-role="page" id="creditnotes-list">
			<?php include('header.html');?>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="creditnotes-filter" data-type="search">
			</form>
			<ul data-role="listview" id="list-creditnotes" data-filter="true" data-input="#creditnotes-filter" data-autodividers="true" data-inset="true">
				<li><a href="#creditnote" onclick="chosen_creditnote('Amet-Euro')">Amet-Euro</a></li>
				<li><a href="#creditnote" onclick="chosen_creditnote('Amet-Zeit-Taler')">Amet-Zeit-Taler</a></li>
			</ul>	
		  </div>

		  <?php include('footer.html');?>
		</div> 	
	
			<div data-role="page" id="creditnote">
				<?php include('header.html');?>
						  
			  <div data-role="main" class="ui-content">
				<a href="#" id="btn-pay"				class="ui-btn ui-icon-carat-r ui-btn-icon-right" autofocus>bezahle</a>
				<a href="#" id="btn-transactions"		class="ui-btn ui-icon-carat-r ui-btn-icon-right">Kontoumsätze</a>
				<a href="#" id="btn-value"				class="ui-btn ui-icon-carat-r ui-btn-icon-right ">Wert</a>
				<a href="#" id="btn-assessment"			class="ui-btn ui-icon-carat-r ui-btn-icon-right ">Bewertung</a>
				<a href="#" id="btn-credit_limit"		class="ui-btn ui-icon-carat-r ui-btn-icon-right ">Max. Überziehung</a>
				<a href="#" id="btn-acceptance_limit"	class="ui-btn ui-icon-carat-r ui-btn-icon-right ">Max. Akzeptanz</a>
				<a href="#" id="btn-exchange-points"	class="ui-btn ui-icon-carat-r ui-btn-icon-right ">Umtauschstellen</a>
				<a href="#" id="btn-creditors"			class="ui-btn ui-icon-carat-r ui-btn-icon-right ">Schuldner</a>
				<a href="#" id="btn-debtors"			class="ui-btn ui-icon-carat-r ui-btn-icon-right ">Gläubiger</a>
				<a href="#" id="btn-publisher"			class="ui-btn ui-icon-carat-r ui-btn-icon-right ">Herausgeber</a>
				<a href="#" id="btn-loading"			class="ui-btn ui-icon-carat-r ui-btn-icon-right ">aufladen</a>
				<a href="#" id="btn-pay-out"			class="ui-btn ui-icon-carat-r ui-btn-icon-right ">auszahlen</a>	
			  </div>

			  <?php include('footer.html');?>
			</div>			

		<div data-role="page" id="creditnotes-publish">
			<?php include('header.html');?>

		  <div data-role="main" class="ui-content">
		   <a href="#creditnote-publish" id="btn-creditnote-publish-euro"    class="ui-btn ui-icon-carat-r ui-btn-icon-right creditnote" autofocus><span class="username"></span>-Euro</a>
		   <a href="#creditnote-publish" id="btn-creditnote-publish-minuto"  class="ui-btn ui-icon-carat-r ui-btn-icon-right creditnote"          ><span class="username"></span>-Minuto</a>
		   <a href="#creditnote-publish" id="btn-creditnote-publish-goods"   class="ui-btn ui-icon-carat-r ui-btn-icon-right creditnote"          > Waren-Gutschein</a>
		   <a href="#creditnote-publish" id="btn-creditnote-publish-service" class="ui-btn ui-icon-carat-r ui-btn-icon-right creditnote"          > Diensleistungs-Gutschein</a>
		  </div>

		  <?php include('footer.html');?>
		</div> 

			<div data-role="page" id="creditnote-publish">
				<?php include('header.html');?>

			  <div data-role="main" class="ui-content">
					<form id="creditnote-publish-form" data-ajax="false" autocomplete="on">
						<label for="creditnotename-input">
							Gutschein Bezeichnung:</label>
						<input type="text" name="creditnotename-input" id="creditnotename-input" placeholder="z.B. Alis-Döner-Taler" data-clear-btn="true">

						<label for="creditnote-value-textarea">
							Der Wert eines Ihrer Gutscheine ist?</label>
						<textarea name="creditnote-value-textarea" id="creditnote-value-textarea" placeholder="Beschreiben Sie hier möglichst genau, welchen Wert einer Ihrer Gutscheine hat!" data-clear-btn="true"></textarea>

						<label for="user_credit_limit-input" >
							Wieviele Ihre Gutscheine wollen Sie maximal in den Umlauf bringen ?</label>
						<input type="text" name="user_credit_limit-input" id="user_credit_limit-input" placeholder="max. Umlauf" data-clear-btn="true" value=10000>

						<label for="member_credit_limit-input" >
							Um wieviele Gutscheine dürfen Personen, 
							die ein solches Gutscheinkonto durch Erst-Überweisung eröffnet bekommen dieses Konto überziehen? 
							Hinweis: Diese Personen wären damit selbst Herausgeber Ihrer Gutscheine!!!</label>
						<input type="text" name="member_credit_limit-input" id="member_credit_limit-input" placeholder="Überziehungslimit der Besitzer Ihrer Gutscheine" data-clear-btn="true" value=0>

						<label for="creditnote-digits-input" >
							Wieviele Nachkommastellen soll Ihr Gutscheine haben?</label>
						<input type="text" name="creditnote-digits-input" id="creditnote-digits-input" placeholder="Anzahl der Nachkommastellen" data-clear-btn="true" value=0>
						
						
						
						<label for="creditnote-privat-checkbox">
							Diese Gutscheine sind privat.<br>
							Die Gutscheine können nur an Personen weitergegeben werden,<br>
							die ein Gutschein-Konto per Erstüberweisung von Ihnen erhalten haben.</label>
						<input type="checkbox" name="creditnote-privat-checkbox" id="creditnote-privat-checkbox" checked="checked">

						
						</form> 
 			  </div>

			  <?php include('footer.html');?>
			</div> 				
			
		

<!--			
//*************************************************************************************************************************************************
// PAY WITH SELECTED CREDITNOTE BY SELECTING A RECEIVER AND DETERMINE A PURPOSE 
//*************************************************************************************************************************************************  
//-->		
				<div data-role="page" id="pay">
					<?php include('header.html');?>
				
				  <div data-role="main" class="ui-content">
						<a href="#" id="btn-creditnotes-pay_to_publisher"		class="ui-btn ui-icon-user ui-btn-icon-right" autofocus>an Herausgeber</a> <!-- nur Falls nur ein Herausgeber d.h. kein Horus? oder doch wenn danach Herausgeber-Liste gezeigt wird? -->
						<a href="#" id="btn-creditnotes-pay_to_member-known" 	class="ui-btn ui-icon-grid ui-btn-icon-right" >an bekanntes Mitglied</a>
						<a href="#" id="btn-creditnotes-pay_to_member-searched" class="ui-btn ui-icon-grid ui-btn-icon-right" >an Mitglied</a>
						<a href="#" id="btn-creditnotes-pay_to_email"			class="ui-btn ui-icon-mail ui-btn-icon-right">an E-Mail</a>
						<a href="#" id="btn-creditnotes-pay_to_mobile"			class="ui-btn ui-icon-phone ui-btn-icon-right">an Handynummer</a>
				  </div>

				  <?php include('footer.html');?>
				</div> 
				
					<div data-role="page" id="pay-member">
						<?php include('header.html');?>
						  
						<div data-role="main" class="ui-content">
							<a href="#members-known" id="btn-pay-members-known" class="ui-btn ui-icon-grid ui-btn-icon-right" autofocus>ein mir bekanntes Mitglieder</a>
							<a href="#members-unknown" class="ui-btn ui-icon-grid ui-btn-icon-right">ein mir unbekanntes Mitglieder</a>
							<a href="#debtors" class="ui-btn ui-icon-grid ui-btn-icon-right">einen meiner Schuldner</a>
							<a href="#creditors" class="ui-btn ui-icon-grid ui-btn-icon-right">einen meiner Gläubiger</a>
							<a href="#suppliers" class="ui-btn ui-icon-grid ui-btn-icon-right">einen  meiner Lieferanten</a>
							<a href="#customers" class="ui-btn ui-icon-grid ui-btn-icon-right">einen meiner Kunden</a>
						</div>

						<?php include('footer.html');?>
					</div> 

					<div data-role="page" id="pay-email">
					  <?php include('header.html');?>
					  
					  <div data-role="main" class="ui-content">
					   <form id="form-pay-email" data-ajax="false">
							<label for="pay-mail" class="ui-hidden-accessible">E-Mail:</label>
							<input type="text" id="input-email-receiver" name="pay-mail" id="pay-mail" placeholder="hans.mustermann@web.de" data-clear-btn="true" autofocus>
	<!--						<a href="#" id="btn-email-receiver" class="ui-btn ui-corner-all " data-transition="flip" data-theme="b" data-icon="check" data-iconpos="right">Weiter</a>
    -->
	</form> 
					  </div>

						<?php include('footer.html');?>
					</div> 

					<div data-role="page" id="pay-mobile">
						<?php include('header.html');?>
						
					  <div data-role="main" class="ui-content">
					  <form id="pay-mob" data-ajax="false">
							<label for="pay-mob" class="ui-hidden-accessible">Handynummer:</label>
							<input type="text" id="input-mobile-receiver" name="pay-mob" id="pay-mop" placeholder="00491738469121" data-clear-btn="true" autofocus>
						</form> 
					  </div>

						<?php include('footer.html');?>
					</div> 

						<div data-role="page" id="pay-amount">
							<?php include('header.html');?>
							
						  <div data-role="main" class="ui-content">
							<form id="pay-mob" data-ajax="false">
								<label for="form-pay-amount" class="ui-hidden-accessible">Betrag:</label>
								<input type="number" name="pay-mob" id="input-pay-amount" placeholder="z.B. 30.00" data-clear-btn="true" autofocus><span class="creditnote-chosen"></span>
							</form> 
						  </div>

							<?php include('footer.html');?>
						</div> 

							<div data-role="page" id="pay-purpose">
								<?php include('header.html');?>
							
							  <div data-role="main" class="ui-content">
							  <form id="form-pay-purpose" data-ajax="false">
									<label for="input-pay-purpose" class="ui-hidden-accessible">Verwendungszweck:</label>
									<input type="text" name="pay-purp" id="input-pay-purpose" placeholder="z.B. das Mähen" data-clear-btn="true" autofocus>
								</form> 
							  </div>

								<?php include('footer.html');?>
							</div> 
							

	
<!--			
//*************************************************************************************************************************************************
// TRANSACTIONS SOW 
//*************************************************************************************************************************************************  
//-->	
				<div data-role="page" id="transactions-table">
					<?php include('header.html');?>

				  <div data-role="main" class="ui-content">

						<table id="tabel-transactions" data-role="table" data-mode="columntoggle" class="ui-responsive" data-column-btn-text="SPALTEN...">
							<thead>
								<tr>
								  <th>Mitglied</th>
								  <th id="tabel-transactions-creditnote"style="text-align: right">...-Minuto</th>
								  <th data-priority="1">für</th>
								  <th data-priority="2">Datum</th>
								  <th data-priority="3">überwiesen über</th>
								</tr>
							</thead>
							<tbody >
								<tr>
								  <td>Nick</td>
								  <td class="negative-number" style="text-align: right">-5,00</td>
								  <td>200 Euro Bargeld</td>
								  <td>2014-07-10 20:18:08</td>
								  <td>Mitglied</td>
								</tr>
								<tr>
								  <td>Ute</td>
								  <td class="positive-number" style="text-align: right">23,00</td>
								  <td>2 Bücher</td>
								  <td>2014-07-10 20:05:27</td>
								  <td>Mitglied</td>
								</tr>
								<tr>
								  <td>Lore</td>
								  <td class="negative-number" style="text-align: right">-23,45</td>
								  <td>rote Handtasche </td>
								  <td>	2013-09-18 18:22:57</td>
								  <td>Email</td>
								</tr>
								<tr>
								  <td>Thomas</td>
								  <td class="positive-number" style="text-align: right">30,00</td>
								  <td>Haare schneiden</td>
								  <td>2013-09-18 18:10:31</td>
								  <td>Mobil</td>
								</tr>
						  </tbody>
							
						</table>
						

				  </div>

				  <?php include('footer.html');?>
				</div> 	

	
						
<!--			
//*************************************************************************************************************************************************
// SHOW PROFILE 
//*************************************************************************************************************************************************  
//-->																			
	<div data-role="page" id="profile">
	  <div data-role="header" data-theme="b" data-position="fixed" data-theme="b">
		<div data-role="navbar">
		  <ul>
				<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
				<li style="text-align: center;">GuTauS</li>
				<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
		  </ul>
		</div>
		<div data-role="navbar">
		  <ul>
				<li style="text-align: center"; class="avatar"></li>
		  </ul>
		</div>
		<h1>Profil</h1>
	  </div>

	  <div data-role="main" class="ui-content">
	   
	  </div>

		<?php include('footer.html');?>
	</div> 


<!--
//*************************************************************************************************************************************************
// SELECT MEMBER 
//*************************************************************************************************************************************************	
//-->
	<div data-role="page" id="members-menu">
		<?php include('header.html');?>
		
	  <div data-role="main" class="ui-content">
	   <a href="#" 					id="btn-members-published" class="ui-btn ui-icon-carat-r ui-btn-icon-right" autofocus>herausgebene Gutscheine</a>
	   <a href="#" 					id="btn-members-received"  class="ui-btn ui-icon-carat-r ui-btn-icon-right"          >erhaltene Gutscheine</a>
	   <a href="#"            		id="btn-member-horus"      class="ui-btn ui-icon-carat-r ui-btn-icon-right"          >Horus</a>
	   <a href="#"            		id="btn-member-euro"       class="ui-btn ui-icon-carat-r ui-btn-icon-right"          >Euro</a>
	   <a href="#" 					id="btn-members-publish"   class="ui-btn ui-icon-carat-r ui-btn-icon-right"          >Gutschein selbst herausgeben</a>
	  </div>
	  
	  <?php include('footer.html');?>
	</div> 
	
		<div data-role="page" id="members-list">
			<?php include('header.html');?>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="members-filter" data-type="search">
			</form>
			<ul data-role="listview" id="list-members" data-filter="true" data-input="#members-filter" data-autodividers="true" data-inset="true">
				<!-- is filled from DB//-->
			</ul>
		  </div>

		  <?php include('footer.html');?>
		</div> 	
	
			<div data-role="page" id="member">
				<?php include('header.html');?>
						  
			  <div data-role="main" class="ui-content">
				<a href="#" id="btn-pay"				class="ui-btn ui-icon-carat-r ui-btn-icon-right" autofocus>bezahle</a>
				<a href="#" 							class="ui-btn ui-icon-carat-r ui-btn-icon-right">Umsätze</a>
				<a href="#" id="btn-value"				class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">Wert</a>
				<a href="#" id="btn-assessment"			class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">Bewertung</a>
				<a href="#" id="btn-credit_limit"		class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">Max. Überziehung</a>
				<a href="#" id="btn-acceptance_limit"	class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">Max. Akzeptanz</a>
				<a href="#" id="btn-exchange-points"	class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">Umtauschstellen</a>
				<a href="#" id="btn-creditors"			class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">Schuldner</a>
				<a href="#" id="btn-debtors"			class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">Gläubiger</a>
				<a href="#" id="btn-publisher"			class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">Herausgeber</a>
				<a href="#" id="btn-loading"			class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">aufladen</a>
				<a href="#" id="btn-pay-out"			class="ui-btn ui-icon-carat-r ui-btn-icon-right btn-member">auszahlen</a>	
			  </div>

			  <?php include('footer.html');?>
			</div>			
	
	


	
	
<!--			
//*************************************************************************************************************************************************
// SELECT MEMBER 
//*************************************************************************************************************************************************  
//-->	
	<div data-role="page" id="memberlists-menu">
		<?php include('header.html');?>

		<div data-role="main" class="ui-content">
			<a href="#" id="btn-members-known"		class="ui-btn ui-icon-grid ui-btn-icon-right">bekannte Mitglieder</a>
			<a href="#" id="btn-suppliers" 			class="ui-btn ui-icon-grid ui-btn-icon-right">Lieferanten</a>
			<a href="#" id="btn-customers"			class="ui-btn ui-icon-grid ui-btn-icon-right">Kunden</a>
			<a href="#" id="btn-debtors"			class="ui-btn ui-icon-grid ui-btn-icon-right">Schuldner</a>
			<a href="#" id="btn-creditors"			class="ui-btn ui-icon-grid ui-btn-icon-right">Gläubiger</a>
			<a href="#" id="btn-members-unknown"	class="ui-btn ui-icon-grid ui-btn-icon-right">unbekannte Mitglieder</a>
			<a href="#" id="btn-members-all" 		class="ui-btn ui-icon-grid ui-btn-icon-right">alle Mitglieder</a>  
		</div>

		<?php include('footer.html');?>
	</div> 

		<div data-role="page" id="memberlist">
		  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center"; class="avatar"></li>
			  </ul>
			</div>
			<h1>meine Schuldner</h1>
		  </div>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="debtors-filter" data-type="search" autofocus>
			</form>			  
			<ul data-role="listview" data-filter="true" data-input="#debtors-filter" data-autodividers="true" data-inset="true">
				<li><a href="#pay-amount" class="receiver">Ali</a></li>
				<li><a href="#pay-amount" class="receiver">Amet</a></li>
				<li><a href="#pay-amount" class="receiver">Lore</a></li>
				<li><a href="#pay-amount" class="receiver">Marco</a></li>
				<li><a href="#pay-amount" class="receiver">Rudi</a></li>
				<li><a href="#pay-amount" class="receiver">Sandra</a></li>
				<li><a href="#pay-amount" class="receiver">Valmir</a></li>
				<li><a href="#pay-amount" class="receiver">Vesel</a></li>
				<li><a href="#pay-amount" class="receiver">Yasar</a></li>
			 </ul>						  
		  </div>

			<?php include('footer.html');?>
		</div> 	
	
		<div data-role="page" id="debtors">
		  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center"; class="avatar"></li>
			  </ul>
			</div>
			<h1>meine Schuldner</h1>
		  </div>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="debtors-filter" data-type="search" autofocus>
			</form>			  
			<ul data-role="listview" data-filter="true" data-input="#debtors-filter" data-autodividers="true" data-inset="true">
				<li><a href="#pay-amount" class="receiver">Ali</a></li>
				<li><a href="#pay-amount" class="receiver">Amet</a></li>
				<li><a href="#pay-amount" class="receiver">Lore</a></li>
				<li><a href="#pay-amount" class="receiver">Marco</a></li>
				<li><a href="#pay-amount" class="receiver">Rudi</a></li>
				<li><a href="#pay-amount" class="receiver">Sandra</a></li>
				<li><a href="#pay-amount" class="receiver">Valmir</a></li>
				<li><a href="#pay-amount" class="receiver">Vesel</a></li>
				<li><a href="#pay-amount" class="receiver">Yasar</a></li>
			 </ul>						  
		  </div>

			<?php include('footer.html');?>
		</div> 

		<div data-role="page" id="creditors">
		  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center"; class="avatar"></li>
			  </ul>
			</div>
			<h1>meine Gläubiger</h1>
		  </div>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="creditors-filter" data-type="search" autofocus>
			</form>			  
			<ul data-role="listview" data-filter="true" data-input="#creditors-filter" data-autodividers="true" data-inset="true">
				<li><a href="#pay-amount" class="receiver">Adrian</a></li>
				<li><a href="#pay-amount" class="receiver">Amet</a></li>
				<li><a href="#pay-amount" class="receiver">Liana</a></li>
				<li><a href="#pay-amount" class="receiver">Marco</a></li>
				<li><a href="#pay-amount" class="receiver">Olga</a></li>
				<li><a href="#pay-amount" class="receiver">Sabine</a></li>
				<li><a href="#pay-amount" class="receiver">Sandra</a></li>
				<li><a href="#pay-amount" class="receiver">Uli</a></li>
				<li><a href="#pay-amount" class="receiver">Valdrin</a></li>
				<li><a href="#pay-amount" class="receiver">Vesel</a></li>
			 </ul>						  
		  </div>

			<?php include('footer.html');?>
		</div> 

		<div data-role="page" id="suppliers">
		  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center"; class="avatar"></li>
			  </ul>
			</div>
			<h1>meine Lieferanten</h1>
		  </div>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="suppliers-filter" data-type="search" autofocus>
			</form>
			<ul data-role="listview" data-filter="true" data-input="#suppliers-filter" data-autodividers="true" data-inset="true">
				<li><a href="#pay-amount" class="receiver">Ali</a></li>
				<li><a href="#pay-amount" class="receiver">Amet</a></li>
				<li><a href="#pay-amount" class="receiver">Liana</a></li>
				<li><a href="#pay-amount" class="receiver">Lore</a></li>
				<li><a href="#pay-amount" class="receiver">Marco</a></li>
				<li><a href="#pay-amount" class="receiver">Rudi</a></li>
				<li><a href="#pay-amount" class="receiver">Sabine</a></li>
				<li><a href="#pay-amount" class="receiver">Sandra</a></li>
				<li><a href="#pay-amount" class="receiver">Uli</a></li>
				<li><a href="#pay-amount" class="receiver">Valdrin</a></li>
				<li><a href="#pay-amount" class="receiver">Verena</a></li>
				<li><a href="#pay-amount" class="receiver">Vesel</a></li>
			 </ul>		
		  
		  </div>

			<?php include('footer.html');?>
		</div> 

		<div data-role="page" id="customers">
		  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center"; class="avatar"></li>
			  </ul>
			</div>
			<h1>meine Kunden</h1>
		  </div>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="customers-filter" data-type="search" autofocus>
			</form>
			<ul data-role="listview" data-filter="true" data-input="#customers-filter" data-autodividers="true" data-inset="true">
				<li><a href="#pay-amount" class="receiver">Adrian</a></li>
				<li><a href="#pay-amount" class="receiver">Ali</a></li>
				<li><a href="#pay-amount" class="receiver">Klaus</a></li>
				<li><a href="#pay-amount" class="receiver">Amet</a></li>
				<li><a href="#pay-amount" class="receiver">Marco</a></li>
				<li><a href="#pay-amount" class="receiver">Olga</a></li>
				<li><a href="#pay-amount" class="receiver">Sandra</a></li>
				<li><a href="#pay-amount" class="receiver">Uli</a></li>
				<li><a href="#pay-amount" class="receiver">Valdrin</a></li>
				<li><a href="#pay-amount" class="receiver">Verena</a></li>
				<li><a href="#pay-amount" class="receiver">Yasar</a></li>
			 </ul>					  
		  </div>

			<?php include('footer.html');?>
		</div> 

		<div data-role="page" id="members-known">
		  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center"; class="avatar"></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center;">bekannte Mitglieder</li>
			  </ul>
			</div> 
			<div data-role="navbar">
			  <ul>
				<li style="text-align: center; background-color: blue">bezahle mit <span class="creditnote-chosen"></span> an ...</li>
			  </ul>
			</div>  
		  </div>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="members-known-filter" data-type="search">
			</form>
			<ul data-role="listview" id="list-members-known" data-filter="true" data-input="#members-known-filter" data-autodividers="true" data-inset="true">
				<li><a href="#pay-amount" class="receiver">Adrian</a></li>
				<li><a href="#pay-amount" class="receiver">Ali</a></li>
				<li><a href="#pay-amount" class="receiver">Klaus</a></li>
				<li><a href="#pay-amount" class="receiver">Amet</a></li>
				<li><a href="#pay-amount" class="receiver">Liana</a></li>
				<li><a href="#pay-amount" class="receiver">Lore</a></li>
				<li><a href="#pay-amount" class="receiver">Marco</a></li>
				<li><a href="#pay-amount" class="receiver">Olga</a></li>
				<li><a href="#pay-amount" class="receiver">Rudi</a></li>
				<li><a href="#pay-amount" class="receiver">Sabine</a></li>
				<li><a href="#pay-amount" class="receiver">Sandra</a></li>
				<li><a href="#pay-amount" class="receiver">Uli</a></li>
				<li><a href="#pay-amount" class="receiver">Valdrin</a></li>
				<li><a href="#pay-amount" class="receiver">Valmir</a></li>
				<li><a href="#pay-amount" class="receiver">Verena</a></li>
				<li><a href="#pay-amount" class="receiver">Vesel</a></li>
				<li><a href="#pay-amount" class="receiver">Yasar</a></li>
			 </ul>			  			  			  
		  </div>

			<?php include('footer.html');?>
		</div> 

		<div data-role="page" id="members-unknown">
		  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center"; class="avatar"></li>
			  </ul>
			</div>
			<h1>unbekannte Mitglieder</h1>
		  </div>

		  <div data-role="main" class="ui-content">
			<form class="ui-filterable">
				<input id="members-unknown-filter" data-type="search" autofocus>
			</form>			  
			<ul data-role="listview" data-filter="true" data-input="#members-unknown-filter" data-autodividers="true" data-inset="true">
				<li><a href="#pay-amount" class="receiver">Adele</a></li>
				<li><a href="#pay-amount" class="receiver">Agnes</a></li>
				<li><a href="#pay-amount" class="receiver">Albert</a></li>
				<li><a href="#pay-amount" class="receiver">Billy</a></li>
				<li><a href="#pay-amount" class="receiver">Bob</a></li>
				<li><a href="#pay-amount" class="receiver">Calvin</a></li>
				<li><a href="#pay-amount" class="receiver">Cameron</a></li>
				<li><a href="#pay-amount" class="receiver">Chloe</a></li>
				<li><a href="#pay-amount" class="receiver">Christina</a></li>
				<li><a href="#pay-amount" class="receiver">Diana</a></li>
				<li><a href="#pay-amount" class="receiver">Gabriel</a></li>
				<li><a href="#pay-amount" class="receiver">Glen</a></li>
				<li><a href="#pay-amount" class="receiver">Ralph</a></li>
				<li><a href="#pay-amount" class="receiver">Valarie</a></li>
			 </ul>
		  
		  </div>

			<?php include('footer.html');?>
		</div> 

		<div data-role="page" id="members-all">
		  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
			<div data-role="navbar">
			  <ul>
					<li style="text-align: center"; class="avatar"></li>
			  </ul>
			</div>
			<h1>alle Mitglieder</h1>
		  </div>

		  <div data-role="main" class="ui-content">
				<form class="ui-filterable">
					<input id="members-all-filter" data-type="search" autofocus>
				</form>			  
				<ul data-role="listview" data-filter="true" data-input="#members-all-filter" data-autodividers="true" data-inset="true">
					<li><a href="#pay-amount" class="receiver">Adele</a></li>
					<li><a href="#pay-amount" class="receiver">Adrian</a></li>
					<li><a href="#pay-amount" class="receiver">Agnes</a></li>
					<li><a href="#pay-amount" class="receiver">Albert</a></li>
					<li><a href="#pay-amount" class="receiver">Ali</a></li>
					<li><a href="#pay-amount" class="receiver">Billy</a></li>
					<li><a href="#pay-amount" class="receiver">Bob</a></li>
					<li><a href="#pay-amount" class="receiver">Calvin</a></li>
					<li><a href="#pay-amount" class="receiver">Cameron</a></li>
					<li><a href="#pay-amount" class="receiver">Chloe</a></li>
					<li><a href="#pay-amount" class="receiver">Christina</a></li>
					<li><a href="#pay-amount" class="receiver">Diana</a></li>
					<li><a href="#pay-amount" class="receiver">Gabriel</a></li>
					<li><a href="#pay-amount" class="receiver">Glen</a></li>
					<li><a href="#pay-amount" class="receiver">Klaus</a></li>
					<li><a href="#pay-amount" class="receiver">Amet</a></li>
					<li><a href="#pay-amount" class="receiver">Liana</a></li>
					<li><a href="#pay-amount" class="receiver">Lore</a></li>
					<li><a href="#pay-amount" class="receiver">Marco</a></li>
					<li><a href="#pay-amount" class="receiver">Olga</a></li>
					<li><a href="#pay-amount" class="receiver">Ralph</a></li>
					<li><a href="#pay-amount" class="receiver">Rudi</a></li>
					<li><a href="#pay-amount" class="receiver">Sabine</a></li>
					<li><a href="#pay-amount" class="receiver">Sandra</a></li>
					<li><a href="#pay-amount" class="receiver">Uli</a></li>
					<li><a href="#pay-amount" class="receiver">Valarie</a></li>
					<li><a href="#pay-amount" class="receiver">Valdrin</a></li>
					<li><a href="#pay-amount" class="receiver">Valmir</a></li>
					<li><a href="#pay-amount" class="receiver">Verena</a></li>
					<li><a href="#pay-amount" class="receiver">Vesel</a></li>
					<li><a href="#pay-amount" class="receiver">Yasar</a></li>					
				 </ul>			  			  			  			
		  </div>

			<?php include('footer.html');?>
		</div> 

			<div data-role="page" id="member">
			  <div data-role="header" data-theme="b" data-position="fixed">
				<div data-role="navbar">
				  <ul>
					<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
					<li style="text-align: center;">GuTauS</li>
					<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
				  </ul>
				</div>
				<div data-role="navbar">
				  <ul>
						<li style="text-align: center"; class="avatar"></li>
				  </ul>
				</div>
				<h1>Mitglied</h1>
			  </div>


			  <div data-role="main" class="ui-content">
				
				<form method="post" action="demoform.asp">
				  <div class="ui-field-contain">
					<label for="member-name">Benuzername:</label>
					<input type="text" name="member-name" id="member-name" disabled="disabled">
					<label for="member-status">Status:</label>
					<input type="text" id="member-status" disabled="disabled" value="online">
					<label for="member-last-login">Letzter Login:</label>
					<input type="text" id="member-last-login" disabled="disabled" value="online">
					<label for="member-msg" placeholder="Bitte geben Sie hier Ihre Nachricht ein ...">Nachricht:</label>
					<textarea name="member-msg" id="member-msg"></textarea>	
				  </div>
				  <input type="submit" name="send-msg" data-inline="true" value="Nachricht senden">
				</form>
				
				
				<div data-role="collapsibleset">
				  <div data-role="collapsible">
					<h3>Avatar bzw. Logo:</h3>
					<p>Hier kommt das Logo des Mitglieds</p>
				  </div>
				  <div data-role="collapsible">
					<h3>Adresse:</h3>
					<p>I'm the expanded content.</p>
				  </div>
				  <div data-role="collapsible">
					<h3>Kontaktdaten:</h3>
					<p>I'm the expanded content.</p>
				  </div>
				  <div data-role="collapsible">
					<h3>Herausgegebne Gutscheine</h3>
					<ul data-role="listview" data-inset="true">
						<li><a href="#member-creditnote">Ali-Euro</a></li>
						<li><a href="#member-creditnote">Alis-Döner-Taler</a></li>
						<li><a href="#member-creditnote">Horus</a></li>
					</ul>		
				  </div>
				</div>

			  </div>



				<?php include('footer.html');?>
			</div> 
					
				<div data-role="page" id="member-creditnote">
				  <div data-role="header" data-theme="b" data-position="fixed">
					<div data-role="navbar">
					  <ul>
							<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
							<li style="text-align: center;">GuTauS</li>
							<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
					  </ul>
					</div>
					<div data-role="navbar">
					  <ul>
							<li style="text-align: center"; class="avatar"></li>
					  </ul>
					</div>
					<h1> Alis-Döner-Taler</h1>
				  </div>

				  <div data-role="main" class="ui-content">
					<a href="#pay" class="ui-btn ui-icon-carat-r ui-btn-icon-right" autofocus>bezahle</a> <!-- nur Falls ein Konto dieser Gutscheine --> 
					<a href="#" class="ui-btn ui-icon-carat-r ui-btn-icon-right">Umsätze</a> <!-- nur Falls ein Konto dieser Gutscheine -->
					<a href="#" class="ui-btn ui-icon-carat-r ui-btn-icon-right">Wert</a>
					<a href="#" class="ui-btn ui-icon-carat-r ui-btn-icon-right">meine max. Akzeptanz</a> <!-- nur Falls ein Konto dieser Gutscheine -->
					<a href="#" class="ui-btn ui-icon-carat-r ui-btn-icon-right">Umtauschstellen</a>
				  </div>

					<?php include('footer.html');?>
				</div>	



				
<!--			
//*************************************************************************************************************************************************
// SHOW FAQ 
//*************************************************************************************************************************************************  
//-->							
	<div data-role="page" id="faq">
	  <div data-role="header" data-theme="b" data-position="fixed">
			<div data-role="navbar">
			  <ul>
				<li><a href="#" class="ui-btn ui-btn-inline ui-corner-all btn-logout" data-transition="flip">LOGOUT<br><span class="username"></span></a></li>
				<li style="text-align: center;">GuTauS</li>
				<li><a href="#main" class="ui-btn ui-btn-inline ui-icon-home ui-btn-icon-right ui-corner-all " data-transition="flow" data-direction="reverse">Home</a></li>
			  </ul>
			</div>
		<h1>FAQ</h1>
	  </div>


	  <div data-role="main" class="ui-content">
		<div data-role="collapsibleset">
		  <div data-role="collapsible">
			<h3>1.) Die grundlegende Idee des Horus Gutschein-Tausch-Systems (GuTauS):</h3>
			<p>I'm the expanded content.</p>
		  </div>
		  <div data-role="collapsible">
			<h3>Click me - I'm collapsible!</h3>
			<p>I'm the expanded content.</p>
		  </div>
		  <div data-role="collapsible">
			<h3>Click me - I'm collapsible!</h3>
			<p>I'm the expanded content.</p>
		  </div>
		  <div data-role="collapsible">
			<h3>Click me - I'm collapsible!</h3>
			<p>I'm the expanded content.</p>
		  </div>
		</div>
	  </div>

		<?php include('footer.html');?>
	</div> 



</body>

</html>
