<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Plugin\Block\Adminhtml;

use Magento\Framework\Exception\LocalizedException;
use DeveloperHub\OrderNote\Api\Data\OrderNoteInterface;
use Magento\Sales\Block\Adminhtml\Order\View\Info as ViewInfo;

class SalesOrderViewInfo
{
    /**
     * @param ViewInfo $subject
     * @param $result
     * @return mixed|string
     * @throws LocalizedException
     */
    public function afterToHtml(ViewInfo $subject, $result)
    {
        $noteBlock = $subject->getLayout()
            ->getBlock('order_note');

        if ($noteBlock !== false) {
            $noteBlock->setOrderNote($subject->getOrder()
                ->getData(OrderNoteInterface::ORDER_NOTE));
            $result = $result . $noteBlock->toHtml();
        }

        return $result;
    }
}
