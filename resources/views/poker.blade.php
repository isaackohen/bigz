
                    @if(!auth()->guest())
<div class="container-lg" style="margin-top: 20px;" >
                @else 
                <div class="container-lg" style="margin-top: 60px;" >
                    @endif
            <div class="container" style="padding: 22px;">
                <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/564109995?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="BIGZ.io Poker"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
        </div>

    <div class="row">
                    @if(!auth()->guest())
        <div class="col-12 col-md-12">
                <div class="transferblock">
                <div class="icon">
                   <div class="bigz-icon"></div>
                </div>
                <div class="desc">
                        <div class="btn btn-primary-small mb-1" onclick="redirect('/pokerclient/')">Play Poker</div>
                        <div class="btn btn-outlined-small mb-1">Poker Balance: {{ auth()->user()->pokerbalance() }}$</div>
                </div>
            </div>


        @else 
        <div class="col-12 col-md-12">
            <div class="transferblock">
                <div class="icon">
                    <i class="fas fa-play"></i>
                </div>

                <div class="desc">
                        <div class="btn btn-primary" onclick="$.auth()">Login to play Poker</div>
                </div>
            </div>
        </div>
        @endif

    </div>
        <div class="col-12 col-md-6">
            <div class="transferblock">
                <div class="icon">
                    <i class="fas fa-inbox-in"></i>
                </div>
                <div class="desc">
                    <div class="btn balance-icon" style="background: transparent !important;"><span style="color: #fff !important; margin-left: 9px;">Select Currency</span></div>
                    <div><input id="depositinput" class="input-transfer depositinput mt-1 mb-1" placeholder="Enter Amount"></div>
                    <div class="btn btn-outlined-small mt-1 depositwallet">Deposit to Poker Balance</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="transferblock">
                <div class="icon">
                    <i class="fas fa-inbox-out"></i>
                </div>
                <div class="desc">
                    <div class="btn balance-icon" style="background: transparent !important; margin-right: 9px;"><span style="color: #fff !important;">To Litecoin  <img class="" width="15px" height="15px" src="/img/currency/svg/ltc.svg"></span></div>
                    <div><input id="withdrawinput" type="text" class="input-transfer withdrawinput mt-1 mb-1" placeholder="Poker Balance: {{ auth()->user()->pokerbalance() }}$"></div>
                    <div class="btn btn-outlined-small withdrawwallet mt-1">Withdraw from Poker Balance</div>
                </div>
            </div>
        </div>
</div>


    <div class="heading">{{ __('help.block.poker.title') }}</div>
    <div class="help">
        <div class="title">{!! __('help.block.poker.about_poker.title') !!}</div>
        <div class="description">{!! __('help.block.poker.about_poker.description') !!}</div>
    </div>
    <div class="help">
        <div class="title">{!! __('help.block.poker.rake.title') !!}</div>
        <div class="description">{!! __('help.block.poker.rake.description') !!}</div>
    </div>
    <div class="help">
        <div class="title">{!! __('help.block.poker.device_support.title') !!}</div>
        <div class="description">{!! __('help.block.poker.device_support.description') !!}</div>
    </div>
    <div class="help">
        <div class="title">{!! __('help.block.poker.how_to_deposit.title') !!}</div>
        <div class="description">{!! __('help.block.poker.how_to_deposit.description') !!}</div>
    </div>
    <div class="help">
        <div class="title">{!! __('help.block.poker.pricing.title') !!}</div>
        <div class="description">{!! __('help.block.poker.pricing.description') !!}</div>
    </div>
</div>



