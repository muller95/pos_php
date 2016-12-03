<?php 
	require_once('system_inits.php');

	if (isset($_SESSION['uid'])) {
		$user_id = $_SESSION['uid'];
		$client_name = $_POST['client_name'];
		$card_number = $_POST['card_number'];
		$discount = $_POST['discount'];

		$error = false;

		if (!$client_name) {
			echo "Необзодимо указать имя клиента<br>";
			$error = true;
		}

		if (!$card_number) {
			echo "Необходимо указать номер карты<br>";
			$error = true;
		} else 
			for ($i = 0; $i < strlen($card_number); $i++)
				if (!ctype_digit($card_number[$i])) {
					echo "Номер карты должен состоять только из цифр<br>";
					$error = true;
					break;
				}

		if (!$discount) {
			$discount = 0.0;
		} else if (!is_numeric($discount)) {
			echo 'Скидка должна быть вещественным числом, например, 123.45<br>';
			$error = true;
		} else if ($discount < 0.0 || $discount >= 1.0 ) {
			echo 'Скидка должна быть от 0.0 до 1.0, не включая 1.0<br>';
			$error = true;
		}

		
		if (!$error) {
			$query = sprintf("SELECT * from clients where user_id=%d and 
				client_card_number='%s';", $user_id, $card_number);
			
			if (!$error) {
				if (!($result = $mysqli->query($query))) {
					fprintf($stderr, "Error message: %s\n", $mysqli->error);
					exit(1);
				}

				if ($result->num_rows > 0) {
					echo "Номер карты уже занят<br>";
					$error = true;
				} else {
					$query = sprintf("INSERT INTO clients VALUES(0, '%s', 
						'%s', %lf, %d);", $client_name, $card_number, 
						$discount, $user_id);

					if (!$mysqli->query($query)) {
						fprintf($stderr, "Error message: %s\n", $mysqli->error);
						exit(1);
					}
				
				}
			}
		}

		if (!$error)
			echo "OK";
	} else 
		header('Location: index.php');

?>