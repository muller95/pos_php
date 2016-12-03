<?php 
	require_once('system_inits.php');	

	$query = "SELECT * from menus where uid=" . $_SESSION['uid'];

	if ((!$result = $mysqli->query($query))) {
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}

	if ($result->num_rows == 0)
		echo "NO MENUS";
	else {
		echo '<div class="panel panel-default">';
		echo '<div class="panel-heading">Ваши меню</div>';
		
		echo '<table class="table">';
		
		echo '<thead>';
    	echo '<tr>';
      	echo '<th>Название</th>';
      	echo '<th></th>';
		echo '</tr>';
		echo '</thead>';

		echo '<tbody>';

		while (($row = $result->fetch_array())) {
			echo '<tr>';

			printf('<td>%s</td>', $row['name']);

			echo '<td>';

			printf('<button type="button" class="btn btn-primary"
				onclick="edit_menu(\'%s\')">Редактировать</button>', 
				$row['mid']);
			
			printf('<button type="button" class="btn btn-danger" 
				onclick="delete_menu(\'%s\')" 
				style="margin-left:2%%">Удалить</button></li>', $row['mid']);

			echo '</td>';

			echo '</tr>';
		}

		echo '</tbody>';

		echo '</table>';
		echo '</div>';
	}
?>