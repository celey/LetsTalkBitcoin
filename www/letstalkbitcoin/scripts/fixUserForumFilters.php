<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \App\Forum\Board_Model;
$meta = new \App\Meta_Model;

$getUsers = $model->getAll('users');

foreach($getUsers as $user){
	$getFilters = $meta->getUserMeta($user['userId'], 'boardFilters');
	if(!$getFilters){
		$getFilters = array();
	}
	else{
		$getFilters = explode(',', $getFilters);
	}
	if(count($getFilters) == 0){
		continue;
	}
	$update = $model->updateBoardFilters($user, $getFilters);
	if($update){
		echo $user['username'].' Success!'.PHP_EOL;
	}
	else{
		echo $user['username'].' failed...'.PHP_EOL;
	}
}
