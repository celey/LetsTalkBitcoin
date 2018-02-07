<?php
ini_set('display_errors', 1);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');
$model = new \Core\Model;
$stats = new \Tags\LTBStats;

$getPub = $stats->getPoolData('poq', true);
$getVal = $stats->getPoolData('pov', true);

$reports = array($getPub, $getVal);

$userList = array();

foreach($reports as $report){
	foreach($report as $dist){
		foreach($dist['report']['info'] as $row){
			$userAddress = $row['address'];
			foreach($dist['distribute']['addressList'] as $addr => $val){
				if($addr == $userAddress){
					if(!isset($userList[$row['userId']])){
						$entry = array();
						$getUser = $model->get('users', $row['userId']);
						if(!$getUser){
							continue 2;
						}
						$entry['username'] = $getUser['username'];
						$entry['email'] = $getUser['email'];
						$entry['ltb_earned'] = 0;
						
						$userList[$row['userId']] = $entry;
					}
					$userList[$row['userId']]['ltb_earned'] += $val / SATOSHI_MOD;
				}
			}
		}
	}
}

//debug($userList);

echo '"Username","Email","LTBcoin Earned"'."\n";
foreach($userList as $userId => $user){
	echo '"'.$user['username'].'","'.$user['email'].'","'.$user['ltb_earned'].'"'."\n";
}
