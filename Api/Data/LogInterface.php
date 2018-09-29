<?php


namespace Shulgin\AdminLogging\Api\Data;

interface LogInterface
{

    const USER = 'user';
    const BEFORE_SAVE = 'before_save';
    const UPDATE_TIME = 'update_time';
    const LOG_ID = 'log_id';
    const AFTER_SAVE = 'after_save';
    const ACTION = 'action';

    /**
     * Get log_id
     * @return string|null
     */
    public function getLogId();

    /**
     * Set log_id
     * @param string $logId
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setLogId($logId);

    /**
     * Get before_save
     * @return string|null
     */
    public function getBeforeSave();

    /**
     * Set before_save
     * @param string $beforeSave
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setBeforeSave($beforeSave);

    /**
     * Get after_save
     * @return string|null
     */
    public function getAfterSave();

    /**
     * Set after_save
     * @param string $afterSave
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setAfterSave($afterSave);

    /**
     * Get user
     * @return string|null
     */
    public function getUser();

    /**
     * Set user
     * @param string $user
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setUser($user);

    /**
     * Get action
     * @return string|null
     */
    public function getAction();

    /**
     * Set action
     * @param string $action
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setAction($action);

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Set update_time
     * @param string $updateTime
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setUpdateTime($updateTime);
}
