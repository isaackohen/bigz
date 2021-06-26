

<?php namespace App\Events;

use WeStacks\TeleBot\Handlers\CommandHandler;
use WeStacks\TeleBot\Laravel\TelegramNotification;
use WeStacks\TeleBot\TeleBot;

class StartCommand extends CommandHandler
{
    protected static $aliases = [ '/start', '/s' ];
    protected static $description = 'Send "/start" or "/s" to get "Hello, World!"';

    public function handle()
    {
        $this->sendMessage([
            'text' => 'Hello, World!'
        ]);
    }
} 