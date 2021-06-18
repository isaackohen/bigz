
@php
@endphp    
<?php
    $user = auth()->user();
    $explode = explode('?', $url);
    $name = $explode[1];
    $provider = "evoplay";
    $freespinslot = \App\Settings::where('name', 'freespin_slot')->first()->value;
    $slotname = \App\Slotslist::get()->where('id', $freespinslot)->first()->n;

    ?>
    @if($name != $freespinslot && $user->freegames > 2222)
  <div class="container-lg" style="z-index: 1;">

<div class="alert alert-danger" role="alert">
  You still have {{ $user->freegames }} free spins on {{ $slotname }}. Please complete your free spins on {{ $slotname }} before playing other slots.
</div>
<button onclick="redirect('/slots/{{ $freespinslot }}')" class="btn btn-primary p-1 m-1">Start Free Spins</button> <button onclick="redirect('/help/')" class="btn btn-secondary p-1 m-1">Help</button>
</div>
<hr>
      @else
<div id="slotcontainer" class="container">
  <div class="card p-1" style="background: #1a1d29;">
    <div id=parent>
      <iframe src="{{ isset($url) ? $url : ''  }}" border="0"></iframe>
    <div class="container">
      <button onclick="redirect('/')" title="Return to Home" class="btn btn-info p-1 m-1 ripple-surface" style="min-width: 45px; font-size: 12px;"><i class="fas fa-home"></i></button>
      <button id="fullscreeniframe" title="Play Full Screen" class="btn btn-secondary p-1 m-1 ripple-surface" style="min-width: 45px; font-size: 12px;"><i class="fas fa-expand"></i></button>
      <button onclick="toggleClass()" title="Toggle Width" class="btn btn-secondary p-1 m-1 ripple-surface" style="min-width: 45px; font-size: 12px;"><i class="far fa-rectangle-wide"></i></button>
      <button onclick="$.leaderboard()" title="Leaderboard" class="btn btn-secondary p-1 m-1 ripple-surface" style="min-width: 45px; font-size: 12px;"><i class="fad fa-trophy"></i></button>
    </div>
    </div>
  </div>
</div>

<div class="container-lg">
  <div class="bonus-box-small mt-3 mb-3" style="z-index: 1;">
  <button onclick="redirect('/provider/{{ $provider }}')" style="padding-top: 5px; font-size: 10px; padding-left: 10px;" class="btn btn-success m-2 p-1">More {{ $provider }}</a></button>
  <h5 style="padding-top: 9px; padding-left: 6px; font-weight: 600;">Relevant Games</h5>
  <div class="container-flex owl-carousel relevantgames"  style="z-index: 1;">
    @foreach(\App\Slotslist::all()->where('p', $provider)->random(10) as $slots)
    <div class="card gamepostercard" style="cursor: pointer; margin-left: 10px; margin-right: 10px;">
      @if(!auth()->guest())
      <div onclick="redirect('/slots-evo/{{ $slots->id }}')" class="game_poster" style="background-image:url(/img/slots-wide/{{ $slots->p }}/{{ $slots->id }}.webp)">
        @else
        <div onclick="$.auth()" class="game_poster" style="background-image:url(/img/slots-wide/{{ $slots->p }}/{{ $slots->id }}.webp)">
          @endif
          <div class="label">
            {{ $slots->p }}
          </div>
        </div>
        <div class="card-footer">
        <h7 class="card-title">{{ $slots->n }}</h7></div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="bonus-box-small mt-3 mb-3" style="z-index: 1;">
    @if(!auth()->guest())<div style="cursor: pointer; padding-top: 11px; padding-left: 4px; font-weight: 600;" class="action" onclick="$.displaySearchBar()"><i class="fas fa-search"></i></div>@endif
    <div id="customNav1" class="owl-nav"></div>
    <h5 style="padding-top: 9px; padding-left: 7px; font-weight: 600;">Random Games</h5>
    <div class="container-flex owl-carousel randomgames"  style="z-index: 1;">
      @foreach(\App\Slotslist::all()->random(15) as $slots)
      <div class="card gamepostercard" style="cursor: pointer; margin-left: 10px; margin-right: 10px;">
        @if(!auth()->guest())
        <div onclick="redirect('/slots/{{ $slots->id }}')" class="game_poster" style="background-image:url(/img/slots-wide/{{ $slots->p }}/{{ $slots->id }}.webp)">
          @else
          <div onclick="$.auth()" class="game_poster" style="background-image:url(/img/slots-wide/{{ $slots->p }}/{{ $slots->id }}.webp)">
            @endif
            <div class="label">
              {{ $slots->p }}
            </div>
          </div>
          <div class="card-footer">
          <h7 class="card-title">{{ $slots->n }}</h7></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
        @endif

  <script>
  const containerElement = document.getElementById("slotcontainer");
  function toggleClass() {
  const newClass = containerElement.className == "container" ? "container-fluid" : "container";
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