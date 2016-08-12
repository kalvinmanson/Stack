<?php 
    session_start(); 
    include("includes/config.php"); 
    include("includes/funciones.php"); 
    include("includes/db.php"); 
	
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
    <link href="/css/bootstrap-material-design.min.css" rel="stylesheet" media="screen">
    <link href="/css/ripples.min.css" rel="stylesheet" media="screen">
    <link href="/css/jquery.fancybox.css" rel="stylesheet" media="screen">
    <link href="/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="/css/animations.css" rel="stylesheet" media="screen">
    <link href="/css/main.css" rel="stylesheet" media="screen">
  </head>
  <body>
  	<div class="container">
    	<header>
            <div class='animatedParent'>
                <h1>Titulo del sitio <i class="fa fa-android animated flip"></i></h1>
            </div>
            <nav>
            	<ul class="nav nav-justified nav-tabs">
                	<li><a href="/">Home</a></li>
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


    <script src="/js/jquery-1.12.3.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/ripples.min.js"></script>
    <script src="/js/material.min.js"></script>
    <script src="/js/jquery.fancybox.pack.js"></script>
    <script src="/js/css3-animate-it.js"></script>
    <script src="/js/main.js"></script>

  </body>
</html>