<?php 
	require_once('system_inits.php');

	if (isset($_SESSION['uid'])) {
		$user_id = $_SESSION['uid'];
		$company_name = trim($_POST['name']);

		$error = false;

		if (!$company_name) {
			echo 'Необзодимо указать название предприятия<br>';
			$error = true;
		}

		$query = sprintf("SELECT * from companies where user_id=%d 
							and company_name='%s';", $user_id, $company_name);

		if (!$error) {
			if (!($result = $mysqli->query($query))) {
				fprintf($stderr, "Error message: %s\n", $mysqli->error);
				exit(1);
			}

			if ($result->num_rows > 0) {
				echo "У вас уже есть такое предприятие<br>";
				$error = true;
			} else {
				$query = sprintf("INSERT INTO companies VALUES(0, '%s', %d, -1);",
									$company_name, $user_id);

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