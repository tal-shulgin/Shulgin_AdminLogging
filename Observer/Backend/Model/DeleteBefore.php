<?php

namespace Shulgin\AdminLogging\Observer\Backend\Model;

/**
 * Class Shulgin\AdminLogging\Observer\Backend\Model\DeleteBefore
 */
class DeleteBefore extends AbstractAdminLogSave implements \Magento\Framework\Event\ObserverInterface 
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

        if(!empty($moduleName) && !empty($controller)) 
        {
            $old = $object->getOrigData();
            $new = $object->getData();


            if ($moduleName.'_'.$controller.'_'.$action == 'admin_system_config_save') 
            {
                $new = $this->handleSystemConfigSave($new);
                $old = $new;

                $old['value'] = !!$old['value'];
                $diff = @array_diff($object->getOrigData(), $object->getData());
                $this->clearDiffData($diff);
            } 

            $data = [
                'action' => $moduleName.'_'.$controller.'_'.$action,
                'before_save' => json_encode(var_export($old,true)),
                'after_save' => json_encode(var_export($new,true)),
                'diff' => var_export(isset($diff) ? $diff : '', true),
                'user' => $this->_adminSession->getUser()->getUserName(),
                'resource_name' => $object->getResourceName()
            ];
            
            try {
                $res = $this->_logResource->insertDataWithoutSave($data);
                $this->_logger->debug(__LINE__, [$res]);
            } catch (\Exception $e) {
                if(isset($data)) {
                    $this->_logger->debug(__LINE__, [$data, $e->getMessage()]);
                } else {
                    $this->_logger->debug(__LINE__, [$e->getMessage()]);
                }
            }
        }
    }
}
