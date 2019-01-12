	
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
		//$.mobile.changePage("#page-logged-out-menu");
		
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

	$(document).on("pageshow", "#page-login", function(){ 
			navigator = ["login"];
			//alert(navigator);
	});	

	$(document).on("pageshow", "#page-logged-in-menu", function(){ 
			navigator = ["page-logged-in-menu"];
		    gutaus.creditnotes.published=false; // empty creditnotes list
			gutaus.creditnotes.received=false; //  empty creditnotes list
			$(".gutaus-btn-next").html("Weiter");
			//alert(navigator);
	});	

//*************************************************************************************************************************************************
// SELECT MEMBERLISTS ******************************************************************************************************************************
//*************************************************************************************************************************************************	

	$(document).on("pagebeforeshow", "#page-memberlists-menu", function () { // chose a menbershiplist on this page
		$(".gutaus-btn-back").attr("href", "#page-logged-in-menu");
		$(".gutaus-btn-next").hide();
		$(".navigation-line").html('Mitgliederlisten');
		$(".info-line-header").hide();
		$(".massage-line-header").html('Bitte wähle eine Liste aus');
	});
	
		//members-list-debtors ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		$(document).on("pagebeforeshow", "#page-members-list-debtors", function () { // chose a debtor on this page
			gutaus.members.chosen = 'debtors'
			gutaus.members.get(); 
			$('#members-filter-debtors').keyup(); //in order to get ABC dividers on first time page is showen
			$(".gutaus-btn-back").attr("href", "#page-memberlists-menu");
			$(".gutaus-btn-next").hide();
			$(".navigation-line").html('Schuldner-Liste');
			$(".info-line-header").css({
				color: "black",
				backgroundColor: "lightgreen"
			}).html('Mitglieder deren Gutscheine Du hast').show();
			$(".massage-line-header").html('Bitte wähle einen Schuldner oder Gutschein aus');	
		});		
		
	
//*************************************************************************************************************************************************
// SELECT CREDITNOTE-MENU ******************************************************************************************************************************
//*************************************************************************************************************************************************	

		$(document).on("pagebeforeshow", "#page-creditnotes-menu", function() { // chose kind of creditnotes (published,received,Euro,Horos or publish one)
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
			$(".info-line-header").hide();
			$(".massage-line-header").html("Bitte wählen Sie eine Gutschein-Kategorie oder einen Gutschein aus!");
			$(".gutaus-btn-back").attr("href", "#page-logged-in-menu");
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
			
				$(document).on("pagebeforeshow", "#page-creditnotes-list", function() {
					$(".info-line-header").hide();
					$(".massage-line-header").html('Bitte w&auml;hlen Sie einen Gutschein aus!');
					$(".gutaus-btn-back").attr("href", "#page-creditnotes-menu");
					$(".gutaus-btn-next").hide();
					if (gutaus.creditnotes.chosen=='received') {
						$(".navigation-line").html("Erhaltene Gutscheine");
					}
					else {
						$(".navigation-line").html("Herausgegebene Gutscheine");
					}
				});
					
					$(document).on("pageshow", "#page-creditnotes-list", function() {
						//gutaus.creditnotes.show();
						$("#list-creditnotes:visible").listview("refresh");
						update_navigator("creditnotes",1);
					});				

			
//creditnote-horus ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++				
			$("#btn-creditnote-horus").on("click", function(){
				var horus_id='7';
				gutaus.creditnotes.creditnote_chosen.get_account_info(horus_id);
			});

			
//creditnote-euro +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
			$("#btn-creditnote-euro").on("click", function(){
				var euro_id='6';
				gutaus.creditnotes.creditnote_chosen.get_account_info(euro_id);
			});	

			
//+++creditnote +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					$(document).on("pagebeforeshow", "#page-creditnote-menu", function(){
						//$(".btn-creditnote").hide();
						$(".gutaus-btn-next").hide();			
					});

						$(document).on("pageshow", "#page-creditnote-menu", function(){
							update_navigator("page-creditnote-menu",3);
							//gutaus.creditnotes.show();
							// HEADER
							//$(".gutaus-btn-back").attr("href", "#page-creditnotes-menu");
							if (gutaus.creditnotes.creditnote_chosen.account_balance<0) {
								$(".info-line-header").css({"background-color": "Crimson", "color": "white"});
							}
							else {
								$(".info-line-header").css({"background-color": "lightgreen", "color": "black"});
							}
							$(".info-line-header").show().html('Kontostand: '+gutaus.creditnotes.creditnote_chosen.account_balance+' '+gutaus.creditnotes.creditnote_chosen.name);
							$(".navigation-line").html(gutaus.creditnotes.creditnote_chosen.name+'-Infos und -Aktionen');

							$(".massage-line-header").html('Hier können Sie mit '+gutaus.creditnotes.creditnote_chosen.name+' bezahlen oder sich über '+gutaus.creditnotes.creditnote_chosen.name+' informieren!');
							//CONTENT
							// FOOTER
							
							$(".info-line-1-footer").html('Max. &Uuml;berziehung: '+gutaus.creditnotes.creditnote_chosen.credit_limit+' '+gutaus.creditnotes.creditnote_chosen.name);
							$(".info-line-2-footer").html('Max. Akzeptanz  : '+gutaus.creditnotes.creditnote_chosen.acceptance_limit+' '+gutaus.creditnotes.creditnote_chosen.name);
							
							if (gutaus.creditnotes.creditnote_chosen.name=="Horus" || gutaus.creditnotes.creditnote_chosen.name=="Euro") {
								$(".gutaus-btn-back").attr("href", "#page-creditnotes-menu"); //  creditnote was chosen directly from page-creditnotes-menu (Horus or Euro)
							}
							else {
								$(".gutaus-btn-back").attr("href", "#page-creditnotes-list"); // creditnote was chosen from page-creditnotes-list
							}
							
						});	

						
//page-creditnote-publish-menu ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ +++++++++++++++++++++++++++++++++++++++++++++++++++						

			$("#btn-creditnotes-publish").on("click", function(){
				gutaus.creditnotes.chosen='publish';	
				gutaus.creditnotes.get(); // object creditnotes.published is created out of Database and is filld in creditnotes list and page page-creditnote-publish-menu is shown
			});
		
				$(document).on("pagebeforeshow", "#page-creditnote-publish-menu", function() {
					$(".massage-line-header").html('Bitte w&auml;hlen Sie eine Gutscheinart aus!');
					$(".gutaus-btn-back").attr("href", "#page-creditnotes-menu");
					$(".gutaus-btn-next").hide();

					
					$(".navigation-line").html('Gutscheine selbst herausgeben');
				});	
				
				
					$("#btn-creditnote-publish-euro").on("click", function(){
						$(".navigation-line").html('Eigenen Euro-Gutschein herausgeben');
						$("#creditnotename-input").val(gutaus.user_data.name+'-Euro');
						$("#creditnotename-input").attr('disabled','disabled');
						$("#creditnote-value-textarea").val('die moralisch ethisch ehrenhafte und rechtskräftige Zusage von '+gutaus.user_data.name+' einen Euro in bar oder per Überweisung unverzögert an den Überbringer des '+gutaus.user_data.name+'-Euro-Gutscheines auszuzahlen.');
						$("#creditnote-value-textarea").attr('disabled','disabled');
						gutaus.creditnotes.creditnote_chosen.publish_type="Euro";
					});				
				
					$("#btn-creditnote-publish-minuto").on("click", function(){
						$(".navigation-line").html('Eigenen Minuto-Gutschein herausgeben');
						$("#creditnotename-input").val(gutaus.user_data.name+'-Minuto');
						$("#creditnotename-input").attr('disabled','disabled');
						$("#creditnote-value-textarea").val('1 Minute der unverzögerten, qualifizierten und nützlichen Arbeit von '+gutaus.user_data.name+'.');
						$("#creditnote-value-textarea").attr('disabled','disabled');
						gutaus.creditnotes.creditnote_chosen.publish_type="Minuto";
					});	

					$("#btn-creditnote-publish-goods").on("click", function(){
						$(".navigation-line").html('Eigenen Waren-Gutschein herausgeben');
						$("#creditnotename-input").removeAttr('disabled');
						$("#creditnote-value-textarea").val('die moralisch ethisch ehrenhafte und rechtskräftige Zusage von '+gutaus.user_data.name+' einen Euro in bar oder per Überweisung unverzögert an den Überbringer des '+gutaus.user_data.name+'-Euro-Gutscheines auszuzahlen.');
						$("#creditnote-value-textarea").attr('disabled','disabled');
						gutaus.creditnotes.creditnote_chosen.publish_type="Goods";
					});						

					$("#btn-creditnote-publish-service").on("click", function(){
						$(".navigation-line").html('Eigenen Diensleistungs-Gutschein herausgeben');
						$("#creditnote-value-textarea").val('1 Minute der unverzögerten, qualifizierten und nützlichen Arbeit von '+gutaus.user_data.name+'.');
						$("#creditnotename-input").removeAttr('disabled');
						$("#creditnote-value-textarea").removeAttr('disabled');
						$("#creditnote-value-textarea").prop('disabled', true);
						gutaus.creditnotes.creditnote_chosen.publish_type="Service";
					});								

						$(document).on("pagebeforeshow", "#page-creditnote-publish", function() {
							$(".massage-line-header").html('Bitte f&uumlllen Sie die Felder aus!');
							$(".gutaus-btn-back").attr("href", "#page-creditnote-publish-menu");
							$(".gutaus-btn-next").show();
							$(".gutaus-btn-next").html("jetzt herausgeben");
						});						
				
//*************************************************************************************************************************************************
// SELECT RECEIVER ********************************************************************************************************************************
//*************************************************************************************************************************************************	


	$("#btn-pay").on("click", function(){
		$("#btn-creditnotes-pay_to_publisher").show();
		if (gutaus.creditnotes.creditnote_chosen.publisher_id==gutaus.user_data.id) {
			$("#btn-creditnotes-pay_to_publisher").hide();
		}
		$.mobile.changePage("#page-pay-to-menu");
	});	
	

		$(document).on("pagebeforeshow", "#page-pay-to-menu", function(){ 
			// HEADER
			$(".navigation-line").html('bezahle ');
			$(".massage-line-header").html('bezahle '+gutaus.creditnotes.creditnote_chosen.name+' an ...');
			$(".gutaus-btn-next").hide();
			//CONTENT
			
			// FOOTER
			$(".gutaus-btn-back").attr("href", "#page-creditnote-menu");
		});	
// Publischer +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
			$("#btn-creditnotes-pay_to_publisher").on("click", function(){
				gutaus.members.chosen='publisher';
				gutaus.creditnotes.creditnote_chosen.pay_type_of_transfer="member";
				gutaus.members.member_chosen.get_member_info_belonging_to_id(gutaus.creditnotes.creditnote_chosen.publisher_id,"page-members-list-pay-to","page-pay-amount");
			});	
									
// known Member ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++						
			$("#btn-creditnotes-pay_to_member-known").on("click", function(){
				gutaus.members.chosen='known';
				gutaus.creditnotes.creditnote_chosen.pay_type_of_transfer='known member';
				gutaus.members.get(); // object members.known is created out of Database and is filld in members list
			});	
// searched Member ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++						
			$("#btn-creditnotes-pay_to_member-searched").on("click", function(){
				gutaus.members.chosen='searched';
				gutaus.creditnotes.creditnote_chosen.pay_type_of_transfer='member';
				if (!typeof(gutaus.members.searched)=='undefined') { 
					gutaus.members.get();
				}
				else {
					$("#list-members-pay-to").empty(); // clear members-list
					$.mobile.changePage("#page-members-list-pay-to");
				}
				
			});	
			

// Memberlists ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++					
		
					$(document).on("pagebeforeshow", "#page-members-list-pay-to", function(){ 
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
						gutaus.creditnotes.creditnote_chosen.pay_type_of_transfer='email';
						$(".massage-line-header").html('bezahle '+gutaus.creditnotes.creditnote_chosen.name+' an Email: '+$("#input-email-receiver").val());
						$.mobile.changePage("#page-pay-email");
					});	

						$(document).on("pagebeforeshow", "#page-pay-email", function(){
							$(".navigation-line").html('bezahle an Email');
							$(".gutaus-btn-back").attr("href", "#page-pay-to-menu");
							//$(".gutaus-btn-next").attr("href", "#page-pay-amount");
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
								$(".massage-line-header").html('bezahle '+gutaus.creditnotes.creditnote_chosen.name+' an Email: '+$("#input-email-receiver").val());
							});
								
// Mobile +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++						
					$("#btn-creditnotes-pay_to_mobile").on("click", function(){
						gutaus.members.chosen='mobile';
						gutaus.creditnotes.creditnote_chosen.pay_type_of_transfer='mobilenumber';
						$(".massage-line-header").html('bezahle '+gutaus.creditnotes.creditnote_chosen.name+' an Hadynummer: '+$("#input-pay-mobile").val());
						$.mobile.changePage("#page-pay-mobile");
					});	
							
						$(document).on("pagebeforeshow", "#page-pay-mobile", function(){ 
							$(".navigation-line").html('bezahle an Handynummer');
							$(".massage-line-header").html('bezahle '+gutaus.creditnotes.creditnote_chosen.name+' an Handynummer:'+$("#input-pay-mobile").val());
							$(".gutaus-btn-back").attr("href", "#page-pay-to-menu");
							$(".gutaus-btn-next").show();
						});						
						
							$("#input-pay-mobile").keyup(function(e){
							
							
								if ((e.which==13)) { // Enter Key
									//$(".gutaus-btn-next").trigger( "focus" );
									gutaus.user_data.validate_user_input();	 
									return false;
								}		
								
								if ((e.which>=48 & e.which<=57) || (e.which>=37 & e.which<=40) || e.which==8) { // is Number or back or next or backspace
									$(".massage-line-header").html('bezahle '+gutaus.creditnotes.creditnote_chosen.name+' an Hadynummer: '+$("#input-pay-mobile").val());
								}
								else { // is no Number
									if (!(e.which==187 & $("#input-pay-mobile").val().length==1)) { // first sign not + ==> delete sign
										$("#input-pay-mobile").val($("#input-pay-mobile").val().substr(0, $("#input-pay-mobile").val().length-1));
									}
									else {
										$("#input-pay-mobile").val("00");
										$(".massage-line-header").html('bezahle '+gutaus.creditnotes.creditnote_chosen.name+' an Hadynummer: '+$("#input-pay-mobile").val());
										alert ("+ wurde durch 00 ersetzt, da nuz Zahlen als Eingabe erlaubt sind!");
									}
								}
								
							});
								
//*************************************************************************************************************************************************
// SET PAY-AMOUNT AND PURPOSE *********************************************************************************************************************
//*************************************************************************************************************************************************
		$(document).on("pagebeforeshow", "#page-pay-amount", function(){ 
			$(".navigation-line").html('Betrag');
			$(".gutaus-btn-next").html("Weiter");
			$(".gutaus-btn-next").show();
				if (gutaus.members.chosen=="email") {
					$(".gutaus-btn-back").attr("href", "#page-pay-email");
				}
				else if (gutaus.members.chosen=="mobile") {
					$(".gutaus-btn-back").attr("href", "#page-pay-mobile");
				}
				else if (gutaus.members.chosen=="known") {
					$(".gutaus-btn-back").attr("href", "#page-members-list-pay-to");
				}
				else if (gutaus.members.chosen=="searched") {
					$(".gutaus-btn-back").attr("href", "#page-members-list-pay-to");
				}
				else {
					$(".gutaus-btn-back").attr("href", "#page-pay-to-menu");
				}
				$(".massage-line-header").html('bezahle '
												+Math.abs($("#input-pay-amount").val())
												+' '
												+gutaus.creditnotes.creditnote_chosen.name
												+' an '
												+gutaus.members.member_chosen.member.name);
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
												+runde(Math.abs($("#input-pay-amount").val()),gutaus.creditnotes.creditnote_chosen.decimal_digits)
												+' '+gutaus.creditnotes.creditnote_chosen.name
												+' an '
												+gutaus.members.member_chosen.member.name);
			});	

			$("#input-pay-amount").change( function(){   
					$(".massage-line-header").html('bezahle '+Math.abs($("#input-pay-amount").val())+' '+gutaus.creditnotes.creditnote_chosen.name+' an '+gutaus.members.member_chosen.member.name);
			});	

		//	$("#input-pay-amount").focusout(function() {
		//			gutaus.user_data.validate_user_input();
		//	});	
			
		$(document).on("pagebeforeshow", "#page-pay-purpose", function(){ 
			$(".navigation-line").html('Verwendungszweck');
			$(".gutaus-btn-back").attr("href", "#page-pay-amount");
			$(".gutaus-btn-next").html("jetzt bezahlen");
			$(".gutaus-btn-next").show();
			$(".massage-line-header").html('bezahle '
										+gutaus.creditnotes.creditnote_chosen.pay_amount
										+' '
										+gutaus.creditnotes.creditnote_chosen.name
										+' an '+gutaus.members.member_chosen.member.name
										+' f&uuml;r '
										+$("#input-pay-purpose").val());
				
		});	
		
			$("#input-pay-purpose").keyup( function(e){   
				if ((e.which==13)) { // Enter Key
					gutaus.user_data.validate_user_input();
					return false;
				}	
				$(".massage-line-header").html('bezahle '
										+gutaus.creditnotes.creditnote_chosen.pay_amount
										+' '
										+gutaus.creditnotes.creditnote_chosen.name
										+' an '+gutaus.members.member_chosen.member.name
										+' f&uuml;r '
										+$("#input-pay-purpose").val());
			});
			
			$("#input-pay-purpose").change( function(){
				$(".massage-line-header").html('bezahle '
										+gutaus.creditnotes.creditnote_chosen.pay_amount
										+' '
										+gutaus.creditnotes.creditnote_chosen.name
										+' an '+gutaus.members.member_chosen.member.name
										+' f&uuml;r '
										+$("#input-pay-purpose").val());				
			});
			

				$("#btn-pay-purpose").on("click", function(){
					gutaus.creditnotes.creditnote_chosen.pay_purpose=$("#input-pay-purpose").val();
					
				});	


				
//*************************************************************************************************************************************************
// SELECT MEMBER **********************************************************************************************************************************
//*************************************************************************************************************************************************	
				
					$(document).on("pageshow", "#page-members-list-pay-to", function() {
						//$("#list-members-pay-to:visible").listview("refresh");
						$("#members-filter-pay-to").blur();
						if(gutaus.members.chosen=='searched') {
							$(".gutaus-btn-next").html("suchen");
							$(".gutaus-btn-next").show();
						}
						else {
							$("#members-filter-pay-to").val("");
							$(".gutaus-btn-next").hide();
						}
						$(".gutaus-btn-back").attr("href","#page-pay-to-menu");
						$("#list-members-pay-to:visible").listview("refresh");
					});			


						$("#members-filter-pay-to").keyup(function(e){
							if (e.which==13 || $("#members-filter-pay-to").val().length>2){ // Enter Key or input larger than two characters
								if (gutaus.members.chosen=='searched') { // what kind of Member are you
									gutaus.members.get(); // 

									if (gutaus.members.searched==0) { // if no members were found in database
										alert("Es gibt keien Mitglieder die mit den Buchstaben "+$("#members-filter-pay-to").val()+" beginnen! Bitte suchen Sie mit ander Anfangsbuchstaben.");
										return false; // no members were found in database
									};

									//$("#members-filter-pay-to").blur();
								}
								//$(".gutaus-btn-next").trigger( "focus" );
								gutaus.user_data.validate_user_input();
								return true; // members were found in database
							}	
							else if (e.which==32) { // Space Key
									return false;
							}
							$(".massage-line-header").html('bezahle '+gutaus.creditnotes.creditnote_chosen.name+' an '+$("#members-filter-pay-to").val());	
						});				

//**************************************************************************************************************************************************
// SHOW GREDITNOT-TRANSACTIONS**********************************************************************************************************************
//**************************************************************************************************************************************************
		$("#btn-transactions").on("click", function(){
			gutaus.creditnotes.creditnote_chosen.get_transactions();
		});


			$(document).on("pagebeforeshow", "#page-transactions-table", function(){ 
				// HEADER
				$(".navigation-line").html("Kontoums&auml;tze meiner "+gutaus.creditnotes.creditnote_chosen.name);
				$(".massage-line-header").html('Sie k&ouml;nnen Spalten ein und ausblenden!');
				$(".gutaus-btn-back").attr("href", "#page-creditnote-menu");
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



