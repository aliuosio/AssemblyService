var postcode_js = true;
define(['jquery'], function ($) {
    'use strict';

    return function (config, element) {
        $(document).ready(function () {
            var assemblyServiceForm = $('#assembly-service');
            var addToCartButton = assemblyServiceForm.find('button.tocart');
            var postcodeInput = $('#postcode');
            var assemblyError = $('#assembly-error');

            if (postcodeInput.length) {
                addToCartButton.on('click', function (event) {

                    assemblyError.hide();
                    var message = '';
                    var postcodeValue = postcodeInput.val();

                    if (!postcodeValue) {
                        $('.postcode-price').hide();
                        message = $.mage.__('Please enter a valid postcode');
                    } else if (postcodeValue.length < 5) {
                        $('.postcode-price').hide();
                        message = $.mage.__('Postcode must be at least 5 characters long');
                    }

                    if (message) {
                        event.preventDefault();
                        assemblyError.text(message).show();
                        postcodeInput.focus();
                    } else {
                        $('#product-assembly-service').modal('closeModal');
                    }
                });
            }
        });
    };
});
