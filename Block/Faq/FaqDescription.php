<?php
namespace Magenuts\Faq\Block\Faq;

/**
 * Class FaqDescription
 * @package Magenuts\Faq\Block\Faq
 */
class FaqDescription extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magenuts\Faq\Helper\Data
     */
    protected $_dataHelper;

    /**
     * FaqDescription constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magenuts\Faq\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magenuts\Faq\Helper\Data $dataHelper
    ) {
        parent::__construct($context);
        $this->_dataHelper = $dataHelper;
    }

    /**
     * @return mixed
     */
    public function getPageTitle()
    {
        $pageTitle = $this->_dataHelper->getPageTitle();
        return $pageTitle;
    }

    /**
     * @return mixed
     */
    public function getPageDescription()
    {
        $pageDescription = $this->_dataHelper->getPageDescription();
        return $pageDescription;
    }
}