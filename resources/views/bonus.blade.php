    {!! NoCaptcha::renderJs() !!}


<div class="container-lg mt-4">
<style>

.bonus-container {
    background: #263337;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 15px;
    border-bottom: 3px solid #202b2f;
}

.bonus-title {
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    font-family: IndustryBlack, Open Sans;
    color: #668791;
    margin-left: 4px;
    margin-right: 20px;
}

.bonus-vip-icon {
    width:  20px;
    height:  20px;
}

.bonus-text {
    margin-left: 4px;
    margin-right: 20px;
}
</style>

@if(!auth()->guest())




      <div class="container-lg " style="max-width: 1300px;">
                            @if(auth()->user()->tg_linked == null)

            <div class="bonus-container">
                
                <div class="bonus-title">Join our Telegram</div>
                    <span class="bonus-text"> Link your Telegram to get a 0.25$ bonus & unlock faucet mode. We publish DROPCODES for random freebies on our Telegram Channel.</span>
                    <div class="telegram-widget">
                    <hr>
                    <span class="join-telegram mt-2">
                    <script async src="https://telegram.org/js/telegram-widget.js?15" data-telegram-login="BIGZioBot" data-size="small" data-auth-url="https://bigz.io/api/callback/no9gqYHbIOWmW1Q4PkTEAW7De1z4v/{{ auth()->user()->id }}" data-request-access="write"></script></span>
                    &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary-small-dark ml-3 mt-0" onclick="redirect('https://t.me/bigzcasino')" >Telegram Group</button>
                    </div>
                    </div>
         @else


                                    @endif



            <div class="bonus-container">
                <div class="bonus-title">VIP Club</div>
                <span class="bonus-text">{{ __('vip.description', ['currency' => auth()->user()->closestVipCurrency()->name()]) }}</span>
                <br>
                <div class="bonus-text">{{ __('vip.description.2', ['currency' => auth()->user()->closestVipCurrency()->name()]) }}</div>
                <hr>
            @php
                $currency = auth()->user()->closestVipCurrency();
                $breakpoints = [
                    1 => floatval($currency->emeraldvip()),
                    2 => floatval($currency->rubyvip()),
                    3 => floatval($currency->goldvip()),
                    4 => floatval($currency->platinumvip()),
                    5 => floatval($currency->diamondvip())
                ];
                $percent = number_format(auth()->user()->vipLevel() == 5 ? 100 : (\Illuminate\Support\Facades\DB::table('games')->where('user', auth()->user()->_id)->where('currency', '!=', 'bonus')->where('currency', $currency->id())->where('demo', '!=', true)->where('status', '!=', 'in-progress')->where('multiplier', '!=', 1)->where('game', '!=', 'plinko')->where('status', '!=', 'cancelled')->sum('wager') / $breakpoints[auth()->user()->vipLevel() + 1]) * 100, 2, '.', '');
            @endphp

            <div class="bonus-title">Your VIP Progress</div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%;">{{ $percent < 8 ? '' : $percent.'%' }}</div>
            </div>
 
                <hr>

                 <div class="bonus-title">VIP Levels</div>
                 <div class="bonus-text">
                <div class="expandableBlock">
                <div class="expandableBlockHeader">
                    <svg class="bonus-vip-icon"><use href="#vip-emerald"></use></svg>
                    {{ __('vip.rank.1') }}
                </div>
                <div class="expandableBlockContent active" style="display: block;">
                    <ul>
                        <li>{{ __('vip.benefit_list.emerald.1') }}</li>
                        <li>{{ __('vip.benefit_list.emerald.2') }}</li>
                        <li>{{ __('vip.benefit_list.emerald.3') }}</li>
                        <li>{{ __('vip.benefit_list.emerald.4') }}</li>
                    </ul>
                </div>
            </div>
            <div class="expandableBlock">
                <div class="expandableBlockHeader">
                    <svg class="bonus-vip-icon"><use href="#vip-ruby"></use></svg>
                    {{ __('vip.rank.2') }}
                </div>
                <div class="expandableBlockContent" style="display: none;">
                    <ul>
                        <li>{{ __('vip.benefit_list.ruby.1') }}</li>
                        <li>{{ __('vip.benefit_list.ruby.2') }}</li>
                        <li>{{ __('vip.benefit_list.ruby.3') }}</li>
                    </ul>
                </div>
            </div>
            <div class="expandableBlock">
                <div class="expandableBlockHeader">
                    <svg class="bonus-vip-icon"><use href="#vip-gold"></use></svg>
                    {{ __('vip.rank.3') }}
                </div>
                <div class="expandableBlockContent" style="display: none;"> 
                    <ul>
                        <li>{{ __('vip.benefit_list.gold.1') }}</li>
                        <li>{{ __('vip.benefit_list.gold.2') }}</li>
                        <li>{{ __('vip.benefit_list.gold.3') }}</li>
                    </ul>
                </div>
            </div>
            <div class="expandableBlock">
                <div class="expandableBlockHeader">
                    <svg class="bonus-vip-icon"><use href="#vip-platinum"></use></svg>
                    {{ __('vip.rank.4') }}
                </div>
                <div class="expandableBlockContent" style="display: none;">
                    <ul>
                        <li>{{ __('vip.benefit_list.platinum.1') }}</li>
                        <li>{{ __('vip.benefit_list.platinum.2') }}</li>
                        <li>{{ __('vip.benefit_list.platinum.3') }}</li>
                    </ul>
                </div>
            </div>
            <div class="expandableBlock">
                <div class="expandableBlockHeader">
                    <svg class="bonus-vip-icon"><use href="#vip-diamond"></use></svg>
                    {{ __('vip.rank.5') }}
                </div>
                <div class="expandableBlockContent" style="display: none;">
                    <ul>
                        <li>{{ __('vip.benefit_list.diamond.1') }}</li>
                        <li>{{ __('vip.benefit_list.diamond.2') }}</li>
                        <li>{{ __('vip.benefit_list.diamond.3') }}</li>
                        <li>{{ __('vip.benefit_list.diamond.4') }}</li>
                    </ul>
                </div>
            </div>
        </div>


            </div>

                  <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="bonus-container">
                <div class="bonus-title">Double your Deposit</div>
                                   <div class="bonus-text">

                        @if(auth()->user()->bonus1 == '0' || auth()->user()->bonus1 == null)
                        <p>First Deposit Bonus, only useable once, simply enable this bonus and deposit to double your first deposit 100%!</p>
                        <p>Make sure to first activate this bonus and afterwards deposit. There is a 15x rollover wager requirement.</p>
                        
                        @elseif(auth()->user()->bonus1 == '1')
                        <p>You have enabled the deposit doubler bonus, now simply deposit any crypto and in any amount.</p>
                        <p>Please note you can only use this bonus once, so make good use of it.</p>

                        @elseif(auth()->user()->bonus1 == '2')
                        <p>Your deposit has been credited as BONUS$ balance. </p> 
                        <p>After you have reached the wager goal, 15x of your initial bonus amount, come back here to exchange bonus back to your deposit currency.</p>
                        <p>You can play with this bonus balance any games. Please note that wagers must be over 0.10$ to count to your wager goal, slots count 100% to your wager amount, any other game 50%.</p>

                        @elseif(auth()->user()->bonus1 == '3')
                        <p>You have reached the bonus requirement. Press button below to convert your bonus balance to your initial deposit currency. </p> 
                        <p>You are free to withdraw afterwards.</p>

                        @else
                        <p>You have already completed this offer or you are not eligible to start this offer.</p>

                        @endif
                        <div class="box" style="padding: 5px">
                        @if(auth()->user()->bonus1 == '0' || auth()->user()->bonus1 == null)
                        <div class="btn btn-primary-small-dark mt-3 ripple-surface bo1" onclick="redirect('/bonus')">Activate</div>

                        @elseif(auth()->user()->bonus1 == '1')
                            <div class="btn btn-primary-small-dark m-2 ripple-surface disabled p-2">Activated - Waiting for Deposit</div>
                             <div id="bo1-forfeit" class="btn btn-primary-small-dark m-2 ripple-surface">Forfeit bonus</div>
                        @elseif(auth()->user()->bonus1 == '2')

                                                @if(auth()->user()->bonus1_wager > auth()->user()->bonus1_goal)
                            <div class="btn btn-primary-small-dark m-2 ripple-surface bo1-complete" onclick="redirect('/bonus')">Complete Bonus & Convert to {{ auth()->user()->bonus1_currency }}</div>
                                                @else
                            <div class="btn btn-primary-small-dark mt-3 ripple-surface" onclick="$.setCurrency('bonus')">Balance: {{ auth()->user()->bonus ?? 0 }}$</div>
                            <div class="btn btn-primary-small-dark mt-3 ripple-surface disabled">Bonus Wagered: {{ auth()->user()->bonus1_wager ?? 0 }}$</div>
                            <div class="btn btn-primary-small-dark m-2 ripple-surface disabled p-2">Bonus Goal: {{ auth()->user()->bonus1_goal ?? 0 }}$</div>
                            <div id="bo1-forfeit" class="btn btn-secondary m-2 bo1-forfeit p-2">Forfeit bonus</div>
                                                @endif
                        @elseif(auth()->user()->bonus1 == '3')

                        @else
                        @endif
                    </div> 
                </div>
        </div>

            <div class="col-12 col-sm-12 col-md-12">
                <div class="bonus-container">
                <div class="bonus-title">Daily Bonus</div>
                    <div class="bonus-text">
                        <p> Time left till next Daily reset: <?php $timeLeft = 86400 - (time() - strtotime("today"));
                        echo date("H\\h  i\\m", $timeLeft); ?></p>
                        <div class="btn btn-primary-small-dark ripple-surface" onclick="$.vipBonus()">More Info</div>
                    </div> 
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12">
                <div class="bonus-container"> 
                <div class="bonus-title">DROPCODE</div>
                    <div class="bonus-text">
                            <p>Enter DROPCODE. Check the <a onclick="redirect('{{ \App\Settings::where('name', 'telegram_link')->first()->value }}')"><u>BIGZ Telegram</u></a> for DROPCODES.</p>
    <div class="mt-2">
        <input id="code" type="text" placeholder="{{ __('bonus.promo.placeholder') }}">
    </div>
    <button id="activate" class="btn btn-primary-small-dark mt-3 ripple-surface">{{ __('bonus.promo.activate') }}</button>
                        </div>
                    </div></div>
                <div class="col-12 col-sm-12 col-md-12">
                <div class="bonus-container">
                <div class="bonus-title">Faucet</div>
                    <div class="bonus-text">    


                            <p>Use our faucet once every hour.</p> 
                            <button id="faucetrequest" class="btn btn-primary-small-dark w-50 mt-2">{{ __('general.spin') }}</button>
                            
                            <hr>

                             {!! NoCaptcha::display(['data-theme' => 'default'], ['data-callback' => 'recaptchaCallback']) !!}
                            </div>
                            <div class="container-fluid">
                            <div class="bonus-side-menu"></div>
                        </div>
                            <div class="wheel-popup" style="display: none">
                                {!! __('bonus.wheel.prompt') !!}
                            </div></div>
                        </div>


        </div>

@endif


                    </div>
                </div>

   

            </div>
