<?php 
	require_once('system_inits.php');

	if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
		$name = $_POST['name'];

		$error = false;

		if (!$name) {
			echo "Необзодимо указать название меню<br>";
			$error = true;
		}

		$query = "SELECT * from menus where uid=" . 
					$uid . " and name='" . $name . "';";

		if (!$error) {
			if (!($result = $mysqli->query($query))) {
				fprintf($stderr, "Error message: %s\n", $mysqli->error);
				exit(1);
			}

			if ($result->num_rows > 0) {
				echo "У вас уже есть такое меню<br>";
				$error = true;
			} else {
				$query = "INSERT INTO menus VALUES(0, '" . $name . "'," . 
							$uid . ");";

				if (!$mysqli->query($query)) {
					fprintf($stderr, "Error message: %s\n", $mysqli->error);
					exit(1);
				}
			}
		}

		if (!$error)
			echo "OK";
	} else 
		header('Location: index.php');

?>