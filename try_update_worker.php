<?php
	require_once('system_inits.php');

	$worker_id = $_POST['worker_id'];
	$worker_role = $_POST['worker_role'];
	$worker_passwd = $_POST['worker_passwd'];

	$query = sprintf("UPDATE company_workers SET worker_role='%s' WHERE
		worker_id=%d", $worker_role, $worker_id);
	
	if (!$mysqli->query($query)) {
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}
	

	if ($worker_passwd) {	
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
			exit(0);
		}

		$worker_passwd_hash = hash("whirlpool", $worker_passwd);
		$query = sprintf("UPDATE company_workers SET 
			worker_passwd_hash='%s' WHERE worker_id=%d", $worker_passwd_hash, 
			$worker_id);

		if (!$mysqli->query($query)) {
			fprintf($stderr, "Error message: %s\n", $mysqli->error);
			exit(1);
		}
	}
?>