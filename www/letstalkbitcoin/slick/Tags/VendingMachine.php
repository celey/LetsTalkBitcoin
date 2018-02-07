<?php
namespace Tags;
use Core, App, App\Tokenly, UI, API;
class VendingMachine
{

	
	function __construct()
	{

		$meta = new \App\Meta_Model;
		$ltbApp = $meta->get('apps', 'tokenly', array(), 'slug');
		$this->appMeta = $meta->appMeta($ltbApp['appId']);
		
		$getExchange = json_decode(@file_get_contents('https://poloniex.com/public?command=returnTicker'), true);
		if($getExchange){
			$this->poloniex = $getExchange;
			$meta->updateAppMeta($ltbApp['appId'], 'poloniex_ticker', json_encode($getExchange));
		}
		else{
			$this->poloniex = json_decode($this->appMeta['poloniex_ticker'], true);
		}
		
		$btc_rate = json_decode(@file_get_contents('https://api.bitcoinaverage.com/ticker/global/USD/'), true);
		if($btc_rate){
			$this->btc_rate = $btc_rate;
			$meta->updateAppMeta($ltbApp['appId'], 'btc_rate', json_encode($btc_rate));
		}
		else{
			$this->btc_rate = json_decode($this->appMeta['btc_rate'], true);
		}
		
		$btc_price = $this->btc_rate['24h_avg'];
		$ltbc_price = $this->poloniex['BTC_LTBC']['high24hr'];
		
		$sjcx_price = $this->getTokenPrice('SJCX');
		$swarm_price = $this->getTokenPrice('SWARM');
		$xcp_price = $this->getTokenPrice('XCP');
		
		$ltbc_peg = 10000; //dollar/LTBC peg
		
		$this->machines = array(
			'LTBCOIN' => array('asset' => 'LTBCOIN',
							   'address' => '14RAUSrHo83yTBjCj7ZA8QJYy1RjYdnx4T',
							   'accepted' => array('BTC' => convertFloat($ltbc_price * 1.2),
													'XCP' => round(($ltbc_price * 1.1) / $xcp_price, 8),
													),
								'discounts' => array('BTC' => -20,
													 'XCP' => -10)
									),
			'SPONSOR' => array('asset' => 'SPONSOR',
							   'address' => '1Z4xTYvaRQV78NNCVoLu74FgzdQ3BRsGw', 'dollar' => 450,
							   'accepted' => array('LTBCOIN' => ($ltbc_peg * ((450 * 0.8) * 0.6)),
													'BTC' => $this->getTokenDollarRate('BTC', 450 * 0.8),
													'XCP' => $this->getTokenDollarRate('XCP', (450 * 0.8) * 1.1)
													),
								'discounts' => array('LTBCOIN' => 40,
													'BTC' => 20,
													 'XCP' => -10),
								),
			'LTBDISPLAY' => array('asset' => 'LTBDISPLAY',
							   'address' => '13ZDSuW1EFWbW6rUm89SYxyERRCnFiusaC', 'dollar' => 150,
							   'accepted' => array('LTBCOIN' => ($ltbc_peg * ((150 * 0.8) * 0.6)),
													'BTC' => $this->getTokenDollarRate('BTC', 150 * 0.8),
													'XCP' => $this->getTokenDollarRate('XCP', (150 * 0.8) * 1.1),
												),
								'discounts' => array('LTBCOIN' => 40,
													 'XCP' => -10,
													 'BTC' => 20,),								
									),
			'HOURCONSULT' => array('asset' => 'HOURCONSULT',
							   'address' => '1M9pb1XRjbeYbWzcpvkp5Da5Ga6nGubFb9', 'dollar' => 300,
							   'accepted' => array('LTBCOIN' => ($ltbc_peg * ((300 * 0.8) * 0.6)),
													'BTC' => $this->getTokenDollarRate('BTC', (300 * 0.8)),
													'XCP' => $this->getTokenDollarRate('XCP', (300 * 0.8) * 1.1),
													),
								'discounts' => array('LTBCOIN' => 40,
													 'XCP' => -10,
													 'BTC' => 20,),										
												   ),
			'HALFHOURADAM' => array('asset' => 'HALFHOURADAM',
							   'address' => '1HuqExsGX9XYG7WpMbru9WduFhTvMTwQjw', 'dollar' => 175,
							   'accepted' => array('LTBCOIN' => ($ltbc_peg * ((175 * 0.8) * 0.6)),
													'BTC' => $this->getTokenDollarRate('BTC', (175 * 0.8)),
													'XCP' => $this->getTokenDollarRate('XCP', (175 * 0.8) * 1.1),
													),
								'discounts' => array('LTBCOIN' => 40,
													 'XCP' => -10,
													 'BTC' => 20,),														
													),
			'BOOKKEEPER' => array('asset' => 'BOOKKEEPER',
								  'address' => '14ns4yamCWCsN9ULvvhYZNkqPkLw5mWNNf', 'dollar' => 0,
								  'accepted' => array('LTBCOIN' => 5000,
													  'BTC' => 0.005,
													  'BITCOINEX' => 0.005),
								  'discounts' => array(),
								  ),
						);
		$this->model = new Core\Model;
		$this->inventory = new Tokenly\Inventory_Model;
		
	}
	
	public function getTokenDollarRate($token, $dollars)
	{
		$btc_rate = $this->btc_rate;
		
		$btc_price = round($dollars / $btc_rate['24h_avg'], 4);
		
		if($token == 'BTC'){
			return $btc_price;
		}
		
		$token_price = $this->getTokenprice($token);
		
		return round($btc_price / $token_price);
		
	}
	
	public function getTokenPrice($token)
	{
		$getExchange = $this->poloniex;

		$symbol = $token;
		switch($token){
			case 'LTBCOIN':
				$symbol = 'LTBC';
				break;
		}
		
		if(!isset($getExchange['BTC_'.$symbol])){
			return 0;
		}
		if($symbol == 'LTBC'){
			return $getExchange['BTC_'.$symbol]['last'];
		}
		return $getExchange['BTC_'.$symbol]['high24hr'];
	}
	
	public function display()
	{
		ob_start();
		
		$dropdown = new UI\Select('vend-select');
		$dropdown->setLabel('Choose a Token to Acquire');
		$dropdown->addOption('', '[Choose Option]');
		
		$tokenList = array();
		foreach($this->machines as $mach => $machine){
			$tokenList[$mach] = $machine['asset'];
			echo '<input type="hidden" class="machine-address" data-machine="'.$mach.'" value="'.$machine['address'].'" />';
			foreach($machine['accepted'] as $token => $price){
				echo '<span style="display: none;" class="machine_'.$mach.'_accept" data-token="'.$token.'" data-price="'.$price.'"></span>';
			}
			if(isset($machine['dollar']) AND $machine['dollar'] > 0){
				echo '<span style="display: none;" class="machine_'.$mach.'_accept" data-token="usd" data-price="'.$machine['dollar'].'"></span>';
			}					
			echo '<div class="machine-description" data-machine="'.$mach.'" style="display: none;">';
			
			$getCache = $this->inventory->getAssetData($machine['asset']);
			$getDesc = '';
			if($getCache){
				$getDesc = $getCache['description']; 
			}
			?>
			<strong>Prices:</strong>
			<ul class="vend-prices">
				<?php
				foreach($machine['accepted'] as $token => $price){
					if($price <= 0){
						continue;
					}
					if($price > 1000){
						$price = number_format($price);
					}
					else{
						$price = convertFloat($price);
					}
					$discountText = '';
					if(isset($machine['discounts'][$token])){
						$discount = $machine['discounts'][$token];
						if($discount > 0){
							$discountText = '<span class="text-success">'.$discount.'% market discount</span>';
						}
						if($discount < 0){
							$discountText = '<span class="text-error">'.(-1*$discount).'% market premium</span>';
						}
					}					
					echo '<li><strong><span class="'.$token.'-quantity">1</span> '.$machine['asset'].' = <span class="'.$token.'-price">'.$price.'</span> '.$token.'</strong> '.$discountText.'</li>';
				}
				if(isset($machine['dollar']) AND $machine['dollar'] > 0){
					echo '<li><strong><span class="usd-quantity">1</span> '.$machine['asset'].' = $<span class="usd-price">'.$machine['dollar'].'</span></strong> (please contact <a href="mailto:dollarpayments@letstalkbitcoin.com">dollarpayments@letstalkbitcoin.com</a>)</li>';
				}				
				?>
			</ul>
			<?php
			$xcp = new API\Bitcoin(XCP_CONNECT);
			$totalLeft = 'N/A';
			try{
				$getBalances = $xcp->get_balances(array('filters' => array('field' => 'address', 'op' => '=', 'value' => $machine['address'])));
				foreach($getBalances as $balance){
					if($balance['asset'] == $machine['asset']){
						if($getCache AND intval($getCache['divisible']) == 1){
							$balance['quantity'] = round($balance['quantity'] / SATOSHI_MOD, 8);
						}
						$totalLeft = $balance['quantity'];
						break;
					}
				}
			}
			catch(\Exception $e){
				$totalLeft = 'N/A (error getting token data)';
			}
			$available_class = 'text-success';
			if($totalLeft <= 0 OR !is_numeric($totalLeft)){
				$available_class = 'text-error';
			}
			?>
			<p>
				<strong class="<?= $available_class ?>">Available <?= $machine['asset'] ?> Tokens Left:</strong> <?= $totalLeft ?>
			</p>
			
			<?= markdown($getDesc) ?>
			<?php
			if($machine['asset'] == 'LTBCOIN'){
				?>
				<p>
					This is not, nor is it intended to be a cost-effective way to acquire LTBCOIN,
					if you want a guarantee of the price you will get please use a centralized 
					exchange like poloniex <a href="https://poloniex.com/exchange#btc_ltbc" target="_blank">https://poloniex.com/exchange#btc_ltbc</a>.
				</p>
				<?php
			}
			?>
			<small><em>Prices are based on the 24 hour BTC/USD average and for tokens, the 24 hour high.</em></small><br>
			<?php
			if(isset($machine['discounts']['BTC'])){
			?>
			<small><em>Market discounts/premiums for all Counterparty token prices are in addition to any BTC discount</em></small><br><br>
			<?php
			}//endif
			?>
			<div class="vend-address">
			</div>
			
			<p>
				<strong><a href="https://blockchain.info/address/<?= $machine['address'] ?>" target="_blank">Blockchain.info</a></strong><br>
				<strong><a href="http://blockscan.com/address?q=<?= $machine['address'] ?>" target="_blank">Blockscan.com</a></strong>
			</p>	
			<?php
			echo '</div>';
		}
		foreach($tokenList as $k => $v){
			$dropdown->addOption($k, $v);
		}
		
		$quantity = new UI\Textbox('quantity');
		$quantity->setLabel('Quantity');
		$quantity->setValue(1);
		
		?>
		
		<p>
			Note: Tokens are automatically vended out after your transaction reaches at least 1 confirmation, but may occasionally take longer.<br>
			The price tool below is only an estimation, real price may be slightly different by the time your transaction goes through due to market volatility.<br>
			Please only send payments <strong><em>from</em> the address you wish to receive your tokens to</strong>.
		</p>
		
		<?= $dropdown->display() ?>
		<div class="quantity-display" style="display: none;">
			<?= $quantity->display() ?>
		</div>

		<div class="vend-details">
		
		</div>

		<script type="text/javascript">
			$(document).ready(function(){
				$('select[name="vend-select"]').change(function(e){
					var machine = $(this).val();
					
					if(machine == ''){
						$('.vend-details').html('');
						$('.quantity-display').hide();
						$('.vend-address').html('');
					}
					else{
						var machine_desc = $('.machine-description[data-machine="' + machine + '"]').html();
						var address = $('.machine-address[data-machine="' + machine + '"]').val();
						$('.vend-details').html(machine_desc);
						$('.quantity-display').show();
						$('.vend-address').html('<strong>Send To:</strong><h3>' + address + '</h3>');
						$('input[name="quantity"]').val(1);
					}
				});
				
				$('input[name="quantity"]').keyup(function(){
					var value = $(this).val();
					if(value == ''){
						value = 1;
					}
					var machine = $('select[name="vend-select"]').val();
					$('.machine_' + machine + '_accept').each(function(){
						var token = $(this).data('token');
						var price = $(this).data('price');
						
						var total = parseFloat(price) * parseFloat(value);
						total = total.toFixed(8);
						
						$('.vend-details').find('.' + token + '-quantity').html(parseFloat(value));
						total = parseFloat(total).toString();
						if(total > 1000){
							total = total.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						}
						$('.vend-details').find('.' + token + '-price').html(total);
						
					});
				});
				
			$('input[name="quantity"]').keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});						
				
			});
		
		</script>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
		
		
	}
	
}
