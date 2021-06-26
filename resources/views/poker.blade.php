
<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" class="svg position-absolute d-none d-lg-block" style="height: 650px;width: 100%;z-index: -10;/* overflow: hidden; *//* transform: scaleY(1.5); */-webkit-transform: scaleX(-1);transform: scaleX(-1) scaleY(1.5);">
  <defs>
    <linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0">
      <stop stop-color="#172327" offset="0%"></stop>
      <stop stop-color="#172327" offset="100%"></stop>
    </linearGradient>
  </defs>
  <path fill="url(#sw-gradient-0)" d="M 0.351 264.418 C 0.351 264.418 33.396 268.165 47.112 270.128 C 265.033 301.319 477.487 325.608 614.827 237.124 C 713.575 173.504 692.613 144.116 805.776 87.876 C 942.649 19.853 1317.845 20.149 1440.003 23.965 C 1466.069 24.779 1440.135 24.024 1440.135 24.024 L 1440 0 L 1360 0 C 1280 0 1120 0 960 0 C 800 0 640 0 480 0 C 320 0 160 0 80 0 L 0 0 L 0.351 264.418 Z">
  </path>
</svg>

<div class="container-lg" style="padding: 22px;">

    <div class="row">
        <div class="col-12 col-md-12" style="margin-left: auto; margin-right: auto;">


<style>
.videoWrapper {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 */
  height: 0;
  border-radius: 12px;
}
.videoWrapper iframe {
  position: absolute;
  top: 0;
border-radius: 1px;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
    <div class="divider">
                <div class="line-small-left"></div>
                <div class="divider-title-left"><i class="fak fa-bigz-letter"></i> BIGZ.IO POKER</div>
                <div class="line-small-left"></div>
    </div>
                <div class="videoWrapper">
                        <iframe title="vimeo-player" src="https://player.vimeo.com/video/566648836" frameborder="0" allowfullscreen></iframe>
                </div>
        </div>

    <div class="divider">
                <div class="line-small-left mb-3"></div>
                                    @if(!auth()->guest())
                <div class="divider-title-left mb-3"><div class="btn btn-primary-small" onclick="redirect('/pokerclient/')"><i class="fak fa-bigz-letter"></i>  Play Poker</div> </div>
                                    @else
                <div class="divider-title-left mb-3"><div class="btn btn-primary-small" onclick="$.auth()"><i class="fak fa-bigz-letter"></i>  Signup</div> </div>
                                    @endif
                <div class="line-small-left mb-3"></div>
    </div>

        <div class="spacer mt-3 mb-1"></div>

                    @if(!auth()->guest())
        <div class="col-12 col-md-12">
                <div class="transferblock">
                <div class="icon">
                   <div class="bigz-icon"></div>
                </div>
                <div class="desc">
                        <div class="btn btn-outlined-small mb-1">Poker Balance: {{ auth()->user()->pokerbalance() }}$</div>
                        <div class="btn btn-outlined-small mb-1">Poker Webclient</div>
                </div>
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

                                            @if(!auth()->guest())
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



