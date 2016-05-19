<?php

namespace Training\Retailer\Model;

use Magento\Framework\Model\AbstractModel;
use Training\Retailer\Api\Data\RetailerInterface;

class Retailer extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Retailer::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->setData('name', $name);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getData('email');
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->setData('email', $email);
    }

    /**
     * @return string
     */
    public function getModifiedAt()
    {
        return $this->getData('modified_at');
    }

    /**
     * @param string $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->setData('modified_at', $modifiedAt);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData('created_at', $createdAt);
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->getData('comment');
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->setData('comment', $comment);
    }

    /**
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->getData('is_enabled');
    }

    /**
     * @param string $isEnabled
     */
    public function setIsEnabled($isEnabled)
    {
        $this->setData('is_enabled', (bool) $isEnabled);
    }

    /**
     * @return array
     */
    public function getStoreIds()
    {
        return $this->_getData('store_ids');
    }

    /**
     * @param int[] $storeIds
     */
    public function setStoreIds(array $storeIds)
    {
        $this->setData('store_ids', $storeIds);
    }
}
