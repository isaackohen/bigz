import iziToast from 'izitoast';

$.success = function(message) {
        iziToast.show({
        timeout: '3500',
        color: 'dark',
        iconUrl: '/img/logo/bigz-icon-success.svg',
        title: 'OK!',
        message: message,
        transitionIn: 'fadeInRight',
        transitionOut: 'fadeOutLeft',
        position: 'topLeft', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(126, 228, 2)',
      });
};

$.error = function(message) {
        iziToast.show({
        timeout: '3500',
        color: 'dark',
        iconUrl: '/img/logo/bigz-icon-error.svg',
        title: 'Oops!',
        message: message,
        transitionIn: 'fadeInRight',
        transitionOut: 'fadeOutLeft',
        position: 'topLeft', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(212, 67, 57)',
      });

    };




    // custom toast
$.toastmessage = function(message) {
        iziToast.show({
        timeout: '10000',
        color: 'dark',
        iconUrl: '/img/logo/bigz-icon.svg',
        title: 'BIGZ',
        message: message,
        transitionIn: 'fadeInRight',
        transitionOut: 'fadeOutLeft',
        position: 'topLeft', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(0, 255, 184)',
        buttons: [
          [
            '<button>Close</button>',
            function (instance, toast) {
              instance.hide({
                transitionOut: 'fadeOutRight'
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
        'iconUrl':'/img/logo/bigz-icon.svg',
        'font-weight': '700',
        'transitionIn': 'fadeInRight',
        'transitionOut': 'fadeOutLeft',
        'messageSize': '15px',
        'messageHeight': '1.5',
        'title': 'BIGZ',
        'message': message,
        'position': 'topLeft'
    });
};

$.warning = function(message) {
    iziToast.warning({
        'layout': '2',
        'titleSize': '17px',
        'messageSize': '16px',
        'messageHeight': '1.4',
        'message': message,
        'position': 'topLeft'
    });
};

$.triviamsg = function(message) {
    iziToast.info({
        'layout': '2',
        'titleSize': '14px',
        'iconUrl':'/img/logo/bigz-icon.svg',
        'font-weight': '700',
        'transitionIn': 'fadeInRight',
        'transitionOut': 'fadeOutLeft',
        'messageSize': '15px',
        'messageHeight': '1.5',
        'title': 'Trivia Time',
        'message': message,
        'position': 'topLeft'
    });
};

$.discordmsg = function(message) {
    iziToast.info({
        'layout': '2',
        'titleSize': '14px',
        'iconUrl':'/img/logo/bigz-icon.svg',
        'font-weight': '700',
        'transitionIn': 'fadeInRight',
        'transitionOut': 'fadeOutLeft',
        'messageSize': '15px',
        'messageHeight': '1.5',
        'title': 'Discord Promocode',
        'message': message,
        'position': 'topLeft'
    });
};


$.info = function(message) {
        iziToast.show({
        timeout: '3500',
        color: 'dark',
        iconUrl: '/img/logo/bigz-icon-info.svg',
        message: message,
        transitionIn: 'fadeInRight',
        transitionOut: 'fadeOutLeft',
        position: 'topLeft', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(2, 106, 228)',
      });
};



 