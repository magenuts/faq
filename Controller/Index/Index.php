<?php
namespace Magenuts\Faq\Controller\Index;

use Magento\Framework\App\Action\Context;

/**
 * Class Index
 * @package Magenuts\Faq\Controller\Index
 */
class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magenuts\Faq\Helper\Data
     */
    protected $_dataHelper;

    /**
     * Index constructor.
     * @param Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magenuts\Faq\Helper\Data $dataHelper
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magenuts\Faq\Helper\Data $dataHelper
    ) {
        $this->_dataHelper = $dataHelper;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $page = $this->resultPageFactory->create(false, ['isIsolated' => true]);
        $pageNo = $this->getRequest()->getParam('p');
        //echo "<pre>"; print_r($pageNo); exit;
        $this->_dataHelper->prepareAndRender($page, $this, $pageNo);

        return $page;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}