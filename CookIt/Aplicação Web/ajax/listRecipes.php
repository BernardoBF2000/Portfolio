<?php
header("Content-Type: application/json; charset=UTF-8");
require '../connection.php';
@$conn = new mysqli($db['host'], $db['user'], $db['password'], $db['database']);
$conn->set_charset('utf8');

$in = $_REQUEST['in'];
$category = $_REQUEST['cat'];
$title = $_REQUEST['title'];
$robot = $_REQUEST['robot'];
$order = $_REQUEST['order'];
$current_page = $_REQUEST['current_page'];

function get_string_between ($string, $start, $end) {

	$string = ' '.$string;
	$ini = strpos($string, $start);
	if ($ini == 0) return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

if ($in == 'all') {

	if ($title != '') {
		$title = str_replace(' ', '%', $title);
		$search_title = "AND title LIKE '%".$title."%'";
	} else $search_title = '';

	if ($robot != '') {
		$robot = str_replace(' ', '%', $robot);
		$search_robot = "AND robot LIKE '%".$robot."%'";
	} else $search_robot = '';

	switch ($category) {
		case 'uncategorized':
		case 'side_dish':
		case 'drinks':
		case 'cakes_cookies':
		case 'food_entrances_salads':
		case 'jellies_jams':
		case 'sauces_spices':
		case 'breads':
		case 'meat_dishes':
		case 'fish_seafood_dishes':
		case 'vegetarian_food':
		case 'salty_pies_pizzas':
		case 'snacks':
		case 'desserts':
		case 'soups':
			$search_category = "AND category LIKE '".$category."'";
			break;
		default:
			$search_category = '';
			break;
	}

	$order = explode(':', $order);
	switch ($order[0]) {
		case 'title':
			$order[1] == 'desc' ? $search_order = "ORDER BY LOCATE('".$title."', title) ASC, title DESC, lst_chg_date DESC" : $search_order = $search_order = "ORDER BY LOCATE('".$title."', title) ASC, title ASC, lst_chg_date DESC";
			break;
		default:
			$order[1] == 'desc' ? $search_order = "ORDER BY lst_chg_date DESC, title ASC" : $search_order = $search_order = "ORDER BY lst_chg_date ASC, title ASC";
			break;
	}
	
	$query = "
		SELECT
			title,
			dificulty,
			time_drt,
			category,
			robot,
			img_path,
			id
		FROM recipes
		WHERE public = 1
		AND valid = 1
		".$search_title."
		".$search_robot."
		".$search_category."
		".$search_order
	;
} elseif (substr($in, 0, 9) == 'favorites') {

	$auth_data = get_string_between($in, '<', '>');
	$auth = explode(':', $auth_data);

	$check = $conn->query("SELECT password FROM users WHERE id = ".$auth[0])->fetch_array(MYSQLI_ASSOC);
	if ($check['password'] == $auth[1]) {

		if ($title != '') {
			$title = str_replace(' ', '%', $title);
			$search_title = "AND title LIKE '%".$title."%'";
		} else $search_title = '';

		if ($robot != '') {
			$robot = str_replace(' ', '%', $robot);
			$search_robot = "AND robot LIKE '%".$robot."%'";
		} else $search_robot = '';

		switch ($category) {
			case 'uncategorized':
			case 'side_dish':
			case 'drinks':
			case 'cakes_cookies':
			case 'food_entrances_salads':
			case 'jellies_jams':
			case 'sauces_spices':
			case 'breads':
			case 'meat_dishes':
			case 'fish_seafood_dishes':
			case 'vegetarian_food':
			case 'salty_pies_pizzas':
			case 'snacks':
			case 'desserts':
			case 'soups':
				$search_category = "AND category LIKE '".$category."'";
				break;
			default:
				$search_category = '';
				break;
		}

		$order = explode(':', $order);
		switch ($order[0]) {
			case 'title':
				$order[1] == 'desc' ? $search_order = "ORDER BY LOCATE('".$title."', title) ASC, title DESC, lst_chg_date DESC" : $search_order = $search_order = "ORDER BY LOCATE('".$title."', title) ASC, title ASC, lst_chg_date DESC";
				break;
			default:
				$order[1] == 'desc' ? $search_order = "ORDER BY lst_chg_date DESC, title ASC" : $search_order = $search_order = "ORDER BY lst_chg_date ASC, title ASC";
				break;
		}

		$query = "
			SELECT
				recipes.title,
				recipes.dificulty,
				recipes.time_drt,
				recipes.category,
				recipes.robot,
				recipes.img_path,
				recipes.id
			FROM recipes
			INNER JOIN favorites ON recipes.id = favorites.recipe_id
			WHERE favorites.user_id = '".$auth[0]."'
			AND recipes.public = 1
			AND recipes.valid = 1
			".$search_title."
			".$search_robot."
			".$search_category."
			".$search_order
		;
	}
} elseif (substr($in, 0, 9) == 'myrecipes') {

	$auth_data = get_string_between($in, '<', '>');
	$auth = explode(':', $auth_data);

	$check = $conn->query("SELECT password FROM users WHERE id = ".$auth[0])->fetch_array(MYSQLI_ASSOC);
	if ($check['password'] == $auth[1]) {

		if ($title != '') {
			$title = str_replace(' ', '%', $title);
			$search_title = "AND title LIKE '%".$title."%'";
		} else $search_title = '';

		if ($robot != '') {
			$robot = str_replace(' ', '%', $robot);
			$search_robot = "AND robot LIKE '%".$robot."%'";
		} else $search_robot = '';

		switch ($category) {
			case 'uncategorized':
			case 'side_dish':
			case 'drinks':
			case 'cakes_cookies':
			case 'food_entrances_salads':
			case 'jellies_jams':
			case 'sauces_spices':
			case 'breads':
			case 'meat_dishes':
			case 'fish_seafood_dishes':
			case 'vegetarian_food':
			case 'salty_pies_pizzas':
			case 'snacks':
			case 'desserts':
			case 'soups':
				$search_category = "AND category LIKE '".$category."'";
				break;
			default:
				$search_category = '';
				break;
		}

		$order = explode(':', $order);
		switch ($order[0]) {
			case 'title':
				$order[1] == 'desc' ? $search_order = "ORDER BY LOCATE('".$title."', title) ASC, title DESC, lst_chg_date DESC" : $search_order = $search_order = "ORDER BY LOCATE('".$title."', title) ASC, title ASC, lst_chg_date DESC";
				break;
			default:
				$order[1] == 'desc' ? $search_order = "ORDER BY lst_chg_date DESC, title ASC" : $search_order = $search_order = "ORDER BY lst_chg_date ASC, title ASC";
				break;
		}

		$query = "
			SELECT
				title,
				dificulty,
				time_drt,
				category,
				robot,
				img_path,
				id
			FROM recipes
			WHERE user_id = '".$auth[0]."'
			".$search_title."
			".$search_robot."
			".$search_category."
			".$search_order
		;
	}
}

$outp = '';

$res_query = $conn->query($query);
$res_query->num_rows % 20 == 0 ? $num_pages = $res_query->num_rows / 20 : $num_pages = floor($res_query->num_rows / 20) + 1;

if ($num_pages <= 0) $num_pages = 1;
if ($current_page < 1) $current_page = 1;
if ($current_page > $num_pages) $current_page = $num_pages;

$query .= " LIMIT 20 OFFSET ".(20 * ($current_page - 1));
$res_query = $conn->query($query);
while ($row = $res_query->fetch_array(MYSQLI_ASSOC)) {

	$title = $row['title'];
	switch ($row['dificulty']) {
		case 'easy': $dificulty = 'Fácil'; break;
		case 'medium': $dificulty = 'Médio'; break;
		case 'hard': $dificulty = 'Difícil'; break;
		default: $dificulty = 'Indefinido'; break;
	}
	$row['time_drt'] != '0' ? $time_drt = $row['time_drt'].' min' : $time_drt = 'Indefinido';
	switch ($row['category']) {
		case 'side_dish': $category = 'Acompanhamentos'; break;
		case 'drinks': $category = 'Bebidas'; break;
		case 'cakes_cookies': $category = 'Bolos e Biscoitos'; break;
		case 'food_entrances_salads': $category = 'Entradas e Saladas'; break;
		case 'jellies_jams': $category = 'Geleias, Doces e Compotas'; break;
		case 'sauces_spices': $category = 'Molhos e Temperos'; break;
		case 'breads': $category = 'Pães'; break;
		case 'meat_dishes': $category = 'Pratos de Carne'; break;
		case 'fish_seafood_dishes': $category = 'Pratos de Peixe e Marisco'; break;
		case 'vegetarian_food': $category = 'Pratos Vegetarianos'; break;
		case 'salty_pies_pizzas': $category = 'Salgados, Tartes e Pizzas'; break;
		case 'snacks': $category = 'Snacks e Aperitivos'; break;
		case 'desserts': $category = 'Sobremesas'; break;
		case 'soups': $category = 'Sopas'; break;
		default: $category = 'Sem Categoria'; break;
	}
	$row['robot'] != '' ? $robot = $row['robot'] : $robot = 'Sem Robô';
	$img_path = 'img/'.$row['img_path'];
	$id = $row['id'];

	if ($outp != '') $outp .= ",";
	$outp .= '
		{
			"title" : "'.$title.'",
			"dificulty" : "'.$dificulty.'",
			"timeDrt" : "'.$time_drt.'",
			"category" : "'.$category.'",
			"robot" : "'.$robot.'",
			"imgPath" : "'.$img_path.'",
			"id" : "'.$id.'"
		}
	';
}

$outp = '{"recipes": ['.$outp.'], "pagination": { "numPages": '.$num_pages.', "currentPage": '.$current_page.' }}';
echo $outp;

?>