<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$getPosts = $model->getAll('blog_posts', array(), array('postId', 'userId', 'editedBy', 'postDate', 'title', 'url', 'editTime', 'publishDate'));

foreach($getPosts as $post){
	
	if($post['editedBy'] != 0 AND $post['editedBy'] != $post['userId']){
		$checkContrib = $model->fetchSingle('SELECT * FROM user_invites
											 WHERE userId = :userId AND type = "blog_contributor"
											 AND accepted = 1 AND itemId = :postId',
											 array(':userId' => $post['editedBy'], ':postId' => $post['postId']));
		if($checkContrib){
			continue;
		}
		$inviteData = array('userId' => $post['editedBy'], 'sendUser' => $post['userId'], 'acceptUser' => $post['editedBy'],
							'type' => 'blog_contributor', 'itemId' => $post['postId'], 'accepted' => 1, 'acceptCode' => md5($post['editedBy'].$post['postId'].microtime()),
							'inviteDate' => $post['postDate'], 'acceptDate' => $post['postDate'], 'class' => '\\App\\Blog\\Submissions_Model',
							'info' => '{"request_type":"invite","post_title":"'.$post['title'].'","request_role":"Editor","request_share":20}');

		$invite = $model->insert('user_invites', $inviteData);
		if($invite){
			$addContrib = $model->insert('blog_contributors', array('postId' => $post['postId'], 'inviteId' => $invite, 'role' => 'Editor', 'share' => 20));
			if($addContrib){
				echo $post['postId'].'-'.$post['editedBy']." success!\n";
				continue;
			}
		}
		echo $post['postId'].'-'.$post['editedBy']." fail\n";
	}
	
}
