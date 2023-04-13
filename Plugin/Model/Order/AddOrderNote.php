<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Plugin\Model\Order;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\ResourceModel\Order as OrderResourceModel;

class AddOrderNote
{
    /** @var OrderFactory */
    private OrderFactory $orderFactory;

    /** @var OrderExtensionFactory */
    private OrderExtensionFactory $orderExtensionFactory;

    /** @var OrderResourceModel */
    private OrderResourceModel $orderResourceModel;

    /**
     * @param OrderExtensionFactory $extensionFactory
     * @param OrderFactory $orderFactory
     * @param OrderResourceModel $orderResourceModel
     */
    public function __construct(
        OrderExtensionFactory $extensionFactory,
        OrderFactory $orderFactory,
        OrderResourceModel $orderResourceModel
    ) {
        $this->orderExtensionFactory = $extensionFactory;
        $this->orderFactory = $orderFactory;
        $this->orderResourceModel = $orderResourceModel;
    }

    /**
     * @param OrderInterface $order
     * @return void
     */
    public function setOrderNote(OrderInterface $order): void
    {
        if ($order instanceof Order) {
            $orderNote = $order->getDeveloperhubOrderNote();
        } else {
            $orderModel = $this->orderFactory->create();
            $this->orderResourceModel->load($orderModel, $order->getId());
            $orderNote = $orderModel->getDeveloperhubOrderNote();
        }

        $extensionAttributes = $order->getExtensionAttributes();
        $orderExtensionAttributes = $extensionAttributes ? $extensionAttributes
            : $this->orderExtensionFactory->create();

        $orderExtensionAttributes->setDeveloperhubOrderNote($orderNote);

        $order->setExtensionAttributes($orderExtensionAttributes);
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $orderSearchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $orderSearchResult
    ): OrderSearchResultInterface {
        foreach ($orderSearchResult->getItems() as $order) {
            $this->setOrderNote($order);
        }
        return $orderSearchResult;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $resultOrder
     * @return OrderInterface
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $resultOrder
    ) {
        $this->setOrderNote($resultOrder);
        return $resultOrder;
    }
}
