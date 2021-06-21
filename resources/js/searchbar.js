$.displaySearchBar = function() {
    $('.searchbar-overlay').fadeToggle('fast');
    $('.searchbar').toggleClass('active');
};

$(document).ready(function() {
    $(document).on('click', '.searchbar-overlay, .searchbar [data-close-searchbar]', $.displaySearchBar);

    
var typingTimer;
var doneTypingInterval = 300; 
    
$('#searchbar').keyup(function(){
    clearTimeout(typingTimer);
    if ($('#searchbar').val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }
}); 




    
    $('.randomize').on('click', function() {
            var text = $('#searchbar').val();
            $.request('search/random', { text: text }).then(function(response) {
                $('#searchbar_result').html('');
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

            });
});
    

function doneTyping () {
            var text = $('#searchbar').val();
            $.request('search/games', { text: text }).then(function(response) {
                $('#searchbar_result').html('');
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
                   $('.img-small-slots').lazy({
                        bind: "event"
                    });
            });
}
    
});