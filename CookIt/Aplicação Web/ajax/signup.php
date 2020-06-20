<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require "../PHPMailer/src/Exception.php";
	require "../PHPMailer/src/PHPMailer.php";
	require "../PHPMailer/src/SMTP.php";
	
	require "../connection.php";
	@$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);

	if ($conn->connect_error) {

		echo "connect_error";
	} else {

		$name = $_REQUEST["name"];
		$email = $_REQUEST["email"];
		$password = $_REQUEST["password"];

		$validationCode = sha1($email).sha1(date("Y.m.d")).sha1(time());

		if ($result = $conn->query("SELECT email FROM users WHERE email LIKE '".$email."'")) {

			$resultCount = $result->num_rows;

			if ($resultCount > 0) {

				echo "email_registered";
			} else if ($conn->query("INSERT INTO users (name, email, password, mk_date, validation_code) VALUES ('".$name."', '".$email."', '".sha1($password)."', NOW(), '".$validationCode."')")) {

				$mail = new PHPMailer(true);

				try {

					$mail->SMTPDebug = false;
					$mail->isSMTP();
					$mail->Host = "smtp.gmail.com";
					$mail->SMTPAuth = true;
					$mail->Username = "bbf2000.dev@gmail.com";
					$mail->Password = "dev.bbf2000";
					$mail->SMTPSecure = "tls";
					$mail->Port = 587;

					$mail->setFrom("bbf2000.dev@gmail.com", "Cookit");
					$mail->addAddress($email);
					$mail->addReplyTo("bbf2000.dev@gmail.com", "Cookit");

					$mail->isHTML(true);
					$mail->Subject = "Confirme a sua conta.";
					$mail->Body = '
						<div align="center">
							<div style="display: inline;">
								<img src="cookit.ddns.net/icon_lg.png" width="64px" height="64px">
								<br>
								<span style="font-size: 20px;">Cookit</span>
							</div>
							<br><br><br><br>
							<div>
								<strong>Clique no link para verficar a sua conta</strong>
								<br>
								<a href="cookit.ddns.net/validate.php?vCode='.$validationCode.'">Confirme a sua conta</a>
							</div>
						</div>
					';

					$mail->send();
					echo "success";
				} catch (Exception $e) {

					echo "send_email_fail";
				}
			} else {

				echo "query_error";
			}
		} else {

			echo "query_error";
		}
	}

?>
