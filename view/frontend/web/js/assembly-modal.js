require(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function ($, modal) {
        let options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: $.mage.__('Assembly Service'),
            buttons: [{
                text: $.mage.__('Close'),
                class: '',
                click: function () {
                    this.closeModal();
                }
            }]
        };

        // Modal open
        let $myModal = $('#product-assembly-service');
        $('#product-addtocart-button').on('click', function (event) {
            let popup = modal(options, $myModal);
            $myModal.modal('openModal');
        });

        // Modal close
        $('button#assembly-cart-add').on('click', function (event) {
            if (typeof postcode_js === 'undefined') {
                $myModal.modal('closeModal');
            }
        });

    });
