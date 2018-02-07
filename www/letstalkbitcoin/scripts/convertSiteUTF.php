<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$tables = $model->fetchAll("SHOW TABLES");



foreach($tables as $table){
	$table = $table['Tables_in_ltb'];
	$exec = $model->sendQuery('alter table '.$table.' convert to character set utf8 collate utf8_unicode_ci');
	if($exec){
		echo 'Table updated: '.$table."\n";
	}
	else{
		echo 'Error converting table: '.$table."\n";
	}
}
