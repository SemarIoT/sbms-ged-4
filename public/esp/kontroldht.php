<?php

$dbname = 'sbms';
$dbuser = 'root';  
$dbpass = ''; 
$dbhost = 'localhost'; 

$connect = @mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

$sql = mysqli_query($connect, "SELECT * FROM kontrols");
$data = mysqli_fetch_array($sql);
$LED = $data['status'];
echo $LED;

?>