<?php
	require_once('system_inits.php');  
	$email = $_POST['email'];
	$passwd = $_POST['passwd'];
	$user_type = $_POST['user_type'];

	$error = false;

	if (!$email) {
		echo "Email необходимо указать<br>";
		$error = true;
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Введите корректный email<br>";
		$error = true;
	} 

	if (!$user_type) {
		echo "Необходимо указать владелец вы или работник<br>";
		$error = true;
	} else {
		$query = "SELECT email from users where email='" . $email . "';"; 
		$result = $mysqli->query($query);
		if (!$result) {
			fprintf($stderr, "Error message: %s\n", $mysqli->error);
			exit(1);
		}

		if ($result->num_rows > 0) {
			echo "Данный email уже зарегистрирован<br>";
			$error = true;
		}
	}

	if (!$passwd) {
		echo "Необходимо указать пароль<br>";
		$error = true;
	} else {
		$short = strlen($passwd) < 7;
		
		$nolower = $noupper = $nodigits = true;
		for ($i = 0; $i < strlen($passwd); $i++) {
			if (ctype_lower($passwd[$i]))
				$nolower = false;

			if (ctype_upper($passwd[$i]))
				$noupper = false;

			if (ctype_digit($passwd[$i]))
				$nodigits = false;
		}

		if ($short || $nolower || $noupper || $nodigits) {
			echo "Ваш пароль слишком слабый<br>";
			$error = true;
		}
	}	

	if (!$error) {
		$passwd_hash = hash("whirlpool", $passwd);
		

		$query = "INSERT INTO users VALUES(0, '" . $email . "', '" . $passwd_hash .
					 "','" . $user_type . "');";

		if (!$mysqli->query($query)) {
			fprintf($stderr, "Error message: %s\n", $mysqli->error);
			exit(1);
		}

		echo "OK";
	}
?>