<?php
$dsn = 'mysql:host=localhost;dbname=ecommerce'; // Data Source Name
$user ='root';  // the user to connect
$pass = 4504; // pass of this user

$options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // to make it support  arabic
);  

try {
    $db = new PDO($dsn , $user , $pass , $options);  // start a new connection with PDO class
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // search about PDO attributes  
}
catch(PDOException $e){
		echo 'failed ' .$e->getMessage();
}