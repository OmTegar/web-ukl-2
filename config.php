<?php

$username = "root";
$password = "pw";
$hostname = "3.235.168.23";
$dbname = "booku";

$dbhandle = mysqli_connect($hostname, $username, $password, $dbname) or die(mysqli_error());

?>
