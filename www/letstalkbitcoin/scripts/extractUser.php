<?php
ini_set('display_errors', 1);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config2.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;

if(!isset($argv[1])){
	die('Please enter User ID or username'."\n");
}

$getUser = $model->fetchSingle('SELECT * FROM users WHERE userId = :id OR username = :username',
							   array(':id' => $argv[1], ':username' => $argv[1]));

if(!$getUser){
	die('User '.$argv[1].' not found'."\n");
}

function firstKey($array = array())
{
	foreach($array as $k => $v){
		return $k;
	}
	return false;
}

$tables = array('blog_comments', 'blog_contributors',
				'blog_posts' => array(
					'blog_comments',
					'blog_contributors',
					'blog_postCategories',
					'blog_postMeta'),
				'blogs' => array(
					'blog_categories',
					'blog_roles',
					'blog_comments'),
				'board_subscriptions',
				'coin_addresses',
				'forum_mods',
				'forum_posts',
				'forum_subscriptions',
				'forum_topics',
				'group_users',
				'pop_firstView',
				'pop_words',
				'private_messages',
				'token_access',
				'user_invites',
				'user_likes',
				'user_meta',
				'user_notifications',
				'user_profileVals',
				'user_referrals',
			);

$output = array();
$output['user'] = $getUser;
$output['rel_data'] = array();

foreach($tables as $k => $table){
	$table_name = $table;
	$subs = false;
	if(is_array($table)){
		$table_name = $k;
		$subs = $table;
	}
	$output['rel_data'][$table_name] = array('rows' => $model->getAll($table_name, array('userId' => $getUser['userId'])), 'subs' => array());
	if($subs){
		foreach($subs as $sub){
			foreach($output['rel_data'][$table_name]['rows'] as $k => $row){
				$primary = firstKey($row);
				if(!$primary){
					continue;
				}
				$output['rel_data'][$table_name]['subs'][$sub][$k] = $model->getAll($sub, array($primary => $row[$primary]));
			}
		}
	}
	
}

echo json_encode($output);

