define(['jquery'], function ($) {
    'use strict';

    function updatePrice() {
        var class_id = $('#class-id').val();
        var product_price = $('#current-product-price').val();
        var price = 0;
        var newPrice = 0;
        var postcode = $('#postcode').val();
        var assemblyError = $('#assembly-error');

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
                        var code = (price > 0) ? postcode : 0;
                        updateFormAction(code);
                    }

                    // @Todo: refactor START
                    if (price) {
                        newPrice = parseFloat(price) + parseFloat(product_price);
                    } else {
                        newPrice = parseFloat(product_price);
                    }

                    if (isNaN(price)) {
                        $('.postcode-price').hide();
                        assemblyError.text($.mage.__('Postcode not available')).show();
                        $('button#assembly-cart-add').attr('disabled', true);
                    } else {
                        assemblyError.hide();
                        $('.postcode-price').text('+ ' + price.toFixed(2)).show();
                        $('button#assembly-cart-add').attr('disabled', false);
                    }

                    $('#price-boxer').text(newPrice.toFixed(2));

                    // @Todo: refactor END
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

    function updateFormAction(newValue) {
        var assembly_form = $("form#assembly-service");
        var originalUrl = assembly_form.attr("action");

        var urlParts = originalUrl.split('?');
        var baseUrl = urlParts[0];
        var queryParams = urlParts[1].split('&');

        var preLastParam = queryParams[queryParams.length - 2];
        var keyValue = preLastParam.split('=');
        var key = keyValue[0];

        queryParams[queryParams.length - 2] = key + '=' + newValue;
        var modifiedUrl = baseUrl + '?' + queryParams.join('&');
        assembly_form.attr("action", modifiedUrl);
    }

    return function () {
        $('.postcode-price').hide();
        $('#postcode').on('input', function () {
            updatePrice();
        });
    };
});
