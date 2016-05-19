<?php
namespace Training\Retailer\Api\Data;

interface RetailerInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return void
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getModifiedAt();

    /**
     * @param string $modifiedAt
     * @return void
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     * @return void
     */
    public function setComment($comment);

    /**
     * @return boolean
     */
    public function getIsEnabled();

    /**
     * @param string $isEnabled
     * @return void
     */
    public function setIsEnabled($isEnabled);

    /**
     * @return array
     */
    public function getStoreIds();

    /**
     * @param int[] $storeIds
     * @return void
     */
    public function setStoreIds(array $storeIds);
}
