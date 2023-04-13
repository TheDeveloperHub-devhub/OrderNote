<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Model;

use DeveloperHub\OrderNote\Api\Data\OrderNoteInterface;
use DeveloperHub\OrderNote\Api\GuestOrderNoteManagementInterface;
use DeveloperHub\OrderNote\Api\OrderNoteManagementInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Model\ResourceModel\Quote\QuoteIdMask;

class GuestOrderNoteManagement implements GuestOrderNoteManagementInterface
{
    /** @var QuoteIdMaskFactory */
    private QuoteIdMaskFactory $quoteIdMaskFactory;

    /** @var OrderNoteManagementInterface */
    private OrderNoteManagementInterface $orderNoteManagement;

    /** @var QuoteIdMask */
    private QuoteIdMask $quoteIdMaskResource;

    /**
     * GuestOrderNoteManagement constructor.
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param QuoteIdMask $quoteIdMaskResource
     * @param OrderNoteManagementInterface $orderNoteManagement
     */
    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        QuoteIdMask $quoteIdMaskResource,
        OrderNoteManagementInterface $orderNoteManagement
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->orderNoteManagement = $orderNoteManagement;
        $this->quoteIdMaskResource = $quoteIdMaskResource;
    }

    /** {@inheritDoc} */
    public function saveOrderNote(
        string $cartId,
        OrderNoteInterface $orderNote
    ) {
        $quoteIdMask = $this->quoteIdMaskFactory->create();
        $this->quoteIdMaskResource->load($quoteIdMask, $cartId, 'masked_id');
        return $this->orderNoteManagement->saveOrderNote(
            (int)$quoteIdMask->getQuoteId(),
            $orderNote
        );
    }
}
