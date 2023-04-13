define(
    [
        'jquery',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/url-builder',
        'mage/url',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Ui/js/model/messageList',
        'mage/translate'
    ],
	function ($, customer, quote, urlBuilder, urlFormatter, errorProcessor, messageContainer, __) {
        'use strict';

        return {

            /**
             * Make an ajax PUT request to save order note in the quote.
             *
             * @returns {Boolean}
             */
            validate: function () {
                var isCustomer = customer.isLoggedIn();
                var form = $('.payment-method input[name="payment[method]"]:checked').parents('.payment-method').find('form.order-note-form');

                var quoteId = quote.getQuoteId();
                var url;

                // validate max length
                var note = form.find('.input-text.order-note').val();
                if (this.hasMaxNoteLength() && note.length > this.getMaxOrderNoteLength()) {
                    messageContainer.addErrorMessage({ message: __("The order note entered exceeded the limit") });
                    return false;
                }

                if (isCustomer) {
                    url = urlBuilder.createUrl('/carts/mine/set-order-note', {})
                } else {
                    url = urlBuilder.createUrl('/guest-carts/:cartId/set-order-note', {cartId: quoteId});
                }

                var payload = {
                    cartId: quoteId,
                    orderNote: {
                        note: note
                    }
                };

                if (!payload.orderNote.note) {
                    return true;
                }

                var result = true;

                $.ajax({
                    url: urlFormatter.build(url),
                    data: JSON.stringify(payload),
                    global: false,
                    contentType: 'application/json',
                    type: 'PUT',
                    async: false
                }).done(
                    function (response) {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response);
                    }
                );

                return result;
            },

            /**
             * Is order note has max length
             *
             * @return {Boolean}
             */
            hasMaxNoteLength: function() {
                 return window.checkoutConfig.max_length > 0;
            },

            /**
             * Retrieve order note length limit
             *
             * @return {String}
             */
            getMaxOrderNoteLength: function () {
                 return window.checkoutConfig.max_length;
            }
        };
    }
);
