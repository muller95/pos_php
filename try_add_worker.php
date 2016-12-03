<?php 
	require_once('system_inits.php');

	if (isset($_SESSION['uid'])) {
		$company_id = $_POST['company_id'];
		$worker_name = $_POST['worker_name'];
		$worker_passwd = $_POST['worker_passwd'];
		$worker_role = $_POST['worker_role'];
		$error = false;

		if (!$worker_name) {
			echo "Необзодимо указать имя работника<br>";
			$error = true;
		}

		if (!$worker_passwd) {
			echo "Необходимо указать пароль<br>";
			$error = true;
		} else {
			$short = strlen($worker_passwd) < 7;
		
			$nolower = $noupper = $nodigits = true;
			for ($i = 0; $i < strlen($worker_passwd); $i++) {
				if (ctype_lower($worker_passwd[$i]))
					$nolower = false;

				if (ctype_upper($worker_passwd[$i]))
					$noupper = false;

				if (ctype_digit($worker_passwd[$i]))
					$nodigits = false;
			}

			if ($short || $nolower || $noupper || $nodigits) {
				$error = true;
				echo "Ваш пароль слишком слабый<br>";
			}
		}

		if (!$worker_role) {
			echo "Необходимо указать роль работника<br>";
			$error = true;
		}

		if (!$error) {
			$worker_passwd_hash = hash("whirlpool", $worker_passwd);
			$query = sprintf("INSERT INTO company_workers 
				VALUES(0, '%s', '%s', '%s', %d);", 
				$worker_name, $worker_passwd_hash, 
				$worker_role, $company_id);

			if (!$mysqli->query($query)) {
				fprintf($stderr, "Error message: %s\n", $mysqli->error);
				exit(1);
			}

		}

		if (!$error)
			echo "OK";
	} else 
		header('Location: index.php');

?>