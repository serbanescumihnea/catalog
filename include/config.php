<?php
define('HOST', "127.0.0.1:3306");
define('USER', "root");
define('PASS', "");
define('DB',"credentials");
$dbi = mysqli_connect(HOST, USER, PASS, DB);
if($dbi === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
echo "Connected successfully";
?>