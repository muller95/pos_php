<?php
	require_once('system_inits.php');

	if (!isset($_SESSION['uid']))
		exit(0);

	$user_id = $_SESSION['uid'];
	$company_id = $_POST['company_id'];

	$mysqli->autocommit(FALSE);

	$query = sprintf('DELETE from companies where user_id=%d and 
		company_id=%d;', $user_id, $company_id);
	$result_delete_company = $mysqli->query($query);

	$query = sprintf('DELETE FROM company_workers where company_id=%d;', 
		$company_id);
	$result_delete_workers = $mysqli->query($query);

	if (!$result_delete_company || !$result_delete_workers) {
		$mysqli->rollback();
		fprintf($stderr, "Error on transaction: %s",  $mysqli->error);
	} else
		$mysqli->commit();
?>