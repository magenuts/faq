<?php
namespace Magenuts\Faq\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\View\Result\Page as ResultPage;

/**
 * Class Data
 * @package Magenuts\Faq\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     *
     */
    const XML_PATH_ENABLED = 'faq/general/enable';
    /**
     *
     */
    const XML_PATH_HEADER_LINK = 'faq/general/header_link';
    /**
     *
     */
    const XML_PATH_FOOTER_LINK = 'faq/general/footer_link';
    /**
     *
     */
    const XML_PATH_PAGE_URL = 'faq/general/page_url';
    /**
     *
     */
    const XML_PATH_LINK_TITLE = 'faq/general/link_title';
    /**
     *
     */
    const XML_PATH_PAGE_TITLE = 'faq/general/page_title';
    /**
     *
     */
    const XML_PATH_PAGE_DESCRIPTION = 'faq/general/page_description';
    /**
     *
     */
    const XML_PATH_META_TITLE = 'faq/general/meta_title';
    /**
     *
     */
    const XML_PATH_META_KEYWORDS = 'faq/general/meta_keywords';
    /**
     *
     */
    const XML_PATH_META_DESCRIPTION = 'faq/general/meta_description';
    /**
     *
     */
    const XML_PATH_PAGE_LAYOUT = 'faq/general/page_layout';
    /**
     *
     */
    const XML_PATH_CATEGORY_URL_PREFIX = 'faq/general/category_url_prefix';
    /**
     *
     */
    const XML_PATH_CATEGORY_URL_SUFFIX = 'faq/general/category_url_suffix';
    /**
     *
     */
    const XML_PATH_VIEW = 'faq/general/view';
    /**
     *
     */
    const XML_PATH_DISPLAY_MODE = 'faq/general/display_mode';

    /**
     * @var
     */
    protected $mediaDirectory;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\App\Config\scopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->filesystem = $filesystem;
        $this->mediaDirectory = $filesystem
            ->getDirectoryWrite(
                DirectoryList::MEDIA
            );
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @param $storePath
     * @return mixed
     */
    public function getStoreConfig($storePath)
    {
        $storeConfig = $this->scopeConfig->getValue(
            $storePath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $storeConfig;
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function isEnabled($store = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function isHeaderLinkEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_HEADER_LINK,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function isFooterLinkEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_FOOTER_LINK,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_VIEW,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getFaqList()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PAGE_LAYOUT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getMetaTitle()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_META_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getMetaKeyword()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_META_KEYWORDS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_META_DESCRIPTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getCategoryUrlPrifix()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CATEGORY_URL_PREFIX,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getCategoryUrlSuffix()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CATEGORY_URL_SUFFIX,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getPageTitle()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PAGE_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getPageDescription()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PAGE_DESCRIPTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getPageUrl()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PAGE_URL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getLinkTitle()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_LINK_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getBaseDir()
    {
        $path = $this->filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(
            self::CAT_MEDIA_PATH
        );
        return $path;
    }

    /**
     * @return string
     */
    public function getBaseUrlMedia()
    {
        return $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . self::CAT_MEDIA_PATH;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    /**
     * @return mixed
     */
    public function getDisplayMode()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DISPLAY_MODE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param ResultPage $resultPage
     * @param $layoutId
     * @return $this
     */
    public function initProductLayout(
        ResultPage
        $resultPage,
        $layoutId
    ) {
        $postListLayout = $this->getFaqList(
            'magenuts/general/' .
            $layoutId
        );
        $pageConfig = $resultPage->getConfig();
        $pageConfig->setPageLayout($postListLayout);
        return $this;
    }

    /**
     * @param ResultPage $resultPage
     * @param $controller
     * @param $pageNo
     * @return $this
     */
    public function prepareAndRender(
        ResultPage
        $resultPage,
        $controller,
        $pageNo
    ) {
        $this->initProductLayout($resultPage, 'page_layout');
        $currentPage = abs(intval($pageNo));
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $resultPage->getLayout();
        $listBlock = $resultPage
            ->getLayout()
            ->getBlock(
                'faqcollapse'
            );
        $listBlock->setCurrentPage($currentPage);
        return $this;
    }

    /**
     * @param ResultPage $resultPage
     * @param $controller
     * @param $pageNo
     * @return $this
     */
    public function prepareAndRenderCat(
        ResultPage
        $resultPage,
        $controller,
        $pageNo
    ) {
        $this->initProductLayout($resultPage, 'page_layout');
        $currentPage = abs(intval($pageNo));
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $resultPage->getLayout();
        $listBlock = $resultPage->getLayout()->getBlock('faq.collapse');
        $listBlock->setCurrentPage($currentPage);
        return $this;
    }
}