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

        // See docs for details:  https://core.telegram.org/bots/api#sendmessage
        $message = $bot->sendMessage([
            'chat_id' => -1001199743876,
            'text' => 'Congratz to '.$bigwinner_player.' on our in-house '.$bigwinner_game.' game, with a whopping '.$bigwinner_multi.'x multiplier with a '.$bigwinner_amount.'$ wager',
            'reply_markup' => [
                    'inline_keyboard' => [[[
                    'text' => 'Play '.$bigwinner_game,
                    'url' => 'https://loff.io/game/'.$bigwinner_game.'/'                
                ]]]
            ]
        ]);
            Settings::where('name', 'tg_bigwinner_cron')->update(['value' => 0]);
    }
    }

}
