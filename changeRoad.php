<?php

$DBname = "roads";
$Tname = "roaddata";
$httpContentType = '';

$dbConn = mysqli_connect("localhost","root","");

$query = "CREATE DATABASE IF NOT EXISTS $DBname";
execQuery($query);					//CREATE DB

$query = "CREATE TABLE IF NOT EXISTS `$DBname`.`$Tname`(
			id SMALLINT PRIMARY KEY AUTO_INCREMENT,
			traffic TINYINT NOT NULL
		)";
execQuery($query);					//CREATE TABLE				

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(isset($_GET['id']) && isset($_GET['status'])){
		// $query = "Use roads";
		
		// $query = "UPDATE `roaddata` SET `traffic` = '2' WHERE `roaddata`.`id` = '2';";
		
		
		$status = $_GET['status'];
		$id = $_GET['id'];
		$query = "UPDATE $DBname.$Tname SET `traffic` = " . "'$status'" . " WHERE $Tname.`id` = $id";
		echo $query;
		execQuery($query);
	}
}	
mysqli_close($dbConn);


function execQuery($query){
	$exec = mysqli_query($GLOBALS['dbConn'], $query);
	if ($exec) {
		return $exec;
	} else {
		exit("error");
	}
}


?>