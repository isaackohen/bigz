import iziToast from 'izitoast';

$.success = function(message) {
    iziToast.success({
        'font-weight': '700',
        'transitionIn': 'bounceInDown',
        'transitionOut': 'fadeOutUp',
        'color': 'rgb(0, 255, 184)',
        'layout': '2',
        'titleSize': '15px',
        'messageSize': '15px',
        'messageHeight': '1.5',
        'message': message,
        'position': 'topCenter'
    });
};

$.error = function(message) {
    iziToast.error({
        'transitionIn': 'bounceInDown',
        'transitionOut': 'fadeOutUp',
        'font-weight': '700',
        'titleSize': '15px',
        'layout': '2',
        'messageSize': '15px',
        'icon': 'ico-error',
        'message': message,
        'position': 'topCenter'
    });
};


    // custom toast
$.multiplier = function(message) {

        iziToast.success({
        color: 'dark',
        icon: '/img/logo/ico.png',
        title: 'BIG WINZ',
        message: message,
        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(0, 255, 184)',
        buttons: [
          [
            '<button>Ok</button>',
            function (instance, toast) {
              alert("Hello world!");
            }
          ],
          [
            '<button>Close</button>',
            function (instance, toast) {
              instance.hide({
                transitionOut: 'fadeOutUp'
              }, toast);
            }
          ]
        ]
      });

    };


$.darktoast = function(message) {
    iziToast.success({
        'layout': '2',
        'titleSize': '14px',
        'iconUrl':'/img/logo/ico.png',
        'font-weight': '700',
        'transitionIn': 'bounceInDown',
        'transitionOut': 'fadeOutUp',
        'messageSize': '15px',
        'messageHeight': '1.5',
        'title': 'BIGZ Message',
        'message': message,
        'position': 'topCenter'
    });
};

$.warning = function(message) {
    iziToast.warning({
        'layout': '2',
        'titleSize': '17px',
        'messageSize': '16px',
        'messageHeight': '1.4',
        'message': message,
        'position': 'topCenter'
    });
};

$.triviamsg = function(message) {
    iziToast.info({
        'layout': '2',
        'titleSize': '14px',
        'iconUrl':'/img/logo/icoblack.svg',
        'font-weight': '700',
        'transitionIn': 'bounceInDown',
        'transitionOut': 'fadeOutUp',
        'messageSize': '15px',
        'messageHeight': '1.5',
        'title': 'Trivia Time',
        'message': message,
        'position': 'topCenter'
    });
};

$.discordmsg = function(message) {
    iziToast.info({
        'layout': '2',
        'titleSize': '14px',
        'iconUrl':'/img/logo/icoblack.svg',
        'font-weight': '700',
        'transitionIn': 'bounceInDown',
        'transitionOut': 'fadeOutUp',
        'messageSize': '15px',
        'messageHeight': '1.5',
        'title': 'Discord Promocode',
        'message': message,
        'position': 'topCenter'
    });
};


$.info = function(message) {
    iziToast.info({
        'layout': '2',
        'titleSize': '15px',
        'iconUrl':'/img/logo/icoblack.svg',
        'font-weight': '700',
        'transitionIn': 'flipInX',
        'transitionOut': 'flipOutX',
        'messageSize': '15px',
        'messageHeight': '1.5',
        'message': message,
        'position': 'topCenter'
    });
};



 