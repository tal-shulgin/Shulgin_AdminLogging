<?php


namespace Shulgin\AdminLogging\Model\ResourceModel\Log;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Shulgin\AdminLogging\Model\Log::class,
            \Shulgin\AdminLogging\Model\ResourceModel\Log::class
        );
    }
}
