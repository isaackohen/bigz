$.on('/poker', function() {
    $('.help .title').on('click', function() {
        $(this).parent().toggleClass('active');
    });
}, ['/css/pages/poker.css']);
