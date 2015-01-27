<?php 
/*
 ************************************************************
 Drodmin V2.1.0
 Desarrollado por Droni.co
 CopyLeft 2014
 ************************************************************
*/
session_start(); include("includes/funciones.php"); include("includes/db.php");
if(isset($_POST['username']) && isset($_POST['password'])) {
	$m = new mysql();
	$query = sprintf("SELECT * FROM dro_users WHERE username = %s AND password = %s",
		nosqlinj($_POST['username'], "text"),
		nosqlinj(sha1($_POST['password']), "text"));
	$usuario_tr = $m->totalrows($query);
	if($usuario_tr == 1) {
		$usuario = $m->query($query);
		$_SESSION['User']['username'] = $usuario[0]['dro_users']['username'];
		$_SESSION['User']['rol'] = $usuario[0]['dro_users']['rol'];
		header('Location: index.php');
	}
	else {
		$error = 1;
	}
}
?><!DOCTYPE html>
<html lang="es">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Drodmin v2.1.0</title>
    <meta name="author" content="Droni.co">
    <meta name="generator" content="Drodmin V2.1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/jquery.fancybox.css" rel="stylesheet" media="screen">
	<style>
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .loginbox {
            width:450px;
            padding:20px;
            margin:auto; 
            background-color:#FFF;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="loginbox">
<center><img src="http://droni.co/img/logo-dronico.png"></center><br>
<?php if(isset($error) && $error == 1) { ?>
	<p class="text-error">Usuario o password incorrectos.</p>
<?php } ?>
<br>

<form name="login" id="login" method="post" action="">
  <fieldset>
    <legend>Ingresar</legend>
    <div class="form-group">
      <label for="exampleInputEmail">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su usuario" required>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su password" required>
    </div>
    <button type="submit" class="btn btn-default">Entrar</button>
  </fieldset>
</form>
<hr>
    <footer>
    <p>&copy; <a href="http://droni.co" title="Desarrollo Inteligente">Droni.co 2014</a></p>
    </footer>
</div> 
</body>
</html>