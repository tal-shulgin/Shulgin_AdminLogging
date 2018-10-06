<?php


namespace Shulgin\AdminLogging\Model\Log;

use Magento\Framework\App\Request\DataPersistorInterface;
use Shulgin\AdminLogging\Model\ResourceModel\Log\CollectionFactory;
use Shulgin\AdvancedLogger\Logger\Logger;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $dataPersistor;

    protected $collection;

    protected $loadedData;

    /**
     * @var Shulgin\AdvancedLogger\Logger\Logger
     */
    protected $_logger;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Logger $logger,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->_logger = $logger;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            
            $before = $model->getData('before_save');
            $after  = $model->getData('after_save');

            $model->setData('before_save', $this->beautify($before));
            $model->setData('after_save',  $this->beautify($after));

            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('shulgin_adminlogging_log');
        $this->_logger->debug(__LINE__, [ $this->loadedData, $data]);
        if (!empty($data)) {
            $this->_logger->debug(__LINE__, []);
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('shulgin_adminlogging_log');
        }
        
        return $this->loadedData;
    }

    private function beautify($value)
    {
        if(!empty($value)){
            $value = json_decode($value);
        }

        return print_r($value, true);
    }
}
