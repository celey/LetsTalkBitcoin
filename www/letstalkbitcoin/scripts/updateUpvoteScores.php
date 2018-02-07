<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \App\Tokenly\Inventory_Model;
$meta = new \App\Meta_Model;
$forumApp = $model->get('apps', 'forum', array(), 'slug');
$settings = $meta->appMeta($forumApp['appId']);
$userList = '38,79,82,91';
$getLikes = $model->fetchAll('SELECT * FROM user_likes WHERE userId IN('.$userList.')');
foreach($getLikes as $like){
	$getItem = false;
	switch($like['type']){
		case 'post':
			$getItem = $model->get('forum_posts', $like['itemId']);
			break;
		case 'topic':
			$getItem = $model->get('forum_topics', $like['itemId']);
			break;
	}
	if(!$getItem){
		$model->delete('user_likes', $like['likeId']);
		echo $like['likeId']." deleted \n";
		continue;
	}
	$getScore = $model->getWeightedUserTokenScore($like['userId'], $getItem['userId'], 
														$settings['weighted-votes-token'], 
														$settings['min-upvote-points'], 
														$settings['max-upvote-points'], 1000,
														$settings['weighted-vote-token-cap']);
														
	if($like['userId'] == $getItem['userId']){
		$getScore['score'] = 0;
	}
	
	$edit = $model->edit('user_likes', $like['likeId'], array('score' => $getScore['score'], 'opUser' => $getItem['userId']));
	if(!$edit){
		echo $like['likeId']." failed \n";
	}
	else{
		echo $like['likeId']." success! \n";
	}
}
