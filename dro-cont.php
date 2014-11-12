<?php //Control de Execucion 
if($execute == 1) {
	$contenido = $m->query("SELECT * FROM dro_conts WHERE slug = '".$_GET['slug']."'");
	
//valores genericos
$dro_titulo = $contenido[0]['dro_conts']['name'];
$dro_descripcion = limitar(strip_tags($contenido[0]['dro_conts']['content']),50);
} if($execute == 2) { ?>
	<h1><?php echo $contenido[0]['dro_conts']['name']; ?></h1>
    <?php echo $contenido[0]['dro_conts']['content']; ?>
<?php } ?>