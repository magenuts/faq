<?php
namespace Magenuts\Faq\Block\Adminhtml\Faqcat\Edit\Tab;

/**
 * Class Form
 * @package Magenuts\Faq\Block\Adminhtml\Faqcat\Edit\Tab
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
    implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
    /**
     * @var \Magenuts\Faq\Model\Status
     */
    protected $_status;
    /**
     * @var \Magenuts\Faq\Model\Categories
     */
    protected $_categories;
    /**
     * @var
     */
    protected $_formFactory;
    /**
     * @var
     */
    protected $_coreRegistry;

    /**
     * Form constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magenuts\Faq\Model\Categories $categories
     * @param \Magenuts\Faq\Model\Status $status
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magenuts\Faq\Model\Categories $categories,
        \Magenuts\Faq\Model\Status $status
    ) {
        $this->_localeDate = $context->getLocaleDate();
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_categories = $categories;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory);
    }

    /**
     *
     */
    protected function _prepareLayout()
    {
        $this->getLayout()
            ->getBlock('page.title')
            ->setPageTitle(
                $this->getPageTitle()
            );
    }

    /**
     * @return mixed
     */
    protected function _prepareForm()
    {
        $model = $this->getFaqcat();
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('page_');
        $fieldSet = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Category Information')
            ]
        );

        if ($model->getId()) {
            $fieldSet->addField(
                'faq_cat_id', 'hidden',
                [
                    'name' => 'faq_cat_id'
                ]
            );
        }

        $fieldSet->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig
            ->getConfig(
                [
                    'tab_id' => $this->getTabId()
                ]
            );
        $fieldSet->addField(
            'description',
            'editor',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'required' => false,
                'class' => 'required-entry',
                'config' => $wysiwygConfig
            ]
        );

        $fieldSet->addField(
            'parent_cat_id',
            'select',
            [
                'name' => 'parent_cat_id',
                'label' => __('Parent Category'),
                'title' => __('Parent Category'),
                'required' => true,
                'class' => 'required-entry',
                'options' => $this->_categories->getOptionArraytwo()
            ]
        );

        $fieldSet->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort Order'),
                'title' => __('Sort Order'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return mixed
     */
    public function getFaqcat()
    {
        return $this->_coreRegistry->registry('faqcat');
    }

    /**
     * @return mixed
     */
    public function getPageTitle()
    {
        return $this->getFaqcat()->getId() ? __(
            "Edit Category '%1'",
            $this->escapeHtml($this->getFaqcat()->getName())
        ) : __('New Category');
    }

    /**
     * @return mixed
     */
    public function getTabLabel()
    {
        return __('Category Information');
    }

    /**
     * @return mixed
     */
    public function getTabTitle()
    {
        return __('Category Information');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
}
