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

        let $myModal = $('#product-assembly-service');
        let popup = modal(options, $myModal);
        $myModal.modal('openModal');
    });
