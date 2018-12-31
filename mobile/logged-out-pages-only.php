		<!--
		//*************************************************************************************************************************************************
		// LOGIN LOGOUT REGISTRATION
		//*************************************************************************************************************************************************	
		//-->
		<div data-role="page" id="page-logged-out-menu" data-theme="a">
			<div data-role="header"  data-position="fixed" data-position="fixed">
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
				<li style="text-align: center;">Mit GuTauS bezahlen Sie Freunde und Bekannte ohne Geld<br>mit eigenen Gutscheinen an wen Sie wollen!!!</li>
				</ul>
			</div>
			</div>
			<div data-role="main" class="ui-content" style="position: relative;top: 45px;">
			<a href="#page-login" class="ui-btn ui-icon-edit ui-btn-icon-right" data-transition="flip" autofocus>LOGIN</a>
			<a href="#page-faq" class="ui-btn ui-icon-bullets ui-btn-icon-right" data-transition="slide">FAQ</a>
			<a href="#page-registration" class="ui-btn ui-icon-edit ui-btn-icon-right" data-transition="slide">REGISTRIERUNG</a>
			</div>

			<div data-role="footer" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li style="text-align: center;"><a href="#" class="ui-btn ui-btn-inline ui-icon-info ui-btn-icon-right  ui-corner-all" data-transition="flow" data-direction="reverse">Info</a></li>
					</ul>
				</div>
			</div>
		</div> 
		<!--
		********************************************************************************************************
		-->
		<div data-role="page" id="page-login" data-theme="a" >
			<div data-role="header" data-position="fixed" data-position="fixed">
				
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
					<li style="text-align: center;">LOGIN</li>
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
				<a href="#" id="btn-login-check" class="ui-btn ui-corner-all " data-transition="flip" data-icon="check" data-iconpos="right">LOGIN</a>
				</form> 
			</div>

			<div data-role="footer" data-position="fixed">
			<div data-role="navbar">
				<ul>	
				<li style="text-align: center;"><a href="#" class="ui-btn ui-btn-inline ui-icon-info ui-btn-icon-right ui-corner-all" data-transition="slide" data-direction="reverse">Info</a></li>
				<li style="text-align: center;">Sie sind nicht eingeloggt!</li>
				<li style="text-align: center;"><a href="#page-logged-out-menu" class="ui-btn ui-btn-inline ui-icon-back ui-btn-icon-right ui-corner-all" data-transition="slide" data-direction="reverse">Back</a></li>
				</ul>
			</div>
			</div>
		
		</div>

		<!--
		********************************************************************************************************
		-->
		<div data-role="page" id="page-registration" data-theme="a" >
			<div data-role="header" data-position="fixed" data-position="fixed">
				
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
					<li style="text-align: center;">REGISTRIERUNG</li>
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

			<div data-role="footer" data-position="fixed">
				<h1>Sie sind nicht eingeloggt</h1>
			<a href="#" class="ui-btn ui-btn-inline ui-icon-info ui-btn-icon-bottom  ui-corner-all" data-transition="flow" data-direction="reverse">Info</a>
			<a href="#page-logged-out-menu" class="ui-btn ui-btn-inline ui-icon-back ui-btn-icon-bottom ui-corner-all" data-transition="slide" data-direction="reverse" data-iconpos="left">Back</a>
			</div> 
		</div>
		<!--
		********************************************************************************************************
		-->
		<div data-role="page" id="page-registration-confirm" data-theme="a">
			<div data-role="header" data-position="fixed" data-position="fixed">
				
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
			<a href="#page-registration" class="ui-btn ui-btn-inline ui-icon-back ui-btn-icon-bottom ui-corner-all" data-transition="slide" data-direction="reverse" data-iconpos="left">Back</a>
			</div> 
		</div>