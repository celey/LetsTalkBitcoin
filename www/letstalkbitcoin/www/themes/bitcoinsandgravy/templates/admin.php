<?php
	include(THEME_PATH.'/inc/header.php');
$menu = \App\Dashboard\DashMenu_Model::getDashMenu();
					
$menuStr = '';
foreach($menu as $heading => $items){
	if(trim($heading) != ''){
		$menuStr .= '<li><strong>'.$heading.'</strong><ul>';
	}
	else{
		$menuStr .=  '<li><strong>Menu</strong>';
	}

	foreach($items as $item){
		$menuStr .=  '<li><a href="'.$item['url'].'">'.$item['label'].'</a></li>';
	}
	if(trim($heading) != ''){
		$menuStr .=  '</ul></li>';
	}
}
?>
		<div class="container">
			<div class="main-content twelve columns">
				<div class="content">
					<?php include($viewPath); ?>
				</div><!-- content -->
			</div><!-- main-content -->
			<div class="sidebar four columns">
				<h3>Dash Menu</h3>
				<ul>
					<?= $menuStr ?>
				</ul>
			</div><!-- sidebar -->
		</div><!-- container -->
<?php
	include(THEME_PATH.'/inc/footer.php');
?>
