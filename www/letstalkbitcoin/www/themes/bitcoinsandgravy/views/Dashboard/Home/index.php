
<h2>Dashboard</h2>
<hr>
<div class="profile-pic">
	<?php
	if(isset($user['meta']['avatar']) AND trim($user['meta']['avatar']) != ''){
		echo '<img src="'.SITE_URL.'/files/avatars/'.$user['meta']['avatar'].'" alt="" />';
	}
	
	?>
</div>
<p>Welcome back, <strong><?= $user['username'] ?></strong></p>
<p>
	For your regular, full account dashboard, visit the main <a href="http://letstalkbitcoin.com">Lets Talk Bitcoin</a> website.
</p>
<p>
	<strong>Last Logged In:</strong> <?= formatDate($user['lastAuth']) ?><br>
	<strong>Date Registered:</strong> <?= formatDate($user['regDate']) ?><br>
	<strong>Email Address:</strong> <?php if($user['email'] == ''){ echo 'N/A'; } else{ echo $user['email']; } ?>
</p>

<?php
if(isset($_GET['closeThis'])){
	
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			window.close();
		});
	</script>
	<?php
}
?>
