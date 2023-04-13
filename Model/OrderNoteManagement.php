<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Model;

use Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use DeveloperHub\OrderNote\Api\Data\OrderNoteInterface;
use DeveloperHub\OrderNote\Api\OrderNoteManagementInterface;

class OrderNoteManagement implements OrderNoteManagementInterface
{
    /** @var CartRepositoryInterface */
    private CartRepositoryInterface $quoteRepository;

    /** @var ScopeConfigInterface */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param CartRepositoryInterface $quoteRepository
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param int $cartId
     * @param OrderNoteInterface $orderNote
     * @return string|null
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     * @throws ValidatorException
     */
    public function saveOrderNote(int $cartId, OrderNoteInterface $orderNote): ?string
    {
        $quote = $this->quoteRepository->getActive($cartId);

        if (!$quote->getItemsCount()) {
            throw new NoSuchEntityException(
                __('Cart %1 doesn\'t contain products', $cartId)
            );
        }

        $note = $orderNote->getNote();
        $this->validateNote($note);
        try {
            $quote->setData(OrderNoteInterface::ORDER_NOTE, strip_tags($note));
            $this->quoteRepository->save($quote);
        } catch (Exception $e) {
            throw new CouldNotSaveException(
                __('The order note could not be saved')
            );
        }

        return $note;
    }

    /**
     * @param string $note
     * @throws ValidatorException
     */
    protected function validateNote($note)
    {
        $noteMaxLength = $this->scopeConfig->getValue(
            OrderNoteConfig::XML_PATH_GENERAL_MAX_LENGTH,
            ScopeInterface::SCOPE_STORE
        );

        if ($noteMaxLength && (mb_strlen($note) > $noteMaxLength)) {
            throw new ValidatorException(
                __('The order note entered exceeded the limit')
            );
        }
    }
}
