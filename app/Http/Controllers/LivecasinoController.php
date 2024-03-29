<?php

namespace App\Http\Controllers;

use App\Currency\Currency;
use App\User;
use App\Leaderboard;
use App\Http\Controllers\Api\WalletController;
use App\Races;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Games\Kernel\Game;
use App\LivecasinoTransaction;

class LivecasinoController extends Controller

{
    public function balance(Request $request)
     {
            $token = $request['username'];
            $currency = explode('-', $token);
            $currency = $currency[1];
            $playerId = explode('-', $token);
            $playerId = $playerId[0];
            $user = \App\User::where('_id', $playerId)->first();
            $balance = $user->balance(Currency::find($currency))->get();

        if ($currency == 'BTC' || $currency == 'btc') {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarBtc()), 2, '.', ''));
        } elseif ($currency == 'doge' || $currency == "DOGE") {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarDoge()), 2, '.', ''));
        } elseif ($currency == 'xrp' || $currency == "XRP") {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarXrp()), 2, '.', ''));
        } elseif ($currency == 'usdt' || $currency == "USDT") {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 2, '.', ''));
        } elseif ($currency == 'usdc' || $currency == "USDC") {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarUsdc()), 2, '.', ''));
        } elseif ($currency == 'bnb' || $currency == "BNB") {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarBnb()), 2, '.', ''));
        } elseif ($currency == 'trx' || $currency == 'TRX') {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarTron()), 2, '.', ''));
        } elseif ($currency == 'ltc' || $currency == 'LTC') {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarLtc()), 2, '.', ''));
        } elseif ($currency == 'bonus' || $currency == 'BONUS') {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarBonus()), 2, '.', ''));
        } elseif ($currency == 'bch' || $currency == 'BCH') {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash()), 2, '.', ''));
        } elseif ($currency == 'eth' || $currency == 'ETH') {
                $balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarEth()), 2, '.', ''));
        }
        
        return response()->json([
                'balance' => $balanceA
        ])->setStatusCode(200);
        }
    

    
    public function bet(Request $request)
    {
		$token = $request['username'];
		$currency = explode('-', $token);
		$currency = $currency[1];
		$playerId = explode('-', $token);
		$playerId = $playerId[0];
		$gamedata = $request['gameId'];
		$transactionId = $request['transactionId'];
		$roundId = $request['roundId'];

		$amount = $request['amount'];
		$user = \App\User::where('_id', $playerId)->first();

		if($gamedata == '100178') {
			$gamedata = 'Rapid Roulette LIVE';
		} elseif($gamedata == '100179') {
			$gamedata = 'Blackjack LIVE';
		} elseif($gamedata == '100180') {
			$gamedata = 'Blackjack LIVE';
		} elseif($gamedata == '100180') {
			$gamedata = 'Blackjack LIVE';
		} elseif($gamedata == '100176') {
			$gamedata = 'Baccarat LIVE';
		} elseif($gamedata == '100169') {
			$gamedata == 'VIP Roulette LIVE';
		} elseif($gamedata == '100166') {
			$gamedata = 'Auto-Roulette LIVE';
		} else {
			$gamedata == 'Live Casino Game';
		}

       if ($currency == 'btc') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarBtc()), 8, '.', ''));
        } elseif ($currency == 'doge' || $currency == "DOGE") {
            $cryptoamount = number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarDoge()), 8, '.', '');
        } elseif ($currency == 'trx' || $currency == 'TRX') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarTron()), 8, '.', ''));
        } elseif ($currency == 'bnb' || $currency == 'BNB') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarBnb()), 8, '.', ''));
        } elseif ($currency == 'usdt' || $currency == 'USDT') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 8, '.', ''));
        } elseif ($currency == 'usdc' || $currency == 'USDC') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarUsdc()), 8, '.', ''));
        } elseif ($currency == 'xrp' || $currency == 'XRP') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarXrp()), 8, '.', ''));
        } elseif ($currency == 'ltc' || $currency == 'LTC') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarLtc()), 8, '.', ''));
        } elseif ($currency == 'bonus' || $currency == 'BONUS') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarBonus()), 8, '.', ''));
        } elseif ($currency == 'bch' || $currency == 'BCH') {            
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarBtcCash()), 8, '.', ''));
        } elseif ($currency == 'eth' || $currency == 'ETH') {
            $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 8, '.', ''));
        }
      
		if($user->balance(Currency::find($currency))->get() > floatval($cryptoamount)) {
			$user->balance(Currency::find($currency))->subtract($cryptoamount);
			$balance = $user->balance(Currency::find($currency))->get();

			if ($currency == 'BTC' || $currency == 'btc') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarBtc()), 2, '.', ''));
			} elseif ($currency == 'doge' || $currency == "DOGE") {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarDoge()), 2, '.', ''));
			} elseif ($currency == 'trx' || $currency == 'TRX') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarTron()), 2, '.', ''));
			} elseif ($currency == 'bnb' || $currency == 'BNB') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarBnb()), 2, '.', ''));
			} elseif ($currency == 'usdt' || $currency == 'USDT') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 2, '.', ''));
			} elseif ($currency == 'usdc' || $currency == 'USDC') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarUsdc()), 2, '.', ''));
			} elseif ($currency == 'bonus' || $currency == 'BONUS') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarBonus()), 2, '.', ''));
			} elseif ($currency == 'xrp' || $currency == 'XRP') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarXrp()), 2, '.', ''));
			} elseif ($currency == 'ltc' || $currency == 'LTC') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarLtc()), 2, '.', ''));
			} elseif ($currency == 'bch' || $currency == 'BCH') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash()), 2, '.', ''));
			} elseif ($currency == 'eth' || $currency == 'ETH') {
					$balanceA = floatval(number_format(($balance * \App\Http\Controllers\Api\WalletController::rateDollarEth()), 2, '.', ''));
			}


			$game = \App\Game::create([
				'id' => DB::table('games')->count() + 1,
				'user' => $user->id,
				'game' => 'livecasino',
				'wager' => (float) $cryptoamount,
				'status' => 'in-progress',
				'server_seed' => $roundId,
				'client_seed' => $amount,
				'nonce' => $gamedata,
				'data' => json_encode($request->getContent()),
				'type' => 'quick',
				'currency' => strtolower($currency)
			]);
			
			LivecasinoTransaction::create([
				'user' => $user->id, 
				'balance' => $balanceA, 
				'bet' => $amount, 
				'result' => null, 
				'status' => 'in-progress', 
				'gameId' => $roundId
			]);
		
			usleep(20);

            return response()->json([
                'balance' => $balanceA
           ])->setStatusCode(200);

		} else {
            return response()->json([
                'status' => 'error',
                'error' => ([
                    'scope' => "user",
                    'no_refund' => "1",
                    'message' => "Not enough money"
                ])
            ])->setStatusCode(403);
        }
    }

    public function win(Request $request)
    {
		$transactionId = $request['sourceTransactionId'];
		$token = $request['username'];
		$currency = explode('-', $token);
		$currency = $currency[1];
		$playerId = explode('-', $token);
		$playerId = $playerId[0];
		$gamedata = $request['gameId'];
		$amount = $request['amount'];
		$user = \App\User::where('_id', $playerId)->first();
		$userid = $user->_id;
		$roundId = $request['roundId'];
			
		$game = \App\Game::where('user', $userid)->where('server_seed', $roundId)->where('status', 'in-progress')->first();
		$transaction = \App\LivecasinoTransaction::where('user', $user->id)->where('gameId', $roundId)->first();
		
		if($game != null && $transaction != null && $transaction->status != 'blocked') {

			if ($currency == 'btc') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarBtc()), 8, '.', ''));
			} elseif ($currency == 'doge' || $currency == "DOGE") {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarDoge()), 8, '.', ''));
			} elseif ($currency == 'trx' || $currency == 'TRX') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarTron()), 8, '.', ''));
			} elseif ($currency == 'ltc' || $currency == 'LTC') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarLtc()), 8, '.', ''));
			} elseif ($currency == 'bnb' || $currency == 'BNB') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarBnb()), 8, '.', ''));
			} elseif ($currency == 'usdt' || $currency == 'USDT') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 8, '.', ''));
			} elseif ($currency == 'usdc' || $currency == 'USDC') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarUsdc()), 8, '.', ''));
			} elseif ($currency == 'bonus' || $currency == 'BONUS') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarBonus()), 8, '.', ''));
			} elseif ($currency == 'xrp' || $currency == 'XRP') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarXrp()), 8, '.', ''));
			} elseif ($currency == 'bch' || $currency == 'BCH') {            
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarBtcCash()), 8, '.', ''));
			} elseif ($currency == 'eth' || $currency == 'ETH') {
				$cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 8, '.', ''));
			}
			
			$getwagerdollar = $transaction->bet;
			$getwager = $game->wager;

			if($amount != 0) {
				$status = 'win';
				$multi = (float) number_format(($cryptoamount / $getwager), 2);
			} 
			else {
				$status = 'lose'; 
				$multi = 0;
			}
			
			$game->update([
				'status' => $status,
				'multiplier' => $multi,
				'profit' => (float) number_format(($cryptoamount), 8)
			]);
			
			$balanceorder = $transaction->balance;
			
			$transaction->update([
				'status' => 'blocked',
				'result' => $status,
				'newbalance' => $balanceorder + $amount
			]);

			event(new \App\Events\LiveFeedGame($game, 10));
			
			Leaderboard::insert($game);
				

			$user->balance(Currency::find($currency))->add($cryptoamount);

			if($multi < 0.95 || $multi > 1.25 && $getwagerdollar > 0.05) {
				Races::insert($game);

			
				if($user->bonus1 == '2' && $currency == 'bonus') {
					if($multi < 0.95 || $multi > 1.20) {
						if($getwagerdollar > floatval(0.1)) {
						   $user->update([
							'bonus1_wager' => ($user->bonus1_wager ?? 0) + (float) $getwagerdollar
							]);
						}
					}
				}

				if($user->bonus2 == '2' && $currency == 'bonus') {
					if($multi < 0.95 || $multi > 1.20) {
						if($getwagerdollar > floatval(0.1)) {
						   $user->update([
							'bonus2_wager' => ($user->bonus2_wager ?? 0) + (float) $getwagerdollar
							]);
						}
					}
				}

				if ((Currency::find($currency)->dailyminslots() ?? 0) <= $getwagerdollar) {
					if ($user->vipLevel() > 0 && ($user->weekly_bonus ?? 0) < 100) {
						$user->update([
							'weekly_bonus' => ($user->weekly_bonus ?? 0) + 0.1
						]);
					}
				}
			}
			
			$balance = $transaction->newbalance;
			
			return response()->json([
				'balance' => $balance
			])->setStatusCode(200);
			
		} else {
			
			$balance = $transaction->newbalance;
			
			return response()->json([
				'balance' => $balance
			])->setStatusCode(200);
		}
    }

    public function seamless(Request $request)
    {
        Log::notice('Live casino: '.$request);

        if ($request['action'] === 'balance') {
            return $this->balance($request);
        }
        if ($request['action'] === 'debit') {
            return $this->bet($request);
        }
        if ($request['action'] === 'credit') {
            return $this->win($request);
        }
 
    }

    
    public function game($slug)
    {
        

        if (strlen($slug) > 50)
            {
            return redirect('/');
            }
    
            $slugsanitize = preg_replace("/[\/\{\}\)\(\%#\$]/", "sanitize", $slug);


            $id = auth()->user()->_id;
            $idreplace = preg_replace("/[^0-9]/", "", $id );
            $name = auth()->user()->name;
            $user = auth()->user()->_id.'-'.auth()->user()->clientCurrency()->id();
            $userdata = array('userId' => $idreplace, 'username' => $user, 'nick' => $name, 'currency' => "USD");
            $jsonbody = json_encode($userdata);
            $curlcatalog = curl_init();
            curl_setopt_array($curlcatalog, array(
            CURLOPT_URL => 'https://gateway.ssl256bit.com/catalog_service/set_user_data',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $jsonbody,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
            "X-CASINO-TOKEN: =MmYjNWM4IzYzkTY0cTMjJGMlFDNwMzNjJGMjVDZkFTZ6ETN4IDM3ATN",
            "Content-Type: application/json"
          ),
        ));
        $responsecurl = curl_exec($curlcatalog);
        curl_close($curlcatalog);
        Log::notice($responsecurl);
        $responsecurl = json_decode($responsecurl);
        
        if ($slug == 'baccarat'){
            $gameid = 'g01.ssl256bit.com/_Games/Baccarat/?gameId=OS_Baccarat';
        }
        elseif ($slug == 'blackjack') {
            $gameid = 'g01.ssl256bit.com/_Games/blackjack_live/#/?gameId=OS_Blackjack';
        }
        elseif ($slug == 'blackjack2') {
            $gameid = 'g01.ssl256bit.com/_Games/blackjack_live/clients/Blackjack2/#/?gameId=OS_Blackjack_2';
        }
        elseif ($slug == 'viproulette') {
            $gameid = 'g01.ssl256bit.com/_Games/roulette/clients/OriginalSpirit/?gameId=OS_Roulette_2';
        }
        elseif ($slug == 'autowheel') {
            $gameid = 'g01.ssl256bit.com/_Games/roulette/clients/OriginalSpirit/?gameId=OS_Roulette_3';
        }
        elseif ($slug == 'rapidroulette') {
            $gameid = 'g01.ssl256bit.com/_Games/roulette/clients/OriginalSpirit/?gameId=OS_Roulette_4';
        }
        else {
            return redirect('/live/');
        }
        
        $url = 'https://'.$gameid.'&clientId=&mode=Real&gameToken='.$responsecurl->sessionToken.'&casinoId=50702851&lobbyUrl=https%3A%2F%2Fg01.ssl256bit.com%2F_Apps%2Flobby%2F%3FcatalogId%3D100092_3685299&sessionToken='.$responsecurl->sessionToken.'&url=https%3A%2F%2Floff.io';

        $view = view('liveplayer')->with('url', $url);
        return view('layouts.app')->with('page', $view);
    }
    
}
