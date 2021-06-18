$.on('/gamelist', function() {



    $('.img-small-slots').lazy({
        visibleOnly: true
        });

    
$('.casinogames').owlCarousel({
    autoplay:true,
    autoplaySpeed: 200,
    dots: false,
    loop: false,
    rewind: true,
    items:7,
    slideBy: 1,
    autoplayTimeout: 5000,
    responsiveRefreshRate: 100,
    checkVisibility: false,
    responsiveBaseElement: ".pageContent",
    navContainer: '#casinoarrows',
    navText: ["<i class='fas fa-arrow-alt-from-right'></i>","<i class='fas fa-arrow-alt-from-left'></i>"],
    responsiveClass:true,
    responsive:{
        0:{
            items:2,
            slideBy: 1
        },
        575:{
            items:3,
            slideBy: 1
        },
        750:{
            items:4,
            slideBy: 2
        },
        950:{ 
            items:5,
            slideBy: 2
        },
        1100:{ 
            items:6,
            slideBy: 2
        },
        1190:{
            items:7,
            slideBy: 3
        }
    }
})


 var o1 = $('#c1'), o2 = $('#c2');

 //Sync o2 by o1
 o1.on('click', '.owl-next', function () {
    o2.trigger('next.owl.carousel')
 });
 o1.on('click', '.owl-prev', function () {
    o2.trigger('prev.owl.carousel')
 });
 //Sync o1 by o2
 o2.on('click', '.owl-next', function () {
    o1.trigger('next.owl.carousel')
 });
 o2.on('click', '.owl-prev', function () {
    o1.trigger('prev.owl.carousel')
 });


$('.o1').owlCarousel({
    autoplay:true,
    autoplaySpeed: 100,
    dots: false,
    loop: true,
    rewind: false,
    items: 8,
    slideBy: 1,
    autoplayTimeout: 25000,
    responsiveRefreshRate: 100,
    checkVisibility: false,
    responsiveBaseElement: ".pageContent",
    nav: false,
    responsiveClass:true,
    responsive:{
        0:{
            items:2,
            slideBy: 1
        },
        275:{
            items:3,
            slideBy: 2
        },
        650:{
            items:4,
            slideBy: 3
        },
        950:{ 
            items:5,
            slideBy: 3
        },
        1100:{ 
            items:6,
            slideBy: 3
        },
        1190:{
            items:8,
            slideBy: 4
        }
    }
})

$('.o2').owlCarousel({
    autoplay:true,
    autoplaySpeed: 100,
    dots: false,
    loop: true,
    rewind: false,
    nav: true,
    items: 8,
    slideBy: 1,
    autoplayTimeout: 25000,
    navText: ["<i class='fas fa-arrow-alt-from-right'></i>","<i class='fas fa-arrow-alt-from-left'></i>"],
    responsiveRefreshRate: 100,
    checkVisibility: false,
    responsiveBaseElement: ".pageContent",
    responsiveClass:true,
    responsive:{
        0:{
            items:2,
            slideBy: 1
        },
        275:{
            items:3,
            slideBy: 2
        },
        650:{
            items:4,
            slideBy: 3
        },
        950:{ 
            items:5,
            slideBy: 3
        },
        1100:{ 
            items:6,
            slideBy: 3
        },
        1190:{
            items:8,
            slideBy: 4
        }
    }
})


}, ['/css/pages/gamelist.css']);
