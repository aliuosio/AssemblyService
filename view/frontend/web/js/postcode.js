define([
    'jquery',
    'Magento_Customer/js/customer-data'
], function($, customerData) {
    'use strict';

    return function postcode() {
        function updatePrice() {
            var value = $('input[name="options[13]"]').val();
            var price = 0;

            if (/^\d{5}$/.test(value)) {
                var intValue = parseInt(value);
                if (intValue >= 10000 && intValue <= 20000) {
                    price = 5.99;
                } else if (intValue > 20000 && intValue <= 30000) {
                    price = 7.99;
                }
            }

            $('.postcode-price').text(price.toFixed(2));
            var cart = customerData.get('cart');
            if (cart) {
                customerData.reload(['cart'], true);
            }
        }
        $('input[name="options[13]"]').on('input', function() {
            updatePrice();
        });

        updatePrice();
    };
});
