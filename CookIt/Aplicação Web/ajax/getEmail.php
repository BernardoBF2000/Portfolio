<?php

require "../connection.php";
@$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);
$conn->set_charset('utf8');

$id = $_REQUEST['id'];

$query = $conn->query("SELECT email FROM users WHERE id = ".$id);
$result = $query->fetch_array(MYSQLI_ASSOC);

echo $result['email'];

?>