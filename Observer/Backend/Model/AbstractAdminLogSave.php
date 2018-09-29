<?php

namespace Shulgin\AdminLogging\Observer\Backend\Model;

use Shulgin\AdvancedLogger\Logger\Logger;
use Shulgin\AdminLogging\Model\LogFactory;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Request\Http;

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
     * ProductDataProvider constructor.
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger,
        Http $request,
        LogFactory $logFactory,
        Session $adminSession
    ) {
        $this->_logger = $logger;
        $this->_request = $request;
        $this->_adminSession = $adminSession;
        $this->_logFactory = $logFactory;
    }


    protected function skipEvent() 
    {
        return [
            "Shulgin\\AdminLogging\\Model\\ResourceModel\\Log",
            "Magento\\Security\\Model\\ResourceModel\\AdminSessionInfo",
            "Magento\\Ui\Model\\ResourceModel\\Bookmark"
        ];
    }
}