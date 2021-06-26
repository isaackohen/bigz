@php
    $game = \App\Games\Kernel\Game::find($data);
    if($game == null || $game->isDisabled()) {

    if($get = \App\Slotslist::get()->where('id', $data)->first()) {
    $slotuid = ($get->UID);
    header("Location:/game/slot/".$slotuid);
    }
    else {
    
    header("Location:/game/slot/".$data);
       
    }

        die();
    }
@endphp
<div class="container-lg" id="gamecontainer">

    <div class="game-container mt-1">
        <div class="row">
            <div class="col {{-- d-none d-md-block --}}">
                <div class="game-sidebar"></div>
            </div>
            <div class="col">
                <div class="game-content"></div>
            </div>
        </div>
 </div>
 </div>

@if(!auth()->guest())
    @php $latest_game = \App\Game::latest()->where('game', $data)->where('user', auth()->user()->_id)->where('status', 'in-progress')->first(); @endphp
    @if(!is_null($latest_game))
        <script type="text/javascript">
            window.restoreGame = {
                'game': {!! json_encode($latest_game->makeHidden('server_seed')->makeHidden('nonce')->makeHidden('data')->toArray()) !!},
                'history': {!! json_encode($latest_game->data['history']) !!},
                'user_data': {!! json_encode($latest_game->data['user_data']) !!}
            };
        </script>
    @else
        <script type="text/javascript">
            window.restoreGame = undefined;
        </script>
    @endif
@endif

 