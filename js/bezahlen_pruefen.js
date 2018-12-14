$(document).ready(function(){

	$(".pruefen").click(function(){

		var Data=$("form").serialize();
		$.post("include_6_bezahlen.php",{formdata:Data},function(data){
			$("#inhalt").html(data).fadeIn(4000);
		});
	
	});
	
	$(".einheit-select").change(function() {
		var einheit=$(this).val();
		$.post("include_0_kontostand.php",{Einheit:einheit},function(data){
			$("#kontostanzanzeige").html(data);
		});
	});	
	
	
});
	