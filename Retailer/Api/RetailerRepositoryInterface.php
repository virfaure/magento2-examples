<?php

namespace Training\Retailer\Api;

interface RetailerRepositoryInterface
{
    /**
     * @return \Training\Retailer\Api\Data\RetailerInterface[]
     */
    public function getForProduct();

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Training\Retailer\Api\Data\RetailerSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
