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


$output = '';
$decode = json_decode($get['addressList'], true);
foreach($decode as $address => $amount){
	$output .= $address.','.round(($amount/100000000),8).PHP_EOL;
}	
echo $output;
