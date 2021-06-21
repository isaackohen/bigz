<div class="container-lg" style="margin-top:50px">

        ** Bonus & Challenges Placeholder **
</div>
@if(!auth()->guest())<!--

      <div class="bonus-box" style="max-width: 1200px;">
          <h5 style="font-weight: 600;"><i style="color: #2367ff; margin-right: 7px;" class="fad fa-layer-plus"></i>       <button style="font-size: 8px !important;" onclick="redirect('/provider/mascot')" class="btn btn-light p-1 m-1">NEW</a> </button>
         Your Bonus</h5>

                  <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="bonus-box-small">
                   <div class="text">
                        <div class="header"><h5>Deposit Doubler Bonus</h5></div>
                        @if(auth()->user()->bonus1 == '0' || auth()->user()->bonus1 == null)
                        <p>First Deposit Bonus, only useable once, simply enable this bonus and deposit to double your first deposit 100%!</p>
                        <p>Make sure to first activate this bonus and afterwards deposit. There is a 20x rollover wager requirement.</p>
                        
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
        </div>
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
                    <div class="col-12 col-sm-12 col-md-6">
                <div class="bonus-box-small">
                    <div class="banner-img">
                        <div class="text" style=" height: 100%;">
                            <div class="header"><h5>Promocode</h5></div>
                            <p>Enter your Promocode. Find promocodes on <a onclick="redirect('{{ \App\Settings::where('name', 'discord_invite_link')->first()->value }}')"><u>Discord</u></a>.</p><div class="btn btn-primary m-1 p-1" data-toggle-bonus-sidebar="promo">Enter Code</div>
                        </div>
                    </div></div>
                </div>

                <div class="col-12 col-sm-12 col-md-6">
                    <div class="bonus-box-small">
                        <div class="banner-img">
                            <div class="text" style=" height: 100%;">
                                <div class="header"><h5>Faucet</h5></div>
                                <p>Use our faucet once every 24 hours for 0.10$ to 1.00$.</p> <div class="btn btn-primary m-1 p-1" data-toggle-bonus-sidebar="wheel">Spin Wheel</div>
                            </div>
                            <div class="wheel-popup" style="display: none">
                                {!! __('bonus.wheel.prompt') !!}
                            </div></div>
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

    <div class="bonus-box" style="max-width: 1200px;">
          <h5 style="font-weight: 600;"><i style="color: #2367ff; margin-right: 7px;" class="fad fa-layer-plus"></i>
         Loyalty Rewards</h5>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <div class="bonus-box-small">
                    <div class="banner-img banner-bg1"><div class="text" style="background: linear-gradient(176deg, #0f121bf2, #1a1d29fc); height: 100%;">
                        <div class="header"><h5>Daily Royalty</h5></div>
                        <p> Time left till next Daily reset: <?php $timeLeft = 86400 - (time() - strtotime("today"));
                        echo date("H\\h  i\\m", $timeLeft); ?></p>
                        <div class="btn btn-primary m-1 p-1" onclick="$.vipBonus()">More Info</div>
                    </div>
                </div>
            </div>
        </div>
                    <div class="col-12 col-sm-12 col-md-6">
                        <div class="bonus-box-small">
                            <div class="banner-img banner-vip">
                                <div class="text" style="background: linear-gradient(176deg, #0f121bf2, #1a1d29fc); height: 100%;">
                                    <div class="header"><h5>Loyalty Club Program</h5></div>
                                    <p>Simply play to work on your Loyalty Club Rank, each rank unlocks new reward features. First rank you just need to wager {{ \App\Settings::where('name', 'emeraldvip')->first()->value }}$ and immediately unlock the Daily Royalty Reward!</p><div class="btn btn-primary m-1 p-1" onclick="$.vip()">Loyalty Club</div>
                                </div>                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div class="bonus-box-small">
                                <div class="banner-img banner-quizbg">
                                    <div class="text" style="background: linear-gradient(176deg, #0f121bf2, #1a1d29fc); height: 100%;">
                                        <div class="header"><h5>Rain & Quiz Bot</h5></div>
                                        <p>Be active and get rewarded by our Ethereum Rain, Promocode Bot and Quiz Bot, dropping every 10 minutes.</p><div class="btn btn-primary m-1 p-1" onclick="redirect('{{ \App\Settings::where('name', 'discord_invite_link')->first()->value }}')">Join Discord</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="bonus-side-menu"></div>
!-->

