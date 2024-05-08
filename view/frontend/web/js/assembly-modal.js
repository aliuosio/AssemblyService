require(
    [
        'Magento_Customer/js/customer-data',
        'jquery',
        'Magento_Ui/js/modal/modal'
    ], function (customerData, $, modal) {

    var cart = customerData.get('cart');
    var currentProductId = $('#current-product-id').val();

    cart.subscribe(function () {
        cart().items.forEach(function(item) {
           if (item.product_id === currentProductId) {
                $('#product-assembly-service').show();
            }
        });
    });
});
