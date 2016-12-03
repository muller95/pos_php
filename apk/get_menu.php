<?php
	require_once('../system_inits.php');

	$company_id = $_POST['company_id'];
	$error = false;
	$error_msg = "";
	
	if (!$company_id) {
		$error = true;
		$error_msg = 'Не указан id компании. ';
	}

	if (!$error) {
		$query = sprintf("SELECT * FROM companies WHERE company_id=%d;", $company_id);


		if ((!$result = $mysqli->query($query))) {
			echo "Неизвестная ошибка." . PHP_EOL;
			fprintf($stderr, "Error message: %s\n", $mysqli->error);
			exit(1);
		}

		if ($result->num_rows == 0) {
			echo "ERR" . PHP_EOL . "Неправильный id компании." . PHP_EOL;
			exit(0);
		}

		$row = $result->fetch_array();
		printf("OK%s%d%s", PHP_EOL, $row['current_menu_id'], PHP_EOL);


		$query = sprintf("SELECT * from menu_categories where mid=%d;", 
			$row['current_menu_id']);


		if (!($result = $mysqli->query($query))) {
			echo "Неизвестная ошибка." . PHP_EOL;
			fprintf($stderr, "Error message: %s\n", $mysqli->error);
			exit(1);
		}

		while (($row_category = $result->fetch_array())) {
			echo 'CATEGORY' . PHP_EOL;
			echo $row_category['name'] . PHP_EOL;

  			$query = sprintf('SELECT * FROM dishes where cid=%d;', 
				$row_category['cid']);
			
  			$query = sprintf('SELECT * FROM dishes where cid=%d;', $row_category['cid']);

  			if (!($result_dishes = $mysqli->query($query))) {
				echo "Неизвестная ошибка." . PHP_EOL;
				fprintf($stderr, "Error message: %s\n", $mysqli->error);
				continue;
			
			
			}
  			
			while (($row_dish = $result_dishes->fetch_array())) {
				echo $row_dish['name'] . PHP_EOL . $row_dish['price'] . PHP_EOL .
					$row_dish['did'] . PHP_EOL;
			}

			echo 'END CATEGORY' . PHP_EOL;
		}
	} else 
		printf('ERR%s%s%s', PHP_EOL, $error_msg, PHP_EOL);
?>
