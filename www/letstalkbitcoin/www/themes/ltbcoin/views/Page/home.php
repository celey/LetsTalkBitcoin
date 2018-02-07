<?php
$model = new \App\Page\View_Model;
foreach($ltbcoin_menu as $menuPage){
	if($menuPage['isLink'] == 1){
		continue;
	}
	
	$getMenuPage = $model->get('menu_pages', $menuPage['itemId']);
	$getPage = $model->get('pages', $getMenuPage['pageId']);
	if(!$getPage){
		continue;
	}
	?>
	<div class="main-section" id="<?= $getPage['url'] ?>">
		<div class="row">
			<div class="small-centered medium-11 columns">
				<h3><?= $getPage['name'] ?></h3>
				<?= $model->processPageContent($getPage['content'], $getPage['siteId']) ?>
			</div>
		</div>
	</div>				
	<?php
	
	
}//endforeach

?>

