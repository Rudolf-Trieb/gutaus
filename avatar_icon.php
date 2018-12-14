<?php 
    //SESSION
    session_start(); 
?>

<?php


	if ($_SESSION['Avatar']<>'') {
		echo "<img   style='height:77px' src='avatare/".$_SESSION['Avatar']."'/>"; 
	}
	else {
		echo "<img  style='height:77px' src='avatare/annonym.jpg/>";
	}

?>