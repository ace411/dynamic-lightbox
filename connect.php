<?php 
$username = "";

$password = "";

$host = "localhost";

$db_name = "dynamic_lightbox";

$db = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8", $username, $password);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$db = null;
