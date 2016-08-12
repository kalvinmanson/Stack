<?php
//Execute control
if($execute == 1) {
  $o = "pictures";
  $full = "1";
	
	//MOSTRAR CONTENIDOS
  $contenido = $m->query("SELECT * FROM dro_conts WHERE id = ".$_GET['cont_id']);
  if(!isset($contenido[0])) {
    echo "No se encontro contenido";  die();
  }
	$registros = $m->query("SELECT * FROM dro_pictures WHERE cont_id = ".$contenido[0]['dro_conts']['id']." ORDER BY orden ASC");
	
	if(isset($_GET['id']) && $_GET['id'] > 0) {
		$registro = $m->query("SELECT * FROM dro_pictures WHERE id = '".$_GET['id']."'");
	}
	
	//AGREGAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "add") {
	$query = sprintf("INSERT INTO dro_pictures (cont_id, name, created, modified) VALUES (%s, %s, %s, %s)",
	   nosqlinj($contenido[0]['dro_conts']['id'], "int"),
     nosqlinj($_POST['name'], "text"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"));
	   
	$lastid = $m->execute($query);
		if($lastid > 0) {
			
			//Log
			$logmsg = "Registro agregado: ".$_POST['name']." | ID: ".$lastid;
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
      header('Location: index.php?o='.$o.'&a=edit&id='.$lastid.'&cont_id='.$contenido[0]['dro_conts']['id']);  die();
		}
	}
	//EDITAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "edit" && $_POST['id'] > 0) {
	$query = sprintf("UPDATE dro_pictures SET name=%s, picture=%s, content=%s, link=%s, modified=%s WHERE id=%s",
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($_POST['picture'], "text"),
     nosqlinj($_POST['content'], "text"),
     nosqlinj($_POST['link'], "text"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj($registro[0]['dro_pictures']['id'], "int"));
	   
	$lastid = $m->execute($query);
			
			//Log
			$logmsg = "Registro editado: ".$_POST['name']." | ID: ".$_POST['id'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
      header('Location: index.php?o='.$o.'&cont_id='.$contenido[0]['dro_conts']['id']);  die();
	}
  //CAMBIAR ORDEN
  if(isset($_GET['orden']) && $registro[0]['dro_pictures']['id'] > 0) {
    $orden = $registro[0]['dro_pictures']['orden'];
    if($_GET['orden'] == "mas") { $orden = $registro[0]['dro_pictures']['orden'] + 1; }
    if($_GET['orden'] == "menos") { $orden = $registro[0]['dro_pictures']['orden'] - 1; }
  $query = sprintf("UPDATE dro_pictures SET orden = %s WHERE id=%s",
     nosqlinj($orden, "int"),
     nosqlinj($registro[0]['dro_pictures']['id'], "int"));
     
  $lastid = $m->execute($query);
      
      header('Location: index.php?o='.$o.'&cont_id='.$contenido[0]['dro_conts']['id']);  die();
  }
	//ELIMINAR CONTENIDO
	if(isset($_POST['dell']) && $_POST['dell'] > 0) {
		$result = $m->delete('dro_pictures','id='.$_POST['dell']);
		
		//Log
			$logmsg = "Registro eliminado ID: ".$_POST['dell'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
      header('Location: index.php?o='.$o.'&cont_id='.$contenido[0]['dro_conts']['id']);  die();
	}
	
} //Execute control
if($execute == 2) { ?>
<?php if(isset($_GET['a']) && $_GET['a'] == "edit") { ?>
<form action="" name="editar" id="editar" method="POST">
  <div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control input-lg" name="name" id="name" required value="<?php echo $registro[0]['dro_pictures']['name']; ?>">
  </div>
  <div class="form-group">
    <label for="picture">Imagen (opcional)</label>
    <input type="text" class="form-control ckfile" name="picture" id="picture" value="<?php echo $registro[0]['dro_pictures']['picture']; ?>" readonly>
    <?php if(!empty($registro[0]['dro_pictures']['picture'])) { ?>
    	<a href="<?php echo $registro[0]['dro_pictures']['picture']; ?>" class="btn btn-default fancyb"><i class="glyphicon glyphicon-picture"> </i> Imagen actual: <?php echo $registro[0]['dro_pictures']['picture']; ?></a>
    <?php } ?>
  </div>
  <div class="form-group">
    <label for="content">Contenido</label>
    <textarea name="content" class="form-control" id="content" rows="10"><?php echo $registro[0]['dro_pictures']['content']; ?></textarea>
  </div>
  <div class="form-group">
    <label for="link">Link</label>
    <input type="text" class="form-control" name="link" id="link" value="<?php echo $registro[0]['dro_pictures']['link']; ?>">
  </div>
  <input type="hidden" name="form" value="edit">
  <input name="id" type="hidden" id="id" value="<?php echo $registro[0]['dro_pictures']['id']; ?>">
  <div class="clearfix"></div>
  <button type="submit" class="btn btn-inverse btn-raised pull-right"><i class="fa fa-save"></i> Guardar</button>
</form>
<?php } elseif(isset($_GET['a']) && $_GET['a'] == "dell") { ?>
<form action="" name="borrar" method="post">
	<fieldset>
    	<legend>Eliminar</legend>
        <p>Si borra este registro no podra ser recuperado.<br />
        Registro: <strong><?php echo $registro[0]['dro_pictures']['name']; ?></strong></p>
        
        <input type="hidden" name="dell" value="<?php echo $registro[0]['dro_pictures']['id']; ?>" />
        <input type="submit" class="btn btn-danger" value="Eliminar" />
    </fieldset>
</form>
<?php } else { ?>


<h5>Imagenes para: <?php echo $contenido[0]['dro_conts']['name']; ?></h5>
<form action="" name="agregar" id="agregar" method="POST" class="form-inline">
    <div class="form-group">
      <label for="name">Nombre</label>
      <input type="text" class="form-control" name="name" id="name" required>
    </div>
    <input type="hidden" name="form" value="add">
    <button type="submit" class="btn btn-inverse btn-raised"><i class="fa fa-save"></i> Agregar</button>
</form>

<?php if(count($registros) > 0) { ?>
<table class="table table-striped">
  <thead>
    <tr>
      <th width="20">ID</th>
      <th width="20">Orden</th>
      <th width="20"></th>
      <th width="150">Fecha</th>
      <th>Nombre</th>
      <th>Imagen</th>
      <th width="100"></th>
    </tr>
  </thead>
   
  <?php foreach($registros as &$registro) { ?>
    <tr>
      <td align="center"><?php echo $registro['dro_pictures']['id']; ?></td>
      <td align="center"><?php echo $registro['dro_pictures']['orden']; ?></td>
      <td align="center">
        <div class="btn-group" role="group" style="margin: 0;">
          <a href="index.php?o=<?php echo $o; ?>&orden=menos&id=<?php echo $registro['dro_pictures']['id']; ?>&cont_id=<?php echo $contenido[0]['dro_conts']['id']; ?>" class="btn btn-xs btn-raised btn-default"><i class="fa fa-angle-up"></i></a>
          <a href="index.php?o=<?php echo $o; ?>&orden=mas&id=<?php echo $registro['dro_pictures']['id']; ?>&cont_id=<?php echo $contenido[0]['dro_conts']['id']; ?>" class="btn btn-xs btn-raised btn-default"><i class="fa fa-angle-down"></i></a>
        </div>
      </td>
      <td><small><?php echo $registro['dro_pictures']['created']; ?><br><?php echo $registro['dro_pictures']['modified']; ?></small></td>
      <td><?php echo $registro['dro_pictures']['name']; ?></td>
      <td><a href="<?php echo $registro['dro_pictures']['picture']; ?>" class="fancyb btn btn-xs btn-raised btn-default"><i class="fa fa-picture"></i> <?php echo $registro['dro_pictures']['picture']; ?></a></td>
      <td width="140">
        <div class="btn-group" role="group">
          <a href="<?php echo $registro['dro_pictures']['link']; ?>" target="_blank" class="btn btn-xs btn-raised btn-default"><i class="fa fa-globe"></i></a>
          <a href="index.php?o=<?php echo $o; ?>&a=edit&id=<?php echo $registro['dro_pictures']['id']; ?>&cont_id=<?php echo $contenido[0]['dro_conts']['id']; ?>" class="btn btn-warning btn-xs btn-raised"><i class="glyphicon glyphicon-pencil"></i></a> 
          <a href="index.php?o=<?php echo $o; ?>&a=dell&id=<?php echo $registro['dro_pictures']['id']; ?>&cont_id=<?php echo $contenido[0]['dro_conts']['id']; ?>" class="btn btn-danger btn-xs btn-raised"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
      </td>
    </tr>
  <?php } ?>
</table>
<?php } else { ?>
  <p align="center">No hay registros disponibles.</p>
<?php } ?>



<?php } }  ?>