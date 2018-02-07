<?php
ini_set('display_errors', 0);
$_SERVER['HTTP_HOST'] = 'letstalkbitcoin.com';
$noForceSSL = true;
require_once('../conf/config.php');
include(FRAMEWORK_PATH.'/autoload.php');

$model = new \Core\Model;
$btc = new \API\Bitcoin(BTC_CONNECT);


$destination = '14EsDFwZFpF9ZQoEjtTfGu9cJvYDBmGSiW';

$accounts = $btc->listaccounts();

$addresses = array();
foreach($accounts as $account => $received){
    $address_list = $btc->getaddressesbyaccount($account);
    if(!$address_list){
        continue;
    }
    foreach($address_list as $address){
        $addresses[] = $address;
    }
}


//print_r($addresses);

echo 'Total # addresses: '.count($addresses).PHP_EOL;

$address_utxos = array();

foreach($addresses as $address){
    $raw_txs = $btc->searchrawtransactions($address);
    if(!$raw_txs){
        //echo 'Could not retrieve txs for '.$address.PHP_EOL;
        continue;
    }
    
    $unspent = array();
    foreach($raw_txs as $tx){
        //find multisig outputs related to this address
        foreach($tx['vout'] as $vout){
            if(isset($vout['scriptPubKey']) AND $vout['scriptPubKey']['type'] == 'multisig'){
                foreach($vout['scriptPubKey']['addresses'] as $v_address){
                    if($v_address == $address){
                        $unspent[] = array('txid' => $tx['txid'], 'n' => $vout['n'], 'amount' => $vout['value']);
                        continue 3;
                    }
                }
            }
        }
    }
    
    if(count($unspent) == 0){
        //echo 'No multisig outputs found for '.$address.PHP_EOL;
        continue;
    }
    
    $address_utxos[$address] = $unspent;
    
}

$prep_txs = array();
foreach($address_utxos as $address => $utxos){
    
    $prep_tx = array();
    $prep_tx['address'] = $address;
    $prep_tx['total'] = 0;
    $prep_tx['estimate_size'] = 34 + (141 * count($utxos));
    $prep_tx['estimate_fee'] = $prep_tx['estimate_size'] * 25;
    foreach($utxos as $utxo){
        $prep_tx['total'] += $utxo['amount'];
    }
    
    $prep_tx['utxos'] = $utxos;
    
    $prep_txs[$address] = $prep_tx;
}

$total = 0;
$total_fee = 0;
$full_utxo_list = array();
foreach($prep_txs as $address => $prep_tx){
    $total += $prep_tx['total'];
    $total_fee += $prep_tx['estimate_fee']; 
    foreach($prep_tx['utxos'] as $utxo){
        $full_utxo_list[] = $utxo;
    }
}

echo "Num utxos: ".count($full_utxo_list).PHP_EOL;
echo 'Total sweepable: '.$total.' BTC'.PHP_EOL;
echo 'Estimated total fee: '.round($total_fee / SATOSHI_MOD, 8).' BTC'.PHP_EOL;

//print_r($prep_txs);

//send out some raw transactions
$utxo_count = count($full_utxo_list);
$send_txs = array();
$max_inputs = 150;
$num_txs = ceil($utxo_count / $max_inputs);
$utxo_per_tx = ceil($utxo_count / $num_txs);
$total_plucked = 0;

for($i = 0; $i < $num_txs; $i++){
    //gather utxos from list
    $plucked = 0;
    $send_utxos = array();
    foreach($full_utxo_list as $k => $utxo){
        $send_utxos[] = $utxo;
        unset($full_utxo_list[$k]);
        $plucked++;
        $total_plucked++;
        if($plucked > $utxo_per_tx OR $total_plucked > $utxo_count){
            break;
        }
    }
    
    //setup raw inputs
    $total_input = 0;
    $raw_inputs = array();
    foreach($send_utxos as $utxo){
        $total_input += $utxo['amount'];
        $raw_inputs[] = array('txid' => $utxo['txid'], 'vout' => $utxo['n']);
    }
    
    //figure out fee
    $raw_fee = ((141*count($raw_inputs)) + 34) * 25;
    $raw_fee = round($raw_fee / 100000000, 8);
    
    $total_input -= $raw_fee;
    
    if($total_input < 0.00005430){
        echo 'TX '.$i.' below dust limit'.PHP_EOL;
        continue;
    }
    
    //setup raw outputs
    $raw_outputs = array($destination => $total_input);
    
    $create = $btc->sendcustomrawtransaction($raw_inputs, $raw_outputs);
    
    echo 'Sent '.$total_input.' BTC: '.$create['txid'].PHP_EOL;
    
    
    
}


