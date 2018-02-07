<?php
namespace Tags;
use App, UI, App\Tokenly, App\Account, API;
class Rabboat
{
	function __construct()
	{
		$this->model = new \App\Meta_Model;
		$this->site = $this->model->get('sites', $_SERVER['HTTP_HOST'], array(), 'domain'); //get basic site data
		$this->inventory = new Tokenly\Inventory_Model; //load inventory model
		$this->user = Account\Home_Model::userInfo(); //load user data
		$this->token_address = '1MWG7pyzk7Thxm9MLzAgA9egvx5gWVKaWV';
		$this->useAsset = 'RABBOAT';
		$this->secret = "100000000000000101000000000000011";
		$this->token_account = 'ARG1_RABBOAT';		
		
	}
	
	public function display()
	{
		
		if(posted()){
			ob_end_clean();
			header('Content-Type: text/json');
			$output = array();
			try{
				$check = $this->checkSecret();
			}
			catch(\Exception $e){
				$output['error'] = $e->getMessage();
				$check = false;
			}
			
			if($check){
				$output['result'] = $check;
			}
			

			echo json_encode($output);
			die();
		}
		
		ob_start();
		?>
		  <p id="message">&nbsp;</p>
		  <canvas id="life" width="640" height="800"></canvas>
		  <br />
		  <button onclick="startAnimating();">Go!</button>&nbsp;
		  <button onclick="stopAnimating();">Stop...</button>&nbsp;
		  <button onclick="clearBoard();">Reset</button>
		  <h3>Instructions</h3>
		  <ol>
			<li>Click on the board to toggle cells and make a pattern.</li>
			<li>Click &quot;Go!&quot; to start the board running Conway's Life and
			  &quot;Stop...&quot; to stop it. Then reset the board by clicking
			  &quot;Reset&quot;.</li>
			<li>If you see a pattern stabilize that you like, let it stay a while...</li>
		  </ol>		  
		  <script type="text/javascript" src="<?= $this->site['url'] ?>/resources/life.js"></script>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
		
	}
	
	public function checkSecret()
	{
		if(!isset($_POST['board']) OR trim($_POST['board']) == '' OR !isset($_POST['generation'])){
			throw new \Exception('Nothing submitted..');
		}
		
		if(intval($_POST['generation']) < 10){
			throw new \Exception('Wrong');
		}
		
		
		if(trim($_POST['board']) != $this->secret){
			throw new \Exception('Wrong');
		}
		
		$getBalances = $this->inventory->getUserBalances($this->user['userId'], false, 'btc', true);
		
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
		
		if(isset($gameData['rabboat_sent'])){
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
		

		$sendData = array('source' => $this->token_address, 'destination' => $useAddress, 'asset' => $this->useAsset, 'quantity' => 1, 'allow_unconfirmed_inputs' => true);
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
		
		$message =  'Key token sent to <a href="https://blockchain.info/address/'.$useAddress.'" target="_blank">'.$useAddress.'</a>. Congrats!';
		$gameData['rabboat_sent'] = array('time' => timestamp(), 'tx' => $send);
		$this->model->updateUserMeta($this->user['userId'], 'arg_game1', json_encode($gameData));
		
		$message = 'Success! '.$message;
		
		return $message;
				
	
	}	
	
}
