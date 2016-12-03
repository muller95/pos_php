<?php
	require_once('system_inits.php');

	if (!isset($_SESSION['uid']))
		exit(0);

	$user_id = $_SESSION['uid'];
	$client_id = $_POST['client_id'];

	$query = sprintf('DELETE FROM clients WHERE client_id=%d and user_id=%d;', 
					$client_id, $user_id);

	if (!$mysqli->query($query)) {
		fprintf($stderr, 'Error_message: %s\n', $mysqli->error);
		exit(1);
	}
?>