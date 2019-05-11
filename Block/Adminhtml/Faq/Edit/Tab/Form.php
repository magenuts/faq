<?php
namespace Magenuts\Faq\Block\Adminhtml\Faq\Edit\Tab;

use Magenuts\Faq\Model\Status;

/**
 * Class Form
 * @package Magenuts\Faq\Block\Adminhtml\Faq\Edit\Tab
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
    implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
    /**
     * @var Status
     */
    protected $_status;
    /**
     * @var
     */
    protected $_formFactory;

    /**
     * Form constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param Status $status
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magenuts\Faq\Model\Status $status
    ) {
        $this->_localeDate = $context->getLocaleDate();
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory);
    }

    /**
     *
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock(
            'page.title'
        )->setPageTitle(
            $this->getPageTitle()
        );
    }

    /**
     * @return mixed
     */
    protected function _prepareForm()
    {
        $model = $this->getFaq();
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('FAQ Information')
            ]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'faq_id', 'hidden',
                [
                    'name' => 'faq_id'
                ]
            );
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title (Question)'),
                'title' => __('Title (Question)'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig->getConfig();
        $fieldset->addField(
            'description',
            'editor',
            [
                'name' => 'description',
                'label' => __('Description (Answer)'),
                'title' => __('Description (Answer)'),
                'required' => true,
                'class' => 'required-entry',
                'config' => $wysiwygConfig
            ]
        );

        $fieldset->addField(
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

        $fieldset->addField(
            'is_frequent',
            'select',
            [
                'name' => 'is_frequent',
                'label' => __('Most Frequently Asked Question'),
                'title' => __('Most Frequently Asked Question'),
                'required' => true,
                'options' => ['1' => 'Yes', '0' => 'No'],
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
    public function getFaq()
    {
        return $this->_coreRegistry->registry('faq');
    }

    /**
     * @return mixed
     */
    public function getPageTitle()
    {
        return $this->getFaq()->getId() ? __(
            "Edit FAQ '%1'",
            $this->escapeHtml($this->getFaq()->getTitle())
        ) : __('New FAQ');
    }

    /**
     * @return mixed
     */
    public function getTabLabel()
    {
        return __('FAQ Information');
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
