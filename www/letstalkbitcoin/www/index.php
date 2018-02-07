<?php
$startTime = microtime(true);
ini_set('display_errors', 0);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');
//setup session cookie to work accross subdomains
$expDomain = explode('.', $_SERVER['HTTP_HOST']);
if(count($expDomain) > 2){
	unset($expDomain[0]);
}

$domainJoin = join('.', $expDomain);
ini_set('session.cookie_domain', '.'.$domainJoin);
session_start();

\Core\Model::$logMode = true;
ob_start();
$ltb = new \App\Controller;
$ltb->init();

$outputSite = trim(ob_get_contents());

ob_end_clean();
echo $outputSite;

$log = \Core\Model::$queryLog;
//debug($log);
$timeSpent = 0;
foreach($log as $item){
	foreach($item['exec-times'] as $time){
		$timeSpent+= $time;
	}
}

echo '<!--"';
echo "Generation time: " . number_format(( microtime(true) - $startTime), 4) . " Seconds\n";
echo ' - Total Queries: '.\Core\Model::$numQueries.' ('.$timeSpent.')';
echo "-->";


