<?php


namespace Shulgin\AdminLogging\Model;

use Shulgin\AdminLogging\Api\Data\LogInterface;

class Log extends \Magento\Framework\Model\AbstractModel implements LogInterface
{

    protected $_eventPrefix = 'shulgin_adminlogging_log';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Shulgin\AdminLogging\Model\ResourceModel\Log::class);
    }

    /**
     * Get log_id
     * @return string
     */
    public function getLogId()
    {
        return $this->getData(self::LOG_ID);
    }

    /**
     * Set log_id
     * @param string $logId
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setLogId($logId)
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    /**
     * Get before_save
     * @return string
     */
    public function getBeforeSave()
    {
        return $this->getData(self::BEFORE_SAVE);
    }

    /**
     * Set before_save
     * @param string $beforeSave
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setBeforeSave($beforeSave)
    {
        return $this->setData(self::BEFORE_SAVE, $beforeSave);
    }

    /**
     * Get after_save
     * @return string
     */
    public function getAfterSave()
    {
        return $this->getData(self::AFTER_SAVE);
    }

    /**
     * Set after_save
     * @param string $afterSave
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setAfterSave($afterSave)
    {
        return $this->setData(self::AFTER_SAVE, $afterSave);
    }

    /**
     * Get user
     * @return string
     */
    public function getUser()
    {
        return $this->getData(self::USER);
    }

    /**
     * Set user
     * @param string $user
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setUser($user)
    {
        return $this->setData(self::USER, $user);
    }

    /**
     * Get action
     * @return string
     */
    public function getAction()
    {
        return $this->getData(self::ACTION);
    }

    /**
     * Set action
     * @param string $action
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setAction($action)
    {
        return $this->setData(self::ACTION, $action);
    }

    /**
     * Get update_time
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Set update_time
     * @param string $updateTime
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }
}
