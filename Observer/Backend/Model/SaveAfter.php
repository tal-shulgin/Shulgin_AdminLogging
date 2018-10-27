<?php

namespace Shulgin\AdminLogging\Observer\Backend\Model;

/**
 * Class Shulgin\AdminLogging\Observer\Backend\Model\SaveAfter
 */
class SaveAfter extends AbstractAdminLogSave implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer) 
    {
        $object = $observer->getEvent();
        $object = $object->getData('object');

        $moduleName = $this->_request->getModuleName();
        $controller = $this->_request->getControllerName();
        $action     = $this->_request->getActionName();
        $route      = $this->_request->getRouteName();

        // Skip Resource Or Routes
        if ( 
             in_array($object->getResourceName(), $this->skipEvent()) || 
             in_array($moduleName.'_'.$controller.'_'.$action, $this->skipEvent()) 
        ) {
            return null;
        }

        $this->_logger->debug(__LINE__, [$moduleName, $controller, $action, $route]);
        if ($object->isObjectNew()) 
        {
            // new Object
            $data = $this->preDataSave('new', $moduleName . '_' . $controller . '_' . $action, $object);

        } elseif($object->hasDataChanges()) 
        {
            $data = $this->preDataSave('exsist', $moduleName . '_' . $controller . '_' . $action, $object);
        } 

        try {
            if(!empty($data)) 
            {
                $res = $this->_logResource->insertDataWithoutSave($data);
            }
        } catch (\Exception $e) {
            if(isset($data)) 
            {
                $this->_logger->debug(__LINE__, [$data, $e->getMessage()]);
            } else {
                $this->_logger->debug(__LINE__, [$e->getMessage()]);
            }
        } 

        return null;
    }

}
