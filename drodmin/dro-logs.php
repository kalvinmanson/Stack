<?php
//Execute control
if($execute == 1) {
	$m = new mysql();
	$o = "logs";
	
	
	//MOSTRAR CONTENIDOS
	//buscar contenidos
	$fq = "";
	$q = "";
	if(isset($_GET['q']) && !empty($_GET['q'])) { $fq = " WHERE log LIKE '%".$_GET['q']."%'"; $q = $_GET['q']; }
	//paginador
	if(isset($_GET['page']) && $_GET['page'] > 1) { $page = $_GET['page'];} else { $page = 1; }
		$paginar = 20;
		$paginaini = ($page - 1) * $paginar;
		$paginall = $m->totalrows('SELECT id FROM dro_logs'.$fq);
		$totalpages = ceil($paginall / $paginar);
		if($page > 1) { $prevlink = $page - 1; } else { $prevlink = "0"; }
		if($page < $totalpages) { $nextlink = $page + 1; } else { $nextlink = "0"; }
		//fin paginador 
	$registros = $m->query("SELECT * FROM dro_logs ".$fq." ORDER BY created DESC LIMIT ".$paginaini.", ".$paginar);
	
	if(isset($_GET['id']) && $_GET['id'] > 0) {
		$registro = $m->query("SELECT * FROM dro_logs WHERE id = '".$_GET['id']."'");
	}
	
	//ELIMINAR CONTENIDO
	if(isset($_POST['dell'])) {
		$result = $m->query("DELETE FROM dro_logs WHERE created < '".date('Y-m-d',strtotime('-30 day'))."'");
		
		//Log
			$logmsg = "Logs eliminados";
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
  <a href="index.php?o=<?php echo $o; ?>&a=dell" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Vaciar Logs</a>
</form>
<h4>Logs</h4>
<?php if(isset($_GET['a']) && $_GET['a'] == "dell") { ?>
<form action="" name="borrar" method="post">
	<fieldset>
    	<legend>Eliminar</legend>
        <p>Si borra estos registros no podran ser recuperados.</p>
        
        <input type="hidden" name="dell" value="1" />
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
					<th>Usuario</th>
					<th>Log</th>
				</tr>
                </thead>
				<?php if(count($registros) > 0) { ?>
                <?php foreach($registros as &$registro) { ?>
                  <tr>
                    <td align="center"><?php echo $registro['dro_logs']['id']; ?></td>
                    <td><small><?php echo $registro['dro_logs']['created']; ?></small></td>
                    <td><small><?php echo $registro['dro_logs']['user_id']; ?></small></td>
                    <td><?php echo $registro['dro_logs']['log']; ?><br />
						<small><?php echo $registro['dro_logs']['page_log']; ?></small></td>
                  </tr>
                <?php } ?>
                  <tr>
                  	<td colspan="4">
                          <ul class="pagination">
                            <?php if($prevlink > 0){ echo '<li><a href="?o='.$o.'&page='.$prevlink.'">Prev</a></li>'; } else { echo '<li class="disabled"><a>Prev</a></li>'; } ?>
                            <?php for ($i = 1; $i <= $totalpages; $i++) { ?>
                            <?php if($page == $i) {  echo '<li class="disabled"><a>'.$i.'</a></li>'; } else { ?>
                            <li><a href="?o=<?php echo $o; ?>&page=<?php echo $i; ?>&q=<?php echo $q; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>
                            <?php }	?>
                            <?php if($nextlink > 0){ echo '<li><a href="?o='.$o.'&page='.$nextlink.'">Next</a></li>'; } else { echo '<li class="disabled"><a>Next</a></li>'; } ?>
                          </ul>
                    </td>
                  </tr>
				<?php } else { ?>
                <tr>
				  <td colspan="4">Aun no hay registros agregados</td>
  				</tr>
                <?php } ?>
</table>	 
<?php } }  ?>