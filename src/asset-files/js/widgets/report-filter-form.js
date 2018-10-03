(function ($) {

    let $datePickers = $('input.date-picker');

    $datePickers.datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

})(jQuery);