let currentAuthMethod = 'auth';



$(document).ready(function() {
    $(document).on('click', '.login .btn-block', function() {
        $.eraseCookie('token');

        const login = $('#login').val(), password = $('#password').val(), captcha = $('.g-recaptcha-response').val();
        if(currentAuthMethod === 'auth') {
            $('.login').uiBlocker();
            $.request('/auth/login', {
                'name': login,
                'password': password,
                'captcha': captcha
            }).then(function() {
                grecaptcha.reset();
                window.location.reload();
            }, function(reason) {
                $('.login').uiBlocker(false);
                if(reason === 1) $.error($.lang('general.auth.wrong_credentials')), grecaptcha.reset();
                if(reason === 4) $.error($.lang('general.error.captcha'));
                else $.error($.parseValidation(reason, {
                    'name': 'general.auth.credentials.login',
                    'password': 'general.auth.credentials.password'
                }));
            });
        } else {
            $('.login').uiBlocker();
            $.request('/auth/register', {
                'name': login,
                'password': password,
                'captcha': captcha
            }).then(function() {
                grecaptcha.reset();
                window.location.reload();
            }, function(error) {
                $('.login').uiBlocker(false);
                if(error === 4) $.error($.lang('general.error.captcha'));
                else $.error($.parseValidation(error, {
                    'name': 'general.auth.credentials.login',
                    'password': 'general.auth.credentials.password'
                })), grecaptcha.reset();
            });
        }
    });

    $(document).on('click', '[data-social]', function() {
        $('.login').uiBlocker();
        window.location.href = '/auth/'+$(this).attr('data-social');
    });
});
