
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



      <button onclick="redirect('/poker/')" title="Return to Home" class="btn btn-primary-small-dark btn-rounded p-1 m-2" style="min-width: 45px; font-size: 13px;"><i class="fas fa-home"></i></button>
      <button id="fullscreeniframe" title="Play Full Screen" class="btn btn-primary-small-dark btn-rounded p-1 m-2 ripple-surface" style="min-width: 45px; font-size: 13px;"><i class="fas fa-expand"></i></button>
    </div>
</div>

<div class="container-lg">
    <div class="slotcontainer-name">
    <span class="live-title">{{ $slotregname }}</span>
  </div>
</div>

<div class="container-lg">
          <div id="o5" class="container owl-carousel o5" style="z-index: 1;">
        @foreach(\App\Slotslist::get()->shuffle() as $slots)
                    @if($slots->f == '1')
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