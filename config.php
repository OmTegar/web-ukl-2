<?php 

	$username = "root";

	$password = "";

	$hostname = "localhost"; 
	
	$dbname = "booku";

	global $dbhandle;

	$dbhandle=mysqli_connect($hostname,$username,$password,$dbname) or die (mysqli_error());

?>