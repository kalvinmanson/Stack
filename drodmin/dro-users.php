<?php
//Execute control
if($execute == 1) {
	$o = "users";
	
	//MOSTRAR CONTENIDOS
	//buscar contenidos
	$fq = "WHERE rol != 'Dronico'";
	$q = "";
	if(isset($_GET['q']) && !empty($_GET['q'])) { $fq = " WHERE rol != 'Dronico' AND (username LIKE '%".$_GET['q']."%' OR email LIKE '%".$_GET['q']."%' OR name LIKE '%".$_GET['q']."%')"; }
	//paginador
	if(isset($_GET['page']) && $_GET['page'] > 1) { $page = $_GET['page'];} else { $page = 1; }
		$paginar = 20;
		$paginaini = ($page - 1) * $paginar;
		$paginall = $m->totalrows('SELECT * FROM dro_users '.$fq);
		$totalpages = ceil($paginall / $paginar);
		if($page > 1) { $prevlink = $page - 1; } else { $prevlink = "0"; }
		if($page < $totalpages) { $nextlink = $page + 1; } else { $nextlink = "0"; }
		//fin paginador 
	$registros = $m->query("SELECT * FROM dro_users ".$fq." ORDER BY dro_users.modified DESC LIMIT ".$paginaini.", ".$paginar);
	
	if(isset($_GET['id']) && $_GET['id'] > 0) {
		$registro = $m->query("SELECT * FROM dro_users WHERE id = '".$_GET['id']."'");
	}
	
	//AGREGAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "add") {
		//validar username
		$val_slug = $m->query("SELECT * FROM dro_users WHERE (username = '".amigable(trim($_POST['username']))."' OR username = '".trim($_POST['email'])."')");
		if(count($val_slug) > 0) {
      $_SESSION['alert_tipo'] = "danger";
      $_SESSION['alert'] = "El nombre de usuario o email ya existe."; 
      header('Location: index.php?o='.$o);  die();
    }
	$query = sprintf("INSERT INTO dro_users (username, password, email, rol, name, created, modified) VALUES (%s, %s, %s, %s, %s, %s, %s)",
	   nosqlinj(amigable(trim($_POST['username'])), "text"),
     nosqlinj(sha1($_POST['password']), "text"),
     nosqlinj(trim($_POST['email']), "text"),
     nosqlinj($_POST['rol'], "text"),
     nosqlinj($_POST['name'], "text"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"));
	   
	$lastid = $m->execute($query);
		if($lastid > 0) {
			
			//Log
			$logmsg = "Registro agregado: ".$_POST['name']." | ID: ".$lastid;
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
			$_SESSION['alert_tipo'] = "success";
      $_SESSION['alert'] = "Registro <strong>Agregado</strong> con éxito."; 
      header('Location: index.php?o='.$o.'&a=edit&id='.$lastid);  die();
		}
	}
	//EDITAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "edit" && $_POST['id'] > 0) {
    //Cambiar password
    if(!empty($_POST['password_new'])) { $pass_save = sha1($_POST['password_new']); } else { $pass_save = $registro[0]['dro_users']['password'];}
	$query = sprintf("UPDATE dro_users SET password=%s, email=%s, country_id=%s, rol=%s, city=%s, name=%s, birthdate=%s, adress=%s, phone=%s, modified=%s WHERE id=%s",
     nosqlinj($pass_save, "text"),
     nosqlinj(trim($_POST['email']), "text"),
     nosqlinj($_POST['country_id'], "text"),
     nosqlinj($_POST['rol'], "text"),
     nosqlinj($_POST['city'], "text"),
     nosqlinj($_POST['name'], "text"),
     nosqlinj($_POST['birthdate'], "text"),
     nosqlinj($_POST['adress'], "text"),
     nosqlinj($_POST['phone'], "text"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj($registro[0]['dro_users']['id'], "int"));
	   
	$lastid = $m->execute($query);
			
			//Log
			$logmsg = "Registro editado: ".$_POST['name']." | ID: ".$_POST['id'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
      $_SESSION['alert_tipo'] = "success";
      $_SESSION['alert'] = "Registro <strong>Editado</strong> con éxito."; 
      header('Location: index.php?o='.$o);  die();
	}
	//ELIMINAR CONTENIDO
	if(isset($_POST['dell']) && $_POST['dell'] > 0) {
		$result = $m->delete('dro_users','id='.$_POST['dell']);
		
		//Log
			$logmsg = "Registro eliminado ID: ".$_POST['dell'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
		  $_SESSION['alert_tipo'] = "success";
      $_SESSION['alert'] = "Registro <strong>Eliminado</strong> con éxito."; 
      header('Location: index.php?o='.$o);  die();
	}

  //listados
  $countries = $m->query("SELECT * FROM dro_countries ORDER BY name ASC");
	
} //Execute control
if($execute == 2) { ?>

<?php if(isset($_GET['a']) && $_GET['a'] == "edit") { ?>
<form action="" name="editar" id="editar" method="POST">
  <fieldset>
    <legend>Editar</legend>

    <div class="form-group">
      <label for="password_new">Password</label>
      <input type="password" class="form-control" name="password_new" id="password_new" placeholder="Dejar en blanco para mantener el actual.">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" name="email" id="email" value="<?php echo $registro[0]['dro_users']['email']; ?>" autocomplete="off" required>
    </div>
    <div class="form-group">
      <label for="rol">Rol</label>
      <select name="rol" class="form-control">
        <option value="User"<?php if($registro[0]['dro_users']['rol'] == "User") { echo " selected"; } ?>>Usuario</option>
        <option value="Admin"<?php if($registro[0]['dro_users']['rol'] == "Admin") { echo " selected"; } ?>>Administrador</option>
      </select>
    </div>
    <div class="form-group">
      <label for="country_id">País</label>
      <select name="country_id" class="form-control">
        <?php foreach($countries as &$country) { ?>
          <option value="<?php echo $country['dro_countries']['id']; ?>"<?php if($registro[0]['dro_users']['country_id'] == $country['dro_countries']['id']) { echo " selected"; } ?>><?php echo $country['dro_countries']['name']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="city">Ciudad</label>
      <input type="text" class="form-control" name="city" id="city" value="<?php echo $registro[0]['dro_users']['city']; ?>">
    </div>
    <div class="form-group">
      <label for="adress">Dirección</label>
      <input type="text" class="form-control" name="adress" id="adress"  value="<?php echo $registro[0]['dro_users']['adress']; ?>">
    </div>
    <div class="form-group">
      <label for="name">Nombre completo</label>
      <input type="text" class="form-control input-lg" name="name" id="name"  value="<?php echo $registro[0]['dro_users']['name']; ?>">
    </div>
    <div class="form-group">
      <label for="birthdate">Fecha de nacimiento</label>
      <input type="date" class="form-control" name="birthdate" id="birthdate"  value="<?php echo $registro[0]['dro_users']['birthdate']; ?>">
    </div>
    <div class="form-group">
      <label for="phone">Teléfono</label>
      <input type="tel" class="form-control" name="phone" id="phone"  value="<?php echo $registro[0]['dro_users']['phone']; ?>">
    </div>
    <input type="hidden" name="form" value="edit">
    <input name="id" type="hidden" id="id" value="<?php echo $registro[0]['dro_users']['id']; ?>">
    <button type="submit" class="btn btn-success btn-raised"><i class="fa fa-save"></i> Guardar</button>
  </fieldset>
</form>
<?php } elseif(isset($_GET['a']) && $_GET['a'] == "dell") { ?>
<form action="" name="borrar" method="post">
	<fieldset>
    	<legend>Eliminar</legend>
        <p>Si borra este registro no podra ser recuperado.<br />
        Registro: <strong><?php echo $registro[0]['dro_users']['name']; ?></strong></p>
        
        <input type="hidden" name="dell" value="<?php echo $registro[0]['dro_users']['id']; ?>" />
        <input type="submit" class="btn btn-danger" value="Eliminar" />
    </fieldset>
</form>
<?php } else { ?>

<form method="get" name="buscar" class="pull-right form-inline">
<div class="form-group">
  <label class="sr-only" for="q"><i class="fa fa-search"></i> Buscar</label>
  <input name="q" id="q" class="form-control" type="text">
</div>
  <input type="hidden" name="o" value="<?php echo $o; ?>" />
  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> BUSCAR</button>
  <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><i class="glyphicon glyphicon-plus"></i> Agregar</a>
</form>
<h4>Usuarios</h4>
<div class="clearfix"></div>

<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="ModalAddLabel">
  <div class="modal-dialog" role="document">
    <form action="" name="agregar" id="agregar" method="POST" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalAddLabel">Agregar</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario" autocomplete="off" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña del usuario" autocomplete="off" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" id="email"  placeholder="Correo electrónico" autocomplete="off" required>
        </div>
        <div class="form-group">
          <label for="rol">Rol</label>
          <select name="rol" class="form-control">
            <option value="User">Usuario</option>
            <option value="Admin">Administrador</option>
          </select>
        </div>
        <div class="form-group">
          <label for="name">Nombre</label>
          <input type="text" class="form-control" name="name" id="name"  placeholder="Titulo del contenido" required>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="form" value="add">
        <button type="submit" class="btn btn-success btn-raised"><i class="fa fa-save"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>
<!-- End Modal -->

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table table-hover">
  <thead>
    <tr>
			<th width="20">ID</th>
			<th width="150">Fecha</th>
			<th>Nombre</th>
			<th>Email</th>
			<th></th>
		</tr>
  </thead>
	<?php if(count($registros) > 0) { 
  foreach($registros as &$registro) { ?>
    <tr>
      <td align="center"><?php echo $registro['dro_users']['id']; ?></td>
      <td><small><?php echo $registro['dro_users']['created']; ?><br><?php echo $registro['dro_users']['modified']; ?></small></td>
      <td><?php echo $registro['dro_users']['username']; ?><br /><small><?php echo $registro['dro_users']['name']; ?></small></td>
      <td><?php echo $registro['dro_users']['email']; ?></td>
      <td width="140" align="right">
        <div class="btn-group" role="group">
          <a href="index.php?o=<?php echo $o; ?>&a=edit&id=<?php echo $registro['dro_users']['id']; ?>" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil"></i></a> 
          <a href="index.php?o=<?php echo $o; ?>&a=dell&id=<?php echo $registro['dro_users']['id']; ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
      </td>
    </tr>
  <?php } ?>
  <?php if($totalpages > 1) { ?>
    <tr>
    	<td colspan="6">
        <nav>
          <ul class="pagination">
            <?php if($prevlink > 0){ echo '<li><a href="?o='.$o.'&page='.$prevlink.'&q='.$q.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>'; } else { echo '<li class="disabled"><a aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>'; } ?>
            
            <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
              <?php if($page == $i) {  echo '<li class="disabled"><a>'.$i.'</a></li>'; } else { ?>
              <li><a href="?o=<?php echo $o; ?>&page=<?php echo $i; ?>&q=<?php echo $q; ?>"><?php echo $i; ?></a></li>
              <?php } ?>
              <?php } ?>
              <?php if($nextlink > 0){ echo '<li><a href="?o='.$o.'&page='.$nextlink.'&q='.$q.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>'; } else { echo '<li class="disabled"><a aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>'; } ?>
          </ul>
        </nav>
      </td>
    </tr>
	<?php } } ?>
</table>	 
<?php } }  ?>