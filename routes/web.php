<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokerApi;
use App\PokerSessions;


Route::post('partner_cashout', function() {
        $user = auth()->user();
        $currency = 'eth';
        $balanceusd = number_format(floatval("$user->referral_balance_usd"), 2);
        $ethvalue = $balanceusd / \App\Http\Controllers\Api\WalletController::rateDollarEth();
        if($balanceusd < 3) return reject(1, 'Minimum 3 dollar before you can cashout');
        $user->balance(\App\Currency\Currency::find($currency))->add($ethvalue, \App\Transaction::builder()->message('Referral Payout')->get()); 
        $user->update([
            'referral_balance_usd' => 0
        ]);
    });


Route::get('/pokerclient/', function() {
function array_value_recursive($key, array $arr){
    $val = array();
    array_walk_recursive($arr, function($v, $k) use($key, &$val){
        if($k == $key) array_push($val, $v);
    });
    return count($val) > 1 ? $val : array_pop($val);
}

    $login = auth()->user()->name;
    $user = auth()->user()->id;

    $now = \Carbon\Carbon::now()->timestamp;
    $last3minute = \Carbon\Carbon::now()->subMinutes(1)->timestamp;
    $pokersession = (\App\PokerSessions::orderBy('time', 'desc')->where('user', $user)->where('time', '>=', $last3minute)->first());

    if($pokersession) {
        $link = ($pokersession->session);
} else {


    $api = new PokerApi(123, 'lkq9b2br-w8oy-01oy-qgtv-48a09v8sz91a', '217.182.195.96', 4000);
    $api->connect();
    $getRunLink = $api->getRunLink($login); 
    //      $linkarray = var_export($getRunLink, true);
   //$link = json_encode($getRunLink);

        $link = $getRunLink['uogetuserrunlink']['@attributes']['runlink'];
        $explode = explode('/', $link);
        $link = 'https://poker.bigz.io/alogin/'.$explode[4].'/';
 
                     \App\PokerSessions::create([
                    'session' => $link, 'time' => $now, 'user' => $user
                    ]);


        Log::notice($getRunLink);
        Log::notice($link);
        //echo '<META HTTP-EQUIV=REFRESH CONTENT="0; '.$link.'">';
}

        $view = view('pokerplayer')->with('url', $link);
        return view('layouts.app')->with('page', $view);

    });

Route::get('/live/{game}', 'LivecasinoController@game');


Route::get('/live/{game}', 'LivecasinoController@game');

 
Route::get('/game/slot/{game}', 'C27Controller@game');
Route::get('/provider/{provider}', 'C27Controller@provider');
Route::get('/game/slot/evoplay/{game}', 'EvoController@game')->name('evoplay');
Route::get('/evoplayapi/list', 'EvoController@list');

Route::group(['prefix' => '/', 'middleware' => 'throttle:360,1'], function() {

Route::get('avatar/{hash}', 'MainController@avatar')->name('avatar');
Route::get('/lang/{locale}', 'MainController@locale');
Route::get('/{page?}/{data?}', 'MainController@main');

});
 