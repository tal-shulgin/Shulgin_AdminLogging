<?php


namespace Shulgin\AdminLogging\Controller\Adminhtml;

abstract class Log extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Shulgin_AdminLogging::top_level';
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Shulgin'), __('Shulgin'))
            ->addBreadcrumb(__('Log'), __('Log'));
        return $resultPage;
    }
}
