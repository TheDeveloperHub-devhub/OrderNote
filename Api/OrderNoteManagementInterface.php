<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Api;

use DeveloperHub\OrderNote\Api\Data\OrderNoteInterface;

interface OrderNoteManagementInterface
{
    /**
     * @param int $cartId
     * @param OrderNoteInterface $orderNote
     * @return string|null
     */
    public function saveOrderNote(
        int $cartId,
        OrderNoteInterface $orderNote
    ): ?string;
}
