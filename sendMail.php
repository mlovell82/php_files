<?php
include("ch19_include.php");
if (!$_POST) {
	//haven't seen the form, so display it 
	echo "<html>
	<head>
	<title>Send a Newsletter</title>
	</head>
	<body>
	<h1>Send a Newsletter</h1>
	<form method=\"post\" action=\"".$_SERVER["PHP_SELF"]."\">
	<p><strong>Subject:</strong><br/>
	<input type=\"text\" name=\"subject\" size=\"30\"></p>
	<p><strong>Mail Body:</strong><br/>
	<textarea name=\"message\" cols=\"50\" rows=\"10\"
		wrap=\"virtual\"></textarea>
	<p><input type=\"submit\" name=\"submit\" value=\"Send It\"></p>
	</form>
	</body>
	</html>";
	} else if ($_POST) {
	//want to send form, so check for required fields
	if (($_POST["subject"] == "") && ($_POST["message"] == "")) {
		header("Location: sendmymail.php");
		exit;
	}
	
	//connect to database
	doDB();
	
	if (mysqli_connect_errno()) {
		//if connection fails, stop script execution
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	} else {
	//otherwise, get emails from subscribers list
	$sql = "SELECT email FROM subscribers";
	$result = mysqli_query($mysqli, $sql)
			or die(mysqli_error($mysqli));
			
	//create a From: mailheader
	$mailheaders = "From: Your Mailing List
		<you@yourdomain.com>";
		//loop through results and send mail
		while ($row = mysqli_fetch_array($result)) {
			set_time_limit(0);
			$email = $row["email"];
			mail("$email", stripslashes($_POST["subject"]), 
				stripslashes($_POST["message"]), $mailheaders);
			echo "newsletter sent: ".$email."<br/>";
		}
		mysqli_free_result($result);
		mysqli_close($mysqli);
	}
}
?>
