<!DOCTYPE html>
<html lang="en" class="theme--{{ $_COOKIE['theme'] ?? 'dark' }}">
    <head>
        <title>{{ \App\Settings::where('name', 'platform_name')->first()->value }}</title>
        <link href="//cloud.typenetwork.com/projects/5774/fontface.css/" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="/img/logo/ico.png"/>
        <meta charset="utf-8">
        <link href="/css/webfonting.css" rel="stylesheet" type="text/css">
        <noscript><meta http-equiv="refresh" content="0; /no_js"></noscript>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ \App\Settings::where('name', 'platform_description')->first()->value }}">
        <meta property="og:description" content="{{ \App\Settings::where('name', 'platform_description')->first()->value }}" />
        <meta property="og:image:type" content="image/svg+xml" />
        <meta property="og:image:width" content="295" />
        <meta property="og:image:height" content="295" />
        <meta property="og:site_name" content="{{ \App\Settings::where('name', 'platform_name')->first()->value }}" />
        @if(env('APP_DEBUG'))
        <meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
        <meta http-equiv="Pragma" content="no-cache">
        @endif
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <link rel="preload" href="{{ mix('/js/app.js') }}" as="script">
        <script src="https://kit.fontawesome.com/2dba14c7e6.js" crossorigin="anonymous"></script>
        <link rel="preload" href="{{ mix('/css/app.css') }}" as="style">
        <link rel="preload" href="{{ mix('/css/loader.css') }}" as="style">
        <script src="{{ mix('/js/bootstrap.js') }}" type="text/javascript" defer></script>
        <link rel="stylesheet" href="{{ mix('/css/loader.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="manifest" href="/manifest.json">
        <script>
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! cache('translations') !!};
        window._mixManifest = {!! file_get_contents(public_path('mix-manifest.json')) !!}
        @php
        $currency = [];
        foreach(\App\Currency\Currency::all() as $c) $currency = array_merge($currency, [
        $c->id() => [
        'id' => $c->id(),
        'name' => $c->name(),
        'icon' => $c->icon(),
        'style' => $c->style(),
        'requiredConfirmations' => intval($c->option('confirmations')),
        'withdrawFee' => floatval($c->option('fee')),
        'minimalWithdraw' => floatval($c->option('withdraw')),
        'bonusWheel' => floatval($c->option('bonus_wheel')),
        'referralBonusWheel' => floatval($c->option('referral_bonus_wheel')),
        'investMin' => floatval($c->option('min_invest')),
        'highRollerRequirement' => floatval($c->option('high_roller_requirement')),
        'min_bet' => $c->option('min_bet'),
        'max_bet' => $c->option('max_bet')
        ]
        ]);
        @endphp
        window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'userId' => auth()->guest() ? null : auth()->user()->id,
        'userName' => auth()->guest() ? null : auth()->user()->name,
        'vapidPublicKey' => config('webpush.vapid.public_key'),
        'access' => auth()->guest() ? 'user' : auth()->user()->access,
        'currency' => $currency]) !!};
        window.currencies = {!! json_encode([
        'btc' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarBtc(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarBtcEur()],
        'bch' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarBtcCash(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarBtcCashEur()],
        'eth' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarEth(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarEthEur()],
        'xmr' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarXmr(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarXmrEur()],
        'xrp' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarXrp(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarXrpEur()],
        'nano' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarNano(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarNanoEur()],
        'usdt' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarUsdt(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarUsdtEur()],
        'usdc' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarUsdc(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarUsdcEur()],
        'ltc' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarLtc(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarLtcEur()],
        'bonus' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarBonus(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarBonusEur()],
        'matic' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarMatic(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarMaticEur()],
        'iota' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarIota(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarIotaEur()],
        'doge' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarDoge(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarDogeEur()],
        'trx' => ['dollar' => \App\Http\Controllers\Api\WalletController::rateDollarTron(), 'euro' => \App\Http\Controllers\Api\WalletController::rateDollarTronEur()]
        ]) !!};
        </script>
        {!! NoCaptcha::renderJs() !!}
        <style>
        </style>


    </head>
    <body>
        <div class="pageLoader">
            <img style="position: absolute; top: 0; bottom: 0; margin: auto; left: 0; right: 0; height: 100px; width: 100px;" src="/img/logo/bigz-preload-small.gif">
        </div>
    </div>
</div>
<div class="wrapper">
    <header>
        @if(auth()->guest())
        <div class="fixed" style="min-height: 70px; box-shadow: none;">
            @else
            <div class="fixed" style="min-height: 60px;">
                @endif
                <a href="/"><div class="smalllogo"></div></a>
                @if(!auth()->guest())
                <div class="menu" style="z-index: 99999; left: 0; margin: 0 auto; top: 2px; text-align: center;">
                    <div class="dropdown-top-menu">
                        
                        <a href="/" data-page-trigger="'/'" data-toggle-class="active">Games</a>
                        <div class="dropdown-top-menu-content">
                            <div class="menu-divider">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="divider">
                                            <div class="line"></div>
                                            <div class="menu-title">BIGZ Games</div>
                                            <div class="line"></div>
                                        </div>
                                        @foreach(\App\Games\Kernel\Game::list() as $game)
                                        @if(!$game->isDisabled() &&  $game->metadata()->id() !== "slotmachine" && $game->metadata()->id() !== "evoplay" && $game->metadata()->id() !== "livecasino")
                                        <div class="game_thumbnail" @if(!$game->isDisabled()) onclick="redirect('/game/{{ $game->metadata()->id() }}')" @endif style="background-image: url('/img/game/{{ $game->metadata()->id() }}.png')">
                                            @if($game->isDisabled())
                                            <div class="unavailable">
                                                <div class="slanting">
                                                    <div class="content">
                                                        {{ $game->metadata()->isPlaceholder() ? __('general.coming_soon') : __('general.not_available') }}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="name">
                                                {{ $game->metadata()->name() }}
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="col-12">
                                        <div class="divider">
                                            <div class="line"></div>
                                            <div class="menu-title">Popular Slots</div>
                                            <div class="line"></div>
                                        </div>
                                        @foreach(\App\Slotslist::where('f','1')->take(5)->get() as $slots)
                                        @if(auth()->guest())
                                        <div onclick="$.auth()" class="game_thumbnail" style="background-image:url(https://cdn.static.bet/i/wide/{{ $slots->p }}/{{ $slots->id }}.webp);">
                                            @else
                                            <div onclick="redirect('/game/{{ $slots->UID }}')" class="game_thumbnail" style="background-image:url(https://cdn.static.bet/i/wide/{{ $slots->p }}/{{ $slots->id }}.webp);">
                                                @endif
                                                <div class="name">
                                                    <div class="gamename" style="display: flex; justify-content: center; margin-top: 10px;">
                                                        <span><b>{{ $slots->n }}</b></span>
                                                    </div>
                                                    <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                                                        <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                                                    </div>
                                                    <div class="button" style="display: flex; justify-content: center; margin-top: 10px;">
                                                        <div class="btn btn-primary m-2">Play</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="container-fluid" style="background: #28373D; padding: 8px;">
                                                <div class="divider">
                                                    <div class="line" style="background: transparent;"></div>
                                                    <div class="btn btn-menu-footer"><i data-feather="arrow-up-circle" style="margin-bottom: 2px; margin-right: 2px; height: 20px; width: 20px;"></i> All Games</div> - <div class="btn btn-menu-footer action" onclick="$.displaySearchBar()"><i data-feather="search" style="margin-bottom: 2px; margin-right: 2px; height: 20px; width: 20px;"></i> Search</div>
                                                    <div class="line" style="background: transparent;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <a href="/poker" data-page-trigger="'/poker'" data-toggle-class="active">Poker</a>
                        <a href="/live" data-page-trigger="'/live'" data-toggle-class="active">Live</a>
                        <a href="/bonus" data-page-trigger="'/bonus'" data-toggle-class="active">Bonus</a>
                    </div>
                    <div class="wallet" style="margin-left: 25px;">
                        <div class="wallet-switcher">
                            @foreach(\App\Currency\Currency::all() as $currency)
                            @if($currency->id() == "bonus" && auth()->user()->bonus1 != "2" && auth()->user()->bonus2 != "2")
                            @else
                            <div class="option" data-set-currency="{{ $currency->id() }}">
                                <div class="wallet-switcher-icon">
                                    <img src="/img/currency/svg/{{ $currency->id() }}.svg" style="width: 16px; height: 16px;">
                                </div>
                                <div class="wallet-switcher-content">
                                    <div data-currency-value="{{ $currency->id() }}">{{ number_format(auth()->user()->balance($currency)->get(), 8, '.', '') }}</div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <div class="option" onclick="redirect('/pokertransfer/')" style="font-family: Proxima Nova Semi Bd;text-shadow: 1px 1px black;border-top: 1px solid #354144;background: #212e34;">
                                <div class="wallet-switcher-icon">
                                    <img src="/img/currency/svg/bonus.svg" style="width: 18px; height: 18px;">
                                </div>
                                <div class="wallet-switcher-content">
                                    <div>Exchange Poker Balance</div>
                                </div>
                            </div>
                        </div>
                        <div class="btn btn-primary btn-rounded wallet-open p-2" style="z-index: 5;margin-top: 1px; margin-bottom: 1px; text-shadow: 0.9px 0.9px #363d42; border-top-right-radius: 0px; border-bottom-right-radius: 0px;"></div>
                        <div class="btn balance-icon"><img class="" data-selected-currency width="17px" height="17px"><div class="balance"></div></div>
                        <div class="btn btn-secondary icon">
                            <i class="fal fa-angle-down"></i>
                        </div>
                    </div>
                    <span class="nav-link cursor-pointer" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="navbar-menu-user">
                            <span><small class="subtitle-profile">Hi, </small></span>
                            <span><small class="subtitle-profile">{{ auth()->user()->name }}</small></span>
                        </span>
                        <i data-feather="chevrons-down" style="margin-bottom: 9px;
                        margin-left: 2px;
                        border-radius: 7px;
                        height: 20px;
                        width: 20px;
                        color: #04b953;
                        padding: 2px;
                        background: #263337;
                        box-shadow: 1px 1px 2px rgb(0 0 0 / 25%);"></i>
                    </span>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <li>
                            <a class="dropdown-item" onclick="$.vip()">VIP Progress</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="">Settings</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick=" $.userinfo(auth()->user()->id())">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="$.request('/auth/logout', [], 'get').then(function() { window.location.reload(); });">Logout</a>
                        </li>
                        <div class="dropdown-divider"></div>
                    </div>
                    @else
                    <a onclick="redirect('/')"><div class="headermiddle"><div class="logo"></div></div></a>
                    @endif
                    <div class="right">
                        @if(auth()->guest())
                        <button class="btn btn-outlined m-1" onclick="$.auth()">{{ __('general.auth.login') }}</button>
                        <button class="btn btn-primary m-1" onclick="$.register()">{{ __('general.auth.register') }}</button>
                        @else
                        @endif
                    </div>
                </div>
                @if(auth()->guest())
                <div class="fixed" style="z-index: 2; top: 70px; min-height: 35px;">
                    <div class="menu-guest">
                        <a href="/bonus" data-page-trigger="'/slots'" data-toggle-class="active">Slots</a>
                        <a href="/poker" data-page-trigger="'/poker'" data-toggle-class="active">Poker</a>
                        <a href="/live" data-page-trigger="'/live'" data-toggle-class="active">Live</a>
                    </div>
                </div>
                @endif
            </header>
            <div class="pageContent" style="opacity: 0;">
                {!! $page !!}
            </div>
            <div class="container-xl">
                <div class="live">
                    <div class="header">
                        <span class="live-title"><div class="bigz-icon" style="margin-right: 5px; height: 24px; width: 24px;"></div> ACTIVITY FEED</span>
                        <div class="tabs"><span class="menu-title">
                            @if(!auth()->guest()) <div class="tab" data-live-tab="mine">{{ __('general.bets.mine') }}</div> @endif
                            <div class="tab active" id="allBetsTab" data-live-tab="all">{{ __('general.bets.all') }}</div>
                            <div class="tab" data-live-tab="lucky_wins">{{ __('general.bets.lucky_wins') }}</div>
                        </div>
                        <!--
                        <select id="liveTableEntries">
                            <option value="10" {{ ($_COOKIE['show'] ?? 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ ($_COOKIE['show'] ?? 10) == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ ($_COOKIE['show'] ?? 10) == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        !-->
                    </span>
                </div>
                <div class="live_table_container"></div>
            </div>
        </div>
        <footer class="text-center text-white">
        </footer>
        <div class="navbar-bottom">
            <div class="headermiddle"><div class="bigz-icon" style="margin-right: 1px; padding: 2px 2px; height: 20px; width: 20px;"></div></div>
            <a href="#news">News</a>
            <a href="#contact">Contact</a>
        </div>
    </div>
    <!--
    <div class="chat">
        <div class="fixed">
            <div class="chat-input-hint chatCommands" style="display: none"></div>
            <div data-user-tag class="chat-input-hint" style="display: none">
                <div class="hint-content"></div>
                <div class="hint-footer">
                    {!! __('general.chat_at') !!}
                </div>
            </div>
            <div class="messages"></div>
            <div class="message-send">
                @if(auth()->guest())
                <div class="message-auth-overlay">
                    <button class="btn btn-block btn-secondary" onclick="$.auth()">{{ __('general.auth.login') }}</button>
                </div>
                @elseif(auth()->user()->mute != null && !auth()->user()->mute->isPast())
                <div class="message-auth-overlay" style="opacity: 1 !important; text-align: center; font-size: 0.8em;">
                    {{ __('general.error.muted', [ 'time' => auth()->user()->mute ]) }}
                </div>
                @endif
                <div class="d-flex w-100">
                    <div class="column">
                        @if(!auth()->guest())
                        <div class="column-icon" data-notification-view onclick="$.displayNotifications()">
                            <i class="fas fa-bell"></i>
                        </div>
                        @endif
                        @if(!auth()->guest() && auth()->user()->access == 'admin')
                        <div class="column-icon" id="chatCommandsToggle">
                            <i class="fal fa-slash fa-rotate-90"></i>
                        </div>
                        @endif
                        <textarea onkeydown="if(event.keyCode === 13) { $.sendChatMessage('.text-message'); return false; }" class="text-message" placeholder="{{ __('general.chat.enter_message') }}"></textarea>
                    </div>
                    <div class="column">
                        <div class="column-icon">
                            @if(!auth()->guest())
                            <div class="emoji-container">
                                <div class="content" data-fill-emoji-target></div>
                                <div class="emoji-footer">
                                    <div class="content">
                                        <div class="emoji-category" onclick="$.unicodeEmojiInit()">
                                            <i class="fad fa-smile"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <i class="fad fa-smile" id="emoji-container-toggle" onclick="$.unicodeEmojiInit(); $('.emoji-container').toggleClass('active')"></i>
                        </div>
                        <div class="column-icon" onclick="$.sendChatMessage('.text-message')" id="sendChatMessage"><i class="fad fa-external-link-square"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    !-->
    <div class="draggableWindow">
        <div class="head">
            {{ __('general.profit_monitoring.title') }}
            <i class="far fa-redo-alt"></i>
            <i class="fal fa-times"></i>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-6">
                    {{ __('general.profit_monitoring.wins') }}
                    <span id="wins" class="float-right text-success"></span>
                </div>
                <div class="col-6">
                    {{ __('general.profit_monitoring.losses') }}
                    <span id="losses" class="float-right text-danger"></span>
                </div>
            </div>
            <div class="profit-monitor-chart"></div>
            <div class="row">
                <div class="col-6">
                    <div>{{ __('general.profit_monitoring.wager') }}</div>
                    <span id="wager"></span>
                </div>
                <div class="col-6">
                    <div>{{ __('general.profit_monitoring.profit') }}</div>
                    <span id="profit"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-menu-extended">
        <div class="control" data-page-trigger="'/help'" data-toggle-class="active" onclick="redirect('/help')">
            <i class="fas fa-question-circle"></i>
            <div>{{ __('general.head.help') }}</div>
        </div>
        <div class="control" @if(Auth::guest()) onclick="$.auth()" @else data-page-trigger="'/earn'" @endif data-toggle-class="active" onclick="redirect('/earn')">
            <i class="far fa-money-bill-wave"></i>
            <div>Earn Wall</div>
        </div>
        <div class="control" onclick="$.races()">
            <i class="fas fa-comet"></i>
            <div>Races</div>
        </div>
        <div class="control" onclick="$.leaderboard()">
            <i class="fas fa-trophy-alt"></i>
            <div>Leaderboard</div>
        </div>
    </div>
    <div class="mobile-menu-games">
        <div class="mobile-menu-games-container">
            <div class="game" onclick="redirect('/'); $('.mobile-menu-games').slideToggle('fast'); $('#mobile-games-angle').toggleClass('fa-rotate-180')">
                <div class="icon">
                    <i class="fas fa-spade"></i>
                </div>
                <div class="name">
                    {{ __('general.head.index') }}
                </div>
            </div>
            @foreach(\App\Games\Kernel\Game::list() as $game)
            @if($game->isDisabled()) @continue @endif
            <div class="game" onclick="redirect('/game/{{ $game->metadata()->id() }}'); $('.mobile-menu-games').slideToggle('fast'); $('#mobile-games-angle').toggleClass('fa-rotate-180')">
                <div class="icon">
                    <i class="{{ $game->metadata()->icon() }}"></i>
                </div>
                <div class="name">
                    {{ $game->metadata()->name() }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="floatingButtons">
        @if(!auth()->guest())
        <div class="floatingButton" style="color: #475d65;" onclick="redirect('/user/{{ auth()->user()->_id }}')">
        <i class="fad fa-user-circle" style="font-size: 23px;margin-right: -1px;margin-top: 5.3px;"></i></div>
        <div class="floatingButton" style="color: #475d65;" onclick="$.displaySearchBar()">
        <i class="fas fa-search" style="font-size: 17px;margin-right: 1px;margin-top: 6.2px;"></i></div>
        <div class="floatingButton" style="color: #475d65;" data-notification-view="" onclick="$.displayNotifications()"><span class="notification pulsating-circle" data-notification-attention="" style="top: 3px;"></span>
        <i class="fas fa-bell" style="font-size: 18px;margin-right: 8px;margin-top: 5px;"></i>
    </div>
    @endif
    <div class="floatingButton" data-chat-toggle>
    <svg><use href="#chat"></use></svg>
</div>
</div>
<div class="mobile-menu">
<div class="control" data-page-trigger="'/','/index'" data-toggle-class="active" onclick="$('.mobile-menu-games').slideToggle('fast'); $('#mobile-games-angle').toggleClass('fa-rotate-180')">
    <i class="fas fa-spade"></i>
    <div><i class="fal fa-angle-up" style="margin-right: 1px" id="mobile-games-angle"></i> {{ __('general.head.games') }}</div>
</div>
<div class="control" onclick="$.swapChat()">
    <i class="fad fa-comments"></i>
    <div>{{ __('general.head.chat') }}</div>
</div>
<div class="control" data-page-trigger="'/bonus'" data-toggle-class="active" onclick="redirect('/bonus')">
    <i class="fad fa-coins"></i>
    <div>{{ __('general.head.bonus_short') }}</div>
</div>
<div class="control" onclick="$('.mobile-menu-extended').slideToggle('fast', function() { if($(this).is(':visible')) $(this).css('display', 'flex'); }); $(this).find('svg').toggleClass('fa-rotate-180');">
    <i class="fal fa-angle-up"></i>
</div>
</div>
<div class="modal-wrapper">
<div class="modal-overlay"></div>
</div>
<div class="notifications">
<i class="fal fa-times" data-close-notifications></i>
<div class="title">{{ __('general.notifications.title') }}</div>
<div class="notifications-content os-host-flexbox"></div>
</div>
<div class="notifications-overlay"></div>
<div class="searchbar">
<i class="fal fa-times" data-close-searchbar></i>
<div class="title">{{ __('general.searchbar') }}</div>
<div class="searchbar-content os-host-flexbox" style="color: white;">
    <input type="text" id="searchbar" placeholder="Search game or provider..">
    <div class="our-games" style="background: transparent !important;" id="searchbar_result">
    </div>
</div>
</div>
<div class="searchbar-overlay"></div>
</body>
</html>