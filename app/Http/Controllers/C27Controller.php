<?php

namespace App\Http\Controllers;

use App\Currency\Currency;
use App\User;
use App\Leaderboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\WalletController;
use App\Races;
use App\Slotslist;
use App\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use outcomebet\casino25\api\client\Client;

class C27Controller extends Controller
{
    /** @var Client */
    protected $client;

    /**
     * C27Controller constructor.
     * @throws \outcomebet\casino25\api\client\Exception
     */
    public function __construct()
    {
        $this->client = new Client(array(
            'url' => 'https://api.c27.games/v1/',
            'sslKeyPath' => env('c27_path'),
        ));
        $this->client->mascot = new Client(array(
            'url' => 'https://api.mascot.games/v1/',
            'sslKeyPath' => env('mascot_path'),
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function seamless(Request $request)
    {
        $content = json_decode($request->getContent());

        //die;
        if ($content->method === 'getBalance') {
            return $this->getBalance($request);
        } elseif ($content->method === 'withdrawAndDeposit') {
            return $this->withdrawAndDeposit($request);
        } elseif ($content->method === 'rollbackTransaction') {
            return response()->json([
                'result' => (json_decode ("{}")),
                'id' => $content->id,
                'jsonrpc' => '2.0'
            ]);
        } else {
            return response()->json([
                'result' => (json_decode ("{}")),
                'id' => $content->id,
                'jsonrpc' => '2.0'
            ]);
        }
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function provider($slug)
    {
        $user = auth()->user();

        if (strlen($slug) > 50){
            return redirect('/');
        }
            $sanitize = preg_replace("/[\/\{\}\)\(\%#\$]/", "sanitize", $slug);
            $url = $sanitize;
            $view = view('provider')->with('url', $url);
        return view('layouts.app')->with('page', $view);
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function game($slug)
    {
        $slug = (\App\Slotslist::get()->where('UID', $slug)->first());
        $slugrecents = ($slug->UID);
        $slug = ($slug->id);
        $mainid = env('mainid');
        $mainbonusid = env('mainbonusid');     
        $mainbankgroup = env('mainbankgroup');
        $mainbonusgroup = env('mainbonusgroup');
        $staticserver = env('staticserver');
        $mascotid = env('mascotid');
        $mascotbonusid = env('mascotbonusid');
        $mascotbankgroup = env('mascotbankgroup');
        $mascotbonusbankgroup = env('mascotbonusbankgroup');
        $user = auth()->user();
        $freespinslot = \App\Settings::where('name', 'freespin_slot')->first()->value;

                if (strlen($slug) > 50){
                    return redirect('/');
                }
                $slugrecentssanitize = preg_replace("/[\/\{\}\)\(\%#\$]/", "sanitize", $slugrecents);

                $slugsanitize = preg_replace("/[\/\{\}\)\(\%#\$]/", "sanitize", $slug);

                /* Deny Guests */
                if (!$user) {
                    return redirect('/');
                }


                /* Record Slotpage Visit */
                if(\App\RecentSlots::where('player', $user->id)->where('s', $slugrecentssanitize)->first() == null) {
                    \App\RecentSlots::create([
                    'player' => $user->id, 's' => $slugrecentssanitize, 'b' => "0"
                    ]);
                }

                /* Get the provider from $slug */
                $provider = \App\Slotslist::where('_id', $slugsanitize)->first()->p;

                /* Forward Evoplay games to Evoplay Controller */
                if($provider == 'evoplay') {
                    return redirect()->route('evoplay', [$slug]);
                }   


            if($provider == 'mascot') {
                /* Deny moderator/streamer role */
                if(auth()->user()->access == 'moderator') {
                        return redirect('/');
                }

                /* Request Mascot Free Spins Session */
        if($slugsanitize == $freespinslot && $user->freegames > 0) {
                $this->client->mascot->setPlayer(['Id' => $user->id . '-' . 'eth' . '-' . $mascotbonusid , 'BankGroupId' => $mascotbonusbankgroup]);
                usleep(11000);
                $this->client->mascot->setBonus([   
                    'Id' => 'shared',   
                    'FsType' => 'original', 
                    'CounterType' => 'shared',  
                    'SharedParams' => [ 
                        'Games' => [    
                            $slugsanitize => [  
                                'FsCount' => auth()->user()->freegames, 
                            ]   
                        ]   
                    ]   
                ]);
                $game = $this->client->mascot->createSession(   
                        [   
                            'GameId' => $slugsanitize,  
                            'BonusId' => 'shared',  
                            'PlayerId' => $user->id . '-' . 'eth' . '-' . $mascotbonusid,  
                            'AlternativeId' => time() . '_' . $user->id . '_' . 'eth', 
                            'Params' => [   
                                'freeround_bet' => 1    
                            ],  
                            'RestorePolicy' => 'Create'
                        ]   
                    );  
        }
        else {

                /* Request Regular Mascot Session */
                $this->client->mascot->setPlayer(['Id' => $user->id . '-' . auth()->user()->clientCurrency()->id() . '-' . $mascotid , 'BankGroupId' => $mascotbankgroup]);
                    usleep(11000);
                    $game = $this->client->mascot->createSession(
                       [
                    'GameId' => $slugsanitize,
                    'PlayerId' => $user->id . '-' . auth()->user()->clientCurrency()->id() . '-' . $mascotid,
                    'AlternativeId' => time() . '_' . $user->id . '_' . auth()->user()->clientCurrency()->id(),
                    'RestorePolicy' => 'Restore'
                       ]
                    );
             }         

                /* Deny moderator/streamer role */              

                $url = $game['SessionUrl'] . '/?' . $slugsanitize;
                $view = view('c27')->with('data', $game)->with('url', $url);
                return view('layouts.app')->with('page', $view);

        } else {
       
                /* Request Free Spins Session for the other providers */ 
       if($slugsanitize == $freespinslot && $user->freegames > 0) {
       if(auth()->user()->access == 'moderator') {
                $this->client->setPlayer(['Id' => $user->id . '-' . 'eth' . '-' . $mainbonusid , 'BankGroupId' => $mainbonusgroup]);
                        usleep(11000);
                $this->client->setBonus([   
                    'Id' => 'shared',   
                    'FsType' => 'original',  
                    'CounterType' => 'shared',  
                    'SharedParams' => [ 
                        'Games' => [    
                            $slug => [  
                                'FsCount' => auth()->user()->freegames, 
                            ]   
                        ]   
                    ]   
                ]);      
                
                $game = $this->client->createSession(   
                [   
                    'GameId' => $slugsanitize,  
                    'BonusId' => 'shared',
                    'StaticHost' => $staticserver,
                    'PlayerId' => $user->id . '-' . 'eth' . '-' . $mainbonusid,  
                    'AlternativeId' => time() . '_' . $user->id . '_' . 'eth', 
                    'Params' => [   
                        'freeround_bet' => 1    
                ],  
                    'RestorePolicy' => 'Create'
                ]   
             );  
             }

        else {

            $this->client->setPlayer(['Id' => $user->id . '-' . 'eth' . '-' . $mainid , 'BankGroupId' => $mainbankgroup]);
                    usleep(11000);
            $this->client->setBonus([   
                    'Id' => 'shared',   
                    'FsType' => 'original', 
                    'StaticHost' => $staticserver,
                    'CounterType' => 'shared',  
                    'SharedParams' => [ 
                        'Games' => [    
                            $slugsanitize => [  
                                'FsCount' => auth()->user()->freegames, 
                            ]   
                        ]   
                    ]   
                ]);      
         $game = $this->client->createSession(   
                [   
                    'GameId' => $slugsanitize,  
                    'BonusId' => 'shared',  
                    'PlayerId' => $user->id . '-' . 'eth' . '-' . $mainid,  
                    'AlternativeId' => time() . '_' . $user->id . '_' . 'eth', 
                    'Params' => [   
                        'freeround_bet' => 1    
                    ],  
                    'RestorePolicy' => 'Create'
                ]   
            );  
        }
        }
        else {
            if(auth()->user()->access == 'moderator') {
                $this->client->setPlayer(['Id' => $user->id . '-' . auth()->user()->clientCurrency()->id() . '-' . $mainbonusid , 'BankGroupId' => $mainbonusgroup]);
                    usleep(11000);
                $game = $this->client->createSession(
                [
                    'GameId' => $slugsanitize,
                    'StaticHost' => $staticserver,
                    'PlayerId' => $user->id . '-' . auth()->user()->clientCurrency()->id() . '-' . $mainbonusid,
                    'AlternativeId' => time() . '_' . $user->id . '_' . auth()->user()->clientCurrency()->id(),
                    'RestorePolicy' => 'Last'
                ]
            );
             }
            else {
                $this->client->setPlayer(['Id' => $user->id . '-' . auth()->user()->clientCurrency()->id() . '-' . $mainid , 'BankGroupId' => $mainbankgroup]);
                    usleep(11000);
                $game = $this->client->createSession(
                [
                    'GameId' => $slugsanitize,
                    'StaticHost' => $staticserver,
                    'PlayerId' => $user->id . '-' . auth()->user()->clientCurrency()->id() . '-' . $mainid,
                    'AlternativeId' => time() . '_' . $user->id . '_' . auth()->user()->clientCurrency()->id(),
                    'RestorePolicy' => 'Last'
                ]
            );
        }
        }
            if($user->freegames > 0 && $slugsanitize == $freespinslot) {
                $url = 'https://' . $game['SessionId'] . '.spins.sh/?' . $slugsanitize;
        }

        else {
                $url = 'https://' . $game['SessionId'] . '.spins.sh/?' . $slugsanitize;
            }
                $view = view('c27')->with('data', $game)->with('url', $url);
                usleep(150000);
            return view('layouts.app')->with('page', $view);
        }
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdrawAndDeposit(Request $request)
    {

        Log::notice($request);

        $content = json_decode($request->getContent());
        $sessionAlternativeId = $content->params->sessionAlternativeId;
        $gameguidc = (\App\Slotslist::get()->where('id', $content->params->gameId)->first());
        $gameguid = ($gameguidc->n);
        $gameslug = ($gameguidc->id);
        $gamevuid = ($gameguidc->UID);


        $currency = explode('_', $sessionAlternativeId);
        $currency = $currency[2];
        $playerName = explode('-', $content->params->playerName);
        $user = $this->getUser($playerName[0]);
        if(\App\Statistics::where('_id', $user->id)->first() == null) {
            $a = \App\Statistics::create([
                '_id' => $user->id, 'bets_btc' => 0, 'wins_btc' => 0, 'loss_btc' => 0, 'wagered_btc' => 0, 'profit_btc' => 0, 'bets_eth' => 0, 'wins_eth' => 0, 'loss_eth' => 0, 'wagered_eth' => 0, 'profit_eth' => 0, 'bets_ltc' => 0, 'wins_ltc' => 0, 'loss_ltc' => 0, 'wagered_ltc' => 0, 'profit_ltc' => 0, 'bets_doge' => 0, 'wins_doge' => 0, 'loss_doge' => 0, 'wagered_doge' => 0, 'profit_doge' => 0, 'bets_bch' => 0, 'wins_bch' => 0, 'loss_bch' => 0, 'wagered_bch' => 0, 'profit_bch' => 0, 'bets_trx' => 0, 'wins_trx' => 0, 'loss_trx' => 0, 'wagered_trx' => 0, 'profit_trx' => 0, 'bets_xrp' => 0, 'wins_xrp' => 0, 'loss_xrp' => 0, 'wagered_xrp' => 0, 'profit_xrp' => 0, 'bets_bnb' => 0, 'wins_bnb' => 0, 'loss_bnb' => 0, 'wagered_bnb' => 0, 'profit_bnb' => 0, 'bets_usdt' => 0, 'wins_usdt' => 0, 'loss_usdt' => 0, 'wagered_usdt' => 0, 'profit_usdt' => 0, 'bets_usdc' => 0, 'wins_usdc' => 0, 'loss_usdc' => 0, 'wagered_usdc' => 0, 'profit_usdc' => 0, 'bets_bonus' => 0, 'wins_bonus' => 0, 'loss_bonus' => 0, 'wagered_bonus' => 0, 'profit_bonus' => 0
            ]);
        }
        $stats = \App\Statistics::where('_id', $user->id)->first();
        $balance = $user->balance(Currency::find($currency))->get();    
        if ($user->freegames > 0) {   
            if (($user->freegames - $content->params->chargeFreerounds) > 0) {  
                $user->freegames = $user->freegames - $content->params->chargeFreerounds;   
                $user->freegames_balance = $user->freegames_balance + $content->params->deposit;    
                $user->save();  
                return response()->json([   
                    'result' => [   
                        'newBalance' => (int) ($user->freegames_balance),   
                        'transactionId' => $content->params->transactionRef,    
                        'freeroundsLeft' => $user->freegames    
                    ],  
                    'id' => $content->id,   
                    'jsonrpc' => '2.0'  
                ]);
                } else {    
                $content->params->deposit = $user->freegames_balance;   
                $user->freegames = 0;   
                $user->freegames_balance = 0;   
                $user->save();  
            }   
        } else if ($user->freegames_balance > 0) {  
            $content->params->deposit = $user->freegames_balance;   
            $user->freegames_balance = 0;   
            $user->save();  
        }

        if ($currency == 'BTC' || $currency == 'btc') {
            $balanceB = (int) ((((string) $balance) * \App\Http\Controllers\Api\WalletController::rateDollarBtc()) * 100);
        } elseif ($currency == 'doge' || $currency == "DOGE") {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarDoge()) * 100);
        } elseif ($currency == 'trx' || $currency == 'TRX') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarTron()) * 100);
        } elseif ($currency == 'bnb' || $currency == 'BNB') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBnb()) * 100);
        } elseif ($currency == 'usdc' || $currency == 'USDC') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarUsdc()) * 100);
        } elseif ($currency == 'xrp' || $currency == 'XRP') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarXrp()) * 100);
        } elseif ($currency == 'bonus' || $currency == 'BONUS') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBonus()) * 100);
        } elseif ($currency == 'usdt' || $currency == 'USDT') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarUsdt()) * 100);
        } elseif ($currency == 'ltc' || $currency == 'LTC') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarLtc()) * 100);
        } elseif ($currency == 'bch' || $currency == 'BCH') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash()) * 100);
        } elseif ($currency == 'eth' || $currency == 'ETH') {
            $balanceB = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarEth()) * 100);
        }

        if ($currency == 'btc') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarBtc() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarBtc() * 100, 8);

        } elseif ($currency == 'doge' || $currency == "DOGE") {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarDoge() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarDoge() * 100, 8);
        } elseif ($currency == 'trx' || $currency == 'TRX') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarTron() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarTron() * 100, 8);
        } elseif ($currency == 'ltc' || $currency == 'LTC') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarLtc() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarLtc() * 100, 8);
        } elseif ($currency == 'usdt' || $currency == 'USDT') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarUsdt() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarUsdt() * 100, 8);
        } elseif ($currency == 'usdc' || $currency == 'USDC') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarUsdc() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarUsdc() * 100, 8);
        } elseif ($currency == 'bnb' || $currency == 'BNB') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarBnb() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarBnb() * 100, 8);
        } elseif ($currency == 'xrp' || $currency == 'XRP') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarXrp() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarXrp() * 100, 8);
        } elseif ($currency == 'bonus' || $currency == 'BONUS') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarBonus() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarBonus() * 100, 8);
        } elseif ($currency == 'bch' || $currency == 'BCH') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarBtcCash() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarBtcCash() * 100, 8);
        } elseif ($currency == 'eth' || $currency == 'ETH') {
            $subtract = bcdiv($content->params->withdraw, \App\Http\Controllers\Api\WalletController::rateDollarEth() * 100, 8);
            $add = bcdiv($content->params->deposit, \App\Http\Controllers\Api\WalletController::rateDollarEth() * 100, 8);
        }

        if($user->freegames < 1) {
            $user->balance(Currency::find($currency))->subtract($subtract, json_decode($request->getContent(), true));
        }
            $user->balance(Currency::find($currency))->add($add, json_decode($request->getContent(), true));

        $balance = $user->balance(Currency::find($currency))->get();
        if ($currency == 'BTC' || $currency == 'btc') {
            $balance = (int) ((((string) $balance) * \App\Http\Controllers\Api\WalletController::rateDollarBtc()) * 100);
        } elseif ($currency == 'doge' || $currency == "DOGE") {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarDoge()) * 100);
        } elseif ($currency == 'trx' || $currency == 'TRX') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarTron()) * 100);
        } elseif ($currency == 'ltc' || $currency == 'LTC') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarLtc()) * 100);
        } elseif ($currency == 'usdt' || $currency == 'USDT') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarUsdt()) * 100);
        } elseif ($currency == 'usdc' || $currency == 'USDC') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarUsdc()) * 100);
        } elseif ($currency == 'xrp' || $currency == 'XRP') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarXrp()) * 100);
        } elseif ($currency == 'bnb' || $currency == 'BNB') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBnb()) * 100);
        } elseif ($currency == 'bch' || $currency == 'BCH') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash()) * 100);
        } elseif ($currency == 'bonus' || $currency == 'BONUS') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBonus()) * 100);
        } elseif ($currency == 'eth' || $currency == 'ETH') {
            $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarEth()) * 100);
        }

        if ($add > 0) {
            $status = 'win';
        } else {
            $status = 'loss';
        }

        if ($subtract != 0) {
            $multi = (float) number_format(($add / $subtract), 2);
        } else {
            $multi = 0;
        }

        $profit = (float) $add - $subtract;

        if($currency == 'doge'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarDoge(), 2, '.', ''));
            $stats->update([
                'bets_doge' => $stats->bets_doge + 1,
                'wins_doge' => $stats->wins_doge + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_doge' => $stats->loss_doge + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_doge' => $stats->wagered_doge + $subtract,
                'profit_doge' => $stats->profit_doge + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }
        if($currency == 'usdt'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarUsdt(), 2, '.', ''));
            $stats->update([
                'bets_usdt' => $stats->bets_usdt + 1,
                'wins_usdt' => $stats->wins_usdt + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_usdt' => $stats->loss_usdt + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_usdt' => $stats->wagered_usdt + $subtract,
                'profit_usdt' => $stats->profit_usdt + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }
        if($currency == 'usdc'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarUsdc(), 2, '.', ''));
            $stats->update([
                'bets_usdc' => $stats->bets_usdc + 1,
                'wins_usdc' => $stats->wins_usdc + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_usdc' => $stats->loss_usdc + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_usdc' => $stats->wagered_usdc + $subtract,
                'profit_usdc' => $stats->profit_usdc + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }
        if($currency == 'bnb'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarBnb(), 2, '.', ''));
            $stats->update([
                'bets_bnb' => $stats->bets_bnb + 1,
                'wins_bnb' => $stats->wins_bnb + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_bnb' => $stats->loss_bnb + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_bnb' => $stats->wagered_bnb + $subtract,
                'profit_bnb' => $stats->profit_bnb + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }
        if($currency == 'xrp'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarXrp(), 2, '.', ''));
            $stats->update([
                'bets_xrp' => $stats->bets_xrp + 1,
                'wins_xrp' => $stats->wins_xrp + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_xrp' => $stats->loss_xrp + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_xrp' => $stats->wagered_xrp + $subtract,
                'profit_xrp' => $stats->profit_xrp + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }
        if($currency == 'btc'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarBtc(), 2, '.', ''));
            $stats->update([
                'bets_btc' => $stats->bets_btc + 1,
                'wins_btc' => $stats->wins_btc + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_btc' => $stats->loss_btc + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_btc' => $stats->wagered_btc + $subtract,
                'profit_btc' => $stats->profit_btc + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }
        if($currency == 'bonus'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarBonus(), 2, '.', ''));
            $stats->update([
                'bets_bonus' => $stats->bets_bonus + 1,
                'wins_bonus' => $stats->wins_bonus + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_bonus' => $stats->loss_bonus + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_bonus' => $stats->wagered_bonus + $subtract,
                'profit_bonus' => $stats->profit_bonus + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }

        if($currency == 'eth'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarEth(), 2, '.', ''));
            $stats->update([
                'bets_eth' => $stats->bets_eth + 1,
                'wins_eth' => $stats->wins_eth + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_eth' => $stats->loss_eth + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_eth' => $stats->wagered_eth + $subtract,
                'profit_eth' => $stats->profit_eth + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }

        if($currency == 'ltc'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarLtc(), 2, '.', ''));
            $stats->update([
                'bets_ltc' => $stats->bets_ltc + 1,
                'wins_ltc' => $stats->wins_ltc + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_ltc' => $stats->loss_ltc + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_ltc' => $stats->wagered_ltc + $subtract,
                'profit_ltc' => $stats->profit_ltc + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }

        if($currency == 'bch'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarBtcCash(), 2, '.', ''));
            $stats->update([
                'bets_bch' => $stats->bets_bch + 1,
                'wins_bch' => $stats->wins_bch + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_bch' => $stats->loss_bch + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_bch' => $stats->wagered_bch + $subtract,
                'profit_bch' => $stats->profit_bch + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }

        if($currency == 'trx'){
            $usd_wager = floatval(number_format($subtract * WalletController::rateDollarTron(), 2, '.', ''));
            $stats->update([
                'bets_trx' => $stats->bets_trx + 1,
                'wins_trx' => $stats->wins_trx + ($profit > 0 ? ($multi < 1 ? 0 : 1) : 0),
                'loss_trx' => $stats->loss_trx + ($profit > 0 ? ($multi < 1 ? 1 : 0) : 1),
                'wagered_trx' => $stats->wagered_trx + $subtract,
                'profit_trx' => $stats->profit_trx + ($profit > 0 ? ($multi < 1 ? -($subtract) : ($profit)) : -($subtract))
            ]);
        }
        $game = \App\Game::create([
            'id' => DB::table('games')->count() + 1,
            'user' => $user->id,
            'game' => 'slotmachine',
            'wager' => (float) $subtract,
            'multiplier' => $multi,
            'status' => $status,
            'profit' => $profit,
            'server_seed' => $content->params->transactionRef,
            'client_seed' => $content->params->transactionRef,
            'nonce' => $gameguid,
            'data' => json_decode($request->getContent(), true),
            'type' => 'quick',
            'balance-before' => number_format($balanceB/100, 2, '.', ''),
            'balance-after' => number_format($balance/100, 2, '.', ''),
            'currency' => strtolower($currency)
        ]);
                
       if($recentslots = \App\RecentSlots::where('user_id', $user->id)->where('s', $gamevuid)->first()) {
                    $recentslots->update([
                    'b' => $recentslots->b + 1
                    ]);      
                }

            event(new \App\Events\LiveFeedGame($game, 10));

            $minmulti = \App\Settings::where('name', 'bigwinner_min_multi')->first()->value;
            $getcronstate = \App\Settings::where('name', 'tg_bigwinner_cron')->first()->value;

            if($multi > $minmulti) {
                if($getcronstate == '0')
                Settings::where('name', 'bigwinner_player')->update(['value' => $user->name]);
                Settings::where('name', 'bigwinner_slot')->update(['value' => $gameguid]);
                Settings::where('name', 'bigwinner_amount')->update(['value' => ($content->params->deposit / 100)]);
                Settings::where('name', 'bigwinner_multi')->update(['value' => $multi]);
                Settings::where('name', 'bigwinner_game')->update(['value' => $gameslug]);
                Settings::where('name', 'bigwinner_gamevuid')->update(['value' => $gamevuid]);

                Settings::where('name', 'tg_bigwinner_cron')->update(['value' => 1]);

            }

                if($user->bonus1 == '2' && $currency == 'bonus') {
                    if($multi < 0.95 || $multi > 1.20) {
                    if($usd_wager > floatval(0.15)) {
                       $user->update([
                        'bonus1_wager' => ($user->bonus1_wager ?? 0) + (float) $subtract
                        ]);
                        }
                    }
                }
                if($user->bonus2 == '2' && $currency == 'bonus') {
                    if($multi < 0.95 || $multi > 1.20) {
                    if($usd_wager > floatval(0.15)) {
                       $user->update([
                        'bonus2_wager' => ($user->bonus2_wager ?? 0) + (float) $subtract
                        ]);
                        }
                    }
                }

            Leaderboard::insert($game);
            
            if($usd_wager > floatval(0.10)) {
                if($multi < 0.95 || $multi > 1.25) {
                    Races::insert($game);
                    if ((Currency::find($currency)->dailyminslots() ?? 0) <= $subtract) {
                        if ($user->vipLevel() > 0 && ($user->weekly_bonus ?? 0) < 100) {
                        $user->update([
                        'weekly_bonus' => ($user->weekly_bonus ?? 0) + 0.1
                ]);
               }
             }
            }
        }

        return response()->json([
            'result' => [
                'newBalance' => $balance,
                'transactionId' => $content->params->transactionRef,
            ],
            'id' => $content->id,
            'jsonrpc' => '2.0'
        ]);
    }

    public function getBalance(Request $request)
    {
        usleep(12000);
        try {
            $content = json_decode($request->getContent());

            $sessionAlternativeId = $content->params->sessionAlternativeId;

            $currency = explode('_', $sessionAlternativeId);
            $currency = $currency[2];


            $playerName = explode('-', $content->params->playerName);

            $user = $this->getUser(strtolower($playerName[0]));

            $balance = $user->balance(Currency::find($currency))->get();

            if ($currency == 'BTC' || $currency == 'btc') {
                $balance = (int) ((((string) $balance) * \App\Http\Controllers\Api\WalletController::rateDollarBtc()) * 100);
            } elseif ($currency == 'doge' || $currency == "DOGE") {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarDoge()) * 100);
            } elseif ($currency == 'trx' || $currency == 'TRX') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarTron()) * 100);
            } elseif ($currency == 'ltc' || $currency == 'LTC') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarLtc()) * 100);
            } elseif ($currency == 'xrp' || $currency == 'XRP') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarXrp()) * 100);
            } elseif ($currency == 'bnb' || $currency == 'BNB') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBnb()) * 100);
            } elseif ($currency == 'usdt' || $currency == 'USDT') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarUsdt()) * 100);
            } elseif ($currency == 'bonus' || $currency == 'BONUS') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBonus()) * 100);
            } elseif ($currency == 'usdc' || $currency == 'USDC') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarUsdc()) * 100);
            } elseif ($currency == 'bch' || $currency == 'BCH') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash()) * 100);
            } elseif ($currency == 'eth' || $currency == 'ETH') {
                $balance = (int)((((string)$balance) * \App\Http\Controllers\Api\WalletController::rateDollarEth()) * 100);
            }
        } catch (\Error $e) {
            $balance = 0;
        }
        $freegames = 0;
        if ($user->freegames > 0 ) {
            $freegames = $user->freegames;
            $balance = (int) $user->freegames_balance;
        }
        return response()->json([
            'result' => ([
                'balance' => $balance,
                'freeroundsLeft' => (int) $freegames
            ]),
            'id' => $content->id,
            'jsonrpc' => '2.0'
        ]);
    }
    public function getUser($playerName): User
    {
        return User::findOrFail($playerName);
    }
}
