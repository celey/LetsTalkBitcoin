<?php
namespace Tags;
use UI, Util, API, Core, App, App\Tokenly, App\Account;
class ABPTorch
{
	function __construct()
	{
		$this->site = currentSite();
		$this->model = new \App\Meta_Model;
		$this->inventory = new Tokenly\Inventory_Model; //load inventory model
		$this->user = Account\Home_Model::userInfo(); //load user data
		$this->token_address = '19hFea3xH8gYfiAXP7RZ4jNc9xhu9SWzVo';
		$this->useAsset = 'FIRED';
		$this->secret = "b34u7ty, truth, and rarity";
		$this->token_account = 'ARG1_FIRED';
		$this->bonusReward = 0;
		//$this->bonusReward = 0.0001;
		$this->useBonus = false;
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
				
		$captcha = new UI\Captcha;
		ob_start();
		?>
		<?php
		if($message != ''){
			echo '<p><strong>'.$message.'</strong></p>';
		}
		?>		
		<img src="<?= $this->site['url'] ?>/resources/abpt/hyap.jpg" alt="r3ts@m" data-reverse="true" />
		<br />
		<form action="" method="post">
		  <input type="text" name="cheddar" required />
			<?= $captcha->display() ?>
		  <input type="submit" value="Submit">
		</form>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
	
	public function checkSecret()
	{
		if(!isset($_POST['cheddar']) OR trim($_POST['cheddar']) == ''){
			throw new \Exception('Nothing submitted..');
		}
		
		require_once(SITE_PATH.'/resources/recaptchalib2.php');
		$recaptcha = new \ReCaptcha(CAPTCHA_PRIV);
		$resp = $recaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $_POST['g-recaptcha-response']);
		if($resp == null OR !$resp->success){
			throw new \Exception('Captcha invalid!');
		}
		
		if(trim($_POST['cheddar']) != $this->secret){
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
		
		if(isset($gameData['fired_sent'])){
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
		
		try{
			
			$getAddress = $btc->validateaddress($this->token_address);
			if(!$getAddress OR !$getAddress['ismine']){
				throw new \Exception('Error sending Token');
			}
			
			$sendData = array('source' => $this->token_address, 'destination' => $useAddress,
							  'asset' => $this->useAsset, 'quantity' => 1, 'allow_unconfirmed_inputs' => true,
							  'pubkey' => $getAddress['pubkey']);
			$btc->walletpassphrase(XCP_WALLET, 60);
			$getRaw = $xcp->create_send($sendData);
			$sign = $btc->signrawtransaction($getRaw);
			$send = $btc->sendrawtransaction($sign['hex']);

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
		$gameData['fired_sent'] = array('time' => timestamp(), 'tx' => $send);
		$this->model->updateUserMeta($this->user['userId'], 'arg_game1', json_encode($gameData));
		
		return $message;
				
	
	}
	
}


