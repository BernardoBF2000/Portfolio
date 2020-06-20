<?php
	require_once "connection.php";
	@$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);
	$conn->set_charset('utf8');

	session_start();

	require_once "classes/User.class.php";
	require_once "classes/Recipe.class.php";

	$user = new User();
	$recipe = new Recipe();

	if (@$_GET["p"] == "authenticate" && isset($_POST["email"]) && isset($_POST["password"])) {
		$user->authenticate($_POST["email"], $_POST["password"], isset($_POST["remenberme"]));
	}

?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>CookIt</title>
	<link rel="icon" type="image/png" href="favicon.png">

	<meta name="description" content="">
	<meta name="author" content="Bernardo Baptista Ferreira">

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="summernote/dist/summernote.css" rel="stylesheet">
	
	<link href="css/modals.css" rel="stylesheet">
	<link href="css/navbar.css" rel="stylesheet">

	<script src="js/jquery.min.js"></script>
	<script src="summernote/dist/summernote.js"></script>
	<script src="js/Loader.class.js"></script>

	<script src="js/angular.min.js"></script>
	<script src="js/angular-animate.min.js"></script>
	<script src="js/angular-password.min.js"></script>

	<script src="js/bootstrap.min.js"></script>

	<script src="js/Alert.class.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/events.js"></script>
	<script src="js/cookit.angular.js"></script>

</head>
<body ng-app="cookit">
	<div class="container-full">
		<div id="teste"></div>
		<div id="loader-container">
			<div id="loader"></div>
		</div>

		<?php
			$modals = array("alert.modal.php", "footer.modals.php");

			array_push($modals, "login.modal.php", "signup.modal.php");
			include "includes/navbar.php";

			if (@$_GET["p"] == "logout") {

				$user->logout();
			} elseif (@$_GET["p"] == "create" && $user->authenticated()) {
				$edit = false;
				include 'includes/create.php';
			} elseif (@$_GET['p'] == 'edit' && $user->authenticated()) {
				$edit = true;
				include 'includes/create.php';
			} elseif (@$_GET["p"] == "create-save") {
				$recipe->create($_POST);
			} elseif (@$_GET["p"] == "recipe_details") {

				$recipe->details(@$_GET["id"]);
			} elseif (@$_GET['p'] == 'favorites' && $user->authenticated()) {
				$recipe->show('favorites');
			} elseif (@$_GET['p'] == 'myrecipes' && $user->authenticated()) {
				$recipe->show('myrecipes');
			} else {
				$recipe->show("home");
			}

			include "includes/footer.php";

			foreach ($modals as $src) {

				require_once "modals/".$src;
			}

		?>
	</div>

	<?php

		if ($conn->connect_error) {

			?>
			<script>
				modalAlert.display("Não foi possível estabelecer conexão com o servidor", "error");
			</script>
			<?php
		}

	?>

</body>
</html>