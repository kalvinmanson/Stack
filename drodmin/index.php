<?php 
/*
 ************************************************************
 Drodmin V2.1.0
 Desarrollado por Droni.co
 CopyLeft 2014
 ************************************************************
*/
session_start(); include("includes/funciones.php"); include("includes/db.php");
if(isset($_GET['do']) && $_GET['do'] == "logout") { session_destroy(); }
if(!permitir("Dronico,Admin", $_SESSION['User']['rol'])) { header('Location: login.php');}
	//Usuario
	$m = new mysql();
	$usuario_log = $m->query("SELECT * FROM dro_users WHERE username = '".$_SESSION['User']['username']."'");
if(isset($_GET['o']) && is_file("dro-".$_GET['o'].".php")) { $file="dro-".$_GET['o'].".php"; } else { $file="dro-home.php"; }
//Contorl de excucion
$execute = 1;
include($file);
?><!DOCTYPE html>
<html lang="es">
  <head>
    <title>Drodmin v2.1.0</title>
    <meta charset="utf-8">
    <meta name="author" content="Droni.co">
    <meta name="generator" content="Drodmin V2.1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="editor/ckeditor.js" charset="utf-8"></script>
	<script type="text/javascript" src="editor/ckfinder/ckfinder.js" charset="utf-8"></script>

    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/jquery.fancybox.css" rel="stylesheet" media="screen">
    <link href="../css/main.css" rel="stylesheet" media="screen">
    <style type="text/css">
		<!--
		body {
			margin-top:60px;
			font-size:12px;
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			font:"Trebuchet MS", Arial, Helvetica, sans-serif;
			font-style:normal;
			}
		-->
	</style>
  </head>
  <body>
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
      <a class="navbar-brand" href="/drodmin">Drodmin v2.1.0</a>
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
            <li><a href="?o=rotas">Rotador</a></li>
            <li><a href="?o=cats">Categorías</a></li>
            <li><a href="?o=logs">Logs</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="?do=logout"><i class="glyphicon glyphicon-log-out"></i> Salir</a></li>
      </ul>
      <form class="navbar-form navbar-right" role="search" action="index.php">
        <div class="form-group">
          <input type="text" class="form-control" name="q" placeholder="Buscar registros" required>
        </div>
        <input type="hidden" name="o" value="buscar">
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



	<div class="container">
	    <?php
		//Contorl de excucion
		$execute = 2;
		include($file);
		?>
        
    <footer>
	    <hr>
	    <p>&copy; <a href="http://droni.co" title="Desarrollo Inteligente">Droni.co 2014</a></p>
    </footer>

    </div>
    
    <script src="../js/jquery-2.0.2.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script src="../js/jquery.fancybox.pack.js"></script>
    <script src="../js/drodmin.js"></script>
  </body>
</html>