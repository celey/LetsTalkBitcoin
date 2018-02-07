<?php
ini_set('display_errors', 1);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');
$model = new \Core\Model;

$orders = $model->getAll('payment_order', array('complete' => 1), array(), 'orderId', 'asc');
$report = array();
foreach($orders as &$order){
	$order['orderData'] = json_decode($order['orderData'], true);
	
	$item = array();
	$item['id'] = $order['orderId'];
	$item['type'] = $order['orderType'];
	$item['amount'] = $order['amount'];
	$item['asset'] = $order['asset'];
	$item['time'] = date('Y-m-d', strtotime($order['completeTime']));
	$item['address'] = $order['address'];
	$item['product'] = 'N/A';
	$item['customer'] = 'N/A';
	
	switch($order['orderType']){
		case 'tca-forum':
			$item['product'] = 'Token Society: '.$order['orderData']['board'];
			$getUser = $model->get('users', $order['orderData']['userId']);
			if($getUser){
				$item['customer'] = $getUser['email'];
			}
			break;
		case 'blog-submission-credits':
			$item['product'] = $order['orderData']['credits'].' Submission Credits';
			$getUser = $model->get('users', $order['orderData']['userId']);
			if($getUser){
				$item['customer'] = $getUser['email'];
			}
			break;
		case 'ad-purchase':
			$item['customer'] = $order['orderData']['customer_email'];
			switch($order['orderData']['ad_type']){
				case 'sponsor':
					$item['product'] = @$order['orderData']['show'].' - '.@$order['orderData']['package'];
					break;
				case 'product':
					$item['product'] = @$order['orderData']['product'].' - '.@$order['orderData']['package'];
					break;
				case 'display':
					$item['product'] = @$order['orderData']['adspace'].' - '.@$order['orderData']['package'];
					break;
				case 'consult':
					$item['product'] = @$order['orderData']['consultant'].' - '.@$order['orderData']['package'];
					break;
			}
			break;
	}
	
	$report[] = $item;
	
}


echo '"Order ID","Customer","Order Type","Purchase","Amount","Asset","Payment Address","Payment Date"'."\n";
foreach($report as $row){
	echo '"'.$row['id'].'","'.$row['customer'].'","'.$row['type'].'","'.$row['product'].'","'.$row['amount'].'","'.$row['asset'].'","'.$row['address'].'","'.$row['time'].'"'."\n";
}
