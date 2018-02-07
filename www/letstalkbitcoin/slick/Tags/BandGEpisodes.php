<?php
namespace Tags;
use App\Blog;
class BandGEpisodes
{
	function display()
	{
		ob_start();
		$bandgCat = 25;
		$model = new Blog\Post_Model;
		$getPosts = $model->fetchAll('SELECT p.* 
									  FROM blog_postCategories c
									  LEFT JOIN blog_posts p ON p.postId = c.postId
									  WHERE p.siteId = 1 AND p.published = 1 AND c.categoryId = :cat
									  ORDER BY publishDate DESC
									 ', array(':cat' => $bandgCat));


		if(count($getPosts) == 0){
			echo '<p>No posts found!</p>';
		}
		else{
			echo '<ul class="blog-list">';
			foreach($getPosts as $post){
				echo '<li><h2><a href="http://letstalkbitcoin.com/blog/post/'.$post['url'].'" target="_blank">'.$post['title'].'</a></h2>';
				
				$postMeta = $model->getPostMeta($post['postId'], false, false, $model->get('sites', 1));
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
