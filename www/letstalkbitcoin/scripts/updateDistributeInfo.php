<?php
ini_set('display_errors', 0);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;

$getDistro = $model->get('xcp_distribute', 594);

$getDistro['txInfo'] = json_decode($getDistro['txInfo'], true);
$getDistro['addressList'] = json_decode($getDistro['addressList'], true);
$missing = array();
foreach($getDistro['addressList'] as $address => $amnt){
	$found = false;
	foreach($getDistro['txInfo'] as $tx){
		if($tx['details'][1] == $address){
			$found = true;
			break;
		}
	}
	if(!$found){
		$missing[] = $address;
	}
}

dd($missing);
