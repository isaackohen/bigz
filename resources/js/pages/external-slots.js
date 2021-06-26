

    $(document).ready(function(){

    });



$.on('/slots', function() {
    $('.help .title').on('click', function() {
        $(this).parent().toggleClass('active');
    });



}, ['/css/pages/external-slots.css']);
