<?php

namespace Training\Retailer\Model\ResourceModel\Retailer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Training\Retailer\Model\Retailer::class,
            \Training\Retailer\Model\ResourceModel\Retailer::class
        );
    }

    public function addStoreIdFilter(array $storeIds)
    {
        $this->getSelect()->joinInner(
            ['stores' => \Training\Retailer\Model\ResourceModel\Retailer::RETAILER_STORE_TABLE],
            $this->getConnection()->quoteInto(
                'store_id IN (?) and main_table.retailer_id = stores.retailer_id',
                $storeIds
            )
        );
    }
}
