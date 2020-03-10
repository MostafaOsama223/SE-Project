<?php
//PHP Data Objects
//PDO
//C:\xampp\phpMyAdmin\config.inc.php
//Defense Switched Network
//127.0.0.1
//query
//''
//``
//ذ


$dsn = "mysql::host=127.0.0.1; dbname=seproject";
try{
	$dbConn = new PDO($dsn,"root","");
	echo "Connection is successful!"."<br>";
	$query = "CREATE TABLE IF NOT EXISTS `elGadwal` (
									`id` INT(3) AUTO_INCREMENT PRIMARY KEY, 
									`name` VARCHAR(10) NULL,
									`budget` INT NULL)";
	execQuery($query,$dbConn);
	echo "tmam Table"."<br>";
	
	$query = "INSERT INTO `elGadwal` VALUES (null,'majestic',100);
			  INSERT INTO `elGadwal` VALUES (null,'mariem',10);";
	execQuery($query,$dbConn);

	$query = "SELECT * FROM `elGadwal`";
	getQuery($query,$dbConn) ;

}catch(PDOException $e){
	echo $e->getMessage();
}

function execQuery($query,$dbConn){
	$data = $dbConn->prepare($query);
	$data->execute();
	return $data;
}

function getQuery($query,$dbConn){
	$data = $dbConn->query($query);
	echo "ID\tName\tBudget."."<br>";
	while($eachRow = $data->fetch()){
		echo $eachRow["id"] . "\t" . $eachRow["name"] . "\t" . $eachRow["budget"] . "<br>";
	}
	
}