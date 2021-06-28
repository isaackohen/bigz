var targetColor = 'red';
var number = [1, 14, 2, 13, 3, 12, 4, 0, 11, 5, 10, 6, 9, 7, 8];
var color = ['red', 'black', 'red', 'black', 'red', 'black', 'red', 'green', 'black', 'red', 'black', 'red', 'black', 'red', 'black'];
$.game('multiroulette', function (container, overviewData) {
  if (!$.isOverview(overviewData)) {
    var card = function card(id) {
	  return `<div class="multiroulette_card ${color[id]}" data-multiroulette="${number[id]}">
                <div class="hexagon">${number[id]}</div>`;
    };
    var clone = function clone() {
      for (var i = 0; i < 2; i++) {
        $('.multiroulette_container_row').append($('.multiroulette_container_row').children().clone(true, true));
      }
    };

    var spin = function spin(id) {
      $(".multiroulette_container_row").css({
        position: 'relative',
        left: 0
      });
      var amount = 15 * 2,
          gw = $('.multiroulette_card').outerWidth(true),
          center = gw / 2,
          containerCenter = $('.multiroulette_container').outerWidth(true) / 2;

	  var pos = id;
	  if(id == 1) pos--;
	  if(id == 3) pos++;
	  if(id == 4) pos+=2;
	  if(id == 5) pos+=4;
	  if(id == 6) pos+=5;
	  if(id == 7) pos+=6;
	  if(id == 8) pos+=6;
	  if(id == 9) pos+=3;
	  if(id == 11) pos+=12;
	  if(id == 12) pos+=8;
	  if(id == 13) pos+=5;
	  if(id == 14) pos+=2;
	  if(id == 0) pos+=7;
	  
      $('.multiroulette_container_row').stop().animate({
        left: "-=".concat(amount * gw + pos * gw - containerCenter + center)
      }, 6000);
    };

    container.append("\n            <div class=\"multirouletteCustomHistory\"></div>\n            <div class=\"multiroulette_container_line\"></div>\n            <div class=\"multiroulette_container\">\n                <div class=\"multiroulette_container_row\"></div>\n            </div>\n        ");
	var hex = {
      0: ['#e76376', '#d4d4d4'],
      1: ['#2a2f30', '#d4d4d4'],
      2: ['#3bc248', '#d4d4d4']
    };

    _.forEach($.multipliers().history, function (m) {
      var color = hex[0];
      if (m.color == 1 || m.color == 2 || m.color == 3 || m.color == 4 || m.color == 5 || m.color == 6 || m.color == 7) color = hex[0];else if (m.color == 14 || m.color == 13 || m.color == 12 || m.color == 11 || m.color == 10 || m.color == 9 || m.color == 8) color = hex[1];else if (m.color == 0) color = hex[2];
      $('.multirouletteCustomHistory').append($.customHistoryPopover($("<div class=\"multirouletteCustomHistoryElement\" style=\"cursor: pointer; background: ".concat(color[0], "; border-bottom: 2px solid ").concat(color[1], "\">").concat(m.color + '', "</div>")), {
        serverSeed: m.server_seed,
        clientSeed: m.client_seed,
        nonce: m.nonce
      }));
    });
	
	for (var i = 0; i < number.length; i++) {
        $('.multiroulette_container_row').append(card(i));
		$(".multiroulette_container_line").prependTo(".multiroulette_container");  
    }
	container.append(`<div class="multiroulette-bets"><div class="multirouletteMultiplayerTable red"><li class="multiroulette-info">Red Bets (2X)</li></div><div class="multirouletteMultiplayerTable green"><li class="multiroulette-info">Green Bets (14X)</li></div><div class="multirouletteMultiplayerTable black"><li class="multiroulette-info">Black Bets (2X)</li></div><div></div></div>`);
	_.forEach($.multipliers().players, function (data) {
      $(`.multirouletteMultiplayerTable.${data.data.target}`).append(`<div class="user" onclick="window.open('/user/${data.user._id}', '_blank')" style=""><div class="avatar"><img src="${data.user.avatar}" alt=""></div><div class="name">${data.user.name}</div><div class="bet">${$.getCookie('unit') == 'disabled' ? (data.game.wager).toFixed(8) : ('$' + (data.game.wager *  $.getPriceCurrencyByCrypto(data.game.currency)).toFixed(2))}<img style="margin-left:3px;" width="16px" height="16px" src="/img/currency/svg/${data.game.currency}.svg"></div></div>`);
	});

    clone();
    if ($.multipliers().timestamp === -1) spin($.multipliers().data.index);else {
      var now = +new Date() / 1000;
      var left = parseInt(now - $.multipliers().timestamp);
      if (left >= 0 && left <= 6) setRoundTimer(left);
    }
    $.multiplayer(function (event, data) {
      switch (event) {
        case 'MultiplayerBettingStateChange':
          if ($.currentBettingType() === 'manual') $('.play-button').toggleClass('disabled', !data.state);
          break;

        case 'MultiplayerGameBet':
          $(`.multirouletteMultiplayerTable.${data.data.target}`).append(`<div class="user" onclick="window.open('/user/${data.user._id}', '_blank')" style=""><div class="avatar"><img src="${data.user.avatar}" alt=""></div><div class="name">${data.user.name}</div><div class="bet">${$.getCookie('unit') == 'disabled' ? (data.game.wager).toFixed(8) : ('$' + (data.game.wager *  $.getPriceCurrencyByCrypto(data.game.currency)).toFixed(2))}<img style="margin-left:3px;" width="16px" height="16px" src="/img/currency/svg/${data.game.currency}.svg"></div></div>`);
          break;

        case 'MultiplayerGameFinished':
          $('.multiroulette_container_row').html('');
          	for (var i = 0; i < number.length; i++) {
				$('.multiroulette_container_row').append(card(i));
			}

          clone();
          spin(data.data.index);
          $.playSound('/sounds/bet.mp3', 150);
          setTimeout(function () {
            $("[data-multiroulette=\"".concat(data.data.index, "\"]")).addClass('selected');
            var color = hex[0];
            if (parseFloat(data.data.index) == 1 || parseFloat(data.data.index) == 2 || parseFloat(data.data.index) == 3 || parseFloat(data.data.index) == 4 || parseFloat(data.data.index) == 5 || parseFloat(data.data.index) == 6 || parseFloat(data.data.index) == 7) color = hex[0];
            if (parseFloat(data.data.index) == 14 || parseFloat(data.data.index) == 13 || parseFloat(data.data.index) == 12 || parseFloat(data.data.index) == 11 || parseFloat(data.data.index) == 10 || parseFloat(data.data.index) == 9 || parseFloat(data.data.index) == 8) color = hex[1];
            if (parseFloat(data.data.index) == 0) color = hex[2];
            var el = $.customHistoryPopover($("<div class=\"multirouletteCustomHistoryElement\" style=\"background: ".concat(color[0], "; border-bottom: 1px solid ").concat(color[1], "\">").concat(parseFloat(data.data.index) + '', "</div>")), {
              clientSeed: data.client_seed,
              serverSeed: data.server_seed,
              nonce: data.nonce 
            });
            $('.multirouletteCustomHistory').prepend(el);
            el.hide().slideDown('fast');
            $('.multirouletteCustomHistoryElement:nth-child(3)').remove();
			$.blockPlayButton(false);
          }, 6000);
          break;

        case 'MultiplayerTimerStart':
          var users = $('.multirouletteMultiplayerTable .user');
          setTimeout(function () {
            return users.slideUp('fast');
          }, 1000);
          setRoundTimer(6);
          break;
      }
    });
  }
}, function () {
  return {
    target: targetColor
  };
}, function () {
  if ($.currentBettingType() === 'manual') $('.play-button').addClass('disabled');
}, function (error) {
  $.error($.lang('general.error.unknown_error', {
    'code': error
  }));
});

var setRoundTimer = function setRoundTimer(seconds) {
  seconds *= 1000;
  $('.multiroulette-time').hide().stop().css({
    'width': '100%'
  }).fadeIn('fast').animate({
    'width': '0%'
  }, {
    duration: seconds,
    easing: 'linear'
  });
};

$.on('/game/multiroulette', function () {
  $.render('multiroulette');
  $.sidebar(function (component) {
    component.bet();
	component.buttons($.lang('general.color'))
		.add('x2.00', function() {
			targetColor = 'red';
		}, 'multiroulette-button multiroulette-button-red')
		.add('x14.00', function() {
			targetColor = 'green';
		}, 'multiroulette-button multiroulette-button-green')
		.add('x2.00', function() {
			targetColor = 'black';
		}, 'multiroulette-button multiroulette-button-black');
    component.history('multiroulette');
    $.history().add(function (e) {
      return e.addClass('multiroulette-time'); 
    });
	component.autoBets();
    component.play();
        component.footer().sound().stats();
  }, function() {
			$.sidebarData().currency(($.sidebarData().bet() * $.getPriceCurrency()).toFixed(4));
    });
  $(".multiroulette-bets").insertBefore(".game-history");
}, ['/css/pages/multiroulette.css']); 