<?php
	require_once('system_inits.php');

	if (!isset($_SESSION['uid']))
		exit(0);

	$worker_id = $_POST['worker_id'];

	$query = sprintf('DELETE FROM company_workers where worker_id=%d', 
					$worker_id);

	echo $query;

	if (!$mysqli->query($query)) {
		fprintf($stderr, 'Error_message: %s\n', $mysqli->error);
		exit(1);
	}
?>