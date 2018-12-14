<?php 
    //SESSION
    //session_start(); 
?>


	<h2>Login</h2>
    
     <form id=Login accept-charset=ISO-8859-1 >
         <table>
            <tr>
                <td>Benutzername_:</td>
                <td><input type='text' name='Nickname' value='<?php echo $_SESSION['Nickname']; ?>'/></td>
            </tr>
            <tr>
                <td>Passwort:</td>
                <td><input type='password' name='Passwort' /></td>
            </tr>
                <td>eingeloggt bleiben :</td>
                <td><input type='checkbox' name='Autologin' value='Autologin' checked></td>
            <tr>
                
				<td><input id='einloggen' type='submit' name='submit' value='einloggen'></td>
                <td>
                    <a class=registrierung  href='#'><span>oder Registrierung</span></a><br>
                    <a id=passwort_vergessen href='#'><span>oder Passwort vergessen</span></a><br>
					<a id=benutzername_vergessen href='#'><span>oder Benutzername vergessen</span></a>
                </td>
            </tr>
        </table>
     </form>
	 
	
	
<script>


			$("#einloggen").click(function() {
			
				var Data=$("form").serialize();
				$.post("include_30_login_kontrolle.php",{formdata:Data},function(data){
				  $("#inhalt").html(data).fadeIn(4000);
				});
				
				return false;
		    });
			
			$(".registrierung").click(function() {
			
				$("#inhalt").load("include_31_registrierung_formular.php");
				
		    });
			
			$("#passwort_vergessen").click(function() {
			
				$("#inhalt").load("include_32_passwort_vergessen.php");
				
		    });
			
			$("#benutzername_vergessen").click(function() {
			
				$("#inhalt").load("include_33_benutzername_vergessen.php");
				
		    });

</script>
