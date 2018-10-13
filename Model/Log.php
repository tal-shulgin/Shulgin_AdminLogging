<?php

namespace Shulgin\AdminLogging\Model;

use Shulgin\AdminLogging\Api\Data\LogInterface;

/**
 * @implements Shulgin\AdminLogging\Api\Data\LogInterface\LogInterface
 */
class Log extends \Magento\Framework\Model\AbstractModel implements LogInterface
{

    protected $_eventPrefix = 'shulgin_adminlogging_log';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\Shulgin\AdminLogging\Model\ResourceModel\Log::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getLogId()
    {
        return $this->getData(self::LOG_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setLogId($logId)
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    /**
     * {@inheritdoc}
     */
    public function getBeforeSave()
    {
        return $this->getData(self::BEFORE_SAVE);
    }

    /**
     * {@inheritdoc}
     */
    public function setBeforeSave($beforeSave)
    {
        return $this->setData(self::BEFORE_SAVE, $beforeSave);
    }

    /**
     * {@inheritdoc}
     */
    public function getAfterSave()
    {
        return $this->getData(self::AFTER_SAVE);
    }

    /**
     * {@inheritdoc}
     */
    public function setAfterSave($afterSave)
    {
        return $this->setData(self::AFTER_SAVE, $afterSave);
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->getData(self::USER);
    }

    /**
     * {@inheritdoc}
     */
    public function setUser($user)
    {
        return $this->setData(self::USER, $user);
    }

    /**
     * {@inheritdoc}
     */
    public function getAction()
    {
        return $this->getData(self::ACTION);
    }

    /**
     * {@inheritdoc}
     */
    public function setAction($action)
    {
        return $this->setData(self::ACTION, $action);
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * {@inheritdoc}
     */
    public function getDiff()
    {
        return $this->getData(self::DIFF);
    }

    /**
     * {@inheritdoc}
     */
    public function setDiff($diff)
    {
        return $this->setData(self::DIFF, $diff);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockId()
    {
        return $this->getData(self::BLOCK_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setBlockId($block_id)
    {
        return $this->setData(self::BLOCK_ID, $block_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceName()
    {
        return $this->getData(self::RESOURCE_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setResourceName($resourceName)
    {
        return $this->setData(self::RESOURCE_NAME, $resourceName);
    }
}
