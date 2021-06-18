<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class WalletReset extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datagamble:walletreset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset assigned wallet addresses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        User::query()->update([
            'wallet_eth' => null,
            'wallet_btc' => null,
            'wallet_ltc' => null,
            'wallet_doge' => null,
            'wallet_xrp' => null,
            'wallet_bnb' => null,
            'wallet_usdc' => null,
            'wallet_usdt' => null,
            'wallet_trx' => null,
            'wallet_bch' => null
        ]);
    }
}
