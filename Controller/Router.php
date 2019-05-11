<?php
namespace Magenuts\Faq\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\State;
use Magenuts\Faq\Model\FaqFactory;
use Magenuts\Faq\Model\FaqcatFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Url;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Router
 * @package Magenuts\Faq\Controller
 */
class Router implements \Magento\Framework\App\RouterInterface
{

    /**
     * @var ActionFactory
     */
    protected $actionFactory;
    /**
     * @var ResponseInterface
     */
    protected $_response;
    /**
     * @var
     */
    protected $dispatched;
    /**
     * @var \Magenuts\Faq\Helper\Data
     */
    protected $_dataHelper;

    /**
     * Router constructor.
     * @param ActionFactory $actionFactory
     * @param ManagerInterface $eventManager
     * @param UrlInterface $url
     * @param FaqFactory $faqFactory
     * @param FaqcatFactory $faqcatFactory
     * @param StoreManagerInterface $storeManager
     * @param ResponseInterface $response
     * @param ResponseInterface $response
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magenuts\Faq\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        ManagerInterface $eventManager,
        UrlInterface $url,
        FaqFactory $faqFactory,
        FaqcatFactory $faqcatFactory,
        StoreManagerInterface $storeManager,
        ResponseInterface $response,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        ScopeConfigInterface $scopeConfig,
        \Magenuts\Faq\Helper\Data $dataHelper
    ) {
        $this->actionFactory = $actionFactory;
        $this->eventManager = $eventManager;
        $this->url = $url;
        $this->_dataHelper = $dataHelper;
        $this->faqFactory = $faqFactory;
        $this->faqcatFactory = $faqcatFactory;
        $this->storeManager = $storeManager;
        $this->messageManager = $messageManager;
        $this->response = $response;
        $this->_response = $response;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param RequestInterface $request
     * @return null
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        if (!$this->dispatched) {
            $urlKey = trim($request->getPathInfo(), '/');
            $origUrlKey = $urlKey;
            $condition = new DataObject(
                [
                    'url_key' => $urlKey,
                    'continue' => true
                ]
            );
            $this->eventManager->dispatch(
                'magentician_faq_controller_router_match_before',
                ['router' => $this, 'condition' => $condition]
            );
            $urlKey = $condition->getUrlKey();
            if ($condition->getRedirectUrl()) {
                $this->response->setRedirect($condition->getRedirectUrl());
                $request->setDispatched(true);
                return $this->actionFactory->create(
                    'Magento\Framework\App\Action\Redirect',
                    ['request' => $request]
                );
            }
            if (!$condition->getContinue()) {
                return null;
            }

            $entities = [
                'author' => [
                    'cat_prefix' => $this->_dataHelper->getCategoryUrlPrifix(),
                    'suffix' => $this->_dataHelper->getCategoryUrlSuffix(),
                    'list_key' => $this->_dataHelper->getPageUrl(),
                    'list_action' => 'categorylist',
                    'controller' => 'category',
                    'action' => 'categorylist',
                    'param' => 'id',
                    'factory' => $this->faqFactory,
                ]
            ];
            foreach ($entities as $entity => $settings) {
                if ($settings['list_key']) {
                    if ($urlKey == $settings['list_key']) {
                        $request->setModuleName('faq')
                            ->setControllerName($settings['controller'])
                            ->setActionName($settings['list_action']);
                        $request->setAlias(
                            Url::REWRITE_REQUEST_PATH_ALIAS, $urlKey
                        );
                        $this->dispatched = true;
                        return $this->actionFactory->create(
                            'Magento\Framework\App\Action\Forward',
                            ['request' => $request]
                        );
                    }
                }
                $parts = explode('/', $urlKey);
                if ($settings['suffix']) {
                    $suffix = substr($urlKey, -strlen($settings['suffix']) - 1);
                    if ($suffix != '.' . $settings['suffix']) {
                        continue;
                    }
                    $urlKey = substr(
                        $urlKey,
                        0,
                        -strlen(
                            $settings
                            [
                            'suffix'
                            ]
                        )
                        - 1
                    );
                }
                $categoryPath = false;
                if ($settings['cat_prefix']) {

                    $categoryPrefix = explode('/', $origUrlKey);
                    if ($parts[0] != $settings
                        [
                        'cat_prefix'
                        ] || count(
                            $categoryPrefix
                        ) != 2) {
                        continue;
                    }
                    $urlKeyPart = substr(
                        $categoryPrefix[1],
                        0,
                        -strlen(
                            $settings[
                            'suffix'
                            ])
                        - 1
                    );
                    if ($parts[0] == $settings
                        [
                        'cat_prefix'
                        ]
                    )
                        $categoryPath = true;
                }
                if ($categoryPath) {
                    $urlKeyCategory = $urlKeyPart;
                    $instanceCategory = $this->faqcatFactory->create();
                    $categoryId = $instanceCategory
                        ->checkUrlKey(
                            $urlKeyCategory
                        );
                    if (!$categoryId) {
                        return null;
                    }
                    $request->setModuleName('faq')
                        ->setControllerName('category')
                        ->setActionName('categorylist')
                        ->setParam('cat', $categoryId);
                    $request->setAlias(
                        Url::REWRITE_REQUEST_PATH_ALIAS,
                        $origUrlKey
                    );
                    $request->setDispatched(true);
                    $this->dispatched = true;
                    return $this->actionFactory->create(
                        'Magento\Framework\App\Action\Forward',
                        ['request' => $request]
                    );
                }

                $instance = $settings['factory']->create();
                $id = $instance->checkUrlKey(
                    $urlKey,
                    $this->storeManager->getStore()->getId()
                );
                if (!$id) {
                    return null;
                }
                $request->setModuleName('faq')
                    ->setControllerName('category')
                    ->setActionName('categorylist')
                    ->setParam('id', $id);
                $request->setAlias(
                    Url::REWRITE_REQUEST_PATH_ALIAS,
                    $origUrlKey
                );
                $request->setDispatched(true);
                $this->dispatched = true;
                return $this->actionFactory->create(
                    'Magento\Framework\App\Action\Forward',
                    ['request' => $request]
                );
            }
        }
        return null;
    }
}