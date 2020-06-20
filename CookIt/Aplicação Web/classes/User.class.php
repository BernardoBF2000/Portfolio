<?php

	class User {

		private $id;
		private $name;

		private $db;
		private $conn;

		function __construct () {

			require 'connection.php';
			$this->conn = new mysqli($db['host'], $db['user'], $db['password'], $db['database']);
			$this->conn->set_charset('utf8');

			if (isset($_SESSION["user"])) {

				if ($result = $this->conn->query("SELECT name, id FROM users WHERE id LIKE '".$_SESSION["user"]."'")) {

					$resultCount = $result->num_rows;

					if ($resultCount > 0) {

						$row = $result->fetch_array(MYSQLI_ASSOC);

						$this->id = $row["id"];
						$this->name = $row["name"];
					}
				}
			}
		}

		function authenticated () {

			if (isset($_SESSION["user"])) {

				return true;
			} else {

				return false;
			}
		}

		function authenticate ($email, $password, $remenberme) {

			if ($result = $this->conn->query("SELECT name, id FROM users WHERE email LIKE '".$email."' AND password LIKE '".sha1($password)."' AND valid LIKE 'true'")) {

				$resultCount = $result->num_rows;

				if ($resultCount > 0) {

					$row = $result->fetch_array(MYSQLI_ASSOC);
					$_SESSION["user"] = $row["id"];

					$this->id = $row["id"];
					$this->name = $row["name"];

					if ($remenberme) {

						setcookie("email", $email, time() + (86400 * 30));
					} else {

						setcookie("email", "", -1);
					}
				}
			}
			?><script>window.location.href = '?p=home';</script><?php
		}

		function logout () {

			session_destroy();
			?><script>window.location.href = '?p=home';</script><?php
		}

		function name () {

			return $this->name;
		}
	}

?>