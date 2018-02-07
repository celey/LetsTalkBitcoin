<?php
ini_set('display_errors', 0);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$btc = new \API\Bitcoin(BTC_CONNECT);
$xcp = new \API\Bitcoin(XCP_CONNECT);

$btc->walletpassphrase(XCP_WALLET, 300);

$get = $model->get('xcp_distribute', $argv[1]);
$addresses = json_decode($get['addressList'], true);
foreach($addresses as $addr => $amnt){
	$addresses[$addr] = (float)round($amnt / SATOSHI_MOD, 8);
}


try{
	$send = $btc->sendmany($get['account'],array($addresses)); 
}
catch(Exception $e){
	$send = $e->getMessage();
}
echo $send."\n";
$btc->walletlock();
