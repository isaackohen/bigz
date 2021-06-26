let wallet = {
    deposit: 'bitcoin',
    withdraw: 'bitcoin',
    sum: 0.00,
    aggregator: null
};

$.on('/wallet', function() {
    $('[data-toggle-wallet-tab]').on('click', function() {
        if($(this).hasClass('active')) return;
        $(`[data-toggle-wallet-tab]`).removeClass('active');
        $(this).addClass('active');

        $(`[data-wallet-tab]`).hide();
        $(`[data-wallet-tab="${$(this).attr('data-toggle-wallet-tab')}"]`).fadeIn('fast');
    });

    $('.aggregator').on('click', function() {
        wallet.aggregator = $(this).attr('data-aggregator-id');
        $('.aggregator.active').removeClass('active');
        $(this).addClass('active');
    });
    $('.aggregator:first-child').click();

    $('[data-toggle-history-tab]').on('click', function() {
        if($(this).hasClass('active')) return;
        $(`[data-toggle-history-tab]`).removeClass('active');
        $(this).addClass('active');

        $(`[data-history-tab]`).hide();
        $(`[data-history-tab="${$(this).attr('data-toggle-history-tab')}"]`).fadeIn('fast');
    });

    $('[data-wallet-tab="deposit"] .paymentMethod').on('click', function() {
        $('[data-wallet-tab="deposit"] .paymentMethod').removeClass('active');
        $(this).addClass('active');
        setPaymentMethodDescription('deposit');
    });

    $('[data-wallet-tab="withdraw"] .paymentMethod').on('click', function() {
        $('[data-wallet-tab="withdraw"] .paymentMethod').removeClass('active');
        $(this).addClass('active');
        setPaymentMethodDescription('withdraw');
    });

    /*
    $('[data-wallet-tab="deposit"] .walletButton').on('click', function() {
        $('[data-wallet-tab="deposit"] .walletButton').removeClass('active');
        $(this).addClass('active');
        wallet.sum = parseFloat($(this).html());
        $('#walletDepValue').val(wallet.sum);
    });
    */

    const setPaymentMethodDescription = function(tab) {
        $(`[data-wallet-tab="${tab}"] .paymentDesc`).html($(`[data-wallet-tab="${tab}"] .paymentMethod.active`).find('.icon').html() + ' ' + $(`[data-wallet-tab="${tab}"] .paymentMethod.active`).find('.name').html());
        $(`[data-wallet-tab="${tab}"] .walletAmount`).html($(`[data-wallet-tab="${tab}"] .paymentMethod.active`).data('amount'));
        $(`[data-wallet-tab="${tab}"] .minAmount`).html($(`[data-wallet-tab="${tab}"] .paymentMethod.active`).data('min-amount'));



        wallet[tab] = $(`[data-wallet-tab="${tab}"] .paymentMethod.active`).attr('data-type');
    };

    setPaymentMethodDescription('deposit');
    setPaymentMethodDescription('withdraw');

    $('.close-action-notify').on('click', function() {
        $('.successfulWalletAction').fadeOut('fast');
        redirect(window.location.pathname);
    });

    $('#withdraw').on('click', function() {
        if($('#wallet').val().length < 5) {
            $.error($.lang('general.error.enter_wallet'));
            return;
        }
        $('.walletUiBlocker').fadeIn('fast');
        $.request('wallet/withdraw', {
            sum: parseFloat($('#walletWithValue').val()),
            currency: wallet.withdraw,
            wallet: $('#wallet').val()
        }).then(function(response) {
            $('.successfulWalletAction .heading').html($.lang('wallet.withdraw.title'));
            $('.successfulWalletAction .content').html($.lang('wallet.withdraw.content'));
            $('.successfulWalletAction').fadeIn('fast');
        }, function(error) {
            $('.walletUiBlocker').fadeOut('fast');
            if(error === 1) $.error($.lang('general.error.invalid_withdraw'));
            if(error === 2) $.error($.lang('general.error.invalid_wager'));
            if(error === 3) $.error($.lang('general.error.only_one_withdraw'));
        });
    });

    $('#deposit').on('click', function() {
        $('.walletUiBlocker').fadeIn('fast');

        $.request('wallet/getDepositWallet', {
            currency: wallet.deposit
        }).then(function(response) {
            $('.successfulWalletAction .heading').html($.lang('wallet.deposit.title'));
            $('.successfulWalletAction .content').html(`${$.lang('wallet.deposit.content')}`);
            $('.successfulWalletAction .ledger').html(response.wallet);
            if(response.currency == 'xrp') document.getElementById('ledger').innerHTML += response.payid;
            $('.successfulWalletAction').fadeIn('fast');
        }, function(error) {
            $('.walletUiBlocker').fadeOut('fast');
            if (error === 1) {
                $.error($.lang('general.error.invalid_deposit_type'));
            } else {
                $.error($.lang('general.error.processing_error'));
            }
        });
    });
}, ['/css/pages/wallet.css']);

$.cancelWithdraw = function(id) {
    $('.walletUiBlocker').fadeIn('fast');
    $.request('wallet/cancel_withdraw', { id: id }).then(function() {
        $.success($.lang('wallet.history.withdraw_cancelled'));
        redirect(window.location.pathname);
    }, function(error) {
        $('.walletUiBlocker').fadeOut('fast');
        $.error(error);
    });
};