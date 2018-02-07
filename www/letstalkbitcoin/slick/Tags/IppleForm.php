<?php
namespace Tags;
use Core, App, App\Account, App\Tokenly, UI, Util, API;
class IppleForm
{
	function __construct()
	{
		$this->model = new \App\Meta_Model;
		$this->site = $this->model->get('sites', $_SERVER['HTTP_HOST'], array(), 'domain'); //get basic site data
		$this->inventory = new Tokenly\Inventory_Model; //load inventory model
		$this->user = Account\Home_Model::userInfo(); //load user data
		$this->token_address = '1DR1nox9sFHwqsbs9AcH23irNZQo7rVuLe';
		$this->useAsset = 'IPPLE';
		$this->secret = "jobs' cr347ion";
		$this->token_account = 'ARG1_TURING';
		$this->bonusReward = 0.2;
		//$this->bonusReward = 0.0001;
		$this->useBonus = true;

	}
	
	
	public function display()
	{
		if(!$this->user){
			header('Location: '.$this->site['url']);
			die();
		}
		
		$message = '';
		if(posted()){
			try{
				$message = $this->checkSecret();
			}
			catch(\Exception $e){
				$message = $e->getMessage();
			}
		}
		
		ob_start();
		?>
		
		<?php
		if($message != ''){
			echo '<p><strong>'.$message.'</strong></p>';
		}
		?>
		<video width="600" height="400" controls="controls">
			<source src="https://s3-us-west-1.amazonaws.com/letstalkbitcoin/videos/TheMan.mp4" type="video/mp4" />
		</video>
		<form action="" method="post">
			<input type="hidden" name="look_again" />
			<input type="password" name="derp" required="required" placeholder="..." style="display: inline-block;">
			<input type="submit" value="Go" style="display: inline-block;" />
		<?php
			require_once(SITE_PATH.'/resources/recaptchalib.php');
			echo recaptcha_get_html(CAPTCHA_PUB, null, true)
		?>
			
		</form>
		
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
	
	public function checkSecret()
	{
		if(!isset($_POST['derp']) OR trim($_POST['derp']) == ''){
			throw new \Exception('Nothing submitted..');
		}
		
		require_once(SITE_PATH.'/resources/recaptchalib.php');
		$resp = recaptcha_check_answer (CAPTCHA_PRIV,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);

		if(!$resp->is_valid) {
			throw new \Exception('Captcha invalid!');
		}		
		
		if(trim(strtolower($_POST['derp'])) != $this->secret){
			throw new \Exception('Wrong');
		}
		
		$getBalances = $this->inventory->getUserBalances($this->user['userId'], false, 'btc', true, true);
		
		if(count($getBalances) == 0){
			throw new \Exception('Error: you have no verified addresses. Please visit the Address Manager');
		}

		$useAddress = false;
		foreach($getBalances as $address => $addressBalances){
			$useAddress = $address;
			break;
		}

		$gameData = $this->model->getUserMeta($this->user['userId'], 'arg_game1');
		if(!$gameData){
			$gameData = array();
		}
		else{
			$gameData = json_decode($gameData, true);
		}
		
		if(isset($gameData['ipple_sent'])){
			throw new \Exception('Key token already sent!');
		}
		
		$xcp = new API\Bitcoin(XCP_CONNECT);
		$btc = new API\Bitcoin(BTC_CONNECT);
		try{
			$getServerBalance = $xcp->get_balances(array('filters' => array('field' => 'address', 'op' => '=', 'value' => $this->token_address)));
		}
		catch(\Exception $e){
			throw new \Exception('Could not connect to CounterParty');
		}			
		$serverBalance = 0;
		foreach($getServerBalance as $row){
			if($row['asset'] == $this->useAsset){
				$serverBalance += $row['quantity'];
			}
		}
		
		if($serverBalance <= 0){
			throw new \Exception('No tokens left...');
		}
		
		if(!$this->useBonus){
			$firstWinner = false;
		}
		else{
			$firstWinner = true;
			$getAllMeta = $this->model->getAll('user_meta', array('metaKey' => 'arg_game1'));
			foreach($getAllMeta as $playerMeta){
				$playerGame = json_decode($playerMeta['metaValue'], true);
				if(isset($playerGame['ipple_bonus'])){
					$firstWinner = false;
				}
			}
		}
		
		$sendData = array('source' => $this->token_address, 'destination' => $useAddress, 'asset' => $this->useAsset, 'quantity' => 1, 'allow_unconfirmed_inputs' => true);
		try{
			$btc->walletpassphrase(XCP_WALLET, 60);
			$getRaw = $xcp->create_send($sendData);
			$sign = $btc->signrawtransaction($getRaw);
			$send = $btc->sendrawtransaction($sign['hex']);
			
			if($firstWinner){
				$sendBonus = $btc->sendfrom($this->token_account, $useAddress, $this->bonusReward);
			}
			$btc->walletlock();
		}
		catch(\Exception $e){
			throw new \Exception('Error sending token');
		}
		try{
			$btc->walletlock();
		}
		catch(\Exception $e){
			//do nothing
		}
		
		$message =  'Key token sent to <a href="https://blockchain.info/address/'.$useAddress.'" target="_blank">'.$useAddress.'</a>. Congrats!';
		$gameData['ipple_sent'] = array('time' => timestamp(), 'tx' => $send);
		if($firstWinner){
			$gameData['ipple_bonus'] = array('time' => timestamp(), 'tx' => $sendBonus, 'amount' => $this->bonusReward);
			$message .= '<br><br>As the first person to get the correct answer, you have received a '.$this->bonusReward.' BTC bonus!';
		}
		$this->model->updateUserMeta($this->user['userId'], 'arg_game1', json_encode($gameData));
		
		return $message;
				
	
	}
	
	
}
