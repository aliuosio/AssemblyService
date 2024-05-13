define([
    'jquery'], function ($) {
    'use strict';

    var postcode = ''; // Declare postcode as a global variable

    return function () {
        $('#postcode').on('input', function () {
            postcode = $(this).val(); // Update the global postcode variable
            updatePrice();
        })

        function addToCustomOptions(price) {
            var form = $('#assembly-service');
            var action = form.attr('action');
            var currentOptions = form.serializeArray();
            var optionExists = false;

            // Check if options[4] already exists, if so, replace its value
            for (var i = 0; i < currentOptions.length; i++) {
                if (currentOptions[i].name === 'options[4]') {
                    currentOptions[i].value = postcode;
                    optionExists = true;
                    break;
                }
            }
            console.log('TEST');
            console.log(optionExists);

            // If options[4] doesn't exist, add it to the form data
            if (price > 0) {
                if (!optionExists) {
                    currentOptions.push({name: 'options[4]', value: postcode});
                }

                // Serialize the updated form data
                var newDataSerialized = $.param(currentOptions);

                // Set the action attribute with the updated form data
                if (action.indexOf('?') !== -1) {
                    form.attr('action', action.split('?')[0] + '?' + newDataSerialized);
                } else {
                    form.attr('action', action + '?' + newDataSerialized);
                }
            } else if (price === 0) {
                // Remove the option value if the price is 0
                var indexToRemove = currentOptions.findIndex(function (option) {
                    return option.name === 'options[4]';
                });
                if (indexToRemove !== -1) {
                    currentOptions.splice(indexToRemove, 1);
                }
            }

            // Serialize the updated form data
            var newDataSerialized = $.param(currentOptions);

            // Set the action attribute with the updated form data
            if (action.indexOf('?') !== -1) {
                form.attr('action', action.split('?')[0] + '?' + newDataSerialized);
            } else {
                form.attr('action', action + '?' + newDataSerialized);
            }
        }

        function updatePrice() {
            var class_id = $('#option_3').val();
            var price = 0;

            if (postcode.length >= 5) { // Use the global postcode variable
                $.ajax({
                    url: '/postcodes/price/index',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postcode: postcode, // Use the global postcode variable
                        class_id: class_id,
                    },
                    success: function (response) {
                        if (response.success) {
                            price = parseFloat(response.price);
                            addToCustomOptions(price);
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
