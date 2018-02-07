<?php
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;


//$exclude = array(225,230,240,263,282,327,347,349,348,408,449,694,721,750,944,994,);

$cats = array(11, 25, 28, 36, 37, 44, 45, 54, 55, 56, 61, 68, 69, 57, 22, 32, 24, 29, 26, 53, 47, 62, 75);
$posts = $model->fetchAll('SELECT b.* FROM blog_posts b
						   LEFT JOIN blog_postCategories pc ON pc.postId = b.postId
						   WHERE b.publishDate > "2015-10-01 00:00:00"
						   AND pc.categoryId IN('.join(',', $cats).')
						   AND b.status = "published"
						   GROUP BY b.postId');


$disqus = new \API\Disqus;
$output = array();
$site = currentSite();
foreach($posts as $row){
	$item = array();
	$item['id'] = $row['postId'];
	$item['title'] = $row['title'];
	$item['views'] = $row['views'];
	$item['comments'] = $row['commentCount'];
	$getWords = $model->fetchSingle('SELECT count(*) as total FROM pop_words WHERE itemId = :id', array(':id' => $row['postId']));
	$item['words'] = 0;
	if($getWords){
		$item['words'] = $getWords['total'];
	}
	$item['time'] = strtotime($row['publishDate']);
	$output[] = $item;
}
aasort($output, 'time');


echo '"ID","Title","Views","Comments","Magic Words","Publish Date"'."\n";
foreach($output as $item){
	echo '"'.$item['id'].'","'.str_replace('"', '', $item['title']).'","'.$item['views'].'","'.$item['comments'].'","'.$item['words'].'","'.date('Y/m/d H:i', $item['time']).'"'."\n";
	
}
//debug($output);
