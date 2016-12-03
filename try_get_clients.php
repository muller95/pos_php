<?php 
	require_once('system_inits.php');	

	$query = sprintf("SELECT * from clients where user_id=%d", 
		$_SESSION['uid']);

	if ((!$result = $mysqli->query($query))) {
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}

	if ($result->num_rows == 0)
		echo "NO CLIENTS";
	else {
		echo '<div class="panel panel-default">';
		echo '<div class="panel-heading">Ваши меню</div>';
		
		echo '<table class="table">';
		
		echo '<thead>';
    	echo '<tr>';
      	echo '<th>Имя клиента</th>';
      	echo '<th>Номер карты</th>';
      	echo '<th>Скидка</th>';
      	echo '<th></th>';
		echo '</tr>';
		echo '</thead>';

		echo '<tbody>';

		while (($row = $result->fetch_array())) {
			echo '<tr>';

			printf('<td>%s</td>', $row['client_name']);
			printf('<td>%s</td>', $row['client_card_number']);
			printf('<td>%lf</td>', $row['client_discount']);

			echo '<td>';
			
			printf('<button type="button" class="btn btn-danger" 
				onclick="delete_client(%d)" style="margin-left:2%%">
				Удалить</button>', $row['client_id']);

			echo '</tr>';
		}

		echo '</tbody>';

		echo '</table>';
		echo '</div>';
	}
?>