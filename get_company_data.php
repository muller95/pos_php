<?php
	function create_role_dropdown($worker_id, $curr_role) {
		$role_text = '';
		if ($curr_role == 'waiter')
			$role_text = 'Официант';
		else if ($curr_role == 'admin') 
			$role_text = 'Администратор зала';
		else if ($curr_role == 'cook')
			$role_text = 'Повар';

		printf('<div class="dropdown">
			<button id="worker%d_role_dropdown"
			class="btn btn-default dropdown-toggle" 
			type="button" id="dropdownMenu1" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="true"
			value="%s">
			%s
			<span class="caret"></span>
			</button>', $worker_id, $curr_role, $role_text);
									
			printf('<ul id="worker%d_dropdown_menu" class="dropdown-menu"
				aria-labelledby="dropdownMenu1">', $worker_id);
			
			printf('<li id="waiter" style="display:%s">
				<a href="#" 
				onclick="set_worker_role(this, \'waiter\', %d)">
				Официант
				</a>
				</li>', ($curr_role == 'waiter') ? 'none' : '', $worker_id);
										
			printf('<li id="admin" style="display:%s">
				<a href="#" 
				onclick="set_worker_role(this, \'admin\', %d)">
				Администратор зала
				</a>
				</li>', ($curr_role == 'admin') ? 'none' : '', $worker_id);
											
			printf('<li id="cook" style="display:%s">
				<a href="#" 
				onclick="set_worker_role(this, \'cook\', %d)">
				Повар
				</a>
				</li>', ($curr_role == 'cook') ? 'none' : '', $worker_id);
	}

	require_once('system_inits.php');	

	$company_id = $_POST['company_id'];

	$query = sprintf("SELECT * from company_workers 
						where company_id=%d;", $company_id);

	if ((!$result = $mysqli->query($query))) {
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}

	if ($result->num_rows == 0)
		echo "NO WORKERS";
	else {
		echo '<div class="panel panel-default">';
		echo '<div class="panel-heading">Ваши работники</div>';
		
		echo '<table class="table">';
		
		echo '<thead>';
    	echo '<tr>';
    	echo '<th>Id</th>';
      	echo '<th>Имя работника</th>';
      	echo '<th>Роль работника</th>';
      	echo '<th>Новый пароль</th>';
      	echo '<th></th>';
		echo '</tr>';
		echo '</thead>';

		echo '<tbody>';

		while (($row = $result->fetch_array())) {
			$worker_id = $row['worker_id'];
			$worker_name = $row['worker_name'];
			$worker_role = $row['worker_role'];

			echo '<tr>';

			printf("<td>%d</td>", $worker_id);
			printf("<td>%s</td>", $worker_name);

			echo '<td>';
			create_role_dropdown($worker_id, $worker_role);
			echo '</td>';

			echo '<td>';
			printf ('<input type="password" class="form-control" 
				id="worker%d_passwd" placeholder="Новый пароль">', $worker_id);
			echo '</td>';

			echo '<td>';

			printf('<button type="button" name="submit" class="btn btn-success" 
				onclick="try_update_worker(%d, %d)">Подтвердить</button>',
				$company_id, $worker_id);

			printf('<button type="button" name="submit" class="btn btn-danger" 
				onclick="delete_worker(%d, %d)"
				style="margin-left:2%%">Удалить</button>',
				$company_id, $worker_id);

			echo '</td>';

			echo '</tr>';
		}

		echo '</tbody>';

		echo '</table>';
		echo '</div>';
	}
?>