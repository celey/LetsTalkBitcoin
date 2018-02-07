<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \App\Blog\Post_Model;
$getPosts = $model->getAll('blog_posts');

foreach($getPosts as $post){
	$getMeta = $model->getPostMeta($post['postId']);
	
	foreach($getMeta as $key => $meta){
			if($key == 'soundcloud-url'){
			
				$id = str_replace('https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F', '', $meta);
				$id = str_replace('&auto_play=false&show_artwork=true&color=ff7700', '', $id);
				$id = str_replace("'", '', $id);
				$id = str_replace('format=set','',$id);
				$id = trim($id);
				
				$getVal = $model->fetchSingle('SELECT * FROM blog_postMeta WHERE postId = :postId AND metaTypeId = :typeId',
											array(':postId' => $id, ':typeId' => 4));
				
				$insertData = array('value' => $id);
				if($getVal){
					$update = $model->edit('blog_postMeta', $getVal['metaData'], $insertData);
				}
				else{
					//insert new one
					$insertData['postId'] = $post['postId'];
					$insertData['metaTypeId'] = 4;
					$update = $model->insert('blog_postMeta', $insertData);
				}
				
				if($update){
					echo "Post updated: ".$post['title']."\n";
				}
				else{
					echo "Error updating post ".$post['title']."\n";
				}
				
				echo $id."\n";
			}
	}
	
}

