<?php //Control de Execucion 
if($execute == 1) {
	$contenido = $m->query("SELECT * FROM dro_conts WHERE slug = '".$_GET['slug']."'");
	
//valores genericos
$dro_titulo = $contenido[0]['dro_conts']['cont'];
$dro_descripcion = limitar(strip_tags($contenido[0]['dro_conts']['des_cont']),50);
} if($execute == 2) { ?>
	<h1><?php echo $contenido[0]['dro_conts']['cont']; ?></h1>
    <?php echo $contenido[0]['dro_conts']['content']; ?>
<?php } ?>