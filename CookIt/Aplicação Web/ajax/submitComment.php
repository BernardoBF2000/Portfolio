<?php

require '../connection.php';
@$conn = new mysqli($db['host'], $db['user'], $db['password'], $db['database']);
$conn->set_charset('utf8');

$email = $_REQUEST['email'];
$rating = $_REQUEST['rating'];
$comment = $_REQUEST['comment'];

if ($conn->connect_error) {

	echo "connectionFailed";
} else {

	if ($conn->query("INSERT INTO comments (email, rating, comment, post_date) VALUES ('".$email."', ".$rating.", '".$comment."', NOW())")) {

		echo "success";
	} else {

		echo "queryFailed";
	}
}

?>