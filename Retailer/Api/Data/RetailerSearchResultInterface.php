<?php

namespace Training\Retailer\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface RetailerSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Training\Retailer\Api\Data\RetailerInterface[]
     */
    public function getItems();

    /**
     * @param \Training\Retailer\Api\Data\RetailerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
