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


class Bigwinner extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datagamble:bigwinner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send bigwinner to Telegram channel';

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
        $cronenabled = floatval(Settings::where('name', 'tg_bigwinner_cron')->first()->value);
        if($cronenabled == '1') {

        $bigwinner_player = \App\Settings::where('name', 'bigwinner_player')->first()->value;
        $bigwinner_slot = \App\Settings::where('name', 'bigwinner_slot')->first()->value;
        $bigwinner_amount = \App\Settings::where('name', 'bigwinner_amount')->first()->value;
        $bigwinner_multi = \App\Settings::where('name', 'bigwinner_multi')->first()->value;
        $bigwinner_gamevuid = \App\Settings::where('name', 'bigwinner_gamevuid')->first()->value;
        $bigwinner_historyid = \App\Settings::where('name', 'bigwinner_historyid')->first()->value;


       
        $bigwinner_game = \App\Settings::where('name', 'bigwinner_game')->first()->value;

        $inlinemessage = $bigwinner_player.' just hit '.$bigwinner_slot.' with a '.$bigwinner_multi.'x multiplier for '.$bigwinner_amount.'$ profit.';
        $bot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));

        $message = $bot->sendPhoto([
            'chat_id' => -1001199743876,
                'photo' => 'https://bigz.imgix.net/i/tgthumb/'.$bigwinner_game.'.webp?shad=2&blur=40&chromasub=444&fm=png&auto=enhance&usm=-60&exp=-6&mark=https%3A%2F%2Fassets.imgix.net%2F~text%3Ftxtclr%3Dfff%26q%3D100%26fm%3Dpng%26txt%3D'.$inlinemessage.'%2B%26w%3D500%26txtsize%3D24%26txtlead%3D0%26txtpad%3D30%26bg%3D55010a0d%26txtfont%3DAvenir-Medium&markalign=center%2Cmiddle&txtalign=center&txtclr=d2d9dc&txtsize=18&txtpad=40&markscale=90&q=90&fit=crop&w=410&h=200&ixlib=js-2.0.0&s=dc591beb29755d2228f129c7a6770f17',
                'reply_markup' => [
                    'inline_keyboard' => [[[
                    'text' => 'Play '.$bigwinner_slot.' @ BIGZ.IO',
                    'url' => 'https://bigz.io/game/slot/'.$bigwinner_gamevuid.'/'
                ]]]
            ]
        ]);
                Settings::where('name', 'tg_bigwinner_cron')->update(['value' => 0]);
                Settings::where('name', 'toast_message')->update(['value' => $inlinemessage]);
                
                event(new \App\Events\UserNotification());


    }
}
}





