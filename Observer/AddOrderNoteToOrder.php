<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;
use DeveloperHub\OrderNote\Api\Data\OrderNoteInterface;

class AddOrderNoteToOrder implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var $order Order **/
        $order = $observer->getEvent()->getOrder();

        /** @var $quote Quote **/
        $quote = $observer->getEvent()->getQuote();

        $order->setData(
            OrderNoteInterface::ORDER_NOTE,
            $quote->getData(OrderNoteInterface::ORDER_NOTE)
        );
    }
}
