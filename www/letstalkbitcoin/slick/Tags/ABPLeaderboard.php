<?php
namespace Tags;
use App, App\Tokenly, UI, Util, Core, App\Account;
class ABPLeaderboard
{
	public $keyRewards = array(0 => 10000, 1 => 8000, 2 => 7000, 3 => 6500, 4 => 6000,
							 5 => 5750, 6 => 5500, 7 => 5250, 8 => 5000, 9 =>4800, 10 => 4600,
							 11 => 4400, 12 => 4200, 13 => 4000, 14 => 3900, 15 => 3800,
							 16 => 3700, 17 => 3600, 18 => 3500, 19 => 3400, 20 => 3000);
	
	public $keyTokens = array('DORKY','IPPLE','RABBOAT','LEAT','FIRED');
							 
	public $bonusRewards = array(0 => 1000, 1 => 900, 2 => 800, 3 => 750, 4 => 700,
							 5 => 650, 6 => 600, 7 => 550, 8 => 500, 9 =>450, 10 => 400,
							 11 => 350, 12 => 300, 13 => 275, 14 => 250, 15 => 225,
							 16 => 200, 17 => 175, 18 => 150, 19 => 125, 20 => 100);				
							 
	public $bonusTokens = array('DRMWRK');
							 
	public $treasureReward = 1;	 
	
	public $treasureTokens = array('GAMR');
	
	public $maxPlayers = 20;
	
	public $ignorePlayers = array('cryptonaut','matt','ytcoinartist','tr3n47y','yarrel','rubenalexander','adam','RUS3','whit3r4bbi7','testderp');
	
	function __construct()
	{
		$this->model = new \App\Meta_Model;
		$this->inventory = new Tokenly\Inventory_Model;
		$this->lateKey = count($this->keyRewards) - 1;
		$this->lateBonus = count($this->bonusRewards) - 1;
		$this->site = $this->model->get('sites', $_SERVER['HTTP_HOST'], array(), 'domain'); //get basic site data
		$this->user = Account\Home_Model::userInfo(); //load user data
	}
	
	public function display()
	{
		
		$leaderboard = array();
		$players = array();
		$getAllUserMeta = $this->model->getAll('user_meta', array('metaKey' => 'site_referral', 'metaValue' => 'whit3r4bbi7'));
		foreach($getAllUserMeta as $meta){
			$getGameData = $this->model->getAll('user_meta', array('metaKey' => 'arg_game1', 'userId' => $meta['userId']));
			if(!$getGameData OR count($getGameData) == 0){
				$gameData = array();
			}
			else{
				$gameData = json_decode($getGameData[0]['metaValue'], true);
			}
			$getUser = $this->model->get('users', $meta['userId']);
			foreach($this->ignorePlayers as $ignore){
				if(trim(strtolower($ignore)) == trim(strtolower($getUser['username']))){
					continue 2;
				}
			}
			$getUser['game'] = $gameData;
			$getUser['inventory'] = $this->inventory->getUserBalances($getUser['userId'], true);
			$players[] = $getUser;
		}
		$this->players = $players;
		
		foreach($players as $player){
			$boardData = array('userId' => $player['userId'], 'username' => $player['username'], 'slug' => $player['slug']);
			$boardData['link'] = '<a href="'.$this->site['url'].'/profile/user/'.$player['slug'].'" target="_blank">'.$player['username'].'</a>';
			$score = $this->getPlayerScore($player);
			$boardData['scoreData'] = $score;
			$boardData['score'] = $score['total'];
			$boardData['displayScore'] = number_format($boardData['score']);
			$boardData['level'] = count($score['keys']['tokens']);
			$leaderboard[] = $boardData;
		}
		aasort($leaderboard, 'score');
		$leaderboard = array_reverse($leaderboard);
		foreach($leaderboard as $key => &$row){
			if($key >= $this->maxPlayers){
				unset($leaderboard[$key]);
				continue;
			}
			$row['position'] = $key+1;
		}
		
		$myInventory = $this->inventory->getUserBalances($this->user['userId'], true);
		$showRabboat = false;
		$graveyard_link = '';
		if(isset($myInventory['IPPLE']) AND $myInventory['IPPLE'] > 0){
			$showRabboat = true;
			$graveyard_link = '          |  <a href="'.$this->site['url'].'/b3l47ed" target="_blank">We Will Never For...</a>  ||'.PHP_EOL;
			if(isset($myInventory['RABBOAT']) AND $myInventory['RABBOAT'] > 0){
				$graveyard_link = '          |  <a href="'.$this->site['url'].'/nucl34rd8198efa" target="_blank">FOR IN THIS SLEEP OF</a>  ||'.PHP_EOL.
								  '          |  <a href="'.$this->site['url'].'/nucl34rd8198efa" target="_blank">D347H WHAT DREAMS MAY</a> ||'.PHP_EOL.
						          '          |          <a href="'.$this->site['url'].'/nucl34rd8198efa" target="_blank">COME...</a>       ||'.PHP_EOL;
			}
		}
		
		$asterik = '*';
		if(isset($myInventory['LEAT']) AND $myInventory['LEAT'] > 0){
			$asterik = '<a href="'.$this->site['url'].'/torched-h34r7s"><i class="fa fa-fire"></i></a>';
		}
		
		$view = new \App\View;
		$table = $view->generateTable($leaderboard, array('fields' => array('position' => '#', 'link' => 'Player', 'displayScore' => 'Points', 'level' => 'Level')));
		ob_start();
		?>
		<div class="abp-leaderboard">
			<h4>Leaderboard [Top <?= $this->maxPlayers ?> Players]</h4>
			<?= $table->display() ?>
		</div>
		<?php
		if($showRabboat){
			?><br>
			<div style="font-family: monospace;">
<pre>
                    ______
           ________/      \\________
          |     _     ___   _      ||
          |    | \     |   | \     ||
          |    |  |    |   |  |    ||
          |    |_/     |   |_/     ||
          |    | \     |   |       ||
          |    |  \    |   |       ||
          |    |   \. _|_. | .     ||
          |                        ||
<?= $graveyard_link ?>
          |                        ||
  <?= $asterik ?>       | *   **    * **   **    |**      <?= $asterik ?><?= $asterik ?>
  </pre>
</div>
			<?php
		}
		?>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
		
	}
	
	public function getKeyScore($player)
	{
		$output = array('score' => 0);
		$tokens = array();
		foreach($player['inventory'] as $asset => $amount){
			if(in_array($asset, $this->keyTokens)){
				$tokenScore = $this->keyRewards[$this->lateKey];
				$getTokenOrder = $this->getTokenOrder($asset, $player);
				if($getTokenOrder != -1 AND $getTokenOrder < count($this->keyRewards)){
					$tokenScore = $this->keyRewards[$getTokenOrder];
				}
				
				$tokens[$asset] = $tokenScore;
				$output['score']+= $tokenScore;
			}
		}
		$output['tokens'] = $tokens;
		
		return $output;
	}
	
	public function getBonusScore($player)
	{
		$output = array('score' => 0);
		$tokens = array();
		foreach($player['inventory'] as $asset => $amount){
			if(in_array($asset, $this->bonusTokens)){
				$tokenScore = $this->bonusRewards[$this->lateKey];
				$getTokenOrder = $this->getTokenOrder($asset, $player);
				if($getTokenOrder != -1 AND $getTokenOrder < count($this->bonusRewards)){
					$tokenScore = $this->bonusRewards[$getTokenOrder];
				}
				
				$tokens[$asset] = $tokenScore;
				$output['score']+= $tokenScore;
			}
		}
		$output['tokens'] = $tokens;
		
		return $output;
	}
	
	public function getTreasureScore($player)
	{
		$output = array();
		$score = 0;
		$tokens = array();
		foreach($player['inventory'] as $asset => $amount){
			if(in_array($asset, $this->treasureTokens)){
				$score += $amount * $this->treasureReward;
				$tokens[$asset] = $amount;
			}
		}
		
		$output['tokens'] = $tokens;
		$output['score'] = $score;
		return $output;
	}
	
	public function getPlayerScore($player)
	{
		$output = array();
		$output['keys'] = $this->getKeyScore($player);
		$output['bonuses'] = $this->getBonusScore($player);
		$output['treasures'] = $this->getTreasureScore($player);
		$output['total'] = $output['keys']['score'] + $output['bonuses']['score'] + $output['treasures']['score'];
		
		return $output;
	}
	
	public function getTokenOrder($asset, $player)
	{
		$output = -1;
		$list = array();
		foreach($this->players as $getPlayer){
			foreach($getPlayer['inventory'] as $invAsset => $invAmount){
				if($invAsset == $asset){
					$listItem = array('userId' => $getPlayer['userId'], 'time' => 0);
					foreach($getPlayer['game'] as $gameKey => $data){
						if($gameKey == strtolower($asset).'_sent'){
							$listItem['time'] = strtotime($data['time']);
						}
					}	
					$list[] = $listItem;				
				}
			}			

		}
		aasort($list, 'time');
		//$list = array_reverse($list);
		$num = 0;
		foreach($list as $row){
			if($row['userId'] == $player['userId']){
				$output = $num;
				break;
			}
			$num++;
		}
		return $output;
	}
	
}
