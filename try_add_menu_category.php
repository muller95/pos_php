<?php 
	require_once('system_inits.php');

	if (isset($_SESSION['uid'])) {
		$mid = $_POST['mid'];
		$name = $_POST['name'];
		$name = trim($name);
		$error = false;

		if (!$name) {
			echo "Необзодимо указать название раздела меню<br>";
			$error = true;
		}

		$query = "SELECT * from menu_categories where mid=" . 
					$mid . " and name='" . $name . "';";

		if (!$error) {
			if (!($result = $mysqli->query($query))) {
				fprintf($stderr, "Error message: %s\n", $mysqli->error);
				exit(1);
			}

			if ($result->num_rows > 0) {
				echo "В этом меню уже есть такой раздел<br>";
				$error = true;
			} else {
				$query = "INSERT INTO menu_categories VALUES(0, '" . $name . "'," . 
							$mid . ");";

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