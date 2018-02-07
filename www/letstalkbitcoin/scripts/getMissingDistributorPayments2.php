<?php
ini_set('display_errors', 1);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \App\Tokenly\Distribute_Model;

$id = intval($argv[1]);
$get = $model->get('xcp_distribute', $id);

if(!$get){
	die("Distribution not found");
}

$get['addressList'] = json_decode($get['addressList'], true);
$get['txInfo'] = json_decode($get['txInfo'], true);

$btc = new \API\Bitcoin(BTC_CONNECT);
$xcp = new \API\Bitcoin(XCP_CONNECT);

$get_sends = $xcp->get_sends(array('filters' => array('field' => 'source', 'op' => '=', 'value' => $get['address'])));
$missing = array();
$found_items = array();
$k_trigger = 0;
$num = 0;
foreach($get['addressList'] as $addr => $amount){
	$found = false;
	foreach($get_sends as $send){
		if($send['destination'] == $addr){
			$found = $send;
			break;
		}
	}
	if(!$found){
		$missing[$addr] = $amount;
		if($k_trigger == 0){
			$k_trigger = $num;
		}
	}
	else{
		$found_items[] = $found;
	}
	$num++;
}

print_r($missing);
var_dump(count($missing));
var_dump(count($found_items));
var_dump($k_trigger);
//var_dump($btc->getaddressunspent($get['address']));
