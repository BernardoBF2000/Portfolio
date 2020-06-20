<?php

require_once '../connection.php';
@$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);

$user = $_REQUEST['user'];
$recipe = $_REQUEST['recipe'];

$query = $conn->query("SELECT * FROM favorites WHERE user_id = ".$user." AND recipe_id = ".$recipe);
$fav_check = $query->num_rows;

if ($fav_check == 0) {

	$conn->query("INSERT INTO favorites(user_id, recipe_id) VALUES (".$user.", ".$recipe.")");
	echo "add";
} else {

	$conn->query("DELETE FROM favorites WHERE user_id = ".$user." AND recipe_id = ".$recipe);
	echo "remove";
}

?>