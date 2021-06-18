var targetColor = 'red';
var number = [1, 14, 2, 13, 3, 12, 4, 0, 11, 5, 10, 6, 9, 7, 8];
var color = ['red', 'black', 'red', 'black', 'red', 'black', 'red', 'green', 'black', 'red', 'black', 'red', 'black', 'red', 'black'];
$.game('double', function (container, overviewData) {
  if (!$.isOverview(overviewData)) {
    var card = function card(id) {
	  return `<div class="double_card ${color[id]}" data-double="${number[id]}">
                <div class="hexagon">${number[id]}</div>`;
    };
    var clone = function clone() {
      for (var i = 0; i < 2; i++) {
        $('.double_container_row').append($('.double_container_row').children().clone(true, true));
      }
    };

    var spin = function spin(id) {
      $(".double_container_row").css({
        position: 'relative',
        left: 0
      });
      var amount = 15 * 2,
          gw = $('.double_card').outerWidth(true),
          center = gw / 2,
          containerCenter = $('.double_container').outerWidth(true) / 2;

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
	  
      $('.double_container_row').stop().animate({
        left: "-=".concat(amount * gw + pos * gw - containerCenter + center)
      }, 6000);
    };

    container.append("\n            <div class=\"doubleCustomHistory\"></div>\n            <div class=\"double_container_line\"></div>\n            <div class=\"double_container\">\n                <div class=\"double_container_row\"></div>\n            </div>\n        ");
	var hex = {
      0: ['#a32622', '#d4d4d4'],
      1: ['#3f3f3f', '#d4d4d4'],
      2: ['#3d863e', '#d4d4d4']
    };

    _.forEach($.multipliers().history, function (m) {
      var color = hex[0];
      if (m.color == 1 || m.color == 2 || m.color == 3 || m.color == 4 || m.color == 5 || m.color == 6 || m.color == 7) color = hex[0];else if (m.color == 14 || m.color == 13 || m.color == 12 || m.color == 11 || m.color == 10 || m.color == 9 || m.color == 8) color = hex[1];else if (m.color == 0) color = hex[2];
      $('.doubleCustomHistory').append($.customHistoryPopover($("<div class=\"doubleCustomHistoryElement\" style=\"cursor: pointer; background: ".concat(color[0], "; border-bottom: 2px solid ").concat(color[1], "\">").concat(m.color + '', "</div>")), {
        serverSeed: m.server_seed,
        clientSeed: m.client_seed,
        nonce: m.nonce
      }));
    });
	
	for (var i = 0; i < number.length; i++) {
        $('.double_container_row').append(card(i));
		$(".double_container_line").prependTo(".double_container");  
    }
	container.append(`<div class="double-bets"><div class="doubleMultiplayerTable red"><li class="double-info">ALL BETS 2X</li></div><div class="doubleMultiplayerTable green"><li class="double-info">ALL BETS 14X</li></div><div class="doubleMultiplayerTable black"><li class="double-info">ALL BET 2X</li></div><div></div></div>`);
	_.forEach($.multipliers().players, function (data) {
      $(`.doubleMultiplayerTable.${data.data.target}`).append(`<div class="user" onclick="window.open('/user/${data.user._id}', '_blank')" style=""><div class="avatar"><img src="${data.user.avatar}" alt=""></div><div class="name">${data.user.name}</div><div class="bet">${(data.game.wager).toFixed(8)}<i class="${window.Laravel.currency[data.game.currency].icon}" style="color: ${window.Laravel.currency[data.game.currency].style}"></i></div></div>`);
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
          $(`.doubleMultiplayerTable.${data.data.target}`).append(`<div class="user" onclick="window.open('/user/${data.user._id}', '_blank')" style=""><div class="avatar"><img src="${data.user.avatar}" alt=""></div><div class="name">${data.user.name}</div><div class="bet">${(data.game.wager).toFixed(8)}<i class="${window.Laravel.currency[data.game.currency].icon}" style="color: ${window.Laravel.currency[data.game.currency].style}"></i></div></div>`);
          break;

        case 'MultiplayerGameFinished':
          $('.double_container_row').html('');
          	for (var i = 0; i < number.length; i++) {
				$('.double_container_row').append(card(i));
			}

          clone();
          spin(data.data.index);
          setTimeout(function () {
            $("[data-double=\"".concat(data.data.index, "\"]")).addClass('selected');
            var color = hex[0];
            if (parseFloat(data.data.index) == 1 || parseFloat(data.data.index) == 2 || parseFloat(data.data.index) == 3 || parseFloat(data.data.index) == 4 || parseFloat(data.data.index) == 5 || parseFloat(data.data.index) == 6 || parseFloat(data.data.index) == 7) color = hex[0];
            if (parseFloat(data.data.index) == 14 || parseFloat(data.data.index) == 13 || parseFloat(data.data.index) == 12 || parseFloat(data.data.index) == 11 || parseFloat(data.data.index) == 10 || parseFloat(data.data.index) == 9 || parseFloat(data.data.index) == 8) color = hex[1];
            if (parseFloat(data.data.index) == 0) color = hex[2];
            var el = $.customHistoryPopover($("<div class=\"doubleCustomHistoryElement\" style=\"background: ".concat(color[0], "; border-bottom: 1px solid ").concat(color[1], "\">").concat(parseFloat(data.data.index) + '', "</div>")), {
              clientSeed: data.client_seed,
              serverSeed: data.server_seed,
              nonce: data.nonce
            });
            $('.doubleCustomHistory').prepend(el);
            el.hide().slideDown('fast');
            $('.doubleCustomHistoryElement:nth-child(3)').remove();
			$.blockPlayButton(false);
          }, 6000);
          break;

        case 'MultiplayerTimerStart':
          var users = $('.doubleMultiplayerTable .user');
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
  $('.double-time').hide().stop().css({
    'width': '100%'
  }).fadeIn('fast').animate({
    'width': '0%'
  }, {
    duration: seconds,
    easing: 'linear'
  });
};

$.on('/game/double', function () {
  $.render('double');
  $.sidebar(function (component) {
    component.bet();
	component.buttons($.lang('general.color'))
		.add('x2.00', function() {
			targetColor = 'red';
		}, 'double-button double-button-red')
		.add('x14.00', function() {
			targetColor = 'green';
		}, 'double-button double-button-green')
		.add('x2.00', function() {
			targetColor = 'black';
		}, 'double-button double-button-black');
    component.history('double');
    $.history().add(function (e) {
      return e.addClass('double-time');
    });
	component.autoBets();
    component.play();
        component.footer().sound().stats();
  }, function() {
			$.sidebarData().currency(($.sidebarData().bet() * $.getPriceCurrency()).toFixed(4));
    });
  $(".double-bets").insertBefore(".game-history");
}, ['/css/pages/double.css']); 