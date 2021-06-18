@php $user = \App\User::where('_id', $data)->first(); @endphp
@php $withdrawals = \App\Withdraw::where('user', $user->id)->where('status', 1)->count(); @endphp
@php $deposits = \App\Invoice::where('user', $user->id)->where('status', 1)->where('ledger', '!=','Offerwall Credit')->count(); @endphp
@php $offerwalls = \App\Invoice::where('user', $user->id)->where('status', 1)->where('ledger', '=','Offerwall Credit')->count(); @endphp

<script>window._id = '{{ $user->_id }}';</script>

<div class="container-fluid">


    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mt-3">
                        <img src="{{ $user->avatar }}" alt="" class="avatar-sm rounded-circle">
                        <h5 class="mt-2 mb-0">{{ $user->name }}</h5>
                        @if(count($user->name_history) > 1)
                            <h6 class="font-weight-normal mt-2 mb-0">Also known as:</h6>
                            @foreach($user->name_history as $history)
                                {!! "<h6 class=\"text-muted font-weight-normal\">".\Carbon\Carbon::parse($history['time'])->diffForHumans().' - '.$history['name'].'</h6>' !!}
                            @endforeach
                        @endif
                    </div>

                    <div class="mt-3 pt-2 border-top">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0 text-muted">
                                <tbody>
                                    <tr>
                                        <th scope="row">Register IP</th>
                                        <td class="text-muted">{{ $user->register_ip }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Latest IP</th>
                                        <td>{{ $user->login_ip }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Referrals</th>
                                        <td>{{ \App\User::where('referral', $user->id)->count() }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Active Referrals</th>
                                        <td>{{ count($user->referral_wager_obtained ?? []) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Created at</th>
                                        <td class="text-muted">{{ $user->created_at }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Last activity</th>
                                        <td class="text-muted">{{ \Carbon\Carbon::parse($user->latest_activity)->diffForHumans() }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Referrer</th>
                                        <th>{!! $user->referral == null ? '-' : '<a href="/admin/user/'.$user->referral.'">'.\App\User::where('_id', $user->referral)->first()->name.'</a>' !!}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Deposits</th>
                                        <td class="text-muted">{{ $deposits }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Withdrawals</th>
                                        <td class="text-muted">{{ $withdrawals }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Offerwalls</th>
                                        <td class="text-muted">{{ $offerwalls }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">2FA status</th>
                                        <td class="text-muted">{{ ($user->tfa_enabled ?? false) ? 'Enabled' : 'Disabled' }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Free games</th>
                                        <th><input data-freegames="{{ $user->id }}" class="form-control form-control-sm" value="{{ $user->freegames }}"></th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Access Level</th>
                                        <th>
                                            <select id="access">
                                                <option value="user" @if($user->access === 'user') selected @endif>User</option>
                                                <option value="moderator" @if($user->access === 'moderator') selected @endif>Moderator</option>
                                                <option value="admin" @if($user->access === 'admin') selected @endif>Administrator</option>
                                            </select>

                        <button type="button" class="btn {{ $user->ban ? 'btn-primary' : 'btn-danger' }} btn-sm mr-1 mt-1" onclick="$.request('/admin/ban', { id: '{{ $data }}' }).then(() => { redirect(window.location.pathname) });">
                            {{ $user->ban ? 'Unban' : 'Ban' }}
                        </button>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Accounts</th>
                                        <th>
                                            @php
                                                $same_register_hash = \App\User::where('register_multiaccount_hash', $user->register_multiaccount_hash)->get();
                                                $same_login_hash = \App\User::where('login_multiaccount_hash', $user->login_multiaccount_hash)->get();
                                                $same_register_ip = \App\User::where('register_ip', $user->register_ip)->get();
                                                $same_login_ip = \App\User::where('login_ip', $user->login_ip)->get();

                                                $printAccounts = function($array) {
                                                    foreach($array as $value) echo '<div><a href="/admin/user/'.$value->_id.'">'.$value->name.'</a></div>';
                                                }
                                            @endphp

                                            @if($user->register_multiaccount_hash == null || $user->login_multiaccount_hash == null)
                                                @if($user->register_multiaccount_hash == null) <div class="text-danger">Cleared cookie before registration</div> @endif
                                                @if($user->login_multiaccount_hash == null) <div class="text-danger">Cleared cookie before authorization</div> @endif
                                            @else
                                                @if(count($same_register_hash) > 1)
                                                    <div class="text-danger">Same registration hash:</div>
                                                    @php $printAccounts($same_register_hash) @endphp
                                                @endif
                                                @if(count($same_login_hash) > 1)
                                                    <div class="text-danger">Same auth hash:</div>
                                                    @php $printAccounts($same_login_hash) @endphp
                                                @endif
                                                @if(count($same_register_ip) > 1)
                                                    <div class="text-danger">Same register IP:</div>
                                                    @php $printAccounts($same_register_ip) @endphp
                                                @endif
                                                @if(count($same_login_ip) > 1)
                                                    <div class="text-danger">Same auth IP:</div>
                                                    @php $printAccounts($same_login_ip) @endphp
                                                @endif
                                                @if(count($same_register_hash) <= 1 && count($same_login_hash) <= 1 && count($same_register_ip) <= 1 && count($same_login_ip) <= 1)
                                                    <div class="text-success">Good standing</div>
                                                @endif
                                            @endif
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <table class="table dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Games</th>
                            <th>Wins</th>
                            <th>Losses</th>
                            <th>Wagered</th>
                            <th>Deposited</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
							@php
							$statistics = \App\Statistics::where('_id', $user->_id)->first();	
							@endphp
                        @if($statistics == null)
                            @foreach(\App\Currency\Currency::all() as $currency)
                                <td>{{ $currency->name() }}</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td><input data-currency-balance="{{ $currency->id() }}" class="form-control form-control-sm" placeholder="{{ $currency->name() }} balance" value="{{ number_format($user->balance($currency)->get(), 8, '.', '') }}"></td>
                            </tr>
                                                        @endforeach
                         @else
                            <td>Total</td>
                            <td>{{ $statistics->bets_btc + $statistics->bets_eth + $statistics->bets_ltc + $statistics->bets_doge + $statistics->bets_bch + $statistics->bets_trx + $statistics->bets_usdt + $statistics->bets_usdc + $statistics->bets_xrp + $statistics->bets_bnb }}</td>
                            <td>{{ $statistics->wins_btc + $statistics->wins_eth + $statistics->wins_ltc + $statistics->wins_doge + $statistics->wins_bch + $statistics->wins_trx + $statistics->wins_usdt + $statistics->wins_usdc + $statistics->wins_xrp + $statistics->wins_bnb }}</td>
                            <td>{{ $statistics->loss_btc + $statistics->loss_eth + $statistics->loss_ltc + $statistics->loss_doge + $statistics->loss_bch + $statistics->loss_trx + $statistics->loss_usdt + $statistics->loss_usdc + $statistics->loss_xrp + $statistics->loss_bnb }}</td>
                        </tr>
                        @foreach(\App\Currency\Currency::all() as $currency)
                            <tr>
							@php
											if($currency->name() == 'BTC'){
												$bets = $statistics->bets_btc;
												$wins = $statistics->wins_btc;
												$loss = $statistics->loss_btc;
												$wagered = $statistics->wagered_btc;
												$profit = $statistics->profit_btc;
											}
											if($currency->name() == 'ETH'){
												$bets = $statistics->bets_eth;
												$wins = $statistics->wins_eth;
												$loss = $statistics->loss_eth;
												$wagered = $statistics->wagered_eth;
												$profit = $statistics->profit_eth;
											}
											if($currency->name() == 'LTC'){
												$bets = $statistics->bets_ltc;
												$wins = $statistics->wins_ltc;
												$loss = $statistics->loss_ltc;
												$wagered = $statistics->wagered_ltc;
												$profit = $statistics->profit_ltc;
											}
											if($currency->name() == 'DOGE'){
												$bets = $statistics->bets_doge;
												$wins = $statistics->wins_doge;
												$loss = $statistics->loss_doge;
										 		$wagered = $statistics->wagered_doge;
												$profit = $statistics->profit_doge;
											}
											if($currency->name() == 'BCH'){
												$bets = $statistics->bets_bch;
												$wins = $statistics->wins_bch;
												$loss = $statistics->loss_bch;
												$wagered = $statistics->wagered_bch;
												$profit = $statistics->profit_bch;
											}
											if($currency->name() == 'TRX'){
												$bets = $statistics->bets_trx;
												$wins = $statistics->wins_trx;
												$loss = $statistics->loss_trx;
												$wagered = $statistics->wagered_trx;
												$profit = $statistics->profit_trx;
											}
                                            if($currency->name() == 'USDT'){
                                                $bets = $statistics->bets_usdt;
                                                $wins = $statistics->wins_usdt;
                                                $loss = $statistics->loss_usdt;
                                                $wagered = $statistics->wagered_usdt;
                                                $profit = $statistics->profit_usdt;
                                            }
                                            if($currency->name() == 'USDC'){
                                                $bets = $statistics->bets_usdc;
                                                $wins = $statistics->wins_usdc;
                                                $loss = $statistics->loss_usdc;
                                                $wagered = $statistics->wagered_usdc;
                                                $profit = $statistics->profit_usdc;
                                            }
                                            if($currency->name() == 'BNB'){
                                                $bets = $statistics->bets_bnb;
                                                $wins = $statistics->wins_bnb;
                                                $loss = $statistics->loss_bnb;
                                                $wagered = $statistics->wagered_bnb;
                                                $profit = $statistics->profit_bnb;
                                            }
                                            if($currency->name() == 'XRP'){
                                                $bets = $statistics->bets_xrp;
                                                $wins = $statistics->wins_xrp;
                                                $loss = $statistics->loss_xrp;
                                                $wagered = $statistics->wagered_xrp;
                                                $profit = $statistics->profit_xrp;
                                            }
							@endphp
                                <td>{{ $currency->name() }}</td>
                                <td>{{ $bets }}</td>
                                <td>{{ $wins }}</td>
                                <td>{{ $loss }}</td>
                                <td>{{ number_format(floatval($wagered), 8, '.', '') }} {{ $currency->name() }}</td>
                                <td>{{ (\App\Invoice::where('user', $user->_id)->where('currency', $currency->id())->sum('sum')) }} {{ $currency->name() }}</td>
                                <td><input data-currency-balance="{{ $currency->id() }}" class="form-control form-control-sm" placeholder="{{ $currency->name() }} balance" value="{{ number_format($user->balance($currency)->get(), 8, '.', '') }}"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                    <hr>

                    <table id="transactions" class="table dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th style="width: 80%">Transaction</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Transaction::where('user', $user->_id)->where('demo', '!=', true)->get() as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                                <td style="width: 80%">
                                    <div>Message: {{ $transaction->data['message'] ?? 'n/a' }}  | Game: {{ $transaction->data['game'] ?? '-' }}</div>
                                    <div>
                                        {{ number_format($transaction->amount, 8, '.', '') }} {{ \App\Currency\Currency::find($transaction->currency)->name() }}
                                        (Before: {{ number_format($transaction->old, 8, '.', '') }}, Now: {{ number_format($transaction->new, 8, '.', '') }})
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                                        <hr>

                    <table id="datatable" class="table dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Game</th>
                                <th>Date</th>
                                <th>Wager</th>
                                <th>Income</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Game::where('demo', '!=', true)->where('user', $user->_id)->limit(300)->get() as $game)
                                <tr>
                                    <td>{{ $game->game }}</td>
                                    <td>{{ $game->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ number_format($game->wager, 8, '.', '') }}</td>
                                    <td>{{ number_format($game->profit, 8, '.', '') }}</td>
                                    <td>{{ $game->status }}</td>
                                    <td style="white-space: normal;">{{ json_encode($game->data) }}</td>
                                    <td>
                                        @if($game->status !== 'in-progress' && $game->status !== 'cancelled')
                                            <a class="disable-pjax" href="/?game={{ $game->game }}-{{ $game->_id }}" target="_blank">View</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
