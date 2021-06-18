$.on('/pokertransfer', function() {

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
        });
    });


    $('.help .title').on('click', function() {
        $(this).parent().toggleClass('active');
    });
}, ['/css/pages/pokertransfer.css']); 
  