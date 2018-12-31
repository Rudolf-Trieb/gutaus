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

		<script src="js/gutaus-class-and-object.js"></script>
		<script src="js/user-event-mobile.js"></script>
		<link rel="stylesheet" href="./css/style-mobil.css">
	</head>

	<body>
		<?php include('logged-out-pages-only.php');?>

		<?php include('logged-in-pages-only.php');?>

		<?php include('logged-out-and-in-pages.php');?>
	</body>

</html>
