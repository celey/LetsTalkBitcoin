<h2><?= $formType ?> Feed Proxy URL</h2>
<p>
	<a href="<?= SITE_URL ?>/<?= $app['url'] ?>/<?= $module['url'] ?>">Go Back</a>
</p>
<?php
if(isset($error) AND $error != null){
	echo '<p class="error">'.$error.'</p>';
}
?>
<?= $form->display() ?>
