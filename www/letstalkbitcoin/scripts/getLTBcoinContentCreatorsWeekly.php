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

$whitelist = array('adam', 'Legendface66', 'johnbarrett', 'SovBTC', 'Rob', 'CoinFire', 'mdw', 'john', 'bcohen');

foreach($reports as $report){
	foreach($report as $dist){
		foreach($dist['report']['info'] as $row){
			$userAddress = $row['address'];
			foreach($dist['distribute']['addressList'] as $addr => $val){
				if($addr == $userAddress){
					if(!isset($userList[$row['userId']][$dist['report']['reportDate']])){
						$entry = array();
						$getUser = $model->get('users', $row['userId']);
						//if(!$getUser OR !in_array($getUser['username'], $whitelist)){
						if(!$getUser){
							continue 2;
						}

						$entry['username'] = $getUser['username'];
						$entry['email'] = $getUser['email'];
						$entry['ltb_earned'] = 0;
						$entry['date'] = date('Y-m-d', strtotime($dist['report']['reportDate']));
						$end_date = strtotime('2016-01-01 23:00:00');
						if(strtotime($entry['date']) < $end_date){
							continue;
						}		
						$userList[$row['userId']][$dist['report']['reportDate']] = $entry;
					}
					$userList[$row['userId']][$dist['report']['reportDate']]['ltb_earned'] += $val / SATOSHI_MOD;
				}
			}
		}
	}
}


echo '"Username","Email","LTBcoin Earned","Date"'."\n";
foreach($userList as $userId => $rows){
	aasort($rows, 'date');
	foreach($rows as $user){
		echo '"'.$user['username'].'","'.$user['email'].'","'.$user['ltb_earned'].'","'.$user['date'].'"'."\n";
	}
}
