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
 
        $inlinemessage = $tg_msg.' has just reached first VIP Level.%0A%0A'.$tg_msg.' has been rewarded 15 Free Spins. To celebrate, VIPDROP for '.$dollaramount.'$ starting next 5 minutes.';
        $toastmessage = $tg_msg.' has just reached first VIP Level and has received 15 free spins. Check Bonus Page for more information.';


        $bot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        // See docs for details:  https://core.telegram.org/bots/api#sendmessage
        $message = $bot->sendPhoto([
            'chat_id' => -1001575847632,
                'photo' => 'https://bigz.imgix.net/i/tgthumb/vip/newvip-min.jpg?shad=2&blur=20&chromasub=444&fm=png&auto=enhance&usm=-60&exp=-6&mark=https%3A%2F%2Fassets.imgix.net%2F~text%3Ftxtclr%3Dfff%26q%3D100%26fm%3Dpng%26txt%3D'.$inlinemessage.'%2B%26w%3D500%26txtsize%3D22%26txtlead%3D0%26txtpad%3D30%26bg%3D55010a0d%26txtfont%3DAvenir-Medium&markalign=center%2Cmiddle&txtalign=center&txtclr=d2d9dc&txtsize=0.98&txtpad=40&markscale=90&q=90&fit=crop&w=410&h=200&ixlib=js-2.0.0&s=dc591beb29755d2228f129c7a6770f17',
                'reply_markup' => [
                    'inline_keyboard' => [[[
                    'text' => 'VIP Program Information',
                    'url' => 'https://bigz.io/bonus/'
                ]]]
            ]
        ]);





        Settings::where('name', 'tg_cron')->update(['value' => 1]);
        Settings::where('name', 'toast_message')->update(['value' => $toastmessage]);
        event(new \App\Events\NewVIPNotification());

    }

}
