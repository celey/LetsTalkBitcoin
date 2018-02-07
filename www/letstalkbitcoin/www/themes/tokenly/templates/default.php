<?php
include(THEME_PATH.'/inc/header.php');
?>
        <div id="top-background" class="small-height">
            <div class="gradient">
                <h1 class="title"><?= $title ?></h1>
            </div>
        </div>

        <div class="content-width content">
			<?php include($viewPath); ?>
            <div class="clearfix"></div>
        </div>
<?php
include(THEME_PATH.'/inc/footer.php');
?>
