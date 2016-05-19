<?php

namespace Training\Retailer\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Api\SortOrder;
use Training\Retailer\Api\Data\RetailerInterface;
use Training\Retailer\Api\Data\RetailerInterfaceFactory;
use Training\Retailer\Api\RetailerRepositoryInterface;
use Training\Retailer\Model\ResourceModel\Retailer\CollectionFactory;

class RetailerRepository implements RetailerRepositoryInterface
{
    /**
     * @var \Training\Retailer\Model\ResourceModel\Retailer\Collection
     */
    private $collectionFactory;

    /**
     * @var RetailerInterfaceFactory
     */
    private $retailerDataModelFactory;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;
    /**
     * @var SearchResultsFactory
     */
    private $searchResults;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param \Training\Retailer\Model\ResourceModel\Retailer\Collection $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        RetailerInterfaceFactory $retailerDataModelFactory,
        DataObjectHelper $dataObjectHelper,
        SearchResultsFactory $searchResults,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->retailerDataModelFactory = $retailerDataModelFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->searchResults = $searchResults;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return \Magento\Framework\DataObject
     */
    public function getForProduct()
    {
        /** @var \Training\Retailer\Model\ResourceModel\Retailer\Collection $retailerCollection */
       /* $retailerCollection = $this->collectionFactory->create();
        $retailerCollection->addFieldToFilter('retailer_id', 1);

        $retailerModels = $retailerCollection->getItems();
        return array_map([$this, 'modelToDataModel'], $retailerModels);*/

        $this->searchCriteriaBuilder->create();
        $this->searchCriteriaBuilder->addFilter('store_id', [0,1]);

        $this->getList($this->searchCriteriaBuilder);

    }

    private function modelToDataModel(Retailer $retailerModel)
    {
        $dataModel = $this->retailerDataModelFactory->create();

        $this->dataObjectHelper->populateWithArray(
            $dataModel,
            $retailerModel->getData(),
            RetailerInterface::class
        );

        return $dataModel;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface  $searchCriteria
     * @return \Training\Retailer\Api\Data\RetailerSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $retailerCollection = $this->collectionFactory->create();

        /** @var SortOrder $sortOrder */
        foreach ((array)$searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $condition = $storeIds = [];

            /** @var Filter $filter */
            foreach ($filterGroup as $filter) {
                if ($filter->getField() === 'store_id') {
                    $storeIds[] = $filter->getValue();
                } else {
                    $fields[] = $filter->getField();
                    $condition[] = [$filter->getConditionType() => $filter->getValue()];
                }
            }

            if (!empty($fields)) {
                $retailerCollection->addFieldToFilter($fields, $condition);
            }

            if (!empty($storeIds)) {
                $retailerCollection->addStoreIdFilter($storeIds);
            }
        }

        /** @var SortOrder $sortOrder */
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() === SortOrder::SORT_ASC ? 'ASC' : 'DESC';
            $retailerCollection->setOrder($direction);
        }
        $retailerCollection->setCurPage($searchCriteria->getCurrentPage());
        $retailerCollection->setPageSize($searchCriteria->getPageSize());

        $retailerModels = $retailerCollection->getItems();
        $retailerDataModels = array_map([$this, 'modelToDataModel'], $retailerModels);

        $result = $this->searchResults->create();
        $result->setItems($retailerDataModels);
        $result->setSearchCriteria($searchCriteria);
        $result->setTotalCount($retailerCollection->getSize());

        return $result;
    }
}
