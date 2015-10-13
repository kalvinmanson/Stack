<?php session_start(); include("drodmin/includes/config.php"); include("drodmin/includes/funciones.php"); include("drodmin/includes/db.php"); 
//setear idioma
	if(isset($_GET['lang']) && is_file("drodmin/includes/lang-".$_GET['lang'].".php")) { $_SESSION['lang'] = $_GET['lang']; include("drodmin/includes/lang-".$_GET['lang'].".php");} 
	elseif(isset($_SESSION['lang']) && is_file("drodmin/includes/lang-".$_SESSION['lang'].".php")){ include("drodmin/includes/lang-".$_SESSION['lang'].".php"); }
	else { include("drodmin/includes/lang-es.php"); } //$lang['id'] = "es"
	
	$m = new mysql();
	//loguear usuario
	if(isset($_SESSION['User']['username']) && !empty($_SESSION['User']['username'])) { $logged = $m->query("SELECT * FROM dro_users WHERE username = '".$_SESSION['User']['username']."'"); }
	
	if(isset($_GET['dro']) && is_file("dro-".$_GET['dro'].".php")) { $file = "dro-".$_GET['dro'].".php"; }
	else { $file = "dro-home.php"; } 
	$execute = 1;
	include($file); 
?><!DOCTYPE html>
<html lang="es">
  <head>
    <title><?php echo $dro_titulo; ?></title>
	<meta name="description" content="<?php echo $dro_descripcion; ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/roboto.min.css" rel="stylesheet">
    <link href="/css/material.min.css" rel="stylesheet">
    <link href="/css/ripples.min.css" rel="stylesheet">
    <link href="/css/material-fullpalette.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="/css/jquery.fancybox.css" rel="stylesheet" media="screen">
    <link href="/css/animate.min.css" rel="stylesheet" media="screen">
    <link href="/css/main.css" rel="stylesheet" media="screen">
    <?php echo $config['site_metas']; ?>
  </head>
  <body>
  	<div class="container">
    	<header>
        <h1 class="animated flip" style="display:inline-block;">Titulo del sitio <i class="fa fa-android"></i></h1>
        <nav>
        	<ul class="nav nav-justified">
            	<li><a href="/" class="btn btn-primary">Home</a></li>
            	<li><a href="/blog">Blog</a></li>
            	<li><a href="/contacto">Contacto</a></li>
            	<li><a href="/users">Usuarios</a></li>
            </ul>
        </nav>
        </header>
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
    	<?php $execute = 2; include($file); ?>
        <footer>
        	<?php echo $config['site_footer']; ?>
        </footer>
        <pre>
        <?php  
		  $vars = get_defined_vars();
		  print_r($vars);  
		?>
        </pre>
    </div>


    <script src="/js/jquery-2.0.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/ripples.min.js"></script>
    <script src="/js/material.min.js"></script>
    <script src="/js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script src="/js/jquery.fancybox.pack.js"></script>
    <script src="/js/main.js"></script>

  </body>
</html>