<?php
ini_set('display_errors', 1);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;

if(!isset($argv[1])){
	die('Please enter a file name containing user JSON data'."\n");
}

$get = file_get_contents($argv[1]);
if(!$get){
	die("Error loading file\n");
}

$decode = json_decode(trim($get), true);
if(!is_array($decode) OR !isset($decode['user']) OR !isset($decode['rel_data'])){
	die("Error parsing file \n");
}

$model = new Core\Model;

function importRow($model, $table, $row)
{
	$values = array();
	$first_key = false;
	foreach($row as $k => $v){
		$values[':'.$k] = $v;
		$first_key = $k;
	}
	if(!$first_key){
		return false;
	}
	$field_list = array();
	$value_list = array();
	foreach($row as $k => $v){
		$field_list[] = $k;
		$value_list[] = ':'.$k;
	}
	$sql = 'INSERT INTO '.$table.' ('.join(',',$field_list).') VALUES('.join(',',$value_list).') ON DUPLICATE KEY UPDATE '.$first_key.' = '.$first_key;
	return $model->sendQuery($sql, $values);
}

function firstKey($array = array())
{
	foreach($array as $k => $v){
		return $k;
	}
	return false;
}


$insert_user = importRow($model, 'users', $decode['user']);
if(!$insert_user){
	die("Error importing user\n");
}

echo 'User '.$decode['user']['username'].' (#'.$decode['user']['userId'].') imported!'."\n";

foreach($decode['rel_data'] as $table => $data){
	foreach($data['rows'] as $row){
		$primary = firstKey($row);
		$import = importRow($model, $table, $row);
		if($import){
			echo $table.' - '.$row[$primary]." imported \n";
		}
		else{
			echo "Failed import for ".$table." - ".$row[$primary]." \n";
		}
	}
	if($data['subs'] AND count($data['subs']) > 0){
		foreach($data['subs'] as $sub_table => $sub_rows){
			if(is_array($sub_rows)){
				foreach($sub_rows as $sub_rows2){
					foreach($sub_rows2 as $sub_row){
						$primary = firstKey($sub_row);
						$import = importRow($model, $sub_table, $sub_row);
						if($import){
							echo $table.':'.$sub_table.' - '.$sub_row[$primary]." imported \n";
						}
						else{
							echo "Failed import for ".$table.":".$sub_table." - ".$sub_row[$primary]." \n";
						}
					}
				}
			}
			
		}
	}
}
echo 'User '.$decode['user']['username'].' (#'.$decode['user']['userId'].') import finished!'."\n";
