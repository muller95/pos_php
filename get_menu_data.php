<?php 
	require_once('system_inits.php');	

	$query = "SELECT * from menu_categories where mid=" . $_POST['mid'];

	if (!($result = $mysqli->query($query))) {
		fprintf($stderr, "Error message: %s\n", $mysqli->error);
		exit(1);
	}

	if ($result->num_rows == 0)
		echo "NO CATEGORIES";
	else {
		while (($row_category = $result->fetch_array())) {
			echo '<div class="panel panel-default">';
			echo '<div class="row">';
			echo '<div class="col-lg-10">';
			echo '<div class="panel-heading">';
			printf('<a data-toggle="collapse" href="#collapse_%d" onclick="change_icon(this)">
					<span class="glyphicon glyphicon-collapse-down"></span> %s</a>', 
					$row_category['cid'], $row_category['name']);
			printf('<button type="button" class="btn btn-danger" onclick="delete_category(%d, %d)" 
					style="margin-left:3%%">Удалить</button></li>', 
					$_POST['mid'], $row_category['cid']);
			echo '</div>';
			echo '</div>';
			echo '</div>';

			printf('<div id="collapse_%d" class="panel-collapse collapse">', $row_category['cid']);	
  			echo '<div class="panel-body">';
    		
  			$query = sprintf('SELECT * FROM dishes where cid=%d;', $row_category['cid']);

  			if (!($result_dishes = $mysqli->query($query))) {
				fprintf($stderr, "Error message: %s\n", $mysqli->error);
				continue;
			}

			/*printf('<div id="alerts_%d" class="alert alert-danger" style="display:none"></div>', 
					$row_category['cid']);*/
			if ($result_dishes->num_rows == 0)
				echo '<div class="alert alert-warning">В этой категории нет ещё ни одного блюда</div>';
			else {
				echo '<table class="table">';

   				echo '<thead>';
    			echo '<tr>';
      			echo '<th>Название</th>';
      			echo '<th>Цена</th>';
      			echo '<th></th>';
				echo '</tr>';


  				echo '<tbody>';

  				while (($row_dish = $result_dishes->fetch_array())) {
  					printf('<tr><td>%s</td><td>%lf</td><td><button type="button" class="btn btn-danger" 
  						onclick="delete_dish(%d, %d, %d)" style="margin-left:3%%">Удалить</button></td>', 
  						$row_dish['name'], $row_dish['price'], $_POST['mid'], $row_category['cid'], $row_dish['did']);
  				}
  				echo '</tbody>';

  				echo '</table>';
			}

			echo '<div class="well well-sm">';

			printf('<label for="dish_name_%d">Название блюда: </label> ', 
						$row_category['cid']);
			printf('<input type="text" class="form-control" id="dish_name_%d" 
						placeholder="Название блюда"> ', $row_category['cid']);

			printf('<label for="dish_name_%d">Цена блюда: </label> ', 
						$row_category['cid']);
			printf('<input type="text" class="form-control" id="dish_price_%d" 
						placeholder="Цена блюда"> ', $row_category['cid']);

			printf('<button type="button" name="submit" class="btn btn-success btn-md" 
					onclick="try_add_dish(%d, %d)" style="margin-top:1%%">Добавить блюдо</button>', 
					$_POST['mid'], $row_category['cid']);

			echo '</div>';

			echo '</div>';
			echo '</form>';
			echo '</div>';
			

  			echo '</div>';
  			echo '</div>';
			echo '</div>';
		}
	}
?>
