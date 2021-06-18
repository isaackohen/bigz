<?php namespace App\Events;

use App\Currency\Currency;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepositCredited implements ShouldBroadcastNow {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn() {
        return new PrivateChannel('App.User.'.$this->user->id);
    }

    public function broadcastWith() {
        return [
        ];
    }

}
