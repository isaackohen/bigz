          @if(auth()->guest())
                    <div style="margin-top: 80px;"></div>
            @endif


<div class="container-xl"> 
    <div class="container mt-5 mb-3">

<style>
</style>



    </div>

    <div class="divider">
                <div class="line-small-left"></div>
                <div class="divider-title-left"><i class="fak fa-bigz-letter"></i> BIGZ.IO Games</div>
                <div class="line-small-left"></div>
    </div>

    <div class="games" style="z-index: 1;">
        @foreach(\App\Games\Kernel\Game::list() as $game)
        @if(!$game->isDisabled() &&  $game->metadata()->id() !== "slotmachine" && $game->metadata()->id() !== "evoplay" && $game->metadata()->id() !== "livecasino")

            <div class="bigz_thumbnail" @if(!$game->isDisabled()) onclick="redirect('/game/{{ $game->metadata()->id() }}')" @endif style="background-image: url('/assets/turnkey/thumbnail/{{ $game->metadata()->id() }}.png')">

                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 25px;">
                    <span style="font-size: 0.80rem">{{ $game->metadata()->name() }}</span>
                </div>
                    
                </div>
            </div>  
        @endif
        @endforeach
                <div onclick="redirect('/slots/')" class="bigz_thumbnail" style="background-image:url(/img/misc/gameposter-bigz.webp);">
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 20px;">
                    <span><b>Register now!</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">Tons of Games</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 10px;">
                    <span style="font-size: 0.80rem">Wager Races, VIP and more.</span>
                </div>
                <div class="button" onclick="$.auth()" style="display: flex; justify-content: center; margin-top: 25px;">
                    <div class="btn btn-primary m-2" onclick="redirect('/provably-fair/')">Provably Fair</div>
                </div>

                </div>
    </div>
</div>   
              @if(!auth()->guest())

    <div class="empty-between mt-5 mb-5"></div>

    <div class="divider">
                <div class="line-small-left"></div>
                <div class="divider-title-left"><i class="fas fa-club"></i> Recommended for you</div>
                <div class="line-small-left"></div>
    </div>
    <div class="container-flex owl-carousel casinogames" style="z-index: 1;">
        @php
        $user = auth()->user()->id;
        $recent = \App\RecentSlots::where('player', $user)->get();
        $recent = json_decode($recent);
        $recent = array_column($recent, 's');
        $recentcount = count($recent);

        Log::notice($recent); 
        Log::notice($recentcount); 

        @endphp

        @if($recentcount > 0)

        @foreach(\App\Slotslist::get()->shuffle() as $slots)


        @if($recentcount > 0 && $slots->UID == $recent[0] || $recentcount > 1 && $slots->UID == $recent[1] || $recentcount > 2 && $slots->UID == $recent[2] || $recentcount > 3 && $slots->UID == $recent[3])
          @if(auth()->guest())          
                    @if($slots->p == 'upgames')
                    <div onclick="redirect('/live/{{ $slots->UID }}')" class="casino_thumbnail" style="background-image:url('/assets/game/livecasino/wide/{{ $slots->id }}.jpg');">
                        @else
                    <div onclick="$.auth()" class="casino_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                    @endif
                @else
                        @if($slots->p == 'upgames')
                    <div onclick="redirect('/live/{{ $slots->UID }}')" class="casino_thumbnail" style="background-image:url('/assets/game/livecasino/wide/{{ $slots->id }}.jpg');">
                        @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="casino_thumbnail" style="background-image:url('/assets/i/wide/{{ $slots->p }}/{{ $slots->id }}.jpg');">
                        @endif
            @endif
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 15px;">
                    <span><b>{{ $slots->n }}</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 5px;">
                    <span style="font-size: 0.80rem">{{ $slots->desc }}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 10px;">
                    <div class="btn btn-primary-small-dark"><i style="color: #3db96d;" class="fad fa-play"></i> Play</div>
                </div>
                </div>
            </div>  
            @endif
        @endforeach

          @foreach(\App\Slotslist::all()->shuffle()->random(15) as $slots)

          @if($slots->p !== "amatic" && $slots->p !== "igrosoft" && $slots->p !== "egt" && $slots->p !== "greentube" && $slots->p !== "konami" && $slots->p !== "apollo")              
          @if(auth()->guest())          
                    @if($slots->p == 'upgames')
                    <div onclick="redirect('/live/{{ $slots->UID }}')" class="casino_thumbnail" style="background-image:url('/assets/game/livecasino/wide/{{ $slots->id }}.jpg');">
                        @else
                    <div onclick="$.auth()" class="casino_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                    @endif
                @else
                        @if($slots->p == 'upgames')
                    <div onclick="redirect('/live/{{ $slots->UID }}')" class="casino_thumbnail" style="background-image:url('/assets/game/livecasino/wide/{{ $slots->id }}.jpg');">
                        @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="casino_thumbnail" style="background-image:url('/assets/i/wide/{{ $slots->p }}/{{ $slots->id }}.jpg');">
                        @endif
            @endif
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 15px;">
                    <span><b>{{ $slots->n }}</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 5px;">
                    <span style="font-size: 0.80rem">{{ $slots->desc }}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 10px;">
                    <div class="btn btn-primary-small-dark"><i style="color: #3db96d;" class="fad fa-play"></i> Play</div>
                </div>
                </div>
            </div>  
            @endif
        @endforeach

        @endif
</div>

        @endif

    <div class="search">                      
        <div class="divider">
            <div class="line-small-left"></div>
            <div class="divider-title-left"><i class="fak fa-bigz-letter"></i> Explore <button style="margin-left: 10px;"class="btn btn-primary-small-dark randomize">Random</button>
</div>
            <div class="line-small-left"></div>
        </div> 

          <div class="row">
    <div class="col-md-10">

    <input id="searchbar" autocomplete="off" type="text" class="lobby search-input" placeholder="Search in 1438 games.." name=""></input>

</div>
    <div class="col-md-2" style="font-size: 11px; max-width: 180px !important; padding: 8px;">
<div class="provider-select-menu">
<select id="searchbar-provider" style="border: none !important;" onchange="$.selectProvider();" data-mdb-placeholder="Explore Providers" class="form-select" data-mdb-clear-button="true">
    <option value="Explore Providers" disabled selected hidden>Select Provider</option>
    <option value="all">all</option>

    @foreach(\App\Providers::get() as $provider)
<option class="" value="{{ $provider->name }}">{{ $provider->name }}</option>
    @endforeach
</select>  
</div>
</div>

</div>
    </div>

    <div class="search-container" style="background: transparent !important;" id="searchbar_result"></div>
    <div class="container" id="bottom-search" style="display: none;">
            <div class="divider">
            <div class="line"></div>
            <div class="divider-title"><button style="margin-left: 5px;" class="btn btn-primary-small-dark randomize"><i class="fas fa-random"></i> Refresh</button>

            <select id="searchbar-showamount" class="btn btn-primary-small-dark">
                    <option style="color: black;" value="10">Show 10</option>
                    <option style="color: black;" value="20">Show 20</option>
                    <option style="color: black;" value="40">Show 40</option>
                    <option style="color: black;" value="100">Show 100</option>
            </select> 
            </div> 
            <div class="line"></div>
    </div>
</div>

    <div class="empty-between mt-4 mb-4"></div>
    <div class="divider">
            <div class="line-small-left"></div>
            <div class="divider-title-left"><i class="fas fa-mistletoe"></i> Popular</div>
            <div class="line-small-left"></div>
    </div>
    <div id="popular"></div>
          <div id="c0" class="container-flex owl-carousel o0" style="z-index: 1;">
        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '2')
          @if(auth()->guest())
                    <div onclick="$.auth()" class="game_long_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="game_long_thumbnail" style="background-image:url('/assets/i/long/jpg/{{ $slots->id }}.jpg');">
            @endif
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 30px;">
                    <span><b>{{ $slots->n }}</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 10px;">
                    <span style="font-size: 0.80rem">{{ $slots->desc }}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 25px;">
                    <div class="btn btn-primary-small-dark"><i style="color: #3db96d;" class="fad fa-play"></i> Play</div>
                </div>

                </div>
            </div>  
            @endif
        @endforeach
    </div>
          <div id="c1" class="container-flex owl-carousel o1" style="z-index: 1;">
        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '1')
          @if(auth()->guest())
                    <div onclick="$.auth()" class="game_long_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="game_long_thumbnail" style="background-image:url('/assets/i/long/jpg/{{ $slots->id }}.jpg');">
            @endif
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 30px;">
                    <span><b>{{ $slots->n }}</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 10px;">
                    <span style="font-size: 0.80rem">{{ $slots->desc }}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 25px;">
                    <div class="btn btn-primary-small-dark"><i style="color: #3db96d;" class="fad fa-play"></i> Play</div>
                </div>

                </div>
            </div>  
            @endif
        @endforeach
    </div>
    <div id="c2" class="container-flex owl-carousel o2" style="z-index: 1;">
        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '2')
          @if(auth()->guest())
                    <div onclick="$.auth()" class="game_long_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="game_long_thumbnail" style="background-image:url('/assets/i/long/jpg/{{ $slots->id }}.jpg');">
            @endif
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 30px;">
                    <span><b>{{ $slots->n }}</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 10px;">
                    <span style="font-size: 0.80rem">{{ $slots->desc }}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 25px;">
                    <div class="btn btn-primary-small-dark"><i style="color: #3db96d;" class="fad fa-play"></i> Play</div>
                </div>

                </div>
            </div>  
            @endif
        @endforeach
   </div>     
</div>
