<?php
require '../connection.php';
@$conn = new mysqli($db['host'], $db['user'], $db['password'], $db['database']);
$conn->set_charset('utf8');

$id = $_REQUEST['userId'];

$outp = "";

$user_query = $conn->query("SELECT name FROM users WHERE id = ".$id);
if ($user_query->num_rows > 0) {
	$result = $user_query->fetch_array(MYSQLI_ASSOC);
	$outp .= 'username<spliter>'.$result['name'];
}

$query = "
	SELECT
		title,
		id
	FROM recipes
	INNER JOIN favorites ON recipes.id = favorites.recipe_id
	WHERE favorites.user_id = ".$id."
	AND recipes.public = 1
	AND recipes.valid = 1
";

$res_query = $conn->query($query);
while ($row = $res_query->fetch_array(MYSQLI_ASSOC)) {
	
	$title = $row['title'];
	$id = $row['id'];

	if ($outp != "") $outp .= "\n";
	$outp .= $title.'<spliter>'.$id;
}

echo $outp;

?>