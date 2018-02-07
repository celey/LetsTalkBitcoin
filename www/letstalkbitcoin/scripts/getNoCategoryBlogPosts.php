<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;

$posts = $model->fetchAll('SELECT postId, title, url FROM blog_posts WHERE status = "published" OR published = 1');
$missing = array();

foreach($posts as $post){
	$cats = $model->getAll('blog_postCategories', array('postId' => $post['postId']));
	if($cats){
		foreach($cats as $k => $cat){
			$getCat = $model->get('blog_categories', $cat['categoryId']);
			if(!$getCat){
				unset($cats[$k]);
				continue;
			}
		}
	}
	if(!$cats OR count($cats) == 0){
		$missing[] = $post;
	}
}

debug($missing);
