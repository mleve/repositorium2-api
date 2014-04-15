<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Repositorium Console</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
</head>

<body>
  <div class="container">
    <?php
      include_once "components/header.php";
    ?>
    <div class="row">
        <div class="col-md-4">
          <form role="login" action="">
            <h2 class="form-signin-heading">Please sign in</h2>
            <input name="username" type="text" class="form-control" placeholder="username"
              required autofocus> 
            <input name="password" type="password" class="form-control"
              placeholder="Password" required> 
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign
              in</button>
          </form>
        </div>

        <div class="col-md-8">
          <form id="videoForm" role="signUp">
            <h2 class="form-signin-heading">new user?, sign up here!</h2>
            <div class="input-group">
              <label for="SignUpUsername" class="input-group-addon">username</label> <input id="SignUpUsername" name="username"
                type="text" class="form-control"
                placeholder="Tu nombre de usuario publico" required>
            </div>
            <br>
            <div class="input-group">
              <label for="SignUpEmail" class="input-group-addon">Email</label> <input
                id="SignUpEmail" name="email" type="text" class="form-control">
            </div>
            <br>
            <div class="input-group">
              <label for="SignUpEmailConfirm" class="input-group-addon">Confirm
                Email</label> <input id="SignUpEmailConfirm" name="emailConfirm"
                type="text" class="form-control">
            </div>
            <br>
            <div class="input-group">
              <label for="SignUpPass" class="input-group-addon">Password</label> <input
                id="SignUpPass" name="password" type="password"
                class="form-control">
            </div>
            <br>
            <div class="input-group">
              <label for="SignUpPassConfirm" class="input-group-addon">Confirm
                password</label> <input id="SignUpPassConfirm"
                name="passwordConfirm" type="password" class="form-control">
            </div>
            <br>
            <div class="input-group">
              <label for="SignUpName" class="input-group-addon">Name</label> <input
                id="SignUpName" name="name" type="text" class="form-control">
            </div>
            <br>
            <div class="input-group">
              <label for="SignUpLastname" class="input-group-addon">Lastname</label>
              <input id="SignUpLastname" name="lastname" type="text"
                class="form-control">
            </div>
            <br>
            <button id="uploadVideo" class="btn btn-lg btn-primary btn-block"
              type="submit">Sign in</button>
          </form>

        </div>
    </div>
  </div>
<script type="text/javascript">
  $(".btn").click(function(event){
    event.preventDefault();
    var form = $(this).parent();
    var url = "";
    if(form.attr("role") == "login")
      url = "./RepositoriumConnector/login.php"
    else
      url = "./RepositoriumConnector/signUp.php"
    var data = form.serialize();
    $.ajax({
      url : url,
      data : data,
      success : function(response){
        var resp = JSON.parse(response);
        if('error' in resp)
          alert(resp.error);
        else{
          window.location = 'index.php';
          return false;   
        }         
      }
    });

    
  });
</script>