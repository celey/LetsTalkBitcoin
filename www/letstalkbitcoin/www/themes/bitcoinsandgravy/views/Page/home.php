<h1>Latest Episodes</h1>
<p>
	<a href="http://www.stitcher.com/s?fid=61010&refid=stpr" target="_blank"><img src="http://bitcoinsandgravy.com/resources/files/images/stitcher.jpg"  alt="Listen to Stitcher"></a>
</p>
<?php
$bandgCat = 25;
$limit = 5;
$model = new \App\Blog\Post_Model;
$getPosts = $model->fetchAll('SELECT p.* 
							  FROM blog_postCategories c
							  LEFT JOIN blog_posts p ON p.postId = c.postId
							  WHERE p.siteId = 1 AND p.published = 1 AND c.categoryId = :cat
							  ORDER BY publishDate DESC
							  LIMIT '.$limit, array(':cat' => $bandgCat));


if(count($getPosts) == 0){
	echo '<p>No posts found!</p>';
}
else{
	echo '<ul class="blog-list">';
	foreach($getPosts as $post){
		echo '<li><h2><a href="http://letstalkbitcoin.com/blog/post/'.$post['url'].'">'.$post['title'].'</a></h2>';
		
		$postMeta = $model->getPostMeta($post['postId'], false, false, $model->get('sites', 1));
		if(isset($postMeta['soundcloud-id'])){
			echo '<iframe src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F'.$postMeta['soundcloud-id'].'&auto_play=false&show_artwork=true&color=ff7700" width="100%" height="150"></iframe>
			';
		}
		echo '</li>';
	}

	echo '</ul>';
}
?>
<br>
<?= $this->displayBlock('home-bottom-content') ?>
