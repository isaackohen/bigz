<?php namespace App\Games\Kernel\Quick;

use App\Currency\Currency;
use App\Events\BalanceModification;
use App\Games\Kernel\Data;
use App\Games\Kernel\Game;
use App\Games\Kernel\Module\ModuleSeeder;
use App\Games\Kernel\ProvablyFair;
use App\Games\Kernel\ProvablyFairResult;
use App\Transaction;
use App\Leaderboard;
use App\Races;
use App\Http\Controllers\Api\WalletController;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Settings;

abstract class QuickGame extends Game {

    private string $server_seed;

    abstract function start($user, Data $data);

    abstract function isLoss(ProvablyFairResult $result, Data $data): bool;

    public function process(Data $data) {
        $this->server_seed = (new ModuleSeeder($this, $data->demo(), $data, null))->find(function(ProvablyFairResult $result) use($data) {
            return $this->isLoss($result, $data);
        });

        $result = $this->start($data->guest() ? null : $data->user(), $data);
        $result_data = $result->toArray($data);
        if(!isset($result_data['error']) && !$data->guest()) {
            $data->user()->balance(Currency::find($data->currency()))->demo($data->demo())->quiet()->subtract($data->bet(), Transaction::builder()->game($this->metadata()->id())->message('Game')->get());

            if ($result->profit() == 0) event(new BalanceModification($data->user(), Currency::find($data->currency()), 'subtract', $data->demo(), $data->bet(), $result->delay));
            else {
                if ($result->multiplier() < 1) event(new BalanceModification($data->user(), Currency::find($data->currency()), 'subtract', $data->demo(), $result->profit(), $result->delay));
                else event(new BalanceModification($data->user(), Currency::find($data->currency()), 'add', $data->demo(), $result->profit() - $data->bet(), $result->delay));
            }

        } else return $result_data;
        $currency = $data->currency();
        if(!$data->demo()) {

			if(\App\Statistics::where('_id', $data->user()->_id)->first() == null) {
				$a = \App\Statistics::create([
					'_id' => $data->user()->_id, 'bets_btc' => 0, 'wins_btc' => 0, 'loss_btc' => 0, 'wagered_btc' => 0, 'profit_btc' => 0, 'bets_eth' => 0, 'wins_eth' => 0, 'loss_eth' => 0, 'wagered_eth' => 0, 'profit_eth' => 0, 'bets_ltc' => 0, 'wins_ltc' => 0, 'loss_ltc' => 0, 'wagered_ltc' => 0, 'profit_ltc' => 0, 'bets_doge' => 0, 'wins_doge' => 0, 'loss_doge' => 0, 'wagered_doge' => 0, 'profit_doge' => 0, 'bets_bch' => 0, 'wins_bch' => 0, 'loss_bch' => 0, 'wagered_bch' => 0, 'profit_bch' => 0, 'bets_trx' => 0, 'wins_trx' => 0, 'loss_trx' => 0, 'wagered_trx' => 0, 'profit_trx' => 0, 'bets_bonus' => 0, 'wins_bonus' => 0, 'loss_bonus' => 0, 'wagered_bonus' => 0, 'profit_bonus' => 0
				]);
			}

			$stats = \App\Statistics::where('_id', $data->user()->_id)->first();

			if($currency == 'btc'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarBtc(), 2, '.', ''));
			$stats->update([
                'bets_btc' => $stats->bets_btc + 1,
				'wins_btc' => $stats->wins_btc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
				'loss_btc' => $stats->loss_btc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
				'wagered_btc' => $stats->wagered_btc + $data->bet(),
				'profit_btc' => $stats->profit_btc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
			}
            if($currency == 'bonus'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarBonus(), 2, '.', ''));
            $stats->update([
                'bets_bonus' => $stats->bets_bonus + 1,
                'wins_bonus' => $stats->wins_bonus + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
                'loss_bonus' => $stats->loss_bonus + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
                'wagered_bonus' => $stats->wagered_bonus + $data->bet(),
                'profit_bonus' => $stats->profit_bonus + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
            }
			if($currency == 'eth'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarEth(), 2, '.', ''));
			$stats->update([
                'bets_eth' => $stats->bets_eth + 1,
				'wins_eth' => $stats->wins_eth + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
				'loss_eth' => $stats->loss_eth + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
				'wagered_eth' => $stats->wagered_eth + $data->bet(),
				'profit_eth' => $stats->profit_eth + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
			}
            if($currency == 'usdt'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarUsdt(), 2, '.', ''));
            $stats->update([
                'bets_usdt' => $stats->bets_usdt + 1,
                'wins_usdt' => $stats->wins_usdt + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
                'loss_usdt' => $stats->loss_usdt + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
                'wagered_usdt' => $stats->wagered_usdt + $data->bet(),
                'profit_usdt' => $stats->profit_usdt + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
            }
            if($currency == 'usdc'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarUsdc(), 2, '.', ''));
            $stats->update([
                'bets_usdc' => $stats->bets_usdc + 1,
                'wins_usdc' => $stats->wins_usdc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
                'loss_usdc' => $stats->loss_usdc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
                'wagered_usdc' => $stats->wagered_usdc + $data->bet(),
                'profit_usdc' => $stats->profit_usdc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
            }
            if($currency == 'xrp'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarXrp(), 2, '.', ''));
            $stats->update([
                'bets_xrp' => $stats->bets_xrp + 1,
                'wins_xrp' => $stats->wins_xrp + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
                'loss_xrp' => $stats->loss_xrp + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
                'wagered_xrp' => $stats->wagered_xrp + $data->bet(),
                'profit_xrp' => $stats->profit_xrp + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
            }
            if($currency == 'bnb'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarBnb(), 2, '.', ''));
            $stats->update([
                'bets_bnb' => $stats->bets_bnb + 1,
                'wins_bnb' => $stats->wins_bnb + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
                'loss_bnb' => $stats->loss_bnb + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
                'wagered_bnb' => $stats->wagered_bnb + $data->bet(),
                'profit_bnb' => $stats->profit_bnb + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
            }
			if($currency == 'ltc'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarLtc(), 2, '.', ''));
			$stats->update([
                'bets_ltc' => $stats->bets_ltc + 1,
				'wins_ltc' => $stats->wins_ltc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
				'loss_ltc' => $stats->loss_ltc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
				'wagered_ltc' => $stats->wagered_ltc + $data->bet(),
				'profit_ltc' => $stats->profit_ltc + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
			}
			if($currency == 'doge'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarDoge(), 2, '.', ''));
			$stats->update([
                'bets_doge' => $stats->bets_doge + 1,
				'wins_doge' => $stats->wins_doge + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
				'loss_doge' => $stats->loss_doge + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
				'wagered_doge' => $stats->wagered_doge + $data->bet(),
				'profit_doge' => $stats->profit_doge + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
			}
			if($currency == 'bch'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarBtcCash(), 2, '.', ''));
			$stats->update([
                'bets_bch' => $stats->bets_bch + 1,
				'wins_bch' => $stats->wins_bch + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
				'loss_bch' => $stats->loss_bch + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
				'wagered_bch' => $stats->wagered_bch + $data->bet(),
				'profit_bch' => $stats->profit_bch + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
			}
			if($currency == 'trx'){
            $usd_wager = floatval(number_format($data->bet() * WalletController::rateDollarTron(), 2, '.', ''));
			$stats->update([
                'bets_trx' => $stats->bets_trx + 1,
				'wins_trx' => $stats->wins_trx + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 0 : 1) : 0),
				'loss_trx' => $stats->loss_trx + ($result->profit() > 0 ? ($result->multiplier() < 1 ? 1 : 0) : 1),
				'wagered_trx' => $stats->wagered_trx + $data->bet(),
				'profit_trx' => $stats->profit_trx + ($result->profit() > 0 ? ($result->multiplier() < 1 ? -($data->bet()) : ($result->profit())) : -($data->bet()))
            ]);
			}


        $multiplierfloat = floatval(number_format($result->multiplier(), 2, '.', ''));
            $game = \App\Game::create([
                'id' => DB::table('games')->count() + 1,
                'user' => $data->user()->_id,
                'game' => $this->metadata()->id(),
                'wager' => $data->bet(),
                'multiplier' => $multiplierfloat,
                'status' => $result->profit() > 0 ? ($result->multiplier() < 1 ? 'lose' : 'win') : 'lose',
                'profit' => $result->profit(), 
                'server_seed' => $result->seed(),
                'client_seed' => $this->client_seed(),
                'nonce' => $result->nonce(),
                'data' => $result->database_data(),
                'type' => 'quick',
                'currency' => $currency
            ]);


                    if ($multiplierfloat > 20 && $usd_wager > 0.2) {
                        Settings::where('name', 'bigwinner_inhouse_player')->update(['value' => $data->user()->name]);
                        Settings::where('name', 'bigwinner_inhouse_game')->update(['value' => $this->metadata()->id()]);
                        Settings::where('name', 'bigwinner_inhouse_amount')->update(['value' => $usd_wager]);
                        Settings::where('name', 'bigwinner_inhouse_multi')->update(['value' => $multiplierfloat]);

						Settings::where('name', 'tg_bigwinner_inhouse_cron')->update(['value' => 1]);
					} 
					
					$settingGameProfit = 'bigprofit_inhouse_game_'.$this->metadata()->id();
					$bigProfit = [$result->profit(), $data->user()->name, $currency, $game->_id];
					$settingGameMul = 'bigmul_inhouse_game_'.$this->metadata()->id();
					$bigMul = [$multiplierfloat, $data->user()->name, $game->_id];
					
					if(Settings::where('name', $settingGameProfit)->first() === null){
						Settings::create(['name' => $settingGameProfit, 'value' => json_encode($bigProfit)]);
					} 
					$settingGameInfo = json_decode(Settings::where('name', $settingGameProfit)->first()->value);
					if($result->profit() > $settingGameInfo[0]) {
						Settings::where('name', $settingGameProfit)->update(['value' => json_encode($bigProfit)]);
					}
					
					if(Settings::where('name', $settingGameMul)->first() === null){
						Settings::create(['name' => $settingGameMul, 'value' => json_encode($bigMul)]);
					} 
					$settingGameInfo = json_decode(Settings::where('name', $settingGameMul)->first()->value);
					if($multiplierfloat > $settingGameInfo[0]) {
						Settings::where('name', $settingGameMul)->update(['value' => json_encode($bigMul)]);
					}

                    if($data->user()->bonus1 == '2' && $currency == 'bonus') {
                        if($multiplierfloat < 0.95 || $multiplierfloat > 1.3 && $usd_wager > 0.1) {

                        $data->user()->update([
                        'bonus1_wager' => ($data->user()->bonus1_wager ?? 0) + (float) ($usd_wager / 2)
                        ]);
                       }
                    }    

                    if($data->user()->bonus2 == '2' && $currency == 'bonus') {
                        if($multiplierfloat < 0.95 || $multiplierfloat > 1.3 && $usd_wager > 0.1) {

                        $data->user()->update([
                        'bonus2_wager' => ($data->user()->bonus2_wager ?? 0) + (float) ($usd_wager / 5)
                        ]);
                       }
                    } 


            if($multiplierfloat < 0.95 || $multiplierfloat > 1.25 && $usd_wager > 0.1) {
            Leaderboard::insert($game);




            if (!$data->demo() && $data->user()->vipLevel() > 0 && ($data->user()->weekly_bonus ?? 0) < 100 && (Currency::find($data->currency())->dailyminbet() ?? 1) <= $data->bet()) {
                $data->user()->update([
                    'weekly_bonus' => ($data->user()->weekly_bonus ?? 0) + 0.1
                ]);
            }

            }




            event(new \App\Events\LiveFeedGame($game, $result->delay));
			
        }
        return $result_data;
    }

    public function server_seed() {
        return $this->server_seed;
    }

}
