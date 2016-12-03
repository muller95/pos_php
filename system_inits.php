<?php
	session_start();
	$mysqli = new mysqli("localhost", "vh26035_db_user", "db_user_very_long", "vh26035_pos_db");
	if ($mysqli->connect_error)
		die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);

	$stderr = fopen('php://stderr', 'rw');
?>
