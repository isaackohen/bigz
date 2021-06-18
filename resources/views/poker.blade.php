
                    @if(!auth()->guest())
<div class="container-lg"  style="margin-top: 20px;" >
                @else 
                <div class="container-lg" style="margin-top: 60px;" >
                    @endif
    

    <div class="row">
                    @if(!auth()->guest())

        <div class="col-12 col-md-6">
            <div class="contact_us">
                <div class="icon">
                    <i class="fas fa-balance-scale-right"></i>
                </div>
                <div class="desc">
                    <div style="font-family: Proxima Nova Semi Bd;">Deposit Poker Balance</div>
                    <div><input id="depositpoker" placeholder="Enter Amount"></div>
                    <div id="depositwallet" class="btn btn-outlined-small mt-1">Deposit to Poker Balance</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="contact_us">
                <div class="icon">
                    <i class="fas fa-balance-scale-right"></i>
                </div>
                <div class="desc">
                    <div style="font-family: Proxima Nova Semi Bd;">Withdraw Poker Balance</div>
                    <div><input id="withdrawpoker" placeholder="Enter Amount"></div>
                    <div id="withdrawwallet" class="btn btn-outlined-small mt-1">Withdraw from Poker Balance</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
                <div class="contact_us">
                <div class="icon">
                    <i class="fas fa-play"></i>
                </div>
                <div class="desc">
                        <div class="btn btn-primary" onclick="redirect('/pokerclient/')">Play Poker</div>
                </div>
            </div>
        @else 
        <div class="col-12 col-md-12">
            <div class="contact_us">
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



