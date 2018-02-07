<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$getPosts = $model->getAll('blog_posts');

foreach($getPosts as $post){
	$getVersions = $model->getAll('content_versions', array('type' => 'blog-post', 'itemId' => $post['postId']));
	if(count($getVersions) > 0){
		continue;
	}
	$versionData = array('type' => 'blog-post', 'itemId' => $post['postId'], 'userId' => $post['userId'], 'formatType' => $post['formatType'],
						 'content' => json_encode(array('content' => $post['content'], 'excerpt' => $post['excerpt'])),
						 'versionDate' => $post['postDate'], 'num' => 1);
	$addVersion = $model->insert('content_versions', $versionData);
	if($addVersion){
		$add = $model->edit('blog_posts', $post['postId'], array('version' => $addVersion));
		if($add){
			echo $post['title']." first version added \n";
			continue;
		}
	}
	echo 'failed: '.$post['title']."\n";
}
