<?php
	require_once('../system_inits.php');

	$worker_id = $_POST['worker_id'];
	$worker_passwd = $_POST['worker_passwd'];
	$error = false;
	$error_msg = "";
	
	if (!$worker_id) {
		$error = true;
		$error_msg = 'Необходимо ввести ваш id. ';
	}

	if (!$worker_passwd) {
		$error = true;
		$error_msg .= 'Необходимо ввести пароль.';
	}

	if (!$error) {
		$passwd_hash = hash("whirlpool", $worker_passwd);
		$query = sprintf("SELECT * FROM company_workers WHERE worker_id=%d 
			AND worker_passwd_hash='%s';", $worker_id, $passwd_hash);


		if (!($result = $mysqli->query($query))) {
			fprintf($stderr, "Error message: %s\n", $mysqli->error);
			exit(1);
		}

		if ($result->num_rows == 0) {
			echo "ERR" . PHP_EOL. "Неправильный id или пароль." . PHP_EOL;
			exit(0);
		}

		$row = $result->fetch_array();
		printf("OK%s%d%s", PHP_EOL, $row['company_id'], PHP_EOL);
	} else 
		printf('ERR%s%s%s', PHP_EOL, $error_msg, PHP_EOL);;
	
?>
