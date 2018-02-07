<!doctype html>
<head>
	<meta charset="utf-8">
	<title><?= $title ?> | Tokenly | Limitless Tokens for a Tokenless World</title>
	<?php
	if(!isset($metaDescription)){
		$metaDescription = "";
	}
	?>
	<meta name="description" content="<?= $metaDescription ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="<?= THEME_URL ?>/styles/main.css">
	<link rel="stylesheet" href="<?= THEME_URL ?>/styles/unsemantic.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
	<link rel="icon" type="image/png" href="<?= THEME_URL ?>/images/favicon.png">
	<script type="text/javascript" src="<?= THEME_URL ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?= THEME_URL ?>/js/migrate.js"></script>
	<script type="text/javascript" src="<?= THEME_URL ?>/js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?= THEME_URL ?>/js/jcycle.js"></script>
	<script type="text/javascript" src="<?= THEME_URL ?>/js/base64.js"></script>
	<script type="text/javascript" src="<?= SITE_URL ?>/resources/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?= THEME_URL ?>/js/scripts.js"></script>        
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-22288117-11', 'auto');
		ga('send', 'pageview');
	</script>	
</head>
<body class="template-<?= $template ?>">
	<div id="navigation-bar" <?php if($template != 'home'){ echo "class='with-logo'"; } ?>>
		<a href="<?= SITE_URL ?>"><div id="logo"></div></a>
		<?= $this->displayMenu('main') ?>
	</div>
