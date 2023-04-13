define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'DeveloperHub_OrderNote/js/model/checkout/order-note-validator'
    ],
    function (Component, additionalValidators, noteValidator) {
        'use strict';

        additionalValidators.registerValidator(noteValidator);

        return Component.extend({});
    }
);
