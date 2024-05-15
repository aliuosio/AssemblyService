require(
    [
        'Magento_Customer/js/customer-data',
        'jquery',
        'Magento_Ui/js/modal/modal'
    ], function (customerData, $, modal) {

        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Assembly Service',
            buttons: [{
                text: $.mage.__('Close'),
                class: '',
                click: function () {
                    this.closeModal();
                }
            }]
        };
        var modalWindow = $('#product-assembly-service');
        var popup = modal(options, modalWindow);
        var cart = customerData.get('cart');
        var currentProductId = $('#current-product-id').val();

        modalWindow.on('click', '#assembly-cart-add', function() {
            modalWindow.modal('closeModal');
        })
        cart.subscribe(function () {
            cart().items.forEach(function (item) {
                if (item.product_id === currentProductId) {
                        $('#product-assembly-service').modal("openModal");
                }
            });
        });
    });
