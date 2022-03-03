import reqwest from "reqwest";
import { Modal } from "bootstrap";

import * as toastr from "toastr";
import "toastr/build/toastr.css";

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

const owlHomeBanners = $("#banners-carousel").owlCarousel({
    margin: 10,
    loop: true,
    nav: false,
    autoplay: true,
    autoplayTimeout: 3500,
    autoplayHoverPause: true,
    items: 1,
});

$("#banners-nav-right").click(function () {
    owlHomeBanners.trigger("next.owl.carousel");
});

$("#banners-nav-left").click(function () {
    owlHomeBanners.trigger("prev.owl.carousel", [300]);
});

const deliveryContent = document.getElementById("delivery-content");

const deliveryModal = new Modal(document.getElementById("delivery-info-modal"));

if (deliveryContent && deliveryModal) {
    deliveryContent.addEventListener("click", () => {
        deliveryModal.show();
    });

    const submitDeliveryForm = document.getElementById("submit-delivery-form");
    const deliveryForm = document.getElementById("form-delivery-info");

    submitDeliveryForm.addEventListener("click", () => {
        const formData = Object.fromEntries(new FormData(deliveryForm));

        const cep = formData.cep && formData.cep.replace("-", "");

        if (!cep || cep.length !== 8) {
            toastr.warning("Por favor, insira um cep valido!");
            return;
        }

        if (!formData.deliveryDate) {
            toastr.warning("Por favor, insira uma data de entrega!");
            return;
        }

        reqwest({
            url: "/api/save/delivery/info",
            method: "post",
            data: formData,
        })
            .then((response) => {
                console.log(response);
            })
            .fail((response) => {
                console.log(response);
                // @TODO: Implementar tratamento de erro com o que retorna do backend.
            });

        // @TODO: Apos request funcionando, devera ficar no success.
        deliveryModal.hide();
        toastr.success("Endereço salvo com sucesso!");
    });
}
