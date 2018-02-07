<div class="login">
	<h2>Login</h2>
	<?php
	if($loginMessage != ''){
		echo '<p class="error">'.$loginMessage.'</p>';
	}
	?>
	<?= $loginForm->display() ?>
	<p>
		Forgot your password? <a href="<?= SITE_URL ?>/account/reset">Click here to reset your password.</a>
	</p>
</div>

