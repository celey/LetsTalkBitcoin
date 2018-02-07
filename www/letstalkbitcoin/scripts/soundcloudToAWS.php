<?php
ini_set('display_errors', 1);
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \App\Blog\Post_Model;
$sc = new \API\Soundcloud;
$aws = new \API\AWS('s3');
$path = SITE_PATH.'/files/podcasts';
$fieldId = 5;

$getField = $model->get('blog_postMetaTypes', $fieldId);
$getPosts = $model->getAll('blog_posts');

foreach($getPosts as $post){
	$post['meta'] = $model->getPostMeta($post['postId']);
	if($post['published'] == 0 OR (isset($post['meta']['audio-url']) AND trim($post['meta']['audio-url']) != '')
		OR (!isset($post['meta']['soundcloud-id']) OR trim($post['meta']['soundcloud-id']) == '')){
		continue;
	}
	
	$filename = genURL($post['title']).'.mp3';
	$fullPath = $path.'/'.$filename;
	if(!file_exists($fullPath)){
		try{
			$download = $sc->downloadTrack($post['meta']['soundcloud-id'], $fullPath);
		}
		catch(Exception $e){
			echo $e->getMessage().' - ['.$post['title']."] \n";
			continue;
		}
		echo 'Audio downloaded for ['.$post['title']."] \n";
	}
	
	$checkAws = $aws->checkItemExists('podcasts/'.$filename);
	if(!$checkAws){
		$awsData = array('file' => $fullPath, 'folder' => 'podcasts');
		try{
			$upload = $aws->uploadFile($awsData);
		}
		catch(Exception $e){
			echo $e->getMessage().' - ['.$post['title']."] \n";
			continue;
		}
		

		echo 'Audio uploaded to AWS successfully - ['.$post['title']."] \n";
	}
	else{
		$upload = $aws->getUrl('podcasts/'.$filename);
		if(!$upload){
			echo 'Could not get AWS S3 link for ['.$post['title']."] \n";
			continue;
		}
	}
	

	$getVal = $model->fetchSingle('SELECT * FROM blog_postMeta WHERE postId = :postId AND metaTypeId = :typeId',
								array(':postId' => $post['postId'], ':typeId' => $fieldId));
	
	$insertData = array('value' => $upload);
	if($getVal){
		$update = $model->edit('blog_postMeta', $getVal['metaId'], $insertData);
	}
	else{
		//insert new one
		$insertData['postId'] = $post['postId'];
		$insertData['metaTypeId'] = $fieldId;
		$update = $model->insert('blog_postMeta', $insertData);
	}
	
	if($update){
		echo 'Audio URL updated for '.$post['title']."\n";
	}
	
	
}
