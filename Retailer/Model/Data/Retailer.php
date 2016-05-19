<?php

namespace Training\Retailer\Model\Data;

use Training\Retailer\Api\Data\RetailerInterface;

class Retailer implements RetailerInterface
{

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var string */
    private $modifiedAt;

    /** @var string */
    private $createdAt;

    /** @var string */
    private $comment;

    /** @var boolean */
    private $isEnabled;

    /** @var array */
    private $storeIds;

    /** @var array */
    private $extensionAttributes;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param string $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * @param string $isEnabled
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return array
     */
    public function getStoreIds()
    {
        return $this->storeIds;
    }

    /**
     * @param int[] $storeIds
     */
    public function setStoreIds(array $storeIds)
    {
        $this->storeIds = $storeIds;
    }
}
