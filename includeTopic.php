<?php

function doDB() {
	global $mysqli;
	
	//connect to server and select databases; you may need iterator_apply
	$mysqli = mysqli_connect("localhost", "mick", "the3pigs", "productd");
	
	//if connection fails, stop script execution
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
}
?>
