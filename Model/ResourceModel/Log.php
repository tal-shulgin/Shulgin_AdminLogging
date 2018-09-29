<?php


namespace Shulgin\AdminLogging\Model\ResourceModel;

class Log extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('shulgin_adminlogging_log', 'log_id');
    }
}
