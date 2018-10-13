<?php

namespace Shulgin\AdminLogging\Block\Adminhtml\CmsBlock;

use Shulgin\AdminLogging\Model\LogFactory;
use Symfony\Component\VarDumper\VarDumper;

class CustomData extends \Magento\Backend\Block\Template
{
    /**
     * Block template.
     *
     * @var string
     */
    protected $_template = 'custom_log_dumps.phtml';
 
    /**
     * LogFactory
     */
    protected $logFactory;
    
    /**
     * Symfony VarDumper
     */
    protected $dumper;
   
    /**
     * AssignProducts constructor.
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array                                    $data
     */
    public function __construct(
        LogFactory $logFactory,
        VarDumper $dumper,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->logFactory = $logFactory;
        $this->dumper = $dumper;
    }

    /**
     * Gets current log data.
     */
    public function getLogData()
    {
        $logId =  $this->getRequest()->getParam('log_id');
        return $this->logFactory->create()->load($logId)->getData();
    }

    /**
     * Gets pertfy var_dump Symfony Dumper.
     */
    public function dumper($value)
    {
       return $this->dumper->dump($value);
    }
}