<?php
	$server="";
	$dbName="";
	$user=""; 
	$db="";

	$pdo = new PDO("mysql:host=".$server."; dbname=" . $dbName, $user, $db);
?>
