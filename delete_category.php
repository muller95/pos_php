<?php
	require_once('system_inits.php');
	$query = sprintf("DELETE FROM menu_categories where mid=%d and cid=%d", 
						$_POST['mid'], $_POST['cid']);

	$mysqli->autocommit(FALSE);

	$query = sprintf("DELETE FROM menu_categories where mid=%d and cid=%d", 
					$_POST['mid'], $_POST['cid']);
	$result_delete_category= $mysqli->query($query);

	$query = sprintf("DELETE FROM dishes where cid=%d", $_POST['cid']);
	$result_delete_dishes = $mysqli->query($query);

	if (!$result_delete_category || !$result_delete_dishes) {
		$mysqli->rollback();
		fprintf($stderr, "Error on transaction: %s",  $mysqli->error);
	} else
		$mysqli->commit();
	
?>