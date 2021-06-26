          @if(auth()->guest())
                    <div style="margin-top: 80px;"></div>
            @endif


<div class="container-xl"> 
    <div class="container mt-4 mb-4">
            <input type="text" id="gamelist-search" placeholder="Search game or provider..">
    </div>

    <div class="divider">
                <div class="line-small-left"></div>
                <div class="divider-title-left"><i class="fas fa-club"></i> BIGZ.IO Games</div>
                <div class="line-small-left"></div>
    </div>

    <div class="container-flex owl-carousel bigzgames" style="z-index: 1;">
        @foreach(\App\Games\Kernel\Game::list() as $game)
        @if(!$game->isDisabled() &&  $game->metadata()->id() !== "slotmachine" && $game->metadata()->id() !== "evoplay" && $game->metadata()->id() !== "livecasino")

            <div class="bigz_thumbnail" @if(!$game->isDisabled()) onclick="redirect('/game/{{ $game->metadata()->id() }}')" @endif style="background-image: url('/assets/turnkey/thumbnail/{{ $game->metadata()->id() }}.png')">

                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 5px;">
                    <span style="font-size: 0.80rem">{{ $game->metadata()->name() }}</span>
                </div>
                    
                </div>
            </div>  
        @endif
        @endforeach
                    <div onclick="redirect('/slots/')" class="bigz_thumbnail" style="background-image:url(/img/misc/gameposter-bigz.webp);">


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
    
        <div class="empty-between mt-5 mb-5"></div>


    <div class="divider">
                <div class="line-small-left"></div>
                <div class="divider-title-left"><i class="fas fa-club"></i> Recommended for you</div>
                <div class="line-small-left"></div>
    </div>

    <div class="container-flex owl-carousel casinogames" style="z-index: 1;">

        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '3'|| $slots->p == 'upgames')

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
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="casino_thumbnail" style="background-image:url('https://cdn.static.bet/i/wide/{{ $slots->p }}/{{ $slots->id }}.jpg');">
                        @endif
            @endif


                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 2px;">
                    <span><b>{{ $slots->n }}</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 5px;">
                    <span style="font-size: 0.80rem">{{ $slots->desc }}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 10px;">
                    <div class="btn btn-primary-small m-1">Play</div>
                </div>

                </div>
            </div>  
            @endif
        @endforeach
</div>

    <div class="empty-between mt-4 mb-4"></div>
    <div class="divider">
                <div class="line-small-left"></div>
                <div class="divider-title-left"><i class="fas fa-mistletoe"></i> Popular</div>
                <div class="line-small-left"></div>
    </div>

    <div id="popular"></div>
          <div id="c1" class="container-flex owl-carousel o1" style="z-index: 1;">
        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '1')
          @if(auth()->guest())
                    <div onclick="$.auth()" class="game_long_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="game_long_thumbnail" style="background-image:url('https://cdn.static.bet/i/long/jpg/{{ $slots->id }}.jpg');">
            @endif
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 2px;">
                    <span><b>{{ $slots->n }}</b></span>
                </div>
                <div class="gamename" style="text-transform: uppercase; display: flex; justify-content: center; margin-top: 1px;">
                    <span style="font-size: 0.65rem">{{ $slots->p }}</span>
                </div>
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 10px;">
                    <span style="font-size: 0.80rem">{{ $slots->desc }}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 25px;">
                    <div class="btn btn-primary-small m-1">Play</div>
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
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="game_long_thumbnail" style="background-image:url('https://cdn.static.bet/i/long/jpg/{{ $slots->id }}.jpg');">
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
                    <div class="btn btn-primary-small m-1">Play</div>
                </div>

                </div>
            </div>  
            @endif
        @endforeach
   </div>     
</div>
