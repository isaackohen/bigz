$.on('/internalerror', function() {
    $('.help .title').on('click', function() {
        $(this).parent().toggleClass('active');
    });
}, ['/css/pages/internalerror.css']);
