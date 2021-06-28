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


class SendTelegramPromocode extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datagamble:SendTelegramPromocode';

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
        $dollaramount = floatval(Settings::where('name', 'promo_dollar')->first()->value);
        $sum = number_format(($dollaramount / \App\Http\Controllers\Api\WalletController::rateDollarEth()), 7, '.', '');
        $usages = intval(Settings::where('name', 'vip_promo_usages')->first()->value);

        $promocode = \App\Promocode::create([
            'code' => \App\Promocode::generate(),
            'used' => [],
            'sum' => $sum,
            'usages' => $usages,
            'currency' => 'eth',
            'times_used' => 0,
            'expires' => \Carbon\Carbon::now()->addHours(1),
            'vip' => false
        ]);


        $bot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));

        $inlinemessage = 'DROPCODE for '.$promocode->sum.' ETH: '.$promocode->code.' - '.$promocode->usages.' uses.';

        $message = $bot->sendPhoto([
            'chat_id' => -1001575847632,
                'photo' => 'https://bigz.imgix.net/i/tgthumb/dropz/dropz-2.png?shad=1&blur=0&chromasub=444&fm=png&auto=enhance&usm=-60&exp=-1&mark=https%3A%2F%2Fassets.imgix.net%2F~text%3Ftxtclr%3Dfff%26q%3D100%26fm%3Dpng%26txt%3D'.$inlinemessage.'%2B%26w%3D500%26txtsize%3D24%26txtlead%3D0%26txtpad%3D30%26bg%3D55010a0d%26txtfont%3DAvenir-Medium&markalign=center%2Cbottom&txtalign=center&txtclr=d2d9dc&txtsize=17&txtpad=30&markscale=80&q=100&fit=crop&w=410&h=160&ixlib=js-2.0.0&s=dc591beb29755d2228f129c7a6770f17',
                'reply_markup' => [
                    'inline_keyboard' => [[[
                    'text' => 'Enter DROPCODE @ BIGZ.IO',
                    'url' => 'https://bigz.io/bonus/'
                ]]]
            ]
        ]);
        event(new \App\Events\PromoNotification());


    }

}

