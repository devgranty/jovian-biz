<?php

$servername = "localhost";
$dbname = "jovianbiz_db";
$username = "root";
$password = "";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    //set the PDO error mode to exception
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";

}catch(PDOException $e){
    echo "Connection failed: ".$e->getMessage();
}

//config timezone setting
//GMT UTC Africa/Lagos
date_default_timezone_set("Africa/Lagos");
?>