import $ from "jquery";
import "select2";
import "select2/dist/css/select2.min.css";

// ajax request :D
// https://select2.org/data-sources/ajax

$(function () {

    $(".select2").each(function () {
        let options = {}
        let data = $(this).data('s2-url')

        if (data && data.length > 0) {
            options.ajax = {
                url: $(this).data('s2-url'),
                dataType: 'json',
                delay: 250
            }
            options.minimumInputLength = 2
        }

        $(this).select2(options);
    })

})


$(function () {
    $('[data-toggle="tooltip"]').each(function () {
        $(this).tooltip({ container: this })
    })
})
