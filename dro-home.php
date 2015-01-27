<?php //Control de Execucion 
if($execute == 1) {
	$rotas = $m->query("SELECT * FROM dro_rotas ORDER BY orden ASC");
	
//valores genericos
$dro_titulo = "Home";
$dro_descripcion = "Descripcion del sitio";
} if($execute == 2) { ?>
<?php if(count($rotas) > 0) { ?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  <?php foreach($rotas as &$rota) { ?>
    <li data-target="#carousel-example-generic" data-slide-to="0"<?php if(!isset($rota_active_i)) { echo ' class="active"'; $rota_active_i = 1; } ?>></li>
  <?php } ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php foreach($rotas as &$rota) { ?>
    <div class="item<?php if(!isset($rota_active)) { echo ' active'; $rota_active = 1; } ?>">
      <img src="/t.php?src=contenido/<?php echo $rota['dro_rotas']['picture']; ?>&w=1400&h=500" alt="<?php echo $rota['dro_rotas']['name']; ?>" class="img-responsive">
      <div class="carousel-caption">
      	<?php echo $rota['dro_rotas']['content']; ?>
      </div>
    </div>
    <?php } ?>
  </div>
	
    <?php if(count($rotas) > 1) { ?>
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  	<?php } ?>
</div>
<?php } ?>

<?php } ?>