//*************************************************************************************************************************************************
// GLOBAL CLASSES
//*************************************************************************************************************************************************


	function GUTAUS () {
	    this.user_data = new USER_DATA();
		this.creditnotes_chosen; // published or received or horus or euro or publish
		this.creditnotes = 	function () { // object creditnotes is created out of Database and method creditnotes_listview_fill is called
								var url;
								
								if (this.creditnotes_chosen=='received') {
									url="./model/creditnotes-received.php";
								}
								else { // published or publish 
									url="./model/creditnotes-published.php";
								}	
								
								$.ajax({
									type: "post",
									url: url,
									data: {}, // Convert a form to a JSON string representation                   
									async: false,
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
									success: function (str_creditnotes) {					
										var creditnotes_local = JSON.parse(str_creditnotes);
										if (typeof creditnotes_local.login === 'undefined') { // user is logged in
											$("#list-creditnotes").empty(); 
											if(creditnotes_local.length>0) {					
												return creditnotes_local;					
											}
											else {
												$("#btn-creditnotes-received").hide();
												alert('Sie haben noch keine Gutscheine erhalten! Lassen Sie sich von einen GuTauS-Mitglied mit Guscheinen bezahlen!');
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
								
							};
		this.creditnotes_listview_fill = 	function creditnotes_listview_fill () { // fills object creditnotes in listview 
												
												var background_color_count_bubble;
												var creditnote_name_with_replaced_blank_space; // because of a javascript error. javascript dosen' t pass pramenters to functions with a blank space
												$.each(this.creditnotes(),function(i,creditnote){
													if (creditnote.account_balance<0) {
														background_color_count_bubble="red";
													}
													else {
														background_color_count_bubble="green";
													}
													creditnote_name_with_replaced_blank_space = creditnote.name.replace(' ','#*+~'); // because of a javascript error. javascript dosen' t pass pramenters to functions with a blank space
													$("#list-creditnotes").append("<li><a href='#creditnote' "
																						+"onclick=set_creditnote_chosen('"
																						+creditnote_name_with_replaced_blank_space // because of a javascript error. javascript dosen' t pass pramenters to functions with a blank space
																						+"','"
																						+creditnote.id
																						+"','"
																						+creditnote.account_balance
																						+"','"
																						+creditnote.decimal_digits
																						+"','"
																						+creditnote.credit_limit
																						+"','"
																						+creditnote.acceptance_limit
																						+"','"
																						+creditnote.total_turnover
																						+"')>"
																						+creditnote.name
																						+"<span class='ui-li-count' style=' text-align: center; background-color: "
																						+background_color_count_bubble
																						+"; color:  white '>"
																						+creditnote.account_balance
																						+"</span></a></li>");
												});
												$.mobile.changePage("#creditnotes-list");
												
												
											} 
		this.creditnote_chosen = new CREDITNOTE_CHOSEN();
		this.receiver_chosen = new RECEIVER_CHOSEN ()
	}
	
		function USER_DATA () {
			this.name;
			this.id;
			this.avatar;
			this.avatar_img_tag=function() {
				return "<img  style='width:63px' src='../avatare/"+this.avatar+"'/>";
			}			
		}

		function CREDITNOTE_CHOSEN () {
			this.name;
			this.id;
			this.account_balance;
			this.credit_limit;
			this.acceptance_limit;
			this.total_turnover;
			this.published;
		}

		function RECEIVER_CHOSEN () {
			this.name;
			this.id;
			this.avatar;
	}

	
	//*************************************************************************************************************************************************
// GLOBAL VARABLES
//*************************************************************************************************************************************************
	var creditnotes;
	var gutaus = new GUTAUS();
	


//*************************************************************************************************************************************************
// GLOBAL FUNCTIONS
//*************************************************************************************************************************************************	
	function runde(x, n) {
	  if (n < 0 || n > 14) return false;
	  var e = Math.pow(10, n);
	  var k = (Math.round(x * e) / e).toString();
	  //if (k.indexOf('.') == -1) k += '.';
	  //k += e.toString().substring(1);
	  return k//.substring(0, k.indexOf('.') + n+1);
	}


	
	
	function get_creditnote_account_info (creditnote_id,creditnote_decimal_digits) {
		$.ajax({
			type: "post",
			url: "./model/creditnote-account-info.php",
			data: {creditnote_chosen_id : creditnote_id,creditnote_chosen_decimal_digits : creditnote_decimal_digits},              
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
			success: function (str_creditnote) {					
				var creditnote = JSON.parse(str_creditnote);
				if (typeof creditnote.login === 'undefined') {
					$(".gutaus-btn-back").attr("href", "#creditnotes-menu");
					set_creditnote_chosen(creditnote.name,creditnote.id,creditnote.account_balance,creditnote.decimal_digits,creditnote.credit_limit,creditnote.acceptance_limit,creditnote.total_turnover);
					$.mobile.changePage("#creditnote");
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
	

	
	function set_creditnote_chosen(name,id,account_balance,decimal_digits,credit_limit,acceptance_limit,total_turnover) {
		name = name.replace('#*+~',' '); // because of a javascript error. javascript dosen' t pass pramenters to functions with a blank space
		$(".creditnote-chosen").html(name);
		account_balance=runde(account_balance,decimal_digits);
		$(".creditnote_account_balance").html(account_balance);
		$(".creditnote_credit_limit").html(credit_limit);
		$(".creditnote_acceptance_limit").html(acceptance_limit);
		$(".creditnote_total_turnover").html(total_turnover);
		gutaus.creditnote_chosen.name=name;
		gutaus.creditnote_chosen.id=id;
		gutaus.creditnote_chosen.account_balance=account_balance;
		gutaus.creditnote_chosen.decimal_digits=decimal_digits;
		gutaus.creditnote_chosen.credit_limit=credit_limit;
		gutaus.creditnote_chosen.acceptance_limit=acceptance_limit;
		gutaus.creditnote_chosen.total_turnover=total_turnover;
		
    };	
	

	
	
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
// LOGIN LOGOUT
//*************************************************************************************************************************************************	 
	$(document).on("click", ".btn-logout", function() { // catch the form"s submit event
		
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
					if (logout_success) {
						//alert ('Sie haben sich erfolgreich von GuTauS abgemeldet!!!');
					}
					else {
						alert ('LOGOUT FEHLER: Ein ordnungsgem&auml;&szlig;er LOGOUT aus der DB war nicht m&ouml;glich!!!');
					}
			},
			error: function (request,error) {
				// This callback function will trigger on unsuccessful action                
				alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
			}
		}); 

		delete gutaus; 
		$(".username").html("");
		$.mobile.changePage("#main-logtout");		

		return false; // cancel original event to prevent form submitting
			
	});    

	$(document).on("click", "#btn-login-check", function() { // catch the form"s submit event

		if($("#username").val().length > 0 && $("#password").val().length > 0)
		{
			// Send data to server through ajax call
				
				$.ajax({
					type: "post",
					url: "./model/login-check.php",
					data: {userName : $("#username").val(), passWord : $("#password").val()},                   
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
								alert('Dennoch loggen wir Sie mal ein, weils ein Testsystem ist! Sie haben aber keine Verbindung zur Datenbank!');
								gutaus.user_data.name=user_data.name;
								gutaus.user_data.id=user_data.id;
								gutaus.user_data.avatar=user_data.avatar;
								$(".username").html(gutaus.user_data.name);
								var avatar_img_tag=gutaus.user_data.avatar_img_tag()
								$(".avatar").html(avatar_img_tag);
								$.mobile.changePage("#main");
							}
					},
					error: function (request,error) {
						// This callback function will trigger on unsuccessful action                
						alert('Netzwerkfehler: Auf den GuTauS-Server konnte nicht zugegriffen werden! Haben Sie Internezugang?');
					}
				}); 

		} 
		else {
			alert('Bitte geben Sie Ihren Benuzernamen und Ihr Passwort ein!');
		}           
			
		return false; // cancel original event to prevent form submitting
		
	});    


	$(document).on("pageshow", "#login", function(){ 
			navigator = ["login"];
			//alert(navigator);
	});	

	$(document).on("pageshow", "#main", function(){ 
			navigator = ["main"];
			//alert(navigator);
	});	


	
	
//*************************************************************************************************************************************************
// SELECT CREDITNOTE 
//*************************************************************************************************************************************************	

		$(document).on("pagebeforeshow", "#creditnotes-menu", function() {
			$(".navigation-line").html("Gutscheine");
			$(".massage-line-header").html("Bitte w&auml;hlen Sie aus!");
			$(".gutaus-btn-back").attr("href", "#main");
			
		});
		
			$("#btn-creditnotes-published").on("click", function(){	

				gutaus.creditnotes_chosen='published';
				gutaus.creditnotes_listview_fill(); // object creditnotes is created out of Database and is filld in creditnotes list
				//creditnotes_listview_fill(gutaus.creditnotes_published); // object creditnotes_published is filled in creditnotes list, this dosen't work because server dosen't allow syncron request
			});

			$("#btn-creditnotes-received").on("click", function(){	
				gutaus.creditnotes_chosen='received';
				gutaus.creditnotes(); // object creditnotes is created out of Database and is filld in creditnotes list
				//creditnotes_listview_fill(gutaus.creditnotes_published); // object creditnotes_published is filled in creditnotes list, this dosen't work because server dosen't allow syncron request
			});
								
				$(document).on("pagebeforeshow", "#creditnotes-list", function() {
					$(".massage-line-header").html('Bitte w&auml;hlen Sie einen Gutschein aus!');
					$(".gutaus-btn-back").attr("href", "#creditnotes-menu");
					if (gutaus.creditnotes_chosen=='received') {
						$(".navigation-line").html("Erhaltene Gutscheine");
					}
					else {
						$(".navigation-line").html("Herausgegebene Gutscheine");
					}
				});
				
				$(document).on("pageshow", "#creditnotes-list", function() {
					$("#list-creditnotes:visible").listview("refresh");
					update_navigator("creditnotes",1);
				});				

			$("#btn-creditnote-horus").on("click", function(){
				var horus_id='7';
				var horus_decimal_digits='0';
				gutaus.creditnotes_chosen='horus';
				get_creditnote_account_info (horus_id,horus_decimal_digits);
			});

			$("#btn-creditnote-euro").on("click", function(){
				var euro_id='6';
				var euro_decimal_digits='2';
				gutaus.creditnotes_chosen='euro';
				get_creditnote_account_info (euro_id,euro_decimal_digits);
			});	

			
					$(document).on("pagebeforeshow", "#creditnote", function(){ 
					    // HEADER
						$(".gutaus-btn-back").attr("href", "#creditnotes-menu");
						if (gutaus.creditnote_chosen.account_balance<0) {
							$(".info-line-header").css("background-color", "red");
						}
						else {
							$(".info-line-header").css("background-color", "green");
						}
						$(".info-line-header").html('Kontostand: '+gutaus.creditnote_chosen.account_balance+' '+gutaus.creditnote_chosen.name);
						$(".navigation-line").html('Gutschein-Infos und -Aktionen');
						$(".massage-line-header").html('Bitte w&auml;hlen Sie f&uuml;r '+gutaus.creditnote_chosen.name+' etwas aus!');
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


			$("#btn-creditnotes-publish").on("click", function(){
				gutaus.creditnotes_chosen='publish';
				$(".navigation-line").html('Gutscheine herausgeben');
				
				$.mobile.changePage("#creditnotes-publish");
			});						

					
					
					
														$("#btn-horus-creditnote").on("click", function(){  //noch nötig ???
																update_navigator("horus-creditnote",2);
														});	
																
														$("#btn-euro-creditnote").on("click", function(){  //noch nötig ???
																update_navigator("euro-creditnote",2);
														});
					
				
				

				
					$(document).on("pagebeforeshow", "#pay", function(){ 
						$(".navigation-line").html('bezahle');
						$(".massage-line-header").html('bezahle mit '+gutaus.creditnote_chosen.name+' an ...');
						$(".gutaus-btn-back").attr("href", "#creditnote");
					});	
					
						$(document).on("pagebeforeshow", "#pay-member", function(){ 
							$(".navigation-line").html('bezahle Mitglied');
							$(".massage-line-header").html('bezahle mit '+gutaus.creditnote_chosen.name+' an ein(en) ...');
						});	
						
						$(document).on("pagebeforeshow", "#pay-email", function(){ 
							$(".navigation-line").html('bezahle an E-Mail');
							$(".massage-line-header").html('bezahle mit '+gutaus.creditnote_chosen.name+' an E-Mail:');
						});	
						
						$(document).on("pagebeforeshow", "#pay-mobile", function(){ 
							$(".navigation-line").html('bezahle an Handynummer');
							$(".massage-line-header").html('bezahle mit '+gutaus.creditnote_chosen.name+' an Handynummer:');
						});	
				
							$(document).on("pagebeforeshow", "#pay-amount", function(){ 
								$(".navigation-line").html('Betrag');
								$(".massage-line-header").html('bezahle <span class="input-pay-amount"></span> '+gutaus.creditnote_chosen.name+' an '+gutaus.receiver_chosen.name);
							});	
							
								$(document).on("pagebeforeshow", "#pay-purpose", function(){ 
									$(".navigation-line").html('Verwendungszweck');
									$(".massage-line-header").html('bezahle '+gutaus.creditnote_chosen.pay_amount+' '+gutaus.creditnote_chosen.name+' an '+gutaus.receiver_chosen.name+' f&uuml;r <span class="input-pay-purpose">...</span>');
								});	
							
			
			$(document).on("pagebeforeshow", "#creditnotes-publish", function() {
				$(".massage-line-header").html('Bitte w&auml;hlen Sie eine Gutscheinart aus!');
				$(".gutaus-btn-back").attr("href", "#creditnotes-menu");
			});
			

			  						
					$(document).on("pagebeforeshow", "#creditnote", function(){
						$(".btn-creditnote").hide();
						if (navigator[2]=="creditnotes-published") {
							$("#btn-value").show();
							$("#btn-exchange-points").show();
							$("#btn-debtors").show();
						}
						else if (navigator[2]=="received-creditnotes") {
							$("#btn-value").show();
							$("#btn-max-acceptance").show();
							$("#btn-exchange-points").show();
							$("#btn-creditors").show();
							$("#btn-publisher").show();
						}
						else if (navigator[2]=="horus-creditnote") {
							$("#btn-value").show();
							$("#btn-max-acceptance").show();
							$("#btn-exchange-points").show();
							$("#btn-creditors").show();
							$("#btn-debtors").show();
							$("#btn-publisher").show();
						}
						else if(navigator[2]=="euro-creditnote") {
							$("#btn-loading").show();
							$("#btn-pay-out").show();
						}
					});
							
					$(document).on("pageshow", "#creditnote", function(){ 
							update_navigator("creditnote",3);
					});	
					

	
//*************************************************************************************************************************************************
// PAY WITH SELECTED CREDITNOTE BY SELECTING A RECEIVER AND DETERMINE A PURPOSE 
//*************************************************************************************************************************************************  
						$(".receiver").on("click", function(){
							$(".chosen-receiver").html($(this).html());
						});
						$("#input-email-receiver").keyup( function(){
							$(".chosen-receiver").html($("#input-email-receiver").val());
						});
						$("#input-mobile-receiver").keyup( function(){
							$(".chosen-receiver").html($("#input-mobile-receiver").val());
						});							
							$("#input-pay-amount").keyup( function(){   
								$(".input-pay-amount").html($("#input-pay-amount").val());
							});								
								$("#input-pay-purpose").keyup( function(){   
									$(".input-pay-purpose").html($("#input-pay-purpose").val());
								});
								
	
});



