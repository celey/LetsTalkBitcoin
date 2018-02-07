<?php
ini_set('display_errors', 0);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$btc = new \API\Bitcoin(BTC_CONNECT);
$xcp = new \API\Bitcoin(XCP_CONNECT);

//$test2 = $xcp->get_mempool();

$test2 = $xcp->get_credits();
//$test2 = $xcp->get_credits(array('filters' => array('field' => 'destination', 'value' => '15fx1Gqe4KodZvyzN6VUSkEmhCssrM1yD7', 'op' => '=')));

//$test = $xcp->getrawtransaction(array('tx_hash' => $argv[1]));
//$test2 = $xcp->get_tx_info(array('tx_hex' => $test));
debug($test2);
die();

$btc->walletpassphrase(XCP_WALLET, 300);

$pubkey = null;
if(isset($argv[5])){
	$pubkey = $argv[5];
}

$sendXCP = $xcp->create_send(array('source' => $argv[1],
									'destination' => $argv[2],
									'asset' => $argv[3],
									'quantity' => intval($argv[4])*SATOSHI_MOD,
									'encoding' => 'opreturn',
									'allow_unconfirmed_inputs' => false,
									'fee_per_kb' => 50000,
									'pubkey' => $pubkey));

$sign = $btc->signrawtransaction($sendXCP);
$send = $btc->sendrawtransaction($sign['hex']);
echo $send."\n";
