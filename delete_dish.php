<?php
	require_once('system_inits.php');

	if (!isset($_SESSION['uid']))
		exit(0);

	$cid = $_POST['cid'];
	$did = $_POST['did'];

	$query = sprintf('DELETE FROM dishes where cid=%d and did=%d;', 
					$cid, $did);

	if (!$mysqli->query($query)) {
		fprintf($stderr, 'Error_message: %s\n', $mysqli->error);
		exit(1);
	}
?>