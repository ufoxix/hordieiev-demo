<?php

declare(strict_types=1);

namespace Hordieiev\Demo\Model\Service\FrontendArea\Account;

use Hordieiev\Demo\Api\Service\FrontendArea\Account\OrderHistoryCountInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class OrderHistoryCount
 */
class OrderHistoryCount implements OrderHistoryCountInterface
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var int|null
     */
    private $lazyLoad;

    /**
     * @param Session $customerSession
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        Session $customerSession,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->customerSession = $customerSession;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return string
     */
    public function execute(): string
    {
        return sprintf(
            '%s %d',
            __('My Orders:'),
            $this->getOrderCount()
        );
    }

    /**
     * @return int
     */
    private function getOrderCount(): int
    {
        if ($this->lazyLoad === null) {
            $criteria = $this->searchCriteriaBuilder
                ->addFilter(OrderInterface::CUSTOMER_ID, $this->getCurrentCustomerId())
                ->create();

            $orderList = $this->orderRepository->getList($criteria);
            $this->lazyLoad = $orderList->getTotalCount();
        }

        return $this->lazyLoad;
    }

    /**
     * @return int
     */
    private function getCurrentCustomerId(): int
    {
        return (int)$this->customerSession->getCustomer()->getId();
    }
}
