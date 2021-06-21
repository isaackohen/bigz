import bitcoin from 'bitcoin-units';

let destroy = null, init;
$.on('/', function(){

$('.game_poster').tilt({
    glare: false,
    scale: 1.02
})



$('.loff').owlCarousel({
    loop:true,
    autoplay:false,
    margin:5,
    autoplaySpeed: 500,
    items:1,
    nav:false,
    dots: true,
    dotsContainer:'#dots',
    autoplayTimeout:5000,
    responsiveRefreshRate: 100,
    responsiveBaseElement: ".pageContent",
    responsiveClass:true

})



}, ['/css/pages/index.css']);
