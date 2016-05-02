<?php //Control de Execucion 
if($execute == 1) {
  $home = $m->query("SELECT * FROM dro_conts WHERE slug = 'home'");
	$slides = $m->query("SELECT * FROM dro_pictures WHERE cont_id = '".$home[0]['dro_conts']['id']."' ORDER BY orden ASC");
	
//valores genericos
$dro_titulo = "Home";
$dro_descripcion = "Descripcion del sitio";
} if($execute == 2) { ?>
<?php if(count($slides) > 0) { ?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  <?php foreach($slides as &$slide) { ?>
    <li data-target="#carousel-example-generic" data-slide-to="0"<?php if(!isset($rota_active_i)) { echo ' class="active"'; $rota_active_i = 1; } ?>></li>
  <?php } ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php foreach($slides as &$slide) { ?>
    <a href="<?php echo $slide['dro_pictures']['link']; ?>" class="item<?php if(!isset($rota_active)) { echo ' active'; $rota_active = 1; } ?>">
      <img src="<?php echo $slide['dro_pictures']['picture']; ?>" alt="<?php echo $slide['dro_pictures']['name']; ?>" class="img-responsive">
      <div class="carousel-caption">
      	<?php echo $slide['dro_pictures']['content']; ?>
      </div>
    </a>
    <?php } ?>
  </div>
	
    <?php if(count($slides) > 1) { ?>
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
<?php echo $home[0]['dro_conts']['content']; ?>

<?php } ?>