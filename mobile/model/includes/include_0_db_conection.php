<?php
	//DB CONEKTION
    error_reporting(E_ALL ^ E_NOTICE); 
    $MYSQL_HOST = 'localhost'; 
    $MYSQL_USER = 'horus777'; 
    $MYSQL_PASS = 'wkkvwnkhsvms'; 
    $MYSQL_DATA = 'gutaus'; 

    $connid = @mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASS) OR die("Error: ".mysql_error());
    mysql_select_db($MYSQL_DATA) OR die("Error: ".mysql_error()); 
?>