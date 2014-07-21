<?php session_start(); include("drodmin/includes/config.php"); include("drodmin/includes/funciones.php"); include("drodmin/includes/db.php"); $m = new mysql();
	
	//loguear usuario
	if(isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) { $logged = $m->query("SELECT * FROM dro_users WHERE username = '".$_SESSION['usuario']."'"); }
	
	//logout 
	if(isset($_GET['do']) && $_GET['do'] == "logout") { session_destroy();  header('Location: login.html'); die(); }
	//menu
	$menu_cats1 = $m->query("SELECT * FROM dro_cats1 ORDER BY dro_cats1.orden ASC");
	$side_rotas = $m->query("SELECT * FROM dro_rotas WHERE tipo = 'Sidebar' AND active = 1 ORDER BY orden ASC");
	
	//headers
	if(isset($_GET['dro']) && $_GET['dro'] == "noticias") { $header_id = 12; }
	elseif(isset($_GET['dro']) && $_GET['dro'] == "documentos") { $header_id = 13; }
	elseif(isset($_GET['dro']) && $_GET['dro'] == "capacitaciones") { $header_id = 14; }
	elseif(isset($_GET['dro']) && $_GET['dro'] == "contacto") { $header_id = 15; }
	elseif(isset($_GET['dro']) && $_GET['dro'] == "productos") { $header_id = 16; }
	else { $header_id = 0; }
	$header = $m->query("SELECT * FROM dro_rotas WHERE id = ".$header_id);	
	
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
    <script src="js/modernizr.custom.87576.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/jquery.fancybox.css" rel="stylesheet" media="screen">
    <link href="css/animate.min.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
    <?php echo $config['site_metas']; ?>
  </head>
  <body>
<div class="container contenedor">
    <header>
    <a href="index.php" class="logo"><img src="img/logo.jpg"></a>
    <div class="contact-info">
    <p><strong>Labcare de Colombia Ltda.</strong><br> Teléfonos. (57+1) 8985201 - (57+1) 8985202<br>
Email. info@labcarecolombia.com</p>
    </div>
    <form class="navbar-form buscador" role="search">
      <div class="form-group">
        <input type="text" class="form-control btnsearch" placeholder="Buscar" size="40"></div><button type="submit" class="btn btn-default btnbuscar"></button>
    </form>
    <ul class="menuprin">
    	<li><a href="soporte.html">Servicio al Cliente</a>
        </li><li><a href="#">Noticias y Eventos</a>
        	<ul>
           	  <li><a href="noticias.html">Noticias Labcare</a></li>
                <li><a href="eventos.html">Eventos Labcare</a></li>
            </ul>
        </li><li><a href="documentos.html">Documentos</a>
        </li><li><a href="capacitaciones.html">Capacitaciones</a>
        </li><li><a href="ver-certificados.html">Certificaciones</a>
        </li><li><a href="contacto.html">Contáctenos</a>
        </li><li><a href="#" class="last">Sobre Labcare</a>
        	<ul class="lastul">
           	  <li><a href="ver-quienes-somos.html">Quienes Somos</a></li>
                <li><a href="ver-informacion-de-la-compania.html">Información de la compañía</a></li>
                <li><a href="ver-instalaciones.html">Instalaciones</a></li>
            </ul>
        </li>
    </ul>
    </header>
    <div class="clearfix"></div>
    <?php if(!isset($_GET['dro'])) { 
	$home_rotas = $m->query("SELECT * FROM dro_rotas WHERE tipo = 'Home' AND active = 1 ORDER BY orden ASC");
	$home_promo = $m->query("SELECT * FROM dro_rotas WHERE tipo = 'Promo'");
	 ?>
    <div class="row notihome">
	<div class="col-sm-3">
	        <h2><?php echo $home_promo[0]['dro_rotas']['name']; ?></h2>
            <div class="gradivi"></div><br />
	        <img src="t.php?src=contenido/<?php echo $home_promo[0]['dro_rotas']['picture']; ?>&w=255" width="100%" />
            <p><?php echo nl2br($home_promo[0]['dro_rotas']['description']); ?></p>
            <a href="<?php echo $home_promo[0]['dro_rotas']['link']; ?>" class="pull-right btngreen1">Ver detalles</a>
    </div>
    <div class="col-sm-9 nopadding">
	    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
          <?php $iactive = 1; for ($i = 0; $i <= count($home_rotas) - 1; $i++) { ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" <?php if($iactive == 1) { echo 'class="active"'; $iactive = 0; } ?>></li>
          <?php } ?>
          </ol>
        
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
          <?php $ractive = 1; foreach($home_rotas as &$home_rota) { ?>
            <div class="item <?php if($ractive == 1) { echo 'active'; $ractive = 0; } ?>">
              <?php if($home_rota['dro_rotas']['link'] == "#") { ?>
              	<img src="t.php?src=contenido/<?php echo $home_rota['dro_rotas']['picture']; ?>&w=855&h=300" alt="<?php echo $home_rota['dro_rotas']['name']; ?>" width="100%" />
              <?php } else { ?>
              	<a href="<?php echo $home_rota['dro_rotas']['link']; ?>" title="<?php echo $home_rota['dro_rotas']['name']; ?>">
                	<img src="t.php?src=contenido/<?php echo $home_rota['dro_rotas']['picture']; ?>&w=855&h=300" alt="<?php echo $home_rota['dro_rotas']['name']; ?>" width="100%" />
                </a>
              <?php } ?>
            </div>
          <?php } ?>
          </div>
        
          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <img src="img/ar1.png" class="armar" />
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <img src="img/ar2.png" class="armar" />
          </a>
        </div>
    </div>
</div>
	<?php } else { ?>
    <div class="row">
    	<?php if(isset($dro_header) && !empty($dro_header)) { ?>
        <img src="t.php?src=contenido/<?php echo $dro_header; ?>&w=1140" class="img-responsive">
        <?php } else { ?>
        	<?php if(is_file("contenido/".$header[0]['dro_rotas']['picture'])) { ?>
	        <img src="t.php?src=contenido/<?php echo $header[0]['dro_rotas']['picture']; ?>&w=1140" alt="<?php echo $header[0]['dro_rotas']['name']; ?>" class="img-responsive">
            <?php } else { ?>
            <img src="contenido/head-cont.jpg" class="img-responsive">
            <?php } ?>
        <?php } ?>
    </div>
    <?php } ?>
    
<div class="row nopadding">
	<div class="hrdivider"></div>
</div>
    <div class="row">
        <div class="col-sm-3 sidebar">
        	<ul>
            	<li class="titulo">Productos</li>
                <?php //primer nivel
					foreach($menu_cats1 as &$menu_cat1) { ?>
                	<li class="especiales"><?php echo $menu_cat1['dro_cats1']['name']; ?></li>
                    <?php //segundo nivel
						$menu_cats2 = $m->query("SELECT * FROM dro_cats2 WHERE cat1_id = ".$menu_cat1['dro_cats1']['id']." ORDER BY dro_cats2.orden");
						  foreach($menu_cats2 as &$menu_cat2) { ?>
                          <li><a class="asubmenu"><?php echo $menu_cat2['dro_cats2']['name']; ?></a>
                          	<?php //tercer nivel
							$menu_cats3 = $m->query("SELECT * FROM dro_cats3 WHERE cat2_id = ".$menu_cat2['dro_cats2']['id']." ORDER BY dro_cats3.orden");
							if(count($menu_cats3) > 0) {
								echo '<ul style="display:none;">';
								foreach($menu_cats3 as &$menu_cat3) { ?>
									<li><a class="asubmenu"><?php echo $menu_cat3['dro_cats3']['name']; ?></a>
                                    	<?php //tercer nivel
										$menu_pros = $m->query("SELECT * FROM dro_pros WHERE cat3_id = ".$menu_cat3['dro_cats3']['id']." and active = 1 ORDER BY name");
										if(count($menu_pros) > 0) {
											echo '<ul style="display:none;">';
											foreach($menu_pros as &$menu_pro) { ?>
                                            	<li><a href="producto-<?php echo $menu_pro['dro_pros']['slug']; ?>.html"><?php echo $menu_pro['dro_pros']['name']; ?></a></li>
                                            <?php }	echo '</ul>'; } ?>
                                    </li>
								<?php }	echo '</ul>'; } ?>
                          </li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <?php foreach($side_rotas as &$side_rota) { ?>
            	<p><a href="<?php echo $side_rota['dro_rotas']['link']; ?>"><img src="t.php?src=contenido/<?php echo $side_rota['dro_rotas']['picture']; ?>&w=300" class="img-responsive" alt="<?php echo $side_rota['dro_rotas']['name']; ?>"></a></p>
            <?php } ?>
            <?php if(isset($_GET['dro'])) { ?>
            <br>
            <a href="eventos.html" class="bigblock">
                <h3>Regístrese en nuestros eventos</h3>
                <p>Separe su cupo a nuestros eventos y capacitaciones registrándose de forma inmediata.</p>
            </a>
            <br>
            <a href="login.html" class="bigblock">
                <h3>Solicite Certificados</h3>
                <p>Solicite sus certificados de participación de nuestros eventos y capacitaciones.</p>
            </a>
            <?php } ?>
        </div>
        <div class="col-sm-9 content">
        <?php if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])) { ?>
        <div class="alert alert-info alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <strong><?php echo $_SESSION['alert']; ?></strong>
        </div>
        <?php $_SESSION['alert'] = "";} ?>
        	<?php  $execute = 2; include($file);  ?>
        </div>
    </div>
    <footer class="row">
    	<div class="col-sm-3">
        	<h3>Ingresa a tu cuenta</h3>
            <?php if(isset($logged[0]['dro_users']['username']) && !empty($logged[0]['dro_users']['username'])) { ?>
            	<p>Bienvenido <?php echo $logged[0]['dro_users']['name']; ?>,<br>
                Recuerda mantener actualizado tu perfil ingresando la informacion en <a href="login.html">este formulario</a>.</p>
                <a href="logout.html" class="btn btn-danger"><i class="glyphicon glyphicon-log-out"></i> Cerrar sesión</a>
			<?php } else { ?>
            	<form role="form" action="login.html" method="post">
                    <div class="form-group input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                      <input type="text" class="form-control" name="username" placeholder="Usuario o Email">
                    </div>
                    <div class="form-group input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                      <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <input type="hidden" name="loginback" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <input type="hidden" name="form" value="login">
                  <button type="submit" class="btn btn-default">Entrar</button>
                  <a href="login.html" class="btn">¿Es nuevo? Regístrese.</a>
                  <a href="login.html" class="btn">Recordar password.</a>
                </form>
            <?php } ?>
        </div>
        <div class="col-sm-2 blockfoot">
       		<h3>Labcare</h3>
            <ul>
            	<li><a href="soporte.html">Servicio al cliente</a></li>
                <li><a href="noticias.html">Noticias y eventos</a></li>
                <li><a href="documentos.html">Documentos</a></li>
                <li><a href="capacitaciones.html">Capacitaciones</a></li>
                <li><a href="contacto.html">Contáctenos</a></li>
            </ul>
        </div>
        <div class="col-sm-2 blockfoot">
        	<h3>Certificaciones</h3>
            <ul>
            	<li><a href="login.html">Registro</a></li>
                <li><a href="ver-certificados.html">Solicitud de Certificado de Participación RIQAS – MLE</a></li>
            </ul>
        </div>
        <div class="col-sm-2 blockfoot">
        	<h3>Sobre Labcare</h3>
            <ul>
            	<li><a href="ver-quienes-somos.html">Quienes Somos</a></li>
                <li><a href="ver-informacion-de-la-compania.html">Información de la compañía</a></li>
                <li><a href="ver-instalaciones.html">Nuestras Instalaciones</a></li>
            </ul>
            <div class="socialinks">
            	<a href="#"><img src="img/ico-fb.jpg"></a>
                <a href="#"><img src="img/ico-tw.jpg"></a>
                <a href="#"><img src="img/ico-gp.jpg"></a>
                <a href="#"><img src="img/ico-yt.jpg"></a>
            </div>
        </div>
        <div class="col-sm-3 blockfoot">
        <p align="right">
        <img src="img/logo-foot.png" class="img-responsive minilogo">
        </p>
        <p align="right">Labcare de Colombia Ltda.<br>
Autopista Medellín. Km 2.5, Vía Parcelas. Parque Empresarial Portos Sabana 80. Bodega 97.<br>
 Tel. (57+1) 8985201 - (57+1) 8985202<br>
 Fax. (57+1) 8985208<br>
Email. info@labcarecolombia.com</p>
        <?php //echo $config['site_footer']; ?>
        </div>
    </footer>
</div>
<?php /*
  <pre>
  	<?php print_r($_GET); ?>
    ------------------------
    <?php print_r($_POST); ?>
    -----------------------
    <?php print_r($_SESSION); ?>
  </pre>
  */ ?>

    <script src="js/jquery-2.0.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script src="js/jquery.fancybox.pack.js"></script>
    <script src="js/main.js"></script>

  </body>
</html>