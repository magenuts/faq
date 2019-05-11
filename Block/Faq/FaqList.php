<?php
namespace Magenuts\Faq\Block\Faq;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class FaqList
 * @package Magenuts\Faq\Block\Faq
 */
class FaqList extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magenuts\Faq\Model\FaqFactory
     */
    protected $_modelFaqFactory;
    /**
     * @var
     */
    protected $_storeManager;
    /**
     * @var null
     */
    protected $_faqCollection = null;
    /**
     * @var \Magenuts\Faq\Helper\Data
     */
    protected $_dataHelper;

    /**
     * FaqList constructor.
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
    public function getFaqs($id)
    {
        $faqCollection = $this->_modelFaqFactory->create()->getCollection();
        if ($id) {
            $faqCollection->addFieldToFilter('faq_category', ['finset' => $id]);
        }
        $storeId = $this->_storeManager->getStore()->getStoreId();
        $faqCollection = $faqCollection->addFieldToFilter('is_active', 1);
        $faqCollection = $faqCollection->addFieldToFilter(
            'store_id',
            [
                ['finset' => $storeId],
                ['eq' => 0]
            ]
        );
        return $faqCollection;
    }

    /**
     * @return mixed|null
     */
    public function getCollection()
    {
        if (empty($this->_faqCollection)) {
            $this->_faqCollection = $this->getFaqs();
            $this->_faqCollection->setCurPage($this->getCurrentPage());
            $this->_faqCollection
                ->setPageSize(
                    $this->_dataHelper->getFaqPerPage()
                );
            $this->_faqCollection
                ->setOrder(
                    'publish_date', $this->_dataHelper->getSortOrder()
                );
        }
        return $this->_faqCollection;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->getData(
            'current_page'
        ) ? $this->getData(
            'current_page'
        ) : 1;
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
    public function getDisplayMode()
    {
        $displayMode = $this->_dataHelper->getDisplayMode();
        return $displayMode;
    }

    public function getFaqcategory()
    {
        $storeId = $this->_storeManager->getStore()->getStoreId();
        $collection = $this->_faqCategoryFactory->create()
            ->getCollection()
            ->addFieldToFilter('is_active', '1')
            ->addFieldToFilter('store_id',
                [
                    ['finset' => $storeId],
                    ['eq' => 0]
                ]
            );
        return $collection;
    }

    /**
     * @return mixed
     */
    protected function _prepareLayout()
    {
        $metaTitle = $this->_dataHelper->getMetaTitle();
        $metaKeywords = $this->_dataHelper->getMetaKeyword();
        $metaDescription = $this->_dataHelper->getMetaDescription();
        $pageTitle = $this->_dataHelper->getPageTitle();

        if ($metaTitle) {
            $this->pageConfig->getTitle()->set($metaTitle);
        } else {
            $this->pageConfig->getTitle()->set(__('FAQs'));
        }

        if ($metaKeywords) {
            $this->pageConfig->setKeywords($metaKeywords);
        } else {
            $this->pageConfig->setKeywords(__('FAQs'));
        }

        if ($metaDescription) {
            $this->pageConfig->setDescription($metaDescription);
        } else {
            $this->pageConfig->setDescription(__('FAQs'));
        }

        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle($pageTitle);
        } else {
            $pageMainTitle->setPageTitle(__('FAQs'));
        }

        return parent::_prepareLayout();
    }
}