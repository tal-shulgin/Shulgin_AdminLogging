<?php

namespace Shulgin\AdminLogging\Observer\Backend\Model;

use Shulgin\AdvancedLogger\Logger\Logger;
use Shulgin\AdminLogging\Model\LogFactory;
use Shulgin\AdminLogging\Model\ResourceModel\Log;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class Shulgin\AdminLogging\Observer\Backend\Model\AbstractAdminLogSave
 */
abstract class AbstractAdminLogSave
{

    /**
     * @var Shulgin\AdvancedLogger\Logger\Logger
     */
    protected $_logger;
    
    /**
     * @var  \Magento\Framework\App\Request\Http
     */
    protected $_request;

  /**
    * @var \Magento\Backend\Model\Auth\Session
    */
    protected $_adminSession;  

  /**
    * @var Shulgin\AdminLogging\Model\LogFactory
    */
    protected $_logFactory;

    /**
    * @var Shulgin\AdminLogging\Model\ResourceModel\Log
    */
    protected $_logResource;

    /**
     * @var Magento\Backend\Model\Auth\Session
     */
    protected $_session;

    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * ProductDataProvider ScopeConfigInterfaceconstructor.
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger,
        Http $request,
        LogFactory $logFactory,
        Log $logResource,
        Session $adminSession,
        ScopeConfigInterface $scopeConfig,
        Json $serializer = null,
        \Magento\Backend\Model\Session $session
    ) {
        $this->_logger = $logger;
        $this->_request = $request;
        $this->_adminSession = $adminSession;
        $this->_logFactory = $logFactory;
        $this->_logResource = $logResource;
        $this->_session = $session;
        $this->_scopeConfig = $scopeConfig;
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
    }


    /**
     * Skipp events in observer.
     */
    protected function skipEvent() 
    {
        $userSkip = $this->_scopeConfig->getValue('admin_logging_section/admin_logging_config/skip', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if(!empty($userSkip)) {
            $userSkip = $this->serializer->unserialize($userSkip, true);
            $userSkip = array_column($userSkip, 'action');
        } else {
            $userSkip = [];
        }

        
        $defaultSkip = [
            "Shulgin\\AdminLogging\\Model\\ResourceModel\\Log",
            "Magento\\Security\\Model\\ResourceModel\\AdminSessionInfo",
            "Magento\\Ui\Model\\ResourceModel\\Bookmark",
            "Magento\\Theme\\Model\\ResourceModel\\Theme",
            "admin_system_config_save"
        ];

        return array_unique(array_merge($defaultSkip, $userSkip));
    }

    protected function preSystemConfigSave()
    {
        return  [
            'user'          => $this->_adminSession->getUser()->getUserName(),
            'diff'          => '',
            'action'        => 'admin_system_config_save',
            'after_save'    => '',
            'before_save'   => '',
            'resource_name' => ''
        ];
    }

    /**
     * Clear system config array.
     * 
     * @return array | keys to skip from remove. 
     */
    private function cleanSystemConfigSkip()
    {
        return ['group_id', 'scope', 'scope_id', 'scope_code', 'field_config', 'path', 'value', 'config_id'];
    }

    /**
     * Clean unnedded data from diff array.
     */
    protected function clearDiffData(&$diff)
    {
        unset($diff['update_time']);
    }

    /**
     * Compare object original data with data
     * 
     * @param OrigData $old
     * @param Data $new
     * @return bool
     */
    protected function is_same($old, $new)
    {
        unset($old['updated_at']);
        unset($new['updated_at']);
        $diff = $this->check_diff_multi($old, $new);

        if(empty($diff)) {
            return true;
        } else {
            return false;
        }
    }

    protected function check_diff_multi($array1, $array2){
        $result = array();
        foreach($array1 as $key => $val) {
             if(isset($array2[$key])){
               if(is_array($val) && $array2[$key]){
                   $result[$key] = check_diff_multi($val, $array2[$key]);
               }
           } else {
               $result[$key] = $val;
           }
        }
    
        return $result;
    }

    /**
     * Check the Diff between multidimensional arrays.
     * 
     * @return result | diff
     */
    protected function getObjectDiff($object)
    {
        $result = [];
        $old = $object->getOrigData();
        
        if(!is_array( $old)) {
            return $result;
        }

        //$this->_logger->debug(__LINE__, [$old]);
        foreach($old as $key => $value )
        {
            if($object->dataHasChangedFor($key)) {
                $result[$key] = $value;
            }
        }

        $this->clearDiffData($result);
        return $result;
    }

    /**
     * Convert array dump to json.
     * 
     * @param array $array | array to convert
     * @return string | json string
     */
    protected function arrayDumpTojson($array)
    {
        if(empty($array)) 
        {
            return '';
        }
        //$this->_logger->debug(__LINE__, [json_encode($array, true), serialize($array)]);
        return serialize($array);
        return json_encode($array, true);
    }

    protected function preDataSave($action, $rout, $object)
    {
        $old = $object->getOrigData();
        $new = $object->getData();
        $diff = [];
        $data = [];
        //$this->_logger->debug(__LINE__, [$action, $rout, $old, $new]);
        if($action == 'new' || $action == 'dell' ) 
        {
            if ($rout == 'cms_block_save') {
                $data['block_id'] = $object->getId();
            }

        } elseif($action == 'exsist')
        {
            $diff = $this->getObjectDiff($object);

            if(empty($diff)){
                return null;
            } else {

                if ($rout == 'cms_block_save') {
                    $data['block_id'] = $object->getId();
                }
            }
        }

        return  array_merge($data, [
            'user'          => $this->_adminSession->getUser()->getUserName(),
            'diff'          => isset($diff) ? $this->arrayDumpTojson($diff) : '',
            'action'        => $rout,
            'after_save'    => $this->arrayDumpTojson($new),
            'before_save'   => $this->arrayDumpTojson($old),
            'resource_name' => $object->getResourceName()
        ]);

    }



    protected function createConfigPath($array, &$str, &$paths)
    {
        foreach ($array as $key => $value)
        {
            if (is_array($value)) 
            {
                if($str != '') {$str .= '_'.$key;} 
                else { $str .= $key;}

                createConfigPath($array[$key], $str, $paths);
            } else {
              $str .= '_'.$key;
              $paths[] = ['key'=> $str, 'value'=> $value];
            }
        }
    }

    protected function checkDifference($array1, $array2){
        $result = [];
        foreach($array1 as $key => $val) {
            if(isset($array2[$key]))
            {
                if(is_array($val) && is_array($array2[$key])) 
                {
                    $result[$key] = $this->checkDifference($val, $array2[$key]);
                } else {
                  if($val != $array2[$key]) {
                    $result[$key] = $val;
                  }
                }
            } else {
                if($val != $array2[$key]) {
                  $result[$key] = $val;
                }
           }
        }
        
        return $result;
      }


    /**
     * Filter array null value keys.
     */
    protected function arrayFilter(&$array)
    {
        
        if(!is_array($array)) {
            return;
        }
        
        $array = array_filter($array);
       
        foreach($array as $key => $value) 
        {

            if(is_array($value) && !empty($value))
            {
                $this->arrayFilter($array[$key]);
                $array[$key] = array_filter($array[$key]);
            } else {
                if(empty($array[$key])) { unset($array[$key]);} 
            }
        }

        $array = array_filter($array);
    }


    protected function filterArrayByArray(&$arrayToFilter, $arrayFilterBy)
    {
        //if(!is_array($arrayToFilter) && !is_array($arrayFilterBy)) return;
        $keys = array_keys($arrayFilterBy);

        foreach($arrayToFilter as $key => $value) 
        {
            if(is_array($value)) {
                if(!isset($arrayFilterBy[$key])) {
                    unset($arrayToFilter[$key]);
                    continue;
                }

                $this->filterArrayByArray($arrayToFilter[$key], $arrayFilterBy[$key]);
            }

            if(!in_array($key, $keys))
            {
                unset($arrayToFilter[$key]);
            }
        }
    }
}