<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$minPosts = 5;
$coinAddressField = 12;
$totalDist = 2250000;

$model = new \App\Profile\User_Model;

$getUsers = $model->getUsersWithProfile($coinAddressField);

$userList = array();

foreach($getUsers as $user){
	$getPosts = intval(\App\Account\Home_Model::getUserPostCount($user['userId']));
	if($getPosts >= $minPosts){
		$user['numPosts'] = $getPosts;
		$userList[] = $user;
	}
}

$coinPerAddress = $totalDist / count($userList);

//build CSV
$output = array();
$output[] = array('User', 'LTBcoin Receiving', '# Posts Made');
foreach($userList as $user){
	$row = array();
	$row[] = $user['username'];
	$row[] = $coinPerAddress;
	$row[] = $user['numPosts'];
	$output[] = $row;
}

$csv = arrayToCSV($output);
echo trim($csv);
