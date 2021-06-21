

    $(document).ready(function(){


    });



$.on('/game/slot', function() {
    $('.help .title').on('click', function() {
        $(this).parent().toggleClass('active');
    });



}, ['/css/pages/external-slots.css']);
