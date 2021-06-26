<div class="container-lg mt-4">
<style>

.bonus-container {
background: #263337;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 15px;
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

.bonus-text {
    margin-left: 4px;
    margin-right: 20px;
}
</style>

@if(!auth()->guest())




      <div class="container-lg " style="max-width: 1300px;">
            
            <div class="bonus-container">

                <div class="bonus-title">Join our Telegram</div>
                    <span class="bonus-text"> Link your Telegram to get 0.25$ non-deposit & unlock faucet mode. We publish DROPCODES for random freebies on our Telegram Channel.</span>
                    <div class="telegram-widget">
                    <hr>

                    <script src="https://telegram.org/js/telegram-widget.js?15" data-telegram-login="bigz_io_bot" data-size="medium" data-userpic="false" data-auth-url="https://loff.io/api/callback/no9gqYHbIOWmW1Q4PkTEAW7De1z4v/{{ auth()->user()->id }}" data-request-access="write"></script>
                </div>
                </div>


            <div class="bonus-container">
                <div class="bonus-title">Your VIP Progress</div>
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


            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%;">{{ $percent < 8 ? '' : $percent.'%' }}</div>
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
                        <div class="btn btn-primary m-2 p-2 bo1" onclick="redirect('/bonus')">Activate</div>

                        @elseif(auth()->user()->bonus1 == '1')
                            <div class="btn btn-primary m-2 disabled p-2">Activated - Waiting for Deposit</div>
                            <div class="btn btn-secondary m-2 bo1-forfeit p-2">Forfeit bonus</div>
                        @elseif(auth()->user()->bonus1 == '2')

                                                @if(auth()->user()->bonus1_wager > auth()->user()->bonus1_goal)
                            <div class="btn btn-primary m-2 bo1-complete" onclick="redirect('/bonus')">Complete Bonus & Convert to {{ auth()->user()->bonus1_currency }}</div>
                                                @else
                            <div class="btn btn-primary m-2 p-2" onclick="$.setCurrency('bonus')">Balance: {{ auth()->user()->bonus ?? 0 }}$</div>
                            <div class="btn btn-primary m-2 p-2 disabled">Bonus Wagered: {{ auth()->user()->bonus1_wager ?? 0 }}$</div>
                            <div class="btn btn-primary m-2 disabled p-2">Bonus Goal: {{ auth()->user()->bonus1_goal ?? 0 }}$</div>
                            <div class="btn btn-secondary m-2 bo1-forfeit p-2">Forfeit bonus</div>
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
                                <p>Use our faucet once every hour.</p> <div class="btn btn-primary-small-dark ripple-surface" data-toggle-bonus-sidebar="wheel">Spin Wheel</div>
                            </div>
                            <div class="wheel-popup" style="display: none">
                                {!! __('bonus.wheel.prompt') !!}
                            </div></div>
                        </div>


        </div>
        
        <!--

            <div class="col-12 col-sm-12 col-md-12">
                <div class="bonus-box-small">
                   <div class="text">
                        <div class="header"><h5>Deposit Tripler Loyalty Bonus</h5></div>
                        @if(auth()->user()->bonus2 == '0' || auth()->user()->bonus2 == null)
                        <p>Triple Deposit Bonus for our <a onclick="$.vip()">Loyalty Members</a>, only useable once, enable this bonus then deposit and get triple your deposit!</p>
                        <p>Make sure to first activate this bonus and afterwards deposit. There is a 45x rollover wager requirement.</p>
                        
                        @elseif(auth()->user()->bonus2 == '1')
                        <p>You have enabled the deposit tripler bonus, now simply deposit any crypto and in any amount.</p>
                        <p>Please note you can only use this bonus once, so make good use of it.</p>

                        @elseif(auth()->user()->bonus2 == '2')
                        <p>Your deposit has been credited as BONUS$ balance. </p> 
                        <p>After you have reached the wager goal, 45x of your initial bonus amount, come back here to exchange bonus back to your deposit currency.</p>
                        <p>You can play with this bonus balance any games. Please note that wagers must be over 0.10$ to count to your wager goal, slots count 100% to your wager amount, any other game 20%.</p>

                        @elseif(auth()->user()->bonus2 == '3')
                        <p>You have reached the bonus requirement. Press button below to convert your bonus balance to your initial deposit currency. </p> 
                        <p>You are free to withdraw afterwards.</p>

                        @else
                        <p>You have already completed this offer or you are not eligible to start this offer.</p>

                        @endif
                        <div class="box" style="padding: 5px">
                        @if(auth()->user()->bonus2 == '0' || auth()->user()->bonus2 == null)
                        <div class="btn btn-primary m-2 p-2 bo2" onclick="redirect('/bonus')">Activate</div>

                        @elseif(auth()->user()->bonus2 == '1')
                            <div class="btn btn-primary m-2 disabled p-2">Activated - Waiting for Deposit</div>
                            <div class="btn btn-secondary m-2 bo2-forfeit p-2">Forfeit bonus</div>
                        @elseif(auth()->user()->bonus2== '2')

                                                @if(auth()->user()->bonus2_wager > auth()->user()->bonus2_goal)
                            <div class="btn btn-primary m-2 bo2-complete" onclick="redirect('/bonus')">Complete Bonus & Convert to {{ auth()->user()->bonus2_currency }}</div>
                                                @else
                            <div class="btn btn-primary m-2 p-2" onclick="$.setCurrency('bonus')">Balance: {{ auth()->user()->bonus ?? 0 }}$</div>
                            <div class="btn btn-primary m-2 p-2 disabled">Bonus Wagered: {{ auth()->user()->bonus2_wager ?? 0 }}$</div>
                            <div class="btn btn-primary m-2 disabled p-2">Bonus Goal: {{ auth()->user()->bonus2_goal ?? 0 }}$</div>
                            <div class="btn btn-secondary m-2 bo2-forfeit p-2">Forfeit bonus</div>
                                                @endif
                        @elseif(auth()->user()->bonus2 == '3')

                        @else
                        @endif
                    </div>
                </div>
            </div>
        </div>

</div>

        </div>

        @else

              <div class="bonus-box" style="max-width: 1200px;">
          <h5 style="font-weight: 600;"><i style="color: #2367ff; margin-right: 7px;" class="fad fa-layer-plus"></i>       <button style="font-size: 8px !important;" onclick="redirect('/provider/mascot')" class="btn btn-light p-1 m-1">NEW</a> </button>
         Deposit Bonuses</h5>

                  <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="bonus-box-small">
                   <div class="text">
                        <div class="header"><h5>Deposit Doubler Bonus</h5></div>
                        <p>First Deposit Bonus, only useable once, simply enable this bonus and deposit to double your first deposit 100%!</p>
                        <p>Make sure to first activate this bonus and afterwards deposit. There is a 15x rollover wager requirement.</p>
                 </div>
                </div>
            </div>
        </div>
    </div>
@endif


                    <div class="col-12 col-sm-12 col-md-6">
                        <div class="bonus-box-small">
                            <div class="banner-img banner-vip">
                                <div class="text" style="background: linear-gradient(176deg, #0f121bf2, #1a1d29fc); height: 100%;">
                                    <div class="header"><h5>Loyalty Club Program</h5></div>
                                    <p>Simply play to work on your Loyalty Club Rank, each rank unlocks new reward features. First rank you just need to wager {{ \App\Settings::where('name', 'emeraldvip')->first()->value }}$ and immediately unlock the Daily Royalty Reward!</p><div class="btn btn-primary-small-dark ripple-surface" onclick="$.vip()">Loyalty Club</div>
                                </div>                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="bonus-box-small">
                                <div class="banner-img banner-quizbg">
                                    <div class="text" style="background: linear-gradient(176deg, #0f121bf2, #1a1d29fc); height: 100%;">
                                        <div class="header"><h5>Rain & Quiz Bot</h5></div>
                                        <p>Be active and get rewarded by our Ethereum Rain, Promocode Bot and Quiz Bot, dropping every 10 minutes.</p><div class="btn btn-primary-small-dark ripple-surface" onclick="redirect('{{ \App\Settings::where('name', 'discord_invite_link')->first()->value }}')">Join Discord</div>
                                    </div>
                                </div>
                            </div>
                        </div>!-->

                    </div>
                </div>

   

            </div>
            <div class="bonus-side-menu"></div>