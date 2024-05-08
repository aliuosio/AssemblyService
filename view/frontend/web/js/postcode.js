define(['jquery'], function ($) {
    'use strict';
    var postcode = $('#postcode'); // Declare postcode as a global variable

    function updatePrice() {
        var class_id = $('#class-id').val();
        var product_price = $('#current-product-price').val();
        var price = 0;
        var newPrice = 0;

        if (postcode.length >= 5) {
            $.ajax({
                url: '/postcodes/price/index',
                type: 'POST',
                dataType: 'json',
                data: {
                    postcode: postcode,
                    class_id: class_id,
                },
                success: function (response) {
                    if (response.success) {
                        price = parseFloat(response.price);
                    }
                    newPrice = parseFloat(price) + parseFloat(product_price);
                    $('.postcode-price').text('+ ' + price.toFixed(2));
                    $('#postcode-price').val(price.toFixed(2));
                    $('#price-boxer').text(newPrice.toFixed(2));
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        } else {
            $('.postcode-price').text('+ ' + price.toFixed(2));
            if (product_price > 0)
                $('#price-boxer').text(parseFloat(product_price).toFixed(2));
        }
    }

    return function () {
        $('#postcode').on('input', function () {
            postcode = $(this).val();
            updatePrice();
        });

        updatePrice();
    };
});
