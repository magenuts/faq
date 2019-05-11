<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Magenuts\Gallery\Controller\Adminhtml\Image
 */
class ImportFaq extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenuts_Faq::faq');
        $resultPage->addBreadcrumb(__('Import'), __('Import'));
        $resultPage->addBreadcrumb(__('Import Faqs'), __('Import Faqs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Import Faqs'));
        return $resultPage;
    }


    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenuts_Faq::importfaq');
    }
}
