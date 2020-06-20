<?php
include 'connection.php';
include 'mpdf60/mpdf.php';

$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);
$conn->set_charset("UTF8");

$id = $_GET['id'];

$query = "
	SELECT
		title,
		dificulty,
		time_drt,
		category,
		robot,
		ingredients,
		img_path,
		user_id,
		lst_chg_date,
		id
	FROM recipes
	WHERE public = 1
	AND valid = 1
	AND id = ".$id."
";

$res_query = $conn->query($query);
if ($res_query->num_rows > 0) {
	$row = $res_query->fetch_array(MYSQLI_ASSOC);

	if ($row['category'] != "") {
		$cat = 'Categoria: '.$row['category'];
	} else {
		$cat = 'Sem Categoria';
	}

	if ($row['dificulty'] == "Fácil") {
		$dif = 'Dificuldade: '.$row['dificulty'];
	} elseif ($row['dificulty'] == "Médio") {
		$dif = 'Dificuldade: '.$row['dificulty'];
	} elseif ($row['dificulty'] == "Difícil") {
		$dif = 'Dificuldade: '.$row['dificulty'];
	} else {
		$dif = 'Dificuldade Indefinida';
	}

	if ($row['time_drt'] != "0") {
		$drt = 'Tempo: '.$row['time_drt']." min";
	} else {
		$drt = 'Tempo Indefinido';
	}

	if ($row['robot'] != "") {
		$rob = $row['robot'];
	} else {
		$rob = 'Sem Robô';
	}

	$res_steps = $conn->query("SELECT step_n, value FROM steps WHERE recipe_id = ".$row['id']." ORDER BY step_n ASC");
	$step = '';
	while ($row_step = $res_steps->fetch_array(MYSQLI_ASSOC)) {
		$step .= '<h4 align="center">Passo '.$row_step['step_n'].'</h4><hr><div align="center">'.$row_step['value'].'</div>';
	}

	if($row['img_path'] != 'default.jpg'){
		$img = '<div align="center"><img src="img/'.$row['img_path'].'" style="max-width: 80%;"></div>';
	} else $img = '';
	
	$html = '
		<h1 align="center"><strong>'.$row['title'].'</strong></h1>
		'.$img.'
		<br>
		<table width="100%">
			<tr>
				<td align="center">'.$cat.'</td>
				<td align="center">'.$dif.'</td>
				<td align="center">'.$drt.'</td>
				<td align="center">'.$rob.'</td>
			</tr>
		</table>
		<h2 align="center"><strong>Ingredientes</strong></h2>
		<div align="center">'.$row['ingredients'].'</div>
		<h2 align="center"><strong>Procedimento</strong></h2>
		<div align="center">'.$step.'</div>
	';

	$mpdf = new mPDF();
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->WriteHTML($html);
	$mpdf->setTitle($row['title']);
	if($_GET['d'] == 'd') { $method = 'D'; } else { $method = 'I'; }
	$mpdf->Output($row['title'].'.pdf', $method);
	exit;
}
?>