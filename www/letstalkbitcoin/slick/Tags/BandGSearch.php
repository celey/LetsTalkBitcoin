<?php
namespace Tags;
use App, App\Blog, UI, Util;
class BandGSearch
{
	function __construct()
	{
		
	}
	
	public function display()
	{
		$model = new Blog\Post_Model;
		$site = $model->get('sites', $_SERVER['HTTP_HOST'], array(), 'domain');
		if(!isset($_GET['search'])){
			header('Location: '.$site['url']);
			return false;
		}
		ob_start();
		$bandgCat = 25;
		$limit = 5;
		$s = htmlentities($_GET['search']);
		$getPosts = $model->fetchAll('SELECT p.* 
									  FROM blog_postCategories c
									  LEFT JOIN blog_posts p ON p.postId = c.postId
									  WHERE p.siteId = 1 AND p.published = 1 AND c.categoryId = :cat
									  AND (p.title LIKE :title OR p.url LIKE :url)
									  ORDER BY publishDate DESC
									  ', array(':cat' => $bandgCat, ':title' => '%'.$s.'%', 
															':url' => '%'.$s.'%'));

		echo '<h2>Search Episodes</h2>
				<p><strong>Found '.count($getPosts).' search results for keywords: '.$s.'</strong></p>';
		if(count($getPosts) == 0){
			echo '<p>No posts found! Try a different keyword.</p>';
		}
		else{
			echo '<ul class="blog-list">';
			foreach($getPosts as $post){
				echo '<li><h2><a href="http://letstalkbitcoin.com/blog/post/'.$post['url'].'">'.$post['title'].'</a></h2>';
				
				$postMeta = $model->getPostMeta($post['postId']);
				if(isset($postMeta['soundcloud-id'])){
					echo '<iframe src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F'.$postMeta['soundcloud-id'].'&auto_play=false&show_artwork=true&color=ff7700" width="100%" height="150"></iframe>
					';
				}
				echo '</li>';
			}

			echo '</ul>';
		}

		$output = ob_get_contents();
		ob_end_clean();
		
		
		return $output;
	}
	
}
