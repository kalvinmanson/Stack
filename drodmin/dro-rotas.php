<?php
//Execute control
if($execute == 1) {
	$m = new mysql();
	$o = "rotas";
	
	//MOSTRAR CONTENIDOS
	//buscar contenidos
	$fq = "";
	if(isset($_GET['q']) && !empty($_GET['q'])) { $fq = " WHERE name LIKE '%".$_GET['q']."%'"; }
	//paginador
	if(isset($_GET['page']) && $_GET['page'] > 1) { $page = $_GET['page'];} else { $page = 1; }
		$paginar = 10;
		$paginaini = ($page - 1) * $paginar;
		$paginall = $m->totalrows('SELECT id FROM dro_rotas'.$fq);
		$totalpages = ceil($paginall / $paginar);
		if($page > 1) { $prevlink = $page - 1; } else { $prevlink = "0"; }
		if($page < $totalpages) { $nextlink = $page + 1; } else { $nextlink = "0"; }
		//fin paginador 
	$registros = $m->query("SELECT * FROM dro_rotas ".$fq." ORDER BY modified DESC LIMIT ".$paginaini.", ".$paginar);
	
	if(isset($_GET['id']) && $_GET['id'] > 0) {
		$registro = $m->query("SELECT * FROM dro_rotas WHERE id = '".$_GET['id']."'");
	}
	
	//AGREGAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "add") {
		//cargar archivo
		if(!empty($_FILES['archivo']['tmp_name']) && $_FILES["archivo"]["size"] < 900000) {
			$nombrefile = rand(1000, 9999)."_".amigable($_POST['name'])."".strrchr($_FILES['archivo']['name'],'.');
			move_uploaded_file($_FILES['archivo']['tmp_name'],'../contenido/'.$nombrefile.'');
		} else { $nombrefile = ""; }
	$query = sprintf("INSERT INTO dro_rotas (name, picture, content, orden, link, lang, created, modified) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($nombrefile, "text"),
	   nosqlinj($_POST['content'], "text"),
	   nosqlinj($_POST['orden'], "int"),
	   nosqlinj($_POST['link'], "text"),
	   nosqlinj($_POST['lang'], "text"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"));
	   
	$lastid = $m->execute($query);
		if($lastid > 0) {
			
			//Log
			$logmsg = "Registro agregado: ".$_POST['name']." | ID: ".$lastid;
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
			header('Location: index.php?o='.$o.'&m=1');
		}
	}
	//EDITAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "edit" && $_POST['id'] > 0) {
		if(!empty($_FILES['archivo']['tmp_name']) && $_FILES["archivo"]["size"] < 900000) {
			$nombrefile = rand(1000, 9999)."_".amigable($_POST['name'])."".strrchr($_FILES['archivo']['name'],'.');
			move_uploaded_file($_FILES['archivo']['tmp_name'],'../contenido/'.$nombrefile.'');
		} else { $nombrefile = $_POST['archivo_antiguo']; }
	$query = sprintf("UPDATE dro_rotas SET name=%s, picture=%s, content=%s, orden=%s, link=%s, lang=%s, modified=%s WHERE id=%s",
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($nombrefile, "text"),
	   nosqlinj($_POST['content'], "text"),
	   nosqlinj($_POST['orden'], "int"),
	   nosqlinj($_POST['link'], "text"),
	   nosqlinj($_POST['lang'], "text"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj($_POST['id'], "int"));
	   
	$lastid = $m->execute($query);
			
			//Log
			$logmsg = "Registro editado: ".$_POST['name']." | ID: ".$_POST['id'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
	header('Location: index.php?o='.$o.'&m=2');
	}
	//ELIMINAR CONTENIDO
	if(isset($_POST['dell']) && $_POST['dell'] > 0) {
		$result = $m->delete('dro_rotas','id='.$_POST['dell']);
		unlink('../contenido/'.$registro[0]['dro_rotas']['picture']);
		
		//Log
			$logmsg = "Registro eliminado ID: ".$_POST['dell'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
		header('Location: index.php?o='.$o.'&m=3');
	}
	
	
} //Execute control
if($execute == 2) { ?>
<form method="get" name="buscar" class="pull-right form-inline">
<div class="form-group">
	<label class="sr-only" for="q">Buscar</label>
  <input name="q" id="q" class="form-control" type="text">
</div>
  <input type="hidden" name="o" value="<?php echo $o; ?>" />
  <input type="submit" class="btn" value="Buscar!">
  <a href="index.php?o=<?php echo $o; ?>&a=add" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Agregar</a>
</form>
<h4>Rotador</h4>
<div class="clearfix"></div>
<?php if(isset($_GET['a']) && $_GET['a'] == "add") { ?>

<form action="" name="agregar" id="agregar" method="POST" enctype="multipart/form-data">
  <fieldset>
    <legend>Agregar</legend>
    <div class="form-group">
      <label for="name">Nombre</label>
      <input type="text" class="form-control" name="name" id="name"  placeholder="Titulo del contenido" required="required">
    </div>
    <div class="form-group">
      <label for="archivo">Imagen (opcional)</label>
      <input type="file" class="form-control" name="archivo" id="archivo">
    </div>
    <div class="form-group">
      <label for="content">Descripción</label>
      <textarea name="content" class="form-control" id="content"></textarea>
    </div>
    <div class="form-group">
      <label for="orden">Orden</label>
      <input type="number" min="0" class="form-control" name="orden" id="orden" value="0" required="required">
    </div>
    <div class="form-group">
      <label for="link">Link</label>
      <input type="text" class="form-control" name="link" id="link" value="#" required="required">
    </div>
    <div class="form-group">
    	<label for="lang">Idioma</label>
    	<select name="lang" class="form-control">
        	<option value="es">Español (es)</option>
        	<option value="en">English (en)</option>
        </select>
    </div>
    
    <input type="hidden" name="form" value="add">
    <button type="submit" value="Agregar" class="btn btn-default">Agregar</button>
  </fieldset>
</form>
<?php } elseif(isset($_GET['a']) && $_GET['a'] == "edit") { ?>
<form action="" name="editar" id="editar" method="POST" enctype="multipart/form-data">
  <fieldset>
    <legend>Editar</legend>
    <div class="form-group">
      <label for="name">Titulo</label>
      <input type="text" class="form-control" name="name" id="name" required="required" value="<?php echo $registro[0]['dro_rotas']['name']; ?>">
    </div>
    <div class="form-group">
    <input type="hidden" name="archivo_antiguo" value="<?php echo $registro[0]['dro_rotas']['picture']; ?>" />
      <label for="archivo">Imagen (opcional)</label>
      <input type="file" class="form-control" name="archivo" id="archivo">
      <?php if(is_file("../contenido/".$registro[0]['dro_rotas']['picture'])) { ?>
      	<a href="../contenido/<?php echo $registro[0]['dro_rotas']['picture']; ?>" class="btn btn-default fancyb"><i class="glyphicon glyphicon-picture"> </i> Imagen actual: <?php echo $registro[0]['dro_rotas']['picture']; ?></a>
      <?php } ?>
    </div>
    <div class="form-group">
      <label for="content">Descripción</label>
      <textarea name="content" class="form-control" id="content"><?php echo $registro[0]['dro_rotas']['content']; ?></textarea>
    </div>
    <div class="form-group">
      <label for="orden">Orden</label>
      <input type="number" min="0" class="form-control" name="orden" id="orden" value="<?php echo $registro[0]['dro_rotas']['orden']; ?>" required="required">
    </div>
    <div class="form-group">
      <label for="link">Link</label>
      <input type="text" class="form-control" name="link" id="link" value="<?php echo $registro[0]['dro_rotas']['link']; ?>" required="required">
    </div>
    <div class="form-group">
    	<label for="lang">Idioma</label>
    	<select name="lang" class="form-control">
        	<option value="es"<?php if($registro[0]['dro_rotas']['lang'] == "es") { echo 'selected'; } ?>>Español (es)</option>
        	<option value="en"<?php if($registro[0]['dro_rotas']['lang'] == "en") { echo 'selected'; } ?>>English (en)</option>
        </select>
    </div>
    <input type="hidden" name="form" value="edit">
    <input name="id" type="hidden" id="id" value="<?php echo $registro[0]['dro_rotas']['id']; ?>">
    <button type="submit" value="Agregar" class="btn btn-default">Guardar</button>
  </fieldset>
</form>
<?php } elseif(isset($_GET['a']) && $_GET['a'] == "dell") { ?>
<form action="" name="borrar" method="post">
	<fieldset>
    	<legend>Eliminar</legend>
        <p>Si borra este registro no podra ser recuperado.<br />
        Registro: <strong><?php echo $registro[0]['dro_rotas']['name']; ?></strong></p>
        
        <input type="hidden" name="dell" value="<?php echo $registro[0]['dro_rotas']['id']; ?>" />
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
					<th>Imagen</th>
					<th width="100"></th>
				</tr>
                </thead>
				<?php if(count($registros) > 0) { ?>
                <?php foreach($registros as &$registro) { ?>
                  <tr>
                    <td align="center"><?php echo $registro['dro_rotas']['id']; ?></td>
                    <td><small><?php echo $registro['dro_rotas']['created']; ?><br>
					<?php echo $registro['dro_rotas']['modified']; ?></small></td>
                    <td><?php echo $registro['dro_rotas']['lang']; ?></td>
                    <td><?php echo $registro['dro_rotas']['name']; ?></td>
                    <td><?php echo $registro['dro_rotas']['picture']; ?></td>
                    <td width="140">
                      <div class="btn-group" role="group">
                        <a href="index.php?o=<?php echo $o; ?>&a=edit&id=<?php echo $registro['dro_rotas']['id']; ?>" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil"></i></a> 
                        <a href="index.php?o=<?php echo $o; ?>&a=dell&id=<?php echo $registro['dro_rotas']['id']; ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
                  <tr>
                  	<td colspan="6">
                          <ul class="pagination">
                            <?php if($prevlink > 0){ echo '<li><a href="?o='.$o.'&page='.$prevlink.'">Prev</a></li>'; } else { echo '<li class="disabled"><a>Prev</a></li>'; } ?>
                            <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
                            <?php if($page == $i) {  echo '<li class="disabled"><a>'.$i.'</a></li>'; } else { ?>
                            <li><a href=""><?php echo $i; ?></a></li>
                            <?php } ?>
                            <?php }	?>
                            <?php if($nextlink > 0){ echo '<li><a href="?o='.$o.'&page='.$nextlink.'">Next</a></li>'; } else { echo '<li class="disabled"><a>Next</a></li>'; } ?>
                          </ul>
                    </td>
                  </tr>
				<?php } else { ?>
                <tr>
				  <td colspan="6">Aun no hay registros agregados</td>
  				</tr>
                <?php } ?>
</table>	 
<?php } }  ?>