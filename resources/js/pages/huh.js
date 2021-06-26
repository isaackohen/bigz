$.on('/huh', function() {
    $('.help .title').on('click', function() {
        $(this).parent().toggleClass('active');
    });
}, ['/css/pages/huh.css']);
