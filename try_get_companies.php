<?php
	require_once('system_inits.php');
	
	$user_id = $_SESSION['uid'];
	
	$query = "SELECT * FROM menus WHERE uid=" . $user_id;

	if ((!$result = $mysqli->query($query))) {
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}

	$menus = array();
	while ($row = $result->fetch_array())
		$menus[$row['name']] = $row['mid'];

	$query = "SELECT * FROM companies WHERE user_id=" . $user_id;

	if ((!$result = $mysqli->query($query))) {
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}

	if ($result->num_rows == 0)
		echo "NO COMPANIES";
	else {
		echo '<div class="panel panel-default">';
		echo '<div class="panel-heading">Ваши предприятия</div>';
		
		echo '<table class="table">';
		
		echo '<thead>';
    	echo '<tr>';
      	echo '<th>Название</th>';
      	echo '<th>Меню</th>';
      	echo '<th></th>';
		echo '</tr>';
		echo '</thead>';

		echo '<tbody>';

		while (($row = $result->fetch_array())) {
			$current_menu_id = $row['current_menu_id'];
			$company_id = $row['company_id'];

			echo '<tr>';

			printf('<td>%s</td>', $row['company_name']);

			echo '<td>';

			printf('<div class="dropdown" id="menu_dropdown_%d">', 
					$company_id);  			

  			if ($current_menu_id == -1) 
  				echo '<button class="btn btn-default dropdown-toggle"
  					type="button" data-toggle="dropdown">Меню не установлено ';
  			else 
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
			echo '</div>';

			echo '</td>';

			echo '<td>';
			printf('<button type="button" class="btn btn-primary"
						onclick="edit_company(%d)">Редактировать</button>', $company_id);
			printf('<button type="button" class="btn btn-danger" onclick="delete_company(%d)" 
						style="margin-left:3%%">Удалить</button></li>', $company_id);
			echo '</td>';

			echo '</tr>';
		}

		echo '</tbody>';

		echo '</table>';
		echo '</div>';
	}
?>