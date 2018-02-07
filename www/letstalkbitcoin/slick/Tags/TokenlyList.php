<?php
namespace Tags;
use Core;
class TokenlyList extends Core\Model
{
	function __construct()
	{
		parent::__construct();
	}

	
	public function display()
	{
		$table = false;
		if(isset($this->params['type'])){
			switch($this->params['type']){
				case 'swapbot':
					$table = $this->showSwapbotList();
					break;
				case 'tend':
					$table = $this->showTendList();
			}
		}
		
		ob_start();
		?>
		<?= $table ?>
		<style>
			.content table a.buy-tokens{
				font-size: 16px;
				font-weight: 700;
				color: #000;
			}
		</style>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;		
	}
	
	protected function showSwapbotList()
	{
		ob_start();
		?>
		<table>
			<thead>
				<tr>
					<th>Primary Token</th>
					<th>Bot Owner</th>
					<th>Link</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>LTBDISPLAY</strong></td>
					<td><strong class="text-success">LTB <i class="fa fa-star"> </i></strong></td>
					<td><a href="http://swapbot.tokenly.com/public/adam/17d3eec5-97d0-41f3-ba6b-1d6e499ec9b2#choose" target="_blank" class="buy-tokens">Buy Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>
				<tr>
					<td><strong>LTBCOIN</strong></td>
					<td><strong class="text-success">LTB <i class="fa fa-star"> </i></strong></td>
					<td><a href="http://swapbot.tokenly.com/public/adam/5d982529-c20e-4bfd-b4b1-4093155ea275" target="_blank" class="buy-tokens">Buy Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>		
				<tr>
					<td><strong>BOOKKEEPER</strong></td>
					<td><strong class="text-success">LTB <i class="fa fa-star"> </i></strong></td>
					<td><a href="http://swapbot.tokenly.com/public/adam/dbca99d0-39ef-455d-81f9-6fbf9aa0c7c2#choose" target="_blank" class="buy-tokens">Buy Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>
				<tr>
					<td><strong>SPONSOR</strong></td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/adam" target="_blank">Adam</a></strong></td>
					<td><a href="http://swapbot.tokenly.com/public/adam/5ad9f09b-73c4-47d9-be06-fbab44918ef1#choose" target="_blank" class="buy-tokens">Buy Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>
				<tr>
					<td><strong>HOURCONSULT</strong></td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/adam" target="_blank">Adam</a></strong></td>
					<td><a href="http://swapbot.tokenly.com/public/adam/fe68c788-e935-4b6a-96da-bc449eb8df0e#choose" target="_blank" class="buy-tokens">Buy Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>	
				<tr>
					<td><strong>TATIANACOIN</strong></td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/tatianamoroz" target="_blank">TatianaMoroz</a></strong></td>
					<td><a href="http://swapbot.tokenly.com/public/tatiana/17d47db1-6115-485d-bd62-bb965bb31867#choose" target="_blank" class="buy-tokens">Buy Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>									
				<tr>
					<td><strong>WOODSHARES</strong></td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/bitcoinsuramerica" target="_blank">Bitcoinsuramerica</a></strong></td>
					<td><a href="http://swapbot.tokenly.com/public/valet/86f3ed63-e98f-47ac-9407-8339e0625d9a" target="_blank" class="buy-tokens">Buy Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>		
				<tr>
					<td><strong>OCTO</strong></td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/framelalife" target="_blank">frameLAlife</a></strong></td>
					<td><a href="http://swapbot.tokenly.com/public/FrameLAlife/1feaa10d-b793-4abb-801d-7b782581faa5" target="_blank" class="buy-tokens">Buy Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>											
			</tbody>
		</table>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;	
	}
	
	protected function showTendList()
	{
		ob_start();
		?>
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Accepted Tokens</th>
					<th>Merchant</th>
					<th>Link</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>1 Week Display Advertisement on the Front Page Sidebar of LetsTalkBitcoin.com</strong></td>
					<td>LTBDISPLAY, LTBCOIN, BTC, XCP</td>
					<td><strong class="text-success">LTB <i class="fa fa-star"> </i></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/7" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>	
				<tr>
					<td><strong>Be a Swapbot Token Vending Machine Early Adopter</strong></td>
					<td>TOKENLY, BTC, LTBCOIN, EARLY, XCP</td>
					<td><strong class="text-success">Tokenly <i class="fa fa-star"> </i></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/4" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>				
				<tr>
					<td><strong>Be a Tend Token Redemption System Early Adopter</strong></td>
					<td>TOKENLY, BTC, LTBCOIN, EARLY, XCP</td>
					<td><strong class="text-success">Tokenly <i class="fa fa-star"> </i></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/5" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>				
				<tr>
					<td><strong>Full Sponsorship on LTB Show</strong></td>
					<td>BTC,LTBCOIN,XCP,SPONSOR</td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/adam" target="_blank">Adam</a></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/14" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>				
				<tr>
					<td><strong>Lite Sponsorship on LTB Show</strong></td>
					<td>BTC,LTBCOIN,XCP,SPONSOR</td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/adam" target="_blank">Adam</a></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/8" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>				
				<tr>
					<td><strong>Schedule a One Hour Consultation via Skype with Adam B. Levine</strong></td>
					<td>HOURCONSULT, LTBCOIN, BTC, XCP </td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/adam" target="_blank">Adam</a></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/1" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>				
				<tr>
					<td><strong>Schedule a Half Hour Consultation via Skype with Adam B. Levine</strong></td>
					<td>HALFHOURADAM, HOURCONSULT, LTBCOIN, BTC, XCP</td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/adam" target="_blank">Adam</a></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/9" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>				
				<tr>
					<td><strong>Personalized Voicemail Greeting by Stephanie Murphy</strong></td>
					<td>LTBCOIN, BTC</td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/stephanie" target="_blank">stephanie</a></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/10" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>				
				<tr>
					<td><strong>Professional Narration by Stephanie Murphy</strong></td>
					<td>LTBCOIN</td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/stephanie" target="_blank">stephanie</a></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/11" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>				
				<tr>
					<td><strong>Digital Album from Singer/Songwriter Tatiana Moroz</strong></td>
					<td>LTBCOIN, TATIANACOIN, BTC</td>
					<td><strong><a href="https://letstalkbitcoin.com/profile/user/tatianamoroz" target="_blank">TatianaMoroz</a></strong></td>
					<td><a href="http://redeem.tokenly.com/redeem/2" target="_blank" class="buy-tokens">Redeem Tokens <i class="fa fa-chevron-right"></i></a></td>
				</tr>																																														
			</tbody>
		</table>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;	
	}
	
	
}
