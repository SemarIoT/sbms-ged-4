<?php

$dbname = 'sbms';
$dbuser = 'root';  
$dbpass = ''; 
$dbhost = 'localhost'; 

$connect = @mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$connect){
	echo "Error: " . mysqli_connect_error();
	exit();
}

echo "Connection Success!<br><br>";

$temperature = $_GET["temperature"];
$humidity = $_GET["humidity"]; 


$query = "INSERT INTO dht_sensors (temperature, humidity) VALUES ('$temperature', '$humidity')";
$result = mysqli_query($connect,$query);

echo "Insertion Success!<br>";

?>