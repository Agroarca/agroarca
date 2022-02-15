import "reqwest";

import "owl.carousel/dist/assets/owl.carousel.css";
import "owl.carousel";

const owlRecentlyViewed = $("#recently-viewed-carousel").owlCarousel({
    margin: 10,
    loop: true,
    nav: false,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 3,
        },
        1000: {
            items: 5,
        },
    },
});

$("#recently-viewed-nav-right").click(function () {
    owlRecentlyViewed.trigger("next.owl.carousel");
});

$("#recently-viewed-nav-left").click(function () {
    owlRecentlyViewed.trigger("prev.owl.carousel", [300]);
});

const owlFlashSale = $("#flash-sale-carousel").owlCarousel({
    margin: 10,
    loop: true,
    nav: false,
    responsive: {
        0: {
            items: 2,
        },
        600: {
            items: 2,
        },
        1000: {
            items: 2,
        },
    },
});

$("#flashsale-nav-right").click(function () {
    owlFlashSale.trigger("next.owl.carousel");
});

$("#flashsale-nav-left").click(function () {
    owlFlashSale.trigger("prev.owl.carousel", [300]);
});
