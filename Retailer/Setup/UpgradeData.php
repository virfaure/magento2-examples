<?php

namespace Training\Retailer\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Training\Retailer\Model\ResourceModel\Retailer;
use Training\Retailer\Model\RetailerFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var RetailerFactory
     */
    private $retailerFactory;

    /**
     * @var Retailer
     */
    private $retailerResource;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @param RetailerFactory $retailerFactory
     * @param Retailer $retailer
     */
    public function __construct(
        RetailerFactory $retailerFactory,
        Retailer $retailer,
        StoreRepositoryInterface $storeRepository
    ) {

        $this->retailerFactory = $retailerFactory;
        $this->retailerResource = $retailer;
        $this->storeRepository = $storeRepository;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $retailer = $this->retailerFactory->create();
        $retailer->setName('Toto');
        $retailer->setEmail('toto@toto.com');

        $storeIds = $this->getSomeStoreIds();
        $retailer->setStoreIds($storeIds);

        $this->retailerResource->save($retailer);
    }

    private function getSomeStoreIds()
    {
        $allStoreIds = $this->getAllStoreIds();
        shuffle($allStoreIds);

        return array_slice($allStoreIds, 0, count($allStoreIds));
    }

    private function getAllStoreIds()
    {
        $stores = $this->storeRepository->getList();

        return array_map(function (StoreInterface $store) {
            return $store->getId();
        }, $stores);
    }
}
