<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?= $title ?> | Bitcoins And Gravy</title>
	<meta property="og:image" content="http://bitcoinsandgravy.com/themes/bitcoinsandgravy/images/main-logo.png" />
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Rye%3Aregular&subset=latin&ver=4.0">
	<link rel="stylesheet" href="<?= THEME_URL ?>/css/base.css">
	<link rel="stylesheet" href="<?= THEME_URL ?>/css/skeleton.css">
	<link rel="stylesheet" href="<?= THEME_URL ?>/css/layout.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?= THEME_URL ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?= SITE_URL ?>/resources/tinymce/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="<?= THEME_URL ?>/js/viewport.js"></script>
	<script type="text/javascript" src="<?= THEME_URL ?>/js/scripts.js"></script>
	<script type="text/javascript">
		window.siteURL = '<?= SITE_URL ?>';
	</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-22288117-9', 'auto');
  ga('send', 'pageview');

</script>	
</head>
<body>
	<div class="header">
		<div class="container">
			<div class="logo center">
				<?= $this->displayBlock('header-tagline') ?>
			</div><!-- logo -->
			<div class="header-social center">
				<?= $this->displayBlock('header-social') ?>
			</div><!-- header-social -->
		</div><!-- container -->
		<div class="nav-cont">
			<div class="container">
				<div class="nav center">
					<div class="mobile-social">
						<?= $this->displayBlock('header-social') ?>
					</div>
					<a href="#" class="mobile-pull"><i class="fa fa-bars"></i></a>
					<div class="mobile-nav">
						<?= $this->displayMenu('main', 0, 'mobile-menu menu') ?>
					</div>
					<?= $this->displayMenu('main', 0, 'menu') ?>
					<div class="clear"></div>
				</div><!-- nav -->
			</div><!-- container -->
		</div><!-- nav-cont -->		
	</div><!-- header -->
	<div class="main">
		<div class="main-marker"></div>
