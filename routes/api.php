<?php

use App\Chat;
use App\Currency\Currency;
use App\Events\Deposit;
use App\Events\DepositCredited;
use App\Events\WithdrawSent;
use App\Events\BonusCredited;
use App\Events\ChatMessage;
use App\Games\Kernel\Data;
use App\Games\Kernel\Extended\ExtendedGame;
use App\Games\Kernel\Game;
use App\Games\Kernel\Module\ModuleSeeder;
use App\Games\Kernel\ProvablyFairResult;
use App\Http\Controllers\Api\WalletController;
use App\Invoice;
use App\User; 
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use MongoDB\BSON\Decimal128;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PokerApi;

Route::any('WVjRFA5EgS3yXTn', 'C27Controller@seamless')->name('rpc.endpoint');
Route::any('evoplay77gS3y', 'EvoController@seamless')->name('rpc.endpoint');
Route::any('callback/upgames', 'LivecasinoController@seamless')->name('rpc.endpoint');


Route::any('callback/no9gqYHbIOWmW1Q4PkTEAW7De1z4v/{userid}', function(Request $request, $userid) {
    Log::warning(json_encode($request->all()));
    $user = User::where('_id', $userid)->first();
    $tglink = \App\Settings::where('name', 'telegram_link')->first()->value;
    $checkcount = \App\User::where('tg_linked', $request->id)->count();

    if($checkcount == 0) {
        $user->update(['tg_linked' => $request->id]);   
    }
    header('Location: '.$tglink);
    die();

});



Route::post('callback/nowpayments/withdrawals', function(Request $request) {
    Log::warning(json_encode($request->all()));
       if($request->status == 'FAILED') {  
        $withdraw = \App\Withdraw::where('address', $request->get('address'))    
            ->where('status', 0)
            ->first();  
        $withdraw->update(['hash' => 'failed']);

            return response('Ok', 200)  
                ->header('Content-Type', 'text/plain'); 
        }   
       if($request->status == 'FINISHED') {  
         $withdraw = \App\Withdraw::where('address', $request->get('address'))    
            ->where('status', 0)
            ->first();  
        $withdraw->update(['status' => '1']);
            return response('Ok', 200)   
                ->header('Content-Type', 'text/plain'); 

        event(new WithdrawSent($user));

        }   

});

Route::get('walletNotify/{currency}/{txid}', function($currency, $txid) {
    Currency::find($currency)->process($txid);
    return success();
});

Route::get('blockNotify/{currency}/{blockId}', function($currency, $blockId) {
    Currency::find($currency)->processBlock($blockId);
    return success();
});

Route::post('search/games', function(Request $request) {
        $request->validate([
            'text' => ['required', 'string', 'min:0']
        ]);
        $games = \App\Slotslist::get();
        $items = json_decode(json_encode($games));
        $input = $request->text;
        $result = array_filter($items, function ($item) use ($input) {
        if ((stripos($item->n, $input) !== false) || (stripos($item->p, $input) !== false)) {
        return true;
        }
        return false;
        });
        $showamount = $request->showamount;


        return success(array_values(array_slice($result, 0, $showamount)));
    });


Route::post('search/provider', function(Request $request) {

        $games = \App\Slotslist::get()->shuffle();
        $items = json_decode(json_encode($games));
        $input = $request->provider;
        $result = array_filter($items, function ($item) use ($input) {
        if ((stripos($item->n, $input) !== false) || (stripos($item->p, $input) !== false)) {
        return true;
        }
        return false;
        });
        $showamount = $request->showamount;


        
        
        return success(array_values(array_slice($result, 0, $showamount)));
    });


Route::post('search/random', function(Request $request) {

        $games = \App\Slotslist::get()->shuffle();
        $items = json_decode(json_encode($games));
        $input = " ";
        $result = array_filter($items, function ($item) use ($input) {
        if ((stripos($item->n, $input) !== false) || (stripos($item->p, $input) !== false)) {
        return true;
        }
        return false;
        });
                $showamount = $request->showamount;



        return success(array_values(array_slice($result, 0, $showamount)));
    });


Route::post('chatHistory', function() {
    $history = \App\Chat::latest()->limit(25)->where('deleted', '!=', true)->get()->toArray();
    if(\App\Settings::where('name', 'quiz_active')->first()->value !== 'false')
        array_push($history, [
            "data" => [
                "question" => \App\Settings::where('name', 'quiz_question')->first()->value,
            ],
            "type" => "quiz"
        ]);
    return success($history);
});

Route::get('callback/KcxVGsn', function(Request $request) {
            Log::notice(json_encode($request->all()));
            $balancetype = \App\Settings::where('name', 'offerwall_balancetype')->first()->value;
            $amount = $request->get('amount');
            $ethpoints = number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 7, '.', '');
            $ethfloat = floatval($ethpoints);
            $user = User::where('_id', $request->get('user_id'))->first();  
            $user->balance(\App\Currency\Currency::find('eth'))->add($ethfloat, \App\Transaction::builder()->message('Offerwall Credit')->get()); 
            $invoice = Invoice::create([
            'currency' => 'eth',
            'ledger' => 'Offerwall Credit',
            'user' => $user->id,
            'status' => 1,
            'sum' => $ethfloat,
        ]);
            return response('1', 200)
                ->header('Content-Type', 'text/plain'); 
});

    Route::post('callback/nowpayments', function(Request $request) {
         Log::critical(json_encode($request->all()));

     if (!$request->has('order_description') || Invoice::where('hash', $request->get('order_description'))->count() === 0) {   
            return response('Ok', 200)  
                ->header('Content-Type', 'text/plain'); 
        } 

       if($request->payment_status == 'confirming') {  
        $invoice = Invoice::where('hash', $request->get('order_description'))    
            ->where('status', 0)
            ->first();  
        $user = \App\User::find($invoice->user);
        $sum = $request->get('actually_paid');
        $currency = $invoice->currency;
        event(new Deposit($user));
        $user->update(['wallet_'.$currency => null]);  
        return response('Ok', 200)  
                ->header('Content-Type', 'text/plain'); 
        }   
       if($request->payment_status == 'expired') {  
        $invoice = Invoice::where('hash', $request->get('order_description'))    
            ->where('status', 0)
            ->first();  
        $user = \App\User::find($invoice->user);
        $currency = $invoice->currency;
        $user->update(['wallet_'.$currency => null]);  
        return response('Ok', 200)  
                ->header('Content-Type', 'text/plain'); 
        }   
       if(!$request->payment_status == 'finished' ||  Invoice::where('hash', $request->get('order_description'))->where('status', 0)->count() === 0) {  
            return response('Ok', 200)  
                ->header('Content-Type', 'text/plain'); 
        }   
        if($request->payment_status == 'finished') {
        $invoice = Invoice::where('hash', $request->get('order_description'))    
            ->where('status', 0)
            ->first();  
        $user = \App\User::find($invoice->user);
        $invoice->update(['status' => 1, 'sum' => $request->get('outcome_amount')]);
                $currency = $invoice->currency;
        $user->update(['wallet_'.$currency => null]);

        if($user->bonus1 == '1') {
            $currency = $invoice->currency;
            $rawdeposit = $request->get('outcome_amount');
            if ($currency == 'btc') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarBtc();
            } elseif ($currency == 'doge') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarDoge();
            } elseif ($currency == 'xrp') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarXrp();
            } elseif ($currency == 'bnb') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarBnb();
            } elseif ($currency == 'usdt' || $currency =='usdttrc20') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarUsdt();
            } elseif ($currency == 'usdc') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarUsdc();
            } elseif ($currency == 'matic') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarMatic();
            } elseif ($currency == 'trx') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarTron();
            } elseif ($currency == 'ltc') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarLtc();
            } elseif ($currency == 'bch') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash();
            } elseif ($currency == 'eth') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarEth();
            }
            
        $bonuscurrency = 'bonus';
        $bonususdamount = round($base * 2,2);
        $bonusgoal = round($bonususdamount * 15,2);

        $user->update(['bonus1' => 2, 'bonus1_currency' => $invoice->currency,'bonus1_goal' => $bonusgoal]);  
        $user->balance(\App\Currency\Currency::find($bonuscurrency))->add($bonususdamount); 
        event(new BonusCredited($user));

        } elseif($user->bonus2 == '1') {
            $currency = $invoice->currency;
            $rawdeposit = $request->get('outcome_amount');
            if ($currency == 'btc') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarBtc();
            } elseif ($currency == 'doge') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarDoge();
            } elseif ($currency == 'xrp') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarXrp();
            } elseif ($currency == 'bnb') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarBnb();
            } elseif ($currency == 'usdt' || $currency =='usdttrc20') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarUsdt();
            } elseif ($currency == 'usdc') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarUsdc();
            } elseif ($currency == 'matic') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarMatic();
            } elseif ($currency == 'trx') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarTron();
            } elseif ($currency == 'ltc') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarLtc();
            } elseif ($currency == 'bch') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash();
            } elseif ($currency == 'eth') {
                $base = $rawdeposit * \App\Http\Controllers\Api\WalletController::rateDollarEth();
            }
            
        $bonuscurrency = 'bonus';
        $bonususdamount = round($base * 3,2);
        $bonusgoal = round($bonususdamount * 45,2);

        $user->update(['bonus2' => 2, 'bonus2_currency' => $invoice->currency,'bonus2_goal' => $bonusgoal]);  
        $user->balance(\App\Currency\Currency::find($bonuscurrency))->add($bonususdamount); 
        event(new BonusCredited($user));      
        } else {            
        $user->balance(\App\Currency\Currency::find($invoice->currency))->add($request->get('outcome_amount')); 
        event(new DepositCredited($user));
        }
        return response('Ok', 200)  
            ->header('Content-Type', 'text/plain'); 
        }
});

Route::middleware('auth')->prefix('investment')->group(function() {
    Route::post('history', function() {
        $out = [];
        foreach(\App\Investment::where('user', auth()->user()->_id)->orderBy('status', 'asc')->latest()->get() as $investment)
            array_push($out, [
                'amount' => $investment->amount,
                'share' => $investment->status == 1 ? $investment->disinvest_share : $investment->getRealShare($investment->getProfit(), \App\Investment::getGlobalBankroll(\App\Currency\Currency::find($investment->currency))),
                'profit' => $investment->getProfit() <= 0 ? 0 : $investment->getProfit(),
                'status' => $investment->status,
                'id' => $investment->_id
            ]);
        return success($out);
    });
    Route::post('stats', function() {
        $currency = auth()->user()->clientCurrency();
        $userBankroll = \App\Investment::getUserBankroll($currency, auth()->user());
        $globalBankroll = \App\Investment::getGlobalBankroll($currency);

        $userBankrollShare = 0;
        foreach(\App\Investment::where('user', auth()->user()->_id)->where('currency', $currency)->where('status', 0)->get() as $investment)
            $userBankrollShare += $investment->getRealShare($investment->getProfit(), $globalBankroll);

        return success([
            'your_bankroll' => auth()->user()->getInvestmentProfit($currency, false),
            'your_bankroll_percent' => $userBankroll == 0 || $globalBankroll == 0 ? 0 : $userBankroll / $globalBankroll * 100,
            'your_bankroll_share' => $userBankrollShare,
            'investment_profit' => auth()->user()->getInvestmentProfit($currency, true, false),
            'site_bankroll' => $globalBankroll,
            'site_profit' => \App\Investment::getSiteProfitSince($currency, \Carbon\Carbon::minValue())
        ]);
    });
});
Route::middleware('auth')->prefix('wallet')->group(function() {
    Route::post('getDepositWallet', function(Request $request) {
        $currency = Currency::find($request->currency);
        $apikey = 'V68WSXK-8GQMEJG-GQFEYHR-HT02EYS';
        try {
        $curlcurrency = curl_init();
        curl_setopt_array($curlcurrency, array(
          CURLOPT_URL => 'https://api.nowpayments.io/v1/min-amount?currency_from='.$currency->nowpayments().'',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
               "x-api-key: ".$apikey."",
          ),
        ));
        $responsecurl = curl_exec($curlcurrency);
        curl_close($curlcurrency);
        Log::notice($responsecurl);
        $responseCurrency = json_decode($responsecurl);
        $mindeposit = $responseCurrency->min_amount;
        } catch (\Exception $exception) {
            Log::notice($exception);
            return reject(2, 'Could not process request');
        }
            if ($request->currency == 'btc') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarBtc();
            } elseif ($request->currency == 'doge') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarDoge();
            } elseif ($request->currency == 'xrp') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarXrp();
            } elseif ($request->currency == 'bnb') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarBnb();
            } elseif ($request->currency == 'usdt') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarUsdt();
            } elseif ($request->currency == 'usdc') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarUsdc();
            } elseif ($request->currency == 'matic') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarMatic();
            } elseif ($request->currency == 'trx') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarTron();
            } elseif ($request->currency == 'ltc') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarLtc();
            } elseif ($request->currency == 'bch') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash();
            } elseif ($request->currency == 'eth') {
                $mindepositusd = $mindeposit * \App\Http\Controllers\Api\WalletController::rateDollarEth();
            }
        $wallet = auth()->user()->depositWallet($currency);
        if($wallet == null || $wallet === 'Error') {
        $hash = Hash::make(12);
        $invoice = Invoice::create([
            'currency' => $currency->id(),
            'user' => auth()->user()->_id,
            'status' => 0,
            'hash' => $hash,
        ]);      
        //$apikey = $currency->option('apikey');
        $apikey = 'V68WSXK-8GQMEJG-GQFEYHR-HT02EYS';
        $ipn = 'https://loff.io/api/callback/nowpayments';
        //$ipn = $currency->option('ipn');
        $price_amount = round($mindepositusd + 3, 3); //(usd, eur)
        $price_currency = 'usd'; //(usd, eur)
        $pay_currency = $currency->nowpayments();
        try {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.nowpayments.io/v1/payment", 
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{
         "price_amount": "'.$price_amount.'",
         "price_currency": "'.$price_currency.'",
         "pay_currency": "'.$pay_currency.'",
         "ipn_callback_url": "'.$ipn.'",
         "order_id": "'.$invoice->_id.'",
         "order_description": "'.$hash.'"
        }',
        CURLOPT_HTTPHEADER => array(
       "x-api-key: ".$apikey."",
       "Content-Type: application/json"
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        } catch (\Exception $exception) {
            Log::notice($exception);
            return reject(2, 'Could not process request');
        }
        $responseResult = json_decode($response);
        Log::notice(json_encode($response));
       if($responseResult->pay_currency == 'xrp' || $responseResult->pay_currency == 'bnb') {
        $invoice->update([
            'payid' => $responseResult->payin_extra_id,
            'ledger' => $responseResult->pay_address,
            'min' => $responseResult->pay_amount,
            'dollar' => $responseResult->price_amount
        ]);
        } else {
        $invoice->update([
            'ledger' => $responseResult->pay_address,
            'min' => $responseResult->pay_amount,
            'payid' => $responseResult->payment_id,
            'dollar' => $responseResult->price_amount
        ]);
        }
        auth()->user()->update([
                'wallet_'.$request->currency => $responseResult->pay_address
        ]);
        return success([
            'currency' => $request->currency,
            'payid' => $invoice->payid,
            'mindeposit' => $responseResult->pay_amount,
            'mindepositusd' => $responseResult->price_amount,
            'wallet' => $responseResult->pay_address
        ]);
        } else {
        $today = \Carbon\Carbon::today()->toDateTimeString();
        $getinvoice = Invoice::where('ledger', $wallet)->where('updated_at', '>=', \Carbon\Carbon::parse($today))->where('status', 0)->first();  
        return success([
            'currency' => $request->currency,
            'mindeposit' => $getinvoice->min,
            'payid' => $getinvoice->payid,
            'mindepositusd' => round($mindepositusd + 3, 3),
            'wallet' => $wallet
        ]); 
    }
    });
    
    Route::post('withdraw', function(Request $request) {
        //if(!auth()->user()->validate2FA(false)) return reject(-1024);
        //auth()->user()->reset2FAOneTimeToken();
        
        $currency = Currency::find($request->currency);
        
        if(floatval($request->sum) < floatval($currency->option('withdraw')) + floatval($currency->option('fee'))) return reject(1, 'Invalid withdraw value');

        if(auth()->user()->balance($currency)->get() < floatval($request->sum) + floatval($currency->option('fee'))) return reject(2, 'Not enough balance');

        if(\App\Withdraw::where('user', auth()->user()->_id)->where('status', 0)->count() > 0) return reject(3, 'Moderation is still in process');

        if(auth()->user()->access == 'moderator') return reject(1, 'Not available');

        auth()->user()->balance($currency)->subtract($request->sum + floatval($currency->option('fee')), \App\Transaction::builder()->message('Withdraw')->get());
        if(auth()->user()->balance($currency)->get() + \App\Withdraw::where('status', 0)->where('user', auth()->user()->_id)->where('currency', $currency->id())->sum('sum') > floatval($currency->option('withdraw_manual_trigger')))
      {
        $withdraw = \App\Withdraw::create([
            'user' => auth()->user()->_id,
            'sum' => $request->sum,
            'currency' => $currency->id(),
            'address' => $request->wallet,
            'status' => 0,
            'auto' => 'false'
        ]);
         //   || $request->sum < $currency->hotWalletBalance();
      } else {
        $withdraw = \App\Withdraw::create([
            'user' => auth()->user()->_id,
            'sum' => $request->sum,
            'currency' => $currency->id(),
            'address' => $request->wallet,
            'status' => 0,
            'auto' => 'true'
        ]);
        try {       
            $url = "https://api.nowpayments.io/v1/auth";
            $curljwt = curl_init($url);
            curl_setopt($curljwt, CURLOPT_URL, $url);
            curl_setopt($curljwt, CURLOPT_POST, true);
            curl_setopt($curljwt, CURLOPT_RETURNTRANSFER, true);
            $headers = array(
               "Content-Type: application/json",
            );
            curl_setopt($curljwt, CURLOPT_HTTPHEADER, $headers);
                $data = <<<DATA
                {
                    "email": "ryan@nx.link",
                    "password": "i7qVFbGWbm6MxAe" 
                }
                DATA;
                curl_setopt($curljwt, CURLOPT_POSTFIELDS, $data);
                //for debug only!
                curl_setopt($curljwt, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curljwt, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($curljwt);
                curl_close($curljwt);
                } catch (\Exception $exception) {
            return reject(2, 'Could not process request');
        }
        $responseResult = json_decode($response);
        Log::notice(json_encode($response));

 if($responseResult !== null) {

Log::notice($request->wallet);
Log::notice($currency->nowpayments());
Log::notice($request->sum);
$usercurrenccy = $currency->nowpayments();
$sumformat = number_format(floatval($request->sum), 6, '.', '');
$ipnwithdr = 'https://bitsarcade.com/api/callback/nowpayments/withdrawals';
try {
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.nowpayments.io/v1/payout',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "withdrawals": [
        {
            "address": "'.$request->wallet.'",
            "currency": "'.$usercurrenccy.'",
            "ipn_callback_url": "'.$ipnwithdr.'",
            "amount": '.$sumformat.'
        }
    ]
}',
  CURLOPT_HTTPHEADER => array(
    'x-api-key: V68WSXK-8GQMEJG-GQFEYHR-HT02EYS',
    'Content-Type: application/json',
    'Authorization: Bearer '.$responseResult->token.''
  ),
));
$responsewithdraw = curl_exec($curl);
curl_close($curl);
Log::notice(json_encode($responsewithdraw));

 } catch (\Exception $exception) {
            Log::notice($exception);
            return reject(2, 'Could not process request');
        }
}
}
        return success();
    });
});

Route::middleware('auth')->prefix('pokerapi')->group(function() {

    Route::post('withdraw', function(Request $request) {
		        $amount = $request->sum;  
				if($amount < 5) return reject(0, 'Min deposit');           
                $getbalance = auth()->user()->pokerbalance();
                if(floatval($amount) > floatval($getbalance)) return reject(2, 'Not enough balance');
                if(auth()->user()->access == 'moderator') return reject(1, 'Not available');
                $ltc = 'ltc';
                $currency = Currency::find($ltc);  
				$api = new PokerApi(541, 'lkq9b2br-w8oy-01oy-qgtv-48a09v8sz91a', '217.182.195.96', 4000);
				$api->connect();
				$pokerwithdraw = '-'.$amount;
				$login = auth()->user()->name;
				$playerid = $api->getIdByLogin($login);
				$result = $api->changeBalance($playerid, 2, $pokerwithdraw);
				Log::notice($result);
                $cryptoamount = floatval(number_format(($amount / \App\Http\Controllers\Api\WalletController::rateDollarLtc()), 7, '.', ''));
                auth()->user()->balance($currency)->add($cryptoamount, \App\Transaction::builder()->message('Withdraw from Poker')->get());
                return success([]);
});

    Route::post('deposit', function(Request $request) { 
	            $amount = $request->sum;
				if($amount < 5) return reject(0, 'Min deposit');
				$currency = $request->currency;
				$cryptoamount = Currency::find($currency)->convertUsd($amount);
				$userbalance = auth()->user()->balance(Currency::find($currency))->get();
				Log::notice('User balance: '.$userbalance.' , Crypto Amount: '.$cryptoamount);
				if($userbalance < $cryptoamount) return reject(2, 'Not enough balance');
				if(auth()->user()->access == 'moderator') return reject(1, 'Not available');
				$api = new PokerApi(541, 'lkq9b2br-w8oy-01oy-qgtv-48a09v8sz91a', '217.182.195.96', 4000);
				$api->connect();
				$pokerdeposit = '+'.$amount;
				$login = auth()->user()->name;
				$playerid = $api->getIdByLogin($login);
				$result = $api->changeBalance($playerid, 2, $pokerdeposit);
				Log::notice($result);
                auth()->user()->balance(Currency::find($currency))->subtract($cryptoamount, \App\Transaction::builder()->message('Deposit to Poker')->get());
                return success([]);
});

});
Route::middleware('auth')->prefix('offers')->group(function() {
    Route::post('bonus1', function() {
                $user = auth()->user();
                if($user->bonus1 !== null) return reject(1, 'You are not eligible.');
                if($user->bonus1 == '1') return reject(1, 'You are not eligible.');
                if($user->bonus1 == '2') return reject(1, 'You are not eligible.');
                if($user->bonus1 == '3') return reject(1, 'You are not eligible.');
                if($user->bonus1 == '4') return reject(1, 'You are not eligible.');

                if($user->bonus2 == '1') return reject(2, 'You can only have one bonus active at a time.');
                if($user->bonus2 == '2') return reject(2, 'You can only have one bonus active at a time.');
                if($user->bonus2 == '3') return reject(2, 'You can only have one bonus active at a time.');

                $user->update([
                   'bonus1' => '1'
                ]);

                return success([]);
});


    Route::post('bonus1forfeit', function() {
                $user = auth()->user();
                if($user->bonus1 == 0) return reject(1, 'You are not eligible.');
                if($user->bonus1 == null) return reject(1, 'You are not eligible.');

                $user->update([
                   'bonus1' => '4',
                   'bonus' => null,
                   'bonus1_goal' => null,
                   'bonus1_currency' => null
                ]);

                return success([]);
});

    Route::post('bonus1complete', function() {
                $user = auth()->user();
                if($user->bonus1 == 0) return reject(1, 'You are not eligible.');
                if($user->bonus1 == 1) return reject(1, 'You are not eligible.');

                $currencyname = $user->bonus1_currency;
                $currency = Currency::find($currencyname);
                $currencyget = $user->balance($currency)->get();
                $amount = $currency->convertBonus();
          



            auth()->user()->balance($currency)->add($amount, \App\Transaction::builder()->message('Double Deposit')->get());
                $user->update([
                    'bonus1' => '4',
                    'bonus' => null,
                    'bonus1_goal' => null,
                    'bonus1_currency' => null
                ]);
                return success([]);
});



    Route::post('bonus2', function() {
                $user = auth()->user();
                if($user->bonus2 !== null) return reject(1, 'You are not eligible.');
                if($user->bonus2 == '1') return reject(1, 'You are not eligible.');
                if($user->bonus2 == '2') return reject(1, 'You are not eligible.');
                if($user->bonus2 == '3') return reject(1, 'You are not eligible.');
                if($user->bonus2 == '4') return reject(1, 'You are not eligible.');
                if($user->bonus1 == '1') return reject(2, 'You can only have one bonus active at a time.');
                if($user->bonus1 == '2') return reject(2, 'You can only have one bonus active at a time.');
                if($user->bonus1 == '3') return reject(2, 'You can only have one bonus active at a time.');
                if($user->vip_discord_notified !== true) return reject(3, 'Your VIP level is too low.');
                $user->update([
                   'bonus2' => '1'
                ]);
                return success([]);
});
    Route::post('bonus2forfeit', function() {
                $user = auth()->user();
                if($user->bonus2 == 0) return reject(1, 'You are not eligible.');
                if($user->bonus2 == null) return reject(1, 'You are not eligible.');

                $user->update([
                    'bonus2' => '4',
                    'bonus' => null,
                    'bonus2_goal' => null,
                    'bonus2_currency' => null
                ]);

                return success([]);
});
    Route::post('bonus2complete', function() {
                $user = auth()->user();
                if($user->bonus2 == 0) return reject(1, 'You are not eligible.');
                if($user->bonus2 == 1) return reject(1, 'You are not eligible.');

                $currencyname = $user->bonus2_currency;
                $currency = Currency::find($currencyname);
                $currencyget = $user->balance($currency)->get();
                $amount = $currency->convertBonus();

                auth()->user()->balance($currency)->add($amount, \App\Transaction::builder()->message('Triple Deposit')->get());
                $user->update([
                    'bonus2' => '4',
                    'bonus' => null,
                    'bonus2_goal' => null,
                    'bonus2_currency' => null
                ]);
                return success([]);
});
});

Route::middleware('auth')->prefix('subscription')->group(function() {
    Route::post('update', function(Request $request) {
        $request->validate([
            'endpoint' => 'required'
        ]);
        auth()->user()->updatePushSubscription(
            $request->endpoint,
            $request->publicKey,
            $request->authToken,
            $request->contentEncoding
        );
        if(auth()->user()->notification_bonus != true) {
            auth()->user()->update([
                'notification_bonus' => true
            ]);
            auth()->user()->balance(auth()->user()->clientCurrency())->add(floatval(auth()->user()->clientCurrency()->option('referral_bonus')), \App\Transaction::builder()->message('Referral bonus')->get());
        }
        return success();
    });
});



Route::middleware('auth')->prefix('user')->group(function() {
    Route::post('updateEmail', function(Request $request) {
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL) === false) return reject(1, 'Invalid email');
        if(!auth()->user()->validate2FA(false)) return reject(-1024);
        auth()->user()->reset2FAOneTimeToken();
        auth()->user()->update(['email' => $request->email]);
        return success();
    });
    Route::get('games/{id}/{page}', function($id, $page) {
        $p = [];
        foreach(\App\Game::orderBy('id', 'desc')->where('demo', '!=', true)->where('user', $id)->where('status', '!=', 'in-progress')->where('status', '!=', 'cancelled')->skip(intval($page) * 15)->take(15)->get() as $game) {
            array_push($p, [
                'game' => $game->toArray(),
                'metadata' => Game::find($game->game)->metadata()->toArray()
            ]);
        }
        return success(['page' => $p]);
    });
    Route::post('client_seed_change', function(Request $request) {
        $request->validate([
            'client_seed' => ['required', 'string', 'min:1']
        ]);

        auth()->user()->update([
            'client_seed' => $request->client_seed
        ]);
        return success();
    });
    Route::post('name_change', function(Request $request) {
        $request->validate([
            'name' => ['required', 'unique:users', 'string', 'max:12', 'regex:/^\S*$/u']
        ]);

        $history = auth()->user()->name_history;
        array_push($history, [
            'time' => \Carbon\Carbon::now(),
            'name' => $request->name
        ]);
        auth()->user()->update([
            'name' => $request->name,
            'name_history' => $history
        ]);
        return success();
    });
    Route::post('2fa_validate', function() {
        if((auth()->user()->tfa_enabled ?? false) == false) return reject(1, '2FA is disabled');
        $client = auth()->user()->tfa();
        if(request('code') == null || $client->verifyCode(auth()->user()->tfa, request('code')) !== true) return reject(2, 'Invalid 2fa code');

        auth()->user()->update([
            'tfa_onetime_key' => now()->addSeconds(15),
            'tfa_persistent_key' => now()->addDays(1)
        ]);

        return success();
    });
    Route::post('2fa_enable', function() {
        if(auth()->user()->tfa_enabled ?? false) return reject(1, 'Hacking attempt');
        $client = auth()->user()->tfa();

        if(request('2faucode') == null || $client->verifyCode(request('2facode'), request('2faucode')) !== true) return reject(2, 'Invalid 2fa code');

        auth()->user()->update([
            'tfa_enabled' => true,
            'tfa' => request('2facode')
        ]);
        return success();
    });
    Route::post('2fa_disable', function() {
        if(!auth()->user()->validate2FA(false)) return reject(-1024);
        auth()->user()->update([
            'tfa_enabled' => false,
            'tfa' => null
        ]);
        auth()->user()->reset2FAOneTimeToken();
        return success();
    });
    Route::post('2fa_test', function() {
        if(!auth()->user()->validate2FA(false)) return reject(-1024);
        auth()->user()->reset2FAOneTimeToken();
        return success();
    });
});

Route::middleware('auth')->prefix('notifications')->group(function() {
    Route::post('mark', function(Request $request) {
        auth()->user()->notifications()->where('id', $request->id)->first()->markAsRead();
        return success();
    });
    Route::post('unread', function() {
        return success([
            'notifications' => auth()->user()->unreadNotifications()->get()->toArray()
        ]);
    });
});

Route::middleware('auth')->prefix('settings')->group(function() {
    Route::get('privacy_toggle', function() {
        auth()->user()->update([
            'private_profile' => auth()->user()->private_profile ? false : true
        ]);
        return success();
    });
    Route::get('privacy_bets_toggle', function() {
        auth()->user()->update([
            'private_bets' => auth()->user()->private_bets ? false : true
        ]);
        return success();
    });
    Route::post('avatar', function(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:50'
        ]);

        $path = auth()->user()->_id.time();
        $request->image->move(public_path('img/avatars'), $path.'.'.$request->image->getClientOriginalExtension());

        $img = Image::make(public_path('img/avatars/'.$path.'.'.$request->image->getClientOriginalExtension()));
        $img->resize(100, 100);
        $img->encode('jpg', 75);
        $img->save(public_path('img/avatars/'.$path.'.jpg'), 75, 'jpg');

        auth()->user()->update([
            'avatar' => '/img/avatars/'.$path.'.jpg'
        ]);
        return success();
    });
});

Route::middleware('auth')->prefix('chat')->group(function() {
    Route::middleware('moderator')->prefix('moderate')->group(function() {
        Route::post('/removeAllFrom', function(Request $request) {
            $messages = \App\Chat::where('user', 'like', "%{$request->id}%")->get();
            \App\Chat::where('user', 'like', "%{$request->id}%")->update([
                'deleted' => true
            ]);

            $ids = [];
            foreach ($messages as $message) array_push($ids, $message->_id);
            event(new \App\Events\ChatRemoveMessages($ids));
            (new \App\ActivityLog\ChatClearLog())->insert(['type' => 'all', 'id' => $message->user['_id']]);
            return success($ids);
        });
        Route::post('/removeMessage', function(Request $request) {
            $message = \App\Chat::where('_id', $request->id)->first();
            $message->update([
                'deleted' => true
            ]);
            event(new \App\Events\ChatRemoveMessages([$request->id]));
            (new \App\ActivityLog\ChatClearLog())->insert(['type' => 'one', 'message' => $message->data, 'id' => $message->user['_id']]);
            return success();
        });
        Route::post('/mute', function(Request $request) {
            \App\User::where('_id', $request->id)->update([
                'mute' => \Carbon\Carbon::now()->addMinutes($request->minutes)->format('Y-m-d H:i:s')
            ]);
            (new \App\ActivityLog\MuteLog())->insert(['id' => $request->id, 'minutes' => $request->minutes]);
            return success();
        });
    });

    Route::post('tip', function(Request $request) {
        if(auth()->user()->access() !== 'admin') return reject(2); 
        $user = User::where('name', 'like', str_replace('.', '', $request->user).'%')->first();
        if($user == null || $user->name === auth()->user()->name) return reject(1);
        if(floatval($request->amount) < floatval(auth()->user()->clientCurrency()->option('quiz')) || auth()->user()->balance(auth()->user()->clientCurrency())->get() < floatval($request->amount)) return reject(2);
        auth()->user()->balance(auth()->user()->clientCurrency())->subtract(floatval($request->amount), \App\Transaction::builder()->message('Tip to '.$user->_id)->get());
        $user->balance(auth()->user()->clientCurrency())->add(floatval($request->amount), \App\Transaction::builder()->message('Tip from '.auth()->user()->_id)->get());
        $user->notify(new \App\Notifications\TipNotification(auth()->user(), auth()->user()->clientCurrency(), number_format(floatval($request->amount), 8, '.', '')));
        if(filter_var($request->public, FILTER_VALIDATE_BOOLEAN)) {
            $message = Chat::create([
                'data' => [
                    'to' => $user->toArray(),
                    'from' => auth()->user()->toArray(),
                    'amount' => number_format(floatval($request->amount), 8, '.', ''),
                    'currency' => auth()->user()->clientCurrency()->id()
                ],
                'type' => 'tip'
            ]);

            event(new ChatMessage($message));
        }
        return success();
    });

    Route::post('rain', function(Request $request) {
        $usersLength = intval($request->users);
        if($usersLength < 1 || $usersLength > 25) return reject(1, 'Invalid users length');
        if(auth()->user()->access = 'user') return reject(2, 'Not available');
        if(auth()->user()->balance(auth()->user()->clientCurrency())->get() < floatval($request->amount) || floatval($request->amount) < floatval(auth()->user()->clientCurrency()->option('rain')) / 3) return reject(2);
        auth()->user()->balance(auth()->user()->clientCurrency())->subtract(floatval($request->amount), \App\Transaction::builder()->message('Rain')->get());

        $all = \App\ActivityLog\ActivityLogEntry::onlineUsers()->toArray();
        if(count($all) < $usersLength) {
            $a = User::get()->toArray();
            shuffle($a);
            $all += $a;
        }

        shuffle($all);

        $dub = []; $users = [];
        foreach ($all as $user) {
            $user = User::where('_id', $user['_id'])->first();
            if($user['_id'] == auth()->user()->_id || $user == null || in_array($user['_id'], $dub)) continue;
            array_push($dub, $user['_id']);
            array_push($users, $user);
        }

        $users = array_slice($users, 0, $usersLength);
        $result = [];

        foreach ($users as $user) {
            $user->balance(auth()->user()->clientCurrency())->add(floatval($request->amount) / $usersLength, \App\Transaction::builder()->message('Rain')->get());
            array_push($result, $user->toArray());
        }

        $message = Chat::create([
            'data' => [
                'users' => $result,
                'reward' => floatval($request->amount) / $usersLength,
                'currency' => auth()->user()->clientCurrency()->id(),
                'from' => auth()->user()->toArray()
            ],
            'type' => 'rain'
        ]);

        event(new ChatMessage($message));
        return success();
    });
    Route::post('link_game', function(Request $request) {
        if(auth()->user()->mute != null && !auth()->user()->mute->isPast()) return reject(2, 'Banned');

        $game = \App\Game::where('_id', $request->id)->first();
        if($game == null) return reject(1, 'Invalid game id');
        if($game->status === 'in-progress' || $game->status === 'cancelled') return reject(2, 'Tried to link unfinished extended game');

        $message = \App\Chat::create([
            'user' => auth()->user()->toArray(),
            'vipLevel' => auth()->user()->vipLevel(),
            'data' => array_merge($game->toArray(), ['icon' => Game::find($game->game)->metadata()->icon()]),
            'type' => 'game_link'
        ]);

        event(new \App\Events\ChatMessage($message));
        return success([]);
    });
});


Route::middleware('auth')->prefix('promocode')->group(function() {
    Route::post('activate', function() {
        $user = auth()->user();
        $promocode = \App\Promocode::where('code', \request()->get('code'))->first();
        $same_register_hash = \App\User::where('register_multiaccount_hash', $user->register_multiaccount_hash)->get();
        $same_login_hash = \App\User::where('login_multiaccount_hash', $user->login_multiaccount_hash)->get();
        $same_register_ip = \App\User::where('register_ip', $user->register_ip)->get();
        $same_login_ip = \App\User::where('login_ip', $user->login_ip)->get();

        if($promocode == null) return reject(1, 'Invalid promocode');
        if(count($same_login_hash) > 6) return reject(3, 'Expired (usages)');
        if(count($same_register_hash) > 6) return reject(3, 'Expired (usages)');
        if($user->register_multiaccount_hash == null || $user->login_multiaccount_hash == null) return reject(3, 'Expired (usages)');
        if($promocode->expires->timestamp != \Carbon\Carbon::minValue()->timestamp && $promocode->expires->isPast()) return reject(2, 'Expired (time)');
        if($promocode->usages != -1 && $promocode->times_used >= $promocode->usages) return reject(3, 'Expired (usages)');
        $created_user = \Carbon\Carbon::parse($user->created_at);
        $created_promo = \Carbon\Carbon::parse($promocode->created_at);
        if($promocode->check_date == 1) {
            if($created_promo->lt($created_user)) return reject(8, 'You cannot use this promo code');
        }
        if($promocode->check_reg > 0) {
            if((\Carbon\Carbon::now()->subMinutes($promocode->check_reg))->lt($created_user)) return reject(9, 'Wait before using this promo');
        }
        if(($promocode->vip ?? false) && auth()->user()->vipLevel() == 0) return reject(7, 'VIP only');
        if(in_array(auth()->user()->_id, $promocode->used)) return reject(4, 'Already activated');

        if(auth()->user()->vipLevel() < 3 || ($promocode->vip ?? false) == false) {
            if (auth()->user()->promocode_limit_reset == null || auth()->user()->promocode_limit_reset->isPast()) {
                auth()->user()->update([
                    'promocode_limit_reset' => \Carbon\Carbon::now()->addHours(auth()->user()->vipLevel() >= 5 ? 12 : 24)->format('Y-m-d H:i:s'),
                    'promocode_limit' => 0
                ]);
            }
            if (auth()->user()->promocode_limit != null && auth()->user()->promocode_limit >= (auth()->user()->vipLevel() >= 8 ? 16 : 8)) return reject(5, 'Promocode timeout');
        }
        if(auth()->user()->vipLevel() < 3 || ($promocode->vip ?? false) == false) {
            auth()->user()->update([
                'promocode_limit' => auth()->user()->promocode_limit == null ? 1 : auth()->user()->promocode_limit + 1
            ]);
        }

        $used = $promocode->used;
        array_push($used, auth()->user()->_id);
        $promocode->update([
            'times_used' => $promocode->times_used + 1,
            'used' => $used
        ]);
        if($promocode->currency != 'freespin') {
        $base = $promocode->sum;
        $vipbronze = round($base * 1.25,0);
        $vipabove = round($base * 1.5,0);

        if(auth()->user()->vipLevel() == 0) {
        auth()->user()->balance(Currency::find($promocode->currency))->add($base, \App\Transaction::builder()->message('Promocode crypto (base)')->get());
    }
        if(auth()->user()->vipLevel() == 1) {
        auth()->user()->balance(Currency::find($promocode->currency))->add($base, \App\Transaction::builder()->message('Promocode crypto (emerald)')->get());
        }
        if(auth()->user()->vipLevel() == 2) {
        auth()->user()->balance(Currency::find($promocode->currency))->add($vipbronze, \App\Transaction::builder()->message('Promocode crypto (ruby)')->get());
        }
        if(auth()->user()->vipLevel() > 2) {
        auth()->user()->balance(Currency::find($promocode->currency))->add($vipabove, \App\Transaction::builder()->message('Promocode crypto (gold and above')->get());
        }
        }
        if($promocode->currency == 'freespin') {
        $base = $promocode->sum;
        $vipbronze = round($base * 1.25, 0);
        $vipabove = round($base * 1.5, 0);

        if(auth()->user()->vipLevel() == 0) {
        auth()->user()->freegames = auth()->user()->freegames + $base;
        auth()->user()->save();
        }
        if(auth()->user()->vipLevel() == 1) {
        auth()->user()->freegames = auth()->user()->freegames + $base;
        auth()->user()->save();
        }

        if(auth()->user()->vipLevel() == 2) {
        auth()->user()->freegames = auth()->user()->freegames + $vipbronze;
        auth()->user()->save();
        }

        if(auth()->user()->vipLevel() > 2) {
        auth()->user()->freegames = auth()->user()->freegames + $vipabove;
        auth()->user()->save();
        }

        }
        return success();
    });

    Route::post('demo', function() {
        if(auth()->user()->balance(auth()->user()->clientCurrency())->demo()->get() > 0.00000001) return reject(1, 'Demo balance is higher than zero');
        auth()->user()->balance(auth()->user()->clientCurrency())->demo()->add(auth()->user()->clientCurrency()->option('demo'), \App\Transaction::builder()->message('Demo')->get());
        return success();
    });

    Route::post('partner_bonus', function() {
        if(count(auth()->user()->referral_wager_obtainer ?? []) < 10 || count(auth()->user()->referral_wager_obtained ?? []) < ((auth()->user()->referral_bonus_obtained ?? 0) + 1) * 10) return reject(1, 'Not enough referrals');
        $v = floatval(auth()->user()->clientCurrency()->option('referral_bonus_wheel'));
        $slices = [
            $v,
            $v * 1.15,
            $v * 1.3,
            $v * 1.15,
            $v * 1.5,
            $v,
            $v * 2,
            $v,
            $v * 1.15,
            $v * 1.3,
            $v * 1.15,
            $v * 1.5,
            $v,
            $v * 2
        ];
        $slice = mt_rand(0, count($slices) - 1);
       // auth()->user()->balance(auth()->user()->clientCurrency())->add($slices[$slice], \App\Transaction::builder()->message('Referral bonus wheel')->get());
        auth()->user()->update([
            'referral_bonus_obtained' => (auth()->user()->referral_bonus_obtained ?? 0) + 1
        ]);
        return success([
            'slice' => $slice
        ]);
    });

    Route::post('bonus', function(Request $request) {
        $validate = Validator::make($request->all(), [
        'captcha' => 'required|captcha'
        ]); 
        $currency = Currency::find("eth");
        $faucetdollar = \App\Settings::where('name', 'faucet_dollar')->first()->value;
        $faucetamount = number_format(($faucetdollar / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 7, '.', '');
        $faucetvipemerald = \App\Settings::where('name', 'faucet_vipemerald')->first()->value;
        $faucetamountemerald = number_format(($faucetvipemerald / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 7, '.', '');
        $faucetvipruby = \App\Settings::where('name', 'faucet_vipruby')->first()->value;
        $faucetviprubyamount = number_format(($faucetvipruby / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 7, '.', '');
        $faucetvipgoldplus = \App\Settings::where('name', 'faucet_vipgoldandabove')->first()->value;
        $faucetvipgoldplusamount = number_format(($faucetvipgoldplus / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 7, '.', '');
        $faucetmaxmultiplier = \App\Settings::where('name', 'faucetmaxmultiplier')->first()->value;
        $faucetmaxbalance = number_format(($faucetmaxmultiplier * $faucetviprubyamount), 7, '.', '');
        $user = auth()->user();
        $same_register_hash = \App\User::where('register_multiaccount_hash', $user->register_multiaccount_hash)->get();
        $same_login_hash = \App\User::where('login_multiaccount_hash', $user->login_multiaccount_hash)->get();
        $same_register_ip = \App\User::where('register_ip', $user->register_ip)->get();
        $same_login_ip = \App\User::where('login_ip', $user->login_ip)->get();

        if($validate->fails()) return reject(4, 'Please verify that you are not a robot');
        if(auth()->user()->bonus_claim != null && !auth()->user()->bonus_claim->isPast()) return reject(1, 'Please wait before trying again');
        //if(auth()->user()->clientCurrency()->id() != 'doge') return reject(2, 'Balance is greater than zero'); 
        if(auth()->user()->balance($currency)->get() > floatval($faucetmaxbalance)) return reject(2, 'Your ETH balance is too big'); 

        if(count($same_login_hash) > 35) return reject(3, 'Expired (usages)');
        if(count($same_register_hash) > 35) return reject(3, 'Expired (usages)');
        if(count($same_login_ip) > 35) return reject(3, 'Expired (usages)');

        //$progresscheck = \App\Game::where('user', $user)->where('status', 'in-progress')->get();
        //if($progresscheck) return reject(3, 'Game in progress');

        if(auth()->user()->vipLevel() == 0) {

        $v = floatval($faucetamount);
        $slices = [
            $v,
            $v * 1.10,
            $v * 1.3,
            $v * 1.20,
            $v * 1.35,
            $v,
            $v * 1.85,
            $v,
            $v * 1.15,
            $v * 1.3,
            $v * 1.15,
            $v * 1.5,
            $v,
            $v * 1.85
        ];
        $slice = mt_rand(0, count($slices) - 1);
        auth()->user()->balance($currency)->add($slices[$slice], \App\Transaction::builder()->message('Faucet')->get());
        auth()->user()->update([
            'bonus_claim' => \Carbon\Carbon::now()->addMinutes(720)
        ]);

        return success([
            'slice' => $slice,
            'next' => \Carbon\Carbon::now()->addMinutes(720)->timestamp
        ]);
        }

        if(auth()->user()->vipLevel() == 1) {
        $v = floatval($faucetamountemerald);
        $slices = [
            $v,
            $v * 1.10,
            $v * 1.3,
            $v * 1.20,
            $v * 1.35,
            $v,
            $v * 1.85,
            $v,
            $v * 1.15,
            $v * 1.3,
            $v * 1.15,
            $v * 1.5,
            $v,
            $v * 1.85
        ];
        $slice = mt_rand(0, count($slices) - 1);
        auth()->user()->balance($currency)->add($slices[$slice], \App\Transaction::builder()->message('Faucet')->get());
        auth()->user()->update([
            'bonus_claim' => \Carbon\Carbon::now()->addMinutes(720)
        ]);

        return success([
            'slice' => $slice,
            'next' => \Carbon\Carbon::now()->addMinutes(720)->timestamp
        ]);
        }

        if(auth()->user()->vipLevel() == 2) {
        $v = floatval($faucetviprubyamount);
        $slices = [
            $v,
            $v * 1.35,
            $v * 1.15,
            $v * 1.25,
            $v * 1.35,
            $v,
            $v * 2.00,
            $v,
            $v * 1.25,
            $v * 1.30,
            $v * 1.25,
            $v * 1.50,
            $v,
            $v * 1.85
        ];
        $slice = mt_rand(0, count($slices) - 1);
        auth()->user()->balance($currency)->add($slices[$slice], \App\Transaction::builder()->message('Faucet')->get());
        auth()->user()->update([
            'bonus_claim' => \Carbon\Carbon::now()->addMinutes(720)
        ]);

        return success([
            'slice' => $slice,
            'next' => \Carbon\Carbon::now()->addMinutes(720)->timestamp
        ]);
        }

        if(auth()->user()->vipLevel() > 2) {
        $v = floatval($faucetvipgoldplusamount);
        $slices = [
            $v,
            $v * 1.20,
            $v * 1.40,
            $v * 1.20,
            $v * 1.15,
            $v,
            $v * 2.50,
            $v,
            $v * 1.25,
            $v * 1.5,
            $v * 1.25,
            $v * 1.7,
            $v,
            $v * 2.50
        ];
        $slice = mt_rand(0, count($slices) - 1);
        auth()->user()->balance($currency)->add($slices[$slice], \App\Transaction::builder()->message('Faucet')->get());
        auth()->user()->update([
            'bonus_claim' => \Carbon\Carbon::now()->addMinutes(720)
        ]);

        return success([
            'slice' => $slice,
            'next' => \Carbon\Carbon::now()->addMinutes(720)->timestamp
        ]);
        }


    });

    Route::post('vipBonus', function() {
                $currency = Currency::find("eth");

        if(auth()->user()->vipLevel() == 0) return reject(1, 'Invalid VIP level');
        if(auth()->user()->weekly_bonus < 0.1) return reject(2, 'Daily bonus is too small');
        if(auth()->user()->weekly_bonus_obtained) return reject(3, 'Already obtained in this week');
        auth()->user()->balance($currency)->add(((auth()->user()->weekly_bonus ?? 0) / 100) * auth()->user()->vipBonus(), \App\Transaction::builder()->message('Daily VIP bonus')->get());
        auth()->user()->update([
            'weekly_bonus_obtained' => true
        ]);
        return success();
    });
});

Route::middleware('auth')->post('invest', function(Request $request) {
    $amount = floatval($request->amount);
    if($amount < floatval(auth()->user()->clientCurrency()->option('min_invest')) || auth()->user()->balance(auth()->user()->clientCurrency())->get() < $amount) return reject(1);

    \App\Investment::create([
        'user' => auth()->user()->_id,
        'amount' => $amount - ((1 / 100) * $amount),
        'site_bankroll' =>  \App\Investment::where('status', 0)->where('currency', auth()->user()->clientCurrency()->id())->sum('amount') + $amount,
        'status' => 0,
        'currency' => auth()->user()->clientCurrency()->id()
    ]);

    auth()->user()->balance(auth()->user()->clientCurrency())->subtract($amount, \App\Transaction::builder()->message('Invest')->get());
    return success();
});

Route::middleware('auth')->post('disinvest', function(Request $request) {
    $investment = \App\Investment::where('_id', $request->id)->first();
    if($investment == null || $investment->status != 0) return reject(1);

    $investment->update([
        'disinvest_profit' => $investment->getProfit(),
        'disinvest_share' => $investment->getShare(),
        'status' => 1
    ]);

    $currency = Currency::find($investment->currency);
    $profit = $investment->getProfit();
    $profit = $profit <= 0 ? $profit : $profit - ((intval($currency->option('invest_commission')) / 100) * $profit);
    if($profit <= 0) return reject(2);

    auth()->user()->balance($currency)->add($profit, \App\Transaction::builder()->message('Disinvest')->get());
    return success();
});

/**
 * Rejects API call.
 * @param int $code Unique to caller function error code
 * @param string $description Error description. It's not visible for the user, but should be visible in console.
 * @return array Formatted route response
 */
function reject(int $code, string $description = 'Unknown error description') {
    return ['error' => [$code, $description]];
}

/**
 * Accepts API call.
 * @param array $response Response
 * @return array Formatted route response
 */
function success(array $response = []) {
    return ['response' => $response];
}
