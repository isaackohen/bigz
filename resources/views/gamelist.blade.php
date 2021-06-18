<div class="container-xl">
    
    <div class="container mt-4 mb-4">
            <input type="text" id="gamelist-search" placeholder="Search game or provider..">

            </div>

                            <div id="casinoarrows"></div>

          <div class="container-flex owl-carousel casinogames" style="z-index: 1;">

        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '3'|| $slots->p == 'upgames')

          @if(auth()->guest())          
                    <div onclick="$.auth()" class="casino_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                @else
                        @if($slots->p == 'upgames')
                    <div onclick="redirect('/live/{{ $slots->UID }}')" class="casino_thumbnail" style="background-image:url('https://cdn.static.bet/i/wide/{{ $slots->p }}/{{ $slots->id }}.jpg');">
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

            <hr>

                                        <div id="popular"></div>


          <div id="c1" class="container-flex owl-carousel o1" style="z-index: 1;">

        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '1')

          @if(auth()->guest())
                    <div onclick="$.auth()" class="slots_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="slots_thumbnail" style="background-image:url('https://cdn.static.bet/i/long/jpg/{{ $slots->id }}.jpg');">
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
                    <div onclick="$.auth()" class="slots_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="slots_thumbnail" style="background-image:url('https://cdn.static.bet/i/long/jpg/{{ $slots->id }}.jpg');">
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
        



</div>
