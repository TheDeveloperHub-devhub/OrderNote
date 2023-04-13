<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Model\Data;

use DeveloperHub\OrderNote\Api\Data\OrderNoteInterface;
use Magento\Framework\Api\AbstractSimpleObject;

class OrderNote extends AbstractSimpleObject implements OrderNoteInterface
{
    /** @return string|null */
    public function getNote(): ?string
    {
        return $this->_get(self::ORDER_NOTE);
    }

    /** @param string|null $note */
    public function setNote(string $note = null)
    {
        $this->setData(self::ORDER_NOTE, $note);
    }
}
