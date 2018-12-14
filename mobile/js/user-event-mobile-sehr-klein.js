
$(document).ready(function(){
	alert('dokument is ready');
//*************************************************************************************************************************************************
// GLOBAL VARABLES
//*************************************************************************************************************************************************
	var navigator = [];

	
	
//*************************************************************************************************************************************************
// FUNKTIONS
//*************************************************************************************************************************************************	
	function update_navigator(page,level) {
		navigator[level] = page;
	    navigator=navigator.slice(0, level+1)
		//alert(navigator);
	};	



//*************************************************************************************************************************************************
// LOGIN LOGOUT
//*************************************************************************************************************************************************	
	$(document).on('pageshow', '#main-logtout', function(){ 
			navigator = ['main-logtout'];
			alert(navigator);
	});	

	$(document).on('pagebeforeshow', '#login', function(){ 
			$(document).on('click', '#login-check', function() { // catch the form's submit event
			
			if($('#username').val().length > 0 && $('#password').val().length > 0){
				 //alert('Benuzernamen und Passwort wurden an JS übergeben!  '+$('#username').val()+'    '+$('#password').val());
				 //$.mobile.changePage("#main");
				// Send data to server through ajax call
				// action is functionality we want to call and outputJSON is our data
					alert('Ihr Login wurde nicht ueberprueft, dennoch loggen wir Sie mal ein weils ein Testsystem ist! ;o)');
					
					$.ajax({
						type: 'post',
						url: './check-mobile-login.php',
						data: {action : 'login', formData : $('#check-user').serialize()}, // Convert a form to a JSON string representation                   
						async: true,
						beforeSend: function() {
							// This callback function will trigger before data is sent
							//$.mobile.showPageLoadingMsg(true); // This will show ajax spinner
							$.mobile.loading('show'); // This will hide ajax spinner
						},
						complete: function() {
							// This callback function will trigger on data sent/received complete
							//$.mobile.hidePageLoadingMsg(); // This will hide ajax spinner
							$.mobile.loading('hide'); // This will hide ajax spinner
						},
						success: function (result) {
								//resultObject.formSubmitionResult = result;
								$.mobile.changePage("#main");
						},
						error: function (request,error) {
							// This callback function will trigger on unsuccessful action                
							alert('Netzwerkfehler! Haben Sie Internezugang?');
						}
					}); 
					/*
					$.post("check-mobile-login.php",
						{
							action : 'login', 
							formData : $('#check-user').serialize()
						},
						function(data,status){
							alert("Data: " + data + "\nStatus: " + status);
							$.mobile.changePage("#main");
						}
					);
					alert('Login wurde überprüft!');
					*/
			} else {
				alert('Bitte geben Sie Ihren Benuzernamen und Ihr Passwort ein!');
			}           
				return false; // cancel original event to prevent form submitting
				
			});    
	});
		
	$(document).on('pageshow', '#login', function(){ 
			navigator = ['login'];
			//alert(navigator);
	});	

	$(document).on('pageshow', '#main', function(){ 
			navigator = ['main'];
			//alert(navigator);
	});	


	
	
//*************************************************************************************************************************************************
// SELECT CREDITNOTE 
//*************************************************************************************************************************************************	
		$(document).on('pageshow', '#creditnotes', function(){ 
				update_navigator('creditnotes',1);
		});	

			$(document).on('pageshow', '#published-creditnotes', function(){ 
					update_navigator('published-creditnotes',2);
			});	
			
			$(document).on('pageshow', '#received-creditnotes', function(){ 
					update_navigator('received-creditnotes',2);
			});	
			
				$(".creditnote").on("click", function(){
					$(".chosen-creditnote").html($(this).html());
				});
  						
			$("#btn-horus-creditnote").on("click", function(){ 
					update_navigator('horus-creditnote',2);
			});	
					
			$("#btn-euro-creditnote").on("click", function(){ 
					update_navigator('euro-creditnote',2);
			});	

					$(document).on('pagebeforeshow', '#creditnote', function(){
						$(".btn-creditnote").hide();
						if (navigator[2]=="published-creditnotes") {
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
							
					$(document).on('pageshow', '#creditnote', function(){ 
							update_navigator('creditnote',3);
					});	
				
			$(document).on('pageshow', '#publish-creditnote', function(){ 
					update_navigator('publish-creditnote',2);
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



