

<div class="container-fluid" style="max-width: 1450px;">
    <div class="text-body-box">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="earn_header">
                    <h3><b>Start Earning!</b></h3>
                    <p>Complete offers, fill out surveys and get ETH instantly credited to your account. </p>

                    <div class="alert alert-success mb-4 p-2 text-center" role="alert">All completed offers & surveys are instantly credited to your BitsArcade.com account.</div>
                </div>
            </div>
        </div>
    
    <div class="earnTabs">
        <div class="earnTab active" data-toggle-earn-tab="offertoro"><b>Offertoro</b></div>
    </div>
    <div class="earnTabContent" data-earn-tab="adgems" style="display: none">
        <div class="empty-nomargin-box">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="earn-container">
                       
@if(!auth()->guest())
<iframe src="https://api.adgem.com/v1/wall?appid=3901&playerid={{ auth()->user()->_id }}" style="position:inherit; top:0px; left:0px; bottom:0px; right:0px; width:100%; overflow:hidden;
 height:100%; min-height: 650px; border:none; margin:0; padding:0;  z-index:999999;">Your browser doesn't support iframes</iframe>

@else
You need to be logged in to see Adgem earn offers.
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="earnTabContent" data-earn-tab="offertoro">
        <div class="empty-nomargin-box">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="earn-container">
@if(!auth()->guest())
<iframe src="https://www.offertoro.com/ifr/show/27392/{{ auth()->user()->_id }}/11826" style="position:inherit; top:0px; left:0px; bottom:0px; right:0px; width:100%; overflow:hidden;
 height:100%; min-height: 650px; border:none; margin:0; padding:0;  z-index:999999;">Your browser doesn't support iframes</iframe>
@else
You need to be logged in to see Offertoro earn offers.
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="earnTabContent" data-earn-tab="more" style="display: none">
        <div class="-box">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="earn_container">
@if(!auth()->guest())
<iframe src="https://wall.adgaterewards.com/n6yaqA/{{ auth()->user()->_id }}" style="position:inherit; top:0px; left:0px; bottom:0px; right:0px; width:100%; overflow:hidden;
 height:100%; min-height: 650px; border:none; margin:0; padding:0;  z-index:999999;">Your browser doesn't support iframes</iframe>

@else
You need to be logged in to see Adgatemedia earn offers.
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
<br><br>
