
@php
use Carbon\Carbon;
@endphp
<?php
    $user = auth()->user();
    $explode = explode('?', $url);
    $name = $explode[1];
    $provider = \App\Slotslist::where('_id', $name)->first()->p;
    $freespinslot = \App\Settings::where('name', 'freespin_slot')->first()->value;
    $freespinevo = \App\Settings::where('name', 'evoplay_freespin_slot')->first()->value;
    $slotname = \App\Slotslist::get()->where('id', $freespinslot)->first()->n;
    $evoslotname = \App\Slotslist::get()->where('u_id', $freespinevo)->first()->n;
    $evoslotabsolute = \App\Slotslist::get()->where('u_id', $freespinevo)->first()->id;
    $slotregname = \App\Slotslist::where('_id', $name)->first()->n;


    ?>
    @if($name != $freespinslot && $user->freegames > 0)
  <div class="container-lg" style="z-index: 1;">

<div class="alert alert-info" role="alert">
  You still have {{ $user->freegames }} free spins. Please complete your free spins on {{ $slotname }} or {{ $evoslotname }} before playing other slots.
</div>
<button onclick="redirect('/slots/{{ $freespinslot }}')" class="btn btn-primary p-1 m-1">{{ $slotname }}</button> <button onclick="redirect('/slots-evo/{{ $evoslotabsolute }}')" class="btn btn-primary p-1 m-1">{{ $evoslotname }}</button> <button onclick="redirect('/help/')" class="btn btn-secondary p-1 m-1">Help</button>
</div>
<hr>
      @else



<style>
.live {
  display:  none;
}

.slotcontainer-name {
    background:  #263337;
    margin-top:  20px;
    margin-bottom:  20px;
    border-radius:  6px;
    padding:  6px;
}
</style>



<div id="slotcontainer-toggle" class="container-lg">
<div id="slotcontainer">

                <div class="gameWrapper">
                    <iframe src="<?php echo $url; ?>" border="0"></iframe>
                </div>



      <button onclick="toggleClass()" title="Return to Home" class="btn btn-primary-small-dark btn-rounded p-1 m-2" style="min-width: 45px; font-size: 13px;"><i class="fas fa-home"></i></button>
      <button id="fullscreeniframe" title="Play Full Screen" class="btn btn-primary-small-dark btn-rounded p-1 m-2 ripple-surface" style="min-width: 45px; font-size: 13px;"><i class="fas fa-expand"></i></button>
      <button onclick="toggleClass()" title="Toggle Width" class="btn btn-primary-small-dark btn-rounded p-1 m-2 ripple-surface" style="min-width: 45px; font-size: 12px;"><i class="far fa-rectangle-wide"></i></button>
    </div>
</div>

<div class="container-lg">
    <div class="slotcontainer-name">
    <span class="live-title">{{ $slotregname }}</span>
  </div>
</div>

<div class="container-lg">
          <div id="o5" class="container-flex owl-carousel o5" style="z-index: 1;">
        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '1')
          @if(auth()->guest())
                    <div onclick="$.auth()" class="game_long_thumbnail" style="background-image:url('/assets/game/preview/{{ $slots->UID }}.webp');">
                @else
                    <div onclick="redirect('/game/{{ $slots->UID }}')" class="game_long_thumbnail" style="margin-left: 30px !important;background-image:url('https://cdn.static.bet/i/long/jpg/{{ $slots->id }}.jpg');">
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

<div class="leaderboard-header">
    <div class="leaderboard-PageTitle">
        <div class="leaderboard-BackTitle">Leaderboard</div>
        <div class="leaderboard-TitleWrap">Leaderboard</div>
    </div>
    <div class="leaderboard-TabContainer">
        <div class="leaderboard-Tabs">
            <div class="leaderboard-TabGroup">
                <div class="leaderboard-Tab active">
                    Hourly
          <canvas class="ink" height="73.00000108778477" width="196.0000029206276" style="border-radius: inherit; height: 100%; left: 0px; position: absolute; top: 0px; width: 100%;"></canvas>
                </div>
                <div class="leaderboard-Tab">
                    Daily
          <canvas class="ink" height="73.00000108778477" width="196.0000029206276" style="border-radius: inherit; height: 100%; left: 0px; position: absolute; top: 0px; width: 100%;"></canvas>
                </div>
                <div class="leaderboard-Tab">
                    Weekly
          <canvas class="ink" height="73.00000108778477" width="196.0000029206276" style="border-radius: inherit; height: 100%; left: 0px; position: absolute; top: 0px; width: 100%;"></canvas>
                </div>
                <div class="leaderboard-TabFill"></div>
            </div>
        </div>
    
    <!--- test --->
    
    <!---
    
    now: {{ Carbon::now() }}
    hourly: {{ Carbon::now()->minute(59)->second(59) }}
    daily: {{ Carbon::now()->endOfDay() }}
    weekly: {{ Carbon::now()->endOfWeek() }}
    
    --->
      
    <!--- test end --->
    
        <div class="leaderboard-timerStyles-container">
            <div class="leaderboard-timerStyles-timer">
                <div class="leaderboard-container">
                    <div class="leaderboard-digit-wrapper">
                        <div id="days" class="leaderboard-digits">00</div>
                        <div class="leaderboard-label"><span>Day</span></div>
                    </div>
                    <span class="leaderboard-digits-colon">:</span>
                    <div class="leaderboard-digit-wrapper">
                        <div id="hours" class="leaderboard-digits">00</div>
                        <div class="leaderboard-label"><span>Hour</span></div>
                    </div>
                    <span class="leaderboard-digits-colon">:</span>
                    <div class="leaderboard-digit-wrapper">
                        <div id="minutes" class="leaderboard-digits">00</div>
                        <div class="leaderboard-label"><span>Min</span></div>
                    </div>
                    <span class="leaderboard-digits-colon">:</span>
                    <div class="leaderboard-digit-wrapper">
                        <div id="seconds" class="leaderboard-digits">00</div>
                        <div class="leaderboard-label"><span>Sec</span></div>
                    </div>
                </div>
            </div>
            <div class="leaderboard-timerbar">
                <div class="leaderboard-component-timer">
                    <div class="leaderboard-tracktimer"><div class="leaderboard-tracktimer-bar" style="background: rgb(51, 193, 108); width: 35.4231%;"></div></div>
                </div>
            </div>
        </div>
    </div>
  <!--- hourly --->
    <div class="leaderboard-Table">
        <div class="leaderboard-RowBase Header">
            <div class="leaderboard-cell1">#</div>
            <div class="leaderboard-cell2">Player</div>
            <div class="leaderboard-cell3"></div>
            <div class="leaderboard-cell4">Hourly Prize</div>
            <div class="leaderboard-cell5">Wagered</div>
        </div>
        <div class="leaderboard-RowGroup">
    
      @foreach (\App\Leaderboard::where('type', 'hourly')->where('currency', 'usd')->where('time', Carbon::now()->minute(59)->second(59)->timestamp)->orderBy('usd_wager', 'desc')->take(10)->get() as $entry)
            <div class="leaderboard-RowTable row-main" style="display: none;">
                <div class="leaderboard-user-num">{{ $loop->index + 1 }}</div>
                <div class="leaderboard-user-name">
        <a style="color: #cccccc;">
                    <div href="javascript:void(0)"  onclick="$.userinfo('{{ \App\User::where('_id', $entry->user)->first()->_id }}');" class="leaderboard-user-info">
            <div class="leaderboard-user-name-fix">{{ \App\User::where('_id', $entry->user)->first()->name }}</div>
          </div>
        </a>
                </div>
                <div class="leaderboard-user-fill"></div>
                <div class="leaderboard-user-wager">
                    <i class="fas fa-usd-circle" style="color: #02b320; margin-top: 2px; margin-right: 4px;"></i>
                    <div class="leaderboard-user-wager-info">--<span>.--</span></div>
                </div>
                <div class="leaderboard-user-wager">
                    <i class="fas fa-usd-circle" style="color: #02b320; margin-top: 2px; margin-right: 4px;"></i>
          @php
          $wager = number_format(floatval($entry->usd_wager), 2, '.', '');
          $wagerdecimal = explode('.', $wager);
          @endphp
                    <div class="leaderboard-user-wager-info">{{ number_format(floatval($wager), 0, '.', '') }}<span>.{{ $wagerdecimal[1] }}</span></div>
                </div>
            </div>
      @endforeach
        </div>
    </div>
  <!--- hourly end --->
    <!--- daily --->
    <div class="leaderboard-Table" style="display: none;">
        <div class="leaderboard-RowBase Header">
            <div class="leaderboard-cell1">#</div>
            <div class="leaderboard-cell2">Player</div>
            <div class="leaderboard-cell3"></div>
            <div class="leaderboard-cell4">Daily Prize</div>
            <div class="leaderboard-cell5">Wagered</div>
        </div>
        <div class="leaderboard-RowGroup">
      @foreach (\App\Leaderboard::where('type', 'daily')->where('currency', 'usd')->where('time', Carbon::now()->endOfDay()->timestamp)->orderBy('usd_wager', 'desc')->take(10)->get() as $entry)
            <div class="leaderboard-RowTable row-main" style="display: none;">
                <div class="leaderboard-user-num">{{ $loop->index + 1 }}</div>
                <div class="leaderboard-user-name">
        <a style="color: #cccccc;">
                    <div href="javascript:void(0)"  onclick="$.userinfo('{{ \App\User::where('_id', $entry->user)->first()->_id }}');" class="leaderboard-user-info">
            <div class="leaderboard-user-name-fix">{{ \App\User::where('_id', $entry->user)->first()->name }}</div>
          </div>
        </a>
                </div>
                <div class="leaderboard-user-fill"></div>
                <div class="leaderboard-user-wager">
                    <i class="fas fa-usd-circle" style="color: #02b320; margin-top: 2px; margin-right: 4px;"></i>
                    <div class="leaderboard-user-wager-info">--<span>.--</span></div>
                </div>
                <div class="leaderboard-user-wager">
                    <i class="fas fa-usd-circle" style="color: #02b320; margin-top: 2px; margin-right: 4px;"></i>
          @php
          $wager = number_format(floatval($entry->usd_wager), 2, '.', '');
          $wagerdecimal = explode('.', $wager);
          @endphp
                    <div class="leaderboard-user-wager-info">{{ number_format(floatval($wager), 0, '.', '') }}<span>.{{ $wagerdecimal[1] }}</span></div>
                </div>
            </div>
      @endforeach
        </div>
    </div>
  <!--- daily end --->
    <!--- weekly --->
    <div class="leaderboard-Table" style="display: none;">
        <div class="leaderboard-RowBase Header">
            <div class="leaderboard-cell1">#</div>
            <div class="leaderboard-cell2">Player</div>
            <div class="leaderboard-cell3"></div>
            <div class="leaderboard-cell4">Weekly Prize</div>
            <div class="leaderboard-cell5">Wagered</div>
        </div>
        <div class="leaderboard-RowGroup">
      @foreach (\App\Leaderboard::where('type', 'weekly')->where('currency', 'usd')->where('time', Carbon::now()->endOfWeek()->timestamp)->orderBy('usd_wager', 'desc')->take(10)->get() as $entry)
            <div class="leaderboard-RowTable row-main" style="display: none;">
                <div class="leaderboard-user-num">{{ $loop->index + 1 }}</div>
                <div class="leaderboard-user-name">
        <a style="color: #cccccc;">
                    <div href="javascript:void(0)"  onclick="$.userinfo('{{ \App\User::where('_id', $entry->user)->first()->_id }}');" class="leaderboard-user-info">
            <div class="leaderboard-user-name-fix">{{ \App\User::where('_id', $entry->user)->first()->name }}</div>
          </div>
        </a>
                </div>
                <div class="leaderboard-user-fill"></div>
                <div class="leaderboard-user-wager">
                    <i class="fas fa-usd-circle" style="color: #02b320; margin-top: 2px; margin-right: 4px;"></i>
                    <div class="leaderboard-user-wager-info">--<span>.--</span></div>
                </div>
                <div class="leaderboard-user-wager">
                    <i class="fas fa-usd-circle" style="color: #02b320; margin-top: 2px; margin-right: 4px;"></i>
          @php
          $wager = number_format(floatval($entry->usd_wager), 2, '.', '');
          $wagerdecimal = explode('.', $wager);
          @endphp
                    <div class="leaderboard-user-wager-info">{{ number_format(floatval($wager), 0, '.', '') }}<span>.{{ $wagerdecimal[1] }}</span></div>
                </div>
            </div>
      @endforeach
        </div>
    </div>
  <!--- weekly end --->
</div>


        @endif
  <script>

  const containerElement = document.getElementById("slotcontainer-toggle");
  function toggleClass() {
  const newClass = containerElement.className == "container-lg" ? "container-fluid slotcontainer-big" : "container-lg";
  containerElement.className = newClass;
  }
  (function(window, document){
  var $ = function(selector,context){return(context||document).querySelector(selector)};
  var iframe = $("iframe"),
  domPrefixes = 'Webkit Moz O ms Khtml'.split(' ');
  var fullscreen = function(elem) {
  var prefix;
  // Mozilla and webkit intialise fullscreen slightly differently
  for ( var i = -1, len = domPrefixes.length; ++i < len; ) {
  prefix = domPrefixes[i].toLowerCase();
  if ( elem[prefix + 'EnterFullScreen'] ) {
  // Webkit uses EnterFullScreen for video
  return prefix + 'EnterFullScreen';
  break;
  } else if( elem[prefix + 'RequestFullScreen'] ) {
  // Mozilla uses RequestFullScreen for all elements and webkit uses it for non video elements
  return prefix + 'RequestFullScreen';
  break;
  }
  }
  return false;
  };
  // Webkit uses "requestFullScreen" for non video elements
  var fullscreenother = fullscreen(document.createElement("iframe"));
  if(!fullscreen) {
  alert("Fullscreen won't work, please make sure you're using a browser that supports it and you have enabled the feature");
  return;
  }
  $("#fullscreeniframe").addEventListener("click", function(){
  // iframe fullscreen and non video elements in webkit use request over enter
  iframe[fullscreenother]();
  }, false);
  })(this, this.document);
  </script>