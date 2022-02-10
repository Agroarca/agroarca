import 'reqwest';

import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel';


const owl = $('#recently-viewed-carousel').owlCarousel({
    margin:10,
    loop: true,
    nav: false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
});

$('#recently-viewed-nav-right').click(function() {
    owl.trigger('next.owl.carousel');
})

$('#recently-viewed-nav-left').click(function() {
    owl.trigger('prev.owl.carousel', [300]);
})



