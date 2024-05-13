define(['jquery'], function ($) {
    'use strict';

    var form = $('#assembly-service'); // Cache form selection
    var action = form.attr('action'); // Cache form action

    function updatePrice() {
        var class_id = $('#class-id').val();
        var product_price = $('#current-product-price').val();
        var price = 0;
        var newPrice = 0;
        var postcode = $('#postcode').val();

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

    function updateFormAction(newValue) {
        // Extract the original URL
        var originalUrl = $("form#assembly-service").attr("action");

        // Parse the URL
        var urlParts = originalUrl.split('?');
        var baseUrl = urlParts[0];
        var queryParams = urlParts[1].split('&');

        // Find the pre-last key-value pair
        var preLastParam = queryParams[queryParams.length - 2];
        var keyValue = preLastParam.split('=');
        var key = keyValue[0];

        // Modify the value with the new value
        queryParams[queryParams.length - 2] = key + '=' + newValue;

        // Reconstruct the URL
        var modifiedUrl = baseUrl + '?' + queryParams.join('&');

        // Update the form action attribute with the modified URL
        $("form#assembly-service").attr("action", modifiedUrl);
    }

    return function () {
        $('#postcode').on('input', function () {
            updatePrice();
        });
    };
});
