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

if($_SERVER['REQUEST_METHOD'] == 'POST')	saveMap();
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$retDataType = explode(",",$_SERVER['HTTP_ACCEPT']);

	if(in_array('image/svg+xml', $retDataType))	returnMap();
	if(in_array('application/json', $retDataType))	returnJson();
	header('Content-Type: '.$httpContentType);
}	
mysqli_close($dbConn);


function returnJson(){
	$query = "SELECT * FROM `" . $GLOBALS['DBname'] . "`.`" . $GLOBALS['Tname'] . "`";
	$queryRes = execQuery($query);
	$data = array();
	for ($i=0; $i < $queryRes->num_rows; $i++) {
		$data[$i] = mysqli_fetch_assoc($queryRes);
	}
	$data = json_encode($data);

	echo $data;
	if (strlen($GLOBALS['httpContentType'])) {
		$GLOBALS['httpContentType'] .= ',';
	}
	$GLOBALS['httpContentType'] .= 'application/json';
}


function returnMap(){
	$roadsFile = fopen("roads.html", "r");
	$data = fread($roadsFile,filesize("roads.html"));
	fclose($roadsFile);

	echo $data;
	if (strlen($GLOBALS['httpContentType'])) {
		$GLOBALS['httpContentType'] .= ',';
	}
	$GLOBALS['httpContentType'] .= 'image/svg+xml';
}


function saveMap(){
	echo "save map";
	$data = file_get_contents('php://input');

	$roadsFile = fopen("roads.html", "w");
	fwrite($roadsFile, $data);
	fclose($roadsFile);

	preg_match_all('/(id="(\d)"|id="(\d\d)")/', $data,$matches,PREG_SET_ORDER);

	$query = "TRUNCATE `roads`.`roaddata`";//CLEAR DB
	execQuery($query);

	foreach ($matches as $key => $value) {//INSERT DATA
		$query = "INSERT INTO `" . $GLOBALS['DBname'] . "`.`" . $GLOBALS['Tname'] . "`(`id`,`traffic`) VALUES ('" . end($value) . "','0')";
		execQuery($query);
	}
}

function execQuery($query){
	$exec = mysqli_query($GLOBALS['dbConn'], $query);
	if ($exec) {
		return $exec;
	} else {
		exit("error");
	}
}