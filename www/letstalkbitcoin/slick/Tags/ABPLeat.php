<?php
namespace Tags;
use App, App\Tokenly, App\Account, UI, Util, API;
class ABPLeat
{
	function __construct()
	{
		$this->site = currentSite();
		$this->model = new \App\Meta_Model;
		$this->inventory = new Tokenly\Inventory_Model; //load inventory model
		$this->user = Account\Home_Model::userInfo(); //load user data
		$this->token_address = '1MArwmcosCBy18fMob8wgCbLWiqGuD2nqs';
		$this->useAsset = 'LEAT';
		$this->secret = "FE8F99F9888F888FF99F99BFF99FF9FA888F1F9F";
		$this->token_account = 'ARG1_LEAT';
		$this->bonusReward = 0;
		//$this->bonusReward = 0.0001;
		$this->useBonus = false;
	}
	
	public function display()
	{
		header('Location: https://letstalkbitcoin.com/torched-h34r7s'); //puzzles over.. redirect to other page
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
		<canvas id="display" width="800" height="600" style="width:100%!important;"></canvas>
		<br />
		<form action="" method="post">
		  <input type="text" name="herp" pattern="[0-9A-F]+" maxlength="40"
				 required />
			<?= $captcha->display() ?>
		  <input type="submit" value="Submit">
		</form>
		<script type="text/javascript">
		var numColumns = 4;
		var numRows = 4;

		var background = new Image;
		var startTime;
		var cellWidth;
		var cellHeight;

		var drawGrid = function(canvas, state) {
		  var context = canvas.getContext("2d");
		  context.clearRect(0, 0, canvas.width, canvas.height);
		  var x = 0;
		  var y = 0;
		  for(var i = 0; i < state.length; i++) {
			if(state[i] == "1") {
			  var xp = x * cellWidth;
			  var yp = y * cellHeight;
			  context.drawImage(background,
								xp, yp, cellWidth, cellHeight,
								xp, yp, cellWidth, cellHeight);
			}
			x++;
			if (x == numColumns) {
			  y++;
			  x = 0;
			}
		  }
		};

		var source = ["1001100111111001", "1111111010001111", "1000100010001111", "1000100010001111", "1111100110011111", "1001100110111111", "1111100110011111", "1111100111111010", "1000100010001111", "0001111110011111"];
		var messageCounter = 0;
		var message;

		var getMessage = function () {
		  messageCounter++;
		  message = source[messageCounter];
		  if (messageCounter > source.length) {
			messageCounter = 0;
		  }
		};

		var displayMessage = function () {
		  var canvas = $("#display")[0];
		  drawGrid(canvas, message);
		};

		$(window).load(function() {
		  background.onload = function() {
			cellWidth = background.width / numColumns;
			cellHeight = background.height / numRows;
			setInterval(function(){
			  getMessage();
			  displayMessage();
			}, 1000)
		  }
		  background.src = "<?= $this->site['url'] ?>/resources/abpt/a5h.png";
		});
				
		
		</script>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
	
	public function checkSecret()
	{
		if(!isset($_POST['herp']) OR trim($_POST['herp']) == ''){
			throw new \Exception('Nothing submitted..');
		}
		
		require_once(SITE_PATH.'/resources/recaptchalib2.php');
		$recaptcha = new \ReCaptcha(CAPTCHA_PRIV);
		$resp = $recaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $_POST['g-recaptcha-response']);
		if($resp == null OR !$resp->success){
			throw new \Exception('Captcha invalid!');
		}
		
		if(trim($_POST['herp']) != $this->secret){
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
		
		if(isset($gameData['leat_sent'])){
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
		$gameData['leat_sent'] = array('time' => timestamp(), 'tx' => $send);
		$this->model->updateUserMeta($this->user['userId'], 'arg_game1', json_encode($gameData));
		
		return $message;
				
	
	}
	
}


