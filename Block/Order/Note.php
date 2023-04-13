<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Block\Order;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use DeveloperHub\OrderNote\Api\Data\OrderNoteInterface;
use DeveloperHub\OrderNote\Model\OrderNoteConfig;

class Note extends Template
{
    /** @var OrderNoteConfig */
    private OrderNoteConfig $orderNoteConfig;

    /** @var Registry */
    private ?Registry $coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param OrderNoteConfig $orderNoteConfig
     * @param array $data
     */
    public function __construct(
        Context         $context,
        Registry        $registry,
        OrderNoteConfig $orderNoteConfig,
        array           $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->orderNoteConfig = $orderNoteConfig;
        $this->_isScopePrivate = true;
        $this->_template = 'order/view/note.phtml';
        parent::__construct($context, $data);
    }

    /**
     * Check if show order note to customer account
     *
     * @return bool
     */
    public function showNoteInAccount(): bool
    {
        return $this->orderNoteConfig->showOrderNoteInAccount();
    }

    /**
     * Get Order
     *
     * @return array|null
     */
    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }

    /**
     * Get Order Note
     *
     * @return string|null
     */
    public function getOrderNote(): ?string
    {
        return trim($this->getOrder()->getData(OrderNoteInterface::ORDER_NOTE));
    }

    /** @return string */
    public function getOrderNoteHtml(): string
    {
        return nl2br($this->escapeHtml($this->getOrderNote()));
    }

    /**
     * Check if order has note
     *
     * @return bool
     */
    public function hasOrderNote(): bool
    {
        return strlen($this->getOrderNote()) > 0;
    }
}
