<?php
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \App\Tokenly\Distribute_Model;

$get = $model->fetchSingle('SELECT * FROM xcp_distribute WHERE distributeId = '.$argv[1]);

if(!$get){
	die('Distro not found'.PHP_EOL);
}

$get['txInfo'] = json_decode($get['txInfo'], true);
$get['addressList'] = json_decode($get['addressList'], true);


//dd($get['account']);

$bitcoin = new \API\Bitcoin(BTC_CONNECT);
//dd($bitcoin->getaddressunspent($get['address']));
$do = $bitcoin->combineaddressutxos($get['address']);
var_dump($do);

die();

$prime = $bitcoin->primeaddressinputs($get['address'], 650, 0.0001, 95, 2);
var_dump($prime);

die();


foreach($get['addressList'] as $address => $amnt){
	$users = $model->lookupAddress($address);
	foreach($users['users'] as $user){
		$has_posts = $model->get('forum_posts', $user['userId'], array(), 'userId');
		$has_threads = $model->get('forum_topics', $user['userId'], array(), 'userId');
		if($has_posts OR $has_threads){
			continue;
		}
		echo $user['email'].PHP_EOL;
	}
	
}
