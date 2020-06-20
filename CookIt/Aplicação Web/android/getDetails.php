<?php

require '../connection.php';
@$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);
$conn->set_charset("utf8");

$id = $_REQUEST["recipeId"];

$recipe_query = $conn->query("SELECT title, dificulty, time_drt, category, robot, ingredients, img_path, user_id, lst_chg_date, id FROM recipes WHERE public = 1 AND valid = 1 AND id = ".$id);
$recipe_result = $recipe_query->fetch_array(MYSQLI_ASSOC);

$title = $recipe_result["title"];

switch ($recipe_result["dificulty"]) {
	case "easy": $dificulty = "Fácil"; break;
	case 'medium': $dificulty = "Médio"; break;
	case "hard": $dificulty = "Difícil"; break;
	default: $dificulty = "Indefinido"; break;
}

if ($recipe_result["time_drt"] != 0) { $duration = $recipe_result["time_drt"]." min"; } else { $duration = "Indefinido"; }

switch ($recipe_result['category']) {
	case "side_dish": $category = "Acompanhamentos"; break;
	case "drinks": $category = "Bebidas"; break;
	case "cakes_cookies": $category = "Bolos e Biscoitos"; break;
	case "food_entrances_salads": $category = "Entradas e Saladas"; break;
	case "jellies_jams": $category = "Geleias, Doces e Compotas"; break;
	case "sauces_spices": $category = "Molhos e Temperos"; break;
	case "breads": $category = "Pães"; break;
	case "meat_dishes": $category = "Pratos de Carne"; break;
	case "fish_seafood_dishes": $category = "Pratos de Peixe e Marisco"; break;
	case "vegetarian_food": $category = "Pratos Vegetarianos"; break;
	case "salty_pies_pizzas": $category = "Salgados, Tartes e Pizzas"; break;
	case "snacks": $category = "Snacks e Aperitivos"; break;
	case "desserts": $category = "Sobremesas"; break;
	case "soups": $category = "Sopas"; break;
	default: $category = "Sem Categoria"; break;
}

if ($recipe_result["robot"] != "") { $robot = $recipe_result['robot']; } else { $robot = "Sem Robô"; }

$ingredients = str_replace("\n", "", $recipe_result['ingredients']);

if($recipe_result['img_path'] == 'default.jpg') $img = 'none';
else $img = 'http://cookit.ddns.net/img/'.$recipe_result['img_path'];

$outp = "title<spliter>".$title."\ndificulty<spliter>".$dificulty."\nduration<spliter>".$duration."\ncategory<spliter>".$category."\nrobot<spliter>".$robot."\ningredients<spliter>".$ingredients."\nimg<spliter>".$img;

$step_query = $conn->query("SELECT value FROM steps WHERE recipe_id = ".$id." ORDER BY step_n ASC");

while($step_result = $step_query->fetch_array(MYSQLI_ASSOC)){
	$outp .= "\nstep<spliter>".str_replace("\n", "", $step_result['value']);
}

echo $outp;

?>