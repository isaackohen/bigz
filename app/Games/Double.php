<?php namespace App\Games;

use App\Events\MultiplayerTimerStart;
use App\Games\Kernel\Data;
use App\Games\Kernel\Game;
use App\Games\Kernel\GameCategory;
use App\Games\Kernel\Metadata;
use App\Games\Kernel\Multiplayer\MultiplayerGame;
use App\Games\Kernel\ProvablyFair;
use App\Games\Kernel\ProvablyFairResult;
use App\Jobs\MultiplayerDisableBetAccepting;
use App\Jobs\MultiplayerFinishAndSetupNextGame;
use App\Jobs\MultiplayerUpdateData;
use App\Jobs\MultiplayerUpdateTimestamp;
use Illuminate\Support\Facades\Log;

class Double extends MultiplayerGame {

    function metadata(): Metadata {
        return new class extends Metadata {
            function id(): string {
                return "double";
            }

            function name(): string {
                return "Double";
            }

            function icon(): string {
                return "fas fa-coin";
            }
        };
    }

    protected function getPlayerData(\App\Game $game): array { 
        return ['target' => $this->userData($game)['data']['target']];
    }

    public function nextGame() {
        $this->state()->resetPlayers();
        $this->state()->clientSeed(ProvablyFair::generateServerSeed());
        $this->state()->serverSeed(ProvablyFair::generateServerSeed());
        $this->state()->nonce(now()->timestamp);
        $this->state()->timestamp(now()->timestamp);
        $result = (new ProvablyFair($this, $this->server_seed()))->result()->result()[0];
        $this->state()->betting(true);

        $data = [
            'index' => $result
        ];

        dispatch((new MultiplayerDisableBetAccepting($this))->delay(now()->addSeconds(6)));
        dispatch((new MultiplayerUpdateData($this, $data))->delay(now()->addSeconds(6)));
        dispatch((new MultiplayerUpdateTimestamp($this, -1))->delay(now()->addSeconds(6)));

        event(new MultiplayerTimerStart($this));

        dispatch((new MultiplayerFinishAndSetupNextGame($this, $data, now()->addSeconds(12)))->delay(6));
    }

    public function onDispatchedFinish() {
        $current = (new ProvablyFair($this, $this->server_seed()))->result()->result()[0];
		$numbers = [1, 14, 2, 13, 3, 12, 4, 0, 11, 5, 10, 6, 9, 7, 8];
		$multipliercolor = null;
		$multiplier = 0;
		if($numbers[0] == $current || $numbers[2] == $current || $numbers[4] == $current || $numbers[6] == $current || $numbers[9] == $current || $numbers[11] == $current || $numbers[13] == $current) { $multipliercolor = 'red'; $multiplierset = 2.00; }
		if($numbers[1] == $current || $numbers[3] == $current || $numbers[5] == $current || $numbers[8] == $current || $numbers[10] == $current || $numbers[12] == $current || $numbers[14] == $current) { $multipliercolor = 'black'; $multiplierset = 2.00; }
       if($numbers[7] == $current) { $multipliercolor = 'green'; $multiplierset = 14.00; }
	   $this->state()->history([
			'server_seed' => $this->server_seed(),
            'client_seed' => $this->client_seed(),
            'nonce' => $this->nonce(),
            'color' => $current
        ]);

        foreach($this->getActiveGames() as $game) {
            $color = $this->userData($game)['data']['target'];
			if($multipliercolor == $color) $multiplier = $multiplierset;
            $this->win($game, $multiplier, 6000);
        }
    }

    public function startChain() {
        dispatch(new MultiplayerFinishAndSetupNextGame($this, [
            'index' => 0
        ], now()));
    }

    function result(ProvablyFairResult $result): array {
        return [
            floor($result->extractFloat() * 15)
        ];
    }

}
