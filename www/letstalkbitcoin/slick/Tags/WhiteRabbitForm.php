<?php
namespace Tags;
use Core, API, App, App\Tokenly, App\Account;
class WhiteRabbitForm
{
	function __construct()
	{
		$this->model = new \App\Meta_Model;
		$this->site = $this->model->get('sites', $_SERVER['HTTP_HOST'], array(), 'domain'); //get basic site data
		$this->inventory = new Tokenly\Inventory_Model; //load inventory model
		$this->user = Account\Home_Model::userInfo(); //load user data
		$this->dorky_address = '1HcoiyeQBBMgkKR2Zq4ZRxyQVMwsdqxPrV';
		//$this->dorky_address = '1As1zvxv4s59mKcaVjS7BaSD4dubDPy9zX';
		$this->useAsset = 'DORKY';
		//$this->useAsset = 'CONSULT';
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
				$message = $this->checkAddresses();
			}
			catch(\Exception $e){
				$message = $e->getMessage();
			}
		}
		
		ob_start();
		?>
		<h2>The Leaderboard</h2>
		<?php
		if($message != ''){
			echo '<p><strong>'.$message.'</strong></p>';
		}
		?>
		<p>
		Game tokens earned throughout gameplay will rank players on the leaderboard. To be placed on the
		leaderboard and earn your first game token, verify that your token address is properly synced by
		clicking the button below. 
		</p>
		<p>
		Once you have received DOOR KEY token you will see the hidden forum under the "token viewpoints"
		tab on the Let's Talk Bitcoin forums. 
		</p>
		<p>
			Players will acquire game tokens that reward points according to their significance:
		</p>
		<ul>
			<li><strong>KEY tokens:</strong> Starting value 10,000 points </li>
			<li><strong>BONUS tokens:</strong> Starting value 1,000 points</li>
			<li><strong>TREASURE tokens:</strong> Constant value 1 point</li>
		</ul>
		 <p>
			Game tokens will also allow access to previously locked areas or items. You may need a combination of tokens to gain access. Good Luck.
		</p>
		<p>
			<strong>Before you continue:</strong> You need to make sure that you have at least one
			CounterParty (XCP) compatible bitcoin address registered and verified on your LTB account. You can get a free wallet
			over at <a href="https://counterwallet.co" target="_blank">https://counterwallet.co</a>. Once your wallet is setup, you can go to
			your Let's Talk Bitcoin account dashboard and click on "Address Manager" to register a new address (make sure to check off "XCP compatible" on the address).
			Once you prove ownership of the address, you will be able to see all CounterParty token balances in your wallet via the "Token Inventory" page.
		</p>
		<p>
			Once you have an address verified, click the "Verify Synced Addresses" button below to receive your DOOR KEY token. 
			Once the token has confirmed in your wallet, you may click "Force Balance Refresh" or "Update My Inventory" in your account dashboard
			to unlock immediate access to the hidden forum.
		</p>
		<p>
			<strong><a href="<?= $this->site['url'] ?>/dashboard/address-manager" target="_blank">Go to Address Manager</a></strong>
		</p>
		<form action="" method="post">
			<input type="hidden" name="game" value="whiterabbit" />
			<input type="submit" value="Verify Synced Addresses" />
		</form>
		
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
	
	public function checkAddresses()
	{
		$getBalances = $this->inventory->getUserBalances($this->user['userId'], false, 'btc', true, true);
		if(count($getBalances) == 0){
			throw new \Exception('You do not have any verified addresses. Please visit the Address Manager');
		}
		else{
			$useAddress = false;
			foreach($getBalances as $address => $addressBalances){
				$useAddress = $address;
				break;
			}
			$metaRef = 'whit3r4bbi7';
			$updateRef = $this->model->updateUserMeta($this->user['userId'], 'site_referral', $metaRef);
			$gameData = $this->model->getUserMeta($this->user['userId'], 'arg_game1');
			if(!$gameData){
				$gameData = array();
			}
			else{
				$gameData = json_decode($gameData, true);
			}
			if(isset($gameData['dorky_sent'])){
				throw new \Exception('Key token already sent!');
			}
			
			$xcp = new API\Bitcoin(XCP_CONNECT);
			$btc = new API\Bitcoin(BTC_CONNECT);
			try{
				$getDorkyBalance = $xcp->get_balances(array('filters' => array('field' => 'address', 'op' => '=', 'value' => $this->dorky_address)));
			}
			catch(\Exception $e){
				throw new \Exception('Could not connect to CounterParty');
			}			
			$dorkBalance = 0;
			foreach($getDorkyBalance as $dork){
				if($dork['asset'] == $this->useAsset){
					$dorkBalance += $dork['quantity'];
				}
			}
			
			if($dorkBalance <= 0){
				throw new \Exception('No tokens left...');
			}

			$sendData = array('source' => $this->dorky_address, 'destination' => $useAddress, 'asset' => $this->useAsset, 'quantity' => 1, 'allow_unconfirmed_inputs' => true);
			try{
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
			
			$message =  'Key token sent to <a href="https://blockchain.info/address/'.$useAddress.'" target="_blank">'.$useAddress.'</a>. Once confirmed, please visit the forums.';
			$gameData['dorky_sent'] = array('time' => timestamp(), 'tx' => $send);
			$this->model->updateUserMeta($this->user['userId'], 'arg_game1', json_encode($gameData));
			
			return $message;
		}		
		
	}
	
	
}
