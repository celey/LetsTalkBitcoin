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
        <div class="main-body">
			<div class="main-section" id="about">
                <div class="row">
					<div class="medium-3 columns">
						<ul>
							<?= $menuStr ?>
						</ul>
					</div>
                    <div class="medium-9 columns">			
						<?php include($viewPath); ?>
                    </div>
                </div>
            </div>
        </div>
<?php
include(THEME_PATH.'/inc/footer.php');
?>
