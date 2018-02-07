<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;

$getBalances = $model->getAll('xcp_balances', array(), array(), 'balanceId', 'desc');
$userBalances = array();

foreach($getBalances as $balance){
	$getAddress = $model->get('coin_addresses', $balance['addressId']);
	$getUser = $model->get('users', $getAddress['userId']);
	$userId = $getUser['userId'];
	if(!isset($userBalances[$userId])){
		$userBalances[$userId] = array();
	}
	if(in_array($balance['asset'], $userBalances[$userId])){
		$delete = $model->delete('xcp_balances', $balance['balanceId']);
		if($delete){
			echo 'Deleted dupe asset balance for '.$getUser['username'].' ['.$balance['asset']."]\n";
		}
		else{
			echo 'Error deleting asset balance for '.$getUser['username'].' ['.$balance['asset']."]\n";
		}
		continue;
	}
	else{
		$userBalances[$userId][] = $balance['asset'];
	}
}
