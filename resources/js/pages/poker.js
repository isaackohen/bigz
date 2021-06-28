$.on('/poker', function() {


    $('.depositwallet').on('click', function() {
            $.request('pokerapi/deposit', { 
				sum: parseFloat($('#depositinput').val()),
				currency: $.getBalanceType()
			}).then(function(response) {
                $.success($.lang('general.poker.success'));
				window.location.reload();
            }, function(error) {
				if(error === 0) $.error($.lang('general.poker.mindeposit'));
                if(error === 1) $.error($.lang('general.poker.invalid'));
                if(error === 2) $.error($.lang('general.poker.notenough'));
                if(error === 3) $.error($.lang('general.poker.needdeposit'));
                if(error === 4) $.error($.lang('general.poker.btcdeposit'));

            });
        });



    $('.withdrawwallet').on('click', function() {
        $.request('pokerapi/withdraw', {
            sum: $('#withdrawinput').val()
        }).then(function() {
            window.location.reload();
        }, function(error) {
				if(error === 0) $.error($.lang('general.poker.minwithdraw'));
                if(error === 1) $.error($.lang('general.poker.invalid'));
                if(error === 2) $.error($.lang('general.poker.notenough'));
                if(error === 3) $.error($.lang('general.poker.needdeposit'));
                if(error === 4) $.error($.lang('general.poker.btcdeposit'));
        });
    });
    
    $('.help .title').on('click', function() {
        $(this).parent().toggleClass('active');
    });
}, ['/css/pages/poker.css']);
