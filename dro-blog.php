<?php //Control de Execucion 
if($execute == 1) {
	if(isset($_GET['a']) && $_GET['a'] == "post" && isset($_GET['slug'])) {
		$post = $m->query("SELECT * FROM dro_posts WHERE slug = '".$_GET['slug']."'");
		
		//valores genericos
		$dro_titulo = $post[0]['dro_posts']['name'];
		$dro_descripcion = limitar(strip_tags($post[0]['dro_posts']['content']),50);
		
	} else {
		$posts = $m->query("SELECT * FROM dro_posts ORDER BY created DESC");
		
		//valores genericos
		$dro_titulo = "Blog";
		$dro_descripcion = "Actualidad y Noticias";
	}
	

} if($execute == 2) { ?>
<div class="row">
    <div class="col-sm-8">
	<?php if(isset($_GET['a']) && $_GET['a'] == "post" && isset($_GET['slug']) && isset($post[0])) { //Show Single Post ?>
        <h1><?php echo $post[0]['dro_posts']['name']; ?></h1>
        <?php echo $post[0]['dro_posts']['content']; ?>
    <?php } else { // List Posts ?>
        <?php foreach($posts as &$post) { ?>
            <h1><?php echo $post['dro_posts']['name']; ?></h1>
            <img src="/t.php?src=contenido/<?php echo $post['dro_posts']['picture']; ?>&w=800&h=400" alt="<?php echo $post['dro_posts']['name']; ?>" class="img-responsive">
            <p><?php echo limitar(strip_tags($post['dro_posts']['content']), 50); ?></p>
            <a href="/blog/<?php echo $post['dro_posts']['slug']; ?>" title="<?php echo $post['dro_posts']['name']; ?>">Leer más...</a>
        <?php } ?>
    <?php } ?>
	</div>
    <div class="col-sm-4">
        <?php include("sis-sidebar.php"); ?>
    </div>
</div>

<?php } ?>