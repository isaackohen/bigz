@if(!isset($_GET['user']))
<div class="userinfo modal fade" id="userinfo modal" tabindex="-1" style="display: block; padding-right: 15px;" aria-labelledby="userinfo modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">User
        <button
          type="button"
          data-mdb-dismiss="userinfo modal"
                class="btn-secondary btn-close"
                ><i class="fas fa-close-symbol"></i></button>
      </div>
      <div class="modal-body" style="min-height:600px;overflow-x:hidden;">
	  <div class="ui-blocker" style="display: none;">
            <div class="loader"><div></div></div>
        </div>
		    </div>
</div>
    </div>
</div>
@endif
@if(isset($_GET['user']))
@php	
	$data = $_GET['user'];
    $user = \App\User::where('_id', $data)->first();
    if(is_null($user)) {
        die();
    }
	
@endphp
       <div class="row profile_row">
            <div class="col-profile">
                <div class="profile-sidebar">
                    <div class="avatar-user">
                        <img alt="" src="{{ $user->avatar }}">
                    </div>
                                        <div class="name-user">
                        {{ $user->name }}
                    </div>
                    
                </div>
            </div>
            <div class="content_column col-stat"><div class="row">
                                    <div class="col-12 col-sm-6 pr-sm-0">
                                        <div class="profile-highlight profile-highlight-no-top-margin-b">
                                            <div>{{ __('general.profile.wager') }}</div>
                                            <div class="text-success">
                                                <i class="fas fa-usd-circle" style="color:#02b320"></i>
                                                @php
												$statistics = \App\Statistics::where('_id', $user->_id)->first();
												$wagered1 = $statistics->wagered_btc;
												$wagered2 = $statistics->wagered_usdt;
												$wagered3 = $statistics->wagered_usdc;
												$wagered4 = $statistics->wagered_bnb;
												$wagered5 = $statistics->wagered_xrp;
												$wagered6 = $statistics->wagered_eth;
												$wagered7 = $statistics->wagered_ltc;
												$wagered8 = $statistics->wagered_doge;
												$wagered9 = $statistics->wagered_bch;
		 										$wagered10 = $statistics->wagered_trx;
												@endphp
												{{ number_format((\App\Http\Controllers\Api\WalletController::rateDollarBtc() * $wagered1), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarUsdt() * $wagered2), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarUsdc() * $wagered3), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarBnb() * $wagered4), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarXrp() * $wagered5), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarEth() * $wagered6), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarLtc() * $wagered7), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarDoge() * $wagered8), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarBtcCash() * $wagered9), 3, '.', '') + number_format((\App\Http\Controllers\Api\WalletController::rateDollarTron() * $wagered10), 3, '.', '') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 pl-sm-0">
                                        <div class="profile-highlight profile-highlight-no-top-margin-b">
                                            <div>{{ __('general.profile.games') }}</div>
                                            <div class="text-primary">
											@php
											$total1 = $statistics->bets_btc;
											$total2 = $statistics->bets_usdt;
											$total3 = $statistics->bets_usdc;
											$total4 = $statistics->bets_bnb;
											$total5 = $statistics->bets_xrp;
											$total6 = $statistics->bets_eth;
											$total7 = $statistics->bets_ltc;
											$total8 = $statistics->bets_doge;
											$total9 = $statistics->bets_bch;
											$total10 = $statistics->bets_trc;
											$alltotal = $total1 + $total2 + $total3 + $total4 + $total5 + $total6 + $total7 + $total8 + $total9 + $total10;
											@endphp
											{{ $alltotal }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 pr-sm-0">
                                        <div class="profile-highlight-r">
                                            <div>{{ __('general.profile.best_mul') }}</div>
                                            <div class="text-primary">
                                                @php
                                                    $highest = \App\Game::where('user', $user->_id)->where('status', 'win')->orderBy('multiplier', 'DESC')->first();
                                                @endphp
                                                @if ($highest)
                                                    x{{ number_format($highest->multiplier, 2, '.', ' ') }}
                                                    <a href="javascript:void(0)" onclick="$('.user .btn-close').click(); $.overview('{{ $highest->_id }}', '{{ $highest->game }}')"><i class="overview fad fa-eye"></i></a>
                                                @else
                                                    {{ __('general.profile.no_games_found') }}
                                                @endif
                                                                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 pl-sm-0">
                                        <div class="profile-highlight-r">
                                            <div>{{ __('general.profile.best_win') }}</div>
                                            <div class="text-success">
                                                @php 
                                                    $highest = \App\Game::where('user', $user->_id)->where('status', 'win')->orderBy('profit', 'DESC')->first();
													$currency = \App\Currency\Currency::find($highest->currency);
                                                @endphp
                                                @if ($highest)
                                                    <img src="/img/currency/svg/{{ $currency->id() }}.svg" style="margin-top: -5px;width: 14px;height: 14px;" alt="" />
                                                    {{ number_format($highest->profit, 2, '.', ' ') }}
                                                    <a href="javascript:void(0)" onclick="$('.user .btn-close').click(); $.overview('{{ $highest->_id }}', '{{ $highest->game }}')"><i class="overview fad fa-eye"></i></a>
                                                @else
                                                    {{ __('general.profile.no_wins_found') }}
                                                @endif
                                                                                            </div>
                                        </div>
                                    </div>
                                </div>
                
            </div>
        </div>
<div class="profile-content">
                                            <div data-tab="profile">
                                                            <div class="cat">
                                    Statistics
                                </div>
								@if(!auth()->guest())
                                <table class="live-table">
                                    <thead>
                                    <tr>
                                        <th>
                                            {{ __('general.profile.bets') }}
                                        </th>
                                        <th  class="d-none d-md-table-cell">
                                            {{ __('general.profile.wins') }}
                                        </th>
                                        <th  class="d-none d-md-table-cell">
                                            {{ __('general.profile.losses') }}
                                        </th>
                                        <th style="text-align: right">
                                            {{ __('general.profile.wagered') }}
                                        </th>
                                        <th>
                                            {{ __('general.profile.wagered') }} ($)
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="live_games">

                                        @foreach(\App\Currency\Currency::all() as $currency)
										@php
										if(\App\Statistics::where('_id', $user->_id)->first() == null) {
											$a = \App\Statistics::create([
											'_id' => $data->user()->_id, 'bets_btc' => 0, 'wins_btc' => 0, 'loss_btc' => 0, 'wagered_btc' => 0, 'profit_btc' => 0, 'bets_eth' => 0, 'wins_eth' => 0, 'loss_eth' => 0, 'wagered_eth' => 0, 'profit_eth' => 0, 'bets_ltc' => 0, 'wins_ltc' => 0, 'loss_ltc' => 0, 'wagered_ltc' => 0, 'profit_ltc' => 0, 'bets_doge' => 0, 'wins_doge' => 0, 'loss_doge' => 0, 'wagered_doge' => 0, 'profit_doge' => 0, 'bets_bch' => 0, 'wins_bch' => 0, 'loss_bch' => 0, 'wagered_bch' => 0, 'profit_bch' => 0, 'bets_trx' => 0, 'wins_trx' => 0, 'loss_trx' => 0, 'wagered_trx' => 0, 'profit_trx' => 0, 'bets_xrp' => 0, 'wins_xrp' => 0, 'loss_xrp' => 0, 'wagered_xrp' => 0, 'profit_xrp' => 0, 'bets_bnb' => 0, 'wins_bnb' => 0, 'loss_bnb' => 0, 'wagered_bnb' => 0, 'profit_bnb' => 0, 'bets_usdt' => 0, 'wins_usdt' => 0, 'loss_usdt' => 0, 'wagered_usdt' => 0, 'profit_usdt' => 0, 'bets_usdc' => 0, 'wins_usdc' => 0, 'loss_usdc' => 0, 'wagered_usdc' => 0, 'profit_usdc' => 0
											]);
										}				
										$statistics = \App\Statistics::where('_id', $user->_id)->first();
											if($currency->name() == 'BTC'){
												$bets = $statistics->bets_btc;
												$wins = $statistics->wins_btc;
												$loss = $statistics->loss_btc;
												$wagered = $statistics->wagered_btc;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarBtc() * $wagered), 3, '.', '');

												$profit = $statistics->profit_btc;
											}
                                            if($currency->name() == 'USDT'){
                                                $bets = $statistics->bets_usdt;
                                                $wins = $statistics->wins_usdt;
                                                $loss = $statistics->loss_usdt;
                                                $wagered = $statistics->wagered_usdt;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarUsdt() * $wagered), 3, '.', '');
                                                $profit = $statistics->profit_usdt;
                                            }
                                            if($currency->name() == 'USDC'){
                                                $bets = $statistics->bets_usdc;
                                                $wins = $statistics->wins_usdc;
                                                $loss = $statistics->loss_usdc;
                                                $wagered = $statistics->wagered_usdc;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarUsdc() * $wagered), 3, '.', '');
                                                $profit = $statistics->profit_usdc;
                                            }
                                            if($currency->name() == 'BNB'){
                                                $bets = $statistics->bets_bnb;
                                                $wins = $statistics->wins_bnb;
                                                $loss = $statistics->loss_bnb;
                                                $wagered = $statistics->wagered_bnb;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarBnb() * $wagered), 3, '.', '');
                                                $profit = $statistics->profit_bnb;
                                            }
                                            if($currency->name() == 'XRP'){
                                                $bets = $statistics->bets_xrp;
                                                $wins = $statistics->wins_xrp;
                                                $loss = $statistics->loss_xrp;
                                                $wagered = $statistics->wagered_xrp;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarXrp() * $wagered), 3, '.', '');
                                                $profit = $statistics->profit_xrp;
                                            }
											if($currency->name() == 'ETH'){
												$bets = $statistics->bets_eth;
												$wins = $statistics->wins_eth;
												$loss = $statistics->loss_eth;
												$wagered = $statistics->wagered_eth;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarEth() * $wagered), 3, '.', '');
												$profit = $statistics->profit_eth;
											}
											if($currency->name() == 'LTC'){
												$bets = $statistics->bets_ltc;
												$wins = $statistics->wins_ltc;
												$loss = $statistics->loss_ltc;
												$wagered = $statistics->wagered_ltc;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarLtc() * $wagered), 3, '.', '');
												$profit = $statistics->profit_ltc;
											}
											if($currency->name() == 'DOGE'){
												$bets = $statistics->bets_doge;
												$wins = $statistics->wins_doge;
												$loss = $statistics->loss_doge;
												$wagered = $statistics->wagered_doge;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarDoge() * $wagered), 3, '.', '');
												$profit = $statistics->profit_doge;
											}
											if($currency->name() == 'BCH'){
												$bets = $statistics->bets_bch;
												$wins = $statistics->wins_bch;
												$loss = $statistics->loss_bch;
												$wagered = $statistics->wagered_bch;
                                                $wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarBtcCash() * $wagered), 3, '.', '');
												$profit = $statistics->profit_bch;
											}
											if($currency->name() == 'TRX'){
												$bets = $statistics->bets_trx;
												$wins = $statistics->wins_trx;
												$loss = $statistics->loss_trx;
												$wagered = $statistics->wagered_trx;
												$wageredusd = number_format((\App\Http\Controllers\Api\WalletController::rateDollarTron() * $wagered), 3, '.', '');
                                                $profit = $statistics->profit_trx;
											}                                        
										@endphp
                                            <tr>
                                                <th>
                                                    <div>
                                                        <div class="icon d-none d-md-inline-block">
                                                                <img src="/img/currency/svg/{{ $currency->id() }}.svg" style="margin-top: -20px; width: 14px; height: 14px;">
                                                        </div>
                                                        <div class="namet">
                                                            <div data-highlight>{{ $currency->name() }}</div>
                                                        <small>{{ $bets == null ? 0 : $bets }}</small>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th data-highlight class="d-none d-md-table-cell">
                                                    <div>
                                                        <span>{{ $wins == null ? 0 : $wins }}</span>
                                                    </div>
                                                </th>
                                                <th data-highlight  class="d-none d-md-table-cell">
                                                    <div>
                                                        <span>{{ $loss == null ? 0 : $loss }}</span>
                                                    </div>
                                                </th>
                                                <th data-highlight style="text-align: right">
                                                    <div>
                                                        <span>{{ number_format(floatval($wagered), 8, '.', '') }}</span>
                                                                <img src="/img/currency/svg/{{ $currency->id() }}.svg" class="wagered-img">
                                                    </div>
                                                </th>
                                                <th data-highlight>
                                                    <div>
                                                        <span>{{ number_format(floatval($wageredusd), 0, '.', '') }}</span>
														<i class="fas fa-usd-circle" style="color:#02b320"></i>
                                                    </div>
                                                </th>
                                            </tr>
                                        @endforeach
                                                                            </tbody>
                                </table>
								@else
								<div style="text-align: center;font-size: 1.5em;padding: 50px;">You must be logged in.</div>
								@endif
                                                    </div>
                                                        </div>
@endif