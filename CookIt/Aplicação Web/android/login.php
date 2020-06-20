<?php

require '../connection.php';
@$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);
$conn->set_charset('utf8');

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

if ($conn->connect_error) {
	echo 'connection_failed';
} else {
	$query = $conn->query("SELECT id FROM users WHERE email LIKE '".$email."' AND password LIKE '".sha1($password)."'");
	if ($query->num_rows > 0) {
		$result = $query->fetch_array(MYSQLI_ASSOC);
		echo $result['id'];
	} else echo 'auth_failed';
}

?>