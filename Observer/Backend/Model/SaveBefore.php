<?php

namespace Shulgin\AdminLogging\Observer\Backend\Model;

/**
 * Class Shulgin\AdminLogging\Observer\Backend\Model\SaveBefore
 */
class SaveBefore extends AbstractAdminLogSave implements \Magento\Framework\Event\ObserverInterface
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

        if ($object->hasDataChanges()) {
            $diff = @array_diff($object->getOrigData(), $object->getData());
            $old = $object->getOrigData();
            $new = $object->getData();

            $moduleName = $this->_request->getModuleName();
            $controller = $this->_request->getControllerName();
            $action     = $this->_request->getActionName();
            $route      = $this->_request->getRouteName();

            if (!in_array($object->getResourceName(), $this->skipEvent()) && !$this->is_same($old, $new) && !empty($moduleName) && !empty($controller)) {
                $data = [
                    'action' => $moduleName . '_' . $controller . '_' . $action,
                    'before_save' => json_encode($object->getOrigData()),
                    'after_save' => json_encode($object->getData()),
                    'diff' => print_r($diff, true),
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

    /**
     * Compare object original data with data
     * 
     * @param OrigData $old
     * @param Data $new
     * @return bool
     */
    private function is_same($old, $new)
    {
        unset($old['updated_at']);
        unset($new['updated_at']);
        $diff = @array_diff($old, $new);

        if(empty($diff)) {
            return true;
        } else {
            return false;
        }
    }
}
