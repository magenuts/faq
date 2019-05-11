<?php
namespace Magenuts\Faq\Controller\Index;

use Magento\Framework\App\Action\Context;

/**
 * Class View
 * @package Magenuts\Faq\Controller\Index
 */
class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var
     */
    protected $viewHelper;
    /**
     * @var \Magenuts\Faq\Helper\Data
     */
    protected $_dataHelper;

    /**
     * View constructor.
     * @param Context $context
     * @param \Magenuts\Faq\Helper\Data $dataHelper
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        \Magenuts\Faq\Helper\Data $dataHelper,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_dataHelper = $dataHelper;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $page = $this->resultPageFactory->create();
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