<?php
	require_once('system_inits.php'); 

	if (!isset($_SESSION['uid']))
		header('Location: index.php');
	else if (!$_GET['company_id']) 
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

		<title>Редактирование работников</title>

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
			var curr_role = null;

			function get_company_data(company_id) {
				var user_warn = document.getElementById('user_warn');
				var company_data = document.getElementById('company_data');

				user_warn.style.display = 'none';
				
				$.post("get_company_data.php", { company_id:company_id },  
    				function(data) {

    					if (data == 'NO WORKERS') {
    						user_warn.style.display = '';
    						user_warn.innerHTML = 'Вы ещё не создали ни одного работника';
    						menu_data.innerHTML = "";
    					} else {
    						company_data.innerHTML = data;
    					}

          			});
			}

			function try_add_worker(company_id) {
				var alerts = 
					document.getElementById("user_alerts");
			   	var worker_name = 
			   		document.getElementById('worker_name').value;
			   	var worker_passwd = 
			   		document.getElementById('worker_passwd').value;
			   	var worker_role = 
			   		document.getElementById('role_dropdown').value;
	
			   	alerts.style.display = "none";

			   	$.post("try_add_worker.php", { company_id: company_id, 
			   		worker_name: worker_name, worker_passwd: worker_passwd,
			   		worker_role:worker_role },  
    				function(data) {
            			if (data != "OK") {
             				alerts.style.display = "";
              				alerts.innerHTML = data;
            			} 

            			get_company_data(company_id);
          			});

			   	
			}

			function set_role(role, value) {
				var role_dropdown = document.getElementById('role_dropdown')

				if (curr_role != null)
					curr_role.style.display = '';

				curr_role = role;

				role.style.display = 'none';
				role_dropdown.innerHTML = role.innerHTML + 
					'<span class="caret"></span>';
				role_dropdown.value = value;
			}

			function set_worker_role(role, value, worker_id) {
				var worker_role_dropdown = document.getElementById(
					'worker' + worker_id + '_role_dropdown');
				var worker_dropdown_menu = document.getElementById(
					'worker' + worker_id + '_dropdown_menu');
				var menu_elements = worker_dropdown_menu.children;
				var curr_value = worker_role_dropdown.value;

				worker_role_dropdown.innerHTML = role.innerHTML + 
					'<span class="caret"></span>';

				worker_role_dropdown.value = value;
			
				for (var i = 0; i < menu_elements.length; i++)
					menu_elements[i].style.display = (menu_elements[i].id ==
						value) ? 'none' : '';
					
			}

			function try_update_worker(company_id, worker_id) {
				var alerts = 
					document.getElementById("user_alerts");
				var role = document.getElementById('worker' + worker_id + 
					'_role_dropdown').value;
				var worker_passwd = document.getElementById(
					'worker' + worker_id + '_passwd').value;

				alerts.style.display = 'none';

				$.post("try_update_worker.php", { worker_id: worker_id, 
					worker_role: role, worker_passwd: worker_passwd },
					function (data) {
						if (data != '') {
							alerts.style.display = "";
              				alerts.innerHTML = data;
						}

						get_company_data(company_id);
					});

			}

			function delete_worker(company_id, worker_id) {
				$.post("delete_worker.php", { worker_id: worker_id },
					function (data) {
						get_company_data(company_id);
					});
			}
		</script>
	</head>

	<body <?php printf('onload="get_company_data(%d)"', $_GET['company_id']) ?>>
		<div class="container-fluid">
			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="jumbotron">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="alert alert-warning" id="user_warn" 
								role="alert" style="display:none;"></div>
							<div class="alert alert-danger" id="user_alerts" 
								role="alert" style="display:none;"></div>
						</div>

						<div class="row">
							<div class="col-lg-12" id="company_data">
							</div>
						</div>

						<form class="form">
								
								<label for="worker_name">
									Имя работника: 
								</label>
								<input type="text" class="form-control" 
									id="worker_name" 
									placeholder="Имя работника">
								
								<label for="worker_passwd">
									Пароль работника: 
								</label>
								<input type="password" class="form-control" 
									id="worker_passwd" 
									placeholder="Пароль работника">
								<small>
										Пароль должен состоять как минимум из 
										семи латнских букв, 
                    					как минимум одна из которых заглавная 
                    					и одна строчная.
                    			</small><br>  
								
								<div class="dropdown">
									<button id="role_dropdown"
										class="btn btn-default dropdown-toggle" 
										type="button" id="dropdownMenu1" 
										data-toggle="dropdown" 
										aria-haspopup="true" 
										aria-expanded="true">
										Роль работника
										<span class="caret"></span>
									</button>
									
									<ul class="dropdown-menu" 
										aria-labelledby="dropdownMenu1">
										<li>
											<a href="#" 
												onclick="set_role(this, 
													'waiter')">
												Официант
											</a>
										</li>
										<li>
											<a href="#"
												onclick="set_role(this, 
													'admin')">
												Администратор зала
											</a>
										</li>
										<li>
											<a href="#"
											onclick="set_role(this, 'cook')">
											Повар
										</a>
										</li>
									</ul>
								</div>
								
								<button type="button" name="submit" 
									class="btn btn-success btn-md" 
									<?php printf('onclick="try_add_worker(%d)"', 
											$_GET['company_id']) ?>
									style="margin-top:1%">
									Добавить работника
								</button>
						</form>

					</div>
				</div>

				


			</div>
		</div>

	</body>
</html>