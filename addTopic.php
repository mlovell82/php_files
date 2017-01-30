<?php
include("includetopic.php");
doDB();

//check for required fields from the form
if ((!$_POST["topic_owner"]) && (!$_POST["topic_title"]) && 
(!$_POST["post_text"])) {
	header("Location: addtopic.html");
	exit;
}
//create and issue the first query
$add_topic_sql = "INSERT INTO forum_topics (topic_title, topic_create_time,
				topic_owner) VALUES ('".$_POST["topic_title"]."',now(),
				'".$_POST["topic_owner"]."')";
$add_topic_res = mysqli_query($mysqli, $add_topic_sql)
				or die(mysqli_error($mysqli));
				
//get the id of the last query
$topic_id = mysqli_insert_id($mysqli);

//create and issue the second query
$add_post_sql = "INSERT INTO forum_posts (topic_id, post_text, 
			post_create_time, post_owner) VALUES ('".$topic_id."',
			'".$_POST["post_text"]."', now(),
			'".$_POST["topic_owner"]."')";
$add_post_res = mysqli_query($mysqli, $add_post_sql)
				or die(mysqli_error($mysqli));
				
//close connection to MYSQL
mysqli_close($mysqli);

//create nice message for user
$display_block = "<p>The<strong>".$_POST["topic_title"]."</strong>
topic has been created.</p>";

?>
<html>
<head>
<title>New Topic Added</title>
</head>
<body>
<h1>New Topic Added</h1>
<?php echo $display_block; ?>
</body>
</html>
