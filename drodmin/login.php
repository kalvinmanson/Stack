<?php 
/*
 ************************************************************
 Drodmin V2.1.0
 Desarrollado por Droni.co
 CopyLeft 2014
 ************************************************************
*/
session_start(); 
include("../includes/funciones.php"); 
include("../includes/config.php");
include("../includes/db.php");
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

        $_SESSION['alert_tipo'] = "info";
        $_SESSION['alert'] = "Bienvenido de a Drodmin."; 
        header('Location: index.php');  die();
	}
	else {
		$_SESSION['alert_tipo'] = "danger";
        $_SESSION['alert'] = "Error de usuario o contraseña."; 
        header('Location: login.php');  die();
	}
}
?><!DOCTYPE html>
<html lang="es">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Drodmin v2.2.0</title>
    <meta name="author" content="Droni.co">
    <meta name="generator" content="Drodmin V2.2.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/bootstrap-material-design.min.css" rel="stylesheet" media="screen">
    <link href="/css/ripples.min.css" rel="stylesheet" media="screen">
    <link href="/css/jquery.fancybox.css" rel="stylesheet" media="screen">
    <link href="/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="/css/animate.css" rel="stylesheet" media="screen">
    <link href="/css/main.css" rel="stylesheet" media="screen">
    <style>
    .logo-login {
        background-color: #CCCCCC;
        margin: 25px auto 25px auto;
        padding: 15px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
    }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <img src="http://droni.co/img/logo-dronico.png" class="img-responsive logo-login">
            
            <?php //alert
            if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])) { 
            if(isset($_SESSION['alert_tipo']) && !empty($_SESSION['alert_tipo'])) { $alert_tipo  = $_SESSION['alert_tipo']; } else { $alert_tipo = "default"; } ?>
                <div class="alert alert-<?php echo $alert_tipo ; ?> alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?php echo $_SESSION['alert']; ?>
                </div>
            <?php 
            $_SESSION['alert'] = "";
            $_SESSION['alert_tipo'] = "";
            } ?>
            <div class="panel panel-default">
              <div class="panel-heading">Ingresar</div>
              <div class="panel-body">
                <form name="login" id="login" method="post" action="">
                  <fieldset>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su usuario" required>
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-raised">Entrar</button>
                  </fieldset>
                </form>
                </div>
            </div>
            <hr>
            <footer>
            <p><?php echo $config['site_footer']; ?></p>
            </footer>
        </div>
    </div> 
</div>
</body>
</html>