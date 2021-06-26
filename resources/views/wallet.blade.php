<div class="container-lg" style="margin-top: 30px;">
    <div class="walletPage">
        <div class="walletUiBlocker" style="display: none">
            <div class="successfulWalletAction" style="display: none">
                <div class="heading"></div>
                <div class="content"></div>
                <div class="ledger"></div>
                <div class="d-flex ml-auto btn btn-primary close-action-notify">{{ __('general.close') }}</div>
            </div>
            <div class="loader"><div></div></div>
        </div>
        <div class="walletTabs">
            <div class="walletTab active" data-toggle-wallet-tab="deposit">{{ __('wallet.tabs.deposit') }}</div>
            <div class="walletTab" data-toggle-wallet-tab="withdraw">{{ __('wallet.tabs.withdraw') }}</div>
            <a class="walletTab" style="color: rgba(113, 142, 152, 0.7)" href="/poker/">{{ __('wallet.tabs.poker') }}</a>
            <div class="walletTab" data-toggle-wallet-tab="history">{{ __('wallet.tabs.history') }}</div>
        </div>
        <div class="walletTabContent" data-wallet-tab="deposit">
            <div class="row">
                <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                    <div class="walletColumnContent">
                        <div class="mb-3">{{ __('wallet.deposit.pick') }}</div>
                        <div class="paymentMethods">
                            @foreach(\App\Currency\Currency::all() as $currency)
                                <div class="paymentMethod {{ ($loop->index === 0 ? 'active' : '') }}" data-type="{{ $currency->id() }}" data-min-amount="1">
                                    <div class="icon">
                                        <img src="/img/currency/svg/{{ $currency->icon() }}.svg" class="walletbalance-icon" alt="" />
                                    </div>
                                    <div class="name">
                                        {{ $currency->name() }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                    <div class="walletColumnContent">
                        <div class="paymentMethodDesc">
                            {{ __('wallet.deposit.balance') }}
                             <div class="mt-3 paymentDesc"></div>
                        </div>
                        <div class="divider">
                            <div class="line"></div>
                            {{ __('wallet.tabs.deposit') }}
                            <div class="line"></div>
                        </div>
                        <div class="walletOut">
                            <div>{{ __('wallet.deposit.minimum') }}<span class="minAmount"></span></div>
                            <button class="btn btn-primary" id="deposit">{{ __('wallet.deposit.go') }}</button>
                        </div>
                        <div class="walletInfo mt-2">
                            <div class="walletInfoBlock">
                                <i class="fas fa-stopwatch"></i>
                                <div class="mt-3">
                                    {!! __('wallet.fast') !!}
                                </div>
                            </div>
                            <div class="walletInfoBlock">
                                <i class="fas fa-headset"></i>
                                <div class="mt-3">
                                    {!! __('wallet.troubles') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="walletTabContent" data-wallet-tab="withdraw" style="display: none">
            <div class="row">
                <div class="col-12 col-md-5 col-lg-4 col-xl-3">
                    <div class="walletColumnContent">
                        <div class="mb-3">{{ __('wallet.withdraw.balance') }}</div>
                        <div class="paymentMethods">
                            @foreach(\App\Currency\Currency::all() as $currency)
                                <div class="paymentMethod {{ ($loop->index === 0 ? 'active' : '') }}" data-type="{{ $currency->id() }}" data-amount="{{ number_format(auth()->user()->balance($currency)->get(), 8, '.', '') }}" data-min-amount="{{ $currency->option('withdraw') }}">
                                    <div class="icon">
                                        <img src="/img/currency/svg/{{ $currency->icon() }}.svg" class="walletbalance-icon" alt="" />
                                    </div>
                                    <div class="name">
                                        {{ $currency->name() }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                    <div class="walletColumnContent">
                        <div class="paymentMethodDesc">
                            {{ __('wallet.withdraw.balance') }}
                            <div class="mt-3 paymentDesc"></div>
                        </div>
                        <div class="divider">
                            <div class="line"></div>
                            <i class="fal fa-angle-down"></i>
                            <div class="line"></div>
                        </div>
                        <div class="divider">
                            <div class="line"></div>
                            <i class="fal fa-angle-down"></i>
                            <div class="line"></div>
                        </div>
                        <div class="walletOut">
                            <p style="font-size: 12px;" class="mt-2">
                                Your saldo is: <span class="walletAmount">0.00</span><br />
                                Minimum withdrawal: <span class="minAmount">0.00</span>
                            </p>
                            <div class="mb-0">{{ __('wallet.withdraw.enter_wallet') }}</div>
                            <input id="wallet" placeholder="{{ __('wallet.withdraw.wallet') }}">
                            <div class="mb-0">{{ __('wallet.withdraw.sum') }}</div>
                            <input id="walletWithValue" value="0.00" type="number" step="0.10">
                            <button class="btn btn-primary" id="withdraw">{{ __('wallet.withdraw.go') }}</button>
                        </div>

                        <div class="walletInfo mt-2">
                            <div class="walletInfoBlock">
                                <i class="fas fa-stopwatch"></i>
                                <div class="mt-3">
                                    {!! __('wallet.fast') !!}
                                </div>
                            </div>
                            <div class="walletInfoBlock">
                                <i class="fas fa-headset"></i>
                                <div class="mt-3">
                                    {!! __('wallet.troubles') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="walletTabContent" data-wallet-tab="history" style="display: none">
            <div class="walletHistory">
                <div class="walletTabs">
                    <div class="walletTab active" data-toggle-history-tab="payments">{{ __('wallet.tabs.deposits') }}</div>
                    <div class="walletTab" data-toggle-history-tab="withdraws">{{ __('wallet.tabs.withdraws') }}</div>
                </div>
                <div class="history-tab-content" data-history-tab="payments">
                    @if(\App\Invoice::where('user', auth()->user()->_id)->count() == 0)
                        <div class="walletHistoryEmpty">
                            <i class="fas fa-waiting"></i>
                            <div>{{ __('wallet.history.empty') }}</div>
                        </div>
                    @else
                        <table class="live-table">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('wallet.history.name') }}
                                    </th>
                                    <th class="d-none d-md-table-cell">
                                        {{ __('wallet.history.sum') }}
                                    </th>
                                    <th class="d-none d-md-table-cell">
                                        {{ __('wallet.history.ledger') }}
                                    </th>
                                    <th>
                                        {{ __('wallet.history.date') }}
                                    </th>
                                    <th>
                                        {{ __('wallet.history.status') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="live_games">
                                    @foreach(\App\Invoice::where('user', auth()->user()->_id)->where('sum', '!=', null)->latest()->get() as $invoice)
                                    <tr>
                                        <th>
                                            <div>
                                                <div>{{ __('wallet.history.deposit_name', ['sum' => $invoice->sum]) }} <i class="fas fa-coins"></i></div>
                                                <div data-highlight>{{ __('wallet.history.id', ['id' => $invoice->_id]) }}</div>
                                            </div>
                                        </th>
                                        <th class="d-none d-md-table-cell">
                                            <div>
                                            <div><i class="{{ \App\Currency\Currency::find($invoice->currency)->icon() }}" style="color: {{ \App\Currency\Currency::find($invoice->currency)->style() }}"></i> -   {{ \App\Currency\Currency::find($invoice->currency)->name() }}</div>
                                            </div>
                                        </th>
                                        <th class="d-none d-md-table-cell">
                                            <div>
                                                {{ $invoice->ledger }}
                                            </div>
                                        </th>
                                        <th>
                                            <div>
                                                {{ $invoice->created_at->diffForHumans() }}
                                            </div>
                                        </th>
                                        <th>
                                            @switch($invoice->status)
                                                @case(0)
                                                    {{ __('wallet.history.not_paid') }}
                                                    @break
                                                @case(1)
                                                    <div data-highlight>{{ __('wallet.history.paid') }}</div>
                                                    @break
                                            @endswitch
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="history-tab-content" data-history-tab="withdraws" style="display: none">
                    @if(\App\Withdraw::where('user', auth()->user()->_id)->count() == 0)
                        <div class="walletHistoryEmpty">
                            <i class="fas fa-waiting"></i>
                            <div>{{ __('wallet.history.empty') }}</div>
                        </div>
                    @else
                        <table class="live-table">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('wallet.history.name') }}
                                    </th>
                                    <th class="d-none d-md-table-cell">
                                        {{ __('wallet.history.sum') }}
                                    </th>
                                    <th> 
                                        {{ __('wallet.history.date') }}
                                    </th>
                                    <th>
                                        {{ __('wallet.history.status') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="live_games">
                                @foreach(\App\Withdraw::where('user', auth()->user()->_id)->latest()->get() as $withdraw)
                                    <tr>
                                        <th>
                                            <div>
                                                <div style="text-transform: capitalize;">{{ \App\Currency\Currency::find($withdraw->currency)->alias() }} <img src="/img/currency/svg/{{ $withdraw->currency }}.svg" style="width:14px; height:14px; margin-bottom: 5px;" alt="" class="walletbalance-icon" /></div> 
                                                <div data-highlight>{{ __('wallet.history.wallet', ['wallet' => $withdraw->wallet.' '.$withdraw->to]) }} {{ $withdraw->address }}</div>
                                            </div>
                                        </th>
                                        <th class="d-none d-md-table-cell">
                                            <div>
                                                {{ $withdraw->sum }} <img src="/img/currency/svg/{{ $withdraw->currency }}.svg" alt="" class="walletbalance-icon" />
                                            </div>
                                        </th>
                                        <th>
                                            <div>
                                                {{ $withdraw->created_at->diffForHumans() }}
                                            </div>
                                        </th>
                                        <th>
                                            @switch($withdraw->status)
                                                @case(0)
                                                @case(3)
                                                    {{ __('wallet.history.withdraw_status.moderation') }}
                                                    @if($withdraw->status == 0)
                                                        <!-- <div data-highlight style="cursor: pointer;" onclick="$.cancelWithdraw('{{ $withdraw->_id }}')">
                                                            {{ __('wallet.history.cancel') }}
                                                        </div> !-->
                                                    @endif
                                                    @break
                                                @case(1)
                                                    <div class="text-success">{{ __('wallet.history.withdraw_status.accepted') }}</div>
                                                    @break
                                                @case(2)
                                                    <div class="text-danger">{{ __('wallet.history.withdraw_status.declined') }}</div>
                                                    <div data-highlight>{{ __('wallet.history.withdraw_status.reason') }} {{ $withdraw->decline_reason }}</div>
                                                    @break
                                                @case(4)
                                                    {{ __('wallet.history.withdraw_status.cancelled') }}
                                                    @break
                                            @endswitch
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>