define(['jquery'], function ($) {
    'use strict';

    return function (config, element) {
        $(document).ready(function () {
            var assemblyServiceForm = $('#assembly-service');
            var addToCartButton = assemblyServiceForm.find('button.tocart');
            var postcodeInput = assemblyServiceForm.find('#postcode');
            var assemblyError = assemblyServiceForm.find('#assembly-error');

            if (postcodeInput.length) {
                addToCartButton.on('click', function (event) {

                    assemblyError.hide();
                    var message = '';
                    var postcodeValue = postcodeInput.val();

                    if (!postcodeValue) {
                        message = 'Please enter a valid postcode.';
                    } else if (postcodeValue.length < 5) {
                        message = 'Postcode must be at least 5 characters long.';
                    }

                    if (message) {
                        event.preventDefault();
                        assemblyError.text(message).show();
                        postcodeInput.focus();
                    }

                });
            }
        });
    };
});
