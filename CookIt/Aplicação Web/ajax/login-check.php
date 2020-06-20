<?php
	
	require "../connection.php";
	@$conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);
	
	if ($conn->connect_error) {

		echo "connect_error";
	} else {
		
		$email = $_REQUEST["email"];
		$password = $_REQUEST["password"];
		
		if ($result = $conn->query("SELECT valid FROM users WHERE email LIKE '".$email."' AND password LIKE '".sha1($password)."'")) {

			$resultCount = $result->num_rows;
			
			if ($resultCount > 0) {

				$row = $result->fetch_array(MYSQLI_ASSOC);
				
				if ($row["valid"] == "true") {
					
					echo "success";
				} else {
					
					echo "not_validated";
				}
			} else {

				echo "authentication_failed";
			}
		} else {
			
			echo "query_error";
		}
	}
	
?>