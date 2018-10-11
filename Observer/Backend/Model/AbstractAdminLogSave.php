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
     * ProductDataProvider constructor.
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
            "Magento\\Theme\\Model\\ResourceModel\\Theme"
        ];

        return array_unique(array_merge($defaultSkip, $userSkip));
    }

    protected function handleSystemConfigSave($data)
    {
        $skipAttributes = $this->cleanSystemConfigSkip();

        foreach($data as $key => $value){
            if(!in_array($key, $skipAttributes)){
                unset($data[$key]);
            }
        }

        return $data;
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

    /**
     * Check the Diff between multidimensional arrays.
     * 
     * @return result | diff
     */
    protected function check_diff_multi($array1, $array2)
    {
        $result = [];

        if(is_array($array1) || is_array($array2))
        {
            return '';
        }

        foreach($array1 as $key => $val) 
        {
            if(isset($array2[$key]))
            {
                if(is_array($val) && $array2[$key]){
                    $result[$key] = $this->check_diff_multi($val, $array2[$key]);
                }

            } else {
                $result[$key] = $val;
            }
        }

        return $result;
    }
}