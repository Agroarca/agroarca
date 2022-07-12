import reqwest from "reqwest";
import * as toastr from "toastr";
import "toastr/build/toastr.css";

import "owl.carousel/dist/assets/owl.carousel.css";
import "owl.carousel";

const owlCarouselInit = ({ element, options = {}, nav = false }) => {
    const instance = $(element).owlCarousel(options);

    if (nav) {
        const { right, left } = nav;

        $(right).click(function () {
            instance.trigger("next.owl.carousel");
        });

        $(left).click(function () {
            instance.trigger("prev.owl.carousel", [300]);
        });
    }
};

owlCarouselInit({
    element: "#recently-viewed-carousel",
    nav: {
        right: "#recently-viewed-nav-right",
        left: "#recently-viewed-nav-left",
    },
    options: {
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
    },
});

owlCarouselInit({
    element: "#flash-sale-carousel",
    nav: { right: "#flashsale-nav-right", left: "#flashsale-nav-left" },
    options: {
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
    },
});

owlCarouselInit({
    element: "#banners-carousel",
    options: {
        animateOut: "fadeOut",
        margin: 10,
        loop: true,
        nav: false,
        autoplay: true,
        autoplayTimeout: 3500,
        autoplayHoverPause: true,
        items: 1,
    },
    nav: { right: "#banners-nav-right", left: "#banners-nav-left" },
});


window.verificarCep = function (input) {
    var cep = input.value.replace(/\D/g, '')
    if (cep.length == 8) {
        input.form.submit()
    }
}

//
class Loader {
    ativo = false;

    mostrar() {
        if (!this.ativo) {
            $('.loader').fadeIn('fast');
            this.ativo = true;
        }
    }

    esconder() {
        if (this.ativo) {
            $('.loader').fadeOut('fast');
            this.ativo = false;
        }
    }
}

window.loader = new Loader();
