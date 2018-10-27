<?php

namespace Shulgin\AdminLogging\Plugin\Config;

use Shulgin\AdvancedLogger\Logger\Logger;
use Shulgin\AdminLogging\Model\LogFactory;
use Shulgin\AdminLogging\Model\ResourceModel\Log;

/**
 * 
 */
class AroundSaveConfig extends \Shulgin\AdminLogging\Observer\Backend\Model\AbstractAdminLogSave
{

    public function aroundSave(
        \Magento\Config\Model\Config $subject,
        callable $proceed
    ) {
        $section = $subject->getSection();
        $oldConfigs = $this->_scopeConfig->getValue($section);
        
        //Proceed
        $returnValue = $proceed();

        $newConfigs = $this->_scopeConfig->getValue($section);
        $difference = $this->checkDifference($oldConfigs, $newConfigs);

        $this->arrayFilter($difference);
        //$newConfigs = $difference;
        $this->filterArrayByArray($oldConfigs, $difference);
        $this->filterArrayByArray($newConfigs, $difference);

        /* 
        //convert arrays to system config strings.
        $tmpConfigString = '';
        $oldConfigsPaths = [];
        $this->createConfigPath([$section => $oldConfigs], $tmpConfigString, $oldConfigsPaths);

        $tmpConfigString = '';
        $newConfigsPaths = [];
        $this->createConfigPath([$section => $newConfigs], $tmpConfigString, $newConfigsPaths);
        */

        try {
            $data = $this->preSystemConfigSave();
            $data['diff']        = json_encode([$section => $difference], true);
            $data['after_save']  = json_encode([$section => $newConfigs], true);
            $data['before_save'] = json_encode([$section => $oldConfigs], true);
            
            $res = $this->_logResource->insertDataWithoutSave($data);

        } catch (\Exception $e) {
            if(isset($data)) {
                $this->_logger->debug(__LINE__, [$data, $e->getMessage()]);
            } else {
                $this->_logger->debug(__LINE__, [$e->getMessage()]);
            }
        }

        //$this->_logger->debug(__LINE__, [$this->_scopeConfig->getResourceName()]);
        
        //$this->_logger->debug(__LINE__, [$section, $oldConfigs, $newConfigs, $difference, get_class_methods($this->_logFactory), get_class_methods($this->_logResource) ]);




        // Do whateever you want to do with the diff array which
        // contains both the old and new value of the array
    }


}