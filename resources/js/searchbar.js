$.displaySearchBar = function() {
    $('.searchbar-overlay').fadeToggle('fast');
    $('.searchbar').toggleClass('active');
    $('#searchoverlay_result').html('');
};

$(document).ready(function() {
    $(document).on('click', '.searchbar-overlay, .searchbar [data-close-searchbar]', $.displaySearchBar);

    
var typingTimer;
var doneTypingInterval = 300; 
    
$('#searchbar').keypress(function(){
    clearTimeout(typingTimer);
    if ($('#searchbar').val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }
}); 

$('#searchbaroverlay').keypress(function(){
    clearTimeout(typingTimer);
    if ($('#searchbaroverlay').val()) {
        typingTimer = setTimeout(doneTypingOverlay, doneTypingInterval);
    }
}); 

$.selectProviderOverlay = function() {
            var provider = $('#searchoverlay-provider').val();
            var showamount = $('#searchoverlay-showamount').val();
            $.request('search/provider', { provider: provider, showamount: showamount }).then(function(response) {
                $('#searchoverlay_result').html('');
                $('#overlay-search').hide();
                var data = response;
                var result = data.map(function(response){
                    var linkslot = function(){
                        if(response.p == 'evoplay'){
                            return `onclick="redirect('/slots-evo/${response.UID}')"`;
                        } else {
                            return `onclick="redirect('/slots/${response.UID}')"`;
                        }
                    };
                    return `
            <div onclick="redirect('/game/${response.UID}')" class="search_thumbnail" style="background-image:url('https://cdn.static.bet/i/wide/${response.p}/${response._id}.jpg');">
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 15px;">
                    <span><b>${response.n}</b></span>
                </div>
                <div class="gameprovider">
                    <span>${response.p}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 5px;">
                    <div class="btn btn-primary-small m-1">Play</div>
                </div>
                <div class="gamedesc">
                    <span>${response.desc}</span>
                </div>
                </div>
            </div>`;

                });
                $('#searchoverlay_result').append(result);
                $('#overlay-search').show();
            }, function (error) {
                    $('#searchoverlay_result').html('');
                }
            );
    
};



$.selectProvider = function() {
            var provider = $('#searchbar-provider').val();
            var showamount = $('#searchbar-showamount').val();
            $.request('search/provider', { provider: provider, showamount: showamount }).then(function(response) {
                $('#searchbar_result').html('');
                $('#bottom-search').hide();
                var data = response;
                var result = data.map(function(response){
                    var linkslot = function(){
                        if(response.p == 'evoplay'){
                            return `onclick="redirect('/slots-evo/${response.UID}')"`;
                        } else {
                            return `onclick="redirect('/slots/${response.UID}')"`;
                        }
                    };
                    return `
            <div onclick="redirect('/game/${response.UID}')" class="search_thumbnail" style="background-image:url('https://cdn.static.bet/i/wide/${response.p}/${response._id}.jpg');">
                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 15px;">
                    <span><b>${response.n}</b></span>
                </div>
                <div class="gameprovider">
                    <span>${response.p}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 5px;">
                    <div class="btn btn-primary-small m-1">Play</div>
                </div>
                <div class="gamedesc">
                    <span>${response.desc}</span>
                </div>
                </div>
            </div>`;

                });
                $('#searchbar_result').append(result);
                $('#bottom-search').show();
            }, function (error) {
                    $('#searchbar_result').html('');
                }
            );
    
};

    $('.overlayrandomize').on('click', function() {
            var text = $('#searchbaroverlay').val();
            var showamount = $('#searchoverlay-showamount').val();
            $.request('search/random', { text: text, showamount: showamount }).then(function(response) {
                $('#searchoverlay_result').html('');
                $('#overlay-search').hide();
                var data = response;
                var result = data.map(function(response){
                    var linkslot = function(){
                        if(response.p == 'evoplay'){
                            return `onclick="redirect('/slots-evo/${response.UID}')"`;
                        } else {
                            return `onclick="redirect('/slots/${response.UID}')"`;
                        }
                    };
                    return `
                <div onclick="redirect('/game/${response.UID}')" class="search_thumbnail" style="background-image:url('https://cdn.static.bet/i/wide/${response.p}/${response._id}.jpg');">
                                    

                <div class="name">
                <div class="gametitle" style="display: flex; justify-content: center; margin-top: 15px;">
                    <span><b>${response.n}</b></span>
                </div>
                <div class="gameprovider">
                    <span>${response.p}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 5px;">
                    <div class="btn btn-primary-small m-1">Play</div>
                </div>
                <div class="gamedesc">
                    <span>${response.desc}</span>
                </div>


                </div>
                </div>
                    `;

                });

                $('#searchoverlay_result').append(result);
                $('#overlay-search').show();

            });
});

    
    $('.randomize').on('click', function() {
            var text = $('#searchbar').val();
            var showamount = $('#searchbar-showamount').val();
            $.request('search/random', { text: text, showamount: showamount }).then(function(response) {
                $('#searchbar_result').html('');
                $('#bottom-search').hide();
                var data = response;
                var result = data.map(function(response){
                    var linkslot = function(){
                        if(response.p == 'evoplay'){
                            return `onclick="redirect('/slots-evo/${response.UID}')"`;
                        } else {
                            return `onclick="redirect('/slots/${response.UID}')"`;
                        }
                    };
                    return `
                <div onclick="redirect('/game/${response.UID}')" class="search_thumbnail" style="background-image:url('https://cdn.static.bet/i/wide/${response.p}/${response._id}.jpg');">
                                    

                <div class="name">
                <div class="gametitle" style="display: flex; justify-content: center; margin-top: 15px;">
                    <span><b>${response.n}</b></span>
                </div>
                <div class="gameprovider">
                    <span>${response.p}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 5px;">
                    <div class="btn btn-primary-small m-1">Play</div>
                </div>
                <div class="gamedesc">
                    <span>${response.desc}</span>
                </div>


                </div>
                </div>
                    `;

                });

                $('#searchbar_result').append(result);
                $('#bottom-search').show();

            });
});
   

function doneTypingOverlay () {
            var text = $('#searchbaroverlay').val();
            var showamount = $('#searchoverlay-showamount').val();
            $.request('search/games', { text: text, showamount: showamount }).then(function(response) {
                $('#searchoverlay_result').html('');
                $('#overlay-search').hide();
                var data = response;

                var result = data.map(function(response){
                    var linkslot = function(){
                        if(response.p == 'evoplay'){
                            return `onclick="redirect('/slots-evo/${response.UID}')"`;
                        } else {
                            return `onclick="redirect('/slots/${response.UID}')"`;
                        }
                    };
                    return `


            <div onclick="redirect('/game/${response.UID}')" class="search_thumbnail" style="background-image:url('https://cdn.static.bet/i/wide/${response.p}/${response._id}.jpg');">
                                    

                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 15px;">
                    <span><b>${response.n}</b></span>
                </div>
                <div class="gameprovider">
                    <span>${response.p}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 5px;">
                    <div class="btn btn-primary-small m-1">Play</div>
                </div>
                <div class="gamedesc">
                    <span>${response.desc}</span>
                </div>


                </div>
            </div>

                    `;

                });
                $('#searchoverlay_result').append(result);
                $('#overlay-search').show();
            });
}
    

function doneTyping () {
            var text = $('#searchbar').val();
            var showamount = $('#searchbar-showamount').val();
            $.request('search/games', { text: text, showamount: showamount }).then(function(response) {
                $('#searchbar_result').html('');
                $('#bottom-search').hide();
                var data = response;

                var result = data.map(function(response){
					var linkslot = function(){
						if(response.p == 'evoplay'){
							return `onclick="redirect('/slots-evo/${response.UID}')"`;
						} else {
							return `onclick="redirect('/slots/${response.UID}')"`;
						}
					};
                    return `


            <div onclick="redirect('/game/${response.UID}')" class="search_thumbnail" style="background-image:url('https://cdn.static.bet/i/wide/${response.p}/${response._id}.jpg');">
                                    

                <div class="name">
                <div class="gamename" style="display: flex; justify-content: center; margin-top: 15px;">
                    <span><b>${response.n}</b></span>
                </div>
                <div class="gameprovider">
                    <span>${response.p}</span>
                </div>
                <div class="button" style="display: flex; justify-content: center; margin-top: 5px;">
                    <div class="btn btn-primary-small m-1">Play</div>
                </div>
                <div class="gamedesc">
                    <span>${response.desc}</span>
                </div>


                </div>
            </div>

                    `;

                });
                $('#searchbar_result').append(result);
                $('#bottom-search').show();
                $('.img-small-slots').lazy({
                        bind: "event"
                    });
            });
}
    
});