@php
    $game = \App\Games\Kernel\Game::find($data);
    if($game == null || $game->isDisabled()) {

    if($get = \App\Slotslist::get()->where('id', $data)->first()) {
    $slotuid = ($get->UID);
    header("Location:/game/slot/".$slotuid);
    }
    else {
    
    header("Location:/game/slot/".$data);
       
    }

        die();
    }
@endphp
          @if(auth()->guest())
                    <div style="margin-top: 60px;"></div>
            @endif
<div class="container-lg" id="gamecontainer">
    <div class="game-container mt-1">
	    <div class="game-container-options">
    </div>
        <div class="row">
            <div class="col {{-- d-none d-md-block --}}">
                <div class="game-sidebar"></div>
            </div>
            <div class="col">
                <div class="game-content"></div>
            </div>
        </div>
		@php
		if(\App\Settings::where('name', 'bigprofit_inhouse_game_'.$data)->first() !== null && \App\Settings::where('name', 'bigmul_inhouse_game_'.$data)->first() !== null){
			$notstated = false;
			$bestProfit = json_decode(\App\Settings::where('name', 'bigprofit_inhouse_game_'.$data)->first()->value);
			$bestMul = json_decode(\App\Settings::where('name', 'bigmul_inhouse_game_'.$data)->first()->value);
			if($bestProfit[2] == 'btc') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarBtc()), 2, '.', '');
			} else if($bestProfit[2] == 'eth') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarEth()), 2, '.', '');
			} else if($bestProfit[2] == 'ltc') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarLtc()), 2, '.', '');
			} else if($bestProfit[2] == 'matic') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarMatic()), 2, '.', '');
			} else if($bestProfit[2] == 'usdt') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarUsdt()), 2, '.', '');
			} else if($bestProfit[2] == 'bch') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarBtcCash()), 2, '.', '');
			} else if($bestProfit[2] == 'trx') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarTron()), 2, '.', '');
			} else if($bestProfit[2] == 'xrp') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarXrp()), 2, '.', '');
			} else if($bestProfit[2] == 'doge') {
			$bestProfitByCurrency = ($_COOKIE['unit'] ?? 'none') == 'disabled' ? number_format(floatval($bestProfit[0]), 8, '.', '')  : '$'.number_format(($bestProfit[0] * \App\Http\Controllers\Api\WalletController::rateDollarDoge()), 2, '.', '');
			}
		} else {
			$notstated = true;
		}
		@endphp
		@if($notstated == false)
		<div class="best-container">
			<div class="best-collapse">
				<div class="collapse-header">
					<div class="best-caption">{{ $data }} − <span>Super wins</span></div>
					<div class="best-users">
						<div href="javascript:void(0)" onclick="$.overview('{{ $bestProfit[3] }}', '{{ $data }}')" class="best-user">
							<img src="/img/misc/cup.svg" alt="">
							{{ $bestProfit[1] }}
							<span class="best-user-bet">
								<span class="best-user-wager">{{ $bestProfitByCurrency }}</span><span class="best-bet-icon"><img src="/img/currency/svg/{{ $bestProfit[2] }}.svg"></span>
							</span>
						</div>
						<div href="javascript:void(0)" onclick="$.overview('{{ $bestMul[2] }}', '{{ $data }}')" class="best-user hide-small"><img src="/img/misc/cup.svg" alt="">{{ $bestMul[1] }}<span class="best-user-coeff">{{ $bestMul[0] }}x</span></div>
					</div>
				</div>
			</div>
		</div>
		@endif
 </div>
 </div>

@if(!auth()->guest())
    @php $latest_game = \App\Game::latest()->where('game', $data)->where('user', auth()->user()->_id)->where('status', 'in-progress')->first(); @endphp
    @if(!is_null($latest_game))
        <script type="text/javascript">
            window.restoreGame = {
                'game': {!! json_encode($latest_game->makeHidden('server_seed')->makeHidden('nonce')->makeHidden('data')->toArray()) !!},
                'history': {!! json_encode($latest_game->data['history']) !!},
                'user_data': {!! json_encode($latest_game->data['user_data']) !!}
            };
        </script>
    @else
        <script type="text/javascript">
            window.restoreGame = undefined;
        </script>
    @endif
		<script type="text/javascript">
            window.ingame = true;
        </script>
@endif

 