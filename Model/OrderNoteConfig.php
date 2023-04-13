<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class OrderNoteConfig implements ConfigProviderInterface
{
    /** Config Paths */
    const XML_PATH_GENERAL_IS_SHOW_IN_MYACCOUNT = 'order_note/general/show_in_my_account';
    const XML_PATH_GENERAL_MAX_LENGTH = 'order_note/general/max_length';
    const XML_PATH_GENERAL_FIELD_STATE = 'order_note/general/state';

    /** @var ScopeConfigInterface */
    private ScopeConfigInterface $scopeConfig;

    /** @param ScopeConfigInterface $scopeConfig */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check if show order note to customer account is enabled
     * @return bool
     */
    public function showOrderNoteInAccount(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_GENERAL_IS_SHOW_IN_MYACCOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /** @return int[] */
    public function getConfig(): array
    {
        return [
            'max_length' => (int) $this->scopeConfig->getValue(
                self::XML_PATH_GENERAL_MAX_LENGTH,
                ScopeInterface::SCOPE_STORE
            ),
            'default_state' => (int) $this->scopeConfig->getValue(
                self::XML_PATH_GENERAL_FIELD_STATE,
                ScopeInterface::SCOPE_STORE
            )
        ];
    }
}
