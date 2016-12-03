<?php
	require_once('system_inits.php');

	$error - false;
	$cid = $_POST['cid'];
	$name = trim($_POST['name']);
	$price = $_POST['price'];

	if (!$name) {
		echo 'Необходимо указать имя блюда<br>';
		$error = true;
	}

	if (!$price) {
		echo 'Необходимо указать цену<br>';
		$error = true;
	} else if (!is_numeric($price)) {
		echo 'Цена должна быть вещественным числом, например, 123.45<br>';
		$error = true;
	}

	if (!$error) {
		$query = sprintf("SELECT * FROM dishes WHERE name='%s' and cid=%d;", $name, $cid);

  		if (!($result = $mysqli->query($query))) {
			fprintf($stderr, "Error message: %s\n", $mysqli->error);
			exit(1);
		}

		if ($result->num_rows > 0) {
			echo 'В этой категории уже есть такое блюдо<br>';
			$error = true;
		} else {
			$query  = sprintf("INSERT INTO dishes VALUES(0, '%s', %lf, %d);", 
								$name, $price, $cid);
			
			if (!$mysqli->query($query)) {
				fprintf($stderr, "Error message: %s\n", $mysqli->error);
				exit(1);
			};
		}

		if (!$error)
			echo "OK";
	}
?>