<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;

$get = $model->getAll('user_profileVals', array('fieldId' => PRIMARY_TOKEN_FIELD));
$getField = $model->get('profile_fields', PRIMARY_TOKEN_FIELD);
$validate = new \API\BTCValidate;

foreach($get as $row){
	if(!$validate->checkAddress($row['value'])){
		continue;
	}
	
	$getUser = $model->get('users', $row['userId']);
	$getAddress = $model->getAll('coin_addresses', array('userId' => $row['userId'], 'address' => $row['value']));
	if(count($getAddress) == 0){
		$model->sendQuery('UPDATE coin_addresses SET isPrimary = 0 WHERE userId = :id', array(':id' => $row['userId']));
		$insert = $model->insert('coin_addresses', array('userId' => $row['userId'], 'address' => $row['value'], 'submitDate' => timestamp(),
								'isXCP' => 1, 'isPrimary' => 1, 'label' => $getField['label'], 'type' => 'btc'));
		if($insert){
			echo 'Address ['.$row['value'].'] added for '.$getUser['username']."\n";
		}
		else{
			echo 'Error adding address ['.$row['value'].'] for '.$getUser['username']."\n";
		}
		
	}
	
}
