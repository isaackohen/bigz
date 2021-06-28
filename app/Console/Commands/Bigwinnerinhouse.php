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


class Bigwinnerinhouse extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datagamble:bigwinnerinhouse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send bigwinnerinhouse to Telegram channel';

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
        $cronenabled = floatval(Settings::where('name', 'tg_bigwinner_inhouse_cron')->first()->value);
        if($cronenabled == '1') {

        $bigwinner_player = \App\Settings::where('name', 'bigwinner_inhouse_player')->first()->value;
        $bigwinner_game = \App\Settings::where('name', 'bigwinner_inhouse_game')->first()->value;
        $bigwinner_amount = \App\Settings::where('name', 'bigwinner_inhouse_amount')->first()->value;
        $bigwinner_multi = \App\Settings::where('name', 'bigwinner_inhouse_multi')->first()->value;

 
        $bot = new TeleBot(env('TELEGRAM_BOT_TOKEN'));
        $inlinemessage = 'BIG MULTIPLIER WIN!%0A%0A'.$bigwinner_player.' got '.$bigwinner_multi.'x multiplier on '.$bigwinner_game.' with a '.$bigwinner_amount.'$ wager.';
        $toastmessage = 'Big multiplier win! '.$bigwinner_player.' got '.$bigwinner_multi.'x multiplier on '.$bigwinner_game.' with a '.$bigwinner_amount.'$ wager.';


        $message = $bot->sendPhoto([
            'chat_id' => -1001575847632,
                'photo' => 'https://bigz.imgix.net/i/tgthumb/inhouse/inhouse'.rand(1, 4).'.jpg?shad=-5&blur=29&chromasub=444&fm=png&auto=enhance&usm=50&exp=-9&mark=https%3A%2F%2Fassets.imgix.net%2F~text%3Ftxtclr%3Dfff%26q%3D100%26fm%3Dpng%26txt%3D'.$inlinemessage.'%2B%26w%3D500%26txtsize%3D23%26txtlead%3D0%26txtpad%3D25%26bg%3D55010a0d%26txtfont%3DAvenir-Heavy&markalign=center%2Cmiddle&txtalign=center&txtclr=d2d9dc&txtsize=18&txtpad=40&markscale=90&q=90&fit=crop&w=410&h=150&ixlib=js-2.0.0&s=dc591beb29755d2228f129c7a6770f17',
                'reply_markup' => [
                    'inline_keyboard' => [[[
                    'text' => 'Play '.$bigwinner_game.' @ BIGZ.IO',
                    'url' => 'https://bigz.io/game/slot/'.$bigwinner_game.'/'
                ]]]
            ]
        ]);

            Settings::where('name', 'tg_bigwinner_inhouse_cron')->update(['value' => 0]);
            Settings::where('name', 'toast_message')->update(['value' => $toastmessage]);
                
            event(new \App\Events\BigwinNotification());
    }
    }

}
