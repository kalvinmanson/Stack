<?php 
/*
 ************************************************************
 Drodmin V2.2.1
 Desarrollado por Droni.co
 CopyLeft 2016
 ************************************************************
*/
session_start(); 
include("../includes/funciones.php"); 
include("../includes/config.php");
include("../includes/db.php");
if(isset($_GET['do']) && $_GET['do'] == "logout") { 
  session_destroy();
  session_start(); 
  $_SESSION['alert_tipo'] = "success";
  $_SESSION['alert'] = "Ha salido del sistema de manera correcta."; 
  header('Location: login.php');  die();
}
if(!permitir("Dronico,Admin", $_SESSION['User']['rol'])) { header('Location: login.php'); die(); }
	//Usuario
	$m = new mysql();
	$usuario_log = $m->query("SELECT * FROM dro_users WHERE username = '".$_SESSION['User']['username']."'");

  //set vars
  $full = 0;
if(isset($_GET['o']) && is_file("dro-".$_GET['o'].".php")) { $file="dro-".$_GET['o'].".php"; } else { $file="dro-home.php"; }
//Contorl de excucion
$execute = 1;
include($file);
?><!DOCTYPE html>
<html lang="es">
  <head>
    <title>Drodmin v2.2.1</title>
    <meta charset="utf-8">
    <meta name="author" content="Droni.co">
    <meta name="generator" content="Drodmin V2.2.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="/drodmin/editor/ckeditor.js" charset="utf-8"></script>

    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/bootstrap-material-design.min.css" rel="stylesheet" media="screen">
    <link href="/css/ripples.min.css" rel="stylesheet" media="screen">
    <link href="/css/jquery.fancybox.css" rel="stylesheet" media="screen">
    <link href="/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="/css/drodmin.css" rel="stylesheet" media="screen">
  </head>
  <body <?php if($full == 1) { echo 'class="full"'; }?>>
  <?php if($full == 0) { ?>
    <hr><hr>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/drodmin">Drodmin v2.2.1</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li<?php if(isset($_GET['o']) && $_GET['o'] == 'conts') { echo ' class="active"';} ?>><a href="?o=conts">Contenidos</a></li>
          <li<?php if(isset($_GET['o']) && $_GET['o'] == 'posts') { echo ' class="active"';} ?>><a href="?o=posts">Posts</a></li>
          <li class="dropdown <?php if(isset($_GET['o']) && $_GET['o'] == 'users') { echo ' active';} ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sistema <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="?o=users">Usuarios</a></li>
              <li><a href="?o=cats">Categorías</a></li>
              <li><a href="?o=logs">Logs</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="?do=logout"><i class="glyphicon glyphicon-log-out"></i> Salir</a></li>
        </ul>
        
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <?php } ?>



	<div class="container">
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


	    <?php
		//Contorl de excucion
		$execute = 2;
		include($file);
		?>
  </div>
  <?php if($full == 0) { ?>
  <footer>
    <div class="container">
      <p><?php echo $config['site_footer']; ?></p>
    </div>
  </footer>
  <?php } ?>
    
    <script src="/js/jquery-1.12.3.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/ripples.min.js"></script>
    <script src="/js/material.min.js"></script>
    <script src="/js/jquery.fancybox.pack.js"></script>
    <script src="/js/drodmin.js"></script>
  </body>
</html>