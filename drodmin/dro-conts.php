<?php
//Execute control
if($execute == 1) {
	$o = "conts";
	
	//MOSTRAR CONTENIDOS
	//buscar contenidos
	$fq = " WHERE dro_cats.id = dro_conts.cat_id ";
	$q = "";
	if(isset($_GET['q']) && !empty($_GET['q'])) { $fq = " WHERE dro_cats.id = dro_conts.cat_id AND dro_conts.name LIKE '%".$_GET['q']."%'"; $q = $_GET['q']; }
	//paginador
	if(isset($_GET['page']) && $_GET['page'] > 1) { $page = $_GET['page'];} else { $page = 1; }
		$paginar = 20;
		$paginaini = ($page - 1) * $paginar;
		$paginall = $m->totalrows('SELECT * FROM dro_conts, dro_cats '.$fq);
		$totalpages = ceil($paginall / $paginar);
		if($page > 1) { $prevlink = $page - 1; } else { $prevlink = "0"; }
		if($page < $totalpages) { $nextlink = $page + 1; } else { $nextlink = "0"; }
		//fin paginador 
	$registros = $m->query("SELECT * FROM dro_conts, dro_cats ".$fq." ORDER BY dro_conts.modified DESC LIMIT ".$paginaini.", ".$paginar);
	
	if(isset($_GET['id']) && $_GET['id'] > 0) {
		$registro = $m->query("SELECT * FROM dro_conts WHERE id = '".$_GET['id']."'");
	}
	
	//AGREGAR CONTENIDO
	if(isset($_POST['form']) && $_POST['form'] == "add") {
		//validar slug
		$val_slug = $m->query("SELECT * FROM dro_conts WHERE slug LIKE '".amigable($_POST['name'])."%'");
		if(count($val_slug) > 0) { $slug = amigable($_POST['name'])."-".(count($val_slug) + 1);	} else { $slug = amigable($_POST['name']); }
	$query = sprintf("INSERT INTO dro_conts (cat_id, name, slug, created, modified) VALUES (%s, %s, %s, %s, %s)",
	   nosqlinj($_POST['cat_id'], "int"),
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($slug, "text"),
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
	$query = sprintf("UPDATE dro_conts SET cat_id=%s, name=%s, picture=%s, content=%s, modified=%s WHERE id=%s",
	   nosqlinj($_POST['cat_id'], "text"),
	   nosqlinj($_POST['name'], "text"),
	   nosqlinj($_POST['picture'], "text"),
	   nosqlinj($_POST['content'], "text"),
	   nosqlinj(date("Y-m-d H:i:s"), "date"),
	   nosqlinj($registro[0]['dro_conts']['id'], "int"));
	   
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
		$result = $m->delete('dro_conts','id='.$_POST['dell']);
		
		//Log
			$logmsg = "Registro eliminado ID: ".$_POST['dell'];
			$m->execute("INSERT INTO dro_logs (user_id, page_log, log, ip, created) VALUES (".$usuario_log[0]['dro_users']['id'].", '".$_SERVER['REQUEST_URI']."', '".$logmsg."', '".$_SERVER['SERVER_ADDR']."', '".date("Y-m-d H:i:s")."')");
			
		  $_SESSION['alert_tipo'] = "success";
      $_SESSION['alert'] = "Registro <strong>Eliminado</strong> con éxito."; 
      header('Location: index.php?o='.$o);  die();
	}
	// Listados
	$cats = $m->query("SELECT * FROM dro_cats ORDER BY name ASC");
	
} //Execute control
if($execute == 2) { ?>

<?php if(isset($_GET['a']) && $_GET['a'] == "edit") { ?>
<form action="" name="editar" id="editar" method="POST">
  <fieldset>
    <legend>Editar</legend>
    <div class="form-group">
      <label for="cat_id">Categoría</label>
      <select name="cat_id" id="cat_id" class="form-control">
      	<?php foreach($cats as &$cat) { ?>
        <option value="<?php echo $cat['dro_cats']['id']; ?>"<?php if($registro[0]['dro_conts']['cat_id'] == $cat['dro_cats']['id']) { echo ' selected';} ?>><?php echo $cat['dro_cats']['name']; ?></option>
    	<?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label for="name">Titulo</label>
      <input type="text" class="form-control input-lg" name="name" id="name" required value="<?php echo $registro[0]['dro_conts']['name']; ?>">
    </div>
    <div class="form-group">
      <label for="picture">Imagen (opcional)</label>
      <input type="text" class="form-control ckfile" name="picture" id="picture" value="<?php echo $registro[0]['dro_conts']['picture']; ?>" readonly>
      <?php if(!empty($registro[0]['dro_conts']['picture'])) { ?>
      	<a href="<?php echo $registro[0]['dro_conts']['picture']; ?>" class="btn btn-default fancyb"><i class="glyphicon glyphicon-picture"> </i> Imagen actual: <?php echo $registro[0]['dro_conts']['picture']; ?></a>
      <?php } ?>
    </div>
    <div class="form-group">
      <label for="content">Contenido</label>
      <textarea name="content" class="form-control ckeditor" id="content" rows="10"><?php echo $registro[0]['dro_conts']['content']; ?></textarea>
    <script type="text/javascript">
		var editor = CKEDITOR.replace('content');
		CKFinder.setupCKEditor(editor,'editor/ckfinder' ) ;
	</script>
    </div>
    <input type="hidden" name="form" value="edit">
    <input name="id" type="hidden" id="id" value="<?php echo $registro[0]['dro_conts']['id']; ?>">
    <button type="submit" class="btn btn-success btn-raised"><i class="fa fa-save"></i> Guardar</button>
  </fieldset>
</form>
<?php } elseif(isset($_GET['a']) && $_GET['a'] == "dell") { ?>
<form action="" name="borrar" method="post">
	<fieldset>
    	<legend>Eliminar</legend>
        <p>Si borra este registro no podra ser recuperado.<br />
        Registro: <strong><?php echo $registro[0]['dro_conts']['name']; ?></strong></p>
        
        <input type="hidden" name="dell" value="<?php echo $registro[0]['dro_conts']['id']; ?>" />
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
<h4>Contenidos</h4>
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
              <label for="cat_id">Categoría</label>
              <select name="cat_id" id="cat_id" class="form-control">
                <?php foreach($cats as &$cat) { ?>
                <option value="<?php echo $cat['dro_cats']['id']; ?>"><?php echo $cat['dro_cats']['name']; ?></option>
              <?php } ?>
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
      <th>Categoría</th>
			<th>Nombre</th>
			<th>Imagen</th>
			<th width="100"></th>
		</tr>
  </thead>
	<?php if(count($registros) > 0) { 
  foreach($registros as &$registro) { ?>
    <tr>
      <td align="center"><?php echo $registro['dro_conts']['id']; ?></td>
      <td><small><?php echo $registro['dro_conts']['created']; ?><br><?php echo $registro['dro_conts']['modified']; ?></small></td>
      <td><?php echo $registro['dro_cats']['name']; ?></td>
      <td><?php echo $registro['dro_conts']['name']; ?><br /><small><?php echo $registro['dro_conts']['slug']; ?></small></td>
      <td><?php echo $registro['dro_conts']['picture']; ?></td>
      <td width="140">
        <div class="btn-group" role="group">
          <a href="/p/<?php echo $registro['dro_conts']['slug']; ?>" target="_blank" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> 
          <a href="index.php?o=<?php echo $o; ?>&a=edit&id=<?php echo $registro['dro_conts']['id']; ?>" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil"></i></a> 
          <a href="index.php?o=<?php echo $o; ?>&a=dell&id=<?php echo $registro['dro_conts']['id']; ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
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