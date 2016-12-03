<?php
	require_once('../system_inits.php');

	$error = false;
	$worker = true;

	$worker_id = $_POST['worker_id'];
	$company_id = $_POST['company_id'];
	$error_msg = '';

	if ($_POST['get_orders'] == 'company')
		$worker = false;

	if (!$worker_id) {
		$error_msg = 'Необходимо указать id работника. ';
		$error = true;
	}
	
	if (!$company_id) {
		$error_msg .= 'Необходимо указать id компании. ';
		$error = true;
	}

	if (!$error) {
		if ($worker)
			$query = sprintf("SELECT * FROM orders WHERE worker_id=%d;", $worker_id);
		
		
			
		if (!($result = $mysqli->query($query))) {
			fprintf($stderr, "Error message: %s\n", $mysqli->error);
			exit(1);
		}

		if ($result->num_rows == 0) {
			printf("ERR%sНетзаказов%s", PHP_EOL, PHP_EOL);
			exit(0);
		}
	} else
		printf('ERR%s%s%s', PHP_EOL, $error_msg, PHP_EOL);
?>
