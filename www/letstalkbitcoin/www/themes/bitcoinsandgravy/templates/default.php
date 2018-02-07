<?php
	include(THEME_PATH.'/inc/header.php');
?>
		<div class="container">
			<div class="main-content twelve columns">
				<div class="content">
					<?php include($viewPath); ?>
				</div><!-- content -->
			</div><!-- main-content -->
			<div class="sidebar four columns">
				<?= $this->displayBlock('sidebar') ?>
			</div><!-- sidebar -->
		</div><!-- container -->
<?php
	include(THEME_PATH.'/inc/footer.php');
?>
