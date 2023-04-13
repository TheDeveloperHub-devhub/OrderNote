<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class State implements OptionSourceInterface
{
    const COLLAPSED = 0;
    const EXPANDED = 1;
    const NO_COLLAPSE_EXPAND = 2;

    /**
     * Get options
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::COLLAPSED => __('Collapse'),
            self::EXPANDED => __('Expand'),
            self::NO_COLLAPSE_EXPAND => __('Without Collapse/Expand')
        ];
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $optionArray = [];
        foreach ($this->toArray() as $value => $label) {
            $optionArray[] = [
                'value' => $value,
                'label' => $label
            ];
        }
        return $optionArray;
    }
}
