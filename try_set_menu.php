<?php
	require_once('system_inits.php');

	$user_id = $_SESSION['uid'];
	$company_id = $_POST['company_id'];
	$current_menu_id = $_POST['menu_id'];

	$query = sprintf('UPDATE companies SET current_menu_id=%d WHERE 
						company_id=%d;', $current_menu_id, $company_id);

	if (!$mysqli->query($query)) {
		echo "ERROR";
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}

	$query = "SELECT * FROM menus WHERE uid=" . $user_id;

	if ((!$result = $mysqli->query($query))) {
		echo "ERROR";
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}

	$menus = array();
	while ($row = $result->fetch_array())
		$menus[$row['name']] = $row['mid'];

	foreach ($menus as $menu => $menu_id)
  		if ($current_menu_id == $menu_id) {
  			printf('<button class="btn btn-default dropdown-toggle"
  					type="button" data-toggle="dropdown">%s ', $menu);
  			break;
  		}

  	echo '<span class="caret"></span></button>';
  		printf('<ul class="dropdown-menu" id="menu_dropdown_%d">', 
  				$company_id);

  	foreach ($menus as $menu => $menu_id)
  		if ($menu_id != $current_menu_id)
	  		printf ('<li><a href="#" onclick="try_set_menu(%d, %d)">
	  					%s</a></li>', $company_id, $menu_id, $menu);

  	echo '</ul>';
?>