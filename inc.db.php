<?php
	$server="";
	$dbName="";
	$user=""; 
	$passwort="";

	$pdo = new PDO("mysql:host=".$server."; dbname=" . $dbName, $user, $passwort);
?>
