<?php

namespace Training\Retailer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Retailer extends AbstractDb
{
    const RETAILER_TABLE = 'training_retailer_entity';
    const RETAILER_STORE_TABLE = 'training_retailer_store';

    /** @var \DateTimeImmutable */
    private $now;

    public function __construct(
        Context $context,
        \DateTimeImmutable $now,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->now = $now;
    }

    protected function _construct()
    {
        $this->_init(self::RETAILER_TABLE, 'retailer_id');
    }

    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        /** @var \Training\Retailer\Model\Retailer */
        $this->setTimestampProperties($object);
        return parent::_beforeSave($object);
    }

    private function setTimestampProperties(\Training\Retailer\Model\Retailer $retailer)
    {
        $time = $this->now->format('Y-m-d H:i:s');
        $retailer->setModifiedAt($time);

        if ($retailer->isObjectNew()) {
            $retailer->setCreatedAt($time);
        }
    }

    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        $storeIds = $this->loadStoreIds($object->getId());
        $object->setStoreIds($storeIds);

        return parent::_afterLoad($object);
    }

    private function loadStoreIds($retailerId)
    {
        $select = $this->getConnection()->select()
            ->from($this->getRetailerStoreTable(), ['store_id'])
            ->where('retailer_id:=retailer_id');

        return $this->getConnection()->fetchCol($select, ['retailer_id' => $retailerId]);
    }

    private function getRetailerStoreTable()
    {
        return $this->getTable(self::RETAILER_STORE_TABLE);
    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->saveStoreIds($object);
        return parent::_afterSave($object);
    }

    /**
     * @param \Training\Retailer\Model\Retailer $retailer
     */
    private function saveStoreIds(\Training\Retailer\Model\Retailer $retailer)
    {
        $storeIds = $retailer->getStoreIds();
        $this->getConnection()->delete($this->getRetailerStoreTable(), ['retailer_id = ?' => $retailer->getId()]);

        foreach ($storeIds as $value) {
            $this->getConnection()->insert(
                $this->getRetailerStoreTable(),
                ['retailer_id' => $retailer->getId(), 'store_id' => $value]
            );
        }
    }
}
