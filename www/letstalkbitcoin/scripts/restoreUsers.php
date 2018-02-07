<?php
ini_set('display_errors', 1);
$noForceSSL = true;
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');
$model = new \Core\Model;
$search = '%@rambler.ru%';
mb_internal_encoding('UTF-8');


function importRow($table, $data)
{
	$model = new \Core\Model;
	$useData = array();
	$fieldText = array();
	$itemId = 0;
	foreach($data as $k => $v){
		if($itemId == 0){
			$itemId = $v;
		}
		$useData[':'.$k] = $v;
		$fieldText[] = ' '.$k.' = :'.$k.' ';
	}
	
	$sql = 'INSERT INTO '.$table.' SET '.join(', ', $fieldText);
	$send = $model->sendQuery($sql, $useData);
	if(!$send){
		echo $table." row failed to add (".$itemId.")\n";
		return false;
	}
	echo $table." row success! (".$itemId.")\n";
	return true;
}

if(isset($argv[1]) AND isset($argv[2])){
	switch($argv[1]){
	case 'import':
		$file = $argv[2];
		$text = utf8_encode(file_get_contents($file));
		$text = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text);
		$text = preg_replace('/[^(\x20-\x7F)]*/','', $text);    
		$getFile = json_decode($text, true);
	
		if(!$getFile OR $getFile == null){
			echo "Error getting file \n";
			die();
		}
		
		$getDefault = $model->get('groups', 'default', array(), 'slug');
	
		foreach($getFile['items'] as $user){
			
			if($getDefault){
				$update = $model->insert('group_users', array('groupId' => $getDefault['groupId'], 'userId' => $user['user']['userId']));
				if($update){
					echo $user['user']['username']." added to default group!\n";
				}
				else{
					echo $user['user']['username']." failed\n";
				}
			}
			continue;
			
			importRow('users', $user['user']);
			foreach($user['sessions'] as $session){
				importRow('user_sessions', $session);
			}
			foreach($user['referrals'] as $ref){
				importRow('user_referrals', $ref);
			}
			foreach($user['profile'] as $prof){
				importRow('user_profileVals', $prof);
			}
			foreach($user['notifications'] as $notify){
				importRow('user_notifications', $notify);
			}
			foreach($user['meta'] as $meta){
				importRow('user_meta', $meta);
			}
			foreach($user['likes'] as $like){
				importRow('user_likes', $like);
			}
			foreach($user['words'] as $word){
				importRow('pop_words', $word);
			}
			foreach($user['addresses'] as $address){
				importRow('coin_addesses', $address);
			}
			foreach($user['topics'] as $topic){
				$posts = $topic['posts'];
				$likes = $topic['likes'];
				unset($topic['posts']);
				unset($topic['likes']);
				importRow('forum_topics', $topic);
				foreach($posts as $post){
					importRow('forum_posts', $post);
				}
				foreach($likes as $like){
					importRow('user_likes', $like);
				}
			}
			foreach($user['posts'] as $post){
				$likes = $post['likes'];
				unset($post['likes']);
				importRow('forum_posts', $post);
				foreach($likes as $like){
					importRow('user_likes', $like);
				}
			}
			foreach($user['subs'] as $sub){
				importRow('forum_subscriptions', $sub);
			}
			foreach($user['views'] as $view){
				importRow('pop_firstView', $view);
			}
			echo $user['user']['username']." complete \n";
		}
	
		break;
	}
}
else{
	$getUsers = $model->fetchAll('SELECT * FROM users WHERE email LIKE :search AND activated = 1', array(':search' => $search));
	$list = array('items' => array());
	foreach($getUsers as $user){
		$item = array();
		$item['user'] = $user;
		$item['sessions'] = $model->fetchAll('SELECT * FROM user_sessions WHERE userId = :id', array(':id' => $user['userId']));
		$item['referrals'] = $model->fetchAll('SELECT * FROM user_referrals WHERE userId = :id', array(':id' => $user['userId']));
		$item['profile'] = $model->fetchAll('SELECT * FROM user_profileVals WHERE userId = :id', array(':id' => $user['userId']));
		$item['notifications'] = $model->fetchAll('SELECT * FROM user_notifications WHERE userId = :id', array(':id' => $user['userId']));
		$item['meta'] = $model->fetchAll('SELECT * FROM user_meta WHERE userId = :id', array(':id' => $user['userId']));
		$item['likes'] = $model->fetchAll('SELECT * FROM user_likes WHERE userId = :id', array(':id' => $user['userId']));
		$item['words'] = $model->fetchAll('SELECT * FROM pop_words WHERE userId = :id', array(':id' => $user['userId']));
		$item['addresses'] = $model->fetchAll('SELECT * FROM coin_addresses WHERE userId = :id', array(':id' => $user['userId']));
		$item['topics'] = $model->fetchAll('SELECT * FROM forum_topics WHERE userId = :id', array(':id' => $user['userId']));
		foreach($item['topics'] as &$topic){
			$topic['posts'] = $model->fetchAll('SELECT* FROM forum_posts WHERE topicId = :topicId AND userId != :id', array(':id' => $user['userId'], ':topicId' => $topic['topicId']));
			$topic['likes'] = $model->fetchAll('SELECT* FROM user_likes WHERE itemId = :itemId AND type="topic" AND userId != :id', array(':id' => $user['userId'], ':itemId' => $topic['topicId']));
		}
		$item['posts'] = $model->fetchAll('SELECT * FROM forum_posts WHERE userId = :id', array(':id' => $user['userId']));
		foreach($item['posts'] as &$post){
			$post['likes'] = $model->fetchAll('SELECT* FROM user_likes WHERE itemId = :itemId AND type="post" AND userId != :id', array(':id' => $user['userId'], ':itemId' => $post['postId']));
		}
		$item['subs'] = $model->fetchAll('SELECT * FROM forum_subscriptions WHERE userId = :id', array(':id' => $user['userId']));
		$item['views'] = $model->fetchAll('SELECT * FROM pop_firstView WHERE userId = :id', array(':id' => $user['userId']));
		
		$list['items'][] = $item;
	}
	echo json_encode($list);
	die();
}
