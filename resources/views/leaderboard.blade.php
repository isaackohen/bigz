@php
use Carbon\Carbon;
@endphp
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