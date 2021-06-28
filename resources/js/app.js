require('velocity-animate');

require('jquery-pjax');

import 'owl.carousel';

import { modal } from 'mdb-ui-kit'; // module

require('./routes');
require('./toast');
require('./game');

require('./chat');
require('./profit-monitoring');
require('./notifications');
require('./searchbar');


import bitcoin from 'bitcoin-units';

import NProgress from 'nprogress';
import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;

const feather = require('feather-icons');
const clipboard = require('clipboard-polyfill');

const container = '.pageContent';
let cachedResources = [];
let loadedContents = null;



$.on = function(route, callback, cssUrls = []) {
    $(document).on(`page:${route.substr(1)}`, function() {
        $.loadCSS(cssUrls, callback);
    });
};


       
const initializeRoute = function() {
    let route = $.routes()[`/${$.currentRoute()}`];
    if(route === undefined) {
        $.loadCSS([], () => {});
        console.error(`/${$.currentRoute()} is not routed`);
        NProgress.done();
    } else {
        $.loadScripts(route, function () {
            $(document).trigger(`page:${$.currentRoute()}`);

            let pathname = window.location.pathname.substr(1);
            if(pathname !== $.currentRoute()) $(document).trigger(`page:${window.location.pathname.substr(1)}`);
        });
    }

    // Bootstrap helpers
    $('.tooltip').remove();
    $('[data-toggle="popover"]').popover('hide');

    $('[data-toggle="popover"]').popover();
    $('[data-toggle="popover"]').on('click', function() {
        $(this).toggleClass('popover-active');
    });
    $('body').tooltip({selector: '[data-toggle="tooltip"]', boundary: 'window'});

    feather.replace();

    $.each($('*[data-page-trigger]'), function(i, e) {
        let match = false;
        $.each(JSON.parse(`[${$(e).attr('data-page-trigger').replaceAll('\'', '"')}]`), function(aI, aE) {
            if(window.location.pathname === aE) match = true;
        });
        $(e).toggleClass($(e).attr('data-toggle-class'), match);
    });

    if(window.location.pathname.includes('game/')) $('.mobile-menu-bet').fadeIn('fast', function() {
        $(this).css({display: 'flex'});
    }); else $('.mobile-menu-bet-content, .mobile-menu-bet').fadeOut('fast');
};

$(document).pjax('a:not(.disable-pjax)', container);

window.redirect = function(page) {
    $.pjax({url: page, container: container})
};

$(document).on('pjax:start', function() {
    NProgress.start();
});

$(document).on('pjax:beforeReplace', function(e, contents) {
    $(container).css({'opacity': 0});
    loadedContents = contents;
});

$(document).on('pjax:end', function() {
    $('[data-async-css]').remove();
    initializeRoute();
    setTimeout(function() {
        $('[data-toggle="toggle"]').bootstrapToggle();
    }, 1000);
});

$(document).on('pjax:timeout', function(event) {
    event.preventDefault();
});

$.loadScripts = function(urls, callback) {
    let notLoaded = [];
    for(let i = 0; i < urls.length; i++) $.cacheResource($.mixManifest(urls[i]), function() {
        notLoaded.push($.mixManifest(urls[i]));
    });

    if(notLoaded.length > 0) {
        let index = 0;
        const next = function() {
            $.getScript(notLoaded[index], index !== notLoaded.length - 1 ? function() {
                index++;
                next();
            } : callback);
        };
        next();
    } else callback();
};

$.loadCSS = function(urls, callback, unload = true) {
    let loaded = 0;
    const finish = function() {
        if(loadedContents != null) $(container).html(loadedContents);
        $(container).animate({opacity: 1}, 150, callback);
        NProgress.done();
        $(document).trigger('page:ready');
    };

    const stylesheetLoadCallback = function() {
        loaded++;
        if(loaded >= urls.length) setTimeout(finish, 150);
    };

    if(urls.length === 0) finish();
    $.map(urls, function(url) {
        loadStyleSheet(url, stylesheetLoadCallback, unload);
    });
};

function loadStyleSheet(path, fn, unload = true) {
    const head = document.getElementsByTagName('head')[0], link = document.createElement('link'), preload = document.createElement('link');

    preload.setAttribute('rel', 'preload');
    preload.setAttribute('href', $.mixManifest(path));
    preload.setAttribute('as', 'style');
    preload.setAttribute('type', 'text/css');
    head.appendChild(preload);

    link.setAttribute('href', $.mixManifest(path));
    link.setAttribute('rel', 'stylesheet');
    link.setAttribute('type', 'text/css');
    if(unload) link.setAttribute('data-async-css', 'true');

    let sheet, cssRules;
    if ('sheet' in link) {
        sheet = 'sheet';
        cssRules = 'cssRules';
    } else {
        sheet = 'styleSheet';
        cssRules = 'rules';
    }

    let interval_id = setInterval( function() {
        try {
            if (link[sheet] && link[sheet][cssRules].length) {
                clearInterval(interval_id);
                clearTimeout(timeout_id);
                fn.call(window, true, link);
                console.log(`${$.mixManifest(path)} is loaded`);
            }
        } catch(e) {} finally {}
    }, 10);
    let timeout_id = setTimeout( function() {
        clearInterval(interval_id);
        clearTimeout(timeout_id);
        head.removeChild(link);
        fn.call(window, false, link);
        console.error(path + ' loading error');
    }, 15000);
    head.appendChild(link);
    return link;
}



$.cacheResource = function(key, callback) {
    if(cachedResources.includes(key)) return;
    cachedResources.push(key);
    console.log(`${key} is loaded`);
    return callback();
};

$.currentRoute = function() {
    let page = window.location.pathname;
    const format = function(skip) {
        return page.count('/') > skip ? page.substr(skip === 1 ? 1 : page.indexOf('/'+page.split('/')[skip]), page.lastIndexOf('/') - 1 ) : page.substr(1);
    };

    if(page.startsWith('/admin')) {
        if(page.endsWith('/index') || page === '/admin') return 'admin';
        page = page.substr('/admin'.length);
        return 'admin/'+format(1);
    }
    return format(1);
};

String.prototype.replaceAll = String.prototype.replaceAll || function(string, replaced) {
    return this.replace(new RegExp(string, 'g'), replaced);
};

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.substring(1);
};

String.prototype.count = function(find) {
    return this.split(find).length - 1;
};

$.urlParam = function(name) {
    const results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) return null;
    return decodeURI(results[1]) || 0;
};

$.setCurrency = function(currency) {
    $.setCookie('currency', currency);
    const currencyseticon = `/img/currency/svg/${window.Laravel.currency[currency].icon}.svg`;
    $('[data-selected-currency]').attr('src', currencyseticon);
    $.updateCurrencyBalance();
    $(document).trigger('win5x:currencyChange');
};

if($.getCookie('unit') == null){
$.setCookie('unit', 'disabled');
};

$.setUnit = function(unit) {
}

$.getPriceCurrency = function() {
    if($.getCookie('demo') != 'true'){
		if($.getCookie('unit') == 'usd') {
			let current = $.getBalanceType();
			try { 
				return window.currencies[$.getBalanceType()].dollar;
			}
			catch(err) { 
				console.log('Currency usd for this crypto not stated');
			}
		}
    } else {
		return '0';
    }
	if($.getCookie('unit') == 'disabled')
    {
		return '0';
    }
};

$.getPriceCurrencyByCrypto = function(name) {
    if($.getCookie('demo') != 'true'){
		if($.getCookie('unit') == 'usd') {
			try { 
				return window.currencies[name].dollar;
			}
			catch(err) { 
			console.log('Currency usd for this crypto not stated');
			}
		}
    } else {
		return '0';
    }
	if($.getCookie('unit') == 'disabled') {
		return '0';
    }
};

$.getBalanceType = function() {
    return $.getCookie('currency');
}

$.getMinBet = function() {
	if($.getCookie('unit') == 'disabled') {
		return window.Laravel.currency[$.getBalanceType()].min_bet;
	} else if ($.getCookie('unit') == 'usd') {
		return (window.Laravel.currency[$.getBalanceType()].min_bet * $.getPriceCurrencyByCrypto($.getBalanceType())).toFixed(2);
	}
}

$.getMaxBet = function() {
	if($.getCookie('unit') == 'disabled') {
		return window.Laravel.currency[$.getBalanceType()].max_bet;
	} else if ($.getCookie('unit') == 'usd') {	
		return (window.Laravel.currency[$.getBalanceType()].max_bet  * $.getPriceCurrencyByCrypto($.getBalanceType())).toFixed(2);
	}
}

$.unit = function() {
return $.getCookie('unit') == null ? 'btc' : 'btc';
}

$.getCurrencyLabel = function() {
        if($.getCookie('unit') == 'usd') {
    return $.lang('general.currency_usd');
        }
            if($.getCookie('unit') == 'euro') {
    return $.lang('general.currency_euro');
        }
};

$.currency = function() {
    return $.getCookie('currency') == null ? 'btc' : $.getCookie('currency');
};

$.isDemo = function() {
    if($.isGuest()) return true; 
    return $.getCookie('demo') == null ? false : $.getCookie('demo') === 'true';
};

$.setDemo = function(demo) {
    $('.wallet-open').html(demo ? $.lang('general.head.wallet_open_demo') : $.lang('general.head.wallet'));
    $('[data-demo-check]').attr('class', demo ? 'fas fa-check-square' : 'far fa-square');
    $(`[data-demo-currency-value]`).toggle(demo);
    $(`[data-currency-value]`).toggle(!demo);
    if(!$.isGuest()) $.setCookie('demo', demo);
    $.updateCurrencyBalance();
};

$.updateCurrencyBalance = function() {
	if($.getCookie('unit') == 'disabled') {
    $('.wallet .balance').html(parseFloat($(`[data-${$.isDemo() ? 'demo-currency' : 'currency'}-value="${$.currency()}"]`).html()).toFixed(8));
	} else if ($.getCookie('unit') == 'usd') {
	$('.wallet .balance').html('$' + parseFloat($(`[data-${$.isDemo() ? 'demo-currency' : 'currency'}-value="${$.currency()}"]`).html()).toFixed(2));	
	}
};

let chatState = false;
$.swapChat = function() {
    chatState ? $('.chat').fadeOut('fast') : $('.chat').fadeIn('fast');
    chatState = !chatState;
};

$.currentTheme = function() {
    return $.getCookie('theme') === 'dark' || $.getCookie('theme') == null ? 'dark' : 'default';
};

$.random = function(min, max, floor = true) {
    let r = Math.random() * max + min;
    if(floor) return Math.floor(r);
    return r;
}; 

$.overview = function(game_id, api_id) {
    $.modal('overview').then((e) => {
        e.uiBlocker();

        $.whisper('Info', { game_id: game_id }).then(function(response) {
            $.loadScripts([`/js/pages/${api_id}.js`], function() {
                $.loadCSS([`/css/pages/${api_id}.css`], function() {
                    $('.server_seed_target').hide();
                    $('.client_seed_target').hide();
                    $('.nonce_target').hide();
                                    if(api_id == "slotmachine") {
                    $('.overview .heading').html(`<strong>${response.info.nonce}</strong> #${response.info.id}`);
                                   } else {
                    $('.overview .heading').html(`<strong>${response.metadata.name}</strong> #${response.info.id}`);
                    }
                    $('.overview').uiBlocker(false);
                    if(api_id !== "slotmachine") {
                    $('.server_seed_target').text(response.info.server_seed).attr('href', `/fairness?verify=${response.info.game}-${response.info.server_seed}-${response.info.client_seed}-${response.info.nonce}`);
                    $('.client_seed_target').text(response.info.client_seed).attr('href', `/fairness?verify=${response.info.game}-${response.info.server_seed}-${response.info.client_seed}-${response.info.nonce}`);
                    $('.nonce_target').text(response.info.nonce).attr('href', `/fairness?verify=${response.info.game}-${response.info.server_seed}-${response.info.client_seed}-${response.info.nonce}`);
                    $('.server_seed_target').show();
                    $('.client_seed_target').show();
                    $('.nonce_target').show();
                    }
                    if(response.user.private_bets !== true) $('.overview-player a').attr('href', '/user/'+response.info.user).html(response.user.name);
                    else $('.overview-player a').attr('href', 'javascript:void(0)').html($.lang('general.bets.hidden_name'));

                    $('.overview-bet .option:nth-child(1) span').html(`${$.getCookie('unit') == 'disabled' ? bitcoin(response.info.wager, 'btc').to($.unit()).value().toFixed(8) : ('$' + bitcoin(response.info.wager * $.getPriceCurrencyByCrypto(response.info.currency), 'btc').to($.unit()).value().toFixed(2))} <img src="/img/currency/svg/${window.Laravel.currency[response.info.currency].icon}.svg" style="width: 12px; height: 12px;">`);
                    $('.overview-bet .option:nth-child(2) span').html(`${response.info.status === 'lose' ? (0).toFixed(2) : response.info.multiplier.toFixed(2)}x`);
                    $('.overview-bet .option:nth-child(3) span').html(`${$.getCookie('unit') == 'disabled' ? bitcoin(response.info.profit, 'btc').to($.unit()).value().toFixed(8) : ('$' + bitcoin(response.info.profit * $.getPriceCurrencyByCrypto(response.info.currency), 'btc').to($.unit()).value().toFixed(2))} <img src="/img/currency/svg/${window.Laravel.currency[response.info.currency].icon}.svg" style="width: 12px; height: 12px;">`);

                    const share_url = `${window.location.origin}?game=${response.info.game}-${response.info._id}`;
                    $('[data-share="link"]').attr('data-link', share_url);
                    $('[data-share="vk"]').attr('href', `https://vk.com/share.php?url=${share_url}&title=${$.lang('general.share_text')}`);
                    $('[data-share="twitter"]').attr('href', `https://twitter.com/intent/tweet?hashtags=jackbet&text=${$.lang('general.share_text')}&url=${share_url}`);
                    $('[data-share="telegram"]').attr('href', `https://telegram.me/share/url?url=${share_url}&text=${$.lang('general.share_text')}`);

                    if($('[data-share="chat"]').attr('data-id') === undefined) {
                        $('[data-share="chat"]').on('click', function () {
                            $.modal('overview');
                            $.request('chat/link_game', { id: $(this).attr('data-id') });
                        });
                    }
                    $('[data-share="chat"]').attr('data-id', response.info._id);
                    $.render(api_id, '.overview-render-target', {
                        'game': response.info
                    });
                });
            });
        }, function() {
            $.modal('overview');
            $.error('Unknown game identifier');
        });
    });
};

$.userinfo = function(userid) {
    $.modal('userinfo').then((e) => {
        e.uiBlocker(); 
  $.get('/modals.userinfo?user='+ userid +'', function(response) {
            $('.modal-body').html(response);
            e.uiBlocker(false);
        });
    });
};


let currentLiveTab = 'all';
$(document).ready(function() {
    $.setDemo($.isDemo(), false);
    $.setCurrency($.currency());
    $.setUnit($.unit());
    $(document).trigger('pjax:start');

    $(`[data-chat-toggle]`).on('click', function() {
        $('.chat').toggleClass('hidden');
        $(`.floatingButtons`).toggleClass('chatIsHidden');
        $(document).trigger('win5x:chatToggle');
        $.setCookie('chatVisibility', $('.chat').hasClass('hidden'));
    });

    const isChatVisible = $.getCookie('chatVisibility') === 'true';
    $('.chat').toggleClass('hidden', isChatVisible);
    $(`.floatingButtons`).toggleClass('chatIsHidden', isChatVisible);

    $('#liveTableEntries, #unitChanger').select2({
        minimumResultsForSearch: -1
    });

    $('#unitChanger').on('change', function() {
		$.setCookie('unit', this.value);
		$(this).addClass('active');
		if(this.value == 'disabled') {
			location.reload();
		} else {
			$.modal('unit');
		}
    });

    $('#liveTableEntries').on('select2:selecting', function(e) {
        $.setCookie('show', e.params.args.data.id);
        $('.live .tab.active').click();
    });

    $('.mobile-menu-bet').on('click', function() {
        $(this).find('svg').toggleClass('fa-rotate-180');
        $('.mobile-menu-bet-content').slideToggle('fast');
        $(this).toggleClass('active');
    });

    $('.mobile-menu-games-container, .mobile-menu-bet-content .mobile-menu-bet-content-copied').overlayScrollbars({});

    if($.urlParam('c') != null) $.setCookie('c', $.urlParam('c'));

    if($.urlParam('game') != null) {
        const data = $.urlParam('game').split('-');
        $.overview(data[1], data[0]);
    }

    window.Echo.channel('laravel_database_Everyone').listen('LiveFeedGame', function(e) {
        if(currentLiveTab === 'mine' && e.user._id !== window.Laravel.userId) return;
        if(currentLiveTab === 'lucky_wins' && (e.game.multiplier < 10 || e.game.status !== 'win')) return;
        if(currentLiveTab === 'high_rollers' && e.game.wager < (window.Laravel.currency[e.game.currency].highRollerRequirement)) return;
        setTimeout(function() {
            $.insertLiveGame(e);
        }, e.delay);
    });

    $('.live .tab').on('click', function() {
        $('.live .tab.active').removeClass('active');
        $(this).addClass('active');
        $('.live_table_container').html(`<div class"loader"><div class="loading__container-animation"><div class="yellow"></div><div class="red"></div><div class="blue"></div><div class="green"></div></div></div>`)

        currentLiveTab = $(this).attr('data-live-tab');
        $.get('/modals.live_games/'+currentLiveTab, function(response) {
            liveQueue = [];
            $('.live_table_container').html(response);

            setTimeout(function() {
                $.each($('i'), (i, e) => $.transformIcon($(e)));
            }, 25);
        });
    });

    $('.live .tab.active').click();

    let liveQueue = [];

    $.insertLiveGame = function(game) {
        liveQueue.push(game);
    };

    $.putNextInLiveQueue = function(force = false) {
        if(liveQueue.length === 0) return;
        const game = liveQueue[0];
        liveQueue.shift();

        const e = $(`<tr id="live-game-insert">
            <th>
                <div>
                    <div class="icon d-none d-md-inline-block" onclick="redirect('/game/${(game.metadata.id != 'slotmachine' ? game.metadata.id : game.game.client_seed)}')">
                        <img class="tiny-game" src="/assets/game/tiny/${(game.metadata.id != 'slotmachine' ? game.metadata.id : game.game.client_seed)}.webp">
                    </div>
                    <div class="name">
                        <div><a href="javascript:void(0)" onclick="$.overview('${game.game._id}', '${game.game.game}')">${(game.metadata.id != 'slotmachine' ? game.metadata.name : game.game.nonce)} </a></div>
                    </div>
                </div>
            </th>
            <th>
                <div class="player">
                    <a href="javascript:void(0)" onclick="${game.user.private_bets !== true || Laravel.access !== 'user' ? `$.userinfo('${game.user._id}');` : 'javascript:void(0)'}" ${game.user.private_bets === true ? `data-toggle="tooltip" data-placement="top" title="${$.lang('general.bets.hidden')}"` : ''}>
                        ${game.user.private_bets === true && Laravel.access === 'user' ? '<i class="fad fa-user-secret mr-1"></i> '+$.lang('general.bets.hidden_name') : game.user.name}
                    </a>
                </div>
            </th>
            <th class="d-none d-md-table-cell">
                <div>
                    <span data-toggle="tooltip" data-placement="top" title="${new Date(game.game.created_at).toLocaleDateString()}">
                        ${new Date(game.game.created_at).toLocaleTimeString()}
                    </span>
                </div>
            </th>
            <th data-highlight class="d-none d-md-table-cell">
                <div>
                    ${$.getCookie('unit') == 'disabled' ? bitcoin(game.game.wager, 'btc').to($.unit()).value().toFixed(8) : ('$' + bitcoin(game.game.wager * $.getPriceCurrencyByCrypto(game.game.currency), 'btc').to($.unit()).value().toFixed(2))}
                    <img class="live-currency-icon" src="/img/currency/svg/${window.Laravel.currency[game.game.currency].icon}.svg">
                </div>
            </th>
            <th data-highlight class="d-none d-md-table-cell">
                <div>
                    ${(game.game.status === 'win' || game.game.multiplier < 1 ? game.game.multiplier : 0).toFixed(2)}x
                </div>
            </th>
            <th>
                <div class="${game.game.status === 'win' ? 'live-win' : ''}">
                    <span>${$.getCookie('unit') == 'disabled' ? bitcoin(game.game.profit, 'btc').to($.unit()).value().toFixed(8) : ('$' + bitcoin(game.game.profit * $.getPriceCurrencyByCrypto(game.game.currency), 'btc').to($.unit()).value().toFixed(2))}</span>
                    <img class="live-currency-icon" src="/img/currency/svg/${window.Laravel.currency[game.game.currency].icon}.svg">
                </div>
            </th>
        </tr>`);
        e.hide();

        $('.live_games_selector').prepend(e);
        e.find('[data-toggle="tooltip"]').tooltip();

        if(!force) {
            if($('.live_games_selector').parent().find('tr').length < ($.getCookie('show') ?? 10)) e.fadeIn(50);
            else $('.live_games_selector').parent().find('tr').last().fadeOut(50, function() {
                $(this).delay(50).remove();
                e.fadeIn(50);
            });
        }
        else e.show();
    };

    setInterval($.putNextInLiveQueue, 150);


         
    window.Echo.channel(`laravel_database_Everyone`)
        .listen('ChatMessage', (e) => $.addChatMessage(e.message))
            .listen('UserNotification', function(e) {
                $('#toastbar').html('');
                $('#toastbar').html(e.message).fadeIn(300);
                $.toastmessage(e.message);
                $.playSound('/sounds/toast1.mp3');
            })
            .listen('BigwinNotification', function(e) {
                $('#toastbar').html('');
                $('#toastbar').html(e.message).fadeIn(300);
                $.toastmessage(e.message);
                $.playSound('/sounds/toastbigwin.mp3');
            })
            .listen('GlobalNotificationUpdate', function(e) {
                $.playSound('/sounds/toast1.mp3');
                $('#notification-append').html('');
                $('#notification-append').append(`<div id="bigz-notification-alert" class="alert fadeInRight" role="alert" style="">${e.message}</div>`);
            })
            .listen('GlobalNotificationRemove', function(e) {
                $('#notification-append').html('');
            })
            .listen('PromoNotification', function(e) {
                $.playSound('/sounds/toast1.mp3');
                $.newvip(e.message);
            })
            .listen('NewVIPNotification', function(e) {
                $('#toastbar').html('');
                $('#toastbar').html(e.message).fadeIn(300);
                $.newvip(e.message);
                $.playSound('/sounds/cheer1.mp3');
            })
            .listen('QuizNotification', function(e) {
                $.playSound('/sounds/open.mp3');
                $.toastmessage(e.message);
            })
        .listen('NewQuiz', function(e) {
            $.addChatMessage({
                data: {
                    question: e.quiz,
                    reward: e.reward
                },
                type: "quiz"
            });
        }).listen('QuizAnswered', function(e) {
            $.addChatMessage({
                data: {
                    user: e.user,
                    question: e.question,
                    correct: e.correct,
                    reward: e.reward,
                    currency: e.currency
                },
                type: "quiz_answered"
            });
        }).listen('ChatRemoveMessages', function(e) {
            _.forEach(e.ids, function(id) {
                $(`#${id}`).remove();
            });
        });

    if(!$.isGuest()) {
        let delayed;

        const updateWithdrawBalance = function() {
            let html = '';
            _.each(window.Laravel.currency, (key, value) => {
                html += `<option value="${value}" data-icon="${key.icon}">${$(`[data-currency-value="${value}"]`).html()}</option>`;
            });
            const formatIcon = function(icon) {
                return $(`<span><i class="${$(icon.element).data('icon')}" style="color: ${$(icon.element).data('style')}"></i> ${icon.text}</span>`)
            };

            $('.currency-selector-withdraw').select2('destroy').html(html).val($.currency()).select2({
                templateSelection: formatIcon,
                templateResult: formatIcon,
                allowHtml: true
            });
        };

        window.Echo.channel(`laravel_database_private-App.User.${$.userId()}`)
            .listen('Deposit', function(e) {
                $.success($.lang('general.notifications.deposit', { sum: bitcoin(e.amount, 'btc').to($.unit()).value().toFixed(8), currency: e.currency }));
                $.playSound('/sounds/toast1.mp3');
            })
            .listen('DepositCredited', function(e) {
                $.success($.lang('general.notifications.depositcredited', { sum: bitcoin(e.amount, 'btc').to($.unit()).value().toFixed(8), currency: e.currency }));
                Intercom('trackEvent', 'deposited');
                $.playSound('/sounds/toastbigwin.mp3');
            })     
            .listen('WithdrawSent', function(e) {
                $.success($.lang('general.notifications.withdrawsent', { sum: bitcoin(e.amount, 'btc').to($.unit()).value().toFixed(2), currency: e.currency }));
                $.playSound('/sounds/guessed.mp3');
            })    
            .listen('BonusCredited', function(e) {
                $.success($.lang('general.notifications.bonuscredited', { sum: bitcoin(e.amount, 'btc').to($.unit()).value().toFixed(8), currency: e.currency }));
                Intercom('trackEvent', 'deposited');
                $.setCurrency('bonus');
                $.playSound('/sounds/toastbigwin.mp3');
                window.location.href = '/bonus';
            })  
            .listen('BalanceModification', function(e) {
            const display = function() {
				if($.getCookie('unit') == 'disabled') {
                $(`[data-currency-value="${e.currency}"]`).html(bitcoin(e.balance, 'btc').to($.unit()).value().toFixed(8));
				} else if ($.getCookie('unit') == 'usd') {
				var balaceUsd = $.getPriceCurrency() * e.balance;
				$(`[data-currency-value="${e.currency}"]`).html(bitcoin(balaceUsd, 'btc').to($.unit()).value().toFixed(3));
				}
                $(`[data-demo-currency-value="${e.currency}"]`).html(bitcoin(e.demo_balance, 'btc').to($.unit()).value().toFixed(8));
                $.updateCurrencyBalance();

                $('.wallet .balance .animated').remove();
				var animated = null; 
				if($.getCookie('unit') == 'disabled') {
                animated = $(`<span class="animated text-${e.diff.action === 'subtract' ? 'danger' : 'success'}">${bitcoin(e.diff.value, 'btc').to($.unit()).value().toFixed(8)}</span>`);
                } else if ($.getCookie('unit') == 'usd') {
				var balaceDiffUsd = $.getPriceCurrency() * e.diff.value;
				animated = $(`<span class="animated text-${e.diff.action === 'subtract' ? 'danger' : 'success'}">${bitcoin(balaceDiffUsd, 'btc').to($.unit()).value().toFixed(3)}</span>`);
				}
				animated.css({ 'top': '30px', 'opacity': 1 }).animate({ top: 0, opacity: 0 }, 200, function() {
                    animated.remove();
                });
                $('.wallet .balance').append(animated);

                updateWithdrawBalance();
            };

            if(e.delay === 0) {
                if(delayed != null) clearTimeout(delayed);
                display();
            } else delayed = setTimeout(display, e.delay);
        });

        $('.wallet-open').html($.isDemo() ? $.lang('general.head.wallet_open_demo') : $.lang('general.head.wallet'));
        $('.wallet .balance').html($.isDemo() ? $('#switcher-demo').html() : $('#switcher-real').html());

        $('.wallet .icon, .balance active, .balance-icon').on('click', function() {
            $('.wallet-switcher').toggleClass('active');
            $(this).toggleClass('active');
        });
        
        const walletmenu = $('.wallet-switcher');
        
        $(document).mouseup(e => {
            if (!walletmenu.is(e.target) && walletmenu.has(e.target).length === 0) {
                walletmenu.removeClass('active');
            }
        });

        $('.wallet-switcher .option:not(.select-option)').on('click', function() {
            $('.wallet-switcher').removeClass('active');
            $('.wallet .icon').removeClass('active');
        });

        $(`[data-set-currency]`).on('click', function() {
            $.setCurrency($(this).attr('data-set-currency'));
            $.setWagerSelector();
            walletmenu.removeClass('active');
            $('.wallet .balance').html($('#switcher-real').html());
			if(window.ingame !== undefined && window.ingame == true) {
			location.reload();
			}
        });

        $('.wallet-open').on('click', function() {
            window.location.href = '/wallet';
        });
    }

    $('[data-share="link"]').on('click', function() {
        clipboard.writeText($(this).attr('data-link'));
        $.success($.lang('general.link_copied'));
    });

    $(document).on('click', '.game-sidebar-tab', function() {
        if($('.auto-bet-overlay').css('display') !== 'none' || $.isExtendedGameStarted()) return;
        $('.game-sidebar-tab').removeClass('active');
        $(this).addClass('active').trigger('tab:selected');
    });

    initializeRoute();
    $(container).css({'opacity': 0});

    $('.sidebar .fixed .games').overlayScrollbars({
        scrollbars: {
            autoHide: 'leave'
        }
    });

    $('.theme-switcher').on('click', function() {
        $.setCookie('theme', ($.getCookie('theme') === 'dark' || $.getCookie('theme') == null) ? 'default' : 'dark');
        $('html').attr('class', `theme--${$.getCookie('theme')}`);
        $(document).trigger('page:themeChange');
    });

    setTimeout(function() {
        $.get('/modals.symbols', function(response) {
            $('body').append(response);
        });
    }, 1000);
});


