<?php //Control de Execucion 
if($execute == 1) {
$re1=""; $re2=""; $re3=""; $re4=""; $re5=""; $re6=""; $cre1=""; $cre2=""; $cre3="";
$form_countries = $m->query("SELECT * FROM dro_countries ORDER BY dro_countries.name ASC");
//logout 
	if(isset($_GET['do']) && $_GET['do'] == "logout") { session_destroy(); header('Location: /users'); die(); }
//loguear usuario
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['form']) && $_POST['form'] == "login") {
	$m = new mysql();
	$query = sprintf("SELECT * FROM dro_users WHERE (username = %s OR email = %s) AND password = %s AND active = 1",
		nosqlinj($_POST['username'], "text"),
		nosqlinj($_POST['username'], "text"),
		nosqlinj(sha1($_POST['password']), "text"));
	$usuario_tr = $m->totalrows($query);
	if($usuario_tr == 1) {
		$usuario = $m->query($query);
		$_SESSION['User']['username'] = $usuario[0]['dro_users']['username'];
		$_SESSION['User']['rol'] = $usuario[0]['dro_users']['rol'];
		$_SESSION['alert_tipo'] = "info";
		$_SESSION['alert'] = "Bienvenido de nuevo ".$usuario[0]['dro_users']['username'];
		if(isset($_POST['loginback'])) { header('Location: '.$_POST['loginback']); die(); }
		else { header('Location: index.php'); die(); } 
	} else {
		$_SESSION['alert_tipo'] = "danger";
		$_SESSION['alert'] = "El nombre de usuario o password es incorrecto."; 
		header('Location: index.php');  die();
	}
}
//Registrar usuario
if(isset($_POST['form']) && $_POST['form'] == "register") {
	$re = array();
	//Valida username
	if(!isset($_POST['username']) || empty($_POST['username']) || strlen($_POST['username']) < 4 || strlen($_POST['username']) > 15 || amigable($_POST['username']) != $_POST['username']) { 
	array_push($re,"El usuario es obligatorio, entre 6 y 15 caracteres sin espacios ni signos."); }
	$existe = $m->totalrows("SELECT * FROM dro_users WHERE username = '".$_POST['username']."'");
	if($existe > 0) { 
	array_push($re,"El usuario ya se encuentra registrado."); }
	//valida email
	if(!isset($_POST['email']) || empty($_POST['email']) || comprobar_email($_POST['email']) == 0) { 
	array_push($re,"El email es obligatorio y debe ser una direccion de correo electrónico valida."); }
	$existe = $m->totalrows("SELECT * FROM dro_users WHERE email = '".$_POST['email']."'");
	if($existe > 0) { 
	array_push($re,"El email ya se encuentra registrado."); }
	//valida password
	if(!isset($_POST['password']) || empty($_POST['password']) || strlen($_POST['password']) < 8 || strlen($_POST['password']) > 15) { 
	array_push($re,"El password es obligatorio, entre 8 y 15 caracteres."); }
	if(!isset($_POST['cpassword']) || empty($_POST['cpassword']) || $_POST['cpassword'] != $_POST['password']) { 
	array_push($re,"La confirmacion no coincide con el password."); }
	
	if(count($re) > 0) {
		$cuerpoalert = "<p>Se presentaron los siguientes problemas:</p><ul>";
		foreach($re as &$rei) {
			$cuerpoalert.= "<li>".$rei."</li>";
		}
		$cuerpoalert.= "</ul>";
		$_SESSION['alert_tipo'] = "danger";
		$_SESSION['alert'] = $cuerpoalert;
		header('Location: /users');  die();
	} else {
		$ahora = date("Y-m-d H:i:s");
		$query = sprintf("INSERT INTO dro_users (username, password, email, country_id, city, name, birthdate, adress, phone, created) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	   nosqlinj(amigable($_POST['username']), "text"),
	   nosqlinj(sha1($_POST['password']), "text"),
	   nosqlinj($_POST['email'], "text"),
	   nosqlinj($_POST['country_id'], "int"),
	   nosqlinj($_POST['city'], "text"),
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($_POST['birthdate'], "date"),
	   nosqlinj($_POST['adress'], "text"),
	   nosqlinj($_POST['phone'], "int"),
	   nosqlinj($ahora, "date"));
	   
	$lastid = $m->execute($query);
	if($lastid > 0) {
		enviar_email($_POST['email'], $_POST['name'], '', 'Confirma tu cuenta en '.$config['sitename'], 'Gracias por registrarte en '.$config['sitename'].', para activar tu cuenta revisa ingresa al siguiente enlace.<p>'.$config['siteurl'].'/activate-'.amigable($_POST['username']).'-'.sha1($ahora).'</p>');
		$_SESSION['alert_tipo'] = "info";
		$_SESSION['alert'] = "Un email de confirmacion ha sido enviado a : ".$_POST['email'];
		 header('Location: /users');  die(); }
	}
}
//Actualizar perfil 
if(isset($_POST['form']) && $_POST['form'] == "perfil" && isset($logged[0]['dro_users']['id']) && $logged[0]['dro_users']['id'] > 0) {
	$query = sprintf("UPDATE dro_users SET country_id=%s, city=%s, name=%s, birthdate=%s, adress=%s, phone=%s, modified=%s WHERE id=%s",
	   nosqlinj($_POST['country_id'], "int"),
	   nosqlinj($_POST['city'], "text"),
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($_POST['birthdate'], "date"),
	   nosqlinj($_POST['adress'], "text"),
	   nosqlinj($_POST['phone'], "text"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj($logged[0]['dro_users']['id'], "int"));
	  
	$lastid = $m->execute($query);
	$_SESSION['alert_tipo'] = "info";
	$_SESSION['alert'] = "Actualizaste tu información de perfil de manera correcta"; 
	header('Location: /users');  die(); 
}
//Cambiar password 
if(isset($_POST['form']) && $_POST['form'] == "password" && isset($logged[0]['dro_users']['id']) && $logged[0]['dro_users']['id'] > 0) {
	$cre = 0;
	//valida password
	if(!isset($_POST['npass0']) || empty($_POST['npass0']) || sha1($_POST['npass0']) != $logged[0]['dro_users']['password']) { 
	$cre = 1; $cre1 = 1; $crm1 = "El password es obligatorio y no coincide con tu password actual."; }
	if(!isset($_POST['npass1']) || empty($_POST['npass1']) || strlen($_POST['npass1']) < 8 || strlen($_POST['npass1']) > 15) { 
	$cre = 1; $cre2 = 1; $crm2 = "El password es obligatorio, entre 8 y 15 caracteres."; }
	if(!isset($_POST['npass1']) || empty($_POST['npass1']) || $_POST['npass1'] != $_POST['npass2']) { 
	$cre = 1; $cre3 = 1; $crm3 = "La confirmacion no coincide con el password."; }
	
	if($cre == 0) {
		$query = sprintf("UPDATE dro_users SET password=%s, modified=%s WHERE id=%s",
		   nosqlinj(sha1($_POST['npass1']), "text"),
		   nosqlinj(date("Y-m-d H:i:s"), "date"),
		   nosqlinj($logged[0]['dro_users']['id'], "int"));
		  
		$lastid = $m->execute($query);
		$_SESSION['alert_tipo'] = "info";
		$_SESSION['alert'] = "Cambiaste el password de tu cuenta de manera correcta. <a href='/logout'>Cerrar sesión</a>"; 
		header('Location: /users');  die(); 
	}
}
//Activar usuario
if(isset($_GET['username']) && !empty($_GET['username']) && isset($_GET['key']) && !empty($_GET['key'])) {
	$usuariovalidar = $m->query("SELECT * FROM dro_users WHERE username = '".$_GET['username']."'");
	if(count($usuariovalidar) > 0 && sha1($usuariovalidar[0]['dro_users']['created']) == $_GET['key']) {
		$query = "UPDATE dro_users SET active=1, modified='".date("Y-m-d H:i:s")."' WHERE id=".$usuariovalidar[0]['dro_users']['id'];
		  
		$lastid = $m->execute($query);
		$_SESSION['alert_tipo'] = "success";
		$_SESSION['alert'] = "Tu cuenta ha sido activada."; 
		header('Location: /users');  die(); 
	}
}
	
//valores genericos
$dro_titulo = "Bienvenido a Droni.co";
$dro_descripcion = "Consulte y administre sus facturas, solicitudes y cotizaciones de manera rapida y eficiente en linea";

} if($execute == 2) { ?>
<?php if(isset($logged[0])) { ?>
<div class="row">
	<div class="col-sm-6">
        <form name="perfil" action="" method="post">
            <div class="form-group<?php if($cre1 == 1) { echo ' form-group has-error'; } ?>">
              <label for="npass0">Password Actual</label>
              <input type="password" class="form-control" name="npass0" required>
            </div>
            <?php if($cre1 == 1) { echo '<p class="text-danger">'.$crm1.'</p>'; } ?>
            <div class="form-group<?php if($cre2 == 1) { echo ' form-group has-error'; } ?>">
              <label for="npass1">Nuevo Password</label>
              <input type="password" class="form-control" name="npass1" required>
            </div>
            <?php if($cre2 == 1) { echo '<p class="text-danger">'.$crm2.'</p>'; } ?>
            <div class="form-group<?php if($cre3 == 1) { echo ' form-group has-error'; } ?>">
              <label for="npass2">Confirma el nuevo password</label>
              <input type="password" class="form-control" name="npass2" required>
            </div>
            <?php if($cre3 == 1) { echo '<p class="text-danger">'.$crm3.'</p>'; } ?>
            <input type="hidden" name="form" value="password">
            <button type="submit" class="btn btn-success btn-block">Cambiar Password</button>
        </form>
        <a href="/logout" class="btn btn-danger">Cerrar Sesion</a>
    </div>
    <div class="col-sm-6">
        <form name="perfil" action="" method="post">
        	<div class="form-group">
              <label for="name">Nombre Completo</label>
              <input type="text" class="form-control" name="name" placeholder="Nombre completo" value="<?php echo $logged[0]['dro_users']['name'];?>" required>
            </div>            
            <div class="form-group">
              <label for="country_id">País</label>
              <select name="country_id" class="form-control">
              <?php foreach($form_countries as &$form_countrie) { ?>
                <option value="<?php echo $form_countrie['dro_countries']['id']; ?>" <?php if($form_countrie['dro_countries']['id'] == $logged[0]['dro_users']['country_id']) { echo 'selected'; } ?>><?php echo $form_countrie['dro_countries']['name']; ?></option>
              <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="city">Ciudad</label>
              <input type="text" class="form-control" name="city" value="<?php echo $logged[0]['dro_users']['city']; ?>" required>
            </div>
            <div class="form-group">
              <label for="adress">Dirección</label>
              <input type="text" class="form-control" name="adress" value="<?php echo $logged[0]['dro_users']['adress'];?>" required>
            </div>
            <div class="form-group">
              <label for="phone">Teléfono</label>
              <input type="text" class="form-control" name="phone" value="<?php echo $logged[0]['dro_users']['phone'];?>" required>
            </div>
            <input type="hidden" name="form" value="perfil">
            <button type="submit" class="btn btn-success btn-block">Actualizar Perfil</button>
        </form>
    </div>
</div>
<?php } else { ?>
<div class="row">
	<div class="col-sm-6">
    	<h3>Login</h3>
        <form role="form" action="" method="post">
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input type="text" class="form-control" name="username" placeholder="Usuario o Email" required>
            </div>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <input type="hidden" name="loginback" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <input type="hidden" name="form" value="login">
          <button type="submit" class="btn btn-default">Entrar</button>
        </form>
    </div>
    <div class="col-sm-6">
    	<h3>Registro</h3>
    	<form role="form" name="register" action="" method="post" autocomplete="off">
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input type="text" class="form-control" name="username" autocomplete="off" placeholder="Usuario" required>
            </div>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
              <input type="email" class="form-control" name="email" autocomplete="off" placeholder="Email" required>
            </div>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
            </div>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input type="password" class="form-control" name="cpassword" placeholder="Confirma tu Password" required>
            </div>
            <div class="form-group">
              <label for="name">Nombre Completo</label>
              <input type="text" class="form-control" name="name" placeholder="Nombre completo" required>
            </div>
            <div class="form-group">
              <label for="name">Fecha de naciemiento</label>
              <input type="date" class="form-control" name="name" required>
            </div>            
            <div class="form-group">
              <label for="country_id">País</label>
              <select name="country_id" class="form-control">
              <?php foreach($form_countries as &$form_countrie) { ?>
                <option value="<?php echo $form_countrie['dro_countries']['id']; ?>"><?php echo $form_countrie['dro_countries']['name']; ?></option>
              <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="city">Ciudad</label>
              <input type="text" class="form-control" name="city" required>
            </div>
            <div class="form-group">
              <label for="adress">Dirección</label>
              <input type="text" class="form-control" name="adress" required>
            </div>
            <div class="form-group">
              <label for="phone">Teléfono</label>
              <input type="text" class="form-control" name="phone" required>
            </div>
            <input type="hidden" name="loginback" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <input type="hidden" name="form" value="register">
          <button type="submit" class="btn btn-default">Registrarme</button>
        </form>
    </div>
</div>
<?php } ?>
    
<?php } ?>