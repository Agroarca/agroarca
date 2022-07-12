import $ from "jquery";
import "select2";
import "select2/dist/css/select2.min.css";

// ajax request :D
// https://select2.org/data-sources/ajax

window.select2 = function (element) {
    let options = {}
    let data = $(element).data('s2-url')

    if (data && data.length > 0) {
        options.ajax = {
            url: $(element).data('s2-url'),
            dataType: 'json',
            delay: 250
        }
        options.minimumInputLength = 2
    }

    $(element).select2(options);
}

$(function () {
    $(".select2").each(function () {
        select2(this);
    })
})


$(function () {
    $('[data-toggle="tooltip"]').each(function () {
        $(this).tooltip({ container: this })
    })
})
