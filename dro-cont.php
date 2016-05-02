<?php //Control de Execucion 
if($execute == 1) {
	$contenido = $m->query("SELECT * FROM dro_conts, dro_cats WHERE dro_cats.id = dro_conts.cat_id AND dro_conts.slug = '".$_GET['slug']."'");
	
//valores genericos
$dro_titulo = $contenido[0]['dro_conts']['name'];
$dro_descripcion = limitar(strip_tags($contenido[0]['dro_conts']['content']),50);
} if($execute == 2) { ?>
<h1><?php echo $contenido[0]['dro_conts']['name']; ?></h1>
<?php //Plantillas
if($contenido[0]['dro_cats']['name'] == "General") { ?>
	<div class="row">
    	<div class="col-sm-8">
			<?php echo $contenido[0]['dro_conts']['content']; ?>
        </div>
        <div class="col-sm-4">
        	<?php include("sis-sidebar.php"); ?>
        </div>
    </div>
<?php } else { ?>
	<?php echo $contenido[0]['dro_conts']['content']; ?>
<?php } ?>
<?php } ?>