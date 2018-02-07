<?php
ini_set('display_errors', 0);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$btc = new \API\Bitcoin(BTC_CONNECT);
$xcp = new \API\Bitcoin(XCP_CONNECT);

//$btc->walletpassphrase(XCP_WALLET, 300);

$get = $btc->listtransactions("", 9999);

$unconf = array();
foreach($get as $row){
	if($row['confirmations'] == 0){
		$unconf[] = $row;
	}
}

foreach($unconf as $tx){
	$raw = $btc->getrawtransaction($tx['txid']);
	$send = $btc->sendrawtransaction($raw);
	echo "TX sent: ".$send." - ".timestamp()."\n";

}

echo "...done \n";
