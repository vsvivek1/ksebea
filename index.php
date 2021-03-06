<!DOCTYPE html>
<html lang="en">

  <title>KSEBEA</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="ea1/bootstrap.min.css">
  <script src="ea1/jquery.js"></script>
  <script src="ea1/bootstrap.min.js"></script>

<style>
<?php
require_once __DIR__ . '/content/head.php';

?>	
	
@import url(http://fonts.googleapis.com/css?family=Roboto);

/****** LOGIN MODAL ******/
.loginmodal-container {
  padding: 30px;
  max-width: 350px;
  width: 100% !important;
  background-color: #F7F7F7;
  margin: 0 auto;
  border-radius: 2px;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  font-family: roboto;
}

.loginmodal-container h1 {
  text-align: center;
  font-size: 1.8em;
  font-family: roboto;
}

.loginmodal-container input[type=submit] {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  position: relative;
}

.loginmodal-container input[type=text], input[type=password] {
  height: 44px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 10px;
  -webkit-appearance: none;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  /* border-radius: 2px; */
  padding: 0 8px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.loginmodal-container input[type=text]:hover, input[type=password]:hover {
  border: 1px solid #b9b9b9;
  border-top: 1px solid #a0a0a0;
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.loginmodal {
  text-align: center;
  font-size: 14px;
  font-family: 'Arial', sans-serif;
  font-weight: 700;
  height: 36px;
  padding: 0 8px;
/* border-radius: 3px; */
/* -webkit-user-select: none;
  user-select: none; */
}

.loginmodal-submit {
  /* border: 1px solid #3079ed; */
  border: 0px;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1); 
  background-color: #4d90fe;
  padding: 17px 0px;
  font-family: roboto;
  font-size: 14px;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
}

.loginmodal-submit:hover {
  /* border: 1px solid #2f5bb7; */
  border: 0px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #357ae8;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
}

.loginmodal-container a {
  text-decoration: none;
  color: #666;
  font-weight: 400;
  text-align: center;
  display: inline-block;
  opacity: 0.6;
  transition: opacity ease 0.5s;
} 

.login-help{
  font-size: 12px;
}



</style>

<style>
.siemens{
    background-image: url('siemens.jpg');
    height: 700px; width: 100%; border: 1px solid black;
}

</style>


</head>
<!-- <a href="#" data-toggle="modal" data-target="#login-modal">Login</a> -->

<body >
<?php
if ('false' === $_GET['login']) {
    echo 'Login failed!';
				

}

?>	
	
<div class="container-fluid">
<nav class="navbar navbar-inverse navbar-fixed-top bg-color:blue">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand bg-pimary text-warning" href="#">EA ACCOUNTING
  	  <i class="fa  fa-2x faa-pulse animated"></i>
        
      </a>
    </div>
  </div>
</nav>
</div>	
	
	
	
<div class="row">
  <div class="col-sm-2"></div>

<div class="col-sm-8" >




<div class="modal show" id="login-modal" tabindex="-1" style="padding-top:200px" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	  <div class="modal-dialog">
				<div class="loginmodal-container">
					<h1>Login </h1><br>
				  <form action="./content/open.php" method=POST>
					<input type="text" name="user" placeholder="Username">
					<input type="password" name="pass" placeholder="Password">
					<input type="submit" name="login" class="login loginmodal-submit" value="Login">
				  </form>
				<!--	
				  <div class="login-help">
					<a href="#">Register</a> - <a href="#">Forgot Password</a>
				  </div>
				  -->
				  
				</div>
			</div>
		  </div>


</div>
<div class="col-sm-2">

<?php //print_r($_SERVER); ?>



</div>

</div>




<div class="container-fluid">
<nav class="navbar navbar-inverse navbar-fixed-bottom">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <i class="fa fa-spanner fa-2x faa-pulse animated"></i>
        
      </a>
    </div>
  </div>
</nav>
</div>



</body>
