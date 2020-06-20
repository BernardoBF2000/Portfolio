<?php

    require_once "connection.php";
    @$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);

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

    <link href="css/buttons.css" rel="stylesheet">
    <link href="css/modals.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">

</head>
<body>

    <div class="container-full">

        <div id="loader-container">
            <div id="loader"></div>
        </div>

        <?php

        	if (!isset($_REQUEST["vCode"])) {

        		$status = "missing_vars";
        	} else {

        		$vCode = $_REQUEST["vCode"];
			
				if ($result = $conn->query("SELECT validation_code FROM users WHERE validation_code LIKE '".$vCode."'")) {

					$resultCount = $result->num_rows;

					if ($resultCount > 0) {

						if ($conn->query("UPDATE users SET valid = 'true', validation_code = '' WHERE validation_code LIKE '".$vCode."'")) {

							$status = "success";
						} else {

							$status = "query_error";
						}
					} else {

						$status = "not_found";
					}
				} else {

					$status = "query_error";
				}
        	}

        ?>
        <div class="col-md-4"></div>
		<div class="col-md-4" align="center">
			<?php

				if ($status == "missing_vars") {
					
					?>
					<br>
					<span style="font-size: 30px; color: var(--error-color);">Erro!</span>
					<br><br><br>
					<span style="font-size: 20px; color: var(--dark-color);">Ocorreu um erro.</span>
					<?php
				}

				if ($status == "query_error") {
					
					?>
					<br>
					<span style="font-size: 30px; color: var(--error-color);">Erro!</span>
					<br><br><br>
					<span style="font-size: 20px; color: var(--dark-color);">Ocorreu um erro.</span>
					<?php
				}

				if ($status == "not_found") {
					
					?>
					<br>
					<span style="font-size: 30px; color: var(--error-color);">Erro!</span>
					<br><br><br>
					<span style="font-size: 20px; color: var(--dark-color);">A conta não existe ou já foi confirmada.</span>
					<br><br>
					<button class="btn btn-default" onclick="location.href = 'cookit.ddns.net';">Ir para a página inicial</button>
					<?php
				}

				if ($status == "success") {
					
					?>
					<br>
					<span style="font-size: 30px; color: var(--success-color);">Sucesso!</span>
					<br><br><br>
					<span style="font-size: 20px; color: var(--dark-color);">A sua conta foi confirmada.</span>
					<br><br>
					<button class="btn btn-default" onclick="location.href = 'http://cookit.ddns.net/';">Ir para a página inicial</button>
					<?php
				}

			?>
		</div>
		<div class="col-md-4"></div>

    </div>

    <script src="js/Loader.class.js"></script>
    <script src="js/Alert.class.js"></script>

    <script src="js/angular.min.js"></script>
    <script src="js/angular-password.min.js"></script>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="js/scripts.js"></script>
    <script src="js/events.js"></script>
    <script src="js/formValidation.js"></script>

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