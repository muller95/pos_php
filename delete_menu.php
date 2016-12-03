<?php
	require_once('system_inits.php');

	if (!isset($_SESSION['uid']))
		exit(0);

	$uid = $_SESSION['uid'];
	$mid = $_POST['mid'];

	$mysqli->autocommit(FALSE);

	$query = sprintf('DELETE FROM menus WHERE uid=%d and mid=%d', $uid, $mid);
	$result_delete = $mysqli->query($query);

	$query = sprintf('UPDATE companies SET current_menu_id=-1 WHERE 
				current_menu_id=%d;', $mid);
	$result_update = $mysqli->query($query);
	if (!$result_delete || !$result_update) {
		$mysqli->rollback();
		fprintf($stderr, "Error on transaction: %s",  $mysqli->error);
	} else
		$mysqli->commit();
	
?>