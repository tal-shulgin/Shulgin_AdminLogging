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

        if ($object->isObjectNew()) {
            // new Object
            $old = $object->getOrigData();
            $new = $object->getData();

            $moduleName = $this->_request->getModuleName();
            $controller = $this->_request->getControllerName();
            $action     = $this->_request->getActionName();
            $route      = $this->_request->getRouteName();

            if (!in_array($object->getResourceName(), $this->skipEvent()) && !empty($moduleName) && !empty($controller)) {

                $data = [
                    'action' => $moduleName . '_' . $controller . '_' . $action,
                    'before_save' => json_encode($object->getData()),
                    'after_save' => '',
                    'diff' => '',
                    'user' => $this->_adminSession->getUser()->getUserName()
                ];

                //convertToJson
                try {
                    $log = $this->_logFactory->create();
                    $log->addData($data)->save();
                } catch (\Exception $e) {
                    $this->_logger->debug(__LINE__, [$data, $e->getMessage()]);
                }
                $this->_logger->debug(__LINE__, [$data]);
            }
        }
    }
}
