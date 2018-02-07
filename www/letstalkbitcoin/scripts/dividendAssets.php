<?php
ini_set('display_errors', 1);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$inventory = new \App\Tokenly\Inventory_Model;
$btc = new \API\Bitcoin(BTC_CONNECT);
$xcp = new \API\Bitcoin(XCP_CONNECT);

$dividends = $xcp->get_dividends();
$output = array();
foreach($dividends as $row){
	$combo = $row['asset'].'_'.$row['dividend_asset'];
	if(!isset($output[$combo])){
		$output[$combo] = array('count' => 0, 'total' => 0, 'asset' => $row['asset'], 'dividend_asset' => $row['dividend_asset']);
	}
	$output[$combo]['count']++;
	$output[$combo]['total'] += $row['quantity_per_unit'];
	
}

aasort($output, 'count');
$output = array_reverse($output);

foreach($output as &$row){
	$getAsset = $inventory->getAssetData($row['dividend_asset']);
	if($getAsset['divisible']){
		$row['total'] = $row['total'] / SATOSHI_MOD;
	}
}

debug($output);
