<?php 
    //SESSION
    session_start(); 
	include('include_0_db_conektion.php');
	include('funktionen.php');
?>

<?php
	$sql="INSERT INTO markers (lat,lng,type) VALUES (".$_POST['Latitude'].",".$_POST['Longitude'].",'Besucher')";
	echo $sql;
	$result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
?>

