define(['jquery'], function ($) {
    'use strict';

    var postcode = ''; // Declare postcode as a global variable
    var form = $('#assembly-service'); // Cache form selection
    var action = form.attr('action'); // Cache form action

    function updateActionURL(currentOptions) {
        // Serialize the form data
        var newDataSerialized = $.param(currentOptions);
        // Set the action attribute with the updated form data
        form.attr('action', action.split('?')[0] + '?' + newDataSerialized);
    }

    function addToCustomOptions(price) {
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

        // If options[4] doesn't exist, add it to the form data
        if (price > 0 && !optionExists) {
            currentOptions.push({name: 'options[4]', value: postcode});
        } else if (price === 0) {
            // Remove the option value if the price is 0
            var indexToRemove = currentOptions.findIndex(function (option) {
                return option.name === 'options[4]';
            });
            if (indexToRemove !== -1) {
                currentOptions.splice(indexToRemove, 1);
            }
        }

        // Update form action URL
        updateActionURL(currentOptions);
    }

    function updatePrice() {
        var class_id = $('#option_3').val();
        var price = 0;

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

    return function () {
        $('#postcode').on('input', function () {
            postcode = $(this).val();
            updatePrice();
        });

        updatePrice();
    };
});
