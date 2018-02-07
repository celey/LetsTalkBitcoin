<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \App\Meta_Model;

$getUsers = $model->fetchAll('SELECT userId, username, auth, lastActive, lastAuth FROM users WHERE auth != ""');
foreach($getUsers as $user){
	$getIP = $model->getUserMeta($user['userId'], 'IP_ADDRESS');
	if(!$getIP){
		$getIP = '0.0.0.0';
	}
	$insert = $model->insert('user_sessions', array('userId' => $user['userId'], 'auth' => $user['auth'], 'IP' => $getIP,
													   'authTime' => $user['lastAuth'], 'lastActive' => $user['lastActive']));
	
	if($insert){
		echo $user['username']." auth key updated!\n";
	}
	else{
		echo 'Error updating '.$user['username']."\n";
	}
}
