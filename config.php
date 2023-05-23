<?php

$username = "root";
$password = "pw";
$hostname = "localhost";
$dbname = "booku";

$dbhandle = mysqli_connect($hostname, $username, $password, $dbname) or die(mysqli_error());

?>
