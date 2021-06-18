<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Statistics extends Model
{
	
	    protected $connection = 'mongodb';
		protected $collection = 'user_statistics';
		    
		protected $fillable = [
            '_id', 'bets_btc', 'wins_btc', 'loss_btc', 'wagered_btc', 'profit_btc', 'bets_eth', 'wins_eth', 'loss_eth', 'wagered_eth', 'profit_eth', 'bets_ltc', 'wins_ltc', 'loss_ltc', 'wagered_ltc', 'profit_ltc', 'bets_doge', 'wins_doge', 'loss_doge', 'wagered_doge', 'profit_doge', 'bets_bch', 'wins_bch', 'loss_bch', 'wagered_bch', 'profit_bch', 'bets_trx', 'wins_trx', 'loss_trx', 'wagered_trx', 'profit_trx', 'bets_xrp', 'wins_xrp', 'loss_xrp', 'wagered_xrp', 'profit_xrp', 'bets_bnb', 'wins_bnb', 'loss_bnb', 'wagered_bnb', 'profit_bnb', 'bets_usdt', 'wins_usdt', 'loss_usdt', 'wagered_usdt', 'profit_usdt', 'bets_usdc', 'wins_usdc', 'loss_usdc', 'wagered_usdc', 'profit_usdc', 'bets_bonus', 'wins_bonus', 'loss_bonus', 'wagered_bonus', 'profit_bonus'
		];
}
