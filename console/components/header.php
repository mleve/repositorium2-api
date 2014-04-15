<?php
	session_start();
?>
<div class="row clearfix" id="row-header">
		<div class="col-md-4 column">
			<img src="img/logo.png" class="img-responsive" id="img-logo"/>
		</div>
		<div class="col-md-8 column login-header text-right">
			<?php 
				if(isset($_SESSION['user'])){
					echo '<span style="color:white;">';
						echo 'Hola '.$_SESSION['user']->username;
					echo '</span>';
					echo '<a href="exit.php" class="btn btn-primary btn-lg active" role="button">Log out</a>';
				}
				else{
			?>			
					<form class="form-inline" role="login">
					  <div class="form-group">
					    <label for="inputEmail3" class="sr-only">Username</label>
					      <input name="username" type="text" class="form-control" id="inputEmail3" placeholder="username">
					    
					  </div>
					  <div class="form-group">
					    <label for="inputPassword3" class="sr-only">Password</label>
					    

					      <input name="password"
					      	type="password" class="form-control" id="inputPassword3" placeholder="Password">
					    
					  </div>
				      <button id="loginBtn" type="submit" class="btn btn-default">Sign in</button>
					  <span style="color:white;">or</span>
				  	  <a class="btn btn-primary btn-lg active" role="button" href="login.php"> sign up</a>
					</form>
			<?php 
				}
			?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default" role="navigation">
				<!--
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="#">Brand</a>
				</div>
				-->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a href="#">Console</a>
						</li>
						<li>
							<a href="#">What is Repositorium?</a>
						</li>
						<li>
							<a href="#">How Repositorium works</a>
						</li>
						<li>
							<a href="#">Contact us</a>
						</li>
						
					</ul>
				</div>
				
			</nav>
		</div>
	</div>
	<script type="text/javascript">
	  $("#loginBtn").click(function(event){
	    event.preventDefault();
	    var form = $(this).parent();
	    var url = "";
	    if(form.attr("role") == "login")
	      url = "./RepositoriumConnector/login.php";
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