<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$disqus = new \API\Disqus;
$getSite = $model->get('sites', 1);
$profModel = new \App\Profile\User_Model;
$getComments = $model->getAll('blog_comments');
$app = $model->get('apps', 7);
$module = $model->get('modules', 28);


$blogUrl = $getSite['url'].'/'.$app['url'].'/'.$module['url'];
foreach($getComments as $comment){
	
	$user = $profModel->getUserProfile($comment['userId'], $getSite['siteId']);
	$post = $model->get('blog_posts', $comment['postId']);
	if(!$post){
		echo "Post not found: #".$comment['postId'].'- '.$comment['commentId']."\n";
		continue;	
	}
	if(!$user){
		echo "User not found: #".$comment['userId'].'- '.$comment['commentId']."\n";
		continue;	
	}
	
	$url = $blogUrl.'/'.$post['url'];
	$getIndex = $model->getAll('page_index', array('moduleId' => $module['moduleId'], 'itemId' => $comment['postId'], 'siteId' => $getSite['siteId']));
	if($getIndex AND count($getIndex) > 0){
		$url = $getSite['url'].'/'.$getIndex[0]['url'];
	}
	
	$getThread = $disqus->getThread($url);
	if(!$getThread){
		//create thread
		$createThread = $disqus->createThread(array('title' => $post['title'], 'url' => $url, 'date' => $post['publishDate'],
												'slug' => $post['url']));
		
		if(!$createThread){
			echo "Thread creation failed - ".$post['title'].'" #'.$post['postId']."\n";
			continue;
		}
		$threadId = $getThread['id'];
	}
	else{
		$threadId = $getThread['thread']['id'];
	}
	
	
	$time = time();
	$userData = array('id' => $comment['userId'], 'username' => $user['username'], 'email' => $user['email'], 'url' => $getSite['url'].'/profile/user/'.$user['slug'],
					'avatar' => $getSite['url'].'/files/avatars/'.$user['avatar']);
	$remote = base64_encode(json_encode($userData)).' '.hash_hmac('sha1', base64_encode(json_encode($userData)).' '.$time, DISQUS_SECRET).' '.$time;
	$message = $comment['message'];
	$makePost = $disqus->makePost(array('message' => $message, 'remote_auth' => $remote, 'threadId' => $threadId));
	
	if(!$makePost){
		echo "Comment failed to post: ".$comment['commentId']."\n";
	}
	else{
		echo 'Success! #'.$comment['commentId'].' ('.$post['title'].")\n";
	}
	

	sleep(1);
}
