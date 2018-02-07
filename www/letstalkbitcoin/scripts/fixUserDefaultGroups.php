<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$getUsers = $model->getAll('users');
$defaultGroups = $model->getAll('groups', array('isDefault' => 1));

foreach($getUsers as $user){
	$getGroups = $model->getAll('group_users', array('userId' => $user['userId']));
	if(count($getGroups) == 0){
		foreach($defaultGroups as $group){
			$add = $model->insert('group_users', array('userId' => $user['userId'], 'groupId' => $group['groupId']));
			if(!$add){
				echo 'Error adding default group for '.$user['username']."\n";
			}
			else{
				echo 'Default group added for '.$user['username']."\n";
			}
		}
	}
}
