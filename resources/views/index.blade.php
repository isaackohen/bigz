            @if(!auth()->guest())
                @php        
                header("Location: /welcome/");

                die();
                @endphp

            @endif     
            
          @if(auth()->guest())
                    <div style="margin-top: 50px;"></div>
            @endif


  <div id="slide control loff" class="owl-carousel owl-theme loff">

  <div id="large-slide" class="container-fluid" style="margin: 0px !important; padding-right: 0 !important; padding-left: 0 !important; margin-right: 0px !important;margin-left: 0px !important;">    


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

    <div class="container-xl" id="#slots">
       <!-- <img src="https://i.imgur.com/bFrM2Yf.png" style="padding: 100px; height: 700px !important; filter: saturate(0.75) drop-shadow(1); opacity: 0.90;" class="content-bg-pulse"> -->
        <img src="https://i.imgur.com/cVWUUgo.png" style="filter: saturate(0.75) drop-shadow(1); opacity: 0.90;" class="content-bg-pulse">

    <div id="#slotscontent" class="content-slideinleft slotscontent" style="opacity: 1 !important;">
            <div class="title">
                <div class="text">Play ALl-time<div class="accent"><div class="bigz-icon" style="margin-right: 5px; height: 37px; width: 40px;"></div>Favorites</span></div></div>
            </div>
    <div class="games-left" style="opacity: 1 !important;">
        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->id == 'starburst_touch' || $slots->id == 'jack_hammer_2_touch' || $slots->id == 'gonzos_quest_touch' || $slots->id == 'qso_bbw' || $slots->id == 'vs20rhinoluxe_prg' || $slots->id == 'vs4096bufking_prg' || $slots->id == 'vs25wolfgold_prg' || $slots->id == 'qso_northernsky' || $slots->id == 'age_of_caesar_bng_html' || $slots->id == 'hotline')

          @if(auth()->guest())
                    <div onclick="$.auth()" class="slots_thumbnail" style="background-image:url('/assets/i/long/jpg/{{ $slots->id }}.jpg');">
                @else
                    <div onclick="$.auth()" class="slots_thumbnail" style="background-image:url('/assets/i/long/jpg/{{ $slots->id }}.jpg');">
            @endif


                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 70px;">
                    <span><b>{{ $slots->n }}</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 10px;">
                    <span style="font-size: 0.80rem">{{ $slots->desc }}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 25px;">
                    <div class="btn btn-primary m-2">Play</div>
                </div>

                </div>
            </div>  
            @endif
        @endforeach

                    <div onclick="$.auth()" class="slots_thumbnail" style="background-image:url(/img/misc/gameposter-bigz.webp);">


                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 70px;">
                    <span><b>Register now!</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">Tons of Games</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 10px;">
                    <span style="font-size: 0.80rem">Wager Races, VIP and more.</span>
                </div>
                <div class="button" onclick="$.auth()" style="display: flex; justify-content: center; margin-top: 25px;">
                    <div class="btn btn-primary m-2">Register</div>
                </div>

                </div>

    </div>
       </div>

    <hr style="margin-top: 40px; margin-bottom: 30px; width: 40%;">

                        <div onclick="$.auth()" class="btn btn-primary m-1 w-25">Easy Register</div>
                    <div onclick="redirect('/welcome/')" class="btn btn-outlined m-1">More Games</div>




    </div>


</div>

</div>



<div id="large-slide" class="container-fluid" style="margin: 0px !important; padding-right: 0 !important; padding-left: 0 !important; margin-right: 0px !important;margin-left: 0px !important;">    
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
    <div class="container-lg" id="#piggydeposit">

        <img src="/assets/i/piggydeposit-2.png" style="filter: saturate(0.75) drop-shadow(1); opacity: 0.90;" class="content-bg-pulse">
</div>
    <div class="container-lg" id="#piggydeposit">
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
    <div class="content-slideinleft" style="opacity: 1 !important;">

            <div class="empty-between mt-5 mb-5"></div>

            <div class="title">
                <div class="text">FIRST DEPOSIT YOU GET</div>
                <div class="accent">No non-sense 100% BONUS.</span></div>
            </div>       
   
    <hr class="mt-3 mb-6" style="opacity: 0.05 !important;">
        
            <div class="title">
                <div class="text">Check out our Poker</div>
            </div>       
    <div class="subtitle">And tons of other games</div>

    <div class="bullet-point" style="margin-right: 1rem;">

        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>Provably Fair Games</span>
        </div>
        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>Dedicated Poker Room</span>
        </div>
        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>Live Casino</span>
        </div>
        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>Thousands of slotmachines</span>
        </div>
    </div>
        <hr class="mt-3 mb-6" style="opacity: 0.05 !important;">

                     <div onclick="$.auth()" class="btn btn-primary m-1 w-25">Easy Register</div>
                    <div onclick="redirect('/welcome/')" class="btn btn-outlined m-1">More Games</div>
    </div>
</div>
</div>


<div id="large-slide" class="container-fluid" style="margin: 0px !important; padding-right: 0 !important; padding-left: 0 !important; margin-right: 0px !important;margin-left: 0px !important;">    
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
    <div class="container-lg" id="#provablyfair">

        <img src="/assets/i/turnkeygirl.png" style="top:  calc(100% - 50%); height:  80%; filter: saturate(0.75) drop-shadow(1); opacity: 0.90;" class="content-bg-pulse">
</div>
    <div class="container-lg" id="#provablyfair">

    <div class="content-slideinleft" style="opacity: 1 !important;">
            <div class="title">
                <div class="text">Enjoy and Play<div class="accent"><div class="bigz-icon" style="margin-right: 5px; height: 37px; width: 40px;"></div>Exclusives</span></div></div>
            </div>
    <div class="games-left" style="opacity: 1 !important;">
        @foreach(\App\Games\Kernel\Game::list() as $game)
        @if(!$game->isDisabled() &&  $game->metadata()->id() !== "slotmachine" && $game->metadata()->id() !== "evoplay" && $game->metadata()->id() !== "livecasino")

            <div class="game_poster" @if(!$game->isDisabled()) onclick="redirect('/game/{{ $game->metadata()->id() }}')" @endif style="background-image: url('/assets/turnkey/thumbnail/{{ $game->metadata()->id() }}.png')">
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
   
    <hr>
    
    <div class="subtitle">What are you waiting for?</div>

    <div class="bullet-point" style="margin-right: 1rem;">

        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>BIG Cash Bonus Program</span>
        </div>
        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>Enticing Social Community</span>
        </div>
        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>Dedicated Poker Room</span>
        </div>
        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>Live Casino</span>
        </div>
        <div class="subtitle">
                <div class="icon"><span><svg width="24" height="24" viewBox="0 0 53 53"><defs></defs><g fill="#00C74D"><path d="M25 50C38.8071 50 50 38.8071 50 25C50 11.1929 38.8071 0 25 0C11.1929 0 0 11.1929 0 25C0 38.8071 11.1929 50 25 50Z" fill-opacity=".15" transform="translate(1.41 1.411)"></path><path d="M17 34C26.3888 34 34 26.3888 34 17C34 7.61116 26.3888 0 17 0C7.61116 0 0 7.61116 0 17C0 26.3888 7.61116 34 17 34Z" transform="translate(9.41 9.411)"></path></g></svg></span></div>

            <span>Thousands of slotmachines</span>
        </div>
    </div>
    </div>
</div>
</div>





</div>

<!--
<div class="container-lg">
<div id="dib-posts"></div>
</div>
<script>
var dib_id = 'GFSUYZLSWSMZ1NPZ31XG';
</script>
<script src="https://io.dropinblog.com/js/embed.js"></script> !-->