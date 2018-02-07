<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;

$getPosts = $model->getAll('blog_posts');

foreach($getPosts as $post){
	$url = $post['url'].'/';
	$getIndex = $model->getAll('page_index', array('moduleId' => 28, 'siteId' => 1, 'itemId' => $post['postId']));
	if(count($getIndex) > 0){
		$getIndex = $getIndex[0];
		$insert = $model->edit('page_index', $getIndex['pageIndexId'], array('url' => $url, 'moduleId' => 28, 'siteId' => 1, 'itemId' => $post['postId']));
	}
	else{
		$insert = $model->insert('page_index', array('url' => $url, 'moduleId' => 28, 'siteId' => 1, 'itemId' => $post['postId']));
	}
	if($insert){
		echo "Index updated for ".$post['title']."! \n";
	}
	else{
		echo "Failed making index for ".$post['title']." \n";
	}
	
}
