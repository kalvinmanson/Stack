<?php
//Execute control
if($execute == 1) {
	$m = new mysql();
	$o = "users";
	
	//MOSTRAR CONTENIDOS
	//buscar contenidos
	$fq = "WHERE rol != 'Dronico'";
	if(isset($_GET['q']) && !empty($_GET['q'])) { $fq = " WHERE rol != 'Dronico' AND (username LIKE '%".$_GET['q']."%' OR email LIKE '%".$_GET['q']."%' OR name LIKE '%".$_GET['q']."%')"; }
	//paginador
	if(isset($_GET['page']) && $_GET['page'] > 1) { $page = $_GET['page'];} else { $page = 1; }
		$paginar = 10;
		$paginaini = ($page - 1) * $paginar;
		$paginall = $m->totalrows('SELECT id FROM dro_users'.$fq);
		$totalpages = ceil($paginall / $paginar);
		if($page > 1) { $prevlink = $page - 1; } else { $prevlink = "0"; }
		if($page < $totalpages) { $nextlink = $page + 1; } else { $nextlink = "0"; }
		//fin paginador 
	$registros = $m->query("SELECT * FROM dro_users ".$fq." ORDER BY modified DESC LIMIT ".$paginaini.", ".$paginar);
	
	if(isset($_GET['id']) && $_GET['id'] > 0) {
		$registro = $m->query("SELECT * FROM dro_users WHERE id = '".$_GET['id']."'");
	}
	
	$countries = $m->query("SELECT * FROM dro_countries ORDER BY name ASC");
	
	//AGREGAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "add") {
	$query = sprintf("INSERT INTO dro_users (username, password, email, country_id, rol, city, name, birthdate, adress, phone, lang, active, created, modified) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	   nosqlinj($_POST['username'], "text"),
	   nosqlinj(sha1($_POST['password']), "text"),
	   nosqlinj($_POST['email'], "text"),
	   nosqlinj($_POST['country_id'], "int"),
	   nosqlinj($_POST['rol'], "text"),
	   nosqlinj($_POST['city'], "text"),
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($_POST['birthdate'], "date"),
	   nosqlinj($_POST['adress'], "text"),
	   nosqlinj($_POST['phone'], "text"),
	   nosqlinj($_POST['lang'], "text"),
	   nosqlinj($_POST['active'], "int"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"));
	   
	
	$lastid = $m->execute($query);
		if($lastid > 0) {
			
			//Log
			$logmsg = "Registro agregado: ".$_POST['username']." | ID: ".$lastid;
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
			header('Location: index.php?o='.$o.'&m=1');
		}
	}
	//EDITAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "edit" && $_POST['id'] > 0) {
		if(!empty($_POST['npassword'])) { $password = sha1($_POST['npassword']); } else { $password = $registro[0]['dro_users']['password']; }
	$query = sprintf("UPDATE dro_users SET username=%s, password=%s, email=%s, country_id=%s, rol=%s, city=%s, name=%s, birthdate=%s, adress=%s, phone=%s, lang=%s, active=%s, modified=%s WHERE id=%s",
	   nosqlinj($_POST['username'], "text"),
	   nosqlinj($password, "text"),
	   nosqlinj($_POST['email'], "text"),
	   nosqlinj($_POST['country_id'], "int"),
	   nosqlinj($_POST['rol'], "text"),
	   nosqlinj($_POST['city'], "text"),
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($_POST['birthdate'], "date"),
	   nosqlinj($_POST['adress'], "text"),
	   nosqlinj($_POST['phone'], "text"),
	   nosqlinj($_POST['lang'], "text"),
	   nosqlinj($_POST['active'], "int"),
	   nosqlinj($_POST['modified'], "date"),
	   nosqlinj($_POST['id'], "int"));
	   
	$lastid = $m->execute($query);
			
			//Log
			$logmsg = "Registro editado: ".$_POST['username']." | ID: ".$_POST['id'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, create) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
	header('Location: index.php?o='.$o.'&m=2');
	}
	//ELIMINAR CONTENIDO
	if(isset($_POST['dell']) && $_POST['dell'] > 0) {
		$result = $m->delete('dro_users','id='.$_POST['dell']);
		
		//Log
			$logmsg = "Registro eliminado ID: ".$_POST['dell'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, create) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
		header('Location: index.php?o='.$o.'&m=3');
	}
	
	
} //Execute control
if($execute == 2) { ?>
<form method="get" username="buscar" class="pull-right form-inline">
<div class="form-group">
	<label class="sr-only" for="q">Buscar</label>
  <input name="q" id="q" class="form-control" type="text">
</div>
  <input type="hidden" name="o" value="<?php echo $o; ?>" />
  <input type="submit" class="btn" value="Buscar!">
  <a href="index.php?o=<?php echo $o; ?>&a=add" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Agregar</a>
</form>
<h4>Usuarios</h4>
<div class="clearfix"></div>
<?php if(isset($_GET['a']) && $_GET['a'] == "add") { ?>
<form action="" username="agregar" id="agregar" method="POST" enctype="multipart/form-data">
  <fieldset>
    <legend>Agregar</legend>
    <div class="form-group">
      <label for="username">Usuario</label>
      <input type="text" class="form-control" name="username" id="username"  placeholder="Nombre de usuario sin espacio ni caracteres extraños" required autocomplete="off">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password"  placeholder="Password de entre 5 y 15 caracteres" required autocomplete="off">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" name="email" id="email"  placeholder="Correo Electrónico valido" required>
    </div>
    <div class="form-group">
      <label for="rol">Rol</label>
      <select name="rol" class="form-control">
      	<option value="User">Usuario</option>
        <option value="Admin">Administrador</option>
      </select>
    </div>
    <div class="form-group">
      <label for="email">País</label>
      <select name="country_id" class="form-control">
      	<?php foreach($countries as &$country) { ?>
        	<option value="<?php echo $country['dro_countries']['id']; ?>"><?php echo $country['dro_countries']['name']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="city">Ciudad</label>
      <input type="text" class="form-control" name="city" id="city"  placeholder="Ciudad del usuario">
    </div>
    <div class="form-group">
      <label for="adress">Dirección</label>
      <input type="text" class="form-control" name="adress" id="adress"  placeholder="Dirección">
    </div>
    <div class="form-group">
      <label for="name">Nombre completo</label>
      <input type="text" class="form-control" name="name" id="name"  placeholder="Nombre completo y apellidos del usuario">
    </div>
    <div class="form-group">
      <label for="birthdate">Fecha de nacimiento</label>
      <input type="date" class="form-control" name="birthdate" id="birthdate"  placeholder="Fecha de nacimiento">
    </div>
    <div class="form-group">
      <label for="phone">Teléfono</label>
      <input type="tel" class="form-control" name="phone" id="phone"  placeholder="Teléfono">
    </div>
    <div class="form-group">
    	<label for="lang">Idioma</label>
    	<select name="lang" class="form-control">
        	<option value="es">Español (es)</option>
        	<option value="en">English (en)</option>
        </select>
    </div>
    <div class="form-group">
        <label>
          <input type="checkbox" name="active" value="1"> Usuario Activo
        </label>
    </div>
    <input type="hidden" name="form" value="add">
    <button type="submit" value="Agregar" class="btn btn-default">Agregar</button>
  </fieldset>
</form>
<?php } elseif(isset($_GET['a']) && $_GET['a'] == "edit") { ?>
<form action="" username="editar" id="editar" method="POST" enctype="multipart/form-data" autocomplete="off">
  <fieldset>
    <legend>Editar</legend>
    <div class="form-group">
      <label for="username">Usuario</label>
      <input type="text" class="form-control" name="username" id="username" value="<?php echo $registro[0]['dro_users']['username']; ?>" required autocomplete="off">
    </div>
    <div class="form-group">
      <label for="npassword">Password</label>
      <input type="password" class="form-control" name="npassword" id="npassword" value="" placeholder="Dejar en blanco para mantener el actual" autocomplete="off"><p class="help-block">Dejar en blanco para mantener el actual.</p>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" name="email" id="email"  value="<?php echo $registro[0]['dro_users']['email']; ?>" required>
    </div>
    <div class="form-group">
      <label for="rol">Rol</label>
      <select name="rol" class="form-control">
      	<option value="User"<?php if($registro[0]['dro_users']['rol'] == "User") { echo " selected"; } ?>>Usuario</option>
        <option value="Admin"<?php if($registro[0]['dro_users']['rol'] == "Admin") { echo " selected"; } ?>>Administrador</option>
      </select>
    </div>
    <div class="form-group">
      <label for="email">País</label>
      <select name="country_id" class="form-control">
      	<?php foreach($countries as &$country) { ?>
        	<option value="<?php echo $country['dro_countries']['id']; ?>"<?php if($registro[0]['dro_users']['country_id'] == $country['dro_countries']['id']) { echo " selected"; } ?>><?php echo $country['dro_countries']['name']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="city">Ciudad</label>
      <input type="text" class="form-control" name="city" id="city"  value="<?php echo $registro[0]['dro_users']['city']; ?>">
    </div>
    <div class="form-group">
      <label for="adress">Dirección</label>
      <input type="text" class="form-control" name="adress" id="adress"  value="<?php echo $registro[0]['dro_users']['adress']; ?>">
    </div>
    <div class="form-group">
      <label for="name">Nombre completo</label>
      <input type="text" class="form-control" name="name" id="name"  value="<?php echo $registro[0]['dro_users']['name']; ?>">
    </div>
    <div class="form-group">
      <label for="birthdate">Fecha de nacimiento</label>
      <input type="date" class="form-control" name="birthdate" id="birthdate"  value="<?php echo $registro[0]['dro_users']['birthdate']; ?>">
    </div>
    <div class="form-group">
      <label for="phone">Teléfono</label>
      <input type="tel" class="form-control" name="phone" id="phone"  value="<?php echo $registro[0]['dro_users']['phone']; ?>">
    </div>
    <div class="form-group">
    	<label for="lang">Idioma</label>
    	<select name="lang" class="form-control">
        	<option value="es"<?php if($registro[0]['dro_users']['lang'] == "es") { echo 'selected'; } ?>>Español (es)</option>
        	<option value="en"<?php if($registro[0]['dro_users']['lang'] == "en") { echo 'selected'; } ?>>English (en)</option>
        </select>
    </div>
    <div class="form-group">
        <label>
          <input type="checkbox" name="active" value="1"<?php if($registro[0]['dro_users']['active'] == 1) { echo " checked"; } ?>> Usuario Activo
        </label>
    </div>
    <input type="hidden" name="form" value="edit">
    <input name="id" type="hidden" id="id" value="<?php echo $registro[0]['dro_users']['id']; ?>">
    <button type="submit" value="Agregar" class="btn btn-default">Guardar</button>
  </fieldset>
</form>
<?php } elseif(isset($_GET['a']) && $_GET['a'] == "dell") { ?>
<form action="" username="borrar" method="post">
	<fieldset>
    	<legend>Eliminar</legend>
        <p>Si borra este registro no podra ser recuperado.<br />
        Registro: <strong><?php echo $registro[0]['dro_users']['username']; ?></strong></p>
        
        <input type="hidden" name="dell" value="<?php echo $registro[0]['dro_users']['id']; ?>" />
        <input type="submit" class="btn btn-danger" value="Eliminar" />
    </fieldset>
</form>
<?php } else { ?>
<?php if(isset($_GET['m'])) { ?>			
<blockquote>
  <p class="text-success">
		<?php 
			if($_GET['m'] == "1") { echo "Registro <strong>Agregado</strong> con éxito";} 
			if($_GET['m'] == "2") { echo "Registro <strong>Editado</strong> con éxito";} 
			if($_GET['m'] == "3") { echo "Registro <strong>Eliminado</strong> con éxito";}
		?> 
  </p>
</blockquote>
<?php } ?>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table table-hover">
  <thead>
                <tr>
					<th width="20">ID</th>
					<th>Fecha</th>
                    <th>Idioma</th>
					<th>Nombre</th>
					<th>Usuario</th>
					<th>Email</th>
					<th width="100"></th>
				</tr>
                </thead>
				<?php if(count($registros) > 0) { ?>
                <?php foreach($registros as &$registro) { ?>
                  <tr>
                    <td align="center"><?php echo $registro['dro_users']['id']; ?></td>
                    <td><small><?php echo $registro['dro_users']['created']; ?><br>
					<?php echo $registro['dro_users']['modified']; ?></small></td>
                    <td><?php echo $registro['dro_users']['lang']; ?></td>
                    <td><?php echo $registro['dro_users']['name']; ?></td>
                    <td><?php echo $registro['dro_users']['username']; ?></td>
                    <td><?php echo $registro['dro_users']['email']; ?></td>
                    <td width="140">
                      <div class="btn-group" role="group">
                        <a href="../ver-<?php echo $registro['dro_users']['slug']; ?>.html" target="_blank" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> 
                        <a href="index.php?o=<?php echo $o; ?>&a=edit&id=<?php echo $registro['dro_users']['id']; ?>" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil"></i></a> 
                        <a href="index.php?o=<?php echo $o; ?>&a=dell&id=<?php echo $registro['dro_users']['id']; ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
                  <tr>
                  	<td colspan="7">
                          <ul class="pagination">
                            <?php if($prevlink > 0){ echo '<li><a href="?o='.$o.'&page='.$prevlink.'">Prev</a></li>'; } else { echo '<li class="disabled"><a>Prev</a></li>'; } ?>
                            <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
                            <?php if($page == $i) {  echo '<li class="disabled"><a>'.$i.'</a></li>'; } else { ?>
                            <li><a href="?o=<?php echo $o; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>
                            <?php }	?>
                            <?php if($nextlink > 0){ echo '<li><a href="?o='.$o.'&page='.$nextlink.'">Next</a></li>'; } else { echo '<li class="disabled"><a>Next</a></li>'; } ?>
                          </ul>
                    </td>
                  </tr>
				<?php } else { ?>
                <tr>
				  <td colspan="7">Aun no hay registros agregados</td>
  				</tr>
                <?php } ?>
</table>	 
<?php } }  ?>