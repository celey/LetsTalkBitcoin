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
$fee = 0.0001;
if(isset($argv[4])){
	$fee = floatval($argv[4]);
}
$send = $btc->sendfromaddress($argv[1],floatval($argv[2]), $argv[3], $fee); 
echo $send."\n";
$btc->walletlock();
