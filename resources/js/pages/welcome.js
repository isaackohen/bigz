$.on('/welcome', function() {



    $('.img-small-slots').lazy({
        visibleOnly: true
        });
   
    
$('.bigzgames').owlCarousel({
    autoplay:false,
    dots: false,
    loop: false,
    items:6,
    nav: false,
    mouseDrag: false,
    slideBy: 1,
    responsiveRefreshRate: 100,
    checkVisibility: false,
    responsiveBaseElement: ".pageContent",
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            slideBy: 1
        },
        350:{
            items:2,
            slideBy: 1
        },
        475:{
            items:3,
            slideBy: 1
        },
        950:{ 
            items:4,
            slideBy: 2
        },
        1085:{ 
            items:5,
            slideBy: 2
        },
        1160:{ 
            items:6,
            slideBy: 2
        }
    }
})

$('.casinogames').owlCarousel({
    autoplay:true,
    autoplaySpeed: 200,
    dots: false,
    loop: true,
    rewind: true,
    items:6,
    nav: false,
    slideBy: 2,
    autoplayTimeout: 20000,
    responsiveRefreshRate: 100,
    checkVisibility: false,
    responsiveBaseElement: ".pageContent",
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            slideBy: 1
        },
        350:{
            items:2,
            slideBy: 1
        }, 
        475:{
            items:3,
            slideBy: 1
        },
        950:{ 
            items:4,
            slideBy: 2
        },
        1085:{ 
            items:5,
            slideBy: 2
        },
        1160:{ 
            items:6,
            slideBy: 2
        }
    }
})


 var o0 = $('#c0'), o1 = $('#c1'), o2 = $('#c2');

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
    o0.trigger('next.owl.carousel')

 });
 o2.on('click', '.owl-prev', function () {
    o1.trigger('prev.owl.carousel')
    o0.trigger('prev.owl.carousel')

 });

$('.o0').owlCarousel({
    autoplay:true,
    dots: false,
    loop: true,
    rewind: false,
    autoplayHoverPause:false,
    items: 8,
    slideBy: 1,
    autoplayTimeout: 20000,
    nav: false,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            slideBy: 1
        },
        295:{
            items:2,
            slideBy: 2
        },
        480:{
            items:4,
            slideBy: 2
        },
        610:{
            items:5,
            slideBy: 3
        },
        850:{ 
            items:6,
            slideBy: 3
        },
        1100:{ 
            items:7,
            slideBy: 3
        },
        1190:{
            items:8,
            slideBy: 4
        }
    }
})

$('.o1').owlCarousel({
    autoplay:true,
    dots: false,
    loop: true,
    rewind: false,
    autoplayHoverPause:false,
    items: 8,
    slideBy: 1,
    autoplayTimeout: 20000,
    nav: false,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            slideBy: 1
        },
        295:{
            items:2,
            slideBy: 2
        },
        480:{
            items:4,
            slideBy: 2
        },
        610:{
            items:5,
            slideBy: 3
        },
        850:{ 
            items:6,
            slideBy: 3
        },
        1100:{ 
            items:7,
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
    dots: false,
    loop: true,
    rewind: false,
    nav: true,
    items: 8,
    slideBy: 1,
    autoplayTimeout: 20000,
    navText: ["<i class='fal fa-arrow-left'></i>","<i class='fal fa-arrow-right'></i>"],
    responsiveBaseElement: ".pageContent",
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            slideBy: 1
        },
        295:{
            items:2,
            slideBy: 2
        },
        480:{
            items:4,
            slideBy: 2
        },
        610:{
            items:5,
            slideBy: 3
        },
        850:{ 
            items:6,
            slideBy: 3
        },
        1100:{ 
            items:7,
            slideBy: 3
        },
        1190:{
            items:8,
            slideBy: 4
        }
    }
})



}, ['/css/pages/welcome.css']);
