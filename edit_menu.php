<?php
	require_once('system_inits.php'); 

	if (!isset($_SESSION['uid']))
		header('Location: index.php');
	else if (!$_GET['mid']) 
		header('Location: user_page.php');
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">

		<title>Редактирование меню</title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="jumbotron.css" rel="stylesheet">

		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<script src="js/ie-emulation-modes-warning.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<script src="jquery-3.1.0.min.js"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 
  		<script src="js/bootstrap.min.js"></script>

		<script type="text/javascript">
			function get_menu_data(mid) {
				var user_warn = document.getElementById('user_warn');
				var menu_data = document.getElementById('menu_data');

				user_warn.style.display = 'none';
				
				$.post("get_menu_data.php", { mid:mid },  
    				function(data) {
    					if (data == 'NO CATEGORIES') {
    						user_warn.style.display = '';
    						user_warn.innerHTML = 'Вы ещё не создали ни одного раздела меню';
    						menu_data.innerHTML = "";
    					} else 
    						menu_data.innerHTML = data;
          			});
			}

			function try_add_menu_category(mid) {
				var alerts = document.getElementById("user_alerts");
			   	var name = document.getElementById('category_name').value.trim();
	
			   	alerts.style.display = "none";

			   	$.post("try_add_menu_category.php", { mid:mid, name:name },  
    				function(data) {
            			if (data != "OK") {
             				alerts.style.display = "";
              				alerts.innerHTML = data;
            			} 

            			get_menu_data(mid);
          			});

			   	
			}

			function delete_category(mid, cid) {
				$.post("delete_category.php", {mid:mid, cid:cid}, 
				function() {
					get_menu_data(mid);
				});
			}

			function change_icon(href) {
				if (href.children[0].className == 'glyphicon glyphicon-collapse-down')
					href.children[0].className = 'glyphicon glyphicon-collapse-up';
				else
					href.children[0].className = 'glyphicon glyphicon-collapse-down';
			}

			function try_add_dish(mid, cid) {
				var alerts = document.getElementById("user_alerts");
				var name = document.getElementById('dish_name_' + cid).value;
				var price = document.getElementById('dish_price_' + cid).value;

				alerts.style.display = 'none';

				$.post("try_add_dish.php", {cid:cid, name:name, price:price}, 
				function (data) {
					if (data != 'OK') {
						alerts.style.display = '';
						alerts.innerHTML = data;
					} else
						get_menu_data(mid);
				});
			}

			function delete_dish(mid, cid, did) {
				$.post("delete_dish.php", {cid:cid, did:did},
				function() {
					get_menu_data(mid);
				})
			}
		</script>
	</head>

	<body <?php printf('onload="get_menu_data(%d)"', $_GET['mid']) ?>>
		<div class="container-fluid">
			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="jumbotron">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="alert alert-warning" id="user_warn" role="alert" style="display:none;"></div>
							<div class="alert alert-danger" id="user_alerts" role="alert" style="display:none;"></div>
						</div>

						<div class="row">
							<div class="col-lg-12" id="menu_data">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-2 col-sm-offset-2 col-xs-offset-0">
								<form class="form-inline">
									<div class="form-group">
										<label for="category_name">Название раздела: </label>
										<input type="text" class="form-control" id="category_name" placeholder="Название раздела">
										<button type="button" name="submit" class="btn btn-success btn-md" 
												<?php printf('onclick="try_add_menu_category(%d)"', $_GET['mid']) ?>>Добавить раздел</button>
									</div>
								</form>
							</div>
						</div>

					</div>
				</div>

				


			</div>
		</div>

	</body>
</html>