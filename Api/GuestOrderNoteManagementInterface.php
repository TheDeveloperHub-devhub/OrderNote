<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Api;

use Magento\Checkout\Api\Data\PaymentDetailsInterface;
use DeveloperHub\OrderNote\Api\Data\OrderNoteInterface;

interface GuestOrderNoteManagementInterface
{
    /**
     * @param string $cartId
     * @param OrderNoteInterface $orderNote
     * @return PaymentDetailsInterface
     */
    public function saveOrderNote(
        string $cartId,
        OrderNoteInterface $orderNote
    );
}
