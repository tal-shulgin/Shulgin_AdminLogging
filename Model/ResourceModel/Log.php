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

    /**
     * Insert data with out triggering model->save()
     * to prevent despatch observer save (infinity loop).
     */
    public function insertDataWithoutSave($data)
    { 
        if(empty($data)) {
            return null;
        }

        $connection = $this->getConnection();

        try {
            $connection->beginTransaction();
            $res = $connection->insert($this->getTable('shulgin_adminlogging_log'), $data);
            $connection->commit();
        } catch(\Exception $e) {
            $connection->rollBack();
        }

        return isset($res) ? $res : null;
    }
}
