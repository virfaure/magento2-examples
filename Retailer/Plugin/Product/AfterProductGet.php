<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Training\Retailer\Plugin\Product;

class AfterProductGet
{
    /** @var \Magento\Catalog\Api\Data\ProductExtensionFactory */
    private $productExtensionFactory;

    /** @var \Training\Retailer\Api\RetailerRepositoryInterface */
    private $retailerRepository;

    /**
     * @param \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory
     */
    public function __construct(
        \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory,
        \Training\Retailer\Api\RetailerRepositoryInterface $retailerRepository
    ) {
        $this->productExtensionFactory = $productExtensionFactory;
        $this->retailerRepository = $retailerRepository;
    }

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function afterGet(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Api\Data\ProductInterface $product
    ) {
        $productExtension = $product->getExtensionAttributes();
        if ($productExtension === null) {
            $productExtension = $this->productExtensionFactory->create();
        }

        $retailerModels = $this->retailerRepository->getForProduct();

        $productExtension->setRetailers([]);
        $product->setExtensionAttributes($productExtension);
        return $product;
    }
}
