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

    <title>Register</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <script src="jquery-3.1.0.min.js"></script>

    <script type="text/javascript">
      function try_register() {
        var email = document.forms["reg_form"]["email"].value;
        var passwd = document.forms["reg_form"]["passwd"].value;
        var user_type = document.forms["reg_form"]["user_type"].value;

        alerts.innerHTML = "";
        alerts.style.display = "none";

        $.post("try_register.php", { email:email, passwd:passwd, user_type:user_type },  
                function(data) {
                  if (data != "OK") {
                    alerts.style.display = "";
                    alerts.innerHTML = data;
                  } else 
                    window.location.href = "index.php";
                });
          
      }
    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-5 col-md-offset-4 col-sm-7 col-sm-offset-3 col-xs-12">
          
          <form name="reg_form" method="post">
            <div class="jumbotron">
           
              <div class="alert alert-danger" role="alert" id="alerts" style="display:none;"></div>
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Email">
              <label for="passwd">Пароль</label>
              <input type="password" class="form-control" name="passwd" placeholder="Пароль">
              <small>Пароль должен состоять как минимум из семи латнских букв, 
                      как минимум одна из которых заглавная и одна строчная.</small>
              <br>            

              <div class="row" style="margin-top:10%">
                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-3 col-xs-offset-4">
                  <input type="radio" name="user_type" value="owner" id="owner">Владелец
                  <input type="radio" name="user_type" value="worker" id="worker">Работник
                </div>
              </div>
              
              <div class="row" style="margin-top:10%">
                <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-4">
                  <button type="button" name="submit" class="btn btn-success btn-lg" 
                          onclick="try_register()">Подтвердить</button>
                </div>
              </div>

            </div>

          </form>

        </div>
      </div>
    </div>
  </body>
</html>
