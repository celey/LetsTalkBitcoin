<?php
namespace App\RSS;
use App\Blog, App\Profile;
class PodProxy_Controller extends \App\ModControl
{
	function __construct()
	{
		parent::__construct();
		$this->model = new Blog\Post_Model;
        $this->profile_model = new Profile\User_Model;
	}
	
	protected function init()
	{
		$output = parent::init();
		ob_end_clean();
			
		if(isset($this->args[2])){
			$split = explode('.', $this->args[2]);
			$postId = $split[0];
			$getPost = $this->model->get('blog_posts', $postId);
			if($getPost){
				$getMeta = $this->model->getPostMeta($getPost['postId']);
				$audio = false;
				if(isset($getMeta['audio-url']) AND trim($getMeta['audio-url']) != ''){
					$audio = $getMeta['audio-url'];
				}
				elseif(isset($getMeta['soundcloud-id']) AND trim($getMeta['soundcloud-id']) != ''){
                    $api_key = SOUNDCLOUD_ID;
                    $profile = $this->profile_model->getUserProfile($getPost['userId'], 0, array('with-private' => true));
                    if(isset($profile['profile'])){
                        $profile = $profile['profile'];
                      //  dd($profile);
                        if(isset($profile['soundcloud-key']) AND trim($profile['soundcloud-key']['value']) != ''){
                            $api_key = $profile['soundcloud-key']['value'];
                        }
                        
                    }
					$audio = 'http://api.soundcloud.com/tracks/'.$getMeta['soundcloud-id'].'/stream?client_id='.$api_key.'&ltb.mp3';
				}
				if($audio !== false AND !botdetect()){
					header("HTTP/1.1 301 Moved Permanently"); 
					header('Location: '.$audio);
					die();
				}
			}
		}
		$output['view'] = '404';
		return $output;
	}
}
