//addressInclude.php

<?php
include("address_include.php");
if (!$_POST) {
	$display_block = "
	<form method=\"post\" action=\"".$_SERVER["PHP_SELF"]."\">
	<p><strong>First/Last Names:</strong><br/>
	<input type=\"text\" name=\"f_name\" size=\"30\" maxlength=\"75\">
	<input type=\"text\" name=\"l_name\" size=\"30\" maxlength=\"75\"></p>
	
	<p><strong>Address:</strong><br/>
	<input type=\"text\" name=\"address\" size=\"30\"></p>
	
	<p><strong>City/State/Zip:</strong><br/>
	<input type=\"text\" name=\"city\" size=\"30\" maxlength=\"50\">
	<input type=\"text\" name=\"state\" size=\"30\" maxlength=\"2\">
	<input type=\"text\" name=\"zipcode\" size=\"30\" maxlength=\"10\"></p>
	
	<p><strong>Address Type:</strong><br/>
	<input type=\"radio\" name=\"add_type\" value=\"home\" checked> home
	<input type=\"radio\" name=\"add_type\" value=\"work\"> work
	<input type=\"radio\" name=\"add_type\" value=\"other\"> other
	
	<p><strong>Telephone Number:</strong><br/>
	<input type=\"text\" name=\"tel_number\" size=\"30\" maxlength=\"25\">
	<input type=\"radio\" name=\"tel_type\" value=\"home\" checked> home
	<input type=\"radio\" name=\"tel_type\" value=\"work\"> work
	<input type=\"radio\" name=\"tel_type\" value=\"other\"> other
	
	<p><strong>Fax Number:</strong><br/>
	<input type=\"text\" name=\"fax_number\" size=\"30\" maxlength=\"25\">
	<input type=\"radio\" name=\"fax_type\" value=\"home\" checked> home
	<input type=\"radio\" name=\"fax_type\" value=\"work\"> work
	<input type=\"radio\" name=\"fax_type\" value=\"other\"> other
	
	<p><strong>Email Address:</strong><br/>
	<input type=\"text\" name=\"email\" size=\"30\" maxlength=\"25\">
	<input type=\"radio\" name=\"email_type\" value=\"home\" checked> home
	<input type=\"radio\" name=\"email_type\" value=\"work\"> work
	<input type=\"radio\" name=\"email_type\" value=\"other\"> other
	
	<p><strong>Personal Note:</strong><br/>
	<textarea name=\"note\" cols=\"35\" rows=\"3\"
	wrap=\"virtual\"></textarea></p>
	
	<p><input type=\"submit\" name\"submit\" value=\"Add Entry\"></p>
	</form>";

} else if ($_POST) { 
		//time to add to tables, so check for required fields
	if (($_POST["f_name"] == "") && ($_POST["l_name"] == "")) {
		header("Location: addentry.php");
		exit;
	}
	
	//connect to database
	doDB();
	
	//add to master_name tables
	$add_master_sql = "INSERT INTO master_name (date_added, date_modified, 
					f_name, l_name) VALUES (now(), now(),
					'".$_POST["f_name"]."', '".$_POST["l_name"]."')";
	$add_master_res = mysqli_query($mysqli, $add_master_sql)
					or die(mysqli_error($mysqli));
					
	//get master_id for use with other tables
	$master_id = mysqli_insert_id($mysqli);
	
	if (($_POST["address"]) && ($_POST["city"]) && ($_POST["state"])
		&& ($_POST["zipcode"])) {
		//something relevant, so add to address tables
		
		
		
		
		
		
		
		
		
		$add_address_sql = "INSERT INTO address (master_id, date_added, 
					date_modified, address, city, state, zipcode, 
					type) VALUES ('".$master_id."', now(), now(),
					'".$_POST["address"]."', '".$_POST["city"]."',
					'".$_POST["state"]."', '".$_POST["zipcode"]."',
					'".$_POST["add_type"]."')";
		$add_address_res = mysqli_query($mysqli, $add_address_sql)
						or die(mysqli_error($mysqli));
	}
	
	if ($_POST["tel_number"]) {
		//something relevant, so add to telephone tables
		$add_tel_sql = "INSERT INTO telephone (master_id, date_added,
						date_modified, tel_number, type) VALUES
						('".$master_id."', now(), now(),
						'".$_POST["tel_number"]."',
						'".$_POST["tel_type"]."')";
		$add_tel_res = mysqli_query($mysqli, $add_tel_sql)
						or die(mysqli_error($mysqli));
	}
	
	if ($_POST["fax_number"]) {
		//something relevant, so add to fax tables
		$add_fax_sql = "INSERT INTO fax (master_id, date_added,
						date_modified, fax_number, type) VALUES
						('".$master_id."', now(), now(),
						'".$_POST["fax_number"]."',
						'".$_POST["fax_type"]."')";
		$add_fax_res = mysqli_query($mysqli, $add_tel_sql)
						or die(mysqli_error($mysqli));
	}

	if ($_POST["email"]) {
		//something relevant, so add to email table 
		$add_email_sql = "INSERT INTO email (master_id, date_added,
						date_modified, email, type) VALUES
						('".$master_id."', now(), now(),
						'".$_POST["email"]."',
						'".$_POST["email_type"]."')";
		$add_email_res = mysqli_query($mysqli, $add_tel_sql)
						or die(mysqli_error($mysqli));
	}
	
	if ($_POST["note"]) {
		//something relevant, so add to notes table 
		$add_notes_sql = "INSERT INTO personal_notes (master_id,
			date_added,	date_modified, note) VALUES
			('".$master_id."', now(), now(), '".$_POST["note"]."')";
		$add_notes_res = mysqli_query($mysqli, $add_notes_sql)
						or die(mysqli_error($mysqli));
	}
	mysqli_close($mysqli);
	$display_block = "<p>Your entry has been added.
	Would you like to <a href=\"addentry.php\">add another</a>?</p>";
}
?>
<html>
<head>
<title>Add an Entry</title>
</head>
<body>
<h1>Add an Entry</h1>
<?php echo $display_block; ?>
</body>
</html>
