<?php
ini_set('display_errors', 1);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \App\Tokenly\Distribute_Model;

$id = intval($argv[1]);
$get = $model->get('xcp_distribute', $id);
$get['addressList'] = json_decode($get['addressList'], true);
$get['txInfo'] = json_decode($get['txInfo'], true);

$xcp = new \API\Bitcoin(XCP_CONNECT);
$output = array();
foreach($get['addressList'] as $addr => $amnt){
	$sends = $xcp->get_sends(array('filters' => array('field' => 'destination', 'value' => $addr, 'op' => '=')));
	$item = array('total' => 0, 'sends' => 0, 'address' => $addr, 'request_amnt' => $amnt);
	foreach($sends as $send){
		if($send['source'] == $get['address']){
			$item['total'] += $send['quantity'];
			$item['sends']++;
		}
	}
	$output[] = $item;
}


foreach($output as $k => $row){
	if($row['total'] > 0){
		unset($output[$k]);
	}
}

/*
print_r($output);
echo "\n";
echo 'Total: '.count($output)."\n";
*/

foreach($output as $row){
	echo $row['address'].','.round($row['request_amnt'] / 100000000, 8)."\n";
}
