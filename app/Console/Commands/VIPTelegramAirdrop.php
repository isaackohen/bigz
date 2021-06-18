<?php

namespace App\Console\Commands;

use App\Notifications\DiscordPromocode;
use App\Notifications\DiscordVipPromocode;
use App\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\Facades\Image;
use WeStacks\TeleBot\Laravel\TelegramNotification;
use WeStacks\TeleBot\TeleBot;


class VIPTelegramAirdrop extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datagamble:VIPTelegramAirdrop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send VIP promocode to Telegram channel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $dollaramount = floatval(Settings::where('name', 'vip_promo_dollar_celebrate')->first()->value);
        $sum = number_format(($dollaramount / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 7, '.', '');
        $usages = intval(Settings::where('name', 'vip_promo_dollar_celebrate_usage')->first()->value);
        $tg_msg = (Settings::where('name', 'tg_msg')->first()->value);
        $promocode = \App\Promocode::create([
            'code' => \App\Promocode::generate(),
            'used' => [],
            'sum' => $sum,
            'usages' => $usages,
            'currency' => 'ltc',
            'times_used' => 0,
            'expires' => \Carbon\Carbon::now()->addHours(1),
            'vip' => true
        ]);

        $bot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        // See docs for details:  https://core.telegram.org/bots/api#sendmessage

        $message = $bot->sendMessage([
            'chat_id' => -1001199743876,
            'text' => 'Woohoo! "'.$tg_msg.'" has just reached first VIP Level. "'.$tg_msg.'" has been rewarded 15 Free Spins. To celebrate within community, airdropping '.$dollaramount.'$ for VIP players within next 5 minutes.',
            'reply_markup' => [
                    'inline_keyboard' => [[[
                    'text' => 'VIP Program Information',
                    'url' => 'https://bigz.io/bonus/'
                ]]]
            ]
        ]);



        Settings::where('name', 'tg_cron')->update(['value' => 1]);


    }

}
