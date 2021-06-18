<?php namespace App\Currency;

use App\Currency\Option\WalletOption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Nbobtc\Command\Command;
use Nbobtc\Http\Client;
use App\Http\Controllers\Api\WalletController;

use App\User;

class Tether extends Currency {

    function id(): string {
        return "usdt";
    }

    function name(): string {
        return "USDT";
    }

    function nowpayments(): string {
        return 'usdttrc20';
    }

    public function alias(): string {
        return 'tether';
    }

    function icon(): string {
        return "usdt";
    }

    public function style(): string {
        return "#53ae94"; 
    }
    public function dailyminslots(): float {
        $dailyslotsbet = \App\Settings::where('name', 'dailybonus_minbet_slots')->first()->value;
        return floatval(number_format(($dailyslotsbet / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }

    public function dailyminbet(): float {
        $dailyminbet = \App\Settings::where('name', 'dailybonus_minbet')->first()->value;
        return floatval(number_format(($dailyminbet / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }
   public function convertBonus(): float {
        $user = auth()->user();
        $getbonus = $user->balance(\App\Currency\Currency::find('bonus'))->get();
        return floatval(number_format(($getbonus / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }
	
	public function convertUsd($value): float {
        return floatval(number_format(($value / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }
	
    public function emeraldvip(): float {
        $emeraldvip = \App\Settings::where('name', 'emeraldvip')->first()->value;
        return floatval(number_format(($emeraldvip / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }
    public function rubyvip(): float {
        $rubyvip = \App\Settings::where('name', 'rubyvip')->first()->value;
        return floatval(number_format(($rubyvip / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }
    public function goldvip(): float {
        $goldvip = \App\Settings::where('name', 'goldvip')->first()->value;
        return floatval(number_format(($goldvip / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }
    public function platinumvip(): float {
        $platinumvip = \App\Settings::where('name', 'platinumvip')->first()->value;
        return floatval(number_format(($platinumvip / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }
    public function diamondvip(): float {
        $diamondvip = \App\Settings::where('name', 'diamondvip')->first()->value;
        return floatval(number_format(($diamondvip / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 7, '.', ''));
    }


    public function isRunning(): bool {
        try {
            $this->coldWalletBalance();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setupWallet(): ?string {
        try {
            $depositAccount = $this->newWalletAddress('deposit');
            $withdrawAccount = $this->newWalletAddress('withdraw');

            if($depositAccount === 'Error' || $withdrawAccount === 'Error') return null;

            $this->option('transfer_address', $depositAccount);
            $this->option('withdraw_address', $withdrawAccount);

            $this->getClient()->sendCommand(new Command('backupwallet', storage_path('app/'.$this->id().'_wallet.dat')));
        } catch (\Exception $e) {
            return null;
        }

        return $this->id().'_wallet.dat';
    }

    public function send(string $from, string $to, float $sum) {
        $client = $this->getClient();

        $fee = floatval($this->option('fee'));
        $client->sendCommand(new Command('settxfee', [$fee]));

        $account = json_decode($client->sendCommand(new Command('getaccount', $from))->getBody()->getContents())->result;
        $client->sendCommand(new Command('sendfrom', [$account, $to, $sum - $fee]));
    }

    function newWalletAddress($accountName = null): string {
        try {
            $client = $this->getClient();
            $command = new Command('getnewaddress', $accountName == null ? auth()->user()->_id : $accountName);
            $response = $client->sendCommand($command);
            $contents = json_decode($response->getBody()->getContents());
            Log::info((array) $contents); 
            if($contents->error != null) throw new \Exception('Exception during getnewaddress');
            return $contents->result;
        } catch (\Exception $e) {
            Log::critical($e);
            return 'Error';
        }
    }

    public function process(string $wallet) {
        $client = $this->getClient();
        $command = new Command('gettransaction', $wallet);
        $response = $client->sendCommand($command);
        $contents = json_decode($response->getBody()->getContents(), true)['result'];
        Log::info('Getted transactions '. $wallet . ' ? '); 
        if(isset($contents['details'][0]['address'])) {
            $this->accept($contents['confirmations'], $contents['details'][0]['address'], $contents['txid'], abs($contents['details'][0]['amount']));
        } else if(isset($contents['details']['address'])) {
            $this->accept($contents['confirmations'], $contents['details']['address'], $contents['txid'], abs($contents['details']['amount']));
        } 
    }

    public function processBlock($blockId) {
        Log::info('Searching block ' . $blockId . '/' . $this->id());
        $client = $this->getClient();
        $response = json_decode($client->sendCommand(new Command('listtransactions'))->getBody()->getContents(), true)['result'];
        foreach($response as $tx) $this->process($tx['txid']);
    } 

    public function getClient(): Client {
        return new Client($this->option('rpc'));
    }

    public function coldWalletBalance(): float {
        $client = $this->getClient();
        $command = new Command('getbalance', 'deposit');
        $response = $client->sendCommand($command);
        $contents = json_decode($response->getBody()->getContents(), true)['result'];
        return $contents;
    }

    public function hotWalletBalance(): float {
        $client = $this->getClient();
        $command = new Command('getbalance', 'withdraw');
        $response = $client->sendCommand($command);
        $contents = json_decode($response->getBody()->getContents(), true)['result'];
        return $contents;
    }

    protected function options(): array {
        return [
        ];
    }

}
