//*************************************************************************************************************************************************
// GLOBAL CLASSES
//*************************************************************************************************************************************************


	function GUTAUS () {
		//PROPERTIES
	    this.user_data = new USER_DATA();
		this.creditnotes = new CREDITNOTES();
		this.creditnote_chosen = new CREDITNOTE_CHOSEN();
		this.members = new MEMBERS();		
		this.member_chosen = new MEMBER_CHOSEN();

		//METHODS		
		this.pay= function() {

			var url;
			var receiver;
			if(gutaus.creditnote_chosen.pay_type_of_transfer=="member"){
				receiver=gutaus.member_chosen.member.id;
			}
			else if(gutaus.creditnote_chosen.pay_type_of_transfer=="known member"){
				receiver=gutaus.member_chosen.member.id;
			}
			else if (gutaus.creditnote_chosen.pay_type_of_transfer=="email") {
				receiver=gutaus.member_chosen.member.email;
			}
			else if (gutaus.creditnote_chosen.pay_type_of_transfer=="mobilenumber") {
				receiver=gutaus.member_chosen.member.mobile;
			}
			else {
				alert('Fehler: Bitte wählen Sie einen Empfänger für Ihrer Zahlung!');
				$.mobile.changePage("#pay");
				return;
			}
			
			
			url="./model/pay.php";

			$.ajax({
				type: "post",
				url: url,
				data: {creditnote : gutaus.creditnote_chosen.name,
					   receiver : receiver, // member_id, email or mobilenumber
					   amount : gutaus.creditnote_chosen.pay_amount,
					   purpose : gutaus.creditnote_chosen.pay_purpose,
					   typeOfTransfer : gutaus.creditnote_chosen.pay_type_of_transfer 
					  },                   
				async: true,
				beforeSend: function() {
					// This callback function will trigger before data is sent
					//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
					$.mobile.loading("show"); // This will show ajax spinner
				},
				complete: function() {
					// This callback function will trigger on data sent/received complete
					//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
					$.mobile.loading("hide"); // This will hide ajax spinner
				},
				success: function (str_pay) {					
					var pay = JSON.parse(str_pay);
					if (typeof pay.login === 'undefined') { // user is logged in
						if (typeof pay.errors != 'undefined') {
							alert(pay.errors);
							if (gutaus.creditnotes.chosen=='published' || gutaus.creditnotes.chosen=='received') {
								$.mobile.changePage("#members-list");
							}
							else if (gutaus.creditnotes.chosen=='email') {
								$.mobile.changePage("#pay-email");
							}
							else if (gutaus.creditnotes.chosen=='mobile') {
								$.mobile.changePage("#pay-mobile");
							}
							else{
								$.mobile.changePage("#pay");
							}

						}
						else {
							alert (pay.msg); // show infos of server
							gutaus.creditnote_chosen.account_balance=gutaus.creditnote_chosen.account_balance-gutaus.creditnote_chosen.pay_amount;
							gutaus.creditnote_chosen.account_balance=runde(gutaus.creditnote_chosen.account_balance,gutaus.creditnote_chosen.decimal_digits);
							if (gutaus.creditnotes.chosen=='published') {
								gutaus.creditnotes.published=false;
								gutaus.creditnotes.get();
							}
							else if (gutaus.creditnotes.chosen=='received') {
								gutaus.creditnotes.received=false;
								gutaus.creditnotes.get();
							}
							$(".info-line-header").html('Kontostand: '+gutaus.creditnote_chosen.account_balance+' '+gutaus.creditnote_chosen.name);
							gutaus.creditnote_chosen.total_turnover=gutaus.creditnote_chosen.total_turnover-gutaus.creditnote_chosen.pay_amount;
							gutaus.creditnote_chosen.transactions=false;
							$.mobile.changePage("#transactions-table");	
						}

					}
					else { // user isn't logged in
						alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
						$.mobile.changePage("#main-logtout");							
					}
				},
				error: function (request,error) {
					// This callback function will trigger on unsuccessful action                
					alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
				}
			}); 
		}

	}
	 
		//USER
		function USER_DATA () {
			//PROPERTIES
			this.name;
			this.id;
			this.avatar;
			
			// METHODS
			this.avatar_img_tag=function() {
				return "<img  style='width:63px' src='../avatare/"+this.avatar+"'/>";
			}

			this.login_check=function(username,password) {
				if(username.length > 0 && password.length > 0){
					// Send data to server through ajax call
						
						$.ajax({
							type: "post",
							url: "./model/login-check.php",
							data: {userName : username, passWord : password},                   
							async: true,
							beforeSend: function() {
								// This callback function will trigger before data is sent
								//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
								$.mobile.loading("show"); // This will hide ajax spinner
							},
							complete: function() {
								// This callback function will trigger on data sent/received complete
								//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
								$.mobile.loading("hide"); // This will hide ajax spinner
							},
							success: function (str_user_data) {
									var user_data = JSON.parse(str_user_data);
									
									if (user_data.id>0) {
										gutaus.user_data.name=user_data.name;
										gutaus.user_data.id=user_data.id;
										gutaus.user_data.avatar=user_data.avatar;
										$(".username").html(gutaus.user_data.name);
										var avatar_img_tag=gutaus.user_data.avatar_img_tag()
										$(".avatar").html(avatar_img_tag);
										$.mobile.changePage("#main");
									}
									else {
										alert ('LOGIN FEHLER: Benutzername oder Passwort falsch !!!');
										// login Gastuser without database conection
										/*
										alert('Dennoch loggen wir Sie mal ein, weils ein Testsystem ist! Sie haben aber keine Verbindung zur Datenbank!');
										gutaus.user_data.name=user_data.name;
										gutaus.user_data.id=user_data.id;
										gutaus.user_data.avatar=user_data.avatar;
										$(".username").html(gutaus.user_data.name);
										var avatar_img_tag=gutaus.user_data.avatar_img_tag()
										$(".avatar").html(avatar_img_tag);
										$.mobile.changePage("#main");
									    */
									}
							},
							error: function (request,error) {
								// This callback function will trigger on unsuccessful action                
								alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
							}
						}); 

				} 
				else {
					if(username.length == 0 & password.length == 0) {
						alert('Bitte geben Sie Ihren Benuzernamen und Ihr Passwort ein!');
						$("#username").focus();
					}
					else if (username.length == 0 & password.length > 0) {
						alert('Bitte geben Sie Ihren Benuzernamen!');
						$("#username").focus();
					}
					else {
						alert('Bitte geben Sie Ihr Passwort ein!');
						$("#password").focus();
					}
				}  			
			}
		
			this.registration_check=function(username,password,password_repeat,email,email_repeat,agb) {
				
				// Send data to server through ajax call

					$.ajax({
						type: "post",
						url: "./model/registration-check.php",
						data: {userName : username, 
							   passWord : password,
							   passWordRepeat : password_repeat, 
							   email : email,
							   emailRepeat : email_repeat,
							   agb : agb
							  },                   
						async: true,
						beforeSend: function() {
							// This callback function will trigger before data is sent
							//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
							$.mobile.loading("show"); // This will show ajax spinner
						},
						complete: function() {
							// This callback function will trigger on data sent/received complete
							//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
							$.mobile.loading("hide"); // This will hide ajax spinner
						},
						success: function (str_response_data) {
								var response_data = JSON.parse(str_response_data);

								if (response_data.error_count>0) {
									var Msg="";
									for (var i=1;i<=response_data.error_count;i++) {
										Msg+=i+". "+response_data.error_Msg[i];
										Msg+="\n";
									}
										alert (Msg);
								}
								else {
									alert (response_data.Msg); 
									$.mobile.changePage("#registration-confirm");
									
								}
						},
						error: function (request,error) {
							// This callback function will trigger on unsuccessful action                
							alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang? oder Fehler in ./model/registration-check.php');
						}
					}); 
			}
			
			this.registrate=function(code) {
					// Send data to server through ajax call
					$.ajax({
						type: "post",
						url: "./model/registrate.php",
						data: {Code : code
							  },                   
						async: true,
						beforeSend: function() {
							// This callback function will trigger before data is sent
							//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
							$.mobile.loading("show"); // This will show ajax spinner
						},
						complete: function() {
							// This callback function will trigger on data sent/received complete
							//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
							$.mobile.loading("hide"); // This will hide ajax spinner
						},
						success: function (str_response_data) {
								var response_data = JSON.parse(str_response_data);

								if (response_data.error_count>0) {
									var Msg="";
									for (var i=1;i<=response_data.error_count;i++) {
										Msg+=response_data.error_Msg[i];
										Msg+="\n";
									}
										alert (Msg);
								}
								else {
									alert (response_data.Msg); 
									$.mobile.changePage("#login");
									
								}
						},
						error: function (request,error) {
							// This callback function will trigger on unsuccessful action                
							alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang? oder Fehler in ./model/registrate.php');
						}
					}); 
				
			}
			
			this.validate_user_input=function(){
			
				var activePage = $.mobile.activePage.attr("id");
				if (activePage=="pay-email") {
					gutaus.member_chosen.member.email=$("#input-email-receiver").val().trim();
					//gutaus.member_chosen.member.email=gutaus.member_chosen.member.email.trim();
					if(gutaus.member_chosen.validateEmail(gutaus.member_chosen.member.email)) {
						gutaus.member_chosen.get_member_info_belonging_to_email(gutaus.member_chosen.member.email);
					}
					else {
						alert('Fehler: '+gutaus.member_chosen.member.name+' ist keine E-Mail-Adresse!');
						$("#input-email-receiver").focus();	
					}															
				} 
				else if (activePage=="pay-mobile") {
					gutaus.member_chosen.member.mobile=$("#input-mobile-receiver").val().trim();
					if(gutaus.member_chosen.validateMobile(gutaus.member_chosen.member.mobile)) {
						gutaus.member_chosen.get_member_info_belonging_to_mobile(gutaus.member_chosen.member.mobile);
					}
					else {
						alert('Fehler: '+gutaus.member_chosen.member.name+' ist keine Handynummer! Bitte geben Sie nur Zahlen ein und nicht mehr als 15 Ziffern!' );
						$("#input-mobile-receiver").focus();
						
					}			
				}
				else if (activePage=="members-list") {
					gutaus.members.get();
				}				
				
				
				
				else if (activePage=="pay-amount") {
					gutaus.creditnote_chosen.pay_amount=runde(Math.abs($("#input-pay-amount").val()),gutaus.creditnote_chosen.decimal_digits);
					$("#input-pay-amount").val(gutaus.creditnote_chosen.pay_amount);
					if (gutaus.creditnote_chosen.pay_amount<=gutaus.creditnote_chosen.get_max_buying_power()) {
						$.mobile.changePage("#pay-purpose");
					}
					else {
						alert(unescape("Fehler: Sie k%F6nnen maximal "
						+gutaus.creditnote_chosen.get_max_buying_power()
						+" "
						+gutaus.creditnote_chosen.name
						+" %FCberweisen!"));			
					}
				}
				else if (activePage=="pay-purpose") {
					gutaus.creditnote_chosen.pay_purpose=$("#input-pay-purpose").val();
					gutaus.pay();
				}
				else if (activePage=="creditnote-publish") {
					gutaus.creditnote_chosen.publish_creditnote();
				}
			}

			this.logout=function() {
						
				$.ajax({
					type: "post",
					url: "./model/logout.php",
					data: {},              
					async: true,
					beforeSend: function() {
						// This callback function will trigger before data is sent
						//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
						$.mobile.loading("show"); // This will hide ajax spinner
					},
					complete: function() {
						// This callback function will trigger on data sent/received complete
						//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
						$.mobile.loading("hide"); // This will hide ajax spinner
					},
					success: function (logout_success) {
							//resultObject.formSubmitionResult = result;
						    $.mobile.changePage("#main-logtout");
							if (logout_success) {
								alert ('Sie haben sich erfolgreich von GuTauS abgemeldet!!!');
							}
							else {
								alert (unescape('LOGOUT FEHLER: Ein ordnungsgem%E4%DFer LOGOUT aus der DB war nicht m%F6glich!!!'));
							}
							
					},
					error: function (request,error) {
						// This callback function will trigger on unsuccessful action                
						alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
					}
				}); 
				
			}
			
			this.removeCookie=function (cookieName){
				cookieValue = "";
				cookieLifetime = -1;
				var date = new Date();
				date.setTime(date.getTime()+(cookieLifetime*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
				document.cookie = cookieName+"="+JSON.stringify(cookieValue)+expires+"; path=/";
			}
	
		}
		
		//CREDITNOTES
		function CREDITNOTES () {
			//PROPERTIES
			this.chosen=false; // chosen creditnotes-list published,received or publish
			this.published=false; // published-creditnotes-list is populated from database
			this.received=false; // received-creditnotes-list is populated from database
			
			//METHODS
			
			this.are_published= function() {

				return true;
			}	
			
			this.are_received= function() {

				return true;
			}	
		 
			this.creditnote_is_published= function(creditnote_name_searched_for) {
				if (gutaus.creditnotes.published!=false) { //if published creditnots-list were read out from DB
					for (var i=0; i < gutaus.creditnotes.published.length; i++) {
						if (gutaus.creditnotes.published[i].name == creditnote_name_searched_for) {
							return true;
						}
					}
				}
				return false;
			}			
			
			this.get= function() {
			
				var url;
				
				if (gutaus.creditnotes.chosen=='received' & gutaus.creditnotes.received==false) { // received is searched and published list not loaded
					url="./model/creditnotes-received.php";
				}
				else if ((gutaus.creditnotes.chosen=='published' || gutaus.creditnotes.chosen=='publish') 
							& gutaus.creditnotes.published==false){ // published or publish is searched and published list not loaded
					url="./model/creditnotes-published.php";
				}	
				
				
				if (typeof(url)!='undefined') { // creditnote-list to get is not loaded so start loading from DB
					$.ajax({
						type: "post",
						url: url,
						data: {}, // Convert a form to a JSON string representation                   
						async: true,
						beforeSend: function() {
							// This callback function will trigger before data is sent
							//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
							$.mobile.loading("show"); // This will show ajax spinner
						},
						complete: function() {
							// This callback function will trigger on data sent/received complete
							//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
							$.mobile.loading("hide"); // This will hide ajax spinner
						},
						success: function (str_creditnotes) {					
							var creditnotes = JSON.parse(str_creditnotes);
							if (typeof creditnote.login === 'undefined') { // user is logged in
								if(creditnotes.length>0) { // creditnote(s) is(are) received/published
									if (gutaus.creditnotes.chosen=='received') { // received
										$("#btn-creditnotes-received").show();
										gutaus.creditnotes.received=creditnotes;
									}
									else{ // published or publish
										$("#btn-creditnotes-published").show();
										gutaus.creditnotes.published=creditnotes;
									}
									gutaus.creditnotes.show();				
								}
								else { // no creditnote is received/published
									if (gutaus.creditnotes.chosen=='received') {
										$("#btn-creditnotes-received").hide();
										alert('Sie haben noch keine Gutscheine erhalten! Lassen Sie sich von einen GuTauS-MitgliedGuscheinen bezahlen!');
									}
									else { 
										$("#btn-creditnotes-published").hide();
										alert('Sie haben noch keine Gutscheine herausgeben! ' 
										+'Geben Sie jetzt selbst einen von vier möglichen Gutscheinarten heraus '
										+'und bezahlen Sie damit Freunde, Bekannte oder auch selbst Ihre Handelspartner!');
										$.mobile.changePage("#creditnotes-publish");
									}
									return;
								}
							}
							else { // user isn't logged in
								alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
								$.mobile.changePage("#main-logtout");							
							}
						},
						error: function (request,error) {
							// This callback function will trigger on unsuccessful action                
							alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
						}
					}); 
				}

				else { // creditnote-list to get is loaded only show datas
					gutaus.creditnotes.show();
				}
			}

			
			this.show= function() {	
				var background_color_count_bubble;
				var color_count_bubble;
				var creditnote_name_with_replaced_blank_space; // because of a javascript error. javascript dosen' t pass pramenters to functions with a blank space

				var creditnotes;
				if (gutaus.creditnotes.chosen=='received') {
					creditnotes=gutaus.creditnotes.received;
				}
				else{ // published
					creditnotes=gutaus.creditnotes.published;
				}
				
				$("#list-creditnotes").empty(); // clear creditnotes-list
				$.each(creditnotes,function(i,creditnote){ // fill creditnotes-list
					if (creditnote.account_balance<0) { // account_balance is negative
						background_color_count_bubble="Crimson";
						color_count_bubble="white";
					}
					else { // account_balance is positive
						background_color_count_bubble="lightgreen";
						color_count_bubble="black";
					}
					creditnote_name_with_replaced_blank_space = creditnote.name.replace(' ','#*+~'); // because of a javascript error. javascript dosen' t pass pramenters to functions with a blank space
					creditnote.account_balance=runde(creditnote.account_balance, creditnote.decimal_digits);
					$("#list-creditnotes").append("<li><a href='#creditnote' "
													+"onclick=gutaus.creditnote_chosen.get_account_info('"
													+creditnote.id
													+"')>"
													+creditnote.name
													+"<span class='ui-li-count' "
													+"style=' text-align: center;" 
													+"background-color: "
													+background_color_count_bubble
													+"; color:"  
													+color_count_bubble
													+"'>"
													+creditnote.account_balance
													+"</span></a></li>");
				});
				
				if (gutaus.creditnotes.chosen!="publish") { // // received or published
					$.mobile.changePage("#creditnotes-list");
				}
				else { //publish
					$('#btn-creditnote-publish-minuto').show();
					$('#btn-creditnote-publish-euro').show();
					if (this.creditnote_is_published(gutaus.user_data.name+'-Minuto')) { // found User-Minuto
						$('#btn-creditnote-publish-minuto').hide();
					}
					if (this.creditnote_is_published(gutaus.user_data.name+'-Euro')) { // found User-Euro
						$('#btn-creditnote-publish-euro').hide();
					}
					$.mobile.changePage("#creditnotes-publish");
				}

			}
				
			
		}		
				
		function CREDITNOTE_CHOSEN () {
			//PROPERTIES
			this.name;
			this.id;
			this.account_balance;
			this.privat;
			this.publisher_id;
			this.credit_limit;
			this.acceptance_limit;
			this.total_turnover;
			this.decimal_digits;
			this.published; // true if creditnote_chosen is ab self published creditnote 
			this.transactions=false; // transactions-list is populated from database
			this.publish_type;
			this.pay_amount;
			this.pay_purpose;
			this.pay_type_of_transfer; //member,email or mobile
			
			//METHODS
			this.get_account_info=function (id) { 
			// gets account infos of DB from criditnote_chosen
				$.ajax({
					type: "post",
					url: "./model/creditnote-account-info.php",
					data: {creditnote_chosen_id : id},              
					async: true,
					beforeSend: function() {
						// This callback function will trigger before data is sent
						//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
						$.mobile.loading("show"); // This will hide ajax spinner
					},
					complete: function() {
						// This callback function will trigger on data sent/received complete
						//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
						$.mobile.loading("hide"); // This will hide ajax spinner
					},
					success: function (str_creditnote_out_of_DB) {					
						var creditnote_out_of_DB = JSON.parse(str_creditnote_out_of_DB);
						if (typeof creditnote_out_of_DB.login === 'undefined') {
							$(".gutaus-btn-back").attr("href", "#creditnotes-menu");
							gutaus.creditnote_chosen.transactions=		false; 
							gutaus.creditnote_chosen.name=				creditnote_out_of_DB.name;
							gutaus.creditnote_chosen.account_balance=	runde(parseFloat(creditnote_out_of_DB.account_balance),creditnote_out_of_DB.decimal_digits);
							gutaus.creditnote_chosen.decimal_digits=	creditnote_out_of_DB.decimal_digits;
							gutaus.creditnote_chosen.privat=			creditnote_out_of_DB.privat;
							gutaus.creditnote_chosen.publisher_id=		creditnote_out_of_DB.publisher_id;
							gutaus.creditnote_chosen.credit_limit=		parseFloat(creditnote_out_of_DB.credit_limit);
							gutaus.creditnote_chosen.acceptance_limit=	parseFloat(creditnote_out_of_DB.acceptance_limit);
							gutaus.creditnote_chosen.total_turnover=	parseFloat(creditnote_out_of_DB.total_turnover);
							$.mobile.changePage("#creditnote");
							gutaus.creditnote_chosen.show();
						}
						else {
							alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
							$.mobile.changePage("#main-logtout");
						}
					},
					error: function (request,error) {
						// This callback function will trigger on unsuccessful action                
						alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
					}
				}); 				
			}
			
			this.show= function() {
			
				// infos for infolines update
				$(".creditnote-chosen").html(this.name);
				$(".creditnote_account_balance").html(runde(this.account_balance,this.decimal_digits));
				this.credit_limit=runde(this.credit_limit, this.decimal_digits);
				$(".creditnote_credit_limit").html(this.credit_limit);
				this.acceptance_limit=runde(this.acceptance_limit, this.decimal_digits);
				$(".creditnote_acceptance_limit").html(this.acceptance_limit);
				this.total_turnover=runde(this.total_turnover, this.decimal_digits);
				$(".creditnote_total_turnover").html(this.total_turnover);
				
				// creditnote buttons show or hide
				$("#btn-value").hide();
				$("#btn-exchange-points").hide();
				$("#btn-credit_limit").hide();
				$("#btn-acceptance_limit").hide();
				$("#btn-publisher").hide();
				$("#btn-debtors").hide();
				$("#btn-creditors").hide();
				$("#btn-loading").hide();
				$("#btn-pay-out").hide();
				
				$("#btn-assessment").show();
				$("#btn-pay").show();

				if(gutaus.creditnote_chosen.account_balance*1<=gutaus.creditnote_chosen.credit_limit*1) { // hide pay-button if no creditnotes to pay
					$("#btn-pay").hide();
				}
				if (this.name=="Euro") {
					$("#btn-loading").show();
					$("#btn-pay-out").show();
					if (this.publisher_id==gutaus.user_data.id) { //user is publisher of chosen-creditnote
						$("#btn-debtors").show();
						$("#btn-credit_limit").show();
					}
				}
				else {
					$("#btn-value").show();
					$("#btn-exchange-points").show();
					if (this.publisher_id==gutaus.user_data.id) { //user is publisher of chosen-creditnote
					    $("#btn-debtors").show();
						if (this.name=="Horus") {
							$("#btn-creditors").show();
						}
						$("#btn-credit_limit").show();
					}
					else { //user is not publisher of chosen-creditnote
						$("#btn-creditors").show();
						if (this.name=="Horus") {
							$("#btn-debtors").show();
						}
						$("#btn-acceptance_limit").show();
						$("#btn-publisher").show();
					}					
					
					
				}
			}
			
			this.get_max_buying_power= function() {
				
				return 	this.account_balance*1-this.credit_limit*1;			
			}
			
			this.get_transactions=function (id) {
			
				var url;
				
				url="./model/creditnote-transactions.php"
				
				if (gutaus.creditnote_chosen.transactions==false) { // transactions-tabel to get is not loaded so start loading from DB
					$.ajax({
						type: "post",
						url: url,
						data: {}, // Convert a form to a JSON string representation                   
						async: true,
						beforeSend: function() {
							// This callback function will trigger before data is sent
							//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
							$.mobile.loading("show"); // This will show ajax spinner
						},
						complete: function() {
							// This callback function will trigger on data sent/received complete
							//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
							$.mobile.loading("hide"); // This will hide ajax spinner
						},
						success: function (str_transactions) {	
							console.log("str_transactions="+str_transactions);
							var transactions = JSON.parse(str_transactions);
							if (typeof transactions.login === 'undefined') { // user is logged in
								if(transactions.length>0) { // transaction(s) is(are) found
									gutaus.creditnote_chosen.transactions=transactions;
									gutaus.creditnote_chosen.show_transactions();				
								}
								else { // no transaction is found
									//$("#btn-transactions").hide();
									alert('Sie haben noch keine '+gutaus.creditnote_chosen.name+'-Umsätze! Lassen Sie sich von einen GuTauS-Mitglied mit diesen Guscheinen bezahlen!');
									return;
								}
							}
							else { // user isn't logged in
								alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
								$.mobile.changePage("#main-logtout");							
							}
						},
						error: function (request,error) {
							// This callback function will trigger on unsuccessful action                
							alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
						}
					}); 
				}

				else { // transactions-table is loaded show Page direct
					$.mobile.changePage("#transactions-table");
				}			
			
			}


			this.show_transactions= function() {	
				var transactions;
				transactions=gutaus.creditnote_chosen.transactions;
				$("#tabel-transactions").empty(); // clear transactions-table-body
				var number_nouveau;
				var an_von;

				$("#tabel-transactions").append("<thead>"
													+"<tr>"
													  +"<th>&Uuml;berweisung ...</th>"
													  +"<th id='tabel-transactions-creditnote' style='text-align: right'>...-Minuto</th>"
													  +"<th data-priority='1'>f&uuml;r</th>"
													  +"<th data-priority='2'>Datum</th>"
													  +"<th data-priority='3'>&uuml;berwiesen &uuml;ber</th>"
													+"</tr>"
												+"</thead>"
												+"<tbody >"
												);
				$.each(transactions,function(i,transaction){ // transactions-table-body
							
					if (transaction.amount<0){
						number_nouveau="negative-number";
						an_von="an ";
					}
					else{
						number_nouveau="positive-number";
						an_von="von ";
					}
				
					$("#tabel-transactions").append("<tr>"
														+"<td>"
														+an_von 
														+transaction.name
														+"</td>"
														+"<td class='"+number_nouveau+"' style='text-align: right'>"
														+runde(transaction.amount,gutaus.creditnote_chosen.decimal_digits)
														+"</td>"
														+"<td>"
														+transaction.purpose
														+"</td>"
														+"<td>"
														+transaction.date
														+"</td>"
														+"<td>"
														+transaction.type
														+"</td>"														
													+"</tr>");
				});
				$("#tabel-transactions").append("</tbody >");
				$("#tabel-transactions-creditnote").html(gutaus.creditnote_chosen.name); // set creditnote name in table column 2 
				$.mobile.changePage("#transactions-table");
				$("#tabel-transactions").trigger("create");
				$("#tabel-transactions").table("refresh");

				

			}
				
			this.publish_creditnote= function() {
	
				var url;
				
				url="./model/creditnote-publish.php";
				//alert("User limit:"+$("#user_credit_limit-input").val()
				//+"digits-input:"+$("#creditnote-digits-input").val()
				//+"member-limit:"+$("#member_credit_limit-input").val()
				//+"checkbox:"+$("#creditnote-privat-checkbox")[0].checked
				//);
				
				
				$.ajax({
					type: "post",
					url: url,
					data: {creditnote_type : this.publish_type,
						   creditnotename_input : $("#creditnotename-input").val(),
						   creditnote_value_textarea : $("#creditnote-value-textarea").val(),
						   user_credit_limit_input : $("#user_credit_limit-input").val(),
						   member_credit_limit_input : $("#member_credit_limit-input").val(),
						   creditnote_digits_input : $("#creditnote-digits-input").val(),
						   creditnote_privat_checkbox : $("#creditnote-privat-checkbox")[0].checked
						  },                   
					async: true,
					beforeSend: function() {
						// This callback function will trigger before data is sent
						//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
						$.mobile.loading("show"); // This will show ajax spinner
					},
					complete: function() {
						// This callback function will trigger on data sent/received complete
						//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
						$.mobile.loading("hide"); // This will hide ajax spinner
					},
					success: function (str_publish) {					
						var publish = JSON.parse(str_publish);
						if (typeof publish.login === 'undefined') { // user is logged in
							if (typeof publish.errors != 'undefined') {
								alert(publish.errors);	
							}
							else {
								alert (publish.msg); // show infos of server 
								gutaus.creditnotes.chosen='published'
								gutaus.creditnotes.published=false; // set published empty
								gutaus.creditnotes.get();
								//$.mobile.changePage("#creditnotes-list");	
							}
							
						}
						else { // user isn't logged in
							alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
							$.mobile.changePage("#main-logtout");							
						}
					},
					error: function (request,error) {
						// This callback function will trigger on unsuccessful action                
						alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang? Oder Fehler in ./model/creditnote-publish.php');
					}
				}); 

			}

		
		
		}

		
		//MEMBERS
		function MEMBERS () {
			//PROPERTIES
			this.chosen=false; //  chosen members or member can be: publisher, known, searched, email, mobile, member, debtors, creditors, suppliers, customers, unknown, all 
			this.known; // known-members-list is populated from database
			this.searched; // searched-members-list is populated from database
			
			//METHODS
			
			this.get= function() {
				var url;
				var data;
				var search_str;
				if (gutaus.members.chosen=='known' & typeof(gutaus.members.known)=='undefined') { // known-list is called but not loaded
					url="./model/members-known.php";
					search_str="";
				}
				else if (gutaus.members.chosen=='searched' & typeof(gutaus.members.members_searcheded)=='undefined') { // searched-list is called but not loaded
					url="./model/members-searched.php";
					search_str=$.trim($(".members-filter").val())
				}	
				
				if (typeof(url)!='undefined') { // Type of members list to search for in DB is set
					$.ajax({
						type: "post",
						url: url,
						data: {members_searched : search_str}, // Convert a form to a JSON string representation                   
						async: true,
						beforeSend: function() {
							// This callback function will trigger before data is sent
							//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
							$.mobile.loading("show"); // This will show ajax spinner
						},
						complete: function() {
							// This callback function will trigger on data sent/received complete
							//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
							$.mobile.loading("hide"); // This will hide ajax spinner
						},
						success: function (str_members) {					
							var members = JSON.parse(str_members);
							if (typeof member.login === 'undefined') { // user is logged in
								if(members.length>0) { // member(s) was (were) found in DB
									if (gutaus.members.chosen=='known') { // known
										gutaus.members.known=members;
									}
									else{ // searched
										gutaus.members.searched=members;
									}
									gutaus.members.show();
									return true; // member(s) was (were) found in DB				
								}
								else { // no member was found
									if (gutaus.members.chosen=='received') {
										$("#btn-members-received").hide();
										alert('Sie haben noch keine Gutscheine erhalten! Lassen Sie sich von einen GuTauS-MitgliedGuscheinen bezahlen!');
									}
									else { 
										$("#btn-members-published").hide();
										alert('Sie haben noch keine Gutscheine herausgeben! ' 
										+'Geben Sie jetzt selbst einen von vier möglichen Gutscheinarten heraus '
										+'und bezahlen Sie damit Freunde, Bekannte oder auch selbst Ihre Handelspartner!');
										$("#btn-members-publish").click ();
									}
									return false; // no member was found in DB
								}

								return false; // no member was found in DB
							}
							else { // user isn't logged in
								alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
								$.mobile.changePage("#main-logtout");
								return false; // no member was found in DB							
							}
						},
						error: function (request,error) {
							// This callback function will trigger on unsuccessful action                
							alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
							return false; // no member(s) was (were) found in DB
						}
					}); 
				}

				else { // Type of members list to search for in DB is not set so only show last members list if any was loaded before
					gutaus.members.show();
					return true; // member(s) was (were) found in DB before this search

				}			
				
			}

			this.show= function() {	

				var members;
				if (gutaus.members.chosen=='known') {
					members=gutaus.members.known;
				}
				else if (gutaus.members.chosen=='searched') { // searched
					members=gutaus.members.searched;
				}
				$("#list-members").empty(); // clear members-list
				$.each(members,function(i,member){ // fill members-list
					$("#list-members").append("<li><a href='#member' "
													+"onclick=gutaus.member_chosen.get_member_info_belonging_to_id('"
													+member.id
													+"')>"
													+member.name
													+"</a></li>");
				});
				
				$.mobile.changePage("#members-list");
				$("#list-members:visible").listview("refresh");
				
			}
				

		}
		
		function MEMBER_CHOSEN () {
		//PROPERTIES
			
			this.member;   // all data of chosen-member
			
		//METHODS
		
			// Validation methods
			this.validateEmail=function(sEmail) {
				var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
				if (filter.test(sEmail)) {
					return true;
				}
				else {
					return false;
				}
			}		
			
			this.validateMobile=function(sMobile) {
				var filter =  /\d+/;
				if (filter.test(sMobile) && sMobile.length<16) {
					return true;
				}
				else {
					return false;
				}
			}	
			
			// get methods  
			this.get_member_info_belonging_to_id= function(id) {
				var url;
				url="./model/member-info-of-id.php";				
				$.ajax({
					type: "post",
					url: url,
					data: {member_chosen_id : id},              
					async: true,
					beforeSend: function() {
						// This callback function will trigger before data is sent
						//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
						$.mobile.loading("show"); // This will hide ajax spinner
					},
					complete: function() {
						// This callback function will trigger on data sent/received complete
						//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
						$.mobile.loading("hide"); // This will hide ajax spinner
					},
					success: function (str_member_out_of_DB) {					
						var member_out_of_DB = JSON.parse(str_member_out_of_DB);
						if (typeof member_out_of_DB.login === 'undefined') {
							gutaus.member_chosen.member=member_out_of_DB;
							//gutaus.member_chosen.id=id;
							gutaus.member_chosen.show();
							$(".gutaus-btn-back").attr("href", "#pay");
							$.mobile.changePage("#pay-amount");

						}
						else {
							alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
							$.mobile.changePage("#main-logtout");
						}
					},
					error: function (request,error) {
						// This callback function will trigger on unsuccessful action                
						alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
					}
				}); 				
		
			}
			
			this.get_member_info_belonging_to_email= function(email) {
				var url;
				url="./model/member-info-of-email.php";				
				$.ajax({
					type: "post",
					url: url,
					data: {member_email : email},              
					async: true,
					beforeSend: function() {
						// This callback function will trigger before data is sent
						//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
						$.mobile.loading("show"); // This will hide ajax spinner
					},
					complete: function() {
						// This callback function will trigger on data sent/received complete
						//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
						$.mobile.loading("hide"); // This will hide ajax spinner
					},
					success: function (str_member_out_of_DB) {					
						var member_out_of_DB = JSON.parse(str_member_out_of_DB);
						if (typeof member_out_of_DB.login === 'undefined') {
							gutaus.member_chosen.member=member_out_of_DB;
							if (gutaus.member_chosen.member.name!="") { //member of email was found in DB
								if(gutaus.member_chosen.member.id!=gutaus.user_data.id) {
									alert('Das Mitglied '
											+gutaus.member_chosen.member.name
											+' ist bereits bei GuTauSder E-Mail-Adresse '
											+email
											+' registiert. Ihre Bezahlung erfogt also an '
											+gutaus.member_chosen.member.name
											+' !!!'  );
									gutaus.member_chosen.show();
									$.mobile.changePage("#pay-amount");
								}
								else { 
									alert('Die E-Mail-Adresse: '
											+email
											+' ist Ihre eigene E-Mail-Adresse! Es ist nicht erlaubt und nicht sinnvoll an sich selbst zu bezahlen!');
									return;
								}
							}
							else { //member of email wasn't found in DB
								alert(unescape('Es ist noch kein Mitglieder E-Mail-Adresse '
								+email
								+' bei GuTauS registriert, wenn Sie an diese E-Mail-Adresse bezahlen, wird ein '
								+gutaus.creditnote_chosen.name
								+'-Konto bei GuTaus f%FCr diese E-Mail-Adresse er%F6ffnet und eine Info E-Mail an '
								+email
								+' gesendet!'));
								gutaus.member_chosen.show();
								$.mobile.changePage("#pay-amount");
							}


						}
						else {
							alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
							$.mobile.changePage("#main-logtout");
						}
					},
					error: function (request,error) {
						// This callback function will trigger on unsuccessful action                
						alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
					}
				}); 				
		
			}
						
			this.get_member_info_belonging_to_mobile= function(mobile) {
				var url;
				url="./model/member-info-of-mobile.php";				
				$.ajax({
					type: "post",
					url: url,
					data: {member_mobile : mobile},              
					async: true,
					beforeSend: function() {
						// This callback function will trigger before data is sent
						//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
						$.mobile.loading("show"); // This will hide ajax spinner
					},
					complete: function() {
						// This callback function will trigger on data sent/received complete
						//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
						$.mobile.loading("hide"); // This will hide ajax spinner
					},
					success: function (str_member_out_of_DB) {					
						var member_out_of_DB = JSON.parse(str_member_out_of_DB);
						if (typeof member_out_of_DB.login === 'undefined') {
							gutaus.member_chosen.member=member_out_of_DB;
							if (gutaus.member_chosen.member.name!="") { //member of email was found in DB
								if(gutaus.member_chosen.member.id!=gutaus.user_data.id) {
									alert('Das Mitglied '
										+gutaus.member_chosen.member.name
										+' ist bereits bei GuTauSder Hadynummer '
										+mobile
										+' registiert. Ihre Bezahlung erfogt also an '
										+gutaus.member_chosen.member.name
										+' !!!'  );
									gutaus.member_chosen.show();
									$.mobile.changePage("#pay-amount");
								}
								else { 
									alert('Die Hadynummer: '
										+mobile
										+' ist Ihre eigene Hadynummer! Es ist nicht erlaubt und nicht sinnvoll an sich selbst zu bezahlen!');		
								}	
							}
							else { //member of email wasn't found in DB
								alert(unescape('Es ist noch kein Mitglieder Handynummer: '
									+mobile
									+' bei GuTauS registriert, wenn Sie an diese Hadynummer bezahlen, wird ein '
									+gutaus.creditnote_chosen.name
									+'-Konto bei GuTaus f%FCr diese Hadynummer er%F6ffnet und eine Info SMS an die Hadynummer:'
									+mobile
									+' gesendet!'));
									gutaus.member_chosen.show();
									$.mobile.changePage("#pay-amount");
							}
						}
						else {
							alert('Sie sind nicht eingeloggt! Bitte loggen Sie sich ein!');
							$.mobile.changePage("#main-logtout");
						}
					},
					error: function (request,error) {
						// This callback function will trigger on unsuccessful action                
						alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
					}
				}); 				
	
			}
			
			// schow methods
			this.show= function() {
				
				if (gutaus.members.chosen=='member' || gutaus.members.chosen=='publisher' ) {
					$(".receiver-chosen").html(this.member.name);
				}
				else {
					$(".receiver-chosen").html(this.member.email);
					$(".receiver-chosen").html(this.member.mobile);
				}					
			}

		}
						
	
//*************************************************************************************************************************************************
// GLOBAL VARABLES
//*************************************************************************************************************************************************
	var gutaus = new GUTAUS();
	
//*************************************************************************************************************************************************
// GLOBAL FUNCTIONS
//*************************************************************************************************************************************************	
	function runde(x, n) {
	  if (n < 0 || n > 14) return false;
	  var e = Math.pow(10, n);
	  var k = (Math.round(x * e) / e).toFixed(n).toString();
	  //if (k.indexOf('.') == -1) k += '.';
	  //k += e.toString().substring(1);
	  return k//.substring(0, k.indexOf('.') + n+1);
	}	
	function validateEmail(email) {
    	var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    	return re.test(email);
	}	

	
$(document).ready(function(){

	var navigator = [];
//*************************************************************************************************************************************************
// FUNCTIONS
//*************************************************************************************************************************************************	
	function update_navigator(page,level) {
		navigator[level] = page;
	    navigator=navigator.slice(0, level+1)
		//alert(navigator);
	};




//*************************************************************************************************************************************************
// EVENTS FOR ...
//*************************************************************************************************************************************************	 

//*************************************************************************************************************************************************
// LOGIN LOGOUT REGISTRATION
//*************************************************************************************************************************************************	 
	$(document).on("click", ".btn-logout", function() { 
		
		gutaus.user_data.logout();
		
		gutaus.user_data.removeCookie("PHPSESSID") // delete SESSION COOKIE
		//gutaus=null;
		gutaus.creditnotes.chosen=false;
		gutaus.creditnotes.published=false;
		gutaus.creditnotes.received=false;
		delete gutaus; 
		//$(".username").html("");
		//$.mobile.changePage("#main-logtout");
		
		var url_current=window.location.href
		url_current = url_current.split('#', 2);
		//alert("Homepath :"+url_current[0]+"/nlast Page: "+url_current[1]);
		var homepath=url_current[0];
		window.location.assign(homepath);

			
	});    
					
	$("#password,#username").keyup(function(e){
		if ((e.which==13)) { // Enter Key
			gutaus.user_data.login_check($("#username").val(),$("#password").val());
			return false
		}		
	}); 
		
	$(document).on("click", "#btn-login-check", function() { // catch the form"s submit event
         gutaus.user_data.login_check($("#username").val(),$("#password").val());		
	});   
	
	$(document).on("click", "#btn-reg-check", function() { // catch the form"s submit event
         gutaus.user_data.registration_check($("#reg-username").val(),
									$("#reg-password").val(),
									$("#reg-password-repeat").val(),
									$("#reg-email").val(),
									$("#reg-email-repeat").val(),
								    $("#reg-agb").is(":checked"));		
	});   

	$(document).on("click", "#btn-reg-confirm", function() { // catch the form"s submit event
         gutaus.user_data.registrate($("#reg-code").val());		
	});  	

	$(document).on("pageshow", "#login", function(){ 
			navigator = ["login"];
			//alert(navigator);
	});	

	$(document).on("pageshow", "#main", function(){ 
			navigator = ["main"];
		    gutaus.creditnotes.published=false; // empty creditnotes list
			gutaus.creditnotes.received=false; //  empty creditnotes list
			$(".gutaus-btn-next").html("Weiter");
			//alert(navigator);
	});	

//*************************************************************************************************************************************************
// SELECT MEMBERLISTS ******************************************************************************************************************************
//*************************************************************************************************************************************************	

		$(document).on("pagebeforeshow", "#memberlists-menu", function() { // chose a menbershiplist 
			$(".navigation-line").html("Mitgliederlisten");
			$(".massage-line-header").html("Bitte w&auml;hlen Sie aus!");
			$(".gutaus-btn-back").attr("href", "#main");
			$(".gutaus-btn-next").hide();
		});	
	
//*************************************************************************************************************************************************
// SELECT CREDITNOTE-MENU ******************************************************************************************************************************
//*************************************************************************************************************************************************	

		$(document).on("pagebeforeshow", "#creditnotes-menu", function() { // chose kind of creditnotes (published,received,Euro,Horos or publish one)
			if (gutaus.creditnotes.chosen==false){
				if (gutaus.creditnotes.are_received()) {
					$("btn-creditnotes-received").show();
				}
				else {
					$("btn-creditnotes-received").hide();
				}
				if (gutaus.creditnotes.are_published()) {
					$("btn-creditnotes-received").show();
				}
				else {
					$("btn-creditnotes-received").hide();
				}
			}
			$(".navigation-line").html("Meine Gutscheine");
			$(".massage-line-header").html("Bitte w&auml;hlen Sie aus!");
			$(".gutaus-btn-back").attr("href", "#main");
			$(".gutaus-btn-next").hide();
		});


//creditnote-published ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
			$("#btn-creditnotes-published").on("click", function(){	

				gutaus.creditnotes.chosen='published';
				gutaus.creditnotes.get(); // object creditnotes.published is created out of Database and is filld in creditnotes list
				//creditnotes.listview_fill(gutaus.creditnotes.published); // object creditnotes.published is filled in creditnotes list, this dosen't work because server dosen't allow syncron request	
			});
			
			
//creditnote-received +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$("#btn-creditnotes-received").on("click", function(){	
				gutaus.creditnotes.chosen='received';
				gutaus.creditnotes.get(); // object creditnotes.published is created out of Database and is filld in creditnotes list
				//gutaus.creditnotes.show();
				//creditnotes.listview_fill(gutaus.creditnotes.published); // object creditnotes.published is filled in creditnotes list, this dosen't work because server dosen't allow syncron request
			});

			
//+++creditnote-list ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
			
				$(document).on("pagebeforeshow", "#creditnotes-list", function() {
					$(".massage-line-header").html('Bitte w&auml;hlen Sie einen Gutschein aus!');
					$(".gutaus-btn-back").attr("href", "#creditnotes-menu");
					$(".gutaus-btn-next").hide();
					if (gutaus.creditnotes.chosen=='received') {
						$(".navigation-line").html("Erhaltene Gutscheine");
					}
					else {
						$(".navigation-line").html("Herausgegebene Gutscheine");
					}
				});
					
					$(document).on("pageshow", "#creditnotes-list", function() {
						//gutaus.creditnotes.show();
						$("#list-creditnotes:visible").listview("refresh");
						update_navigator("creditnotes",1);
					});				

			
//creditnote-horus ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++				
			$("#btn-creditnote-horus").on("click", function(){
				var horus_id='7';
				gutaus.creditnote_chosen.get_account_info(horus_id);
			});

			
//creditnote-euro +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
			$("#btn-creditnote-euro").on("click", function(){
				var euro_id='6';
				gutaus.creditnote_chosen.get_account_info(euro_id);
			});	

			
//+++creditnote +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$(document).on("pagebeforeshow", "#creditnote", function(){
						//$(".btn-creditnote").hide();
						$(".gutaus-btn-next").hide();			
					});

						$(document).on("pageshow", "#creditnote", function(){
							update_navigator("creditnote",3);
							//gutaus.creditnotes.show();
							// HEADER
							//$(".gutaus-btn-back").attr("href", "#creditnotes-menu");
							if (gutaus.creditnote_chosen.account_balance<0) {
								$(".info-line-header").css({"background-color": "Crimson", "color": "white"});
							}
							else {
								$(".info-line-header").css({"background-color": "lightgreen", "color": "black"});
							}
							$(".info-line-header").html('Kontostand: '+gutaus.creditnote_chosen.account_balance+' '+gutaus.creditnote_chosen.name);
							$(".navigation-line").html('Gutschein-Infos und -Aktionen');
							$(".massage-line-header").html('Bitte w&auml;hlen Sie f&uuml;r '+gutaus.creditnote_chosen.name+' etwas aus!');
							//CONTENT
							// FOOTER
							
							$(".info-line-1-footer").html('Max. &Uuml;berziehung: '+gutaus.creditnote_chosen.credit_limit+' '+gutaus.creditnote_chosen.name);
							$(".info-line-2-footer").html('Max. Akzeptanz  : '+gutaus.creditnote_chosen.acceptance_limit+' '+gutaus.creditnote_chosen.name);
							
							if (gutaus.creditnote_chosen.name=="Horus" || gutaus.creditnote_chosen.name=="Euro") {
								$(".gutaus-btn-back").attr("href", "#creditnotes-menu"); //  creditnote was chosen directly from creditnotes-menu (Horus or Euro)
							}
							else {
								$(".gutaus-btn-back").attr("href", "#creditnotes-list"); // creditnote was chosen from creditnotes-list
							}
							
						});	

						
//creditnotes-publish ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ +++++++++++++++++++++++++++++++++++++++++++++++++++						

			$("#btn-creditnotes-publish").on("click", function(){
				gutaus.creditnotes.chosen='publish';	
				gutaus.creditnotes.get(); // object creditnotes.published is created out of Database and is filld in creditnotes list and page creditnotes-publish is shown
			});
		
				$(document).on("pagebeforeshow", "#creditnotes-publish", function() {
					$(".massage-line-header").html('Bitte w&auml;hlen Sie eine Gutscheinart aus!');
					$(".gutaus-btn-back").attr("href", "#creditnotes-menu");
					$(".gutaus-btn-next").hide();

					
					$(".navigation-line").html('Gutscheine selbst herausgeben');
				});	
				
				
					$("#btn-creditnote-publish-euro").on("click", function(){
						$(".navigation-line").html('Eigenen Euro-Gutschein herausgeben');
						$("#creditnotename-input").val(gutaus.user_data.name+'-Euro');
						$("#creditnotename-input").attr('disabled','disabled');
						$("#creditnote-value-textarea").val('die moralisch ethisch ehrenhafte und rechtskräftige Zusage von '+gutaus.user_data.name+' einen Euro in bar oder per Überweisung unverzögert an den Überbringer des '+gutaus.user_data.name+'-Euro-Gutscheines auszuzahlen.');
						$("#creditnote-value-textarea").attr('disabled','disabled');
						gutaus.creditnote_chosen.publish_type="Euro";
					});				
				
					$("#btn-creditnote-publish-minuto").on("click", function(){
						$(".navigation-line").html('Eigenen Minuto-Gutschein herausgeben');
						$("#creditnotename-input").val(gutaus.user_data.name+'-Minuto');
						$("#creditnotename-input").attr('disabled','disabled');
						$("#creditnote-value-textarea").val('1 Minute der unverzögerten, qualifizierten und nützlichen Arbeit von '+gutaus.user_data.name+'.');
						$("#creditnote-value-textarea").attr('disabled','disabled');
						gutaus.creditnote_chosen.publish_type="Minuto";
					});	

					$("#btn-creditnote-publish-goods").on("click", function(){
						$(".navigation-line").html('Eigenen Waren-Gutschein herausgeben');
						$("#creditnotename-input").removeAttr('disabled');
						$("#creditnote-value-textarea").val('die moralisch ethisch ehrenhafte und rechtskräftige Zusage von '+gutaus.user_data.name+' einen Euro in bar oder per Überweisung unverzögert an den Überbringer des '+gutaus.user_data.name+'-Euro-Gutscheines auszuzahlen.');
						$("#creditnote-value-textarea").attr('disabled','disabled');
						gutaus.creditnote_chosen.publish_type="Goods";
					});						

					$("#btn-creditnote-publish-service").on("click", function(){
						$(".navigation-line").html('Eigenen Diensleistungs-Gutschein herausgeben');
						$("#creditnote-value-textarea").val('1 Minute der unverzögerten, qualifizierten und nützlichen Arbeit von '+gutaus.user_data.name+'.');
						$("#creditnotename-input").removeAttr('disabled');
						$("#creditnote-value-textarea").removeAttr('disabled');
						$("#creditnote-value-textarea").prop('disabled', true);
						gutaus.creditnote_chosen.publish_type="Service";
					});								

						$(document).on("pagebeforeshow", "#creditnote-publish", function() {
							$(".massage-line-header").html('Bitte f&uumlllen Sie die Felder aus!');
							$(".gutaus-btn-back").attr("href", "#creditnotes-publish");
							$(".gutaus-btn-next").show();
							$(".gutaus-btn-next").html("jetzt herausgeben");
						});						
				
//*************************************************************************************************************************************************
// SELECT RECEIVER ********************************************************************************************************************************
//*************************************************************************************************************************************************	


	$("#btn-pay").on("click", function(){
		$("#btn-creditnotes-pay_to_publisher").show();
		if (gutaus.creditnote_chosen.publisher_id==gutaus.user_data.id) {
			$("#btn-creditnotes-pay_to_publisher").hide();
		}
		$.mobile.changePage("#pay");
	});	
	

		$(document).on("pagebeforeshow", "#pay", function(){ 
			// HEADER
			$(".navigation-line").html('bezahle ');
			$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an ...');
			$(".gutaus-btn-next").hide();
			//CONTENT
			
			// FOOTER
			$(".gutaus-btn-back").attr("href", "#creditnote");
		});	
// Publischer +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
			$("#btn-creditnotes-pay_to_publisher").on("click", function(){
				gutaus.members.chosen='publisher';
				gutaus.creditnote_chosen.pay_type_of_transfer="member";
				gutaus.member_chosen.get_member_info_belonging_to_id(gutaus.creditnote_chosen.publisher_id);
			});	
									
// known Member ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++						
			$("#btn-creditnotes-pay_to_member-known").on("click", function(){
				gutaus.members.chosen='known';
				gutaus.creditnote_chosen.pay_type_of_transfer='known member';
				gutaus.members.get(); // object members.known is created out of Database and is filld in members list
			});	
// searched Member ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++						
			$("#btn-creditnotes-pay_to_member-searched").on("click", function(){
				gutaus.members.chosen='searched';
				gutaus.creditnote_chosen.pay_type_of_transfer='member';
				if (!typeof(gutaus.members.searched)=='undefined') { 
					gutaus.members.get();
				}
				else {
					$("#list-members").empty(); // clear members-list
					$.mobile.changePage("#members-list");
				}
				
			});	
			/*
				$(document).on("pagebeforeshow", "#memberlists-menu", function(){ 
					$(".navigation-line").html('bezahle');
					$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an ein Mitglied aus Liste ...');
					$(".gutaus-btn-back").attr("href", "#pay");
				});	
			*/	

// Memberlists ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++					
		
					$(document).on("pagebeforeshow", "#members-list", function(){ 
						if(gutaus.members.chosen=='known'){
							$(".navigation-line").html('bezahle an bekanntes Mitglied');
						}
						else{
							$(".navigation-line").html('bezahle an Mitglied');
						}	
					});	
					
				
				
				
// Email ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
					$("#btn-creditnotes-pay_to_email").on("click", function(){
						gutaus.members.chosen='email';
						gutaus.creditnote_chosen.pay_type_of_transfer='email';
						$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an Email: '+$("#input-email-receiver").val());
						$.mobile.changePage("#pay-email");
					});	

						$(document).on("pagebeforeshow", "#pay-email", function(){
							$(".navigation-line").html('bezahle an Email');
							$(".gutaus-btn-back").attr("href", "#pay");
							//$(".gutaus-btn-next").attr("href", "#pay-amount");
							//$(".gutaus-btn-next").attr("id","btn-email-receiver");
							//$(".gutaus-btn-next").button('refresh');
							$(".gutaus-btn-next").show();
							//$("#btn-email-receiver").show();

						});	
			
					
							$("#input-email-receiver").keydown(function(e){
								if ((e.which==13)) { // Enter Key
									//$(".gutaus-btn-next").trigger( "focus" );
									gutaus.user_data.validate_user_input();
									return false;
								}	
								$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an Email: '+$("#input-email-receiver").val());
							});
								
// Mobile +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++						
					$("#btn-creditnotes-pay_to_mobile").on("click", function(){
						gutaus.members.chosen='mobile';
						gutaus.creditnote_chosen.pay_type_of_transfer='mobilenumber';
						$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an Hadynummer: '+$("#input-mobile-receiver").val());
						$.mobile.changePage("#pay-mobile");
					});	
							
						$(document).on("pagebeforeshow", "#pay-mobile", function(){ 
							$(".navigation-line").html('bezahle an Handynummer');
							$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an Handynummer:'+$("#input-mobile-receiver").val());
							$(".gutaus-btn-back").attr("href", "#pay");
							$(".gutaus-btn-next").show();
						});						
						
							$("#input-mobile-receiver").keyup(function(e){
							
							
								if ((e.which==13)) { // Enter Key
									//$(".gutaus-btn-next").trigger( "focus" );
									gutaus.user_data.validate_user_input();	 
									return false;
								}		
								
								if ((e.which>=48 & e.which<=57) || (e.which>=37 & e.which<=40) || e.which==8) { // is Number or back or next or backspace
									$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an Hadynummer: '+$("#input-mobile-receiver").val());
								}
								else { // is no Number
									if (!(e.which==187 & $("#input-mobile-receiver").val().length==1)) { // first sign not + ==> delete sign
										$("#input-mobile-receiver").val($("#input-mobile-receiver").val().substr(0, $("#input-mobile-receiver").val().length-1));
									}
									else {
										$("#input-mobile-receiver").val("00");
										$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an Hadynummer: '+$("#input-mobile-receiver").val());
										alert ("+ wurde durch 00 ersetzt, da nuz Zahlen als Eingabe erlaubt sind!");
									}
								}
								
							});
								
//*************************************************************************************************************************************************
// SET PAY-AMOUNT AND PURPOSE *********************************************************************************************************************
//*************************************************************************************************************************************************
		$(document).on("pagebeforeshow", "#pay-amount", function(){ 
			$(".navigation-line").html('Betrag');
			$(".gutaus-btn-next").html("Weiter");
			$(".gutaus-btn-next").show();
				if (gutaus.members.chosen=="email") {
					$(".gutaus-btn-back").attr("href", "#pay-email");
				}
				else if (gutaus.members.chosen=="mobile") {
					$(".gutaus-btn-back").attr("href", "#pay-mobile");
				}
				else if (gutaus.members.chosen=="known") {
					$(".gutaus-btn-back").attr("href", "#members-list");
				}
				else if (gutaus.members.chosen=="searched") {
					$(".gutaus-btn-back").attr("href", "#members-list");
				}
				else {
					$(".gutaus-btn-back").attr("href", "#pay");
				}
				$(".massage-line-header").html('bezahle '
												+Math.abs($("#input-pay-amount").val())
												+' '
												+gutaus.creditnote_chosen.name
												+' an '
												+gutaus.member_chosen.member.name);
		});	
		
			$("#input-pay-amount").keyup( function(e){ 
				if (e.which==13) { // Enter Key
					gutaus.user_data.validate_user_input();
					return false;
				}
				else if (e.which==32) { //space key
					return false;
				}

		
				$(".massage-line-header").html('bezahle '
												+runde(Math.abs($("#input-pay-amount").val()),gutaus.creditnote_chosen.decimal_digits)
												+' '+gutaus.creditnote_chosen.name
												+' an '
												+gutaus.member_chosen.member.name);
			});	

			$("#input-pay-amount").change( function(){   
					$(".massage-line-header").html('bezahle '+Math.abs($("#input-pay-amount").val())+' '+gutaus.creditnote_chosen.name+' an '+gutaus.member_chosen.member.name);
			});	

		//	$("#input-pay-amount").focusout(function() {
		//			gutaus.user_data.validate_user_input();
		//	});	
			
		$(document).on("pagebeforeshow", "#pay-purpose", function(){ 
			$(".navigation-line").html('Verwendungszweck');
			$(".gutaus-btn-back").attr("href", "#pay-amount");
			$(".gutaus-btn-next").html("jetzt bezahlen");
			$(".gutaus-btn-next").show();
			$(".massage-line-header").html('bezahle '
										+gutaus.creditnote_chosen.pay_amount
										+' '
										+gutaus.creditnote_chosen.name
										+' an '+gutaus.member_chosen.member.name
										+' f&uuml;r '
										+$("#input-pay-purpose").val());
				
		});	
		
			$("#input-pay-purpose").keyup( function(e){   
				if ((e.which==13)) { // Enter Key
					gutaus.user_data.validate_user_input();
					return false;
				}	
				$(".massage-line-header").html('bezahle '
										+gutaus.creditnote_chosen.pay_amount
										+' '
										+gutaus.creditnote_chosen.name
										+' an '+gutaus.member_chosen.member.name
										+' f&uuml;r '
										+$("#input-pay-purpose").val());
			});
			
			$("#input-pay-purpose").change( function(){
				$(".massage-line-header").html('bezahle '
										+gutaus.creditnote_chosen.pay_amount
										+' '
										+gutaus.creditnote_chosen.name
										+' an '+gutaus.member_chosen.member.name
										+' f&uuml;r '
										+$("#input-pay-purpose").val());				
			});
			

				$("#btn-pay-purpose").on("click", function(){
					gutaus.creditnote_chosen.pay_purpose=$("#input-pay-purpose").val();
					
				});	


				
//*************************************************************************************************************************************************
// SELECT MEMBER **********************************************************************************************************************************
//*************************************************************************************************************************************************	
				
					$(document).on("pageshow", "#members-list", function() {
						//$("#list-members:visible").listview("refresh");
						$(".members-filter").blur();
						if(gutaus.members.chosen=='searched') {
							$(".gutaus-btn-next").html("suchen");
							$(".gutaus-btn-next").show();
						}
						else {
							$(".members-filter").val("");
							$(".gutaus-btn-next").hide();
						}
						$(".gutaus-btn-back").attr("href","#pay");
						$("#list-members:visible").listview("refresh");
					});			


						$(".members-filter").keyup(function(e){
							if (e.which==13 || $(".members-filter").val().length>2){ // Enter Key or input larger than two characters
								if (gutaus.members.chosen=='searched') { // what kind of Member are you
									gutaus.members.get(); // 

									if (gutaus.members.searched==0) { // if no members were found in database
										alert("Es gibt keien Mitglieder die mit den Buchstaben "+$(".members-filter").val()+" beginnen! Bitte suchen Sie mit ander Anfangsbuchstaben.");
										return false; // no members were found in database
									};

									//$(".members-filter").blur();
								}
								//$(".gutaus-btn-next").trigger( "focus" );
								gutaus.user_data.validate_user_input();
								return true; // members were found in database
							}	
							else if (e.which==32) { // Space Key
									return false;
							}
							$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.name+' an '+$(".members-filter").val());	
						});				

//**************************************************************************************************************************************************
// SHOW GREDITNOT-TRANSACTIONS**********************************************************************************************************************
//**************************************************************************************************************************************************
		$("#btn-transactions").on("click", function(){
			gutaus.creditnote_chosen.get_transactions();
		});


			$(document).on("pagebeforeshow", "#transactions-table", function(){ 
				// HEADER
				$(".navigation-line").html("Kontoums&auml;tze");
				$(".massage-line-header").html('Sie k&ouml;nnen Spalten ein und ausblenden!');
				$(".gutaus-btn-back").attr("href", "#creditnote");
				$(".gutaus-btn-next").hide();
			});	




						
//********************************** ***************************************************************************************************************
// SET VALIDATE USER INPUT OF E-MAIL, MOBILENUMBER, PAY-AMOUNT OR PURPOSE **************************************************************************
//**************************************************************************************************************************************************
			
	$(".gutaus-btn-next").on("click", function(){
			gutaus.user_data.validate_user_input();
	});	


//***********************************************************************************************************************************************
//***********************************************************************************************************************************************
//***********************************************************************************************************************************************							
			

	
//*************************************************************************************************************************************************
// PAY WITH SELECTED CREDITNOTE BY SELECTING A RECEIVER AND DETERMINE A PURPOSE 
//*************************************************************************************************************************************************  
						$(".receiver").on("click", function(){
							$(".chosen-receiver").html($(this).html());
						});
				
						

								
	
});



