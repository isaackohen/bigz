<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class LivecasinoTransaction extends Model {

    protected $collection = 'live_casino_transactions';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user', 'balance', 'bet', 'newbalance', 'result', 'status', 'gameId'
    ];

    protected $casts = [
        'data' => 'json'
    ];

}
