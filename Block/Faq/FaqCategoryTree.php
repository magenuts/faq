<?php
namespace Magenuts\Faq\Block\Faq;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class FaqCategoryTree
 * @package Magenuts\Faq\Block\Faq
 */
class FaqCategoryTree extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magenuts\Faq\Helper\Data
     */
    protected $_dataHelper;
    /**
     * @var
     */
    protected $_storeManager;
    /**
     * FaqCategoryTree constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magenuts\Faq\Model\FaqcatFactory $faqCategoryFactory
     * @param \Magenuts\Faq\Model\Categories $categories
     * @param \Magenuts\Faq\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magenuts\Faq\Model\FaqcatFactory $faqCategoryFactory,
        \Magenuts\Faq\Model\Categories $categories,
        \Magenuts\Faq\Helper\Data $dataHelper
    ) {
        $this->_faqCategoryFactory = $faqCategoryFactory;
        $this->_dataHelper = $dataHelper;
        $this->_categories = $categories;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getCategoryTree()
    {
        return $this->_categories->getfrontOptionArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFaqcategories($id)
    {
        $collection = $this->_faqCategoryFactory->create()->load($id);
        return $collection;
    }

    /**
     * @return mixed
     */
    public function getFaqcategory()
    {
		$storeId =  $this->_storeManager->getStore()->getStoreId(); 
        $collection = $this->_faqCategoryFactory->create()
            ->getCollection()->addFieldToFilter('is_active', '1')
			->addFieldToFilter(
                'store_id', [['finset' => $storeId], ['eq' => 0]]
            );
        return $collection;
    }

    /**
     * @return mixed
     */
    public function getPageUrl()
    {
        $mains = $this->_dataHelper->getPageUrl();
        return $mains;
    }

    /**
     * @param $categoryUrl
     * @return mixed
     */
    public function getCategoryUrl($categoryUrl)
    {
        $categoryPrefix = $this->_dataHelper->getCategoryUrlPrifix();
        $categorySuffix = '.' . $this->_dataHelper->getCategoryUrlSuffix();
        return $this->getUrl(
            $categoryPrefix .
            '/'
            . $categoryUrl
            . '' .
            $categorySuffix
        );
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }
	
	public function getCurrentStoreName()
    {
        return $this->_storeManager->getStore()->getId();
    }
}	