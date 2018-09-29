<?php


namespace Shulgin\AdminLogging\Controller\Adminhtml\Log;
use Shulgin\AdvancedLogger\Logger\Logger;

class Edit extends \Shulgin\AdminLogging\Controller\Adminhtml\Log
{

    protected $resultPageFactory;

    /**
     * @var Shulgin\AdvancedLogger\Logger\Logger
     */
    protected $_logger;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Logger $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_logger = $logger;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('log_id');
        $model = $this->_objectManager->create(\Shulgin\AdminLogging\Model\Log::class);
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Log no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $before = $model->getData('before_save');
        $after  = $model->getData('after_save');



        $model->setData('before_save', $this->beautify($before));
        $model->setData('after_save',  $this->beautify($after));

        $this->_logger->debug(__LINE__, [$model->getData()]);
        $this->_coreRegistry->register('shulgin_adminlogging_log', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Log') : __('New Log'),
            $id ? __('Edit Log') : __('New Log')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Logs'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Log %1', $model->getId()) : __('New Log'));
        return $resultPage;
    }

    private function beautify($value)
    {
        if(!empty($value)){
            $value = json_decode($value);
        }

        return print_r($value, true);
    }
}
