define([
    'jquery',
    'Magento_Customer/js/customer-data'
], function ($, customerData) {
    'use strict';

    return function () {
        $('#postcode').on('input', function () {
            updatePrice();
        });

        function updatePrice() {
            var value = $('#postcode').val();
            var price = 0;

            if (value.length >= 5) {
                $.ajax({
                    url: '/postcodes/price/index',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postcode: value
                    },
                    success: function (response) {
                        if (response.success) {
                            price = parseFloat(response.price);
                        }

                        $('.postcode-price').text(price.toFixed(2));
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                $('.postcode-price').text(price.toFixed(2));
            }
        }

        updatePrice();
    };
});
