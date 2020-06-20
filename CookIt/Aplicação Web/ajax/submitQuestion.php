<?php

require '../connection.php';
@$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);
$conn->set_charset('utf8');

$email = $_REQUEST['email'];
$subject = $_REQUEST['subject'];
$question = $_REQUEST['question'];

if ($conn->connect_error) {

	echo "connectionFailed";
} else {

	if ($conn->query("INSERT INTO questions (email, subject, question, post_date) VALUES ('".$email."', '".$subject."', '".$question."', NOW())")) {

		echo "success";
	} else {

		echo "queryFailed";
	}
}

?>