<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?= $title ?> | LTBcoin - Official token of the Let's Talk Bitcoin! Network</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?= THEME_URL ?>/favicon.ico">
    <link rel="stylesheet" href="<?= THEME_URL ?>/css/normalize.min.css">
    <link rel="stylesheet" href="<?=THEME_URL ?>/css/main.css">
    <link rel="stylesheet" href="<?= THEME_URL ?>/css/foundation.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="<?= THEME_URL ?>/js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
        <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="fixed">
            <nav class="top-bar" data-topbar id="main-nav">
                <ul class="title-area">
                    <li class="name">
						<?php
						if($view == 'home'){
							echo '<h1><a href="#top">LTBcoin</a></h1>';
						}
						else{
							echo '<h1><a href="'.SITE_URL.'">LTBcoin</a></h1>';
						}
						?>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
                </ul>
                <section class="top-bar-section">
                    <!-- Left Nav Section -->
                    <?php
                    $menu = $this->getMenu('ltbcoin-menu');
                    $model = new \Core\Model;
					foreach($menu as $mk => $mv){
						if($mv['isLink'] == 0){
							$getMenuPage = $model->get('menu_pages', $mv['itemId']);
							$getPage = $model->get('pages', $getMenuPage['pageId']);
							if($view == 'home'){
								$menu[$mk]['url'] = '#'.$getPage['url'];
							}
							else{
								$menu[$mk]['url'] = SITE_URL.'/#'.$getPage['url'];
							}
						}
					}
					echo $this->displayMenu($menu, 0, 'left');
					$ltbcoin_menu = $menu;
                    ?>
                </section>
            </nav>
        </div>

        <div id="top"></div>
        <header>
            <div class="row">
                <div class="columns text-center">
                    <a href="<?= SITE_URL ?>"><img class="right" src="<?= SITE_URL ?>/files/sites/<?= $site['image'] ?>" alt="LTBcoin"></a>
					<?= $this->displayBlock('header-text') ?>
                </div>
            </div>
        </header>
