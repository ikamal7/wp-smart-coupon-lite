(function ($) {
    $(document).ready(function () {
        $(".copy-button").on('click', function (e) {
            e.preventDefault();
            return false;
        })

        $('#exp_date').datepicker({
            dateFormat: 'dd-M-yy'
        });

        $("#coupon_type").keyup(function () {
            var coupon_type = $(this).val();
            if (coupon_type == 'Deals') {
                $('.coupon_deals').text('Deals Button Text');
            } else {
                $('.coupon_deals').text('Coupon Code');
            }
        });
    });
})(jQuery);