<?php 
	require_once('system_inits.php'); 
	if (!isset($_SESSION['uid']))
		header('Location: index.php');

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

		<title>User page</title>

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
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		<script type="text/javascript">
			var WORKSPACES = {COMPANIES:'workspace_сompanies',
				MENUS:'workspace_menus', 
				CLIENT_CARDS:'workspace_client_cards',
				workspace_controls: 
					{'workspace_сompanies':{controls: 'company_controls'}, 
					'workspace_menus':{controls:'menu_controls'}, 
					'workspace_client_cards':{controls:
						'client_cards_controls'}}};
			var curr_workspace = WORKSPACES.COMPANIES;

			function set_workspace(workspace) {
				var workspaces = document.getElementById('workspaces').children;
				var controls = document.getElementById('controls').children;

				curr_workspace = workspace.id;

				for (var i = 0; i < workspaces.length; i++)
					if (workspaces[i].id == curr_workspace)
						workspaces[i].className = "list-group-item active";
					else 
						workspaces[i].className = "list-group-item";

				var controls_name = WORKSPACES.
					workspace_controls[curr_workspace].controls;

				for (var i = 0; i < controls.length; i++)
					if (controls[i].id == controls_name)
						controls[i].style.display = '';
					else if (controls[i].id != 'alerts' && controls[i].id != 
						'data_list')
						controls[i].style.display = 'none';

				try_get_data();
			}
			
    		function try_get_data() {
    			var user_warn = document.getElementById('user_warn');
    			var data_list = document.getElementById('data_list');

    			data_list.innerHTML = '';
    			user_warn.style.display = 'none';
    			if (curr_workspace == WORKSPACES.MENUS)
    				$.get("try_get_menus.php", 
    						function (data) {
    							if (data == "NO MENUS") {
    								user_warn.style.display = '';
    								user_warn.innerHTML = 'Вы ещё не создали ни одного меню';
    							} else										
    								data_list.innerHTML = data;
    						});
    			else if (curr_workspace == WORKSPACES.COMPANIES)
    				$.get("try_get_companies.php", 
    						function (data) {
    							if (data == "NO COMPANIES") {
    								user_warn.style.display = '';
    								user_warn.innerHTML = 'Вы ещё не создали ни одного предприятия';
    							} else										
    								data_list.innerHTML = data;
    						});
    			else
    				$.get("try_get_clients.php", 
    						function (data) {
    							if (data == "NO CLIENTS") {
    								user_warn.style.display = '';
    								user_warn.innerHTML = 'Вы ещё не добавили ещё ни одного клиента';
    							} else										
    								data_list.innerHTML = data;
    						});


    		}

			function try_add_company() {
    			var alerts = document.getElementById("user_alerts");
			   	var name = document.getElementById('company_name').value.trim();
			   	alerts.style.display = "none";
			  
			   	$.post("try_add_company.php", { name:name },  
    				function(data) {
            			if (data != "OK") {
             				alerts.style.display = "";
              				alerts.innerHTML = data;
            			} else 
            				try_get_data();
          			});

			   	
    		}

    		function try_add_menu() {
    			var alerts = document.getElementById("user_alerts");
			   	var name = document.getElementById('menu_name').value.trim();
			   	alerts.style.display = "none";
			  
			   	$.post("try_add_menu.php", { name:name },  
    				function(data) {
            			if (data != "OK") {
             				alerts.style.display = "";
              				alerts.innerHTML = data;
            			} else 
            				try_get_data();
          			});

			   	
    		}



    		function delete_menu(mid) {
       			$.post("delete_menu.php", {mid:mid}, 
    				function(data){
    					try_get_data();			
    				});
    			
    		}

    		function delete_company(company_id) {
       			$.post("delete_company.php", {company_id:company_id}, 
    				function(data){
    					try_get_data();			
    				});
    			
    		}

    		function edit_company(company_id) {
    			window.location.href = 'edit_company.php?company_id=' + 
    									company_id;
    		}

    		function edit_menu(mid) {
    			window.location.href = 'edit_menu.php?mid='+mid;
    		}

    		function try_set_menu(company_id, menu_id) {
    			$.post("try_set_menu.php", {company_id:company_id, 
    						menu_id:menu_id},
    					function(data) {
    						if (data != 'ERROR') {
    							var menu_dropdown = 
    								document.getElementById('menu_dropdown_' 
    														+ company_id);
    								menu_dropdown.innerHTML = data;
    						}
    					})
    		}

    		function delete_company(company_id) {
       			$.post("delete_company.php", {company_id:company_id}, 
    				function(data){
    					try_get_data();			
    				});
    			
    		}

    		function try_add_client() {
    			var alerts = document.getElementById("user_alerts");
    			var client_name = document.getElementById('client_name').value;
    			var card_number = document.getElementById('card_number').value;
    			var discount = document.getElementById('discount').value;

    			alerts.style.display = 'none';
    			$.post("try_add_client.php", { client_name: client_name, 
    				card_number: card_number, discount: discount },  
    				function(data) {
            			if (data != "OK") {
             				alerts.style.display = "";
              				alerts.innerHTML = data;
            			} else 
            				try_get_data();
            			
          			});
    		}

    		function delete_client(client_id) {
       			$.post("delete_client.php", {client_id: client_id}, 
    				function(data){
    					try_get_data();			
    				});
    			
    		}
		</script>
	</head>

	<body onload="try_get_data()">
		<div class="container-fluid">
			<div class="row">

				<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
					<div class="jumbotron">
						
						<div class="list-group" id="workspaces">
							<button type="button" id="workspace_сompanies" class="list-group-item active"
									onclick="set_workspace(this)">Предприятия</button>
							<button type="button" id="workspace_menus" class="list-group-item" 
									onclick="set_workspace(this)">Мои меню</button>
							<button type="button" id="workspace_client_cards" class="list-group-item"
									onclick="set_workspace(this)"> Карты клиентов</button>
						</div>

					</div>
				</div>

				<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
				
					<div id="controls" class="jumbotron">
						<div id="alerts" class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="alert alert-warning" id="user_warn" role="alert" style="display:none;"></div>
								<div class="alert alert-danger" id="user_alerts" role="alert" style="display:none;"></div>
							</div>
						</div>

						<ul id='data_list' class="list-group"></ul>

						<!-- Company controls -->
						<div id="company_controls" class="row" style="display:;">
							<div class="col-lg-offset-4 col-md-offset-2 col-sm-offset-2 col-xs-offset-0">
								<form class="form-inline">
									<div class="form-group">
										<label for="company_name">Название предприятия: </label>
										<input type="text" class="form-control" id="company_name" placeholder="Название предприятия">
										<button type="button" name="submit" class="btn btn-success btn-md" 
												onclick="try_add_company()">Добавить предприятие</button>
									</div>
								</form>
							</div>
						</div>

						<!-- Menus controls -->
						<div id="menu_controls" class="row" style="display:none;">
							<div class="col-lg-offset-4 col-md-offset-2 col-sm-offset-2 col-xs-offset-0">
								<form class="form-inline">
									<div class="form-group">
										<label for="menu_name">Название меню: </label>
										<input type="text" class="form-control" id="menu_name" placeholder="Название меню">
										<button type="button" name="submit" class="btn btn-success btn-md" 
												onclick="try_add_menu()">Добавить меню</button>
									</div>
								</form>
							</div>
						</div>

						<!-- Client cards controls -->
						<div id="client_cards_controls" class="row" 
							style="display:none;">
							<form class="form">
								<div class="form-group">
									<label for="client_name">
										Имя клиента: 
									</label>
									<input type="text" class="form-control" 
										id="client_name" 
										placeholder="Имя клиента">
									<label for="card_number">
										Номер карты: 
									</label>
									<input type="text" class="form-control" 
										id="card_number" 
										placeholder="Номер карты">
									<label for="discount">
										Скидка: 
									</label>
									<input type="text" class="form-control" 
										id="discount" 
										placeholder="Скидка">
									<small>15% записывается как 0.15</small>
									<br>
									<button type="button" name="submit" 
										class="btn btn-success btn-md" 
										onclick="try_add_client()"
										style="margin-top:1%">
										Добавить клиента
									</button>
								</div>
							</form>
						</div>

					</div>

				</div>
			</div>
		</div>

	</body>
</html>