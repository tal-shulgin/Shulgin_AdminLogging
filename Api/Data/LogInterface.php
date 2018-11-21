<?php

namespace Shulgin\AdminLogging\Api\Data;

/**
 * interface LogInterface
 */
interface LogInterface
{

    const DIFF          = 'diff';
    const USER          = 'user';
    const ACTION        = 'action';
    const LOG_ID        = 'log_id';
    Const BLOCK_ID      = 'block_id';
    const AFTER_SAVE    = 'after_save';
    const BEFORE_SAVE   = 'before_save';
    const UPDATE_TIME   = 'update_time';
    const RESOURCE_NAME = 'resource_name';

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

    /**
     * Get diff
     * @return string|null
     */
    public function getDiff();

    /**
     * Set diff
     * @param string $diff
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setDiff($diff);

    /**
     * Get cms block id
     * @return string|null
     */
    public function getBlockId();

    /**
     * Set cms block id
     * @param string $block_id
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setBlockId($block_id);

    /**
     * Get resource_name
     * @return string|null
     */
    public function getResourceName();

    /**
     * Set resource_name
     * @param string $resourceName
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface
     */
    public function setResourceName($resourceName);
}
