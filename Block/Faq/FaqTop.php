<?php
namespace Magenuts\Faq\Block\Faq;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class FaqTop
 * @package Magenuts\Faq\Block\Faq
 */
class FaqTop extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magenuts\Faq\Model\FaqFactory
     */
    protected $_modelFaqFactory;
    /**
     * @var null
     */
    protected $_faqCollection = null;
    /**
     * @var \Magenuts\Faq\Helper\Data
     */
    protected $_dataHelper;

    /**
     * FaqTop constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magenuts\Faq\Model\FaqFactory $modelFaqFactory
     * @param \Magenuts\Faq\Model\FaqcatFactory $faqCategoryFactory
     * @param \Magenuts\Faq\Helper\Data $dataHelper
     * @param \Magenuts\Faq\Model\Categories $categories
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magenuts\Faq\Model\FaqFactory $modelFaqFactory,
        \Magenuts\Faq\Model\FaqcatFactory $faqCategoryFactory,
        \Magenuts\Faq\Helper\Data $dataHelper,
        \Magenuts\Faq\Model\Categories $categories
    )
    {
        parent::__construct($context);
        $this->_modelFaqFactory = $modelFaqFactory;
        $this->_faqCategoryFactory = $faqCategoryFactory;
        $this->_dataHelper = $dataHelper;
        $this->_categories = $categories;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFaqTops($id)
    {
        $storeId = $this->_storeManager->getStore()->getStoreId();
        $faqCollection = $this->_modelFaqFactory->create()->getCollection();
        $faqCollection = $faqCollection->addFieldToFilter('is_active', 1);
        $faqCollection = $faqCollection->addFieldToFilter('is_frequent', 1);
        $faqCollection = $faqCollection->addFieldToFilter
        (
            'store_id',
            [
                ['finset' => $storeId],
                ['eq' => 0]
            ]
        );
        return $faqCollection;
    }

    /**
     * @return mixed
     */
    public function getDisplayMode()
    {
        $displayMode = $this->_dataHelper->getDisplayMode();
        return $displayMode;
    }
}	
	