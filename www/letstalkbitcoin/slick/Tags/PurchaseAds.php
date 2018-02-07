<?php
namespace Tags;
use UI, Util, Core, API, App, App\Tokenly, App\Account;
class PurchaseAds
{
	/* add in support for "rules" field to this later */
	private $main_email = 'nrathman@ironcladtech.ca';
	private $shows = array('ltb' => array('name' => 'Let\'s Talk Bitcoin!',
										  'packages' => array('standard' => array(
																  'name' => 'Sponsorship Package A',
																  'accepted' => array('SPONSOR' => 1,
																					  'LTBCOIN' => 150000,
																					  'BTC' => 1.5,
																					  ),
																  'description' => 'A host of Let\'s Talk Bitcoin! (Adam or Stephanie) will investigate your project and tell people about what they\'ve found for about 45 seconds.  This is unscripted and sponsors have no editorial control. Sponsor is also called out (per package B)  Two per show.',
																				  ),
															  'standard-b' => array(
																  'name' => 'Sponsorship Package B',
																  'accepted' => array('SPONSOR' => 0.1957,
																					  'LTBCOIN' => 25000,
																					  'BTC' => 0.25,
																					  ),
																  'description' => 'Sponsors have their projects called out by name during the closing show credits.  Five per show.',
																				  ),
															  ),
											'emails' => 'adamlevinemobile@gmail.com,krystalmobile@gmail.com',
											'forward_address' => '14q6GqFaKek9FN6YnkkeqqQcxxMYYXgRGM',
											'rules' => ''),									
							'bandg' => array('name' => 'Bitcoins and Gravy',
											 'packages' => array('standard' => array(
																	'name' => 'Sponsorship Package A',
																	'accepted' => array('LTBCOIN' => 200000,
																						'BTC' => 1),
																	'description' => 'John Barrett, Host of Bitcoins & Gravy will spend 30-45 seconds investigating and sharing your project or company with the listeners.  Sponsors have no editorial control.  Two available per show.',
																	
																    )
																  ),
											 'emails' => 'adamlevinemobile@gmail.com,jcbarrett2003@yahoo.com',
											 'forward_address' => '18iGEi3ou4523M6eECAf1rWygaSBXBRR63', 
											 'rules' => ''
														),
							'p2pconnects' => array('name' => 'P2P Connects Us',
												   'packages' => array(
																'standard' => array(
																		'name' => 'Sponsorship Package A',
																		'accepted' => array(
																							'LTBCOIN' => 500000,
																							'BTC' => 0.2
																							),
																		'description' => '1 (one) 15 second unscripted monologue about sponsor in announcement section of podcast + link in show notes on letstalkbitcoin.com, p2pconnects.us, SoundCloud, and YouTube

(Two 15 second slots available per episode; episodes released once per week.)'
																			)
																	),
													'emails' => 'adamlevinemobile@gmail.com,p2pconnectsus@gmail.com',
													'forward_address' => '14VGju8HUpjivLN75ZATejetXLDVhTquoT',
													'rules' => '')
											);
	private $adspaces = array('frontpage' => array('name' => 'LTB Front Page',
												   'packages' => array('sidebar' => array(
																		   'name' => 'Sidebar',
																		   'width' => 155,
																		   'height' => 155,
																		   'accepted' => array(
																			   'LTBDISPLAY' => 1,
																			   'LTBCOIN' => 100000,
																			   'BTC' => 0.75),
																		   'description' => 'This package represents one week in one of the prominently featured, 155x155 display ad, sponsor spots located on right sidebar of the LTB Networks front page.  This is the exclusive and only advertising option on the front page of the LTB Network.',
																	  ),
																	 ),														   

													'emails' => 'adamlevinemobile@gmail.com,krystalmobile@gmail.com',
													'forward_address' => '1Q9bEvqCgEuuqfsxw7Ky3ZhKKZ7R4pBNpw',
													'rules' => ''
															),
							 'site-wide' => array('name' => 'LTB All Pages',
												  'packages' => array('top-ad' => array(
																		'name' => 'Top Banner Ad',
																		'width' => 728,
																		'height' => 90,
																		'accepted' => array('LTBDISPLAY' => 3),
																		'description' => 'This package represents one week on the top 728x90 banner ad which appears on all pages across the site.',
																		),
																	),
													'emails' => 'adamlevinemobile@gmail.com,krystalmobile@gmail.com',
													'forward_address' => '1Q9bEvqCgEuuqfsxw7Ky3ZhKKZ7R4pBNpw',
													'rules' => ''
												),
								);
								
	private $consultants =  array('adam' => array('name' => 'Adam B. Levine',
												   'packages' => array('half-hour' => array(
																		   'name' => 'Half Hour Consultation',
																		   'accepted' => array(
																			   'HALFHOURADAM' => 1,
																			   'LTBCOIN' => 60000,
																			   'BTC' => 0.6),
																		   'description' => 'A 30 Minute Consultation over Skype with Adam B. Levine, Creator of the Let\'s Talk Bitcoin! Show & Network. A recording can be made available at request',
																	  ),
																	  'full-hour' => array(
																		   'name' => 'One Hour Consultation',
																		   'accepted' => array(
																			   'HOURCONSULT' => 1,
																			   'LTBCOIN' => 100000,
																			   'BTC' => 1),
																			'description' => 'A 60 Minute Consultation over Skype or by phone with Adam B. Levine, Creator of the Let\'s Talk Bitcoin! Show & Network. A Recording can be made available at request'
																		)
																	 ),														   

													'emails' => 'adamlevinemobile@gmail.com,krystalmobile@gmail.com',
													'forward_address' => '1Q9bEvqCgEuuqfsxw7Ky3ZhKKZ7R4pBNpw',
													'rules' => ''
															),
									'stephanie' => array('name' => 'Stephanie Murphy',
														 'packages' => array(
																		'explainer' => array(
																			'name' => 'Explainer Video Voiceover',
																			'accepted' => array(
																				'BTC' => 0.6,
																				'LTBCOIN' => 1000000
																			),
																			'description' => '
**What is offered:** A professional quality voice recording for an explainer video or any other type of video, by Stephanie, of up to 380 words (approximately 2 minutes in length.) The recording will be completed within 2 days of Stephanie receiving the script, and can be delivered in any audio format you specify (WAV, mp3, AIFF, etc.) 

Young adult female voice with a friendly, conversational delivery. Specializing in medical, scientific, and of course bitcoin explainer videos. I have voiced over 100 explainer videos and hundreds of other voiceover projects. Languages spoken: English and Spanish. Demos can be heard at: [SMVoice.info](http://SMVoice.info). 

Scripts are subject to Stephanie\'s approval. Scripts that may not be approved include but are not limited to: those in languages other than English or Spanish, those that exceed the length requirements, religious content, government/legal/tax related content, endorsements.

(To the bidder) 

1) Please paste the script here. 

2) Please describe any direction (i.e. pace, tone, adjectives to describe how you want the voiceover to sound). 

3) If you have any requirements for the audio format, please list them here (i.e. WAV, mp3, AIFF, 48 kHz, raw unedited audio, etc.) My default is to deliver the audio in WAV format, 48 kHz, with some volume leveling. 

4) What is the best way to get in touch with you (email, Skype, phone, etc.)?
																			'
																		
																		),
																		'phone' => array(
																			'name' => 'Phone Greeting',
																			'accepted' => array(
																				'BTC' => 0.3,
																				'LTBCOIN' => 500000
																			),
																			'description' => '
**What is offered:** A professional quality voice recording for a phone greeting of up to 200 words, by Stephanie. The recording will be completed within 2 days of Stephanie receiving the script, and can be delivered in any audio format you specify (WAV, mp3, etc.) 

Young adult female voice with a friendly, conversational delivery. I have voiced several dozens of phone systems for companies and individuals, and hundreds of other voiceover projects. Languages spoken: English and Spanish. Demos can be heard at: Voicemail-greeting.com or [SMVoice.info](http://SMVoice.info). 

Scripts are subject to Stephanie\'s approval. Scripts that may not be approved include but are not limited to: those in languages other than English or Spanish, those that exceed the length requirements, religious content, government/legal/tax related content, endorsements.

(To the bidder)

1) Please paste the script here. Sample scripts for phone greetings can be found at voicemail-greeting.com.

2) Please describe any direction (i.e. pace, tone, adjectives to describe how you want the phone greeting to sound). 

3) If you have any requirements for the audio format, please list them here (i.e. WAV, mp3, AIFF, 8 kHz, u-law, etc.) My default is to deliver the audio in WAV format, 48 kHz. 

4) What is the best way to get in touch with you (email, Skype, phone, etc.)
																			'
																		)
																	),
														  'emails' => 'adamlevinemobile@gmail.com,Stephanie@letstalkbitcoin.com',
														  'forward_address' => '18Z3aF67DptVh5La834NimrMFnvEeeA91D',
														  'rules' => ''
														)
								);
								
	private $products =  array('bkeychain' => array('name' => 'Bkeychain.com Bitcoin Keychain',
												   'packages' => array('10-pack' => array(
																		   'name' => '10 Pack of Keychains',
																		   'accepted' => array(
																			   'LTBCOIN' => 250000,
																			   'BTC' => 0.23,
																			   'XCP' => 20,),
																		   'description' => '10 [Bkeychain.com](http://bkeychain.com) Bitcoin Keychains shipped anywhere in the USA via USPS First Class Mail.',
																	  ),
																	 ),														   

													'emails' => 'adamlevinemobile@gmail.com,gra.fics.101@gmail.com',
													'forward_address' => '1QLi66WNuUFzd2Bj8b6vHsACApxCAsFBy',
													'rules' => ''
															),
								'ageofcrypto' => array('name' => 'Age of Cryptocurrency Book',
													   'packages' => array('prize' => array(
																				'name' => 'Book Prize Redemption',
																				'accepted' => array('THEAGE' => 1),
																				'description' => 'Redeem your THEAGE token to recieve a free copy of The Age of Cryptocurrency, available now!  
																				**CAN ONLY BE REDEEMED IN THE CONTINENTAL UNITED STATES**',
																				),
																			),
														'emails' => 'adamlevinemobile@gmail.com,krystalmobile@gmail.com',
														'forward_address' => '1Q9bEvqCgEuuqfsxw7Ky3ZhKKZ7R4pBNpw',
														'rules' => ''
													),
								);								
														

	function __construct()
	{
		$this->model = new Core\Model;
		$this->user = Account\Home_Model::userInfo(); //load user data
		$this->pageURL = 'purchase-ads'; //CMS page URL the form is located on
		$this->site = currentSite();
		$this->inventory = new Tokenly\Inventory_Model;
		
		$meta = new \App\Meta_Model;
		$ltbApp = $meta->get('apps', 'tokenly', array(), 'slug');
		$this->appMeta = $meta->appMeta($ltbApp['appId']);
		
		//get poloniex price conversions for robs keychains
		$getExchange = json_decode(file_get_contents('https://poloniex.com/public?command=returnTicker'), true);
		if($getExchange){
			$this->poloniex = $getExchange;
			$meta->updateAppMeta($ltbApp['appId'], 'poloniex_ticker', json_encode($getExchange));
		}
		else{
			$this->poloniex = json_decode($this->appMeta['poloniex_ticker'], true);
		}
		
		$btc_rate = json_decode(file_get_contents('https://api.bitcoinaverage.com/ticker/global/USD/'), true);
		if($btc_rate){
			$this->btc_rate = $btc_rate;
			$meta->updateAppMeta($ltbApp['appId'], 'btc_rate', json_encode($btc_rate));
		}
		else{
			$this->btc_rate = json_decode($this->appMeta['btc_rate'], true);
		}
		
		$ltbc_peg = 10000; //dollar/LTBC peg
		
		//bkeychain custom prices
		$this->products['bkeychain']['packages']['10-pack']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (100 * 0.8));
		$rob_btc_price = $this->products['bkeychain']['packages']['10-pack']['accepted']['BTC'];
		$this->products['bkeychain']['packages']['10-pack']['accepted']['XCP'] = $this->getTokenDollarRate('XCP', (100 * 0.8) * 1.1);
		$this->products['bkeychain']['packages']['10-pack']['accepted']['LTBCOIN'] = ($ltbc_peg * ((100 * 0.8) * 0.75));
		
		//stephanie custom prices
		$this->consultants['stephanie']['packages']['phone']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (150 * 0.8));
		$steph_phone_price = $this->consultants['stephanie']['packages']['phone']['accepted']['BTC'];
		$this->consultants['stephanie']['packages']['phone']['accepted']['LTBCOIN'] = ($ltbc_peg * ((150 * 0.8) * 0.75));
		
		$this->consultants['stephanie']['packages']['explainer']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (250 * 0.8));
		$steph_explainer_price = $this->consultants['stephanie']['packages']['explainer']['accepted']['BTC'];
		$this->consultants['stephanie']['packages']['explainer']['accepted']['LTBCOIN'] = ($ltbc_peg * ((250 * 0.8) * 0.75));	
		
		//adam consult prices
		$this->consultants['adam']['packages']['half-hour']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (175 * 0.8));
		$adam_half_price = $this->consultants['adam']['packages']['half-hour']['accepted']['BTC'];
		$this->consultants['adam']['packages']['half-hour']['accepted']['LTBCOIN'] = ($ltbc_peg * ((175 * 0.8) * 0.6));
		$this->consultants['adam']['packages']['half-hour']['accepted']['XCP'] =  $this->getTokenDollarRate('XCP', (175 * 0.8) * 1.1);
		
		$this->consultants['adam']['packages']['full-hour']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (300 * 0.8));
		$adam_hour_price = $this->consultants['adam']['packages']['full-hour']['accepted']['BTC'];
		$this->consultants['adam']['packages']['full-hour']['accepted']['LTBCOIN'] = ($ltbc_peg * ((300 * 0.8) * 0.6));
		$this->consultants['adam']['packages']['full-hour']['accepted']['XCP'] = $this->getTokenDollarRate('XCP', (300 * 0.8) * 1.1);
		
		//ltb display ad prices
		$this->adspaces['frontpage']['packages']['sidebar']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (150 * 0.8));
		$frontpage_price = $this->adspaces['frontpage']['packages']['sidebar']['accepted']['BTC'];
		$this->adspaces['frontpage']['packages']['sidebar']['accepted']['LTBCOIN'] = ($ltbc_peg * ((150 * 0.8) * 0.6));
		$this->adspaces['frontpage']['packages']['sidebar']['accepted']['XCP'] = $this->getTokenDollarRate('XCP', (150 * 0.8) * 1.1);	
		
		$this->adspaces['site-wide']['packages']['top-ad']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (450 * 0.8));
		$sitewide_price = $this->adspaces['site-wide']['packages']['top-ad']['accepted']['BTC'];
		$this->adspaces['site-wide']['packages']['top-ad']['accepted']['LTBCOIN'] = ($ltbc_peg * ((450 * 0.8) * 0.6));
		$this->adspaces['site-wide']['packages']['top-ad']['accepted']['XCP'] = $this->getTokenDollarRate('XCP', (450 * 0.8) * 1.1);			
		
		//p2p connects us prices
		$this->shows['p2pconnects']['packages']['standard']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (100 * 0.8));
		$p2p_standard_price = $this->shows['p2pconnects']['packages']['standard']['accepted']['BTC'];
		$this->shows['p2pconnects']['packages']['standard']['accepted']['LTBCOIN'] = ($ltbc_peg * ((100 * 0.8) * 0.75));		
		
		//b&g  prices
		$this->shows['bandg']['packages']['standard']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (300 * 0.8));
		$bandg_standard_price = $this->shows['bandg']['packages']['standard']['accepted']['BTC'];
		$this->shows['bandg']['packages']['standard']['accepted']['LTBCOIN'] = ($ltbc_peg * ((300 * 0.8) * 0.75));	
		
		//ltb sponsor prices
		$this->shows['ltb']['packages']['standard']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (450 * 0.8));
		$ltb_sponsor_price = $this->shows['ltb']['packages']['standard']['accepted']['BTC'];
		$this->shows['ltb']['packages']['standard']['accepted']['LTBCOIN'] = ($ltbc_peg * ((450 * 0.8) * 0.60));
		//$this->shows['ltb']['packages']['standard']['accepted']['LTBCOIN'] = 100;
		$this->shows['ltb']['packages']['standard']['accepted']['XCP'] = $this->getTokenDollarRate('XCP', (450 * 0.8) * 1.1);
		
		$this->shows['ltb']['packages']['standard-b']['accepted']['BTC'] = $this->getTokenDollarRate('BTC', (90 * 0.8));
		$ltb_sponsor_priceb = $this->shows['ltb']['packages']['standard-b']['accepted']['BTC'];
		$this->shows['ltb']['packages']['standard-b']['accepted']['LTBCOIN'] = ($ltbc_peg * ((90 * 0.8) * 0.60));
		$this->shows['ltb']['packages']['standard-b']['accepted']['XCP'] = $this->getTokenDollarRate('XCP', (90 * 0.8) * 1.1);		

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
		
		return $getExchange['BTC_'.$symbol]['high24hr'];
	}	
	
	public function display()
	{
		ob_start();
		?>

		<?php

		if(isset($_GET['pay'])){
			ob_clean();
			$this->displayPayment();
		}
		else{
			$this->displayForm();
		}
	
		
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
	
	private function displayPayment()
	{
		$getOrder = $this->model->getAll('payment_order', array('address' => $_GET['pay'], 'orderType' => 'ad-purchase'));
		if(!$getOrder OR count($getOrder) == 0 OR $getOrder[0]['complete'] == 1){
			header('Location: '.$this->site['url'].'/'.$this->pageURL);
			return false;
		}
		$getOrder = $getOrder[0];
		
		if(isset($_GET['check'])){
			return $this->checkOrderPayment($getOrder['orderId']);
		}
		
		$displayAmount = number_format($getOrder['amount']);
		if($getOrder['asset'] == 'BTC'){
			$displayAmount = convertFloat($getOrder['amount']);
		}
		
		$orderData = json_decode($getOrder['orderData'], true);
		
		echo '<h2>Confirmation & Payment</h1>';
		echo '<p>Almost done! Please pay the amount displayed below in order to complete your display ad or sponsorship submission.<br>
				<strong>Please stay on this page until the transaction confirms.</strong></p>';
		echo '<p>All submissions are reviewed and approved manually after payment is complete</p>';
		echo '<h3 style="padding: 10px; border: solid 1px #ccc; text-align: center; margin-top: 20px;">Please pay '.$displayAmount.' '.$getOrder['asset'].' to<br>
				
				<span style="color: #000;">'.$getOrder['address'].'</span></h3>';
		
		echo '<p><strong class="payment-status">Waiting for payment...</strong></p>';
		echo '<br>';
		echo '<h3>Order Details</h3>';

		
		
		echo '<ul>
				<li><strong>Customer Email:</strong> '.$orderData['customer_email'].'</li>	
		';
		switch($orderData['ad_type']){
			case 'display':
				?>
				<li><strong>Type:</strong> Display Ad</li>
				<li><strong>Destination URL:</strong> <?= $orderData['destination_url'] ?></li>
				<li><strong>Page:</strong> <?= $orderData['adspace'] ?></li>
				<li><strong>Advertisement Package:</strong> <?= $orderData['package'] ?></li>
				<li><strong># of Weeks:</strong> <?= $orderData['weeks'] ?></li>
				<li><strong>Display Image:</strong> <img src="<?= $orderData['image_url'] ?>" alt="" style="display: block;"/></li>
				<?php
				break;
			case 'sponsor':
				?>
				<li><strong>Type:</strong> Podcast Sponsorship</li>
				<li><strong>Destination URL:</strong> <?= $orderData['destination_url'] ?></li>
				<li><strong>Show:</strong> <?= $orderData['show'] ?></li>
				<li><strong>Sponsorship Package:</strong> <?= $orderData['package'] ?></li>
				<li><strong>Preferred Sponsorship Date:</strong> <?= $orderData['preferred_date'] ?></li>
				<li><strong>What are you hoping to accomplish?:</strong> <?= $orderData['reason'] ?></li>
				<?php
				break;
			case 'consult':
				?>
				<li><strong>Type:</strong> Network Personality</li>
				<li><strong>Personality:</strong> <?= $orderData['consultant'] ?></li>
				<li><strong>Package:</strong> <?= $orderData['package'] ?></li>
				<li><strong>What are you hoping to accomplish?:</strong> <?= $orderData['reason'] ?></li>
				<?php			
				break;
			case 'product':
				?>
				<li><strong>Type:</strong> Physical Item</li>
				<li><strong>Product Type:</strong> <?= $orderData['product'] ?></li>
				<li><strong>Package:</strong> <?= $orderData['package'] ?></li>
				<li><strong>Quantity:</strong> <?= $orderData['quantity'] ?></li>
				<li><strong>Shipping Details:</strong>
					<ul>
						<li><strong>Name:</strong> <?= $orderData['ship_name'] ?></li>
						<li><strong>Address:</strong> <?= $orderData['ship_address'] ?></li>
						<li><strong>City:</strong> <?= $orderData['ship_city'] ?></li>
						<li><strong>State/Province:</strong> <?= $orderData['ship_state'] ?></li>
						<li><strong>Country:</strong> <?= $orderData['ship_country'] ?></li>
						<li><strong>ZIP / Postal Code:</strong> <?= $orderData['ship_postal'] ?></li>
					</ul>
				</li>
				<?php
				break;
		}
		?>
		<li><strong>Additional Info:</strong> <?= $orderData['additional_info'] ?></li>
		<?php
		
		echo '</ul>';
		

		?>
		<script type="text/javascript">
			$(document).ready(function(){
				window.checkTimer = setInterval(function(){
					var url = '<?= $this->site['url'] ?>/<?= $this->pageURL ?>?pay=<?= $getOrder['address'] ?>&check=1';
					$.get(url, function(data){
						console.log(data);
						if(data.result == 'receiving'){
							$('.payment-status').html('Receiving payment (' + data.received + ' seen)...');
						}
						if(data.result == 'complete'){
							$('.payment-status').addClass('success').html('Payment complete! Your submission has been sent to the appropriate parties and will get a hold of you soon.');
							clearInterval(window.checkTimer);
						}
					});
					
				}, 5000);
			});
		</script>
		<?php
	}
	
	private function displayForm()
	{
		require_once(SITE_PATH.'/resources/recaptchalib.php');		
		$form = $this->getBuilderForm();
		$error = '';
		if(posted()){
			$data = $form->grabData();
			try{
				$submit = $this->submitForm($data);
			}
			catch(\Exception $e){
				$error = $e->getMessage();
				$submit = false;
			}
			
			if($submit){
				header('Location: '.$this->site['url'].'/'.$this->pageURL.'?pay='.$submit['address']);
				return true;
			}
		}
		$view = new App\View;
		if(isset($_COOKIE['ordered_sponsorship'])){
			echo '<div id="sponsor-tos" style="display: none;">'.$view->displayBlock('purchase-ads-content').'</div>';
		}
		else{
			echo $view->displayBlock('purchase-ads-content');
		}
		?>
		<h3>Submit Sponsorship</h3>
			<?php
			if($error != ''){
				echo '<p class="error">'.$error.'</p>';
			}	
			if(isset($_COOKIE['ordered_sponsorship'])){
				echo '<input type="button" id="show-tos" value="Show Network Rules and ToS" /><br>
						<div id="sponsor-form-cont">';
			}	
			else{
			?>		
			<input type="button" id="i-agree" value="I Agree to the Above Terms and Conditions" />
			<div id="sponsor-form-cont" style="display: none;">
			<?php
			}//endif
			echo $form->open();
			?>
			<p>
				<strong>Note:</strong> Display advertisement positions are on a first come first serve basis.
				After submitting your order, please stay on the page until your payment confirms.
			</p>
			<?= $form->field('email')->display() ?>
			<?= $form->field('url')->display() ?>
			<?= $form->field('ad_type')->display() ?>

			<div id="product_form" style="display: none;">
				<?php
				$firstProductAccept = false;
				$firstProductPackage = false;
				foreach($this->products as $slug => $con){
					foreach($con['packages'] as $pSlug => $package){
						if(!$firstProductPackage){
							$firstProductPackage = $package;
						}
						echo '<span class="product_'.$slug.'_package_item" data-package-slug="'.$pSlug.'" data-package-name="'.$package['name'].'"></span>';
				
						foreach($package['accepted'] as $accept => $val){
							$realPrice = $val;
							if($val >= 1000){
								$val = number_format($val);
							}
							if(!$firstProductAccept){
								$firstProductAccept = array('token' => $accept, 'val' => $val);
							}
							echo '<span class="product_'.$slug.'_'.$pSlug.'_accepted" data-token="'.$accept.'" data-price="'.$val.'" data-real-price="'.$realPrice.'"></span>';
						}
						echo '<span class="product_'.$slug.'_'.$pSlug.'_description" style="display: none;">'.markdown($package['description']).'</span>';
					}
					echo '<span class="product_'.$slug.'_rules" style="display: none;">'.markdown($con['rules']).'</span>';
				}				
				
				?>
				<?= $form->field('product')->display() ?>
				<?= $form->field('product_package')->display() ?>
				<div class="product_package_desc_display">
					<?= markdown($firstProductPackage['description']) ?>
				</div>
				<?= $form->field('product_quantity')->display() ?>
				<h4>Shipping Details</h4>
				<?= $form->field('product_ship_name')->display() ?>
				<?= $form->field('product_ship_address')->display() ?>
				<?= $form->field('product_ship_city')->display() ?>
				<?= $form->field('product_ship_state')->display() ?>
				<?= $form->field('product_ship_country')->display() ?>
				<?= $form->field('product_ship_postal')->display() ?>
			</div>	
		
			<div id="consult_form" style="display: none;">
				<?php
				$firstConsultAccept = false;
				$firstConsultPackage = false;
				foreach($this->consultants as $slug => $con){
					foreach($con['packages'] as $pSlug => $package){
						if(!$firstConsultPackage){
							$firstConsultPackage = $package;
						}
						echo '<span class="consult_'.$slug.'_package_item" data-package-slug="'.$pSlug.'" data-package-name="'.$package['name'].'"></span>';
				
						foreach($package['accepted'] as $accept => $val){
							$realPrice = $val;
							if($val >= 1000){
								$val = number_format($val);
							}
							if(!$firstConsultAccept){
								$firstConsultAccept = array('token' => $accept, 'val' => $val);
							}
							echo '<span class="consult_'.$slug.'_'.$pSlug.'_accepted" data-token="'.$accept.'" data-price="'.$val.'" data-real-price="'.$realPrice.'"></span>';
						}
						echo '<span class="consult_'.$slug.'_'.$pSlug.'_description" style="display: none;">'.markdown($package['description']).'</span>';
					}
					echo '<span class="consult_'.$slug.'_rules" style="display: none;">'.markdown($con['rules']).'</span>';
				}				
				
				?>
				<?= $form->field('consultant')->display() ?>
				<?= $form->field('consult_package')->display() ?>
				<div class="consult_package_desc_display">
					<?= markdown($firstConsultPackage['description']) ?>
				</div>
				<?= $form->field('consult_brief')->display() ?>
			</div>			
			
			<div id="adspace_form" style="display: none;">
				<?php
				$firstAccept = false;
				$firstAdspacePackage = false;
				foreach($this->adspaces as $slug => $space){
					foreach($space['packages'] as $pSlug => $package){
						if(!$firstAdspacePackage){
							$firstAdspacePackage = $package;
						}
						echo '<span id="adspace_'.$slug.'_'.$pSlug.'_width" data-info="'.$package['width'].'"></span>';
						echo '<span id="adspace_'.$slug.'_'.$pSlug.'_height" data-info="'.$package['height'].'"></span>';
						echo '<span class="adspace_'.$slug.'_package_item" data-package-slug="'.$pSlug.'" data-package-name="'.$package['name'].' ('.$package['width'].'x'.$package['height'].')"></span>';
				
						foreach($package['accepted'] as $accept => $val){
							$realPrice = $val;
							if($val >= 1000){
								$val = number_format($val);
							}
							if(!$firstAccept){
								$firstAccept = array('token' => $accept, 'val' => $val);
							}
							echo '<span class="adspace_'.$slug.'_'.$pSlug.'_accepted" data-token="'.$accept.'" data-price="'.$val.'" data-real-price="'.$realPrice.'"></span>';
						}
						echo '<span class="adspace_'.$slug.'_'.$pSlug.'_description" style="display: none;">'.markdown($package['description']).'</span>';
					}
					echo '<span class="adspace_'.$slug.'_rules" style="display: none;">'.markdown($space['rules']).'</span>';
				}				
				
				?>
				<?= $form->field('adspace')->display() ?>
				<?= $form->field('adspace_package')->display() ?>
				<div class="adspace_package_desc_display">
					<?= markdown($firstAdspacePackage['description']) ?>
				</div>
				<?= $form->field('adspace_weeks')->display() ?>
				<?= $form->field('adspace_image')->display() ?>
			</div>
			
			<div id="sponsor_form" >
				<?php
				$firstShowAccept = false;
				$firstShowPackage = false;
				foreach($this->shows as $slug => $show){
					foreach($show['packages'] as $pSlug => $package){
						if(!$firstShowPackage){
							$firstShowPackage = $package;
						}
						foreach($package['accepted'] as $accept => $val){
							$realPrice = $val;
							if($val >= 1000){
								$val = number_format($val);
							}
							if(!$firstShowAccept){
								$firstShowAccept = array('token' => $accept, 'val' => $val);
							}
							echo '<span class="sponsor_'.$slug.'_'.$pSlug.'_accepted" data-token="'.$accept.'" data-price="'.$val.'" data-real-price="'.$realPrice.'"></span>';
						}
						echo '<span class="sponsor_'.$slug.'_package_item" data-package-slug="'.$pSlug.'" data-package-name="'.$package['name'].'"></span>';
						echo '<span class="sponsor_'.$slug.'_'.$pSlug.'_description" style="display: none;">'.markdown($package['description']).'</span>';
					}
					echo '<span class="sponsor_'.$slug.'_rules" style="display: none;">'.markdown($show['rules']).'</span>';
				}
				
				?>
				<?= $form->field('sponsor_show')->display() ?>
				<?= $form->field('sponsor_package')->display() ?>
				<div class="sponsor_package_desc_display">
					<?= markdown($firstShowPackage['description']) ?>
				</div>				
				<?= $form->field('sponsor_time')->display() ?>
				<?= $form->field('sponsor_reason')->display() ?>
			</div>
			
			<?= $form->field('info')->display() ?>
			<?= $form->field('payment_type')->display() ?>
			<p class="success text-large">Your Total: <strong class="order-total"><?= $firstShowAccept['val'] ?> <?= $firstShowAccept['token'] ?></strong></p>
			<?php
			echo recaptcha_get_html(CAPTCHA_PUB, null, true);
			echo $form->displaySubmit();
			echo $form->close();
			
			?>
		</div>
		<link rel="stylesheet" type="text/css" href="<?= $this->site['url'] ?>/themes/ltb/css/jquery.datetimepicker.css"/ >
		<script src="<?= $this->site['url'] ?>/themes/ltb/js/jquery.datetimepicker.js"></script>		
		<script type="text/javascript">
			
		Number.prototype.formatMoney = function(c, d, t){
		var n = this, 
			c = isNaN(c = Math.abs(c)) ? 2 : c, 
			d = d == undefined ? "." : d, 
			t = t == undefined ? "," : t, 
			s = n < 0 ? "-" : "", 
			i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
			j = (j = i.length) > 3 ? j % 3 : 0;
		   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		 };			
			
		$(document).ready(function(){
			
			$('input[name="product_quantity"]').keydown(function (e) {
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
			
			$('#datetimepicker').datetimepicker({timepicker:false,format:'Y/m/d'});
			
			$('#i-agree').click(function(e){
				if(!$(this).is(':disabled')){
					$('#sponsor-form-cont').slideDown();
					$(this).attr('disabled', 'disabled');
				}
			});
			
			function refreshPriceTotal(){
				var newTotal = 0;
				var ad_type = $('select[name="ad_type"]').val();
				var token = $('select[name="payment_type"]').val();
				
				if(ad_type == 'sponsor'){
					var show = $('select[name="sponsor_show"]').val();
					var pkg = $('select[name="sponsor_package"]').val();
					var price = parseFloat($('.sponsor_' + show + '_' + pkg + '_accepted[data-token="' + token + '"]').data('real-price'));
					newTotal = price;
				}
				else if(ad_type == 'consult'){
					var show = $('select[name="consultant"]').val();
					var pkg = $('select[name="consult_package"]').val();
					var price = parseFloat($('.consult_' + show + '_' + pkg + '_accepted[data-token="' + token + '"]').data('real-price'));
					newTotal = price;
				}
				else if(ad_type == 'product'){
					var item = $('select[name="product"]').val();
					var pkg = $('select[name="product_package"]').val();
					var price = parseFloat($('.product_' + item + '_' + pkg + '_accepted[data-token="' + token + '"]').data('real-price'));
					var quantity = parseInt($('input[name="product_quantity"]').val());
					if(quantity <= 0){
						quantity = 1;
					}
					newTotal = price * quantity;
				}
				else{
					var space = $('select[name="adspace"]').val();
					var pkg = $('select[name="adspace_package"]').val();
					var price = parseFloat($('.adspace_' + space + '_' + pkg + '_accepted[data-token="' + token + '"]').data('real-price'));
					var weeks = parseFloat($('select[name="adspace_weeks"]').val());
					newTotal = price * weeks;
				}
				
				if(newTotal >= 1000){
					newTotal = newTotal.formatMoney(0);
				}
				
				$('.order-total').html(newTotal + ' ' + token)
			}
			
			function refreshPriceList(){

				var optList = '';
				var ad_type = $('select[name="ad_type"]').val();
				if(ad_type == 'sponsor'){
					var show = $('select[name="sponsor_show"]').val();
					var pkg = $('select[name="sponsor_package"]').val();
					$('.sponsor_' + show + '_' + pkg + '_accepted').each(function(){
						if(parseFloat($(this).data('price')) > 0){
							optList = optList + '<option value="' + $(this).data('token') + '">' + $(this).data('price') + ' ' + $(this).data('token') + '</option>';
						}
					});
					
					var pkg_desc = $('.sponsor_' + show + '_' + pkg + '_description').html();
					$('.sponsor_package_desc_display').html(pkg_desc);
				}
				else if(ad_type == 'consult'){
					var consult = $('select[name="consultant"]').val();
					var pkg = $('select[name="consult_package"]').val();
					$('.consult_' + consult + '_' + pkg + '_accepted').each(function(){
						if(parseFloat($(this).data('price')) > 0){
							optList = optList + '<option value="' + $(this).data('token') + '">' + $(this).data('price') + ' ' + $(this).data('token') + '</option>';
						}
					});
					
					var pkg_desc = $('.consult_' + consult + '_' + pkg + '_description').html();
					$('.consult_package_desc_display').html(pkg_desc);
				}
				else if(ad_type == 'product'){
					var item = $('select[name="product"]').val();
					var pkg = $('select[name="product_package"]').val();
					$('.product_' + item + '_' + pkg + '_accepted').each(function(){
						if(parseFloat($(this).data('price')) > 0){
							optList = optList + '<option value="' + $(this).data('token') + '">' + $(this).data('price') + ' ' + $(this).data('token') + '</option>';
						}
					});
					
					var pkg_desc = $('.product_' + item + '_' + pkg + '_description').html();
					$('.product_package_desc_display').html(pkg_desc);
				}
				else{
					//display ad
					var space = $('select[name="adspace"]').val();
					var pkg = $('select[name="adspace_package"]').val();
					$('.adspace_' + space + '_' + pkg + '_accepted').each(function(){
						if(parseFloat($(this).data('price')) > 0){
							optList = optList + '<option value="' + $(this).data('token') + '">' + $(this).data('price') + ' ' + $(this).data('token') + '</option>';
						}
					});
					
					var pkg_desc = $('.adspace_' + space + '_' + pkg + '_description').html();
					$('.adspace_package_desc_display').html(pkg_desc);		


					var width = $('#adspace_' + space + '_' + pkg + '_width').data('info');
					var height = $('#adspace_' + space + '_' + pkg + '_height').data('info');
					
					$('label[for="adspace_image"]').html('Upload Image (' + width + 'x' + height + ')');								
				}
				
				$('select[name="payment_type"]').html(optList);
				refreshPriceTotal();
			}
			
			$('select[name="ad_type"]').change(function(e){
				var val = $(this).val();
				if(val == 'sponsor'){
					$('#sponsor_form').show();
					$('#adspace_form').hide();
					$('#consult_form').hide();
					$('#product_form').hide();
					$('input[name="url"],label[for="url"]').show();
				}
				else if(val == 'consult'){
					$('#sponsor_form').hide();
					$('#adspace_form').hide();
					$('#consult_form').show();
					$('#product_form').hide();
					$('input[name="url"],label[for="url"]').hide();
				}
				else if(val == 'product'){
					$('#sponsor_form').hide();
					$('#adspace_form').hide();
					$('#consult_form').hide();
					$('#product_form').show();
					$('input[name="url"],label[for="url"]').hide();
				}
				else{
					$('#sponsor_form').hide();
					$('#adspace_form').show();
					$('#consult_form').hide();
					$('#product_form').hide();
					$('input[name="url"],label[for="url"]').show();
				}
				refreshPriceList();
			});
			
			$('select[name="sponsor_package"], select[name="adspace_package"], select[name="consult_package"], select[name="product_package"]').change(function(e){
				refreshPriceList();
			});
			$('select[name="sponsor_show"]').change(function(e){
				var show = $(this).val();
				var newOpts = '';
				$('.sponsor_' + show + '_package_item').each(function(){
					newOpts = newOpts + '<option value="' + $(this).data('package-slug') + '">' + $(this).data('package-name') + '</option>';
				});
				$('select[name="sponsor_package"]').html(newOpts);
				refreshPriceList();
				
			});
			$('select[name="consultant"]').change(function(e){
				var consultant = $(this).val();
				var newOpts = '';
				$('.consult_' + consultant + '_package_item').each(function(){
					newOpts = newOpts + '<option value="' + $(this).data('package-slug') + '">' + $(this).data('package-name') + '</option>';
				});
				$('select[name="consult_package"]').html(newOpts);
				refreshPriceList();
			});			
			
			$('select[name="product"]').change(function(e){
				var item = $(this).val();
				var newOpts = '';
				$('.product_' + item + '_package_item').each(function(){
					newOpts = newOpts + '<option value="' + $(this).data('package-slug') + '">' + $(this).data('package-name') + '</option>';
				});
				$('select[name="product_package"]').html(newOpts);
				refreshPriceList();
			});					
			
			$('select[name="adspace"]').change(function(e){
				var space = $(this).val();
				var newOpts = '';
				$('.adspace_' + space + '_package_item').each(function(){
					newOpts = newOpts + '<option value="' + $(this).data('package-slug') + '">' + $(this).data('package-name') + '</option>';
				});
				$('select[name="adspace_package"]').html(newOpts);
				refreshPriceList();
			});			
			
			$('select[name="payment_type"]').change(function(e){
				refreshPriceTotal();
			});			
			
			$('select[name="adspace_weeks"], input[name="product_quantity"]').change(function(e){
				refreshPriceTotal();
			});			
			
			$('#show-tos').click(function(e){
				if($(this).hasClass('collapse')){
					$('#sponsor-tos').slideUp();
					$(this).val('Show Network Rules and ToS');
					$(this).removeClass('collapse');
				}
				else{
					$('#sponsor-tos').slideDown();
					$(this).val('Hide Network Rules and ToS');
					$(this).addClass('collapse');
				}
			});		
						
		});
		
		</script>
		<?php		
	}
	
	private function getBuilderForm()
	{
		$form = new UI\Form;
		$form->setFileEnc();
		
		$email = new UI\Textbox('email', 'email');
		$email->setLabel('Your Email Address');
		$email->addAttribute('required');
		$form->add($email);
		
		$url =  new UI\Textbox('url', 'url');
		$url->setLabel('Destination URL / URL to Mention');
		$form->add($url);
		
		$adType = new UI\Select('ad_type');
		$adType->setLabel('Sponsorship Type');
		$adType->addOption('sponsor', 'Podcast Sponsorship');
		$adType->addOption('display', 'Display Advertisement');
		$adType->addOption('consult', 'Network Personalities');
		$adType->addOption('product', 'Physical Items / Prize Redemptions');
		$form->add($adType);
		
		/*** PODCAST SPONSORS ***/
		$shows = new UI\Select('sponsor_show');
		$firstShow = false;
		foreach($this->shows as $slug => $show){
			if(!$firstShow){
				$firstShow = $show;
			}
			$shows->addOption($slug, $show['name']);
		}
		$shows->setLabel('Choose Your Show');
		$form->add($shows);
		
		$sponsor_package = new UI\Select('sponsor_package');
		$sponsor_package->setLabel('Sponsorship Package');
		$firstShowPackage = false;
		foreach($firstShow['packages'] as $pSlug => $package){
			if(!$firstShowPackage){
				$firstShowPackage = $package;
			}
			$sponsor_package->addOption($pSlug, $package['name']);
		} 
		$form->add($sponsor_package);
		
		$sponsor_time = new UI\Textbox('sponsor_time', 'datetimepicker');
		$sponsor_time->setLabel('Preferred date of sponsorship? (optional)');
		$form->add($sponsor_time);
		
		$sponsorReason = new UI\Textarea('sponsor_reason');
		$sponsorReason->setLabel('What are you hoping to accomplish with this sponsorship?');
		$form->add($sponsorReason);
		
		/*** END PODCAST SPONSORS ***/
		
		/*** DISPLAY ADS ***/
		
		$adspaces = new UI\Select('adspace');
		$adspaces->setLabel('Choose Your Page');
		$firstSpace = false;
		foreach($this->adspaces as $slug => $space){
			if(!$firstSpace){
				$firstSpace = $space;
			}
			$adspaces->addOption($slug, $space['name']);
		}
		$form->add($adspaces);
		
		$adspace_package = new UI\Select('adspace_package');
		$adspace_package->setLabel('Advertisement Package');
		$firstSpacePackage = false;
		foreach($firstSpace['packages'] as $pSlug => $package){
			if(!$firstSpacePackage){
				$firstSpacePackage = $package;
			}
			$adspace_package->addOption($pSlug, $package['name'].' ('.$package['width'].'x'.$package['height'].')');
		} 
		$form->add($adspace_package);		
		
		$weeks = new UI\Select('adspace_weeks');
		for($i = 1; $i <= 12; $i++){
			$weeks->addOption($i, $i);
		}
		$weeks->setLabel('Number of Weeks');
		$form->add($weeks);
		
		$img = new UI\File('adspace_image', 'adspace_image');
		$img->setLabel('Upload Image ('.$firstSpacePackage['width'].'x'.$firstSpacePackage['height'].')');
		$form->add($img);
		
		/*** END DISPLAY ENDS ***/
		
		/*** NETWORK PEOPLE ***/
		
		$consultant = new UI\Select('consultant');
		$consultant->setLabel('Choose an Individual');
		$firstConsult = false;
		foreach($this->consultants as $cSlug => $con){
			if(!$firstConsult){
				$firstConsult = $con;
			}
			$consultant->addOption($cSlug, $con['name']);
		}
		$form->add($consultant);
		
		$consult_package = new UI\Select('consult_package');
		$consult_package->setLabel('Choose Package');
		$firstConsultPackage = false;
		foreach($firstConsult['packages'] as $pSlug => $package){
			if(!$firstConsultPackage){
				$firstConsultPackage = $package;
			}
			$consult_package->addOption($pSlug, $package['name']);
		} 
		$form->add($consult_package);
		
		$briefing = new UI\Textarea('consult_brief');
		$briefing->setLabel('What are you hoping to accomplish?');
		$form->add($briefing);
		
		/*** END NETWORK PEOPLE ***/
		
		/*** PHYSICAL ITEMS ***/
		$products = new UI\Select('product');
		$products->setLabel('Choose Item Type');
		$firstProduct = false;
		foreach($this->products as $cSlug => $con){
			if(!$firstProduct){
				$firstProduct = $con;
			}
			$products->addOption($cSlug, $con['name']);
		}
		$form->add($products);
		
		$product_package = new UI\Select('product_package');
		$product_package->setLabel('Choose Package');
		$firstProductPackage = false;
		foreach($firstProduct['packages'] as $pSlug => $package){
			if(!$firstProductPackage){
				$firstProductPackage = $package;
			}
			$product_package->addOption($pSlug, $package['name']);
		} 
		$form->add($product_package);
			
		$product_quantity = new UI\Textbox('product_quantity');
		$product_quantity->setLabel('Quantity');
		$product_quantity->setValue(1);
		$form->add($product_quantity);
		
		$product_ship_name = new UI\Textbox('product_ship_name');
		$product_ship_name->setLabel('Your Name');
		$form->add($product_ship_name);
		
		$product_ship_address = new UI\Textbox('product_ship_address');
		$product_ship_address->setLabel('Shipping Address');
		$form->add($product_ship_address);
		
		$product_ship_city = new UI\Textbox('product_ship_city');
		$product_ship_city->setLabel('City');
		$form->add($product_ship_city);
		
		$product_ship_state = new UI\Textbox('product_ship_state');
		$product_ship_state->setLabel('State / Province');
		$form->add($product_ship_state);
		
		$product_ship_country = new UI\Textbox('product_ship_country');
		$product_ship_country->setLabel('Country');
		$form->add($product_ship_country);
		
		$product_ship_postal = new UI\Textbox('product_ship_postal');
		$product_ship_postal->setLabel('ZIP / Postal Code');
		$form->add($product_ship_postal);										
		
		/*** END PHYSICAL ITEMS ***/
		
		$info = new UI\Textarea('info', 'info');
		$info->setLabel('Additional Info (optional)');
		$form->add($info);
		
		
		$payType = new UI\Select('payment_type');
		$payType->setLabel('Method of Payment');
		foreach($firstShowPackage['accepted'] as $token => $val){
			if($val <= 0){
				continue;
			}
			if($token != 'BTC'){
				$val = number_format($val);
			}
			$payType->addOption($token, $val.' '.$token);
		}
		$form->add($payType);
		
		return $form;
	}
	
	private function submitForm($data)
	{
		$xcp = new API\Bitcoin(XCP_CONNECT);
		
		$resp = recaptcha_check_answer (CAPTCHA_PRIV,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);
										
		if(!$resp->is_valid) {
			throw new \Exception('Captcha invalid!');
		}												
		
		if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
			throw new \Exception('Invalid email address');
		}
		
		if(trim($data['url']) == '' AND ($data['ad_type'] != 'consult' AND $data['ad_type'] != 'product')){
			throw new \Exception('Destination URL required');
		}
		
		$validTypes = array('sponsor', 'display', 'consult', 'product');
		if(!in_array($data['ad_type'], $validTypes)){
			throw new \Exception('Invalid Advertisement Type');
		}
		
		$emailList = $this->main_email;
		
		switch($data['ad_type']){
			case 'sponsor':
				if(trim($data['sponsor_reason']) == ''){
					throw new \Exception('Please include what you are hoping to accomplish with this sponsorship');
				}
				if(!isset($this->shows[$data['sponsor_show']])){
					throw new \Exception('Invalid podcast');
				}
				$show = $this->shows[$data['sponsor_show']];
				if(!isset($show['packages'][$data['sponsor_package']])){
					throw new \Exception('Invalid sponsorship package');
				}
				$package = $show['packages'][$data['sponsor_package']];
				$accepted = $package['accepted'];
				$emailList .= ','.$show['emails'];
				break;
			case 'consult':
				if(trim($data['consult_brief']) == ''){
					throw new \Exception('Please include what you are hoping to accomplish');
				}
				if(!isset($this->consultants[$data['consultant']])){
					throw new \Exception('Invalid person');
				}
				$con = $this->consultants[$data['consultant']];
				if(!isset($con['packages'][$data['consult_package']])){
					throw new \Exception('Invalid sponsorship package');
				}
				$package = $con['packages'][$data['consult_package']];
				$accepted = $package['accepted'];
				$emailList .= ','.$con['emails'];			
				break;
			case 'product':
				if(!isset($this->products[$data['product']])){
					throw new \Exception('Invalid product type');
				}
				$product = $this->products[$data['product']];
				if(!isset($product['packages'][$data['product_package']])){
					throw new \Exception('Invalid product package');
				}
				$package = $product['packages'][$data['product_package']];
				$accepted = $package['accepted'];
				$emailList .= ','.$product['emails'];	
				
				if(empty($data['product_quantity'])){
					throw new \Exception('Please enter in a product quantity');
				}
				
				$shippingFields = array('name', 'address', 'city', 'state', 'country', 'postal');
				foreach($shippingFields as $ship_field){
					if(empty($data['product_ship_'.$ship_field])){
						throw new \Exception('Please include all shipping details');
					}
				}		
				break;
			case 'display':
				if(!isset($_FILES['adspace_image']['name']) OR trim($_FILES['adspace_image']['name']) == ''){
					throw new \Exception('Please upload an image for your advertisement');
				}
			
				$imgName = $_FILES['adspace_image']['tmp_name'];
				$getSize = getimagesize($imgName);
				$validMimes = array('image/png', 'image/jpeg', 'image/gif');
				if(!$getSize OR !in_array($getSize['mime'], $validMimes)){
					throw new \Exception('Invalid image file type');
				}
				if(!isset($this->adspaces[$data['adspace']])){
					throw new \Exception('Invalid adspace');
				}				
				$adspace = $this->adspaces[$data['adspace']];
				if(!isset($adspace['packages'][$data['adspace_package']])){
					throw new \Exception('Invalid sponsorship package');
				}				
				$package = $adspace['packages'][$data['adspace_package']];				
								
				
				$reqRatio = $package['width'] / $package['height'];
				$thisRatio = $getSize[0] / $getSize[1];
				if($thisRatio != $reqRatio OR ($getSize[0] < $package['width'] OR $getSize[1] < $package['height'])){
					throw new \Exception('Image incorrect size, must be '.$package['width'].'x'.$package['height'].' (or larger, but same size ratio)');
				}
				
				//save image
				$adPath = SITE_PATH.'/files/ads';
				$adUrl = $this->site['url'].'/files/ads';
				if(!is_dir($adPath)){
					@mkdir($adPath);
				}
				
				$ext = '';
				switch($getSize['mime']){
					case 'image/png':
						$ext = '.png';
						break;
					case 'image/gif':
						$ext = '.gif';
						break;
					case 'image/jpeg':
					default:
						$ext = '.jpg';
						break;
				}
				
				$newImgName = md5($_FILES['adspace_image']['name'].time()).$ext;
				$saveImage = move_uploaded_file($imgName, $adPath.'/'.$newImgName);
				if(!$saveImage){
					throw new \Exception('Error uploading display ad image');
				}
				
				$accepted = $package['accepted'];
				$emailList .= ','.$adspace['emails'];
				
				break;
		}
		
		$price = 0;
		$acceptFound = false;
		foreach($accepted as $key => $adprice){
			if($key == $data['payment_type']){
				$acceptFound = true;
				$price = $adprice;
			}
		}
		
		if(!$acceptFound){
			throw new \Exception('Invalid payment method');
		}
		
		$finalCost = $price;
		if($data['ad_type'] == 'display'){
			$weeks = intval($data['adspace_weeks']);
			$finalCost = $price * $weeks;
		}
		if($data['ad_type'] == 'product'){
			$quant = intval($data['product_quantity']);
			if($quant <= 0){
				$quant = 1;
			}
			$finalCost = $price * $quant;
		}
		
		if($finalCost <= 0){
			throw new \Exception('Invalid payment type');
		}

		$orderInfo = array();
		$orderInfo['time'] = timestamp();
		$orderInfo['account'] = 'ad_'.$data['ad_type'].'_'.md5($orderInfo['time']);
		$orderInfo['payment_token'] = $data['payment_type'];
		$orderInfo['userId'] = $this->user['userId'];
		
		$btc = new API\Bitcoin(BTC_CONNECT);
		try{
			$getAddress = $btc->getaccountaddress($orderInfo['account']);
		}
		catch(\Exception $e){
			throw new \Exception('Error connecting to bitcoin');
		}
		
		$orderInfo['address'] = $getAddress;
		
		$insertData = array();
		$insertData['address'] = $orderInfo['address'];
		$insertData['account'] = $orderInfo['account'];
		$insertData['amount'] = $finalCost;
		$insertData['asset'] = $orderInfo['payment_token'];
		$insertData['orderTime'] = $orderInfo['time'];
		$insertData['orderType'] = 'ad-purchase';

		$insertData['orderData'] = array();
		$insertData['orderData']['ad_type'] = $data['ad_type'];
		switch($data['ad_type']){
			case 'sponsor':
				$insertData['orderData']['destination_url'] = $data['url'];
				$insertData['orderData']['show'] = $show['name'];
				$insertData['orderData']['package'] = $package['name'];
				$insertData['orderData']['preferred_date'] = $data['sponsor_time'];
				$insertData['orderData']['reason'] = $data['sponsor_reason'];
				$insertData['orderData']['forward_address'] = $show['forward_address'];
				break;
			case 'consult':
				$insertData['orderData']['consultant'] = $con['name'];
				$insertData['orderData']['package'] = $package['name'];
				$insertData['orderData']['reason'] = $data['consult_brief'];
				$insertData['orderData']['forward_address'] = $con['forward_address'];			
				break;
			case 'product':
				$insertData['orderData']['product'] = $product['name'];
				$insertData['orderData']['package'] = $package['name'];
				$insertData['orderData']['quantity'] = $data['product_quantity'];
				$insertData['orderData']['ship_name'] = $data['product_ship_name'];
				$insertData['orderData']['ship_address'] = $data['product_ship_address'];
				$insertData['orderData']['ship_city'] = $data['product_ship_city'];
				$insertData['orderData']['ship_state'] = $data['product_ship_state'];
				$insertData['orderData']['ship_country'] = $data['product_ship_country'];
				$insertData['orderData']['ship_postal'] = $data['product_ship_postal'];
				$insertData['orderData']['forward_address'] = $product['forward_address'];
				break;
			case 'display':
				$insertData['orderData']['destination_url'] = $data['url'];
				$insertData['orderData']['adspace'] = $adspace['name'];
				$insertData['orderData']['package'] = $package['name'];
				$insertData['orderData']['weeks'] = $data['adspace_weeks'];
				$insertData['orderData']['image'] = $newImgName;
				$insertData['orderData']['image_url'] = $adUrl.'/'.$newImgName;
				$insertData['orderData']['forward_address'] = $adspace['forward_address'];
				break;
		}
		$insertData['orderData']['additional_info'] = $data['info'];
		$insertData['orderData']['customer_email'] = $data['email'];
		$insertData['orderData']['forward_emails'] = $emailList;
		$insertData['orderData'] = json_encode($insertData['orderData']);
			
		$addOrder = $this->model->insert('payment_order', $insertData);
		if(!$addOrder){
			throw new \Exception('Error submitting order');
		}
		
		$orderInfo['orderId'] = $addOrder;
		setcookie('ordered_sponsorship', true, time()+(60*60*24*200));
		
		return $orderInfo;
	}
	
	public function checkOrderPayment($orderId)
	{
		ob_end_clean();
		header('Content-Type: text/json');
		$output = array();
		$getOrder = $this->model->get('payment_order', $orderId);
		if(!$getOrder){
			http_response_code(404);
			$output['error'] = 'Order not found';
		}
		else{
			$btc = new API\Bitcoin(BTC_CONNECT);
			$xcp = new API\Bitcoin(XCP_CONNECT);
			$getOrder['orderData'] = json_decode($getOrder['orderData'], true);
			$editValues = array();
			switch($getOrder['asset']){
				case 'BTC':
					$balance = 0;
					$confirmed = 0;
					try{
						$getTx = $btc->listtransactions($getOrder['account']);
					}
					catch(\Exception $e){
						http_response_code(400);
						$output['error'] = 'Error getting balance';
						echo json_encode($output);
						die();
					}
					if(is_array($getTx)){
						foreach($getTx as $tx){
							if($tx['category'] == 'receive'){
								$balance += $tx['amount'];
								if($tx['confirmations'] > 0){
									$confirmed += $tx['amount'];
								}
							}
						}
					}
					$received = $balance;
					$complete = 0;
					$editValues = array('received' => $received);
					if($confirmed >= $getOrder['amount']){
						$complete = 1;
						$editValues['complete'] = 1;
						$editValues['completeTime'] = timestamp();		
						try{
							$finalize = $this->completeOrder($getOrder);
						}
						catch(\Exception $e){
							$finalize = false;
							http_response_code(400);
							$output['error'] = 'Could not complete order: '.$e->getMessage();
							echo json_encode($output);
							die();							
						}
						$output['board_link'] = $finalize;	
					}
					break;
				default:
					
					try{
						$getPool = $xcp->get_mempool();
						$getBalances = $xcp->get_balances(array('filters' => array('field' => 'address', 'op' => '=', 'value' => $getOrder['address'])));
					}
					catch(\Exception $e){
						http_response_code(400);
						$output['reror'] = 'Error retrieving balance';
						echo json_encode($output);
						die();
					}
					
					$received = 0;
					$complete = 0;
					$assetInfo = $this->inventory->getAssetData($getOrder['asset']);
					
					foreach($getPool as $pool){
						if($pool['category'] == 'sends'){
							$parse = json_decode($pool['bindings'], true);
							if($parse['destination'] == $getOrder['address'] AND $parse['asset'] == $getOrder['asset']){
								//check TX to make sure its an actual unconfirmed transaction
								$getTx = $btc->gettransaction($pool['tx_hash']);
								if($getTx AND $getTx['confirmations'] == 0){
									$newCoin = $parse['quantity'];
									if($assetInfo['divisible'] == 1 AND $newCoin > 0){
										$newCoin = $newCoin / SATOSHI_MOD;
									}
									$received+= $newCoin;
								}
							}
						}
					}	

					foreach($getBalances as $balance){
						if($balance['asset'] == $getOrder['asset']){
							if($assetInfo['divisible'] == 1 AND $balance['quantity'] > 0){
								$balance['quantity'] = $balance['quantity'] / SATOSHI_MOD;
							}
							$received += $balance['quantity'];
						}
					}
					
					$editValues = array('received' => $received);
					
					if($received >= $getOrder['amount']){
						$complete = 1;
						$editValues['complete'] = 1;
						$editValues['completeTime'] = timestamp();
						try{
							$finalize = $this->completeOrder($getOrder);
						}
						catch(\Exception $e){
							$finalize = false;
							http_response_code(400);
							$output['error'] = 'Could not complete order: '.$e->getMessage();
							echo json_encode($output);
							die();							
						}
					}	
					break;
			}
			$edit = $this->model->edit('payment_order', $getOrder['orderId'], $editValues);
			if(!$edit){
				http_response_code(400);
				$output['error'] = 'Error updating order';
				echo json_encode($output);
				die();
			}	
			if($complete === 1){
				$output['result'] = 'complete';
				$output['received'] = $received;
			}
			else{
				$output['result'] = 'none';
				if($received > 0){
					$output['result'] = 'receiving';
				}
				$output['received'] = $received;
			}
		}
		http_response_code(200);
		echo json_encode($output);
		die();
	}
	
	public function completeOrder($order)
	{
		$orderData = $order['orderData'];
		
		ob_start();
		?>
		<p>
			A new advertisement/sponsorship submission has been received. Details below:
		</p>
		<?php
		echo '<ul>
				<li><strong>Customer Email:</strong> '.$orderData['customer_email'].'</li>
				<li><strong>Destination URL:</strong> '.$orderData['destination_url'].'</li>		
		';
		$typeName = '';
		switch($orderData['ad_type']){
			case 'display':
				$typeName = 'Display Advertisement';
				?>
				<li><strong>Type:</strong> Display Ad</li>
				<li><strong>Page:</strong> <?= $orderData['adspace'] ?></li>
				<li><strong>Package:</strong> <?= $orderData['package'] ?></li>
				<li><strong># of Weeks:</strong> <?= $orderData['weeks'] ?></li>
				<li><strong>Display Image:</strong> <a href="<?= $orderData['image_url'] ?>" target="_blank"><?= $orderData['image_url'] ?></a></li>
				<?php
				break;
			case 'sponsor':
				$typeName = 'Podcast Sponsorship';
				?>
				<li><strong>Type:</strong> Podcast Sponsorship</li>
				<li><strong>Podcast/Show:</strong> <?= $orderData['show'] ?></li>
				<li><strong>Package:</strong> <?= $orderData['package'] ?></li>
				<li><strong>Preferred Sponsorship Date:</strong> <?= $orderData['preferred_date'] ?></li>
				<li><strong>What are you hoping to accomplish?:</strong> <?= $orderData['reason'] ?></li>
				<?php
				break;
			case 'consult':
				$typeName = 'Network Personality';
				?>
				<li><strong>Type:</strong> Network Personality</li>
				<li><strong>Personality:</strong> <?= $orderData['consultant'] ?></li>
				<li><strong>Package:</strong> <?= $orderData['package'] ?></li>
				<li><strong>What are you hoping to accomplish?:</strong> <?= $orderData['reason'] ?></li>
				<?php
				break;	
			case 'product':
				?>
				<li><strong>Type:</strong> Physical Item</li>
				<li><strong>Product Type:</strong> <?= $orderData['product'] ?></li>
				<li><strong>Package:</strong> <?= $orderData['package'] ?></li>
				<li><strong>Quantity:</strong> <?= $orderData['quantity'] ?></li>
				<li><strong>Shipping Details:</strong>
					<ul>
						<li><strong>Name:</strong> <?= $orderData['ship_name'] ?></li>
						<li><strong>Address:</strong> <?= $orderData['ship_address'] ?></li>
						<li><strong>City:</strong> <?= $orderData['ship_city'] ?></li>
						<li><strong>State/Province:</strong> <?= $orderData['ship_state'] ?></li>
						<li><strong>Country:</strong> <?= $orderData['ship_country'] ?></li>
						<li><strong>ZIP / Postal Code:</strong> <?= $orderData['ship_postal'] ?></li>
					</ul>
				</li>
				<?php
				break;
		}
		if($order['asset'] != 'BTC'){
			$order['amount'] = number_format($order['amount']);
		}
		else{
			$order['amount'] = convertFloat($order['amount']);
		}
		?>
		<li><strong>Additional Info:</strong> <?= $orderData['additional_info'] ?></li>
		<li><strong>Payment Method:</strong> <?= $order['amount'] ?> <?= $order['asset'] ?> (completed)</li>
		<li><strong>Payment Address:</strong> <a href="https://blockchain.info/address/<?= $order['address'] ?>" target="_blank"><?= $order['address'] ?></a></li>
		<li><strong>Customer IP Address:</strong> <?= $_SERVER['REMOTE_ADDR'] ?></li>
		<?php
	
		echo '</ul>';		
		$emailOutput = ob_get_contents();
		ob_end_clean();
		
		$mail = new Util\Mail;
		$mail->setFrom('noreply@'.$this->site['domain']);
		$expEmails = explode(',', $orderData['forward_emails']);
		foreach($expEmails as $em){
			$mail->addTo($em);
		}
		$mail->setSubject($typeName.' Purchase - '.timestamp());
		$mail->setHTML($emailOutput);
		
		$send = $mail->send();
		if(!$send){
			return false;
		}

		return true;
	}
	
}
